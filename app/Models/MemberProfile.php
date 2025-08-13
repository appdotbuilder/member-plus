<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\MemberProfile
 *
 * @property int $id
 * @property int $user_id
 * @property string $member_number
 * @property string $first_name
 * @property string $last_name
 * @property string|null $phone
 * @property \Illuminate\Support\Carbon|null $date_of_birth
 * @property string|null $gender
 * @property string|null $address
 * @property string|null $city
 * @property string|null $state
 * @property string|null $postal_code
 * @property string $country
 * @property string|null $emergency_contact_name
 * @property string|null $emergency_contact_phone
 * @property string $membership_tier
 * @property \Illuminate\Support\Carbon $membership_start_date
 * @property \Illuminate\Support\Carbon|null $membership_end_date
 * @property bool $is_active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|MemberProfile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberProfile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberProfile query()
 * @method static \Illuminate\Database\Eloquent\Builder|MemberProfile active()
 * @method static \Database\Factories\MemberProfileFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class MemberProfile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'member_number',
        'first_name',
        'last_name',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'emergency_contact_name',
        'emergency_contact_phone',
        'membership_tier',
        'membership_start_date',
        'membership_end_date',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'membership_start_date' => 'date',
        'membership_end_date' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the member profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include active members.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the member's full name.
     *
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Get the membership tier badge color.
     *
     * @return string
     */
    public function getTierColorAttribute(): string
    {
        return match($this->membership_tier) {
            'bronze' => 'amber',
            'silver' => 'gray',
            'gold' => 'yellow',
            'platinum' => 'purple',
            default => 'gray'
        };
    }

    /**
     * Check if membership is currently active.
     *
     * @return bool
     */
    public function isMembershipActive(): bool
    {
        return $this->is_active && 
               ($this->membership_end_date === null || $this->membership_end_date >= now());
    }
}