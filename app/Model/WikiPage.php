<?php
class WikiPage extends AppModel {
	public $validate = array(
        'title' => array(
        	array('rule' => 'notEmpty'),
        	array('rule' => array('custom', '/^[^\\/]*$/u'),'message' => '/はタイトルに使えません.'),
        	array('rule' => 'isUnique','message' => 'このタイトルは既に使われています')
    	)
    );
    public $name = 'WikiPage';
    public $belongsTo = 'Category';
    public $hasMany = 'Attachment';

    public function beforeSave($options = array()) {
    	if (isset($this->data[$this->alias]['title'])) {
    		$this->data[$this->alias]['title']=h($this->data[$this->alias]['title']);
    	}
    	return true;
    }
}
