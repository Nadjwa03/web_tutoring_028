@extends('layout/cms_base')

@section('title', 'User Management')

@section('page-title', 'User Management')

@section('content')
<main class="w-full flex flex-col space-y-6 px-8 py-4">
  <div class="w-full flex">
    <form class="flex flex-row">
      <input type="text" name="search" placeholder="Search..." value="{{ app('request')->input('search') }}" class="w-96 px-3 py-2 border border-slate-300 rounded-md hover:border-slate-700 focus:border-slate-700 focus:outline focus:outline-2 focus:outline-slate-300">
    </form>
    <a href="{{ route('user.create_view') }}" class="text-center px-3 py-2 rounded-md bg-slate-700 hover:bg-slate-800 active:bg-slate-900 text-white ml-auto">Add User</a>
  </div>
  <div class="w-full flex flex-col space-y-4">
    <table class="border-collapse">
      <thead>
        <tr>
          <th class="border px-2 py-2.5">#</th>
          <th class="border px-2 py-2.5">Name</th>
          <th class="border px-2 py-2.5">Username</th>
          <th class="border px-2 py-2.5">Email</th>
          <th class="border px-2 py-2.5">Role</th>
          <th class="border px-2 py-2.5">Handle</th>
        </tr>
      </thead>
      <tbody>
        @if (count($users) == 0)
        <tr>
          <td colspan="6" class="border px-2 py-2.5 align-middle text-center text-slate-500">Data doesn't exist!</td>
        </tr>
        @endif
        @foreach($users as $i => $user)
        <tr class="{{ $user->deleted_at != null ? 'text-neutral-300': '' }}">
          <td class="border px-2 py-2.5 text-center">{{ ($i + 1) }}</td>
          <td class="border px-2 py-2.5">{{ $user['name'] }}</td>
          <td class="border px-2 py-2.5">{{ $user['username'] }}</td>
          <td class="border px-2 py-2.5">
            <a class="{{ $user->deleted_at != null ? 'text-blue-300': 'text-blue-700' }}" href="mailto:{{ $user->email }}">{{ $user['email'] }}</a>
          </td>
          <td class="border px-2 py-2.5">{{ $user['role'] }}</td>
          <td class="border px-2 py-2.5">
            @if (auth()->user()->id != $user->id)
            <div class="flex justify-center space-x-2 text-black">
              <a href="{{ route('user.update_view', [ 'id' => $user->id ]) }}" class="block px-3 py-2 rounded-md border border-slate-400 w-fit hover:cursor-pointer hover:bg-slate-100">Edit</a>
              @if (collect(['superadmin'])->contains(auth()->user()->role) || (collect(['admin'])->contains(auth()->user()->role) && $user->role == 'teacher'))
              <button data-modal-target="popup-remove-user-{{ $user->id }}" data-modal-toggle="popup-remove-user-{{ $user->id }}" class="block px-3 py-2 rounded-md border border-red-400 w-fit hover:cursor-pointer hover:bg-red-100">{{ $user->deleted_at != null ? 'Activate' : 'Deactivate' }}</butt>
                @endif
            </div>
            @else
            <div class="flex justify-center">
              <a href="#" class="text-center px-3 py-2 rounded-md bg-slate-700 hover:bg-slate-800 active:bg-slate-900 text-white">View Profile</a>
            </div>
            @endif
          </td>
        </tr>
        <div id="popup-remove-user-{{ $user->id }}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
          <div class="relative w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-slate-700">
              <button type="button" class="absolute top-3 right-2.5 text-slate-400 bg-transparent hover:bg-slate-200 hover:text-slate-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-slate-600 dark:hover:text-white" data-modal-hide="popup-remove-user-{{ $user->id }}">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
                <span class="sr-only">Close modal</span>
              </button>
              <div class="p-6 text-center">
                <svg class="mx-auto mb-4 text-red-600 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="mb-8 font-normal">Apakah kamu yakin untuk {{ $user->deleted_at != null ? 'aktivasi kembali' : 'deaktivasi'  }} user dengan nama <span class="font-semibold">{{ $user->name }}</span>?</h3>
                <form method="POST" action="{{ $user->deleted_at != null ? route('user.activate') : route('user.deactivate') }}">
                  @csrf
                  <input type="hidden" value="{{ $user->id }}" name="id">
                  <button data-modal-hide="popup-remove-user-{{ $user->id }}" type="submit" class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                    Yes
                  </button>
                </form>
                <button data-modal-hide="popup-remove-user-{{ $user->id }}" type="button" class="text-center px-3 py-2 rounded-md border border-slate-400 w-fit hover:cursor-pointer hover:bg-slate-100 text-sm">No, Cancel</button>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </tbody>
    </table>
    @php
    $start = ($users->currentPage() - 1) * $users->perPage() + 1;
    $end = $users->currentPage() * $users->perPage();

    $end = $end < $users->total() ? $end : $users->total();
      @endphp
      <p class="text-slate-500">
        Showing {{ $start }} to {{ $end }} of {{ $users->total() }} entries
      </p>

      <div class="flex w-full items-center justify-center mt-3">
        <div class="w-48">
          {{ $users->links() }}
        </div>
      </div>
  </div>
</main>
@endsection