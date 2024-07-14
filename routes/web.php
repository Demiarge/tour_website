<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\pageController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\editController;
use App\Http\Controllers\packageController;
use App\Http\Controllers\adminsController;
use Illuminate\Http\Request;
use App\Http\Controllers\eventController;
use App\Http\Controllers\orderController;
use App\Http\Controllers\userBooking;

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

// Public routes
Route::get('/', [pageController::class, 'home'])->name('home');

// Login and Logout routes
Route::get('/login', [loginController::class, 'login'])->name('login');
Route::post('/login', [loginController::class, 'loginConfirm'])->name('login');
Route::get('/logout', [loginController::class, 'logout'])->name('logout');

// Registration routes
Route::get('/register', [registerController::class, 'register'])->name('register');
Route::post('/register', [registerController::class, 'registration'])->name('register');

// Routes that require user authentication
Route::middleware(['auth'])->group(function () {
    // Profile routes
    Route::get('/profile', [editController::class, 'editProfile'])->name('editprofile')->middleware('ValidUser');
    Route::post('/profile', [editController::class, 'updateData'])->name('editprofile')->middleware('ValidUser');

    // Package routes
    Route::get('/packages', [packageController::class, 'packagelist'])->name('packages');
    Route::get('/packagedetails/{id}', [packageController::class, 'packdetails'])->name('packdetails');
    Route::post('/createpackages', [packageController::class, 'createpackages'])->name('createpackages')->middleware('ValidUser')->middleware('CheckRole');
    Route::get('/createpackages', [packageController::class, 'package'])->name('createpackages')->middleware('ValidUser')->middleware('CheckRole');
    Route::get('package/delete/{id}', [packageController::class, 'delete'])->middleware('CheckRole');
    Route::get('/book/{id}', [packageController::class, 'whoBooked'])->middleware('CheckRole');
    Route::get('/editpackage/{id}', [packageController::class, 'editpackage'])->name('editpackage')->middleware('ValidUser')->middleware('CheckRole');
    Route::post('/editpackage', [packageController::class, 'updatePackage'])->name('editpackage')->middleware('ValidUser')->middleware('CheckRole');
    Route::post('/packagedetails', [orderController::class, 'confirmPackage'])->name('confirmpackage')->middleware('ValidUser');

    // User booking route
    Route::get('/mybooking', [userBooking::class, 'mybooking'])->name('mybooking')->middleware('ValidUser');

    // Event routes
    Route::get('/events', [eventController::class, 'eventlist'])->name('events');
    Route::get('/eventdetails/{id}', [eventController::class, 'eventdetails'])->name('eventdetails');
    Route::post('/createevents', [eventController::class, 'createevents'])->name('createevents')->middleware('ValidUser')->middleware('CheckRole');
    Route::get('/createevents', [eventController::class, 'event'])->name('createevents')->middleware('ValidUser')->middleware('CheckRole');
    Route::get('/delete/{id}', [eventController::class, 'delete'])->middleware('ValidUser')->middleware('CheckRole');
    Route::get('/editevent/{id}', [eventController::class, 'editevent'])->name('editevent')->middleware('ValidUser')->middleware('CheckRole');
    Route::post('/editevent', [eventController::class, 'updateEvent'])->name('editevent')->middleware('ValidUser')->middleware('CheckRole');
    Route::get('/bookevent/{id}', [packageController::class, 'whoBookedEvent'])->middleware('ValidUser')->middleware('CheckRole');
    Route::post('/eventdetails', [orderController::class, 'confirmevent'])->name('confirmevent')->middleware('ValidUser');

    // Agent routes (redundant check removed)
    Route::post('/createpackages', [packageController::class, 'createpackages'])->name('createpackages')->middleware('ValidUser')->middleware('CheckRole');
    Route::get('/createpackages', [packageController::class, 'package'])->name('createpackages')->middleware('ValidUser')->middleware('CheckRole');
    Route::post('/createevents', [eventController::class, 'createevents'])->name('createevents')->middleware('ValidUser')->middleware('CheckRole');
    Route::get('/createevents', [eventController::class, 'event'])->name('event')->middleware('ValidUser')->middleware('CheckRole');
});

// Admin routes
Route::prefix('admin')->group(function () {
    // Admin login routes
    Route::get('/', [loginController::class, 'adminlogin'])->name('admin');
    Route::post('/', [loginController::class, 'adminloginConfirm']);
    Route::post('/logout', [loginController::class, 'Alogout'])->name('Alogout');

    // Routes that require admin authentication
    Route::middleware(['auth:admin'])->group(function () {
        // Admin dashboard route
        Route::get('/dash', [pageController::class, 'adminDash'])->name('adminDash');

        // Admin profile routes
        Route::get('/profile', [editController::class, 'admineditProfile'])->name('admineditprofile');
        Route::post('/profile', [editController::class, 'adminupdateData'])->name('admineditprofile');

        // Admin management routes
        Route::get('/create', [adminsController::class, 'create'])->name('admins.create');
        Route::post('/create', [adminsController::class, 'createSubmit'])->name('admins.create');
        Route::get('/list', [adminsController::class, 'list'])->name('admins.list');
        Route::get('/edit/{id}/{name}', [adminsController::class, 'edit']);
        Route::post('/edit', [adminsController::class, 'editSubmit'])->name('admin.edit');
        Route::get('/delete/{id}/{name}', [adminsController::class, 'delete']);

        // User management routes
        Route::get('/users', [adminsController::class, 'Userlist'])->name('admins.Userlist');
        Route::get('/useredit/{id}/{name}', [adminsController::class, 'Useredit']);
        Route::post('/useredit', [adminsController::class, 'UsereditSubmit'])->name('admin.Useredit');
        Route::get('/userdelete/{id}/{name}', [adminsController::class, 'Userdelete']);
        Route::get('/orderlist/{id}/{name}', [adminsController::class, 'orderlist']);

        // Package management routes
        Route::get('/packagelist', [adminsController::class, 'Packagelist'])->name('admins.packagelist');
        Route::get('/packageedit/{id}/{name}', [adminsController::class, 'Packageedit']);
        Route::post('/packageedit', [adminsController::class, 'PackageeditSubmit'])->name('admin.Packageedit');
        Route::get('/packagedelete/{id}/{name}', [adminsController::class, 'Packagedelete']);

        // Agent management routes
        Route::get('/agent', [adminsController::class, 'Agentlist'])->name('admins.Agentlist');
        Route::get('/agentedit/{id}/{name}', [adminsController::class, 'Agentedit']);
        Route::post('/agentedit', [adminsController::class, 'AgenteditSubmit'])->name('admin.Agentedit');
        Route::get('/agentdelete/{id}/{name}', [adminsController::class, 'Agentdelete']);
        Route::get('/item/{id}/{name}', [adminsController::class, 'item']);

        // Event management routes
        Route::get('/events', [eventController::class, 'Admineventlist'])->name('admins.events');
        Route::get('/eventdetails/{id}/{name}', [eventController::class, 'Admineventdetails'])->name('admins.eventdetails');
    });
});

// Admin logout route (redundant, handled in group)
Route::get('/adminlogout', [loginController::class, 'Alogout'])->name('Alogout');
