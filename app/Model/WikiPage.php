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

/**
 * バリデーションルール
 *
 * @var array
 */
	public $validate = array(
		'title' => array(
			array('rule' => 'notBlank'),
			array('rule' => array('custom', '/^[^\\/]*$/u'), 'message' => '/はタイトルに使えません.'),
			array('rule' => 'isUnique', 'message' => 'このタイトルは既に使われています')
		)
	);

/**
 * WikiPage belongs to Category
 *
 * @var string
 */
	public $belongsTo = 'Category';

/**
 * WikiPage has many Attachments
 *
 * @var string
 */
	public $hasMany = 'Attachment';

/**
 * RevisionBehaviorが残す履歴の最大数
 *
 * @var int
 */
	private $limit_revisions = 100;

/**
 * SearchableBehaviorの検索条件指定
 *
 * @var array
 */
	public $filterArgs = array(
		'title' => array('type' => 'like'),
		'body' => array('type' => 'like'),
		'keyword' => array('type' => 'like', 'field' => array('WikiPage.title', 'WikiPage.body'), 'connectorAnd' => ' ', 'connectorOr' => ','),
		'is_public' => array('type' => 'value')
	);

/**
 * SearchableBehavior
 *
 * @var array
 */
	public $actsAs = array('Search.Searchable');

/**
 * 保存前にRevisionBehaviorを動的に読み込む
 *
 * @param array $options
 * @return bool
 */
	public function beforeSave($options = array()) {
		$this->Behaviors->load('Revision', array('limit' => $this->limitRevisions));
		return true;
	}

/**
 * 履歴を管理するモデルを返す
 *
 * @return Model WikiPagesRev
 */
	public function getRevision() {
		if (empty($this->revision)) {
			$this->Behaviors->load('Revision', array('limit' => $this->limitRevisions));
			$this->revision = $this->ShadowModel;
		}

		return $this->revision;
	}
}
