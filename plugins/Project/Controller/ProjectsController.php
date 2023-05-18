<?php
App::uses('AppController', 'Controller');

class ProjectsController extends ProjectAppController
{
	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Httpupload', 'CmsAcl' => array('allUsers' => array('index')));
	public $helpers = array('AdminHtml' => array('action' => 'Project'));

	/**
	 * admin_index method
	 *
	 * @return void
	 */

	public
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('search', 'view', 'last');
		//
		$this->_add_admin_member_permision(array('admin_deletevideo'));
	}

	public
	function admin_index()
	{
		$this->Project->recursive = -1;
		$this->set('title_for_layout', __d(__PROJECT_LOCALE, 'project_list'));
		if (isset($_REQUEST['filter'])) {
			$limit = $_REQUEST['filter'];
		} else $limit = 10;

		if (isset($this->request->data['Project']['search'])) {
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields' => array(
					'Projectcategorytranslation.title',
					'Project.id',
					'Projecttranslation.title',
					'Projecttranslation.mini_detail',
					'Project.status',
					'Project.created',
				),
				'joins' => array(
					array('table' => 'projectcategories',
						'alias' => 'Projectcategory',
						'type' => 'left',
						'conditions' => array(
							'Project.project_category_id = Projectcategory.id ',
						)
					),
					array('table' => 'projectcategorytranslations',
						'alias' => 'Projectcategorytranslation',
						'type' => 'left',
						'conditions' => array(
							'Projectcategory.id = Projectcategorytranslation.project_category_id',
							"Projectcategorytranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						)
					),
					array('table' => 'projecttranslations',
						'alias' => 'Projecttranslation',
						'type' => 'left',
						'conditions' => array(
							'Project.id = Projecttranslation.project_id',
							"Projecttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						)
					)
				),
				'conditions' => array('Projecttranslation.title LIKE' => '' . $this->request->data['Project']['search'] . '%'),
				'limit' => $limit,
				'order' => array(
					'Project.id' => 'desc'
				)
			);
		} else {
			$this->paginate = array(
				'fields' => array(
					'Projectcategorytranslation.title',
					'Project.id',
					'Projecttranslation.title',
					'Projecttranslation.mini_detail',
					'Project.status',
					'Project.created',
				),
				'joins' => array(
					array('table' => 'projectcategories',
						'alias' => 'Projectcategory',
						'type' => 'left',
						'conditions' => array(
							'Project.project_category_id = Projectcategory.id ',
						)
					)
				,
					array('table' => 'projectcategorytranslations',
						'alias' => 'Projectcategorytranslation',
						'type' => 'left',
						'conditions' => array(
							'Projectcategory.id = Projectcategorytranslation.project_category_id',
							"Projectcategorytranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						)
					),
					array('table' => 'projecttranslations',
						'alias' => 'Projecttranslation',
						'type' => 'left',
						'conditions' => array(
							'Project.id = Projecttranslation.project_id',
							"Projecttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						)
					)
				),
				'limit' => $limit,
				'order' => array(
					'Project.id' => 'desc'
				)
			);
		}
		$projects = $this->paginate('Project');
		$this->set(compact('projects'));
	}


	/**
	 * admin_add method
	 *
	 * @return void
	 */
	public
	function admin_add()
	{
		$this->set('title_for_layout', __d(__PROJECT_LOCALE, 'add_project'));
		if ($this->request->is('post')) {

			$datasource = $this->Project->getDataSource();
			try {
				$datasource->begin();

				$data = Sanitize::clean($this->request->data);

				$file = $data['Project']['video'];

				if ($file['size'] > 0) {
					$output = $this->__uploadVideo();
					if (!$output['error']) $this->request->data['Project']['video'] = $output['filename'];
					else {
						$this->request->data['Project']['video'] = '';
						//@unlink(__PROJECT_IMAGE_PATH."/".$cover_image);
					}
				} else $this->request->data['Project']['video'] = '';

				if (!$this->Project->save($this->request->data))
					throw new Exception(__d(__PROJECT_LOCALE, 'the_project_could_not_be_saved_Please_try_again'));
				$project_id = $this->Project->getLastInsertID();

				/** @project translate */

				$this->Project->Projecttranslation->recursive = -1;
				$this->request->data['Projecttranslation']['project_id'] = $project_id;
				$this->request->data['Projecttranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
				$this->request->data['Projecttranslation']['title'] = trim($this->request->data['Projecttranslation']['title']);
				$this->request->data['Projecttranslation']['mini_detail'] = trim($this->request->data['Projecttranslation']['mini_detail']);
				$this->request->data['Projecttranslation']['detail'] = trim($this->request->data['Projecttranslation']['detail']);
				$this->Project->Projecttranslation->create();

				if (!$this->Project->Projecttranslation->save($this->request->data))
					throw new Exception(__d(__PROJECT_LOCALE, 'the_project_could_not_be_saved'));

				/** project translate */


				if (!empty($this->request->data['Projectimage']['image'])) {

					foreach ($this->request->data['Projectimage']['image'] as $key => $value) {
						if (trim($value['name']) == '') {
							unset($this->request->data['Projectimage']['image'][$key]);
							unset($this->request->data['Projectimage']['title'][$key]);
						}
					}
					$data = array();
					$image_list = array();
					foreach ($this->request->data['Projectimage']['image'] as $key => $value) {
						$output = $this->_picture($value, $key);
						if (!$output['error']) $image = $output['filename'];
						else {
							$image = '';
							if (!empty($image_list)) {
								foreach ($image_list as $img) {
									@unlink(__PROJECT_IMAGE_PATH . "/" . $img);
									@unlink(__PROJECT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $img);
								}
							}
							throw new Exception($output['message'] . '  ' . __d(__PROJECT_LOCALE, 'image_name') . ' ' . $value['name']);
						}

						$image_list[] = $image;

						$data = array('Projectimage' => array(
							'image' => $image,
							'project_id' => $project_id
						));

						if (!$this->Project->Projectimage->save($data))
							throw new Exception(__d(__PROJECT_LOCALE, 'the_project_image_not_saved'));

						$project_image_id = $this->Project->Projectimage->getLastInsertID();

						$this->loadModel('Projectimagetranslation');
						$this->Projectimagetranslation->recursive = -1;

						$datatranslate = array('Projectimagetranslation' => array(
							'title' => $this->request->data['Projectimage']['title'][$key],
							'project_image_id' => $project_image_id,
							'language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						));
						//pr($datatranslate);
						$this->Projectimagetranslation->create();
						if (!$this->Projectimagetranslation->save($datatranslate))
							throw new Exception(__d(__PROJECT_LOCALE, 'the_project_image_not_saved'));

					}
					//exit();

				}

				$datasource->commit();

				$this->Redirect->flashSuccess(__d(__PROJECT_LOCALE, 'the_project_has_been_saved'), array('action' => 'index'));
			} catch (Exception $e) {
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}

		}
		$this->loadModel(__PROJECT_PLUGIN . '.Projectcategory');
		$projectcategories = $this->Projectcategory->_getCategories(0, $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID));
		$this->set(compact('projectcategories'));
		$this->_loadCompanies();
	}

	public function _loadCompanies()
	{
		$this->loadModel('Companytranslation');
		$this->Companytranslation->recursive = -1;

		$options = array();
		$options['fields'] = array(
			'Companytranslation.company_id',
			'Companytranslation.title'
		);
		$options['conditions'] = array(
			//	"Companytranslation.company_id" => $id,
			"Companytranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
		);
		$companies = $this->Companytranslation->find('list', $options);
		$this->set('companies', $companies);
	}

	/**
	 * admin_edit method
	 *
	 * @param string $id
	 * @return void
	 * @throws NotFoundException
	 */

	private function __uploadVideo()
	{
		App::uses('Sanitize', 'Utility');

		$output = array();
		$data = Sanitize::clean($this->request->data);
		$file = $data['Project']['video'];

		if ($file['size'] > 0) {
			$ext = $this->Httpupload->get_extension($file['name']);
			$filename = md5(rand() . $_SERVER['REMOTE_ADDR']);
			if (file_exists(__PROJECT_IMAGE_PATH . $filename . '.' . $ext))
				$filename = md5(rand() . $_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Project');
			$this->Httpupload->setuploaddir(__PROJECT_IMAGE_PATH);
			$this->Httpupload->setuploadname('video');
			$this->Httpupload->settargetfile($filename . '.' . $ext);
			//$this->Httpupload->setmaxsize(__UPLOAD_FILE_MAX_SIZE);
			$this->Httpupload->allowExt = __UPLOAD_VIDEO_EXTENSION;
			if (!$this->Httpupload->upload()) {
				return array('error' => true, 'filename' => '', 'message' => $this->Httpupload->get_error());
			}
			$filename .= '.' . $ext;

		}
		return array('error' => false, 'filename' => $filename);
	}

	public
	function admin_edit($id = null)
	{
		$this->set('title_for_layout', __d(__PROJECT_LOCALE, 'edit_project'));
		if (!$this->Project->exists($id)) {
			$this->Redirect->flashWarning(__d(__PROJECT_LOCALE, 'invalid_project'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->loadModel('Projectimagetranslation');
			$this->Projectimagetranslation->recursive = -1;

			$datasource = $this->Project->getDataSource();
			try {
				$datasource->begin();

				$project = $this->Project->findById($id);
				$data = Sanitize::clean($this->request->data);

				$file = $data['Project']['video'];

				if ($file['size'] > 0) {
					$output = $this->__uploadVideo();
					if (!$output['error']) $this->request->data['Project']['video'] = $output['filename'];
					else {
						$this->request->data['Project']['video'] = '';
						//@unlink(__PROJECT_IMAGE_PATH."/".$cover_image);
					}
				} else $this->request->data['Project']['video'] = $project['Project']['video'];

				if (!$this->Project->save($this->request->data))
					throw new Exception(__d(__PROJECT_LOCALE, 'the_project_could_not_be_saved_Please_try_again'));

				/* project translation */
				$this->Project->Projecttranslation->recursive = -1;
				$options = array();
				$options['conditions'] = array(
					"Projecttranslation.project_id" => $id,
					"Projecttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				);
				$count = $this->Project->Projecttranslation->find('count', $options);
				/*
				* @project translate
				*/
				if ($count == 0) {
					$this->Project->Projecttranslation->recursive = -1;
					$this->request->data['Projecttranslation']['project_id'] = $id;
					$this->request->data['Projecttranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
					$this->request->data['Projecttranslation']['title'] = trim($this->request->data['Projecttranslation']['title']);
					$this->request->data['Projecttranslation']['little_detail'] = trim($this->request->data['Projecttranslation']['mini_detail']);
					$this->request->data['Projecttranslation']['detail'] = trim($this->request->data['Projecttranslation']['detail']);
					$this->Project->create();
					if (!$this->Project->Projecttranslation->save($this->request->data))
						throw new Exception(__d(__PROJECT_LOCALE, 'the_project_could_not_be_saved'));
				} else {
					$ret = $this->Project->Projecttranslation->updateAll(
						array('Projecttranslation.title' => '"' . trim($this->request->data['Projecttranslation']['title']) . '"',
							'Projecttranslation.mini_detail' => '"' . $this->request->data['Projecttranslation']['mini_detail'] . '"',
							'Projecttranslation.detail' => '"' . $this->request->data['Projecttranslation']['detail'] . '"'
						),
						array('Projecttranslation.project_id' => $id, 'language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))

					);
					if (!$ret) {

						throw new Exception(__d(__PROJECT_LOCALE, 'the_project_could_not_be_saved'));
					}
				}
				/* project translation */


				// image opration

				$options = array();
				$this->Project->Projectimage->recursive = -1;
				$options['fields'] = array(
					'Projectimage.id',
					'Projectimagetranslation.title',
					'Projectimage.image'
				);
				$options['joins'] = array(
					array(
						'table' => 'projectimagetranslations',
						'alias' => 'Projectimagetranslation',
						'type' => 'left',
						'conditions' => array(
							'Projectimage.id = Projectimagetranslation.project_image_id ',
							'Projectimagetranslation.language_id  = ' . $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID),
						)
					)
				);
				$options['conditions'] = array(
					'Projectimage.project_id' => $id
				);
				$projectimages = $this->Project->Projectimage->find('all', $options);
				//pr($this->request->data);throw new Exception();
				if (!empty($projectimages)) {
					foreach ($projectimages as $projectimage) {
						if (!in_array($projectimage['Projectimage']['id'], $this->request->data['Projectimage']['id'])) {
							if (!$this->Project->Projectimage->delete($projectimage['Projectimage']['id']))
								throw new Exception(__d(__PROJECT_LOCALE, 'the_project_image_not_saved'));
							else {
								@unlink(__PROJECT_IMAGE_PATH . "/" . $projectimage['Projectimage']['image']);
								@unlink(__PROJECT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $projectimage['Projectimage']['image']);
							}
						}
					}
				}


				if (!empty($this->request->data['Projectimage']['id'])) {
					foreach ($this->request->data['Projectimage']['id'] as $key => $value) {

						if ($this->request->data['Projectimage']['image'][$key]['size'] > 0) {

							@unlink(__PROJECT_IMAGE_PATH . "/" . $this->request->data['Projectimage']['old_image'][$key]);
							@unlink(__PROJECT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $this->request->data['Projectimage']['old_image'][$key]);
							$output = $this->_picture($this->request->data['Projectimage']['image'][$key], $key);
							if (!$output['error']) $image = $output['filename'];
							else {
								$image = '';
								if (!empty($image_list)) {
									foreach ($image_list as $img) {
										@unlink(__PROJECT_IMAGE_PATH . "/" . $img);
										@unlink(__PROJECT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $img);
									}
								}
								throw new Exception($output['message'] . '  ' . __d(__PROJECT_LOCALE, 'image_name') . ' ' . $this->request->data['Projectimage']['image'][$key]['name']);
							}

							$image_list[] = $image;
						} else $image = $this->request->data['Projectimage']['old_image'][$key];

						$ret = $this->Project->Projectimage->updateAll(
							array('Projectimage.image' => '"' . $image . '"'),   //fields to update
							array('Projectimage.id' => $value)  //condition
						);
						if (!$ret) {
							throw new Exception(__d(__PROJECT_LOCALE, 'the_project_image_not_saved'));
						}


						$this->Projectimagetranslation->recursive = -1;
						$options = array();
						$options['conditions'] = array(
							"Projectimagetranslation.project_image_id" => $value,
							"Projectimagetranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						);
						$count = $this->Projectimagetranslation->find('count', $options);
						/*
						* @project translate
						*/
						if ($count == 0) {
							$ProjectimagetranslationData = array();
							$this->Projectimagetranslation->recursive = -1;
							$ProjectimagetranslationData['Projectimagetranslation']['project_image_id'] = $value;
							$ProjectimagetranslationData['Projectimagetranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
							$ProjectimagetranslationData['Projectimagetranslation']['title'] = trim($this->request->data['Projectimage']['title'][$key]);
							$this->Projectimagetranslation->create();

							if (!$this->Projectimagetranslation->save($ProjectimagetranslationData))
								throw new Exception(__d(__PROJECT_LOCALE, 'the_project_could_not_be_saved'));
						} else

							$ret = $this->Projectimagetranslation->updateAll(
								array('Projectimagetranslation.title' => '"' . $this->request->data['Projectimage']['title'][$key] . '"'
								),   //fields to update
								array('Projectimagetranslation.project_image_id' => $value, 'Projectimagetranslation.language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))  //condition
							);
						if (!$ret) {
							throw new Exception(__d(__PROJECT_LOCALE, 'the_project_image_not_saved'));
						}

					}
				}


				if (!empty($this->request->data['Projectimage']['id'])) {
					foreach ($this->request->data['Projectimage']['id'] as $key => $value) {
						unset($this->request->data['Projectimage']['title'][$key]);
						unset($this->request->data['Projectimage']['image'][$key]);
					}
				}


				$data = array();
				if (!empty($this->request->data['Projectimage']['image'])) {

					foreach ($this->request->data['Projectimage']['image'] as $key => $value) {
						$output = $this->_picture($value, $key);
						if (!$output['error']) $image = $output['filename'];
						else {
							$image = '';
							if (!empty($image_list)) {
								foreach ($image_list as $img) {
									@unlink(__PROJECT_IMAGE_PATH . "/" . $img);
									@unlink(__PROJECT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $img);
								}
							}
							throw new Exception($output['message'] . '  ' . __d(__PROJECT_LOCALE, 'image_name') . ' ' . $value['name']);
						}

						$image_list[] = $image;

						$data = array('Projectimage' => array(
							'image' => $image,
							'project_id' => $id
						));


						if (!$this->Project->Projectimage->save($data))
							throw new Exception(__d(__PROJECT_LOCALE, 'the_project_image_not_saved'));

						$project_image_id = $this->Project->Projectimage->getLastInsertID();

						$datatranslate = array('Projectimagetranslation' => array(
							'title' => $this->request->data['Projectimage']['title'][$key],
							'project_image_id' => $project_image_id,
							'language_id' => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						));
						$this->Projectimagetranslation->create();
						if (!$this->Projectimagetranslation->save($datatranslate))
							throw new Exception(__d(__PROJECT_LOCALE, 'the_project_image_not_saved'));
					}
					//pr($data);throw new Exception();

				}


				// image opration


				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__PROJECT_LOCALE, 'the_project_has_been_saved'), array('action' => 'index'));

			} catch (Exception $e) {
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(), array('action' => 'index'));
			}

		} else {
			$this->Project->recursive = -1;

			$options = array();
			$options['fields'] = array(
				'Project.id',
				'Project.project_category_id',
				'Project.slug',
				'Project.company_id',
				'Projecttranslation.title',
				'Projecttranslation.mini_detail',
				'Projecttranslation.detail',
				'Project.status',
				'Project.created'
			);
			$options['joins'] = array(
				array('table' => 'projecttranslations',
					'alias' => 'Projecttranslation',
					'type' => 'left',
					'conditions' => array(
						'Project.id = Projecttranslation.project_id',
						"Projecttranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
					)
				)
			);
			$options['conditions'] = array(
				"Project.id" => $id,
			);

			$this->request->data = $this->Project->find('first', $options);

			$this->Project->Projectimage->recursive = -1;
			$options = array();
			$options['fields'] = array(
				'Projectimage.id',
				'Projectimagetranslation.title',
				'Projectimage.image'
			);
			$options['joins'] = array(
				array('table' => 'projectimagetranslations',
					'alias' => 'Projectimagetranslation',
					'type' => 'left',
					'conditions' => array(
						'Projectimage.id = Projectimagetranslation.project_image_id',
						"Projectimagetranslation.language_id" => $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
					)
				)
			);
			$options['conditions'] = array(
				'Projectimage.project_id' => $id
			);
			$projectimages = $this->Project->Projectimage->find('all', $options);
			$this->set('projectimages', $projectimages);
			$this->_loadCompanies();
		}

		$this->loadModel(__PROJECT_PLUGIN . '.Projectcategory');
		$projectcategories = $this->Projectcategory->_getCategories(0, $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID));

		$this->set(compact('projectcategories'));
	}

	/**
	 * admin_delete method
	 *
	 * @param string $id
	 * @return void
	 * @throws NotFoundException
	 */
	public
	function admin_delete($id = null)
	{
		$this->loadModel('Projectimagetranslation');
		$this->Projectimagetranslation->recursive = -1;

		$this->Project->id = $id;
		if (!$this->Project->exists()) {
			$this->Redirect->flashWarning(__d(__PROJECT_LOCALE, 'invalid_project'));
		}
		$this->Project->Projectimage->recursive = -1;
		$options['fields'] = array(
			'Projectimage.id',
			'Projectimage.image'
		);

		$options['conditions'] = array(
			'Projectimage.project_id' => $id
		);
		$images = $this->Project->Projectimage->find('all', $options);
		if ($this->Project->delete()) {

			$this->Project->Projectimage->deleteAll(array('Projectimage.project_id' => $id), false);
			$this->Project->Projecttranslation->deleteAll(array('Projecttranslation.project_id' => $id), false);

			if (!empty($images)) {
				foreach ($images as $img) {
					$this->Projectimagetranslation->deleteAll(array('Projectimagetranslation.project_image_id' => $img['Projectimage']['id']), false);
					@unlink(__PROJECT_IMAGE_PATH . "/" . $img['Projectimage']['image']);
					@unlink(__PROJECT_IMAGE_PATH . "/" . __UPLOAD_THUMB . "/" . $img['Projectimage']['image']);
				}
			}
			$this->Redirect->flashSuccess(__d(__PROJECT_LOCALE, 'the_project_has_been_deleted'));
		} else {
			$this->Redirect->flashWarning(__d(__PROJECT_LOCALE, 'the_project_could_not_be_deleted_please_try_again'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function admin_deletevideo($id = null)
	{
		$this->Project->id = $id;
		if (!$this->Project->exists()) {
			$this->Redirect->flashWarning(__d(__PROJECT_LOCALE, 'invalid_project'));
		}
		$project = $this->Project->findById($id);
		$this->Project->recursive = -1;
		$ret = $this->Project->updateAll(
			array('Project.video' => "NULL"
			),   //fields to update
			array('Project.id' => $id)  //condition
		);

		if ($ret) {
			@unlink(__PROJECT_IMAGE_PATH . "/" . $project['Project']['video']);
			$this->Redirect->flashSuccess(__d(__PROJECT_LOCALE, 'the_project_video_has_been_deleted'), array('action' => 'edit', $id));
		} else {
			$this->Redirect->flashWarning(__d(__PROJECT_LOCALE, 'the_project_video_could_not_be_deleted_please_try_again'), array('action' => 'edit', $id));
		}
		return $this->redirect(array('action' => 'edit', $id));
	}


	function _picture($data, $index)
	{
		App::uses('Sanitize', 'Utility');

		$output = array();

		if ($data['size'] > 0) {
			$ext = $this->Httpupload->get_extension($data['name']);
			$filename = md5(rand() . $_SERVER['REMOTE_ADDR']);
			if (file_exists(__PROJECT_IMAGE_PATH . $filename . '.' . $ext)) $filename = md5(rand() . $_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Projectimage');
			$this->Httpupload->setuploadindex($index);
			$this->Httpupload->setuploaddir(__PROJECT_IMAGE_PATH);
			$this->Httpupload->setuploadname('image');
			$this->Httpupload->settargetfile($filename . '.' . $ext);
			$this->Httpupload->setmaxsize(__UPLOAD_IMAGE_MAX_SIZE);
			$this->Httpupload->setimagemaxsize(__UPLOAD_IMAGE_MAX_WIDTH, __UPLOAD_IMAGE_MAX_HEIGHT);
			$this->Httpupload->allowExt = __UPLOAD_IMAGE_EXTENSION;
			$this->Httpupload->create_thumb = true;
			$this->Httpupload->thumb_folder = __UPLOAD_THUMB;
			$this->Httpupload->thumb_width = 180;
			$this->Httpupload->thumb_height = 120;
			if (!$this->Httpupload->upload()) {
				return array('error' => true, 'filename' => '', 'message' => $this->Httpupload->get_error());
			}
			$filename .= '.' . $ext;

		} else return array('error' => true, 'filename' => '', 'message' => '');

		return array('error' => false, 'filename' => $filename);
	}


	function index($category_id)
	{

		$this->Project->Projectcategory->recursive = -1;
		$options['fields'] = array(
			'Projectcategory.id',
			'Projectcategory.title',
			'Projectcategory.slug',
		);
		$options['conditions'] = array(
			"OR" => array('Projectcategory.id' => $category_id, 'Projectcategory.slug' => $category_id)
		);
		$category = $this->Project->Projectcategory->find('first', $options);

		$this->set('title_for_layout', __d(__PROJECT, 'projects') . ' ' . $category['Projectcategory']['title'] . __('default_title'));
		$this->set('description_for_layout', $category['Projectcategory']['title'] . ',' . __('site_description'));
		$this->set('keywords_for_layout', $category['Projectcategory']['title'] . ',' . __('site_keywords'));


		$open_graph_items = array(
			"property='og:title'" => __d(__PROJECT, 'projects') . ' ' . $category['Projectcategory']['title'] . __('default_title'),
			"property='og:description'" => $category['Projectcategory']['title'] . ',' . __('site_description'),
			"property='og:image'" => __SITE_URL . 'img/logo.png',
			"property='og:url'" => __SITE_URL . 'project/projects/index/' . $category['Projectcategory']['slug'],
			"name='twitter:title'" => __d(__PROJECT, 'projects') . ' ' . $category['Projectcategory']['title'] . __('default_title'),
			"name='twitter:description'" => $category['Projectcategory']['title'] . ',' . __('site_description'),
			"name='twitter:image'" => __SITE_URL . 'img/logo.png',
			"name='twitter:card'" => 'summary'
		);
		$this->set('open_graph_items', $open_graph_items);

		$options = array();
		$this->Project->recursive = -1;
		$options['fields'] = array(
			'Project.id',
			'Project.title',
			'Project.slug',
			'Project.mini_detail',
			'(select image from projectimages where project_id = Project.id limit 0,1)as image'
		);
		$options['conditions'] = array(
			'Project.status' => 1,
			'Project.project_category_id' => $category['Projectcategory']['id']
		);
		$options['order'] = array(
			'Project.id' => 'desc'
		);
		//$options['limit'] = 5;
		$projects = $this->Project->find('all', $options);
		$this->set('projects', $projects);
		$this->set('category', $category);
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
		$this->Project->recursive = -1;
		$options['fields'] = array(
			'Project.id',
			'Projecttranslation.title',
			'Companytranslation.title',
			'Project.slug',
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
			array('table'     => 'companytranslations',
				'alias'     => 'Companytranslation',
				'type'      => 'left',
				'conditions' => array(
					'Project.company_id = Companytranslation.company_id'
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
			'Project.status' => 1,
			'Language.code' => $this->Session->read('Config.language')
		);
		$options['order'] = array(
			'Project.id' => 'desc'
		);
		//$options['limit'] = 5;
		$projects = $this->Project->find('all', $options);

		$this->set(compact('projects'));


		$options = array();
		$options['conditions'] = array(
			'Project.status ' => 1
		);
		$total_count = $this->Project->find('count', $options);
		$this->set(compact('total_count'));

		$this->set('project_detail', __d(__PROJECT_LOCALE, 'weproject'));
		$this->set('limit', $limit);

		$this->set('title_for_layout', __d(__PROJECT_LOCALE, 'weproject'));
		$this->set('description_for_layout', __d(__PROJECT_LOCALE, 'weproject' . ',' . __('site_description')));
		$this->set('keywords_for_layout', __d(__PROJECT_LOCALE, 'weproject') . ',' . __('site_keywords'));
	}

	public function search()
	{
		//$this->request->data = Sanitize::clean($this->request->data);

		$itemspp_filter = '';
		$categoryid_filter = '';
		$search_projects = '';

		if (!empty($_GET['search']))
			$search_projects = Sanitize::clean($_GET['search']);

		if (!empty($_GET['itemspp_filter']))
			$itemspp_filter = Sanitize::clean($_GET['itemspp_filter']);
		if (!empty($_GET['categoryid_filter']))
			$categoryid_filter = Sanitize::clean($_GET['categoryid_filter']);


		$this->set('itemspp_filter', $itemspp_filter);
		$this->set('categoryid_filter', $categoryid_filter);


		$projectcategory = $this->Project->_getCategories(0);
		$this->set('projectcategory', $projectcategory);
		// ---------------------------------------------------------------
		$_limit = 20;
		if ($itemspp_filter == '1')
			$_limit = 6;


		if (!empty($_REQUEST['page'])) {
			$page = $_REQUEST['page'];
		} else $page = 1;

		if (isset($page)) {
			$first = ($page - 1) * $_limit;
		} else $first = 0;


		$_Order = 'ASC';


		$this->loadModel('Projectimage');
		$this->Project->recursive = -1;

		$options['fields'] = array(
			'Project.id',
			'Project.title',
			'(select image from  projectimages where project_id = Project.id limit 0,1) as image',
			'Projectcategory.title as CatTitle',
			'Projectcategory.id',
		);


		if ($categoryid_filter != '') {
			$categories = $this->Project->_getCategories($categoryid_filter);
			$ids = array($categoryid_filter);
			if (!empty($categories)) {
				foreach ($categories as $category) {
					$ids[] = $category['id'];
				}
			}


			$options['conditions'] = array(
				'OR' => array(
					'Projectcategory.id' => $categoryid_filter,
					'Projectcategory.id IN' => $ids,
				)

			);
		}

		if ($search_projects != '') {
			if (!empty($options['conditions'])) {
				array_push($options['conditions'], array('Project.title like ' => '%' . $search_projects . '%'));
			} else {
				$options['conditions'] = array('Project.title like ' => '%' . $search_projects . '%');
			}
		}


		$options['joins'] = array(
			array(
				'table' => 'projectcategories',
				'alias' => 'Projectcategory',
				'type' => 'LEFT',
				'conditions' => array('Project.project_category_id = Projectcategory.id')
			)
		);

		$total_count = $this->Project->find('count', $options);

		$options['limit'] = $_limit;
		$options['offset'] = $first;

		$projects = $this->Project->find('all', $options);
		$this->set('projects', $projects);
		$this->set('total_count', $total_count);
		$this->set('limit', $_limit);


		$options = array();
		$this->Project->recursive = -1;
		$options['fields'] = array(
			'Project.id',
			'Project.title',
			'Project.mini_detail',
			'(select image from projectimages where project_id = Project.id limit 0,1)as image'
		);
		$options['conditions'] = array(
			'Project.status' => 1
		);
		$options['order'] = array(
			'Project.id' => 'desc'
		);
		$options['limit'] = 5;
		$lastprojects = $this->Project->find('all', $options);
		$this->set('lastprojects', $lastprojects);

		$this->set('title_for_layout', 'محصولات');
		$this->set('description_for_layout', 'محصولات');
	}


	public function view($id)
	{

		$this->Project->id = $id;
		if (!$this->Project->exists()) {
			$project = $this->Project->findBySlug($id);
			if (empty($project)) {
				throw new NotFoundException(__('not_valid_page'));
			}
			$id = $project['Project']['id'];
		}

		$this->Project->recursive = -1;
		$options['fields'] = array(
			'Project.id',
			'Projecttranslation.title',
			'Projecttranslation.mini_detail',
			'Projecttranslation.detail',
			'Project.status',
			'Project.slug',
			'Project.project_category_id',
			'Project.video',
			'Project.created');

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
			"Project.id" => $id,
			'Language.code' => $this->Session->read('Config.language')
		);

		$project = $this->Project->find('first', $options);
		$this->set('project', $project);

		$id = Sanitize::clean($id);

		$this->Project->Projectimage->recursive = -1;
		$options['fields'] = array(
			'Projectimagetranslation.title',
			'Projectimage.image');

		$options['joins'] = array(
			array('table' => 'projectimagetranslations',
				'alias' => 'Projectimagetranslation',
				'type' => 'left',
				'conditions' => array(
					'Projectimage.id = Projectimagetranslation.project_image_id'
				)
			),
			array('table' => 'languages',
				'alias' => 'Language',
				'type' => 'left',
				'conditions' => array(
					'Language.id = Projectimagetranslation.language_id'
				)
			)
		);
		$options['conditions'] = array(
			'Projectimage.project_id' => $id,
			'Language.code' => $this->Session->read('Config.language')
		);

		$images = $this->Project->Projectimage->find('all', $options);
		$this->set('images', $images);

		/*$this->Project->Projectcategory->recursive = -1;
		$options['fields'] = array(
			'Projectcategory.id',
			'Projectcategorytranslation.title',
			'Projectcategory.slug',
		);

		$options['joins'] = array(
			array('table'     => 'projectcategoryimagetranslations',
				'alias'     => 'Projectcategorytranslation',
				'type'      => 'left',
				'conditions' => array(
					'Projectcategory.id = Projectcategorytranslation.projectcategoryimage_id'
				)
			),
			array('table'     => 'languages',
				'alias'     => 'Language',
				'type'      => 'left',
				'conditions' => array(
					'Language.id = Projectcategorytranslation.language_id'
				)
			)
		);

		$options['conditions'] = array(
			"OR" => array('Projectcategory.id' => $project['Project']['project_category_id'],)
		);
		$category = $this->Project->Projectcategory->find('first', $options);
		$this->set('category', $category);*/

		$options = array();
		$this->Project->recursive = -1;
		$options['fields'] = array(
			'Project.id',
			'Projecttranslation.title',
			'Project.slug',
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
			'Language.code' => $this->Session->read('Config.language')
		);
		$options['order'] = array(
			'Project.id' => 'desc'
		);
		$options['limit'] = 5;
		$lastprojects = $this->Project->find('all', $options);
		$this->set('lastprojects', $lastprojects);

		$this->set('title_for_layout', $project['Projecttranslation']['title'] . __('default_title'));
		$this->set('description_for_layout', $project['Projecttranslation']['mini_detail'] . ',' . __('site_description'));
		$this->set('keywords_for_layout', $project['Projecttranslation']['title'] . ',' . __('site_keywords'));
		$this->set('header_canonical', __SITE_URL . __PROJECT . "/" . $project['Project']['slug']);

		$open_graph_items = array(
			"property='og:title'" => $project['Projecttranslation']['title'] . __('default_title'),
			"property='og:description'" => $project['Projecttranslation']['mini_detail'] . ',' . __('site_description'),
			"property='og:image'" => __SITE_URL . __PROJECT_IMAGE_URL . __UPLOAD_THUMB . '/' . $images[0]['Projectimage']['image'],
			"property='og:url'" => __SITE_URL . __PROJECT . "/" . $project['Project']['slug'],

			"name='twitter:title'" => $project['Projecttranslation']['title'] . __('default_title'),
			"name='twitter:description'" => $project['Projecttranslation']['mini_detail'] . ',' . __('site_description'),
			"name='twitter:image'" => __SITE_URL . __PROJECT_IMAGE_URL . __UPLOAD_THUMB . '/' . $images[0]['Projectimage']['image'],
			"name='twitter:card'" => 'summary'
		);
		$this->set('open_graph_items', $open_graph_items);
	}

}
