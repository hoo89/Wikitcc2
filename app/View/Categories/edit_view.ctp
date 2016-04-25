<?php $this->assign('page_title','カテゴリー編集'); ?>
[↑]:カテゴリーを上に移動<br>
[↓]:カテゴリーを下に移動<br>
X:カテゴリーを削除<br>
<div class="category">
TOP
<?php
echo $this->Tree->generate_edit($categories);
?>
</div>