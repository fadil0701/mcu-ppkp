<x-filament-widgets::widget>
    <x-filament::section>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Database Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Database</h3>
                    <div class="flex items-center">
                        @if($database_status['status'] === 'healthy')
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        @elseif($database_status['status'] === 'warning')
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        @else
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        @endif
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-2">{{ $database_status['message'] }}</p>
                @if(isset($database_status['response_time']))
                    <p class="text-xs text-gray-500 mt-1">Response: {{ $database_status['response_time'] }}</p>
                @endif
            </div>

            <!-- Cache Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Cache</h3>
                    <div class="flex items-center">
                        @if($cache_status['status'] === 'healthy')
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        @elseif($cache_status['status'] === 'warning')
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        @else
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        @endif
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-2">{{ $cache_status['message'] }}</p>
            </div>

            <!-- Storage Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Storage</h3>
                    <div class="flex items-center">
                        @if($storage_status['status'] === 'healthy')
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        @elseif($storage_status['status'] === 'warning')
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        @else
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        @endif
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-2">{{ $storage_status['message'] }}</p>
            </div>

            <!-- Queue Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Queue</h3>
                    <div class="flex items-center">
                        @if($queue_status['status'] === 'healthy')
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        @elseif($queue_status['status'] === 'warning')
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        @else
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        @endif
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-2">{{ $queue_status['message'] }}</p>
            </div>

            <!-- Memory Usage -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Memory</h3>
                    <div class="flex items-center">
                        @if($memory_usage['status'] === 'healthy')
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        @elseif($memory_usage['status'] === 'warning')
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        @else
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        @endif
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-2">{{ $memory_usage['usage'] }} / {{ $memory_usage['limit'] }}</p>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-{{ $memory_usage['status'] === 'healthy' ? 'green' : ($memory_usage['status'] === 'warning' ? 'yellow' : 'red') }}-500 h-2 rounded-full" 
                         style="width: {{ $memory_usage['percentage'] }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ $memory_usage['percentage'] }}% used</p>
            </div>

            <!-- Disk Usage -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900">Disk Space</h3>
                    <div class="flex items-center">
                        @if($disk_usage['status'] === 'healthy')
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                        @elseif($disk_usage['status'] === 'warning')
                            <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                        @else
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                        @endif
                    </div>
                </div>
                <p class="text-sm text-gray-600 mt-2">{{ $disk_usage['free'] }} free of {{ $disk_usage['total'] }}</p>
                <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                    <div class="bg-{{ $disk_usage['status'] === 'healthy' ? 'green' : ($disk_usage['status'] === 'warning' ? 'yellow' : 'red') }}-500 h-2 rounded-full" 
                         style="width: {{ $disk_usage['percentage'] }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">{{ $disk_usage['percentage'] }}% used</p>
            </div>
        </div>

        <!-- Recent Errors -->
        @if(!empty($last_errors))
        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Errors</h3>
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="max-h-40 overflow-y-auto">
                    @foreach($last_errors as $error)
                        <p class="text-sm text-red-800 font-mono mb-1">{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>

