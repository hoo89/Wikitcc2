<?php
/**
 * Category
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * 
 * @copyright	Copyright (c) 2014, hoo89
 * @link		https://github.com/hoo89/Wikitcc2
 * @license		MIT License
 */

class Category extends AppModel {
	public $actsAs = array('Tree');
	public $name = 'Category';
	public $hasMany = 
	array(
		'WikiPage'=>array(
		   'fields' => array('id','title','category_id','is_public'),
		'order' => 'WikiPage.modified DESC'
		)
	);

	public function beforeDelete($options = array()){
		$category = $this->findById($this->id);

		if(array_key_exists('WikiPage',$category)){
			//カテゴリを削除する前にそのカテゴリに属していたページのページカテゴリをnullに戻す
			foreach($category['WikiPage'] as $page){
				$this->WikiPage->id = $page['id'];
				$this->WikiPage->saveField('category_id',null);
			}
		}
		return true;
	}
}
