<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Facility;
use App\Models\RoomType;

class FacilityController extends Controller
{
    public function index()
    {
        $types = RoomType::orderBy('name')->get();

        $facilities = Facility::with('roomType')->get();

        return view('admin.facility', compact('types', 'facilities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'name' => 'required|string|max:255'
        ]);

        Facility::create([
            'room_type_id' => $request->room_type_id,
            'name' => $request->name
        ]);

        return redirect('/admin/facility')
            ->with('success', 'Facility added successfully.');
    }

    public function destroy($id)
    {
        Facility::findOrFail($id)->delete();

        return redirect('/admin/facility')
            ->with('success', 'Facility deleted successfully.');
    }
}