<?php
App::uses('AppController', 'Controller');

class WikiPagesController extends AppController {
	public $components = array('Search.Prg','RequestHandler','Security' => array('validatePost' => false));
	public $presetVars = true;

	var $paginate = array(
		'limit' => 20,
		'order' => array(
			'WikiPage.modified' => 'desc'
		)
	);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Security->blackHoleCallback = 'blackhole';
		$this->Security->requireAuth('add', 'edit', 'add_comment');

		if ($this->RequestHandler->isRSS()){
			$this->Auth->authenticate = array('Form','Basic');
		}
		$this->Auth->allow('public_find','view','public_index');
		if ($this->action === 'view'){
			$title = $this->request->params['pass'][0];
			if (!$this->WikiPage->isPublic($title)){
				$this->Auth->deny('view');
			}
		}
		if ($this->action === 'find'||$this->action === 'public_find'||$this->action === 'preview'){
			$this->Security->csrfCheck = false;
		}
	}

	public function index() {
		$categoryList = $this->WikiPage->Category->generateTreeList(null,null,null, '-');
		$this->set('categoryList',$categoryList);
		if ($this->request->is('post') && !$this->request->is('requested')){
			foreach ($this->request->data['WikiPage']['id'] as $id => $selected) {
				if ($selected){
					$this->WikiPage->save(array('id'=>$id,'category_id'=>$this->request->data['WikiPage']['category_id'],'modified'=>false));
				}
			}
		}

		$wikiPages = $this->paginate();
		if ($this->request->is('requested')) {
			return $wikiPages;
		} else {
			$this->set('wikiPages', $wikiPages);
		}
	}

	public function public_index() {
		$this->paginate['conditions'] = array('WikiPage.is_public'=>true);
		$wikiPages = $this->paginate();
		if ($this->request->is('requested')) {
			return $wikiPages;
		} else {
			$this->set('wikiPages', $wikiPages);
			$this->render('index');
		}
	}

	public function find(){
		$this->set('title','検索結果');
		$categoryList = $this->WikiPage->Category->generateTreeList(null,null,null, '-');
		$this->set('categoryList',$categoryList);
		if ($this->request->is('post') && array_key_exists('id',$this->request->data['WikiPage'])){
			foreach ($this->request->data['WikiPage']['id'] as $id => $selected) {
				if ($selected){
					$this->WikiPage->save(array('id'=>$id,'category_id'=>$this->request->data['WikiPage']['category_id'],'modified'=>false));
				}
			}
		}

		$this->Prg->commonProcess();
		$this->paginate['conditions'] = $this->WikiPage->parseCriteria($this->passedArgs);
		$this->set('searchword',$this->request->named);
		$posts = $this->paginate();
		if ($this->request->is('requested')) {
			return $posts;
		} else {
			$this->set('wikiPages', $posts);
			$this->render('index');
		}
	}

	public function public_find(){
		$this->set('title','検索結果');
		$this->Prg->commonProcess();
		$this->passedArgs['is_public'] = 1;
		$this->paginate['conditions'] = $this->WikiPage->parseCriteria($this->passedArgs);
		$this->set('searchword',$this->request->named);
		$posts = $this->paginate();
		$this->set('posts', $posts);
		if ($this->request->is('requested')) {
			return $posts;
		} else {
			$this->set('wikiPages', $posts);
			$this->render('index');
		}
	}

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
		$this->set('parents', $this->WikiPage->Category->getPath($post['Category']['id']));
		$this->set('data', $post);
	}

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
			if ($post){
				$this->WikiPage->id = $post['WikiPage']['id'];
			}
			if ($this->WikiPage->save($this->request->data)) {
				if ($post){
					$this->Session->setFlash('ページが更新されました','alert/success');
				} else {
					$this->Session->setFlash('ページが作成されました','alert/success');
				}
				return $this->redirect(array('action' => 'view',$post['WikiPage']['title']));
			}
			if ($post){
				$this->Session->setFlash('ページを更新できませんでした','alert/danger');
			} else {
				$this->Session->setFlash('ページを作成できませんでした','alert/danger');
			}
		}

		//フォームのデフォルト値をここで設定
		if (!$this->request->data) {
			$this->request->data = $post;
		}
		$this->render('add');
	}

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

	public function add_comment(){
		if ($this->request->is('post')) {
			$post = $this->WikiPage->findById($this->request->data['WikiPage']['id']);
			if (!$post) {
				throw new NotFoundException('ページが見つかりません');
			}            
			$this->WikiPage->id = $post['WikiPage']['id'];
			$content = $post['WikiPage']['body'];
			$name = h($this->request->data['WikiPage']['name']);
			$message = nl2br(h($this->request->data['WikiPage']['comment']));
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

	public function revisions($title=null){
		$this->WikiPage->Behaviors->load('Revision',array('limit'=>$this->WikiPage->limit_revisions));

		$post = $this->WikiPage->findByTitle($title);
		if (!$post){
			throw new NotFoundException('ページが見つかりません');
		}
		$this->WikiPage->id = $post['WikiPage']['id'];
		$revisions = $this->paginate('WikiPage.ShadowModel',array('id'=>$this->WikiPage->id));
		$this->set('wikiPages',$revisions);
		$this->set('content_title',$post['WikiPage']['title']);
	}

	public function view_revision($version_id){
		$this->WikiPage->Behaviors->load('Revision',array('limit'=>$this->WikiPage->limit_revisions));

		$post = $this->WikiPage->ShadowModel->findByVersionId($version_id);
		$this->set('post',$post);
	}

	public function view_prev_diff($version_id){
		$this->WikiPage->Behaviors->load('Revision',array('limit'=>$this->WikiPage->limit_revisions));

		$old = $this->WikiPage->ShadowModel->findByVersionId($version_id);
		$this->WikiPage->id = $old['WikiPage']['id'];
		$diff = $this->WikiPage->diff(null,$version_id,array('limit'=>2));
		$this->set('diff',$diff);
	}
	
	public function view_latest_diff($version_id){
		$this->WikiPage->Behaviors->load('Revision',array('limit'=>$this->WikiPage->limit_revisions));

		$old = $this->WikiPage->ShadowModel->findByVersionId($version_id);
		$current = $this->WikiPage->findById($old['WikiPage']['id']);
		$diff = array_merge_recursive($current, $old);
		$this->set('diff',$diff);
		$this->render('view_prev_diff');
	}

	public function preview(){
		$this->log($this->request->data);

		$this->set('body',$this->request->data['body']);
	}

	/**
	 * blackhole
	 * - for SecurityComponent
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
}
