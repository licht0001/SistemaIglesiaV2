<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ActivityType;
use Illuminate\Http\Request;

class ActivityTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityType::query()->orderBy('sort_order')->orderBy('label');
        if ($request->boolean('active')) {
            $query->where('is_active', true);
        }
        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:100'],
            'value' => ['required', 'string', 'max:100', 'regex:/^[a-z0-9_\-]+$/', 'unique:activity_types,value'],
            'is_active' => ['sometimes', 'boolean'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
        ]);

        $type = ActivityType::create($data);
        return response()->json($type, 201);
    }

    public function update(Request $request, ActivityType $activityType)
    {
        $data = $request->validate([
            'label' => ['sometimes', 'string', 'max:100'],
            'value' => ['sometimes', 'string', 'max:100', 'regex:/^[a-z0-9_\-]+$/', 'unique:activity_types,value,' . $activityType->id],
            'is_active' => ['sometimes', 'boolean'],
            'sort_order' => ['sometimes', 'integer', 'min:0'],
        ]);

        $activityType->update($data);
        return response()->json($activityType);
    }

    public function destroy(ActivityType $activityType)
    {
        $activityType->delete();
        return response()->json(['message' => 'deleted']);
    }
}
