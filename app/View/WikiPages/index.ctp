<?php 
    $this->assign('title', 'ページ一覧');
    $this->assign('rss', '<link rel="alternate" type="application/rss+xml" href=".rss" title="RSS2.0" />');
?>

<div class="row">
    <div class="span9">
        <p>
            <?php echo $this->BootstrapPaginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')));?>
        </p>

        <table class="table">
            <tr>
                <th><?php echo $this->BootstrapPaginator->sort('id');?></th>
                <th><?php echo $this->BootstrapPaginator->sort('title');?></th>
                <th><?php echo $this->BootstrapPaginator->sort('created');?></th>
                <th><?php echo $this->BootstrapPaginator->sort('modified');?></th>
                <th><?php echo $this->BootstrapPaginator->sort('category_id');?></th>
                <th><?php echo $this->BootstrapPaginator->sort('is_public');?></th>
                <th><?php echo $this->BootstrapPaginator->sort('format');?></th>
                
                <th class="actions"><?php echo __('Actions');?></th>
            </tr>
        <?php foreach ($wikiPages as $wikiPage): ?>
            <tr>
                <td><?php echo h($wikiPage['WikiPage']['id']); ?>&nbsp;</td>
                <td><?php echo h($wikiPage['WikiPage']['title']); ?>&nbsp;</td>

                <td><?php echo h($wikiPage['WikiPage']['created']); ?>&nbsp;</td>
                <td><?php echo h($wikiPage['WikiPage']['modified']); ?>&nbsp;</td>
                <td>
                    <?php echo $this->Html->link($wikiPage['Category']['name'], array('controller' => 'categories', 'action' => 'view', $wikiPage['Category']['id'])); ?>
                </td>
                <td><?php echo h($wikiPage['WikiPage']['is_public']); ?>&nbsp;</td>
                <td><?php echo h($wikiPage['WikiPage']['format']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $wikiPage['WikiPage']['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $wikiPage['WikiPage']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $wikiPage['WikiPage']['id']), null, __('Are you sure you want to delete # %s?', $wikiPage['WikiPage']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </table>

        <?php echo $this->BootstrapPaginator->pagination(array('div' => 'text-center')); ?>
    </div>
    <div class="span3">
        <div class="well" style="padding: 8px 0; margin-top:8px;">
        <ul class="nav nav-list">
            <li class="nav-header"><?php echo __('Actions'); ?></li>
            <li><?php echo $this->Html->link(__('New %s', __('Wiki Page')), array('action' => 'add')); ?></li>
            <li><?php echo $this->Html->link(__('List %s', __('Categories')), array('controller' => 'categories', 'action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__('New %s', __('Category')), array('controller' => 'categories', 'action' => 'add')); ?> </li>
            <li><?php echo $this->Html->link(__('List %s', __('Attachments')), array('controller' => 'attachments', 'action' => 'index')); ?> </li>
            <li><?php echo $this->Html->link(__('New %s', __('Attachment')), array('controller' => 'attachments', 'action' => 'add')); ?> </li>
        </ul>
        </div>
    </div>
</div>
<!--
<table class="table">
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Action</th>
        <th>Created</th>
        <th>Category</th>
    </tr>

    <?php foreach ($posts as $post): ?>
    <tr>
        <td><?php echo $post['WikiPage']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($post['WikiPage']['title'],
array('controller' => 'wikiPages', 'action' => 'view', $post['WikiPage']['title'])); ?>
        </td>
        <td>
            <?php echo $this->Form->postLink(
                'Delete',
                array('action' => 'delete', $post['WikiPage']['title']),
                array('confirm' => 'このページを削除してよろしいですか？'));
            ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $post['WikiPage']['title'])); ?>
        </td>
        <td><?php echo $post['WikiPage']['created']; ?></td>
        <td><?php echo $post['WikiPage']['category_id']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($post); ?>
</table>
-->