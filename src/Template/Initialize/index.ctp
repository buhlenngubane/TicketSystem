<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-success">
                <div class="panel-heading">Ticket System</div>


					<?php if($loggedIn): ?>
						<br />
						<?= $this->Html->link('Logout', '/users/logout', ['class' => 'btn btn-danger']); ?>

						<hr />

						<br/>
						<br/>
						<h5> Create/Edit Ticket</h5>
						  <br/>
						  <?= $this->Html->link('Create Ticket', '/Ticket/add', ['class' => 'btn btn-info']); ?> 
						  <br/>
						  <br/>
						  <?= $this->Html->link('Edit Ticket', '/Ticket/edit', ['class' => 'btn btn-info']); ?> 
							
					<?php elseif(!$connected): ?>
						<br />
						<div align="center">
						<?= $this->Form->create() ?>
							<fieldset>
							  <legend><?= __('Please enter your username and/or password') ?></legend>
							  <?= $this->Form->control('Username') ?>
							  <?= $this->Form->control('Password', ['type' => 'password']) ?>
							  
							</fieldset>
							<?= $this->Form->button(__('Insert'), ['class' => 'btn btn-info']); ?>
						<?= $this->Form->end() ?>
						  
						</div>
					<?php else : ?>
						<br />
						<div align="center">
						  <h5> You need to login/register to load ticket</h5>
						  <br/>
						  <?= $this->Html->link('Login', '/users/login', ['class' => 'btn btn-info']); ?> 
						</div>
                  <?php endif; ?>


            </div>
        </div>
    </div>
</div>