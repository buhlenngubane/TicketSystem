
<div align="center">
	<?= $this->Form->create() ?>
		<fieldset>
		  <legend><?= __('Please enter your username and/or password') ?></legend>
		  <?= $this->Form->control('Username') ?>
		  <?= $this->Form->control('Password', ['type' => 'password']) ?>
		  
		</fieldset>
		<?= $this->Form->button(__('Check'), ['class' => 'btn btn-info']); ?>
	<?= $this->Form->end() ?>
  
</div>