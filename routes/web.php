<?php

declare(strict_types=1);

use App\Http\Controllers\RemoteLicenseController;
use App\Http\Controllers\RemotePersonController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('{group}/person', [RemotePersonController::class, 'index'])->name('person.group');
Route::post('person/{person}', [RemotePersonController::class, 'create'])->name('person.remote.create');
Route::put('person/{person}', [RemotePersonController::class, 'update'])->name('person.remote.update');
Route::delete('person/{person}', [RemotePersonController::class, 'delete'])->name('person.remote.delete');

Route::get('{person}/license', [RemoteLicenseController::class, 'index'])->name('license.index');
