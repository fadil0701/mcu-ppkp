<div class="space-y-4 text-sm">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Tips 1 -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="font-semibold text-gray-900 mb-2">✏️ Cara Menulis Template</h4>
            <ul class="space-y-1 text-gray-600">
                <li>• Ketik teks biasa seperti menulis pesan WhatsApp</li>
                <li>• Gunakan variabel dengan format: <code class="bg-gray-200 px-1 rounded">{nama_variabel}</code></li>
                <li>• Baris baru akan dipertahankan dalam pesan</li>
                <li>• Bisa menggunakan emoji 😊</li>
            </ul>
        </div>

        <!-- Tips 2 -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="font-semibold text-gray-900 mb-2">📝 Variabel yang Tersedia</h4>
            <ul class="space-y-1 text-gray-600 text-xs">
                <li>• <code class="bg-gray-200 px-1 rounded">{nama_lengkap}</code> - Nama peserta</li>
                <li>• <code class="bg-gray-200 px-1 rounded">{nik_ktp}</code> - NIK KTP</li>
                <li>• <code class="bg-gray-200 px-1 rounded">{nrk_pegawai}</code> - NRK Pegawai</li>
                <li>• <code class="bg-gray-200 px-1 rounded">{tanggal_pemeriksaan}</code> - Tanggal MCU</li>
                <li>• <code class="bg-gray-200 px-1 rounded">{jam_pemeriksaan}</code> - Jam MCU</li>
                <li>• <code class="bg-gray-200 px-1 rounded">{lokasi_pemeriksaan}</code> - Lokasi MCU</li>
                <li>• <code class="bg-gray-200 px-1 rounded">{queue_number}</code> - Nomor antrian</li>
                <li>• <code class="bg-gray-200 px-1 rounded">{skpd}</code> - SKPD</li>
                <li>• <code class="bg-gray-200 px-1 rounded">{ukpd}</code> - UKPD</li>
            </ul>
        </div>

        <!-- Tips 3 -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="font-semibold text-gray-900 mb-2">💡 Best Practices</h4>
            <ul class="space-y-1 text-gray-600">
                <li>• Gunakan bahasa yang sopan dan profesional</li>
                <li>• Jaga pesan tetap singkat dan jelas</li>
                <li>• Sertakan informasi penting (tanggal, jam, lokasi)</li>
                <li>• Gunakan emoji untuk membuat pesan lebih menarik</li>
            </ul>
        </div>

        <!-- Tips 4 -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="font-semibold text-gray-900 mb-2">⚠️ Perhatian</h4>
            <ul class="space-y-1 text-gray-600">
                <li>• Variabel harus ditulis dengan benar (case-sensitive)</li>
                <li>• Jangan lupa tanda kurung kurawal { }</li>
                <li>• Test template sebelum kirim massal</li>
                <li>• Backup template sebelum edit</li>
            </ul>
        </div>
    </div>

    <!-- Contoh Template -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mt-4">
        <h4 class="font-semibold text-green-900 mb-2">📱 Contoh Template Lengkap:</h4>
        <pre class="bg-white p-3 rounded border text-xs text-gray-700 whitespace-pre-wrap">Halo {nama_lengkap}! 👋

Anda diundang untuk mengikuti Medical Check Up:
📅 Tanggal: {tanggal_pemeriksaan}
🕐 Jam: {jam_pemeriksaan}
📍 Lokasi: {lokasi_pemeriksaan}
🎫 Nomor Antrian: {queue_number}

Mohon hadir 15 menit sebelum jadwal.

Terima kasih! 🙏</pre>
    </div>
</div>
