# Probate Management System - Database Analysis

## Executive Summary

This was a comprehensive web-based legal case management system designed for law firms specializing in probate, wills, and estate management. The system tracked complex multi-party cases, integrated accounting with QuickBooks Online, managed international/overseas cases, and maintained full compliance documentation including AML (Anti-Money Laundering) checks.

---

## Part 1: Existing System Architecture

### Core Modules

#### 1. **User & Account Management** (5 tables)
| Table | Purpose |
|-------|---------|
| `accounts` | Core user accounts with credentials, contact info, TFA secrets, API keys |
| `accounts_extra` | Extended user profile data (flexible text fields) |
| `accounts_online` | Real-time user online status tracking |
| `accounts_copy` | Historical/backup copy of account records |
| `login_logs` | Login activity audit trail with IP and timestamp |

#### 2. **Client Management** (7 tables + variants)
The system has **multiple client type tables** - a major design issue:

| Table | Purpose |
|-------|---------|
| `client_details` | Core client personal/contact information |
| `clients` | Client profiles with service tracking (wills, LPA, trusts, funeral plans, deeds, annual care) |
| `probate_clients` | Clients specifically for probate cases with estate details |
| `misc_clients` | Miscellaneous clients for other services/storage |
| `overseas_clients` | International clients with overseas assets |
| `leads` | Sales leads/prospects for potential new clients |
| `leads_executors` | Executors associated with lead cases |
| `leads_contacts` | Contact details for leads (implicit relationship) |

**Overlapping Data:** These tables store largely redundant information (names, addresses, contact details, GDPR preferences) across different client types.

#### 3. **Probate Case Management** (8 tables)
| Table | Purpose |
|-------|---------|
| `probate_clients` | Probate case masters (deceased person details, NINO, estate notes) |
| `probate_persons` | Executors, beneficiaries, and related parties in probate cases |
| `probate_case_status` | Detailed questionnaire tracking (status_q1-q21, status_dow) |
| `probate_assets` | Deceased's assets (bank accounts, investments, property) |
| `probate_property` | Real estate properties with insurance, valuation, drainage, clearing status |
| `probate_deleted` | Soft-delete archive for deleted probate records |
| `probate_acc_assets` | Accounting view of assets (realized value, interest earned) |
| `probate_admin_spreadsheet` | Administrative spreadsheet data storage |

#### 4. **Accounting & Financial Management** (8 tables)
| Table | Purpose |
|-------|---------|
| `probate_acc_ledger` | Transaction ledger (receipts, payments, BACS/cheques, approval workflow) |
| `probate_acc_assets` | Asset valuations and realization tracking |
| `probate_acc_liabilities` | Debts and liabilities of estates |
| `probate_acc_distribution` | Beneficiary distributions (percentages and amounts) |
| `probate_acc_request_payment` | Payment requests with approval workflow |
| `earnings` | Staff commission and earnings tracking |
| `payments` | Manual payments and authorization |
| `accounting` | Global accounting settings/fields |

#### 5. **QuickBooks Online Integration** (3 tables)
| Table | Purpose |
|-------|---------|
| `qbo_invoice_request` | Invoice generation requests to send to QBO |
| `qbo_items` | Cached QBO line items and services |
| `qbo_tokens` | OAuth tokens for QuickBooks authentication |

#### 6. **Will Management** (1 joining table + client references)
| Table | Purpose |
|-------|---------|
| `will_with_probate` | Links wills to probate cases (one-to-many relationship) |

**Note:** Wills are primarily tracked via the `clients` table fields and don't have their own dedicated tables.

#### 7. **Overseas/International Cases** (4 tables)
| Table | Purpose |
|-------|---------|
| `overseas_clients` | International client cases with overseas assets |
| `overseas_persons` | Executors/beneficiaries in overseas cases |
| `overseas_assets` | Assets held in foreign countries/currencies |
| `overseas_mg` | Probably "Monkey Grants" or similar legal documents in JSON format |
| `overseas_type_status` | Workflow status tracking for overseas cases (forms, verification, courier tracking) |

#### 8. **AML & Compliance** (2 tables)
| Table | Purpose |
|-------|---------|
| `aml_requests` | AML (Anti-Money Laundering) check requests |
| `amllogs` | Detailed logs of AML API calls (requests/responses/errors) |

#### 9. **Document Management** (5 tables)
| Table | Purpose |
|-------|---------|
| `document_store` | Central document storage with tokens for secure access |
| `templates` | Legal document templates |
| `templates_done` | Completed/generated documents from templates |
| `templates_folders` | Folder organization for templates |
| `storage_box` | Physical storage box tracking (archive management) |

#### 10. **Internal Communications** (6 tables)
| Table | Purpose |
|-------|---------|
| `chat_messages` | Internal instant messaging system |
| `chat_online` | User online status for chat |
| `email_templates` | Email template library |
| `marketing_emails` | Sent marketing emails with open tracking |
| `marketing_letters` | Physical letter mail-outs log |
| `record_changes` | Audit trail of data modifications |

#### 11. **Internal Operations** (6 tables)
| Table | Purpose |
|-------|---------|
| `todo_list` | Task management for staff |
| `staff_holidays` | Holiday/leave booking and approval |
| `case_editing` | Concurrent editing locks (prevents simultaneous edits) |
| `consultants_list` | Staff/consultant directory |
| `query_logs` | Database query audit trail |
| `partners` | Partner company contacts and API credentials |

#### 12. **System Infrastructure** (9 tables)
| Table | Purpose |
|-------|---------|
| `users` | Laravel user authentication table |
| `sessions` | Session management |
| `password_reset_tokens` | Password reset token tracking |
| `failed_jobs` | Failed queue job logging |
| `jobs` | Job queue system |
| `job_batches` | Batch job grouping |
| `cache` | Cache storage |
| `cache_locks` | Cache locking mechanism |
| `menus` | Navigation menu configuration |

#### 13. **Miscellaneous Data** (5 tables)
| Table | Purpose |
|-------|---------|
| `products` | Service/product offerings |
| `subscriptions` | Customer subscription records |
| `email_templates` | Email message templates |
| `api_calls` | API integration call logs |
| `mc_lists` | Mailchimp audience/list management |

#### 14. **Sandbox/Testing** (3 tables)
| Table | Purpose |
|-------|---------|
| `sandbox_clients` | Test/development copy of clients |
| `sandbox_client_details` | Test/development copy of client details |
| `sandbox_persons` | Test/development copy of persons |

---

## Key Features Identified

### Business Processes

1. **Client Onboarding**
   - Client intake and lead management
   - Multiple service types (wills, probate, trusts, LPA, funeral plans, deeds)
   - Document collection and storage

2. **Probate Case Lifecycle**
   - Case intake from leads
   - Deceased person registration
   - Executor/beneficiary identification
   - Asset declaration and valuation
   - Accounting and distribution
   - Property management (insurance, valuation, clearing)
   - Case status tracking via detailed questionnaire

3. **Estate Accounting**
   - Multi-currency support (overseas assets)
   - Transaction ledger with approval workflows
   - Asset realization and interest tracking
   - Beneficiary distribution calculations
   - Payment requests and authorization

4. **Compliance & Risk**
   - AML (Anti-Money Laundering) checks with API integration
   - GDPR consent tracking (opt-in dates, methods, withholding)
   - Detailed audit trails (record changes, query logs, login logs)
   - Concurrent editing prevention

5. **International Support**
   - Overseas client management
   - Multi-currency asset tracking
   - Courier and document verification workflow
   - Tax clearance and IRS coordination

6. **Document Management**
   - Legal template library
   - Document generation from templates
   - Secure document storage with tokens
   - Physical storage box tracking

7. **Marketing & Communications**
   - Email and letter campaigns
   - Open/read tracking
   - Internal chat system
   - Task management and staff coordination

8. **Integration Points**
   - QuickBooks Online for invoicing
   - Mailchimp for marketing automation
   - AML check provider API
   - Custom APIs for external access

---

## Data Duplication & Design Issues

### Critical Issues

| Issue | Location | Impact |
|-------|----------|--------|
| **Fragmented Client Model** | Multiple client tables (clients, probate_clients, misc_clients, overseas_clients) | Redundant name/address/contact fields; inconsistent GDPR tracking |
| **Repeated GDPR Fields** | Present in client_details, clients, persons, probate_persons, overseas_persons, misc_clients, leads | Massive duplication; maintenance nightmare |
| **No Proper Relationships** | Foreign keys missing; data linked by codes/IDs without constraints | Data integrity issues; orphaned records likely |
| **Separate Accounting Tables** | probate_acc_* tables mirror data in probate_assets | Denormalization without clear purpose |
| **Historic Copies** | accounts_copy, sandbox_* tables | Poor approach to versioning; should use soft-deletes or audit tables |
| **Overlapping Person Types** | persons, probate_persons, overseas_persons, leads_executors | Same role (executor/beneficiary) modeled in 4 places |

---

## Part 2: Proposed Modernized Database Structure

### Design Principles

1. **Single Source of Truth** - One client, one person, one asset, one transaction record
2. **Proper Relationships** - Foreign keys and referential integrity
3. **Audit Trail** - Timestamps, soft deletes, change tracking (not separate tables)
4. **GDPR Compliance** - Centralized consent tracking
5. **Scalability** - Normalized, but with strategic denormalization for performance
6. **Extensibility** - Use polymorphic relationships for case types (probate, will, trust)

### Proposed Table Structure

#### Core Domain (Identity & Relationships)

```
accounts (Users/Staff)
├─ id, username, email, password, api_key, tfa_secret
├─ access_level, is_restricted, status
├─ name, surname, title, contact info
├─ deleted_at, created_at, updated_at

clients
├─ id (primary client record)
├─ client_code (legacy reference)
├─ title, forename, surname, dob
├─ is_deceased, deceased_date
├─ address fields (single set)
├─ contact fields (single set)
├─ estate_worth
├─ company_id (FK)
├─ consultant_id (FK to accounts)
├─ secondary_consultant_id (FK to accounts)
├─ gdpr_consent (JSON with timestamps, methods, withholding reason)
├─ deleted_at, created_at, updated_at

persons (Executors, Beneficiaries, Relatives)
├─ id
├─ name, title, dob, relationship
├─ address fields, contact fields
├─ gdpr_consent (JSON)
├─ deleted_at, created_at, updated_at

cases (Polymorphic - Probate, Will, Trust, etc.)
├─ id
├─ case_type (probate, will, trust, lpa, funeral_plan, deeds, annual_care)
├─ case_number, case_reference
├─ primary_client_id (FK to clients) - deceased or testator
├─ secondary_client_id (FK to clients) - co-client
├─ company_id (FK)
├─ case_manager_id (FK to accounts)
├─ agent_id (FK to accounts)
├─ status (enum: pending, active, completed, archived)
├─ submitted_by (FK to accounts)
├─ date_created, date_completed, date_archived
├─ notes, special_notes
├─ deleted_at, created_at, updated_at

case_persons (Links persons to cases with specific roles)
├─ id
├─ case_id (FK)
├─ person_id (FK)
├─ role_type (executor, beneficiary, witness, solicitor, etc.)
├─ exec_number (for ordering executors)
├─ account_no, sort_code (banking details)
├─ share_percentage (for beneficiaries)
├─ status (alive, deceased, abdicated, etc.)
├─ id_checked, bankruptcy_checked, aml_checked
├─ created_at, updated_at
```

#### Case-Specific Details

```
case_status_probate (Probate-specific fields)
├─ id
├─ case_id (FK unique)
├─ deceased_nino
├─ estate_notes (800 chars)
├─ covid_status
├─ ledger_account
├─ od_explanation, od_timestamp
├─ questionnaire_json (status_q1 through q21)
├─ [other probate-specific fields as JSON or separate columns]

case_status_overseas
├─ id
├─ case_id (FK unique)
├─ case_type_description
├─ assets_to_be_dealt_with
├─ submitter_type, submitter info (FK to accounts or misc data)
├─ workflow_status_json (forms_sent, forms_signed, id_verified, etc.)
├─ tax_clearance_received, clearance_date
└─ [other overseas-specific fields]

case_properties (Real Estate)
├─ id
├─ case_id (FK)
├─ address (full address fields)
├─ title_number
├─ status_sold, status_selling, status_transferring, etc. (booleans)
├─ insurance_active, insurance_from, insurance_expired
├─ insurance_provider_id (FK to service_providers)
├─ valuation_date, valuation_amount, valuation_provider_id
├─ age_assessment_date, age_assessment_provider_id
├─ clearing_date, clearing_provider_id
├─ keys_held_with (text/notes)
├─ notes
├─ created_at, updated_at

service_providers (Insurance, Valuers, Solicitors, etc.)
├─ id
├─ name
├─ contact, company, address, phone, email
├─ service_type (insurance, valuation, age_assessment, solicitor, courier, etc.)
├─ created_at, updated_at
```

#### Assets & Accounting

```
assets (Declared assets from clients)
├─ id
├─ case_id (FK)
├─ asset_type (bank_account, investment, property, vehicle, etc.)
├─ is_joint (boolean)
├─ account_number
├─ description
├─ declared_value (decimal)
├─ currency
├─ declared_date
├─ created_at, updated_at

accounting_ledger (Complete transaction history)
├─ id
├─ case_id (FK)
├─ transaction_type (receipt, payment, interest, fee, distribution, etc.)
├─ transaction_date
├─ description
├─ amount (decimal, can be positive/negative)
├─ currency
├─ cleared_date
├─ method (bacs, cheque, cash, transfer, etc.)
├─ cheque_number
├─ reference_number
├─ reason (why the transaction occurred)
├─ approved (boolean)
├─ approved_by_id (FK to accounts)
├─ approved_date
├─ related_to_asset_id (FK to assets, optional)
├─ related_to_liability_id (FK to liabilities, optional)
├─ created_at, updated_at

liabilities (Debts to be settled from estate)
├─ id
├─ case_id (FK)
├─ liability_type (mortgage, loan, credit_card, tax, utility, etc.)
├─ description
├─ creditor_name
├─ declared_amount (decimal)
├─ paid_amount (decimal)
├─ status (unpaid, partially_paid, paid)
├─ due_date
├─ paid_date
├─ notes
├─ created_at, updated_at

distributions (Beneficiary payments)
├─ id
├─ case_id (FK)
├─ distribution_type (residuary, specific_gift, per_stirpes, etc.)
├─ beneficiary_id (FK to case_persons - person with beneficiary role)
├─ share_percentage
├─ calculated_amount (decimal)
├─ status (pending, approved, paid)
├─ paid_date
├─ payment_method
├─ notes
├─ created_at, updated_at

payment_requests
├─ id
├─ case_id (FK)
├─ requested_by_id (FK to accounts)
├─ requested_date
├─ request_type (payee_payment, beneficiary_payment, etc.)
├─ payee_name
├─ amount (decimal)
├─ reason
├─ method (bacs, cheque)
├─ sort_code, account_number (if BACS)
├─ cheque_number (if cheque)
├─ status (requested, approved, rejected, processed)
├─ approved_by_id (FK to accounts)
├─ approved_date
├─ rejected_reason (if rejected)
├─ related_ledger_id (FK to accounting_ledger)
├─ created_at, updated_at
```

#### Compliance & Verification

```
aml_checks
├─ id
├─ case_id (FK)
├─ person_id (FK)
├─ check_type (individual, corporate)
├─ full_name_checked
├─ dob_checked
├─ result (clear, flag_1, flag_2, match, etc.)
├─ result_summary
├─ result_pdf_url
├─ aml_token (provider reference)
├─ checked_by_id (FK to accounts)
├─ checked_date
├─ expires_date
├─ notes
├─ created_at, updated_at

compliance_audit
├─ id
├─ entity_type (enum: case, person, account, transaction)
├─ entity_id
├─ action (create, update, delete, verify, approve, etc.)
├─ old_values (JSON)
├─ new_values (JSON)
├─ changed_by_id (FK to accounts)
├─ ip_address
├─ user_agent
├─ reason (manual note)
├─ created_at
```

#### Documents & Templates

```
documents
├─ id
├─ case_id (FK)
├─ document_type (will, template_generated, uploaded, etc.)
├─ filename
├─ description
├─ file_path / storage_token
├─ file_size
├─ mime_type
├─ uploaded_by_id (FK to accounts)
├─ uploaded_date
├─ physical_storage_box_id (FK)
├─ access_token (UUID for secure sharing)
├─ is_deleted
├─ deleted_by_id (FK to accounts)
├─ deleted_date
├─ created_at, updated_at

templates
├─ id
├─ template_name
├─ template_type (will, lpa, trust_deed, etc.)
├─ folder_id (FK)
├─ file_path
├─ created_by_id (FK to accounts)
├─ is_active (boolean)
├─ created_at, updated_at

documents_generated (From templates)
├─ id
├─ case_id (FK)
├─ template_id (FK)
├─ generated_filename
├─ generated_date
├─ generated_by_id (FK to accounts)
├─ generated_from_token
├─ document_id (FK - links to final document)
├─ created_at

storage_boxes
├─ id
├─ box_number (physical ID)
├─ box_location
├─ box_capacity
├─ box_usage (count of stored items)
├─ created_at
```

#### Marketing & Communications

```
marketing_campaigns
├─ id
├─ campaign_name
├─ campaign_type (email, letter, both)
├─ template_id (FK to email_templates or letter_templates)
├─ target_criteria (JSON - client types, status, segments, etc.)
├─ scheduled_date
├─ sent_date
├─ created_by_id (FK to accounts)
├─ mailchimp_campaign_id (if MC integrated)
├─ created_at, updated_at

marketing_communications (Individual outreach)
├─ id
├─ campaign_id (FK)
├─ client_id (FK)
├─ communication_type (email, letter, other)
├─ sent_to
├─ subject / content
├─ sent_date
├─ read_date (if email)
├─ opened_count
├─ link_clicks (JSON array of clicked links)
├─ notes
├─ created_at, updated_at

internal_messages (Chat system)
├─ id
├─ from_id (FK to accounts)
├─ to_id (FK to accounts)
├─ message_text
├─ is_read
├─ read_at
├─ sent_at
├─ created_at

staff_todos
├─ id
├─ todo_type (task, reminder, follow_up, etc.)
├─ assigned_to_id (FK to accounts)
├─ related_case_id (FK to cases, optional)
├─ related_person_id (FK to persons, optional)
├─ title
├─ description
├─ due_date
├─ priority (0-5)
├─ status (pending, in_progress, completed, cancelled)
├─ completed_date
├─ completed_by_id (FK to accounts)
├─ notes
├─ origin (system, manual, case_event, etc.)
├─ created_at, updated_at

staff_leave
├─ id
├─ staff_id (FK to accounts)
├─ leave_type (holiday, sick, personal, etc.)
├─ start_date
├─ end_date
├─ working_days_count
├─ status (pending, approved, rejected)
├─ approved_by_id (FK to accounts)
├─ approval_date
├─ notes
├─ created_at, updated_at
```

#### System & Integrations

```
integrations_oauth_tokens
├─ id
├─ integration_name (quickbooks_online, mailchimp, smart_search, etc.)
├─ token_type (bearer, basic, oauth2)
├─ access_token
├─ refresh_token
├─ expires_at
├─ scope
├─ created_at, updated_at

integrations_api_logs
├─ id
├─ integration_name (FK)
├─ http_method (GET, POST, PUT, etc.)
├─ endpoint
├─ request_payload (JSON)
├─ response_status_code
├─ response_body (JSON)
├─ error_message
├─ caller_id (FK to accounts)
├─ created_at

company_settings
├─ id
├─ company_id (FK) - for multi-tenant support
├─ setting_key
├─ setting_value (JSON/TEXT)
├─ created_at, updated_at

users (Laravel auth table)
├─ id
├─ name, email, password
├─ email_verified_at
├─ two_factor_secret, two_factor_enabled
├─ remember_token
├─ created_at, updated_at

sessions
├─ id
├─ user_id (FK)
├─ ip_address, user_agent
├─ payload
├─ last_activity
```

---

## Migration Strategy

### Phase 1: Foundation
1. Create new normalized tables (clients, persons, cases, case_persons)
2. Add foreign key constraints
3. Add audit trail capability

### Phase 2: Data Migration
1. Consolidate `clients`, `probate_clients`, `misc_clients`, `overseas_clients` → new `clients`
2. Consolidate `persons`, `probate_persons`, `overseas_persons` → new `persons` 
3. Create `cases` from existing case records with proper type classification
4. Link persons to cases via `case_persons`
5. Consolidate accounting tables → single `accounting_ledger`

### Phase 3: Cleanup
1. Migrate documents to new structure
2. Update integrations (QBO, AML, Mailchimp)
3. Decommission old tables (optionally keep as views for backwards compatibility)

---

## Key Improvements

| Aspect | Before | After |
|--------|--------|-------|
| **Client Fragmentation** | 5 separate client tables | 1 unified clients table + polymorphic cases |
| **Person/Role Data** | 4 person tables with overlaps | 1 persons table + flexible case_persons linking |
| **GDPR Tracking** | Replicated in 7 tables | Centralized in clients & persons |
| **Relationships** | No foreign keys | Proper referential integrity |
| **Audit Trail** | Multiple scattered tables | Single compliance_audit table |
| **Accounting** | 8 tables with duplication | Single ledger + supporting tables |
| **Data Integrity** | Orphaned records possible | Cascading deletes + soft deletes |
| **Scalability** | Limited; denormalized in ad-hoc ways | Normalized; strategic denormalization via views |

---

## Notes for Laravel 12 Implementation

1. **Use Eloquent Models** - One model per table with clear relationships
2. **Polymorphic Relationships** - Cases table can use polymorphic morph types
3. **Soft Deletes** - Use `SoftDeletes` trait instead of multiple tables
4. **Audit Trail** - Consider using packages like `Spatie\Activitylog`
5. **Multi-tenancy** - Add `company_id` foreign keys if multi-tenant needed
6. **Timestamps** - Always use `timestamps()` on new tables
7. **Enums** - Use PHP Enums for case types, statuses, transaction types
8. **Casts** - Use JSON casts for flexible fields (gdpr_consent, workflow_status_json)
9. **Relationships** - Define clear `hasMany`, `belongsTo`, `morphMany` on models
10. **Migrations** - Use Laravel 12 migration helpers for cleaner code

