<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Add New Product</title>
        <link rel="stylesheet" href="{{ asset('\css\shop.css') }}">
    </head>
    <body>
        <form action="{{ route('shop.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-row justify-center items-center h-screen">
                <div class="basis-1/3">
                    
                </div>
                <div class="basis-1/3 flex flex-col justify-center items-center">

                    <!-- Dodaj zdjecie -->
                    <div class="mb-4">
                        <x-input-label for="photos" :value="__('Photos')" />
                        <input type="file" id="photos" name="photos[]" multiple required>
                    </div>

                    <!-- Nazwa produktu -->
                    <div class="mb-4 w-full">
                        <x-input-label for="name" :value="__('Product name')" />
                        <input type="text" name="name" id="name" value="{{ old('name') }}" class="x-text-input w-full" required/>
                    </div>

                    <!-- Opis -->
                    <div class="mb-4 w-full">
                        <x-input-label for="description" :value="__('Product description')" />
                        <textarea name="description" id="description" class="x-text-input w-full" style="height: 200px;">{{ old('description') }}</textarea>
                    </div>

                    <!-- Cena -->
                    <div class="mb-4 w-full">
                        <div class="flex flex-row">
                            <div class="basis-1/2">
                                <x-input-label for="price" :value="__('Price ($)')" />
                                <input type="number" name="price" id="price" value="{{ old('price') }}" placeholder="0,00" class="x-text-input w-full" style="width: 75%" step="0.01" required/>
                            </div>
                            <div class="basis-1/2">
                                
                            </div>
                        </div>
                    </div>

                    <!-- Przycisk -->
                    <div class="mb-4">
                        <button class="add-button" id="add_button" type="submit">Add</button>
                    </div>
                </div>
                <div class="basis-1/3"></div>
            </div>
            
            
            
        </form>
    </body>
    <script>
    
        // document.addEventListener('DOMContentLoaded', function() {
        //     const photoInput = document.getElementById('photo_input');
        //     const addButton = document.getElementById('add_button');
    
        //     // pierwsze sprawdzenie
        //     toggleButton();
    
        //     // sprawdzenie podczas zmiany w formie
        //     photoInput.addEventListener('change', toggleButton);
    
        //     function toggleButton() {
        //         if(photoInput.value == 'n/a' || photoInput.value == ''){
        //             addButton.style.display = 'none';
        //         } else {
        //             addButton.style.display = 'block';
        //         }
        //     }
        // });
    </script>
    </x-app-layout>
    