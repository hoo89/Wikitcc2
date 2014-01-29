<div class="users form">
<?php echo $this->Session->flash('auth', array('element' => 'failure')); ?>
<?php echo $this->Form->create('User'); ?>
    <fieldset>
        <legend><?php echo __('ユーザ名とパスワードを入力してください.'); ?></legend>
        <div class="col-md-4 col-sm-5">
        <?php echo $this->Form->input('username',array('label'=>'ユーザ名','class'=>'form-control'));
        echo $this->Form->input('password',array('label'=>'パスワード','class'=>'form-control'));
        ?>
        </div>
    </fieldset>
<?php echo $this->Form->end(array('label'=>'ログイン','class'=>'btn btn-default')); ?>
</div>
