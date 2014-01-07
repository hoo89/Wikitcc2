<div class="row">
	<div class="col-sm-4 pull-right">
		<ul class="nav nav-pills">
		<li><?php echo $this->Html->link('ログイン',array('controller' => 'users', 'action' => 'login')); ?></li>
		<li><?php echo $this->Html->link('サイトマップ',array('controller' => 'categories', 'action' => 'index')); ?></li>
		</ul>
	</div>

	<div class="col-xs-5 col-sm-3 pull-right">
		<form action="/wikitcc2/WikiPages/find_public" class="form-search" id="WikiPageViewForm" method="post" accept-charset="utf-8">
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