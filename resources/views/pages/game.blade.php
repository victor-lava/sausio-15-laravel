@extends('layouts/app')

@section('title', 'Welcome to Home')

@section('sidebar')
    @parent
    <li class="breadcrumb-item" aria-current="page">
        {{-- <a href="{{ route('game.show') }}">Game</a>--}}
    </li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Game</div>

                <div class="card-body">

                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
