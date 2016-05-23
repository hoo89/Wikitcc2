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
		$children = $this->children();
		$category_ids = Hash::extract($children, '{n}.Category.id');
		$category_ids[] = $this->id;

		$pages = $this->WikiPage->findAllByCategoryId($category_ids);

		// 自身を含む下位カテゴリのページの所属カテゴリをnull(TOP)へ変更する
		foreach($pages as $page){
			$this->WikiPage->id = $page['WikiPage']['id'];
			$this->WikiPage->saveField('category_id', null);
		}
		return true;
	}
}
