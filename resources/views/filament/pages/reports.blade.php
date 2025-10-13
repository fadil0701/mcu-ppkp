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
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Participants</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ \App\Models\Participant::count() }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-700">
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Scheduled MCU</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ \App\Models\Schedule::count() }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-700">
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">MCU Results</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ \App\Models\McuResult::count() }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-700">
                <div class="text-center">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Pending MCU</p>
                    <p class="text-2xl font-semibold text-gray-900 dark:text-gray-100">{{ \App\Models\Participant::where('status_mcu', 'Belum MCU')->count() }}</p>
                </div>
            </div>
        </div>

        <!-- Download Reports -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border border-gray-100 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Download Reports</h3>

            @php
                $start = $this->data['start_date'] ?? null;
                if ($start instanceof \DateTimeInterface) { $start = $start->format('Y-m-d'); }
                $end = $this->data['end_date'] ?? null;
                if ($end instanceof \DateTimeInterface) { $end = $end->format('Y-m-d'); }
                $filters = [
                    'start_date' => $start,
                    'end_date' => $end,
                    'skpd' => $this->data['skpd'] ?? null,
                    'status_pegawai' => $this->data['status_pegawai'] ?? null,
                ];
                $query = http_build_query(array_filter($filters, fn($v) => filled($v)));
            @endphp

            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">
                <a href="{{ route('filament.admin.pages.reports.download', 'participants') . ($query ? ('?' . $query) : '') }}" class="bg-blue-100 hover:bg-blue-200 text-blue-700 dark:bg-blue-900/40 dark:hover:bg-blue-900/60 dark:text-blue-300 px-4 py-2 rounded-md text-center">Download Participants</a>
                <a href="{{ route('filament.admin.pages.reports.download', 'schedules') . ($query ? ('?' . $query) : '') }}" class="bg-green-100 hover:bg-green-200 text-green-700 dark:bg-green-900/40 dark:hover:bg-green-900/60 dark:text-green-300 px-4 py-2 rounded-md text-center">Download Schedules</a>
                <a href="{{ route('filament.admin.pages.reports.download', 'mcu') . ($query ? ('?' . $query) : '') }}" class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 dark:bg-yellow-900/40 dark:hover:bg-yellow-900/60 dark:text-yellow-300 px-4 py-2 rounded-md text-center">Download MCU Results</a>
                <a href="{{ route('filament.admin.pages.reports.download', 'diagnoses') . ($query ? ('?' . $query) : '') }}" class="bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/40 dark:hover:bg-red-900/60 dark:text-red-300 px-4 py-2 rounded-md text-center">Download Diagnoses</a>
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
