<?php
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
class User extends AppModel {
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('custom', '/[a-zA-Z0-9\'.\\\s]{1,}$/i'),
                'message' => 'ユーザ名には1文字以上の半角英数字が必要です.'
            ),
            'required' => array(
                'rule' => 'isUnique',
                'message' => 'このユーザ名は既に使われています.'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('custom', '/[a-zA-Z0-9\'.\\\s]{4,}$/i'),
                'message' => 'パスワードには4文字以上の半角英数字が必要です.'
            )
        )
    );

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash($this->data[$this->alias]['password']);
        }
        return true;
    }
}
