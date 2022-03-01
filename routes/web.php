<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CaisseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome'); // page d'acceuil
});

/*
  Route: direction vers la page Entrée de fond de caisse
*/



Auth::routes([
  'register' => false, // désactivé inscription
  'reset' => false, // désactivé mot de passe oublié
  'verify' => false,
]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('caisse')->group(function(){
  Route::get('/', [CaisseController::class, 'index'])->name('caisse'); // page d'entrée de fond de caisse
  Route::post('/', [CaisseController::class, 'create'])->name('create_caisse');  // création d'operation de caisse
  Route::get('/list/{date}', [CaisseController::class, 'show'])->name('show_caisse'); //consultation d'operation de caisse
  Route::get('/update/{id}', [CaisseController::class, 'edit'])->name('update_caisse'); // mise à jour de donnée sur l'operation de caisse
  Route::post('/update', [CaisseController::class, 'update'])->name('update_caisse_post'); // consultation d'une operation de caisse
  Route::get('/detete/{id}/{date}', [CaisseController::class, 'destroy'])->name('delete_caisse'); // supprression d'opperation de caisse
});
