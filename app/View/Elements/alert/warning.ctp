<?php
if (!isset($class)) {
	$class = false;
}
if (!isset($close)) {
	$close = true;
}
?>
<div class="alert alert-warning">
<?php if ($close): ?>
	<a class="close" data-dismiss="alert" href="#">×</a>
<?php endif; ?>
	<?php echo $message; ?>
</div>