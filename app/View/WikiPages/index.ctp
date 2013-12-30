<?php 
    $this->assign('title', '<h3>ページ一覧</h3>');
    echo $this->Html->link(
    'Add WikiPage',
    array('controller' => 'wikiPages', 'action' => 'add')
); ?>

<table class="table">
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Action</th>
        <th>Created</th>
        <th>Category</th>
    </tr>

    <!-- ここから、$posts配列をループして、投稿記事の情報を表示 -->

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
                array('confirm' => 'Are you sure?'));
            ?>
            <?php echo $this->Html->link('Edit', array('action' => 'edit', $post['WikiPage']['title'])); ?>
        </td>
        <td><?php echo $post['WikiPage']['created']; ?></td>
        <td><?php echo $post['WikiPage']['category_id']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($post); ?>
</table>
