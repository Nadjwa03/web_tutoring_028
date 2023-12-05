@extends('layout/cms_base')

@if($editable)
@section('title', 'Update User')
@else
@section('title', 'Create User')
@endif

@if($editable)
@section('page-title', 'Update User')
@else
@section('page-title', 'Create User')
@endif

@section('back')
<a href="{{ route('user.index') }}" class="hover:bg-slate-100 rounded-md">
  <svg class="fill-current w-7 h-7 " viewBox="0 0 48 48">
    <path d="M26.95 34.9L17.05 25C16.8833 24.8333 16.7666 24.6667 16.7 24.5C16.6333 24.3333 16.6 24.15 16.6 23.95C16.6 23.75 16.6333 23.5667 16.7 23.4C16.7666 23.2333 16.8833 23.0667 17.05 22.9L27 12.95C27.3 12.65 27.6583 12.5 28.075 12.5C28.4916 12.5 28.85 12.65 29.15 12.95C29.45 13.25 29.5916 13.6167 29.575 14.05C29.5583 14.4833 29.4 14.85 29.1 15.15L20.3 23.95L29.15 32.8C29.45 33.1 29.6 33.45 29.6 33.85C29.6 34.25 29.45 34.6 29.15 34.9C28.85 35.2 28.4833 35.35 28.05 35.35C27.6166 35.35 27.25 35.2 26.95 34.9Z"></path>
  </svg>
</a>
@endsection

@section('content')
<main class="w-full flex flex-col space-y-6 px-8 py-4">
  <div class="w-full flex flex-col items-center">
    <form class=" w-full max-w-md space-y-4 flex flex-col" @if($editable) action="{{ route('user.update') }}" @else action="{{ route('user.create') }}" @endif method="POST">
      @csrf
      @if($editable)
      <input type="hidden" name="id" value="{{ $user->id }}">
      @endif
      <div class="space-y-1 flex flex-col w-full">
        <label>Full Name</label>
        <input class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300" name="name" type="text" @if(isset($user)) value="{{ $user['name'] }}" @else value="{{ old('name') }}" @endif placeholder="Input email">
        @error('name')
        <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
      </div>
      <div class="space-y-1 flex flex-col w-full">
        <label>Email</label>
        <input class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300" name="email" type="email" @if(isset($user)) value="{{ $user['email'] }}" @else value="{{ old('email') }}" @endif placeholder="Input email">
        @error('email')
        <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
      </div>
      <div class="space-y-1 flex flex-col w-full">
        <label>Username</label>
        <input class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300" name="username" type="text" @if(isset($user)) value="{{ $user['username'] }}" @else value="{{ old('username') }}" @endif placeholder="Input username">
        @error('username')
        <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
      </div>
      <div class="space-y-1 flex flex-col w-full">
        <label>Role</label>
        @if(collect(['superadmin'])->contains(auth()->user()->role))
        <select name="role" class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300">
          <option value="teacher" @if(isset($user) and ($user['role']=='teacher' )) selected @endif>Teacher</option>
          <option value="admin" @if(isset($user) and ($user['role']=='admin' )) selected @endif>Admin</option>
        </select>
        @else
        <input type="hidden" name="role" value="{{ isset($user) ? $user['role'] : 'teacher' }}" readonly>
        <label class="px-3 py-2 border border-slate-300 text-slate-500 rounded-md read-only:focus:outline-none">{{ isset($user) ? ucfirst($user['role']) : 'Teacher' }}</label>
        @endif
        @error('role')
        <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
      </div>
      <div class="pt-4 flex flex-col w-full">
        <button type="submit" class="text-center px-3 py-2 rounded-md border border-slate-700 bg-slate-700 hover:bg-slate-800 active:bg-slate-900 text-white">@if($editable) Update @else Create @endif User</button>
      </div>
    </form>
  </div>
</main>
@endsection