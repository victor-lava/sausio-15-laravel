<a  href="{{ isset($href) ? $href : '#' }}"
    class="btn btn-primary{{ isset($size) ? " btn-$size" : ''}}">
    {{ $slot }}
</a>
