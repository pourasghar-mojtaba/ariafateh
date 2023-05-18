<?php


$this->add_hook('admin_group_menu','project_menu');

function project_menu($arg)
{
	$active = NULL;
	$controllers = array('projects','projectcategories');
	if(in_array($arg['arguments']['controller'],$controllers)) $active= 'active';
	echo "
		<li class='treeview ".$active."'>
			<a href='#'>
				<i class='fa fa-th'>
				</i>
				<span>
					". __d(__PROJECT_LOCALE,'project_managment')."
				</span>
				<i class='fa fa-angle-left pull-right'>
				</i>
			</a> 	
			<ul class='treeview-menu'>";
			$active = NULL;
			if($arg['request']->params['controller'] == 'projectcategories')	 $active = 'class="active"';
			echo"
				<li ".$active." >
					<a href='".__SITE_URL."admin/project/projectcategories/index'>
						<i class='fa fa-circle-o'>
						</i> ".__d(__PROJECT_LOCALE,'category_managment')."
					</a>
				</li>";
			$active = NULL;
			if($arg['request']->params['controller'] == 'projects')	 $active = 'class="active"';
			echo"	
				<li ".$active."> 
					<a href='".__SITE_URL."admin/project/projects/index'>
						<i class='fa fa-circle-o'>
						</i> ". __d(__PROJECT_LOCALE,'project_managment')."
					</a>
				</li>
			</ul>
		</li>
	";

}

$this->add_hook('user_menu', 'project_user_menu');
function project_user_menu($arg)
{

	App::uses('ProjectAppModel', 'Project.Model');
	App::uses('Project', 'Project.Model');

	$lang = $arg['arguments']['lang'];

	$projects = array();
	$project = new Project();
	$project->recursive = - 1;

	$options['fields'] = array(
		'Project.id',
		'Project.slug',
		'Projecttranslation.title'
	);

	$options['joins'] = array(
		array('table'     => 'projecttranslations',
			'alias'     => 'Projecttranslation',
			'type'      => 'left',
			'conditions' => array(
				'Project.id = Projecttranslation.project_id'
			)
		),
		array('table'     => 'languages',
			'alias'     => 'Language',
			'type'      => 'left',
			'conditions' => array(
				'Language.id = Projecttranslation.language_id'
			)
		)
	);

	$options['conditions'] = array(
		'Project.status'=> 1,
		'Language.code'=>$lang
	);
	$options['order'] = array(
		'Project.id'=>'desc'
	);
	$options['limit'] = 9;
	$projects = $project->find('all',$options);
	echo "
	<li class='nav-item dropdown mega-dropdown'>
						<a class='nav-link dropdown-toggle' href='#' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
							<span class='megamenu-caret'></span>
							" . __d(__PROJECT_LOCALE, 'projects') . "</a>
						<div class='dropdown-menu mega-menu' aria-labelledy='navbarDropdown'>
							<h2 class='mega-menu-title'>
								<a href='#'>
									" . __d(__PROJECT_LOCALE, 'all_colleage_projects') . "
								</a>
							</h2>
							<div class='megamenu-row-section'>";
	$i=0;
	foreach ($projects as $project){

		if ($i % 3==0){
			echo  "
										<div class='mega-menu-column col-lg-3 col-md-4 col-sm-6'>
											<ul class='list-unstyled'>";
		}
		echo "	
											<li class='mega-menu-item'>
												<span class='item-circle-icon'><i class='fas fa-circle'></i></span>
												<a href='".__SITE_URL.__PROJECT."/".$project['Project']['slug']."'>".$project['Projecttranslation']['title']."</a>
											</li>";

		$i++;
		if ($i % 3 ==0) {
			echo "</ul>
											</div>
										";
		}


	}
	if ($i % 3 !=0) {
		echo "</ul>
										</div>
								";
	}

	echo "</div>
					</div>
	</li>";

}

/*$this->add_hook('user_menu','project_user_menu');
function project_user_menu($arg){
		_get_header_catrgories(0);
}*/

function _get_header_catrgories($parent_id) {

	App::uses('ProjectAppModel', 'Project.Model');
	App::uses('Projectcategory', 'Project.Model');

	$Projectcategory = new Projectcategory();

	$category_data = array();
	$Projectcategory->recursive=-1;
	$query=	$Projectcategory->find('all',array('fields' => array('id','slug','parent_id','title as title'),'conditions' => array('parent_id' => $parent_id,'status'=>1)));

		foreach ($query as $result) {

			$sub_query=	$Projectcategory->find('all',array('fields' => array('id','slug','parent_id','title as title'),
			'conditions' => array('parent_id' => $result['Projectcategory']['id'])));
			if(empty($sub_query)){
				echo "
					<li>
						<a class='dropdown-item' href='".__SITE_URL."project/projects/index/".$result['Projectcategory']['slug']/*."/".$result['Projectcategory']['title']*/."'  >".$result['Projectcategory']['title']."</a>
					</li>
				";
			}
			else{
				// <a href='javascript:void(0)' title='".$result['Projectcategory']['id']."' >".$result['Projectcategory']['title']."</a>
				echo "
					<li class='nav-item dropdown'> 
						<a class='nav-link dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false' href='".__SITE_URL."project/projects/search?categoryid_filter=".$result['Projectcategory']['id']."' title='".$result['Projectcategory']['id']."' >".$result['Projectcategory']['title']." <i class='fa fa-angle-down m-l-5'></i></a>
						<ul class='b-none dropdown-menu font-14 animated fadeInUp'>
				";
						_get_header_catrgories($result['Projectcategory']['id']);

				echo "  </ul>
					</li>";
				}

		}
}

$this->add_hook('home_projects','home_projects');

function home_projects($arg){

	App::uses('ProjectAppModel', 'Project.Model');
	App::uses('Projectcategory', 'Project.Model');

	App::uses('Project', 'Project.Model');
	$project = new Project();
	$options = array();
	$lang = $arg['arguments']['lang'];
	$project->recursive = - 1;
	$options['fields'] = array(
		'Project.id',
		'Project.slug',
		'Projecttranslation.title',
		'Projecttranslation.mini_detail',
		'(select image from projectimages where project_id = Project.id limit 0,1)as image'
	);

	$options['joins'] = array(
		array('table'     => 'projecttranslations',
			'alias'     => 'Projecttranslation',
			'type'      => 'left',
			'conditions' => array(
				'Project.id = Projecttranslation.project_id'
			)
		),
		array('table'     => 'languages',
			'alias'     => 'Language',
			'type'      => 'left',
			'conditions' => array(
				'Language.id = Projecttranslation.language_id'
			)
		)
	);

	$options['conditions'] = array(
		'Project.status'=> 1,
		'Language.code'=>$lang
	);
	$options['order'] = array(
		'Project.id'=>'desc'
	);
	$options['limit'] = 5;
	$projects = $project->find('all',$options);

	echo "
			<div class='content-title-row'>
				<h3 class='content-title'>" . __d(__PROJECT_LOCALE, 'last_projects') . "</h3>
			</div>
			<div class='content-main-box'>

				<div class='main-carousel-box owl-carousel' id='project-new-carousel'>";
				foreach($projects as $project){
				  echo"	
					<div class='carousel-col-box'>
						<div class='col-item-box'>
							<div class='carousel-img-box' id='carousel-light-1'>
								<img src='".__SITE_URL.__PROJECT_IMAGE_URL.__UPLOAD_THUMB.'/'.$project['0']['image']."' alt='".$project['Projecttranslation']['title']."'>
							</div>
							<div class='carousel-title-box'>
								<h3 class='carousel-title'><a href='".__SITE_URL.__PROJECT."/".$project['Project']['slug']."'>".$project['Projecttranslation']['title']."</a></h3>
							</div>
						</div>
					</div>";
				}

	echo "
			   </div>
		</div>";

}

$this->add_hook('admin_last_items','admin_last_projects');

function admin_last_projects(){

	App::uses('ProjectAppModel', 'Project.Model');
	App::uses('Project', 'Project.Model');
	$project = new Project();
	$project->recursive = - 1;
	$options = array();
	$project->recursive = - 1;
	$options['fields'] = array(
		'Project.id',
		'Projecttranslation.title',
		'(select image from projectimages where project_id = Project.id limit 0,1)as image'
	);
	$options['joins'] = array(
		array('table'     => 'projecttranslations',
			'alias'     => 'Projecttranslation',
			'type'      => 'left',
			'conditions' => array(
				'Project.id = Projecttranslation.project_id'
			)
		)
	);

	$options['conditions'] = array(
		'Project.status'=> 1
	);
	$options['order'] = array(
		'Project.id'=>'desc'
	);
	$options['limit'] = 5;
	$projects = $project->find('all',$options);

	echo "
		<div class='col-md-4'>
          <!-- PRODUCT LIST -->
          <div class='box box-primary'>
            <div class='box-header with-border'>
              <h3 class='box-title'>".__('last_projects')."</h3>

              <div class='box-tools pull-right'>
                <button type='button' class='btn btn-box-tool' data-widget='collapse'><i class='fa fa-minus'></i>
                </button>
                <button type='button' class='btn btn-box-tool' data-widget='remove'><i class='fa fa-times'></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class='box-body'>
              <ul class='products-list product-list-in-box'>
	";
	foreach($projects as $project){
		echo "
			<li class='item'>
              <div class='product-img'>
                <img src='".__SITE_URL.__PROJECT_IMAGE_URL.__UPLOAD_THUMB.'/'.$project['0']['image']."' alt='".$project['Projecttranslation']['title']."'>
              </div>
              <div class='product-info'>
                <a href='".__SITE_URL."admin/project/projects/edit/". $project['Project']['id']."'>". $project['Projecttranslation']['title']."</a>
                    <span class='product-description'>
                      
                    </span>
              </div>
            </li>
		";
	}

	echo "
			  </ul>
            </div>
            <!-- /.box-body -->
            <div class='box-footer text-center'>
              <a href='".__SITE_URL."admin/project/projects/index' class='uppercase'>". __('view_all_projects')."</a>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /.box -->
        </div>
	";
}
?>

