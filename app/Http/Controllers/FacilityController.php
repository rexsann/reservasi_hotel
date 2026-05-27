<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Room;
use App\Models\Facility;

class FacilityController extends Controller
{
    public function index()
{
    $rooms = Room::select('type')
        ->distinct()
        ->get();

    $facilities = Facility::all();

    return view('admin.facility', compact('rooms', 'facilities'));
}

public function store(Request $request)
{
    $request->validate([
        'type' => 'required',
        'name' => 'required'
    ]);

    Facility::create([
        'room_type' => $request->type,
        'name'      => $request->name
    ]);

    return redirect('/admin/facility');
}

public function destroy($id)
{
    Facility::findOrFail($id)->delete();

    return redirect('/admin/facility');
}
}