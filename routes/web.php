<?php

use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MatchingListController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\FilesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::resource('/users', UserController::class);
    Route::resource('/products', ProductsController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/stocks', StocksController::class);
    Route::resource('/files', FilesController::class);
    Route::resource('/matchinglist', MatchingListController::class);
    Route::get('/matching/select/{product}', [MatchingListController::class, 'showSelectPage'])->where('product', '.*')->name('matchinglist.select');
    Route::post('/matching/save', [MatchingListController::class, 'saveMacthingInformation'])->name('matching.save');
    Route::get('/file/user', [FilesController::class, 'getFilesByUser'])->name('files.user');
    Route::get('/file/mine', [FilesController::class, 'getMyFiles'])->name('files.mine');
    Route::post('/file/upload', [FilesController::class, 'uploadFile'])->name('files.upload');
});

Route::post('/users/delete', [UserController::class, 'deleteMultiple'])->name('users.delete');
Route::post('/products/delete', [ProductsController::class, 'deleteMultiple'])->name('products.delete');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function (Request $request) {
        $user = $request->user();
        if ($user->isAdmin())
            return Inertia::render('Dashboard');
        else
            return redirect()->route('files.mine');
    })->name('dashboard');
});
