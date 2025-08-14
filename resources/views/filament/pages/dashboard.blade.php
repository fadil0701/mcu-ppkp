<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Welcome Section with Bright Gradient -->
        <div class="bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-600 rounded-xl p-8 text-white shadow-lg">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-3">🎉 Selamat Datang di Dashboard MCU</h1>
                    <p class="text-pink-100 text-lg">Sistem Monitoring Medical Check Up PPKP DKI Jakarta</p>
                    <div class="mt-4 flex items-center space-x-4">
                        <div class="bg-white/20 rounded-lg px-4 py-2">
                            <span class="text-sm font-medium">Status: Online</span>
                        </div>
                        <div class="bg-white/20 rounded-lg px-4 py-2">
                            <span class="text-sm font-medium">Users: {{ \App\Models\User::count() }}</span>
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm text-pink-200">Terakhir diperbarui</div>
                    <div class="font-semibold text-xl">{{ now()->format('d/m/Y H:i') }}</div>
                    <div class="mt-2">
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions with Bright Colors -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <a href="{{ route('filament.admin.resources.participants.create') }}" 
               class="group bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="bg-white/20 rounded-xl p-4 mr-4 group-hover:bg-white/30 transition-colors">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-lg">Tambah Peserta</h3>
                        <p class="text-blue-100">Daftarkan peserta baru</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('filament.admin.resources.schedules.create') }}" 
               class="group bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="bg-white/20 rounded-xl p-4 mr-4 group-hover:bg-white/30 transition-colors">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-lg">Jadwalkan MCU</h3>
                        <p class="text-emerald-100">Buat jadwal pemeriksaan</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('filament.admin.resources.mcu-results.create') }}" 
               class="group bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="bg-white/20 rounded-xl p-4 mr-4 group-hover:bg-white/30 transition-colors">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-lg">Upload Hasil</h3>
                        <p class="text-purple-100">Upload hasil MCU</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('filament.admin.pages.reports') }}" 
               class="group bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-center">
                    <div class="bg-white/20 rounded-xl p-4 mr-4 group-hover:bg-white/30 transition-colors">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-white text-lg">Laporan</h3>
                        <p class="text-orange-100">Lihat laporan MCU</p>
                    </div>
                </div>
            </a>
        </div>

        <!-- Statistics Cards with Bright Colors -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl p-6 shadow-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-bold">{{ \App\Models\Participant::count() }}</h3>
                        <p class="text-cyan-100 font-medium">Total Peserta</p>
                    </div>
                    <div class="bg-white/20 rounded-xl p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-6 shadow-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-bold">{{ \App\Models\Schedule::where('status', 'Terjadwal')->count() }}</h3>
                        <p class="text-green-100 font-medium">Terjadwal</p>
                    </div>
                    <div class="bg-white/20 rounded-xl p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl p-6 shadow-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-bold">{{ \App\Models\McuResult::count() }}</h3>
                        <p class="text-violet-100 font-medium">Selesai MCU</p>
                    </div>
                    <div class="bg-white/20 rounded-xl p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl p-6 shadow-lg text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-3xl font-bold">{{ \App\Models\Schedule::where('status', 'Terjadwal')->where('tanggal_pemeriksaan', '>=', now())->count() }}</h3>
                        <p class="text-amber-100 font-medium">Pending MCU</p>
                    </div>
                    <div class="bg-white/20 rounded-xl p-3">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information with Bright Design -->
        <div class="bg-gradient-to-br from-slate-50 to-blue-50 rounded-xl shadow-lg border border-blue-100">
            <div class="p-6 border-b border-blue-200">
                <h2 class="text-xl font-bold text-gray-800 flex items-center">
                    <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Informasi Sistem
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-green-400 to-green-500 rounded-xl p-6 mb-4 group-hover:shadow-lg transition-shadow">
                            <svg class="w-12 h-12 text-white mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Sistem Aman</h3>
                        <p class="text-gray-600 text-sm">Data dilindungi dengan enkripsi tingkat tinggi</p>
                    </div>
                    
                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-blue-400 to-blue-500 rounded-xl p-6 mb-4 group-hover:shadow-lg transition-shadow">
                            <svg class="w-12 h-12 text-white mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Performa Optimal</h3>
                        <p class="text-gray-600 text-sm">Sistem berjalan dengan kecepatan maksimal</p>
                    </div>
                    
                    <div class="text-center group">
                        <div class="bg-gradient-to-br from-purple-400 to-purple-500 rounded-xl p-6 mb-4 group-hover:shadow-lg transition-shadow">
                            <svg class="w-12 h-12 text-white mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 100 19.5 9.75 9.75 0 000-19.5z"></path>
                            </svg>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">24/7 Tersedia</h3>
                        <p class="text-gray-600 text-sm">Sistem dapat diakses kapan saja</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
