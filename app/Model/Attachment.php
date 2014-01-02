<?php
class Attachment extends AppModel {
    public $validate = array(
        'name' => array(
            array('rule' => 'notEmpty'),
            array('rule' => 'isUnique','message' => '別のファイル名を指定してください')
            )
        );
    /*public $actsAs = array(
        'Upload.Upload' => array(
            'attachment' => array(
                'thumbnailSizes' => array(
                    'xvga' => '1024x768',
                    'vga' => '640x480',
                    'thumb' => '80x80',
                ),
                'fields' => array(
                    'dir' => 'dir'
                )
            ),
        ),
    );*/
    public $belongsTo = 'WikiPage';
    public function beforeSave($options = array()) {
        $upload_dir = 'files/attachment';
        setlocale(LC_ALL, 'ja_JP.UTF-8');
        $this->data[$this->alias]['name'] = basename($this->data[$this->alias]['name']);
        $filename=$this->data[$this->alias]['name'];
        $upload_file = $upload_dir.DS.$filename;
        move_uploaded_file($this->data['Attachment']['attachment']['tmp_name'],$upload_file);
        $this->data[$this->alias]['dir'] = $upload_file;
        return true;
    }
}