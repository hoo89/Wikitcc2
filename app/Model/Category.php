<?php
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
    public function beforeSave($options = array()) {
    	if (isset($this->data[$this->alias]['title'])) {
    		$this->data[$this->alias]['title']=h($this->data[$this->alias]['title']);
    	}
    	return true;
    }
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