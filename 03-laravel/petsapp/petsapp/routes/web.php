<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Models\User as User;
use App\Models\Pet as Pet;
use Carbon\Carbon as Carbon;

Route::get('/', function () {
    return view('welcome');
})->name('home');

//list all users (Factory challenge
Route::get('show/users', function () {
    $users = User::all();
   //d($users->toArray());
    return view('users-factory')->with('users', $users);
});

Route::get('show/Pets', function(){
    $pets = Pet::all();
    dd($pets);
})->name('Pets');

Route::get('hello', function(){
    return "<h1>Hello ruta</h1>";
})->name('helloMensagge');

// mostrando datos de los 20 primeros usuarios
Route::get('show/info/users',function (){
    $usersInfo = User::select('fullname', 'birthdate', 'created_at')->take(20)->get();
    $html = '<table border="1" style=""border-collapse: collapse; width: 50%; margin: 20px auto; border: 1px solid #ddd; font-family: Arial, sans-serif;">
                <tr style="background-color: #f0f0f0; color: #333;">
                    <td style="padding: 10px; border: 1px solid #ddd;">Nombre completo</td>
                    <td style="padding: 10px; border: 1px solid #ddd;">Edad </td>
                    <td style="padding: 10px; border: 1px solid #ddd;">Creado hace</td>
                </tr>';
    foreach ($usersInfo as $user){
        // sacando la edad
        $bithD = $user->birthdate;
        $birthArr = explode('-',$bithD);
        $age = Carbon::createFromDate(intval($birthArr[0]), intval($birthArr[1]),intval($birthArr[2]))->age;
        
        // dd($age);
        // <td>'.$user->created_at->diffForHumans().'</td>
        // dd($user->fullname,$user->birthdate);
        // echo '<"h1">'.$user->fullname." ".$user->birthdate." ".$user->created_at." <h1>";
        $html .= '<tr style="background-color: #f0f0f0; color: #333;">';
        $html .=   '<td style="padding: 10px; border: 1px solid #ddd;">'.$user->fullname.'</td>';
        $html .=   '<td style="padding: 10px; border: 1px solid #ddd;">'. $age.' años</td>';
        $html .=   '<td style="padding: 10px; border: 1px solid #ddd;">'.$user->created_at->diffForHumans().'</td>';
        $html .= '</tr>';
    }
    return $html . '</table>';
});

Route::get('/view/blade' ,function (){
    $title = "Examples blade";
    $pets = Pet::whereIn('kind',['cat','dog'])->get();
    return view('example-view')
    ->with('title',$title)
    ->with('pets',$pets); 
});

// ruta para obtener informacion sobre la mascota
Route::get('/show/info/pet/{id}',function (string $Id){
    $petId = $Id;
    // hago la consulta de la mascota
    $pet = Pet::where('id',$petId)->get();
// dd($pet);
    return  view('pet-info') ->with('pets', $pet);
});

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';