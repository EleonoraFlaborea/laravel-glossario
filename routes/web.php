<?php

use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Guest\HomeController as GuestHomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', GuestHomeController::class)->name('guest.home');
Route::get('/words/{word}', [GuestHomeController::class, 'show'])->name('guest.words.show');

// Route x il cestino
Route::get('/words/trash', [WordController::class, 'trash'])->name('admin.words.trash');
// Route x recupero dal cestino
Route::patch('/admin./{word}/restore', [WordController::class, 'restore'])->name('admin.words.restore')->withTrashed();
// // Route x eliminazione definitiva
// Route::delete('/words/{word}/drop', [WordController::class, 'drop'])->name('admin.words.drop')->withTrashed();

// Rotta per la home Admin
Route::get('/admin', AdminHomeController::class)->middleware(['auth', 'verified'])->name('admin.home');
// Route x Index
Route::get('/admin/words', [WordController::class, 'index'])->name('admin.words.index');
// Route x Create
Route::get('/admin/words/create', [WordController::class, 'create'])->name('admin.words.create');
// Route x Show
Route::get('/admin/words/{word}', [WordController::class, 'show'])->name('admin.words.show');
// Rotta per la modifica della parola
Route::get('/admin/words/{word}/edit', [WordController::class, 'edit'])->name('admin.words.edit');
// Route per Store
Route::post('/admin/words', [WordController::class, 'store'])->name('admin.words.store');
// Route per Delete
Route::delete('/admin/words/{word}', [WordController::class, 'destroy'])->name('admin.words.destroy');
// Rotta per salvataggio della modifica su db
Route::put('/admin/words/{word}/', [WordController::class, 'update'])->name('admin.words.update');







Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
