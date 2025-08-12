<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\FinancialPeriod
 *
 * @property int $id
 * @property int $year
 * @property string $name
 * @property \Illuminate\Support\Carbon $start_date
 * @property \Illuminate\Support\Carbon $end_date
 * @property string $status
 * @property bool $is_current
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Budget> $budgets
 * @property-read int|null $budgets_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialPeriod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialPeriod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialPeriod query()
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialPeriod whereYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialPeriod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialPeriod whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialPeriod whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialPeriod whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialPeriod whereIsCurrent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialPeriod whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialPeriod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialPeriod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialPeriod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinancialPeriod current()

 * 
 * @mixin \Eloquent
 */
class FinancialPeriod extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'year',
        'name',
        'start_date',
        'end_date',
        'status',
        'is_current',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'year' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get budgets for this financial period.
     */
    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    /**
     * Scope a query to only include current financial period.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }
}