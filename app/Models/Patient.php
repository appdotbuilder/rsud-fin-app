<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Patient
 *
 * @property int $id
 * @property string $patient_number
 * @property string|null $nik
 * @property string|null $bpjs_number
 * @property string $name
 * @property \Illuminate\Support\Carbon $birth_date
 * @property string $gender
 * @property string $address
 * @property string|null $phone
 * @property string|null $emergency_contact_name
 * @property string|null $emergency_contact_phone
 * @property string $insurance_type
 * @property string|null $insurance_number
 * @property string|null $insurance_class
 * @property bool $is_active
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PatientBill> $bills
 * @property-read int|null $bills_count
 * 
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient query()
 * @method static \Illuminate\Database\Eloquent\Builder|Patient wherePatientNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereNik($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereBpjsNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereEmergencyContactName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereEmergencyContactPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereInsuranceType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereInsuranceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereInsuranceClass($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Patient active()

 * 
 * @mixin \Eloquent
 */
class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'patient_number',
        'nik',
        'bpjs_number',
        'name',
        'birth_date',
        'gender',
        'address',
        'phone',
        'emergency_contact_name',
        'emergency_contact_phone',
        'insurance_type',
        'insurance_number',
        'insurance_class',
        'is_active',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birth_date' => 'date',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the bills for this patient.
     */
    public function bills(): HasMany
    {
        return $this->hasMany(PatientBill::class);
    }

    /**
     * Scope a query to only include active patients.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}