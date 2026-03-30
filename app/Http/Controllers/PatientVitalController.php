<?php

namespace App\Http\Controllers;

use App\Models\PatientVital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PatientVitalController extends Controller
{
    public function index()
    {
        $vitals = PatientVital::where('user_id', Auth::id())
            ->orderByDesc('recorded_at')
            ->orderByDesc('id')
            ->paginate(10);

        $latest = $vitals->first();

        return view('patient.vitals', compact('vitals', 'latest'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bmi' => 'nullable|numeric|min:1|max:80',
            'heart_rate' => 'nullable|integer|min:20|max:250',
            'fbc_status' => 'nullable|string|max:100',
            'weight' => 'nullable|numeric|min:1|max:400',
            'blood_pressure' => 'nullable|string|max:20',
            'glucose_level' => 'nullable|string|max:20',
            'body_temperature' => 'nullable|numeric|min:30|max:45',
            'spo2' => 'nullable|integer|min:50|max:100',
            'recorded_at' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Ensure at least one vital field is provided.
        $hasAtLeastOneMetric = collect([
            'bmi',
            'heart_rate',
            'fbc_status',
            'weight',
            'blood_pressure',
            'glucose_level',
            'body_temperature',
            'spo2',
        ])->contains(fn ($field) => filled($validated[$field] ?? null));

        if (!$hasAtLeastOneMetric) {
            return redirect()
                ->route('patient.vitals')
                ->withErrors(['vitals' => 'Please enter at least one vital measurement.'])
                ->withInput();
        }

        try {
            $validated['user_id'] = Auth::id();
            $validated['recorded_at'] = !empty($validated['recorded_at'])
                ? Carbon::parse($validated['recorded_at'])
                : now();

            PatientVital::create($validated);

            return redirect()->route('patient.vitals')->with('success', 'Vitals added successfully.');
        } catch (\Throwable $e) {
            Log::error('Failed to save patient vital', [
                'user_id' => Auth::id(),
                'payload' => $request->except(['_token']),
                'error' => $e->getMessage(),
            ]);

            return redirect()
                ->route('patient.vitals')
                ->withErrors(['vitals' => 'Could not save vitals right now. Please try again.'])
                ->withInput();
        }
    }

    public function destroy(PatientVital $vital)
    {
        if ((int) $vital->user_id !== (int) Auth::id()) {
            abort(403);
        }

        $vital->delete();

        return redirect()->route('patient.vitals')->with('success', 'Vital record deleted.');
    }
}
