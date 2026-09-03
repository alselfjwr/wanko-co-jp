# 合同会社わんわんわんこ 公式サイト（WordPressテーマ）

`wp-content/themes/wanko` に、合同会社わんわんわんこ様の会社HP用オリジナルテーマを収録しています。
WordPress本体・プラグイン・アップロード画像はこのリポジトリに含めません（テーマのみ管理）。

## サイト構成

| ページ | URL | テンプレート | 備考 |
| --- | --- | --- | --- |
| トップ | `/` | `front-page.php` | MV → NEWS → PRODUCTS → PHILOSOPHY → COMMITMENT → COLUMN → COMPANY → CONTACT |
| 商品一覧 | `/products/` | `archive-products.php` | カテゴリーごとに商品カードを表示 |
| カテゴリ別商品一覧 | `/products/{category}/` | `taxonomy-product_category.php` | 例：`/products/food/` |
| 商品詳細 | `/products/{category}/{product}/` | `single-products.php` | 画像・キャッチ・価格・購入CTA・特徴3点・おすすめ・スペック表・関連商品 |
| 私たちについて | `/about/` | `page-about.php` | 想い・理念・こだわりへのハブ |
| 私たちの想い | `/about/message/` | `page-message.php` | ブランドストーリー4章＋代表メッセージ |
| ブランド理念 | `/about/philosophy/` | `page-philosophy.php` | PURPOSE → MISSION → VALUE |
| 私たちのこだわり | `/about/commitment/` | `page-commitment.php` | こだわり01〜04 |
| 会社概要 | `/company/` | `page-company.php` | 会社情報テーブル＋Googleマップ（住所から自動） |
| 事業内容 | `/business/` | `page-business.php` | 卸販売・主要取引メーカー・定期便サービス |
| お知らせ | `/news/` | `home.php` `single.php` | 標準「投稿」を使用（カテゴリーで将来の絞り込みに対応） |
| コラム | `/column/` | `archive.php` `single.php` | カスタム投稿タイプ `column`。カテゴリー・タグ・目次（自動）・関連記事 |
| 採用情報 | `/recruit/` | `page-recruit.php` | 募集要項は固定ページ本文で編集 |
| お問い合わせ | `/contact/` | `page-contact.php` | Contact Form 7 のショートコードを設定 |
| プライバシーポリシー | `/privacy/` | `page-privacy.php` | 初期文面入り |
| サイトマップ | `/sitemap/` | `page-sitemap.php` | 自動生成 |

固定ページ・メニュー・トップページ設定・パーマリンク・初期カテゴリー（商品：フード／おやつ／用品／その他、コラム：犬との暮らし／健康／食事／お手入れ／商品について）は、**テーマを有効化した瞬間に自動作成**されます（既存のものは上書きしません）。

### 管理画面の構成

```
WordPress
├ お知らせ（標準の投稿）
├ 商品        ← 商品一覧／新規追加／商品カテゴリー（カテゴリー画像を設定可）
├ コラム      ← コラム一覧／新規追加／カテゴリー／タグ
├ 固定ページ
└ 外観 › カスタマイズ › サイトコンテンツ（わんわんわんこ）
```

### 商品登録の入力欄（プラグイン不要）

商品の編集画面に、次の入力欄が表示されます。入力した内容は商品詳細ページに自動で反映されます。

- 基本情報：キャッチコピー／価格／購入URL／購入ボタンの文言
- この商品の特徴：POINT 01〜03（見出し＋説明）
- こんな子におすすめ（1行1項目）
- 商品情報：商品名／内容量／対象／原材料／原産国／賞味期限／保存方法／販売元／注意事項
- 商品画像はアイキャッチ、商品説明は本文、短い説明は抜粋に入力

## お名前.com への反映手順

1. **WordPressをインストール**
   お名前.com Navi → レンタルサーバー → コントロールパネル → 「WordPress簡単インストール」から `wanko.co.jp` にインストール。
   ※ 既存サイトを置き換える場合は、先に現行サイトのバックアップを取得してください（コントロールパネルのバックアップ機能、またはFTPでファイル一式をダウンロード）。
2. **テーマZIPを作成**
   ```bash
   ./build.sh   # → dist/wanko.zip
   ```
   GitHub上で「Code › Download ZIP」した場合は、展開後の `wp-content/themes/wanko` フォルダをZIP化してください。
3. **テーマをアップロードして有効化**
   WordPress管理画面 → 外観 → テーマ → 新規追加 → テーマのアップロード → `wanko.zip` → 有効化。
   有効化と同時に固定ページ・メニューが作成され、トップページが設定されます。
4. **プラグインを追加**
   - Contact Form 7（お問い合わせフォーム）
   - SiteGuard WP Plugin（ログイン保護）
   - UpdraftPlus（バックアップ）
   - XML Sitemap & Google News または WordPress標準サイトマップ（`/wp-sitemap.xml`）
5. **サイトの文言を入力**
   外観 → カスタマイズ → 「サイトコンテンツ（わんわんわんこ）」から、以下を入力します。
   - トップ：キャッチコピー・リード文・メインビジュアル画像
   - ペットフード各カードの写真、「私たちのお約束」の背景写真、ムービー（YouTube URL、任意）
   - ECサイトURL（にゃんにゃん／わんわん／総合ショップ。空欄のままなら Coming Soon 表示）
   - ごあいさつ・会社概要（代表者、所在地、電話、メール など）
   - お問い合わせフォームのショートコード（Contact Form 7 で作成したもの）
   - ロゴは 外観 → カスタマイズ → サイト基本情報 → ロゴ から設定
6. **公開前チェック**
   - 設定 → 表示設定 →「検索エンジンがサイトをインデックスしないようにする」のチェックを外す
   - 設定 → パーマリンク →「変更を保存」を一度クリック（リライトルール更新）
   - お知らせ・コラムをそれぞれ1件以上投稿してトップの表示を確認

## ローカルでの確認

Dockerが使える環境では次のコマンドで確認できます。

```bash
docker run --rm -p 8080:80 \
  -v "$PWD/wp-content/themes/wanko:/var/www/html/wp-content/themes/wanko" \
  -e WORDPRESS_DB_HOST=db wordpress:latest
```

（DBコンテナは別途用意。`docker compose` を使う場合は `wordpress` と `mariadb` を組み合わせてください。）

## 素材について

- `assets/img/photo-*.jpg` は、わんわんわんこ様からご提供いただいた写真（Zoho WorkDrive「202609_ご提供素材」）をWeb用に縮小したものです。`photo-dog-food.jpg` のみ現行サイトの素材で、ストック写真の可能性があるため利用可否を確認してください。
- `assets/img/logo.svg`（ヘッダー用）、`logo-full.png`（英字入り）、`mascot.png`（チワワのマスコット）は、ご提供のロゴAIデータから書き出したものです。
- にゃんにゃんデリバリーフーズは BASE（https://wanwanwanko.official.ec/）と Shopify（https://nyan-nyan-delivery.myshopify.com/）の2店舗があり、初期値は Shopify 側です。カスタマイザーから変更できます。

## 開発メモ

- 文言は `inc/customizer.php` の `wanko_defaults()` に初期値をまとめています。
- スタイルは `assets/css/main.css`、動作は `assets/js/main.js`（依存ライブラリなし）。
- カラー：ロゴの濃紺 `#0a3190`（基調・いぬ）／水色 `#2ea8e1`（ねこ）／イエロー `#f6c344`（総合）。
- フォント：Noto Sans JP（本文）＋ Zen Maru Gothic（見出し）を Google Fonts から読み込み。
