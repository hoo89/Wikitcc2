<?php
class CategoriesController extends AppController {
	public $helpers = array('Tree');
    public function index() {
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
				$this->Session->setFlash('カテゴリーを削除しました.');
			} else {
				$this->Session->setFlash('カテゴリーの削除に失敗しました.');
			}
			$this->redirect(array('action'=> 'index'));
		}

		$this->request->data = $this->Category->findById($id);
		if (empty($this->request->data)) {
			$this->Session->setFlash('カテゴリーが見つかりませんでした.');
			$this->redirect(array('action'=> 'index'));
		}

		$deleteCategoryList = $this->Category->children($id);
		$this->set('deleteCategoryList',$deleteCategoryList);
	}


	public function edit($id = null) {
		if ($this->request->isPost() || $this->request->isPut()) {
			if ($this->Category->save($this->request->data)) {
				$this->Session->setFlash('カテゴリーを保存しました.');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('入力に間違いがあります.');
			}
		} else {
			if ($id != null) {
				$this->request->data = $this->Category->findById($id);
				if (empty($this->request->data)) {
					$this->Session->setFlash('カテゴリーが見つかりませんでした.');
					$this->redirect(array('action'=> 'index'));
				}
			}

		}

		$categoryList = $this->Category->generateTreeList(null, null, null, '-');
		$this->set('categoryList',$categoryList);

		$this->render('edit');
	}
}