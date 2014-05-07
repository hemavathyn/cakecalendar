<?php
App::uses('AppModel', 'Model');
/**
 * Event Model
 *
 */
class Event extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'title';
	var $name = 'Event';
	var $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
		'start' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		)
	);
	public function isOwnedBy($event, $user) {
			return $this->field('id', array('id' => $event, 'user_id' => $user)) !== false;
	}
}
?>