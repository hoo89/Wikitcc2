<?php
/**
 * WikiPage Fixture
 */
class WikiPageFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'WikiPage');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
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
		array(
			'id' => '9',
			'title' => 'page8',
			'body' => '',
			'created' => '2016-05-22 14:27:53',
			'modified' => '2016-05-22 14:28:01',
			'category_id' => '7',
			'is_public' => 1,
			'format' => '0',
			'attachment_id' => null
		),
	);

}
