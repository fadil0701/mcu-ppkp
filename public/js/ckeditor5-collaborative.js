// CKEditor 5 Ultimate Fix - Regenerated 2025-10-08 04:48:24
console.log("🚀 CKEditor5 Ultimate Fix: Loading...");

var ckEditorInstances = {};

// Function to create fallback editor
function createFallbackEditor(editorId, editorContainer, textarea, initialData) {
    console.warn("🔄 Creating fallback editor...");
    editorContainer.innerHTML = `
        <div id="${editorId}-fallback-toolbar" style="border: 1px solid #ccc; border-bottom: none; background: #f0f0f0; padding: 5px; border-radius: 5px 5px 0 0;">
            <select onchange="document.execCommand('formatBlock', false, this.value); this.selectedIndex=0;">
                <option value="">Format</option>
                <option value="H1">Heading 1</option>
                <option value="H2">Heading 2</option>
                <option value="H3">Heading 3</option>
                <option value="P">Paragraph</option>
            </select>
            <button type="button" onclick="document.execCommand('bold', false, null)"><b>B</b></button>
            <button type="button" onclick="document.execCommand('italic', false, null)"><i>I</i></button>
            <button type="button" onclick="document.execCommand('underline', false, null)"><u>U</u></button>
            <button type="button" onclick="document.execCommand('justifyLeft', false, null)">Align Left</button>
            <button type="button" onclick="document.execCommand('justifyCenter', false, null)">Align Center</button>
            <button type="button" onclick="document.execCommand('justifyRight', false, null)">Align Right</button>
            <button type="button" onclick="document.execCommand('insertUnorderedList', false, null)">UL</button>
            <button type="button" onclick="document.execCommand('insertOrderedList', false, null)">OL</button>
            <button type="button" onclick="document.execCommand('outdent', false, null)">Outdent</button>
            <button type="button" onclick="document.execCommand('indent', false, null)">Indent</button>
            <button type="button" onclick="document.execCommand('createLink', true, 'http://')">Link</button>
            <button type="button" onclick="document.execCommand('undo', false, null)">Undo</button>
            <button type="button" onclick="document.execCommand('redo', false, null)">Redo</button>
        </div>
        <div id="${editorId}-fallback-editor" contenteditable="true" style="min-height: 400px; border: 1px solid #ccc; padding: 10px; border-radius: 0 0 5px 5px; background: white;"></div>
    `;
    const fallbackEditor = document.getElementById(`${editorId}-fallback-editor`);
    fallbackEditor.innerHTML = initialData || textarea.value;

    fallbackEditor.addEventListener("input", () => {
        textarea.value = fallbackEditor.innerHTML;
        textarea.dispatchEvent(new Event("input", { bubbles: true }));
        textarea.dispatchEvent(new Event("change", { bubbles: true }));
        console.log("🔄 Fallback editor data synced");
    });
    console.log("✅ Fallback editor created");
}

window.initCollaborativeEditor = async function(editorId, config) {
    const textarea = document.getElementById(editorId);
    const editorEl = document.getElementById(`${editorId}-editor`);
    const toolbarEl = document.getElementById(`${editorId}-toolbar`);

    if (!textarea || !editorEl || !toolbarEl) {
        console.error(`❌ Required elements not found for editorId: ${editorId}`);
        return;
    }
    
    console.log(`🚀 Initializing CKEditor 5: ${editorId}`);

    // Destroy existing instance
    if (ckEditorInstances[editorId]) {
        try {
            await ckEditorInstances[editorId].destroy();
            console.log(`🗑️ Destroyed existing editor instance for ${editorId}`);
        } catch (e) {
            console.warn(`⚠️ Could not destroy existing editor instance for ${editorId}:`, e);
        }
        delete ckEditorInstances[editorId];
    }

    // Show loading
    editorEl.innerHTML = "<div style=\"text-align: center; padding: 20px; color: #6b7280; font-family: Arial, sans-serif;\">Loading CKEditor 5...</div>";
    if (toolbarEl) toolbarEl.innerHTML = "";

    // Load CKEditor 5
    const scriptPath = "/ckeditor5/ckeditor.js";
    
    if (!window.DecoupledEditor) {
        console.log("📦 Loading CKEditor 5 from local build:", scriptPath);
        
        const script = document.createElement("script");
        script.src = scriptPath;
        script.defer = true;

        const loadPromise = new Promise((resolve, reject) => {
            script.onload = () => {
                if (window.DecoupledEditor) {
                    console.log("✅ CKEditor 5 loaded successfully");
                    resolve(window.DecoupledEditor);
                } else {
                    console.error("❌ DecoupledEditor not found after script load");
                    reject(new Error("DecoupledEditor not found"));
                }
            };
            script.onerror = (e) => {
                console.error(`❌ Failed to load CKEditor 5 script: ${scriptPath}`, e);
                reject(new Error(`Failed to load script: ${scriptPath}`));
            };
            document.head.appendChild(script);
        });

        try {
            window.DecoupledEditor = await loadPromise;
        } catch (error) {
            console.error(`❌ Error loading CKEditor 5:`, error);
            editorEl.innerHTML = "";
            createFallbackEditor(editorId, editorEl, textarea, textarea.value);
            return;
        }
    }

    try {
        const editor = await window.DecoupledEditor.create(editorEl, config);
        ckEditorInstances[editorId] = editor;

        // Mount toolbar
        if (toolbarEl && editor.ui && editor.ui.view && editor.ui.view.toolbar) {
            toolbarEl.innerHTML = "";
            toolbarEl.appendChild(editor.ui.view.toolbar.element);
            console.log("✅ Toolbar mounted");
        }

        // Set initial data
        var currentData = textarea.value || "";
        console.log("🔄 Setting initial data:", currentData.substring(0, 100) + "...");
        editor.setData(currentData);

        // Data sync
        editor.model.document.on("change:data", function() {
            textarea.value = editor.getData();
            textarea.dispatchEvent(new Event("input", { bubbles: true }));
            textarea.dispatchEvent(new Event("change", { bubbles: true }));
            console.log("🔄 Real-time data synced");
        });

        // Form submission sync
        const form = textarea.closest("form");
        if (form) {
            form.addEventListener("submit", function() {
                textarea.value = editor.getData();
                console.log("💾 Data synced on form submit");
            }, true);
        }

        // Enhanced save button sync
        document.addEventListener("click", function(e) {
            const target = e.target;
            if (target.matches("button[type='submit']") || target.closest("button[type='submit']") ||
                target.matches("[wire\\:click*='save']") || target.closest("[wire\\:click*='save']") ||
                target.matches("[wire\\:click*='Save']") || target.closest("[wire\\:click*='Save']") ||
                (target.matches("button") && target.textContent.includes("Save"))) {
                console.log("💾 Save button clicked, syncing data...");
                setTimeout(function() {
                    if (ckEditorInstances[editorId]) {
                        textarea.value = ckEditorInstances[editorId].getData();
                        textarea.dispatchEvent(new Event("input", { bubbles: true }));
                        textarea.dispatchEvent(new Event("change", { bubbles: true }));
                        console.log("💾 Data synced on save button click");
                    }
                }, 150);
            }
        }, true);

        // Livewire specific event handling
        if (typeof Livewire !== "undefined") {
            Livewire.on("save", function() {
                console.log("💾 Livewire save event detected");
                setTimeout(function() {
                    if (ckEditorInstances[editorId]) {
                        textarea.value = ckEditorInstances[editorId].getData();
                        textarea.dispatchEvent(new Event("input", { bubbles: true }));
                        textarea.dispatchEvent(new Event("change", { bubbles: true }));
                        console.log("💾 Data synced on Livewire save event");
                    }
                }, 100);
            });
        }

        console.log("🎉 CKEditor 5 Ultimate Fix ready!");

    } catch (error) {
        console.error(`❌ Failed to initialize CKEditor 5:`, error);
        editorEl.innerHTML = "";
        createFallbackEditor(editorId, editorEl, textarea, textarea.value);
    }
};

// Cleanup function
window.destroyCKEditor5 = function(editorId) {
    if (ckEditorInstances[editorId]) {
        try {
            ckEditorInstances[editorId].destroy();
            console.log(`🗑️ Destroyed editor instance for ${editorId}`);
        } catch (e) {
            console.warn(`⚠️ Could not destroy editor instance for ${editorId}:`, e);
        }
        delete ckEditorInstances[editorId];
    }
};

console.log("✅ CKEditor5 Ultimate Fix loaded successfully");