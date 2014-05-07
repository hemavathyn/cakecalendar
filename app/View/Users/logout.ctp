<h2>Logout</h2>
<?php
	echo $this->Form->create('User', array(
			'url' => array(
			'controller' => 'users',
			'action' => 'login'
			)
	));

echo $this->Form->end('Logout');
?>