<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PrayerRequest;
use Illuminate\Http\Request;

class PrayerRequestController extends Controller
{
    public function index()
    {
        return response()->json(PrayerRequest::orderBy('created_at', 'desc')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'request' => 'required|string',
            'name' => 'nullable|string|max:255',
            'is_anonymous' => 'boolean',
            'contact_info' => 'nullable|string|max:255',
        ]);

        $prayer = PrayerRequest::create($validated);

        return response()->json($prayer, 201);
    }

    public function update(Request $request, PrayerRequest $prayerRequest)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pendiente,mensionado,completado',
        ]);

        $prayerRequest->update($validated);

        return response()->json($prayerRequest);
    }

    public function destroy(PrayerRequest $prayerRequest)
    {
        $prayerRequest->delete();
        return response()->json(null, 204);
    }
}
