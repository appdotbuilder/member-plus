<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\InsurancePolicy
 *
 * @property int $id
 * @property int $user_id
 * @property string $policy_number
 * @property string $type
 * @property string $name
 * @property string $description
 * @property float $premium_amount
 * @property float $coverage_amount
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property string $status
 * @property array|null $details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\InsuranceClaim[] $claims
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePolicy newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePolicy newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePolicy query()
 * @method static \Illuminate\Database\Eloquent\Builder|InsurancePolicy active()
 * @method static \Database\Factories\InsurancePolicyFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class InsurancePolicy extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'policy_number',
        'type',
        'name',
        'description',
        'premium_amount',
        'coverage_amount',
        'start_date',
        'end_date',
        'status',
        'details',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'premium_amount' => 'decimal:2',
        'coverage_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'details' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the insurance policy.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the claims for this policy.
     */
    public function claims(): HasMany
    {
        return $this->hasMany(InsuranceClaim::class);
    }

    /**
     * Scope a query to only include active policies.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Check if the policy is currently active.
     *
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->status === 'active' && 
               $this->start_date <= now() && 
               $this->end_date >= now();
    }

    /**
     * Get the formatted premium amount.
     *
     * @return string
     */
    public function getFormattedPremiumAttribute(): string
    {
        return '$' . number_format($this->premium_amount, 2);
    }

    /**
     * Get the formatted coverage amount.
     *
     * @return string
     */
    public function getFormattedCoverageAttribute(): string
    {
        return '$' . number_format($this->coverage_amount, 2);
    }
}