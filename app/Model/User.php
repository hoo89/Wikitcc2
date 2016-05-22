<?php
/**
 * User
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 *
 * @copyright	Copyright (c) 2014, hoo89
 * @link		https://github.com/hoo89/Wikitcc2
 * @license		MIT License
 */

App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
class User extends AppModel {
	public $validate = array(
		'username' => array(
			'least1' => array(
				'rule' => array('custom', '/[a-zA-Z0-9\'.\\\s]{1,}$/i'),
				'message' => 'ユーザ名には1文字以上の半角英数字が必要です.'
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'このユーザ名は既に使われています.'
			)
		),
		'password' => array(
			'least4' => array(
				'rule' => array('custom', '/[a-zA-Z0-9\'.\\\s]{4,}$/i'),
				'message' => 'パスワードには4文字以上の半角英数字が必要です.'
			)
		)
	);

	public function beforeSave($options = array()) {
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new SimplePasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
		}
		return true;
	}
}
