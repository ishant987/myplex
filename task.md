# MyPlexus — Subscription Bugs & Issues

---

## 1. Dashboard → Ratio Reports

### Quick Ratio (Weekly / Monthly)
- **Date picker shows wrong month** — auto-selects May 2026 instead of the user-selected month (e.g. April).
- **Sub-section dropdown** — shows generic "Select" instead of a relevant default option.

### Return Less Index
- **Slow initial load** — first load takes 30 seconds to 2 minutes.

### Monthly Snapshot
- **Missing data** — multiple fund categories display `N/A` in the **% Change (Returns)** and **Median** columns instead of actual values.

### Monthly Snapshot → Fund Category
- **Missing data** — **% Change (Returns)** and **Median** columns show `N/A` instead of actual data.

### Snapshot Navigation (Weekly / Monthly)
- **Redundant UI** — separate Weekly and Monthly Snapshot cards are confusing because the Monthly option already exists inside the Weekly Snapshot section.

### Fund Factsheet
- **Very slow load** — data takes approximately 2 minutes or more to load.

### Performance Ratios
- **Duplicate label** — "Ratio" appears as both the main tab/category name and again inside the sub-section dropdown.
- **"As On" date selection bug** — data does not load; shows "No data available".

### Quartile & Decile
- **By Category / By Fund toggle bug** — options do not behave properly.
- **As On / Range tab bug** — date/filter logic is inconsistent or malfunctioning.
- **Active tab UI bug** — active tab does not show the expected arrow-style indicator; shows an incorrect I-shaped/text tab instead.

### Comparative → Quartile & Decile
- **By Category / By Fund toggle bug** — same as above; options are not functioning properly.
- **Active tab UI bug** — same arrow-style tab indicator issue as above.

---

## 2. Dashboard → Ratio Analysis

### Risk Ratio
- **Filter/selection bug across all 4 tabs** — By Category, By Fund, Range, and As On tabs all have non-functioning selection/filter logic.

---

## 3. Dashboard → Composition Report

### Composition Allocation Snapshot
- **By Category / By Fund toggle bug** — toggle/filter behavior is not functioning properly.
- **Select Month filter bug** — month selection is not working properly.

### Scheme Portfolio
- **No data loads** — selected scheme/month/year combination returns "No data available".

### Occurrence Report
- **No data shows** — search results display "No information available" despite valid selected inputs.
- **Bugs across all tabs/filters** — Scrip, Industry, By Category, By Fund, and Month/Year selection all have issues.

### Top Scrips / Top Industries
- **Data not loading** — bugs across all tabs and filters.
- **Amount (in Cr.) column shows 0** — actual values are not being displayed.

### New Scrips / New Industries
- **Bugs across all tabs, filters, and sections** — selection logic and data loading are not functioning properly.

### Boomers
- **Percentage Change data incorrect** — not showing correctly.
- **Limit input/tab not working** — limit filter is malfunctioning.

### Busters
- **Bugs across all tabs, filters, and sections** — By Category, By Fund, Limit, Fund Classification, and Month/Year selectors are all affected.

---

## 4. Dashboard → Indices Report

### Indices Composition
- **No data loads** — this section shows no data at all.
- **Month filter bug** — month selection/filter is not functioning properly.

### Indices Boomers
- **Limit tab/input not working** — limit filter is malfunctioning.

### Indices Busters
- **Limit tab/input not working** — limit filter is malfunctioning.

### Index vs NAV
- **Compare tab bugs** — comparison functionality has issues.
- **UI/UX layout problem** — tab structure and comparison interface are confusing and not properly designed.

---

## 5. Sidebar Navigation

### Model Portfolio
- **Tab sometimes unresponsive** — Model Portfolio tab occasionally does not open or respond to clicks.

---

## 6. Dashboard → Filters

### By Ratio
- **Bugs across all tabs and filters** — Range, As On, By Category, By Fund, By Ratio, and By Composition all have issues.

### By Jensen's
- **Return tab/filter bug** — filter is not working correctly.
- **Submit/Search button missing** — the submit/search action button is absent.

---

## 7. Dashboard → Predictive

### By Jensen's
- **Expected Future Index unclear/broken** — function/tab is not working properly or its purpose is unclear.

### By Sharpe Ratio
- **Expected Future Index unclear/broken** — same issue as above.

### By Treynor
- **Expected Future Index unclear/broken** — same issue as above.

---

## 8. Admin Panel → Settings

### Publish Monthly Quartile & Decile Ranks
- **Both tabs (Returns / Jensen's Alpha) not working** — neither tab is responding or functioning properly.