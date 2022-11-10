<x-admin-card>

    <x-company-edit-buttons :company="$company"/>

    <h1>Edit rankings</h1>
    <a class="btn btn-success" href="/dashboard/companies/{{$company->hex}}/rankings/create">Add new ranking</a>

    <div class="w-100 justify-content-center">

        <div style="
            display: grid;
            grid-template-columns: repeat(7, 1fr);
        ">  
            <div class="p-2 flex-fill border-right border-bottom">
                <b>Year</b>
            </div>
            <div class="p-2 flex-fill border-right border-bottom">
                <b>Turnover</b>
            </div>
            <div class="p-2 flex-fill border-right border-bottom">
                <b>Employees</b>
            </div>
            <div class="p-2 flex-fill border-right border-bottom">
                <b>Training rate</b>
            </div>
            <div class="p-2 flex-fill border-right border-bottom">
                <b>Confirmed by company</b>
            </div>
            <div class="p-2 flex-fill border-right border-bottom">
                <b>Last updated</b>
            </div>
            <div class="p-2 flex-fill border-right border-bottom text-right">
                <b>Actions</b>
            </div>

            @foreach($company->rankings as $ranking)
                
                <div class="p-2 flex-fill border-right border-bottom">
                    {{$ranking->year}}
                </div>
                <div class="p-2 flex-fill border-right border-bottom">
                    {{$ranking->turnover}}
                </div>
                <div class="p-2 flex-fill border-right border-bottom">
                    {{$ranking->employees}}
                </div>
                <div class="p-2 flex-fill border-right border-bottom">
                    {{$ranking->training_rate}}
                </div>
                <div class="p-2 flex-fill border-right border-bottom">
                    {{$ranking->confirmed_by_company}}
                </div>
                <div class="p-2 flex-fill border-right border-bottom">
                    {{$ranking->updated_at}}
                </div>
                <div class="p-2 flex-fill border-bottom text-right">
                    <a href="/dashboard/companies/{{$company->hex}}/rankings/edit/{{$ranking->hex}}" class="btn btn-success btn-sm">
                        <i class="fa-solid fa-pen-to-square"></i>
                        Edit
                    </a>
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteRankingModal_{{$ranking->hex}}">
                        <i class="fa-solid fa-trash"></i> Delete
                    </button>
                </div>
                    
            @endforeach
        </div>
        
    </div>

    <x-popup-modal :rankings="$company->rankings" />
</x-admin-card>