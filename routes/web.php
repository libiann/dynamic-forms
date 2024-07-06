<?php

use App\Http\Controllers\FormFieldController;
use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', [FormController::class, 'index'])->name('welcome');
Route::post('/store-form', [FormController::class, 'store'])->name('form.store');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [FormFieldController::class, 'index'])->name('home');
    Route::get('/create-field', [FormFieldController::class, 'create'])->name('field.create');
    Route::post('/store-field', [FormFieldController::class, 'store'])->name('field.store');
    Route::get('/edit-field/{field}', [FormFieldController::class, 'edit'])->name('field.edit');
    Route::put('/update-field/{field}', [FormFieldController::class, 'update'])->name('field.update');
    Route::delete('/destroy-field/{field}', [FormFieldController::class, 'destroy'])->name('field.destroy');
});
