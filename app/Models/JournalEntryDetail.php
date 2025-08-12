<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\JournalEntryDetail
 *
 * @property int $id
 * @property int $journal_entry_id
 * @property int $account_id
 * @property float $debit_amount
 * @property float $credit_amount
 * @property string $description
 * @property string|null $reference_number
 * @property int|null $budget_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\JournalEntry $journalEntry
 * @property-read \App\Models\ChartOfAccount $account
 * @property-read \App\Models\Budget|null $budget
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntryDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntryDetail newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntryDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntryDetail whereJournalEntryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntryDetail whereAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntryDetail whereDebitAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntryDetail whereCreditAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntryDetail whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntryDetail whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntryDetail whereBudgetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntryDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntryDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntryDetail whereId($value)

 * 
 * @mixin \Eloquent
 */
class JournalEntryDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'journal_entry_id',
        'account_id',
        'debit_amount',
        'credit_amount',
        'description',
        'reference_number',
        'budget_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'journal_entry_id' => 'integer',
        'account_id' => 'integer',
        'debit_amount' => 'decimal:2',
        'credit_amount' => 'decimal:2',
        'budget_id' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the journal entry that owns this detail.
     */
    public function journalEntry(): BelongsTo
    {
        return $this->belongsTo(JournalEntry::class);
    }

    /**
     * Get the account for this detail.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }

    /**
     * Get the budget for this detail.
     */
    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }
}