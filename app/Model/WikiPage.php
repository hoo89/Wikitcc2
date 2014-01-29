<?php
class WikiPage extends AppModel {
	public $validate = array(
		'title' => array(
			array('rule' => 'notEmpty'),
			array('rule' => array('custom', '/^[^\\/]*$/u'),'message' => '/はタイトルに使えません.'),
			array('rule' => 'isUnique','message' => 'このタイトルは既に使われています')
		)
	);

	public $belongsTo = 'Category';
	public $hasMany = 'Attachment';

	public function beforeSave($options = array()) {
		$this->Behaviors->load('Revision',array('limit'=>$this->limit_revisions));
		return true;
	}

	public $actsAs = array('Search.Searchable');
	public $filterArgs = array(
		'title' => array('type' => 'like'),
		'body' => array('type' => 'like'),
		'keyword' => array('type' => 'like', 'field' => array('WikiPage.title', 'WikiPage.body'),'connectorAnd' => ' ', 'connectorOr' => ','),
		'is_public' => array('type' => 'value')
	);
	public function isPublic($title){
		$post = $this->findByTitle($title);
		if(!$post) return true;
		return $post['WikiPage']['is_public'];
	}

	private $limit_revisions = 100;
}
