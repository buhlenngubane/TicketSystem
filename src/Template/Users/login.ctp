<div class="users form">
<?= $this->Flash->render() ?>
  <?= $this->Form->create() ?>
      <fieldset>
        <legend><?= __('Please enter your username and password') ?></legend>
        <?= $this->Form->control('username', ['type' => 'email']) ?>
        <?= $this->Form->control('password', ['type' => 'password']) ?>
		<?= $this->Form->control('role', [
            'options' => ['sales' => 'Sales', 'accounts' => 'Accounts', 'it' => 'IT']
        ]) ?>
    </fieldset>
	  
  <?= $this->Form->button(__('Login'), ['class' => 'btn btn-info']); ?>
  <?= $this->Form->end() ?>
</div>