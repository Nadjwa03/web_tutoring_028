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
  @if(session('success'))
  <div id="alert-success" class="absolute top-8 flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
    </svg>
    <span class="sr-only">Info</span>
    <div class="ms-3 text-sm font-medium">
      @yield('alert-success-content')
    </div>
    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-success" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
      </svg>
    </button>
  </div>
  @endif
  @if(session('error'))
  <div id="alert-error" class="absolute top-8 flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50" role="alert">
    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
      <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
    </svg>
    <span class="sr-only">Info</span>
    <div class="ms-3 text-sm font-medium">
      @yield('alert-error-content')
    </div>
    <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8" data-dismiss-target="#alert-error" aria-label="Close">
      <span class="sr-only">Close</span>
      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
      </svg>
    </button>
  </div>
  @endif
  <div class="flex justify-between w-full">
    <aside class="flex flex-col w-80 px-6 py-4 h-screen border border-slate-300">
      <a class="px-3 pb-3 border-b border-slate-300" href="{{ route('dashboard') }}">
        <h1 class="font-medium text-3xl text-slate-950">beladiri.id</h1>
      </a>
      <div class="flex flex-col space-y-3 py-4">
        @if (collect(['superadmin', 'teacher', 'admin'])->contains(auth()->user()->role))
        <a href="{{ route('dashboard') }}" class="{{ Request::routeIs('dashboard') ? 'bg-slate-200' : '' }} block px-3 py-2 rounded-md w-full hover:bg-slate-200 cursor-pointer">Dashboad</a>
        @endif
        @if (collect(['superadmin', 'admin'])->contains(auth()->user()->role))
        <a href="{{ route('user.index') }}" class="{{ Request::routeIs('user.*') ? 'bg-slate-200' : '' }} block px-3 py-2 rounded-md w-full hover:bg-slate-200 cursor-pointer">User Management</a>
        @endif
        @if (collect(['superadmin', 'teacher', 'admin'])->contains(auth()->user()->role))
        <a href="{{ route('course.index') }}" class="{{ Request::routeIs('course.*') ? 'bg-slate-200' : '' }} block px-3 py-2 rounded-md w-full hover:bg-slate-200 cursor-pointer">Course Management</a>
        @endif
      </div>
    </aside>
    <div class="w-full flex flex-col items-center">
      <header class="flex justify-between items-center px-8 py-3 w-full border-b border-b-slate-300">
        <div class="flex space-x-4 items-center">
          @yield('back')
          <h1 class="font-medium text-2xl text-neutral-950">@yield('page-title')</h1>
        </div>
        <div class="flex space-x-4 items-center">
          <h2 class="text-slate-700">Hello, {{ auth()->user()->name }} ({{ auth()->user()->role }})</h2>
          <a href="{{ route('auth.logout') }}" class="min-w-[6rem] text-center px-3 py-2 rounded-md bg-slate-700 hover:bg-slate-800 active:bg-slate-900 text-white">Logout</a>
        </div>
      </header>
      @yield('content')
    </div>
  </div>
</body>

</html>