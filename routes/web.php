<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// routes/web.php

//notes route
use App\Http\Controllers\NoteController;
// Resource routes for notes (your existing routes)
Route::resource('notes', NoteController::class)->middleware('auth');
// Shared notes routes
Route::get('/shared-notes', [NoteController::class, 'sharedNotes'])->name('notes.shared');
Route::post('/notes/{note}/share', [NoteController::class, 'share'])->name('notes.share');
Route::get('/shared-notes/{note}', [NoteController::class, 'showSharedNote'])->name('notes.shared.show');

//report notes
use App\Http\Controllers\ReportController;
Route::post('/notes/{note}/report', [ReportController::class, 'store'])->name('notes.report');
Route::post('/notes/{note}/report', [ReportController::class, 'store'])->name('notes.report')->middleware('auth');


//flashcard route
use App\Http\Controllers\FlashcardController;
Route::resource('flashcards', FlashcardController::class)->middleware('auth');
Route::get('/flashcards/{flashcardSet}', [FlashcardController::class, 'show'])->name('flashcards.show');
Route::get('/flashcards/add/{flashcardSet}', [FlashcardController::class, 'add'])->name('flashcards.add');
Route::post('/flashcards/add/{flashcardSet}', [FlashcardController::class, 'storeFlashcard'])->name('flashcards.storeFlashcard');
Route::get('/flashcards/{id}/edit', [FlashcardController::class, 'edit'])->name('flashcards.edit');
Route::put('/flashcards/{id}', [FlashcardController::class, 'update'])->name('flashcards.update');

//tasks route
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaskController;

//dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/dashboard', [TaskController::class, 'getDashboardTasks'])->name('dashboard');
Route::resource('tasks', TaskController::class)->only(['index', 'store', 'update', 'destroy']);
