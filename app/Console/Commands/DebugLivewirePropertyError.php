<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;
use App\Filament\Forms\Components\GoogleDocsEditor;

class DebugLivewirePropertyError extends Command
{
    protected $signature = 'debug:livewire-property-error';
    protected $description = 'Debug Livewire PropertyNotFoundException for combined_html';

    public function handle()
    {
        $this->info("🔍 Debugging Livewire PropertyNotFoundException...");
        
        // Test 1: Check database structure
        $this->info("\n📊 Testing Database Structure...");
        
        try {
            $template = PdfTemplate::find(1);
            if ($template) {
                $this->info("✅ PDF Template found:");
                $this->info("   ID: " . $template->id);
                $this->info("   Name: " . $template->name);
                
                // Check if combined_html column exists
                $columns = \Schema::getColumnListing('pdf_templates');
                if (in_array('combined_html', $columns)) {
                    $this->info("✅ combined_html column exists in database");
                    $this->info("   Value: " . (strlen($template->combined_html ?? '') > 0 ? strlen($template->combined_html) . ' characters' : 'NULL'));
                } else {
                    $this->error("❌ combined_html column not found in database");
                }
                
                // Check model fillable
                $fillable = $template->getFillable();
                if (in_array('combined_html', $fillable)) {
                    $this->info("✅ combined_html is in model fillable array");
                } else {
                    $this->error("❌ combined_html not in model fillable array");
                    $this->info("   Fillable fields: " . implode(', ', $fillable));
                }
                
            } else {
                $this->error("❌ PDF Template with ID 1 not found");
            }
        } catch (\Exception $e) {
            $this->error("❌ Database error: " . $e->getMessage());
        }
        
        // Test 2: Check GoogleDocsEditor component
        $this->info("\n🧪 Testing GoogleDocsEditor Component...");
        
        try {
            $editor = GoogleDocsEditor::make('combined_html')
                ->templateType('mcu_letter')
                ->showVariables(true);
            
            $this->info("✅ GoogleDocsEditor component created successfully");
            $this->info("   Field name: " . $editor->getName());
            $this->info("   View: " . $editor->getView());
            
            // Test getState method
            try {
                $state = $editor->getState();
                $this->info("✅ getState() method works: " . (is_string($state) ? strlen($state) . ' characters' : gettype($state)));
            } catch (\Exception $e) {
                $this->error("❌ getState() method failed: " . $e->getMessage());
            }
            
        } catch (\Exception $e) {
            $this->error("❌ GoogleDocsEditor creation failed: " . $e->getMessage());
        }
        
        // Test 3: Check Filament Resource
        $this->info("\n📝 Testing Filament Resource...");
        
        try {
            $resource = new \App\Filament\Resources\PdfTemplateResource();
            $form = $resource->form(new \Filament\Forms\Form());
            
            $this->info("✅ PdfTemplateResource created successfully");
            
            // Check if form has combined_html field
            $schema = $form->getSchema();
            $hasCombinedHtml = false;
            
            foreach ($schema as $component) {
                if (method_exists($component, 'getName') && $component->getName() === 'combined_html') {
                    $hasCombinedHtml = true;
                    $this->info("✅ combined_html field found in form schema");
                    break;
                }
            }
            
            if (!$hasCombinedHtml) {
                $this->warn("⚠️ combined_html field not found in form schema");
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Filament Resource error: " . $e->getMessage());
        }
        
        // Test 4: Check migration status
        $this->info("\n🗄️ Testing Migration Status...");
        
        try {
            $migrations = \DB::select("SELECT * FROM migrations WHERE migration LIKE '%combined_html%'");
            if (!empty($migrations)) {
                $this->info("✅ combined_html migration found:");
                foreach ($migrations as $migration) {
                    $this->info("   - " . $migration->migration . " (Batch: " . $migration->batch . ")");
                }
            } else {
                $this->error("❌ No combined_html migration found");
            }
        } catch (\Exception $e) {
            $this->error("❌ Migration check failed: " . $e->getMessage());
        }
        
        // Test 5: Check view file
        $this->info("\n📁 Testing View File...");
        
        $viewPath = resource_path('views/filament/forms/components/google-docs-editor.blade.php');
        if (file_exists($viewPath)) {
            $this->info("✅ Google Docs editor view exists");
            
            $viewContent = file_get_contents($viewPath);
            if (strpos($viewContent, '{!! $getState() !!}') !== false) {
                $this->info("✅ View uses {!! $getState() !!} for HTML rendering");
            } else {
                $this->warn("⚠️ View may not be using correct HTML rendering");
            }
            
            if (strpos($viewContent, '$getStatePath()') !== false) {
                $this->info("✅ View uses getStatePath() method");
            } else {
                $this->warn("⚠️ View may not be using getStatePath()");
            }
            
        } else {
            $this->error("❌ Google Docs editor view not found");
        }
        
        $this->info("\n🎯 Recommendations:");
        $this->info("   1. If combined_html column exists, the issue might be in Livewire property access");
        $this->info("   2. Try using a different approach for default values");
        $this->info("   3. Check if there are any cached views or configs");
        $this->info("   4. Consider using a simpler field type for testing");
        
        return 0;
    }
}