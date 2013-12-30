<?php $this->start('title'); ?>
<h3>カテゴリー</h3><?php echo empty($this->data['Category']['id']) ? '追加' : '編集'; ?>
<?php $this->end(); ?>
<div>
	<?php echo $this->Form->create('Category'); ?>
	<?php echo empty($this->data['Category']['id']) ? null : $this->Form->input('id', array('type' => 'hidden')); ?>

	<h3>カテゴリー名</h3>
	<p><?php echo $this->Form->inout('name', array('placeholder' => 'カテゴリー名を入力して下さい。')); ?></p>

	<h3>親カテゴリー</h3>
	<p><?php echo $this->Form->select('parent_id', $categoryList, array('empty' => '------')); ?></p>

	<?php echo $this->Form->end(empty($this->data['Category']['id']) ? ' 追加 ' : ' 編集 '); ?>
</div>

<div style="text-align: right;">
	<?php echo empty($this->data['Category']['id']) ? null : $this->Html->link('削除する', array('action' => 'delete', $this->data['Category']['id'])); ?>
</div>