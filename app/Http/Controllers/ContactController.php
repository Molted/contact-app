<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // protected $company;

    // Option A
    // public function __construct()
    // {
    //     $this->company = new CompanyRepository();
    // }

    // Option B
    // public function __construct(CompanyRepository $company)
    // {
    //     $this->company = $company;
    // }

    // Option C
    public function __construct(protected CompanyRepository $company)
    {
    }

    public function index() {
        // $companies = [
        //     1 => ['name' => 'Company One', 'contacts' => 3],
        //     2 => ['name' => 'Company Two', 'contacts' => 5],
        // ];
        $companies = $this->company->pluck();
        $contacts = $this->getContacts();
        // $contacts = []; // empty value
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create() {
        return view('contacts.create'); // contacts = the folder, create = the file
    }

    public function show($id) {
        $contacts = $this->getContacts();
        abort_if(!isset($contacts[$id]), 404); //Validation for data in array of getContacts();
        $contact = $contacts[$id];
        return view('contacts.show')->with('contact', $contact);
    }

    protected function getContacts() {
        return [
            1 => ['name' => 'Name 1', 'phone' => '1234567890'],
            2 => ['name' => 'Name 2', 'phone' => '2345678901'],
            3 => ['name' => 'Name 3', 'phone' => '3456789012'],
        ];
    }
}
