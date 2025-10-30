@props(['variant'=>'primary','size'=>'md','type'=>'button','as'=>null,'href'=>null])

@php
$base = 'inline-flex items-center justify-center rounded-md font-medium transition focus:outline-none focus:ring disabled:opacity-50 disabled:cursor-not-allowed';

$variants = [
  'primary'   => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-400',
  'secondary' => 'bg-gray-200 text-gray-900 hover:bg-gray-300 focus:ring-gray-300',
  'danger'    => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-400',
  'link'      => 'bg-transparent underline text-blue-700 hover:text-blue-800 focus:ring-blue-300',
];

$sizes = [
  'sm' => 'px-3 py-1.5 text-sm',
  'md' => 'px-4 py-2 text-base',
  'lg' => 'px-5 py-2.5 text-lg',
];


$variantClass = $variants[$variant] ?? $variants['primary'];
$sizeClass    = $sizes[$size] ?? $sizes['md'];

$classes = trim($base . ' ' . $variantClass . ' ' . $sizeClass);
@endphp

@if($as === 'a')
  <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
  </a>
@else
  <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
  </button>
@endif
