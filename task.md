# MyPlexus SEO Page Manager — Full Project Prompt

## What you are building

You are building a **full-stack SEO Blog & Landing Page Management System** for **myplexus.com** — a mutual fund research and portfolio management platform based in India.

The system has two parts:
1. **Admin Dashboard** — a web interface where the myplexus team can create, edit, preview, and manage SEO-optimised pages
2. **Public Pages** — pages that get published to the live site under URLs like `https://www.myplexus.com/financial-needs`, `https://www.myplexus.com/blog/why-sip-works`, etc.

---

## Tech Stack (suggest or use these)

- **Frontend**: React.js (with Tailwind CSS for styling)
- **Backend**: Node.js + Express.js (REST API)
- **Database**: PostgreSQL (or MongoDB if preferred)
- **File storage**: AWS S3 or Cloudinary (for image uploads)
- **Rich text editor**: TipTap or Quill.js (for SEO-friendly blog content)
- **CSV parsing**: PapaParse (frontend) or csv-parser (backend)
- **SEO rendering**: Next.js (preferred for server-side rendering so Google can crawl pages properly)

> If using Next.js, the admin dashboard can live at `/admin/*` routes and public pages at `/[slug]` dynamic routes.

---

## Core Features to Build

### Feature 1 — Create New Page (Single)

The admin should see a **"Create New Page"** button that opens a full-page form with these fields:

#### Basic Info
| Field | Type | Notes |
|---|---|---|
| Page Title | Text input | e.g. "Why Every Indian Needs a Financial Plan" |
| URL Slug | Auto-generated + editable | e.g. `/financial-needs` or `/blog/why-sip-works` |
| Page Type | Dropdown | Options: Blog Post, Landing Page, Guide, FAQ Page |
| Category | Dropdown | Options: Mutual Funds, SIP, NFO, Tax Planning, Market Insights, Financial Planning |
| Author | Text input | e.g. "Prasun Mukherjee" |
| Publish Date | Date picker | Defaults to today |
| Status | Toggle | Draft / Published |

#### Content Section
| Field | Type | Notes |
|---|---|---|
| Featured Image | File upload (JPG/PNG/WebP) | Max 2MB. Shows preview after upload. Auto-generates alt text field. |
| Image Alt Text | Text input | Important for SEO. Pre-fill with page title. |
| Short Description / Excerpt | Textarea (160 chars max) | This becomes the meta description. Show character counter. |
| Full Page Content | Rich text editor (WYSIWYG) | Must support: H1, H2, H3 headings, Bold, Italic, Bullet lists, Numbered lists, Blockquotes, Internal links, External links, Inline images |
| Tags | Multi-select tag input | e.g. SIP, mutual funds, ELSS, NFO |

#### SEO Settings Panel (collapsible section)
| Field | Type | Notes |
|---|---|---|
| SEO Title | Text input (60 chars max) | If empty, use Page Title. Show character counter with green/red indicator. |
| Meta Description | Textarea (160 chars max) | If empty, use Short Description. Show character counter. |
| Focus Keyword | Text input | The main keyword this page targets. e.g. "mutual fund SIP calculator India" |
| Canonical URL | Text input | Pre-fill with `https://www.myplexus.com/[slug]` |
| Open Graph Title | Text input | For social sharing (Facebook, WhatsApp, LinkedIn) |
| Open Graph Image | File upload or select from uploaded images | 1200x630px recommended |
| Schema Type | Dropdown | Article, FAQPage, HowTo, BlogPosting |
| Index / No-Index | Toggle | Default: Index (let Google crawl it) |

#### Preview Panel
- Live preview of how the page will look in Google Search results (shows the blue title, green URL, and grey description snippet as it would appear on Google)
- Mobile preview toggle

---

### Feature 2 — Bulk Upload via CSV (10 pages at once)

Add a **"Bulk Upload"** button next to "Create New Page".

#### How it works:
1. User downloads a **CSV template** (provide a download button)
2. User fills in the CSV with up to 10 rows (one row = one page)
3. User uploads the filled CSV
4. System parses it and shows a **preview table** — user can review all 10 entries before confirming
5. User clicks **"Publish All"** or **"Save All as Draft"**
6. System creates all pages at once

#### CSV Template columns:
```
page_title, url_slug, page_type, category, author, publish_date, short_description, full_content, tags, seo_title, meta_description, focus_keyword, schema_type, status, featured_image_url
```

#### Validation rules on CSV upload:
- `url_slug` must be unique — show error if duplicate exists
- `url_slug` must only contain lowercase letters, numbers, and hyphens (no spaces, no capitals)
- `seo_title` must be under 60 characters — warn if over
- `meta_description` must be under 160 characters — warn if over
- `status` must be "draft" or "published"
- If `featured_image_url` is a URL, fetch and store it; if blank, flag it in the review table

---

### Feature 3 — Pages List Dashboard

After creating pages, the admin lands on a **"All Pages"** list view.

#### List view columns:
| Column | Details |
|---|---|
| Title | Clickable. Goes to edit page. |
| URL Slug | Shows full URL as a clickable link that opens in new tab |
| Type | Badge (Blog / Landing / Guide / FAQ) |
| Category | Text |
| Status | Green "Published" or Grey "Draft" badge |
| SEO Score | 0–100 score (see SEO Score logic below) |
| Last Updated | Date |
| Actions | Edit / Preview / Duplicate / Delete buttons |

#### Filters & search:
- Search by title or keyword
- Filter by: Status (All / Published / Draft), Type, Category
- Sort by: Date created, Last updated, SEO Score (lowest first — helps fix weak pages)

#### SEO Score logic (calculate automatically):
Give each page a score out of 100 based on:
- SEO title present and under 60 chars → +15 points
- Meta description present and under 160 chars → +15 points
- Focus keyword present → +10 points
- Focus keyword appears in SEO title → +10 points
- Focus keyword appears in first paragraph of content → +10 points
- Featured image present → +10 points
- Image alt text present → +10 points
- Content is over 500 words → +10 points
- Internal links in content (at least 1) → +5 points
- Tags added → +5 points

Show score as a coloured bar: Red (0–40), Amber (41–70), Green (71–100)

---

### Feature 4 — Edit Page

Clicking **Edit** on any page opens the exact same form as "Create New Page" but pre-filled with existing data.

Additional features on edit:
- **Version history** — show last 5 saved versions with timestamps. Allow rollback.
- **"View Live Page"** button — opens the published URL in a new tab
- **Republish button** — if status is Draft, show a prominent "Publish Now" button
- **Delete with confirmation** — "Are you sure? This will remove the page from Google too." with a checkbox the user must tick

---

### Feature 5 — Public Page Rendering

When a page is published, it must be accessible at its slug URL and properly SEO-optimised.

#### Each public page must have in its HTML `<head>`:
```html
<title>{seo_title}</title>
<meta name="description" content="{meta_description}" />
<meta name="robots" content="index, follow" />
<link rel="canonical" href="https://www.myplexus.com/{slug}" />

<!-- Open Graph (for WhatsApp, Facebook, LinkedIn sharing) -->
<meta property="og:title" content="{og_title}" />
<meta property="og:description" content="{meta_description}" />
<meta property="og:image" content="{og_image_url}" />
<meta property="og:url" content="https://www.myplexus.com/{slug}" />
<meta property="og:type" content="article" />

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{seo_title}" />
<meta name="twitter:description" content="{meta_description}" />
<meta name="twitter:image" content="{og_image_url}" />

<!-- Schema.org structured data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "{schema_type}",
  "headline": "{page_title}",
  "description": "{meta_description}",
  "author": { "@type": "Person", "name": "{author}" },
  "datePublished": "{publish_date}",
  "image": "{featured_image_url}",
  "publisher": {
    "@type": "Organization",
    "name": "MyPlexus",
    "url": "https://www.myplexus.com"
  }
}
</script>
```

#### Public page layout:
- Hero section: Featured image (full width) + Page title (H1) + Author + Date
- Content body: Full rich text content rendered as clean HTML
- Related pages: Show 3 pages from the same category (pulls from database)
- Breadcrumb: Home > Category > Page Title (also add breadcrumb schema)

---

### Feature 6 — Auto-generate Sitemap

Every time a page is published or deleted, regenerate `https://www.myplexus.com/sitemap.xml` automatically.

Format:
```xml
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc>https://www.myplexus.com/financial-needs</loc>
    <lastmod>2026-07-03</lastmod>
    <changefreq>weekly</changefreq>
    <priority>0.8</priority>
  </url>
  <!-- one <url> block per published page -->
</urlset>
```

---

## Folder / File Structure to Create

```
myplexus-page-manager/
├── frontend/                        # React / Next.js app
│   ├── pages/
│   │   ├── admin/
│   │   │   ├── index.jsx            # Pages list dashboard
│   │   │   ├── create.jsx           # Create new page form
│   │   │   ├── edit/[id].jsx        # Edit existing page
│   │   │   └── bulk-upload.jsx      # CSV bulk upload page
│   │   ├── [slug].jsx               # Public page renderer
│   │   └── sitemap.xml.jsx          # Auto-generated sitemap
│   ├── components/
│   │   ├── RichTextEditor.jsx       # TipTap/Quill wrapper
│   │   ├── SeoPanel.jsx             # SEO fields collapsible panel
│   │   ├── GooglePreview.jsx        # Live Google snippet preview
│   │   ├── SeoScoreBar.jsx          # 0-100 score indicator
│   │   ├── ImageUploader.jsx        # Drag & drop image upload
│   │   ├── CsvUploader.jsx          # CSV bulk upload component
│   │   └── PageTable.jsx            # Pages list table with filters
│   └── styles/
│       └── globals.css
│
├── backend/                         # Node.js + Express API
│   ├── routes/
│   │   ├── pages.js                 # CRUD routes for pages
│   │   ├── upload.js                # Image upload to S3/Cloudinary
│   │   └── sitemap.js               # Sitemap generation
│   ├── models/
│   │   └── Page.js                  # Database model/schema
│   ├── middleware/
│   │   └── auth.js                  # Basic admin authentication
│   └── server.js                    # Express entry point
│
├── database/
│   └── schema.sql                   # PostgreSQL table definitions
│
├── csv-template/
│   └── bulk-upload-template.csv     # Downloadable CSV template
│
└── README.md                        # Setup instructions
```

---

## Database Schema

```sql
CREATE TABLE pages (
  id              SERIAL PRIMARY KEY,
  page_title      VARCHAR(255) NOT NULL,
  url_slug        VARCHAR(255) UNIQUE NOT NULL,
  page_type       VARCHAR(50),           -- blog, landing, guide, faq
  category        VARCHAR(100),
  author          VARCHAR(100),
  publish_date    DATE,
  status          VARCHAR(20) DEFAULT 'draft',  -- draft, published
  short_description TEXT,
  full_content    TEXT,                  -- HTML from rich text editor
  tags            TEXT[],                -- array of tag strings
  featured_image_url TEXT,
  image_alt_text  VARCHAR(255),
  seo_title       VARCHAR(60),
  meta_description VARCHAR(160),
  focus_keyword   VARCHAR(255),
  canonical_url   TEXT,
  og_title        VARCHAR(255),
  og_image_url    TEXT,
  schema_type     VARCHAR(50) DEFAULT 'BlogPosting',
  is_indexed      BOOLEAN DEFAULT TRUE,
  seo_score       INTEGER DEFAULT 0,     -- auto-calculated 0-100
  created_at      TIMESTAMP DEFAULT NOW(),
  updated_at      TIMESTAMP DEFAULT NOW()
);

CREATE TABLE page_versions (
  id          SERIAL PRIMARY KEY,
  page_id     INTEGER REFERENCES pages(id) ON DELETE CASCADE,
  content_snapshot JSONB,               -- full page data at that point
  saved_at    TIMESTAMP DEFAULT NOW()
);
```

---

## API Endpoints to Build

```
GET    /api/pages              — list all pages (with filters: ?status=published&category=sip)
GET    /api/pages/:slug        — get single page by slug (for public rendering)
GET    /api/pages/id/:id       — get single page by ID (for admin edit)
POST   /api/pages              — create new page
PUT    /api/pages/:id          — update existing page
DELETE /api/pages/:id          — delete page
POST   /api/pages/bulk         — create multiple pages from CSV data (array of page objects)
POST   /api/upload/image       — upload image, return CDN URL
GET    /api/sitemap            — return XML sitemap of all published pages
GET    /api/pages/:id/versions — get version history for a page
POST   /api/pages/:id/restore/:versionId — restore a previous version
```

---

## Important SEO Rules to Enforce in the UI

1. **Slug format**: Always lowercase, hyphens not underscores, no special characters. Auto-convert page title to slug. Example: "Why SIP Works in India" → `why-sip-works-in-india`

2. **No duplicate slugs**: Check on blur (when user leaves the slug field) whether the slug already exists. Show red error if it does.

3. **Canonical always set**: Default canonical to `https://www.myplexus.com/{slug}`. Never let it be blank.

4. **Image alt text mandatory**: If user uploads image but leaves alt text blank, show warning and block publish.

5. **H1 rule**: The rich text editor should warn if there is more than one H1 in the content. Each page should have exactly one H1 (the page title), then H2s and H3s for subheadings.

6. **Word count indicator**: Show live word count in the content editor. Warn if under 300 words, encourage 500+ for SEO.

7. **Internal link suggestion**: After saving, show a prompt: "Consider adding internal links to related pages" with a list of 3 suggested pages from the same category.

---

## Admin Authentication

Keep it simple for now — use a single hardcoded admin password stored in `.env`:

```
ADMIN_PASSWORD=your_secure_password_here
ADMIN_EMAIL=admin@myplexus.com
```

Use JWT tokens. Admin logs in at `/admin/login`. All `/admin/*` routes require a valid JWT in localStorage.

---

## Example Pages to Create (to test after building)

Once built, create these 5 test pages via the dashboard:

| Page Title | Slug | Category | Focus Keyword |
|---|---|---|---|
| Why Every Indian Needs a Financial Plan | `/financial-needs` | Financial Planning | financial planning India |
| What is SIP and How Does It Work | `/what-is-sip` | SIP | what is SIP mutual fund |
| How to Choose the Right Mutual Fund | `/how-to-choose-mutual-fund` | Mutual Funds | choose mutual fund India |
| NFO Monitor — New Fund Offers Explained | `/nfo-explained` | NFO | NFO mutual fund India |
| Tax Saving with ELSS Mutual Funds | `/elss-tax-saving` | Tax Planning | ELSS tax saving mutual fund |

---

## What Good Output Looks Like

When complete, the admin should be able to:

1. Go to `https://www.myplexus.com/admin` → log in
2. See all existing pages in a table with SEO scores
3. Click "Create New Page" → fill in the form → publish in under 3 minutes
4. Upload a CSV of 10 pages → review → publish all at once
5. Click any page in the list → edit any field → save changes
6. Visit `https://www.myplexus.com/financial-needs` and see a fully rendered, SEO-optimised public page
7. Check `https://www.myplexus.com/sitemap.xml` and see all published pages listed

---

## Notes for the Developer / AI Building This

- Use **server-side rendering (SSR)** for all public pages — do NOT use client-side rendering for public pages as Google needs to read the HTML directly
- All images must be served with **lazy loading** (`loading="lazy"`) and have explicit `width` and `height` attributes to avoid layout shift (Core Web Vitals)
- Add **`robots.txt`** at the root: allow all crawlers, point to sitemap
- All admin routes must redirect to `/admin/login` if not authenticated
- The CSV bulk upload must handle encoding issues (UTF-8 only, reject other encodings with a clear error message)
- Content from the rich text editor must be **sanitised** before saving to prevent XSS attacks (use DOMPurify or equivalent)
- API responses must follow consistent format: `{ success: true, data: {...} }` or `{ success: false, error: "message" }`

---

*This document was prepared for myplexus.com — a mutual fund research platform. All pages created through this system will be published under the canonical domain `https://www.myplexus.com/`.*