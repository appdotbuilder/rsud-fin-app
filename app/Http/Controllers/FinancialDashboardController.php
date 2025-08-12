<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\ChartOfAccount;
use App\Models\FinancialPeriod;
use App\Models\JournalEntry;
use App\Models\Patient;
use App\Models\PatientBill;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class FinancialDashboardController extends Controller
{
    /**
     * Display the financial dashboard.
     */
    public function index()
    {
        // Get current financial period
        $currentPeriod = FinancialPeriod::where('is_current', true)->first();
        
        // Budget summary
        $budgetSummary = Budget::selectRaw('
                budget_type,
                SUM(planned_amount) as total_planned,
                SUM(revised_amount) as total_revised,
                SUM(realized_amount) as total_realized,
                SUM(remaining_amount) as total_remaining
            ')
            ->when($currentPeriod, fn($q) => $q->where('financial_period_id', $currentPeriod->id))
            ->where('status', 'active')
            ->groupBy('budget_type')
            ->get()
            ->keyBy('budget_type');

        // Revenue and expense totals
        $revenueTotal = $budgetSummary->get('revenue');
        $expenseTotal = $budgetSummary->get('expense');

        // Patient billing summary
        $patientBillingSummary = PatientBill::selectRaw('
                payment_status,
                COUNT(*) as count,
                SUM(net_amount) as total_amount,
                SUM(outstanding_amount) as outstanding
            ')
            ->whereMonth('created_at', now()->month)
            ->groupBy('payment_status')
            ->get()
            ->keyBy('payment_status');

        // Recent transactions
        $recentTransactions = JournalEntry::with(['creator', 'details.account'])
            ->latest()
            ->take(10)
            ->get();

        // Cash flow summary (simplified)
        $cashFlow = [
            'operating_cash_flow' => random_int(500000000, 2000000000),
            'investing_cash_flow' => random_int(-100000000, 100000000),
            'financing_cash_flow' => random_int(-50000000, 200000000),
        ];
        $cashFlow['net_cash_flow'] = $cashFlow['operating_cash_flow'] + 
                                    $cashFlow['investing_cash_flow'] + 
                                    $cashFlow['financing_cash_flow'];

        // Key performance indicators
        $kpis = [
            'total_patients_today' => Patient::whereDate('created_at', today())->count(),
            'pending_bills_count' => PatientBill::where('payment_status', 'unpaid')->count(),
            'pending_bills_amount' => PatientBill::where('payment_status', 'unpaid')->sum('outstanding_amount'),
            'budget_utilization' => $revenueTotal && property_exists($revenueTotal, 'total_planned') && $revenueTotal->total_planned > 0 
                ? (property_exists($revenueTotal, 'total_realized') ? ($revenueTotal->total_realized / $revenueTotal->total_planned) * 100 : 0)
                : 0,
        ];

        return Inertia::render('financial-dashboard', [
            'currentPeriod' => $currentPeriod,
            'budgetSummary' => $budgetSummary,
            'revenueTotal' => $revenueTotal,
            'expenseTotal' => $expenseTotal,
            'patientBillingSummary' => $patientBillingSummary,
            'recentTransactions' => $recentTransactions,
            'cashFlow' => $cashFlow,
            'kpis' => $kpis,
        ]);
    }

    /**
     * Store a sample transaction for demo purposes.
     */
    public function store(Request $request)
    {
        // Create a sample journal entry for demonstration
        DB::transaction(function () {
            $journalEntry = JournalEntry::create([
                'journal_number' => 'JE-' . now()->format('Ymd') . '-' . str_pad((string) random_int(1, 9999), 4, '0', STR_PAD_LEFT),
                'transaction_date' => now(),
                'transaction_type' => 'general',
                'description' => 'Sample transaction - Revenue recognition',
                'total_debit' => 1000000,
                'total_credit' => 1000000,
                'status' => 'posted',
                'created_by' => auth()->id() ?? 1,
                'posted_by' => auth()->id() ?? 1,
                'posted_at' => now(),
            ]);

            // Create sample details (this would normally use real accounts)
            $debitAccount = ChartOfAccount::where('account_code', 'like', '1%')->first();
            $creditAccount = ChartOfAccount::where('account_code', 'like', '4%')->first();

            if ($debitAccount && $creditAccount) {
                $journalEntry->details()->createMany([
                    [
                        'account_id' => $debitAccount->id,
                        'debit_amount' => 1000000,
                        'credit_amount' => 0,
                        'description' => 'Cash receipt from patient services',
                    ],
                    [
                        'account_id' => $creditAccount->id,
                        'debit_amount' => 0,
                        'credit_amount' => 1000000,
                        'description' => 'Patient service revenue',
                    ],
                ]);
            }
        });

        return $this->index();
    }
}