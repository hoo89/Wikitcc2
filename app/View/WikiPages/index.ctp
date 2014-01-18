<?php 
    $this->assign('title', 'ページ一覧');
    $this->assign('rss', $this->Html->meta('京都工芸繊維大学コンピュータ部',$this->Html->url().'.rss',array('type' => 'rss')));
?>

<div class="row">
        <p>
            <?php echo $this->BootstrapPaginator->counter(array('format' => __('{:pages}ページ中 {:page}ページ目 &nbsp;&nbsp;{:count}記事中 {:start}-{:end}記事を表示')));?>
        </p>

        <table class="table table-hover">
            <tr>
                <th><?php echo $this->BootstrapPaginator->sort('title','タイトル');?></th>
                <th><?php echo $this->BootstrapPaginator->sort('created','作成日時');?></th>
                <th><?php echo $this->BootstrapPaginator->sort('modified','更新日時');?></th>
                <th><?php echo $this->BootstrapPaginator->sort('category_id','カテゴリー');?></th>
                <th><?php echo $this->BootstrapPaginator->sort('is_public','外部公開');?></th>
            </tr>
        <?php foreach ($wikiPages as $wikiPage): ?>
            <tr>
                <td><?php echo $this->Html->link($wikiPage['WikiPage']['title'],array('controller' => 'wikiPages','action' => 'view',$wikiPage['WikiPage']['title'])); ?>&nbsp;</td>

                <td><?php echo h($wikiPage['WikiPage']['created']); ?>&nbsp;</td>
                <td><?php echo h($wikiPage['WikiPage']['modified']); ?>&nbsp;</td>
                <td>
                    <?php echo $wikiPage['Category']['name']; ?>
                </td>
                <td><?php if($wikiPage['WikiPage']['is_public']) echo '○';else echo '✕'; ?>&nbsp;</td>
            </tr>
        <?php endforeach; ?>
        </table>
        <?php echo $this->BootstrapPaginator->pagination(array('div' => 'text-center')); ?>
</div>
