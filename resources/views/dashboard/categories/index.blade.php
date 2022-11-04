<x-admin-card>
    <h1>Category Library</h1>
        <div class="row">
            @foreach($categories as $category)
                <div class="col-3">
                    <x-category-card :category="$category" />
                </div>
            @endforeach
        </div>
    </div>
</x-admin-card>
