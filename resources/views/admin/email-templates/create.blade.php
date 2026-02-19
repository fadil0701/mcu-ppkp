@extends('layouts.app')

@section('title', 'Tambah Email Template')

@section('content')
<x-common.page-breadcrumb pageTitle="Tambah Email Template" />

<x-common.component-card title="Form Email Template">
    <form method="POST" action="{{ route('admin.email-templates.store') }}" class="space-y-4">
        @csrf
        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Nama <span class="text-error-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                @error('name')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Tipe <span class="text-error-500">*</span></label>
                <select name="type" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
                    <option value="mcu_invitation" {{ old('type') === 'mcu_invitation' ? 'selected' : '' }}>MCU Invitation</option>
                    <option value="reminder" {{ old('type') === 'reminder' ? 'selected' : '' }}>Reminder</option>
                    <option value="notification" {{ old('type') === 'notification' ? 'selected' : '' }}>Notification</option>
                    <option value="custom" {{ old('type') === 'custom' ? 'selected' : '' }}>Custom</option>
                </select>
                @error('type')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
            </div>
        </div>
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Subject <span class="text-error-500">*</span></label>
            <input type="text" name="subject" value="{{ old('subject') }}" required class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">
            @error('subject')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Variable</label>
            <p class="mb-2 text-theme-xs text-gray-500 dark:text-gray-400">Klik variabel untuk menyisipkan ke Body HTML (sesuai tipe template di atas).</p>
            <script type="application/json" id="variables-by-type">@json($availableVariablesByType ?? [])</script>
            <div id="variable-tags" class="flex flex-wrap gap-2 rounded-lg border border-gray-200 p-3 dark:border-gray-800 dark:bg-gray-800/50"></div>
        </div>

        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Body HTML</label>
            <textarea name="body_html" id="body_html" rows="12" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">{{ old('body_html', '') }}</textarea>
            @error('body_html')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Body Plain Text</label>
            <textarea name="body_text" rows="4" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">{{ old('body_text') }}</textarea>
            @error('body_text')<p class="mt-1 text-theme-xs text-error-500">{{ $message }}</p>@enderror
        </div>
        <div>
            <label class="mb-1 block text-theme-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi</label>
            <textarea name="description" rows="2" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-theme-sm dark:border-gray-800 dark:bg-gray-800 dark:text-white/90">{{ old('description') }}</textarea>
        </div>
        <div class="flex flex-wrap gap-4">
            <label class="flex items-center gap-2"><input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}> Aktif</label>
            <label class="flex items-center gap-2"><input type="checkbox" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}> Default</label>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="rounded-lg bg-brand-500 px-4 py-2 text-theme-sm font-medium text-white hover:bg-brand-600">Simpan</button>
            <a href="{{ route('admin.email-templates.index') }}" class="rounded-lg border border-gray-200 px-4 py-2 text-theme-sm font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-800 dark:text-gray-300 dark:hover:bg-white/5">Batal</a>
        </div>
    </form>
</x-common.component-card>
@endsection

@push('scripts')
    <script src="https://unpkg.com/tinymce@6/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var variablesByType = {};
        try {
            var el = document.getElementById('variables-by-type');
            if (el && el.textContent) variablesByType = JSON.parse(el.textContent);
        } catch (e) {}
        var typeSelect = document.querySelector('select[name="type"]');
        var tagsContainer = document.getElementById('variable-tags');

        function renderVariableTags() {
            var type = typeSelect ? typeSelect.value : 'mcu_invitation';
            var vars = variablesByType[type] || {};
            tagsContainer.innerHTML = '';
            Object.keys(vars).forEach(function(key) {
                var btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'rounded border border-gray-300 bg-gray-100 px-2 py-1 text-theme-xs font-mono text-gray-700 hover:bg-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600';
                btn.textContent = '{' + key + '}';
                btn.dataset.var = key;
                btn.onclick = function() {
                    var placeholder = '{' + key + '}';
                    if (typeof tinymce !== 'undefined' && tinymce.get('body_html')) {
                        tinymce.get('body_html').insertContent(placeholder);
                    } else {
                        var ta = document.getElementById('body_html');
                        if (ta) {
                            var start = ta.selectionStart, end = ta.selectionEnd;
                            ta.value = ta.value.slice(0, start) + placeholder + ta.value.slice(end);
                            ta.selectionStart = ta.selectionEnd = start + placeholder.length;
                        }
                    }
                };
                tagsContainer.appendChild(btn);
            });
        }
        if (typeSelect) typeSelect.addEventListener('change', renderVariableTags);
        renderVariableTags();

        tinymce.init({
            selector: '#body_html',
            height: 320,
            menubar: false,
            plugins: 'lists link table code charmap',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link table charmap | code | removeformat',
            block_formats: 'Paragraf=p; Heading 2=h2; Heading 3=h3',
            content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',
            branding: false,
            promotion: false,
            resize: true
        });
    });
    </script>
@endpush
