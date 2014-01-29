<!DOCTYPE html>
<html lang="ja-JP">
<head>
	<meta charset="utf-8">
	<title>
		京都工芸繊維大学コンピュータ部
		<?php if(!empty($content_title)){echo ' : '.$content_title;} ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="京都工芸繊維大学コンピュータ部のウェブページ">
	<meta name="author" content="京都工芸繊維大学コンピュータ部">

	<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
	<![endif]-->
	<?php echo $this->Html->css('bootstrap.min');
	echo $this->Html->css('wikitcc');

	echo $this->fetch('meta');
	echo $this->fetch('css');

	$this->startIfEmpty('rss');
	echo $this->Html->meta('京都工芸繊維大学コンピュータ部','/wikiPages/public_index.rss',array('type' => 'rss'));
	$this->end();
	
	echo $this->fetch('rss');

	$isLoggedIn = $this->Session->check('name');
	?>
</head>

<body>
	<div class="container" id="container">
		<div class="row">
			<div id="header">
				<?php
				if(empty($content_title)){
					$content_title=null;
				}
				echo $this->element('header',array('isLoggedIn'=>$isLoggedIn,'content_title'=>$content_title));
				?>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-3 col-md-2" id="sidebar">
				<?php
				if(!$isLoggedIn){
					echo $this->element('sidebar/sidemenu');
					echo $this->element('sidebar/recent_updates');
				}else{
					echo $this->element('sidebar/sidemenu');
					echo $this->element('sidebar/private_recent_updates');
				}
				?>
			</div>

			<div class="col-sm-9 col-md-10" id="content">
				<div id="content-header">
					<div class="pull-right">
						<?php
						if(empty($content_title)){
							$content_title=null;
						}
						if($isLoggedIn){
							echo $this->element('content_header',array('logged_in'=>$this->Session->check('name'),'content_title'=>$content_title));
						}
						?>
					</div>
					<div class="pull-right" id="content-header-breadcrumb">
						<?php
						echo $this->fetch('breadcrumb');
						?>
					</div>
				</div>
				<div class="col-sm-12" id="content-body">
					<div id="message">
						<?php echo $this->Session->flash(); ?>
					</div>
					<div>
						<h2 id="title"><?php echo $title=$this->fetch('title'); ?></h2>
					</div>		
					<?php if(!empty($title)) echo'<hr style="margin-top:0">'; ?>
					<?php echo $this->fetch('content'); ?>
					<?php echo $title=$this->fetch('contentInfo'); ?>
				</div>
			</div>
		</div>
		<div id="footer">Copyright© KITCC All Rights Reserved. Since 2013 - <?php echo date('Y')?><br />Powered by Wikitcc2 with CakePHP2.4.4 and PHP5</div>
	</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<?php echo $this->Html->script('bootstrap.min'); ?>
	<?php echo $this->fetch('script'); ?>
</body>
</html>
