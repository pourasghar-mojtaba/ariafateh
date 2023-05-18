<?php

class Honorimage extends HonorAppModel {
	public $name = 'Honorimage';
	public $useTable = "honorimages";
	public $primaryKey = 'id';

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

	public $hasMany = array(
		'Honorimagetranslation' => array(
			'className' => 'Honorimagetranslation',
			'foreignKey' => 'id',
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
