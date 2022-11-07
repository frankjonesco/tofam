<x-admin-card>
        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="/dashboard/color-swatches">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteColorSwatchModal">
                <i class="fa-solid fa-trash"></i> Delete
            </button>
            <x-popup-modal :colorSwatch="$color_swatch" />
        </x-buttons-bar>

        
        <div class="w-100">

            {{-- Form for editing colors --}}
            <form action="/dashboard/color-swatches/update" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="hex" value="{{$color_swatch->hex}}">

                <h1>Edit color swatch</h1>

                {{-- Edit swatch details --}}
                <label for="">Color swatch name</label>
                <input class="form-control input-lg mb-3" name="name" value="{{$color_swatch->name}}">
                <label for="">Decsription</label>
                <textarea class="form-control mb-3" name="description" rows="3">{{$color_swatch->description}}</textarea>
                

                {{-- Colors table --}}
                <table id="colorsTable" class="table">

                    {{-- Table header row --}}
                    <thead>
                        <tr>
                            <th class="align-middle" scope="col">#</th>
                            <th class="align-middle" scope="col">Color</th>
                            <th class="align-middle" scope="col">Code</th>
                            <th class="align-middle" scope="col">Name</th>
                            <th class="align-middle" scope="col"></th>
                        </tr>
                    </thead>

                    {{-- Table body --}}
                    <tbody id="tableBody">
                        @foreach($color_swatch->colors as $color)
                            <tr 
                                id="row_{{$color->fill_id}}"
                            >
                                {{-- Fill ID --}}
                                <th 
                                    id="td_{{$color->fill_id}}" 
                                    class="align-middle" 
                                    scope="row"
                                >
                                    {{$color->fill_id}}
                                </th>
                                
                                {{-- Color square --}}
                                <td 
                                    class="align-middle"
                                >
                                    <div 
                                        id="color_square_{{$color->fill_id}}" 
                                        class="color-square" 
                                        style="background: #{{$color->code}};"
                                    >
                                    </div>
                                </td>
                                
                                {{-- Color code --}}
                                @error('code_'.$color->fill_id)
                                    <td 
                                        class="align-middle"
                                    >
                                        <input 
                                            id="input_code_{{$color->fill_id}}" 
                                            type="text" 
                                            class="form-control" 
                                            name="code_{{$color->fill_id}}" 
                                            value="{{old('code_'.$color->fill_id)}}" 
                                            maxlength="6" 
                                            oninput="countColorCodeCharacters({{$color->fill_id}})"
                                            autofocus
                                        >
                                        <script>
                                            const input = document.getElementById('input_code_{{$color->fill_id}}');
                                            const end = input.value.length;
                                            input.setSelectionRange(end, end);
                                            input.focus();
                                        </script>
                                    </td>
                                @else
                                    <td 
                                        class="align-middle"
                                    >
                                        <input 
                                            id="input_code_{{$color->fill_id}}" 
                                            type="text" 
                                            class="form-control" 
                                            name="code_{{$color->fill_id}}" 
                                            value="{{$color->code}}" 
                                            maxlength="6"
                                            oninput="countColorCodeCharacters({{$color->fill_id}})"
                                        >
                                    </td>                                    
                                @enderror
                                
                                {{-- Color name --}}
                                @error('name_'.$color->fill_id)
                                    <td 
                                        class="align-middle"
                                        >
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                id="name_{{$color->fill_id}}" 
                                                name="name_{{$color->fill_id}}" 
                                                value="{{old('name_'.$color->fill_id)}}"
                                                autofocus
                                            >
                                            <script>
                                                const input = document.getElementById('name_{{$color->fill_id}}');
                                                const end = input.value.length;
                                                input.setSelectionRange(end, end);
                                                input.focus();
                                            </script>
                                    </td> 
                                @else
                                    <td 
                                        class="align-middle"
                                        >
                                            <input 
                                                type="text" 
                                                class="form-control" 
                                                name="name_{{$color->fill_id}}" 
                                                value="{{$color->name}}"
                                            >
                                    </td>                                 
                                @enderror
                                

                                {{-- Buttons --}}
                                <td 
                                    style="text-align: right;" 
                                    class="align-middle"
                                >   
                                    {{-- Delete button --}}
                                    <button 
                                        id="deleteButton_{{$color->fill_id}}" 
                                        onclick="hideRow('fill_id_{{$color->fill_id}}', '{{$color->fill_id}}', 'original')" 
                                        type="button" 
                                        class="btn btn-danger btn-sm"
                                    >
                                        <i class="fa fa-trash"></i>     
                                        Delete
                                    </button>

                                    {{-- Undo delete button --}}
                                    <button 
                                        id="undoDeleteButton_{{$color->fill_id}}" 
                                        onclick="showRow('fill_id_{{$color->fill_id}}', '{{$color->fill_id}}')" 
                                        type="button" 
                                        class="btn btn-secondary btn-sm" 
                                        style="display: none;"
                                    >
                                        <i class="fa fa-undo"></i>     
                                        Undo
                                    </button>
                                </td>
                            </tr>

                            {{-- Validation errors --}}
                            @error('code_'.$color->fill_id)
                                <tr>
                                    <td colspan="5" class="align-middle text-center text-danger" style="background: #fff3cd;">
                                        {{$message}}
                                    </td>
                                </tr>
                            @else
                                @error('name_'.$color->fill_id)
                                    <tr>
                                        <td colspan="5" class="align-middle text-center text-danger" style="background: #fff3cd;">
                                            {{$message}}
                                        </td>
                                    </tr>
                                @enderror
                            @enderror
                        @endforeach
                    </tbody>
                </table>

                {{-- Form control buttons --}}
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary btn-sm me-2" onclick="addNewColor()">Add another color</button>
                    <a href="{{url()->previous()}}">
                        <button id="test" type="submit" class="btn btn-secondary btn-sm me-2">Cancel</button>
                    </a>
                    <button type="submit" class="btn btn-sm btn-success">Save changes</button>
                </div>

                <input type="hidden" id="currentHighestColorNumber" name="currentHighestColorNumber" value="{{count($color_swatch->colors)}}">
                <input type="hidden" id="countNewColors" name="countNewColors" value="0">
                <input type="hidden" id="countDeletedColors" name="countDeletedColors" value="0">
                <input type="hidden" id="idsToBeDeleted" name="idsToBeDeleted" value="">
                <input type="hidden" id="colorsNewTotal" name="colorsNewTotal" value="{{count($color_swatch->colors)}}">
                <input type="hidden" name="color_swatch_id" value="{{$color_swatch->id}}">

            </form>
        </div>
</x-admin-card>


<script>

    // INCREMENT VALUE
    function incrementValue(source){
        field = document.getElementById(source);
        currentValue = field.value;
        newValue = parseInt(currentValue, 10) + 1;
        field.value = newValue;
        return newValue;
    }


    // DECREMENT VALUE
    function decrementValue(source){
        field = document.getElementById(source);
        currentValue = field.value;
        newValue = parseInt(currentValue, 10) - 1;
        field.value = newValue;
        return newValue;
    }


    // ADD A NEW COLOR
    function addNewColor(){
        // Increment the currentHightestColorNumber field and assign to 'rowNumber'
        rowNumber = incrementValue('currentHighestColorNumber');
        // Increment the countNewColors field
        incrementValue('countNewColors');
        // Increment the colorsNewTotal field
        incrementValue('colorsNewTotal');
        // Set the new table row ID
        var newTableRowId = rowNumber;
        // Set new table row content
        var newTableRowContent = '<th id="td_' + rowNumber + '" class="align-middle" scope="row">' + rowNumber + '</th><td class="align-middle"><div id="color_square_' + rowNumber + '" class="color-square" style="background: #FFFFFF;"></div></td><td class="align-middle"><input id="input_code_' + rowNumber + '" type="text" class="form-control" name="code_' + rowNumber + '" value="FFFFFF" maxlength="6" oninput="countColorCodeCharacters(' + rowNumber + ')"></td><td class="align-middle"><input type="text" class="form-control" name="name_' + rowNumber + '" value="Plain White"></td><td style="text-align: right;" class="align-middle"><button id="deleteButton_' + rowNumber + '" onclick="hideRow(' + newTableRowId + ', ' + rowNumber + ', \'new\')" type="button" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i>Delete</button><button id="undoDeleteButton_' + rowNumber + '" onclick="showRow(' + newTableRowId + ', ' + rowNumber + ')" type="button" class="btn btn-secondary btn-sm" style="display: none;"><i class="fa fa-undo"></i> Undo</button></td>';
        // Get the table
        var tableBody = document.getElementById('tableBody');
        // Insert the new row
        var newTableRow = tableBody.insertRow(tableBody.rows.length);
        // Add the content to the new row
        newTableRow.innerHTML = newTableRowContent;
        // Set the ID for the new row
        row = document.getElementById('td_' + rowNumber).parentNode;
        row.setAttribute("id", newTableRowId, 0);
        // Log this action
        console.log('Action: Added new color');
        console.log('New color number: ' + rowNumber);
    }


    // COUNT COLOR CODE CHARACTERS
    function countColorCodeCharacters(rowNumber){
        // Get color value for this row
        colorInput = document.getElementById('input_code_' + rowNumber).value;
        // If the color value contains 6 characters...
        if(colorInput.length == 6){
            // Change the color of the box
            changeColorCode(rowNumber, colorInput);
        }
    }


    // CHANGE COLOR CODE
    function changeColorCode(rowNumber, colorInput){
        // Update the color square
        colorCode = "#" + colorInput;
        document.getElementById('color_square_' + rowNumber).style.backgroundColor=colorCode;       
        // Log this action
        console.log('Action: Change color code');
        console.log('Color number: ' + rowNumber);
        console.log('New color: ' + colorCode);
    }
            

    // HIDE ROW (DELETE COLOR)
    function hideRow(row, colorNumber, type){
        // Set opacity for row
        var row = document.querySelector('#td_' + colorNumber);
        row.parentNode.style.opacity="0.3";

        // Increment the colorsNewTotal field
        colorsNewTotal = document.getElementById('currentHighestColorNumber');
        colorsNewTotal.value = colorsNewTotal.value;

        // Increment the countDeletedColors field
        incrementValue('countDeletedColors');
        
        // Show/hide delete/undo buttons
        var deleteButton = document.getElementById('deleteButton_' + colorNumber);
        var undoDeleteButton = document.getElementById('undoDeleteButton_' + colorNumber);
        deleteButton.style.display="none";
        undoDeleteButton.style.display="inline-block";

        // Set values for form field
        idsToBeDeleted.value+=colorNumber + ',';

        // Log this action
        console.log('Action: Deleted color');
        console.log('Color number: ' + colorNumber);
        console.log('List of colors to delete: ' + idsToBeDeleted.value);
    }


    // SHOW ROW (UNDO DELETE COLOR)
    function showRow(row, colorNumber, type){
        // Set opacity for row
        var row = document.querySelector('#td_' + colorNumber);
        row.parentNode.style.opacity="1";

        // Increment the colorsNewTotal field
        colorsNewTotal = document.getElementById('currentHighestColorNumber');
        colorsNewTotal.value = colorsNewTotal.value;

        // Decrement the countDeletedColors field
        decrementValue('countDeletedColors');

        // Show/hide delete/undo button
        var deleteButton = document.getElementById('deleteButton_' + colorNumber);
        var undoDeleteButton = document.getElementById('undoDeleteButton_' + colorNumber);
        deleteButton.style.display="inline-block";
        undoDeleteButton.style.display="none";

        // Get the current list of colors to be deleted
        idsToBeDeleted = document.getElementById("idsToBeDeleted");
        listIds = idsToBeDeleted;
        listIds = listIds.value.replace(/,\s*$/, "");
        listItems = listIds.toString().split(',');
        
        // Make a new list with the updated values
        var newList = '';
        for(var i = 0; i < listItems.length; i++){
            // console.log(listItems[i]);
            if(listItems[i] != colorNumber){
                newList+=listItems[i] + ',';
            }
        }

        // Set the value of the form field
        idsToBeDeleted.value = newList;  
    }
</script>



       
    