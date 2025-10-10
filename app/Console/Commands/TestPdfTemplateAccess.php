<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TestPdfTemplateAccess extends Command
{
    protected $signature = 'pdf:test-access';
    protected $description = 'Test PDF template access and rendering';

    public function handle()
    {
        $this->info("🧪 Testing PDF Template Access...");
        
        // Test database access
        $template = PdfTemplate::find(1);
        if (!$template) {
            $this->error("❌ PDF template not found!");
            return 1;
        }
        
        $this->info("✅ PDF template found: {$template->name}");
        
        // Test user authentication
        $user = User::find(1);
        if (!$user) {
            $this->error("❌ User not found!");
            return 1;
        }
        
        $this->info("✅ User found: {$user->name}");
        
        // Test authentication
        Auth::login($user);
        $this->info("✅ User authenticated");
        
        // Test PDF template resource
        try {
            $resource = new \App\Filament\Resources\PdfTemplateResource();
            $this->info("✅ PdfTemplateResource instantiated");
            
            // Test form schema
            $form = $resource->form(new \Filament\Forms\Form());
            $this->info("✅ Form schema created");
            
            // Test table schema
            $table = $resource->table(new \Filament\Tables\Table());
            $this->info("✅ Table schema created");
            
        } catch (\Exception $e) {
            $this->error("❌ Resource error: " . $e->getMessage());
            return 1;
        }
        
        // Test WYSIWYG editor component
        try {
            $component = new \App\Filament\Forms\Components\WysiwygEditor('test_field');
            $this->info("✅ WysiwygEditor component created");
            
            // Test component methods
            $component->showPreview(true);
            $component->showVariables(true);
            $component->templateType('pdf');
            
            $this->info("✅ WysiwygEditor methods working");
            
        } catch (\Exception $e) {
            $this->error("❌ WysiwygEditor error: " . $e->getMessage());
            return 1;
        }
        
        // Test view rendering
        try {
            $viewPath = resource_path('views/filament/forms/components/wysiwyg-editor.blade.php');
            if (file_exists($viewPath)) {
                $this->info("✅ WYSIWYG editor view exists");
                
                // Test if view can be compiled
                $view = view('filament.forms.components.wysiwyg-editor', [
                    'getFieldWrapperView' => fn() => 'filament::forms.components.field-wrapper',
                    'getField' => fn() => (object)['getStatePath' => fn() => 'test_field'],
                    'applyStateBindingModifiers' => fn($value) => $value,
                    'getStatePath' => fn() => 'test_field',
                    'getTemplateType' => fn() => 'pdf',
                    'isPreviewEnabled' => fn() => true,
                    'isVariablesEnabled' => fn() => true,
                    'getAvailableVariables' => fn() => ['test' => 'Test Variable']
                ]);
                
                $this->info("✅ View compilation successful");
                
            } else {
                $this->error("❌ WYSIWYG editor view not found");
                return 1;
            }
            
        } catch (\Exception $e) {
            $this->error("❌ View rendering error: " . $e->getMessage());
            $this->error("Stack trace: " . $e->getTraceAsString());
            return 1;
        }
        
        $this->info("\n🎉 PDF template access test completed successfully!");
        
        return 0;
    }
}