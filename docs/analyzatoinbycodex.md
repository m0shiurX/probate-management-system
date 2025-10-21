# Feature Summary
- User & Access Control — manage staff accounts, partner firms, API keys, and login auditing.
- Client & Contact Records — maintain individuals, beneficiaries, executors, and partner organizations with GDPR tracking.
- Probate & Will Case Management — handle probate files, related leads, executors, overseas matters, and case status workflows.
- Document & Template Library — store uploaded documents, generated templates, and correspondence history.
- Tasking & Collaboration — support to-do items, chat messages, case editing locks, and holiday scheduling.
- Finance & Billing — track probate accounting, ledgers, liabilities, QuickBooks integrations, subscriptions, and payments.
- Marketing & Communications — capture leads, quotes, marketing emails/letters, and Mailchimp-style list management.
- Compliance & AML — log AML requests, smart search API usage, and record change history.

# Proposed Database Structure
- users
  - Purpose: Core authentication and profile management.
  - Relationships: users *—* roles (via user_role); users 1—* cases; users 1—* documents.

- roles
  - Purpose: Define system roles and permissions.
  - Relationships: roles *—* users (via user_role); roles 1—* permissions (via role_permission).

- firms
  - Purpose: Store partner company details and integration credentials.
  - Relationships: firms 1—* users; firms 1—* cases; firms 1—* subscriptions.

- clients
  - Purpose: Centralize all client, executor, and beneficiary person records.
  - Relationships: clients *—* cases (via case_participants); clients 1—* addresses; clients 1—* gdpr_preferences.

- addresses
  - Purpose: Normalize postal contact information shared across entities.
  - Relationships: addresses 1—* clients; addresses 1—* firms; addresses 1—* cases.

- gdpr_preferences
  - Purpose: Track consent and contact preferences.
  - Relationships: gdpr_preferences 1—1 clients; gdpr_preferences 1—1 users.

- cases
  - Purpose: Represent probate, will, and related legal matters.
  - Relationships: cases *—* clients (via case_participants); cases 1—* case_status_logs; cases 1—* documents; cases 1—* tasks; cases 1—* financial_accounts.

- case_participants
  - Purpose: Link clients to cases with participant roles (executor, beneficiary, etc.).
  - Relationships: case_participants many-to-one to cases; case_participants many-to-one to clients.

- case_status_logs
  - Purpose: Record progression of case workflow checkpoints.
  - Relationships: case_status_logs many-to-one to cases; case_status_logs many-to-one to users.

- leads
  - Purpose: Manage prospective cases, quotes, and marketing conversions.
  - Relationships: leads 1—1 cases (optional); leads 1—* lead_contacts; leads many-to-one firms.

- lead_contacts
  - Purpose: Store additional contact people attached to a lead.
  - Relationships: lead_contacts many-to-one to leads; lead_contacts many-to-one to clients.

- tasks
  - Purpose: Track todos, reminders, and case actions.
  - Relationships: tasks many-to-one to cases; tasks many-to-one to users; tasks many-to-one to firms.

- communications
  - Purpose: Consolidate emails, letters, chat messages, and notifications.
  - Relationships: communications many-to-one to cases; communications many-to-one to users; communications many-to-one to clients.

- documents
  - Purpose: Manage uploaded files, generated templates, and versioning.
  - Relationships: documents many-to-one to cases; documents many-to-one to users; documents *—* templates (via document_template).

- templates
  - Purpose: Catalog reusable document/email templates and folders.
  - Relationships: templates *—* documents (via document_template); templates many-to-one to users.

- financial_accounts
  - Purpose: Maintain estate ledgers, assets, liabilities, and payment requests per case.
  - Relationships: financial_accounts many-to-one to cases; financial_accounts 1—* financial_entries; financial_accounts 1—* financial_documents.

- financial_entries
  - Purpose: Store ledger transactions, distributions, and reconciliations.
  - Relationships: financial_entries many-to-one to financial_accounts; financial_entries many-to-one to clients; financial_entries many-to-one to users.

- subscriptions
  - Purpose: Track partner subscriptions, recurring services, and products.
  - Relationships: subscriptions many-to-one to firms; subscriptions many-to-one to products.

- products
  - Purpose: Define billable services and packages.
  - Relationships: products 1—* subscriptions; products 1—* financial_entries.

- audit_logs
  - Purpose: Record data changes and API activity for compliance.
  - Relationships: audit_logs many-to-one to users; audit_logs many-to-one to cases; audit_logs many-to-one to clients.

- integrations
  - Purpose: Store external API credentials and sync metadata (QuickBooks, AML, Mailchimp).
  - Relationships: integrations many-to-one to firms; integrations many-to-one to users.

# Quick Notes
- Legacy schema duplicates person/contact fields across dozens of tables and embeds JSON blobs (`prop_*_arr`) that should become relational entities.
- Several tables use integer timestamps and text enums interchangeably; plan data migrations to normalize into Laravel datetime columns and enum tables.
- Currency column default uses legacy `¬£` symbol; map values to standardized ISO currency codes during migration.
- Sessions, cache, and queue tables mirror Laravel defaults; retain but move them into separate infrastructure database if supported.
- Confidence: Medium — inferred case/participant roles and financial groupings from table names; assumptions may need adjustment once business rules are clarified.