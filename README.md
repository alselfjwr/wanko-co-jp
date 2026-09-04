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

## お名前.com への反映手順（現行サイトを止めずに設置 → 確認OK後に切り替え）

WordPress は `public_html/wp/` に設置します。現行サイト（静的HTML）はそのまま公開され続け、新サイトは `https://wanko.co.jp/wp/` で確認できます。切り替えは最後に5分で行い、いつでも元に戻せます。

### 1. 設置（初回のみ）

1. **現行サイトのバックアップ**：ファイルマネージャーで `public_html` を丸ごとダウンロード（取得済み）。
2. **WordPress簡単インストール**：コントロールパネル → WordPress簡単インストール → ドメイン `wanko.co.jp`、**インストール先ディレクトリ `wp`**、サイト名「合同会社わんわんわんこ」、管理者ユーザー名は `admin` 以外。
3. **FTPアカウントの確認**：コントロールパネル「FTP・SSHアカウント」でサーバー名・アカウント名・パスワードを確認。
4. **GitHub Secrets 登録**：Settings → Secrets and variables → Actions で `FTP_HOST` `FTP_USER` `FTP_PASSWORD` を登録。配置先が `/public_html/wp/wp-content/themes/wanko/` と異なる場合のみ `FTP_REMOTE_PATH` も登録。
5. **デプロイ実行**：Actions → 「Deploy theme」 → Run workflow。以降は push のたびに自動同期。
6. **テーマ有効化**：`https://wanko.co.jp/wp/wp-admin/` → 外観 → テーマ → 「Wanko Corporate」を有効化（固定ページ・メニュー・トップ設定・パーマリンクが自動作成）。
7. **検索エンジン除外**：設定 → 表示設定 →「検索エンジンがサイトをインデックスしないようにする」にチェック（切り替え時に外す）。
8. **推奨プラグイン**：SiteGuard WP Plugin、UpdraftPlus。フォームの通知メールが届かなければ WP Mail SMTP。

この時点で、クライアントは `https://wanko.co.jp/wp/` で新サイトを確認できます。

### 2. 切り替え（クライアント確認OK後、約5分）

WordPress のファイルは `wp/` に置いたまま、公開URLだけをドメイン直下にします（WordPress公式の「WordPress を専用ディレクトリに置く」方式）。

1. 管理画面 → 設定 → 一般 で、**「サイトアドレス (URL)」だけ** を `https://wanko.co.jp` に変更して保存（「WordPress アドレス (URL)」は `https://wanko.co.jp/wp` のまま）。保存直後は一時的にトップが表示されなくなりますが、次の手順で直ります。
2. ファイルマネージャーで `public_html/wp/index.php` を `public_html/` に**コピー**し、コピーした方の最終行を次のように書き換える：
   `require __DIR__ . '/wp-blog-header.php';` → `require __DIR__ . '/wp/wp-blog-header.php';`
3. `public_html/wp/.htaccess` があれば `public_html/` にコピー（なければ手順5で自動生成）。
4. 現行サイトの `public_html/index.html` を `index_old.html` にリネーム（旧サイトの他のフォルダはそのままで構いません。後日削除）。
5. 管理画面 → 設定 → パーマリンク → 「変更を保存」を1回押す。
6. 設定 → 表示設定 の「インデックスしない」チェックを外す。
7. `https://wanko.co.jp/` と `https://wanko.co.jp/company/` などを開いて表示を確認。

**元に戻す場合**：`index_old.html` を `index.html` に戻し、`public_html/index.php` と `public_html/.htaccess` を削除、設定 → 一般 の「サイトアドレス」を `https://wanko.co.jp/wp` に戻す。

### 以降の更新

文言・写真・デザインの修正はテーマ側で行い、GitHub への push だけで本番へ反映されます。管理画面での作業は、お知らせ・コラムの投稿と、外観 › カスタマイズでの文言差し替えのみです。

### 手動で反映する場合

```bash
./build.sh   # → dist/wanko.zip を 外観 › テーマ › 新規追加 › テーマのアップロード
```

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
