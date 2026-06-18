# Market Overview / Fund Heatmap Spec

Use this document as the implementation brief for building a **Market Overview** page with a **Fund Heatmap** that is driven from the database.

The goal is to show:
- Fund performance at a glance
- Different funds grouped by classification
- A visual heatmap that updates from database data
- Filterable views for users and admins

---

## 1. Goal

Build a market overview page that helps users quickly understand:
- Which funds are performing well or poorly
- How assets are grouped by classification
- Which fund types are hot or cold
- How the market is distributed by fund type, benchmark, manager, or style

The page should be data-driven from the database, not hardcoded.

---

## 2. Core Page Sections

### A. Header Summary
Show compact high-level market stats:
- Total funds
- Positive movers
- Negative movers
- Flat movers
- Average change percentage
- Largest gainers
- Largest losers
- Last updated time

### B. Filters
Provide filters so the same page can serve different users:
- Search by fund code, fund name, or classification
- Time range:
  - 1D
  - 1W
  - 1M
  - 3M
  - 1Y
  - YTD
- Classification filter:
  - Dynamic fund types from `mpx_fund_type`
  - Common examples: Equity, Debt, Hybrid, Index
- Region filter:
  - US
  - Global
  - Emerging Markets
  - Europe
  - Asia
  - Other
- Performance filter:
  - Top gainers
  - Top losers
  - Most active
  - High volume

### C. Heatmap
Main visual section.

Each tile should represent one fund.

Each tile should show:
- Fund code
- Fund name
- Current NAV
- Change amount
- Change percentage
- Color intensity based on performance

Heatmap colors:
- Green shades for positive performance
- Red shades for negative performance
- Neutral gray for flat or missing data

Tile size can be based on:
- AUM / corpus entry
- Volume
- Weight
- Custom ranking

### D. Fund Classification Panel
Show grouped cards or a side panel with classification breakdown:
- Fund type
- Benchmark / indices
- Fund manager
- Fund house
- Risk band
- Active / passive flag
- Internal tags

Each group should show:
- Count
- Average performance
- Total corpus / AUM
- Top fund in that group

### E. Detail Drawer or Sidebar
When a user clicks a tile:
- Show fund summary
- Show classification tags
- Show key metrics
- Show historical chart if available
- Show related funds in same classification
- Show links to the fund detail page

---

## 3. Database-Driven Design

Do not hardcode the heatmap items.

The page should read from the database and derive all labels, classifications, and groups from stored records.

### MyPlex database entities

Use the existing `mpx_` tables and map the UI to these records.

#### `mpx_fund_master`
Primary fund record.

Fields:
- `fund_id`
- `fund_name`
- `fund_code`
- `fund_manager`
- `fund_type_id`
- `fund_term_id`
- `risk_free_return`
- `fund_opened`
- `cost`
- `indices_name`
- `fund_house`
- `classification`
- `status`

#### `mpx_fund_detail`
Daily NAV and movement history for each fund.

Fields:
- `fund_code`
- `entry_date`
- `closing_nav`
- `holiday`
- `percentage_change`
- `publish`

#### `mpx_fund_type`
Fund category lookup.

Fields:
- `ft_id`
- `name`
- `active_passive`
- `monthly_performance`

#### `mpx_indices_master`
Benchmark lookup used by funds.

Fields:
- `name`
- `corelation`
- `status`

#### `mpx_indices_detail`
Benchmark history.

Fields:
- `name`
- `entry_date`
- `closing_value`
- `holiday`
- `percentage_change`
- `publish`

#### `fund_watch_disclaimer`
Footer disclaimer text for the page.

Fields:
- `disclaimer`
- `status`

---

## 4. Heatmap Logic

### Color rules
Use a normalized score for color intensity.

Example:
- `changePercent >= 5` -> strong green
- `changePercent >= 1` -> moderate green
- `changePercent > 0` -> light green
- `changePercent == 0` -> gray
- `changePercent < 0` -> light red
- `changePercent <= -1` -> moderate red
- `changePercent <= -5` -> strong red

### Tile sizing rules
Choose one:
- Market cap-based sizing
- AUM-based sizing
- Volume-based sizing
- Equal-size grid

If the database does not have enough size data, default to equal-size tiles.

### Sorting rules
Default sort order:
- Biggest movers first
- Then by corpus / AUM / weight

Optional modes:
- Performance descending
- Performance ascending
- Name A-Z
- Weight descending
- Classification group order

---

## 5. Required UI Behavior

### Search
Search should filter by:
- Fund code
- Fund name
- Classification
- Fund type
- Benchmark / indices
- Fund manager

### Responsive layout
Desktop:
- Top summary row
- Left or top filters
- Large heatmap grid
- Right side details panel

Mobile:
- Filters in a collapsible sheet
- Heatmap in a single-column or two-column adaptive grid
- Detail panel opens as a bottom sheet or modal

### Loading states
Show:
- Skeleton cards for summary
- Skeleton heatmap tiles
- Spinner or shimmer while data loads

### Empty states
If no data exists:
- Show a friendly empty message
- Explain that fund records must be added in the database
- Provide an admin action if appropriate

### Error states
If the database request fails:
- Show a retry button
- Show a short error message
- Do not crash the entire page

---

## 6. Data Queries Needed

The page should be able to fetch:

### Overview query
Return:
- total funds
- positive count
- negative count
- flat count
- average change percent
- top gainers
- top losers

### Heatmap query
Return:
- fund list
- grouping fields
- current NAV
- change metrics
- size metric
- metadata for rendering

### Classification query
Return:
- all fund types
- counts per fund type
- avg change per fund type
- total corpus / AUM per fund type

### Optional detail query
Return:
- historical NAV values
- related funds
- classification metadata
- chart-ready time series

---

## 7. Suggested API Contract

### `GET /api/market-overview`
Return summary stats.

Example response:
```json
{
  "summary": {
    "totalFunds": 128,
    "positiveCount": 74,
    "negativeCount": 41,
    "flatCount": 13,
    "averageChangePercent": 0.82,
    "lastUpdatedAt": "2026-06-11T10:30:00Z"
  },
  "topGainers": [],
  "topLosers": []
}
```

### `GET /api/market-heatmap`
Return heatmap-ready items.

Example response:
```json
{
  "items": [
    {
      "id": "1",
      "fundCode": "MPXLC001",
      "name": "MyPlexus Large Cap Fund",
      "classification": "Large Cap",
      "fundType": "Equity",
      "benchmark": "NIFTY 100",
      "fundManager": "Aarav Mehta",
      "nav": 152.68,
      "change": 4.21,
      "changePercent": 0.98,
      "corpus": 1540.25,
      "sizeMetric": 1540.25,
      "colorScore": 0.42,
      "lastUpdatedAt": "2022-01-31"
    }
  ]
}
```

### `GET /api/funds/:id`
Return detailed fund information for the side drawer or modal.

---

## 8. Database Rendering Rules

The page should calculate groups like this:

- Group by `classification`
- Subgroup by `fund_type_id`
- Subgroup by `indices_name`
- Optional secondary grouping by `fund_house` or `fund_manager`

The UI should not assume all items are equities.
It must support:
- Funds
- Fund schemes
- Benchmark-linked funds
- Custom grouped fund views

---

## 9. Admin Requirements

If an admin manages the data, provide:
- Create/edit classification
- Assign funds to a classification
- Set tile size metric
- Hide/show funds
- Override color tags
- Mark featured funds
- Set custom sort order

---

## 10. Implementation Notes for AI

When building this page, the AI should:

1. Inspect the existing database models first.
2. Reuse the real `mpx_` fund and index tables if they already exist.
3. Avoid hardcoded lists unless they are fallback defaults.
4. Build the page so data comes from API responses.
5. Keep the heatmap responsive and interactive.
6. Use the database as the source of truth for:
   - names
   - classifications
   - NAV values
   - change data
   - sizing
7. Add loading, empty, and error states.
8. Make the click interaction open a detail panel.
9. Support both desktop and mobile layouts.
10. Keep the code modular:
   - summary widgets
   - heatmap grid
   - filters
   - fund detail drawer
   - classification sidebar

---

## 11. Suggested Component Breakdown

- `MarketOverviewPage`
- `MarketStatsSummary`
- `MarketFilters`
- `FundHeatmapGrid`
- `HeatmapTile`
- `ClassificationSidebar`
- `FundDetailDrawer`
- `MarketOverviewSkeleton`

---

## 12. Suggested Prompt for Another AI

You can paste this directly into another AI:

> Build a database-driven Market Overview page with a Fund Heatmap. The page must show funds grouped by classification using the existing `mpx_` tables. Use the database as the source of truth for fund codes, fund names, fund types, benchmark indices, fund manager, current NAV, change, change percent, corpus/AUM, and classification. Include summary stats, filters, responsive heatmap tiles, fund-type grouping, a detail drawer, loading states, empty states, and error states. Do not hardcode the fund items. The page should support desktop and mobile layouts and be modular enough to reuse existing database models if they already exist.

---

## 13. Minimum Data Needed

To render the page properly, each item should have at least:
- `fundCode`
- `name`
- `classification`
- `fundType`
- `nav`
- `changePercent`
- `corpus` or `aum` or `weight`

If any of those are missing, the AI should:
- show fallback values
- avoid breaking the page
- visually mark incomplete items if needed

---

## 14. Recommended Build Order

1. Inspect database schema
2. Create API endpoint for market overview
3. Create API endpoint for heatmap data
4. Build summary cards
5. Build filter bar
6. Build heatmap grid
7. Build classification sidebar
8. Build fund detail drawer
9. Add loading and empty states
10. Connect real database values

---

## 15. Notes

- This page should be driven by live DB records
- Do not assume only stocks exist
- Funds and classifications should be editable
- Keep labels simple and readable
- If a later project has a different database, map these concepts to its own collections/tables
