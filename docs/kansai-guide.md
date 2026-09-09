# Kansai guide

Research date: 2026-09-09. Six genres across Osaka, Kyoto, Hyogo, Nara, Shiga and Wakayama. The dated source URLs and original concise factual summaries live in `app/Support/kansai-guide.json`.

GLAMP ELEMENT (White Dome), Kasagi Camp Field, Forest Adventure Kobe Mt.Rokko, Nobeha no Yu Tsuruhashi, Yoshino forest therapy and Toretore no Yu are featured. Accommodation prices specify the room type; entry and optional rock-bath fees are separated. Kasagi's official index announces an August 24 price revision, but the new amounts/effective date could not be verified from the operator article. No old price is presented as current. Yoshino's current tour price and fixed schedule are unverified; old tourism articles' prices are not reused. The office address is not represented as a meeting point. Toretore no Yu's address is 2508, from the local tourism association, rather than the market's 2521 address on the shared access page.

RegionalGuide resolves editorial keys to region-specific content. `/guides/kansai` and the existing `/guides/metropolitan` share a template, with distinct titles, descriptions, JSON-LD, active region navigation, research dates and facility sets. Existing URLs are retained. Facility details link back to their own region.

KansaiGuideSeeder reuses the transactional, idempotent editorial importer. It matches names/official URLs within the prefecture, fails on ambiguity or an existing different editorial key, and does not alter descriptions, ratings, reviews, booking links or coordinates. The production workflow invokes the dedicated seeder after application upload. No invented reviews, ratings, photos, medical benefits or map coordinates are added.
