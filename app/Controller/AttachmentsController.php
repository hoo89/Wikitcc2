<?php
class AttachmentsController extends AppController{
	public function add($title=null){
		if ($this->request->is('post')) {
            $this->Attachment->create();
            if ($this->Attachment->save($this->request->data)) {
                $this->Session->setFlash('アップロードが完了しました.','alert/success');
                return $this->redirect($this->referer());
            }
            $this->Session->setFlash('アップロードできませんでした.','alert/danger');
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

    public function index() {
        if(!empty($this->request['named']['title'])){
            $post = $this->Attachment->WikiPage->findByTitle($this->request['named']['title']);
            $wiki_page_id = 0;
            if ($post) {
                $wiki_page_id = $post['WikiPage']['id'];
                $this->set('content_title',$post['WikiPage']['title']);
                $this->set('wiki_page_id',$wiki_page_id);
            }
            $attachments = $this->paginate(array('Attachment.wiki_page_id' => $wiki_page_id));
        }else{
            $attachments = $this->paginate();
        }

        if ($this->request->is('requested')) {
            return $attachments;
        } else {
            $this->set('attachments', $attachments);
        }
    }

    public function delete($id) {
        if ($this->Attachment->delete($id)) {
            $this->Session->setFlash('ファイルを削除しました','alert/success');
        } else {
            $this->Session->setFlash('ファイルの削除に失敗しました','alert/danger');
        }
        $this->redirect($this->referer(null,true));
    }
}