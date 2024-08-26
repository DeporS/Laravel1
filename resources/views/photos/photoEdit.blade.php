<x-app-layout>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Photo</title>
    <link rel="stylesheet" href="{{ asset('\css\styles.css') }}">
</head>
<body>
    <form action="{{ route('photos.update', $photo->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        
        

        <div class="flex flex-row justify-center items-center h-screen">
            <div class="basis-1/3">
                
            </div>
            <div class="basis-1/3 flex flex-col justify-center items-center">
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $photo->path) }}" alt="Photo" width="400px" height="auto" style="padding-top: 20px">
                </div>
                <div class="mb-4">
                    <label for="photo">Choose a new photo:</label>
                    <input type="file" id="photo_input" name="photo">
                </div>
                <div class="mb-4">
                    <button type="submit" class="add-button" id="edit_button" onclick="return confirm('Are you sure you want to replace this photo?');">Update Photo</button>
                </div>
            </div>
            <div class="basis-1/3"></div>
        </div>
    </form>
</body>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        const photoInput = document.getElementById('photo_input');
        const addButton = document.getElementById('edit_button');

        // pierwsze sprawdzenie
        toggleButton();

        // sprawdzenie podczas zmiany w formie
        photoInput.addEventListener('change', toggleButton);

        function toggleButton() {
            if(photoInput.value == 'n/a' || photoInput.value == ''){
                addButton.style.display = 'none';
            } else {
                addButton.style.display = 'block';
            }
        }
    });

</script>
</x-app-layout>
