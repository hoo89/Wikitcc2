<?php
class WikiPagesRevFixture extends CakeTestFixture {
	public $fields = array(
		'version_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'version_created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'body' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
		'is_public' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'format' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 10),
		'attachment_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10),
	);
}