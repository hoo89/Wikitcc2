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

/**
 * To use TreeBehavior
 *
 * @var array
 */
	public $actsAs = array('Tree');

/**
 * Category has many WikiPages
 *
 * @var array
 */
	public $hasMany =
	array(
		'WikiPage' => array(
		   'fields' => array('id', 'title', 'category_id', 'is_public'),
		'order' => 'WikiPage.modified DESC'
		)
	);

/**
 * カテゴリ削除前に自身と下位カテゴリに属するページのカテゴリをTOPへ変更する
 *
 * @param array $options
 * @return bool
 */
	public function beforeDelete($options = array()) {
		$children = $this->children();
		$categoryIds = Hash::extract($children, '{n}.Category.id');
		$categoryIds[] = $this->id;

		$pages = $this->WikiPage->findAllByCategoryId($categoryIds);

		// 自身を含む下位カテゴリのページの所属カテゴリをnull(TOP)へ変更する
		foreach($pages as $page){
			$this->WikiPage->id = $page['WikiPage']['id'];
			$this->WikiPage->saveField('category_id', null);
		}
		return true;
	}
}
