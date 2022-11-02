<x-admin-card>
    <div class="d-flex">
        <div class="flex-grow-1">
            <h1>Color swatches</h1>
        </div>
        <div>
            <a href="/dashboard/color-swatches/create" class="btn btn-primary">Create new swatch</a>
        </div>
    </div>
    <h5 class="mb-5">You can select different color swatches to use on the site. Colors are assigned to categories and users etc. </h5>
    <div class="row">
        @foreach($color_swatches as $color_swatch)
            <div class="col-3">
                <div class="card swatch-card pt-4 pb-0" style="{{$color_swatch->inUse() ? 'background: #fff3cd;' : null}}" onclick="showColorSwatch('{{$color_swatch->hex}}')">
                    <img src="{{asset('images/color_swatches/'.$color_swatch->hex.'/'.$color_swatch->image)}}" alt="" class="mx-4 mb-4">
                    <div class="mx-3">
                        @foreach($color_swatch->colors as $key => $color)
                            <div class="color-square me-2 mb-2" style="background: #{{$color->code}};"></div>
                        @endforeach
                    </div>
                    <div class="card-body">
                        <h3 class="card-title">
                            {{$color_swatch->name}} 
                            @if($color_swatch->inUse())
                                <span class="position-relative translate-middle badge rounded-pill bg-danger" style="left:32px; top:6px; font-size:.8rem;">
                                    In use
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            @endif
                        </h3>
                        <table class="mt-3 mb-3 text-muted fw-light w-100" style="font-size: .75rem;">
                            <tr class="border-top">
                                <td>
                                    <div class="py-1">Created by:</div>
                                </td>
                                <td style="text-align: right;">
                                    <img 
                                        src="{{asset('images/users/'.auth()->user()->hex.'/tn-'.auth()->user()->image)}}" 
                                        alt="" 
                                        class="nav-user-image"
                                        style="border-color: #{{auth()->user()->color->code}}; width:20px;"    
                                    >Frank Jones
                                </td>
                            </tr>
                            <tr class="border-top border-bottom">
                                <td>
                                    <div class="py-1">Updated:</div>
                                </td>
                                <td style="text-align: right;">
                                    {{$color_swatch->updated_at}}
                                </td>
                            </tr>
                        </table>
                        <p class="card-text mb-3">
                            {{$color_swatch->description}}
                        </p>
                        <a href="/dashboard/color-swatches/{{$color_swatch->hex}}/edit" class="btn btn-primary btn-sm btn-block mb-2 mt-auto">
                            <i class="fa fa-pencil"></i> 
                            Edit color swatch
                        </a>
                        @if($color_swatch->inUse())
                            <button class="btn btn-success btn-sm btn-block mb-2" style="cursor: not-allowed; pointer-events: all !important;" disabled>
                                <i class="fa fa-brush"></i> 
                                Swatch is in use
                            </button>
                        @else
                            <a href="/dashboard/color-swatches/{{$color_swatch->hex}}/use">
                                <button class="btn btn-success btn-sm btn-block mb-2" {{$color_swatch->inUse() ? 'disabled' : null}}>
                                    <i class="fa fa-brush"></i> 
                                    Use this swatch
                                </button>
                            </a>
                        @endif
                    </div>
                </div>
            </div>            
        @endforeach
    </div>
</x-admin-card>

<script>
    function showColorSwatch(hex){
        window.location='/dashboard/color-swatches/' + hex;
    }
</script>
