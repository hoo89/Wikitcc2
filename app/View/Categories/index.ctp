<?php $this->assign('title','<h3>サイトマップ</h3>'); ?>

	<?php echo $this->Html->link('カテゴリーを登録する', array('action' => 'add'), array('class'=>'btn btn-primary btn-sm')); ?>
	<?php echo $this->Html->link('カテゴリーを削除する', array('action' => 'add'), array('class'=>'btn btn-danger btn-sm','style'=>'display:none')); ?>

<div class="category">
トップ
<?php
echo $this->Tree->generate($categories,$top_pages);
?>
</div>