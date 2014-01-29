<?php 
    $this->assign('title', 'アップロード');
?>

<?php if(!empty($content_title)): ?>
<script type="text/javascript">
  function selectFile() {
    var fileName = document.getElementById("file-name").files[0].name;
    document.getElementById("input-name").value = fileName;
  }
</script>

<?php echo $this->Form->create('Attachment', array('type' => 'file', 'action' => 'add')); ?>
<?php echo $this->Form->input('Attachment.attachment', array('type' => 'file','id' => 'file-name','onchange'=>'selectFile()')); ?>
<?php echo $this->Form->input('Attachment.name',array('id' => 'input-name')); ?>
<?php echo $this->Form->input('Attachment.dir', array('type' => 'hidden')); ?>
<?php echo $this->Form->input('Attachment.wiki_page_id', array('type' => 'hidden','value' => $wiki_page_id)); ?>
<?php echo $this->Form->end(__('Submit')); ?>
<?php endif; ?>

<div>
    <p>
        <?php echo $this->Paginator->counter(array('format' => __('{:pages}ページ中 {:page}ページ目 &nbsp;&nbsp;{:count}ファイル中 {:start}-{:end}ファイルを表示')));?>
    </p>

    <table class="table table-hover">
        <tr>
            <th></th>
            <th>ファイル名</th>
            <th>ページ</th>
            <th></th>
        </tr>
    <?php foreach ($attachments as $attachment): ?>
        <tr>
            <td>
                <?php 
                if($attachment['Attachment']['thumb_dir']){
                    echo '<a href="',$this->webroot,h($attachment['Attachment']['dir']),'" class="img-thumbnail">','<img src="',$this->webroot,h($attachment['Attachment']['thumb_dir']),'" width="70" height="70">';
                } 
                ?>
            </td>
            <td><?php echo '<a href="',$this->webroot,h($attachment['Attachment']['dir']),'">',h($attachment['Attachment']['name']),'</a>';?>
            <td><?php echo $this->Html->link($attachment['WikiPage']['title'], array('controller'=>'wikiPages','action'=>'view',$attachment['WikiPage']['title']));?>
            <td><?php echo $this->Form->create('Attachment',array('onsubmit'=>"return confirm('このファイルを削除してよろしいですか？');",'class'=>'form-inline','url' => array('controller' => 'Attachments', 'action' => 'delete',$attachment['Attachment']['id'])));
                echo $this->Form->end(array('label'=>'削除','class'=>'btn btn-sm btn-warning'));?></td>
        </tr>
    <?php endforeach; ?>
    </table>
    <?php echo $this->Paginator->pagination(array('ul' => 'pagination','div' => 'text-center')); ?>
</div>
