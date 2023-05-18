<?php

$items = array();
$controller = 'employments';
$items['action_name'] = __d(__EMPLOYMENT_LOCALE,'employment_list');
$items['url'] = 'employment/employments';
$items['action'] = __EMPLOYMENT_PLUGIN;
$items['add_style'] =
array(/*'link'=>array(
		'title'=>__d(__EMPLOYMENT_LOCALE,'add_employment'),
		'url'  => __SITE_URL.'admin/employment/'.$controller.'/add'
	)*/
);
$items['titles'] = array(
	array('title'=> __d(__EMPLOYMENT_LOCALE,'title')),
	array('title'=> __d(__EMPLOYMENT_LOCALE,'arrangment')),
	array('title'=> __('status'),'index'=> 'status'),
	array('title'=> __('created'),'index'=> 'created'),
);

$records = $employments;

$items['show_search_box'] = FALSE;
echo $this->element('Admin/index_header', array('items'=>$items) );
if(!empty($records)){

	foreach($records as $record){
		echo "
		<tr>
		<td>
		<input type='checkbox' >
		</td>
		";
		echo "<td>".$record['Companytranslation']['title'];
		echo $this->AdminHtml->createActionLink();
		echo $this->AdminHtml->actionLink(__('edit'),__SITE_URL.'admin/employment/'.$controller.'/edit/'.$record['Company']['id'],'','|');
		echo $this->AdminHtml->actionLink(__('delete'),__SITE_URL.'admin/employment/'.$controller.'/delete/'.$record['Company']['id'],'delete');
		echo $this->AdminHtml->endActionLink();
		echo"</td>";
		echo "<td>".$record['Company']['arrangment']."</td>";
		echo "<td>";
		if($record['Company']['status'] == 0)
		{
			echo $this->AdminHtml->status(__('inactive'),array('class'=>'label label-danger'));
		}
		else echo $this->AdminHtml->status(__('active'),array('class'=>'label label-success'));
		echo"</td>";
		echo "<td>".$this->Cms->show_persian_date(" l ، j F Y    ",strtotime($record['Company']['created']))."</td>";

	}
}
echo $this->element('Admin/index_footer' );
?>

