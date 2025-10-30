@extends('layouts.app')
@section('title', $course->name)
@section('content')
  <x-card :title="$course->name" :footer="'Code: ' . $course->code">
    @if($course->image_url)
      <img src="{{ $course->image_url }}" alt="" class="mb-4 rounded max-h-64 w-auto">
    @endif
    <p class="mb-3">{{ $course->description }}</p>
    <dl class="text-sm grid grid-cols-2 gap-2">
      <div class="mt-4 flex gap-2">
        <x-button as="a" variant="primary" :href="route('courses.edit', $course)">Edit</x-button>
        <x-button as="a" variant="secondary" :href="route('courses.index')">Back</x-button>
        {{-- Botón CREATE extra --}}
        <x-button as="a" :href="route('courses.create')">New Course</x-button>
      </div>

      <div>
        <dt class="font-semibold">Credits</dt>
        <dd>{{ $course->credits }}</dd>
      </div>
      <div>
        <dt class="font-semibold">Hours</dt>
        <dd>{{ $course->hours }}</dd>
      </div>
      <div>
        <dt class="font-semibold">Price</dt>
        <dd>${{ number_format($course->price, 2) }}</dd>
      </div>
      <div>
        <dt class="font-semibold">Kit</dt>
        <dd>{{ optional($course->roboticsKit)->name ?? '—' }}</dd>
      </div>
      <div>
        <dt class="font-semibold">Start</dt>
        <dd>{{ optional($course->start_date)->format('Y-m-d') }}</dd>
      </div>
      <div>
        <dt class="font-semibold">End</dt>
        <dd>{{ optional($course->end_date)->format('Y-m-d') }}</dd>
      </div>
      <div>
        <dt class="font-semibold">Published</dt>
        <dd>{{ $course->published ? 'Yes' : 'No' }}</dd>
      </div>
    </dl>
    <div class="mt-4 flex gap-2">
      <x-button as="a" variant="primary" :href="route('courses.edit', $course)">Edit</x-button>
      <x-button as="a" variant="secondary" :href="route('courses.index')">Back</x-button>
    </div>
  </x-card>
@endsection