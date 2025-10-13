# 🧪 User Acceptance Testing (UAT) - Sistem Monitoring MCU

## 📋 Document Information

| Item | Detail |
|------|--------|
| **Document Title** | User Acceptance Testing Plan & Execution |
| **Project Name** | Sistem Monitoring MCU PPKP DKI Jakarta |
| **Version** | 1.0 |
| **Date** | October 2024 |
| **Prepared By** | QA Team |
| **Approved By** | Project Manager |
| **Status** | Ready for Execution |

---

## 🎯 UAT Overview

### Purpose
Dokumen ini berisi rencana dan prosedur User Acceptance Testing (UAT) untuk memvalidasi bahwa Sistem Monitoring MCU memenuhi kebutuhan bisnis dan dapat digunakan oleh end users dalam kondisi operasional nyata.

### Objectives
1. ✅ Memvalidasi sistem sesuai business requirements
2. ✅ Memastikan sistem user-friendly dan intuitive
3. ✅ Mengidentifikasi gap antara expectation dan implementation
4. ✅ Mendapatkan sign-off dari stakeholders
5. ✅ Memastikan readiness untuk production deployment

### Success Criteria
- **Pass Rate**: ≥ 95% test scenarios passed
- **Critical Issues**: 0 critical issues
- **User Satisfaction**: ≥ 90% (post-UAT survey)
- **Performance**: All response time < 3 seconds
- **Usability**: SUS Score ≥ 70

---

## 📅 UAT Schedule

### Timeline

| Phase | Activity | Duration | Start Date | End Date |
|-------|----------|----------|------------|----------|
| **Phase 1** | UAT Preparation | 3 days | Week 15 Mon | Week 15 Wed |
| **Phase 2** | UAT Training | 1 day | Week 15 Thu | Week 15 Thu |
| **Phase 3** | UAT Execution | 5 days | Week 16 Mon | Week 16 Fri |
| **Phase 4** | Issue Resolution | 2 days | Week 16 Mon-Fri | (Parallel) |
| **Phase 5** | Re-testing | 1 day | Week 17 Mon | Week 17 Mon |
| **Phase 6** | UAT Sign-off | 1 day | Week 17 Tue | Week 17 Tue |

### Daily Schedule (UAT Execution Week)

**Morning Session: 09:00 - 12:00**
- 09:00 - 09:15: Daily briefing
- 09:15 - 11:45: Test execution
- 11:45 - 12:00: Morning wrap-up

**Afternoon Session: 13:00 - 17:00**
- 13:00 - 16:45: Test execution
- 16:45 - 17:00: Daily summary & issue review

---

## 👥 Roles & Responsibilities

### UAT Team Structure

| Role | Name | Responsibility | Count |
|------|------|----------------|-------|
| **UAT Lead** | [Name] | Overall UAT coordination | 1 |
| **Business Representative** | [Name] | Business validation | 1 |
| **Super Admin Tester** | [Name] | Test super admin scenarios | 1 |
| **Admin Testers** | [Names] | Test admin scenarios | 3 |
| **User Testers** | [Names] | Test end user scenarios | 5 |
| **QA Observer** | [Name] | Documentation & support | 2 |
| **Tech Support** | [Name] | Technical issue resolution | 2 |

### Responsibilities Detail

#### UAT Lead
- Overall UAT planning and coordination
- Daily progress monitoring
- Issue prioritization and escalation
- Final sign-off recommendation
- Stakeholder communication

#### Business Representative
- Validate business rules and workflows
- Approve/reject business scenarios
- Provide business context
- Final business sign-off

#### Testers (Super Admin/Admin/User)
- Execute assigned test scenarios
- Document results and issues
- Provide feedback on usability
- Complete post-UAT survey

#### QA Observer
- Support testers during execution
- Document issues and feedback
- Assist with test data preparation
- Track test execution progress

#### Tech Support
- Resolve technical issues quickly
- Monitor system performance
- Fix bugs during UAT
- Ensure environment stability

---

## 🔍 UAT Scope

### In Scope

#### Module 1: Authentication & Authorization ✅
- User login/logout
- Password reset
- Role-based access control
- Session management

#### Module 2: Participant Management ✅
- Create/Read/Update/Delete participants
- Search and filter participants
- Import participants from Excel
- Export participants to Excel/PDF

#### Module 3: Schedule Management ✅
- Create MCU schedule
- Update/cancel schedule
- 3-year rule validation
- Calendar view
- Schedule notifications

#### Module 4: MCU Results Management ✅
- Upload MCU results
- View results
- Download results
- Multiple file support
- Diagnosis management

#### Module 5: Dashboard & Reporting ✅
- Admin dashboard
- Client dashboard
- Statistics and charts
- Generate reports
- Export reports

#### Module 6: Communication ✅
- Email notifications
- WhatsApp notifications
- Template management

### Out of Scope
- Infrastructure performance testing (separate load testing)
- Security penetration testing (separate security audit)
- Browser compatibility testing (done in system testing)
- Mobile app (not in current scope)

---

## 📝 Test Scenarios

### Scenario Category

```
Total Test Scenarios: 50
├── Authentication: 5 scenarios
├── Participant Management: 12 scenarios
├── Schedule Management: 10 scenarios
├── Results Management: 8 scenarios
├── Dashboard & Reports: 8 scenarios
├── Communication: 4 scenarios
└── Integration Flows: 3 scenarios
```

---

## 📋 UAT Test Cases

### Module 1: Authentication & Authorization

#### UAT-AUTH-001: User Login
**Priority**: Critical  
**Role**: All Users

**Pre-condition**:
- User account exists in system
- User has valid credentials

**Test Steps**:
1. Navigate to login page (https://mcu.ppkp-jakarta.go.id/login)
2. Enter valid email address
3. Enter valid password
4. Click "Login" button
5. Verify redirect to appropriate dashboard based on role

**Expected Result**:
- Super Admin → redirected to /admin
- Admin → redirected to /admin
- User → redirected to /client/dashboard
- Success message displayed
- User menu shows correct user name and role

**Test Data**:
| Role | Email | Password |
|------|-------|----------|
| Super Admin | superadmin@mcu.local | password |
| Admin | admin@mcu.local | password |
| User | user@mcu.local | password |

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-AUTH-002: Invalid Login
**Priority**: High  
**Role**: All Users

**Pre-condition**:
- Login page is accessible

**Test Steps**:
1. Navigate to login page
2. Enter email: wrong@example.com
3. Enter password: wrongpassword
4. Click "Login" button

**Expected Result**:
- User remains on login page
- Error message displayed: "These credentials do not match our records"
- No access granted to system

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-AUTH-003: Password Reset
**Priority**: High  
**Role**: All Users

**Pre-condition**:
- User account exists
- Email system configured

**Test Steps**:
1. Navigate to login page
2. Click "Forgot Password?" link
3. Enter registered email address
4. Click "Send Reset Link" button
5. Check email inbox
6. Click reset link in email
7. Enter new password
8. Confirm new password
9. Click "Reset Password" button
10. Login with new password

**Expected Result**:
- Email received within 2 minutes
- Reset link is valid
- Password successfully reset
- Can login with new password
- Cannot use old password

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-AUTH-004: Role-Based Access Control
**Priority**: Critical  
**Role**: Admin

**Pre-condition**:
- Logged in as Admin

**Test Steps**:
1. Try to access Super Admin only features
2. Verify access denied
3. Try to access User features
4. Verify appropriate access level

**Expected Result**:
- Admin can access admin panel
- Admin cannot access Super Admin settings
- Admin cannot delete critical data
- Proper error messages for unauthorized access

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-AUTH-005: Logout
**Priority**: Medium  
**Role**: All Users

**Pre-condition**:
- User is logged in

**Test Steps**:
1. Click user menu (top right)
2. Click "Logout" button
3. Verify redirect to homepage
4. Try to access dashboard URL directly
5. Verify redirect to login page

**Expected Result**:
- Successfully logged out
- Redirected to homepage
- Cannot access protected pages
- Session cleared

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

### Module 2: Participant Management

#### UAT-PART-001: Create New Participant
**Priority**: Critical  
**Role**: Admin

**Pre-condition**:
- Logged in as Admin
- Navigate to Participants page

**Test Steps**:
1. Click "Tambah Participant" button
2. Fill all required fields:
   - NIK KTP: 3171234567890001
   - NRK Pegawai: NRK-UAT-001
   - Nama Lengkap: Test Participant UAT
   - Tempat Lahir: Jakarta
   - Tanggal Lahir: 01/01/1990
   - Jenis Kelamin: Laki-laki
   - SKPD: SKPD Test
   - UKPD: UKPD Test
   - No Telepon: 081234567890
   - Email: test.uat@example.com
   - Status Pegawai: PNS
   - Status MCU: Belum MCU
3. Click "Simpan" button

**Expected Result**:
- Participant successfully created
- Success message displayed
- Redirected to participant detail page
- All data displayed correctly
- Umur calculated automatically (34 tahun)
- Kategori umur shown (25-34 tahun)

**Test Data**: See test steps

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-PART-002: Validation - Duplicate NIK
**Priority**: High  
**Role**: Admin

**Pre-condition**:
- Participant with NIK 3171234567890001 exists

**Test Steps**:
1. Click "Tambah Participant"
2. Fill form with same NIK: 3171234567890001
3. Fill other fields with different data
4. Click "Simpan"

**Expected Result**:
- Form not submitted
- Error message: "NIK sudah terdaftar"
- User remains on form page
- No duplicate data created

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-PART-003: Search Participant
**Priority**: High  
**Role**: Admin

**Pre-condition**:
- Multiple participants exist in system
- At least one participant named "Test Participant UAT"

**Test Steps**:
1. Go to Participants list page
2. Enter "Test Participant" in search box
3. Press Enter or click Search button
4. Verify filtered results

**Expected Result**:
- Search results show only matching participants
- Search is case-insensitive
- Partial name match works
- Result count displayed
- Clear search button available

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-PART-004: Filter Participant
**Priority**: High  
**Role**: Admin

**Test Steps**:
1. Go to Participants list page
2. Apply filter: Status Pegawai = PNS
3. Verify results show only PNS
4. Apply additional filter: Jenis Kelamin = Laki-laki
5. Verify results show only PNS + Laki-laki
6. Clear filters
7. Verify all participants shown again

**Expected Result**:
- Single filter works correctly
- Multiple filters work together (AND logic)
- Clear filter restores all data
- Filter count badge shows applied filters

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-PART-005: Update Participant
**Priority**: High  
**Role**: Admin

**Pre-condition**:
- Participant exists (from UAT-PART-001)

**Test Steps**:
1. Find participant "Test Participant UAT"
2. Click Edit button
3. Change Nama Lengkap to "Test Participant UAT Updated"
4. Change No Telepon to "081234567899"
5. Click "Update" button

**Expected Result**:
- Data successfully updated
- Success message displayed
- Updated data shown in detail view
- Timestamp updated_at changed

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-PART-006: Import Participants from Excel
**Priority**: Critical  
**Role**: Admin

**Pre-condition**:
- Excel template downloaded
- Excel file prepared with 5 test participants

**Test Steps**:
1. Go to Participants page
2. Click "Import Excel" button
3. Download template if not already downloaded
4. Upload prepared Excel file with 5 participants
5. Review preview/validation
6. Click "Import" button
7. Wait for import process
8. Review import summary

**Expected Result**:
- Template download works
- Excel file accepted
- Validation shows before import
- Import progress indicator shown
- Success summary: "5 participants imported successfully"
- Failed records shown (if any) with reason
- All 5 participants appear in list

**Test Data**: Excel file with 5 valid participant records

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-PART-007: Export Participants to Excel
**Priority**: High  
**Role**: Admin

**Test Steps**:
1. Go to Participants list
2. Apply filter if desired (optional)
3. Click "Export Excel" button
4. Wait for file generation
5. Download and open Excel file
6. Verify data

**Expected Result**:
- Excel file downloads successfully
- File name format: participants_YYYYMMDD_HHMMSS.xlsx
- All columns included
- Data matches what's shown in list
- Filtered data exported if filter applied
- Excel file opens without errors

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-PART-008: Delete Participant
**Priority**: Medium  
**Role**: Admin

**Pre-condition**:
- Participant without any schedules exists

**Test Steps**:
1. Find participant to delete
2. Click Delete button
3. Verify confirmation dialog appears
4. Read warning message
5. Click "Confirm Delete"

**Expected Result**:
- Confirmation dialog shows
- Warning about deletion displayed
- After confirm, participant removed from list
- Success message: "Participant deleted successfully"
- Soft deleted (can be restored by Super Admin)

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

### Module 3: Schedule Management

#### UAT-SCHED-001: Create MCU Schedule (Eligible Participant)
**Priority**: Critical  
**Role**: Admin

**Pre-condition**:
- Participant exists who is eligible for MCU (no MCU in last 3 years)
- Logged in as Admin

**Test Steps**:
1. Navigate to Schedules page
2. Click "Buat Jadwal Baru" button
3. Select participant from dropdown
4. Select tanggal jadwal: [30 days from now]
5. Enter lokasi: "RS Pelni Jakarta"
6. Select jenis MCU: "Rutin"
7. Enter catatan: "Test UAT Schedule"
8. Click "Simpan" button

**Expected Result**:
- Schedule successfully created
- Success message displayed
- Status automatically set to "Terjadwal"
- Email notification sent to participant
- WhatsApp notification sent (if configured)
- Schedule appears in calendar view
- Participant can view their schedule

**Test Data**:
- Participant: [Eligible participant name]
- Tanggal: [Today + 30 days]
- Lokasi: RS Pelni Jakarta
- Jenis: Rutin

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-SCHED-002: Validation - 3 Year Rule
**Priority**: Critical  
**Role**: Admin

**Pre-condition**:
- Participant who had MCU less than 3 years ago exists

**Test Steps**:
1. Navigate to Schedules page
2. Click "Buat Jadwal Baru"
3. Try to select participant who had recent MCU (< 3 years)
4. Attempt to save

**Expected Result**:
- Validation error displayed
- Error message: "Participant tidak eligible untuk MCU. MCU terakhir kurang dari 3 tahun yang lalu."
- Schedule NOT created
- Suggested next eligible date shown

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-SCHED-003: View Schedule Calendar
**Priority**: High  
**Role**: Admin

**Pre-condition**:
- Multiple schedules exist for current month

**Test Steps**:
1. Navigate to Schedules page
2. Switch to Calendar view
3. Navigate between months
4. Click on a schedule in calendar
5. Verify detail popup/modal

**Expected Result**:
- Calendar displays correctly
- Schedules shown on correct dates
- Color coding by status:
  - Terjadwal: Blue
  - Selesai: Green
  - Batal: Red
- Can navigate months
- Clicking schedule shows details
- Today highlighted

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-SCHED-004: Update Schedule
**Priority**: High  
**Role**: Admin

**Pre-condition**:
- Schedule exists with status "Terjadwal"

**Test Steps**:
1. Find schedule from UAT-SCHED-001
2. Click Edit button
3. Change tanggal to different date
4. Change lokasi to "RSUD Jakarta"
5. Update catatan
6. Click "Update" button

**Expected Result**:
- Schedule updated successfully
- Success message displayed
- Updated information shown
- Notification sent to participant about change
- History/log recorded

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-SCHED-005: Cancel Schedule
**Priority**: High  
**Role**: Admin

**Test Steps**:
1. Find a schedule with status "Terjadwal"
2. Click "Batalkan" button
3. Enter alasan pembatalan: "Test UAT - Schedule Cancelled"
4. Click "Confirm" button

**Expected Result**:
- Schedule status changed to "Batal"
- Alasan pembatalan saved
- Cancellation notification sent to participant
- Schedule still visible but marked as cancelled
- Can create new schedule for same participant

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-SCHED-006: User View Their Schedule
**Priority**: Critical  
**Role**: User (Pegawai)

**Pre-condition**:
- Logged in as regular user
- User has at least one schedule

**Test Steps**:
1. Login as user
2. Navigate to Dashboard
3. View "Jadwal MCU Saya" section
4. Click "Lihat Detail" on a schedule

**Expected Result**:
- User can see only their own schedules
- Schedule details shown clearly:
  - Tanggal dan waktu
  - Lokasi
  - Jenis MCU
  - Status
- Cannot see other users' schedules
- Cannot edit/delete schedules
- Can download schedule info

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-SCHED-007: Email Notification
**Priority**: High  
**Role**: System

**Pre-condition**:
- Email SMTP configured
- Schedule created (from UAT-SCHED-001)

**Test Steps**:
1. Check email inbox of participant
2. Verify email received
3. Check email content
4. Verify email template formatting

**Expected Result**:
- Email received within 2 minutes
- Subject: "Jadwal MCU Anda - [Tanggal]"
- Contains: participant name, date, time, location
- Professional formatting
- MCU logo/header included
- Contact information included

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

### Module 4: MCU Results Management

#### UAT-RESULT-001: Upload MCU Results
**Priority**: Critical  
**Role**: Admin

**Pre-condition**:
- Schedule exists with status "Terjadwal"
- Logged in as Admin

**Test Steps**:
1. Navigate to MCU Results page
2. Click "Upload Hasil MCU" button
3. Select schedule from dropdown
4. Enter tanggal pemeriksaan
5. Select diagnosis (multiple): "Hipertensi", "Diabetes"
6. Enter hasil pemeriksaan detail
7. Select status kesehatan: "Kurang Sehat"
8. Enter rekomendasi
9. Select dokter spesialis: "Dokter Jantung", "Dokter Gizi"
10. Upload file hasil (PDF): test_mcu_result.pdf
11. Click "Simpan" button

**Expected Result**:
- Results uploaded successfully
- Success message displayed
- File uploaded and stored
- Schedule status auto-updated to "Selesai"
- Participant's tanggal_mcu_terakhir updated
- Notification sent to participant
- User can view/download results

**Test Data**:
- Schedule: [From UAT-SCHED-001]
- Tanggal pemeriksaan: [Today]
- Diagnosis: Hipertensi, Diabetes
- Status: Kurang Sehat
- File: PDF (< 10MB)

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-RESULT-002: Upload Multiple Files
**Priority**: High  
**Role**: Admin

**Test Steps**:
1. Create/edit MCU result
2. Upload multiple files:
   - hasil_laboratorium.pdf
   - hasil_rontgen.jpg
   - rekam_jantung.pdf
3. Verify all files uploaded
4. Save result

**Expected Result**:
- All files uploaded successfully
- File list shown
- Each file has correct name and size
- Can preview each file
- Can delete individual file before saving
- All files accessible after saving

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-RESULT-003: User Download Results
**Priority**: Critical  
**Role**: User (Pegawai)

**Pre-condition**:
- Logged in as user
- MCU results available for this user

**Test Steps**:
1. Login as user
2. Navigate to Dashboard
3. Go to "Hasil MCU" section
4. Click on latest result
5. View result details
6. Click "Download" button on file
7. Verify file downloads

**Expected Result**:
- User can see only their own results
- Result details displayed clearly:
  - Tanggal pemeriksaan
  - Diagnosis
  - Status kesehatan (with color coding)
  - Rekomendasi
  - Dokter spesialis
- File downloads successfully
- Download tracked in system
- Downloaded_at timestamp recorded

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-RESULT-004: View Diagnosis History
**Priority**: Medium  
**Role**: Admin

**Pre-condition**:
- Participant has multiple MCU results over time

**Test Steps**:
1. Navigate to Participant detail page
2. View MCU Results history section
3. Expand each result to see details
4. Compare diagnosis over time

**Expected Result**:
- All MCU results listed chronologically
- Each result shows:
  - Date
  - Status kesehatan
  - Key diagnosis
  - Link to full result
- Easy to track health trends
- Export history option available

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

### Module 5: Dashboard & Reporting

#### UAT-DASH-001: Admin Dashboard
**Priority**: High  
**Role**: Admin

**Pre-condition**:
- Logged in as Admin
- System has data (participants, schedules, results)

**Test Steps**:
1. Navigate to Admin Dashboard
2. Review all widgets
3. Interact with charts
4. Check data accuracy
5. Apply date filter
6. Refresh/reload page

**Expected Result**:
- Dashboard loads within 3 seconds
- Widgets show:
  - Total Participants
  - Total Schedules
  - Pending Schedules
  - Total Results
- Charts display:
  - Participants by SKPD
  - MCU Status distribution
  - Schedule timeline
  - Health status distribution
- Data is accurate (match database)
- Real-time updates work
- Charts are interactive (hover, click)
- Responsive layout

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-DASH-002: Client Dashboard
**Priority**: High  
**Role**: User (Pegawai)

**Test Steps**:
1. Login as regular user
2. View dashboard
3. Check all sections
4. Navigate to detail pages

**Expected Result**:
- Dashboard shows user's information:
  - Personal info card
  - Next scheduled MCU (if any)
  - Latest MCU result
  - MCU history timeline
  - Next eligible MCU date
- All data accurate
- Quick actions available:
  - Download latest result
  - View schedule detail
- Notification alerts shown
- User-friendly interface

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-REPORT-001: Generate Participant Report
**Priority**: High  
**Role**: Admin

**Test Steps**:
1. Navigate to Reports page
2. Select "Participant Report"
3. Set date range filter
4. Select SKPD filter (optional)
5. Select status filter (optional)
6. Click "Generate Report" button
7. View report preview
8. Export to Excel
9. Export to PDF

**Expected Result**:
- Report generates within 10 seconds
- Preview shows correctly
- Excel export works:
  - Proper formatting
  - All data included
  - Column headers clear
- PDF export works:
  - Professional layout
  - Logo/header included
  - Page numbers
  - Summary statistics
- File downloads successfully

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-REPORT-002: Generate Schedule Report
**Priority**: High  
**Role**: Admin

**Test Steps**:
1. Navigate to Reports
2. Select "Schedule Report"
3. Set date range: Last 3 months
4. Select status: All
5. Generate report
6. Export to Excel

**Expected Result**:
- Report includes:
  - All schedules in date range
  - Participant details
  - Schedule date and location
  - Status
  - Completion status
- Summary statistics:
  - Total schedules
  - Completed count
  - Cancelled count
  - Pending count
- Charts included in report
- Export successful

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

### Module 6: Communication

#### UAT-COMM-001: Email Template Management
**Priority**: Medium  
**Role**: Super Admin

**Pre-condition**:
- Logged in as Super Admin

**Test Steps**:
1. Navigate to Settings > Email Templates
2. Select "Schedule Created" template
3. View template content
4. Edit template:
   - Change subject
   - Modify body text
   - Preview with sample data
5. Save changes
6. Create test schedule
7. Verify email uses new template

**Expected Result**:
- Can view all email templates
- Can edit template content
- Variables list shown: {nama}, {tanggal}, etc.
- Preview with real data
- Changes saved successfully
- New emails use updated template

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-COMM-002: WhatsApp Notification
**Priority**: Medium  
**Role**: System

**Pre-condition**:
- WhatsApp API configured
- Participant has valid phone number

**Test Steps**:
1. Create new schedule
2. Check if WhatsApp notification sent
3. Verify message received on phone
4. Check message content

**Expected Result**:
- WhatsApp message sent within 1 minute
- Message contains:
  - Greeting with name
  - Schedule date and time
  - Location
  - Contact info for questions
- Professional formatting
- Delivery status tracked in system

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

### Integration Flows

#### UAT-FLOW-001: Complete MCU Cycle
**Priority**: Critical  
**Role**: Admin & User

**Scenario**: Complete end-to-end MCU process

**Test Steps**:
1. **Registration** (Admin):
   - Create new participant
   - Verify participant created

2. **Scheduling** (Admin):
   - Create MCU schedule for participant
   - Verify schedule created
   - Verify notification sent

3. **Notification** (User):
   - User receives email notification
   - User receives WhatsApp notification (if configured)
   - User logs in to check schedule

4. **View Schedule** (User):
   - User views their schedule in dashboard
   - User sees schedule details

5. **Upload Results** (Admin):
   - Upload MCU results with files
   - Verify schedule status updated to "Selesai"

6. **View Results** (User):
   - User logs in
   - User views MCU results
   - User downloads result files

7. **Analytics** (Admin):
   - View updated dashboard statistics
   - Generate report including this participant

**Expected Result**:
- Complete cycle works smoothly
- All notifications sent appropriately
- Data flows correctly between modules
- User experience is seamless
- No errors or delays
- All audit trails recorded

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-FLOW-002: Bulk Import and Schedule
**Priority**: High  
**Role**: Admin

**Scenario**: Import multiple participants and schedule them

**Test Steps**:
1. Import 10 participants from Excel
2. Verify all 10 imported successfully
3. Create schedules for all 10 participants
4. Verify all schedules created
5. Check all notifications sent
6. View calendar with all schedules

**Expected Result**:
- Bulk import successful
- Bulk scheduling successful
- All notifications sent
- System performance acceptable
- No errors or timeouts

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

#### UAT-FLOW-003: Schedule Modification Flow
**Priority**: High  
**Role**: Admin & User

**Scenario**: Schedule created, modified, then cancelled

**Test Steps**:
1. Create schedule for participant
2. User receives notification and views schedule
3. Admin modifies schedule date
4. User receives update notification
5. User views updated schedule
6. Admin cancels schedule
7. User receives cancellation notification
8. Admin creates new schedule
9. Complete cycle

**Expected Result**:
- Each change triggers appropriate notification
- User always sees current information
- History tracked properly
- No confusion in communication

**Actual Result**: _____________

**Status**: ☐ Pass ☐ Fail ☐ Blocked

**Comments**: _____________________________________________

---

## 📊 UAT Execution Tracking

### Test Execution Summary

| Module | Total Tests | Executed | Passed | Failed | Blocked | Pass Rate |
|--------|-------------|----------|--------|--------|---------|-----------|
| Authentication | 5 | 0 | 0 | 0 | 0 | 0% |
| Participant Mgmt | 8 | 0 | 0 | 0 | 0 | 0% |
| Schedule Mgmt | 7 | 0 | 0 | 0 | 0 | 0% |
| Results Mgmt | 4 | 0 | 0 | 0 | 0 | 0% |
| Dashboard & Reports | 4 | 0 | 0 | 0 | 0 | 0% |
| Communication | 2 | 0 | 0 | 0 | 0 | 0% |
| Integration Flows | 3 | 0 | 0 | 0 | 0 | 0% |
| **TOTAL** | **33** | **0** | **0** | **0** | **0** | **0%** |

---

## 🐛 Issue Tracking

### Issue Log Template

| ID | Module | Priority | Description | Steps to Reproduce | Expected | Actual | Reported By | Date | Status |
|----|--------|----------|-------------|-------------------|----------|--------|-------------|------|--------|
| UAT-001 | - | - | - | - | - | - | - | - | Open |

### Issue Priority

- **P0 - Critical**: System crash, data loss, blocking issue
- **P1 - High**: Major feature not working, significant impact
- **P2 - Medium**: Minor feature issue, workaround available
- **P3 - Low**: Cosmetic, enhancement, nice to have

### Issue Status

- **Open**: Issue reported, not yet assigned
- **In Progress**: Being investigated/fixed
- **Fixed**: Fix completed, ready for retest
- **Verified**: Retested and confirmed fixed
- **Closed**: Issue resolved and accepted
- **Deferred**: Will be fixed in future release
- **Won't Fix**: Not a bug or out of scope

---

## 📝 UAT Feedback Form

### Tester Information
- **Tester Name**: _____________________
- **Role**: ☐ Super Admin ☐ Admin ☐ User
- **Date**: _____________________

### Overall Experience

1. **Ease of Use** (1-5): ☐☐☐☐☐
   - 1 = Very Difficult, 5 = Very Easy

2. **Interface Design** (1-5): ☐☐☐☐☐
   - 1 = Poor, 5 = Excellent

3. **Performance** (1-5): ☐☐☐☐☐
   - 1 = Very Slow, 5 = Very Fast

4. **Feature Completeness** (1-5): ☐☐☐☐☐
   - 1 = Incomplete, 5 = Complete

5. **Overall Satisfaction** (1-5): ☐☐☐☐☐
   - 1 = Very Unsatisfied, 5 = Very Satisfied

### Qualitative Feedback

**What did you like most?**
_____________________________________________________________
_____________________________________________________________

**What needs improvement?**
_____________________________________________________________
_____________________________________________________________

**Any missing features?**
_____________________________________________________________
_____________________________________________________________

**Any confusing parts?**
_____________________________________________________________
_____________________________________________________________

**Additional comments:**
_____________________________________________________________
_____________________________________________________________

**Would you recommend this system?** ☐ Yes ☐ No

**Signature**: _____________________  **Date**: _____________________

---

## 📊 System Usability Scale (SUS)

### Instructions
Rate your agreement with each statement (1 = Strongly Disagree, 5 = Strongly Agree)

| # | Statement | 1 | 2 | 3 | 4 | 5 |
|---|-----------|---|---|---|---|---|
| 1 | I think I would like to use this system frequently | ☐ | ☐ | ☐ | ☐ | ☐ |
| 2 | I found the system unnecessarily complex | ☐ | ☐ | ☐ | ☐ | ☐ |
| 3 | I thought the system was easy to use | ☐ | ☐ | ☐ | ☐ | ☐ |
| 4 | I think I would need support to use this system | ☐ | ☐ | ☐ | ☐ | ☐ |
| 5 | I found the various functions well integrated | ☐ | ☐ | ☐ | ☐ | ☐ |
| 6 | I thought there was too much inconsistency | ☐ | ☐ | ☐ | ☐ | ☐ |
| 7 | I imagine most people would learn quickly | ☐ | ☐ | ☐ | ☐ | ☐ |
| 8 | I found the system very cumbersome to use | ☐ | ☐ | ☐ | ☐ | ☐ |
| 9 | I felt very confident using the system | ☐ | ☐ | ☐ | ☐ | ☐ |
| 10 | I needed to learn a lot before using this system | ☐ | ☐ | ☐ | ☐ | ☐ |

**SUS Score**: _________ / 100

**Interpretation**:
- 0-50: Poor
- 51-70: Fair
- 71-85: Good
- 86-100: Excellent

**Target**: ≥ 70

---

## ✅ UAT Sign-off

### Acceptance Criteria

- [ ] ≥ 95% of test scenarios passed
- [ ] 0 critical (P0) issues open
- [ ] 0 high (P1) issues open
- [ ] All medium (P2) issues documented and accepted
- [ ] Average user satisfaction ≥ 90%
- [ ] SUS Score ≥ 70
- [ ] All key user workflows tested
- [ ] Performance acceptable (< 3s)
- [ ] Documentation reviewed and approved
- [ ] Training materials adequate

### Stakeholder Sign-off

#### UAT Lead
- **Name**: _____________________
- **Status**: ☐ Approved ☐ Approved with conditions ☐ Rejected
- **Comments**: _____________________________________________
- **Signature**: _____________________
- **Date**: _____________________

#### Business Representative
- **Name**: _____________________
- **Status**: ☐ Approved ☐ Approved with conditions ☐ Rejected
- **Comments**: _____________________________________________
- **Signature**: _____________________
- **Date**: _____________________

#### QA Lead
- **Name**: _____________________
- **Status**: ☐ Approved ☐ Approved with conditions ☐ Rejected
- **Comments**: _____________________________________________
- **Signature**: _____________________
- **Date**: _____________________

#### Project Manager
- **Name**: _____________________
- **Status**: ☐ Approved ☐ Approved with conditions ☐ Rejected
- **Comments**: _____________________________________________
- **Signature**: _____________________
- **Date**: _____________________

#### IT Manager
- **Name**: _____________________
- **Status**: ☐ Approved ☐ Approved with conditions ☐ Rejected
- **Comments**: _____________________________________________
- **Signature**: _____________________
- **Date**: _____________________

---

## 📋 Post-UAT Actions

### Action Items

| ID | Action | Owner | Priority | Due Date | Status |
|----|--------|-------|----------|----------|--------|
| 1 | Fix all P0/P1 issues | Dev Team | High | - | Pending |
| 2 | Address approved P2 issues | Dev Team | Medium | - | Pending |
| 3 | Update documentation based on feedback | Doc Team | Medium | - | Pending |
| 4 | Enhance training materials | Training Team | Medium | - | Pending |
| 5 | Prepare production deployment | DevOps | High | - | Pending |

### Lessons Learned

**What went well?**
_____________________________________________________________
_____________________________________________________________

**What could be improved?**
_____________________________________________________________
_____________________________________________________________

**Recommendations for future UAT:**
_____________________________________________________________
_____________________________________________________________

---

## 📞 UAT Support

### Contact Information

**UAT Lead**
- Name: [Name]
- Email: uat-lead@mcu-system.com
- Phone: [Phone]

**Technical Support**
- Email: uat-support@mcu-system.com
- Slack: #uat-support
- Phone: [Phone]

**Business Support**
- Email: business-support@mcu-system.com
- Phone: [Phone]

### Support Hours During UAT
- **Monday - Friday**: 08:00 - 17:00
- **Response Time**: < 30 minutes
- **Issue Resolution**: Same day for P0/P1

---

## 📚 Reference Documents

1. [SPECIFICATION_CHECKLIST.md](SPECIFICATION_CHECKLIST.md) - Requirements
2. [TESTING_GUIDE.md](TESTING_GUIDE.md) - Testing procedures
3. [QUALITY_ASSURANCE.md](QUALITY_ASSURANCE.md) - QA standards
4. [README.md](README.md) - System overview
5. User Manual (provided separately)
6. Training Materials (provided separately)

---

## 📝 Document Control

| Version | Date | Author | Changes |
|---------|------|--------|---------|
| 1.0 | Oct 2024 | QA Team | Initial UAT document |

**Last Updated**: October 12, 2024  
**Next Review**: After UAT completion  
**Status**: Ready for Execution

---

**Prepared by**: QA Team  
**Reviewed by**: Project Manager  
**Approved by**: IT Manager

**UAT Environment**: https://staging.mcu-system.go.id  
**UAT Period**: Week 16 (5 days)  
**Expected Completion**: Week 17

---

*"Quality is not an act, it is a habit."* - Aristotle

**Good luck with the UAT! Let's ensure our system meets user expectations.** 🎯✅


