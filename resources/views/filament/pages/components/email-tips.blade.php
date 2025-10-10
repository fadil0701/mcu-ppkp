<div class="space-y-4 text-sm">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Tips 1 -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="font-semibold text-gray-900 mb-2">✏️ Cara Menulis Template</h4>
            <ul class="space-y-1 text-gray-600">
                <li>• Ketik teks biasa seperti menulis email</li>
                <li>• Gunakan variabel dengan format: <code class="bg-gray-200 px-1 rounded">{nama_variabel}</code></li>
                <li>• Baris baru akan dipertahankan dalam email</li>
                <li>• Format teks biasa (plain text), bukan HTML</li>
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
                <li>• Gunakan bahasa yang sopan dan formal</li>
                <li>• Jaga email tetap singkat dan jelas</li>
                <li>• Sertakan informasi penting (tanggal, jam, lokasi)</li>
                <li>• Berikan instruksi yang diperlukan</li>
                <li>• Sertakan kontak jika ada pertanyaan</li>
            </ul>
        </div>

        <!-- Tips 4 -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="font-semibold text-gray-900 mb-2">⚠️ Perhatian</h4>
            <ul class="space-y-1 text-gray-600">
                <li>• Variabel harus ditulis dengan benar (case-sensitive)</li>
                <li>• Jangan lupa tanda kurung kurawal { }</li>
                <li>• Subject email harus informatif dan jelas</li>
                <li>• Test template sebelum kirim massal</li>
            </ul>
        </div>
    </div>

    <!-- Contoh Template -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mt-4">
        <h4 class="font-semibold text-green-900 mb-2">📧 Contoh Template Email Lengkap:</h4>
        
        <div class="mb-3">
            <p class="text-xs font-semibold text-green-800 mb-1">Subject:</p>
            <pre class="bg-white p-2 rounded border text-xs text-gray-700">Undangan Medical Check Up - {nama_lengkap}</pre>
        </div>
        
        <div>
            <p class="text-xs font-semibold text-green-800 mb-1">Isi Email:</p>
            <pre class="bg-white p-3 rounded border text-xs text-gray-700 whitespace-pre-wrap">Kepada Yth. {nama_lengkap}

Dengan hormat,

Kami mengundang Bapak/Ibu untuk mengikuti Medical Check Up yang akan dilaksanakan pada:

Tanggal: {tanggal_pemeriksaan}
Waktu: {jam_pemeriksaan}
Lokasi: {lokasi_pemeriksaan}
Nomor Antrian: {queue_number}

CATATAN PENTING:
1. Harap hadir 15 menit sebelum jadwal
2. Membawa KTP/kartu identitas
3. Puasa 8 jam sebelum pemeriksaan
4. Menggunakan pakaian yang nyaman

Mohon konfirmasi kehadiran Anda melalui sistem atau hubungi kami jika berhalangan hadir.

Terima kasih atas perhatian dan kerjasamanya.

Hormat kami,
Tim Medical Check Up</pre>
        </div>
    </div>

    <!-- Format Tips -->
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-4">
        <h4 class="font-semibold text-yellow-900 mb-2">💬 Tips Format Email:</h4>
        <ul class="space-y-1 text-yellow-800 text-sm">
            <li>• <strong>Salam pembuka:</strong> "Kepada Yth." atau "Dengan hormat"</li>
            <li>• <strong>Isi utama:</strong> Informasi jadwal dan detail MCU</li>
            <li>• <strong>Instruksi:</strong> Apa yang perlu dibawa/dilakukan</li>
            <li>• <strong>Penutup:</strong> Ucapan terima kasih dan salam</li>
            <li>• <strong>Kontak:</strong> Informasi kontak jika diperlukan</li>
        </ul>
    </div>
</div>
