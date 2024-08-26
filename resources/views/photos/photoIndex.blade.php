<x-app-layout>
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
                padding-top: 10px;
                padding-left: 10px;
            }

            .photo-container img {
                height: 200px; 
                object-fit: cover; 
            }
        </style>
    </head>
    <body>
        <x-slot name="header">
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Stored photos') }}
                </h2>
                <x-nav-link href="photos/create" class="button font-semibold text-xl leading-tight">{{ __("Upload") }}</x-nav-link>
            </div>
        </x-slot>
        <div class="photo-container">
            @foreach($photosData as $photo)
            <div>
                <a href="/photos/{{ $photo['id'] }}">
                    <img src="{{ Storage::url($photo['path']) }}" alt="Photo" />
                </a>
            </div>
            @endforeach
        </div>
    </body>
</x-app-layout>