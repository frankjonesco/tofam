<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-dark">
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
            <div class="navbar-nav">
                <a class="nav-link {{ (request()->segment(1) == null) ? 'active' : null }}" aria-current="page" href="/">Home</a>
                <a class="nav-link {{ (request()->segment(1) == 'articles') ? 'active' : null }}" href="/articles">Articles</a>
                <a class="nav-link {{ (request()->segment(1) == 'categories') ? 'active' : null }}" href="/categories">Categories</a>
                <a class="nav-link {{ (request()->segment(1) == 'users') ? 'active' : null }}" href="/users">Users</a>

                @auth
                    <a class="nav-link {{ (Route::currentRouteName() == 'dashboard') ? 'active' : null }}" href="/dashboard">Dashboard</a>
                    <form action="/logout" class="inline"  id="logoutForm" method="POST">
                        @csrf
                        <a class="nav-link" onclick="logoutSubmit()" style="cursor:pointer;">Log out</a>
                    </form>
                    <script>
                        function logoutSubmit(){
                            document.getElementById("logoutForm").submit();
                        }
                    </script>
                @else
                    <a class="nav-link {{ (Route::currentRouteName() == 'register') ? 'active' : null }}" href="/register">Register</a>
                    <a class="nav-link {{ (Route::currentRouteName() == 'login') ? 'active' : null }}" href="/login">Login</a>
                @endauth

            </div>
        </div>
    </div>
</nav>