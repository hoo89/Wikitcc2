<?php foreach ($wikiPages as $wikiPage):?>
<div class="media">
  <?php if(!empty($wikiPage['Attachment']) && !empty($wikiPage['Attachment'][0]['thumb_dir'])): ?>
  <a class="pull-left" href="#">
    <img class="media-object img-thumbnail" src="<?php echo $this->webroot,$wikiPage['Attachment'][0]['thumb_dir'];?>" width="70" height="70">
  </a>
<?php endif; ?>
  <div class="media-body">
  	<h4 class="media-heading">
    <?php echo $this->Html->link($wikiPage['WikiPage']['title'],array('controller'=>'wiki_pages','action'=>'view',$wikiPage['WikiPage']['title']),array('escape'=>false));?>
    <small>
      -
      <?php
      echo $this->Html->link($wikiPage['Category']['name'],array('controller'=>'categories','action'=>'view',$wikiPage['Category']['id']));
      ?>
    </small>
  </h4>

    <?php 
    	//echo $wikiPage['WikiPage']['body'];
    	//$lines = explode("\n",h($wikiPage['WikiPage']['body']),6);
    	//echo implode(array_slice($lines,0,5));
    	$len = 200;
    	$body = h($wikiPage['WikiPage']['body']);
    	echo mb_substr($body, 0, $len);
    	if(mb_strlen($body) > $len){
    		echo '...';
    	}
    	?>
    	<h4><small>
    <?php echo strftime("%Y-%m-%d",strtotime($wikiPage['WikiPage']['modified']));?>
    </small></h4>
  </div>

  
</div>
<?php endforeach;?>