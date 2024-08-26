<x-app-layout>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add New Photo</title>
    <link rel="stylesheet" href="{{ asset('\css\styles.css') }}">
</head>
<body>
    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-row justify-center items-center h-screen">
            <div class="basis-1/3">
                
            </div>
            <div class="basis-1/3 flex flex-col justify-center items-center">
                <div class="mb-4">
                    <label for="photo">Choose a photo:</label>
                </div>
                <div class="mb-4">
                    <input type="file" id="photo_input" name="photo">
                </div>
                <div class="mb-4">
                    <button class="add-button" id="add_button" type="submit">Add</button>
                </div>
            </div>
            <div class="basis-1/3"></div>
        </div>
        
        
        
    </form>
</body>
<script>
    // if(document.getElementById('photo_input').value == 'n/a' || document.getElementById('photo_input').value == ''){
    //     document.getElementById('add_button').style.display = 'none';
    // } else {
    //     document.getElementById('add_button').style.display = 'block';
    // }

    document.addEventListener('DOMContentLoaded', function() {
        const photoInput = document.getElementById('photo_input');
        const addButton = document.getElementById('add_button');

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
