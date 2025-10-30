@props(['title' => null, 'footer' => null])

<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow border']) }}>
  @if($title)
    <div class="px-4 py-3 border-b font-semibold">{{ $title }}</div>
  @endif

  <div class="p-4">
    {{ $slot }}
  </div>

  @if($footer)
    <div class="px-4 py-3 border-t text-sm text-gray-600">
      {{ $footer }}
    </div>
  @endif
</div>
