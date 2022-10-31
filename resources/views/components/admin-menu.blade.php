<link rel="stylesheet" href="{{asset('css/sidebar1.css?t='.time())}}">

<nav id="sidebar">
    <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Toggle Menu</span>
        </button>
    </div>
    <div class="p-4 pt-5">
        <h1><a href="index.html" class="logo">Admin</a></h1>
        <ul class="list-unstyled components mb-5 dashboard-menu">
            <li>
                <a href="/dashboard"><i class="fa fa-dashboard"></i>Dashboard</a>
            </li>
            <li>
                <a href="#categorySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-folder"></i>Categories</a>
                <ul class="collapse list-unstyled" id="categorySubmenu">
                    <li>
                        <a href="/dashboard/categories/create">Create new category</a>
                    </li>
                    <li>
                        <a href="/dashboard/categories">View library</a>
                    </li>
                    <li>
                        <a href="/dashboard/categories/mine">My categories</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#articleSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-newspaper"></i>Articles</a>
                <ul class="collapse list-unstyled" id="articleSubmenu">
                    <li>
                        <a href="/dashboard/articles/create">Create new article</a>
                    </li>
                    <li>
                        <a href="/dashboard/articles">View library</a>
                    </li>
                    <li>
                        <a href="/dashboard/articles/mine">My articles</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#userSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-users"></i>Users</a>
                <ul class="collapse list-unstyled" id="userSubmenu">
                    <li>
                        <a href="/dashboard/users/create">Create new user</a>
                    </li>
                    <li>
                        <a href="/dashboard/users">View users</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="/dashboard/color-swatches"><i class="fa fa-palette"></i>Color Swatches</a>
            </li>
            <li>
                <a href="/dashboard/settings"><i class="fa fa-gear"></i>Settings</a>
            </li>
        </ul>
        <div class="mb-5">
            <h3 class="h6">Subscribe for newsletter</h3>
            <form action="#" class="colorlib-subscribe-form">
                <div class="form-group d-flex">
                    <div class="icon"><span class="icon-paper-plane"></span></div>
                    <input type="text" class="form-control" placeholder="Enter Email Address">
                </div>
            </form>
        </div>
        <div class="footer">
            <p>
                Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib.com</a>
            </p>
        </div>
    </div>
</nav>

{{-- Slim jQuery for admin sidebar menu (Temporary) --}}
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
{{-- Bootstrap 4 for admin sidebar menu (Temporary) --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
{{-- Custom script for admin sidebar menu (Temporary) --}}
<script>
(function($){"use strict";var fullHeight=function(){$('.js-fullheight').css('height',$(window).height());$(window).resize(function(){$('.js-fullheight').css('height',$(window).height());});};fullHeight();$('#sidebarCollapse').on('click',function(){$('#sidebar').toggleClass('active');});})(jQuery);
</script>

<script>

    // Make sidebar fill <main>
    $(document).ready(function(){
        height = $("#main").height();
        $("#sidebar").height( height );
    });

</script>

