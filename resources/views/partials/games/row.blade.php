<tr @if(isset($game->broadcasted)) class="flash animated" @endif>
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
