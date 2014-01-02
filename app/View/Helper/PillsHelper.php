<?php
class PillsHelper extends AppHelper {
	public $helpers = array('Html');
	function isActive($controller, $actions = array()){
        foreach ($actions as $action){
            if($controller == $this->params['controller'] && $action == $this->params['action']) {
        	    return true;
            }
        }
        return false;
    }
}