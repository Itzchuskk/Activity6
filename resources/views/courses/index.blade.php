@extends('layouts.app')
@section('title', 'Courses')
@section('content')
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Courses</h1>
    <x-button as="a" :href="route('courses.create')">New Course</x-button>
  </div>
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($courses as $course)
      <x-card :title="$course->name" :footer="'Code: ' . $course->code">
        @if($course->image_url)
          <img src="{{ $course->image_url }}" alt="" class="mb-3 rounded max-h-40 w-auto">
        @endif
        <p class="mb-3">{{ Str::limit($course->description, 140) }}</p>
        <p class="text-sm mb-2">
          Kit: <strong>{{ optional($course->roboticsKit)->name ?? '—' }}</strong>
        </p>
        <div class="flex gap-2">
          <x-button variant="secondary" as="a" :href="route('courses.show', $course)">View</x-button>
          <x-button variant="primary" as="a" :href="route('courses.edit', $course)">Edit</x-button>
          <form method="POST" action="{{ route('courses.destroy', $course) }}"
            onsubmit="return confirm('Delete this course?')">
            @csrf @method('DELETE')
            <x-button variant="danger" type="submit">Delete</x-button>
          </form>
        </div>
      </x-card>
    @empty
      <x-card>No courses yet.</x-card>
    @endforelse
  </div>
  <div class="mt-6">{{ $courses->links() }}</div>
@endsection