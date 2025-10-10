@php
    $editorId = 'ckeditor5-' . $getStatePath();
    $buildType = 'collaborative-document';
    $height = 400;
    $config = [
        'toolbar' => [
            'heading', '|', 'bold', 'italic', 'underline', '|',
            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', '|',
            'alignment', '|', 'numberedList', 'bulletedList', 'outdent', 'indent', '|',
            'link', 'insertTable', 'blockQuote', 'horizontalLine', 'specialCharacters', '|',
            'undo', 'redo', 'sourceEditing'
        ],
        'heading' => [
            'options' => [
                ['model' => 'paragraph', 'title' => 'Paragraph', 'class' => 'ck-heading_paragraph'],
                ['model' => 'heading1', 'view' => 'h1', 'title' => 'Heading 1', 'class' => 'ck-heading_heading1'],
                ['model' => 'heading2', 'view' => 'h2', 'title' => 'Heading 2', 'class' => 'ck-heading_heading2'],
                ['model' => 'heading3', 'view' => 'h3', 'title' => 'Heading 3', 'class' => 'ck-heading_heading3']
            ]
        ],
        'fontSize' => [
            'options' => [9, 10, 11, 12, 14, 16, 18, 20, 24, 28, 32, 36, 'default']
        ],
        'fontFamily' => [
            'options' => [
                'default',
                'Arial, Helvetica, sans-serif',
                'Times New Roman, Times, serif',
                'Courier New, Courier, monospace',
                'Georgia, serif',
                'Verdana, Geneva, sans-serif'
            ]
        ],
        'alignment' => [
            'options' => ['left', 'center', 'right', 'justify']
        ],
        'table' => [
            'contentToolbar' => ['tableColumn', 'tableRow', 'mergeTableCells']
        ],
        'link' => [
            'addTargetToExternalLinks' => true,
            'defaultProtocol' => 'https://',
        ],
        'htmlSupport' => [
            'allow' => [
                [
                    'name' => '.*',
                    'attributes' => true,
                    'classes' => true,
                    'styles' => true,
                ],
            ],
        ],
        'htmlEmbed' => [
            'showPreviews' => true,
        ],
        'sourceEditing' => [
            'allow' => [
                [
                    'name' => '.*',
                    'attributes' => true,
                    'classes' => true,
                    'styles' => true,
                ],
            ],
        ],
    ];
@endphp

<div class="fi-fo-field-wrp-label">
    <div class="ckeditor5-container" id="ckeditor5-container-{{ $getStatePath() }}">
        <!-- Hidden textarea for form data -->
        <textarea
            name="{{ $getStatePath() }}"
            id="{{ $editorId }}"
            style="display: none;"
        >{{ $getState() }}</textarea>

        {{-- Toolbar container for DecoupledEditor --}}
        <div
            id="{{ $editorId }}-toolbar"
            class="ckeditor5-toolbar-container"
            style="border: 1px solid #cbd5e0; border-bottom: none; border-radius: 0.375rem 0.375rem 0 0; background: #f7fafc; min-height: 50px;"
            wire:ignore.self
        ></div>

        {{-- Editor container --}}
        <div
            id="{{ $editorId }}-editor"
            class="ckeditor5-editor"
            style="min-height: {{ $height }}px; border: 1px solid #cbd5e0; border-radius: 0 0 0.375rem 0.375rem; padding: 1rem;"
            wire:ignore
        ></div>
    </div>
</div>

@push('scripts')
<script>
(function() {
    var editorId = '{{ $editorId }}';
    var config = @json($config);

    document.addEventListener('DOMContentLoaded', function() {
        console.log('[CKE Blade] Initializing Ultimate Fix Editor:', editorId);
        window.initCollaborativeEditor(editorId, config);
    });

    // Livewire hook to re-initialize editor if component is re-rendered
    if (typeof Livewire !== 'undefined') {
        Livewire.hook('element.initialized', (el, component) => {
            if (el.id === 'ckeditor5-container-{{ $getStatePath() }}') {
                console.log('[CKE Blade] Livewire element initialized, re-initializing editor:', editorId);
                window.initCollaborativeEditor(editorId, config);
            }
        });
    }
})();
</script>
@endpush