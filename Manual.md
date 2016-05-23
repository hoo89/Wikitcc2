運用マニュアル
================

### 導入方法
動作には以下のものが必要です。
- PHP >= 5.3.0
- MySQL
- PHPのモジュール php-mysql php-gd php-mcrypt
また、Apacheで動かす場合、Apacheのmod-rewriteモジュールを有効にしないとトップページ以外をうまく読み込んでくれません。

Ubuntu 14.04では以下のパッケージを導入することで動かせます。
```
apache2 php5-fpm php5-mysql libapache2-mod-php5 php-pear mysql-server php5-gd php5-mcrypt
```

また```php5enmod mcrypt```でmodを有効にする必要があることに注意します。

Ubuntu 16.04では以下のパッケージを導入することで動かせます。
```
apache2 php-fpm php-mysql libapache2-mod-php php-pear mysql-server php-gd php-mcrypt
```

Apacheのmod-rewriteモジュールは以下のコマンドで有効に出来ます。
```
sudo a2enmod rewrite
sudo service apache2 restart
```

本体の導入はgitで行い
```
git clone https://github.com/hoo89/Wikitcc2.git
```
Cakephpなどの導入はComposerというPHPの依存関係解決ツールを用います。
```
cd app; php composer.phar install
```

その後、tmpディレクトリ、webroot/files/attachmentディレクトリをApacheユーザーから読み書き可能にします。
```
mkdir -p tmp webroot/files/attachment
chmod 755 tmp webroot/files/attachment
chown www-data:www-data tmp webroot/files/attachment
```

また、本番環境ではWarningやDeprecatedによる警告を表示しないよう、app/Config/core.phpのデバッグレベルを変更することを推奨します。
```
Configure::write('debug', 2);
```

### データベース(DB)設定方法
MySQLおよびDB設定の方法を解説します。
MySQLコンソールにrootでログインし
```
mysql -u root -p
```

まずWikitcc2用のユーザーを作成します。
```
CREATE USER cake_user IDENTIFIED BY 'password';
```

次にWikitcc2用のDBを作成します。
```
CREATE DATABASE cake_db CHARACTER SET utf8;
```

その後DBにアクセスできるようユーザーに権限を与えます。
```
GRANT ALL PRIVILEGES ON cake_db.* TO "cake_user"@"localhost";
```

ユーザ名、パスワード、DB名は適宜変えてください。

最後にWikitcc2のDB設定ファイルを開き、
```
		'login' => 'cake_user',
		'password' => 'password',
		'database' => 'cake_db',
```
を先ほどの設定通りに設定します。

Wikitcc2のルートディレクトリに戻りこのコマンドを実行しテーブルを作ります。
```
app/Console/cake schema create
(yを押して実行)
```

### Apache設定方法
例えば'/var/www/Wikitcc2'に置き、http://[ドメイン名]/Wikitcc2でアクセスする場合の設定の記述は次のようになります。
```
<Directory /var/www/Wikitcc2>
        Options FollowSymLinks
        AllowOverride All
        Order allow,deny
        allow from all
</Directory>
<Directory /var/www/Wikitcc2/app/webroot/files/attachment>
        Options -Indexes -FollowSymLinks
        AllowOverride None
</Directory>
```
http://[ドメイン名]/のみでアクセスする場合、次の行を追加します。
```
DocumentRoot /var/www/Wikitcc2/app/webroot
```


### バックアップ・移行方法
移行はディレクトリごとコピーすればだいたい大丈夫かと思います。
DBのデータの移行はダンプファイルに書き出して
```
mysqldump -u cake_user -p cake_db --add-drop-table > dump.sql (移行元)
mysql -u cake_user -p cake_db < dump.sql (移行先)
```
のようにすれば移行できるはずです。

### その他
  + アップデート方法
    appディレクトリ内で
    php composer.phar update
    を実行することでCakePHPやその他Composerで管理しているライブラリのアップデートが可能です。

  + PHP 7.0 への対応
    CakePHP 2.8ではPHP7.0への対応がなされています。
    ただし、CakePHP Pluginで未対応のものを用いているため、そのままでは検索機能が動きません。
    バージョンアップするまでのとりあえずの対応ですが、
```
    sed -i "s/String::/CakeText::/g" app/Plugin/Search/Model/Behavior/SearchableBehavior.php
```
とやれば動かせます。

  + 初期ユーザーの作成
	ユーザーを作成する機能は未実装ですが、app/Controller/UsersController.php中
```
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login');
	}
```
の$this->Auth->allow('login');を$this->Auth->allow();に変えることで
[BaseURL]/usersからユーザーの追加・管理画面を表示できます。
