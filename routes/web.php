<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingsViewController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\TransactionsController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {

        Route::group(['prefix' => 'transactions'], function () {
            Route::get('/', [TransactionsController::class, 'listTransactions'])->name('transaction.listing');
            Route::get('/{id}/delete', [TransactionsController::class, 'deleteTransactionAction'])->name('transaction.delete.action');
            Route::get('/new', [TransactionsController::class, 'newTransactionView'])->name('transaction.new.view');
            Route::post('/new', [TransactionsController::class, 'newTransactionAction'])->name('transaction.new.action');
        });

    Route::group(['prefix' => 'settings'], function () {
        Route::group(['prefix' => 'transaction'], function () {
            Route::get('/categories', [SettingsViewController::class, 'TransactionCategoriesListing'])->name('settings.transaction.category.listing');
            Route::post('/categories', [SettingsController::class, 'AddNewTransactionCategory'])->name('settings.transaction.category.new');
        });
    });

	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade');
	 Route::get('map', function () {return view('pages.maps');})->name('map');
	 Route::get('icons', function () {return view('pages.icons');})->name('icons');
	 Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});
