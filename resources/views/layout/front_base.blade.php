<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>@yield('title') | Beladiri</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="antialiased flex flex-col items-center">
  <header class="flex justify-between items-center px-8 py-3 w-full border-b border-b-slate-300 bg-white sticky top-0 z-10">
    <div class="flex space-x-4 items-center">
      <h1 class="font-medium text-3xl text-neutral-950">beladiri.id</h1>
    </div>
    <div class="flex space-x-4 items-center">
      <h2 class="text-slate-700">Hello, {{ auth()->user()->name }}</h2>
      <a href="{{ route('auth.logout') }}" class="min-w-[6rem] text-center px-3 py-2 rounded-md bg-slate-700 hover:bg-slate-800 active:bg-slate-900 text-white">Logout</a>
    </div>
  </header>
  @yield('content')
</body>

</html>