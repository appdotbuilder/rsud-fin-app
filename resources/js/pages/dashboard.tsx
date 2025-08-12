
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Dashboard() {
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="flex h-full flex-1 flex-col gap-6 rounded-xl p-6 overflow-x-auto">
                <div className="text-center">
                    <h1 className="text-3xl font-bold text-gray-900 mb-4">🏥 Selamat Datang di RSUD Financial</h1>
                    <p className="text-gray-600 mb-6">Sistem Manajemen Keuangan BLUD untuk Rumah Sakit Umum Daerah</p>
                    
                    <Link href="/financial">
                        <Button size="lg" className="bg-blue-600 hover:bg-blue-700">
                            📊 Buka Dashboard Keuangan
                        </Button>
                    </Link>
                </div>

                <div className="grid auto-rows-min gap-4 md:grid-cols-3">
                    <div className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-gradient-to-br from-blue-50 to-blue-100">
                        <div className="p-6 h-full flex flex-col justify-center items-center">
                            <div className="text-4xl mb-4">📊</div>
                            <h3 className="text-lg font-semibold text-gray-900 mb-2">Manajemen Anggaran</h3>
                            <p className="text-sm text-gray-600 text-center">Perencanaan dan monitoring anggaran BLUD</p>
                        </div>
                    </div>
                    <div className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-gradient-to-br from-green-50 to-green-100">
                        <div className="p-6 h-full flex flex-col justify-center items-center">
                            <div className="text-4xl mb-4">💰</div>
                            <h3 className="text-lg font-semibold text-gray-900 mb-2">Pendapatan</h3>
                            <p className="text-sm text-gray-600 text-center">Billing pasien dan klaim BPJS</p>
                        </div>
                    </div>
                    <div className="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border bg-gradient-to-br from-purple-50 to-purple-100">
                        <div className="p-6 h-full flex flex-col justify-center items-center">
                            <div className="text-4xl mb-4">📚</div>
                            <h3 className="text-lg font-semibold text-gray-900 mb-2">Akuntansi</h3>
                            <p className="text-sm text-gray-600 text-center">Jurnal dan laporan keuangan</p>
                        </div>
                    </div>
                </div>

                <div className="bg-white p-8 rounded-xl border border-gray-200 shadow-sm">
                    <h2 className="text-xl font-bold text-gray-900 mb-4">🎯 Fitur Utama Sistem</h2>
                    <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div className="flex items-start gap-3">
                            <div className="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <span className="text-white text-sm">✓</span>
                            </div>
                            <div>
                                <h4 className="font-semibold text-gray-900">Compliance BLUD</h4>
                                <p className="text-gray-600 text-sm">Sesuai regulasi Kemendagri dan standar akuntansi pemerintahan</p>
                            </div>
                        </div>
                        <div className="flex items-start gap-3">
                            <div className="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <span className="text-white text-sm">✓</span>
                            </div>
                            <div>
                                <h4 className="font-semibold text-gray-900">Integrasi BPJS</h4>
                                <p className="text-gray-600 text-sm">Manajemen klaim dan billing terintegrasi</p>
                            </div>
                        </div>
                        <div className="flex items-start gap-3">
                            <div className="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <span className="text-white text-sm">✓</span>
                            </div>
                            <div>
                                <h4 className="font-semibold text-gray-900">Pelaporan Real-time</h4>
                                <p className="text-gray-600 text-sm">Dashboard dan laporan keuangan secara real-time</p>
                            </div>
                        </div>
                        <div className="flex items-start gap-3">
                            <div className="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <span className="text-white text-sm">✓</span>
                            </div>
                            <div>
                                <h4 className="font-semibold text-gray-900">Audit Trail</h4>
                                <p className="text-gray-600 text-sm">Pelacakan lengkap untuk transparansi dan akuntabilitas</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppLayout>
    );
}
