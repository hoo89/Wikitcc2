<?php $this->start('title'); ?>
	カテゴリー削除
<?php $this->end(); ?>

<div>
	このカテゴリーを削除しますか？(ページは削除されません)
	<?php echo $this->Form->create('Category', array('type' => 'delete')); ?>
	<?php echo $this->Form->input('id', array('type' => 'hidden')); ?>

	<h4>カテゴリー名</h4>
	<p><?php echo h($this->data['Category']['name']); ?>

	<h4>※削除される下位カテゴリー</h4>
	<ul>
		<?php if (count($deleteCategoryList) <= 0): ?>
			<li>なし</li>
		<?php else: ?>
			<?php foreach($deleteCategoryList as $deleteCategory): ?>
			<li>
				<?php echo h($deleteCategory['Category']['name']); ?>
			</li>
			<?php endforeach; ?>
		<?php endif; ?>
	</ul>
	<?php echo $this->Form->end(array('label'=>'削除', 'class'=>'btn btn-danger')); ?>
</div>