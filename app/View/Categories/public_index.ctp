<?php $this->assign('title','サイトマップ'); ?>

<div class="category">
TOP
<?php
echo $this->Tree->generate($categories,$top_pages);
?>
</div>