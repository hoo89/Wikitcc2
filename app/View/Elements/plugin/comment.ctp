<div id="comment" class="row" style="margin:0">
<?php
if(empty($data)){
	$data=array('WikiPage'=>array('id'=>false));
}
echo $this->Form->create('WikiPage',array('class'=>'form-horizontal','url' => array('controller' => 'wiki_pages', 'action' => 'add_comment')));
echo $this->Form->input('name',array('class' => 'comment-form form-control','div' => 'form-group col-sm-4','placeholder'=>'名前','label'=>false));
echo '<div class="form-group col-sm-9">';
echo $this->Form->textarea('comment',array('class' => 'comment-form form-control','rows'=>3, 'placeholder'=>'本文'));
echo '</div>';
echo $this->Form->input('id', array('type' => 'hidden','default'=>$data['WikiPage']['id']));
echo '<div class="form-group col-sm-9">';
echo $this->Form->end(array('label'=>'コメント','class'=>'comment-form btn btn-primary'));
echo '</div>';
?>
</div>
