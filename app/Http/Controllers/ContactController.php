<?php

namespace App\Http\Controllers;

use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactController extends Controller
{
    // protected $company;

    // Option A
    public function __construct()
    {
        $this->company = new CompanyRepository();
    }

    // Option B
    // public function __construct(CompanyRepository $company)
    // {
    //     $this->company = $company;
    // }

    // Option C
    // public function __construct(protected CompanyRepository $company)
    // {
    // }

    public function index() 
    {
        $companies = $this->company->pluck();
        $contacts = Contact::latest()->where(function($query) {
            if ($companyId = request()->query('company_id')) {
                $query->where('company_id', $companyId);
            }
        })->paginate(10);
        // $contactsCollection = Contact::latest()->get();
        // $perPage = 10;
        // $currentPage = request()->query('page', 1);
        // $items = $contactsCollection->slice(($currentPage * $perPage) - $perPage, $perPage);
        // $total = $contactsCollection->count();
        // $contacts = new LengthAwarePaginator($items, $total, $perPage, $currentPage, [
        //     'path' => request()->url(),
        //     'query' => request()->query(),
        // ]); Manual Pagination
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create()
    {
        return view('contacts.create'); // contacts = the folder, create = the file
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.show')->with('contact', $contact);
    }
}
