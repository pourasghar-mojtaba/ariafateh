<?php
App::uses('AppModel', 'Model');

class Page extends AppModel
{
	public
	function _getPageInfo($id)
	{
		$options['fields'] = array(
			'Page.id',
			'Page.title',
			'Page.body',
			'Page.meta' ,
			'Page.keyword'
		);

		$options['conditions'] = array(
			'Page.id'=> $id
		);
		$page = $this->find('first',$options);
		return $page;
	}

}
?>