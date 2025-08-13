<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read MemberProfile|null $memberProfile
 * @property-read \Illuminate\Database\Eloquent\Collection|InsurancePolicy[] $insurancePolicies
 * @property-read \Illuminate\Database\Eloquent\Collection|InsuranceClaim[] $insuranceClaims
 * @property-read \Illuminate\Database\Eloquent\Collection|LoyaltyPoint[] $loyaltyPoints
 * @property-read \Illuminate\Database\Eloquent\Collection|DentalAppointment[] $dentalAppointments
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the member profile for the user.
     */
    public function memberProfile(): HasOne
    {
        return $this->hasOne(MemberProfile::class);
    }

    /**
     * Get the insurance policies for the user.
     */
    public function insurancePolicies(): HasMany
    {
        return $this->hasMany(InsurancePolicy::class);
    }

    /**
     * Get the insurance claims for the user.
     */
    public function insuranceClaims(): HasMany
    {
        return $this->hasMany(InsuranceClaim::class);
    }

    /**
     * Get the loyalty points transactions for the user.
     */
    public function loyaltyPoints(): HasMany
    {
        return $this->hasMany(LoyaltyPoint::class);
    }

    /**
     * Get the dental appointments for the user.
     */
    public function dentalAppointments(): HasMany
    {
        return $this->hasMany(DentalAppointment::class);
    }

    /**
     * Get the user's total loyalty points balance.
     *
     * @return int
     */
    public function getLoyaltyPointsBalanceAttribute(): int
    {
        return $this->loyaltyPoints()->sum('amount');
    }

    /**
     * Check if the user has an active membership.
     *
     * @return bool
     */
    public function hasActiveMembership(): bool
    {
        return $this->memberProfile?->isMembershipActive() ?? false;
    }
}
