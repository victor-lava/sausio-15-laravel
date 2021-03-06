<div class="col-md-6 join-{{ $color }}">
  <div>
      <img class="checker" width="60" src="/img/{{ $color }}-checker.png">
      <h5>{{ $color }}</h5>
  </div>
  @if($isPlaying)
  <span class="badge badge-secondary">
    <i class="fa fa-user"></i>
    <span class="badge-name">{{ $player->name }}</span>
  </span></br>
  <!-- time should start -->
  <span class="btn btn-secondary">
    <i class="fa fa-clock-o"></i> 00:00
  </span>
  @elseif($player)
  <span class="badge badge-secondary">
    <i class="fa fa-user"></i>
    <span class="badge-name">{{ $player->name }}</span>
  </span></br>
  <button class="btn btn-secondary" onclick="game.leave('{{ $color }}')">Leave</button>
  @else
  <span class="badge badge-warning">
    <i class="fa fa-user"></i>
    Empty
  </span></br>
  <button class="btn btn-success" onclick="game.join('{{ $color }}')">Join</button>
  @endif
</div>
