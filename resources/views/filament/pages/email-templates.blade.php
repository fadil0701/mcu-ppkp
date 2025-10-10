<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M3 4a2 2 0 00-2 2v1.161l8.441 4.221a1.5 1.5 0 001.418 0L19 7.162V6a2 2 0 00-2-2H3z" />
                        <path d="M19 8.839l-7.77 3.885a2.75 2.75 0 01-2.46 0L1 8.839V14a2 2 0 002 2h14a2 2 0 002-2V8.839z" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">
                        Tentang Email Template Undangan
                    </h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <p>Template ini digunakan untuk mengirim undangan MCU via email. Edit subject dan isi email sesuai kebutuhan, gunakan variabel untuk personalisasi pesan secara otomatis.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="save">
            {{ $this->form }}

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 mt-6">
                @foreach ($this->getFormActions() as $action)
                    {{ $action }}
                @endforeach
            </div>
        </form>
    </div>
</x-filament-panels::page>
