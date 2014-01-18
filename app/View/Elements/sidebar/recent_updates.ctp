<div class="updates">
<h4>Latest Updates</h4>
<?php $posts = $this->requestAction('wikiPages/public_find/sort:modified/direction:desc/limit:5');?>

<?php foreach ($posts as $post): ?>
	<?php 
		echo date('Y-n-j',strtotime($post['WikiPage']['modified']));
	?>
	<ul>
    <li><?php echo $this->Html->link($post['WikiPage']['title'],
array('controller' => 'wikiPages', 'action' => 'view', $post['WikiPage']['title']),array('escape' => false)); ?></li>
	</ul>
<?php endforeach; ?>
</div>