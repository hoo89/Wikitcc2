<div class="row">
	<div class="col-sm-4 col-md-3  pull-right">
		<ul class="nav nav-pills" id="header-link">
		<li><?php echo $this->Html->link('ログアウト',array('controller' => 'users', 'action' => 'logout')); ?></li>
		<li><?php echo $this->Html->link('サイトマップ',array('controller' => 'categories', 'action' => 'index')); ?></li>
		</ul>
	</div>

	<div class="col-sm-3 col-md-2 pull-right">
		<form action="/wikitcc2/WikiPages/find" class="form-search" id="WikiPageViewForm" method="post" accept-charset="utf-8">
		<div style="display:none;"><input type="hidden" name="_method" value="POST"></div>
		<div class="input-group input-group-sm">
		<input name="data[WikiPage][keyword]" placeholder="ページを検索" class="form-control" type="text" id="WikiPageKeyword">
		<span class="input-group-btn">
		<button type="submit" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-search"></span></button>
		</span>
		</div>
		</form>
	</div>
</div>