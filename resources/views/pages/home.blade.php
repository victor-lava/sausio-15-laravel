@extends('layouts/app')

@section('title', 'Welcome to Home')

@section('sidebar')
    @parent
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
                                <li class="list-group-item">
                                    <a class="w-100 d-flex justify-content-between align-items-center" href="{{ route('user', ['id' => $user->id]) }}">

                                        <span>
                                            <img height="30" class="rounded-circle" src="{{ $user->gravatar_url }}" alt="Gravatar {{$user->username}}">
                                            {{ $user->name }}
                                        </span>
                                        <div>
                                            <span class="badge badge-pill badge-secondary">
                                                {{ $user->statistic->getPlayed() }}
                                            </span>
                                            @component('components/badge', ['className' => $user->online === 1 ? 'badge-success' : 'badge-danger' ,
                                                                            'text' => $user->online === 1 ? 'Online' : 'Offline'])
                                            @endcomponent
                                        </div>
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
