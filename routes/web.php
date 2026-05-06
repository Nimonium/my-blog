<?php

use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\HeadlineController;
use App\Http\Controllers\Admin\HelpVideoController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/blog/{slug}', [FrontendController::class, 'show'])->name('blog.show');

Route::get('/dashboard', function () {
    return redirect()->route('admin.blogs.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('blogs', BlogController::class);
    
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('headlines', HeadlineController::class);
    Route::resource('help_videos', HelpVideoController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
