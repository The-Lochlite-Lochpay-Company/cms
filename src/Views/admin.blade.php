<!DOCTYPE html>
<html>
<head>
  <title inertia>Lochlite CMS</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <!-- CSRF Token -->
  <meta name="_token" content="{{ csrf_token() }}">
  
  <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
  <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
  <link rel="stylesheet" href="{{ mix('/sass/main.css') }}">
        @routes
        <script src="{{ mix('/js/app.js') }}" defer></script>
        @inertiaHead
</head>
<body class="relative min-h-screen min-w-screen font-sans antialiased m-0 p-0" data-base-url="{{url('/')}}" data-mode="dashboard">
        @inertia

</body>
</html>