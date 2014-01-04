<?php
class WikiPagesController extends AppController {
    public $components = array('Search.Prg');
    public $presetVars = true;

    public function index() {
        $this->Prg->commonProcess();
        $this->paginate = array(
            'conditions' => $this->WikiPage->parseCriteria($this->passedArgs),
        );
        
        $posts = $this->paginate();
        if ($this->request->is('requested')) {
            return $posts;
        } else {
            $this->set('posts', $posts);
        }
    }
    public function view($title = null) {
        $this->helpers[] = 'WikitccParse';
        if (!$title) {
            throw new NotFoundException(__('ページが見つかりません'));
        }

        $post = $this->WikiPage->findByTitle($title);
        if (!$post) {
            throw new NotFoundException(__('ページが見つかりません'));
        }
        $this->set('parents', $this->WikiPage->Category->getPath($post['Category']['id']));
        $this->set('content_title', $post['WikiPage']['title']);
        $this->set('post', $post);
    }
    public function add() {
        $categoryList = $this->WikiPage->Category->generateTreeList(array('is_leaf' => false),null,null, '-');
        $this->set('categoryList',$categoryList);
        $this->set('content_title', null);

        if ($this->request->is('post')) {
            $this->WikiPage->create();
            if ($this->WikiPage->save($this->request->data)) {
                $this->Session->setFlash(__('ページが作成されました.'));
                return $this->redirect(array('action' => 'view',h($this->request->data['WikiPage']['title'])));
            }
            $this->Session->setFlash(__('ページを作成できませんでした.'));
        }
    }
    public function edit($title = null) {
        $categoryList = $this->WikiPage->Category->generateTreeList(array('is_leaf' => false),null,null, '-');
        $this->set('content_title', $title);
        $this->set('categoryList',$categoryList);
        if (!$title) {
            throw new NotFoundException(__('ページが見つかりません'));
        }
        $post = $this->WikiPage->findByTitle($title);
        if (!$post) {
            throw new NotFoundException(__('ページが見つかりません'));
        }
        $this->set('post', $post);

        if ($this->request->is(array('post', 'put'))) {
            $this->WikiPage->id = $post['WikiPage']['id'];
            if ($this->WikiPage->save($this->request->data)) {
                $this->Session->setFlash(__('ページが更新されました.'));
                return $this->redirect(array('action' => 'view',$post['WikiPage']['title']));
            }
            $this->Session->setFlash(__('ページを更新できませんでした.'));
        }

        if (!$this->request->data) {
            $this->request->data = $post;
        }
    }
    public function delete($title = null) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }

        $post = $this->WikiPage->findByTitle($title);
        if(!$post){
            $this->Session->setFlash(__('削除するページが見つかりません', h($title)));
            return $this->redirect(array('action' => 'index'));
        }
        $id=$post['WikiPage']['id'];

        if ($this->WikiPage->delete($id)) {
            $this->Session->setFlash(__('ページ： %s を削除しました', h($title)));
            return $this->redirect(array('action' => 'index'));
        }
    }
    public function add_comment(){
        if ($this->request->is('post')) {
            $post = $this->WikiPage->findById($this->request->data['WikiPage']['id']);
            if (!$post) {
                $this->Session->setFlash(__('ページが見つかりません'));
                return $this->redirect(array('action' => 'index'));
            }            
            $this->WikiPage->id = $post['WikiPage']['id'];
            $content = $post['WikiPage']['body'];
            $name = h($this->request->data['WikiPage']['name']);
            $message = h($this->request->data['WikiPage']['comment']);
            if(empty($name)){
                $name = "名無しさん";
            }
            $wiki_comment = "*$message - $name\n";
            $content = str_replace('{{comment}}', $wiki_comment.'{{comment}}', $content);
            $post['WikiPage']['body'] = $content;

            if ($this->WikiPage->save($post)) {
                $this->Session->setFlash(__('ページが更新されました'));
                return $this->redirect(array('action' => 'view',$post['WikiPage']['title']));
            }else{
                $this->Session->setFlash(__('ページを更新できませんでした'));
            }
        }
    }
}
