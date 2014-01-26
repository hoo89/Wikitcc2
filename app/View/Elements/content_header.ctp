<ul class="nav nav-pills content-header-nav">
<?php

echo $this->Nav->tab('<span class="glyphicon glyphicon-file"></span> ページ',array('controller' => 'wiki_pages', 'action' => 'view',$content_title),empty($content_title));

			  echo $this->Nav->tab('<span class="glyphicon glyphicon-edit"></span> 編集',array('controller' => 'wiki_pages', 'action' => 'edit',$content_title),empty($content_title));
			  echo $this->Nav->tab('<span class="glyphicon glyphicon-time"></span> 履歴',array('controller' => 'wiki_pages', 'action' => 'revisions',$content_title),empty($content_title));
			  echo $this->Nav->tab('<span class="glyphicon glyphicon-upload"></span> 添付',array('controller' => 'attachments', 'action' => 'index','title:'.$content_title),empty($content_title));
			  echo $this->Nav->tab('<span class="glyphicon glyphicon-plus"></span> 新規',array('controller' => 'wiki_pages', 'action' => 'add'));
?>
</ul>