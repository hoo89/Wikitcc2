<?php $this->assign('title','サイトマップ'); ?>

	<?php echo $this->Html->link('カテゴリーを登録する', array('action' => 'add'), array('class'=>'btn btn-primary btn-sm')); ?>
	<?php echo $this->Html->link('カテゴリーを削除する', array('action' => 'add'), array('class'=>'btn btn-danger btn-sm','style'=>'display:none')); ?>

<div class="category">
TOP
<?php
echo $this->Tree->generate($categories,$top_pages);
?>
</div>