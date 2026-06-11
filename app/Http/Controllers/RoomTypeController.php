<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomTypeController extends Controller
{
    // ── Tampilkan semua tipe kamar ──────────────────────────────
    public function index()
    {
       $types = RoomType::withCount('rooms')->orderBy('id', 'asc')->get();
        return view('admin.room_types', compact('types'));
    }

    // ── Simpan tipe baru ────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:room_types,name',
        ], [
            'name.unique' => 'Room type name already exists.',
        ]);

        RoomType::create([
            'name' => trim($request->name)
        ]);

        return redirect()->route('admin.room-types.index')
            ->with('success', 'Added new room type successfully.');
    }

    // ── Update tipe kamar ───────────────────────────────────────
    public function update(Request $request, $id)
{
    $type = RoomType::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:100|unique:room_types,name,' . $id,
    ]);

    $type->update([
        'name' => trim($request->name)
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Room type updated successfully'
    ]);
}

    // ── Hapus tipe kamar ────────────────────────────────────────
    public function destroy($id)
    {
        $type = RoomType::findOrFail($id);

        $roomCount = $type->rooms()->count();

        if ($roomCount > 0) {
            return redirect()->route('admin.room-types.index')
                ->with(
                    'error',
                    "Cannot delete. There are {$roomCount} rooms using the type \"{$type->name}\"."
                );
        }

        $type->delete();

        return redirect()->route('admin.room-types.index')
            ->with('success', "Room type \"{$type->name}\" deleted successfully.");
    }
}