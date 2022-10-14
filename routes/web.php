<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Spatie\FlareClient\View;

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

// October 10, 2022 - Monday (First day of learning Laravel)
// compact('contacts') is equivalent to ['contacts' => $contacts]
// public function __invoke() - if there's only a single action on a controller -> singleAction controller

Route::get('/', WelcomeController::class); // <- singleAction controller

Route::controller(ContactController::class)->name('contacts.')->group(function() {
    Route::get('/contacts', 'index')->name('index');
    Route::get('/contacts/create', 'create')->name('create'); // to call route('contacts.create') in the View
    Route::get('/contacts/{id}', 'show')->whereNumber('id')->name('show'); // ->where('id', '[0-9]+');
});

// Resources Controller - Section 6: No. 40
Route::resource('/companies', CompanyController::class);
Route::resources([
    '/tags' => TagController::class,
    '/tasks' => TaskController::class
]);
Route::resource('/activities', ActivityController::class)->except([
    'index', 'show'
]);


// Route::get('/companies/{name?}', function($name = null) {
//     if ($name){
//         return "Company " . $name;
//     } else {
//         return "All Companies";
//     }
// })->whereAlpha('name'); // ->where('name', '[a-zA-Z]+');

Route::fallback(function() {
    return "<h1>Sorry, the page does not exist.</h1>";
});