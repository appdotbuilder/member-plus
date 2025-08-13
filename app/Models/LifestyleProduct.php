<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\LifestyleProduct
 *
 * @property int $id
 * @property string $name
 * @property string $category
 * @property string $description
 * @property string $features
 * @property float $price
 * @property float|null $member_price
 * @property string|null $image_url
 * @property bool $is_active
 * @property array|null $eligibility_criteria
 * @property int $points_reward
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|LifestyleProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LifestyleProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LifestyleProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|LifestyleProduct active()
 * @method static \Database\Factories\LifestyleProductFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class LifestyleProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'category',
        'description',
        'features',
        'price',
        'member_price',
        'image_url',
        'is_active',
        'eligibility_criteria',
        'points_reward',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'member_price' => 'decimal:2',
        'is_active' => 'boolean',
        'eligibility_criteria' => 'array',
        'points_reward' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scope a query to only include active products.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the formatted price.
     *
     * @return string
     */
    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * Get the formatted member price.
     *
     * @return string
     */
    public function getFormattedMemberPriceAttribute(): string
    {
        return $this->member_price ? '$' . number_format($this->member_price, 2) : 'N/A';
    }

    /**
     * Get the category icon.
     *
     * @return string
     */
    public function getCategoryIconAttribute(): string
    {
        return match($this->category) {
            'car_insurance' => '🚗',
            'dental_care' => '🦷',
            'health' => '🏥',
            'wellness' => '💪',
            default => '📦'
        };
    }
}