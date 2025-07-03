<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\User as User;
use App\Models\Pet as Pet;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UserController;
use App\Http\Controllers\PetController;
//use App\Http\Controllers\AdoptionController;

Route::get('/', function () {
    return view('welcome');
});

// List All Users (Factory Challenge)
Route::get('show/users', function() {
    $users = User::all();
    //dd($users->toArray());
    return view('users-factory')->with('users', $users);
});

Route::get('hello', function() {
    //echo "Hello from Laravel";
    return "<h1>Hello Laravel ❤️</h1>";
})->name('hello');



Route::get('/challenge/users', function() {
    $users = User::limit(20)->get();
    //dd($users->toArray());
    $code = "<table style='border-collapse: collapse; margin: 2rem auto; font-family: Arial'>
                <tr>
                    <th style='background: gray; color: white; padding: 0.4rem'>Id</th>
                    <th style='background: gray; color: white; padding: 0.4rem'>Fullname</th>
                    <th style='background: gray; color: white; padding: 0.4rem'>Age</th>
                    <th style='background: gray; color: white; padding: 0.4rem'>Created At</th>
                </tr>";
    foreach($users as $user) {
        $code .= ($user->id%2 == 0) ? "<tr style='background: #ddd'>" : "<tr>";
        $code .=    "<td style='border: 1px solid gray; padding: 0.4rem'>".$user->id."</td>";
        $code .=    "<td style='border: 1px solid gray; padding: 0.4rem'>".$user->fullname."</td>";
        $code .=    "<td style='border: 1px solid gray; padding: 0.4rem'>".Carbon\Carbon::parse($user->birthdate)->age." years old</td>";
        $code .=    "<td style='border: 1px solid gray; padding: 0.4rem'>".$user->created_at->diffForHumans()."</td>";
        $code .= "</tr>";
    }
    return $code . "</table>";
});

// lista de pets
Route::get('/challenge/pets', function () {
    $pets = Pet::limit(20)->get();

    $code = "<table style='border-collapse: collapse; margin: 2rem auto; font-family: Arial'>
                <tr>
                    <th style='background: gray; color: white; padding: 0.4rem'>ID</th>
                    <th style='background: gray; color: white; padding: 0.4rem'>Name</th>
                    <th style='background: gray; color: white; padding: 0.4rem'>Image</th>
                    <th style='background: gray; color: white; padding: 0.4rem'>Kind</th>
                    <th style='background: gray; color: white; padding: 0.4rem'>Weight</th>
                    <th style='background: gray; color: white; padding: 0.4rem'>Age</th>
                    <th style='background: gray; color: white; padding: 0.4rem'>Breed</th>
                    <th style='background: gray; color: white; padding: 0.4rem'>Location</th>
                    <th style='background: gray; color: white; padding: 0.4rem'>Description</th>
                    <th style='background: gray; color: white; padding: 0.4rem'>Created At</th>
                </tr>";

    foreach ($pets as $pet) {
        $code .= ($pet->id % 2 == 0) ? "<tr style='background: #ddd'>" : "<tr>";

        $code .= "<td style='border: 1px solid gray; padding: 0.4rem'>{$pet->id}</td>";
        $code .= "<td style='border: 1px solid gray; padding: 0.4rem'>{$pet->name}</td>";
        $code .= "<td style='border: 1px solid gray; padding: 0.4rem'><img src='{$pet->image}' alt='image' width='60' height='60'></td>";
        $code .= "<td style='border: 1px solid gray; padding: 0.4rem'>{$pet->kind}</td>";
        $code .= "<td style='border: 1px solid gray; padding: 0.4rem'>{$pet->weight} kg</td>";
        $code .= "<td style='border: 1px solid gray; padding: 0.4rem'>{$pet->age} years</td>";
        $code .= "<td style='border: 1px solid gray; padding: 0.4rem'>{$pet->breed}</td>";
        $code .= "<td style='border: 1px solid gray; padding: 0.4rem'>{$pet->location}</td>";
        $code .= "<td style='border: 1px solid gray; padding: 0.4rem'>{$pet->description}</td>";
        $code .= "<td style='border: 1px solid gray; padding: 0.4rem'>{$pet->created_at->diffForHumans()}</td>";

        $code .= "</tr>";
    }

    $code .= "</table>";

    return $code;
});


Route::get('view/blade', function() {
    $title = "Examples Blade";
    $pets  = App\Models\Pet::whereIn('kind', ['dog', 'cat'])->get();

    return view('example-view')
         ->with('title', $title)
         ->with('pets', $pets);
});


Route::get('show/pet/{id}', function() {
    $pet = App\Models\Pet::find(request()->id);
    //dd($pet->toArray());
    return view('show-pet')->with('pet', $pet);
});

Route::get('edit/pet/{id}', function() {
    $pet = App\Models\Pet::find(request()->id);
    return view('edit-pet')->with('pet', $pet);
});

Route::get('/dashboard', function (Request $request) {

    if (Auth::user()->role == 'Admin') {
        return view('dashboard-admin');
    } else if (Auth::user()->role == 'Customer') {
        return view('dashboard-customer');
    } else {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->back()->with('error', 'Role no exist!');
    }
    
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {

    Route::resources([
        'users'     => UserController::class,
        'pets'      => PetController::class,
        //'adoptions' => AdoptionController::class,
    ]);
    
});

require __DIR__.'/auth.php';
