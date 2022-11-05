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
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create()
    {
        $companies = $this->company->pluck();
        return view('contacts.create', compact('companies')); // contacts = the folder, create = the file
    }

    public function store()
    {
        dd('Store');
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        return view('contacts.show')->with('contact', $contact);
    }
}
