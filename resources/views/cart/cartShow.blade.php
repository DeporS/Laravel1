<x-app-layout>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Cart</title>
        <link rel="stylesheet" href="{{ asset('\css\shop.css') }}">
        <link rel="stylesheet" href="{{ asset('\css\styles.css') }}">
    </head>
    <body>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        @if (session('cart') && count(session('cart')) > 0)
                            <ul class="cart-list space-y-2 overflow-auto max-h-60">
                                @foreach (session('cart') as $item)
                                <li class="flex justify-between items-center bg-white p-2 rounded shadow-sm">
                                    
                                    <div class="flex items-center">
                                        <form action="{{ route('cart.delete', $item['id']) }}" method="POST" class="ml-2">
                                            @csrf
                                            <button type="submit" style="padding-right: 12px" title="Remove">❌</button>
                                        </form>
                                        {{-- <a href="" style="padding-right: 10px">❌</a> --}}
                                        <a class="flex justify-between items-center" href="/shop/{{ $item['id'] }}">
                                            <div class="flex items-center space-x-2">
                                                <img src="{{ asset('storage/' . $item['img']) }}" class="img" width="40px" height="auto" />
                                                <span class="px-2">{{ $item['name'] }}</span>
                                            </div>
                                        </a> 
                                    </div>
                                    
                                    <div class="ml-2">
                                        
                                        <span>{{ $item['quantity'] }} x</span>
                                        <span>${{ number_format($item['price'], 2) }}</span>
                                        
                                    </div>

                                                                       
                                </li>
                                @endforeach
                            </ul>
                        @endif 
                        <div class="mt-4" align="right">
                            
                            
                            <div class="mt-4">
                                <p><strong>Total:</strong> ${{ number_format($price_sum, 2) }}</p>
                                @if (session('discounted_sum'))
                                    <p><strong>After discount:</strong> ${{ number_format(session('discounted_sum'), 2) }}</p>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center ">
                            <!-- Promo code -->
                            <form action="{{ route('cart.applyDiscount') }}" method="POST">
                                @csrf
                                <div class="flex">
                                    <div>
                                        <x-input-label for="discount_code" :value="__('Discount code')" />
                                        <x-text-input type="text" name="discount_code" id="discount_code" value="{{ old('discount_code') }}" class="w-full" required/>
                                    </div>
                                    <div class="ml-3 mt-4">
                                        <button type="submit" class="buy-button">Apply</button>
                                    </div>
                                    @if ($errors->has('discount_code'))
                                        <div class="alert alert-danger">
                                            <p>{{ $errors->first('discount_code') }}</p>
                                        </div>
                                    @endif
                                    
                                </div>
                            </form>

                            <!-- Buy -->
                            @if ($errors->has('quantity_error'))
                                <div class="alert alert-danger">
                                    <p>{!! $errors->first('quantity_error') !!}</p>
                                </div>
                            @endif

                            <a href="{{ route('shop.buy') }}" class="mt-4">
                                <button class="buy-button">Buy</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</x-app-layout>