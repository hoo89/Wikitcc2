<?php $this->start('page_title'); ?>
カテゴリー<?php echo empty($this->data['Category']['id']) ? '追加' : '編集'; ?>
<?php $this->end(); ?>
<div>
	<?php echo $this->Form->create('Category'); ?>
	<?php echo empty($this->data['Category']['id']) ? null : $this->Form->input('id', array('type' => 'hidden')); ?>

	<h3>カテゴリー名</h3>
	<p><?php echo $this->Form->inout('name', array('placeholder' => 'カテゴリー名')); ?></p>

	<h3>親カテゴリー</h3>
	<p><?php echo $this->Form->select('parent_id', $categoryList, array('empty' => '------')); ?></p>

	<?php echo $this->Form->radio('is_public', array(0=>'部内のみに公開する',1=>'外部に公開する'));?>

	<?php echo $this->Form->end(empty($this->data['Category']['id']) ? ' 追加 ' : ' 編集 '); ?>
</div>