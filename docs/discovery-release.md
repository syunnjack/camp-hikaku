# Outdoor & wellness release

This is an extension of the existing Laravel 12 application and Xserver deployment. Existing facility IDs, links, booking affiliations, reviews and LINE functionality remain. No new site or hosting account is needed.

## Included

- Seven category routes (the six requested genres plus existing campgrounds). Solo includes legacy campground records tagged solo.
- Server-rendered keyword, prefecture and audience search; 12 records per page; review-count and rating sorting; comparison of up to three facilities.
- Visit date, party and personal spend on persistent reviews, reports with per-reporter deduplication, operator hide/restore commands, excluded hidden reviews in lists and aggregates.
- HTML metadata, self-canonical pagination, noindex for ad-hoc filters and comparison, valid escaped JSON-LD, category sitemap links, factual llms.txt and visible sourcing caveats.
- Responsive search-first design. The licensed landscape is decorative scenery, explicitly not a property photograph.

## Deployment

The main/master push workflow publishes publicly to the existing Xserver. Review the PR before merging. It now runs tests/build first, uploads additive migrations and executes `php artisan migrate --force` before uploading dependent application code. Database columns/tables are added; existing records are not rewritten or reseeded. Take the usual server/database backup before release. The existing SFTP deployment is not atomic; use a scheduled maintenance window for a production rollout and monitor the application after publication.

On a manual deployment: install locked dependencies, back up database, copy/run new migrations first, deploy app/routes/resources/public, clear route/view/config caches, then verify search, facility details and a real review submission. Keep `.env`, database files, session files and uploads on the server. Do not deploy local SQLite files or test data.

Do not run the default DatabaseSeeder on production. Existing CampSeeder and GlampingSeeder were used only in the isolated local database for preview. The four new wellness/activity genres require real, checked facility submissions before they have catalog entries; empty lists are shown honestly.

## Moderation

SSH access is the operator authorization boundary; no public administration endpoint is added.

```text
php artisan reviews:reports
php artisan reviews:visibility REVIEW_ID hide
php artisan reviews:visibility REVIEW_ID show
```

Review reports daily. These commands record state in the shared database. Automated notifications to the operator, identity verification, visit verification and photo uploads are not part of this release. Existing anonymous publication is retained with throttle, honeypot and prohibited-string checks. Those checks are basic spam controls, not comprehensive moderation.

## Search and AI discovery

Google's [AI guidance](https://developers.google.com/search/docs/appearance/ai-features) prioritizes the same crawlable, useful, reliable content used for Search. Structured markup describes visible facts; no synthetic reviews or unsupported health claims are introduced. llms.txt is supplemental guidance, not a ranking guarantee. After launch, verify the canonical production APP_URL, resubmit sitemap in Search Console and monitor indexed pages, impressions, clicks and conversion to facility/booking pages. Ranking above another site or being cited by an AI is not established by this implementation.

## Image

`public/images/lake-motosu.jpg`: Supanut Arunoprayote, [Mount Fuji from Lake Motosu](https://commons.wikimedia.org/wiki/File:Mount_Fuji_from_Lake_Motosu_20241026.jpg), [CC BY 4.0](https://creativecommons.org/licenses/by/4.0/), displayed with cropping. Attribution is in the footer.

## Rollback

Restore the previous application source if necessary. Leave the additive schema in place to retain new reviews/reports and metadata; do not run migration rollback against live contributions. Restore a database backup only as a separately approved incident procedure.
