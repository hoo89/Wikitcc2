Wikitcc2
==========

CakePHPで動くWikiクローンです.
ある先輩が作成したWikitccというWikiクローンの後継を目指し開発を行いました。

Wiki clone powered by CakePHP.

### 機能
* PukiWikiライクな記法を用いた通常のWikiとしてのページ作成,編集,閲覧機能
* ファイルアップロード機能
* ユーザー認証を行い特定のユーザーのみに編集等の操作を許可する機能(不完全)
* ページ検索機能
* 履歴閲覧機能
* ツリー階層状のカテゴリー作成・分類機能
* RSS配信機能

などがあります。
部内用CMSとしての利用しか想定していないため、至らない点はご容赦ください。
ユーザー認証を外せるようにして、Markdownを使えるようにすると
もう少し幅広い人に使ってもらえそうですが、対応予定は未定。

### 動作環境
php5 + CakePHPが動くDB

#### 依存ライブラリ
* Text_Diff(http://pear.php.net/package/Text_Diff)
* GD(http://www.php.net/manual/ja/book.image.php)

### 動作方法
HowToRun.md参照

### ライセンス
私のライセンスが明記してあるものはMIT Licenseで公開します。
また、 app/View フォルダ内にある私が書いたものについてはパブリックドメインで公開します。

Copyright(c) 2013-2014 hoo89 http://hoo89.hatenablog.com/ hoo89@me.com


bokkoさんに敬意を込めて.

