@extends('layouts.app')
@section('title', 'Edit Pet')

@section('content')
@include('layouts.navbar')

<h1 class="text-3xl pt-30 flex gap-2 items-center text-white font-bold mb-10 pb-2 border-b-2">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
    </svg>
    Edit Pet
</h1>

<!-- ✅ RUTA CORRECTA: pets.update con PUT -->
<form method="post" action="{{ route('pets.update', $pet->id) }}" class="pt-6 pb-20" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
    <fieldset class="fieldset w-md bg-base-200 border border-base-300 p-4 rounded-box">
        
        {{-- Mostrar errores de validación --}}
        @if (count($errors->all()) > 0)
            <div class="flex flex-col gap-1 my-4">
                @foreach ($errors->all() as $message)
                    <div class="badge badge-error">
                        <svg class="size-[1em]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g fill="currentColor">
                                <rect x="1.972" y="11" width="20.056" height="2" transform="translate(-4.971 12) rotate(-45)" fill="currentColor" stroke-width="0"></rect>
                                <path d="m12,23c-6.065,0-11-4.935-11-11S5.935,1,12,1s11,4.935,11,11-4.935,11-11,11Zm0-20C7.038,3,3,7.037,3,12s4.038,9,9,9,9-4.037,9-9S16.962,3,12,3Z" stroke-width="0" fill="currentColor"></path>
                            </g>
                        </svg>
                        {{ $message }}
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Upload de imagen --}}
        <div class="avatar max-auto flex flex-col gap-2 items-center">
            <div id="upload" class="mask mask-squircle w-36 cursor-pointer hover:scale-105 transition-transform">
                <img id="preview" src="{{ asset('images/'.$pet->image) }}" alt="Pet photo" />
            </div>
            <small class="flex items-center gap-2 text-sm text-gray-500">
                <img class="w-8 h-8" src="{{ asset('images/nuve.gif') }}" alt="">
                Click to change photo (optional)
            </small>
        </div>
        <input type="file" name="image" id="image" class="hidden">

        {{-- Campos del formulario con valores prellenados --}}
        <label class="fieldset-label">Pet Name:</label>
        <input type="text" 
               name="name" 
               class="input rounded-full w-full" 
               placeholder="Pet name" 
               value="{{ old('name', $pet->name) }}" />

        <label class="fieldset-label">Kind:</label>
        <select name="kind" class="select rounded-full w-full">
            <option value="">Select Kind...</option>
            <option value="Dog" @if(old('kind', $pet->kind) == 'Dog') selected @endif>Dog</option>
            <option value="Cat" @if(old('kind', $pet->kind) == 'Cat') selected @endif>Cat</option>
            <option value="Bird" @if(old('kind', $pet->kind) == 'Bird') selected @endif>Bird</option>
            <option value="Fish" @if(old('kind', $pet->kind) == 'Fish') selected @endif>Fish</option>
            <option value="Rabbit" @if(old('kind', $pet->kind) == 'Rabbit') selected @endif>Rabbit</option>
        </select>

        <label class="fieldset-label">Weight (kg):</label>
        <input type="number" step="0.1" name="weight" class="input rounded-full w-full" placeholder="Weight" value="{{ old('weight', $pet->weight) }}" />

        <label class="fieldset-label">Age (years):</label>
        <input type="number" name="age" class="input rounded-full w-full" placeholder="Age in years" value="{{ old('age', $pet->age) }}" />

        <label class="fieldset-label">Breed:</label>
        <input type="text" name="breed" class="input rounded-full w-full" placeholder="breed" value="{{ old('breed', $pet->breed) }}" />

        <label class="fieldset-label">Location:</label>
        <input type="text" name="location" class="input rounded-full w-full" placeholder="Location" value="{{ old('location', $pet->location) }}" />

        <label class="fieldset-label">Description:</label>
        <textarea name="description" class="textarea w-full" rows="4" placeholder="Tell us about this pet...">{{ old('description', $pet->description) }}</textarea>

        <button class="btn mt-4 p-6 rounded-full text-white bg-purple-800 w-full">Update Pet</button>

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