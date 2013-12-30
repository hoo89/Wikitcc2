<div id="sidemenu">
	<?php echo $this->Html->image("wikitcc.png", array(
		"alt" => "KITCC",
		'url' => '/'
	)); ?>
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#wikitcc-nav">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
     </button>
	<ul class="nav nav-stacked collapse navbar-collapse" id="wikitcc-nav">
		<li><?php echo $this->Html->link('トップページ','/'); ?></li>
		<li><?php echo $this->Html->link('サイトマップ',array('controller' => 'categories', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link('プロジェクト',array('controller' => 'wikiPages', 'action' => 'view','プロジェクト')); ?></li>
		<li><?php echo $this->Html->link('イベント',array('controller' => 'wikiPages', 'action' => 'view','イベント')); ?></li>
		<li><?php echo $this->Html->link('部員',array('controller' => 'wikiPages', 'action' => 'view','部員')); ?></li>
		<li><?php echo $this->Html->link('クラブ紹介',array('controller' => 'wikiPages', 'action' => 'view','クラブ紹介')); ?></li>
		<li><?php echo $this->Html->link('活動場所',array('controller' => 'wikiPages', 'action' => 'view','活動場所')); ?></li>
		<li><?php echo $this->Html->link('リンク',array('controller' => 'wikiPages', 'action' => 'view','リンク')); ?></li>
	</ul>
</div>
