@props(['label'=>'','value'=>0,'hint'=>null])

<div class="rounded-2xl border border-gray-200 bg-white p-4">
  <div class="text-sm text-gray-600">{{ $label }}</div>
  <div class="mt-1 text-2xl font-semibold">{{ number_format($value) }}</div>
  @if($hint)
    <div class="mt-2 text-xs text-gray-500">{{ $hint }}</div>
  @endif
</div>
