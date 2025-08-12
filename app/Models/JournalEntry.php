<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\JournalEntry
 *
 * @property int $id
 * @property string $journal_number
 * @property \Illuminate\Support\Carbon $transaction_date
 * @property \Illuminate\Support\Carbon|null $posting_date
 * @property string|null $reference_number
 * @property string $transaction_type
 * @property string $description
 * @property float $total_debit
 * @property float $total_credit
 * @property string $status
 * @property int $created_by
 * @property int|null $posted_by
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $posted_at
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $creator
 * @property-read \App\Models\User|null $poster
 * @property-read \App\Models\User|null $approver
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JournalEntryDetail> $details
 * @property-read int|null $details_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry query()
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereJournalNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereTransactionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry wherePostingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereTransactionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereTotalDebit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereTotalCredit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry wherePostedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry wherePostedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JournalEntry posted()

 * 
 * @mixin \Eloquent
 */
class JournalEntry extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'journal_number',
        'transaction_date',
        'posting_date',
        'reference_number',
        'transaction_type',
        'description',
        'total_debit',
        'total_credit',
        'status',
        'created_by',
        'posted_by',
        'approved_by',
        'posted_at',
        'approved_at',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'transaction_date' => 'date',
        'posting_date' => 'date',
        'total_debit' => 'decimal:2',
        'total_credit' => 'decimal:2',
        'created_by' => 'integer',
        'posted_by' => 'integer',
        'approved_by' => 'integer',
        'posted_at' => 'datetime',
        'approved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who created this journal entry.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who posted this journal entry.
     */
    public function poster(): BelongsTo
    {
        return $this->belongsTo(User::class, 'posted_by');
    }

    /**
     * Get the user who approved this journal entry.
     */
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get the journal entry details.
     */
    public function details(): HasMany
    {
        return $this->hasMany(JournalEntryDetail::class);
    }

    /**
     * Scope a query to only include posted journal entries.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePosted($query)
    {
        return $query->where('status', 'posted');
    }
}