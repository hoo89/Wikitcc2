<?php
/**
 * WikiPage
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * 
 * @copyright	Copyright (c) 2014, hoo89
 * @link		https://github.com/hoo89/Wikitcc2
 * @license		MIT License
 */

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

	private $limit_revisions = 100;

	public function getRevision(){
		if(empty($this->revision)){
			$this->Behaviors->load('Revision',array('limit'=>$this->limit_revisions));
			$this->revision = $this->ShadowModel;
		}

		return $this->revision;
	}
}
