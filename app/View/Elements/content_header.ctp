<ul class="nav nav-pills">
<?php

echo $this->Nav->tab('<span class="glyphicon glyphicon-file"></span> ページ',array('controller' => 'wikiPages', 'action' => 'view',$content_title),empty($content_title));

			  echo $this->Nav->tab('<span class="glyphicon glyphicon-edit"></span> 編集',array('controller' => 'wikiPages', 'action' => 'edit',$content_title),empty($content_title));
			  echo $this->Nav->tab('<span class="glyphicon glyphicon-time"></span> 履歴',array('controller' => 'wikiPages', 'action' => 'revisions',$content_title),empty($content_title));
			  echo $this->Nav->tab('<span class="glyphicon glyphicon-upload"></span> 添付',array('controller' => 'attachments', 'action' => 'index','title:'.$content_title),empty($content_title));
			  echo $this->Nav->tab('<span class="glyphicon glyphicon-plus"></span> 新規',array('controller' => 'wikiPages', 'action' => 'add'));
?>
</ul>