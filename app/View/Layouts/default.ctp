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
	<meta name="description" content="">
	<meta name="author" content="Kyoto Institute of Technology Computer Club - KITCC">

	<?php echo $this->Html->css('cake.generic'); ?>
	<?php echo $this->Html->css('bootstrap.min'); ?>
	<?php echo $this->Html->css('jquery.treeview'); ?>
	<?php echo $this->Html->css('wikitcc'); ?>
	<!--
	<link rel="shortcut icon" href="/ico/favicon.ico">
	-->
	<?php
	echo $this->fetch('meta');
	echo $this->fetch('css');
	?>
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="pull-right" id="header">
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
			<div class="col-sm-2" id="sidebar">
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

			<div class="col-sm-offset-2 col-md-9 col-sm-10" id="content">
				<div id="content-header">
					<div class="col-md-6" id="breadcrumb">
					<?php
					echo $this->fetch('breadcrumb');
					?>
					</div>
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
					<div class="col-sm-6">
						<?php echo $this->fetch('title'); ?>
					</div>
					<div class="col-sm-12">
						<?php echo $this->Session->flash('flash', array('element' => 'message')); ?>
					</div>
				</div>
				<div class="col-sm-12" id="content-body">
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
