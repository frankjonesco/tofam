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
                    @if($company->founded)
                        <div class="d-flex border-bottom py-1">
                            <div class="p-2" style="width:30px; text-align: center;"><i class="fas fa-compass"></i></div>
                            <div class="p-2 flex-grow-1">Founded</div>
                            <div class="p-2">{{$company->founded}}</div>
                        </div>
                    @endif
                    @if($company->family_business)
                        <div class="d-flex border-bottom py-1">
                            <div class="p-2" style="width:30px; text-align: center;"><i class="fas fa-users me-2"></i></div>
                            <div class="p-2 flex-grow-1"> Family business</div>
                            <div class="p-2"><i class="fas fa-check"></i></div>
                        </div>
                    @endif
                    @if($company->family_generations)
                        <div class="d-flex border-bottom py-1">
                            <div class="p-2" style="width:30px; text-align: center;"><i class="far fa-calendar-alt me-2"></i></div>
                            <div class="p-2 flex-grow-1">Generations</div>
                            <div class="p-2">{{$company->family_generations}}</div>
                        </div>
                    @endif
                    @if($company->family_executive)
                        <div class="d-flex border-bottom py-1">
                            <div class="p-2" style="width:30px; text-align: center;"><i class="fas fa-user-tie"></i></div>
                            <div class="p-2 flex-grow-1">Family executive</div>
                            <div class="p-2"><i class="fas fa-check"></i></div>
                        </div>
                    @endif
                    @if($company->female_executive)
                        <div class="d-flex border-bottom py-1">
                            <div class="p-2" style="width:30px; text-align: center;"><i class="fas fa-female"></i></div>
                            <div class="p-2 flex-grow-1">Female executive</div>
                            <div class="p-2"><i class="fas fa-check"></i></div>
                        </div>
                    @endif
                    @if($company->stock_listed)
                        <div class="d-flex border-bottom py-1">
                            <div class="p-2" style="width:30px; text-align: center;"><i class="fas fa-chart-line"></i></div>
                            <div class="p-2 flex-grow-1">Listed on stock exchange</div>
                            <div class="p-2"><i class="fas fa-check"></i></div>
                        </div>
                    @endif
                    @if($company->matchbird_partner)
                        <div class="d-flex border-bottom py-1">
                            <div class="p-2" style="width:30px; text-align: center;"><i class="far fa-handshake"></i></div>
                            <div class="p-2 flex-grow-1">Matchbird partner</div>
                            <div class="p-2"><i class="fas fa-check"></i></div>
                        </div>
                    @endif

                    
                </div>
                <div class="col-9">
                    <h1>{{$company->name}}</h1>
                    <p><b>Registered name:</b> {{$company->registered_name}}</p>
                    @if($company->parent_organization)
                        <p><b>Parent organization:</b> {{$company->parent_organization}}</p>
                    @endif
                    
                    <p>{{$company->description}}</p>
                    <p>
                        <b>Company address:</b> {{$company->address}}<br>
                        <b>Phone:</b> {{$company->address_phone}}
                    </p>

                    <p>
                        <b>Industries:</b> 
                        @php
                            $numItems = count($company->industries);
                            $i = 0;
                        @endphp
                        @foreach($company->industries as $key => $industry)
                            @if(++$i === $numItems)
                                <a href="/industries/{{$industry->slug}}">{{$industry->name}}</a>
                            @else
                                <a href="/industries/{{$industry->slug}}">{{$industry->name}}</a>,    
                            @endif
                        @endforeach
                    </p>

                    <p>
                        <b>Categories:</b> 
                        @php
                            $numItems = count($company->categories);
                            $i = 0;
                        @endphp
                        @foreach($company->categories as $key => $category)
                            @if(++$i === $numItems)
                                <a href="/categories/{{$category->slug}}">{{$category->name}}</a>
                            @else
                                <a href="/categories/{{$category->slug}}">{{$category->name}}</a>,    
                            @endif
                        @endforeach
                    </p>
                </div>
            </div>
            
        </div>

    </x-card>
</x-layout>