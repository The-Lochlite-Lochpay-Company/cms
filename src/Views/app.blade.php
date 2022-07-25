<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"{{ Lochlitecms::seo('translate') == 'notranslate' ? ' notranslate' : '' }}>
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
         {!! Lochlitecms::appendCoding('head') !!}
        @routes
		@vite(['vendor/lochlite/cms/src/Disk/private/dashboard.css', 'vendor/lochlite/cms/src/Disk/private/app.css', 'vendor/lochlite/cms/src/Disk/private/main.scss', 'resources/js/app.js'])
        @inertiaHead
    </head>
    <body class="relative min-h-screen min-w-screen font-sans antialiased m-0 p-0" data-mode="web">
         {!! Lochlitecms::appendCoding('body-top') !!}
         @inertia
         {!! Lochlitecms::appendCoding('body-end') !!}
    </body>
</html>
