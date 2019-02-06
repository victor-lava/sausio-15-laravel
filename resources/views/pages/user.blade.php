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
                    <span>{{ $user->name }}</span>
                    <img class="ml-auto" src="{{ $user->gravatar_url }}" alt="">
                </div>

                <div class="card-body">


                </div>
            </div>
        </div>
    </div>
</div>
@endsection
