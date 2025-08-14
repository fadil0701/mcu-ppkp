<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Report Filters -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Report Filters</h3>
            {{ $this->form }}
        </div>

        <!-- Quick Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Participants</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ \App\Models\Participant::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Scheduled MCU</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ \App\Models\Schedule::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">MCU Results</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ \App\Models\McuResult::count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending MCU</p>
                        <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ \App\Models\Participant::where('status_mcu', 'Belum MCU')->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Report Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Generate & Download Reports</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <button wire:click="generateParticipantReport" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    Participant Report
                </button>

                <button wire:click="generateScheduleReport" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Schedule Report
                </button>

                <button wire:click="generateMcuReport" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    MCU Results Report
                </button>

                <button wire:click="generateDiagnosisReport" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Diagnosis Report
                </button>
            </div>

            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <a href="{{ route('filament.admin.pages.reports.download', 'participants') }}" class="bg-blue-100 hover:bg-blue-200 text-blue-700 dark:bg-blue-900/40 dark:hover:bg-blue-900/60 dark:text-blue-300 px-4 py-2 rounded-md text-center">Download Participants (CSV)</a>
                <a href="{{ route('filament.admin.pages.reports.download', 'schedules') }}" class="bg-green-100 hover:bg-green-200 text-green-700 dark:bg-green-900/40 dark:hover:bg-green-900/60 dark:text-green-300 px-4 py-2 rounded-md text-center">Download Schedules (CSV)</a>
                <a href="{{ route('filament.admin.pages.reports.download', 'mcu') }}" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 dark:bg-yellow-900/40 dark:hover:bg-yellow-900/60 dark:text-yellow-300 px-4 py-2 rounded-md text-center">Download MCU Results (CSV)</a>
                <a href="{{ route('filament.admin.pages.reports.download', 'diagnoses') }}" class="bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/40 dark:hover:bg-red-900/60 dark:text-red-300 px-4 py-2 rounded-md text-center">Download Diagnoses (CSV)</a>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Recent Activity</h3>
            <div class="space-y-4">
                @php
                    $recentParticipants = \App\Models\Participant::latest()->limit(5)->get();
                    $recentSchedules = \App\Models\Schedule::with('participant')->latest()->limit(5)->get();
                    $recentResults = \App\Models\McuResult::with('participant')->latest()->limit(5)->get();
                @endphp

                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    <div>
                        <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Recent Participants</h4>
                        <div class="space-y-2">
                            @foreach($recentParticipants as $participant)
                                <div class="text-sm text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">{{ $participant->nama_lengkap }}</span>
                                    <span class="text-gray-400 dark:text-gray-500">- {{ $participant->skpd }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Recent Schedules</h4>
                        <div class="space-y-2">
                            @foreach($recentSchedules as $schedule)
                                <div class="text-sm text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">{{ $schedule->participant->nama_lengkap ?? 'N/A' }}</span>
                                    <span class="text-gray-400 dark:text-gray-500">- {{ $schedule->tanggal_pemeriksaan_formatted }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-2">Recent Results</h4>
                        <div class="space-y-2">
                            @foreach($recentResults as $result)
                                <div class="text-sm text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">{{ $result->participant->nama_lengkap ?? 'N/A' }}</span>
                                    <span class="text-gray-400 dark:text-gray-500">- {{ $result->status_kesehatan }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
