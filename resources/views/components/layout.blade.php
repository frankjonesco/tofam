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


    
</head>
<body x-data="{'isModalOpen': false}" x-on:keydown.escape="isModalOpen=false" class="d-flex flex-column min-vh-100" style="display:none !important;">

    <x-navbar />
    
    <main>
        {{$slot}}
    </main>

    <x-footer />

    <x-flash-message />


    <script>
        document.addEventListener("DOMContentLoaded", function(event) {
            console.log("DOM fully loaded and parsed");
            document.body.style.display='block';
          });
    </script>
</body>
</html>