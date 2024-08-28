<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

Route::get('/register', [AuthController::class, 'loadRegister'])->name('loadRegister');
Route::post('/register', [AuthController::class, 'studentRegister'])->name('studentRegister');

Route::get('/', [AuthController::class, 'loadLogin'])->name('loadLogin');
Route::post('/', [AuthController::class, 'userLogin'])->name('userLogin');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forget-password', [AuthController::class, 'forgetPasswordLoad'])->name('forgetPasswordLoad');
Route::post('/forget-password', [AuthController::class, 'forgetPassword'])->name('forgetPassword');

Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordLoad']);
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('resetPassword');

Route::get('/404', function(){
    return view('404');
});

Route::group(['middleware' => ['web', 'checkAdmin']], function () {
    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');

    Route::post('/add-subject', [AdminController::class, 'addSubject'])->name('addSubject');
    Route::post('/edit-subject', [AdminController::class, 'editSubject'])->name('editSubject');
    Route::post('/delete-subject', [AdminController::class, 'deleteSubject'])->name('deleteSubject');

    Route::get('/admin/exams', [AdminController::class, 'examDashboard'])->name('admin.examDashboard');
    Route::post('/add-exam', [AdminController::class, 'addExam'])->name('addExam');
    Route::post('/edit-exam', [AdminController::class, 'editExam'])->name('editExam');
    Route::post('/delete-exam', [AdminController::class, 'deleteExam'])->name('deleteExam');
    Route::get('/get-exam-detail{id}', [AdminController::class, 'getExamDetail'])->name('getExamDetail');

    Route::get('/admin/qna', [AdminController::class, 'qnaDashboard'])->name('admin.qnaDashboard');
    Route::post('/add-qna-ans', [AdminController::class, 'addQna'])->name('admin.addQna');
    Route::get('/get-qna-detail', [AdminController::class, 'getQnaDetail'])->name('getQnaDetail');
    Route::get('/delete-ans', [AdminController::class, 'deleteAns'])->name('deleteAns');
    Route::post('/update-qna-ans', [AdminController::class, 'updateAns'])->name('updateAns');
    Route::post('/delete-qna-ans', [AdminController::class, 'deleteQnaAns'])->name('deleteQnaAns');

    Route::get('/admin/students', [AdminController::class, 'studentList'])->name('admin.students');
    Route::post('/add-student', [AdminController::class, 'addStudent'])->name('addStudent');
    Route::post('/edit-student', [AdminController::class, 'editStudent'])->name('editStudent');
    Route::post('/delete-student', [AdminController::class, 'deleteStudent'])->name('deleteStudent');
});
Route::group(['middleware' => ['web', 'checkUser']], function () {
    Route::get('/dashboard', [AuthController::class, 'loadDashboard'])->name('load.dashboard');
});
