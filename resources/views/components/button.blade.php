@if($type !== 'logout')
<a href="#" class="btn btn-primary {{ $size === 'lg' ? 'btn-lg' : ''}}">
    {{ $text }}
</a>
@else
<a class="btn btn-primary {{ $size === 'lg' ? 'btn-lg' : ''}}" href="{{ route('logout') }}"
   onclick="event.preventDefault();
                 document.getElementById('logout-form').submit();">
    {{ $text }}
</a>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
@endif
