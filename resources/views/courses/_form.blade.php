@csrf
<div class="grid md:grid-cols-2 gap-4">
  <div>
    <x-input-label for="robotics_kit_id" value="Robotics Kit (FK)" />
    <select id="robotics_kit_id" name="robotics_kit_id"
            class="mt-1 block w-full border rounded-md p-2">
      <option value="">-- None --</option>
      @foreach($kits as $id => $label)
        <option value="{{ $id }}" @selected(old('robotics_kit_id', $course->robotics_kit_id)==$id)>
          {{ $label }}
        </option>
      @endforeach
    </select>
    <x-input-error :messages="$errors->get('robotics_kit_id')" class="mt-1" />
  </div>

  <div>
    <x-input-label for="code" value="Code" />
    <x-text-input id="code" name="code" type="text" class="mt-1 block w-full"
      :value="old('code', $course->code)" required maxlength="20"/>
    <x-input-error :messages="$errors->get('code')" class="mt-1" />
  </div>

  <div>
    <x-input-label for="name" value="Name" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
      :value="old('name', $course->name)" required maxlength="100"/>
    <x-input-error :messages="$errors->get('name')" class="mt-1" />
  </div>

  <div>
    <x-input-label for="credits" value="Credits" />
    <x-text-input id="credits" name="credits" type="number" class="mt-1 block w-full"
      :value="old('credits', $course->credits ?? 0)" min="0" max="255" required />
    <x-input-error :messages="$errors->get('credits')" class="mt-1" />
  </div>

  <div>
    <x-input-label for="hours" value="Hours" />
    <x-text-input id="hours" name="hours" type="number" class="mt-1 block w-full"
      :value="old('hours', $course->hours ?? 0)" min="0" max="65535" required />
    <x-input-error :messages="$errors->get('hours')" class="mt-1" />
  </div>

  <div>
    <x-input-label for="price" value="Price" />
    <x-text-input id="price" name="price" type="number" step="0.01" class="mt-1 block w-full"
      :value="old('price', $course->price ?? 0)" min="0" required />
    <x-input-error :messages="$errors->get('price')" class="mt-1" />
  </div>

  <div>
    <x-input-label for="start_date" value="Start date" />
    <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full"
      :value="old('start_date', optional($course->start_date)->format('Y-m-d'))" />
    <x-input-error :messages="$errors->get('start_date')" class="mt-1" />
  </div>

  <div>
    <x-input-label for="end_date" value="End date" />
    <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full"
      :value="old('end_date', optional($course->end_date)->format('Y-m-d'))" />
    <x-input-error :messages="$errors->get('end_date')" class="mt-1" />
  </div>

  <div class="md:col-span-2">
    <x-input-label for="description" value="Description" />
    <textarea id="description" name="description" rows="4"
      class="mt-1 block w-full border rounded-md p-2">{{ old('description', $course->description) }}</textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-1" />
  </div>

  <div class="md:col-span-2">
    <x-input-label for="image" value="Course image" />
    <input id="image" name="image" type="file" accept="image/*" class="mt-1 block w-full border rounded-md p-2">
    <x-input-error :messages="$errors->get('image')" class="mt-1" />
    @if($course->image_url)
      <div class="mt-2">
        <img src="{{ $course->image_url }}" alt="Course image" class="max-h-40 rounded">
      </div>
    @endif
  </div>
</div>

<div class="flex items-center gap-3 mt-6">
  <label class="inline-flex items-center gap-2">
    <input type="checkbox" name="published" value="1" @checked(old('published', $course->published))>
    <span>Published</span>
  </label>
  <x-button type="submit">Save</x-button>
  <x-button as="a" variant="secondary" :href="route('courses.index')">Back</x-button>
</div>
