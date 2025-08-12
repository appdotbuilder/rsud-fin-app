<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FinancialPeriod;
use App\Models\ChartOfAccount;
use App\Models\Budget;
use App\Models\Patient;
use App\Models\PatientBill;

class FinancialDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create current financial period
        $currentPeriod = FinancialPeriod::create([
            'year' => now()->year,
            'name' => 'Tahun Anggaran ' . now()->year,
            'start_date' => now()->startOfYear(),
            'end_date' => now()->endOfYear(),
            'status' => 'active',
            'is_current' => true,
            'description' => 'Periode anggaran tahunan RSUD ' . now()->year,
        ]);

        // Create basic chart of accounts following Indonesian government accounting
        $accounts = [
            // ASSETS (1xxx)
            ['1100', 'Kas di Bendahara Penerimaan', 'asset', 'current_asset', null, 1, 'debit'],
            ['1110', 'Kas di Bendahara Pengeluaran', 'asset', 'current_asset', null, 1, 'debit'],
            ['1200', 'Piutang Pelayanan', 'asset', 'current_asset', null, 1, 'debit'],
            ['1210', 'Piutang BPJS', 'asset', 'current_asset', null, 1, 'debit'],
            ['1300', 'Persediaan Obat', 'asset', 'current_asset', null, 1, 'debit'],
            ['1310', 'Persediaan Alat Kesehatan', 'asset', 'current_asset', null, 1, 'debit'],
            ['1500', 'Peralatan dan Mesin', 'asset', 'fixed_asset', null, 1, 'debit'],
            ['1510', 'Gedung dan Bangunan', 'asset', 'fixed_asset', null, 1, 'debit'],

            // LIABILITIES (2xxx)
            ['2100', 'Utang Kepada Pihak Ketiga', 'liability', 'current_liability', null, 1, 'credit'],
            ['2110', 'Utang Gaji dan Tunjangan', 'liability', 'current_liability', null, 1, 'credit'],
            ['2200', 'Utang Jangka Panjang', 'liability', 'long_term_liability', null, 1, 'credit'],

            // EQUITY (3xxx)
            ['3100', 'Ekuitas', 'equity', 'equity', null, 1, 'credit'],
            ['3110', 'Ekuitas SAL', 'equity', 'equity', null, 1, 'credit'],

            // REVENUE (4xxx)
            ['4100', 'Pendapatan Jasa Layanan', 'revenue', 'operating_revenue', null, 1, 'credit'],
            ['4110', 'Pendapatan BPJS', 'revenue', 'operating_revenue', null, 1, 'credit'],
            ['4200', 'Pendapatan Hibah', 'revenue', 'non_operating_revenue', null, 1, 'credit'],
            ['4300', 'Pendapatan APBD', 'revenue', 'operating_revenue', null, 1, 'credit'],

            // EXPENSES (5xxx)
            ['5100', 'Beban Pegawai', 'expense', 'operating_expense', null, 1, 'debit'],
            ['5200', 'Beban Barang dan Jasa', 'expense', 'operating_expense', null, 1, 'debit'],
            ['5300', 'Beban Pemeliharaan', 'expense', 'operating_expense', null, 1, 'debit'],
            ['5400', 'Beban Perjalanan Dinas', 'expense', 'operating_expense', null, 1, 'debit'],
            ['5500', 'Beban Penyusutan', 'expense', 'depreciation', null, 1, 'debit'],
        ];

        foreach ($accounts as $account) {
            ChartOfAccount::create([
                'account_code' => $account[0],
                'account_name' => $account[1],
                'account_type' => $account[2],
                'account_category' => $account[3],
                'parent_id' => $account[4],
                'level' => $account[5],
                'normal_balance' => $account[6],
                'is_active' => true,
                'is_header' => false,
            ]);
        }

        // Create sample budgets
        $budgets = [
            [
                'budget_code' => 'REV-001',
                'budget_name' => 'Pendapatan Jasa Pelayanan Medis',
                'budget_type' => 'revenue',
                'budget_category' => 'blud_revenue',
                'planned_amount' => 15000000000, // 15 Miliar
                'revised_amount' => 15000000000,
                'realized_amount' => 8500000000,  // 8.5 Miliar realized
                'remaining_amount' => 6500000000,
                'status' => 'active',
            ],
            [
                'budget_code' => 'REV-002', 
                'budget_name' => 'Pendapatan BPJS Kesehatan',
                'budget_type' => 'revenue',
                'budget_category' => 'blud_revenue',
                'planned_amount' => 25000000000, // 25 Miliar
                'revised_amount' => 25000000000,
                'realized_amount' => 14200000000, // 14.2 Miliar realized
                'remaining_amount' => 10800000000,
                'status' => 'active',
            ],
            [
                'budget_code' => 'EXP-001',
                'budget_name' => 'Belanja Pegawai',
                'budget_type' => 'expense',
                'budget_category' => 'personnel_expense',
                'planned_amount' => 20000000000, // 20 Miliar
                'revised_amount' => 20000000000,
                'realized_amount' => 11800000000, // 11.8 Miliar realized
                'remaining_amount' => 8200000000,
                'status' => 'active',
            ],
            [
                'budget_code' => 'EXP-002',
                'budget_name' => 'Belanja Barang dan Jasa',
                'budget_type' => 'expense',
                'budget_category' => 'goods_services',
                'planned_amount' => 12000000000, // 12 Miliar
                'revised_amount' => 12000000000,
                'realized_amount' => 6500000000,  // 6.5 Miliar realized
                'remaining_amount' => 5500000000,
                'status' => 'active',
            ],
        ];

        foreach ($budgets as $budget) {
            Budget::create(array_merge($budget, [
                'financial_period_id' => $currentPeriod->id,
            ]));
        }

        // Create sample patients
        $patients = [
            [
                'patient_number' => 'P001-' . now()->format('Y'),
                'nik' => '3273010101800001',
                'bpjs_number' => '0000123456789',
                'name' => 'Ahmad Supardi',
                'birth_date' => '1980-01-01',
                'gender' => 'male',
                'address' => 'Jl. Merdeka No. 123, Bandung, Jawa Barat',
                'phone' => '08123456789',
                'emergency_contact_name' => 'Siti Supardi',
                'emergency_contact_phone' => '08198765432',
                'insurance_type' => 'bpjs',
                'insurance_number' => '0000123456789',
                'insurance_class' => '2',
                'is_active' => true,
            ],
            [
                'patient_number' => 'P002-' . now()->format('Y'),
                'nik' => '3273020202850002',
                'name' => 'Dewi Sartika',
                'birth_date' => '1985-02-02',
                'gender' => 'female',
                'address' => 'Jl. Sudirman No. 456, Bandung, Jawa Barat',
                'phone' => '08234567890',
                'emergency_contact_name' => 'Budi Sartika',
                'emergency_contact_phone' => '08187654321',
                'insurance_type' => 'private',
                'insurance_number' => 'PRV-001234567',
                'is_active' => true,
            ],
        ];

        foreach ($patients as $patientData) {
            $patient = Patient::create($patientData);

            // Create sample bills for each patient
            PatientBill::create([
                'bill_number' => 'BILL-' . $patient->id . '-' . now()->format('Ymd') . '-001',
                'patient_id' => $patient->id,
                'service_date' => now()->subDays(3),
                'bill_date' => now()->subDays(2),
                'due_date' => now()->addDays(30),
                'service_type' => 'inpatient',
                'gross_amount' => 5500000,
                'discount_amount' => 500000,
                'tax_amount' => 0,
                'insurance_coverage' => $patient->insurance_type === 'bpjs' ? 4500000 : 2000000,
                'patient_responsibility' => $patient->insurance_type === 'bpjs' ? 500000 : 3000000,
                'net_amount' => 5000000,
                'paid_amount' => $patient->insurance_type === 'bpjs' ? 4500000 : 0,
                'outstanding_amount' => $patient->insurance_type === 'bpjs' ? 500000 : 5000000,
                'payment_status' => $patient->insurance_type === 'bpjs' ? 'partial' : 'unpaid',
                'insurance_claim_status' => $patient->insurance_type === 'bpjs' ? 'submitted' : null,
                'insurance_claim_number' => $patient->insurance_type === 'bpjs' ? 'CLM-' . now()->format('Ymd') . '-001' : null,
                'insurance_claim_date' => $patient->insurance_type === 'bpjs' ? now()->subDay() : null,
                'notes' => 'Perawatan inap ruang kelas ' . ($patient->insurance_class ?? 'VIP'),
            ]);
        }
    }
}