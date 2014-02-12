<?php App::uses('Security', 'Utility'); ?>
<nav class="navbar navbar-default" role="navigation">
	<div class="container" id="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#wikitcc-header">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a href="<?php echo $this->Html->url('/')?>" class="navbar-brand" style="padding:5px 15px;"><?php echo $this->Html->image('header.png'); ?></a> 
	  	</div>
	  	<div class="collapse navbar-collapse" id="wikitcc-header">
			<ul class="nav navbar-nav navbar-right">
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
			echo $this->Nav->tab('最近の更新','/wiki_pages/index');
			else:
			echo $this->Nav->tab('最近の更新','/wiki_pages/public_index');
			endif; ?>
			</ul>

			<div class="col-sm-4 col-md-4  navbar-right">
				<?php if($isLoggedIn): ?>
				<?php echo $this->Form->create('WikiPage',array('action'=>'find','class'=>'navbar-form','inputDefaults' => array('div' => 'form-group','label' => false,'wrapInput' => false,'class' => 'form-control')));?>
				<?php else: ?>
				<?php echo $this->Form->create('WikiPage',array('action'=>'public_find','class'=>'navbar-form','inputDefaults' => array('div' => 'form-group','label' => false,'wrapInput' => false,'class' => 'form-control')));?>
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
	</div>
</nav>