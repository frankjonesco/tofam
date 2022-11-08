<x-admin-card>

    <x-company-edit-buttons :company="$company"/>

    <h1>Edit storage</h1>


    <h5>Organize your companies into categories and industries. </h5>
    <div class="w-100 justify-content-center">
        <form action="/dashboard/companies/update/storage" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="hex" value="{{$company->hex}}">
            
            <h5 class="pt-4">Categories</h5>
            {{-- Select a new category --}}
            <label for="new_category">Add to another category</label>
            <select id="newCategory" rel="#" name="new_category" class="form-select mb-3">
                <option value="" selected disabled>Select a new category...</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
            @error('new_category')
                <p class="text-danger">{{$message}}</p>
            @enderror
            <div id="categoriesList" class="mb-4">
                <p>This company is currently stored in the following categories:</p>
                @foreach($existing_categories as $existing_category)
                    <div id="category_{{$existing_category->id}}" class="d-flex border-bottom">
                        <div class="p-2">
                            <i class="fa fa-folder"></i>
                        </div>
                        <div class="p-2 flex-grow-1">
                            {{$existing_category->name}}
                        </div>
                        <div class="p-2">
                            <button
                                type="button"
                                id="removeCategory_{{$existing_category->id}}" 
                                onclick="hideCategoryRow('{{$existing_category->id}}')"
                                class="btn btn-danger btn-sm"
                            >
                                <i class="fa fa-trash"></i> 
                                Remove
                            </button>
                            <button
                                type="button"
                                id="undoRemoveCategory_{{$existing_category->id}}" 
                                onclick="showCategoryRow('{{$existing_category->id}}')"
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
            <input id="categoriesArray" name="categories_array" type="hidden" class="form-control mb-3" value="{{$company->category_ids ? $company->category_ids.',' : null}}">
            <input id="deletedCategoriesArray" name="deleted_categories_array" type="hidden" class="form-control" value="">

            

            <h5 class="pt-4">Industries</h5>
            {{-- Select a new industry --}}
            <label for="new_industry">Add to another industry</label>
            <select id="newIndustry" rel="#" name="new_industry" class="form-select mb-3">
                <option value="" selected disabled>Select a new industry...</option>
                @foreach($industries as $industry)
                    <option value="{{$industry->id}}">{{$industry->name}}</option>
                @endforeach
            </select>
            @error('new_industry')
                <p class="text-danger">{{$message}}</p>
            @enderror
            <div id="industriesList" class="mb-4">
                <p>This company is currently stored in the following industries:</p>
                @foreach($existing_industries as $existing_industry)
                    <div id="industry_{{$existing_industry->id}}" class="d-flex border-bottom">
                        <div class="p-2">
                            <i class="fa fa-industry"></i>
                        </div>
                        <div class="p-2 flex-grow-1">
                            {{$existing_industry->name}}
                        </div>
                        <div class="p-2">
                            <button
                                type="button"
                                id="removeIndustry_{{$existing_industry->id}}" 
                                onclick="hideIndustryRow('{{$existing_industry->id}}')"
                                class="btn btn-danger btn-sm"
                            >
                                <i class="fa fa-trash"></i> 
                                Remove
                            </button>
                            <button
                                type="button"
                                id="undoRemoveIndustry_{{$existing_industry->id}}" 
                                onclick="showIndustryRow('{{$existing_industry->id}}')"
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
            <input id="industriesArray" name="industries_array" type="hidden" class="form-control mb-3" value="{{$company->industry_ids ? $company->industry_ids.',' : null}}">
            <input id="deletedIndustriesArray" name="deleted_industries_array" type="hidden" class="form-control" value="">

            <button type="submit" class="btn btn-success btn-sm mt-5">
                <i class="fa-regular fa-floppy-disk"></i> Save changes
            </button>
        </form>
    </div>
</x-admin-card>


<script>
    // ADD CATEGORY (Add company to another category)
    var newCategory;
    newCategory = document.getElementById('newCategory');
    newCategory.addEventListener('change', function(){
        var newCategoryId;
        newCategoryId = newCategory.value;
        var name;
        name = newCategory.options[newCategory.selectedIndex].text;
        categoryIsInList = false;
        categoriesArray = document.getElementById('categoriesArray');
        categoriesArrayValues = categoriesArray.value;
        categoriesValuesArray = categoriesArray.value.split(',');
        categoryIsInList = categoriesValuesArray.includes(newCategoryId);
        if(categoryIsInList){
            // Category is already in the list
            console.log('Already in list');
            document.getElementById('category_' + newCategoryId).style.background="#FFF3CD";
        }else{
            deletedCategoriesArray = document.getElementById('deletedCategoriesArray');
            deletedValues = deletedCategoriesArray.value;
            deletedValuesArray = deletedValues.split(',');
            categoryIsInList = deletedValuesArray.includes(newCategoryId);
            if(categoryIsInList){
                // Category is in the deleted list
                console.log('Already in delete list');
                showCategoryRow(newCategoryId, 'preserveDeleteArray');
            }else{
                // Category is not in the list or the deleted list
                console.log('Not in list');
                var categoriesList;
                categoriesList = document.getElementById('categoriesList');
                categoriesList.innerHTML += '<div id="category_' + newCategoryId + '" class="d-flex border-bottom"><div class="p-2"><i class="fa fa-folder"></i></div><div class="p-2 flex-grow-1">' + name + '</div><div class="p-2"><button type="button" id="removeCategory_' + newCategoryId + '" onclick="hideCategoryRow(' + newCategoryId + ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Remove</button><button type="button" id="undoRemoveCategory_' + newCategoryId + '" onclick="showCategoryRow(' + newCategoryId + ')" class="btn btn-secondary btn-sm" style="display: none;"><i class="fa fa-undo"></i> Undo</button></div></div>';
                // Set values for form field
                categoriesArray.value+=newCategoryId + ',';
            }
        }        
    });

    // HIDE ROW (Remove category)
    function hideCategoryRow(id){
        // Set opacity for row
        var row = document.getElementById('category_' + id);
        row.style.opacity="0.3";

        // Show/hide delete/undo buttons
        var removeCategoryButton = document.getElementById('removeCategory_' + id);
        var undoRemoveCategoryButton = document.getElementById('undoRemoveCategory_' + id);
        removeCategoryButton.style.display="none";
        undoRemoveCategoryButton.style.display="inline-block";

        // Get the current list of colors to be deleted
        categoriesArray = document.getElementById("categoriesArray");
        listIds = categoriesArray;
        listIds = listIds.value.replace(/,\s*$/, "");
        listItems = listIds.toString().split(',');
        
        // Make a new list with the updated values
        var newList = '';
        for(var i = 0; i < listItems.length; i++){
            // console.log(listItems[i]);
            if(listItems[i] != id){
                newList+=listItems[i] + ',';
            }
        }
        // Set the value of the form field
        categoriesArray.value = newList;  
        // Set values for form field
        deletedCategoriesArray = document.getElementById('deletedCategoriesArray');
        deletedCategoriesArray.value+=id + ',';
    }
    // SHOW ROW (Undo remove category)
    function showCategoryRow(id, preserveDeleteArray){
        // Set opacity for row
        var row = document.getElementById('category_' + id);
        row.style.opacity="1";
        // Show/hide delete/undo buttons
        var removeCategoryButton = document.getElementById('removeCategory_' + id);
        var undoRemoveCategoryButton = document.getElementById('undoRemoveCategory_' + id);
        undoRemoveCategoryButton.style.display="none";
        removeCategoryButton.style.display="inline-block";
        // Set values for form field
        categoriesArray = document.getElementById('categoriesArray');
        categoriesArray.value+=id + ',';
        // Get the current list of colors to be deleted
        deletedCategoriesArray = document.getElementById("deletedCategoriesArray");
        listIds = deletedCategoriesArray;
        listIds = listIds.value.replace(/,\s*$/, "");
        listItems = listIds.toString().split(',');
        // Make a new list with the updated values
        var newList = '';
        for(var i = 0; i < listItems.length; i++){
            // console.log(listItems[i]);
            if(listItems[i] != id){
                newList+=listItems[i] + ',';
            }
        }
        // Set the value of the form field
        deletedCategoriesArray.value = newList;  
    }



    // ADD INDUSTRY (Add company to another industry)
    var newIndustry;
    newIndustry = document.getElementById('newIndustry');
    newIndustry.addEventListener('change', function(){

        var newIndustryId;
        newIndustryId = newIndustry.value;
        
        var name;
        name = newIndustry.options[newIndustry.selectedIndex].text;

        industryIsInList = false;

        industriesArray = document.getElementById('industriesArray');
        industriesArrayValues = industriesArray.value;
        industriesValuesArray = industriesArray.value.split(',');
        industryIsInList = industriesValuesArray.includes(newIndustryId);

        if(industryIsInList){
            // Category is already in the list
            console.log('Already in list');
            document.getElementById('industry_' + newIndustryId).style.background="#FFF3CD";
        }
        
        else{
            deletedIndustriesArray = document.getElementById('deletedIndustriesArray');
            deletedValues = deletedIndustriesArray.value;
            deletedValuesArray = deletedValues.split(',');
            industryIsInList = deletedValuesArray.includes(newIndustryId);
            if(industryIsInList){
                // Category is in the deleted list
                console.log('Already in delete list');
                showCategoryRow(newIndustryId, 'preserveDeleteArray');
            }else{
                // Category is not in the list or the deleted list
                console.log('Not in list');
                var industriesList;
                industriesList = document.getElementById('industriesList');
                industriesList.innerHTML += '<div id="industry_' + newIndustryId + '" class="d-flex border-bottom"><div class="p-2"><i class="fa fa-folder"></i></div><div class="p-2 flex-grow-1">' + name + '</div><div class="p-2"><button type="button" id="removeIndustry_' + newIndustryId + '" onclick="hideIndustryRow(' + newIndustryId + ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Remove</button><button type="button" id="undoRemoveIndustry_' + newIndustryId + '" onclick="showIndustryRow(' + newIndustryId + ')" class="btn btn-secondary btn-sm" style="display: none;"><i class="fa fa-undo"></i> Undo</button></div></div>';
                // Set values for form field
                industriesArray.value+=newIndustryId + ',';
                console.log('Bosh');
                console.log(newIndustryId);
            }
        }        
    });

    // HIDE ROW (Remove category)
    function hideIndustryRow(id){
        // Set opacity for row
        var row = document.getElementById('industry_' + id);
        row.style.opacity="0.3";

        // Show/hide delete/undo buttons
        var removeIndustryButton = document.getElementById('removeIndustry_' + id);
        var undoRemoveIndustryButton = document.getElementById('undoRemoveIndustry_' + id);
        removeIndustryButton.style.display="none";
        undoRemoveIndustryButton.style.display="inline-block";

        // Get the current list of colors to be deleted
        industriesArray = document.getElementById("industriesArray");
        listIds = industriesArray;
        listIds = listIds.value.replace(/,\s*$/, "");
        listItems = listIds.toString().split(',');
        
        // Make a new list with the updated values
        var newList = '';
        for(var i = 0; i < listItems.length; i++){
            // console.log(listItems[i]);
            if(listItems[i] != id){
                newList+=listItems[i] + ',';
            }
        }
        // Set the value of the form field
        industriesArray.value = newList;  
        // Set values for form field
        deletedIndustriesArray = document.getElementById('deletedIndustriesArray');
        deletedIndustriesArray.value+=id + ',';
    }
    // SHOW ROW (Undo remove category)
    function showIndustryRow(id, preserveDeleteArray){
        // Set opacity for row
        var row = document.getElementById('industry_' + id);
        row.style.opacity="1";
        // Show/hide delete/undo buttons
        var removeIndustryButton = document.getElementById('removeIndustry_' + id);
        var undoRemoveIndustryButton = document.getElementById('undoRemoveIndustry_' + id);
        undoRemoveIndustryButton.style.display="none";
        removeIndustryButton.style.display="inline-block";
        // Set values for form field
        industriesArray = document.getElementById('industriesArray');
        industriesArray.value+=id + ',';
        // Get the current list of colors to be deleted
        deletedIndustriesArray = document.getElementById("deletedIndustriesArray");
        listIds = deletedIndustriesArray;
        listIds = listIds.value.replace(/,\s*$/, "");
        listItems = listIds.toString().split(',');
        // Make a new list with the updated values
        var newList = '';
        for(var i = 0; i < listItems.length; i++){
            // console.log(listItems[i]);
            if(listItems[i] != id){
                newList+=listItems[i] + ',';
            }
        }
        // Set the value of the form field
        deletedIndustriesArray.value = newList;  
    }
</script>