GRANT ALL PRIVILEGES ON *.* TO cake_user@localhost IDENTIFIED BY [password];
CREATE DATABASE cake_db CHARACTER SET utf8;

CREATE TABLE wiki_pages (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    body TEXT DEFAULT '',
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL,
    category_id INT UNSIGNED DEFAULT NULL,
    is_public BOOLEAN DEFAULT 1,
    format INT UNSIGNED DEFAULT 0,
    attachment_id INT UNSIGNED DEFAULT NULL
);

CREATE TABLE categories (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    parent_id INTEGER(10) DEFAULT NULL,
    lft INTEGER(10) DEFAULT NULL,
    rght INTEGER(10) DEFAULT NULL,
    name VARCHAR(255) DEFAULT '',
    wiki_page_id INT UNSIGNED DEFAULT NULL,
    is_public BOOLEAN DEFAULT 1
);

CREATE TABLE users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(50),
    created DATETIME DEFAULT NULL,
    modified DATETIME DEFAULT NULL
);

CREATE table attachments (
    id INT unsigned NOT NULL auto_increment PRIMARY KEY,
    name varchar(255) NOT NULL,
    dir varchar(255) DEFAULT NULL,
    thumb_dir varchar(255) DEFAULT NULL,
    wiki_page_id INT UNSIGNED DEFAULT 0,
    created DATETIME DEFAULT NULL
);

CREATE table wiki_pages_revs (
	version_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	version_created DATETIME DEFAULT NULL,
	id INT UNSIGNED,
	title VARCHAR(255) NOT NULL,
	body TEXT DEFAULT '',
	created DATETIME DEFAULT NULL,
	modified DATETIME DEFAULT NULL,
	category_id INT UNSIGNED DEFAULT NULL,
	is_public BOOLEAN DEFAULT 1,
	format INT UNSIGNED DEFAULT 0,
	attachment_id INT UNSIGNED DEFAULT NULL
);
