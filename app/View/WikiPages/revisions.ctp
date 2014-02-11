<table class="table table-striped">
<?php
$this->Paginator->options(array('url' => $content_title));
echo $this->Html->tableHeaders(array('#','更新日時','',''));
$count = 0;
$html=$this->Html;
foreach($wikiPages as $rev){
	$count++;
	echo '<tr>';
	echo '<td>'.$count.'</td>';
	echo '<td>'.$html->link($rev['WikiPage']['version_created'],array('action'=>'view_revision',$rev['WikiPage']['version_id'])).'</td>';
	echo '<td>'.$html->link('一つ前との差分',array('action'=>'view_prev_diff',$rev['WikiPage']['version_id'])).'</td>';
	echo '<td>'.$html->link('現在のページとの差分',array('action'=>'view_latest_diff',$rev['WikiPage']['version_id'])).'</td>';
	echo '</tr>';
}?>
</table>

<?php echo $this->Paginator->pagination(array('ul' => 'pagination','div' => 'text-center')); ?>
