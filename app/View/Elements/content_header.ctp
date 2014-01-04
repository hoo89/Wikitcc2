<ul class="nav nav-pills">
<li <?php if($this->Pills->isActive('wikiPages', array('view'))) { echo 'class="active"'; } ?> >
	<?php 
	if(!empty($content_title) && $content_title!='TOP'){
		echo $this->Html->link('ページ',array('controller' => 'wikiPages', 'action' => 'view',$content_title));
	}else{
		echo $this->Html->link('ページ','/');
	}
	?>
</li>

<?php if(!empty($content_title)){ ?>
<li <?php if($this->Pills->isActive('wikiPages', array('edit'))) { echo 'class="active"'; } ?> >
	<?php echo $this->Html->link('編集',array('controller' => 'wikiPages', 'action' => 'edit',$content_title)); ?>
</li>
<?php }else{ ?>
<li class="disabled <?php if($this->Pills->isActive('wikiPages', array('edit'))) { echo ' active'; } ?>">
	<?php echo $this->Html->link('編集','#'); ?>
</li>
<?php } ?>

<?php if(!empty($content_title)){ ?>
<li <?php if($this->Pills->isActive('wikiPages', array('revisions'))) { echo 'class="active"'; } ?> >
	<?php echo $this->Html->link('履歴',array('controller' => 'wikiPages', 'action' => 'revisions',$content_title)); ?>
</li>
<?php }else{ ?>
<li class="disabled <?php if($this->Pills->isActive('wikiPages', array('edit'))) { echo ' active'; } ?>">
	<?php echo $this->Html->link('履歴','#'); ?>
</li>
<?php } ?>

<li <?php if($this->Pills->isActive('attachments', array('add'))) { echo 'class="active"'; } ?> >
	<?php 
	if(!empty($content_title)){
		echo $this->Html->link('アップロード',array('controller' => 'attachments', 'action' => 'add',$content_title));
	}else{
		echo $this->Html->link('アップロード',array('controller' => 'attachments', 'action' => 'add'));
	}
	?>
</li>
<li <?php if($this->Pills->isActive('wikiPages', array('add'))) { echo 'class="active"'; } ?> >
	<?php echo $this->Html->link('新規',array('controller' => 'wikiPages', 'action' => 'add')); ?>
</li>
</ul>