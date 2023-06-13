@extends('layouts.front')

@section('title', 'Category')

@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>All categories</h2>
                    <div class="row">
                        @foreach ($categories as $category)
                            <div class="col-md-4 mb-3">
                                <a href="{{ url('category/' . $category->slug) }}">
                                    <div class="card height-img">
                                        <img src="{{ $category->image }}" alt="Category image" class="d-block w-100" style="height: 350px;">
                                        {{-- <img src="{{ asset('assets/uploads/category/' . $category->image) }}" alt="Category image" class="d-block w-100" style="height: 350px;"> --}}
                                        <div class="card-body">
                                            <h5>{{ $category->title }}</h5>
                                            <p>{{ $category->description }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

@endsection
