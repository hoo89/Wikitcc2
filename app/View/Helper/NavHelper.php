<?php
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