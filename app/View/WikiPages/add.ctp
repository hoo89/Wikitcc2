<?php
$this->append('script','<script>
    $(function(){
        $("#preview-tab").click(function(){
            $("#preview-body").empty();
        	$.post("'.$this->Html->url('/wiki_pages/preview').'",{"body":$("#WikiPageBody").val()},function(rs){
        		$("#preview-body").prepend(rs);
        	});
        });
    });
    </script>');

if($content_title){
	$this->assign('page_title','編集');
}else{
	$this->assign('page_title', '新規作成');
}
?>

<ul class="nav nav-tabs page-tabs">
  <li class="active"><a href="#edit" data-toggle="tab">編集</a></li>
  <li><a href="#preview" data-toggle="tab" id="preview-tab">プレビュー</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane" id="preview">
        <div id="preview-body"></div>
    </div>

    <div class="tab-pane active" id="edit">
		<p>&nbsp;&nbsp;&nbsp;&nbsp;Wikitcc記法は<?php echo $this->Html->link('こちら',array('controller' => 'wiki_pages', 'action' => 'view', 'Wikitcc記法一覧')); ?></p>
		<?php echo $this->Form->create('WikiPage'); ?>
		<div class="col-sm-6">
			<?php if($content_title){
	        	echo $this->Form->input('title',array('disabled' => true, 'class' => 'form-control', 'label'=>false));
	        }else{
				echo $this->Form->input('title',array('class' => 'form-control', 'label' => false, 'placeholder' => 'タイトル'));
			}?>
		</div>
		<div class="col-sm-12">
			<?php echo $this->Form->textarea('body', array(
			            "rows"=>20,
			            "class"=>"form-control",
			            'placeholder'=>'本文'
			        ));

			echo 'カテゴリー ';
			echo $this->Form->select('category_id', $categoryList, array('empty' => '------'));
			echo $this->Form->radio('is_public', array(0=>'部内のみに公開する',1=>'外部に公開する'),array('legend' => false));
			echo $this->Form->input('id', array('type' => 'hidden'));
			echo $this->Form->end(array('label'=>'保存する','class'=>'btn btn-primary'));

			if($content_title){
	        	echo $this->Form->create('WikiPage',array('onsubmit'=>"return confirm('このページを削除してよろしいですか？');",'class'=>'form-inline','url' => array('controller' => 'wiki_pages', 'action' => 'delete',$this->data['WikiPage']['title'])));
	        	echo $this->Form->end(array('label'=>'このページを削除する','class'=>'btn btn-warning'));
	        }; ?>
		</div>
	</div>
</div>