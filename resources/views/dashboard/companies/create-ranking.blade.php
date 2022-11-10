<x-admin-card>
    <x-company-edit-buttons :company="$company" />
    <h1>Add a new ranking</h1>
    <div class="w-100 justify-content-center">
        <form action="/dashboard/companies/{{$company->hex}}/rankings/store" method="POST" class="w-50">
            @csrf

            {{-- Year --}}
            <label for="year">Year</label>
            <input 
                type="text"
                name="year"
                class="form-control mb-3"
                placeholder="YYYY"
                value="{{old('year')}}"
            >
            @error('year')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Turnover --}}
            <label for="turnover">Turnover</label>
            <input 
                id="turnover"
                type="text"
                name="turnover"
                class="form-control mb-3"
                placeholder="Turnover"
                value="{{old('turnover')}}"
                oninput="updateRenderedTurnover()"
            >
            @error('turnover')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Rendered turnover --}}
            <label for="rendered_turnover">Rendered turnover</label>
            <input 
                id="renderedTurnover"
                type="text"
                name="rendered_turnover"
                class="form-control mb-3"
                placeholder="Rendered turnover"
                value="{{old('turnover')}}"
                disabled
            >

            {{-- Employees --}}
            <label for="employees">Employees</label>
            <input 
                id="employees"
                type="text"
                name="employees"
                class="form-control mb-3"
                placeholder="Employees"
                value="{{old('employees')}}"
                oninput="updateRenderedEmployees()"
            >
            @error('employees')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Rendered employees --}}
            <label for="rendered_employees">Rendered employees</label>
            <input 
                id="renderedEmployees"
                type="text"
                name="rendered_employees"
                class="form-control mb-3"
                placeholder="Rendered employees"
                value="{{old('employees')}}"
                disabled
            >

            {{-- Training rate --}}
            <label for="training_rate">Training rate</label>
            <input 
                type="text"
                name="training_rate"
                class="form-control mb-3"
                placeholder="Training rate"
                value="{{old('training_rate')}}"
            >
            @error('training_rate')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- Confirmed by company --}}
            <label for="confirmed_by_company">Confirmed by company</label>
            <select name="confirmed_by_company" class="form-select mb-3">
                <option value="" selected disabled>Select an option</option>
                <option value="1" {{(old('confirmed_by_company') == true) ? 'selected' : null}}>Yes</option>
                <option value="" {{(old('confirmed_by_company') == false) ? 'selected' : null}}>No</option>
            </select>
            @error('confirmed_by_company')
                <p class="text-danger">{{$message}}</p>
            @enderror

            

            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa-regular fa-floppy-disk"></i> Save changes
            </button>

        </form>
    </div>

    <script>
        var renderedTurnover;
        var renderedEmployees;
        renderedTurnover = document.getElementById('renderedTurnover');
        renderedEmployees = document.getElementById('renderedEmployees');

        renderedTurnover.value=renderNumber(document.getElementById('turnover').value);
        renderedEmployees.value=renderNumber(document.getElementById('employees').value);

        function renderNumber(number){
            return number.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
        }

        function updateRenderedTurnover(){
            turnoverValue = document.getElementById('turnover').value;
            renderedTurnover.value=renderNumber(turnoverValue);
        }

        function updateRenderedEmployees(){
            var employeesValue;
            employeesValue = document.getElementById('employees').value
            renderedEmployees.value=renderNumber(employeesValue);
        }
    </script>

</x-admin-card>