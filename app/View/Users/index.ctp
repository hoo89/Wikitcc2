<?php 
    $this->assign('title', '<h3>ページ一覧</h3>');
    echo $this->Html->link(
    'Add User',
    array('controller' => 'Users', 'action' => 'add')
); ?>

<table class="table">
    <tr>
        <th>Id</th>
        <th>Name</th>
        <th>Pass</th>
        <th>Created</th>
    </tr>

    <!-- ここから、$users配列をループして、投稿記事の情報を表示 -->

    <?php foreach ($users as $post): ?>
    <tr>
        <td><?php echo $post['User']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($post['User']['username'],
array('controller' => 'Users', 'action' => 'view', $post['User']['id'])); ?>
        </td>
        <td><?php echo $post['User']['password']; ?></td>
        <td><?php echo $post['User']['created']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($post); ?>
</table>
