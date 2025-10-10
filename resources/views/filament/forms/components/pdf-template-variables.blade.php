<div class="space-y-4">
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <h4 class="font-semibold text-blue-900 mb-2">📋 Available PDF Template Variables</h4>
        <p class="text-sm text-blue-700 mb-3">Use these variables in your PDF template by wrapping them with curly braces: <code>{variable_name}</code></p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            @php
                $model = $getRecord();
                $variables = $model ? $model->getAvailableVariables() : [
                    'letter_number' => 'Nomor surat',
                    'letter_date' => 'Tanggal surat',
                    'participant_name' => 'Nama peserta',
                    'participant_nik' => 'NIK peserta',
                    'examination_date' => 'Tanggal pemeriksaan',
                    'examination_time' => 'Waktu pemeriksaan',
                    'examination_location' => 'Lokasi pemeriksaan',
                    'organization_name' => 'Nama organisasi',
                    'signature_name' => 'Nama penandatangan',
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
        <h4 class="font-semibold text-amber-900 mb-2">💡 PDF Template Tips</h4>
        <ul class="text-sm text-amber-700 space-y-1">
            <li>• Variables are case-sensitive</li>
            <li>• Always use curly braces: <code>{variable_name}</code></li>
            <li>• HTML formatting works in all HTML fields</li>
            <li>• Use CSS for styling (included in the template)</li>
            <li>• Test your template with real data before using</li>
            <li>• PDF will be generated in A4 format by default</li>
        </ul>
    </div>
    
    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
        <h4 class="font-semibold text-green-900 mb-2">🎨 Styling Classes Available</h4>
        <div class="text-sm text-green-700 grid grid-cols-2 gap-2">
            <div><code>.header</code> - Document header</div>
            <div><code>.organization-name</code> - Organization title</div>
            <div><code>.letter-meta</code> - Letter metadata</div>
            <div><code>.participant-info</code> - Participant data table</div>
            <div><code>.examination-details</code> - Exam details table</div>
            <div><code>.contact-info</code> - Contact information box</div>
            <div><code>.footer</code> - Document footer</div>
            <div><code>.signature</code> - Signature section</div>
            <div><code>.stamp</code> - Official stamp</div>
            <div><code>.logo</code> - Organization logo</div>
        </div>
    </div>
</div>
