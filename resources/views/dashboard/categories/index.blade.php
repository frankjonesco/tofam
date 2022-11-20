<x-admin-card>
    <h1>Category Library</h1>
    <h5>Manage the categories for the site.</h5>

    <div class="w-100 justify-content-center">
        
            <h5 class="pt-4">Add a new category</h5>

            {{-- Add a new category --}}
            <form action="/dashboard/categories/store" method="POST">
                @csrf                
                <label for="name">Category name</label>
                <input type="text" name="name" class="form-control mb-3" placeholder="Enter new category name" value="{{old('name')}}">
                @error('name')
                    <p class="text-danger">{{$message}}</p>
                @enderror
                <button type="submit" class="btn btn-success btn-sm">Create category</button>
            </form>

            <div id="categoriesList" class="mb-4">
                <h5 class="pt-4">List of current categories</h5>

                @foreach($categories as $category)
                    <div id="category_{{$category->id}}" class="d-flex border-bottom">
                        <div class="p-2">
                            <i class="fa fa-folder"></i>
                        </div>
                        <div class="p-2 flex-grow-1">
                            {{$category->name}}
                        </div>
                        <div class="p-2">
                            {{$category->company_count}}
                        </div>
                        <div class="p-2">
                            <button
                                type="button"
                                id="removeCategory_{{$category->id}}" 
                                onclick="hideCategoryRow('{{$category->id}}')"
                                class="btn btn-danger btn-sm"
                            >
                                <i class="fa fa-trash"></i> 
                                Remove
                            </button>
                            <button
                                type="button"
                                id="undoRemoveCategory_{{$category->id}}" 
                                onclick="showCategoryRow('{{$category->id}}')"
                                class="btn btn-secondary btn-sm"
                                style="display: none;"
                            >
                                <i class="fa fa-undo"></i> 
                                Undo
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- <input id="categoriesArray" name="categories_array" type="hidden" class="form-control mb-3" value="{{$company->category_ids ? $company->category_ids.',' : null}}">
            <input id="deletedCategoriesArray" name="deleted_categories_array" type="hidden" class="form-control" value=""> --}}



        </form>
       
    </div>
</x-admin-card>
