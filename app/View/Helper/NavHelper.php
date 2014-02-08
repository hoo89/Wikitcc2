<?php
/**
 * NavHelper
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * 
 * @copyright	Copyright (c) 2014, hoo89
 * @link		https://github.com/hoo89/Wikitcc2
 * @license		MIT License
 */

class NavHelper extends AppHelper {
	public $helpers = array('Html');
	function tab($title,$link,$disable=false){
		if($disable){
			return '<li class="disabled">'.$this->Html->link($title,'#',array('escape' => false)).'</li>';
		}
		if($this->Html->url($link) === $this->Html->url()){
			return '<li class="active">'.$this->Html->link($title,$link,array('escape' => false)).'</li>';
		}else{
			return '<li>'.$this->Html->link($title,$link,array('escape' => false)).'</li>';
		}
	}
}
