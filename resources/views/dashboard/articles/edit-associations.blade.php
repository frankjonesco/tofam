<x-admin-card>

    <x-article-edit-buttons :article="$article"/>

    <h1>Manage associated companies</h1>


    <h5>Select which companies you would like to associate with this article. </h5>
    <div class="w-100 justify-content-center">
        <form action="/dashboard/articles/{{$article->hex}}/associations/update" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="hex" value="{{$article->hex}}">
            
            <h5 class="pt-4">Associate a new company</h5>
            {{-- Select a new company --}}
            <label for="new_company">Select an company</label>
            <select id="newCompany" rel="#" name="new_company" class="form-select mb-3">
                <option value="" selected disabled>Select a new company...</option>
                @foreach($companies as $company)
                    <option value="{{$company->id}}">{{$company->handle}}</option>
                @endforeach
            </select>
            @error('new_company')
                <p class="text-danger">{{$message}}</p>
            @enderror
            <div id="companiesList" class="mb-4">
                <h5 class="pt-4">Current associations:</h5>
                @if(empty($existing_associations))
                    <p id="noCompaniesMessage">There are no current associations.</p>
                @else
                    @foreach($existing_associations as $existing_association)
                        <div id="company_{{$existing_association->company_id}}" class="d-flex border-bottom">
                            <div class="p-2">
                                <i class="fa fa-building"></i>
                            </div>
                            <div class="p-2 flex-grow-1">
                                {{$existing_association->company->handle}}
                            </div>
                            <div class="p-2">
                                <button
                                    type="button"
                                    id="removeCompany_{{$existing_association->company_id}}" 
                                    onclick="hideCompanyRow('{{$existing_association->company_id}}')"
                                    class="btn btn-danger btn-sm"
                                >
                                    <i class="fa fa-trash"></i> 
                                    Remove
                                </button>
                                <button
                                    type="button"
                                    id="undoRemoveCompany_{{$existing_association->company_id}}" 
                                    onclick="showCompanyRow('{{$existing_association->company_id}}')"
                                    class="btn btn-secondary btn-sm"
                                    style="display: none;"
                                >
                                    <i class="fa fa-undo"></i> 
                                    Undo
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            
            <input id="companiesArray" name="companies_array" type="hidden" class="form-control mb-3" value="{{$existing_association_ids}}">
            
            <input id="deletedCompaniesArray" name="deleted_companies_array" type="hidden" class="form-control" value="">

            <button type="submit" class="btn btn-success btn-sm mt-3">
                <i class="fa-regular fa-floppy-disk"></i>
                Save associations
            </button>
        </form>
    </div>           
</x-admin-card>


<script>
    // ADD COMPANY (Association)
    var newCompany;
    newCompany = document.getElementById('newCompany');
    newCompany.addEventListener('change', function(){
        if(document.getElementById("noCompaniesMessage")){
            document.getElementById('noCompaniesMessage').style.display="none";
        }
        var newCompanyId;
        newCompanyId = newCompany.value;
        var name;
        name = newCompany.options[newCompany.selectedIndex].text;
        companyIsInList = false;
        companiesArray = document.getElementById('companiesArray');
        companiesArrayValues = companiesArray.value;
        companiesValuesArray = companiesArray.value.split(',');
        companyIsInList = companiesValuesArray.includes(newCompanyId);
        if(companyIsInList){
            // Company is already in the list
            console.log('Already in list');
            document.getElementById('company_' + newCompanyId).style.background="#FFF3CD";
        }else{
            console.log('Not in list');
            deletedCompaniesArray = document.getElementById('deletedCompaniesArray');
            deletedValues = deletedCompaniesArray.value;
            deletedValuesArray = deletedValues.split(',');
            companyIsInList = deletedValuesArray.includes(newCompanyId);
            if(companyIsInList){
                // Company is in the deleted list
                console.log('Already in delete list');
                showCompanyRow(newCompanyId, 'preserveDeleteArray');
            }else{
                // Category is not in the list or the deleted list
                console.log('Not in list');
                var companiesList;
                companiesList = document.getElementById('companiesList');
                companiesList.innerHTML += '<div id="company_' + newCompanyId + '" class="d-flex border-bottom"><div class="p-2"><i class="fa fa-building"></i></div><div class="p-2 flex-grow-1">' + name + '</div><div class="p-2"><button type="button" id="removeCompany_' + newCompanyId + '" onclick="hideCompanyRow(' + newCompanyId + ')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Remove</button><button type="button" id="undoRemoveCompany_' + newCompanyId + '" onclick="showCompanyRow(' + newCompanyId + ')" class="btn btn-secondary btn-sm" style="display: none;"><i class="fa fa-undo"></i> Undo</button></div></div>';
                // Set values for form field
                companiesArray.value+=newCompanyId + ',';
            }
        }        
    });

    // HIDE ROW (Remove company)
    function hideCompanyRow(id){
        // Set opacity for row
        var row = document.getElementById('company_' + id);
        row.style.opacity="0.3";

        // Show/hide delete/undo buttons
        var removeCompanyButton = document.getElementById('removeCompany_' + id);
        var undoRemoveCompanyButton = document.getElementById('undoRemoveCompany_' + id);
        removeCompanyButton.style.display="none";
        undoRemoveCompanyButton.style.display="inline-block";

        // Get the current list of companies to be deleted
        companiesArray = document.getElementById("companiesArray");
        listIds = companiesArray;
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
        companiesArray.value = newList;  
        // Set values for form field
        deletedCompaniesArray = document.getElementById('deletedCompaniesArray');
        deletedCompaniesArray.value+=id + ',';
    }
    // SHOW ROW (Undo remove company)
    function showCompanyRow(id, preserveDeleteArray){
        // Set opacity for row
        var row = document.getElementById('company_' + id);
        row.style.opacity="1";
        // Show/hide delete/undo buttons
        var removeCompanyButton = document.getElementById('removeCompany_' + id);
        var undoRemoveCompanyButton = document.getElementById('undoRemoveCompany_' + id);
        undoRemoveCompanyButton.style.display="none";
        removeCompanyButton.style.display="inline-block";
        // Set values for form field
        companiesArray = document.getElementById('companiesArray');
        companiesArray.value+=id + ',';
        // Get the current list of companies to be deleted
        deletedCompaniesArray = document.getElementById("deletedCompaniesArray");
        listIds = deletedCompaniesArray;
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
        deletedCompaniesArray.value = newList;  
    }

</script>