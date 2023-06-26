@extends('layouts.admin')

@section('title', 'Registered Users')

@section('content')
    <div class="card">
        <div class="card-header">
            <h1>Registered Users</h1>
        </div>
        <div class="card-body">
            <table class="table table-stripped table-hover">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Phone</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="text-center align-middle">{{ $user->id }}</td>
                            <td class="text-center align-middle">{{ $user->name }}</td>
                            <td class="text-center align-middle">{{ $user->email }}</td>
                            <td class="text-center align-middle">{{ $user->phone }}</td>
                            <td class="text-center align-middle">
                                <a href="{{ route('dashboard.viewUser', ['id' => $user->id]) }}" class="btn btn-primary" type="button"><i class="fa fa-eye"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <div class="text-center" colspan="5">
                                <img src="{{ asset('assets/logging-off.svg', true) }}" alt="Nothing to see here..." width="200px">
                                <h2 class="text-center">Nothing to see here...</h2>
                            </div>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
