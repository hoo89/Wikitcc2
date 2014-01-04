<div id="comment">
<?php
echo $this->Form->create('WikiPage',array('class'=>'form-inline','url' => array('controller' => 'WikiPages', 'action' => 'add_comment')));
echo $this->Form->input('name',array('class' => 'form-control','div' => 'form-group col-sm-2','placeholder'=>'名前'));
echo $this->Form->input('comment',array('class' => 'form-control','div' => 'form-group col-sm-4','placeholder'=>'本文'));
echo $this->Form->input('id', array('type' => 'hidden','default'=>$data['WikiPage']['id']));
echo $this->Form->end(array('label'=>'コメント','class'=>'btn btn-primary'));
?>
</div>
