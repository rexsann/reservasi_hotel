<?php

namespace App\Console\Commands;

use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CancelExpiredReservations extends Command
{
    /**
     * php artisan reservations:cancel-expired
     */
    protected $signature = 'reservations:cancel-expired';

    protected $description = 'Auto-cancel reservasi yang melewati tenggat waktu pembayaran 24 jam (Pending Payment & Waiting Verification)';

    public function handle()
    {
        $deadline = Carbon::now()->subHours(24);

        // 1) Pending Payment: belum pernah upload bukti sama sekali.
        //    Dihitung dari created_at karena paid_at masih null.
        $expiredPending = Reservation::where('status', 'Pending Payment')
            ->whereNull('paid_at')
            ->where('created_at', '<=', $deadline)
            ->get();

        // 2) Waiting Verification: sudah upload bukti tapi belum diverifikasi admin.
        //    Dihitung dari paid_at (di-set saat upload bukti).
        $expiredWaiting = Reservation::where('status', 'Waiting Verification')
            ->whereNotNull('paid_at')
            ->where('paid_at', '<=', $deadline)
            ->get();

        $expired = $expiredPending->merge($expiredWaiting);

        if ($expired->isEmpty()) {
            $this->info('Tidak ada reservasi yang expired.');
            return self::SUCCESS;
        }

        // Group per reservation_code supaya satu group (multi-room) di-cancel bareng,
        // konsisten dengan cara AdminReservationController menangani group.
        $codes = $expired->pluck('reservation_code')->unique();

        $totalCancelled = 0;

        foreach ($codes as $code) {
            DB::transaction(function () use ($code, &$totalCancelled) {
                $group = Reservation::where('reservation_code', $code)
                    ->whereIn('status', ['Pending Payment', 'Waiting Verification'])
                    ->lockForUpdate()
                    ->get();

                if ($group->isEmpty()) {
                    return;
                }

                foreach ($group as $reservation) {
                    $reservation->update([
                        'status'       => 'Cancelled',
                        'cancelled_at' => now(),
                    ]);

                    // Update payment terkait (kalau ada) jadi Cancelled juga,
                    // bukan dihapus, supaya histori tetap ada.
                    $reservation->payments()
                        ->where('status', 'Waiting Verification')
                        ->update(['status' => 'Cancelled']);

                    $totalCancelled++;
                }
            });
        }

        Log::info("Auto-cancel: {$totalCancelled} reservation row(s) dari " . $codes->count() . ' group dibatalkan karena lewat tenggat 24 jam.');
        $this->info("{$totalCancelled} reservasi (dari {$codes->count()} group) berhasil dibatalkan otomatis.");

        return self::SUCCESS;
    }
}