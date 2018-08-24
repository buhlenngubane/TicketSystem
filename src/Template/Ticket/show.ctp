<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">Ticket Details</div>
				<?= $this->Form->create() ?>
					<fieldset>
						<legend><?= __('Ticket logged by '.$ticket->name) ?></legend>
						<?= $this->Form->control('', ['label' => 'TicketId','value' => $ticket->id, 'disabled' => true]) ?>
						<?= $this->Form->control('ticket', [ 'label' => 'Ticket logged',
						'value' => $ticket->ticket,
						'type' => 'textarea',
						'disabled' => true]); ?>
						<?= $this->Form->control('status', ['value' => $ticket->status, 'disabled' => true]) ?>
					</fieldset>
				<?= $this->Form->end() ?>
				</div>
			</div>
		</div>
	</div>
</div>