<div class="space-y-4">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h4 class="font-semibold text-blue-900 mb-2">📋 Available Template Variables</h4>
        <p class="text-sm text-blue-700 mb-3">Use these variables in your email template by wrapping them with curly braces: <code>{variable_name}</code></p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @php
                $model = $getRecord();
                $variables = $model ? $model->getAvailableVariables() : [
                    'participant_name' => 'Nama peserta',
                    'participant_email' => 'Email peserta',
                    'examination_date' => 'Tanggal pemeriksaan',
                    'examination_time' => 'Jam pemeriksaan',
                    'examination_location' => 'Lokasi pemeriksaan',
                    'queue_number' => 'Nomor antrian',
                    'app_name' => 'Nama aplikasi',
                ];
            @endphp
            
            @foreach($variables as $key => $description)
                <div class="flex items-start space-x-2 bg-white p-2 rounded border">
                    <code class="text-xs bg-gray-100 px-2 py-1 rounded font-mono text-gray-800">
                        { {{ $key }} }
                    </code>
                    <span class="text-sm text-gray-600">{{ $description }}</span>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
        <h4 class="font-semibold text-amber-900 mb-2">💡 Tips</h4>
        <ul class="text-sm text-amber-700 space-y-1">
            <li>• Variables are case-sensitive</li>
            <li>• Always use double curly braces: <code>{variable_name}</code></li>
            <li>• HTML formatting works in the HTML body field</li>
            <li>• Plain text version should not contain HTML tags</li>
            <li>• Preview your template to see how variables will be replaced</li>
        </ul>
    </div>
</div>
