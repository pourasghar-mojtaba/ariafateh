<?php

class Projectcategorytranslation extends ProjectAppModel {
	public $name = 'Projectcategorytranslation';

	public $primaryKey = 'id';

	var $actsAs = array('Containable');


	public $belongsTo = array(

		'Projectcategory' => array(
			'className' => 'Projectcategory',
			'foreignKey' => 'project_category_id',
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
