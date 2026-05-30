<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::orderBy('room_type')
            ->orderBy('name')
            ->get();

        return view('admin.offers', compact('offers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'room_type' => 'required|string',
            'price' => 'required|numeric|min:0',
        ]);

        Offer::create([
            'name' => $request->name,
            'room_type' => $request->room_type,
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