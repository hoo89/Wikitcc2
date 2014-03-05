### How to run
* Install those packages $sudo apt-get install apache2 php5-mysql libapache2-mod-php5 php-pear mysql-server php5-gd
* Install Text_Diff $pear install Text_Diff
* Confirm mods-rewrite enabled
* DB setting
  - Configure app/Config/database.php (based on database.php.default)
  - Create schema $app/Console/cake schema create
* Configure app/Config/core.php (based on core.php.default)
* Make app/tmp directory and Set appropriate permission
* If you need other knowledge (such as URL setting) refer http://book.cakephp.org/2.0/ja/installation.html

### How to transition
* $mysqldump -u cake_user -p cake_db > dump.sql (on your old server)
* $mysql -u cake_user -p cake_db < dump.sql (on your new server)
* Copy app/Config/core.php and app/Config/database.php
* Copy app/webroot/attachment

