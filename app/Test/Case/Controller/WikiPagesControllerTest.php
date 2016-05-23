<?php
App::uses('WikiPagesController', 'Controller');

/**
 * WikiPagesController Test Case
 */
class WikiPagesControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.wiki_page',
		'app.category',
		'app.attachment',
		'app.wiki_pages_rev'
	);

/**
 * Mock of WikiPagesController
 *
 * @var Object|null
 */
	public $WikiPages = null;

/**
 * Full URL pass
 *
 * @var string
 */
	public $base_url = "http://example.com";
/**
 * SetUp
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		Configure::write('App.fullBaseUrl', $this->base_url);

		$this->WikiPages = $this->generate('WikiPages', array(
			'methods' => array(
				'isAuthorized'
			),
			'components' => array(
				'Session',
				'Auth' => array('loggedIn')
			),
			'models' => array(
				'WikiPage' => array('save')
			)
		));
	}

/**
 * Add stub for login
 *
 * @return void
 */
	public function login() {
		$this->WikiPages->Auth
			->Expects($this->any())
			->method('loggedIn')
			->will($this->returnValue(true));

		$this->WikiPages
			->Expects($this->any())
			->method('isAuthorized')
			->will($this->returnValue(true));
	}

/**
 * Add stub for logout
 *
 * @return void
 */
	public function logout() {
		$this->controller->Auth->logout();
		$this->WikiPages->Auth
			->Expects($this->any())
			->method('loggedIn')
			->will($this->returnValue(false));

		$this->WikiPages
			->Expects($this->any())
			->method('isAuthorized')
			->will($this->returnValue(false));
	}

/**
 * test of publicIndex() on login
 *
 * @return void
 */
	public function testPublicIndexLogin() {
		$this->login();

		// if user is logged in, redirect to wiki_pages/index
        $results = $this->testAction('/wiki_pages/public_index',array('method' => 'get', 'return' => 'vars'));
		$this->assertEquals(array(), $results);

		$expected = array(
			'Location' => $this->base_url . $this->controller->request->base . DS . 'wiki_pages'
		);
		$this->assertEquals($expected, $this->headers);
	}

/**
 * test of publicIndex() on logout
 *
 * @return void
 */
	public function testPublicIndexLogout(){
		$this->logout();

		// if user is logout, show public pages
		$results = $this->testAction('/wiki_pages/public_index',array('method' => 'get', 'return' => 'vars'));
		//debug($results);

		$expected = array(
			'wikiPages' => array(
				(int) 0 => array(
					'WikiPage' => array(
						'id' => '9',
						'title' => 'page8',
						'body' => '',
						'created' => '2016-05-22 14:27:53',
						'modified' => '2016-05-22 14:28:01',
						'category_id' => '7',
						'is_public' => true,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => '7',
						'parent_id' => '6',
						'lft' => '12',
						'rght' => '13',
						'name' => 'public',
						'wiki_page_id' => null,
						'is_public' => true
					),
					'Attachment' => array()
				),
				(int) 1 => array(
					'WikiPage' => array(
						'id' => '8',
						'title' => 'public_page',
						'body' => 'a',
						'created' => '2016-05-21 23:24:28',
						'modified' => '2016-05-21 23:24:28',
						'category_id' => '6',
						'is_public' => true,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => '6',
						'parent_id' => null,
						'lft' => '11',
						'rght' => '14',
						'name' => 'private',
						'wiki_page_id' => null,
						'is_public' => false
					),
					'Attachment' => array()
				),
				(int) 2 => array(
					'WikiPage' => array(
						'id' => '7',
						'title' => 'page7',
						'body' => '',
						'created' => '2016-05-21 23:23:12',
						'modified' => '2016-05-21 23:23:12',
						'category_id' => '5',
						'is_public' => true,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => '5',
						'parent_id' => '2',
						'lft' => '3',
						'rght' => '4',
						'name' => 'category5',
						'wiki_page_id' => null,
						'is_public' => true
					),
					'Attachment' => array()
				),
				(int) 3 => array(
					'WikiPage' => array(
						'id' => '6',
						'title' => 'page6',
						'body' => '',
						'created' => '2016-05-21 23:22:37',
						'modified' => '2016-05-21 23:22:37',
						'category_id' => '1',
						'is_public' => true,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => '1',
						'parent_id' => null,
						'lft' => '1',
						'rght' => '6',
						'name' => 'category1',
						'wiki_page_id' => null,
						'is_public' => true
					),
					'Attachment' => array()
				),
				(int) 4 => array(
					'WikiPage' => array(
						'id' => '3',
						'title' => 'page3',
						'body' => 'cccc',
						'created' => '2016-05-21 23:21:39',
						'modified' => '2016-05-21 23:21:39',
						'category_id' => '4',
						'is_public' => true,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => '4',
						'parent_id' => '3',
						'lft' => '8',
						'rght' => '9',
						'name' => 'category4',
						'wiki_page_id' => null,
						'is_public' => false
					),
					'Attachment' => array()
				),
				(int) 5 => array(
					'WikiPage' => array(
						'id' => '2',
						'title' => 'page2',
						'body' => 'bbb',
						'created' => '2016-05-21 23:07:17',
						'modified' => '2016-05-21 23:07:17',
						'category_id' => '2',
						'is_public' => true,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => '2',
						'parent_id' => '1',
						'lft' => '2',
						'rght' => '5',
						'name' => 'category2',
						'wiki_page_id' => null,
						'is_public' => true
					),
					'Attachment' => array(
						(int) 0 => array(
							'id' => '4',
							'name' => '797844194.png',
							'dir' => 'files/attachment/797844194.png',
							'thumb_dir' => 'files/attachment/thumb_797844194.png',
							'wiki_page_id' => '2',
							'created' => '2016-05-22 00:06:40'
						),
						(int) 1 => array(
							'id' => '5',
							'name' => '805805651.png',
							'dir' => 'files/attachment/805805651.png',
							'thumb_dir' => 'files/attachment/thumb_805805651.png',
							'wiki_page_id' => '2',
							'created' => '2016-05-22 00:06:46'
						)
					)
				),
				(int) 6 => array(
					'WikiPage' => array(
						'id' => '1',
						'title' => 'page1',
						'body' => 'bbbbb',
						'created' => '2016-05-21 21:44:42',
						'modified' => '2016-05-21 21:44:54',
						'category_id' => null,
						'is_public' => true,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => null,
						'parent_id' => null,
						'lft' => null,
						'rght' => null,
						'name' => null,
						'wiki_page_id' => null,
						'is_public' => null
					),
					'Attachment' => array(
						(int) 0 => array(
							'id' => '6',
							'name' => 'Todo',
							'dir' => 'files/attachment/Todo',
							'thumb_dir' => null,
							'wiki_page_id' => '1',
							'created' => '2016-05-22 00:07:24'
						)
					)
				)
			)
		);
		$this->assertEquals($expected, $results);
	}

/**
 * test of index() on login
 *
 * @return void
 */
	public function testIndexLogin(){
		$this->login();
		// if user is logged in, show all pages
        $results = $this->testAction('/wiki_pages/index',array('method' => 'get', 'return' => 'vars'));
        //debug($results);
		$expected = array(
			'wikiPages' => array(
				(int) 0 => array(
					'WikiPage' => array(
						'id' => '9',
						'title' => 'page8',
						'body' => '',
						'created' => '2016-05-22 14:27:53',
						'modified' => '2016-05-22 14:28:01',
						'category_id' => '7',
						'is_public' => true,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => '7',
						'parent_id' => '6',
						'lft' => '12',
						'rght' => '13',
						'name' => 'public',
						'wiki_page_id' => null,
						'is_public' => true
					),
					'Attachment' => array()
				),
				(int) 1 => array(
					'WikiPage' => array(
						'id' => '8',
						'title' => 'public_page',
						'body' => 'a',
						'created' => '2016-05-21 23:24:28',
						'modified' => '2016-05-21 23:24:28',
						'category_id' => '6',
						'is_public' => true,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => '6',
						'parent_id' => null,
						'lft' => '11',
						'rght' => '14',
						'name' => 'private',
						'wiki_page_id' => null,
						'is_public' => false
					),
					'Attachment' => array()
				),
				(int) 2 => array(
					'WikiPage' => array(
						'id' => '7',
						'title' => 'page7',
						'body' => '',
						'created' => '2016-05-21 23:23:12',
						'modified' => '2016-05-21 23:23:12',
						'category_id' => '5',
						'is_public' => true,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => '5',
						'parent_id' => '2',
						'lft' => '3',
						'rght' => '4',
						'name' => 'category5',
						'wiki_page_id' => null,
						'is_public' => true
					),
					'Attachment' => array()
				),
				(int) 3 => array(
					'WikiPage' => array(
						'id' => '6',
						'title' => 'page6',
						'body' => '',
						'created' => '2016-05-21 23:22:37',
						'modified' => '2016-05-21 23:22:37',
						'category_id' => '1',
						'is_public' => true,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => '1',
						'parent_id' => null,
						'lft' => '1',
						'rght' => '6',
						'name' => 'category1',
						'wiki_page_id' => null,
						'is_public' => true
					),
					'Attachment' => array()
				),
				(int) 4 => array(
					'WikiPage' => array(
						'id' => '5',
						'title' => 'page5',
						'body' => '',
						'created' => '2016-05-21 23:22:23',
						'modified' => '2016-05-21 23:22:23',
						'category_id' => '1',
						'is_public' => false,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => '1',
						'parent_id' => null,
						'lft' => '1',
						'rght' => '6',
						'name' => 'category1',
						'wiki_page_id' => null,
						'is_public' => true
					),
					'Attachment' => array()
				),
				(int) 5 => array(
					'WikiPage' => array(
						'id' => '4',
						'title' => 'page4',
						'body' => 'ddd',
						'created' => '2016-05-21 23:21:52',
						'modified' => '2016-05-21 23:21:57',
						'category_id' => '3',
						'is_public' => false,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => '3',
						'parent_id' => null,
						'lft' => '7',
						'rght' => '10',
						'name' => 'category3',
						'wiki_page_id' => null,
						'is_public' => true
					),
					'Attachment' => array()
				),
				(int) 6 => array(
					'WikiPage' => array(
						'id' => '3',
						'title' => 'page3',
						'body' => 'cccc',
						'created' => '2016-05-21 23:21:39',
						'modified' => '2016-05-21 23:21:39',
						'category_id' => '4',
						'is_public' => true,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => '4',
						'parent_id' => '3',
						'lft' => '8',
						'rght' => '9',
						'name' => 'category4',
						'wiki_page_id' => null,
						'is_public' => false
					),
					'Attachment' => array()
				),
				(int) 7 => array(
					'WikiPage' => array(
						'id' => '2',
						'title' => 'page2',
						'body' => 'bbb',
						'created' => '2016-05-21 23:07:17',
						'modified' => '2016-05-21 23:07:17',
						'category_id' => '2',
						'is_public' => true,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => '2',
						'parent_id' => '1',
						'lft' => '2',
						'rght' => '5',
						'name' => 'category2',
						'wiki_page_id' => null,
						'is_public' => true
					),
					'Attachment' => array(
						(int) 0 => array(
							'id' => '4',
							'name' => '797844194.png',
							'dir' => 'files/attachment/797844194.png',
							'thumb_dir' => 'files/attachment/thumb_797844194.png',
							'wiki_page_id' => '2',
							'created' => '2016-05-22 00:06:40'
						),
						(int) 1 => array(
							'id' => '5',
							'name' => '805805651.png',
							'dir' => 'files/attachment/805805651.png',
							'thumb_dir' => 'files/attachment/thumb_805805651.png',
							'wiki_page_id' => '2',
							'created' => '2016-05-22 00:06:46'
						)
					)
				),
				(int) 8 => array(
					'WikiPage' => array(
						'id' => '1',
						'title' => 'page1',
						'body' => 'bbbbb',
						'created' => '2016-05-21 21:44:42',
						'modified' => '2016-05-21 21:44:54',
						'category_id' => null,
						'is_public' => true,
						'format' => '0',
						'attachment_id' => null
					),
					'Category' => array(
						'id' => null,
						'parent_id' => null,
						'lft' => null,
						'rght' => null,
						'name' => null,
						'wiki_page_id' => null,
						'is_public' => null
					),
					'Attachment' => array(
						(int) 0 => array(
							'id' => '6',
							'name' => 'Todo',
							'dir' => 'files/attachment/Todo',
							'thumb_dir' => null,
							'wiki_page_id' => '1',
							'created' => '2016-05-22 00:07:24'
						)
					)
				)
			),
			'categoryList' => array(
				(int) 1 => 'category1',
				(int) 2 => '-category2',
				(int) 5 => '--category5',
				(int) 3 => 'category3',
				(int) 4 => '-category4',
				(int) 6 => 'private',
				(int) 7 => '-public',
				(int) 8 => 'empty'
			)
		);

		$this->assertEquals($expected, $results);
    }

/**
 * test of publicIndex() on logout
 *
 * @return void
 */
	public function testIndexLogout() {
		$this->logout();

		// if user is logged out, redirect to users/login
		$results = $this->testAction('/wiki_pages/index',array('method' => 'get', 'return' => 'vars'));
		$expected = array(
			'Location' => $this->base_url . $this->controller->request->base . DS . 'users/login'
		);
		$this->assertEquals($expected, $this->headers);
	}

/**
 * test of view() on logout
 *
 * @return void
 */
    public function testViewLogout() {
		$this->logout();

        $results = $this->testAction('/wiki_pages/view/page2', array('return' => 'vars'));
        //debug($results);
		$expected = array(
			'data' => array(
				'WikiPage' => array(
					'id' => '2',
					'title' => 'page2',
					'body' => 'bbb',
					'created' => '2016-05-21 23:07:17',
					'modified' => '2016-05-21 23:07:17',
					'category_id' => '2',
					'is_public' => true,
					'format' => '0',
					'attachment_id' => null
				),
				'Category' => array(
					'id' => '2',
					'parent_id' => '1',
					'lft' => '2',
					'rght' => '5',
					'name' => 'category2',
					'wiki_page_id' => null,
					'is_public' => true
				),
				'Attachment' => array(
					(int) 0 => array(
						'id' => '4',
						'name' => '797844194.png',
						'dir' => 'files/attachment/797844194.png',
						'thumb_dir' => 'files/attachment/thumb_797844194.png',
						'wiki_page_id' => '2',
						'created' => '2016-05-22 00:06:40'
					),
					(int) 1 => array(
						'id' => '5',
						'name' => '805805651.png',
						'dir' => 'files/attachment/805805651.png',
						'thumb_dir' => 'files/attachment/thumb_805805651.png',
						'wiki_page_id' => '2',
						'created' => '2016-05-22 00:06:46'
					)
				)
			),
			'parents' => array(
				(int) 0 => array(
					'Category' => array(
						'id' => '1',
						'parent_id' => null,
						'lft' => '1',
						'rght' => '6',
						'name' => 'category1',
						'wiki_page_id' => null,
						'is_public' => true
					)
				),
				(int) 1 => array(
					'Category' => array(
						'id' => '2',
						'parent_id' => '1',
						'lft' => '2',
						'rght' => '5',
						'name' => 'category2',
						'wiki_page_id' => null,
						'is_public' => true
					)
				)
			),
			'content_title' => 'page2'
		);

		$this->assertEquals($expected, $results);
		//debug($this->headers);

		// if page is private and user is not logged in, redirect to users/login
		$results = $this->testAction('/wiki_pages/view/page4',array('method' => 'get', 'return' => 'vars'));
		$expected = array(
			'Location' => $this->base_url . $this->controller->request->base . DS . 'users/login'
		);
		$this->assertEquals($expected, $this->headers);
    }

/**
 * test of add() on logout by GET
 *
 * @return void
 */
	public function testAddGetLogout() {
		$this->logout();

		$results = $this->testAction('/wiki_pages/add', array('method' => 'get', 'return' => 'vars'));
		$expected = array(
			'Location' => $this->base_url . $this->controller->request->base . DS . 'users/login'
		);
		$this->assertEquals($expected, $this->headers);
	}

/**
 * test of add() on login by GET
 *
 * @return void
 */
	public function testAddGetLogin() {
		$this->login();

		$results = $this->testAction('/wiki_pages/add', array('method' => 'get', 'return' => 'vars'));
		//debug($results);
		$expected = array(
			'content_title' => null,
			'categoryList' => array(
				(int) 1 => 'category1',
				(int) 2 => '-category2',
				(int) 5 => '--category5',
				(int) 3 => 'category3',
				(int) 4 => '-category4',
				(int) 6 => 'private',
				(int) 7 => '-public',
				(int) 8 => 'empty'
			)
		);
		$this->assertEquals($expected, $results);
	}

/**
 * test of add() on logout by POST
 *
 * @return void
 */
	public function testAddPostLogout() {
		$this->logout();

		// In test environment, the posted article is saved to DB though the user is logged out.
		// But in product environment, Object#_stop() will halt process in AuthComponent.
		$this->WikiPages
			->expects($this->atLeastOnce())
			->method('_stop');

		$this->WikiPages->WikiPage
			->expects($this->once())
			->method('save')
			->will($this->returnValue(true));

		$page = array(
				'WikiPage' => array(
				'is_public' => 1,
				'format' => 0,
				'title' => 'New Article'
			)
		);

		$results = $this->testAction('/wiki_pages/add', array('data' => $page, 'return' => 'vars'));
	}

/**
 * test of add() on login by POST
 *
 * @return void
 */
    public function testAddPostLogin() {
		$this->login();

		$this->WikiPages->WikiPage
			->expects($this->once())
			->method('save')
			->will($this->returnValue(true));

		$page = array(
				'WikiPage' => array(
				'is_public' => 1,
				'format' => 0,
				'title' => 'New Article'
			)
		);

		$results = $this->testAction('/wiki_pages/add',array('data' => $page, 'return' => 'vars'));
		//debug($results);
		$expected = array(
			'content_title' => null,
			'categoryList' => array(
				(int) 1 => 'category1',
				(int) 2 => '-category2',
				(int) 5 => '--category5',
				(int) 3 => 'category3',
				(int) 4 => '-category4',
				(int) 6 => 'private',
				(int) 7 => '-public',
				(int) 8 => 'empty'
			)
		);
		$this->assertEquals($expected, $results);
		$expected = array(
			'Location' => $this->base_url . $this->controller->request->base . DS . 'wiki/New%20Article'
		);
		$this->assertEquals($expected, $this->headers);
    }

/**
 * testFind method
 *
 * @return void
 */
	public function testFind() {
		$this->markTestIncomplete('testFind not implemented.');
	}

/**
 * testPublicFind method
 *
 * @return void
 */
	public function testPublicFind() {
		$this->markTestIncomplete('testPublicFind not implemented.');
	}

/**
 * testChangePagesCategory method
 *
 * @return void
 */
	public function testChangePagesCategory() {
		$this->markTestIncomplete('testChangePagesCategory not implemented.');
	}

/**
 * testEdit method
 *
 * @return void
 */
	public function testEdit() {
		$this->markTestIncomplete('testEdit not implemented.');
	}

/**
 * testDelete method
 *
 * @return void
 */
	public function testDelete() {
		$this->markTestIncomplete('testDelete not implemented.');
	}

/**
 * testRevisions method
 *
 * @return void
 */
	public function testRevisions() {
		$this->markTestIncomplete('testRevisions not implemented.');
	}

/**
 * testViewRevision method
 *
 * @return void
 */
	public function testViewRevision() {
		$this->markTestIncomplete('testViewRevision not implemented.');
	}

/**
 * testViewPrevDiff method
 *
 * @return void
 */
	public function testViewPrevDiff() {
		$this->markTestIncomplete('testViewPrevDiff not implemented.');
	}

/**
 * testViewLatestDiff method
 *
 * @return void
 */
	public function testViewLatestDiff() {
		$this->markTestIncomplete('testViewLatestDiff not implemented.');
	}

/**
 * testPreview method
 *
 * @return void
 */
	public function testPreview() {
		$this->markTestIncomplete('testPreview not implemented.');
	}

/**
 * testBlackhole method
 *
 * @return void
 */
	public function testBlackhole() {
		$this->markTestIncomplete('testBlackhole not implemented.');
	}

/**
 * testAddComment method
 *
 * @return void
 */
	public function testAddComment() {
		$this->markTestIncomplete('testAddComment not implemented.');
	}

}
