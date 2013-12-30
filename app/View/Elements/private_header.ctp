<div  id="header" class="row">
    <div class="col-sm-offset-8">
    <ul class="nav nav-pills">
    <li><?php echo $this->Html->link('ログアウト',array('controller' => 'users', 'action' => 'logout')); ?></li>
    <?php if(!empty($page_title)){ ?>
    	<li><?php echo $this->Html->link('編集',array('controller' => 'wikiPages', 'action' => 'edit',$page_title)); ?></li>
    <?php }else{ ?>
    	<li class="disabled"><?php echo $this->Html->link('編集','#'); ?></li>
    <?php } ?>
    <li><?php echo $this->Html->link('新規',array('controller' => 'wikiPages', 'action' => 'add')); ?></li>
    <li><?php echo $this->Html->link('サイトマップ',array('controller' => 'categories', 'action' => 'index')); ?></li>
    </ul>
    </div>
</div>