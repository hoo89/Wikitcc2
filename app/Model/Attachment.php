<?php
class Attachment extends AppModel {
    public $validate = array(
        'name' => array(
            array('rule' => 'notEmpty'),
            array('rule' => 'isUnique','message' => '別のファイル名を指定してください')
            )
        );

    public $belongsTo = 'WikiPage';
    public function beforeValidate($options = array()) {
        setlocale(LC_ALL, 'ja_JP.UTF-8');
        $this->data[$this->alias]['name'] = basename(h($this->data[$this->alias]['name']));
        return true;
    }
    public function beforeSave($options = array()){
        $upload_dir = 'files/attachment';
        $filename=$this->data[$this->alias]['name'];
        $upload_file = $upload_dir.DS.$filename;
        move_uploaded_file($this->data['Attachment']['attachment']['tmp_name'],$upload_file);
        $this->data[$this->alias]['dir'] = $upload_file;
        return true;
    }
}