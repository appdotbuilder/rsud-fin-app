<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\ChartOfAccount
 *
 * @property int $id
 * @property string $account_code
 * @property string $account_name
 * @property string $account_type
 * @property string|null $account_category
 * @property int|null $parent_id
 * @property int $level
 * @property string|null $path
 * @property string $normal_balance
 * @property bool $is_active
 * @property bool $is_header
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ChartOfAccount> $children
 * @property-read int|null $children_count
 * @property-read \App\Models\ChartOfAccount|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\JournalEntryDetail> $journalDetails
 * @property-read int|null $journal_details_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount whereAccountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount whereAccountCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount whereNormalBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount whereIsHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ChartOfAccount active()

 * 
 * @mixin \Eloquent
 */
class ChartOfAccount extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'account_code',
        'account_name',
        'account_type',
        'account_category',
        'parent_id',
        'level',
        'path',
        'normal_balance',
        'is_active',
        'is_header',
        'description',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'parent_id' => 'integer',
        'level' => 'integer',
        'is_active' => 'boolean',
        'is_header' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the parent account.
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(ChartOfAccount::class, 'parent_id');
    }

    /**
     * Get the child accounts.
     */
    public function children(): HasMany
    {
        return $this->hasMany(ChartOfAccount::class, 'parent_id');
    }

    /**
     * Get the journal entry details for this account.
     */
    public function journalDetails(): HasMany
    {
        return $this->hasMany(JournalEntryDetail::class, 'account_id');
    }

    /**
     * Scope a query to only include active accounts.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}