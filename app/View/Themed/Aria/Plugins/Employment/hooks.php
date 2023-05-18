<?php


$this->add_hook('admin_group_menu', 'admin_employment_menu');


function admin_employment_menu($arg)
{
	$active = NULL;
	$controllers = array('employments');
	if (in_array($arg['arguments']['controller'], $controllers)) $active = 'active';
	echo "
		<li class='treeview " . $active . "'>
			<a href='#'>
				<i class='fa fa-user'>
				</i>
				<span>
					" . __d(__EMPLOYMENT_LOCALE, 'employment_managment') . "
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
	$active = NULL;
	if ($arg['request']->params['controller'] == 'employments') $active = 'class="active"';
	echo "	
				<li " . $active . "> 
					<a href='" . __SITE_URL . "admin/employment/employments/index'>
						<i class='fa fa-circle-o'>
						</i> " . __d(__EMPLOYMENT_LOCALE, 'employment_managment') . "
					</a>
				</li>
			</ul>
		</li>
	";

}

$this->add_hook('user_menu', 'employment_menu');
function employment_menu($arg)
{
	echo "<li class='nav-item'>
			<a class='nav-link' href='" . __SITE_URL . "employment'>" . __d(__EMPLOYMENT_LOCALE, 'employment') . "</a>
		 </li>";
}





$this->add_hook('last_employments', 'last_employment');

function last_employment($arg)
{

	App::uses('EmploymentAppModel', 'Employment.Model');
	App::uses('Employment', 'Employment.Model');

	$employment = new Employment();
	$employment->recursive = -1;
	$lang = $arg['arguments']['lang'];
	$options['fields'] = array(
		'Employment.id',
		'Employmenttranslation.title',
		'Employment.image'
	);
	$options['joins'] = array(
		array('table' => 'employmenttranslations',
			'alias' => 'Employmenttranslation',
			'type' => 'left',
			'conditions' => array(
				'Employment.id = Employmenttranslation.employment_id'
			)
		),
		array('table' => 'languages',
			'alias' => 'Language',
			'type' => 'left',
			'conditions' => array(
				'Language.id = Employmenttranslation.language_id'
			)
		)
	);

	$options['conditions'] = array(
		'Employment.status' => 1,
		'Language.code' => $lang
	);
	$options['order'] = array(
		'Employment.arrangment' => 'asc'
	);
	//$options['limit'] = 12;
	$employments = $employment->find('all', $options);

	echo "
		<div class='content-title-row'>
				<h3 class='content-title'>" . __d(__EMPLOYMENT_LOCALE, 'employments') . "</h3>
			</div>
			<div class='content-main-box'>
				<div class='main-carousel-box  owl-carousel' id='employment-carousel'>";
				foreach ($employments as $employment) {
					echo "<div class='carousel-col-box'>
							<div class='carousel-img-box'>
								<a href='".__SITE_URL.__EMPLOYMENT."/".str_replace(' ','-',$employment['Employmenttranslation']['title'])."'>
									<img src='" . __SITE_URL . __EMPLOYMENT_IMAGE_URL . $employment['Employment']['image'] . "' alt='" . $employment['Employmenttranslation']['title'] . "'>
								</a>
							</div>
						  </div>";
				}
		echo "				
				</div>
			</div>
		";
}


?>

