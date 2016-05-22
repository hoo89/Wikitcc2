<?php
/**
 * User Fixture
 */
class UserFixture extends CakeTestFixture {

/**
 * Import
 *
 * @var array
 */
	public $import = array('model' => 'User', 'connection' => 'test');

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'username' => 'aaaaa',
			'password' => '8ab73ccac16d8816136b3bc18da244b2c830ed00',
			'created' => '2016-05-21 21:44:13',
			'modified' => '2016-05-21 21:44:13'
		),
	);

}
