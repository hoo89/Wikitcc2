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
	<ul class="nav nav-pills nav-stacked collapse navbar-collapse" id="wikitcc-nav">
		<?php echo $this->Nav->tab('トップページ','/');?>
		<li <?php 
		$url = $this->Html->url();
		if($url === $this->Html->url('/categories')||$url === $this->Html->url('/categories/public_index')){echo 'class="active"';}?> >
       <?php echo $this->Html->link('サイトマップ','/categories')?>
		</li>
		<?php
		echo $this->Nav->tab('プロジェクト',array('controller' => 'wikiPages', 'action' => 'view','プロジェクト'));
		echo $this->Nav->tab('イベント',array('controller' => 'wikiPages', 'action' => 'view','イベント'));
		echo $this->Nav->tab('部員',array('controller' => 'wikiPages', 'action' => 'view','部員'));
		echo $this->Nav->tab('クラブ紹介',array('controller' => 'wikiPages', 'action' => 'view','クラブ紹介'));
		echo $this->Nav->tab('活動場所',array('controller' => 'wikiPages', 'action' => 'view','活動場所'));
		echo $this->Nav->tab('リンク',array('controller' => 'wikiPages', 'action' => 'view','リンク'));?>
	</ul>
</div>
