@extends('layouts/app')

@section('title', $user->name . ' #' . $user->id)

@section('sidebar')
    @parent
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ route('user', $user->id) }}">  {{ $user->name . ' #' . $user->id }} </a>
    </li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span>{{ $user->name }}</span>
                    <img class="rounded-circle" src="{{ $user->gravatar_url }}" alt="">
                </div>

                <div class="card-body">

                    <ul>
                        <li>E-mail: {{ $user->email }}</li>
                        <li>Registered: {{ $user->created_at }}</li>
                        <li>
                            Online:
                            @component('components/badge', ['className' => $user->online === 1 ? 'badge-success' : 'badge-danger' ,
                                                            'text' => $user->online === 1 ? 'Online' : 'Offline'])
                            @endcomponent
                        </li>
                        <li>Location: {{ $user->location }}</li>
                    </ul>

                    <h3>Total: {{ $user->statistic->getPlayed() }}</h3>
                    <ul>
                        <li>Wins: {{ $user->statistic->wins }}</li>
                        <li>Losses: {{ $user->statistic->losses }}</li>
                        <li>Draws: {{ $user->statistic->draws }}</li>
                        <li>Abandoned: {{ $user->statistic->abandoned }}</li>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
