# 合同会社わんわんわんこ 公式サイト（WordPressテーマ）

`wp-content/themes/wanko` に、合同会社わんわんわんこ様の会社HP用オリジナルテーマを収録しています。
WordPress本体・プラグイン・アップロード画像はこのリポジトリに含めません（テーマのみ管理）。

## サイト構成（提案資料準拠）

| ページ | URL | テンプレート | 備考 |
| --- | --- | --- | --- |
| トップ | `/` | `front-page.php` | MV → お知らせ → こだわりのペットフード → コラム → 私たちのお約束 → 企業情報への導線 |
| 企業情報 | `/company/` | `page-company.php` | ごあいさつ／会社概要／私たちのお約束（ページ内リンク） |
| 事業内容 | `/business/` | `page-business.php` | 卸販売・主要取引メーカー・にゃんにゃん／わんわんデリバリーフーズ・ペット総合ショップ |
| お知らせ | `/news/` | `home.php` `single.php` | 標準「投稿」を使用 |
| コラム | `/column/` | `archive.php` `single.php` | カスタム投稿タイプ `column`。カテゴリー・タグ・目次（自動）・関連記事 |
| 採用情報 | `/recruit/` | `page-recruit.php` | 募集要項は固定ページ本文で編集 |
| お問い合わせ | `/contact/` | `page-contact.php` | テーマ内蔵フォーム（通知＋自動返信）。Contact Form 7 のショートコードを設定すると置き換え可 |
| プライバシーポリシー | `/privacy/` | `page-privacy.php` | 初期文面入り |
| サイトマップ | `/sitemap/` | `page-sitemap.php` | 自動生成 |

固定ページ・メニュー・トップページ設定・パーマリンク・コラムの初期カテゴリーは、**テーマを有効化した瞬間に自動作成**されます（既存のものは上書きしません）。

`page-message.php`（私たちの想い）、`page-philosophy.php`（ブランド理念）、`page-commitment.php`（私たちのこだわり）は、将来ページを増やす際に使えるテンプレートとして残しています（自動作成はされません）。

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
   - （任意）Contact Form 7：内蔵フォームで足りない場合のみ。メールが届かない場合は WP Mail SMTP を追加
   - SiteGuard WP Plugin（ログイン保護）
   - UpdraftPlus（バックアップ）
   - XML Sitemap & Google News または WordPress標準サイトマップ（`/wp-sitemap.xml`）
5. **サイトの文言を入力**
   外観 → カスタマイズ → 「サイトコンテンツ（わんわんわんこ）」から、以下を入力します。
   - トップ：キャッチコピー・リード文・メインビジュアル画像
   - こだわりのペットフード各タイルの写真、「私たちのお約束」の写真、ムービー（YouTube URL、任意）
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
