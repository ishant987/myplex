# Local Demo Notes

Local app URL: `http://127.0.0.1:8000`

## What this adds

- Seeds the hardcoded `pages` records used by many frontend routes.
- Creates the missing `new_from_myplexus` table used on the homepage.
- Adds missing `fund_man` columns expected by the web controller.
- Seeds light demo content for homepage/news/FAQ/about/fund-manager sections.
- Makes several external HTTP calls fail soft in local/offline runs.

## Tested URLs

These returned `200 OK` locally after `php artisan migrate:fresh --seed --force`:

- `/`
- `/about`
- `/contact`
- `/faq`
- `/page/about-us`
- `/page/contact-us`
- `/know-your-scheme`
- `/fund-portfolio`
- `/composition-snapshot`
- `/monthly-ranking`
- `/return-calculator`
- `/volatility-calculator`
- `/in-the-news`
- `/fund-man-details`
- `/fund-man-details/shridatta-bhandwaldar`
- `/meet-the-fund-man/local-demo-fund-manager`

## Seeded local login

- User: `testuser@myplexus.com`
- Password: `User@1234`

## Rebuild commands

```bash
php artisan migrate:fresh --seed --force
npm run dev
php artisan serve --host=127.0.0.1 --port=8000
```
