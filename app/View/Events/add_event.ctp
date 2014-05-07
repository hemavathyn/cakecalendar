<div class="events form">
<?php echo $this->Form->create('Event'); ?>
	<fieldset>
		<legend><?php echo __('Add Event'); ?></legend>
	<?php
		echo $this->Form->input('title');
		echo $this->Form->input('details');
		echo $this->Form->input('start');
		echo $this->Form->input('end');
	?>
	</fieldset>
	  
 <?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('View calendar',true), array('controller' => 'events','action' => 'index')); ?></li>
	</ul>
</div>
<?php echo $this->Html->link( "Logout",   array('controller' => 'users', 'action'=>'login') );?>