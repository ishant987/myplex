# ARN Verification Admin Handoff

## Purpose

This document is for the separate admin AI/project.

We need an admin module named `arn-verification` where admin can:

- view all registered ARN users
- see full registration details
- change ARN verification status from `pending` to `verified`
- optionally change `verified` back to `pending`
- show a confirmation popup before status change

Important:

- Right now, a separate ARN verification table is **not required**
- current application already stores ARN verification status in the `users` table

## Current Data Model

Use the existing `users` table.

Relevant column already exists:

```text
users.arn_verification_status
```

Current allowed values:

```text
pending
verified
```

Migration already used in main project:

```text
database/migrations/2026_05_29_112000_add_arn_verification_status_to_users_table.php
```

It adds:

```php
$table->string('arn_verification_status', 20)->default('pending')->after('arn');
```

## Recommendation

Do **not** create a new table like `arn_verifications` for now.

Why:

- all registration details are already in `users`
- login blocking already depends on `users.arn_verification_status`
- simpler admin workflow
- less duplication

Create a dedicated admin folder/module:

```text
arn-verification
```

But keep the data source as:

```text
users table
```

## User Fields To Show In Admin Table

Show these columns in ARN verification listing:

- `u_id`
- `u_code`
- `company`
- `contact_person`
- `f_name`
- `l_name`
- `email`
- `city`
- `state`
- `arn`
- `pan`
- `gst`
- `subscription_expiry_date`
- `created_at`
- `arn_verification_status`

Optional nice-to-have:

- `mobile`
- `is_approved`
- `email_verified_at`

## Table Screen Requirements

Create page:

```text
ARN Verification List
```

Suggested folder structure:

```text
resources/views/admin/arn-verification/
app/Http/Controllers/Admin/ArnVerificationController.php
```

Suggested files:

```text
index.blade.php
edit.blade.php
```

## List Page Features

Add a table with:

- serial number
- user id
- company name
- contact person
- email
- ARN
- PAN
- GST
- city
- state
- registration date
- current ARN status
- action button

## Filters

Add filters on top:

- search by company name
- search by contact person
- search by email
- search by ARN
- filter by status:
  - `pending`
  - `verified`

Recommended default:

- show `pending` users first

## Action Buttons

Each row should have:

- `View`
- `Verify`
- optional `Mark Pending`

Behavior:

- if current status is `pending`, show `Verify`
- if current status is `verified`, show `Mark Pending`

## Confirmation Popup

Before status update, show confirmation popup.

Popup text for verify:

```text
Are you sure you want to continue?
This user will be marked as ARN verified and will be allowed to log in.
```

Popup text for mark pending:

```text
Are you sure you want to continue?
This user will be marked as pending and will not be allowed to log in.
```

Buttons:

- `Yes, Continue`
- `Cancel`

## Detail Page Requirements

Create `View` or `Edit` page to show full user registration data.

Show:

- company name
- contact person
- first name
- last name
- email
- mobile
- city
- state
- ARN
- PAN
- GST
- current ARN verification status
- created date

Also add a status dropdown:

```text
Pending
Verified
```

And a submit button:

```text
Update ARN Status
```

Before submit, show confirmation popup.

## Backend Logic

When admin updates status:

- update `users.arn_verification_status`
- if set to `verified`, user can log in
- if set to `pending`, user login should remain blocked

No extra approval table is required in version 1.

## Login Dependency In Main Project

Main project already blocks login unless:

```php
$user->arn_verification_status === 'verified'
```

So admin project must update that same field.

## Suggested Routes

Use routes similar to:

```php
Route::get('/arn-verification', [ArnVerificationController::class, 'index'])->name('admin.arn-verification.index');
Route::get('/arn-verification/{id}', [ArnVerificationController::class, 'edit'])->name('admin.arn-verification.edit');
Route::post('/arn-verification/{id}/status', [ArnVerificationController::class, 'updateStatus'])->name('admin.arn-verification.update-status');
```

Or `PUT/PATCH` if project convention uses resource routes.

## Suggested Controller Methods

```php
index()
edit($id)
updateStatus(Request $request, $id)
```

Validation:

```php
'arn_verification_status' => 'required|in:pending,verified'
```

## Suggested Query Rules

List only ARN-type registered users if needed.

If no separate user type exists, at minimum show users where ARN is not empty:

```php
whereNotNull('arn')->where('arn', '!=', '')
```

Optional stronger filtering:

- `acc_type = 'a'` if that is the advisor/business registration type in admin project

## UI Notes

Design should feel like an admin approval screen.

Recommended visual treatment:

- `pending` status badge in amber/yellow
- `verified` status badge in green
- sticky filter row if table is long
- pagination
- sortable columns for:
  - created date
  - email
  - company
  - ARN status

## Optional Future Enhancement

If later needed, a separate table can be introduced for audit logs only, for example:

```text
arn_verification_logs
```

Possible columns:

- `id`
- `user_id`
- `old_status`
- `new_status`
- `changed_by_admin_id`
- `remarks`
- `created_at`

But this is **not required now**.

## Final Build Requirement

Please build:

1. admin folder/module `arn-verification`
2. listing page with filters and status badges
3. detail/edit page with full user registration data
4. status update action
5. confirmation popup before changing status
6. backend update on `users.arn_verification_status`

## One-Line Conclusion

For current implementation, use the existing `users` table and build a dedicated admin `arn-verification` module around `arn_verification_status`; do not create a separate ARN table yet.
