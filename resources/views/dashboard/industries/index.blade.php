<x-admin-card>
    <h1>Industry Library</h1>
        <div class="row">
            @foreach($industries as $industry)
                <div class="col-3">
                    <x-industry-card :industry="$industry" />
                </div>
            @endforeach

            {{ $industries->links() }}
        </div>
    </div>
</x-admin-card>
