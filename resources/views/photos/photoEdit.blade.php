<x-app-layout>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Photo</title>
</head>
<body>
    <h1>Edit Photo</h1>
    <form action="{{ route('photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <img src="{{ asset('storage/' . $photo->path) }}" alt="Photo" style="width: 100px;">
        <label for="photo">Choose a new photo:</label>
        <input type="file" id="photo" name="photo">
        <button type="submit">Update Photo</button>
    </form>
</body>
</x-app-layout>
