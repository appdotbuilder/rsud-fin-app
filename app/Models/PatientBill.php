<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\PatientBill
 *
 * @property int $id
 * @property string $bill_number
 * @property int $patient_id
 * @property \Illuminate\Support\Carbon $service_date
 * @property \Illuminate\Support\Carbon $bill_date
 * @property \Illuminate\Support\Carbon $due_date
 * @property string $service_type
 * @property float $gross_amount
 * @property float $discount_amount
 * @property float $tax_amount
 * @property float $insurance_coverage
 * @property float $patient_responsibility
 * @property float $net_amount
 * @property float $paid_amount
 * @property float $outstanding_amount
 * @property string $payment_status
 * @property string|null $insurance_claim_status
 * @property string|null $insurance_claim_number
 * @property \Illuminate\Support\Carbon|null $insurance_claim_date
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Patient $patient
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill query()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereBillNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill wherePatientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereServiceDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereBillDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereDueDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereServiceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereGrossAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereTaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereInsuranceCoverage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill wherePatientResponsibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereNetAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill wherePaidAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereOutstandingAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereInsuranceClaimStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereInsuranceClaimNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereInsuranceClaimDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill unpaid()
 * @method static \Illuminate\Database\Eloquent\Builder|PatientBill overdue()

 * 
 * @mixin \Eloquent
 */
class PatientBill extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'bill_number',
        'patient_id',
        'service_date',
        'bill_date',
        'due_date',
        'service_type',
        'gross_amount',
        'discount_amount',
        'tax_amount',
        'insurance_coverage',
        'patient_responsibility',
        'net_amount',
        'paid_amount',
        'outstanding_amount',
        'payment_status',
        'insurance_claim_status',
        'insurance_claim_number',
        'insurance_claim_date',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'patient_id' => 'integer',
        'service_date' => 'date',
        'bill_date' => 'date',
        'due_date' => 'date',
        'gross_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'insurance_coverage' => 'decimal:2',
        'patient_responsibility' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'outstanding_amount' => 'decimal:2',
        'insurance_claim_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the patient that owns this bill.
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * Scope a query to only include unpaid bills.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', 'unpaid');
    }

    /**
     * Scope a query to only include overdue bills.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->whereIn('payment_status', ['unpaid', 'partial']);
    }
}