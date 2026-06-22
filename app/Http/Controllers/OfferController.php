<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Facility;

class OfferController extends Controller
{
   public function index()
{
    $offers = Offer::with('roomType')
        ->orderBy('id', 'asc')
        ->get();

    $types = RoomType::orderBy('id', 'asc')
        ->get();

    return view('admin.offers', compact('offers', 'types'));
}

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'room_type_id' => 'required|exists:room_types,id',
            'price' => 'required|numeric|min:0',
        ]);

                Offer::create([
            'name' => $request->name,
            'room_type_id' => $request->room_type_id,
            'price' => $request->price,
            'benefits' => json_encode($request->benefits ?? []),
        ]);

        return back()->with('success', 'Offer created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $offer = Offer::findOrFail($id);

        $offer->update([
            'price' => $request->price,
            'benefits' => json_encode($request->benefits ?? []),
        ]);

        return back()->with('success', 'Offer updated successfully.');
    }

    public function destroy(int $id)
    {
        $offer = Offer::findOrFail($id);

        $offer->delete();

        return back()->with('success', 'Offer deleted successfully.');
    }
}