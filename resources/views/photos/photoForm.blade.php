<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Photo</title>
</head>
<body>
    <h1>Add New Photo</h1>
    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="photo">Choose a photo:</label>
        <input type="file" id="photo" name="photo">
        <button type="submit">Add Photo</button>
    </form>
</body>
</html>
