<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\GPAController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\FeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*asdasdadasd
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /* Profile */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* Campus Utility Modules */
    Route::resource('timetables', TimetableController::class);
    Route::resource('gpa', GPAController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::resource('notices', NoticeController::class);
    Route::resource('fees', FeeController::class);
});
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('notice', NoticeController::class);
    Route::resource('fee', FeeController::class);
    Route::resource('timetable', TimetableController::class);
});

Route::middleware(['auth', 'role:teacher'])->group(function () {
    Route::resource('attendance', AttendanceController::class)->except(['show']);
    Route::resource('assignment', AssignmentController::class);
    Route::resource('quiz', QuizController::class);
});

Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('assignment', [AssignmentController::class, 'index'])->name('assignment.index');
    Route::post('assignment/upload', [AssignmentController::class, 'upload'])->name('assignment.upload');
    Route::get('quiz', [QuizController::class, 'index'])->name('quiz.index');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
