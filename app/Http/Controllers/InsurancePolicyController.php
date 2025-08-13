<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InsurancePolicy;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InsurancePolicyController extends Controller
{
    /**
     * Display a listing of the user's insurance policies.
     */
    public function index(Request $request)
    {
        $policies = $request->user()->insurancePolicies()
            ->with('claims')
            ->latest()
            ->paginate(10);

        return Inertia::render('insurance/policies/index', [
            'policies' => $policies
        ]);
    }

    /**
     * Display the specified insurance policy.
     */
    public function show(Request $request, InsurancePolicy $policy)
    {
        // Ensure the policy belongs to the authenticated user
        if ($policy->user_id !== $request->user()->id) {
            abort(404);
        }

        $policy->load('claims');

        return Inertia::render('insurance/policies/show', [
            'policy' => $policy
        ]);
    }
}