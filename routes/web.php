<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AutreRecetteController;
use App\Http\Controllers\AvanceSalaireController;
use App\Http\Controllers\BoulangerController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DepenceController;
use App\Http\Controllers\EmployeurController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ObservationController;
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
Route::get('contact', [HomeController::class, 'contact'])->middleware('auth')->name('contact');
Route::get('situation', [SituationController::class, 'index'])->middleware('auth')->name('situation.index');
Route::get('situation/printetat', [SituationController::class, 'printetat'])->middleware('auth')->name('situation.printetat');
Route::get('situation/printrecette', [SituationController::class, 'printrecette'])->middleware('auth')->name('situation.printrecette');
Route::get('situation/printdepence', [SituationController::class, 'printdepence'])->middleware('auth')->name('situation.printdepence');
Route::post('situation/etat', [SituationController::class, 'etat'])->middleware('auth')->name('situation.etat');
Route::get('salaire/print', [SalaireController::class, 'print'])->middleware('auth')->name('salaire.print');
Route::get('salaireavancer/{id}', [AvanceSalaireController::class, 'getAvanceSalaire'])->middleware('auth')->name('salaireavancer');
Route::get('avancesalaire/print', [AvanceSalaireController::class, 'print'])->middleware('auth')->name('avancesalaire.print');
Route::get('depence/print', [DepenceController::class, 'print'])->middleware('auth')->name('depence.print');
Route::get('recette/print', [RecetteController::class, 'print'])->middleware('auth')->name('recette.print');
Route::get('boulanger/print', [BoulangerController::class, 'print'])->middleware('auth')->name('boulanger.print');
Route::get('boulanger/printDetail', [BoulangerController::class, 'printDetail'])->middleware('auth')->name('boulanger.printDetail');
Route::get('employeur/print', [EmployeurController::class, 'print'])->middleware('auth')->name('employeur.print');
Route::get('autrerecette/print', [AutreRecetteController::class, 'print'])->middleware('auth')->name('autrerecette.print');
Route::get('observation/print', [ObservationController::class, 'print'])->middleware('auth')->name('observation.print');
Route::get('observation/prints', [ObservationController::class, 'prints'])->middleware('auth')->name('observation.prints');
Route::post('comment/{comment}', [CommentController::class, 'updateComment'])->middleware('auth')->name('comment.updateComment');
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
    Route::resource('recette', RecetteController::class);
    Route::resource('autrerecette', AutreRecetteController::class);
    Route::resource('depence', DepenceController::class);
    Route::resource('observation', ObservationController::class);
    Route::resource('comment', CommentController::class);
});


