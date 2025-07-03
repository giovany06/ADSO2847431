@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
@include('layouts.navbar')

<h1 class="text-3xl pt-30 flex gap-2 items-center text-white font-bold mb-10 pb-2 border-b-2">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
    </svg>
    Edit User
</h1>

<form method="post" action="{{ route('users.update', $user->id) }}" class="pt-6 pb-20" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
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
        
        <div class="avatar max-auto flex flex-col gap-2 items-center">
            <div id="upload" class="mask mask-squircle w-36 cursor-pointer hover:scale-105 transition-transform">
                <img id="preview" src="{{ asset('images/'.$user->photo) }}" />
            </div>
            <small class="flex items-center gap-2 text-sm text-gray-500">
                <img class="w-8 h-8" src="{{ asset('images/nuve.gif') }}" alt="">
                new photo
            </small>
        </div>
        <input type="file" name="photo" id="photo" class="hidden">
        

        
        <label class="fieldset-label">Document:</label>
        <input type="number" name="document" class="input rounded-full w-full" placeholder="document" value="{{ old('document', $user->document) }}" />

        <label class="fieldset-label">Full Name:</label>
        <input type="text" name="fullname" class="input rounded-full w-full" placeholder="name" value="{{ old('fullname', $user->fullname) }}" />

        <label class="fieldset-label">Gender:</label>
        <select name="gender" class="select rounded-full w-full">
            <option value="">Select gender</option>
            <option value="Female" @if(old('gender', $user->gender) == 'Female') selected @endif>Female</option>
            <option value="Male" @if(old('gender', $user->gender) == 'Male') selected @endif>Male</option>
        </select>

        <label class="fieldset-label">Birth Date:</label>
        <input type="date" name="birthdate" class="input rounded-full w-full" value="{{ old('birthdate', $user->birthdate) }}" />

        <label class="fieldset-label">Phone:</label>
        <input type="text" name="phone" class="input rounded-full w-full" placeholder="phone" value="{{ old('phone', $user->phone) }}" />

        <label class="fieldset-label">Email:</label>
        <input type="email" name="email" class="input rounded-full w-full" placeholder="Enter email address" value="{{ old('email', $user->email) }}" />
        
        <label class="fieldset-label">New Password (optional):</label>
        <input type="password" name="password" class="input rounded-full w-full" placeholder="new password" />

        <label class="fieldset-label">Confirm New Password:</label>
        <input type="password" name="password_confirmation" class="input rounded-full w-full" placeholder="Confirm new password" />
        
        <button class="btn mt-4 p-6 rounded-full text-white bg-purple-800 w-full">Update User</button>
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
        if (this.files[0]) {
            preview.src = URL.createObjectURL(this.files[0]);
        }
    });
</script>
@endsection