<?php foreach ($wikiPages as $wikiPage):?>
<div class="media">
	<?php if(!empty($wikiPage['Attachment']) && !empty($wikiPage['Attachment'][0]['thumb_dir'])): ?>
	<a class="pull-left" href="<?php echo $this->Html->url('/wiki_pages/view/'.h($wikiPage['WikiPage']['title']));?>">
		<img class="media-object img-thumbnail" src="<?php echo $this->webroot,h($wikiPage['Attachment'][0]['thumb_dir']);?>" width="70" height="70">
	</a>
	<?php endif; ?>
	<div class="media-body">
		<h4 class="media-heading">
			<?php echo $this->Html->link($wikiPage['WikiPage']['title'],array('controller'=>'wiki_pages','action'=>'view',$wikiPage['WikiPage']['title']));?>
			<small>
				-
				<?php
				echo $this->Html->link($wikiPage['Category']['name'],array('controller'=>'categories','action'=>'view',$wikiPage['Category']['id']));
				?>
			</small>
		</h4>

		<?php
		
		// article body
		$len = 200;
		$body = h($wikiPage['WikiPage']['body']);

		if (!empty($searchword) && array_key_exists('keyword', $searchword)) {
			echo $this->Text->highlight($this->Text->excerpt($body, $searchword['keyword'], $len), $searchword['keyword'], array('format' => '<b>\1</b>'));
		} else{
			echo $this->Text->truncate($body, $len);
		}
		?>
		<h4 class="wiki-page-date"><small>
		<?php echo strftime("%Y-%m-%d",strtotime($wikiPage['WikiPage']['modified']));?>
		</small></h4>
	</div>

	
</div>
<?php endforeach;?>