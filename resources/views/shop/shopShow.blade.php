<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Listing Details</title>
        <link rel="stylesheet" href="{{ asset('\css\shop.css') }}">
        <link rel="stylesheet" href="{{ asset('\css\styles.css') }}">
    </head>
    <body>
        <div class="flex flex-row justify-center items-center h-screen">
            <div class="basis-1/3">
            </div>
            <div class="basis-1/3 flex flex-col justify-center items-center">
                <div class="mb-4" style="padding-top: 20px">
                    @php
                        $paths = json_decode($product->paths, true); // Dekodowanie JSON do tablicy
                    @endphp
                    <div class="flex flex-row" >
                        @foreach ($paths as $path)
                            <img src="{{ asset('storage/' . $path) }}" alt="Product Image" class="photo-in-show"/>
                        @endforeach
                    </div>
                    
                </div>
                <div class="mb-4 flex flex-col justify-center">
                    <p style="font-weight: bold" align="center"> {{ $product->name }} - ${{ $product->price }} </p>
                    <p align="center"> {{ $product->description }} </p>
                </div>
                <div style="padding-bottom: 5px">
                    <!-- kup teraz czyli dodaj do koszyka i przekieruj -->
                    <button class="buy-button" onclick="addToCartAndRedirect();">Buy</button>


                    <!-- dodanie do koszyka -->
                    <a href="{{ route('cart.add', ['id' => $product->id]) }}">
                        <button class="add-to-cart-button" onclick="addToCartAndOpenDropdown()">Add to cart</button>
                    </a>
                    
                </div>
                <div>
                    <!-- link do edytowania zdjecia -->
                    @if (Auth::user()->role === 'admin')
                    <a href="{{ route('shop.edit', $product->id) }}">
                        <button class="add-button">Edit</button>
                    </a>
                    
                    <!-- formularz do usuwania zdjecia -->
                    <form action="{{ route('shop.destroy', $product->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="delete-button" type="submit" onclick="return confirm('Are you sure you want to delete this listing?');">Delete</button>
                    </form>
                    @endif
                </div>
            </div>
            <div class="basis-1/3">
            </div>
            
        </div>
    </body>
    <script>
        function addToCartAndRedirect() {
            // najpierw dodanie do koszyka
            fetch('{{ route('cart.add', ['id' => $product->id]) }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                }
            }).then(response => {
                // nastepnie przekierowanie do view koszyka
                window.location.href = '{{ route('cart.show') }}';
            });
        }

        
    </script>
</x-app-layout>