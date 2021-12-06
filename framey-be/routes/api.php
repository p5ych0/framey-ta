<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'employees', 'namespace' => 'App\Http\Controllers'], function() {
    Route::post('/', [EmployeeController::class, 'store']);
    Route::get('/', [EmployeeController::class, 'index'])->name('list');
    Route::get('{id}', [EmployeeController::class, 'show'])->whereNumber('id')->name('find');
    Route::get('{id}/children', [EmployeeController::class, 'children'])->whereNumber('id')->name('children');
    Route::put('{id}', [EmployeeController::class, 'update'])->whereNumber('id')->name('edit');
    Route::delete('{id}', [EmployeeController::class, 'destroy'])->whereNumber('id')->name('delete');
    Route::get('positions', [EmployeeController::class, 'positions'])->whereNumber('id')->name('positions');
});
