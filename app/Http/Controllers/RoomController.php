<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Offer;
use App\Models\RoomType;

class RoomController extends Controller
{
    // tampilkan data room
    public function index()
    {
        $rooms = Room::with([
            'roomType.facilities',
            'offer'
        ])->get();

        $offers = Offer::with('roomType')->get();
        $types  = RoomType::orderBy('name')->get();

        return view('admin.rooms', compact(
            'rooms',
            'offers',
            'types'
        ));
    }

    // halaman create
    public function create()
    {
        $types = RoomType::orderBy('name')->get();

        $offers = Offer::with('roomType')
            ->orderBy('name')
            ->get();

        return view('admin.create_room', compact(
            'types',
            'offers'
        ));
    }

    // simpan room baru
    public function store(Request $request)
    {
        $request->validate([
            'room_name'    => 'required|string|max:255',
            'room_type_id' => 'required|exists:room_types,id',
            'offer_id'     => 'required|exists:offers,id',
            'status'       => 'required|in:Available,Occupied,Maintenance',
        ]);

        Room::create([
            'room_name'    => $request->room_name,
            'room_type_id' => $request->room_type_id,
            'offer_id'     => $request->offer_id,
            'status'       => $request->status,
        ]);

        return redirect('/admin/rooms')
            ->with('success', 'Room added successfully');
    }

    // update room
    public function update(Request $request, $id)
    {
        $request->validate([
            'offer_id' => 'required|exists:offers,id',
            'status'   => 'required|in:Available,Occupied,Maintenance',
        ]);

        $room = Room::findOrFail($id);

        $room->update([
            'offer_id' => $request->offer_id,
            'status'   => $request->status,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Room updated successfully'
            ]);
        }

        return back()->with(
            'success',
            'Room updated successfully'
        );
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