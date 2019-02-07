@extends('layouts/app')

@section('title', '#'.$game->id)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <div class="table">
                        @foreach($table as $row)
                            <div class="row-checker">
                                @foreach($row as $col)
                                <div id="{{ $col['position'] }}" class="col-checker col-{{ $col['color'] }}">
                                    <span>{{ $col['position'] }}</span>
                                </div>
                                @endforeach
                            </div class="row-checker">
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/checker.css') }}">
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/checker.js') }}"></script>
@endsection
