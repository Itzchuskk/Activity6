<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\RoboticsKit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('roboticsKit')->latest()->paginate(12);
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $kits = RoboticsKit::orderBy('name')->pluck('name', 'id');
        $course = new Course();
        return view('courses.create', compact('course','kits'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('courses', 'public');
        }
        $course = Course::create($data);
        return redirect()->route('courses.show', $course)->with('status','Course created');
    }

    public function show(Course $course)
    {
        $course->load('roboticsKit');
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        $kits = RoboticsKit::orderBy('name')->pluck('name', 'id');
        return view('courses.edit', compact('course','kits'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $this->validateData($request, $course->id);
        if ($request->hasFile('image')) {
            if ($course->image_path && Storage::disk('public')->exists($course->image_path)) {
                Storage::disk('public')->delete($course->image_path);
            }
            $data['image_path'] = $request->file('image')->store('courses', 'public');
        }
        $course->update($data);
        return redirect()->route('courses.show', $course)->with('status','Course updated');
    }

    public function destroy(Course $course)
    {
        if ($course->image_path && Storage::disk('public')->exists($course->image_path)) {
            Storage::disk('public')->delete($course->image_path);
        }
        $course->delete();
        return redirect()->route('courses.index')->with('status','Course deleted');
    }

    protected function validateData(Request $request, $id = null): array
    {
        return $request->validate([
            'robotics_kit_id' => ['nullable','integer','exists:robotics_kits,id'],
            'code'            => ['required','string','max:20', Rule::unique('courses','code')->ignore($id)],
            'name'            => ['required','string','max:100'],
            'description'     => ['nullable','string'],
            'credits'         => ['required','integer','min:0','max:255'],
            'hours'           => ['required','integer','min:0','max:65535'],
            'price'           => ['required','numeric','min:0'],
            'start_date'      => ['nullable','date'],
            'end_date'        => ['nullable','date','after_or_equal:start_date'],
            'published'       => ['boolean'],
            'user_id'         => ['nullable','integer','exists:users,id'],
            'options'         => ['nullable','array'],
            'image'           => ['nullable','image','mimes:jpg,jpeg,png,webp','max:5120'],
        ]);
    }
}
