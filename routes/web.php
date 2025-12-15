<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\GPAController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\FeeController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\QuizController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard (All authenticated users)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'admin' => view('dashboards.admin'),
        'teacher' => view('dashboards.teacher'),
        'student' => view('dashboards.student'),
        default => abort(403),
    };
})->middleware('auth');


/*
|--------------------------------------------------------------------------
| Authenticated User (Common)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    /* Profile */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /* GPA (Students only see data, Admin manages) */
    Route::resource('gpa', GPAController::class)->only(['index', 'show']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    Route::resource('timetables', TimetableController::class);
    Route::resource('notices', NoticeController::class);
    Route::resource('fees', FeeController::class);

    Route::resource('assignments', AssignmentController::class);
    Route::resource('quizzes', QuizController::class);
});

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->group(function () {

    /* Attendance */
    Route::resource('attendance', AttendanceController::class);
    
    /* Bulk attendance marking */
    Route::post('attendance/bulk', [AttendanceController::class, 'bulkMark'])
        ->name('attendance.bulk');

    /* Assignments */
    Route::resource('assignments', AssignmentController::class);

    /* Quizzes */
    Route::resource('quizzes', QuizController::class);
});

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:student'])->prefix('student')->group(function () {

    /* Attendance (View only) */
    Route::get('attendance', [AttendanceController::class, 'studentIndex'])
        ->name('student.attendance');

    /* Assignments */
    Route::get('assignments', [AssignmentController::class, 'index'])
        ->name('student.assignments');

    Route::post('assignments/upload', [AssignmentController::class, 'upload'])
        ->name('student.assignments.upload');

    /* Quizzes */
    Route::get('quizzes', [QuizController::class, 'index'])
        ->name('student.quizzes');

    /* GPA */
    Route::get('gpa', [GPAController::class, 'index'])
        ->name('student.gpa');
});

/*
|--------------------------------------------------------------------------
| Breeze Auth Routes
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';