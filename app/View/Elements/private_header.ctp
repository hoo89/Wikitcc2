<?php echo $this->Form->create('WikiPage', array('class'=>'form-inline','url' => array('controller' => 'WikiPages', 'action' => 'find'))); ?>

<?php echo $this->Form->input('keyword', array('label' => false,'placeholder'=>'ページを検索', 'class' => 'form-control input-sm', 'div' => 'form-group')); ?>
<button type="submit" class="btn btn-default btn-sm" style="margin:0px 5px;"><span class="glyphicon glyphicon-search"></span> 検索</button>
</form>

<ul class="nav nav-pills">
<li><?php echo $this->Html->link('ログアウト',array('controller' => 'users', 'action' => 'logout')); ?></li>
<li><?php echo $this->Html->link('サイトマップ',array('controller' => 'categories', 'action' => 'index')); ?></li>
</ul>

