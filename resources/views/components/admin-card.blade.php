<x-layout>
    <x-card-full>
        <div>
            <x-admin-menu />
        </div>
        <section id="dashboard" class="container-fluid dashboard">
            {{$slot}}
        </section>
    </x-card-full>
</x-layout>