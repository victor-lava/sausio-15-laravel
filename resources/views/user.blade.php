@extends('layouts/app')

@section('title', $user->name . ' #' . $user->id)

@section('sidebar')
    @parent
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ route('user', ['id', $user->id]) }}">  {{ $user->name . ' #' . $user->id }} </a>
    </li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header flex">
                    <img class="ml-auto" src="{{ $user->gravatar_url }}" alt="">
                    <span>{{ $user->name }}</span>
                </div>
                <div class="card-body">
                <ul>
                        <li>E-mail: {{ $user->email }}</li>
                        <li>Registered: {{ $user->created_at }}</li>
                        <li>Online: {{ $user->online === 1 ? 'Yes' : 'No' }}</li>
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