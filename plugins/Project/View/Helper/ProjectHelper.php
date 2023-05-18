<?php

class ProjectHelper extends AppHelper
{

	public $helpers = array('Html','Session');

	function categoryToList($projectcategories,$noParent= FALSE)
	{
		$category_list = array();
		if($noParent){
			$category_list[0] = __d(__PROJECT_LOCALE,'with_out_parent');
		}
		if(!empty($projectcategories))
		{
			foreach($projectcategories as $project_category){
				$category_list[$project_category['id']] = $project_category['title'];
			}
		}
		return $category_list;
	}




}






?>
