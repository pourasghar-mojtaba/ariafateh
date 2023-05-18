<?php

class Investment extends InvestmentAppModel
{
	public $name = 'Investment';
	public $primaryKey = 'id';

	var $actsAs     = array('Containable');


	public $hasMany = array(
		'Investmenttranslation' => array(
			'className' => 'Investmenttranslation',
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
		),
	);
}

?>
