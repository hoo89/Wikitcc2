<?php
/**
 * AttachmentsController
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 *
 * @copyright	Copyright (c) 2014, hoo89
 * @link		https://github.com/hoo89/Wikitcc2
 * @license		MIT License
 */

class AttachmentsController extends AppController{

/**
 * Add Attachment
 * If posted Attachment, upload and create Attachment, then redirect previous page.
 *
 * @param string @title
 * @return void
 */
	public function add($title = null) {
		if ($this->request->is('post')) {
			$this->Attachment->create();
			if ($this->Attachment->save($this->request->data)) {
				$this->Session->setFlash('アップロードが完了しました.', 'alert/success');
				return $this->redirect($this->referer());
			}
			$this->Session->setFlash('アップロードできませんでした.', 'alert/danger');
		}

		$wikiPageId = null;
		if (!empty($title)){
			$post = $this->Attachment->WikiPage->findByTitle($title);
			if ($post) {
				$wikiPageId = $post['WikiPage']['id'];
				$this->set('content_title', $post['WikiPage']['title']);
			}
		}
		$this->set('wiki_page_id', $wikiPageId);
	}

/**
 * Show Attachments
 * If it called from requestAction(), this return array of Attachments.
 * If named paramater 'title' given, add condition 'wiki_pages.title = [title] AND attachments.wiki_page_id = wiki_pages.id'
 *
 * @return array|void
 */
	public function index() {
		if (!empty($this->request['named']['title'])){
			$post = $this->Attachment->WikiPage->findByTitle($this->request['named']['title']);
			$wikiPageId = 0;

			if ($post) {
				$wikiPageId = $post['WikiPage']['id'];
				$this->set('content_title', $post['WikiPage']['title']);
				$this->set('wiki_page_id', $wikiPageId);
			}
			$attachments = $this->paginate(array('Attachment.wiki_page_id' => $wikiPageId));
		} else {
			$attachments = $this->paginate();
		}

		if ($this->request->is('requested')){
			return $attachments;
		} else {
			$this->set('attachments', $attachments);
		}
	}

/**
 * Delete Attachment
 *
 * @param string @id
 */
	public function delete($id) {
		if ($this->Attachment->delete($id)){
			$this->Session->setFlash('ファイルを削除しました', 'alert/success');
		} else {
			$this->Session->setFlash('ファイルの削除に失敗しました', 'alert/danger');
		}
		$this->redirect($this->referer(null, true));
	}
}
