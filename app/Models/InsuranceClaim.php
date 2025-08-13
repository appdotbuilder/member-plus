<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\InsuranceClaim
 *
 * @property int $id
 * @property int $user_id
 * @property int $insurance_policy_id
 * @property string $claim_number
 * @property string $title
 * @property string $description
 * @property float $claimed_amount
 * @property float|null $approved_amount
 * @property string $status
 * @property \Illuminate\Support\Carbon $incident_date
 * @property array|null $documents
 * @property string|null $admin_notes
 * @property \Illuminate\Support\Carbon|null $submitted_at
 * @property \Illuminate\Support\Carbon|null $processed_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read User $user
 * @property-read InsurancePolicy $insurancePolicy
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceClaim newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceClaim newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InsuranceClaim query()
 * @method static \Database\Factories\InsuranceClaimFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class InsuranceClaim extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'insurance_policy_id',
        'claim_number',
        'title',
        'description',
        'claimed_amount',
        'approved_amount',
        'status',
        'incident_date',
        'documents',
        'admin_notes',
        'submitted_at',
        'processed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'claimed_amount' => 'decimal:2',
        'approved_amount' => 'decimal:2',
        'incident_date' => 'date',
        'documents' => 'array',
        'submitted_at' => 'datetime',
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the claim.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the insurance policy for this claim.
     */
    public function insurancePolicy(): BelongsTo
    {
        return $this->belongsTo(InsurancePolicy::class);
    }

    /**
     * Get the formatted claimed amount.
     *
     * @return string
     */
    public function getFormattedClaimedAmountAttribute(): string
    {
        return '$' . number_format($this->claimed_amount, 2);
    }

    /**
     * Get the formatted approved amount.
     *
     * @return string
     */
    public function getFormattedApprovedAmountAttribute(): string
    {
        return $this->approved_amount ? '$' . number_format($this->approved_amount, 2) : 'N/A';
    }

    /**
     * Get the status badge color.
     *
     * @return string
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'under_review' => 'blue',
            'approved' => 'green',
            'rejected' => 'red',
            'paid' => 'emerald',
            default => 'gray'
        };
    }
}