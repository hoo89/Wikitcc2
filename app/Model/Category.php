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
}