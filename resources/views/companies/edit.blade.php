@extends('layouts.main')

@section('content')
  <main class="py-5">
    <div class="container">
      <div class="row justify-content-md-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header card-title">
              <strong>Edit Company</strong>
            </div>           
            <div class="card-body">
              <form action="{{ route('companies.update', $company->id) }}" method="POST">
                {{-- @csrf OR <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
                @csrf
                @method('put')
                @include('companies._form')
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection

@section('title', 'Contact App | Edit company')