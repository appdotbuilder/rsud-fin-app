<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Budget
 *
 * @property int $id
 * @property string $budget_code
 * @property string $budget_name
 * @property int $financial_period_id
 * @property string $budget_type
 * @property string $budget_category
 * @property float $planned_amount
 * @property float $revised_amount
 * @property float $realized_amount
 * @property float $remaining_amount
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property int|null $approved_by
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\FinancialPeriod $financialPeriod
 * @property-read \App\Models\User|null $approver
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JournalEntryDetail> $journalDetails
 * @property-read int|null $journal_details_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Budget newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Budget newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Budget query()
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereBudgetCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereBudgetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereFinancialPeriodId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereBudgetType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereBudgetCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget wherePlannedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereRevisedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereRealizedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereRemainingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Budget active()

 * 
 * @mixin \Eloquent
 */
class Budget extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'budget_code',
        'budget_name',
        'financial_period_id',
        'budget_type',
        'budget_category',
        'planned_amount',
        'revised_amount',
        'realized_amount',
        'remaining_amount',
        'status',
        'approved_at',
        'approved_by',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'financial_period_id' => 'integer',
        'planned_amount' => 'decimal:2',
        'revised_amount' => 'decimal:2',
        'realized_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'approved_at' => 'date',
        'approved_by' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the financial period for this budget.
     */
    public function financialPeriod(): BelongsTo
    {
        return $this->belongsTo(FinancialPeriod::class);
    }

    /**
     * Get the user who approved this budget.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the journal entry details for this budget.
     */
    public function journalDetails(): HasMany
    {
        return $this->hasMany(JournalEntryDetail::class);
    }

    /**
     * Scope a query to only include active budgets.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}