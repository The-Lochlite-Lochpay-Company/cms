<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="application-name" content="{{ Lochlitecms::config('appname') }}">
        <meta name="generator" content="Lochlite CMS">
	    <meta name="robots" content="{{ Lochlitecms::seo('robots') }}">
  
        <!-- CSRF Token -->
        <meta name="_token" content="{{ csrf_token() }}">

         <title inertia>{{ Lochlitecms::seo('title') }}</title>
	     <meta name="author" content="{{ Lochlitecms::seo('author') }}">
	     <meta name="description" content="{{ Lochlitecms::seo('description') }}">
	     <meta name="keywords" content="{{ Lochlitecms::seo('keywords') }}">
	     <!-- Google -->
	     <meta name="google-site-verification" content="{{ Lochlitecms::seo('google_site_verification') }}">
	     <!-- Pinterest -->
	     <meta name="p:domain_verify" content="{{ Lochlitecms::seo('p:domain_verify') }}">
	     <!-- Open Graph / Facebook -->
	     <meta property="og:type" content="{{ Lochlitecms::seo('og:type') }}">
	     <meta property="og:url" content="{{ Lochlitecms::seo('og:url') }}">
	     <meta property="og:title" content="{{ Lochlitecms::seo('og:title') }}">
	     <meta property="og:description" content="{{ Lochlitecms::seo('og:description') }}">
	     <meta property="og:image" content="{{ Lochlitecms::seo('og:image') }}">
         <meta property="fb:app_id" content="{{ Lochlitecms::seo('fb:app_id') }}" />
	     
	     <!-- Twitter -->
	     <meta name="twitter:card" content="{{ Lochlitecms::seo('twitter:card') }}">
	     <meta name="twitter:url" content="{{ Lochlitecms::seo('twitter:url') }}">
	     <meta name="twitter:title" content="{{ Lochlitecms::seo('twitter:title') }}">
	     <meta name="twitter:description" content="{{ Lochlitecms::seo('twitter:description') }}">
	     <meta name="twitter:image" content="{{ Lochlitecms::seo('twitter:image') }}">
         <meta name="twitter:site" content="{{ Lochlitecms::seo('twitter:site') }}">
	     <meta name="msapplication-TileColor" content="{{ Lochlitecms::pwa('msapplicationtilecolor') }}">
	     <meta name="theme-color" content="{{ Lochlitecms::pwa('theme_color') }}">
	     <link rel="shortcut icon" href="{{ Lochlitecms::seo('icon') }}">
         <link rel="manifest" href="/manifest.webmanifest">
         @if(empty($headInlineScript) == false && is_string($headInlineScript) == true)
         <script> {!! $headInlineScript !!} </script>
         @endif

         @routes
		 @vite(['resources/css/app.css', 'resources/sass/main.scss', 'resources/js/app.js'])
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
