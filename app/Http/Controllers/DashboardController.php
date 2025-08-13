<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the member dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Get user's insurance policies
        $insurancePolicies = $user->insurancePolicies()
            ->with(['claims' => function($query) {
                $query->latest()->limit(3);
            }])
            ->latest()
            ->get();

        // Get recent claims
        $recentClaims = $user->insuranceClaims()
            ->with('insurancePolicy')
            ->latest()
            ->limit(5)
            ->get();

        // Get loyalty points balance
        $loyaltyPointsBalance = $user->loyaltyPointsBalance;

        // Get recent loyalty points transactions
        $recentPointsTransactions = $user->loyaltyPoints()
            ->latest()
            ->limit(5)
            ->get();

        // Get upcoming dental appointments
        $upcomingAppointments = $user->dentalAppointments()
            ->where('appointment_datetime', '>', now())
            ->whereIn('status', ['scheduled', 'confirmed'])
            ->latest('appointment_datetime')
            ->limit(3)
            ->get();

        // Get member profile
        $memberProfile = $user->memberProfile;

        // Calculate dashboard stats
        $stats = [
            'active_policies' => $insurancePolicies->where('status', 'active')->count(),
            'pending_claims' => $recentClaims->whereIn('status', ['pending', 'under_review'])->count(),
            'loyalty_points' => $loyaltyPointsBalance,
            'upcoming_appointments' => $upcomingAppointments->count(),
        ];

        return Inertia::render('dashboard', [
            'stats' => $stats,
            'insurancePolicies' => $insurancePolicies,
            'recentClaims' => $recentClaims,
            'loyaltyPointsBalance' => $loyaltyPointsBalance,
            'recentPointsTransactions' => $recentPointsTransactions,
            'upcomingAppointments' => $upcomingAppointments,
            'memberProfile' => $memberProfile,
        ]);
    }
}