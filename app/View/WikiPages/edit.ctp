<?php
if($this->data && $this->data['WikiPage']){
	$this->assign('title','編集');
}else{
	$this->assign('title', '新規作成');
}
echo '<p>&nbsp;&nbsp;&nbsp;&nbsp;Wikitcc記法は',$this->Html->link('こちら',array('controller' => 'wikiPages', 'action' => 'view','Wikitcc記法一覧')),'</p>';
echo $this->Form->create('WikiPage');
echo '<div class="col-sm-6">';
if($this->data && $this->data['WikiPage']){
	echo $this->Form->input('title',array('disabled' => true, 'class' => 'form-control', 'label'=>false,'error' => array('attributes' => array('class' => 'has-error'))));
}else{
	echo $this->Form->input('title',array('class' => 'form-control', 'label'=>'タイトル','error' => array('attributes' => array('class' => 'has-error'))));
}
echo '</div>';
echo '<div class="col-sm-12">';
echo $this->Form->textarea('body', array(
            "rows"=>20,
            "class"=>"form-control",
            'label'=>'本文'
        ));

echo 'カテゴリー ';
echo $this->Form->select('category_id', $categoryList, array('empty' => '------'));
echo $this->Form->radio('is_public', array(0=>'部内のみに公開する',1=>'外部に公開する'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end(array('label'=>'保存する','class'=>'btn btn-primary'));
if($this->data && $this->data['WikiPage']){
	echo $this->Form->create('WikiPage',array('onsubmit'=>"return confirm('このページを削除してよろしいですか？');",'class'=>'form-inline','url' => array('controller' => 'WikiPages', 'action' => 'delete',$this->data['WikiPage']['title'])));
	echo $this->Form->end(array('label'=>'このページを削除する','class'=>'btn btn-warning'));
}
echo '</div>';

?>