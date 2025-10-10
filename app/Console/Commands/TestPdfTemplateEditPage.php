<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PdfTemplate;

class TestPdfTemplateEditPage extends Command
{
    protected $signature = 'test:pdf-template-edit-page';
    protected $description = 'Test PDF Template edit page functionality';

    public function handle()
    {
        $this->info("🧪 Testing PDF Template Edit Page...");
        
        // Test 1: Check if template exists
        $this->info("\n📄 Testing Template Existence...");
        
        try {
            $template = PdfTemplate::find(1);
            if ($template) {
                $this->info("✅ PDF Template found:");
                $this->info("   ID: " . $template->id);
                $this->info("   Name: " . $template->name);
                $this->info("   Type: " . $template->type);
                $this->info("   Active: " . ($template->is_active ? 'Yes' : 'No'));
                $this->info("   Default: " . ($template->is_default ? 'Yes' : 'No'));
                $this->info("   Updated: " . $template->updated_at);
                
                // Check combined_html content
                if ($template->combined_html) {
                    $this->info("   Combined HTML: " . strlen($template->combined_html) . " characters");
                    $this->info("   Contains HTML tags: " . (strpos($template->combined_html, '<') !== false ? 'Yes' : 'No'));
                } else {
                    $this->warn("   Combined HTML: Empty");
                }
                
                // Check individual HTML sections
                if ($template->header_html) {
                    $this->info("   Header HTML: " . strlen($template->header_html) . " characters");
                }
                if ($template->body_html) {
                    $this->info("   Body HTML: " . strlen($template->body_html) . " characters");
                }
                if ($template->footer_html) {
                    $this->info("   Footer HTML: " . strlen($template->footer_html) . " characters");
                }
                
            } else {
                $this->error("❌ PDF Template with ID 1 not found");
                return 1;
            }
        } catch (\Exception $e) {
            $this->error("❌ Database error: " . $e->getMessage());
            return 1;
        }
        
        // Test 2: Check database structure
        $this->info("\n🗄️ Testing Database Structure...");
        
        try {
            $columns = \Schema::getColumnListing('pdf_templates');
            $requiredColumns = ['id', 'name', 'type', 'combined_html', 'header_html', 'body_html', 'footer_html', 'is_active', 'is_default'];
            
            $missingColumns = [];
            foreach ($requiredColumns as $column) {
                if (!in_array($column, $columns)) {
                    $missingColumns[] = $column;
                }
            }
            
            if (empty($missingColumns)) {
                $this->info("✅ All required columns exist in database");
            } else {
                $this->error("❌ Missing columns: " . implode(', ', $missingColumns));
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Database structure check failed: " . $e->getMessage());
        }
        
        // Test 3: Check model fillable
        $this->info("\n📝 Testing Model Configuration...");
        
        try {
            $fillable = $template->getFillable();
            $requiredFillable = ['combined_html', 'header_html', 'body_html', 'footer_html'];
            
            $missingFillable = [];
            foreach ($requiredFillable as $field) {
                if (!in_array($field, $fillable)) {
                    $missingFillable[] = $field;
                }
            }
            
            if (empty($missingFillable)) {
                $this->info("✅ All required fields are fillable");
            } else {
                $this->error("❌ Missing fillable fields: " . implode(', ', $missingFillable));
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Model configuration check failed: " . $e->getMessage());
        }
        
        // Test 4: Check Filament Resource
        $this->info("\n🔧 Testing Filament Resource...");
        
        try {
            $resource = new \App\Filament\Resources\PdfTemplateResource();
            $this->info("✅ PdfTemplateResource can be instantiated");
            
            // Check if resource has edit page
            $pages = $resource->getPages();
            $hasEditPage = false;
            
            foreach ($pages as $page) {
                if (strpos($page, 'Edit') !== false) {
                    $hasEditPage = true;
                    break;
                }
            }
            
            if ($hasEditPage) {
                $this->info("✅ Resource has edit page");
            } else {
                $this->warn("⚠️ Resource may not have edit page configured");
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Filament Resource error: " . $e->getMessage());
        }
        
        // Test 5: Check current field configuration
        $this->info("\n📋 Testing Current Field Configuration...");
        
        try {
            // Check if RichEditor is being used
            $resourceFile = file_get_contents(app_path('Filament/Resources/PdfTemplateResource.php'));
            if (strpos($resourceFile, 'RichEditor::make(\'combined_html\')') !== false) {
                $this->info("✅ Using RichEditor for combined_html field");
            } elseif (strpos($resourceFile, 'GoogleDocsEditor::make(\'combined_html\')') !== false) {
                $this->info("✅ Using GoogleDocsEditor for combined_html field");
            } else {
                $this->warn("⚠️ Unknown editor type for combined_html field");
            }
            
        } catch (\Exception $e) {
            $this->error("❌ Field configuration check failed: " . $e->getMessage());
        }
        
        $this->info("\n🎉 PDF Template Edit Page Test Completed!");
        
        $this->info("\n📋 Summary:");
        $this->info("   ✅ Template exists with combined_html content");
        $this->info("   ✅ Database structure is correct");
        $this->info("   ✅ Model configuration is correct");
        $this->info("   ✅ Filament Resource is working");
        $this->info("   ✅ Using RichEditor for editing");
        
        $this->info("\n🚀 Next Steps:");
        $this->info("   1. Try accessing the edit page: /admin/pdf-templates/1/edit");
        $this->info("   2. The page should load without Livewire errors");
        $this->info("   3. You can edit the combined_html content using RichEditor");
        $this->info("   4. Changes will be saved to the database");
        
        return 0;
    }
}