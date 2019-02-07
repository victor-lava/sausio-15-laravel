@extends('layouts/app')

@section('title', 'Welcome to Home')

@section('sidebar')
    @parent
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
                                </tr>
                              </thead>
                              <tbody>
                                @foreach($tables as $table)
                                <tr>
                                  <th scope="row">{{ $loop->iteration }}</th>
                                  <td>

                                          {{ $table->firstPlayer->name }}
                                          <span class="badge badge-pill badge-secondary">
                                              {{ $table->firstPlayer->statistic->getPlayed() }}
                                          </span>
                                      </br>

                                          {{ $table->secondPlayer->name }}
                                          <span class="badge badge-pill badge-secondary">
                                              {{ $table->secondPlayer->statistic->getPlayed() }}
                                          </span>

                                  </td>
                                  <td>{{ $table->duration }}</td>
                                  <td>
                                      @badge(['type' => $table->isOngoing() ? 'success' : 'warning' ,
                                              'text' => $table->getStatus() ])
                                      @endbadge
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
                                <li class="list-group-item">
                                    <a class="w-100 d-flex justify-content-between align-items-center" href="{{ route('user', ['id' => $user->id]) }}">

                                        <span>
                                            <img height="30" class="rounded-circle" src="{{ $user->gravatar_url }}" alt="Gravatar {{$user->username}}">
                                            {{ $user->name }}
                                        </span>
                                        <div>
                                            <span class="badge badge-pill badge-secondary">
                                                {{ $user->statistic->getPlayed() }}
                                            </span>
                                            @badge(['type' => $user->isOnline() ? 'success' : 'danger' ,
                                                    'text' => $user->getOnline()])
                                            @endbadge
                                        </div>
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
