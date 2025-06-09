<x-layout>
    <x-slot:title>
        {{ $data['name'] }}
    </x-slot>
    <product :product='@json($data)'></product>
</x-layout>
