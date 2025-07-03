<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$users = User::all();
        //lastest() para listar del ultimo al primero
        $users = User::latest()->paginate(10);
        //$users = User::simplePaginate(10);
        //dd($users->toArray()); //Dump & Die
        return view('users.index')->with('users', $users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'document'  => ['required', 'numeric', 'unique:'.User::class],
            'fullname'  => ['required', 'string'],
            'gender'    => ['required'],
            'birthdate' => ['required', 'date'],
            'photo'     => ['required', 'image'],
            'phone'     => ['required',],
            'email'     => ['required', 'lowercase', 'email', 'unique:'.User::class],
            'password'  => ['required', 'confirmed', 'min:4'],
        ]);
        if($validated){
            //dd($request->all());
            if($request->hasFile('photo')){
                $photo = time().'.'.$request->photo->extension();
                $request->photo->move(public_path('images'), $photo);
            }
        }
        
        $user = new user;
        $user->document = $request->document;
        $user->fullname = $request->fullname;
        $user->gender = $request->gender;
        $user->birthdate = $request->birthdate;
        $user->photo = $photo;
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->password = bcrypt($request->password); 

        if($user->save()){
            return redirect('users')->with('message', 'Thes user: '.$user->fullname.' was successfully added');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show')->with('user', $user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'document'  => 'nullable|numeric|unique:users,document,'.$user->id,
            'fullname'  => 'nullable|string',
            'gender'    => 'nullable|in:Male,Female',
            'birthdate' => 'nullable|date',
            'photo'     => 'nullable|image',
            'phone'     => 'nullable|string',
            'email'     => 'nullable|email|unique:users,email,'.$user->id,
            'password'  => 'nullable|confirmed|min:4',
        ]);
        
        //este sirve para filtrar los campos que se van a actualizar
        $data = array_filter($request->only([
            'document','fullname','gender','birthdate','phone','email'
        ]), function($value) {
            return !is_null($value) && $value !== '';
        });

        // este sirve pra ver si se subio la foto nueva
        if ($request->hasFile('photo')) {
            if ($user->photo && file_exists(public_path('images/'.$user->photo))) {
                unlink(public_path('images/'.$user->photo));
            }
            
            $photo = time().'.'.$request->photo->extension();
            $request->photo->move(public_path('images'), $photo);
            $data['photo'] = $photo;
        }

        //este sirve para ver si se cambio la contraseña
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->fill($data);
        $user->save();

        return redirect('users')->with('message', 'User updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //funcion para eliminar la imagen
        if($user->photo && file_exists(public_path('images/'.$user->photo))){
            unlink(public_path('images/'.$user->photo));
        }
        //funcion para eliminar el registro
        $user->delete();
        return redirect('users')->with('message', 'The pet: '.$user->fullname.' was successfully deleted');
    }
}
