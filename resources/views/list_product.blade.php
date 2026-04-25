@extends('layouts.list')

@section('title', 'Ini adalah judul pada meta')
@section('content')

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Produk</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $post)
        <tr>
            <p>ID Produk: {{ $data['id'] }}</p>
            <p>Nama Produk: {{ $data['produk'] }}</p>

        </tr>
        @endforeach
    </tbody>
</table>
@endsection