<?php
class NavHelper extends AppHelper {
	public $helpers = array('Html');
    function tab($title,$link,$disable=false){
    	if($disable){
    		return '<li class="disabled">'.$this->Html->link($title,'#').'</li>';
    	}
    	if($this->Html->url($link) === $this->Html->url()){
    		return '<li class="active">'.$this->Html->link($title,$link).'</li>';
    	}else{
    		return '<li>'.$this->Html->link($title,$link).'</li>';
    	}
    }
}