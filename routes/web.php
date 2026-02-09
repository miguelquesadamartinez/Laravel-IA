<?php

use App\Http\Controllers\AiSearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/ai/{provider}', [AiSearchController::class, 'index'])
        ->whereIn('provider', ['openai', 'anthropic', 'gemini', 'groq', 'xai', 'deepseek', 'mistral', 'ollama'])
        ->name('ai.index');
    Route::post('/ai/{provider}', [AiSearchController::class, 'search'])
        ->whereIn('provider', ['openai', 'anthropic', 'gemini', 'groq', 'xai', 'deepseek', 'mistral', 'ollama'])
        ->name('ai.search');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('users', UserController::class)->except(['show']);
});

require __DIR__.'/auth.php';
