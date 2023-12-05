@extends('layout/cms_base')

@if($editable)
@section('title', 'Update Course')
@else
@section('title', 'Create Course')
@endif

@if($editable)
@section('page-title', 'Update Course')
@else
@section('page-title', 'Create Course')
@endif

@section('back')
<a href="{{ route('course.index') }}" class="hover:bg-slate-100 rounded-md">
  <svg class="fill-current w-7 h-7 " viewBox="0 0 48 48">
    <path d="M26.95 34.9L17.05 25C16.8833 24.8333 16.7666 24.6667 16.7 24.5C16.6333 24.3333 16.6 24.15 16.6 23.95C16.6 23.75 16.6333 23.5667 16.7 23.4C16.7666 23.2333 16.8833 23.0667 17.05 22.9L27 12.95C27.3 12.65 27.6583 12.5 28.075 12.5C28.4916 12.5 28.85 12.65 29.15 12.95C29.45 13.25 29.5916 13.6167 29.575 14.05C29.5583 14.4833 29.4 14.85 29.1 15.15L20.3 23.95L29.15 32.8C29.45 33.1 29.6 33.45 29.6 33.85C29.6 34.25 29.45 34.6 29.15 34.9C28.85 35.2 28.4833 35.35 28.05 35.35C27.6166 35.35 27.25 35.2 26.95 34.9Z"></path>
  </svg>
</a>
@endsection

@section('content')
<main class="w-full flex flex-col space-y-6 px-8 py-4">
  <div class="w-full flex flex-col items-center">
    <form class=" w-full max-w-md space-y-4 flex flex-col" action="{{ $editable ? route('course.update') : route('course.create') }}" method="POST">
      @csrf
      @if($editable)
      <input type="hidden" name="id" value="{{ $course->id }}">
      @endif
      <div class="space-y-1 flex flex-col w-full">
        <label>Course Title</label>
        <input class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300" name="name" type="text" @if(isset($course)) value="{{ $course['name'] }}" @else value="{{ old('name') }}" @endif placeholder="Input course title">
        @error('name')
        <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
      </div>
      <div class="space-y-1 flex flex-col w-full">
        <label>Description</label>
        <textarea class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300 resize-none" rows="5" name="description" placeholder="Input description">{{ isset($course) ? $course['description'] : old('description') }}</textarea>
        @error('description')
        <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
      </div>
      <div class="w-full flex space-x-2">
        <div class="space-y-1 flex flex-col w-full">
          <label>Start Date</label>
          <input class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300" name="start_date" type="date" @if(isset($course)) value="{{ $course['start_date']->format('Y-m-d') }}" @else value="{{ old('start_date', date('Y-m-d')) }}" @endif placeholder="Input start date">
          @error('start_date')
          <span class="text-red-600 text-sm">{{ $message }}</span>
          @enderror
        </div>
        <div class="space-y-1 flex flex-col w-full">
          <label>End Date</label>
          <input class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300" name="end_date" type="date" @if(isset($course)) value="{{ $course['end_date']->format('Y-m-d') }}" @else value="{{ old('end_date', date('Y-m-d')) }}" @endif placeholder="Input end date">
          @error('end_date')
          <span class="text-red-600 text-sm">{{ $message }}</span>
          @enderror
        </div>
      </div>
      @if (collect(['teacher'])->contains(auth()->user()->role))
      <input name="teacher" value="{{ auth()->user()->id }}" type="hidden" class="h-0">
      @endif
      @if (collect(['superadmin', 'admin'])->contains(auth()->user()->role))
      <div class="space-y-1 flex flex-col w-full">
        <label>Teacher</label>
        <select name="teacher" class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300">
          @foreach($teachers as $teacher)
          <option value="{{ $teacher['id'] }}" @if(isset($course['lecturer_id']) and $course['lecturer_id']==$teacher['id']) selected @endif>{{ $teacher['name'] }}</option>
          @endforeach
        </select>
        @error('teacher')
        <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
      </div>
      @endif
      <div class="pt-4 flex flex-col w-full">
        <button type="submit" class="text-center px-3 py-2 rounded-md border border-slate-700 bg-slate-700 hover:bg-slate-800 active:bg-slate-900 text-white">@if($editable) Update @else Create @endif Course</button>
      </div>
    </form>
  </div>
</main>
@endsection