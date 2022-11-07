<!-- Delete user -->
@if(isset($user))
    <div class="modal fade" id="deleteUserModal{{$user->hex}}" tabindex="-1" aria-labelledby="deleteUserModalLabel{{$user->hex}}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteUserModalLabel{{$user->hex}}">Delete user?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{$user->full_name}}
                </div>
                <div class="modal-footer">
                    <form action="/dashboard/users/{{$user->hex}}/delete" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger"><i class="fa-solid fa-trash"></i> Confirm delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endif
<!-- Delete color swatch -->
@if(isset($colorSwatch))

    <div class="modal fade" id="deleteColorSwatchModal" tabindex="-1" aria-labelledby="deleteColorSwatchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteColorSwatchModalLabel">Delete color swatch?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                @if($colorSwatch->inUse())
                    <div class="modal-body">
                        You can not delete a color swatch while it is in use.<br>Select a differenct swatch to use before deleting this swatch.
                    </div>  
                    <div class="modal-footer">
                        <a href="/dashboard/color-swatches">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                                <i class="fa fa-brush"></i> 
                                Select another swatch
                            </button>
                        </a>
                    </div>
                @else
                    <div class="modal-body">
                        {{$colorSwatch->name}}
                    </div>
                    <div class="modal-footer">
                        <form action="/dashboard/color-swatches/{{$colorSwatch->hex}}/delete" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger"><i class="fa-solid fa-trash"></i> Confirm delete</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                @endif
            </div>
        </div>
    </div> 
@endif

<!-- Delete category -->
@if(isset($category))
    <div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-labelledby="deleteCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteCategoryModalLabel">Delete category?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{$category->name}}
                </div>
                <div class="modal-footer">
                    <form action="/dashboard/categories/{{$category->hex}}/delete" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger"><i class="fa-solid fa-trash"></i> Confirm delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Delete industry -->
@if(isset($industry))
    <div class="modal fade" id="deleteIndustryModal" tabindex="-1" aria-labelledby="deleteIndustryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteIndustryModalLabel">Delete category?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{$industry->name}}
                </div>
                <div class="modal-footer">
                    <form action="/dashboard/industries/{{$industry->hex}}/delete" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger"><i class="fa-solid fa-trash"></i> Confirm delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Delete article -->
@if(isset($article))
    <div class="modal fade" id="deleteArticleModal" tabindex="-1" aria-labelledby="deleteArticleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteArticleModalLabel">Delete article?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{$article->title}}
                </div>
                <div class="modal-footer">
                    <form action="/dashboard/articles/{{$article->hex}}/delete" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger"><i class="fa-solid fa-trash"></i> Confirm delete</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div> 
@endif