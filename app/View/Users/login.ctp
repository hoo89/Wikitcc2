<div class="users form">
<?php echo $this->Session->flash('auth', array('element' => 'failure')); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('ユーザ名とパスワードを入力してください.'); ?></legend>
        <div class="col-sm-3">
        <?php echo $this->Form->input('username',array('label'=>'ユーザ名','class'=>'form-control col-sm-2'));
        echo $this->Form->input('password',array('label'=>'パスワード','class'=>'form-control col-sm-2'));
        ?>
        </div>
    </fieldset>
<?php echo $this->Form->end(array('label'=>'ログイン','class'=>'btn btn-default')); ?>
</div>
