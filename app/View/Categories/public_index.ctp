<?php $this->assign('page_title','サイトマップ');
$this->append('css',$this->Html->css('jquery.treeview'));
$this->append('script',$this->Html->script('jquery.treeview'));
$this->append('script',$this->Html->script('jquery.cookie')); ?>

<div class="category">
TOP
<?php
echo $this->Tree->generate_public($categories,$top_pages);
?>
</div>