<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Offer;

class RoomController extends Controller
{
    // tampilkan data room
    public function index()
    {
        $rooms = Room::all();
        $offers = Offer::all();

        return view('admin.rooms', compact('rooms', 'offers'));
    }

    // halaman create
    public function create()
    {
        return view('admin.create_room');
    }

    // simpan room baru
    public function store(Request $request)
    {
        Room::create([
            'room_name' => $request->room_name,
            'type' => $request->type,
            'offer' => $request->offer,
            'price_per_night' => $request->price_per_night,
            'status' => $request->status,
        ]);

        return redirect('/admin/rooms')
            ->with('success', 'Room added successfully');
    }

    // update room
    public function update(Request $request, $id)
{
    $room = Room::findOrFail($id);

    $offer = Offer::where('name', $request->offer)
        ->where('room_type', $room->type)
        ->first();

    if (!$offer) {
        return back()->with('error', 'Offer not found');
    }

    $room->update([
        'offer' => $offer->name,
        'price_per_night' => $offer->price,
        'status' => $request->status,
    ]);

    return back()->with('success', 'Room updated');
}

    // delete room
    public function destroy($id)
    {
        $room = Room::findOrFail($id);

        $room->delete();

        return redirect('/admin/rooms')
            ->with('success', 'Room deleted successfully');
    }
}