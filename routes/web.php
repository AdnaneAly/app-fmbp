<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutreRecetteController;
use App\Http\Controllers\AvanceSalaireController;
use App\Http\Controllers\BoulangerController;
use App\Http\Controllers\DepenceController;
use App\Http\Controllers\EmployeurController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProprietaireController;
use App\Http\Controllers\RecetteController;
use App\Http\Controllers\SalaireController;
use App\Http\Controllers\SituationController;
use App\Http\Controllers\TypeDepenceController;
use App\Http\Controllers\TypeRecetteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::post('/login', [AuthController::class, 'dologin']);
Route::delete('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/contact', [HomeController::class, 'contact'])->middleware('auth')->name('contact');
Route::get('/situation', [SituationController::class, 'index'])->middleware('auth')->name('situation.index');
Route::post('/situation/etat', [SituationController::class, 'etat'])->middleware('auth')->name('situation.etat');
Route::fallback(fn() => Redirect::to('/'));



Route::prefix('operation')->name('operation')->middleware('auth')->group(function(){
    Route::resource('grade', GradeController::class);
    Route::resource('typerecette', TypeRecetteController::class);
    Route::resource('typedepence', TypeDepenceController::class);
    Route::resource('proprietaire', ProprietaireController::class);
});

Route::group(["middleware" => "auth"], function(){
    Route::resource('boulanger', BoulangerController::class);
    Route::resource('employeur', EmployeurController::class);
    Route::resource('salaire', SalaireController::class);
    Route::resource('avancesalaire', AvanceSalaireController::class);
    Route::get('salaireavancer/{id}', [AvanceSalaireController::class, 'getAvanceSalaire'])->name('salaireavancer');
    Route::resource('recette', RecetteController::class);
    Route::resource('autrerecette', AutreRecetteController::class);
    Route::resource('depence', DepenceController::class);
});


