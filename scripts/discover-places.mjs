// Research tool: Google content is displayed for review, never imported into spots.
// Only place IDs and our own query metadata are retained in the optional report.
import fs from 'node:fs';
import { fileURLToPath } from 'node:url';
const root = fileURLToPath(new URL('../', import.meta.url));
const cities = JSON.parse(fs.readFileSync(root + 'app/Support/designated-cities.json', 'utf8'));
const genres = { glamping: 'グランピング', solo: 'ソロキャンプ キャンプ場', activity: 'アスレチック アクティビティ', ganbanyoku: '岩盤浴', healing: '植物園 日本庭園', spa: '日帰り温泉 スパ' };
const options = Object.fromEntries(process.argv.slice(2).map(arg => arg.replace(/^--/, '').split('=')));
const offset = Number(options.offset ?? 0);
const limit = Number(options.limit ?? 6);
const size = Number(options.size ?? 3);
if (!Number.isInteger(offset) || offset < 0 || !Number.isInteger(limit) || limit < 1 || limit > 120 || !Number.isInteger(size) || size < 1 || size > 10) throw new Error('offset >= 0, limit 1..120, size 1..10 required');
const key = process.env.GOOGLE_PLACES_API_KEY;
if (!key) throw new Error('GOOGLE_PLACES_API_KEY is required');
const queries = Object.entries(cities).flatMap(([city, info]) => Object.entries(genres).map(([category, label]) => ({ city, category, query: `${info.area} ${info.label} ${label}` })));
const report = { checked_at: new Date().toISOString(), requests: 0, errors: [], selections: [] };
for (const selection of queries.slice(offset, offset + limit)) {
  report.requests++;
  try {
    const response = await fetch('https://places.googleapis.com/v1/places:searchText', {
      method: 'POST', signal: AbortSignal.timeout(20000),
      headers: { 'Content-Type': 'application/json', 'X-Goog-Api-Key': key, 'X-Goog-FieldMask': 'places.id,places.displayName,places.websiteUri,places.businessStatus' },
      body: JSON.stringify({ textQuery: selection.query, languageCode: 'ja', regionCode: 'JP', pageSize: size }),
    });
    if (!response.ok) {
      report.errors.push({ ...selection, http: response.status });
      if ([401, 403, 429].includes(response.status)) break;
      continue;
    }
    const data = await response.json();
    const places = data.places ?? [];
    report.selections.push({ ...selection, place_ids: places.map(p => p.id).filter(Boolean) });
    // Do not redirect this transient Google Maps content into a permanent catalog.
    console.log(JSON.stringify({ provider: 'Google Maps', ...selection, candidates: places.map(p => ({ id: p.id, name: p.displayName?.text, website: p.websiteUri, status: p.businessStatus })) }));
  } catch {
    // Never log exceptions containing authenticated request headers.
    report.errors.push({ ...selection, error: 'request_failed' });
  }
  await new Promise(resolve => setTimeout(resolve, 200));
}
if (options.report) fs.writeFileSync(options.report, JSON.stringify(report, null, 2) + '\n');
console.error(JSON.stringify({ requests: report.requests, successful: report.selections.length, errors: report.errors.length }));
if (report.errors.length) process.exitCode = 1;
