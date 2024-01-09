@extends('layouts.admin')

@section('title', 'Registered Users')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>User Details
                        <a href="{{ route('dashboard.users') }}" class="btn btn-primary btn-sm float-end">Back</a>
                    </h1>
                    <div class="col-lg-12 hr-line"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mt-3">
                            <label for="name">Name</label>
                            <div class="p-2 border">{{ $user->name }}</div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="email">Email</label>
                            <div class="p-2 border">{{ $user->email }}</div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="phone">Phone</label>
                            <div class="p-2 border">{{ $user->phone ?? '-' }}</div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="cpf_cnpj">CPF/CNPJ</label>
                            <div class="p-2 border">{{ $user->cpf }}</div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="state">State</label>
                            <div class="p-2 border">{{ $user->state }}</div>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="city">City</label>
                            <div class="p-2 border">{{ $user->city }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
