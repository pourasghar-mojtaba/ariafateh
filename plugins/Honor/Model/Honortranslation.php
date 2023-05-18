<?php

class Honortranslation extends HonorAppModel {

	var $actsAs = array('Containable');



 	public $belongsTo = array(

		'Honor' => array(
			'className' => 'Honor',
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
