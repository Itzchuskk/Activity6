@extends('layouts.app')

@section('title','Robotics Kits')

@section('content')
  <div class="flex justify-between items-center mb-4">
    <h1 class="text-2xl font-semibold">Robotics Kits</h1>
    <x-button variant="primary" as="a" href="#">New Kit</x-button>
  </div>

  @php
    $kits = [
      ['name'=>'Starter Bot','desc'=>'Entry-level kit with sensors and basic motors.'],
      ['name'=>'AI Rover','desc'=>'Camera module and edge AI samples.'],
      ['name'=>'Arm Pro','desc'=>'6-DOF robotic arm with gripper.'],
    ];
  @endphp

  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($kits as $kit)
      <x-card :title="$kit['name']" :footer="'Demo item'">
        <p class="mb-3">{{ $kit['desc'] }}</p>
        <div class="flex gap-2">
          <x-button variant="secondary" as="a" href="#">Details</x-button>
          <x-button variant="primary" as="a" href="#">Edit</x-button>
        </div>
      </x-card>
    @endforeach
  </div>
@endsection
