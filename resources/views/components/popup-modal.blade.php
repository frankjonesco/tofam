
@if(isset($user))
    <!-- Delete user -->
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

@if(isset($colorSwatch))
    <!-- Delete color swatch -->
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


@if(isset($category))
    <!-- Delete category -->
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


@if(isset($industry))
    <!-- Delete industry -->
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


@if(isset($article))
    <!-- Delete article -->
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


@if(isset($comments))
    <!-- Delete comment -->
    @foreach($comments as $comment)
        <div class="modal fade" id="deleteCommentModal_{{$comment->id}}" tabindex="-1" aria-labelledby="deleteCommentModalLabel_{{$comment->id}}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteCommentModalLabel_{{$comment->id}}">Delete comment?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
            
                    <div class="modal-footer" style="border-top:none;">
                        <form action="/dashboard/companies/{{$comment->company->hex}}/comments/delete" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="comment_id" value="{{$comment->id}}">
                            <button class="btn btn-danger"><i class="fa-solid fa-trash"></i> Confirm delete</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div> 
    @endforeach
@endif


@if(isset($contacts))
    <!-- Delete contacts -->
    @foreach($contacts as $contact)
        <div class="modal fade" id="deleteContactModal_{{$contact->hex}}" tabindex="-1" aria-labelledby="deleteContactModalLabel_{{$contact->hex}}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteContactModalLabel_{{$contact->hex}}">Delete contact?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-3">
                                <div>    
                                    <img 
                                        src="{{asset('images/users/default-profile-pic-male.jpg')}}" 
                                        class="card-img-top" 
                                        alt="{{$contact->hex}}"
                                    >
                                </div>
                            </div>
                            <div class="col-9 align-self-center">
                                <p>{{$contact->formal_name}}</p>
                            </div>
                        </div>
                    </div>
            
                    <div class="modal-footer">
                        <form action="/dashboard/companies/{{$contact->company->hex}}/contacts/delete" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="contact_hex" value="{{$contact->hex}}">
                            <button class="btn btn-danger"><i class="fa-solid fa-trash"></i> Confirm delete</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div> 
    @endforeach
@endif

@if(isset($rankings))
    <!-- Delete comment -->
    @foreach($rankings as $ranking)
        <div class="modal fade" id="deleteRankingModal_{{$ranking->hex}}" tabindex="-1" aria-labelledby="deleteRankingModalLabel_{{$ranking->hex}}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteRankingModalLabel_{{$ranking->hex}}">Delete Ranking?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <h5 class="text-center">Year: {{$ranking->year}}</h5>
                        <h6 class="text-center">{{$ranking->company->handle}}</h6>
                    </div>
            
                    <div class="modal-footer">
                        <form action="/dashboard/companies/{{$ranking->company->hex}}/rankings/delete" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="ranking_hex" value="{{$ranking->hex}}">
                            <button class="btn btn-danger"><i class="fa-solid fa-trash"></i> Confirm delete</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div> 
    @endforeach
@endif
