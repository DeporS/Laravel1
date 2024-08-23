<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Photos</title>
    <style>
        .photo-container {
            display: flex; 
            flex-wrap: wrap; 
            gap: 10px; 
        }

        .photo-container img {
            height: 200px; 
            object-fit: cover; 
        }
    </style>
</head>
<body>
    <h1>Uploaded Photos</h1>
    
    <div class="photo-container">
        @foreach($photos as $photo)
        <div>
            <img src="{{ asset('storage/photos/' . trim($photo, '"')) }}" alt="">
        </div>
        @endforeach
    </div>
</body>
</html>
