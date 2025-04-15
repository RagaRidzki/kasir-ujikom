<a href="{{ $href ?? '#' }}" class="py-2 px-4 bg-{{ $color ?? 'gray' }}-500 hover:bg-{{ $color ?? 'gray' }}-700 shadow-sm shadow-{{ $shadow ?? 'gray' }}-500 text-white rounded-md"> 
    {{ $slot }}
</a>