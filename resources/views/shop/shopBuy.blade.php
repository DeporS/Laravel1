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
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Ship details') }}
            </h2>
        </div>
    </x-slot>
    <!-- Form -->
    <form action="{{ route('validateOrder') }}" method="POST" style="padding-top: 20px">
    @csrf
    <div>
        <div class="mb-4 flex justify-center gap-4">
            <!-- Name -->
            <div>
                <div class="w-1/3 sm:w-1/2">
                    <x-input-label for="customer_name" :value="__('Name')" />
                    <x-text-input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" class="w-full" required/>
                </div>
            </div>
    
            <!-- Surname -->
            <div>
                <div class="w-1/3 sm:w-1/2">
                    <x-input-label for="customer_surname" :value="__('Surname')" />
                    <x-text-input type="text" name="customer_surname" id="customer_surname" value="{{ old('customer_surname') }}" class="w-full" required/>
                </div>
            </div>
        </div>

        <!-- Country -->
        <div class="mb-4 flex justify-center">
            <div class="w-1/3 sm:w-1/2">
                <x-input-label for="country" :value="__('Country')" />
                <x-text-input type="text" name="country" id="country" value="{{ old('country') }}" class="w-full" required/>
            </div>
        </div>

        <!-- State -->
        <div class="mb-4 flex justify-center">
            <div class="w-1/3 sm:w-1/2">
                <x-input-label for="state" :value="__('State (optional)')" />
                <x-text-input type="text" name="state" id="state" value="{{ old('state') }}" class="w-full"/>
            </div>
        </div>

        <div class="mb-4 flex justify-center gap-4">
            <!-- City -->
            <div class="flex justify-center">
                <div class="w-1/3 sm:w-1/2">
                    <x-input-label for="city" :value="__('City')" />
                    <x-text-input type="text" name="city" id="city" value="{{ old('city') }}" class="w-full" required/>
                </div>
            </div>

            <!-- Postal code -->
            <div class="flex justify-center">
                <div class="w-1/3 sm:w-1/2">
                    <x-input-label for="postal_code" :value="__('Postal code')" />
                    <x-text-input type="text" pattern="\d{2}-\d{3}" placeholder="XX-XXX" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" class="w-full" required/>
                </div>
            </div>
        </div>

        <!-- Address line 1 -->
        <div class="mb-4 flex justify-center">
            <div class="w-1/3 sm:w-1/2">
                <x-input-label for="address_line_1" :value="__('Address')" />
                <x-text-input type="text" name="address_line_1" id="address_line_1" value="{{ old('address_line_1') }}" class="w-full" required/>
            </div>
        </div>

        <!-- Address line 2 -->
        <div class="mb-4 flex justify-center">
            <div class="w-1/3 sm:w-1/2">
                <x-input-label for="address_line_2" :value="__('Additional address (optional)')" />
                <x-text-input type="text" name="address_line_2" id="address_line_2" value="{{ old('address_line_2') }}" class="w-full"/>
            </div>
        </div>

        <div class="mb-4 flex justify-center gap-4">
            <!-- Email -->
            <div>
                <div class="w-1/3 sm:w-1/2">
                    <x-input-label for="customer_email" :value="__('E-mail')"/>
                    <x-text-input type="email" name="customer_email" id="customer_email" value="{{ old('customer_email') }}" class="w-full" required/>
                </div>
            </div>

            <!-- Phone number -->
            <div>
                <div class="w-1/3 sm:w-1/2">
                    <x-input-label for="customer_phone" :value="__('Phone number (optional)')" />
                    <x-text-input type="text" pattern="\d{9}" name="customer_phone" id="customer_phone" value="{{ old('customer_phone') }}" class="w-full"/>
                </div>
            </div>
        </div>

        

        <div class="flex items-center justify-center mt-6">
            <x-primary-button class="mb-4" type="submit">
                {{ __('Wyślij') }}
            </x-primary-button>
        </div>
    </div>                            
    </form>
</x-app-layout>
