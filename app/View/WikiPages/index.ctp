<?php 
    $this->assign('title', 'ページ一覧');
    $this->assign('rss', $this->Html->meta('京都工芸繊維大学コンピュータ部',$this->Html->url().'.rss',array('type' => 'rss')));
    if(!empty($searchword)) $this->BootstrapPaginator->options(array('url' => $searchword));
    $this->assign('script','<script>$(function(){
                $(".edit").hide();
                $("#editEnable").click(function(){
                    $(".edit").toggle();
                    $(this).toggleClass("active");
                });
                $("#checkAll").click(function(){
                    $(".checkbox").prop("checked", $(this).prop("checked"));
                });
            });</script>');
?>

<div> 
    <p>
        <?php echo $this->BootstrapPaginator->counter(array('format' => __('{:pages}ページ中 {:page}ページ目 &nbsp;&nbsp;{:count}記事中 {:start}-{:end}記事を表示')));?>
    </p>
    <?php if(!empty($categoryList)){ ?>
    <div class="control-group">
    <button type="button" class="btn btn-default btn-sm" id="editEnable">カテゴリー変更</button>
    </div>
    <div class="edit">
        左のチェックが入っているページのカテゴリーをまとめて変更できます.<br />
        すべてにチェックを入れたい時は一番上のチェックを押してください.<br />
    </div>
    <?php
    echo $this->Form->create('WikiPage');
    echo $this->Form->select('category_id', $categoryList, array('empty' => '------','class'=>'edit'));
    echo $this->Form->submit('カテゴリーを変更する',array('class'=>'btn btn-sm btn-primary edit'));
    }?>
    <table class="table table-hover">
        <tr>
            <th class="edit"><input id="checkAll" type="checkbox" value="dummy" label="全選択"></th>
            <th><?php echo $this->BootstrapPaginator->sort('title','タイトル');?></th>
            <th><?php echo $this->BootstrapPaginator->sort('modified','更新日時');?></th>
            <th><?php echo $this->BootstrapPaginator->sort('created','作成日時');?></th>
            <th><?php echo $this->BootstrapPaginator->sort('category_id','カテゴリー');?></th>
            <th><?php echo $this->BootstrapPaginator->sort('is_public','外部公開');?></th>
        </tr>
    <?php foreach ($wikiPages as $wikiPage): ?>
        <tr>
            <td class="edit"><?php echo $this->Form->input('WikiPage.id.'.$wikiPage['WikiPage']['id'], array('type' => 'checkbox', 'multiple' => 'checkbox', 'class'=>'checkbox edit'));?></td>
            <td><?php echo $this->Html->link($wikiPage['WikiPage']['title'],array('controller' => 'wikiPages','action' => 'view',$wikiPage['WikiPage']['title'])); ?>&nbsp;</td>
            <td><?php echo h($wikiPage['WikiPage']['modified']); ?>&nbsp;</td>
            <td><?php echo h($wikiPage['WikiPage']['created']); ?>&nbsp;</td>
            <td><?php echo $wikiPage['Category']['name']; ?></td>
            <td><?php if($wikiPage['WikiPage']['is_public']) echo '○';else echo '✕'; ?>&nbsp;</td>
        </tr>
    <?php endforeach; ?>
    </table>

    <?php if(!empty($categoryList)) echo $this->Form->end(); ?>
    <?php echo $this->BootstrapPaginator->pagination(array('div' => 'text-center')); ?>
</div>
