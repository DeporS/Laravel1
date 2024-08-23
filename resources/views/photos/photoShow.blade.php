<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Photo Details</title>
</head>
<body>
    <h1>Photo Details</h1>
    <img src="{{ asset('storage/' . trim($photo->path, '"')) }}" height="100px" alt="">
    <p>ID: {{ $photo->id }}</p>
    <p>Path: {{ $photo->path }}</p>

    <!-- link do edytowania zdjecia -->
    <a href="{{ route('photos.edit', $photo->id) }}">Edit</a>

    <!-- formularz do usuwania zdjecia -->
    <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
</body>
</html>
