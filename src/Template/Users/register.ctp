<div class="users form">
<?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?= $this->Form->control('username', ['type' => 'email']) ?>
        <?= $this->Form->control('password', ['type' => 'password']) ?>
        <?= $this->Form->control('role', [
            'options' => ['sales' => 'Sales', 'accounts' => 'Accounts', 'it' => 'IT']
        ]) ?>
   </fieldset>
<?= $this->Form->button(__('Submit')); ?>
<?= $this->Form->end() ?>
<br />
                    <div>
                      <h5><?= $this->Html->link('Have account? Login here', '/users/login', ['class' => 'btn btn-link']); ?> </h5>
                    </div>
	<br />
</div>