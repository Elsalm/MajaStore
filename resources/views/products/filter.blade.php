<x-layout>
    <x-slot:title>
        Muebles
    </x-slot>
    <products-body :filtro-id="@json($category ?? null)"></products-body>
</x-layout>
