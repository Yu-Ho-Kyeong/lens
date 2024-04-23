<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ mix('css/tailwind.css') }}" rel="stylesheet">
        <title>LensMarkSearch2</title>
    </head>
    <body>
        
        <section class="bg-white dark:bg-dark py-20 lg:py-[120px]">
            <div id="app">
                <hello-world/>
            </div>
        </section>   
    </body>
    <script defer src="https://unpkg.com/alpinejs@3.13.8/dist/cdn.min.js"></script>
    <script src="{{asset('js/app.js')}}"></script>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
    });
</script>
