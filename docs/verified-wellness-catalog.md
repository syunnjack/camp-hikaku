# Verified wellness and activity catalog

Official source pages checked on 2026-09-08. Eight real facilities, two per requested genre. The exact official/access source URLs and descriptions are frozen in `VerifiedWellnessSeeder` and stored on each inserted facility. Names and broad descriptions are paraphrased from operators or public forestry/tourism authorities, without copying promotional health claims. No prices, opening hours, ratings, reviews, likes or congestion observations are synthesized.

| Genre | Facility | Prefecture |
| --- | --- | --- |
| Activity | フォレストアドベンチャー・箱根 | 神奈川県 |
| Activity | フォレストアドベンチャー・フジ | 山梨県 |
| Stone sauna | 横浜みなとみらい 万葉倶楽部 | 神奈川県 |
| Stone sauna | スパジアム ジャポン | 東京都 |
| Healing / nature walks | BIOTOPIA（ビオトピア）森林セラピー | 神奈川県 |
| Healing / nature walks | 赤沢自然休養林 | 長野県 |
| Spa | スパ ラクーア | 東京都 |
| Spa | SPAWORLD HOTEL&RESORT（スパワールド） | 大阪府 |

Coordinates come from the embedded access-map centers on the official pages. Akasawa uses the first on-site Street View point on the Forestry Agency page, not the much wider regional access-map center. They are representative locations, not verified entrances or meeting points. The UI explains this distinction; approximate editorial points are omitted from the facility's JSON-LD geo. Address strings and the original official access links are provided so visitors can verify their route.

BIOTOPIA's address refers to the complex, not a guaranteed meeting place for every program. Forest guide availability, opening seasons, closures, entry conditions and prices must be checked with the operator. The healing category describes forest walks and rest, not a medical treatment or verified health outcome.

Deployment adds nullable source metadata fields, uploads this specific seeder, and invokes it after application upload. It inserts only missing names in the same prefecture or missing official URLs, in a transaction. Existing records, booking links and UGC are never overwritten. Repeated deployments do not create duplicate entries. The ordinary DatabaseSeeder is not invoked. Public submission validation does not accept editorial verification metadata.

Before this release, public keyword searches for all eight facility names (shared operator prefix for the two Forest Adventure facilities) returned no matches. After publication, verify that each of the four category pages contains its two facilities, and that their detail pages show the official sources and reference date.
