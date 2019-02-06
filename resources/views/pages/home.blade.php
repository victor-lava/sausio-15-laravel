@extends('layouts/app')

@section('title', 'Welcome to Home')

@section('sidebar')
    @parent
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ route('home') }}">Home</a>
    </li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4 ml-auto">
                            <!-- Users -->
                            <ul class="list-group">
                            @foreach($users as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('user', ['id' => $user->id]) }}">
                                        {{ $user->name }}
                                        <span class="badge badge-primary badge-pill">
                                            <img height="30" src="{{ $user->gravatar_url }}" alt="Gravatar {{$user->username}}">
                                    </span>
                                    </a>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
