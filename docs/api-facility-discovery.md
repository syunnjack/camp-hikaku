# APIによる施設調査

2026-09-10: Google Places Text Search (New)で20政令指定都市×6ジャンルの120検索を実施。265件の検索結果、重複を除く226 place IDを確認した。検索は地域内に限定されないため、所在地を公式サイトで再確認した。検索語との一致だけではジャンルを決めない。

公式サイトで照合した36施設（各ジャンル6施設、全20都市）を `app/Support/api-verified-facilities.json` に収録した。Googleの口コミ・評価・画像・座標・説明文は転載していない。住所と紹介内容の出典は各レコードの `source_urls`。医療効果は記載しない。営業日・料金は変動するため公式案内へ誘導する。

## 再調査

プロセス環境に GOOGLE_PLACES_API_KEY を設定し、以下を実行する。`.env` はこのNodeスクリプトでは自動読込しない。キーは出力・リポジトリ保存しない。

```sh
node scripts/discover-places.mjs --offset=0 --limit=6 --size=3 --report=/tmp/place-ids.json
```

- 上限は120リクエスト。通常は6件ずつ調査し、課金額はGoogle Cloud側で確認する。
- 401/403/429は中断する。自動再試行や無制限のページ送りは行わない。
- 画面出力は確認中のGoogle Maps提供情報。永続保存やspotsへの自動転記をしない。
- reportに保持するのはplace IDと自分たちの検索条件・件数・取得日時のみ。
- 市外・閉業・設備の裏付けがない候補は掲載しない。GoogleのOPERATIONALと公式の休業告知が矛盾する場合は保留する。
- ラヴィマーナ神戸、淀川キャンプフィールドは休業告知との整合が取れず今回保留。民家園・一般公園・BBQ飲食店を検索語だけで別ジャンルに分類しない。
- ヒーリングは今回、植物園・庭園の散策を対象として調査した。施術サービス全般を調査したわけではない。

## 掲載と保護

`php artisan db:seed --class=ApiVerifiedFacilitiesSeeder` は公式照合済みカタログのみ追加する。名称・都道府県・正規化した公式URLで重複を照合する。既存データ・体験記・予約URLは上書きしない。複数候補は停止して確認する。API検索自体は公開時に実行しない。

Google Places利用条件: https://developers.google.com/maps/documentation/places/web-service/policies

今後サイト上でGoogleの営業時間等を直接表示する場合は、保存制限とGoogle Mapsの帰属表示を満たす別実装が必要。今回の施設ページは各公式サイトから独立に確認した情報のみを掲載する。
