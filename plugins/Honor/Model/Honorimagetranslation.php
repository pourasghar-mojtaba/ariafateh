<?php

class Honorimagetranslation extends HonorAppModel {

	var $actsAs = array('Containable');



 	public $belongsTo = array(

		'Honorimage' => array(
			'className' => 'Honorimage',
			'foreignKey' => 'honorimage_id',
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
