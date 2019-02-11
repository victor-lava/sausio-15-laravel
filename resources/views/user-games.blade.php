@extends('pages/user')

@section('title', $user->name . ' #' . $user->id)

@section('sidebar')
    @parent
    <li class="breadcrumb-item" aria-current="page">
        <a href="{{ route('user.games', $user->id) }}"> Games </a>
    </li>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header flex">
                    <span>{{ $user->name }}</span>
                    <img class="ml-auto float-right" src="{{ $user->gravatar_url }}" alt="">
                </div>

                <div class="card-body">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Date</th>
                          <th scope="col">Players</th>
                          <th scope="col">Result</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($user->histories as $history)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $history->created_at}}</td>
                              <td>
                                  <a href="{{ route('user', $history->game->firstPlayer->id) }}">
                                      {{ $history->game->firstPlayer->name }}
                                  </a> -
                                  <a href="{{ route('user', $history->game->secondPlayer->id) }}">
                                      {{ $history->game->secondPlayer->name }}
                                  </a>
                              </td>
                          <td>{{ $history->getStatus() }}</td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection