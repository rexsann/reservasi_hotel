<?php

namespace App\Http\Controllers; use Illuminate\Http\Request;
class HomeController extends Controller
{
public function index()
{
// $data = [
//	'nama' => 'Budi',
// 'pekerjaan' => 'Developer',
//];
// return view('home')->with($data);
$nama = "Teddy";
$pekerjaan = "programmer";
$alamat = "Jakarta";
$notelp = "08123456789";
$jurusan = "Teknik Informatika";
return view('home', compact('nama', 'pekerjaan', 'alamat', 'notelp', 'jurusan'));
}
public function contact()
{
return view('contact');
}
}
 
