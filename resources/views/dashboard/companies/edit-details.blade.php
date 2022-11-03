<x-admin-card>
    
    <x-edit-company-buttons :company="$company"/>

    <h1>Edit further details</h1>
    <div class="w-100 justify-content-center">
        <form action="/dashboard/companies/update/details" method="POST" class="w-50">
            @csrf
            @method('PUT')

            <input type="hidden" name="hex" value="{{$company->hex}}">

            {{-- Female executive --}}
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" name="female_executive" {{$company->female_executive == 1 ? 'checked' : null}}>
                <label class="form-check-label" for="female_executive">
                    Female executive
                </label>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" name="stock_listed" {{$company->stock_listed == 1 ? 'checked' : null}}>
                <label class="form-check-label" for="stock_listed">
                    Listed on stock exchange
                </label>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" name="matchbird_partner" {{$company->matchbird_partner == 1 ? 'checked' : null}}>
                <label class="form-check-label" for="matchbird_partner">
                    Matchbird partner
                </label>
            </div>

            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa-regular fa-floppy-disk"></i> Save changes
            </button>

        </form>
    </div>
</x-admin-card>