<x-admin-card>

    <x-company-edit-buttons :company="$company"/>


        <h1>{{$company->handle}}</h1>
        <h4>Registered name: {{$company->registered_name}}</h4>

        <img 
            src="{{$company->image ? asset('images/companies/'.$company->hex.'/'.$company->image) : asset('images/no-image.png')}}" 
            alt=""
            style="border: 1px solid #ddd; padding: 2px;"
        >

        <p>Owner: {{$company->user->full_name}}</p>
        <p>Slug: {{$company->slug}}</p>
        <p>Parent organization: {{$company->parent_organization}}</p>
        <p>Website: {{$company->website}}</p>
        <p>Desreiption: {{$company->description}}</p>
        <p>Founded in: {{$company->founded_in}}</p>
        <p>Founded by: {{$company->founded_by}}</p>
        <p>Headqurters: {{$company->headquarters}}</p>

        <h2>Address</h2>

        <p>{{$company->address}}</p>

        <h2>Family information</h2>

        <p>Family business: {{$company->family_business ? 'Yes' : 'No'}}</p>

        <p>Family name: {{$company->family_name}}</p>

        <p>Generations: {{$company->family_generations}}</p>

        <p>Family executive: {{$company->family_executive ? 'Yes' : 'No'}}</p>

        <h2>Additional information</h2>

        <p>Female executive: {{$company->female_executive ? 'Yes' : 'No'}}</p>

        <p>Listed on stock exchange: {{$company->stock_listed ? 'Yes' : 'No'}}</p>

        <p>Matchbird partner: {{$company->matchbird_partner ? 'Yes' : 'No'}}</p>


        

</x-admin-card>
