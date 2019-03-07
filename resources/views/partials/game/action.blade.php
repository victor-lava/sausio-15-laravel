<div id="join-game" class="row">
  @component('partials/game/action-checker', ['color' => 'white',
                                              'player' => $firstPlayer,
                                              'isPlaying' => $isPlaying])
  @endcomponent

  @component('partials/game/action-checker', ['color' => 'black',
                                              'player' => $secondPlayer,
                                              'isPlaying' => $isPlaying])
  @endcomponent
</div>
