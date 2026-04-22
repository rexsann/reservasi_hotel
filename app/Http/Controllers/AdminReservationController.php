<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
 
class AdminReservationController extends Controller
{
    /**
     * Tampilkan daftar reservasi + filter.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'room']);
 
        // Filter: search by customer name
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }
 
        // Filter: status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
 
        // Filter: check_in date
        if ($request->filled('date')) {
            $query->whereDate('check_in', $request->date);
        }
 
        $reservations = $query->latest()->paginate(10)->withQueryString();
 
        // Stat cards
        $total     = Reservation::count();
        $confirmed = Reservation::where('status', 'confirmed')->count();
        $pending   = Reservation::where('status', 'pending')->count();
        $canceled  = Reservation::where('status', 'canceled')->count();
 
       return view('admin.admin_reservation', compact(
    'reservations',
    'total',
    'confirmed',
    'pending',
    'canceled'
));
    }
 
    /**
     * Form tambah reservasi baru.
     */
    public function create()
    {
        $rooms = Room::where('status', 'available')->get();
        $users = User::where('role', 'user')->get();
 
        return view('admin.admin_reservation', compact('rooms', 'users'));
    }
 
    /**
     * Simpan reservasi baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|exists:users,id',
            'room_id'    => 'required|exists:rooms,id',
            'check_in'   => 'required|date|after_or_equal:today',
            'check_out'  => 'required|date|after:check_in',
            'status'     => 'required|in:pending,confirmed,canceled',
        ]);
 
        Reservation::create($request->only([
            'user_id', 'room_id', 'check_in', 'check_out', 'status'
        ]));
 
        return redirect()
            ->route('admin.admin_reservations')
            ->with('success', 'Reservasi berhasil ditambahkan.');
    }
 
    /**
     * Detail satu reservasi (untuk modal atau halaman terpisah).
     */
    public function show($id)
    {
        $reservation = Reservation::with(['user', 'room'])->findOrFail($id);
 
        return view('admin.admin_reservation_show', compact('reservation'));
    }
 
    /**
     * Form edit reservasi.
     */
    public function edit($id)
    {
        $reservation = Reservation::with(['user', 'room'])->findOrFail($id);
        $rooms = Room::all();
        $users = User::where('role', 'user')->get();
 
        return view('admin.admin_reservation_edit', compact('reservation', 'rooms', 'users'));
    }
 
    /**
     * Update reservasi.
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
 
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'room_id'   => 'required|exists:rooms,id',
            'check_in'  => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'status'    => 'required|in:pending,confirmed,canceled',
        ]);
 
        $reservation->update($request->only([
            'user_id', 'room_id', 'check_in', 'check_out', 'status'
        ]));
 
        return redirect()
            ->route('admin.admin_reservations')
            ->with('success', 'Reservasi berhasil diperbarui.');
    }
 
    /**
     * Hapus reservasi.
     */
    public function destroy($id)
    {
        Reservation::findOrFail($id)->delete();
 
        return redirect()
            ->route('admin.admin_reservations')
            ->with('success', 'Reservasi berhasil dihapus.');
    }
}