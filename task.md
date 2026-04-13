# MyPlexus — Razorpay Subscription: AI Build Instructions

## CRITICAL SAFETY RULES — READ BEFORE WRITING ANY CODE

1. **Every migration MUST use `Schema::hasTable()` and `Schema::hasColumn()` checks.**
   The live database already has tables and data. Never write a migration that drops, renames, or alters existing columns. Additive only.

2. **Never suggest `migrate:fresh`, `migrate:reset`, `db:wipe`, or `migrate:rollback` on a live server.**
   These destroy data. Only `php artisan migrate` is allowed on live.

3. **All new routes go inside a feature flag check:**
   ```php
   if (config('features.subscription_enabled')) { ... }
   ```
   This keeps live site unchanged until the developer deliberately turns it on.

4. **Read every existing file before editing it.** Do not assume what is inside
   `User.php`, `LoginController.php`, `Kernel.php`, or `routes/web.php`.
   Only ADD to these files, never remove existing code.

5. **Every migration must have a working `down()` method** so it can be rolled back safely.

---

## Project Context

This is a **Laravel-based** mutual fund analytics platform called MyPlexus.
The codebase is on a Plesk server running AlmaLinux 8.10, PHP 8.1, Laravel (version TBD from composer.json).
The project already has:
- `app/Models/User.php` with `subscription_expiry_date` column
- `subscription` middleware that gates premium routes
- `AuthController` and `LoginController` for auth
- Existing `/subscription` route at `?cal=subscription`

**Do NOT overwrite existing auth, middleware, or any existing models without reading them first.**
**Always read a file before editing it.**

---

## Your Task: Build the Complete Razorpay Subscription System

Implement all items below in the exact order listed.
After each section, confirm what was created before moving to the next.

---

## SECTION 1 — Database Migrations

> **SAFETY RULE FOR ALL MIGRATIONS:** Every migration modifying an existing table
> MUST wrap each column in a `Schema::hasColumn()` check. Every new table MUST
> use `Schema::hasTable()`. This is non-negotiable — the live DB already has real data.

Create and run these migrations **in this order**:

### 1A. Add columns to `users` table
```
File: database/migrations/YYYY_MM_DD_add_subscription_fields_to_users_table.php
```
Add these columns if they do not already exist (check first):
- `trial_ends_at` — `timestamp, nullable`
- `session_token` — `string(100), nullable`
- `is_session_active` — `boolean, default false`
- `subscription_status` — `enum(['trial','active','expired','cancelled']), default 'trial'`

### 1B. Create `subscription_plans` table
```
Columns:
- id (primary)
- name — string (Basic / Standard / Premium)
- slug — string (basic / standard / premium)
- price_monthly — decimal(10,2)
- price_yearly — decimal(10,2)
- features — json (array of feature strings)
- is_active — boolean, default true
- razorpay_plan_id_monthly — string, nullable (Razorpay plan ID)
- razorpay_plan_id_yearly — string, nullable
- timestamps
```

### 1C. Create `subscriptions` table
```
Columns:
- id (primary)
- user_id — foreign key to users
- plan_id — foreign key to subscription_plans
- razorpay_order_id — string, nullable
- razorpay_payment_id — string, nullable
- razorpay_subscription_id — string, nullable
- billing_cycle — enum(['monthly','yearly'])
- status — enum(['pending','active','failed','cancelled'])
- starts_at — timestamp, nullable
- ends_at — timestamp, nullable
- trial_ends_at — timestamp, nullable
- amount — decimal(10,2)
- currency — string(3), default 'INR'
- timestamps
```

### 1D. Create `payment_transactions` table
```
Columns:
- id (primary)
- user_id — foreign key to users
- subscription_id — foreign key to subscriptions, nullable
- razorpay_order_id — string
- razorpay_payment_id — string, nullable
- razorpay_signature — string, nullable
- amount — decimal(10,2)
- currency — string(3), default 'INR'
- status — enum(['pending','captured','failed','refunded'])
- failure_reason — text, nullable
- metadata — json, nullable
- timestamps
```

### 1E. Create `user_sensitive_details` table (separate secure panel data)
```
Columns:
- id (primary)
- user_id — foreign key to users, unique
- joining_date — date, nullable
- bank_name — string, nullable
- bank_account_number — string, nullable (store encrypted)
- bank_ifsc — string, nullable
- bank_branch — string, nullable
- pan_number — string, nullable
- arn_number — string, nullable (AMFI Registration Number)
- notes — text, nullable
- created_by — integer, nullable (admin user id)
- updated_by — integer, nullable
- timestamps
```

---

## SECTION 2 — Models

Create or update these Eloquent models:

### 2A. `app/Models/SubscriptionPlan.php`
- fillable: all columns
- cast `features` as array
- hasMany Subscriptions

### 2B. `app/Models/Subscription.php`
- fillable: all columns
- belongsTo User
- belongsTo SubscriptionPlan
- hasMany PaymentTransactions
- Scope: `active()` — where status = active and ends_at > now
- Scope: `trial()` — where status = trial and trial_ends_at > now

### 2C. `app/Models/PaymentTransaction.php`
- fillable: all columns
- belongsTo User
- belongsTo Subscription

### 2D. `app/Models/UserSensitiveDetail.php`
- fillable: all columns
- Encrypt/decrypt `bank_account_number` using Laravel's `encrypted` cast
- belongsTo User

### 2E. Update `app/Models/User.php`
**READ THE FILE FIRST before editing.**
Add these relationships if not already present:
- `hasMany(Subscription::class)`
- `hasOne(Subscription::class)->latestOfMany()` named `activeSubscription`
- `hasOne(UserSensitiveDetail::class)`
Add helper methods:
- `isOnTrial()` — returns bool
- `hasActiveSubscription()` — returns bool
- `subscriptionExpired()` — returns bool

---

## SECTION 3 — Config

### 3A. Create `config/razorpay.php`
```php
<?php
return [
    'key_id'          => env('RAZORPAY_KEY_ID'),
    'key_secret'      => env('RAZORPAY_KEY_SECRET'),
    'webhook_secret'  => env('RAZORPAY_WEBHOOK_SECRET'),
    'currency'        => 'INR',
];
```

---

## SECTION 4 — Service Class

### 4A. Create `app/Services/RazorpayService.php`

This class wraps all Razorpay API calls. Use the official `razorpay/razorpay` SDK (already installed via composer).

Implement these public methods:

**`createOrder(int $amountPaise, string $currency, array $notes): array`**
- Creates a Razorpay order
- `$amountPaise` is amount × 100 (Razorpay uses paise)
- Returns order array with `id`, `amount`, `currency`

**`verifyPaymentSignature(string $orderId, string $paymentId, string $signature): bool`**
- Uses `Razorpay\Api\Utility::verifyPaymentSignature()`
- Returns true if signature is valid, false otherwise

**`verifyWebhookSignature(string $payload, string $signature): bool`**
- Verifies incoming webhook using `RAZORPAY_WEBHOOK_SECRET`
- Returns bool

**`fetchPayment(string $paymentId): array`**
- Fetches payment details from Razorpay API
- Returns payment array

**`createSubscription(string $planId, int $totalCount): array`**
- Creates a Razorpay subscription object for recurring payments

---

## SECTION 5 — Controllers

### 5A. Create `app/Http/Controllers/Web/SubscriptionController.php`

**Methods:**

`index(Request $request)`
- Load all active subscription plans from DB
- Load current user's active subscription if logged in
- Check if user is on trial
- Return view `subscription.index` with plans, user subscription status

`checkout(Request $request)`
- Validate: `plan_id`, `billing_cycle` (monthly/yearly)
- Get plan from DB
- Calculate amount based on billing cycle
- Create Razorpay order via `RazorpayService::createOrder()`
- Store pending subscription record in `subscriptions` table
- Store pending transaction in `payment_transactions` table
- Return JSON: `{ order_id, amount, currency, key_id, user_name, user_email, user_phone }`

`verifyPayment(Request $request)`
- Validate: `razorpay_order_id`, `razorpay_payment_id`, `razorpay_signature`
- Verify signature via `RazorpayService::verifyPaymentSignature()`
- If valid:
  - Update subscription status to `active`
  - Update transaction status to `captured`
  - Update user's `subscription_expiry_date` and `subscription_status`
  - Send payment confirmation email
  - Redirect to dashboard with success message
- If invalid:
  - Update transaction status to `failed`
  - Redirect back with error

`cancel(Request $request)`
- Auth required
- Mark subscription as cancelled
- Update user's subscription_status

### 5B. Create `app/Http/Controllers/Web/RazorpayWebhookController.php`

`handle(Request $request)`
- Read raw payload body
- Verify webhook signature using `RazorpayService::verifyWebhookSignature()`
- If signature fails: return 400
- Parse event type and dispatch to private handlers:
  - `payment.captured` → update transaction + subscription to active
  - `payment.failed` → update transaction to failed, notify user
  - `subscription.cancelled` → mark subscription cancelled
- Return 200 JSON `{ status: 'ok' }`

**Important:** Use `$request->getContent()` for raw body — do NOT use `$request->all()` for webhook signature verification.

---

## SECTION 6 — Routes

### 6A. Add to `routes/web.php`

```php
// Public subscription page
Route::get('/subscription', [SubscriptionController::class, 'index'])->name('subscription.index');

// Authenticated subscription actions
Route::middleware(['auth'])->group(function () {
    Route::post('/subscription/checkout', [SubscriptionController::class, 'checkout'])->name('subscription.checkout');
    Route::post('/subscription/verify-payment', [SubscriptionController::class, 'verifyPayment'])->name('subscription.verify');
    Route::post('/subscription/cancel', [SubscriptionController::class, 'cancel'])->name('subscription.cancel');
});

// Razorpay webhook — NO auth middleware, NO CSRF
Route::post('/razorpay/webhook', [RazorpayWebhookController::class, 'handle'])->name('razorpay.webhook');
```

### 6B. Exclude webhook from CSRF in `app/Http/Middleware/VerifyCsrfToken.php`

Add to `$except` array:
```php
'razorpay/webhook',
```

---

## SECTION 7 — Blade Views

### 7A. Create `resources/views/subscription/index.blade.php`

Extend the existing site layout (find the `@extends` pattern used in other views).

Page sections to include:

**Hero section:**
- Headline about the mutual fund advisor platform
- Subheadline with value proposition
- "Start Free Trial" CTA button

**Plans comparison section:**
- 3 cards (Basic, Standard, Premium) pulled from `$plans` variable
- Each card shows: name, price (monthly/yearly toggle), features list
- Highlight the recommended plan (Standard) with a badge
- Monthly/Yearly toggle switch (JS, no page reload)
- "Get Started" button on each plan

**Free Trial Banner:**
- If user is NOT logged in: show "Start your free trial — no credit card required"
- If user IS on trial: show "Your trial ends on {date}" with countdown
- If user has active plan: show "Your {plan name} plan is active until {date}"

**Payment Modal (Bootstrap or existing modal system):**
- Opens when user clicks "Get Started" on a plan
- Shows: plan name, billing cycle, amount
- "Pay with Razorpay" button
- On button click: calls `/subscription/checkout` via AJAX, gets order details, opens Razorpay checkout JS

### 7B. Razorpay Checkout JS Integration

Inside the subscription view, add this script logic:

```javascript
// Called after AJAX returns order details from /subscription/checkout
function openRazorpayCheckout(orderData) {
    var options = {
        key: orderData.key_id,
        amount: orderData.amount,
        currency: orderData.currency,
        order_id: orderData.order_id,
        name: "MyPlexus",
        description: orderData.plan_name,
        image: "/path/to/logo.png",
        prefill: {
            name: orderData.user_name,
            email: orderData.user_email,
            contact: orderData.user_phone
        },
        theme: { color: "#1a73e8" },
        handler: function(response) {
            // On payment success, post to verify endpoint
            submitVerification(
                response.razorpay_order_id,
                response.razorpay_payment_id,
                response.razorpay_signature
            );
        },
        modal: {
            ondismiss: function() {
                // User closed modal without paying — show message
            }
        }
    };
    var rzp = new Razorpay(options);
    rzp.on('payment.failed', function(response) {
        // Show error message
    });
    rzp.open();
}
```

Load Razorpay JS in the view head:
```html
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
```

---

## SECTION 8 — Email System

### 8A. Create `app/Mail/TrialExpiryReminder.php`
- Mailable class
- Constructor: `User $user, int $daysLeft`
- `build()` returns view `emails.trial-expiry-reminder`
- Subject: "Your MyPlexus trial expires in {$daysLeft} day(s)"

### 8B. Create `resources/views/emails/trial-expiry-reminder.blade.php`
- Professional HTML email
- Show: user name, days left, expiry date
- CTA button linking to `/subscription`
- Fallback plain text version

### 8C. Create `app/Mail/PaymentConfirmation.php`
- Constructor: `User $user, Subscription $subscription, PaymentTransaction $transaction`
- Subject: "Payment Confirmed — MyPlexus {Plan Name} Plan"
- View: `emails.payment-confirmation`

### 8D. Create `app/Console/Commands/SendTrialReminders.php`
```
Signature: app:send-trial-reminders
Description: Send reminder emails to users whose trial expires in 1, 2, or 3 days
```
Logic:
- Query users where `trial_ends_at` is exactly 3, 2, or 1 day from now (use `whereDate`)
- For each user, send `TrialExpiryReminder` mail with correct `$daysLeft`
- Log each reminder sent

### 8E. Register command in `app/Console/Kernel.php`
In the `schedule()` method, add:
```php
$schedule->command('app:send-trial-reminders')->dailyAt('09:00');
```

---

## SECTION 9 — Single Session Enforcement

### 9A. Create `app/Http/Middleware/EnforceSingleSession.php`

Logic:
- On each authenticated request, check if `session()->getId()` matches `users.session_token`
- If it does NOT match: logout the user, invalidate session, redirect to login with message "Your account was logged in from another device."
- If it DOES match: allow request through

### 9B. Update login flow in `LoginController` (READ FILE FIRST)

After successful login, add:
```php
// Store new session token, invalidating any previous session
auth()->user()->update([
    'session_token' => session()->getId(),
    'is_session_active' => true,
]);
```

### 9C. Register middleware in `app/Http/Kernel.php`

Add to the `web` middleware group:
```php
\App\Http\Middleware\EnforceSingleSession::class,
```

---

## SECTION 10 — Admin Panel Additions

### 10A. Add subscription stats to existing admin dashboard

Find the existing admin dashboard view (search for `admin` in `resources/views/`).
Add a new stats row with:
- Total active subscribers
- Total trial users
- Trial expiring in 7 days (action needed)
- Monthly revenue (sum of captured transactions this month)

### 10B. Create `resources/views/admin/subscriptions/index.blade.php`

Table with columns:
- User name, email
- Plan name
- Status (badge: trial/active/expired/cancelled)
- Start date, End date
- Amount paid
- Actions: View, Cancel

### 10C. Create Secure Follow-up Panel

Route prefix: `/admin/secure-panel` — protected by separate middleware `SecureAdminMiddleware`

Create `app/Http/Middleware/SecureAdminMiddleware.php`:
- Must be admin AND must have entered a secondary password (stored in `.env` as `SECURE_PANEL_PASSWORD`)
- Store secondary auth in session with 30-min timeout

Views needed:
- `admin/secure-panel/login.blade.php` — password entry form
- `admin/secure-panel/users/index.blade.php` — list of users with sensitive data
- `admin/secure-panel/users/show.blade.php` — full profile: joining date, bank details, PAN, ARN
- `admin/secure-panel/users/edit.blade.php` — edit sensitive fields

Controller: `app/Http/Controllers/Admin/SecurePanelController.php`

---

## SECTION 11 — Seeder for Subscription Plans

Create `database/seeders/SubscriptionPlanSeeder.php`

Insert the 3 plans with placeholder prices (developer will update actual prices):
```php
SubscriptionPlan::create([
    'name' => 'Basic',
    'slug' => 'basic',
    'price_monthly' => 499.00,
    'price_yearly'  => 4999.00,
    'features'      => ['Feature 1', 'Feature 2', 'Feature 3'],
    'is_active'     => true,
]);
// Repeat for Standard (999/9999) and Premium (1999/19999)
```

Run with: `php artisan db:seed --class=SubscriptionPlanSeeder`

---

## SECTION 12 — Trial Assignment on User Registration

### 12A. Find where new users are created (likely in `AuthController` `signup` or `investor-signup` method)

READ THE FILE FIRST. After user is created, add:
```php
$user->update([
    'trial_ends_at'       => now()->addDays(14), // Adjust days as needed
    'subscription_status' => 'trial',
]);
```

---

## Testing Checklist (Verify Each Before Marking Done)

- [ ] Migration runs without errors: `php artisan migrate`
- [ ] Subscription plans seeded and visible in DB
- [ ] `/subscription` page loads and shows 3 plans
- [ ] Monthly/yearly price toggle works with JS
- [ ] Clicking "Get Started" triggers AJAX, gets Razorpay order
- [ ] Razorpay checkout modal opens with correct amount
- [ ] Test payment with Razorpay test card: `4111 1111 1111 1111`, CVV `123`, expiry any future date
- [ ] After test payment: subscription activated in DB, user redirected to dashboard
- [ ] Payment confirmation email arrives
- [ ] Trial reminder command runs: `php artisan app:send-trial-reminders`
- [ ] Single session: log in on Browser A, then log in on Browser B — Browser A should be kicked out
- [ ] Webhook endpoint returns 200 for valid signature, 400 for invalid
- [ ] Admin panel shows subscriber list
- [ ] Secure panel requires secondary password

---

## Important: Files NOT to Touch

- `app/Http/Controllers/Web/AuthController.php` — only ADD trial assignment, do not rewrite
- `app/Models/User.php` — only ADD relationships and methods, do not remove existing
- `app/Http/Middleware/` existing files — only ADD new middleware, do not edit existing
- Any existing migration files — never edit, only create new ones
- `.env` on the live server — developer will update this manually

---

## File Creation Summary

| File | Status |
|------|--------|
| `database/migrations/*_add_subscription_fields_to_users_table.php` | CREATE |
| `database/migrations/*_create_subscription_plans_table.php` | CREATE |
| `database/migrations/*_create_subscriptions_table.php` | CREATE |
| `database/migrations/*_create_payment_transactions_table.php` | CREATE |
| `database/migrations/*_create_user_sensitive_details_table.php` | CREATE |
| `app/Models/SubscriptionPlan.php` | CREATE |
| `app/Models/Subscription.php` | CREATE |
| `app/Models/PaymentTransaction.php` | CREATE |
| `app/Models/UserSensitiveDetail.php` | CREATE |
| `app/Models/User.php` | MODIFY (add only) |
| `config/razorpay.php` | CREATE |
| `app/Services/RazorpayService.php` | CREATE |
| `app/Http/Controllers/Web/SubscriptionController.php` | CREATE |
| `app/Http/Controllers/Web/RazorpayWebhookController.php` | CREATE |
| `app/Http/Controllers/Admin/SecurePanelController.php` | CREATE |
| `app/Http/Middleware/EnforceSingleSession.php` | CREATE |
| `app/Http/Middleware/SecureAdminMiddleware.php` | CREATE |
| `app/Mail/TrialExpiryReminder.php` | CREATE |
| `app/Mail/PaymentConfirmation.php` | CREATE |
| `app/Console/Commands/SendTrialReminders.php` | CREATE |
| `resources/views/subscription/index.blade.php` | CREATE |
| `resources/views/emails/trial-expiry-reminder.blade.php` | CREATE |
| `resources/views/emails/payment-confirmation.blade.php` | CREATE |
| `resources/views/admin/subscriptions/index.blade.php` | CREATE |
| `resources/views/admin/secure-panel/*.blade.php` | CREATE |
| `routes/web.php` | MODIFY (add only) |
| `app/Http/Kernel.php` | MODIFY (add only) |
| `app/Http/Middleware/VerifyCsrfToken.php` | MODIFY (add only) |
| `app/Console/Kernel.php` | MODIFY (add only) |
| `database/seeders/SubscriptionPlanSeeder.php` | CREATE |