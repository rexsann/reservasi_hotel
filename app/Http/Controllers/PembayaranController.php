<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayaran = Pembayaran::with('reservation')
            ->latest()
            ->get();

        return view('admin.pembayaran', compact('pembayaran'));
    }

    public function updateStatus(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->status = $request->status;
        $pembayaran->save();

        return response()->json([
            'message' => 'Status updated'
        ]);
    }
}