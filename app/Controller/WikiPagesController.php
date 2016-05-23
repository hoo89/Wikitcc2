<?php
/**
 * WikiPagesController
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 *
 * @copyright	Copyright (c) 2014, hoo89
 * @link		https://github.com/hoo89/Wikitcc2
 * @license		MIT License
 */

App::uses('AppController', 'Controller');

class WikiPagesController extends AppController {
	public $components = array('Search.Prg','RequestHandler','Security' => array('validatePost' => false));

	// for Search Plugin
	public $presetVars = true;

	public $helpers = array('Text');

	// WikiPage order
	var $paginate = array(
		'limit' => 20,
		'order' => array(
			'WikiPage.modified' => 'desc'
		)
	);

	/**
	 * Called before Action.
	 *
	 * @return void
	 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Security->blackHoleCallback = 'blackhole';
		$this->Security->requireAuth('add', 'edit', 'add_comment');

		if ($this->RequestHandler->isRSS()) {
			$this->Auth->authenticate = array('Form', 'Basic');
		}
		$this->Auth->allow('public_index', 'public_find', 'view');

		if ($this->action === 'preview') {
			$this->Security->csrfCheck = false;
		}
	}

	/**
	 * It makes WikiPage index.
	 * If it called from requestAction(), this return array of WikiPages.
	 *
	 * @return array|void
	 */
	public function index() {
		$categoryList = $this->WikiPage->Category->generateTreeList(null,null,null, '-');
		$this->set('categoryList',$categoryList);

		$wikiPages = $this->paginate();
		if ($this->request->is('requested')) {
			return $wikiPages;
		} else {
			$this->set('wikiPages', $wikiPages);
		}
	}

	/**
	 * It makes public WikiPage index for users not logged in.
	 * If it called from requestAction(), this return array of WikiPages.
	 *
	 * @return array|void
	 */
	public function public_index() {
		if($this->Auth->loggedIn()){
			return $this->redirect(array('action'=>'index'));
		}

		$this->paginate['conditions'] = array('WikiPage.is_public' => true);
		$wikiPages = $this->paginate();

		if ($this->request->is('requested')) {
			return $wikiPages;
		} else {
			$this->set('wikiPages', $wikiPages);
			$this->render('index');
		}
	}

	/**
	 * Search action.
	 * If it called from requestAction(), this return array of WikiPages.
	 *
	 * @return array|void
	 */
	public function find(){
		$this->set('title','検索結果');
		$categoryList = $this->WikiPage->Category->generateTreeList(null,null,null, '-');
		$this->set('categoryList',$categoryList);

		App::uses('String', 'Utility');
		$this->Prg->commonProcess();
		$this->paginate['conditions'] = $this->WikiPage->parseCriteria($this->passedArgs);
		$this->set('searchword', $this->request->named);
		$wikiPages = $this->paginate();
		if ($this->request->is('requested')) {
			return $wikiPages;
		} else {
			$this->set('wikiPages', $wikiPages);
			$this->render('index');
		}
	}

	/**
	 * Search action for users not logged in.
	 * If it called from requestAction(), this return array of WikiPages.
	 *
	 * @return array|void
	 */
	public function public_find(){
		if($this->Auth->loggedIn()){
			$this->redirect(array('action'=>'find'));
		}

		$this->set('title','検索結果');

		App::uses('String', 'Utility');
		$this->Prg->commonProcess();
		$this->passedArgs['is_public'] = true;
		$this->paginate['conditions'] = $this->WikiPage->parseCriteria($this->passedArgs);
		$this->set('searchword',$this->request->named);
		$wikiPages = $this->paginate();
		$this->set('wikiPages', $wikiPages);
		if ($this->request->is('requested')) {
			return $wikiPages;
		} else {
			$this->set('wikiPages', $wikiPages);
			$this->render('index');
		}
	}

	/**
	 * Change multiple pages category at once.
	 *
	 * - Example Post data
	 * {'WikiPage'=>{'id'=>{1=>true, 2=>true, 3=>false}, 'category_id'=> 1}
	 * Change 1 and 2 page's category_id to 1
	 *
	 * @return void
	 */
	function changePagesCategory(){
		if ($this->request->is('post')) {
			foreach ($this->request->data['WikiPage']['id'] as $id => $selected) {
				if ($selected){
					$this->WikiPage->save(array('id'=>$id,'category_id'=>$this->request->data['WikiPage']['category_id'],'modified'=>false));
				}
			}
			$this->setFlash('カテゴリーを変更しました','alert/success');
			$this->redirect($this->referer(null,true));
		}
	}

	/**
	 * WikiPage View
	 *
	 * @param string $title
	 * @return void
	 * @throws NotFoundException
	 */
	public function view($title = null) {
		$this->set('content_title', $title);
		$this->helpers[] = 'WikitccParse';
		if (!$title) {
			throw new NotFoundException('ページが見つかりません');
		}

		$post = $this->WikiPage->findByTitle($title);
		if (!$post) {
			throw new NotFoundException('ページが見つかりません');
		}

		if(!$this->Auth->loggedIn() && !$post['WikiPage']['is_public']){
			$this->Session->write('Auth.redirect', Router::url(null, true));
			$this->Session->setFlash('そのページを表示するにはログインが必要です','alert/danger');
			$this->redirect(array('controller'=>'users', 'action'=>'login'));
		}

		$this->set('parents', $this->WikiPage->Category->getPath($post['Category']['id']));
		$this->set('data', $post);
	}

	/**
	 * Add WikiPage
	 * If posted WikiPage, create page and redirect created one.
	 *
	 * @return void
	 */
	public function add() {
		$categoryList = $this->WikiPage->Category->generateTreeList(null,null,null, '-');
		$this->set('categoryList',$categoryList);
		$this->set('content_title', null);

		if ($this->request->is('post')) {
			$this->WikiPage->create();
			if ($this->WikiPage->save($this->request->data)) {
				$this->Session->setFlash('ページが作成されました','alert/success');
				return $this->redirect(array('action' => 'view',$this->request->data['WikiPage']['title']));
			}
			$this->Session->setFlash('ページを作成できませんでした','alert/danger');
		}
	}

	/**
	 * Edit WikiPage
	 * If posted WikiPage, update page and redirect updated one.
	 *
	 * @param string $title
	 * @return void
	 * @throws NotFoundException
	 */
	public function edit($title = null) {
		$categoryList = $this->WikiPage->Category->generateTreeList(null,null,null, '-');
		$this->set('content_title', $title);
		$this->set('categoryList',$categoryList);

		$post = $this->WikiPage->findByTitle($title);
		if (!$post) {
			throw new NotFoundException('ページが見つかりません');
		}
		$this->set('post', $post);

		if ($this->request->is(array('post', 'put'))) {
			$this->WikiPage->id = $post['WikiPage']['id'];

			if ($this->WikiPage->save($this->request->data)) {
				$this->Session->setFlash('ページが更新されました','alert/success');
				return $this->redirect(array('action' => 'view',$post['WikiPage']['title']));
			}
			$this->Session->setFlash('ページを更新できませんでした','alert/danger');
		}

		//for setting form default value
		if (!$this->request->data) {
			$this->request->data = $post;
		}
		$this->render('add');
	}

	/**
	 * Delete WikiPage
	 *
	 * @param string $title
	 * @return void
	 * @throws NotFoundException MethodNotAllowedException
	 */
	public function delete($title = null) {
		if ($this->request->is('get')) {
			throw new MethodNotAllowedException();
		}

		$post = $this->WikiPage->findByTitle($title);
		if (!$post){
			throw new NotFoundException('ページが見つかりません');
		}
		$id=$post['WikiPage']['id'];

		if ($this->WikiPage->delete($id)) {
			$this->Session->setFlash('ページ： '.h($title).'を削除しました','alert/success');
			return $this->redirect(array('action' => 'index'));
		}
	}

	public function revisions($title=null){
		$post = $this->WikiPage->findByTitle($title);
		if (!$post){
			throw new NotFoundException('ページが見つかりません');
		}
		$this->WikiPage->id = $post['WikiPage']['id'];
		$revisions = $this->paginate($this->WikiPage->getRevision(), array('id'=>$this->WikiPage->id));
		$this->set('wikiPages',$revisions);
		$this->set('content_title',$post['WikiPage']['title']);
	}

	public function view_revision($version_id){
		$post = $this->WikiPage->getRevision()->findByVersionId($version_id);
		$this->set('post',$post);
	}

	public function view_prev_diff($version_id){
		$old = $this->WikiPage->getRevision()->findByVersionId($version_id);
		$this->WikiPage->id = $old['WikiPage']['id'];
		$diff = $this->WikiPage->diff(null, $version_id, array('limit'=>2));
		$this->set('diff',$diff);
	}

	public function view_latest_diff($version_id){
		$old = $this->WikiPage->getRevision()->findByVersionId($version_id);
		$current = $this->WikiPage->findById($old['WikiPage']['id']);
		$diff = array_merge_recursive($current, $old);
		$this->set('diff',$diff);
		$this->render('view_prev_diff');
	}

	public function preview(){
		if ($this->RequestHandler->isAjax()) {
			$this->set('body',$this->request->data['body']);
		}
	}

	/**
	 * blackhole method for SecurityComponent
	 */
	public function blackhole($type){
		switch($type){
			case 'csrf' :
				$this->Session->setFlash('送信できませんでした.セッションがタイムアウトした可能性があります.もう一度再読み込みしてやり直してください',
					'alert/warning');
				$this->redirect(array('action' => $this->action));
				break;
			default :
				$this->redirect(array('action' => 'index'));
				break;
		}
	}

	public function add_comment(){
		if ($this->request->is('post')) {
			$post = $this->WikiPage->findById($this->request->data['WikiPage']['id']);
			if (!$post) {
				throw new NotFoundException('ページが見つかりません');
			}
			$this->WikiPage->id = $post['WikiPage']['id'];
			$content = $post['WikiPage']['body'];
			$name = h($this->request->data['WikiPage']['name']);
			$message = ereg_replace("\n|\r",'',nl2br(h($this->request->data['WikiPage']['comment']), false));
			if (empty($name)){
				$name = "名無しさん";
			}
			$wiki_comment = "*$message - $name\n";
			$content = str_replace('{{comment}}', $wiki_comment.'{{comment}}', $content);
			$post['WikiPage']['body'] = $content;

			if ($this->WikiPage->save($post)) {
				$this->Session->setFlash('ページが更新されました','alert/success');
				return $this->redirect(array('action' => 'view',$post['WikiPage']['title']));
			}else{
				$this->Session->setFlash('ページを更新できませんでした','alert/danger');
			}
		}
	}
}
