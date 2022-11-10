<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Repositories\CompanyRepository;
use Illuminate\Http\Request;
use App\Models\Contact;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    // protected $company;

    // Option A
    public function __construct()
    {
        $this->middleware('auth');
        $this->company = new CompanyRepository();
    }

    public function index() 
    {
        $companies = $this->company->pluck();
        // DB::enableQueryLog();
        $contacts = Contact::allowedTrash()
            ->allowedSorts(['first_name', 'last_name', 'email'], "-id")
            ->allowedFilters('company_id')
            ->allowedSearch('first_name', 'last_name', 'email')
            ->paginate(10);
        // dump(DB::getQueryLog());
        return view('contacts.index', compact('contacts', 'companies'));
    }

    public function create()
    {
        $companies = $this->company->pluck();
        $contact = new Contact();

        return view('contacts.create', compact('companies', 'contact')); // contacts = the folder, create = the file
    }

    public function store(ContactRequest $request)
    {     
        Contact::create($request->all());
        return redirect()->route('contacts.index')->with('message', 'Contact has been added successfully.');   
    }

    public function show(Contact $contact) // Implicit Binding
    {
        return view('contacts.show')->with('contact', $contact);
    }

    public function edit(Contact $contact) // Implicit Binding
    {
        $companies = $this->company->pluck();
        return view('contacts.edit', compact('companies', 'contact'));
    }

    public function update(ContactRequest $request, Contact $contact)
    {
        $contact->update($request->all());
        return redirect()->route('contacts.index')->with('message', 'Contact has been updated successfully.');
    }

    public function destroy(Contact $contact) // Implicit Binding
    {
        $contact->delete();
        $redirect = request()->query('redirect'); // 'redirect' = contacts.index from Contact Show View
        return ($redirect ? redirect()->route($redirect) : back())
            ->with('message', 'Contact has been moved to trash.')
            ->with('undoRoute',  $this->getUndoRoute('contacts.restore', $contact));
    }

    public function restore(Contact $contact) // Implicit Binding
    {
        $contact->restore();
        return back()
            ->with('message', 'Contact has been restored from trash.')
            ->with('undoRoute', $this->getUndoRoute('contacts.destroy', $contact));
    }

    protected function getUndoRoute($name, $resource)
    {
        return request()->missing('undo') ? route($name, [$resource->id, 'undo' => true]) : null;
    }

    public function forceDelete(Contact $contact) // Implicit Binding
    {
        $contact->forceDelete();
        return back()
            ->with('message', 'Contact has been removed permanently.');
    }
}
