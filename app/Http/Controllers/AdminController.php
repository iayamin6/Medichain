<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalUsers = DB::table('medical_users')->count();
        $totalDoctors = DB::table('medical_users')->where('role', 'doctor')->count();
        $totalPatients = DB::table('medical_users')->where('role', 'patient')->count();
        $totalAppointments = DB::table('appointments')->count();

        $recentUsers = DB::table('medical_users')
            ->select('user_id', 'first_name', 'last_name', 'role', 'created_at')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentAppointments = DB::table('appointments as a')
            ->join('medical_users as p', 'a.user_id', '=', 'p.user_id')
            ->join('medical_users as d', 'a.doctor_id', '=', 'd.user_id')
            ->select(
                'a.id',
                'p.first_name as patient_name',
                'd.first_name as doctor_name',
                'a.date',
                'a.time',
                'a.status'
            )
            ->orderBy('a.created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalDoctors',
            'totalPatients',
            'totalAppointments',
            'recentUsers',
            'recentAppointments'
        ));
    }
}