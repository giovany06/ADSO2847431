@extends('layouts.app')
@section('title', 'Create Pet')

@section('content')
@include('layouts.navbar')

<h1 class="text-3xl pt-30 flex gap-2 items-center text-white font-bold mb-10 pb-2 border-b-2">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
    </svg>
    Create Pet
</h1>

<form method="post" action="{{ route('pets.store') }}" class="pt-6 pb-20" enctype="multipart/form-data">
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
                <input type="file" name="image" id="image" class="hidden">

                <label class="fieldset-label">Pet Name:</label>
                <input type="text" name="name" class="input rounded-full w-full" placeholder="Max" value="{{ old('name') }}" />

                <label class="fieldset-label">Kind:</label>
                <select name="kind" class="select rounded-full w-full">
                    <option value="">Select Kind...</option>
                    <option value="Dog" @if(old('kind')=='Dog') selected @endif>Dog</option>
                    <option value="Cat" @if(old('kind')=='Cat') selected @endif>Cat</option>
                    <option value="Bird" @if(old('kind')=='Bird') selected @endif>Bird</option>
                    <option value="Fish" @if(old('kind')=='Fish') selected @endif>Fish</option>
                    <option value="Rabbit" @if(old('kind')=='Rabbit') selected @endif>Rabbit</option>
                </select>

                <label class="fieldset-label">Weight (kg):</label>
                <input type="number" step="0.1" name="weight" class="input rounded-full w-full" placeholder="5.5" value="{{ old('weight') }}"/>

                <label class="fieldset-label">Age (years):</label>
                <input type="number" name="age" class="input rounded-full w-full" placeholder="2" value="{{ old('age') }}"/>

                <label class="fieldset-label">Breed:</label>
                <input type="text" name="breed" class="input rounded-full w-full" placeholder="Golden Retriever" value="{{ old('breed') }}"/>

                <label class="fieldset-label">Location:</label>
                <input type="text" name="location" class="input rounded-full w-full" placeholder="Bogotá, Colombia" value="{{ old('location') }}"/>

                <label class="fieldset-label">Description:</label>
                <textarea name="description" class="textarea w-full" rows="4" placeholder="Tell us about this pet...">{{ old('description') }}</textarea>
                
                <button class="btn mt-4 p-6 rounded-full text-white bg-purple-800 w-full">Create Pet</button>

        </fieldset>
    </form>

@endsection

@section('js')
<script>
    // Obtener elementos
    const upload = document.getElementById('upload');
    const image = document.getElementById('image');
    const preview = document.getElementById('preview');

    // Abrir selector de archivo al hacer click en la imagen
    upload.addEventListener('click', function(e) {
        image.click();
    });

    // Mostrar vista previa de la imagen seleccionada
    image.addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            preview.src = URL.createObjectURL(this.files[0]);
        }
    });
</script>
@endsection