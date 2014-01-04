<?php
class AttachmentsController extends AppController{
	public $scaffold;
	public function add($title=null){
		if ($this->request->is('post')) {
            $this->Attachment->create();
            if ($this->Attachment->save($this->request->data)) {
                $this->Session->setFlash(__('アップロードが完了しました.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('アップロードできませんでした.'));
        }
        $wiki_page_id=null;
        if(!empty($title)){
            $post = $this->Attachment->WikiPage->findByTitle($title);
            if ($post) {
                $wiki_page_id = $post['WikiPage']['id'];
                $this->set('content_title',$post['WikiPage']['title']);
            }
        }
        $this->set('wiki_page_id',$wiki_page_id);
	}
}