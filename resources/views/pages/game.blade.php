@extends('layouts/app')

@section('title', 'Game')

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

                  <div class="table">

                    @foreach($squares as $squareLine)
                      @php $y = $loop->index @endphp
                    <div class="checker-row">
                      @foreach($squareLine as $squareColumn)
                        @php $x = $loop->index @endphp
                      <div id="{{ $squareColumn['id'] }}"
                           class="checker-col checker-col-{{ $squareColumn['color'] }}"
                           @if($squareColumn['color'] === 'black')
                           onclick="selectChecker(this)"
                           @endif>
                           <!-- <span>{{ $squareColumn['id'] }}</span> -->
                           @if($squareColumn['color'] === 'black')
                           <span>
                            {{ $x }} : {{ $y }}
                           </span>
                           @endif

                           @if($squareColumn['checker'] !== false)
                           <img class="checker"
                                data-x="{{ $squareColumn['checker']->x }}"
                                data-y="{{ $squareColumn['checker']->y }}"
                                src="{{ asset('/img/'. $squareColumn['checker']->colorName().'-checker.png') }}">
                          @endif
                      </div>
                      @endforeach
                    </div>
                    @endforeach
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
