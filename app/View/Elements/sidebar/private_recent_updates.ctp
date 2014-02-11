<div id="sidebar-updates">
<h4>Latest Updates</h4>
<?php $posts = $this->requestAction('wikiPages/index/sort:modified/direction:desc/limit:5');?>

<?php foreach ($posts as $post): ?>
	<?php 
		echo date('Y-n-j',strtotime($post['WikiPage']['modified']));
		//echo $post['WikiPage']['modified']; 
	?>
	<ul>
    <li><?php echo $this->Html->link($post['WikiPage']['title'],
array('controller' => 'wiki_pages', 'action' => 'view', $post['WikiPage']['title'])); ?></li>
	</ul>
<?php endforeach; ?>
</div>