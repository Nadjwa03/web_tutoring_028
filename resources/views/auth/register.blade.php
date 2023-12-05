@extends('layout.auth')

@section('title', 'Register')

@section('content')

<header class="flex justify-between items-center px-6 py-3 w-full border-b border-b-slate-300">
  <h1 class="font-medium text-3xl text-neutral-950">beladiri.id</h1>
  <div class="flex items-center">
    <a href="{{ route('auth.login_view') }}" class="min-w-[6rem] text-center px-3 py-2 rounded-md bg-slate-700 hover:bg-slate-800 active:bg-slate-900 text-white">Login</a>
  </div>
</header>

<main class="flex flex-col items-center w-full py-6">
  <form class="mt-8 px-10 py-8 border rounded-lg border-slate-300 w-full max-w-md space-y-4" method="POST" action="{{ route('auth.register') }}">
    <h1 class="text-3xl font-semibold text-slate-900 text-center pb-3">Register</h1>
    @csrf
    <div class="space-y-1 flex flex-col w-full">
      <label>Nama Lengkap</label>
      <input class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300" name="name" value="{{ old('name') }}" placeholder="Masukkan nama">
      @error('name')
      <span class="text-red-600 text-sm">{{ $message }}</span>
      @enderror
    </div>
    <div class="space-y-1 flex flex-col w-full">
      <label>Username</label>
      <input class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300" name="username" value="{{ old('username') }}" placeholder="Masukkan username">
      @error('username')
      <span class="text-red-600 text-sm">{{ $message }}</span>
      @enderror
    </div>
    <div class="space-y-1 flex flex-col w-full">
      <label>Email</label>
      <input class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300" name="email" type="email" value="{{ old('email') }}" placeholder="Masukkan email">
      @error('email')
      <span class="text-red-600 text-sm">{{ $message }}</span>
      @enderror
    </div>
    <div class="space-y-1 flex flex-col w-full">
      <label>Kata Sandi</label>
      <input class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300" type="password" name="password" value="{{ old('password') }}" placeholder="Masukkan kata sandi">
      @error('password')
      <span class="text-red-600 text-sm">{{ $message }}</span>
      @enderror
    </div>
    <div class="space-y-1 flex flex-col w-full">
      <label>Konfirmasi Kata Sandi</label>
      <input class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300" type="password" name="confirm_password" value="{{ old('confirm_password') }}" placeholder="Masukkan konfirmasi kata sandi">
      @error('confirm_password')
      <span class="text-red-600 text-sm">{{ $message }}</span>
      @enderror
    </div>
    <div class="pt-4 pb-2 flex flex-col w-full">
      <button class="text-center px-3 py-2 rounded-md bg-slate-700 hover:bg-slate-800 active:bg-slate-900 text-white w-full" type="submit">Register</button>
    </div>
  </form>
</main>

@endsection