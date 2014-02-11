<div id="sidemenu">
	<ul class="nav nav-pills nav-stacked" id="wikitcc-nav">
		<?php echo $this->Nav->tab('トップページ','/');?>
		<li <?php 
		$url = $this->Html->url();
		if($url === $this->Html->url('/categories')||$url === $this->Html->url('/categories/public_index')){echo 'class="active"';}?> >
       <?php echo $this->Html->link('サイトマップ','/categories');?>
		</li>
		<?php
		echo $this->Nav->tab('クラブ紹介',array('controller' => 'wiki_pages', 'action' => 'view','クラブ紹介'));
		echo $this->Nav->tab('プロジェクト',array('controller' => 'wiki_pages', 'action' => 'view','プロジェクト'));
		echo $this->Nav->tab('部員紹介',array('controller' => 'wiki_pages', 'action' => 'view','部員紹介'));
		echo $this->Nav->tab('活動場所',array('controller' => 'wiki_pages', 'action' => 'view','活動場所'));
		echo $this->Nav->tab('リンク',array('controller' => 'wiki_pages', 'action' => 'view','リンク'));?>
	</ul>
</div>
