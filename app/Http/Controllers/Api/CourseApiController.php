<?php

namespace App\Http\Controllers\Api;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class CourseApiController extends Controller
{
    public function index(Request $request)
    {
        $q = Course::with('roboticsKit')
            ->when($request->filled('kit_id'), fn($c) => $c->where('robotics_kit_id', $request->integer('kit_id')))
            ->when($request->filled('search'), function ($c) use ($request) {
                $s = '%' . $request->query('search') . '%';
                $c->where(function ($w) use ($s) {
                    $w->where('name', 'like', $s)
                        ->orWhere('code', 'like', $s)
                        ->orWhere('description', 'like', $s);
                });
            })
            ->orderByDesc('created_at');

        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        $data = $q->paginate($perPage)->through(function ($course) {
            return $this->serialize($course);
        });

        return $this->ok($data);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('courses', 'public');
        }
        $course = Course::create($data);
        return $this->ok($this->serialize($course->fresh('roboticsKit')), 201);
    }

    public function show($id)
    {
        $course = Course::with('roboticsKit')->find($id);
        if (!$course)
            return $this->fail('Not found', 404);
        return $this->ok($this->serialize($course));
    }

    public function update(Request $request, $id)
    {
        $course = Course::find($id);
        if (!$course)
            return $this->fail('Not found', 404);

        $data = $this->validateData($request, $course->id);
        if ($request->hasFile('image')) {
            if ($course->image_path && Storage::disk('public')->exists($course->image_path)) {
                Storage::disk('public')->delete($course->image_path);
            }
            $data['image_path'] = $request->file('image')->store('courses', 'public');
        }
        $course->update($data);
        return $this->ok($this->serialize($course->fresh('roboticsKit')));
    }

    public function destroy($id)
    {
        $course = Course::find($id);
        if (!$course)
            return $this->fail('Not found', 404);
        if ($course->image_path && Storage::disk('public')->exists($course->image_path)) {
            Storage::disk('public')->delete($course->image_path);
        }
        $course->delete();
        return $this->ok(['deleted_id' => (int) $id]);
    }

    protected function validateData(Request $request, $id = null): array
    {
        return $request->validate([
            'robotics_kit_id' => ['nullable', 'integer', 'exists:robotics_kits,id'],
            'code' => ['required', 'string', 'max:20', Rule::unique('courses', 'code')->ignore($id)],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'credits' => ['required', 'integer', 'min:0', 'max:255'],
            'hours' => ['required', 'integer', 'min:0', 'max:65535'],
            'price' => ['required', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'published' => ['boolean'],
            'user_id' => ['nullable', 'integer', 'exists:users,id'],
            'options' => ['nullable', 'array'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]);
    }

    protected function serialize(Course $c): array
    {
        return [
            'id' => $c->id,
            'code' => $c->code,
            'name' => $c->name,
            'description' => $c->description,
            'credits' => $c->credits,
            'hours' => $c->hours,
            'price' => (float) $c->price,
            'start_date' => optional($c->start_date)->toDateString(),
            'end_date' => optional($c->end_date)->toDateString(),
            'published' => (bool) $c->published,
            'robotics_kit_id' => $c->robotics_kit_id,
            'image_url' => method_exists($c, 'getImageUrlAttribute') ? $c->image_url : null,
            'created_at' => optional($c->created_at)->toIso8601String(),
            'updated_at' => optional($c->updated_at)->toIso8601String(),
            'robotics_kit' => $c->relationLoaded('roboticsKit') && $c->roboticsKit ? [
                'id' => $c->roboticsKit->id,
                'name' => $c->roboticsKit->name,
                'sku' => $c->roboticsKit->sku,
                'price' => (float) $c->roboticsKit->price,
            ] : null,
        ];
    }



    public function enroll(Request $request, Course $course)
    {
        $data = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'role' => ['nullable', 'string', 'max:30'],
        ]);

        $course->users()->syncWithoutDetaching([
            $data['user_id'] => ['role' => $data['role'] ?? null, 'enrolled_at' => now()],
        ]);

        return $this->ok(['course_id' => $course->id, 'user_id' => $data['user_id']]);
    }

    public function unenroll(Course $course, User $user)
    {
        $course->users()->detach($user->id);
        return $this->ok(['course_id' => $course->id, 'user_id' => $user->id, 'removed' => true]);
    }

}
