@extends('layouts.app')
@section('title', 'Pets')

@section('content')
@include('layouts.navbar')

<h1 class="text-3xl pt-30 flex gap-2 items-center text-white font-bold mb-10 pb-2 border-b-2">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
    </svg>
    Pets Module
</h1>

<ul class="menu gap-1 mb-8 menu-horizontal bg-base-200 rounded-box">
  <li>
    <a href="{{ url('pets/create') }}" class="btn btn-sm sm:btn-md btn-success btn-outline">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        Add Pet
    </a>
  </li>
  <li><a class="btn btn-sm sm:btn-md btn-neutral btn-outline">Export PDF</a></li>
  <li><a class="btn btn-sm sm:btn-md btn-neutral btn-outline">Export Excel</a></li>
</ul>

<div class="overflow-x-auto my-2 rounded-box bg-base-100">
  <table class="table table-zebra">
    <thead>
      <tr>
        <th>Image</th>
        <th>Name</th>
        <th>Breed</th>
        <th>Age</th>
        <th>Created</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($pets as $pet)
      <tr class="hover:bg-base-300">
        <td>
          <div class="avatar">
            <div class="mask mask-squircle h-12 w-12">
              <img src="{{ asset('images/'.$pet->image) }}" alt="Pet image" />
            </div>
          </div>
        </td>
        <td class="font-bold">{{ $pet->name }}</td>
  
        <td>{{ $pet->breed }}</td>
        <td>{{ $pet->age }} years</td>
        <td>{{ $pet->created_at->diffForHumans() }}</td>
        <td class="flex gap-1">
          <a class="btn btn-outline btn-square btn-neutral btn-xs" href="{{ url('pets/'.$pet->id) }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
          </a>
          <a class="btn btn-outline btn-square btn-neutral btn-xs" href="{{ url('pets/'.$pet->id.'/edit') }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
            </svg>
          </a>
          <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline btn-square btn-error btn-xs"
             onclick="return confirm('¿Estás seguro?')">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </button>
          </form>
        </td>
      </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th></th>
        <th>Name</th>
        <th>Breed</th>
        <th>Age</th>
        <th>Created</th>
        <th>Actions</th>
      </tr>
    </tfoot>
  </table>
</div>

{{ $pets->links('layouts.paginator') }}

{{-- Modal --}}
<dialog id="messageModal" class="modal">
  <div class="modal-box">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <div class="flex items-center gap-3 mb-4">
      <div class="flex-shrink-0">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-success">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <div>
        <h3 class="text-lg font-bold text-success">Success!</h3>
        <p class="text-sm text-gray-600">Operation completed successfully</p>
      </div>
    </div>
    <div class="bg-base-200 p-4 rounded-lg">
      <p id="text-message" class="text-base-content">Lorem Ipsum Dolor</p>
    </div>
  </div>
</dialog>

@endsection

{{-- funcion para el modal --}}
@section('js')
<script>
  const messaggeModal = document.querySelector('#messaggeModal');
  const textMensagge = document.querySelector('#text-mensagge');

  @if (session('messagge'))
    textMensagge.textContent = "{{ session('messagge') }}";
    messaggeModal.showModal();
  @endif
</script>
@endsection
