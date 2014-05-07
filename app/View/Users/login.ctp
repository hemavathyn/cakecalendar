<h2>Login</h2>
<?php
	echo $this->Form->create('user',array('action'=>'login'));
echo $this->Form->input('User.username');
echo $this->Form->input('User.password');
echo $this->Form->end('Login');
echo $this->Html->link( "register",   array('controller' => 'users', 'action'=>'add') );
?>