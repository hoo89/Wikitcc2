<?php
App::uses('User', 'Model');

/**
 * User Test Case
 */
class UserTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.user'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->User = ClassRegistry::init('User');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->User);

		parent::tearDown();
	}

/**
 * test save()
 *
 * @return void
 */
    public function testSave(){
		Configure::write('Security.salt', 'aaaaa');

		$sample = array(
			'username' => 's',
			'password' => 'aaaa',
			'created' => '2016-05-21 21:44:13',
			'modified' => '2016-05-21 21:44:13'
		);

    	$this->User->create();
    	$result = $this->User->save($sample);

    	$expected = array(
			'User' => 	array(
						'id' => '1',
						'username' => 's',
						// salted password
						'password' => '2882f38e575101ba615f725af5e59bf2333a9a68',
						'created' => '2016-05-21 21:44:13',
						'modified' => '2016-05-21 21:44:13'
			)
    	);

		// Confirm the sample user is created.
    	$this->assertEquals($expected, $result);

		$this->User->set('username', 'modified');
		$result = $this->User->save();
		$this->assertTrue($result !== false);
		$this->assertEquals('1', $this->User->id);
		$result = $this->User->findById(1);
		$this->assertEquals('modified', $result['User']['username']);


		$sample2 = array(
			'username' => '_',
			'password' => '----',
			'created' => '2016-05-21 21:44:13',
			'modified' => '2016-05-21 21:44:13'
		);

		$this->User->create();
		$result = $this->User->save($sample2);

		$expected2 = array(
			'User' => 	array(
						'id' => '2',
						'username' => '_',
						// salted password
						'password' => 'b9a366c52a9ef762ef16aa5f9f0882ffdb65f3bd',
						'created' => '2016-05-21 21:44:13',
						'modified' => '2016-05-21 21:44:13'
			)
		);

		// Confirm the sample user is created.
		$this->assertEquals($expected2, $result);

        // Same username is not allowed.
    	$this->User->create();
    	$result = $this->User->save($sample2);
    	$this->assertEquals(false, $result);

		// Empty username is not allowed.
    	$this->User->create();
		$sample['username']='';
		$result = $this->User->save($sample);
    	$this->assertEquals(false, $result);

		// The password needs 4 length at least.
		$this->User->create();
		$sample['username']='s2';
		$sample['password']='aaa';
		$result = $this->User->save($sample);
    	$this->assertEquals(false, $result);

		// Invalid username is not allowed.
		$this->User->create();
		$sample['username']='/a';
		$result = $this->User->save($sample);
		$this->assertEquals(false, $result);
    }

}
