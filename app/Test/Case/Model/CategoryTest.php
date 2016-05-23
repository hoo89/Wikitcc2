<?php
App::uses('Category', 'Model');

/**
 * Category Test Case
 */
class CategoryTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.category',
		'app.wiki_page',
		'app.attachment'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Category = ClassRegistry::init('Category');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Category);

		parent::tearDown();
	}

/**
 * test Delete()
 *
 * @return void
 */
	public function testDelete() {
		// Delete an empty category
		$category8 = $this->Category->findById(8);
		$expected = array(
			'Category' => array(
				'id' => '8',
				'parent_id' => null,
				'lft' => '15',
				'rght' => '16',
				'name' => 'empty',
				'wiki_page_id' => null,
				'is_public' => true
			),
			'WikiPage'=> array()
		);

		$this->assertEquals($expected, $category8);
		$this->Category->delete(8);
		$category8 = $this->Category->findById(8);
		$this->assertEquals(array(), $category8);

		// Delete a category which has one WikiPage
		$category7 = $this->Category->findById(7);
		$expected = array(
			'Category' => array(
					'id' => '7',
					'parent_id' => '6',
					'lft' => '12',
					'rght' => '13',
					'name' => 'public',
					'wiki_page_id' => null,
					'is_public' => 1
				),
			'WikiPage'=> array(
				0 => array(
					'id' => '9',
					'title' => 'page8',
					'category_id' => '7',
					'is_public' => 1
				)
			)
		);

		$this->assertEquals($expected, $category7);
		$this->Category->delete(7);
		$category7 = $this->Category->findById(7);
		$this->assertEquals(array(), $category7);

		// assert no page belongs to category7
		$wikiPages = $this->Category->WikiPage->findAllByCategoryId(7);
		$this->assertEquals(array(), $wikiPages);

		// Delete a category which has multiple pages and categories below
		$category1 = $this->Category->findById(1);
		$expected = array(
			'Category' => array(
					'id' => '1',
					'parent_id' => null,
					'lft' => '1',
					'rght' => '6',
					'name' => 'category1',
					'wiki_page_id' => null,
					'is_public' => true
				),
			'WikiPage'=> array(
				0 => array(
					'id' => '6',
					'title' => 'page6',
					'category_id' => '1',
					'is_public' => true
				),
				1 => array(
					'id' => '5',
					'title' => 'page5',
					'category_id' => '1',
					'is_public' => false
				)
			)
		);
		$this->assertEquals($expected, $category1);

		// category 2 is under category 1 and category 5 is under category 2
		$wikiPages = $this->Category->WikiPage->findAllByCategoryId(2);
		$this->assertTrue(!empty($wikiPages));
		$wikiPages = $this->Category->WikiPage->findAllByCategoryId(5);
		$this->assertTrue(!empty($wikiPages));

		// assert no page belongs to category1, 2, 5
		$this->Category->delete(1);
		$category1 = $this->Category->findById(1);
		$this->assertEquals(array(), $category1);

		$wikiPages = $this->Category->WikiPage->findAllByCategoryId(1);
		$this->assertEquals(array(), $wikiPages);

		$wikiPages = $this->Category->WikiPage->findAllByCategoryId(2);
		$this->assertEquals(array(), $wikiPages);

		$wikiPages = $this->Category->WikiPage->findAllByCategoryId(5);
		$this->assertEquals(array(), $wikiPages);
	}
}
