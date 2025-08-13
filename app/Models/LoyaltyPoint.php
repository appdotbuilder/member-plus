<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\LoyaltyPoint
 *
 * @property int $id
 * @property int $user_id
 * @property int $points
 * @property string $transaction_type
 * @property string $description
 * @property int $amount
 * @property string|null $reference_type
 * @property int|null $reference_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|LoyaltyPoint newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoyaltyPoint newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoyaltyPoint query()
 * @method static \Database\Factories\LoyaltyPointFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class LoyaltyPoint extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'points',
        'transaction_type',
        'description',
        'amount',
        'reference_type',
        'reference_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'points' => 'integer',
        'amount' => 'integer',
        'reference_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the loyalty points.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}