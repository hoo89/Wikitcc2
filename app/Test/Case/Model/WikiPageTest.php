<?php
App::uses('WikiPage', 'Model');

class WikiPageTest extends CakeTestCase {
    public $fixtures = array('app.wiki_page','app.category','app.attachment','app.wiki_pages_rev');

    public function setUp() {
        parent::setUp();
        $this->WikiPage = ClassRegistry::init('WikiPage');
    }

    public function testSave(){
    	$this->WikiPage->create();
    	$result = $this->WikiPage->save(
    		array(
                'id' => 100,
    			'title' => 'Same Article',
    			'modified'=>'2014-02-14 10:36:49',
    			'created' => '2014-02-14 10:36:49'
    	));

    	$expected = array(
    		'WikiPage' => array(
                'id' => 100,
    			'is_public' => 1,
    			'format' => 0,
    			'title' => 'Same Article',
    			'modified'=>'2014-02-14 10:36:49',
    			'created' => '2014-02-14 10:36:49'
    	));

    	$this->assertEquals($expected, $result);

        // Same title is not allowed.
    	$this->WikiPage->create();
    	$result = $this->WikiPage->save(array('title' => 'Same Article'));
    	$this->assertEquals(false, $result);

    	$this->WikiPage->create();
    	$result = $this->WikiPage->save(array('title' => 'slash / is not allowed'));
    	$this->assertEquals(false, $result);
    }

    public function testGetRevison(){
    	//First Record
    	$this->WikiPage->create();
    	$this->WikiPage->save(array('id' => 100, 'title' => 'Record', 'body'=>'First Record'));
    	$result = $this->WikiPage->getRevision()->find('all');

 		//Number of revisions equal 1
    	$this->assertEquals(1, count($result));

    	//It contains ...
    	$expected = array('version_id'=> 1, 'id' => 100, 'title' => 'Record', 'body'=>'First Record');
    	$filtered_result = array_intersect_key($result[0]['WikiPage'], $expected);
    	$this->assertEquals($expected, $filtered_result);

    	//Second Record
    	$this->WikiPage->save(array('id' => 100, 'title' => 'Record', 'body'=>'Second Record'));
    	$result = $this->WikiPage->getRevision()->find('all', array('order' => array('version_id' => 'desc')));

    	//Number of revisions equal 2
    	$this->assertEquals(2, count($result));

    	//It contains ...
		$expected = array('version_id'=> 2, 'id' => 100, 'title' => 'Record', 'body'=>'Second Record');
    	$filtered_result = array_intersect_key($result[0]['WikiPage'], $expected);
    	$this->assertEquals($expected, $filtered_result);

    	$expected = array('version_id'=> 1, 'id' => 100, 'title' => 'Record', 'body'=>'First Record');
    	$filtered_result = array_intersect_key($result[1]['WikiPage'], $expected);
    	$this->assertEquals($expected, $filtered_result);
    }
}