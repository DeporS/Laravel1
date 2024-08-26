{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Simple Form</title>
</head>
<body>
    @if (count($errors) > 0)
        <div class = "alert alert-danger" >
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        </div>
    @endif

    <form action="{{ route('validateForm') }}" method="POST">
        <input type = "hidden" name = "_token" value = "<?php echo csrf_token() ?>">
        <table align="center">
            <tr>
                <td>Imie</td>
                <td>
                    <input type="text" name="name" value="{{ old('name') }}">
                </td>
            </tr>
            <tr>
                <td>Nazwisko</td>
                <td>
                    <input type="text" name="surname" value="{{ old('surname') }}">
                </td>
            </tr>
            <tr>
                <td>E-mail</td>
                <td>
                    <input type="text" name="email" value="{{ old('email') }}">
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" value="Wyślij">
                </td>
            </tr>
        </table>
    </form>
</body>
</html> --}}

<x-app-layout>
    

    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Whoops!</strong> There were some problems with your input.
            <ul class="mt-3 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('validateForm') }}" method="POST" style="padding-top: 20px">
        @csrf
        <div class="flex-wrap">
            <div class="mb-4 flex justify-center">
                <div class="w-1/3 sm:w-1/2">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full" required/>
                </div>
            </div>

            <div class="mb-4 flex justify-center">
                <div class="w-1/3 sm:w-1/2">
                    <x-input-label for="surname" :value="__('Surname')" />
                    <x-text-input type="text" name="surname" id="surname" value="{{ old('surname') }}" class="w-full" required/>
                </div>
            </div>

            <div class="mb-4 flex justify-center">
                <div class="w-1/3 sm:w-1/2">
                    <x-input-label for="email" :value="__('E-mail')"/>
                    <x-text-input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full" required/>
                </div>
            </div>

            <div class="flex items-center justify-center mt-6">
                <x-primary-button class="ms-3" type="submit">
                    {{ __('Wyślij') }}
                </x-primary-button>
            </div>
        </div>                            
    </form>
</x-app-layout>

