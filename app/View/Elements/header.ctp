<?php App::uses('Security', 'Utility'); ?>
<nav class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#wikitcc-header">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		<?php echo $this->Html->link('KITCC', '/' ,array('class'=>'navbar-brand')); ?>
  	</div>
  	<div class="collapse navbar-collapse" id="wikitcc-header">
		<ul class="nav navbar-nav navbar-right">
		<?php if($isLoggedIn): ?>
		  <li class="dropdown">

			<a href="#" class="dropdown-toggle" data-toggle="dropdown">ページ編集 <b class="caret"></b></a>
			<ul class="dropdown-menu">
			  <?php
			  echo $this->Nav->tab('<span class="glyphicon glyphicon-plus"></span> 新規ページ',array('controller' => 'wikiPages', 'action' => 'add'));
			  echo $this->Nav->tab('<span class="glyphicon glyphicon-edit"></span> 編集',array('controller' => 'wikiPages', 'action' => 'edit',$content_title),empty($content_title));
			  echo $this->Nav->tab('<span class="glyphicon glyphicon-time"></span> 編集履歴',array('controller' => 'wikiPages', 'action' => 'revisions',$content_title),empty($content_title));
			  echo $this->Nav->tab('<span class="glyphicon glyphicon-upload"></span> アップロード',array('controller' => 'attachments', 'action' => 'index','title:'.$content_title),empty($content_title));
			  
			  echo $this->Nav->tab('<span class="glyphicon glyphicon-file"></span> ページ',array('controller' => 'wikiPages', 'action' => 'view',$content_title),empty($content_title));
			  ?>
			</ul>
		  </li>
		<?php endif; ?>
		<?php if($isLoggedIn):
		echo $this->Nav->tab('ログアウト',array('controller' => 'users', 'action' => 'logout'));
		else:
		echo $this->Nav->tab('ログイン',array('controller' => 'users', 'action' => 'login'));
		endif;?>
		</ul>
		<ul class="nav navbar-nav navbar-right" id="header-link">
		<li <?php 
		$url = $this->Html->url();
		if($url === $this->Html->url('/categories')||$url === $this->Html->url('/categories/public_index')){echo 'class="active"';}?> >
	   <?php echo $this->Html->link('サイトマップ','/categories')?>
		</li>
		<?php if($isLoggedIn):
		echo $this->Nav->tab('ページ一覧','/wikiPages/index');
		else:
		echo $this->Nav->tab('ページ一覧','/wikiPages/public_index');
		endif; ?>
		</ul>

		<div class="col-sm-4 col-md-4  navbar-right">
			<?php if($isLoggedIn): ?>
			<?php echo $this->Form->create('WikiPage',array('action'=>'find','class'=>'navbar-form'));?>
			<?php else: ?>
			<?php echo $this->Form->create('WikiPage',array('action'=>'public_find','class'=>'navbar-form'));?>
			<?php endif; ?>
			<div class="input-group input-group-sm">
				<div class="input-group-btn">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
					<ul class="dropdown-menu">
					  <li class="active" id="dropdown1"><a>タイトル+本文</a></li>
					  <li id="dropdown2"><a>タイトル</a></li>
					  <li id="dropdown3"><a>本文</a></li>
					</ul>
				</div>
				<?php
				echo $this->Form->input('WikiPage.keyword', array(
					'div' => false,
					'class' => 'form-control',
					'placeholder'=>'ページを検索',
					'label'=>false
				));
				?>
				<div class="input-group-btn">
				<?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span>', array('type' => 'submit','class'=>'btn btn-default btn-sm'));?>
				
				</div>
			</div>
			<?php echo $this->Form->end();?>
			<?php $this->Html->scriptBlock('$(function(){
				$("#dropdown1").click(function(){
					$(".dropdown-menu > *").removeClass("active");
					$(this).addClass("active");
					$("#WikiPageKeyword").prop("name","data[WikiPage][keyword]");
				});
				$("#dropdown2").click(function(){
					$(".dropdown-menu > *").removeClass("active");
					$(this).addClass("active");
					$("#WikiPageKeyword").prop("name","data[WikiPage][title]");
				});
				$("#dropdown3").click(function(){
					$(".dropdown-menu > *").removeClass("active");
					$(this).addClass("active");
					$("#WikiPageKeyword").prop("name","data[WikiPage][body]");
				});
			});',array('inline'=>false)); ?>
		</div>
	</div>
</nav>