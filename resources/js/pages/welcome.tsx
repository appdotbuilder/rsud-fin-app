import { type SharedData } from '@/types';
import { Head, Link, usePage } from '@inertiajs/react';

export default function Welcome() {
    const { auth } = usePage<SharedData>().props;

    return (
        <>
            <Head title="RSUD Financial Management System">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="flex min-h-screen flex-col bg-gradient-to-br from-blue-50 via-white to-green-50">
                {/* Navigation */}
                <header className="w-full p-6">
                    <nav className="flex items-center justify-between max-w-7xl mx-auto">
                        <div className="flex items-center gap-2">
                            <span className="text-2xl">🏥</span>
                            <span className="font-bold text-xl text-gray-900">RSUD Financial</span>
                        </div>
                        <div className="flex items-center gap-4">
                            {auth.user ? (
                                <Link
                                    href={route('dashboard')}
                                    className="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors"
                                >
                                    Dashboard
                                </Link>
                            ) : (
                                <div className="flex gap-3">
                                    <Link
                                        href={route('login')}
                                        className="px-4 py-2 text-gray-700 hover:text-blue-600 font-medium transition-colors"
                                    >
                                        Masuk
                                    </Link>
                                    <Link
                                        href={route('register')}
                                        className="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors"
                                    >
                                        Daftar
                                    </Link>
                                </div>
                            )}
                        </div>
                    </nav>
                </header>

                {/* Hero Section */}
                <main className="flex-1 flex items-center justify-center px-6">
                    <div className="max-w-6xl mx-auto">
                        <div className="text-center mb-12">
                            <div className="flex justify-center mb-6">
                                <div className="w-20 h-20 bg-blue-600 rounded-2xl flex items-center justify-center">
                                    <span className="text-3xl">🏥</span>
                                </div>
                            </div>
                            <h1 className="text-5xl font-bold text-gray-900 mb-6">
                                Sistem Manajemen Keuangan
                                <br />
                                <span className="text-blue-600">RSUD BLUD</span>
                            </h1>
                            <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                                Platform terintegrasi untuk mengelola keuangan Rumah Sakit Umum Daerah sesuai standar 
                                Badan Layanan Umum Daerah (BLUD) dan regulasi Kemendagri Indonesia
                            </p>
                            <div className="flex justify-center gap-4">
                                {auth.user ? (
                                    <Link
                                        href={route('financial.dashboard')}
                                        className="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors text-lg"
                                    >
                                        <span className="mr-2">📊</span>
                                        Buka Dashboard Keuangan
                                    </Link>
                                ) : (
                                    <Link
                                        href={route('register')}
                                        className="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors text-lg"
                                    >
                                        <span className="mr-2">🚀</span>
                                        Mulai Sekarang
                                    </Link>
                                )}
                                <a 
                                    href="#features"
                                    className="inline-flex items-center px-8 py-4 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-blue-600 hover:text-blue-600 transition-colors text-lg"
                                >
                                    <span className="mr-2">📋</span>
                                    Lihat Fitur
                                </a>
                            </div>
                        </div>

                        {/* Features Grid */}
                        <div id="features" className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
                            <div className="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                                <div className="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mb-4">
                                    <span className="text-2xl">📊</span>
                                </div>
                                <h3 className="text-xl font-bold text-gray-900 mb-3">Manajemen Anggaran</h3>
                                <p className="text-gray-600">Perencanaan, monitoring, dan kontrol anggaran APBD sesuai regulasi BLUD</p>
                            </div>

                            <div className="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                                <div className="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mb-4">
                                    <span className="text-2xl">💰</span>
                                </div>
                                <h3 className="text-xl font-bold text-gray-900 mb-3">Manajemen Pendapatan</h3>
                                <p className="text-gray-600">Integrasi billing pasien, piutang, penerimaan kas, dan klaim BPJS</p>
                            </div>

                            <div className="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                                <div className="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center mb-4">
                                    <span className="text-2xl">🛒</span>
                                </div>
                                <h3 className="text-xl font-bold text-gray-900 mb-3">Manajemen Belanja</h3>
                                <p className="text-gray-600">Pengadaan, hutang, pembayaran kas/bank, dan penggajian</p>
                            </div>

                            <div className="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                                <div className="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mb-4">
                                    <span className="text-2xl">📚</span>
                                </div>
                                <h3 className="text-xl font-bold text-gray-900 mb-3">Buku Besar & Akuntansi</h3>
                                <p className="text-gray-600">Jurnal, bagan akun, neraca saldo sesuai standar akuntansi pemerintahan</p>
                            </div>

                            <div className="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                                <div className="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center mb-4">
                                    <span className="text-2xl">🏢</span>
                                </div>
                                <h3 className="text-xl font-bold text-gray-900 mb-3">Manajemen Aset Tetap</h3>
                                <p className="text-gray-600">Akuisisi, penyusutan, dan pelepasan aset sesuai regulasi BMD</p>
                            </div>

                            <div className="bg-white p-8 rounded-2xl shadow-lg border border-gray-100 hover:shadow-xl transition-shadow">
                                <div className="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center mb-4">
                                    <span className="text-2xl">📈</span>
                                </div>
                                <h3 className="text-xl font-bold text-gray-900 mb-3">Pelaporan Keuangan</h3>
                                <p className="text-gray-600">Laporan keuangan lengkap: Neraca, LO, LAK, LPE, CaLK, dan LRA</p>
                            </div>
                        </div>

                        {/* Key Benefits */}
                        <div className="bg-white p-12 rounded-3xl shadow-xl border border-gray-100 mb-16">
                            <h2 className="text-3xl font-bold text-center text-gray-900 mb-8">
                                🎯 Keunggulan Sistem
                            </h2>
                            <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div className="flex items-start gap-4">
                                    <div className="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <span className="text-white text-sm">✓</span>
                                    </div>
                                    <div>
                                        <h4 className="font-semibold text-lg text-gray-900">Compliance BLUD</h4>
                                        <p className="text-gray-600">Sesuai regulasi Kemendagri dan standar akuntansi pemerintahan</p>
                                    </div>
                                </div>
                                <div className="flex items-start gap-4">
                                    <div className="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <span className="text-white text-sm">✓</span>
                                    </div>
                                    <div>
                                        <h4 className="font-semibold text-lg text-gray-900">Multi-User Access</h4>
                                        <p className="text-gray-600">Role-based permissions untuk berbagai tingkat akses pengguna</p>
                                    </div>
                                </div>
                                <div className="flex items-start gap-4">
                                    <div className="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <span className="text-white text-sm">✓</span>
                                    </div>
                                    <div>
                                        <h4 className="font-semibold text-lg text-gray-900">Data Integrity</h4>
                                        <p className="text-gray-600">Audit trail lengkap dan kontrol internal yang ketat</p>
                                    </div>
                                </div>
                                <div className="flex items-start gap-4">
                                    <div className="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                        <span className="text-white text-sm">✓</span>
                                    </div>
                                    <div>
                                        <h4 className="font-semibold text-lg text-gray-900">Real-time Reporting</h4>
                                        <p className="text-gray-600">Dashboard dan laporan keuangan secara real-time</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* CTA Section */}
                        <div className="text-center">
                            <h2 className="text-3xl font-bold text-gray-900 mb-4">
                                Siap Modernisasi Sistem Keuangan RSUD?
                            </h2>
                            <p className="text-xl text-gray-600 mb-8">
                                Bergabunglah dengan puluhan RSUD yang telah mempercayakan sistem keuangan mereka
                            </p>
                            {!auth.user && (
                                <div className="flex justify-center gap-4">
                                    <Link
                                        href={route('register')}
                                        className="inline-flex items-center px-8 py-4 bg-blue-600 text-white font-semibold rounded-xl hover:bg-blue-700 transition-colors text-lg"
                                    >
                                        <span className="mr-2">🚀</span>
                                        Mulai Gratis
                                    </Link>
                                    <Link
                                        href={route('login')}
                                        className="inline-flex items-center px-8 py-4 border-2 border-gray-300 text-gray-700 font-semibold rounded-xl hover:border-blue-600 hover:text-blue-600 transition-colors text-lg"
                                    >
                                        <span className="mr-2">👤</span>
                                        Sudah Punya Akun?
                                    </Link>
                                </div>
                            )}
                        </div>
                    </div>
                </main>

                {/* Footer */}
                <footer className="border-t border-gray-200 mt-16">
                    <div className="max-w-7xl mx-auto px-6 py-8">
                        <div className="flex justify-between items-center">
                            <div className="flex items-center gap-2">
                                <span className="text-xl">🏥</span>
                                <span className="font-semibold text-gray-900">RSUD Financial Management System</span>
                            </div>
                            <div className="text-sm text-gray-600">
                                Built with ❤️ for Indonesian Healthcare
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}