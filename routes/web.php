<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\NoteLogsController;
use App\Http\Controllers\AnalyticsController;

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
Route::post('/shared-notes', [NoteController::class, 'storeSharedNotes'])->name('notes.shared.store');


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

// Admin Login route
Route::get('/adminLogin', [AdminController::class, 'showLoginForm'])
->name('adminLogin.form');
Route::post('/adminLogin', [AdminController::class, 'login'])
->name('adminLogin');

// Admin Dashboard route
Route::get('/adminDashboard', [AdminDashboardController::class, 'index'])
->name('adminDashboard');

// Note Logs route
Route::get('/admin/approved-notes', [NoteLogsController::class, 'approvedNotes'])->name('approvedNotes');
Route::get('/admin/disapproved-notes', [NoteLogsController::class, 'disapprovedNotes'])->name('disapprovedNotes');
Route::get('/notes/{noteId}/view', [NoteLogsController::class, 'view'])->name('notes.view');

// Reported Notes route
Route::get('/reportedNotes', [ReportController::class, 'index'])
->name('reportedNotes');
Route::post('/reported-notes/{noteId}/{action}', [ReportController::class, 'review'])
->name('reportedNotes.review');

// Analytics route
Route::get('/analytics/approval-disapproval', [AnalyticsController::class, 'getApprovalDisapprovalData']);
Route::get('/analytics/note-sharing', [AnalyticsController::class, 'getNoteSharing']);
Route::get('/analytics/reported-notes-over-time', [AnalyticsController::class, 'getReportedNotesOverTime']);
Route::get('/analytics/reported-issues', [AnalyticsController::class, 'getReportedIssues']);
Route::get('/analytics/reported-issues-categories', [AnalyticsController::class, 'getReportedIssuesCategories']);

// UpdateNoteStatus route
Route::put('/notes/{noteId}/status', [NoteController::class, 'updateNoteStatus'])
->name('updateNoteStatus');

//Logout route
Route::post('/adminLogout', function () {
    Auth::logout();
    return redirect('/adminLogin'); 
})->name('adminLogout');
