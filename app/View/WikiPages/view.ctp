<?php
if($this->Html->url()!=$this->Html->webroot){
	$this->Html->addCrumb('TOP', '/');
	if(!empty($parents)){
		foreach($parents as $parent){
			$this->Html->addCrumb($parent['Category']['name'],'/categories/view/'.$parent['Category']['id']);
		}
	}
	$this->Html->addCrumb($data['WikiPage']['title']);
	$this->assign('title', $data['WikiPage']['title']);
}

$this->assign('breadcrumb', $this->Html->getCrumbList(array('class'=>'breadcrumb')));
$this->assign('contentInfo','<h4 class="text-right"><small>最終更新日時：'.$data['WikiPage']['modified'].'</small></h4><h4 class="text-right"><small>作成日時：'.$data['WikiPage']['created'].'</small></h4>');

?>
<div class="wiki_content">
	<?php echo $this->WikitccParse->parse($this,$data['WikiPage']['body']); ?>
</div>
