@extends('layout/cms_base')

@if($editable)
@section('title', 'Update Course Content')
@else
@section('title', 'Create Course Content (' . $course->name . ')')
@endif

@if($editable)
@section('page-title', 'Update Course Content')
@else
@section('page-title', 'Create Course Content (' . $course->name . ')')
@endif

@section('back')
<a href="{{ route('course.details', [ 'id' => $course->id ]) }}" class="hover:bg-slate-100 rounded-md">
  <svg class="fill-current w-7 h-7 " viewBox="0 0 48 48">
    <path d="M26.95 34.9L17.05 25C16.8833 24.8333 16.7666 24.6667 16.7 24.5C16.6333 24.3333 16.6 24.15 16.6 23.95C16.6 23.75 16.6333 23.5667 16.7 23.4C16.7666 23.2333 16.8833 23.0667 17.05 22.9L27 12.95C27.3 12.65 27.6583 12.5 28.075 12.5C28.4916 12.5 28.85 12.65 29.15 12.95C29.45 13.25 29.5916 13.6167 29.575 14.05C29.5583 14.4833 29.4 14.85 29.1 15.15L20.3 23.95L29.15 32.8C29.45 33.1 29.6 33.45 29.6 33.85C29.6 34.25 29.45 34.6 29.15 34.9C28.85 35.2 28.4833 35.35 28.05 35.35C27.6166 35.35 27.25 35.2 26.95 34.9Z"></path>
  </svg>
</a>
@endsection

@section('content')
<main class="w-full flex flex-col space-y-6 px-8 py-4">
  <div class="w-full flex flex-col items-center">
    <form enctype="multipart/form-data" class="w-full max-w-md space-y-4 flex flex-col" action="{{ $editable ? route('course.update_content', [ 'id' => $course->id ]) : route('course.create_content', [ 'id' => $course->id ]) }}" method="POST">
      @csrf
      @if($editable)
      <input type="hidden" name="id" value="{{ $content->id }}">
      @endif
      <input class="h-0" type="hidden" name="course_id" value="{{ $course->id }}">
      <div class="space-y-1 flex flex-col w-full">
        <label>Content Title</label>
        <input class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300" name="name" type="text" @if(isset($content)) value="{{ $content['name'] }}" @else value="{{ old('name') }}" @endif placeholder="Input content title">
        @error('name')
        <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
      </div>
      <div class="space-y-1 flex flex-col w-full">
        <label>Description</label>
        <textarea class="px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300 resize-none" rows="5" name="description" placeholder="Input description">{{ isset($content) ? $content['description'] : old('description') }}</textarea>
        @error('description')
        <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
      </div>
      <div class="space-y-1 flex flex-col w-full">
        <label>File Content <span class="text-sm">(PDF)</span></label>
        <input class="border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300" name="file" type="file" placeholder="Input content title">
        @error('file')
        <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
      </div>
      <div class="pt-4 flex flex-col w-full">
        <button type="submit" class="text-center px-3 py-2 rounded-md border border-slate-700 bg-slate-700 hover:bg-slate-800 active:bg-slate-900 text-white">@if($editable) Update @else Create @endif Content</button>
      </div>
    </form>
  </div>
</main>
@endsection