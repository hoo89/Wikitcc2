<div id="comment">
<?php
echo $this->Form->create('WikiPage',array('class'=>'form-inline','url' => array('controller' => 'WikiPages', 'action' => 'add_comment')));
echo $this->Form->input('name',array('class' => 'comment-form form-control','div' => 'form-group col-sm-4','placeholder'=>'名前'));
echo '<div class="form-group col-sm-9">';
echo $this->Form->textarea('comment',array('class' => 'comment-form form-control','rows'=>3, 'placeholder'=>'本文'));
echo '</div>';
echo $this->Form->input('id', array('type' => 'hidden','default'=>$data['WikiPage']['id']));
echo '<div class="form-group col-sm-9">';
echo $this->Form->end(array('label'=>'コメント','class'=>'comment-form btn btn-primary'));
echo '</div>';
?>
</div>
