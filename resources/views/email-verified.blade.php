<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>
        <div class="flex flex-col items-center justify-center h-100 w-100">
            <img src="{{ asset('images/email-verified.png') }}" alt="">
            <hr>
            <label class="text-2xl font-bold capitalize">Email verified successfully!</label>
            <p class="pt-2">Head to {{ config('app.name') }} mobile application to login</p>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>