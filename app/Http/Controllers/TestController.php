<?php

namespace App\Http\Controllers;

use App\Models\Course;

class TestController extends Controller
{
    // 1) Index: obtener todos los registros
    public function index()
    {
        $data = Course::orderByDesc('created_at')->get();
        return response()->json(['ok' => true, 'data' => $data]);
    }

    // 2) Create: crear uno (valores de ejemplo)
    public function create()
    {
        $course = Course::create([
            'code'        => 'CS' . mt_rand(100, 999),
            'name'        => 'Sample Course ' . mt_rand(1, 99),
            'description' => 'Auto-created for testing',
            'credits'     => 6,
            'hours'       => 64,
            'price'       => 199.99,
            'start_date'  => now()->toDateString(),
            'end_date'    => now()->addMonths(4)->toDateString(),
            'published'   => true,
            'options'     => ['mode' => 'online', 'lang' => 'en'],
            'user_id'     => null, // o un user_id válido si quieres enlazar
        ]);

        return response()->json(['ok' => true, 'created' => $course], 201);
    }

    // 3) Read: obtener uno por id
    public function read($id)
    {
        $course = Course::find($id);
        if (!$course) return response()->json(['ok'=>false,'error'=>'Not found'], 404);

        return response()->json(['ok'=>true,'data'=>$course]);
    }

    // 4) Update: actualizar uno por id (valores de ejemplo)
    public function update($id)
    {
        $course = Course::find($id);
        if (!$course) return response()->json(['ok'=>false,'error'=>'Not found'], 404);

        $course->update([
            'name'        => $course->name.' (Updated)',
            'description' => 'Updated at '.now(),
            'published'   => !$course->published,
        ]);

        return response()->json(['ok'=>true,'updated'=>$course]);
    }

    // 5) Delete: eliminar uno por id (Soft delete)
    public function delete($id)
    {
        $course = Course::find($id);
        if (!$course) return response()->json(['ok'=>false,'error'=>'Not found'], 404);

        $course->delete();
        return response()->json(['ok'=>true,'deleted_id'=>(int)$id]);
    }
}
