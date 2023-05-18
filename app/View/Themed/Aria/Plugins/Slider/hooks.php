<?php


$this->add_hook('admin_group_menu','slider_menu');

function slider_menu($arg)
{
	$active = NULL;
	$controllers = array('sliders');
	if(in_array($arg['arguments']['controller'],$controllers)) $active= 'active';
	echo "
		<li class='treeview ".$active."'>
			<a href='#'>
				<i class='fa fa-dashcube'>
				</i>
				<span>
					". __d(__SLIDER_LOCALE,'slider_managment')."
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
			$active = NULL;
			if($arg['arguments']['controller'] == 'banners')	 $active = 'class="active"';
			echo"	
				<li ".$active."> 
					<a href='".__SITE_URL."admin/slider/sliders/index'>
						<i class='fa fa-circle-o'>
						</i> ". __d(__SLIDER_LOCALE,'slider_managment')."
					</a>
				</li>
			</ul>
		</li>
	";

}


$this->add_hook('last_slider','last_slider');

function last_slider($arg){

	App::uses('SliderAppModel', 'Slider.Model');
	App::uses('Slider', 'Slider.Model');

	$lang = $arg['arguments']['lang'];


	$sliders = array();
	$slider = new Slider();
	$slider->recursive = - 1;
	$options['fields'] = array(
		'Slider.id',
		'Slidertranslation.url',
		'Slidertranslation.detail',
		'Slidertranslation.title',
		'Slidertranslation.image'
	);

	$options['joins'] = array(
		array('table'     => 'slidertranslations',
			'alias'     => 'Slidertranslation',
			'type'      => 'left',
			'conditions' => array(
				'Slider.id = Slidertranslation.slider_id'
			  )
			),
		array('table'     => 'languages',
			'alias'     => 'Language',
			'type'      => 'left',
			'conditions' => array(
				'Language.id = Slidertranslation.language_id'
			)
		  )
	);

	$options['conditions'] = array(
		'Slider.status'=> 1,
		'Language.code'=>$lang
	);
	$options['order'] = array(
			'Slider.arrangment'=>'asc'
	);
	//$options['limit'] = 5;
	$sliders = $slider->find('all',$options);

	foreach($sliders as $slider){

		echo "
			<div class='slider-item'>
					<img src='".__SITE_URL.__SLIDER_IMAGE_URL."/".$slider['Slidertranslation']['image']."' alt='".$slider['Slidertranslation']['title']."'>
					<div class='caption-box'>
						<h2 class='caption-title'>".$slider['Slidertranslation']['title']."</h2>
						<p class='caption-text'>".$slider['Slidertranslation']['detail']."</p>
					</div>
				</div>
		";
	}

}
?>
