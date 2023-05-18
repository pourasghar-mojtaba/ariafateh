<?php


$this->add_hook('admin_group_menu', 'investment_menu');

function investment_menu($arg)
{
	$active = NULL;
	$controllers = array('investments');
	if (in_array($arg['arguments']['controller'], $controllers)) $active = 'active';
	echo "
		<li class='treeview " . $active . "'>
			<a href='#'>
				<i class='fa fa-line-chart'>
				</i>
				<span>
					" . __d(__INVESTMENT_LOCALE, 'investment_managment') . "
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
	$active = NULL;
	if ($arg['request']->params['controller'] == 'investments') $active = 'class="active"';
	echo "	
				<li " . $active . "> 
					<a href='" . __SITE_URL . "admin/investment/investments/index'>
						<i class='fa fa-circle-o'>
						</i> " . __d(__INVESTMENT_LOCALE, 'investment_managment') . "
					</a>
				</li>
			</ul>
		</li>
	";

}

$this->add_hook('user_menu', 'investment_user_menu');
function investment_user_menu($arg)
{
	echo "<li class='nav-item'>
			<a class='nav-link' href='" . __SITE_URL . "investment'>" . __d(__INVESTMENT_LOCALE, 'investment') . "</a>
		 </li>";
}


$this->add_hook('last_investments', 'last_investment');

function last_investment($arg)
{

	App::uses('InvestmentAppModel', 'Investment.Model');
	App::uses('Investment', 'Investment.Model');

	$investment = new Investment();
	$investment->recursive = -1;
	$lang = $arg['arguments']['lang'];
	$options['fields'] = array(
		'Investment.id',
		'Investmenttranslation.title',
		'Investment.image'
	);
	$options['joins'] = array(
		array('table' => 'investmenttranslations',
			'alias' => 'Investmenttranslation',
			'type' => 'left',
			'conditions' => array(
				'Investment.id = Investmenttranslation.investment_id'
			)
		),
		array('table' => 'languages',
			'alias' => 'Language',
			'type' => 'left',
			'conditions' => array(
				'Language.id = Investmenttranslation.language_id'
			)
		)
	);

	$options['conditions'] = array(
		'Investment.status' => 1,
		'Language.code' => $lang
	);
	$options['order'] = array(
		'Investment.arrangment' => 'asc'
	);
	//$options['limit'] = 12;
	$investments = $investment->find('all', $options);

	echo "
		<div class='content-title-row'>
				<h3 class='content-title'>" . __d(__INVESTMENT_LOCALE, 'investments') . "</h3>
			</div>
			<div class='content-main-box'>
				<div class='main-carousel-box  owl-carousel' id='investment-carousel'>";
				foreach ($investments as $investment) {
					echo "<div class='carousel-col-box'>
							<div class='carousel-img-box'>
								<a href='".__SITE_URL.__INVESTMENT."/".str_replace(' ','-',$investment['Investmenttranslation']['title'])."'>
									<img src='" . __SITE_URL . __INVESTMENT_IMAGE_URL . $investment['Investment']['image'] . "' alt='" . $investment['Investmenttranslation']['title'] . "'>
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

