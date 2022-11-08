<div class="card p-4 mb-3">
    <div class="row">
        <div class="col-3">
            @if($comment->user)
                <img 
                    src="{{$comment->user->image ? asset('images/users/'.$comment->user->hex.'/tn-'.$comment->user->image) : asset('images/no-image.png')}}" 
                    alt=""
                    class="mb-3 pt-1 pe-5 w-100"
                >
                {{$comment->user->full_name}}
            @else
                <img 
                    src="{{asset('images/no-image.png')}}" 
                    alt=""
                    class="mb-3 pt-1 pe-5 w-100"
                >
                Unknown user
            @endif
            
        </div>
        <div class="col-9">
            <p>{{$comment->body}}</p>
            <p>{{$comment->date}}</p>

            <a href="#" id="btnShowReplyForm_{{$comment->id}}" onclick="showReplyForm({{$comment->id}}); return false" style="display: inline-block;" class="btn btn-success btn-sm"><i class="fa-solid fa-reply"></i> Reply</a>

            <a href="#" id="btnHideReplyForm_{{$comment->id}}" onclick="hideReplyForm({{$comment->id}}); return false" style="display: none;" class="btn btn-danger btn-sm"><i class="fa-solid fa-ban"></i> Cancel reply</a>

            @if($comment->user_id === auth()->user()->id)
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCommentModal_{{$comment->id}}">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
            @endif
        </div>
    </div>
    
</div>



<div id="replyForm_{{$comment->id}}" class="card p-4 mb-3" style="display: none;">

    <div class="row">
        <div class="col-3"></div>
        <div class="col-9">
            <form action="/dashboard/companies/{{$comment->company->hex}}/comments/reply" method="POST">
                @csrf

                <input type="hidden" name="comment_id" value="{{$comment->id}}">

                {{-- New comment --}}
                <textarea 
                    name="reply_body"
                    class="form-control mb-3" 
                    rows="3"
                    placeholder="Type your reply"
                >{{old('reply_body')}}</textarea>
                @error('body')
                    <p class="text-danger">{{$message}}</p>
                @enderror

                <button type="submit" class="btn btn-success btn-sm">
                    <i class="fa-regular fa-comment"></i> Send reply
                </button>

            </form>
        </div>
    </div>
</div>



@foreach($comment->nested_comments as $nested_comment)
    <div class="card p-4 mb-3" style="background: #fff3cd;"> 
        <div class="row">
            <div class="col-3">
                @if($nested_comment->user)
                    <img 
                        src="{{$nested_comment->user->image ? asset('images/users/'.$nested_comment->user->hex.'/tn-'.$nested_comment->user->image) : asset('images/no-image.png')}}" 
                        alt=""
                        class="mb-3 pt-1 pe-5 w-100"
                    >
                    {{$nested_comment->user->full_name}}
                @else
                    <img 
                        src="{{asset('images/no-image.png')}}" 
                        alt=""
                        class="mb-3 pt-1 pe-5 w-100"
                    >
                    Unknown user
                @endif
            </div>
            <div class="col-9">
                <p><b>Replying to {{($comment->user) ? $comment->user->full_name : 'Unknown user'}}</b></p>
                <p>{{$nested_comment->body}}</p>
                <p>{{$nested_comment->date}}</p>

                @if($nested_comment->user_id === auth()->user()->id)
                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteCommentModal_{{$nested_comment->id}}">
                        <i class="fa-solid fa-trash"></i> Delete
                    </button>
                @endif
            </div>
        </div>
    </div>
@endforeach