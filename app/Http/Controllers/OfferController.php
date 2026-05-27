<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Offer;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::all();

        return view('admin.offers', compact('offers'));
    }

    public function store(Request $request)
    {
        Offer::create([
            'name' => $request->name,
            'room_type' => $request->room_type,
            'price' => $request->price,
            'benefits' => json_encode($request->benefits),
        ]);

        return redirect()->back();
    }

    public function destroy($id)
    {
        Offer::findOrFail($id)->delete();

        return redirect()->back();
    }
}