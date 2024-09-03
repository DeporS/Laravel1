<head>
    <link rel="stylesheet" href="/css/float.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
</head>
<!-- Floating button -->
<div class="floating-container">
    <div class="floating-button">

        <i class="material-icons">+</i>

        
    </div>
    <div class="element-container">
        <!-- friends -->
        <a class="float-element" href="{{ route('friends.index') }}" title="Friends"> 
            <i class="material-icons">people</i>
        </a>

        <a class="float-element" href="{{ route('friends.create') }}" title="Add friends">
            <i class="material-icons">person_add</i>
        </a>

        <a class="float-element" href="" title="Messages">
            <i class="material-icons">message</i>
        </a>

    </div>
</div>
<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('form')" :active="request()->routeIs('form')">
                        {{ __('Form') }}
                    </x-nav-link>
                    @if (Auth::user()->role === 'admin')
                    <x-nav-link :href="route('formCenter')" :active="request()->routeIs('formCenter')">
                        {{ __('Form Center') }}
                    </x-nav-link>
                    @endif
                    <x-nav-link :href="route('photos.index')" :active="request()->routeIs('photos.index')">
                        {{ __('Photos') }}
                    </x-nav-link>
                    <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.index')">
                        {{ __('Shop') }}
                    </x-nav-link>
                    @if (Auth::user()->role === 'admin')
                    <x-nav-link :href="route('shopPanel')" :active="request()->routeIs('shopPanel')">
                        {{ __('Shop Panel') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="flex">
                <!-- Cart Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6" id="cartDropdown">
                    <x-dropdown>
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                
                                <!-- tutaj dzialanie carta, wyswietlanie sie ilosci przedmiotow w nawiasie -->
                                @php
                                    $sum = 0;
                                @endphp
                                
                                @if (session('cart') && count(session('cart')) > 0)
                                    @foreach (session('cart') as $item)
                                        @php
                                            $sum += $item['quantity'];
                                        @endphp
                                    @endforeach
                                @endif

                                @if ( $sum  > 0)
                                    <div>Cart ({{ $sum }})</div>
                                @else
                                    <div>Cart</div>
                                @endif
                                
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
                        
                        <!-- zawartosc koszyka -->
                        <x-slot name="content">
                            @if (session('cart') && count(session('cart')) > 0)
                                <ul class="cart-list space-y-2 overflow-auto max-h-60">
                                    @foreach (session('cart') as $item)
                                    <li class="flex justify-between items-center bg-white p-2 rounded shadow-sm">
                                        <a class="flex justify-between items-center" href="/shop/{{ $item['id'] }}">
                                            <img src="{{ asset('storage/' . $item['img']) }}" class="img" width="40px" height="auto"/>
                                            <span style="padding-right: 5px; padding-left: 5px;">{{ $item['name'] }}</span>
                                            <div>
                                                <span>{{ $item['quantity'] }} x</span>
                                                <span>${{ number_format($item['price'], 2) }}</span>
                                            </div>
                                            
                                    </a>
                                        
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="border-t border-gray-200 mt-2 pt-2">
                                    <a href="{{ route('cart.show') }}" class="block text-center text-blue-500">View Cart</a>
                                </div>
                            @else
                                <p class="text-center text-gray-500">Your cart is empty.</p>
                            @endif
                
                            
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Settings Dropdown -->
                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <x-dropdown width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                    
                    <!-- Tutaj zdjecie profilowe -->
                    <div class="">
                        <a href="{{ route('profile.edit') }}"><img src="{{ asset('storage/' . Auth::user()->profile_picture_path) }}" alt="Photo" style="width: 50px; height: 50px; object-fit: cover;" cover;></a>
                    </div>


                    
                </div>
            </div>

            
            
            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('form')" :active="request()->routeIs('form')">
                {{ __('Form') }}
            </x-responsive-nav-link>
            @if (Auth::user()->role === 'admin')
            <x-responsive-nav-link :href="route('formCenter')" :active="request()->routeIs('formCenter')">
                {{ __('Form Center') }}
            </x-responsive-nav-link>
            @endif
            <x-responsive-nav-link :href="route('photos.index')" :active="request()->routeIs('photos.index')">
                {{ __('Photos') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.index')">
                {{ __('Shop') }}
            </x-responsive-nav-link>
            @if (Auth::user()->role === 'admin')
            <x-responsive-nav-link :href="route('shopPanel')" :active="request()->routeIs('shopPanel')">
                {{ __('Shop Panel') }}
            </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>

    
    
</nav>

