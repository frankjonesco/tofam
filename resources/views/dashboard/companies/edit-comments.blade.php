<x-admin-card>
    
    <x-company-edit-buttons :company="$company"/>

    <h1>Edit comments</h1>

    <div class="w-50 justify-content-center">
        @if(empty($comments))
            <p>There are no comments to display.</p>
        @else
            @foreach($comments as $comment)
                <x-comment-card :comment="$comment" />
            @endforeach
        @endif


        
        <h3 class="mt-4">Add new comment</h3>
        <form action="/dashboard/companies/{{$company->hex}}/comments/add" method="POST">
            @csrf

            {{-- New comment title --}}
            <input
                name="title"
                class="form-control mb-3"
                placeholder="Comment title"
                value="{{old('title')}}"
            />

            @error('title')
                <p class="text-danger">{{$message}}</p>
            @enderror

            {{-- New comment body --}}
            <textarea 
                name="body"
                class="form-control mb-3" 
                rows="3"
                placeholder="Add your comment"
            >{{old('comment')}}</textarea>
            @error('body')
                <p class="text-danger">{{$message}}</p>
            @enderror

            <button type="submit" class="btn btn-success btn-sm">
                <i class="fa-regular fa-comment"></i> Add comment
            </button>

        </form>
    </div>

    <x-popup-modal :comments="$company->comments" />

    <script>
        function showReplyForm(comment_id){
            document.getElementById('replyForm_' + comment_id).style.display='block';
            document.getElementById('btnShowReplyForm_' + comment_id).style.display='none';
            document.getElementById('btnHideReplyForm_' + comment_id).style.display='inline-block';
        }
        function hideReplyForm(comment_id){
            document.getElementById('replyForm_' + comment_id).style.display='none';
            document.getElementById('btnShowReplyForm_' + comment_id).style.display='inline-block';
            document.getElementById('btnHideReplyForm_' + comment_id).style.display='none';
        }
    </script>

</x-admin-card>

