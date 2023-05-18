<?php


App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');

class InvestmentsController extends InvestmentAppController
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
	public $name = 'Investments';
	public $helpers = array('AdminHtml' => array('action' => 'Investment'));

	/**
	 * This controller does not use a model
	 *
	 * @var array
	 */
	public $uses = array();

	/**
	 * Displays a view
	 *
	 * @param mixed What investment to display
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

		$this->set('title_for_layout', __d(__INVESTMENT_LOCALE, 'investment_list'));
		//$this->Investment->recursive = - 1;
		if (isset($_REQUEST['filter'])) {
			$limit = $_REQUEST['filter'];
		} else $limit = 10;

		if (isset($this->request->data['Investment']['search'])) {
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields' => array(
					'Investment.id',
					'Investmenttranslation.title',
					'Investment.arrangment',
					'Investment.status',
					'Investment.created'
				),
				'joins' => array(

					array('table' => 'investmenttranslations',
						'alias' => 'Investmenttranslation',
						'type' => 'LEFT',
						'conditions' => array(
							'Investmenttranslation.investment_id = Investment.id '
						)
					)

				),
				'conditions' => array('Investmenttranslation.title LIKE' => '%' . $this->request->data['Investment']['search'] . '%', 'Investmenttranslation.language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)),
				'limit' => $limit,
				'order' => array(
					'Investment.id' => 'desc'
				)
			);
		} else {
			$this->paginate = array(
				/*'joins'=>array(

				),*/
				'fields' => array(
					'Investment.id',
					'Investmenttranslation.title',
					'Investment.arrangment',
					'Investment.status',
					'Investment.created'
				),
				'joins' => array(

					array('table' => 'investmenttranslations',
						'alias' => 'Investmenttranslation',
						'type' => 'LEFT',
						'conditions' => array(
							'Investmenttranslation.investment_id = Investment.id '
						)
					)

				),
				'conditions' => array('Investmenttranslation.language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)),
				'limit' => $limit,
				'order' => array(
					'Investment.id' => 'desc'
				)
			);
		}
		$companies = $this->paginate('Investment');
		$this->set(compact('companies'));
	}


	function admin_add()
	{
		$this->set('title_for_layout', __d(__INVESTMENT_LOCALE, 'add_investment'));
		if ($this->request->is('post')) {
			$datasource = $this->Investment->getDataSource();
			try {
				$datasource->begin();
				$data = Sanitize::clean($this->request->data);

				$file = $data['Investment']['image'];

				if ($file['size'] > 0) {
					$output = $this->_investment_picture();
					if (!$output['error']) {
						$cover_image = $output['filename'];
					} else {
						$cover_image = '';
					}
				} else    $cover_image = "";

				$this->request->data['Investment']['image'] = $cover_image;
				$this->Investment->create();
				if (!$this->Investment->save($this->request->data))
					throw new Exception(__d(__INVESTMENT_LOCALE, 'the_investment_could_not_be_saved'));

				$investment_id = $this->Investment->getLastInsertID();
				/**
				 * @investment translate
				 */
				$this->Investment->Investmenttranslation->recursive = -1;
				$this->request->data['Investmenttranslation']['investment_id'] = $investment_id;
				$this->request->data['Investmenttranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
				$this->request->data['Investmenttranslation']['title'] = trim($this->request->data['Investmenttranslation']['title']);
				$this->request->data['Investmenttranslation']['detail'] = trim($this->request->data['Investmenttranslation']['detail']);
				$this->Investment->Investmenttranslation->create();
				if (!$this->Investment->Investmenttranslation->save($this->request->data))
					throw new Exception(__d(__INVESTMENT_LOCALE, 'the_investment_could_not_be_saved'));
				/**
				 * investment translate
				 */

				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__INVESTMENT_LOCALE, 'the_investment_has_been_saved'), array('action' => 'index'));

			} catch (Exception $e) {
				$datasource->rollback();
				@unlink(__INVESTMENT_IMAGE_PATH . "/" . $cover_image);
				@unlink(__INVESTMENT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $cover_image);
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}
		}

	}


	function _investment_picture()
	{
		App::uses('Sanitize', 'Utility');

		$output = array();
		$data = Sanitize::clean($this->request->data);
		$file = $data['Investment']['image'];

		if ($file['size'] > 0) {
			$ext = $this->Httpupload->get_extension($file['name']);
			$filename = md5(rand() . $_SERVER['REMOTE_ADDR']);
			if (file_exists(__INVESTMENT_IMAGE_PATH . $filename . '.' . $ext))
				$filename = md5(rand() . $_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Investment');
			$this->Httpupload->setuploaddir(__INVESTMENT_IMAGE_PATH);
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
		$this->set('title_for_layout', __d(__INVESTMENT_LOCALE, 'edit_investment'));
		$this->Investment->id = $id;
		if (!$this->Investment->exists()) {
			$this->Redirect->flashWarning(__d(__INVESTMENT_LOCALE, 'invalid_id_for_investment'), array('action' => 'index'));
		}

		if ($this->request->is('post') || $this->request->is('put')) {
			$datasource = $this->Investment->getDataSource();
			try {
				$datasource->begin();

				$this->Investment->recursive = -1;
				$options = array();
				$options['fields'] = array(
					'Investment.id',
					'Investment.image'
				);
				$options['conditions'] = array(
					"Investment.id" => $id
				);

				$investment = $this->Investment->find('first', $options);

				$data = Sanitize::clean($this->request->data);

				$file = $data['Investment']['image'];

				if ($file['size'] > 0) {
					$output = $this->_investment_picture();
					if (!$output['error']) {
						$cover_image = $output['filename'];
					} else {
						$cover_image = '';
					}
				} else $cover_image = $investment['Investment']['image'];
				$this->request->data['Investment']['image'] = $cover_image;

				if (!$this->Investment->save($this->request->data))
					throw new Exception(__d(__INVESTMENT_LOCALE, 'the_investment_could_not_be_saved'));

				$this->Investment->Investmenttranslation->recursive = -1;
				$options = array();
				$options['conditions'] = array(
					"Investmenttranslation.investment_id" => $id,
					"Investmenttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				);
				$count = $this->Investment->Investmenttranslation->find('count', $options);
				//pr($count);exit();
				/*
				* @investment translate
				*/
				if ($count == 0) {
					$this->Investment->Investmenttranslation->recursive = -1;
					$this->request->data['Investmenttranslation']['investment_id'] = $id;
					$this->request->data['Investmenttranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
					$this->request->data['Investmenttranslation']['title'] = trim($this->request->data['Investmenttranslation']['title']);
					$this->request->data['Investmenttranslation']['detail'] = trim($this->request->data['Investmenttranslation']['detail']);
					$this->Investment->Investmenttranslation->create();
					if (!$this->Investment->Investmenttranslation->save($this->request->data))
						throw new Exception(__d(__INVESTMENT_LOCALE, 'the_investment_could_not_be_saved'));
				} else {
					$ret = $this->Investment->Investmenttranslation->updateAll(
						array('Investmenttranslation.title' => '"' . trim($this->request->data['Investmenttranslation']['title']) . '"'
						),
						array('Investmenttranslation.investment_id' => $id, 'language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))
					);
					if (!$ret) {

						throw new Exception(__d(__INVESTMENT_LOCALE, 'the_investment_could_not_be_saved'));
					}
				}
				/*
				* investment translate
				*/
				$datasource->commit();
				if ($file['size']) {
					@unlink(__INVESTMENT_IMAGE_PATH . "/" . $investment['Investment']['image']);
					@unlink(__INVESTMENT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $investment['Investment']['image']);

				}

				$this->Redirect->flashSuccess(__d(__INVESTMENT_LOCALE, 'the_investment_has_been_saved'), array('action' => 'index'));

			} catch (Exception $e) {
				$datasource->rollback();
				@unlink(__INVESTMENT_IMAGE_PATH . "/" . $cover_image);
				@unlink(__INVESTMENT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $cover_image);
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}
		}

		$this->Investment->recursive = -1;
		$options = array();
		$options['fields'] = array(
			'Investment.id',
			'Investmenttranslation.title',
			'Investmenttranslation.detail',
			'Investment.arrangment',
			'Investment.image',
			'Investment.status',
			'Investment.created',

		);
		$options['joins'] = array(
			array('table' => 'investmenttranslations',
				'alias' => 'Investmenttranslation',
				'type' => 'left',
				'conditions' => array(
					'Investment.id = Investmenttranslation.investment_id',
					"Investmenttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				)
			)
		);
		$options['conditions'] = array(
			"Investment.id" => $id,
		);

		$this->request->data = $this->Investment->find('first', $options);

		//$options = array('conditions' => array('Investment.' . $this->Investment->primaryKey => $id));
		//$this->request->data = $this->Investment->find('first', $options);
		//$this->set($investment,$this->request->data);

	}

	function admin_delete($id = null)
	{
		$this->Investment->id = $id;
		if (!$this->Investment->exists()) {
			$this->Redirect->flashWarning(__d(__INVESTMENT_LOCALE, 'invalid_id_for_investment'), array('action' => 'index'));
		}

		$investment = $this->Investment->findById($id);
		if ($this->Investment->delete($id)) {
			@unlink(__INVESTMENT_IMAGE_PATH . "/" . $investment['Investment']['image']);
			@unlink(__INVESTMENT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $investment['Investment']['image']);
			$this->Investment->Investmenttranslation->deleteAll(array('Investmenttranslation.investment_id' => $id), FALSE);
			$this->Redirect->flashSuccess(__d(__INVESTMENT_LOCALE, 'delete_investment_success'), array('action' => 'index'));
		} else {
			$this->Redirect->flashWarning(__d(__INVESTMENT_LOCALE, 'delete_investment_not_success'), array('action' => 'index'));
		}
	}


	function get_main_companies()
	{
		$options['fields'] = array(
			'Investment.id',
			'Investment.parent_id',
			'Investment.title as title'
		);
		$options['conditions'] = array(
			'Investment.status' => 1,
			'Investment.parent_id' => 0
		);
		$options['order'] = array(
			'Investment.arrangment' => 'asc'
		);
		$companies = $this->Investment->find('all', $options);
		return $companies;
	}

	function view($id = null)
	{
		$this->Investment->recursive = -1;

		$this->Investment->id = $id;
		if (!$this->Investment->exists()) {
			$investment = $this->Investment->Investmenttranslation->findByTitleSlug($id);
			if (empty($investment)) {
				throw new NotFoundException(__('not_valid_page'));
			}
			$id = $investment['Investmenttranslation']['investment_id'];
		}

		$User_Info = $this->Session->read('User_Info');


		$options['fields'] = array(
			'Investment.id',
			'Investmenttranslation.title',
			'Investmenttranslation.detail',
			'Investment.image',
			'Investment.created'
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
			"Investment.status" => 1,
			"Investment.id" => $id,
			'Language.code' => $this->Session->read('Config.language')
		);

		$investment = $this->Investment->find('first', $options);
		//pr($investment);
		$this->set(compact('investment'));

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
			"Project.investment_id" => $id,
			'Language.code' => $this->Session->read('Config.language')
		);

		$options['order'] = array(
			'Project.id' => 'desc'
		);

		$projects = $this->Project->find('all', $options);

		$this->set(compact('projects'));


		$this->set('title_for_layout', $investment['Investmenttranslation']['title'] . __('default_title'));
		$this->set('description_for_layout', $investment['Investmenttranslation']['detail']);
		//$this->set('keywords_for_layout', $tag_str);
		$this->set('header_canonical', __SITE_URL . __INVESTMENT . "/" . $investment['Investmenttranslation']['title']);

		$this->set('investment_id', $id);
		$this->set('title', $investment['Investmenttranslation']['title']);
		$this->set('weinvestment_detail', $investment['Investmenttranslation']['title']);

		$open_graph_items = array(
			"property='og:title'" => $investment['Investmenttranslation']['title'],
			"property='og:description'" => $investment['Investmenttranslation']['detail'],
			"property='og:image'" => __SITE_URL . __INVESTMENT_IMAGE_PATH . __UPLOAD_THUMB . '/' . $investment['Investment']['image'],
			"property='og:url'" => __SITE_URL . __INVESTMENT . "/" . $investment['Investmenttranslation']['title'],

			"name='twitter:title'" => $investment['Investmenttranslation']['title'],
			"name='twitter:description'" => $investment['Investmenttranslation']['detail'],
			"name='twitter:image'" => __SITE_URL . __INVESTMENT_IMAGE_PATH . __UPLOAD_THUMB . '/' . $investment['Investment']['image'],
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
		$this->Investment->recursive = -1;
		$options['fields'] = array(
			'Investment.id',
			'Investmenttranslation.title',
			'Investment.image',
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
			'Language.code' => $this->Session->read('Config.language')
		);
		$options['order'] = array(
			'Investment.id' => 'desc'
		);
		//$options['limit'] = 5;
		$companies = $this->Investment->find('all', $options);

		$this->set(compact('companies'));


		$options = array();
		$options['conditions'] = array(
			'Investment.status ' => 1
		);
		$total_count = $this->Investment->find('count', $options);
		$this->set(compact('total_count'));

		$this->set('investment_detail', __d(__INVESTMENT_LOCALE, 'weinvestment'));
		$this->set('limit', $limit);

		$this->set('title_for_layout', __d(__INVESTMENT_LOCALE, 'weinvestment'));
		$this->set('description_for_layout', __d(__INVESTMENT_LOCALE, 'weinvestment' . ',' . __('site_description')));
		$this->set('keywords_for_layout', __d(__INVESTMENT_LOCALE, 'weinvestment') . ',' . __('site_keywords'));
	}

	public function index() {

	}

}

