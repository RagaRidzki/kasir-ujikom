<button type="{{ $type ?? 'button' }}" class="px-4 py-2 rounded-md text-white bg-{{ $color ?? 'blue' }}-500 hover:bg-{{ $color ?? 'blue' }}-700 shadow-md shadow-{{ $shadow ?? 'blue' }}-500 flex items-center gap-2 ">
    {{ $slot }}
</button>
