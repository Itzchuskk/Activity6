<?php

namespace App\Http\Controllers\Api;

use App\Models\RoboticsKit;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoboticsKitApiController extends Controller
{
    public function index(Request $request)
    {
        $q = RoboticsKit::query()
            ->when($request->filled('search'), function ($c) use ($request) {
                $s = '%'.$request->query('search').'%';
                $c->where(function ($w) use ($s) {
                    $w->where('name', 'like', $s)
                      ->orWhere('sku', 'like', $s)
                      ->orWhere('description', 'like', $s);
                });
            })
            ->orderBy('name');

        $perPage = min(max((int) $request->query('per_page', 15), 1), 100);
        $data = $q->paginate($perPage);

        return $this->ok($data);
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $kit = RoboticsKit::create($data);
        return $this->ok($kit, 201);
    }

    public function show($id)
    {
        $kit = RoboticsKit::find($id);
        if (!$kit) return $this->fail('Not found', 404);
        return $this->ok($kit);
    }

    public function update(Request $request, $id)
    {
        $kit = RoboticsKit::find($id);
        if (!$kit) return $this->fail('Not found', 404);
        $data = $this->validateData($request, $kit->id);
        $kit->update($data);
        return $this->ok($kit);
    }

    public function destroy($id)
    {
        $kit = RoboticsKit::find($id);
        if (!$kit) return $this->fail('Not found', 404);
        $kit->delete();
        return $this->ok(['deleted_id' => (int) $id]);
    }

    protected function validateData(Request $request, $id = null): array
    {
        return $request->validate([
            'name'        => ['required','string','max:120'],
            'sku'         => ['required','string','max:40', Rule::unique('robotics_kits','sku')->ignore($id)],
            'description' => ['nullable','string'],
            'price'       => ['required','numeric','min:0'],
        ]);
    }
}
