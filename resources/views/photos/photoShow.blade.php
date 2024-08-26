<x-app-layout>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Photo Details</title>
    <link rel="stylesheet" href="{{ asset('\css\styles.css') }}">
</head>
<body>
    <div class="flex flex-row justify-center items-center h-screen">
        <div class="basis-1/3">
        </div>
        <div class="basis-1/3 flex flex-col justify-center items-center">
            <div class="mb-4" style="padding-top: 20px">
                <img src="{{ asset('storage/' . trim($photo->path, '"')) }}" width="400px" height="auto" alt="Photo">
            </div>
            <div class="mb-4">
                <p>Photo ID: {{ $photo->id }}</p>
            </div>
            <div>
                <!-- link do edytowania zdjecia -->
                <a href="{{ route('photos.edit', $photo->id) }}">
                    <button class="add-button">Edit</button>
                </a>
                
                <!-- formularz do usuwania zdjecia -->
                <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="delete-button" type="submit" onclick="return confirm('Are you sure you want to delete this photo?');">Delete</button>
                </form>
            </div>
        </div>
        <div class="basis-1/3">
        </div>
        
    </div>
</body>
</x-app-layout>
