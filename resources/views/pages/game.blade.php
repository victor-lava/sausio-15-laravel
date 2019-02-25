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
                <div class="card-header">Game #{{ $hash }}</div>

                <div class="card-body">
                  <div class="row">
                    <div  class="col-md-6 table"
                          data-api="{{ url('/api/') }}"
                          data-hash="{{ $hash }}"
                          @if($authHash)
                          data-auth="{{ $authHash }}"
                          @endif>

                      @foreach($squares as $squareLine)
                        @php $y = $loop->index @endphp
                      <div class="checker-row">
                        @foreach($squareLine as $squareColumn)
                          @php $x = $loop->index @endphp
                        <div id="{{ $squareColumn['id'] }}"
                             class="checker-col checker-col-{{ $squareColumn['color'] }}{{ $squareColumn['clickable'] && $squareColumn['checker'] !== false ? ' checker-col-clickable' : '' }}"
                             data-x="{{ $x }}"
                             data-y="{{ $y }}"
                             @if($squareColumn['color'] === 'black' && $squareColumn['clickable'])
                             onclick="checker.select(this)"
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


                    <div class="col-md-4">
                      <h2>Status: <span class="badge badge-warning">Waiting</span></h2>
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-6">
                            #1 White<br>
                            <a href="#" class="btn btn-light">Join</a>
                            <br>
                            <span class="badge badge-secondary">empty</span>
                          </div>
                          <div class="col-md-6">
                            #2 Black<br>
                            <a href="#" class="btn btn-dark">Join</a>
                            <br>
                            <span class="badge badge-secondary">empty</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
