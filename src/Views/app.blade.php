<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
  
        <!-- CSRF Token -->
        <meta name="_token" content="{{ csrf_token() }}">

         <title inertia>Sem titulo</title>
	     <meta name="description" content="" inertia>
	     <meta name="keywords" content="" inertia>
	     <!-- Open Graph / Facebook -->
	     <meta property="og:type" content="website">
	     <meta property="og:url" content="{{url()->current()}}">
	     <meta property="og:title" content="Sem titulo">
	     <meta property="og:description" content="Sem descrição">
	     <meta property="og:image" content="">
	     
	     <!-- Twitter -->
	     <meta property="twitter:card" content="summary_large_image">
	     <meta property="twitter:url" content="{{url()->current()}}">
	     <meta property="twitter:title" content="Sem titulo">
	     <meta property="twitter:description" content="Sem descrição">
	     <meta property="twitter:image" content="">
	     <meta name="msapplication-TileColor" content="#00aba9">
	     <meta name="theme-color" content="#3b7977">
         @include('feed::links')
	     <link rel="icon" type="image/png" sizes="32x32" href="">
         <link rel="stylesheet" href="{{ mix('css/app.css') }}">
         <link rel="stylesheet" href="{{ mix('sass/main.css') }}">
        @routes
        <script src="{{ mix('js/app.js') }}" defer></script>
        @inertiaHead
    </head>
    <body class="relative min-h-screen min-w-screen font-sans antialiased m-0 p-0" data-mode="web">
        @inertia


    </body>
</html>
