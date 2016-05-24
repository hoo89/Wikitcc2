<?php
/**
 * UsersController
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 *
 * @copyright	Copyright (c) 2014, hoo89
 * @link		https://github.com/hoo89/Wikitcc2
 * @license		MIT License
 */

class UsersController extends AppController {

	public $scaffold;

	public $components = array(
		'Auth' => array(
			'authenticate' => array(
				'Form' => array(
					'passwordHasher' => 'Simple',
					'fields' => array('username', 'password')
				)
			)
	));

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('login');
	}

	public function isAuthorized($user) {
		if($this->action === 'logout'){
			return parent::isAuthorized();
		}
		return false;
	}

	public function login() {
		App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
		if ($this->request->is('post')) {
			if ($this->Auth->login()) {
				$this->Session->write('name', $this->Auth->user('username'));
				$this->redirect($this->Auth->redirectUrl());
			} else {
				$this->Session->setFlash('ユーザ名かパスワードが間違っています.', 'alert/danger');
				$this->redirect(array('action' => 'login'));
			}
		}else{
			$url = $this->Auth->redirectUrl();
			if($url === '/'){
				$url = $this->referer(null, true);
			}
			$this->Session->write('Auth.redirect', $url);
		}
	}

	public function logout() {
		$this->Session->delete('name');
		$this->redirect($this->Auth->logout());
	}

	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException('不正なユーザ名');
		}
		$this->set('user', $this->User->read(null, $id));
	}

	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('ユーザが作成されました.');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('ユーザが作成できませんでした.');
			}
		}
	}

	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException('不正なユーザ名');
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash('ユーザが更新されました.');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('ユーザの更新ができませんでした.');
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
			unset($this->request->data['User']['password']);
		}
	}

	public function delete($id = null) {
		$this->request->onlyAllow('post');

		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException('不正なユーザ名');
		}
		if ($this->User->delete()) {
			$this->Session->setFlash('ユーザは削除されました.');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('ユーザの削除ができませんでした.');
		$this->redirect(array('action' => 'index'));
	}

}
