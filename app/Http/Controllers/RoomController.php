<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    // tampilkan semua room
    public function index()
    {
        $rooms = Room::all();
        return view('admin.rooms', compact('rooms'));
    }

    // form tambah
    public function create()
    {
        return view('admin.create_room');
    }

    // simpan data
    public function store(Request $request)
    {
        $request->validate([
            'room_number' => 'required',
            'floor' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'status' => 'required'
        ]);

        Room::create([
            'room_number' => $request->room_number,
            'floor' => $request->floor,
            'type' => $request->type,
            'price' => $request->price,
            'status' => $request->status
        ]);

        return redirect('/admin/rooms');
    }

    // form edit
    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.edit_room', compact('room'));
    }

    // update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'room_number' => 'required',
            'floor' => 'required',
            'type' => 'required',
            'price' => 'required|numeric',
            'status' => 'required'
        ]);

        $room = Room::findOrFail($id);

        $room->update([
            'room_number' => $request->room_number,
            'floor' => $request->floor,
            'type' => $request->type,
            'price' => $request->price,
            'status' => $request->status
        ]);

        return redirect('/admin/rooms');
    }

    // hapus
    public function destroy($id)
    {
        Room::destroy($id);
        return redirect('/admin/rooms');
    }
}