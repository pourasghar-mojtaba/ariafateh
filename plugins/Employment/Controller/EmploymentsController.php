<?php


App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class EmploymentsController extends EmploymentAppController
{

	/*public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('view','get_child_employments');
	}*/

	/**
	 * Controller name
	 *
	 * @var string
	 */
	public $name = 'Employments';
	public $helpers = array('AdminHtml' => array('action' => 'Employment'));

	/**
	 * This controller does not use a model
	 *
	 * @var array
	 */
	public $uses = array();

	/**
	 * Displays a view
	 *
	 * @param mixed What employment to display
	 * @return void
	 */

	public
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('view', 'last','index');
	}

	function admin_index()
	{

		$this->set('title_for_layout', __d(__EMPLOYMENT_LOCALE, 'employment_list'));
		//$this->Employment->recursive = - 1;
		if (isset($_REQUEST['filter'])) {
			$limit = $_REQUEST['filter'];
		} else $limit = 10;

		if (isset($this->request->data['Employment']['search'])) {
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields' => array(
					'Employment.id',
					'Employmenttranslation.job',
					'Employment.arrangment',
					'Employment.status',
					'Employment.created'
				),
				'joins' => array(

					array('table' => 'employmenttranslations',
						'alias' => 'Employmenttranslation',
						'type' => 'LEFT',
						'conditions' => array(
							'Employmenttranslation.employment_id = Employment.id '
						)
					)

				),
				'conditions' => array('Employmenttranslation.title LIKE' => '%' . $this->request->data['Employment']['search'] . '%', 'Employmenttranslation.language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)),
				'limit' => $limit,
				'order' => array(
					'Employment.id' => 'desc'
				)
			);
		} else {
			$this->paginate = array(
				/*'joins'=>array(

				),*/
				'fields' => array(
					'Employment.id',
					'Employmenttranslation.job',
					'Employment.arrangment',
					'Employment.status',
					'Employment.created'
				),
				'joins' => array(

					array('table' => 'employmenttranslations',
						'alias' => 'Employmenttranslation',
						'type' => 'LEFT',
						'conditions' => array(
							'Employmenttranslation.employment_id = Employment.id '
						)
					)

				),
				'conditions' => array('Employmenttranslation.language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)),
				'limit' => $limit,
				'order' => array(
					'Employment.id' => 'desc'
				)
			);
		}
		$employments = $this->paginate('Employment');
		$this->set(compact('employments'));
	}


	function admin_add()
	{
		$this->set('title_for_layout', __d(__EMPLOYMENT_LOCALE, 'add_employment'));
		if ($this->request->is('post')) {
			$datasource = $this->Employment->getDataSource();
			try {
				$datasource->begin();
				$data = Sanitize::clean($this->request->data);

				$file = $data['Employment']['image'];

				if ($file['size'] > 0) {
					$output = $this->_employment_picture();
					if (!$output['error']) {
						$cover_image = $output['filename'];
					} else {
						$cover_image = '';
					}
				} else    $cover_image = "";

				$this->request->data['Employment']['image'] = $cover_image;
				$this->Employment->create();
				if (!$this->Employment->save($this->request->data))
					throw new Exception(__d(__EMPLOYMENT_LOCALE, 'the_employment_could_not_be_saved'));

				$employment_id = $this->Employment->getLastInsertID();
				/**
				 * @employment translate
				 */
				$this->Employment->Employmenttranslation->recursive = -1;
				$this->request->data['Employmenttranslation']['employment_id'] = $employment_id;
				$this->request->data['Employmenttranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
				$this->request->data['Employmenttranslation']['title'] = trim($this->request->data['Employmenttranslation']['title']);
				$this->request->data['Employmenttranslation']['detail'] = trim($this->request->data['Employmenttranslation']['detail']);
				$this->Employment->Employmenttranslation->create();
				if (!$this->Employment->Employmenttranslation->save($this->request->data))
					throw new Exception(__d(__EMPLOYMENT_LOCALE, 'the_employment_could_not_be_saved'));
				/**
				 * employment translate
				 */

				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__EMPLOYMENT_LOCALE, 'the_employment_has_been_saved'), array('action' => 'index'));

			} catch (Exception $e) {
				$datasource->rollback();
				@unlink(__EMPLOYMENT_IMAGE_PATH . "/" . $cover_image);
				@unlink(__EMPLOYMENT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $cover_image);
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}
		}

	}


	function _employment_picture()
	{
		App::uses('Sanitize', 'Utility');

		$output = array();
		$data = Sanitize::clean($this->request->data);
		$file = $data['Employment']['image'];

		if ($file['size'] > 0) {
			$ext = $this->Httpupload->get_extension($file['name']);
			$filename = md5(rand() . $_SERVER['REMOTE_ADDR']);
			if (file_exists(__EMPLOYMENT_IMAGE_PATH . $filename . '.' . $ext))
				$filename = md5(rand() . $_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Employment');
			$this->Httpupload->setuploaddir(__EMPLOYMENT_IMAGE_PATH);
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
		$this->set('title_for_layout', __d(__EMPLOYMENT_LOCALE, 'edit_employment'));
		$this->Employment->id = $id;
		if (!$this->Employment->exists()) {
			$this->Redirect->flashWarning(__d(__EMPLOYMENT_LOCALE, 'invalid_id_for_employment'), array('action' => 'index'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			$datasource = $this->Employment->getDataSource();
			try {
				$datasource->begin();

				$this->Employment->recursive = -1;
				$options = array();
				$options['fields'] = array(
					'Employment.id',
					'Employment.image'
				);
				$options['conditions'] = array(
					"Employment.id" => $id
				);

				$employment = $this->Employment->find('first', $options);

				$data = Sanitize::clean($this->request->data);

				$file = $data['Employment']['image'];

				if ($file['size'] > 0) {
					$output = $this->_employment_picture();
					if (!$output['error']) {
						$cover_image = $output['filename'];
					} else {
						$cover_image = '';
					}
				} else $cover_image = $employment['Employment']['image'];
				$this->request->data['Employment']['image'] = $cover_image;

				if (!$this->Employment->save($this->request->data))
					throw new Exception(__d(__EMPLOYMENT_LOCALE, 'the_employment_could_not_be_saved'));

				$this->Employment->Employmenttranslation->recursive = -1;
				$options = array();
				$options['conditions'] = array(
					"Employmenttranslation.employment_id" => $id,
					"Employmenttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				);
				$count = $this->Employment->Employmenttranslation->find('count', $options);
				//pr($count);exit();
				/*
				* @employment translate
				*/
				if ($count == 0) {
					$this->Employment->Employmenttranslation->recursive = -1;
					$this->request->data['Employmenttranslation']['employment_id'] = $id;
					$this->request->data['Employmenttranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
					$this->request->data['Employmenttranslation']['title'] = trim($this->request->data['Employmenttranslation']['title']);
					$this->request->data['Employmenttranslation']['detail'] = trim($this->request->data['Employmenttranslation']['detail']);
					$this->Employment->Employmenttranslation->create();
					if (!$this->Employment->Employmenttranslation->save($this->request->data))
						throw new Exception(__d(__EMPLOYMENT_LOCALE, 'the_employment_could_not_be_saved'));
				} else {
					$ret = $this->Employment->Employmenttranslation->updateAll(
						array('Employmenttranslation.title' => '"' . trim($this->request->data['Employmenttranslation']['title']) . '"'
						),
						array('Employmenttranslation.employment_id' => $id, 'language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))
					);
					if (!$ret) {

						throw new Exception(__d(__EMPLOYMENT_LOCALE, 'the_employment_could_not_be_saved'));
					}
				}
				/*
				* employment translate
				*/
				$datasource->commit();
				if ($file['size']) {
					@unlink(__EMPLOYMENT_IMAGE_PATH . "/" . $employment['Employment']['image']);
					@unlink(__EMPLOYMENT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $employment['Employment']['image']);

				}

				$this->Redirect->flashSuccess(__d(__EMPLOYMENT_LOCALE, 'the_employment_has_been_saved'), array('action' => 'index'));

			} catch (Exception $e) {
				$datasource->rollback();
				@unlink(__EMPLOYMENT_IMAGE_PATH . "/" . $cover_image);
				@unlink(__EMPLOYMENT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $cover_image);
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}
		}

		$this->Employment->recursive = -1;
		$options = array();
		$options['fields'] = array(
			'Employment.id',
			'Employmenttranslation.title',
			'Employmenttranslation.detail',
			'Employment.arrangment',
			'Employment.image',
			'Employment.status',
			'Employment.created',

		);
		$options['joins'] = array(
			array('table' => 'employmenttranslations',
				'alias' => 'Employmenttranslation',
				'type' => 'left',
				'conditions' => array(
					'Employment.id = Employmenttranslation.employment_id',
					"Employmenttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				)
			)
		);
		$options['conditions'] = array(
			"Employment.id" => $id,
		);

		$this->request->data = $this->Employment->find('first', $options);

		//$options = array('conditions' => array('Employment.' . $this->Employment->primaryKey => $id));
		//$this->request->data = $this->Employment->find('first', $options);
		//$this->set($employment,$this->request->data);

	}

	function admin_delete($id = null)
	{
		$this->Employment->id = $id;
		if (!$this->Employment->exists()) {
			$this->Redirect->flashWarning(__d(__EMPLOYMENT_LOCALE, 'invalid_id_for_employment'), array('action' => 'index'));
		}

		$employment = $this->Employment->findById($id);
		if ($this->Employment->delete($id)) {
			@unlink(__EMPLOYMENT_IMAGE_PATH . "/" . $employment['Employment']['image']);
			@unlink(__EMPLOYMENT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $employment['Employment']['image']);
			$this->Employment->Employmenttranslation->deleteAll(array('Employmenttranslation.employment_id' => $id), FALSE);
			$this->Redirect->flashSuccess(__d(__EMPLOYMENT_LOCALE, 'delete_employment_success'), array('action' => 'index'));
		} else {
			$this->Redirect->flashWarning(__d(__EMPLOYMENT_LOCALE, 'delete_employment_not_success'), array('action' => 'index'));
		}
	}


	function get_main_employments()
	{
		$options['fields'] = array(
			'Employment.id',
			'Employment.parent_id',
			'Employment.title as title'
		);
		$options['conditions'] = array(
			'Employment.status' => 1,
			'Employment.parent_id' => 0
		);
		$options['order'] = array(
			'Employment.arrangment' => 'asc'
		);
		$employments = $this->Employment->find('all', $options);
		return $employments;
	}

	function view($id = null)
	{
		$this->Employment->recursive = -1;

		$this->Employment->id = $id;
		if (!$this->Employment->exists()) {
			$employment = $this->Employment->Employmenttranslation->findByTitleSlug($id);
			if (empty($employment)) {
				throw new NotFoundException(__('not_valid_page'));
			}
			$id = $employment['Employmenttranslation']['employment_id'];
		}

		$User_Info = $this->Session->read('User_Info');


		$options['fields'] = array(
			'Employment.id',
			'Employmenttranslation.title',
			'Employmenttranslation.detail',
			'Employment.image',
			'Employment.created'
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
			"Employment.status" => 1,
			"Employment.id" => $id,
			'Language.code' => $this->Session->read('Config.language')
		);

		$employment = $this->Employment->find('first', $options);
		//pr($employment);
		$this->set(compact('employment'));

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
			"Project.employment_id" => $id,
			'Language.code' => $this->Session->read('Config.language')
		);

		$options['order'] = array(
			'Project.id' => 'desc'
		);

		$projects = $this->Project->find('all', $options);

		$this->set(compact('projects'));


		$this->set('title_for_layout', $employment['Employmenttranslation']['title'] . __('default_title'));
		$this->set('description_for_layout', $employment['Employmenttranslation']['detail']);
		//$this->set('keywords_for_layout', $tag_str);
		$this->set('header_canonical', __SITE_URL . __EMPLOYMENT . "/" . $employment['Employmenttranslation']['title']);

		$this->set('employment_id', $id);
		$this->set('title', $employment['Employmenttranslation']['title']);
		$this->set('weemployment_detail', $employment['Employmenttranslation']['title']);

		$open_graph_items = array(
			"property='og:title'" => $employment['Employmenttranslation']['title'],
			"property='og:description'" => $employment['Employmenttranslation']['detail'],
			"property='og:image'" => __SITE_URL . __EMPLOYMENT_IMAGE_PATH . __UPLOAD_THUMB . '/' . $employment['Employment']['image'],
			"property='og:url'" => __SITE_URL . __EMPLOYMENT . "/" . $employment['Employmenttranslation']['title'],

			"name='twitter:title'" => $employment['Employmenttranslation']['title'],
			"name='twitter:description'" => $employment['Employmenttranslation']['detail'],
			"name='twitter:image'" => __SITE_URL . __EMPLOYMENT_IMAGE_PATH . __UPLOAD_THUMB . '/' . $employment['Employment']['image'],
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
		$this->Employment->recursive = -1;
		$options['fields'] = array(
			'Employment.id',
			'Employmenttranslation.title',
			'Employment.image',
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
			'Language.code' => $this->Session->read('Config.language')
		);
		$options['order'] = array(
			'Employment.id' => 'desc'
		);
		//$options['limit'] = 5;
		$employments = $this->Employment->find('all', $options);

		$this->set(compact('employments'));


		$options = array();
		$options['conditions'] = array(
			'Employment.status ' => 1
		);
		$total_count = $this->Employment->find('count', $options);
		$this->set(compact('total_count'));

		$this->set('employment_detail', __d(__EMPLOYMENT_LOCALE, 'employment'));
		$this->set('limit', $limit);

		$this->set('title_for_layout', __d(__EMPLOYMENT_LOCALE, 'employment'));
		$this->set('description_for_layout', __d(__EMPLOYMENT_LOCALE, 'employment' . ',' . __('site_description')));
		$this->set('keywords_for_layout', __d(__EMPLOYMENT_LOCALE, 'employment') . ',' . __('site_keywords'));
	}

	public function index(){
		if($this->request->is('post'))
		{

			if(md5($this->request->data['Contactmessage']['captcha'].'DYhG93b') != $this->Session->read('encoded_captcha'))
			{
				$this->Redirect->flashWarning(__('incorrect_captcha'),'/pages/contact_us');
				return FALSE;
			}

			$this->request->data = Sanitize::clean($this->request->data);

			$this->Contactmessage->create();
			if($this->Contactmessage->save($this->request->data))
			{
				//$this->Session->setFlash(__('send_message_not_successfully'),'success');
				$this->Redirect->flashSuccess(__('send_message_successfully'),'/pages/contact_us');
			}
			else
			{
				//$this->Session->setFlash(__('send_message_successfully'),'error');
				$this->Redirect->flashWarning(__('send_message_not_successfully'),'/pages/contact_us');
			}

		}

		$this->set('title_for_layout', __d(__EMPLOYMENT_LOCALE, 'employment'));
		$this->set('description_for_layout', __d(__EMPLOYMENT_LOCALE, 'employment'));
		$this->set('keywords_for_layout', __d(__EMPLOYMENT_LOCALE, 'employment'));
	}

}

