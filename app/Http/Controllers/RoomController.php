<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RoomController extends Controller
{
    // 🔹 tampilkan halaman rooms (data di-handle JS)
    public function index()
    {
        return view('admin.rooms');
    }

    // 🔹 tampilkan halaman create room
    public function create()
    {
        return view('admin.create_room');
    }

    // 🔹 fake store (biar route ga error aja)
    public function store(Request $request)
    {
        return redirect('/admin/rooms')->with('success', 'Room added (frontend only)');
    }

    // 🔹 fake edit (optional, kalau mau halaman edit)
    public function edit($id)
    {
        return view('admin.edit_room');
    }

    // 🔹 fake update
    public function update(Request $request, $id)
    {
        return redirect('/admin/rooms')->with('success', 'Room updated (frontend only)');
    }

    // 🔹 fake delete
    public function destroy($id)
    {
        return redirect('/admin/rooms')->with('success', 'Room deleted (frontend only)');
    }
}