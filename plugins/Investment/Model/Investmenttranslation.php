<?php

class Investmenttranslation extends InvestmentAppModel {
	public $name = 'Investmenttranslation';

	public $primaryKey = 'id';

	var $actsAs = array('Containable');


	public $belongsTo = array(
		'Investment' => array(
			'className' => 'Investment',
			'foreignKey' => 'investment_id',
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
