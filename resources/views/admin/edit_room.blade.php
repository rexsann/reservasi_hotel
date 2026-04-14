<h2>Edit Room</h2>

<form action="/admin/rooms/update/{{ $room->id }}" method="POST">
    @csrf
    <input type="text" name="name" value="{{ $room->name }}"><br><br>
    <input type="number" name="price" value="{{ $room->price }}"><br><br>
    <button type="submit">Update</button>
</form>