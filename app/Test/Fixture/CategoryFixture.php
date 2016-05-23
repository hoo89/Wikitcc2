<?php
/**
 * Category Fixture
 */
class CategoryFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'Category');

/**
 * Records
 * 1
 * ├──2
 * │  └──5
 * ├──3
 * │  └──4
 * └──6
 *    └──7
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'parent_id' => null,
			'lft' => '1',
			'rght' => '6',
			'name' => 'category1',
			'wiki_page_id' => null,
			'is_public' => 1
		),
		array(
			'id' => '2',
			'parent_id' => '1',
			'lft' => '2',
			'rght' => '5',
			'name' => 'category2',
			'wiki_page_id' => null,
			'is_public' => 1
		),
		array(
			'id' => '3',
			'parent_id' => null,
			'lft' => '7',
			'rght' => '10',
			'name' => 'category3',
			'wiki_page_id' => null,
			'is_public' => 1
		),
		array(
			'id' => '4',
			'parent_id' => '3',
			'lft' => '8',
			'rght' => '9',
			'name' => 'category4',
			'wiki_page_id' => null,
			'is_public' => 0
		),
		array(
			'id' => '5',
			'parent_id' => '2',
			'lft' => '3',
			'rght' => '4',
			'name' => 'category5',
			'wiki_page_id' => null,
			'is_public' => 1
		),
		array(
			'id' => '6',
			'parent_id' => null,
			'lft' => '11',
			'rght' => '14',
			'name' => 'private',
			'wiki_page_id' => null,
			'is_public' => 0
		),
		array(
			'id' => '7',
			'parent_id' => '6',
			'lft' => '12',
			'rght' => '13',
			'name' => 'public',
			'wiki_page_id' => null,
			'is_public' => 1
		),
		array(
			'id' => '8',
			'parent_id' => null,
			'lft' => '15',
			'rght' => '16',
			'name' => 'empty',
			'wiki_page_id' => null,
			'is_public' => 1
		),
	);

}
