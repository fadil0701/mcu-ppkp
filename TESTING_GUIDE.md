# 🧪 Testing Guide - Sistem Monitoring MCU

## 📋 Overview
Panduan lengkap untuk melakukan testing pada Sistem Monitoring MCU PPKP DKI Jakarta. Dokumen ini mencakup setup testing environment, test cases detail, dan prosedur testing.

---

## 🛠️ Setup Testing Environment

### 1. Prerequisites

```bash
# PHP 8.2+
php --version

# Composer
composer --version

# Node.js & NPM
node --version
npm --version

# Database (MySQL/SQLite)
mysql --version
```

### 2. Clone & Install

```bash
# Clone repository
git clone <repository-url>
cd monitoring-mcu

# Install dependencies
composer install
npm install

# Copy environment
cp .env.example .env.testing

# Generate key
php artisan key:generate --env=testing
```

### 3. Configure Test Database

**.env.testing**
```bash
APP_ENV=testing
APP_DEBUG=true

DB_CONNECTION=sqlite
DB_DATABASE=:memory:

# Or use dedicated test database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mcu_monitoring_test
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Migrations

```bash
# Run test migrations
php artisan migrate --env=testing

# Seed test data
php artisan db:seed --env=testing
```

---

## 🧪 Unit Testing

### Running Unit Tests

```bash
# Run all unit tests
php artisan test --testsuite=Unit

# Run specific test file
php artisan test tests/Unit/ParticipantTest.php

# Run with coverage
php artisan test --coverage

# Run with coverage report (HTML)
php artisan test --coverage-html=coverage
```

### Unit Test Examples

#### 1. Model Tests

**tests/Unit/Models/ParticipantTest.php**
```php
<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipantTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_calculates_age_correctly()
    {
        $participant = Participant::factory()->create([
            'tanggal_lahir' => now()->subYears(30),
        ]);

        $this->assertEquals(30, $participant->umur);
    }

    /** @test */
    public function it_determines_age_category_correctly()
    {
        $participant = Participant::factory()->create([
            'tanggal_lahir' => now()->subYears(30),
        ]);

        $this->assertEquals('25-34 tahun', $participant->kategori_umur);
    }

    /** @test */
    public function it_checks_mcu_eligibility_correctly()
    {
        // Eligible: no MCU in last 3 years
        $eligible = Participant::factory()->create([
            'status_pegawai' => 'PNS',
            'tanggal_mcu_terakhir' => now()->subYears(4),
        ]);

        $this->assertTrue($eligible->canScheduleMcu());

        // Not eligible: MCU less than 3 years ago
        $notEligible = Participant::factory()->create([
            'status_pegawai' => 'PNS',
            'tanggal_mcu_terakhir' => now()->subYears(2),
        ]);

        $this->assertFalse($notEligible->canScheduleMcu());
    }

    /** @test */
    public function it_has_schedules_relationship()
    {
        $participant = Participant::factory()
            ->hasSchedules(3)
            ->create();

        $this->assertCount(3, $participant->schedules);
    }

    /** @test */
    public function it_has_mcu_results_relationship()
    {
        $participant = Participant::factory()
            ->hasMcuResults(2)
            ->create();

        $this->assertCount(2, $participant->mcuResults);
    }
}
```

#### 2. Service Tests

**tests/Unit/Services/EmailServiceTest.php**
```php
<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\EmailService;
use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailServiceTest extends TestCase
{
    use RefreshDatabase;

    private EmailService $emailService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->emailService = new EmailService();
    }

    /** @test */
    public function it_sends_schedule_notification()
    {
        Mail::fake();

        $user = User::factory()->create();
        $schedule = Schedule::factory()->create();

        $this->emailService->sendScheduleNotification($user, $schedule);

        Mail::assertSent(function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });
    }

    /** @test */
    public function it_replaces_template_variables()
    {
        $template = 'Hello {nama}, your schedule is on {tanggal}';
        $variables = [
            'nama' => 'John Doe',
            'tanggal' => '2024-01-01',
        ];

        $result = $this->emailService->replaceVariables($template, $variables);

        $this->assertEquals('Hello John Doe, your schedule is on 2024-01-01', $result);
    }
}
```

---

## 🔗 Feature Testing

### Running Feature Tests

```bash
# Run all feature tests
php artisan test --testsuite=Feature

# Run specific test
php artisan test tests/Feature/ParticipantManagementTest.php

# Run with filters
php artisan test --filter=test_user_can_create_participant
```

### Feature Test Examples

#### 1. Authentication Tests

**tests/Feature/Auth/AuthenticationTest.php**
```php
<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /** @test */
    public function users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect('/dashboard');
    }

    /** @test */
    public function users_can_not_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }

    /** @test */
    public function users_can_logout()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect('/');
    }
}
```

#### 2. Participant Management Tests

**tests/Feature/ParticipantManagementTest.php**
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipantManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_view_participants_list()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Participant::factory()->count(5)->create();

        $response = $this->actingAs($admin)
            ->get('/admin/participants');

        $response->assertStatus(200);
        $response->assertViewHas('participants');
    }

    /** @test */
    public function admin_can_create_participant()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $participantData = [
            'nik_ktp' => '1234567890123456',
            'nrk_pegawai' => 'NRK001',
            'nama_lengkap' => 'John Doe',
            'tempat_lahir' => 'Jakarta',
            'tanggal_lahir' => '1990-01-01',
            'jenis_kelamin' => 'L',
            'skpd' => 'SKPD A',
            'ukpd' => 'UKPD A',
            'no_telp' => '08123456789',
            'email' => 'john@example.com',
            'status_pegawai' => 'PNS',
            'status_mcu' => 'Belum MCU',
        ];

        $response = $this->actingAs($admin)
            ->post('/admin/participants', $participantData);

        $response->assertRedirect();
        $this->assertDatabaseHas('participants', [
            'nik_ktp' => '1234567890123456',
            'nama_lengkap' => 'John Doe',
        ]);
    }

    /** @test */
    public function admin_can_update_participant()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $participant = Participant::factory()->create();

        $response = $this->actingAs($admin)
            ->put("/admin/participants/{$participant->id}", [
                'nama_lengkap' => 'Updated Name',
                // ... other fields
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('participants', [
            'id' => $participant->id,
            'nama_lengkap' => 'Updated Name',
        ]);
    }

    /** @test */
    public function admin_can_delete_participant()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $participant = Participant::factory()->create();

        $response = $this->actingAs($admin)
            ->delete("/admin/participants/{$participant->id}");

        $response->assertRedirect();
        $this->assertSoftDeleted('participants', [
            'id' => $participant->id,
        ]);
    }

    /** @test */
    public function user_cannot_access_admin_participants()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)
            ->get('/admin/participants');

        $response->assertStatus(403);
    }
}
```

#### 3. Schedule Management Tests

**tests/Feature/ScheduleManagementTest.php**
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Participant;
use App\Models\Schedule;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ScheduleManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_schedule_for_eligible_participant()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $participant = Participant::factory()->create([
            'status_pegawai' => 'PNS',
            'tanggal_mcu_terakhir' => now()->subYears(4),
        ]);

        $scheduleData = [
            'participant_id' => $participant->id,
            'tanggal_jadwal' => now()->addDays(30)->format('Y-m-d'),
            'lokasi' => 'RS Test',
            'jenis_mcu' => 'Rutin',
        ];

        $response = $this->actingAs($admin)
            ->post('/admin/schedules', $scheduleData);

        $response->assertRedirect();
        $this->assertDatabaseHas('schedules', [
            'participant_id' => $participant->id,
            'status' => 'Terjadwal',
        ]);
    }

    /** @test */
    public function cannot_create_schedule_for_ineligible_participant()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $participant = Participant::factory()->create([
            'status_pegawai' => 'PNS',
            'tanggal_mcu_terakhir' => now()->subYears(2), // < 3 years
        ]);

        $scheduleData = [
            'participant_id' => $participant->id,
            'tanggal_jadwal' => now()->addDays(30)->format('Y-m-d'),
            'lokasi' => 'RS Test',
            'jenis_mcu' => 'Rutin',
        ];

        $response = $this->actingAs($admin)
            ->post('/admin/schedules', $scheduleData);

        $response->assertSessionHasErrors();
    }

    /** @test */
    public function admin_can_cancel_schedule()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $schedule = Schedule::factory()->create(['status' => 'Terjadwal']);

        $response = $this->actingAs($admin)
            ->patch("/admin/schedules/{$schedule->id}/cancel", [
                'alasan_pembatalan' => 'Test reason',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('schedules', [
            'id' => $schedule->id,
            'status' => 'Batal',
        ]);
    }

    /** @test */
    public function user_can_view_their_own_schedules()
    {
        $user = User::factory()->create(['role' => 'user']);
        $participant = Participant::factory()->create(['user_id' => $user->id]);
        $schedule = Schedule::factory()->create(['participant_id' => $participant->id]);

        $response = $this->actingAs($user)
            ->get('/client/schedules');

        $response->assertStatus(200);
        $response->assertSee($schedule->tanggal_jadwal->format('d/m/Y'));
    }
}
```

---

## 🌐 Browser Testing (Laravel Dusk)

### Setup Laravel Dusk

```bash
# Install Dusk
composer require --dev laravel/dusk

# Install Dusk
php artisan dusk:install

# Run Dusk tests
php artisan dusk
```

### Dusk Test Examples

**tests/Browser/LoginTest.php**
```php
<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'test@example.com')
                    ->type('password', 'password')
                    ->press('Login')
                    ->assertPathIs('/dashboard')
                    ->assertSee('Dashboard');
        });
    }

    /** @test */
    public function user_sees_error_with_invalid_credentials()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email', 'wrong@example.com')
                    ->type('password', 'wrongpassword')
                    ->press('Login')
                    ->assertPathIs('/login')
                    ->assertSee('These credentials do not match our records');
        });
    }
}
```

---

## 📡 API Testing

### Running API Tests

```bash
# Using PHPUnit
php artisan test tests/Feature/Api/

# Using Postman (Manual)
# Import Postman collection from docs/postman/
```

### API Test Examples

**tests/Feature/Api/ParticipantApiTest.php**
```php
<?php

namespace Tests\Feature\Api;

use Tests\TestCase;
use App\Models\User;
use App\Models\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;

class ParticipantApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_participants_list()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($admin);

        Participant::factory()->count(3)->create();

        $response = $this->getJson('/api/participants');

        $response->assertStatus(200)
                ->assertJsonCount(3, 'data')
                ->assertJsonStructure([
                    'data' => [
                        '*' => [
                            'id',
                            'nik_ktp',
                            'nama_lengkap',
                            'email',
                        ]
                    ]
                ]);
    }

    /** @test */
    public function can_create_participant_via_api()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($admin);

        $participantData = [
            'nik_ktp' => '1234567890123456',
            'nrk_pegawai' => 'NRK001',
            'nama_lengkap' => 'API Test',
            'email' => 'api@test.com',
            // ... other fields
        ];

        $response = $this->postJson('/api/participants', $participantData);

        $response->assertStatus(201)
                ->assertJsonFragment([
                    'nama_lengkap' => 'API Test',
                ]);
    }

    /** @test */
    public function unauthorized_user_cannot_access_api()
    {
        $response = $this->getJson('/api/participants');

        $response->assertStatus(401);
    }
}
```

---

## ⚡ Performance Testing

### Using Laravel Debugbar

```bash
# Install Debugbar
composer require barryvdh/laravel-debugbar --dev

# Enable in .env
APP_DEBUG=true
DEBUGBAR_ENABLED=true
```

### Performance Test Checklist

- [ ] Homepage load < 2s
- [ ] Dashboard load < 3s
- [ ] List pages load < 3s
- [ ] Search response < 1s
- [ ] File upload with progress
- [ ] No N+1 query problems
- [ ] Database queries < 50 per page
- [ ] Memory usage < 128MB

### JMeter Load Testing

**Basic Load Test Plan:**
```xml
<?xml version="1.0" encoding="UTF-8"?>
<jmeterTestPlan version="1.2">
  <hashTree>
    <TestPlan guiclass="TestPlanGui" testclass="TestPlan" testname="MCU System Load Test">
      <elementProp name="TestPlan.user_defined_variables" elementType="Arguments">
        <collectionProp name="Arguments.arguments"/>
      </elementProp>
    </TestPlan>
    <hashTree>
      <ThreadGroup guiclass="ThreadGroupGui" testclass="ThreadGroup" testname="Users">
        <intProp name="ThreadGroup.num_threads">50</intProp>
        <intProp name="ThreadGroup.ramp_time">10</intProp>
        <longProp name="ThreadGroup.duration">300</longProp>
      </ThreadGroup>
      <hashTree>
        <HTTPSamplerProxy guiclass="HttpTestSampleGui" testclass="HTTPSamplerProxy" testname="Homepage">
          <stringProp name="HTTPSampler.domain">localhost</stringProp>
          <stringProp name="HTTPSampler.port">8000</stringProp>
          <stringProp name="HTTPSampler.path">/</stringProp>
          <stringProp name="HTTPSampler.method">GET</stringProp>
        </HTTPSamplerProxy>
      </hashTree>
    </hashTree>
  </hashTree>
</jmeterTestPlan>
```

---

## 🔒 Security Testing

### Security Test Checklist

#### Authentication & Authorization
- [ ] Test brute force protection
- [ ] Test session hijacking prevention
- [ ] Test password reset security
- [ ] Test role-based access control
- [ ] Test unauthorized access attempts

#### Input Validation
- [ ] Test SQL injection
- [ ] Test XSS attacks
- [ ] Test CSRF attacks
- [ ] Test file upload security
- [ ] Test parameter tampering

#### Data Protection
- [ ] Test password hashing
- [ ] Test sensitive data encryption
- [ ] Test secure file storage
- [ ] Test data masking in logs

### Security Testing Commands

```bash
# Check for common vulnerabilities
composer require --dev enlightn/security-checker
php artisan security-check

# Scan dependencies for vulnerabilities
composer audit

# Static analysis
composer require --dev phpstan/phpstan
vendor/bin/phpstan analyse app
```

---

## 📊 Test Reporting

### Generate Test Report

```bash
# HTML coverage report
php artisan test --coverage-html=coverage

# Text coverage report
php artisan test --coverage-text

# JUnit XML report
php artisan test --log-junit=test-results.xml
```

### Test Report Template

```markdown
# Test Report - [Date]

## Executive Summary
- Total Tests: 250
- Passed: 245
- Failed: 5
- Skipped: 0
- Pass Rate: 98%

## Test Coverage
- Code Coverage: 78%
- Feature Coverage: 100%
- Requirement Coverage: 99.3%

## Test Results by Type
### Unit Tests
- Total: 100
- Passed: 98
- Failed: 2
- Pass Rate: 98%

### Feature Tests
- Total: 100
- Passed: 98
- Failed: 2
- Pass Rate: 98%

### Browser Tests
- Total: 30
- Passed: 29
- Failed: 1
- Pass Rate: 97%

### API Tests
- Total: 20
- Passed: 20
- Failed: 0
- Pass Rate: 100%

## Failed Tests
1. **Test Name**: test_participant_export_excel
   - **Module**: Participant Management
   - **Error**: Timeout exceeded
   - **Status**: Under investigation

2. **Test Name**: test_email_notification_sent
   - **Module**: Email System
   - **Error**: SMTP connection failed
   - **Status**: Fixed in next iteration

## Performance Results
- Average Page Load: 2.1s ✅
- Average API Response: 0.6s ✅
- Database Query Time: 0.3s ✅
- Memory Usage: 98MB ✅

## Issues Found
- 2 Medium bugs
- 3 Low priority bugs
- No critical bugs

## Recommendations
1. Increase unit test coverage to 80%
2. Fix failed test cases
3. Optimize slow queries
4. Add more edge case tests

## Next Steps
1. Fix failed tests
2. Rerun regression tests
3. Proceed to UAT
4. Deploy to staging
```

---

## 🎓 Testing Best Practices

### 1. Test Organization

```
tests/
├── Feature/
│   ├── Auth/
│   │   ├── LoginTest.php
│   │   └── RegistrationTest.php
│   ├── Admin/
│   │   ├── ParticipantManagementTest.php
│   │   ├── ScheduleManagementTest.php
│   │   └── ResultsManagementTest.php
│   └── Client/
│       └── DashboardTest.php
├── Unit/
│   ├── Models/
│   │   ├── ParticipantTest.php
│   │   ├── ScheduleTest.php
│   │   └── McuResultTest.php
│   └── Services/
│       ├── EmailServiceTest.php
│       └── PdfServiceTest.php
└── Browser/
    ├── LoginTest.php
    └── RegistrationTest.php
```

### 2. Test Naming Convention

```php
// Good naming
public function test_user_can_login_with_valid_credentials()
public function test_admin_can_create_participant()
public function it_calculates_age_correctly()

// Bad naming
public function testLogin()
public function test1()
public function myTest()
```

### 3. Arrange-Act-Assert Pattern

```php
public function test_participant_can_schedule_mcu()
{
    // Arrange: Setup test data
    $participant = Participant::factory()->create([
        'tanggal_mcu_terakhir' => now()->subYears(4),
    ]);

    // Act: Perform action
    $result = $participant->canScheduleMcu();

    // Assert: Verify outcome
    $this->assertTrue($result);
}
```

### 4. Use Factories

```php
// Good: Using factories
$participant = Participant::factory()->create();

// Bad: Manual creation
$participant = new Participant([
    'nik_ktp' => '1234567890123456',
    'nama_lengkap' => 'Test',
    // ... many more fields
]);
```

### 5. Clean Up After Tests

```php
// Use RefreshDatabase trait
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipantTest extends TestCase
{
    use RefreshDatabase;

    // Tests automatically rollback database changes
}
```

---

## 📚 Quick Reference

### Common PHPUnit Assertions

```php
// Equality
$this->assertEquals($expected, $actual);
$this->assertSame($expected, $actual); // Strict comparison

// Boolean
$this->assertTrue($condition);
$this->assertFalse($condition);

// Database
$this->assertDatabaseHas('table', ['column' => 'value']);
$this->assertDatabaseMissing('table', ['column' => 'value']);
$this->assertSoftDeleted('table', ['id' => 1]);

// HTTP Responses
$response->assertStatus(200);
$response->assertRedirect('/path');
$response->assertJson(['key' => 'value']);
$response->assertJsonCount(5, 'data');
$response->assertSee('text');

// Authentication
$this->assertAuthenticated();
$this->assertGuest();
```

### Useful Commands

```bash
# Run all tests
php artisan test

# Run specific suite
php artisan test --testsuite=Unit
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage

# Run parallel (faster)
php artisan test --parallel

# Run with specific filter
php artisan test --filter=ParticipantTest

# Stop on failure
php artisan test --stop-on-failure

# Generate coverage report
php artisan test --coverage-html=coverage
```

---

## 📞 Support

Jika ada pertanyaan tentang testing:
1. Review dokumentasi ini
2. Check Laravel testing docs: https://laravel.com/docs/testing
3. Contact QA Team

---

**Last Updated**: {{ date }}  
**Version**: 1.0.0  
**Prepared by**: QA Team  
**Contact**: qa-team@mcu-system.com


