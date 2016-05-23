<?php
/**
 * WikiPagesRev Fixture
 */
class WikiPagesRevFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'version_id' => '1',
			'version_created' => '2016-05-21 21:44:42',
			'id' => '1',
			'title' => 'page1',
			'body' => 'aaaaa',
			'created' => '2016-05-21 21:44:42',
			'modified' => '2016-05-21 21:44:42',
			'category_id' => null,
			'is_public' => 1,
			'format' => '0',
			'attachment_id' => null
		),
		array(
			'version_id' => '2',
			'version_created' => '2016-05-21 21:44:54',
			'id' => '1',
			'title' => 'page1',
			'body' => 'bbbbb',
			'created' => '2016-05-21 21:44:42',
			'modified' => '2016-05-21 21:44:54',
			'category_id' => null,
			'is_public' => 1,
			'format' => '0',
			'attachment_id' => null
		),
		array(
			'version_id' => '3',
			'version_created' => '2016-05-21 23:07:17',
			'id' => '2',
			'title' => 'page2',
			'body' => 'bbb',
			'created' => '2016-05-21 23:07:17',
			'modified' => '2016-05-21 23:07:17',
			'category_id' => '2',
			'is_public' => 1,
			'format' => '0',
			'attachment_id' => null
		),
		array(
			'version_id' => '4',
			'version_created' => '2016-05-21 23:21:39',
			'id' => '3',
			'title' => 'page3',
			'body' => 'cccc',
			'created' => '2016-05-21 23:21:39',
			'modified' => '2016-05-21 23:21:39',
			'category_id' => '4',
			'is_public' => 1,
			'format' => '0',
			'attachment_id' => null
		),
		array(
			'version_id' => '5',
			'version_created' => '2016-05-21 23:21:52',
			'id' => '4',
			'title' => 'page4',
			'body' => 'ddd',
			'created' => '2016-05-21 23:21:52',
			'modified' => '2016-05-21 23:21:52',
			'category_id' => '3',
			'is_public' => 1,
			'format' => '0',
			'attachment_id' => null
		),
		array(
			'version_id' => '6',
			'version_created' => '2016-05-21 23:21:57',
			'id' => '4',
			'title' => 'page4',
			'body' => 'ddd',
			'created' => '2016-05-21 23:21:52',
			'modified' => '2016-05-21 23:21:57',
			'category_id' => '3',
			'is_public' => 0,
			'format' => '0',
			'attachment_id' => null
		),
		array(
			'version_id' => '7',
			'version_created' => '2016-05-21 23:22:23',
			'id' => '5',
			'title' => 'page5',
			'body' => '',
			'created' => '2016-05-21 23:22:23',
			'modified' => '2016-05-21 23:22:23',
			'category_id' => '1',
			'is_public' => 0,
			'format' => '0',
			'attachment_id' => null
		),
		array(
			'version_id' => '8',
			'version_created' => '2016-05-21 23:22:38',
			'id' => '6',
			'title' => 'page6',
			'body' => '',
			'created' => '2016-05-21 23:22:37',
			'modified' => '2016-05-21 23:22:37',
			'category_id' => '1',
			'is_public' => 1,
			'format' => '0',
			'attachment_id' => null
		),
		array(
			'version_id' => '9',
			'version_created' => '2016-05-21 23:23:12',
			'id' => '7',
			'title' => 'page7',
			'body' => '',
			'created' => '2016-05-21 23:23:12',
			'modified' => '2016-05-21 23:23:12',
			'category_id' => '5',
			'is_public' => 1,
			'format' => '0',
			'attachment_id' => null
		),
		array(
			'version_id' => '10',
			'version_created' => '2016-05-21 23:24:28',
			'id' => '8',
			'title' => 'public_page',
			'body' => 'a',
			'created' => '2016-05-21 23:24:28',
			'modified' => '2016-05-21 23:24:28',
			'category_id' => '6',
			'is_public' => 1,
			'format' => '0',
			'attachment_id' => null
		),
	);

	public $fields = array(
		'version_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true, 'key' => 'primary'),
		'version_created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'unsigned' => true),
		'title' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'body' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'category_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true),
		'is_public' => array('type' => 'boolean', 'null' => true, 'default' => '1'),
		'format' => array('type' => 'integer', 'null' => true, 'default' => '0', 'length' => 10, 'unsigned' => true),
		'attachment_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'length' => 10, 'unsigned' => true),
	);

}
