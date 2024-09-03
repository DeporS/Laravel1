<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Add a friend') }}
            </h2>
        </div>
    </x-slot>

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="bg-red-100 border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" align="center" role="alert">
            <ul class="mt-3 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Display status message -->
    @if(session('status'))
        <div class="alert alert-success mt-3" align="center">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('friends.store') }}" method="POST" style="padding-top: 20px">
        @csrf
        <div class="flex-wrap">
            <div class="mb-4 flex justify-center">
                <div class="w-1/3 sm:w-1/2">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full" required/>
                </div>
            </div>
            <div class="flex justify-center">
                <x-primary-button class="ms-3" type="submit">
                    {{ __('Add') }}
                </x-primary-button>
            </div>
                
        </div>                            
    </form>
</x-app-layout>