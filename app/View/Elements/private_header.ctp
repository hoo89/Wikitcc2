<?php App::uses('Security', 'Utility'); ?>
<div class="row">
	<div class="col-sm-4 pull-right">
		<ul class="nav nav-pills" id="header-link">
		<li><?php echo $this->Html->link('ログアウト',array('controller' => 'users', 'action' => 'logout')); ?></li>
		<li><?php echo $this->Html->link('サイトマップ',array('controller' => 'categories', 'action' => 'index')); ?></li>
		<li><?php echo $this->Html->link('ページ一覧','/wikiPages/index');?></li>
		</ul>
	</div>

<div class="col-sm-4 col-md-3 pull-right">
		
		<?php echo $this->Form->create('WikiPage',array('action'=>'find','class'=>'form-search'));?>
		<div class="input-group input-group-sm">
		<?php
		echo $this->Form->input('WikiPage.keyword', array(
		    'div' => false,
		    'class' => 'form-control',
		    'placeholder'=>'ページを検索'
		));
		?>
		<div class="input-group-btn">
		<?php echo $this->Form->button('<span class="glyphicon glyphicon-search"></span>', array('type' => 'submit','class'=>'btn btn-default btn-sm'));?>
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
        <ul class="dropdown-menu">
          <li class="active" id="dropdown1"><a>タイトル+本文</a></li>
          <li id="dropdown2"><a>タイトル</a></li>
          <li id="dropdown3"><a>本文</a></li>
        </ul>
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