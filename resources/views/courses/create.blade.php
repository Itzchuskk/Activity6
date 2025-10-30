@extends('layouts.app')
@section('title','New Course')
@section('content')
  <h1 class="text-2xl font-semibold mb-4">New Course</h1>
  <form method="POST" action="{{ route('courses.store') }}" enctype="multipart/form-data">
    @include('courses._form')
  </form>
@endsection
