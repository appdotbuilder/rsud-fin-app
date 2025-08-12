import React from 'react';
import { Head } from '@inertiajs/react';
import AppLayout from '@/layouts/app-layout';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { router } from '@inertiajs/react';
import { type BreadcrumbItem } from '@/types';

interface BudgetSummary {
    budget_type: string;
    total_planned: number;
    total_revised: number;
    total_realized: number;
    total_remaining: number;
}

interface PatientBillSummary {
    payment_status: string;
    count: number;
    total_amount: number;
    outstanding: number;
}

interface Transaction {
    id: number;
    journal_number: string;
    transaction_date: string;
    description: string;
    total_debit: number;
    status: string;
    creator: {
        name: string;
    };
}

interface Props {
    currentPeriod: {
        id: number;
        name: string;
        year: number;
        status: string;
    } | null;
    budgetSummary: Record<string, BudgetSummary>;
    revenueTotal: BudgetSummary | null;
    expenseTotal: BudgetSummary | null;
    patientBillingSummary: Record<string, PatientBillSummary>;
    recentTransactions: Transaction[];
    cashFlow: {
        operating_cash_flow: number;
        investing_cash_flow: number;
        financing_cash_flow: number;
        net_cash_flow: number;
    };
    kpis: {
        total_patients_today: number;
        pending_bills_count: number;
        pending_bills_amount: number;
        budget_utilization: number;
    };
    [key: string]: unknown;
}

export default function FinancialDashboard({ 
    currentPeriod, 
    revenueTotal, 
    expenseTotal, 
    patientBillingSummary, 
    recentTransactions,
    cashFlow,
    kpis
}: Props) {
    const formatRupiah = (amount: number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0,
        }).format(amount);
    };

    const formatNumber = (number: number) => {
        return new Intl.NumberFormat('id-ID').format(number);
    };

    const handleCreateTransaction = () => {
        router.post(route('financial.dashboard'), {}, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    const getStatusBadgeVariant = (status: string) => {
        switch (status) {
            case 'paid':
            case 'posted':
            case 'approved':
                return 'default';
            case 'partial':
            case 'draft':
                return 'secondary';
            case 'unpaid':
            case 'overdue':
                return 'destructive';
            default:
                return 'outline';
        }
    };

    const breadcrumbs: BreadcrumbItem[] = [
        {
            title: 'Dashboard Keuangan',
            href: '/financial',
        },
    ];

    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard Keuangan RSUD" />
            
            <div className="space-y-6">
                {/* Header */}
                <div className="flex items-center justify-between">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900">🏥 Dashboard Keuangan RSUD</h1>
                        <p className="text-gray-600 mt-1">
                            Sistem Manajemen Keuangan BLUD - {currentPeriod ? `Periode ${currentPeriod.name} ${currentPeriod.year}` : 'Belum ada periode aktif'}
                        </p>
                    </div>
                    <Button onClick={handleCreateTransaction} className="bg-blue-600 hover:bg-blue-700">
                        📝 Tambah Transaksi Sample
                    </Button>
                </div>

                {/* KPI Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Pasien Hari Ini</CardTitle>
                            <span className="text-2xl">👥</span>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold">{formatNumber(kpis.total_patients_today)}</div>
                            <p className="text-xs text-muted-foreground">
                                Pendaftaran pasien baru
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Tagihan Tertunda</CardTitle>
                            <span className="text-2xl">📋</span>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-orange-600">{formatNumber(kpis.pending_bills_count)}</div>
                            <p className="text-xs text-muted-foreground">
                                {formatRupiah(kpis.pending_bills_amount)}
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Utilisasi Anggaran</CardTitle>
                            <span className="text-2xl">📊</span>
                        </CardHeader>
                        <CardContent>
                            <div className="text-2xl font-bold text-green-600">
                                {kpis.budget_utilization.toFixed(1)}%
                            </div>
                            <p className="text-xs text-muted-foreground">
                                Realisasi anggaran pendapatan
                            </p>
                        </CardContent>
                    </Card>

                    <Card>
                        <CardHeader className="flex flex-row items-center justify-between space-y-0 pb-2">
                            <CardTitle className="text-sm font-medium">Arus Kas Bersih</CardTitle>
                            <span className="text-2xl">💰</span>
                        </CardHeader>
                        <CardContent>
                            <div className={`text-2xl font-bold ${cashFlow.net_cash_flow >= 0 ? 'text-green-600' : 'text-red-600'}`}>
                                {formatRupiah(cashFlow.net_cash_flow)}
                            </div>
                            <p className="text-xs text-muted-foreground">
                                Cash flow bulan ini
                            </p>
                        </CardContent>
                    </Card>
                </div>

                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {/* Budget Overview */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                📈 Ringkasan Anggaran
                            </CardTitle>
                        </CardHeader>
                        <CardContent className="space-y-4">
                            {revenueTotal && (
                                <div className="p-4 bg-green-50 rounded-lg">
                                    <h4 className="font-semibold text-green-800 mb-2">Pendapatan</h4>
                                    <div className="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p className="text-gray-600">Direncanakan</p>
                                            <p className="font-semibold">{formatRupiah(revenueTotal.total_planned)}</p>
                                        </div>
                                        <div>
                                            <p className="text-gray-600">Realisasi</p>
                                            <p className="font-semibold text-green-600">{formatRupiah(revenueTotal.total_realized)}</p>
                                        </div>
                                    </div>
                                </div>
                            )}

                            {expenseTotal && (
                                <div className="p-4 bg-red-50 rounded-lg">
                                    <h4 className="font-semibold text-red-800 mb-2">Belanja</h4>
                                    <div className="grid grid-cols-2 gap-4 text-sm">
                                        <div>
                                            <p className="text-gray-600">Direncanakan</p>
                                            <p className="font-semibold">{formatRupiah(expenseTotal.total_planned)}</p>
                                        </div>
                                        <div>
                                            <p className="text-gray-600">Realisasi</p>
                                            <p className="font-semibold text-red-600">{formatRupiah(expenseTotal.total_realized)}</p>
                                        </div>
                                    </div>
                                </div>
                            )}

                            {(!revenueTotal && !expenseTotal) && (
                                <div className="text-center py-8 text-gray-500">
                                    <p>🏗️ Belum ada data anggaran</p>
                                    <p className="text-sm mt-1">Data akan muncul setelah setup periode keuangan</p>
                                </div>
                            )}
                        </CardContent>
                    </Card>

                    {/* Patient Billing Summary */}
                    <Card>
                        <CardHeader>
                            <CardTitle className="flex items-center gap-2">
                                🧾 Ringkasan Tagihan Pasien
                            </CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div className="space-y-3">
                                {Object.entries(patientBillingSummary).length > 0 ? (
                                    Object.entries(patientBillingSummary).map(([status, data]) => (
                                        <div key={status} className="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                            <div className="flex items-center gap-3">
                                                <Badge variant={getStatusBadgeVariant(status)}>
                                                    {status.charAt(0).toUpperCase() + status.slice(1)}
                                                </Badge>
                                                <span className="font-medium">{formatNumber(data.count)} tagihan</span>
                                            </div>
                                            <div className="text-right">
                                                <p className="font-semibold">{formatRupiah(data.total_amount)}</p>
                                                {data.outstanding > 0 && (
                                                    <p className="text-xs text-red-600">
                                                        Outstanding: {formatRupiah(data.outstanding)}
                                                    </p>
                                                )}
                                            </div>
                                        </div>
                                    ))
                                ) : (
                                    <div className="text-center py-8 text-gray-500">
                                        <p>📋 Belum ada tagihan bulan ini</p>
                                        <p className="text-sm mt-1">Data tagihan pasien akan muncul di sini</p>
                                    </div>
                                )}
                            </div>
                        </CardContent>
                    </Card>
                </div>

                {/* Recent Transactions */}
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2">
                            📝 Transaksi Terbaru
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="space-y-3">
                            {recentTransactions.length > 0 ? (
                                recentTransactions.map((transaction) => (
                                    <div key={transaction.id} className="flex items-center justify-between p-3 border rounded-lg">
                                        <div className="flex-1">
                                            <div className="flex items-center gap-2">
                                                <span className="font-mono text-sm text-blue-600">{transaction.journal_number}</span>
                                                <Badge variant={getStatusBadgeVariant(transaction.status)}>
                                                    {transaction.status}
                                                </Badge>
                                            </div>
                                            <p className="text-sm text-gray-600 mt-1">{transaction.description}</p>
                                            <p className="text-xs text-gray-500">
                                                {transaction.creator?.name} • {new Date(transaction.transaction_date).toLocaleDateString('id-ID')}
                                            </p>
                                        </div>
                                        <div className="text-right">
                                            <p className="font-semibold">{formatRupiah(transaction.total_debit)}</p>
                                        </div>
                                    </div>
                                ))
                            ) : (
                                <div className="text-center py-8 text-gray-500">
                                    <p>📝 Belum ada transaksi</p>
                                    <p className="text-sm mt-1">Transaksi jurnal akan muncul di sini</p>
                                </div>
                            )}
                        </div>
                    </CardContent>
                </Card>

                {/* Cash Flow Summary */}
                <Card>
                    <CardHeader>
                        <CardTitle className="flex items-center gap-2">
                            💸 Ringkasan Arus Kas
                        </CardTitle>
                    </CardHeader>
                    <CardContent>
                        <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div className="text-center p-4 bg-green-50 rounded-lg">
                                <p className="text-sm text-green-700">Arus Kas Operasional</p>
                                <p className="text-lg font-bold text-green-600">{formatRupiah(cashFlow.operating_cash_flow)}</p>
                            </div>
                            <div className="text-center p-4 bg-blue-50 rounded-lg">
                                <p className="text-sm text-blue-700">Arus Kas Investasi</p>
                                <p className={`text-lg font-bold ${cashFlow.investing_cash_flow >= 0 ? 'text-blue-600' : 'text-red-600'}`}>
                                    {formatRupiah(cashFlow.investing_cash_flow)}
                                </p>
                            </div>
                            <div className="text-center p-4 bg-purple-50 rounded-lg">
                                <p className="text-sm text-purple-700">Arus Kas Pendanaan</p>
                                <p className={`text-lg font-bold ${cashFlow.financing_cash_flow >= 0 ? 'text-purple-600' : 'text-red-600'}`}>
                                    {formatRupiah(cashFlow.financing_cash_flow)}
                                </p>
                            </div>
                            <div className="text-center p-4 bg-gray-50 rounded-lg">
                                <p className="text-sm text-gray-700">Arus Kas Bersih</p>
                                <p className={`text-lg font-bold ${cashFlow.net_cash_flow >= 0 ? 'text-green-600' : 'text-red-600'}`}>
                                    {formatRupiah(cashFlow.net_cash_flow)}
                                </p>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </AppLayout>
    );
}