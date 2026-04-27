# User Login And Subscription Flow

## User Login Flow

### 1. Login page
- Route: `GET /user-login`
- View: `resources/views/web/auth/login.blade.php`
- Optional query: `?cal=subcription`
- This page shows:
  - email/password login
  - Google login
  - Facebook login
  - registration link

### 2. Normal login
- Route: `POST /post-login`
- Controller: `app/Http/Controllers/User/LoginController.php`
- Flow:
  - validates `email` and `password`
  - uses `Auth::attempt()`
  - on success:
    - regenerates session
    - stores `session_token`
    - sets `is_session_active = true`
  - redirect:
    - if hidden `pageurl = subcription`, goes to subscription page
    - otherwise goes to `user.index_dashboard`
  - on failure:
    - redirects back to `/user-login` with `Wrong credentials`

### 3. Social login
- Routes:
  - `GET /login/google`
  - `GET /login/google/callback`
  - `GET /login/facebook`
  - `GET /login/facebook/callback`
- Flow:
  - if user email already exists:
    - logs user in
    - updates social account info if missing
  - if user does not exist:
    - creates user
    - creates one row in `subscriptions`
    - logs user in

### 4. Logout
- Route: `GET /logout`
- Clears:
  - `session_token`
  - `is_session_active`
  - auth session

## Registration Flow

### 1. Registration
- Routes:
  - `GET /registration`
  - `POST /registration-store`
- Controller: `app/Http/Controllers/User/RegistrationController.php`
- Flow:
  - validates company/user details
  - creates user
  - stores hashed password
  - creates one row in `subscriptions`
  - sends registration email

### 2. Email verify
- Route: `GET /verify-email/{id}`
- Marks user `is_approved = 'y'`

## Subscription / Access Flow

### 1. Protected area
- Protected routes are inside:
  - `auth`
  - `nocache`
  - `subscription`
- Main protected pages:
  - dashboard
  - ratio reports
  - composition report
  - indices reports
  - filters / predictive / snapshots / factsheet etc.

### 2. Access check
- Middleware: `app/Http/Middleware/SubscriptionMiddleware.php`
- Rule:
  - allow only when `user->hasValidAccess()` is `true`
  - otherwise redirect to `user.subscription_lock`

### 3. How `hasValidAccess()` works
- File: `app/Models/User.php`
- Access is allowed if:
  - user has active paid subscription, or
  - user is on valid trial

### 4. Paid subscription logic
- New flow is enabled by `config/features.php`:
  - `FEATURE_SUBSCRIPTION_ENABLED=true`
- New subscription page:
  - Route: `GET /subscription`
  - Controller: `app/Http/Controllers/Web/SubscriptionController.php`
  - View: `resources/views/subscription/index.blade.php`
- Payment flow:
  - user selects a plan
  - `POST /subscription/checkout`
  - order is created in Razorpay
  - local `subscriptions` row is created with `pending`
  - local `payment_transactions` row is created
  - after Razorpay success:
    - `POST /subscription/verify-payment`
    - subscription becomes `active`
    - user `subscription_status = active`
    - user `subscription_expiry_date` is updated
    - trial is cleared
    - user is redirected to dashboard

### 5. Lock / renew page
- Route: `GET /user-subscription-lock`
- Controller: `RatioController@subscription_lock`
- CTA link:
  - goes to new `/subscription` page when feature flag is enabled
  - otherwise goes to old `user/subscription` page

## Important Current Behavior

- Trial is currently created with `addDays(0)` in registration and new Google/Facebook user creation.
- Because access check uses `isFuture()`, this means trial access effectively expires immediately / same day.
- So after login, many newly created users can reach login successfully but still get blocked by subscription middleware.
- Facebook new user flow is weaker than Google/registration:
  - it creates user + legacy subscription row
  - but does not clearly set `subscription_status = trial`
  - so access may fail immediately
- `is_approved` is set by verify-email, but normal login does not check it before logging user in.

## In Short

- Login works first.
- Real page access depends on subscription middleware after login.
- Current active access mostly depends on paid subscription.
- Free trial setup looks effectively broken right now because expiry is being saved as today.
