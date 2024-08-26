<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Products</title>
        <link rel="stylesheet" href="{{ asset('\css\shop.css') }}">
    </head>
    <body>
        <x-slot name="header">
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Products') }}
                </h2>
                <x-nav-link href="/shop/create" class="button font-semibold text-xl leading-tight">{{ __("Add listing") }}</x-nav-link>
            </div>
        </x-slot>
        <div class="listings flex justify-center">
            @foreach($productsData as $product)
            <div class="div<?php echo $product['id']; ?>">
                {{-- @foreach ($product['paths'] as $path)
                    <img src="{{ asset('storage/' . $path) }}" alt="Product Image" style="width: 200px; height: auto;"/>
                @endforeach --}}
                {{-- <div class="container">
                    <img src="{{ asset('storage/' . last($product['paths'])) }}" class="img<?php echo $product['id']; ?>" alt="Product Image" style="width: 200px; height: auto;"/>    <!-- pierwsze zdjecie od konca -->
                    <img src="{{ asset('storage/' . $product['paths'][count($product['paths']) - 2]) }}" class="img_block<?php echo $product['id']; ?>" alt="Product Image" style="width: 200px; height: auto;"/>    <!-- drugie zdjecie od konca -->
                </div> --}}
                <a href="/shop/{{ $product['id'] }}">
                    <div class="container">
                        <div class="imageInn">
                            <img src="{{ asset('storage/' . $product['paths'][0]) }}" class="img" alt="Product Image" />    <!-- pierwsze zdjecie od konca -->
                        </div>
                        @php
                            if(count($product['paths']) > 1){
                                $nums = 2;
                            }
                        @endphp
                        <div class="hoverImg">
                            <img src="{{ asset('storage/' . $product['paths'][1]) }}" class="img_block" alt="Product Image" />    <!-- drugie zdjecie od konca -->
                        </div>
                        
                        
                    </div>
                </a>
                
                
                <h1>{{ $product['name'] }}</h1>
                <h1>{{ "$" . $product['price'] }}</h1>
            </div>
            @endforeach
        </div>
    </body>
    <script>
        
    </script>
</x-app-layout>