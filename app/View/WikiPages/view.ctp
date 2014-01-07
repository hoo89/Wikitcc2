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

$this->assign('breadcrumb', $this->Html->getCrumbList(array('class'=>'breadcrumb')));
$this->assign('title', '<h3>'.$data['WikiPage']['title'].'</h3>');

?>
<div class="wiki_content">
	<?php echo $this->WikitccParse->parse($this,$data['WikiPage']['body']); ?>
</div>
