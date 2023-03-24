<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Learner\User\Presentation\API\CreateLearnerController;
use App\Teacher\User\Presentation\API\CreateTeacherController;
use App\Learner\Reservation\Presentation\API\BookLessonController;
use App\Teacher\Lesson\Presentation\API\ValidateBookingController;
use App\Learner\Reservation\Presentation\API\GetBookingsController;
use App\Learner\Reservation\Presentation\API\GetLessonsAvailableController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('learner', CreateLearnerController::class);
Route::post('teacher', CreateTeacherController::class);

Route::get('lessons-available', GetLessonsAvailableController::class);

Route::post('book', BookLessonController::class);

Route::get('bookings/{learner_id}', GetBookingsController::class);

Route::post('booking/{id}/validation-state', ValidateBookingController::class);