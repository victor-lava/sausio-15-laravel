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
                        <div class="col-md-8">
                            <table class="table">
                                <thead>
                                <tr>
                                  <th scope="col">#</th>
                                  <th scope="col">Players</th>
                                  <th scope="col">Duration</th>
                                  <th scope="col">Status</th>
                                  <th scope="col">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($games as $game)
                                <tr>
                                  <th scope="row">{{ $loop->iteration }}</th>
                                  <td>
                                      @if($game->firstPlayer)
                                      <a href="{{ route('user', $game->firstPlayer->id) }}">
                                          {{ $game->firstPlayer->name }}
                                      </a>
                                      @component('components/badge',
                                                ['className' => 'light' ])
                                            {{ $game->firstPlayer->statistic->getPlayed() }}
                                      @endcomponent
                                      @endif
                                     </br>
                                     @if($game->secondPlayer)
                                         <a href="{{ route('user', $game->secondPlayer->id) }}">
                                             {{ $game->secondPlayer->name }}
                                         </a>
                                         @component('components/badge',
                                                   ['className' => 'light' ])
                                                   {{ $game->secondPlayer->statistic->getPlayed() }}
                                         @endcomponent
                                     @else
                                     --------------------
                                     @endif
                                  </td>
                                  <td>{{ $game->getDuration() }}</td>
                                  <td>

                                      @component('components/badge',
                                                ['className' => $game->badgeStatus()->className ])
                                                {{ $game->badgeStatus()->name }}
                                      @endcomponent
                                  </td>
                                  <td>
                                      @component('components/button',
                                                ['size' => 'lg',
                                                 'href' => route('game.show', $game->hash),
                                                'className' => $game->buttonStatus()->className])
                                                {{ $game->buttonStatus()->name }}
                                      @endcomponent
                                  </td>
                                </tr>
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
