<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateMemberProfileRequest;
use App\Models\MemberProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MemberProfileController extends Controller
{
    /**
     * Display the user's member profile.
     */
    public function show(Request $request)
    {
        $memberProfile = $request->user()->memberProfile;

        if (!$memberProfile) {
            return redirect()->route('member.profile.create');
        }

        return Inertia::render('member/profile/show', [
            'memberProfile' => $memberProfile
        ]);
    }

    /**
     * Show the form for creating a member profile.
     */
    public function create()
    {
        return Inertia::render('member/profile/create');
    }

    /**
     * Store a newly created member profile.
     */
    public function store(UpdateMemberProfileRequest $request)
    {
        $memberNumber = 'MEM-' . now()->format('Y') . '-' . str_pad((string)random_int(1, 99999), 5, '0', STR_PAD_LEFT);

        MemberProfile::create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
            'member_number' => $memberNumber,
            'membership_start_date' => now(),
            'is_active' => true,
        ]);

        return redirect()->route('member.profile.show')
            ->with('success', 'Member profile created successfully.');
    }

    /**
     * Show the form for editing the member profile.
     */
    public function edit(Request $request)
    {
        $memberProfile = $request->user()->memberProfile;

        if (!$memberProfile) {
            return redirect()->route('member.profile.create');
        }

        return Inertia::render('member/profile/edit', [
            'memberProfile' => $memberProfile
        ]);
    }

    /**
     * Update the member profile.
     */
    public function update(UpdateMemberProfileRequest $request)
    {
        $memberProfile = $request->user()->memberProfile;

        if (!$memberProfile) {
            return redirect()->route('member.profile.create');
        }

        $memberProfile->update($request->validated());

        return redirect()->route('member.profile.show')
            ->with('success', 'Profile updated successfully.');
    }
}