<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-0">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Top-Family Business</a>
        <button 
            class="navbar-toggler" 
            type="button" 
            data-bs-toggle="collapse" 
            data-bs-target="#navbarNavAltMarkup" 
            aria-controls="navbarNavAltMarkup" 
            aria-expanded="false" 
            aria-label="Toggle navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav w-100">
                <a class="nav-link {{ (request()->segment(1) == null) ? 'active' : null }}" aria-current="page" href="/">Home</a>
                <a class="nav-link {{ (request()->segment(1) == 'about') ? 'active' : null }}" href="/about">About</a>
                <a class="nav-link {{ (request()->segment(1) == 'articles') ? 'active' : null }}" href="/articles">Articles</a>
                <a class="nav-link {{ (request()->segment(1) == 'categories') ? 'active' : null }}" href="/categories">Categories</a>
                <a class="nav-link {{ (request()->segment(1) == 'users') ? 'active' : null }}" href="/users">Users</a>
                <a class="nav-link {{ (request()->segment(1) == 'contact') ? 'active' : null }}" href="/contact">Contact</a>
                
                <div class="d-flex ms-auto">
                    @auth
                        <div class="collapse navbar-collapse" id="navbarNavDarkDropdown">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img 
                                            src="{{asset('images/users/'.auth()->user()->hex.'/tn-'.auth()->user()->image)}}" 
                                            alt="" 
                                            class="nav-user-image"
                                            style="border-color: #{{auth()->user()->color->code ?? 'ff0000'}};"    
                                        >
                                        Hello {{auth()->user()->first_name}}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="navbarDarkDropdownMenuLink">
                                        <li>
                                            <a class="nav-link {{ (Route::currentRouteName() == 'profile') ? 'active' : null }}" href="/profile">Profile</a>
                                        </li>
                                        <li>
                                            <a class="nav-link {{ (Route::currentRouteName() == 'dashboard') ? 'active' : null }}" href="/dashboard">Dashboard</a>
                                        </li>
                                        <li>
                                            <form action="/logout" class="inline"  id="logoutForm" method="POST">
                                                @csrf
                                                <a class="nav-link" onclick="logoutSubmit()" style="cursor:pointer;">Log out</a>
                                            </form>
                                            <script>
                                                function logoutSubmit(){
                                                    document.getElementById("logoutForm").submit();
                                                }
                                            </script>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    @else
                        <a class="nav-link {{ (Route::currentRouteName() == 'register') ? 'active' : null }}" href="/register">Register</a>
                        <a class="nav-link {{ (Route::currentRouteName() == 'login') ? 'active' : null }}" href="/login">Login</a>
                    @endauth
                </div>

            </div>
        </div>
    </div>
</nav>