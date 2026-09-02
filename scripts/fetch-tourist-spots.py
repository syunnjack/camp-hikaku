"""都道府県ごとの観光スポットを OpenStreetMap から取る。

出典: OpenStreetMap contributors（ODbL）
      https://www.openstreetmap.org/copyright

## なぜ OSM か

**楽天ウェブサービスに観光スポットのAPIは無い**（2026-09-02 に一覧を確認。
市場・ブックス・トラベル・レシピ・Kobo・GORA の6分野だけで、
トラベルは宿泊施設のみ）。施設は楽天トラベルから引き、
観光スポットは OSM から取って組み合わせる。

## 取る種類

  tourism=attraction   観光名所
  tourism=museum       博物館・美術館
  tourism=viewpoint    展望地
  historic=castle      城
  natural=waterfall    滝
  leisure=park         公園（name があるものだけ）

**名前の無いものは載せない。** 近くにある「無名の観光地」を
並べても読む人の役に立たない。

## Overpass の癖

**0件を「エラーではなく空」で返すことがある。** 取れなかった県は
`failedPrefectures` に記録し、**0件として上書きしない**。
ゴルフ練習場のときは1回目に14県が取れず、そのまま信じると
「東京に練習場は無い」ことになるところだった。

環境変数:
  ONLY  県名をカンマ区切りで並べると、その県だけ取り直して他は引き継ぐ

使い方: python scripts/fetch-tourist-spots.py
"""
import json
import os
import sys
import time
import urllib.parse
import urllib.request
from datetime import date
from pathlib import Path

# ミラーは軒並み不安定（502/500）。本家だけを、間隔を空けて叩く。
ENDPOINTS = ('https://overpass-api.de/api/interpreter',)
UA = 'camp-hikaku.jp data build (contact: info@camp-hikaku.jp)'
PAUSE = 6.0
PER_PREFECTURE = 40

OUT = Path(__file__).resolve().parent.parent / 'storage' / 'app' / 'tourist-spots.json'

KINDS = (
    ('tourism', 'attraction', '観光名所'),
    ('tourism', 'museum', '博物館・美術館'),
    ('tourism', 'viewpoint', '展望地'),
    ('historic', 'castle', '城'),
    ('natural', 'waterfall', '滝'),
)

PREFECTURES = [
    '北海道', '青森県', '岩手県', '宮城県', '秋田県', '山形県', '福島県', '茨城県',
    '栃木県', '群馬県', '埼玉県', '千葉県', '東京都', '神奈川県', '新潟県', '富山県',
    '石川県', '福井県', '山梨県', '長野県', '岐阜県', '静岡県', '愛知県', '三重県',
    '滋賀県', '京都府', '大阪府', '兵庫県', '奈良県', '和歌山県', '鳥取県', '島根県',
    '岡山県', '広島県', '山口県', '徳島県', '香川県', '愛媛県', '高知県', '福岡県',
    '佐賀県', '長崎県', '熊本県', '大分県', '宮崎県', '鹿児島県', '沖縄県',
]


def ask(query: str) -> dict | None:
    for endpoint in ENDPOINTS:
        try:
            request = urllib.request.Request(
                endpoint,
                data=urllib.parse.urlencode({'data': query}).encode(),
                headers={'User-Agent': UA, 'Accept': 'application/json'},
            )
            with urllib.request.urlopen(request, timeout=300) as response:
                return json.loads(response.read().decode('utf-8', 'replace'))
        except Exception as error:
            print(f'    {endpoint.split("/")[2]}: {str(error)[:60]}', file=sys.stderr)
            time.sleep(30)

    return None


def ask_with_retry(query: str, tries: int = 4) -> dict | None:
    """公開サーバーは混むと落ちる。あきらめずに間を空けて試す。"""
    for attempt in range(tries):
        payload = ask(query)
        if payload is not None:
            return payload
        wait = 30 * (attempt + 1)
        print(f'    {wait}秒待って試し直します', file=sys.stderr)
        time.sleep(wait)

    return None


def clean(element: dict) -> dict | None:
    tags = element.get('tags') or {}
    name = (tags.get('name') or tags.get('name:ja') or '').strip()

    if not name:
        return None

    kind = ''
    for key, value, label in KINDS:
        if tags.get(key) == value:
            kind = label
            break

    center = element.get('center') or element
    record = {
        'id': f'{element.get("type")}/{element.get("id")}',
        'name': name,
        'kind': kind,
        'lat': center.get('lat'),
        'lon': center.get('lon'),
    }

    if tags.get('website'):
        record['website'] = tags['website'].strip()

    return record


def load_previous() -> dict:
    if not OUT.exists():
        return {}
    try:
        return json.loads(OUT.read_text(encoding='utf-8'))
    except Exception:
        return {}


def main() -> int:
    previous = load_previous()
    found = dict(previous.get('byPrefecture') or {})
    failed = []

    only = [p.strip() for p in (os.environ.get('ONLY') or '').split(',') if p.strip()]
    targets = only or PREFECTURES

    if only:
        print(f'{len(only)}県だけ取り直します。', file=sys.stderr)

    for prefecture in targets:
        # **種類ごとに分けて投げる。** 5種類を1本の union にすると
        # 公開サーバーが重くて 504 や「200のまま空」を返す（2026-09-02 実測）。
        elements = []
        broke = False

        for key, value, _label in KINDS:
            query = (
                '[out:json][timeout:120];'
                f'area["name"="{prefecture}"]["admin_level"="4"]->.a;'
                f'nwr["{key}"="{value}"]["name"](area.a);'
                'out center tags;'
            )
            payload = ask_with_retry(query)

            if payload is None:
                broke = True
                break

            elements.extend(payload.get('elements', []))
            time.sleep(4.0)

        # 種類ごとに引いた結果、観光名所が1件も無い県は無い。
        # 空なら失敗とみなし、**前回の結果を消さない**。
        if broke or not elements:
            print(f'  {prefecture}: 取れませんでした'
                  f'（前回の {len(found.get(prefecture, []))}件を残します）', file=sys.stderr)
            failed.append(prefecture)
            time.sleep(PAUSE)
            continue

        rows = [clean(e) for e in elements]
        rows = [r for r in rows if r]
        # 名前順にして、県ごとに上限まで
        rows.sort(key=lambda r: r['name'])
        found[prefecture] = rows[:PER_PREFECTURE]

        print(f'  {prefecture}: {len(rows)}件 → {len(found[prefecture])}件を保存', file=sys.stderr)
        time.sleep(PAUSE)

    for prefecture in (previous.get('failedPrefectures') or []):
        if prefecture not in targets and prefecture not in failed:
            failed.append(prefecture)

    total = sum(len(v) for v in found.values())

    OUT.parent.mkdir(parents=True, exist_ok=True)
    OUT.write_text(json.dumps({
        'confirmedOn': date.today().isoformat(),
        'source': 'OpenStreetMap contributors',
        'sourceUrl': 'https://www.openstreetmap.org/copyright',
        'license': 'ODbL',
        'note': '名前が入っている施設だけを載せています。OSM に登録が無いスポットは出ません。',
        'perPrefecture': PER_PREFECTURE,
        'failedPrefectures': failed,
        'total': total,
        'byPrefecture': found,
    }, ensure_ascii=False), encoding='utf-8')

    print(f'\n合計 {total}件 / 取れなかった県 {len(failed)}', file=sys.stderr)
    return 0


if __name__ == '__main__':
    raise SystemExit(main())
