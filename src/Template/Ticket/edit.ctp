
<?= $this->Form->create() ?>
	<fieldset>
		<legend><?= __('Please specify ticket status') ?></legend>
		<?= $this->Form->control('id', ['type' => 'number'])?>
		<?= $this->Form->control('status', [
            'options' => ['newly logged' => 'Newly Logged', 'in progress' => 'In Progress', 'resolved' => 'Resolved']
        ]) ?>
	</fieldset>
<?= $this->Form->button(__('Edit Tickect'), ['class' => 'btn btn-info']); ?>
<br/>
<div align='right'>
	<?= $this->Html->link('Logout', '/users/logout', ['class' => 'btn btn-link']); ?> 
</div>
<?= $this->Form->end() ?>