/**
 * CKEditor 5 Classic untuk form Email Template (Body HTML).
 * Hanya di-load di halaman create/edit email template.
 */
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

const container = document.getElementById('body_html_editor');
const hiddenInput = document.getElementById('body_html');
const initialScript = document.getElementById('body_html_initial');
let initialData = '';
if (initialScript && initialScript.textContent) {
    try {
        initialData = JSON.parse(initialScript.textContent) || '';
    } catch (_) {
        initialData = '';
    }
}

if (container && hiddenInput) {
    // Toolbar lengkap: semua fitur yang disediakan oleh build Classic (pre-built).
    // Untuk fitur tambahan (font size, font color, underline, dll) butuh custom build.
    ClassicEditor.create(container, {
        initialData: initialData,
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', '|',
                'link', 'blockQuote', 'insertTable', '|',
                'bulletedList', 'numberedList', 'outdent', 'indent', '|',
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: false
        },
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraf', class: 'ck-heading_paragraph' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
            ]
        }
    }).then(editor => {
        window.emailBodyEditor = editor;
        const form = container.closest('form');
        if (form) {
            form.addEventListener('submit', () => {
                hiddenInput.value = editor.getData();
            });
        }
    }).catch(err => {
        console.error('CKEditor error:', err);
    });
}
