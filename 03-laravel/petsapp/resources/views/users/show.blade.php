@extends('layouts.app')
@section('title', 'Create User')

@section('content')
@include('layouts.navbar')

<h1 class="text-3xl pt-30 flex gap-2 items-center text-white font-bold mb-10 pb-2 border-b-2">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
    </svg>
    Show User
</h1>

<ul class="list bg-base-100 rounded-box shadow-md">
    <div id="upload" class="mask mask-squircle w-30 flex justify-center items-center mx-auto">
        <img src="{{ asset('images/'.$user->photo) }}" class="w-full h-auto object-cover" />
    </div>
    <li class="list-row">    
        <div>Full name</div>
        <div class="text-xs uppercase font-semibold opacity-60">{{ $user->fullname }}</div>
        </div>
    </li>
    <li class="list-row">    
        <div>Document</div>
        <div class="text-xs uppercase font-semibold opacity-60">{{ $user->document }}</div>
        </div>
    </li>

    <li class="list-row">    
        <div>email</div>
        <div class="text-xs uppercase font-semibold opacity-60">{{ $user->email }}</div>
        </div>
    </li>
    <li class="list-row">    
        <div>phone</div>
        <div class="text-xs uppercase font-semibold opacity-60">{{ $user->phone }}</div>
        </div>
    </li>
    <li class="list-row">    
        <div>gender</div>
        <div class="text-xs uppercase font-semibold opacity-60">{{ $user->gender }}</div>
        </div>
    </li>
    
  

  
  
  
</ul>
  
@endsection


