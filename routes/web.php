<?php

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

function getContacts() {
    return [
        1 => ['name' => 'Name 1', 'phone' => '1234567890'],
        2 => ['name' => 'Name 2', 'phone' => '2345678901'],
        3 => ['name' => 'Name 3', 'phone' => '3456789012'],
    ];
}

Route::get('/', function () {
    return view('welcome');
});

// October 10, 2022 - Monday (First day of learning Laravel)
// compact('contacts') is equivalent to ['contacts' => $contacts]

Route::get('/contacts', function () {
    $companies = [
        1 => ['name' => 'Company One', 'contacts' => 3],
        2 => ['name' => 'Company Two', 'contacts' => 5],
    ];
    $contacts = getContacts();
    return view('contacts.index', compact('contacts', 'companies'));
})->name('contacts.index');

Route::get('/contacts/create', function () {
    return view('contacts.create'); // contacts = the folder, create = the file
})->name('contacts.create'); // to call route('contacts.create')

Route::get('/contacts/{id}', function($id) {
    $contacts = getContacts();
    abort_if(!isset($contacts[$id]), 404); //Validation for data in array of getContacts();
    $contact = $contacts[$id];
    return view('contacts.show')->with('contact', $contact);
})->whereNumber('id')->name('contacts.show'); // ->where('id', '[0-9]+');

Route::get('/companies/{name?}', function($name = null) {
    if ($name){
        return "Company " . $name;
    } else {
        return "All Companies";
    }
})->whereAlpha('name'); // ->where('name', '[a-zA-Z]+');

Route::fallback(function() {
    return "<h1>Sorry, the page does not exist.</h1>";
});