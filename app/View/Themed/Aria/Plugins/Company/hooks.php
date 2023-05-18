<?php


$this->add_hook('admin_group_menu', 'company_menu');

function company_menu($arg)
{
	$active = NULL;
	$controllers = array('companies');
	if (in_array($arg['arguments']['controller'], $controllers)) $active = 'active';
	echo "
		<li class='treeview " . $active . "'>
			<a href='#'>
				<i class='fa fa-briefcase'>
				</i>
				<span>
					" . __d(__COMPANY_LOCALE, 'company_managment') . "
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
	$active = NULL;
	if ($arg['request']->params['controller'] == 'companies') $active = 'class="active"';
	echo "	
				<li " . $active . "> 
					<a href='" . __SITE_URL . "admin/company/companies/index'>
						<i class='fa fa-circle-o'>
						</i> " . __d(__COMPANY_LOCALE, 'company_managment') . "
					</a>
				</li>
			</ul>
		</li>
	";

}

$this->add_hook('user_menu', 'company_user_menu');
function company_user_menu($arg)
{

	App::uses('CompanyAppModel', 'Company.Model');
	App::uses('Company', 'Company.Model');

	$lang = $arg['arguments']['lang'];

	$companys = array();
	$company = new Company();
	$company->recursive = -1;
	$options['fields'] = array(
		'Company.id',
		'Companytranslation.detail',
		'Companytranslation.title'
	);

	$options['joins'] = array(
		array('table' => 'companytranslations',
			'alias' => 'Companytranslation',
			'type' => 'left',
			'conditions' => array(
				'Company.id = Companytranslation.company_id'
			)
		),
		array('table' => 'languages',
			'alias' => 'Language',
			'type' => 'left',
			'conditions' => array(
				'Language.id = Companytranslation.language_id'
			)
		)
	);

	$options['conditions'] = array(
		'Company.status' => 1,
		'Language.code' => $lang
	);
	$options['order'] = array(
		'Company.arrangment' => 'asc'
	);
	$options['limit'] = 5;
	$companies = $company->find('all', $options);

	echo "
	<li class='nav-item dropdown mega-dropdown'>
						<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
							<span class='megamenu-caret'></span>
							" . __d(__COMPANY_LOCALE, 'companies') . "</a>
						<div class='dropdown-menu mega-menu' aria-labelledy='navbarDropdown'>
							<h2 class='mega-menu-title'>
								<a href='#'>
									" . __d(__COMPANY_LOCALE, 'all_colleage_companies') . "
								</a>
							</h2>
							<div class='megamenu-row-section'>";
	$i = 0;
	foreach ($companies as $company) {

		if ($i % 3 == 0) {
			echo "
										<div class='mega-menu-column col-lg-3 col-md-4 col-sm-6'>
											<ul class='list-unstyled'>";
		}
		echo "	
											<li class='mega-menu-item'>
												<span class='item-circle-icon'><i class='fas fa-circle'></i></span>
												<a href='" . __SITE_URL . __COMPANY . "/" . str_replace(' ', '-', $company['Companytranslation']['title']) . "'>" . $company['Companytranslation']['title'] . "</a>
											</li>";

		$i++;
		if ($i % 3 == 0) {
			echo "</ul>
										</div>
									";
		}


	}
	if ($i % 3 != 0) {
		echo "</ul>
										</div>
								";
	}

	echo "</div>
					</div>
	</li>";

}


$this->add_hook('last_companies', 'last_company');

function last_company($arg)
{

	App::uses('CompanyAppModel', 'Company.Model');
	App::uses('Company', 'Company.Model');

	$company = new Company();
	$company->recursive = -1;
	$lang = $arg['arguments']['lang'];
	$options['fields'] = array(
		'Company.id',
		'Companytranslation.title',
		'Company.image'
	);
	$options['joins'] = array(
		array('table' => 'companytranslations',
			'alias' => 'Companytranslation',
			'type' => 'left',
			'conditions' => array(
				'Company.id = Companytranslation.company_id'
			)
		),
		array('table' => 'languages',
			'alias' => 'Language',
			'type' => 'left',
			'conditions' => array(
				'Language.id = Companytranslation.language_id'
			)
		)
	);

	$options['conditions'] = array(
		'Company.status' => 1,
		'Language.code' => $lang
	);
	$options['order'] = array(
		'Company.arrangment' => 'asc'
	);
	$options['limit'] = 5;
	$companies = $company->find('all', $options);

	echo "
		<div class='content-title-row'>
				<h3 class='content-title'>" . __d(__COMPANY_LOCALE, 'companies') . "</h3>
			</div>
			<div class='content-main-box'>
				<div class='main-carousel-box  owl-carousel' id='company-carousel'>";
				foreach ($companies as $company) {
					echo "<div class='carousel-col-box'>
							<div class='carousel-img-box'>
								<a href='".__SITE_URL.__COMPANY."/".str_replace(' ','-',$company['Companytranslation']['title'])."'>
									<img src='" . __SITE_URL . __COMPANY_IMAGE_URL . $company['Company']['image'] . "' alt='" . $company['Companytranslation']['title'] . "'>
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

