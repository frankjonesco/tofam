<x-layout>
    <x-card>

        <div class="bg-white border p-5">
            

            <div class="row">
                <div class="col-3">
                    <div class="company-image">
                        <img 
                            src="{{$company->image ? asset('/images/companies/'.$company->hex.'/'.$company->image) : asset('/images/no-image.png')}}" 
                            alt="{{$company->handle}}" class="w-100"
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
                    <h1>{{$company->handle}}</h1>
                    <p><b>Registered name:</b> {{$company->registered_name}}</p>
                    @if($company->parent_organization)
                        <p><b>Parent organization:</b> {{$company->parent_organization}}</p>
                    @endif
                    
                    <p>{{$company->description}}</p>
                    <p>
                        <b>Company address:</b> {{$company->address}}<br>
                        <b>Phone:</b> {{$company->address_phone}}
                    </p>

                    {{-- Industries --}}
                    @if(count($company->getIndustries($company->industry_ids)) > 0)
                        <p>
                            <b>Industries:</b> 
                            @php
                                $numItems = count($company->getIndustries($company->industry_ids));
                                $i = 0;
                            @endphp
                            @foreach($company->getIndustries($company->industry_ids) as $key => $industry)
                                @if(++$i === $numItems)
                                    <a href="/industries/{{$industry->slug}}">{{$industry->name}}</a>
                                @else
                                    <a href="/industries/{{$industry->slug}}">{{$industry->name}}</a>,    
                                @endif
                            @endforeach
                        </p>
                    @endif
                    
                    {{-- Categories --}}
                    @if(count($company->getCategories($company->category_ids)) > 0)
                        <p>
                            <b>Categories:</b> 
                            @php
                                $numItems = count($company->getCategories($company->category_ids));
                                $i = 0;
                            @endphp
                            @foreach($company->getCategories($company->category_ids) as $key => $category)
                                @if(++$i === $numItems)
                                    <a href="/categories/{{$category->slug}}">{{$category->name}}</a>
                                @else
                                    <a href="/categories/{{$category->slug}}">{{$category->name}}</a>,    
                                @endif
                            @endforeach
                        </p>
                    @endif
                </div>
            </div>
            
        </div>

    </x-card>
</x-layout>