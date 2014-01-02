<?php
class Category extends AppModel {
	public $actsAs = array('Tree');
	public $name = 'Category';
    public $hasMany = 
    array(
    	'WikiPage'=>array(
    		'fields' => array('id','title','category_id','is_public')
    	)
    );
    public function beforeSave($options = array()) {
    	if (isset($this->data[$this->alias]['title'])) {
    		$this->data[$this->alias]['title']=h($this->data[$this->alias]['title']);
    	}
    	return true;
    }
}