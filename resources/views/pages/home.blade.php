@extends('layouts/app')

@section('title', 'Welcome to Home')

@section('sidebar')
    @parent
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ route('home') }}">Home</a>
    </li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-12 col-lg-8">
                            <table id="games" class="table table-hover">
                                <thead>
                                <tr>
                                  <th scope="col">Players</th>
                                  <th scope="col">Duration</th>
                                  <th scope="col">Status</th>
                                  <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($games as $game)
                                  @component('partials/games/row', ['game' => $game])
                                  @endcomponent
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4 ml-auto">
                            <!-- Users -->
                            <ul class="list-group">
                            @foreach($users as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="{{ route('user', ['id' => $user->id]) }}">
                                        <span class="badge badge-primary badge-pill">
                                            <img height="30" src="{{ $user->gravatar_url }}" alt="Gravatar {{$user->name}}">
                                    </span>
                                    {{ $user->name }}
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

@section('scripts')
<script src="https://js.pusher.com/4.4/pusher.min.js"></script>
<script type="text/javascript">
document.addEventListener('DOMContentLoaded', function() {

  let games = new Channel('GameList');

      games.event('created', (response) => {

        let table = document.querySelector('#games'),
            tbody = table.querySelector('tbody');

            console.log(response);

            tbody.insertAdjacentHTML('afterbegin', response.html);

      });

});
</script>
@endsection
