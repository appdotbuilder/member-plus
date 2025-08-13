<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\DentalAppointment
 *
 * @property int $id
 * @property int $user_id
 * @property string $appointment_number
 * @property string $service_type
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon $appointment_datetime
 * @property int $duration_minutes
 * @property string|null $dentist_name
 * @property string $clinic_name
 * @property string $clinic_address
 * @property string $clinic_phone
 * @property string $status
 * @property float|null $estimated_cost
 * @property string|null $preparation_instructions
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * 
 * @property-read User $user
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|DentalAppointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DentalAppointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DentalAppointment query()
 * @method static \Illuminate\Database\Eloquent\Builder|DentalAppointment upcoming()
 * @method static \Database\Factories\DentalAppointmentFactory factory($count = null, $state = [])
 * 
 * @mixin \Eloquent
 */
class DentalAppointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'appointment_number',
        'service_type',
        'notes',
        'appointment_datetime',
        'duration_minutes',
        'dentist_name',
        'clinic_name',
        'clinic_address',
        'clinic_phone',
        'status',
        'estimated_cost',
        'preparation_instructions',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'appointment_datetime' => 'datetime',
        'duration_minutes' => 'integer',
        'estimated_cost' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the appointment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include upcoming appointments.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUpcoming($query)
    {
        return $query->where('appointment_datetime', '>', now())
                    ->whereIn('status', ['scheduled', 'confirmed']);
    }

    /**
     * Get the formatted appointment date and time.
     *
     * @return string
     */
    public function getFormattedDateTimeAttribute(): string
    {
        return $this->appointment_datetime->format('M j, Y \a\t g:i A');
    }

    /**
     * Get the formatted estimated cost.
     *
     * @return string
     */
    public function getFormattedCostAttribute(): string
    {
        return $this->estimated_cost ? '$' . number_format($this->estimated_cost, 2) : 'TBD';
    }

    /**
     * Get the status badge color.
     *
     * @return string
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'scheduled' => 'blue',
            'confirmed' => 'green',
            'completed' => 'emerald',
            'cancelled' => 'red',
            'no_show' => 'gray',
            default => 'gray'
        };
    }

    /**
     * Get the service type icon.
     *
     * @return string
     */
    public function getServiceIconAttribute(): string
    {
        return match($this->service_type) {
            'cleaning' => '🧽',
            'checkup' => '🔍',
            'treatment' => '🦷',
            'emergency' => '🚨',
            default => '🦷'
        };
    }
}