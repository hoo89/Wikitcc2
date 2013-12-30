<?php
$this->assign('title','<h3>編集</h3>');
echo $this->Form->create('WikiPage');
echo '<div class="col-sm-6">';
echo $this->Form->input('title',array('disabled' => true, 'class' => 'form-control', 'label'=>'タイトル','default'=>$post['WikiPage']['title']));
echo '</div>';
echo '<div class="col-sm-12">';
echo $this->Form->textarea('body', array(
            "rows"=>20,
            "class"=>"form-control",
            'label'=>'本文'
            'default'=>$post['WikiPage']['body'],
            'error' => array('attributes' => array('class' => 'has-error')
        ));

echo 'カテゴリー ';
echo $this->Form->select('category_id', $categoryList, array('empty' => '------'));
echo $this->Form->input('id', array('type' => 'hidden','default'=>$post['WikiPage']['id']));
echo $this->Form->end('保存する');
echo '</div>';
?>