<a  href="{{ isset($href) ? $href : '#'}}" 
    class="btn btn-{{ isset($className) ? $className : 'primary' }} btn-{{ isset($size) ? $size : 'md'}}">
    {{ $slot }}
</a>
