<?php
/**
 * Attachment Fixture
 */
class AttachmentFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'Attachment');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '4',
			'name' => '797844194.png',
			'dir' => 'files/attachment/797844194.png',
			'thumb_dir' => 'files/attachment/thumb_797844194.png',
			'wiki_page_id' => '2',
			'created' => '2016-05-22 00:06:40'
		),
		array(
			'id' => '5',
			'name' => '805805651.png',
			'dir' => 'files/attachment/805805651.png',
			'thumb_dir' => 'files/attachment/thumb_805805651.png',
			'wiki_page_id' => '2',
			'created' => '2016-05-22 00:06:46'
		),
		array(
			'id' => '6',
			'name' => 'Todo',
			'dir' => 'files/attachment/Todo',
			'thumb_dir' => null,
			'wiki_page_id' => '1',
			'created' => '2016-05-22 00:07:24'
		),
		array(
			'id' => '7',
			'name' => 'NoOwnPage',
			'dir' => 'files/attachment/NoOwnPage',
			'thumb_dir' => null,
			'wiki_page_id' => null,
			'created' => '2016-05-22 14:24:32'
		),
	);

}
