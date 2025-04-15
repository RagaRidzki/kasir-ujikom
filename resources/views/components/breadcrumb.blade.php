<div class="mb-6">
    <h1 class="text-2xl font-semibold text-blue-950">{{ $title }}</h1>
    <ul class="flex items-center text-sm">
        {{-- Foreach --}}
        @foreach ($paths as $path)
        <li class="mr-2">
            {{-- if --}}
            @if (!$loop->last)
            <a href="{{ $path['url'] }}" class="text-gray-400 hover:text-gray-600 font-medium">{{ $path['name'] }}</a>
            <li class="mr-2 text-gray-600 font-medium">/</li>
            {{-- else --}}
            @else
            <span class="text-gray-600 font-medium">{{ $path['name'] }}</span>
            @endif
        </li>
        @endforeach
    </ul>
</div>
