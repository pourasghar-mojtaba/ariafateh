<?php


$this->add_hook('admin_group_menu', 'honor_menu');

function honor_menu($arg)
{
	$active = NULL;
	$controllers = array('honors', 'honorcategories');

	if (in_array($arg['arguments']['controller'], $controllers)) $active = 'active';
	echo "
		<li class='treeview " . $active . "'>
			<a href='#'>
				<i class='fa fa-photo'>
				</i>
				<span>
					" . __d(__HONOR_LOCALE, 'honor_managment') . "
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";

	$active = NULL;
	if ($arg['arguments']['controller'] == 'honors') $active = 'class="active"';
	echo "	
				<li " . $active . "> 
					<a href='" . __SITE_URL . "admin/honor/honors/index'>
						<i class='fa fa-circle-o'>
						</i> " . __d(__HONOR_LOCALE, 'honor_managment') . "
					</a>
				</li>
			</ul>
		</li>
	";

}

$this->add_hook('user_menu', 'honor_user_menu');
function honor_user_menu($arg)
{
	echo "<li class='nav-item'>
			<a class='nav-link' href='" . __SITE_URL . __HONOR . "/honors/view'>" . __d(__HONOR_LOCALE, 'honor') . "</a>
		 </li>";
}


$this->add_hook('home_honors', 'home_honors');
function home_honors($arg)
{

	App::uses('HonorAppModel', 'Honor.Model');

	App::uses('Honor', 'Honor.Model');

	$honor = new Honor();
	$options = array();
	$lang = $arg['arguments']['lang'];
	$cms = $arg['arguments']['cms'];
	$honor->recursive = -1;
	$options['fields'] = array(
		'Honor.id',
		'Honor.created',
		'Honortranslation.title',
		'Honortranslation.detail',
		'(select image from honorimages where honor_id = Honor.id limit 0,1)as image'
	);

	$options['joins'] = array(
		array('table' => 'honortranslations',
			'alias' => 'Honortranslation',
			'type' => 'left',
			'conditions' => array(
				'Honor.id = Honortranslation.honor_id'
			)
		),
		array('table' => 'languages',
			'alias' => 'Language',
			'type' => 'left',
			'conditions' => array(
				'Language.id = Honortranslation.language_id'
			)
		)
	);

	$options['conditions'] = array(
		'Honor.status' => 1,
		'Language.code' => $lang
	);
	/*$options['order'] = array(
		'Honor.id' => 'desc'
	);*/
	//$options['limit'] = 3;
	$honors = $honor->find('first', $options);

	$options = array();
	$honor->Honorimage->recursive = - 1;
	$options['fields'] = array(
		'Honorimage.image',
		'Honorimage.honor_id',
		'Honorimagetranslation.title'
	);

	$options['joins'] = array(
		array('table'     => 'honorimagetranslations',
			'alias'     => 'Honorimagetranslation',
			'type'      => 'left',
			'conditions' => array(
				'Honorimage.id = Honorimagetranslation.honorimage_id'
			)
		),
		array('table'     => 'languages',
			'alias'     => 'Language',
			'type'      => 'left',
			'conditions' => array(
				'Language.id = Honorimagetranslation.language_id'
			)
		)
	);

	$options['conditions'] = array(
		'Language.code'=> $lang
	);
	$options['order'] = array(
		'Honorimage.id'=>'asc'
	);
	//$options['limit'] = 5;
	$honorimages = $honor->Honorimage->find('all',$options);


	echo "
		<a href='#' class='title-custom-shape'>افتخارات</a>
		<div class='main-carousel-box owl-carousel' id='winner-carousel'>";
	foreach ($honorimages as $honorimage) {
		echo "<div class='winner-present-box'>
				<div class='present-image-box col-md-5 col-12'>
					<img src='" . __SITE_URL . __HONOR_IMAGE_URL . $honorimage['Honorimage']['image'] . "' alt='winner'>
					
				</div>
				<div class='winner-content-box col-md-7 col-12'>
					<article class='winner-article'>
						<p class='winner-article-text'>
							".$cms->convert_character_editor($honors['Honortranslation']['detail'])."
						</p>
						<div class='winner-info-box'>
							 
							<a href='".__SITE_URL.__HONOR."/".str_replace(' ','-',$honors['Honortranslation']['title'])."' class='winner-more'>
								ادامه مطلب
								<span class='more-icon'>
									<i class='fal fa-angle-left'></i>
								 </span>
							</a>
						</div>
					</article>
				</div>
			</div>";
	}
	echo "</div>";

}


?>
