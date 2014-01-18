<?php
$this->assign('title', '新規作成');

echo $this->Form->create('WikiPage');
echo '<div class="col-sm-6">';
echo $this->Form->input('title',array('class' => 'form-control', 'label'=>false, 'placeholder'=>'タイトル', 'error' => array('attributes' => array('class' => 'has-error'))));
echo '</div>';
echo '<div class="col-sm-12">';
echo $this->Form->textarea('body', array(
            "rows"=>20,
            "class"=>"form-control",
            'placeholder'=>'本文'
        ));

echo 'カテゴリー ';
echo $this->Form->select('category_id', $categoryList, array('empty' => '------'));
echo $this->Form->radio('is_public', array(0=>'部内のみに公開する',1=>'外部に公開する'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end(array('label'=>'保存する','class'=>'btn btn-primary'));
echo '</div>';

?>