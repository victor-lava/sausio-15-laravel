@extends('layouts/app')

@section('title', '#'.$game->id)

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <div id="game-window">
                        @foreach($table as $row)
                            <div class="row-checker">
                                @foreach($row as $col)
                                <div    id="{{ $col['position'] }}"
                                        class="col-checker col-{{ $col['color'] === 0 ? 'white' : 'black' }}"
                                        onclick="selectChecker(this)">
                                    <span>{{ $col['position'] }}</span>
                                    @if($col['checker'])
                                        @php $color = $col['checker']->color === 0 ? 'white' : 'black'  @endphp
                                        <img    data-x="{{ $col['checker']->x }}"
                                                data-y="{{ $col['checker']->y }}"
                                                class="checker"
                                                src="{{ asset("img/$color-checker.png") }}">
                                    @endif
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
