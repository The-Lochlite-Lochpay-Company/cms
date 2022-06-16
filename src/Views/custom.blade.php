<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
  
        <!-- CSRF Token -->
        <meta name="_token" content="{{ csrf_token() }}">
 
         <title inertia>{{ Lochlitecms::seo('title') }}</title>
	     <meta name="description" content="{{ Lochlitecms::seo('description') }}">
	     <meta name="keywords" content="{{ Lochlitecms::seo('keywords') }}">
	     <!-- Open Graph / Facebook -->
	     <meta property="og:type" content="{{ Lochlitecms::seo('og:type') }}">
	     <meta property="og:url" content="{{ Lochlitecms::seo('og:url') }}">
	     <meta property="og:title" content="{{ Lochlitecms::seo('og:title') }}">
	     <meta property="og:description" content="{{ Lochlitecms::seo('og:description') }}">
	     <meta property="og:image" content="{{ Lochlitecms::seo('og:image') }}">
	     
	     <!-- Twitter -->
	     <meta property="twitter:card" content="{{ Lochlitecms::seo('twitter:card') }}">
	     <meta property="twitter:url" content="{{ Lochlitecms::seo('twitter:url') }}">
	     <meta property="twitter:title" content="{{ Lochlitecms::seo('twitter:title') }}">
	     <meta property="twitter:description" content="{{ Lochlitecms::seo('twitter:description') }}">
	     <meta property="twitter:image" content="{{ Lochlitecms::seo('twitter:image') }}">
	     <meta name="msapplication-TileColor" content="{{ Lochlitecms::seo('msapplicationtilecolor') }}">
	     <meta name="theme-color" content="{{ Lochlitecms::seo('themecolor') }}">
         @include('feed::links')
	     <link rel="shortcut icon" type="image/png" sizes="32x32" href="">
         <link rel="manifest" href="/manifest.webmanifest">
         @if(empty($headInlineScript) == false && is_string($headInlineScript) == true)
         <script> {!! $headInlineScript !!} </script>
         @endif

         @routes
         <script src="{{ mix('js/app.js') }}" defer></script>
         @inertiaHead
         @if(empty($importCSS) == false && is_array($importCSS) == true)
	      	{!! Lochlitecms::generateStylesheet($importCSS) !!}
         @endif
         @if(empty($style) == false && is_string($style) == true)
         <style> {!! $style !!} </style>
         @endif
    </head>
    <body class="relative min-h-screen min-w-screen font-sans antialiased m-0 p-0" data-mode="web">
         @inertia
         @if(empty($importScript) == false && is_array($importScript) == true)
	      	{!! Lochlitecms::generateScript($importScript) !!}
         @endif
         
         @if(empty($bodyInlineScript) == false && is_string($bodyInlineScript) == true)
         <script> {!! $bodyInlineScript !!} </script>
         @endif
    </body>
</html>
