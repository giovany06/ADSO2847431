@extends('layouts.app')
@section('title', 'Create User')

@section('content')
@include('layouts.navbar')

<h1 class="text-3xl pt-30 flex gap-2 items-center text-white font-bold mb-10 pb-2 border-b-2">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
    </svg>
    Create User
</h1>

<form method="post" action="{{ route('users.store') }}" class="pt-6 pb-20" enctype="multipart/form-data">
        @csrf
        <fieldset class="fieldset w-md bg-base-200 border border-base-300 p-4 rounded-box">
                
                @if (count($errors->all()) > 0)
                    <div class="flex flex-col gap-1 my-4">
                        @foreach ($errors->all() as $message)
                            <div class="badge badge-error">
                                <svg class="size-[1em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><g fill="currentColor"><rect x="1.972" y="11" width="20.056" height="2" transform="translate(-4.971 12) rotate(-45)" fill="currentColor" stroke-width="0"></rect><path d="m12,23c-6.065,0-11-4.935-11-11S5.935,1,12,1s11,4.935,11,11-4.935,11-11,11Zm0-20C7.038,3,3,7.037,3,12s4.038,9,9,9,9-4.037,9-9S16.962,3,12,3Z" stroke-width="0" fill="currentColor"></path></g></svg>
                                {{ $message }}
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="avatar max-auto flex flex-col gap-2 items-center ">
                    <div id="upload" class="mask mask-squircle w-36 cursor-pointer hover:scale-105 trasition-transform">
                        <img id="preview" src="{{ asset('images/no-photo.png') }}" />
                    </div>
                    <small class="flex items-center gap-2 text-sm text-gray-500">
                        <img class="w-8 h-8" src="{{ asset('images/nuve.gif') }}" alt="">
                        upload photo
                    </small>
                </div>
                <input type="file" name="photo" id="photo" class="hidden">
                <label class="fieldset-label">Document:</label>
                <input type="number" name="document" class="input rounded-full w-full" placeholder="75000001" value="{{ old('document') }}" />

                <label class="fieldset-label">FullName:</label>
                <input type="text" name="fullname" class="input rounded-full w-full" placeholder="John Wick" value="{{ old('fullname') }}"/>

                <label class="fieldset-label">Gender:</label>
                <select name="gender" class="select rounded-full w-full">
                    <option value="">Select Gender...</option>
                    <option value="Female" @if(old('gender')=='Female') selected @endif>Female</option>
                    <option value="Male" @if(old('gender')=='Male') selected @endif>Male</option>
                </select>

                <label class="fieldset-label">BirthDate:</label>
                <input type="date" name="birthdate" class="input rounded-full w-full" value="{{ old('birthdate') }}"/>

                <label class="fieldset-label">Phone:</label>
                <input type="text" name="phone" class="input rounded-full w-full" placeholder="3210000001" value="{{ old('phone') }}"/>

                <label class="fieldset-label">Email:</label>
                <input type="email" name="email" class="input rounded-full w-full" placeholder="jwick@mail.com" value="{{ old('email') }}"/>
                
                <label class="fieldset-label">Password:</label>
                <input type="password" name="password" class="input rounded-full w-full" placeholder="secret" />

                <label class="fieldset-label">Confirm Password:</label>
                <input type="password" name="password_confirmation" class="input rounded-full w-full" placeholder="secret" />
                
                <button class="btn mt-4 p-6 rounded-full text-white bg-purple-800 w-full">Create</button>


        </fieldset>
    </form>
    


  
@endsection

@section('js')
<script>
    // Obtener elementos
    const upload = document.getElementById('upload');
    const photo = document.getElementById('photo');
    const preview = document.getElementById('preview');

    // Abrir selector de archivo al hacer click en la imagen
    upload.addEventListener('click', function(e) {
        photo.click();
    });

    // Mostrar vista previa de la imagen seleccionada
    photo.addEventListener('change', function(e) {
        preview.src = URL.createObjectURL(this.files[0]);
    });
</script>
@endsection

