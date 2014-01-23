<?php $this->assign('title','サイトマップ'); ?>

<div class="category">
TOP
<?php
echo $this->Tree->generate_public($categories,$top_pages);
?>
</div>