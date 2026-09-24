@props(['title','value','icon'])

<div class="bg-white rounded-2xl shadow-lg p-6 border-t-4 border-red-600">

<div class="flex justify-between items-center">

<div>

<p class="text-gray-500">
{{ $title }}
</p>

<h2 class="text-5xl font-bold text-black mt-2">
{{ $value }}
</h2>

</div>

<div class="text-red-600">

{!! $icon !!}

</div>

</div>

</div>