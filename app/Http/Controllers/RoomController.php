<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    // tampilkan data room dari database
    public function index()
    {
        $rooms = Room::all();

        return view('admin.rooms', compact('rooms'));
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
            'offer' => $request->offer,
            'price_per_night' => $request->price_per_night,
            'status' => $request->status,
        ]);

        return redirect('/admin/rooms')
            ->with('success', 'Room added successfully');
    }

    // halaman edit
    public function edit($id)
    {
        $room = Room::findOrFail($id);

        return view('admin.edit_room', compact('room'));
    }

    // update room
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);

        $room->update([
            'room_name' => $request->room_name,
            'offer' => $request->offer,
            'price_per_night' => $request->price_per_night,
            'status' => $request->status,
        ]);

        return redirect('/admin/rooms')
            ->with('success', 'Room updated successfully');
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