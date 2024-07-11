<?php

//tambahan gpt
use App\Http\Controllers\InternController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\AdminController;

use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SessionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

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


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');

//gpt pake yang ni ?
// Route::get('/intern/dashboard', [InternController::class, 'dashboard']);
// Route::get('/intern/attendance', [InternController::class, 'attendance']);
// Route::post('/intern/check-in', [InternController::class, 'checkIn']);
// Route::post('/intern/check-out', [InternController::class, 'checkOut']);
// Route::get('/intern/attendance-history', [InternController::class, 'attendanceHistory']);
// Route::get('/intern/daily-reports', [InternController::class, 'dailyReports']);
// Route::get('/intern/create-daily-report', [InternController::class, 'createDailyReport']);
// Route::post('/intern/store-daily-report', [InternController::class, 'storeDailyReport']);
// Route::get('/intern/show-daily-report/{id}', [InternController::class, 'showDailyReport']);
// Route::get('/intern/edit-daily-report/{id}', [InternController::class, 'editDailyReport']);
// Route::post('/intern/update-daily-report/{id}', [InternController::class, 'updateDailyReport']);
// Route::get('/intern/daily-reports-history', [InternController::class, 'dailyReportsHistory']);
// Route::get('/intern/tasks', [InternController::class, 'tasks']);
// Route::get('/intern/assigned-tasks', [InternController::class, 'assignedTasks']);
// Route::get('/intern/completed-tasks', [InternController::class, 'completedTasks']);
// Route::get('/intern/approaching-deadline-tasks', [InternController::class, 'approachingDeadlineTasks']);
// Route::get('/intern/profile', [InternController::class, 'profile']);
// Route::get('/intern/edit-profile', [InternController::class, 'editProfile']);
// Route::post('/intern/update-profile', [InternController::class, 'updateProfile']);

// Route::get('/supervisor/dashboard', [SupervisorController::class, 'dashboard']);
// Route::get('/supervisor/interns', [SupervisorController::class, 'interns']);
// Route::get('/supervisor/show-intern/{id}', [SupervisorController::class, 'showIntern']);
// Route::get('/supervisor/intern-attendance/{id}', [SupervisorController::class, 'internAttendance']);
// Route::get('/supervisor/intern-daily-reports/{id}', [SupervisorController::class, 'internDailyReports']);
// Route::get('/supervisor/intern-tasks/{id}', [SupervisorController::class, 'internTasks']);
// Route::get('/supervisor/assigned-tasks', [SupervisorController::class, 'assignedTasks']);
// Route::get('/supervisor/completed-tasks', [SupervisorController::class, 'completedTasks']);
// Route::get('/supervisor/approaching-deadline-tasks', [SupervisorController::class, 'approachingDeadlineTasks']);

// Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
// Route::get('/admin/user-management', [AdminController::class, 'userManagement']);
// Route::get('/admin/attendance-management', [AdminController::class, 'attendanceManagement']);
// Route::get('/admin/report-management', [AdminController::class, 'reportManagement']);
// Route::get('/admin/task-management', [AdminController::class, 'taskManagement']);
// Route::get('/admin/department-management', [AdminController::class, 'departmentManagement']);
// Route::get('/admin/system-settings', [AdminController::class, 'systemSettings']);


// gpt atau yang niii
Route::prefix('intern')->group(function () {
    Route::get('dashboard', [InternController::class, 'dashboard']);
    Route::get('attendance', [InternController::class, 'attendance']);
    Route::post('check-in', [InternController::class, 'checkIn']);
    Route::post('check-out', [InternController::class, 'checkOut']);
    Route::get('attendance-history', [InternController::class, 'attendanceHistory']);
    Route::get('daily-reports', [InternController::class, 'dailyReports']);
    Route::get('create-daily-report', [InternController::class, 'createDailyReport']);
    Route::post('store-daily-report', [InternController::class, 'storeDailyReport']);
    Route::get('show-daily-report/{id}', [InternController::class, 'showDailyReport']);
    Route::get('edit-daily-report/{id}', [InternController::class, 'editDailyReport']);
    Route::post('update-daily-report/{id}', [InternController::class, 'updateDailyReport']);
    Route::get('daily-reports-history', [InternController::class, 'dailyReportsHistory']);
    Route::get('tasks', [InternController::class, 'tasks']);
    Route::get('assigned-tasks', [InternController::class, 'assignedTasks']);
    Route::get('completed-tasks', [InternController::class, 'completedTasks']);
    Route::get('approaching-deadline-tasks', [InternController::class, 'approachingDeadlineTasks']);
    Route::get('profile', [InternController::class, 'profile']);
    Route::get('edit-profile', [InternController::class, 'editProfile']);
    Route::post('update-profile', [InternController::class, 'updateProfile']);
});

Route::prefix('supervisor')->group(function () {
    Route::get('dashboard', [SupervisorController::class, 'dashboard']);
    Route::get('interns', [SupervisorController::class, 'interns']);
    Route::get('show-intern/{id}', [SupervisorController::class, 'showIntern']);
    Route::get('intern-attendance/{id}', [SupervisorController::class, 'internAttendance']);
    Route::get('intern-daily-reports/{id}', [SupervisorController::class, 'internDailyReports']);
    Route::get('intern-tasks/{id}', [SupervisorController::class, 'internTasks']);
    Route::get('assigned-tasks', [SupervisorController::class, 'assignedTasks']);
    Route::get('completed-tasks', [SupervisorController::class, 'completedTasks']);
    Route::get('approaching-deadline-tasks', [SupervisorController::class, 'approachingDeadlineTasks']);
});

Route::prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard']);
    Route::get('user-management', [AdminController::class, 'userManagement']);
    Route::get('attendance-management', [AdminController::class, 'attendanceManagement']);
    Route::get('report-management', [AdminController::class, 'reportManagement']);
    Route::get('task-management', [AdminController::class, 'taskManagement']);
    Route::get('department-management', [AdminController::class, 'departmentManagement']);
    Route::get('system-settings', [AdminController::class, 'systemSettings']);
});
