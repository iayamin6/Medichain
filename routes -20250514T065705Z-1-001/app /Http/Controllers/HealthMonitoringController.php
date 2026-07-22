<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HealthMonitoringController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Fetch last 30 days of metrics
        $metrics = DB::table('health_metrics')
            ->where('user_id', $user->user_id)
            ->where('measured_at', '>=', Carbon::now()->subDays(30))
            ->orderBy('measured_at')
            ->get();

        // Prepare weight chart data
        $weightMetrics = $metrics->whereNotNull('weight');
        $weight_dates = $weightMetrics->map(function($metric) {
            return Carbon::parse($metric->measured_at)->format('M d');
        })->values();
        $weight_data = $weightMetrics->pluck('weight')->values();
        $latest_weight = $weightMetrics->last()?->weight;

        // Prepare blood pressure chart data
        $bpMetrics = $metrics->whereNotNull('blood_pressure');
        $bp_dates = $bpMetrics->map(function($metric) {
            return Carbon::parse($metric->measured_at)->format('M d');
        })->values();
        $bp_systolic = $bpMetrics->map(function($metric) {
            return explode('/', $metric->blood_pressure)[0];
        })->values();
        $bp_diastolic = $bpMetrics->map(function($metric) {
            return explode('/', $metric->blood_pressure)[1];
        })->values();
        $latest_bp = $bpMetrics->last()?->blood_pressure;

        // Prepare heart rate chart data
        $hrMetrics = $metrics->whereNotNull('heart_rate');
        $hr_dates = $hrMetrics->map(function($metric) {
            return Carbon::parse($metric->measured_at)->format('M d');
        })->values();
        $hr_data = $hrMetrics->pluck('heart_rate')->values();
        $latest_hr = $hrMetrics->last()?->heart_rate;

        // Fetch active medication reminders
        $reminders = DB::table('medication_reminders')
            ->where('user_id', $user->user_id)
            ->where('status', 'active')
            ->where('end_date', '>=', Carbon::today())
            ->get();

        // Generate AI recommendations
        $recommendations = $this->generateRecommendations($metrics);

        return view('health.monitor', compact(
            'weight_dates',
            'weight_data',
            'latest_weight',
            'bp_dates',
            'bp_systolic',
            'bp_diastolic',
            'latest_bp',
            'hr_dates',
            'hr_data',
            'latest_hr',
            'reminders',
            'recommendations'
        ));
    }

    private function generateRecommendations($metrics)
    {
        $recommendations = collect();

        if ($metrics->isNotEmpty()) {
            $latest = $metrics->last();

            // Weight recommendations
            if ($latest->weight) {
                if ($latest->weight > $metrics->avg('weight') + 2) {
                    $recommendations->push((object)[
                        'icon' => 'fa-weight',
                        'title' => 'Weight Management',
                        'description' => 'Your weight has increased. Consider increasing physical activity and monitoring calorie intake.'
                    ]);
                }
            }

            // Blood pressure recommendations
            if ($latest->blood_pressure) {
                list($systolic, $diastolic) = explode('/', $latest->blood_pressure);
                if ($systolic > 140 || $diastolic > 90) {
                    $recommendations->push((object)[
                        'icon' => 'fa-heart',
                        'title' => 'Blood Pressure Alert',
                        'description' => 'Your blood pressure is elevated. Consider reducing sodium intake and stress levels.'
                    ]);
                }
            }

            // Heart rate recommendations
            if ($latest->heart_rate && $latest->heart_rate > 100) {
                $recommendations->push((object)[
                    'icon' => 'fa-heartbeat',
                    'title' => 'Heart Rate Alert',
                    'description' => 'Your resting heart rate is elevated. Consider stress management techniques.'
                ]);
            }
        }

        // Add general recommendations if none specific
        if ($recommendations->isEmpty()) {
            $recommendations->push((object)[
                'icon' => 'fa-heart',
                'title' => 'Stay Healthy',
                'description' => 'Maintain a balanced diet, regular exercise, and adequate sleep for optimal health.'
            ]);
        }

        return $recommendations;
    }

    public function logMetric(Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'value' => 'required'
        ]);

        DB::table('health_metrics')->insert([
            'user_id' => Auth::id(),
            $request->type => $request->value,
            'measured_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function addMedication(Request $request)
    {
        $request->validate([
            'medication_name' => 'required|string',
            'dosage' => 'required|string',
            'frequency' => 'required|string',
            'reminder_time' => 'required'
        ]);

        DB::table('medication_reminders')->insert([
            'user_id' => Auth::id(),
            'medication_name' => $request->medication_name,
            'dosage' => $request->dosage,
            'frequency' => $request->frequency,
            'reminder_time' => $request->reminder_time,
            'start_date' => now(),
            'status' => 'active'
        ]);

        return redirect()->back()->with('success', 'Medication reminder added successfully');
    }
}