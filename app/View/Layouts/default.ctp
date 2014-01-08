<!DOCTYPE html>
<html lang="ja-JP">
<head>
	<meta charset="utf-8">
	<title>
		<?php echo __('京都工芸繊維大学コンピュータ部'); ?>
		<?php
		if(!empty($content_title)){
			echo ' : '.$content_title;
		}
		?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="京都工芸繊維大学コンピュータ部のウェブページ">
	<meta name="author" content="京都工芸繊維大学コンピュータ部">

	<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->
	<?php echo $this->Html->css('cake.generic'); ?>
	<?php echo $this->Html->css('bootstrap.min'); ?>
	<?php echo $this->Html->css('jquery.treeview'); ?>
	<?php echo $this->Html->css('wikitcc'); ?>

	<?php
	echo $this->fetch('meta');
	echo $this->fetch('css');
	?>
</head>

<body>
	<div class="container">
		<div class="row">
			<div id="header">
				<?php
				if(!$logged_in){
					echo $this->element('header');
				}else{
					echo $this->element('private_header');
				}
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3 col-md-2" id="sidebar">
				<?php
				if(!$logged_in){
					echo $this->element('sidebar/sidemenu');
					echo $this->element('sidebar/recent_updates');
				}else{
					echo $this->element('sidebar/sidemenu');
					echo $this->element('sidebar/private_recent_updates');
				}
				?>
			</div>

			<div class="col-sm-9" id="content">
				<div id="content-header">
					<div class="pull-right">
						<?php
						if(empty($content_title)){
							$content_title=null;
						}
						if($logged_in){
							echo $this->element('content_header',array('logged_in'=>$logged_in,'content_title'=>$content_title));
						}
						?>
					</div>
					<div class="pull-right" id="breadcrumb">
						<?php
						echo $this->fetch('breadcrumb');
						?>
					</div>
				</div>
				<div class="col-sm-12" id="content-body">
					<div id="message">
						<?php echo $this->Session->flash('flash', array('element' => 'message')); ?>
					</div>
					<div>
						<?php echo $this->fetch('title'); ?>
					</div>		
					<hr>
					<?php echo $this->fetch('content'); ?>
					<hr class="col-sm-12">
				</div>
			</div>
		</div>
		<div id="footer">Copyright© KITCC All Rights Reserved. Since 2013 - <?php echo date('Y')?><br/>Powered by Wikitcc2 with CakePHP2.4.4 and PHP5</div>
	</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<?php echo $this->Html->script('bootstrap.min'); ?>
	<?php echo $this->Html->script('jquery.treeview'); ?>
	<?php echo $this->Html->script('jquery.cookie'); ?>
	<?php echo $this->fetch('script'); ?>
</body>
</html>
