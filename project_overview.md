# MyPlexus: Project Architecture & Execution Overview

This document provides an in-depth summary of the MyPlexus platform, specifically focusing on its **User Registration & Login mechanisms** and its **Financial Data Architecture**.

MyPlexus is a comprehensive, Laravel-based wealth management, analytics, and mutual fund platform. It is engineered to capture high-frequency financial data, perform complex statistical analyses (like Alpha, Beta, Sharpe, CAGR), and deliver tailored dashboards to different classes of users (from standard users to subscribed investors).

---

## 1. User Authentication & Profile Ecosystem

The user ecosystem relies heavily on Laravel’s robust built-in authentication, extended to integrate subscription features, third-party Social Logins, and API-based tokens via Laravel Passport. The core logic is distributed across `app/Models/User.php`, `App\Http\Controllers\Web\AuthController`, and `App\Http\Controllers\User\LoginController`. 

### A. Authentication & Sign-Up Flows
The application features isolated entry points for users and administrators, coupled with specialized flows for platform features like calculators.

*   **Standard & Investor Registration:** 
    *   **Standard Sign-Up (`signup`)**: General purpose sign-up capturing basic user attributes.
    *   **Investor Sign-Up (`investor-signup`)**: An extended signup tailored for financial investors, linked tightly to their portfolios and subscriptions.
*   **Social Authentication (OAuth):**
    *   The `LoginController` integrates with Laravel Socialite to handle seamless onboarding via **Google** and **Facebook**.
    *   Social login functionality is also piped into specialized platform tools, such as the `calculator-login/{provider}` flow.
*   **Password Management:** 
    *   Secure "Forgot Password" workflows encompass generating verification codes, validating the code, and resetting passwords, complete with customized email notifications (`to-user-forgot-password.blade.php`).

### B. The `User` Model & Data Structure
The `app/Models/User.php` dictates a broad set of user attributes required for an advanced financial platform, capturing both regulatory and personal details:
*   **Identifiers:** Unique Code (`u_code`), Email, Mobile.
*   **Financial & Regulatory Flags:** PAN (Permanent Account Number), GST, ARN (AMFI Registration Number), and `company` records.
*   **Authentication specifics:** Account Type (`acc_type`), Sign-up Medium (`s_acc_medium`), Identity Tokens, etc.
*   **Subscription Tiering:** `subscription_expiry_date` works with platform middleware to restrict access to premium reporting sections.

### C. Role-based Middleware & Authorization
*   **Middleware (`auth`, `admin`, `subscription`)**: Strict access control is enforced at the routing level. For example:
    *   Standard `auth` protects the user dashboards (`myaccount`, `edit.profile`, Q&A "Ask Expert" modules).
    *   The `subscription` middleware walls off advanced analytics like `quick-ratio`, `user-monthly-snapshot`, and `user-weekly-snapshot`. Unauthorized users hit a `subscription_lock` route.

---

## 2. Core Data Architecture & Processing Flow

Data is the lifeblood of MyPlexus. The project’s backend reveals an intensive data ingestion pipeline designed to store, manage, and calculate financial metrics for mutual funds and broad market indices.

### A. Master Data Models
The data structure categorizes the universe of investments into distinct, rigid definitions to standardize calculation.
*   **`FundMaster` & `IndicesMaster`**: Core tables holding the definition of all mutual funds and market indices available on the platform.
*   **Auxillary Definitions**: Data models exist for `CurrencyMaster`, `FundType`, `FundTerm`, `Scrips`, and `FundClassification`.

### B. High-Frequency Data Imports
The platform consumes daily and monthly operational metrics to chart fund performance. The system acts as a data pipeline, ingesting source files via specific upload controllers.
*   **Daily Batches:** `DailyNavsValueController`, `DailyIndicesValueController`, `DailyCurrenciesValueController` manage the daily uploads of Net Asset Values, Index points, and Exchange Rates.
*   **Monthly Batches:** Large-scale compositional data like `MonthlyAUMsValueController` (Assets Under Management) and Fund house compositions are handled via monthly batches.
*   **Publishing Queues:** Notably, data doesn't just insert straight into active queries. They pass through "Publish" controllers (e.g., `NavsPublishController`, `AUMsPublishController`), suggesting a staging-to-production approval flow for data integrity.

### C. Algorithmic Processing & Reporting (Calculators)
A huge aspect of the application is purely computational. Custom calculator controllers digest the Daily/Monthly time-series data to output standard financial ratios. Dedicated controllers include:
*   **Risk & Return Analytics:** `BetaController`, `VolatilityController`, `SharpeController`, `TreynorController`, `SortinoController`, and `JensonsalphaController`.
*   **Performance Metrics:** `CagrController`, `SipreturnController`, `RollingreturnController`.
*   **Statistical Analysis:** `SkewnessController`, `KurtosisController`, `TrackingerrorController`, `rsquereController`.

### D. User-Facing Data Delivery 
Once data is securely ingested and analyzed, it's aggregated into comprehensive views for the end user:
*   **Fund Watch (`NewfundwatchController`)**: A deep-dive analytical interface offering metrics such as Portfolio Breakup, Risk/Alpha generation, Lumpsum/SIP performance, and ranking percentiles (Quartile/Decile rankings).
*   **Snapshots**: Real-time analytical snapshots (`composition-snapshot`, `monthly-snapshot`) which can be dynamically exported to PDFs via `PDFDataController`.

## Summary
The MyPlexus codebase heavily reflects a data-driven fintech ecosystem. It intricately balances a multi-tiered User Authentication system—distinguishing between generic browsers, registered participants, and subscribed investors—with a high-intensity Data Pipeline capable of ingesting, validating, calculating, and securely serving daily market intelligence.
