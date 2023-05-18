<?php

class Employment extends EmploymentAppModel
{
	public $name = 'Employment';
	public $primaryKey = 'id';

	var $actsAs     = array('Containable');


	public $hasMany = array(
		'Employmenttranslation' => array(
			'className' => 'Employmenttranslation',
			'foreignKey' => 'employment_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);
}

?>
