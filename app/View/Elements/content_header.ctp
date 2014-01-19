<ul class="nav nav-pills">
<?php
echo $this->Nav->tab('ページ',array('controller' => 'wikiPages', 'action' => 'view',$content_title),empty($content_title));
echo $this->Nav->tab('編集',array('controller' => 'wikiPages', 'action' => 'edit',$content_title),empty($content_title));
echo $this->Nav->tab('履歴',array('controller' => 'wikiPages', 'action' => 'revisions',$content_title),empty($content_title));
echo $this->Nav->tab('アップロード',array('controller' => 'attachments', 'action' => 'add',$content_title),empty($content_title));
echo $this->Nav->tab('新規',array('controller' => 'wikiPages', 'action' => 'add'));
?>
</ul>