<?php $this->assign('title','サイトマップ'); ?>

	<?php echo $this->Html->link('カテゴリーを登録する', array('action' => 'add'), array('class'=>'btn btn-primary btn-sm')); ?>
	<?php echo $this->Html->link('カテゴリーを編集する', array('action' => 'edit_view'), array('class'=>'btn btn-warning btn-sm')); ?>

<div class="category">
TOP
<?php
echo $this->Tree->generate($categories,$top_pages);
?>
</div>