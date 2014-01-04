<?php
if($this->Html->url()!=$this->Html->webroot){
	$this->Html->addCrumb('TOP', '/');
	if(!empty($parents)){
		foreach($parents as $parent){
			$this->Html->addCrumb($parent['Category']['name']);
		}
	}
	$this->Html->addCrumb($data['WikiPage']['title']);
}
$this->start('title');
echo $this->Html->getCrumbList(array('class'=>'breadcrumb'));
echo '<h3>'.$data['WikiPage']['title'].'</h3>';
$this->end();
?>
<div class="content-body">
	<?php echo $this->WikitccParse->parse($this,$data['WikiPage']['body']); ?>
</div>
