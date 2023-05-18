<?php


App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class CompaniesController extends CompanyAppController
{

	/*public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('view','get_child_companies');
	}*/

	/**
	 * Controller name
	 *
	 * @var string
	 */
	public $name = 'Companies';
	public $helpers = array('AdminHtml' => array('action' => 'Company'));

	/**
	 * This controller does not use a model
	 *
	 * @var array
	 */
	public $uses = array();

	/**
	 * Displays a view
	 *
	 * @param mixed What company to display
	 * @return void
	 */

	public
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('view', 'last');
	}

	function admin_index()
	{

		$this->set('title_for_layout', __d(__COMPANY_LOCALE, 'company_list'));
		//$this->Company->recursive = - 1;
		if (isset($_REQUEST['filter'])) {
			$limit = $_REQUEST['filter'];
		} else $limit = 10;

		if (isset($this->request->data['Company']['search'])) {
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields' => array(
					'Company.id',
					'Companytranslation.title',
					'Company.arrangment',
					'Company.status',
					'Company.created'
				),
				'joins' => array(

					array('table' => 'companytranslations',
						'alias' => 'Companytranslation',
						'type' => 'LEFT',
						'conditions' => array(
							'Companytranslation.company_id = Company.id '
						)
					)

				),
				'conditions' => array('Companytranslation.title LIKE' => '%' . $this->request->data['Company']['search'] . '%', 'Companytranslation.language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)),
				'limit' => $limit,
				'order' => array(
					'Company.id' => 'desc'
				)
			);
		} else {
			$this->paginate = array(
				/*'joins'=>array(

				),*/
				'fields' => array(
					'Company.id',
					'Companytranslation.title',
					'Company.arrangment',
					'Company.status',
					'Company.created'
				),
				'joins' => array(

					array('table' => 'companytranslations',
						'alias' => 'Companytranslation',
						'type' => 'LEFT',
						'conditions' => array(
							'Companytranslation.company_id = Company.id '
						)
					)

				),
				'conditions' => array('Companytranslation.language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)),
				'limit' => $limit,
				'order' => array(
					'Company.id' => 'desc'
				)
			);
		}
		$companies = $this->paginate('Company');
		$this->set(compact('companies'));
	}


	function admin_add()
	{
		$this->set('title_for_layout', __d(__COMPANY_LOCALE, 'add_company'));
		if ($this->request->is('post')) {
			$datasource = $this->Company->getDataSource();
			try {
				$datasource->begin();
				$data = Sanitize::clean($this->request->data);

				$file = $data['Company']['image'];

				if ($file['size'] > 0) {
					$output = $this->_company_picture();
					if (!$output['error']) {
						$cover_image = $output['filename'];
					} else {
						$cover_image = '';
					}
				} else    $cover_image = "";

				$this->request->data['Company']['image'] = $cover_image;
				$this->Company->create();
				if (!$this->Company->save($this->request->data))
					throw new Exception(__d(__COMPANY_LOCALE, 'the_company_could_not_be_saved'));

				$company_id = $this->Company->getLastInsertID();
				/**
				 * @company translate
				 */
				$this->Company->Companytranslation->recursive = -1;
				$this->request->data['Companytranslation']['company_id'] = $company_id;
				$this->request->data['Companytranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
				$this->request->data['Companytranslation']['title'] = trim($this->request->data['Companytranslation']['title']);
				$this->request->data['Companytranslation']['detail'] = trim($this->request->data['Companytranslation']['detail']);
				$this->Company->Companytranslation->create();
				if (!$this->Company->Companytranslation->save($this->request->data))
					throw new Exception(__d(__COMPANY_LOCALE, 'the_company_could_not_be_saved'));
				/**
				 * company translate
				 */

				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__COMPANY_LOCALE, 'the_company_has_been_saved'), array('action' => 'index'));

			} catch (Exception $e) {
				$datasource->rollback();
				@unlink(__COMPANY_IMAGE_PATH . "/" . $cover_image);
				@unlink(__COMPANY_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $cover_image);
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}
		}

	}


	function _company_picture()
	{
		App::uses('Sanitize', 'Utility');

		$output = array();
		$data = Sanitize::clean($this->request->data);
		$file = $data['Company']['image'];

		if ($file['size'] > 0) {
			$ext = $this->Httpupload->get_extension($file['name']);
			$filename = md5(rand() . $_SERVER['REMOTE_ADDR']);
			if (file_exists(__COMPANY_IMAGE_PATH . $filename . '.' . $ext))
				$filename = md5(rand() . $_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Company');
			$this->Httpupload->setuploaddir(__COMPANY_IMAGE_PATH);
			$this->Httpupload->setuploadname('image');
			$this->Httpupload->settargetfile($filename . '.' . $ext);
			$this->Httpupload->setmaxsize(__UPLOAD_IMAGE_MAX_SIZE);
			//$this->Httpupload->create_thumb = true;
			$this->Httpupload->thumb_folder = __UPLOAD_THUMB;
			$this->Httpupload->thumb_width = 200;
			$this->Httpupload->thumb_height = 200;
			$this->Httpupload->setimagemaxsize(__UPLOAD_IMAGE_MAX_WIDTH, __UPLOAD_IMAGE_MAX_HEIGHT);
			$this->Httpupload->allowExt = __UPLOAD_IMAGE_EXTENSION;
			if (!$this->Httpupload->upload()) {
				return array('error' => true, 'filename' => '', 'message' => $this->Httpupload->get_error());
			}
			$filename .= '.' . $ext;

		}
		return array('error' => false, 'filename' => $filename);
	}


	function admin_edit($id = null)
	{
		$this->set('title_for_layout', __d(__COMPANY_LOCALE, 'edit_company'));
		$this->Company->id = $id;
		if (!$this->Company->exists()) {
			$this->Redirect->flashWarning(__d(__COMPANY_LOCALE, 'invalid_id_for_company'), array('action' => 'index'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			$datasource = $this->Company->getDataSource();
			try {
				$datasource->begin();

				$this->Company->recursive = -1;
				$options = array();
				$options['fields'] = array(
					'Company.id',
					'Company.image'
				);
				$options['conditions'] = array(
					"Company.id" => $id
				);

				$company = $this->Company->find('first', $options);

				$data = Sanitize::clean($this->request->data);

				$file = $data['Company']['image'];

				if ($file['size'] > 0) {
					$output = $this->_company_picture();
					if (!$output['error']) {
						$cover_image = $output['filename'];
					} else {
						$cover_image = '';
					}
				} else $cover_image = $company['Company']['image'];
				$this->request->data['Company']['image'] = $cover_image;

				if (!$this->Company->save($this->request->data))
					throw new Exception(__d(__COMPANY_LOCALE, 'the_company_could_not_be_saved'));

				$this->Company->Companytranslation->recursive = -1;
				$options = array();
				$options['conditions'] = array(
					"Companytranslation.company_id" => $id,
					"Companytranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				);
				$count = $this->Company->Companytranslation->find('count', $options);
				//pr($count);exit();
				/*
				* @company translate
				*/
				if ($count == 0) {
					$this->Company->Companytranslation->recursive = -1;
					$this->request->data['Companytranslation']['company_id'] = $id;
					$this->request->data['Companytranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
					$this->request->data['Companytranslation']['title'] = trim($this->request->data['Companytranslation']['title']);
					$this->request->data['Companytranslation']['detail'] = trim($this->request->data['Companytranslation']['detail']);
					$this->Company->Companytranslation->create();
					if (!$this->Company->Companytranslation->save($this->request->data))
						throw new Exception(__d(__COMPANY_LOCALE, 'the_company_could_not_be_saved'));
				} else {
					$ret = $this->Company->Companytranslation->updateAll(
						array('Companytranslation.title' => '"' . trim($this->request->data['Companytranslation']['title']) . '"'
						),
						array('Companytranslation.company_id' => $id, 'language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))
					);
					if (!$ret) {

						throw new Exception(__d(__COMPANY_LOCALE, 'the_company_could_not_be_saved'));
					}
				}
				/*
				* company translate
				*/
				$datasource->commit();
				if ($file['size']) {
					@unlink(__COMPANY_IMAGE_PATH . "/" . $company['Company']['image']);
					@unlink(__COMPANY_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $company['Company']['image']);

				}

				$this->Redirect->flashSuccess(__d(__COMPANY_LOCALE, 'the_company_has_been_saved'), array('action' => 'index'));

			} catch (Exception $e) {
				$datasource->rollback();
				@unlink(__COMPANY_IMAGE_PATH . "/" . $cover_image);
				@unlink(__COMPANY_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $cover_image);
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}
		}

		$this->Company->recursive = -1;
		$options = array();
		$options['fields'] = array(
			'Company.id',
			'Companytranslation.title',
			'Companytranslation.detail',
			'Company.arrangment',
			'Company.image',
			'Company.status',
			'Company.created',

		);
		$options['joins'] = array(
			array('table' => 'companytranslations',
				'alias' => 'Companytranslation',
				'type' => 'left',
				'conditions' => array(
					'Company.id = Companytranslation.company_id',
					"Companytranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				)
			)
		);
		$options['conditions'] = array(
			"Company.id" => $id,
		);

		$this->request->data = $this->Company->find('first', $options);

		//$options = array('conditions' => array('Company.' . $this->Company->primaryKey => $id));
		//$this->request->data = $this->Company->find('first', $options);
		//$this->set($company,$this->request->data);

	}

	function admin_delete($id = null)
	{
		$this->Company->id = $id;
		if (!$this->Company->exists()) {
			$this->Redirect->flashWarning(__d(__COMPANY_LOCALE, 'invalid_id_for_company'), array('action' => 'index'));
		}

		$company = $this->Company->findById($id);
		if ($this->Company->delete($id)) {
			@unlink(__COMPANY_IMAGE_PATH . "/" . $company['Company']['image']);
			@unlink(__COMPANY_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $company['Company']['image']);
			$this->Company->Companytranslation->deleteAll(array('Companytranslation.company_id' => $id), FALSE);
			$this->Redirect->flashSuccess(__d(__COMPANY_LOCALE, 'delete_company_success'), array('action' => 'index'));
		} else {
			$this->Redirect->flashWarning(__d(__COMPANY_LOCALE, 'delete_company_not_success'), array('action' => 'index'));
		}
	}


	function get_main_companies()
	{
		$options['fields'] = array(
			'Company.id',
			'Company.parent_id',
			'Company.title as title'
		);
		$options['conditions'] = array(
			'Company.status' => 1,
			'Company.parent_id' => 0
		);
		$options['order'] = array(
			'Company.arrangment' => 'asc'
		);
		$companies = $this->Company->find('all', $options);
		return $companies;
	}

	function view($id = null)
	{
		$this->Company->recursive = -1;

		$this->Company->id = $id;
		if (!$this->Company->exists()) {
			$company = $this->Company->Companytranslation->findByTitleSlug($id);
			if (empty($company)) {
				throw new NotFoundException(__('not_valid_page'));
			}
			$id = $company['Companytranslation']['company_id'];
		}

		$User_Info = $this->Session->read('User_Info');


		$options['fields'] = array(
			'Company.id',
			'Companytranslation.title',
			'Companytranslation.detail',
			'Company.image',
			'Company.created'
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
			"Company.status" => 1,
			"Company.id" => $id,
			'Language.code' => $this->Session->read('Config.language')
		);

		$company = $this->Company->find('first', $options);
		//pr($company);
		$this->set(compact('company'));

		$this->loadModel('Project');
		$this->Project->recursive = -1;

		$options['fields'] = array(
			'Project.id',
			'Project.slug',
			'Projecttranslation.title',
			'Project.created',
			'Projecttranslation.mini_detail',
			'(select image from projectimages where project_id = Project.id limit 0,1)as image'
		);
		$options['joins'] = array(
			array('table' => 'projecttranslations',
				'alias' => 'Projecttranslation',
				'type' => 'left',
				'conditions' => array(
					'Project.id = Projecttranslation.project_id'
				)
			),
			array('table' => 'languages',
				'alias' => 'Language',
				'type' => 'left',
				'conditions' => array(
					'Language.id = Projecttranslation.language_id'
				)
			)
		);

		$options['conditions'] = array(
			"Project.status" => 1,
			"Project.company_id" => $id,
			'Language.code' => $this->Session->read('Config.language')
		);

		$options['order'] = array(
			'Project.id' => 'desc'
		);

		$projects = $this->Project->find('all', $options);

		$this->set(compact('projects'));


		$this->set('title_for_layout', $company['Companytranslation']['title'] . __('default_title'));
		$this->set('description_for_layout', $company['Companytranslation']['detail']);
		//$this->set('keywords_for_layout', $tag_str);
		$this->set('header_canonical', __SITE_URL . __COMPANY . "/" . $company['Companytranslation']['title']);

		$this->set('company_id', $id);
		$this->set('title', $company['Companytranslation']['title']);
		$this->set('wecompany_detail', $company['Companytranslation']['title']);

		$open_graph_items = array(
			"property='og:title'" => $company['Companytranslation']['title'],
			"property='og:description'" => $company['Companytranslation']['detail'],
			"property='og:image'" => __SITE_URL . __COMPANY_IMAGE_PATH . __UPLOAD_THUMB . '/' . $company['Company']['image'],
			"property='og:url'" => __SITE_URL . __COMPANY . "/" . $company['Companytranslation']['title'],

			"name='twitter:title'" => $company['Companytranslation']['title'],
			"name='twitter:description'" => $company['Companytranslation']['detail'],
			"name='twitter:image'" => __SITE_URL . __COMPANY_IMAGE_PATH . __UPLOAD_THUMB . '/' . $company['Company']['image'],
			"name='twitter:card'" => 'summary'
		);
		$this->set('open_graph_items', $open_graph_items);
	}

	function last()
	{
		$limit = 20;

		if (!empty($_REQUEST['page'])) {
			$page = $_REQUEST['page'];
		} else $page = 1;

		if (isset($page)) {
			$first = ($page - 1) * $limit;
		} else $first = 0;


		$options = array();
		$this->Company->recursive = -1;
		$options['fields'] = array(
			'Company.id',
			'Companytranslation.title',
			'Company.image',
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
			'Language.code' => $this->Session->read('Config.language')
		);
		$options['order'] = array(
			'Company.id' => 'desc'
		);
		//$options['limit'] = 5;
		$companies = $this->Company->find('all', $options);

		$this->set(compact('companies'));


		$options = array();
		$options['conditions'] = array(
			'Company.status ' => 1
		);
		$total_count = $this->Company->find('count', $options);
		$this->set(compact('total_count'));

		$this->set('company_detail', __d(__COMPANY_LOCALE, 'wecompany'));
		$this->set('limit', $limit);

		$this->set('title_for_layout', __d(__COMPANY_LOCALE, 'wecompany'));
		$this->set('description_for_layout', __d(__COMPANY_LOCALE, 'wecompany' . ',' . __('site_description')));
		$this->set('keywords_for_layout', __d(__COMPANY_LOCALE, 'wecompany') . ',' . __('site_keywords'));
	}

}

