<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Edit Listing</title>
        <link rel="stylesheet" href="{{ asset('\css\styles.css') }}">
        <link rel="stylesheet" href="{{ asset('\css\shop.css') }}">
    </head>
    <body>
        <form action="{{ route('shop.update', $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            
            
    
            <div class="flex flex-row justify-center items-center h-screen">
                <div class="basis-1/3">
                    
                </div>
                <div class="basis-1/3 flex flex-col justify-center items-center">
                    @php
                        $paths = json_decode($product->paths, true); // Dekodowanie JSON do tablicy
                    @endphp
                    <div class="flex flex-row" >
                        @foreach ($paths as $path)
                            <img src="{{ asset('storage/' . $path) }}" alt="Product Image" class="photo-in-show"/>
                        @endforeach
                    </div>
                    <!-- Dodaj zdjecie -->
                    <div class="mb-4">
                        <x-input-label for="photos" :value="__('Photos')" />
                        <input type="file" id="photos" name="photos[]" multiple>
                    </div>
                    <!-- Nazwa produktu -->
                    <div class="mb-4 w-full">
                        <x-input-label for="name" :value="__('Product name')" />
                        <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" class="x-text-input w-full" required/>
                    </div>

                    <!-- Opis -->
                    <div class="mb-4 w-full">
                        <x-input-label for="description" :value="__('Product description')" />
                        <textarea name="description" id="description" class="x-text-input w-full" style="height: 200px;">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <!-- Cena -->
                    <div class="mb-4 w-full">
                        <div class="flex flex-row">
                            <div class="basis-1/2">
                                <x-input-label for="price" :value="__('Price ($)')" />
                                <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" placeholder="0,00" class="x-text-input w-full" style="width: 75%" step="0.01" required/>
                            </div>
                            <div class="basis-1/2">
                                
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="add-button" id="edit_button" >Update listing</button>
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