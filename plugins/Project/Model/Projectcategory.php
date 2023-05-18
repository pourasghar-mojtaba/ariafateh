<?php

class Projectcategory extends ProjectAppModel
{
	public $name = 'Projectcategory';
	//public $useTable = "projectcategories";
	public $primaryKey = 'id';

	var $actsAs     = array('Containable');

	public $hasMany = array(
		'Project' => array(
			'className'   => 'Project',
			'foreignKey'  => 'id',
			'dependent'   => false,
			'conditions'  => '',
			'fields'      => '',
			'order'       => '',
			'limit'       => '',
			'offset'      => '',
			'exclusive'   => '',
			'finderQuery' => '',
			'counterQuery'=> ''
		),
		'Projectcategorytranslation' => array(
			'className' => 'Projectcategorytranslation',
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

	public
	function _getCategories($parent_id, $lang)
	{
		$category_data = array();
		$this->recursive = -1;
		$query = $this->find('all',array('fields'=> array('id','parent_id'),'conditions' => array('parent_id'=> $parent_id)));

		foreach ($query as $result) {
			$category_data[] = array(
				'id' => $result['Projectcategory']['id'],
				'title' => $this->_getPath($result['Projectcategory']['id'],$lang)
			);

			$category_data = array_merge($category_data, $this->_getCategories($result['Projectcategory']['id'],$lang));
		}
		return $category_data;
	}

	public
	function _getPath($category_id,$lang)
	{
		$this->recursive = -1;

		$options = array();
		$options['fields'] = array(
			'Projectcategory.id',
			'Projectcategory.arrangment',
			'Projectcategory.parent_id',
			'Projectcategory.status',
			'Projectcategory.created',
			'Projectcategorytranslation.title',
			'Projectcategorytranslation.project_category_id',
			'Projectcategory.slug',
		);
		$options['joins'] = array(
			array('table' => 'projectcategorytranslations',
				'alias' => 'Projectcategorytranslation',
				'type' => 'left',
				'conditions' => array(
					'Projectcategory.id = Projectcategorytranslation.project_category_id',
					"Projectcategorytranslation.language_id" => $lang
				)
			)
		);

		$options['conditions'] = array(
			"Projectcategory.id" => $category_id,
		);

		$query = $this->find('all',$options);
		//$query = $this->find('all', array('fields' => array('id', 'parent_id', 'title as title'), 'conditions' => array('id' => $category_id)));

		foreach ($query as $category_info) {
			if ($category_info['Projectcategory']['parent_id']) {
				return $this->_getPath($category_info['Projectcategory']['parent_id'],$lang) .
					" > " . $category_info['Projectcategorytranslation']['title'];
			} else {
				return $category_info['Projectcategorytranslation']['title'];
			}
		}
	}


}

?>
