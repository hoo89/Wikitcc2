<div class="row">
	<div class="col-sm-4 pull-right">
		<ul class="nav nav-pills" id="header-link">
		<li><?php echo $this->Html->link('ログアウト',array('controller' => 'users', 'action' => 'logout')); ?></li>
		<li><?php echo $this->Html->link('サイトマップ',array('controller' => 'categories', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link('ページ一覧','/wikiPages/index');?></li>
		</ul>
	</div>

	<div class="col-sm-3 col-md-2 pull-right">
		<?php echo $this->Form->create('WikiPage',array('action'=>'find','class'=>'form-search'));?>
		<div class="input-group input-group-sm">
		<input name="data[WikiPage][keyword]" placeholder="ページを検索" class="form-control" type="text" id="WikiPageKeyword">
		<span class="input-group-btn">
		<button type="submit" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span></button>
		</span>
		</div>
		<?php echo $this->Form->end();?>
	</div>
</div>