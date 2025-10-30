@extends('layouts.app')
@section('title','Edit Course')
@section('content')
  <h1 class="text-2xl font-semibold mb-4">Edit Course</h1>
  <form method="POST" action="{{ route('courses.update', $course) }}" enctype="multipart/form-data">
    @method('PUT')
    @include('courses._form')
  </form>
@endsection
