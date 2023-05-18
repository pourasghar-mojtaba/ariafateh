<?php

class Employmenttranslation extends EmploymentAppModel {
	public $name = 'Employmenttranslation';

	public $primaryKey = 'id';

	var $actsAs = array('Containable');


	public $belongsTo = array(
		'Employment' => array(
			'className' => 'Employment',
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
		)
	);



}

?>
