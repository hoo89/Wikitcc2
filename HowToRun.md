### How to run
* $sudo apt-get install apache2 php5-mysql libapache2-mod-php5 php-pear mysql-server php5-gd
* install Text_Diff by $pear install Text_Diff
* confirm mods-rewrite enable
* DB setting
  - configure app/Config/database.php (based on database.php.default)
  - $app/Console/cake schema create
* Configure app/Config/core.php (based on core.php.default)
* If you need other knowledge (such as URL setting) refer http://book.cakephp.org/2.0/ja/installation.html

### How to transition
* mysqldump -u cake_user -p cake_db > dump.sql (on your old server)
* mysql -u cake_user -p cake_db < dump.sql (on your new server)
* copy app/Config/core.php and app/Config/database.php
* copy app/webroot/attachment

