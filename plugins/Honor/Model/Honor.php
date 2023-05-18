<?php

class Honor extends HonorAppModel {

	var $actsAs = array('Containable');



 	public $hasMany = array(
        'Honorimage' => array(
			'className' => 'Honorimage',
			'foreignKey' => 'honor_id',
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
		'Honortranslation' => array(
			'className' => 'Honortranslation',
			'foreignKey' => 'honor_id',
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
