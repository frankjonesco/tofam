<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Top Family Business</title>

    {{-- Alpine.js --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    @vite('resources/js/app.js')

    <link rel="stylesheet" href="{{asset('css/app.css?t='.time())}}">
    

    
</head>
<body x-data="{'isModalOpen': false}" x-on:keydown.escape="isModalOpen=false" class="d-flex flex-column min-vh-100">

    <x-navbar />
    
    <main id="main">
        {{$slot}}
    </main>

    <x-footer />

    <x-flash-message />

    <button id="scrollToTopButton" class="scroll-to-top btn btn-success btn-lg">
        <i class="fa-solid fa-arrow-up"></i>
    </button>

    

</body>
</html>