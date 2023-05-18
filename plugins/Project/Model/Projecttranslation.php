<?php

class Projecttranslation extends ProjectAppModel {
	public $name = 'Projecttranslation';

	public $primaryKey = 'id';

	var $actsAs = array('Containable');


	public $belongsTo = array(

		'Project' => array(
			'className' => 'Project',
			'foreignKey' => 'project_id',
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
