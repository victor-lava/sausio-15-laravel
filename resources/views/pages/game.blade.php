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
        <div class="col-md-8">
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

                  <div id="checkers"
                      class="table"
                      data-hash="{{ $hash }}"
                      @if($firstPlayer)
                      data-first="{{ $firstPlayer->id }}"
                      @endif
                      @if($secondPlayer)
                      data-second="{{ $secondPlayer->id }}"
                      @endif
                      @if(isset($myself))
                      data-token="{{ $token }}"
                      data-myself="{{ $myself }}"
                      @endif
                  >

                    @foreach($squares as $squareLine)
                      @php $y = $loop->index @endphp
                    <div class="checker-row">
                      @foreach($squareLine as $squareColumn)
                        @php $x = $loop->index @endphp
                      <div id="{{ $squareColumn['id'] }}"
                           class="checker-col checker-col-{{ $squareColumn['color'] }}"
                           @if($squareColumn['color'] === 'black' && $isLogged === true && $isPlaying === true && ($squareColumn['checker'] !== false && $squareColumn['checker']->color === $color) || $squareColumn['checker'] === false)
                           onclick="selectChecker(this)"
                           @endif
                           data-x="{{ $x }}"
                           data-y="{{ $y }}">
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
        <div class="col-md-4">
          @if(!Auth::guest())
          <div id="join-game" class="row">
            <div class="col-md-6 join-white">
              @if($firstPlayer)
              <span class="badge badge-success">{{ $firstPlayer->name }}</span></br>
              @else
              <span class="badge badge-warning">Empty</span></br>
              @endif
              <button class="btn btn-secondary" onclick="joinGame('white',
                                                                {{ Auth::user()->id }},
                                                                joinGameOnDOM)">Join White</button>
            </div>
            <div class="col-md-6 join-black">
              @if($secondPlayer)
              <span class="badge badge-success">{{ $secondPlayer->name }}</span></br>
              @else
              <span class="badge badge-warning">Empty</span></br>
              @endif
              <button class="btn btn-dark" onclick="joinGame('black',
                                                          {{ Auth::user()->id }},
                                                          joinGameOnDOM)">Join Black</button>
            </div>
          </div>
          @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {

  let first = window.table.dataset.first,
      second = window.table.dataset.second,
      myself = false;

    if(window.table.dataset.myself) { myself = window.table.dataset.myself; }

    console.log(myself);

  var pusher = new Pusher('a4784a4451c0de4372ac', {
    cluster: 'eu',
    forceTLS: true
  });
  var channel = pusher.subscribe(window.table.dataset.hash);

  if(myself === false) { // watching, both channels
    channel.bind('move-checker-'+first, function(response) {
      window.moveCheckerOnDOM(response, true);
    })

    channel.bind('move-checker-'+second, function(response) {
      window.moveCheckerOnDOM(response, true);
    })

  } else { // playing, watching only one channel

    let enemy;

    if(myself === first) { enemy = second; }
    else { enemy = first; }

    channel.bind('move-checker-'+enemy, function(response) {
      // alert(JSON.stringify(response));
      console.log(response);
      window.moveCheckerOnDOM(response, true);
    })
  }

  /* {
"data": {
"data": {
"enemy":false,
"from": {"x":2,"y":5}, "to": {"x":3,"y":4}
}
}
} */
  // alert('sdf');
})
</script>
@endsection
