<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //latest() para listar del ultimo al primero
        $pets = Pet::latest()->paginate(10);
        return view('pets.index')->with('pets', $pets);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = request()->validate([
            'name'        => ['required', 'string'],
            'image'       => ['required', 'image'],
            'kind'        => ['required', 'string'],
            'weight'      => ['required', 'numeric'],
            'age'         => ['required', 'numeric'],
            'breed'       => ['required', 'string'],
            'location'    => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);
        if ($validated){
            if($request->hasFile('image')){
                $image = time().'.'.$request->image->extension();
                $request->image->move(public_path('images'), $image);
            }
        }

        $pet = new Pet;
        $pet->name = $request->name;
        $pet->image = $image;
        $pet->kind = $request->kind;
        $pet->weight = $request->weight;
        $pet->age = $request->age;
        $pet->breed = $request->breed;
        $pet->location = $request->location;
        $pet->description = $request->description;
        $pet->status = 0;

        if($pet->save()){
            return redirect('pets')->with('message', 'Thes pet: '.$pet->name.' was successfully added');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pet $pet)
    {
        return view('pets.show')->with('pet', $pet);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pet $pet)
    {
        return view('pets.edit')->with('pet', $pet);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pet $pet)
    {
       $request->validate([
            'name'        => ['nullable', 'string'],
            'image'       => ['nullable', 'image'],
            'kind'        => ['nullable', 'string', 'in:Dog,Cat,Bird,Fish,Reptile'],
            'weight'      => ['nullable', 'numeric'],
            'age'         => ['nullable', 'numeric'],
            'breed'       => ['nullable', 'string'],
            'location'    => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
        ]);
        
        //este sirve para filtrar los campos que se van a actualizar
        $data = array_filter($request->only([
            'name','kind','weight','age','breed','location','description'
        ]), function($value) {
            return !is_null($value) && $value !== '';
        });

        // este sirve pra ver si se subio la imagen nueva
        if ($request->hasFile('image')) {
            if ($pet->image && file_exists(public_path('images/'.$pet->image))) {
                unlink(public_path('images/'.$pet->image));
            }
            
            $image = time().'.'.$request->image->extension();
            $request->image->move(public_path('images'), $image);
            $data['image'] = $image;
        }

        $pet->fill($data);
        $pet->save();

        return redirect('pets')->with('message', 'Pet updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pet $pet)
    {
        //funcion para eliminar la imagen
        if($pet->image && file_exists(public_path('images/'.$pet->images))){
            unlink(public_path('images/'.$pet->image));
        }
        //funcion para eliminar el registro
        $pet->delete();
        return redirect('pets')->with('message', 'The pet: '.$pet->name.' was successfully deleted');
    }
}
