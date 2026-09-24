@props(['href', 'active' => false, 'icon'])

<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' => 'flex items-center gap-3 px-6 py-4 transition duration-200 ' .
        ($active
            ? 'bg-red-600 text-white border-l-4 border-white'
            : 'text-gray-300 hover:bg-red-600 hover:text-white')
    ]) }}>

    {!! $icon !!}

    <span class="font-medium">{{ $slot }}</span>

</a>