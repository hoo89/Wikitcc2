<?php
class CategoriesController extends AppController {
	public $helpers = array('Tree');
	public $components = array('Security');

	var $paginate = array(
		'limit' => 20,
		'order' => array(
			'Category.lft',
			'WikiPage.modified' => 'desc'
		)
	);

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Security->requireAuth('add','edit','delete');
		$this->Auth->allow('index', 'public_index', 'view', 'public_view');
	}

	public function index() {
		if(!$this->Auth->loggedIn()){
			$this->redirect(array('action' => 'public_index'));
		}

		$categories = $this->Category->find('threaded', array( 
			'order' => array('Category.lft')) 
		);

		$top_pages = $this->Category->WikiPage->findAllByCategoryId(null);
		
		if ($this->request->is('requested')) {
			return $categories;
		} else {
			$this->set('categories',$categories);
			$this->set('top_pages',$top_pages);
		}
	}

	public function add() {
		return $this->edit();
	}

	public function delete($id) {
		if($this->request->isDelete()) {
			if ($this->Category->delete($id)) {
				$this->Session->setFlash('カテゴリーを削除しました','alert/success');
			} else {
				$this->Session->setFlash('カテゴリーの削除に失敗しました','alert/danger');
			}
			$this->redirect(array('action'=> 'index'));
		}

		$this->request->data = $this->Category->findById($id);
		if (empty($this->request->data)) {
			$this->Session->setFlash('カテゴリーが見つかりませんでした','alert/warning');
			$this->redirect(array('action'=> 'index'));
		}

		$deleteCategoryList = $this->Category->children($id);
		$this->set('deleteCategoryList',$deleteCategoryList);
	}

	public function edit($id = null) {
		if ($this->request->isPost() || $this->request->isPut()) {
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash('カテゴリーを保存しました','alert/success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('カテゴリーを保存できませんでした','alert/danger');
			}
		} else {
			if ($id != null) {
				$this->request->data = $this->Category->findById($id);
				if (empty($this->request->data)) {
					$this->Session->setFlash('カテゴリーが見つかりませんでした','alert/warning');
					$this->redirect(array('action'=> 'index'));
				}
			}
		}

		$categoryList = $this->Category->generateTreeList(null, null, null, '-');
		$this->set('categoryList',$categoryList);

		$this->render('edit');
	}

	public function movedown($id = null, $delta = null) {

		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}

		if ($delta > 0) {
			$this->Category->moveDown($this->Category->id, abs($delta));
		} else {
			$this->Session->setFlash('入力に間違いがあります。','alert/warning');
		}

		$this->redirect(array('action' => 'edit_view'), null, true);

	}


	public function moveup($id = null, $delta = null) {

		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException('Invalid category');
		}

		if ($delta > 0) {
			$this->Category->moveUp($this->Category->id, abs($delta));
		} else {
			$this->Session->setFlash('入力に間違いがあります。','alert/warning');
		}

		$this->redirect(array('action' => 'edit_view'), null, true);

	}

	public function edit_view(){
		$categories = $this->Category->find('threaded', array( 
			'order' => array('Category.lft')) 
		);
		
		$this->set('categories',$categories);
	}

	public function public_index(){
		if($this->Auth->loggedIn()){
			$this->redirect(array('action' => 'index'));
		}

		$categories = $this->Category->find(
			'threaded', array(
				'conditions' => array('Category.is_public' => true),
				'order' => array('Category.lft')
			)
		);

		$top_pages = $this->Category->WikiPage->find(
			'all',array('conditions' => array(
					'WikiPage.category_id' => null,
					'WikiPage.is_public' => true
				)
			)
		);

		$this->set('categories',$categories);
		$this->set('top_pages',$top_pages);
	}

	public function view($id = null){
		if(!$this->Auth->loggedIn()){
			$this->redirect(array('action' => 'public_view', $id));
		}

		$this->Category->id = $id;
		if ($this->Category->exists()) {
			$a = $this->Category->findById($id);
			$this->set('title','カテゴリー： '.$a['Category']['name']);
		}

		$categoryList = $this->Category->generateTreeList(null,null,null, '-');
		$this->set('categoryList',$categoryList);
		if ($this->request->is('post') && array_key_exists('id',$this->request->data['WikiPage'])){
			foreach ($this->request->data['WikiPage']['id'] as $wiki_id => $selected) {
				if($selected){
					$this->Category->WikiPage->save(array('id'=>$wiki_id,'category_id'=>$this->request->data['WikiPage']['category_id'],'modified'=>false));
				}
			}
		}

		$category_ids = $this->Category->children($id,false,'id');
		$ids = array_map(function($item){return $item['Category']['id'];},$category_ids);
		$ids[] = $id;
		$wikiPages = $this->paginate('WikiPage',array('category_id'=>$ids));
		$this->set('wikiPages', $wikiPages);
		$this->set('searchword',$id);
		$this->render('/WikiPages/index');
	}

	public function public_view($id = null){
		if($this->Auth->loggedIn()){
			$this->redirect(array('action' => 'view', $id));
		}

		$this->Category->id = $id;
		if ($this->Category->exists()) {
			$a = $this->Category->findById($id);
			if(!$a['Category']['is_public']){
				throw new ForbiddenException('ログインが必要です');
			}
			$this->set('title','カテゴリー： '.$a['Category']['name']);
		}
		$category_ids = $this->Category->children($id);
		$ids = array_map(function($item){if($item['Category']['is_public']) return $item['Category']['id'];},$category_ids);
		$ids[] = $id;
		$wikiPages = $this->paginate('WikiPage',array('WikiPage.category_id'=>$ids,'WikiPage.is_public'=>true));
		$this->set('wikiPages', $wikiPages);
		$this->set('searchword',$id);
		$this->render('/WikiPages/index');
	}
}
