<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInsuranceClaimRequest;
use App\Models\InsuranceClaim;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InsuranceClaimController extends Controller
{
    /**
     * Display a listing of the user's insurance claims.
     */
    public function index(Request $request)
    {
        $claims = $request->user()->insuranceClaims()
            ->with('insurancePolicy')
            ->latest()
            ->paginate(10);

        return Inertia::render('insurance/claims/index', [
            'claims' => $claims
        ]);
    }

    /**
     * Show the form for creating a new claim.
     */
    public function create(Request $request)
    {
        $policies = $request->user()->insurancePolicies()
            ->where('status', 'active')
            ->get(['id', 'policy_number', 'name', 'type']);

        return Inertia::render('insurance/claims/create', [
            'policies' => $policies
        ]);
    }

    /**
     * Store a newly created claim.
     */
    public function store(StoreInsuranceClaimRequest $request)
    {
        $claimNumber = 'CLM-' . now()->format('Ymd') . '-' . str_pad((string)random_int(1, 9999), 4, '0', STR_PAD_LEFT);

        $claim = InsuranceClaim::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
            'claim_number' => $claimNumber,
            'submitted_at' => now(),
        ]);

        return redirect()->route('insurance.claims.show', $claim)
            ->with('success', 'Insurance claim submitted successfully.');
    }

    /**
     * Display the specified claim.
     */
    public function show(Request $request, InsuranceClaim $claim)
    {
        // Ensure the claim belongs to the authenticated user
        if ($claim->user_id !== $request->user()->id) {
            abort(404);
        }

        $claim->load('insurancePolicy');

        return Inertia::render('insurance/claims/show', [
            'claim' => $claim
        ]);
    }
}