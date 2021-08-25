## 導入手順

### 前準備
#### 1.composer インストール
[composer 公式サイト](https://getcomposer.org/)  
上記サイトのDownloadを参照

### ローカル開発環境
#### 1.リポジトリ取得(developブランチ)
    $ git clone -b develop

以下、corporateディレクトリの中で行う
#### 2.依存モジュール取得
    $ composer install
※上記実行後はcorporate/vendorが生成されていることを確認。

#### 3.環境ファイル設定
    $ cp .env.example .env
※上記実行後は.envが生成されていることを確認。

    $ php artisan key:generate
.env内、APP_KEYが設定されていることを確認。
その他、環境に合わせて.envファイルを変更。(DBの設定など)  

#### 4.DBマイグレーション
    $ php artisan migrate

### リポジトリ規約
#### テスト環境用
developはテスト環境確認用の最新版。  
基本的にbranch元はここ。
プルリクエストの際はdevelopへ。
ユニットテスト導入後は、developへのマージタスクを作成する予定。

#### 本番環境
masterは本番リリースいつでも可能な状態にしておく。  
基本的に管理者以外プルリクエスト禁止。
