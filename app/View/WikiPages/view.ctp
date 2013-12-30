<?php
if($this->Html->url()!=$this->Html->webroot){
$this->Html->addCrumb('トップページ', '/');
if(!empty($parents)){
	foreach($parents as $parent){
		$this->Html->addCrumb($parent['Category']['name']);
	}
}

$this->Html->addCrumb($post['WikiPage']['title']);
}
$this->start('title');
echo $this->Html->getCrumbList(array('class'=>'breadcrumb'));
echo '<h3>'.$post['WikiPage']['title'].'</h3>';
$this->end();
?>
<div class="content-body"><p><?php echo $this->WikitccParse->parse($post['WikiPage']['body']); ?></p></div>
