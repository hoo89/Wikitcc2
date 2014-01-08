<?php
class CategoriesController extends AppController {
	public $helpers = array('Tree');

	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'public_index');
	}

    public function index() {
    	if(!$this->Auth->loggedIn()){
    		$this->redirect(array('action' => 'public_index'), null, true);
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
				$this->Session->setFlash('カテゴリーを削除しました');
			} else {
				$this->Session->setFlash('カテゴリーの削除に失敗しました');
			}
			$this->redirect(array('action'=> 'index'));
		}

		$this->request->data = $this->Category->findById($id);
		if (empty($this->request->data)) {
			$this->Session->setFlash('カテゴリーが見つかりませんでした');
			$this->redirect(array('action'=> 'index'));
		}

		$deleteCategoryList = $this->Category->children($id);
		$this->set('deleteCategoryList',$deleteCategoryList);
	}


	public function edit($id = null) {
		if ($this->request->isPost() || $this->request->isPut()) {
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash('カテゴリーを保存しました');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('カテゴリーを保存できませんでした');
			}
		} else {
			if ($id != null) {
				$this->request->data = $this->Category->findById($id);
				if (empty($this->request->data)) {
					$this->Session->setFlash('カテゴリーが見つかりませんでした');
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
			$this->Session->setFlash('入力に間違いがあります。');
		}

		$this->redirect(array('action' => 'edit_view'), null, true);

	}


	public function moveup($id = null, $delta = null) {

		$this->Category->id = $id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid category'));
		}

		if ($delta > 0) {
			$this->Category->moveUp($this->Category->id, abs($delta));
		} else {
			$this->Session->setFlash('入力に間違いがあります。');
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
}
