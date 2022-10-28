<x-layout>
    <x-card>

        {{-- Buttons bar --}}
        <x-buttons-bar>
            <a class="btn btn-primary btn-sm" href="{{url()->previous()}}">
                <i class="fa-solid fa-arrow-left"></i> Back
            </a>
            @auth
                <a class="btn btn-success btn-sm" href="/dashboard/articles/{{$article->hex}}/edit">
                    <i class="fa-solid fa-pencil"></i> Edit article
                </a>   
                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteArticleModal">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
                <x-popup-modal :article="$article" />
            @endauth
        </x-buttons-bar>

        {{-- Static message --}}
        <x-static-message />

        {{-- View article card --}}
        <div class="p-3 border bg-light h-100 mb-5">
            <div class="card h-100">
                <div class="view-article-img">
                    <a href="/articles/{{$article->hex}}/{{$article->slug}}">
                        <img 
                            src="{{$article->image ? asset('/images/articles/'.$article->hex.'/'.$article->image) : asset('/images/no-image.png')}}" 
                            class="card-img-top" 
                            alt="{{$article->title}}"
                        >
                    </a>
                </div>
                <div class="card-body d-flex flex-column">
                    <h1>{{$article->title}}</h1>
                    <h3>{{$article->caption}}</h3>
                    <h5>{{$article->teaser}}</h5>

                    {{-- Article tags --}}
                    @if($article->tags && is_array($article->tags))
                        <div class="mt-1 mb-3">
                            @foreach($article->tags as $tag)
                                <a href="/tags/{{$tag}}" style="text-decoration:none;">
                                    <span class="badge bg-primary">{{$tag}}</span>
                                </a>
                            @endforeach
                        </div>
                    @endif

                    <div class="d-flex justify-content-between">
                        <p>{{$article->user->full_name}}</p>
                        <p>{{$article->created_at}}</p>
                    </div>
                    <p>Category: {{$article->category->name}}</p>
                    <p>{!!$article->body!!}</p>

                    <p>Views: {{$article->views}}</p>
                    <p>Likes: <span id="likeCount">{{$article->likes}}</span></p>

                    
                    

                    @if(Session::has('liked_'.$article->hex))
                        @php
                            $unlike_class = null;
                            $like_class = 'd-none';
                        @endphp
                    @else
                        @php
                            $unlike_class = 'd-none';
                            $like_class = null;    
                        @endphp
                    @endif

                    {{-- Unlike button --}}
                    <form id="unlikeForm" x-data="unlikeArticle()" action="/articles/unlike" method="POST" {{--@submit.prevent="submit"--}} @submit.prevent="submitData()" class="{{$unlike_class}}">
                        @csrf
                        <input type="hidden" name="hex" value="{{$article->hex}}" x-model="formData.hex">
                        <button id="unlikeButton" type="submit" class="btn btn-light btn-sm me-auto">
                            <i class="fa-solid fa-thumbs-up"></i> Unlike
                        </button>
                    </form>

                    {{-- Like button --}}
                    <form id="likeForm" x-data="likeArticle()" action="/articles/like" method="POST" {{--@submit.prevent="submit"--}} @submit.prevent="submitData()" class="{{$like_class}}">
                        @csrf
                        <input type="hidden" name="hex" value="{{$article->hex}}" x-model="formData.hex">
                        <button id="likeButton" type="submit" class="btn btn-primary btn-sm me-auto">
                            <i class="fa-regular fa-thumbs-up"></i> Like
                        </button>
                    </form>
                        
                    

                    {{-- Submit like button --}}
                    <script>
                        function unlikeArticle() {
                            return {
                                formData: {
                                    hex: '{{$article->hex}}',
                                },
                                // message: 'Some message',
            
                                submitData() {
                                    this.message = ''
                                    fetch('/articles/unlike', {
                                        method: 'POST',
                                        headers: { 
                                            'Content-Type': 'application/json', 
                                            'X-CSRF-TOKEN': "{{csrf_token()}}",
                                        },
                                        body: JSON.stringify(this.formData)
                                    })
                                    .then(response => response.json())
                                    .then(result => {
                                        // console.log('Success:', result);
                                        //   this.message = 'likes: ' + result;
                                        document.getElementById('likeCount').textContent=result;
                                        document.getElementById('unlikeForm').classList.add('d-none');
                                        document.getElementById('likeForm').classList.remove('d-none');
                                      
                                    })
                                    .catch(() => {
                                        console.log('Ooops! Something went wrong!');
                                        this.message = 'Ooops! Something went wrong!'
                                    })
                                }
                            }
                        }

                        function likeArticle() {
                            return {
                                formData: {
                                    hex: '{{$article->hex}}',
                                },
                                // message: 'Some message',
            
                                submitData() {
                                    this.message = ''
                                    fetch('/articles/like', {
                                        method: 'POST',
                                        headers: { 
                                            'Content-Type': 'application/json', 
                                            'X-CSRF-TOKEN': "{{csrf_token()}}",
                                        },
                                        body: JSON.stringify(this.formData)
                                    })
                                    .then(response => response.json())
                                    .then(result => {
                                        // console.log('Success:', result);
                                        //   this.message = 'likes: ' + result;
                                        document.getElementById('likeCount').textContent=result;
                                        document.getElementById('likeForm').classList.add('d-none');
                                        document.getElementById('unlikeForm').classList.remove('d-none');
                                      
                                    })
                                    .catch(() => {
                                        console.log('Ooops! Something went wrong!');
                                        this.message = 'Ooops! Something went wrong!'
                                    })
                                }
                            }
                        }
                    </script>
                </div>
            </div>
        </div>
        

        {{-- Other articles --}}
        @if(count($other_articles))
            
            <h1 class="mb-3">Other Articles</h1>
            <div class="container">
                <div class="row g-2 mb-4">
                    @foreach($other_articles as $other_article)
                        <x-article-card :article="$other_article" />
                    @endforeach
                </div>
            </div>
            
        @else
            <p>There are no articles to display.</p>
        @endif


    </x-card>
</x-layout>



