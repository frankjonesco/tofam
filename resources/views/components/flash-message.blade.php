@if(session()->has('message'))
    <div 
        x-data="{show: true}" 
        x-init="setTimeout(() => show = false, 3000)" 
        x-show="show" 
        class="alert alert-success"     
        style="position:fixed; top:0; left:0; right:0; width:476px; margin:5% auto; text-align:center; box-shadow:1px 1px 7px #ccc;"

        x-show="animate" 
        x-transition:enter="transition ease-out duration-1000" 
        x-transition:enter-start="opacity-0 transform scale-90" 
        x-transition:enter-end="opacity-100 transform scale-100" 
        x-transition:leave="transition ease-in duration-1000" 
        x-transition:leave-start="opacity-100 transform scale-100" 
        x-transition:leave-end="opacity-0 transform scale-90" 
        {{-- class="rounded shadow-md p-2 m-4 w-1/4 text-center bg-gray-700 text-white" --}}
    >
        {{session('message')}}
    </div>
@endif

