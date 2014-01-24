<?php foreach ($wikiPages as $wikiPage):?>
<div class="media">
  <?php if(!empty($wikiPage['Attachment']) && !empty($wikiPage['Attachment'][0]['thumb_dir'])): ?>
  <a class="pull-left" href="#">
    <img class="media-object img-thumbnail" src="<?php echo $this->webroot,$wikiPage['Attachment'][0]['thumb_dir'];?>" width="70" height="70">
  </a>
<?php endif; ?>
  <div class="media-body">
    <h4 class="media-heading"><?php echo $wikiPage['WikiPage']['title'];?> <small><?php echo $wikiPage['WikiPage']['modified'];?></small></h4>
     [image:logo.jpg] <br />
<b>Kyoto Institute of Technology Computer Club</b><br />
<br />
京都工芸繊維大学コンピュータ部のウェブページへようこそそそ<br />
京都工芸繊維大学コンピュータ部は、ソフトな人からハードな人まで...
  </div>
  
</div>
<?php endforeach;?>