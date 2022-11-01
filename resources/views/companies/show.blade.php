<x-layout>
    <x-card>

        <div class="bg-white border p-5">
            

            <div class="row">
                <div class="col-3">
                    <div class="company-logo">
                        <img 
                            src="{{$company->logo ? asset('/images/companies/'.$company->hex.'/'.$company->logo) : asset('/images/no-image.png')}}" 
                            alt="{{$company->name}}"
                        >
                    </div>
                    <p>Founded: {{$company->founded}}</p>
                    <p>Family business: {{$company->family_business}}</p>
                    <p>Family generations: {{$company->family_generations}}</p>
                    <p>Family executive: {{$company->family_executive}}</p>
                    <p>Female executive: {{$company->female_executive}}</p>
                    <p>Stock listed: {{$company->stock_listed}}</p>
                    <p>Matchbird partner: {{$company->matchbird_partner}}</p>
                </div>
                <div class="col-9">
                    <h1>{{$company->short_name}}</h1>
                    <p>Registered name: {{$company->name}}</p>
                    <p>Parent organization: {{$company->parent_organization}}</p>
                    <p>Address: {{$company->address}}</p>
                    <p>Phone: {{$company->address_phone}}</p>
                    <p>Headquarters: {{$company->headquarters}}</p>
                    <p>Description: {{$company->description}}</p>
                </div>
            </div>
            
        </div>

    </x-card>
</x-layout>