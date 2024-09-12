<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', [UserController::class, 'index']);

Route::post('/users/store', [UserController::class, 'store'])->name('users.store');

Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

