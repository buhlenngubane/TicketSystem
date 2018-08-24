<div class="ticket form">
	<?= $this->Form->create($ticket) ?>
		<fieldset>
			<legend><?= __('Please enter ticket details') ?></legend>
			<?= $this->Form->control('name') ?>
			<?= $this->Form->control('surname') ?>
			<?= $this->Form->control('email', ['type' => 'email']) ?>
			<?= $this->Form->control('phoneNo') ?>
			<?= $this->Form->textarea('ticket', ['rows' => '5', 'cols' => '5']);?>
			<?= $this->Form->control('status', [
            'options' => ['newly logged' => 'Newly Logged', 'in progress' => 'In Progress', 'resolved' => 'Resolved']
        ]) ?>
		</fieldset>

	<?= $this->Form->button(__('Send Tickect'), ['class' => 'btn btn-info']); ?>
	<?= $this->Form->end() ?>
</div>
