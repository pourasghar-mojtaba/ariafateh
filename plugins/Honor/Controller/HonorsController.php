<?php
App::uses('AppController', 'Controller');

class HonorsController extends HonorAppController
{
	/**
	* Components
	*
	* @var array
	*/
	public $components = array('Paginator','Httpupload','CmsAcl'=>array('allUsers'=>array('index')));
	public $helpers = array('AdminHtml'=>array('action'=>'Honor'));
	/**
	* admin_index method
	*
	* @return void
	*/

	public
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->Auth->allow('search','view');
	}

	public
	function admin_index()
	{
		$this->Honor->recursive = -1;
		$this->set('title_for_layout',__d(__HONOR_LOCALE,'honor_list'));
		if(isset($_REQUEST['filter'])){
			$limit = $_REQUEST['filter'];
		}
		else $limit = 10;

		if(isset($this->request->data['Honor']['search'])){
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'=>array(
					'Honorcategory.title',
					'Honor.id',
					'Honor.title',
					'Honor.mini_detail',
					'Honor.status',
					'Honor.created',
				),
				'joins'=>array(array('table' => 'honortranslations',
					'alias' => 'Honortranslation',
					'type' => 'left',
					'conditions' => array(
					'Honor.id = Honortranslation.honor_id ',
					)
				 )),
				'conditions' => array('Honortranslation.title LIKE'=> ''.$this->request->data['Honor']['search'].'%','Honortranslation.language_id'=> $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID) ),
				'limit'     => $limit,
				'order'                     => array(
					'Honor.id'=> 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
				'fields'=>array(
					'Honor.id',
					'Honortranslation.title',
					'(select count(*) from honorimages where honor_id = Honor.id) as imagecount',
					'Honor.status',
					'Honor.created',
				),
				'joins'=>array(array('table' => 'honortranslations',
					'alias' => 'Honortranslation',
					'type' => 'left',
					'conditions' => array(
					'Honor.id = Honortranslation.honor_id ',
					)
				 )),
				'conditions' => array('Honortranslation.language_id'=> $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID) ),
				'limit'=> $limit,
				'order' => array(
					'Honor.id'=> 'desc'
				)
			);
		}
		$honors = $this->paginate('Honor');
		$this->set(compact('honors'));
	}


	/**
	* admin_add method
	*
	* @return void
	*/
	public
	function admin_add()
	{
		$this->set('title_for_layout',__d(__HONOR_LOCALE,'add_honor'));
		if($this->request->is('post')){

			$datasource = $this->Honor->getDataSource();
			try
			{
				$datasource->begin();

				if(!$this->Honor->save($this->request->data))
					throw new Exception(__d(__HONOR_LOCALE,'the_honor_could_not_be_saved_Please_try_again'));
				$honor_id = $this->Honor->getLastInsertID();
				/*
				* @honor translate
				*/

				$this->Honor->Honortranslation->recursive = - 1;
				$this->request->data['Honortranslation']['honor_id'] = $honor_id;
				$this->request->data['Honortranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
				$this->request->data['Honortranslation']['title'] = trim($this->request->data['Honortranslation']['title']);
				$this->Honor->Honortranslation->create();
				if(!$this->Honor->Honortranslation->save($this->request->data))
					throw new Exception(__d(__BLOG_LOCALE,'the_honor_could_not_be_saved_Please_try_again'));

				/*
				* honor translate
				*/


				if(!empty($this->request->data['Honorimage']['image'])){

					$this->Honor->Honorimage->recursive = -1;


					foreach($this->request->data['Honorimage']['image'] as $key => $value){
						if(trim($value['name']) == '')
						{
							unset($this->request->data['Honorimage']['image'][$key]);
							unset($this->request->data['Honorimage']['title'][$key]);
						}
					}
					$data = array();
					$datatranslate = array();
					$image_list = array();

					$this->loadModel('Honorimagetranslation');
					$this->Honorimagetranslation->recursive = -1;

					foreach($this->request->data['Honorimage']['image'] as $key => $value){
						$output = $this->_picture($value,$key);
						if(!$output['error']) $image = $output['filename'];
						else
						{
							$image = '';
							if(!empty($image_list))
							{
								foreach($image_list as $img){
									@unlink(__HONOR_IMAGE_PATH."/".$img);
									@unlink(__HONOR_IMAGE_PATH."/".__UPLOAD_THUMB."/".$img);
								}
							}
							throw new Exception($output['message'].'  '.__d(__HONOR_LOCALE,'image_name').' '.$value['name']);
						}

						$image_list[] = $image;

						$data = array('Honorimage' => array(
								'image'     => $image ,
								'honor_id'=> $honor_id
							));
						$this->Honor->Honorimage->create();
						if(!$this->Honor->Honorimage->save($data))
							throw new Exception(__d(__HONOR_LOCALE,'the_honor_image_not_saved'));

						$honorimage_id = $this->Honor->Honorimage->getLastInsertID();

						$datatranslate = array('Honorimagetranslation' => array(
								'title'      => $this->request->data['Honorimage']['title'][$key],
								'honorimage_id' => $honorimage_id,
								'language_id'=> $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
							));
						$this->Honorimagetranslation->create();
						if(!$this->Honorimagetranslation->save($datatranslate))
							throw new Exception(__d(__HONOR_LOCALE,'the_honor_image_not_saved'));
					}

				}

				$datasource->commit();

				$this->Redirect->flashSuccess(__d(__HONOR_LOCALE,'the_honor_has_been_saved'),array('action'=>'index'));
			} catch(Exception $e){
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(),array('action'=>'index'));
			}

		}


	}

	/**
	* admin_edit method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public
	function admin_edit($id = null)
	{
		$this->set('title_for_layout',__d(__HONOR_LOCALE,'edit_honor'));
		if(!$this->Honor->exists($id)){
			$this->Redirect->flashWarning(__d(__HONOR_LOCALE,'invalid_honor'));
		}
		if($this->request->is(array('post', 'put'))){

			$datasource = $this->Honor->getDataSource();
			try
			{
				$datasource->begin();

				if(!$this->Honor->save($this->request->data))
				throw new Exception(__d(__HONOR_LOCALE,'the_honor_could_not_be_saved_Please_try_again'));


				$this->Honor->Honortranslation->recursive = - 1;
				$options = array();
				$options['conditions'] = array(
					"Honortranslation.honor_id"=> $id,
					"Honortranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
				);
				$count = $this->Honor->Honortranslation->find('count',$options);
				/*
				* @honor translate
				*/
				if($count==0){
					$this->Honor->Honortranslation->recursive = - 1;
					$this->request->data['Honortranslation']['honor_id'] = $id;
					$this->request->data['Honortranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
					$this->request->data['Honortranslation']['title'] = trim($this->request->data['Honortranslation']['title']);
					$this->Honor->create();
					if(!$this->Honor->Honortranslation->save($this->request->data))
						throw new Exception(__d(__BLOG_LOCALE,'the_honor_could_not_be_saved'));
				}else
				{
					$ret= $this->Honor->Honortranslation->updateAll(
					    array('Honortranslation.title' =>'"'.trim($this->request->data['Honortranslation']['title']).'"',
							  ),
		    			array('Honortranslation.honor_id'=>$id,'language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID))

					  );
					if(!$ret){

						throw new Exception(__d(__BLOG_LOCALE,'the_honor_could_not_be_saved'));
					}
				}
				/*
				* honor translate
				*/


				// image opration

				$options = array();
				$this->Honor->Honorimage->recursive=-1;
				$options['fields'] = array(
					'Honorimage.id',
					'Honorimagetranslation.title',
					'Honorimage.image'
				);
				$options['joins'] = array(
				  array(
			        'table' => 'honorimagetranslations',
					'alias' => 'Honorimagetranslation',
					'type' => 'left',
					'conditions' => array(
						'Honorimage.id = Honorimagetranslation.honorimage_id ',
						'Honorimagetranslation.language_id  = '.$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID),
						)
				   )
				  ) ;
				$options['conditions'] = array(
					'Honorimage.honor_id'=> $id
				);
				$honorimages = $this->Honor->Honorimage->find('all',$options);
				$this->loadModel('Honorimagetranslation');
				//pr($honorimages);pr($this->request->data);exit();

				if(!empty($honorimages))
				{
					if(!empty($this->request->data['Honorimage']['id'])){
						foreach($honorimages as $honorimage){
							if(!in_array($honorimage['Honorimage']['id'],$this->request->data['Honorimage']['id'])){
								if(!$this->Honor->Honorimage->delete($honorimage['Honorimage']['id']))
								throw new Exception(__d(__HONOR_LOCALE,'the_honor_image_not_saved'));
								else
								{
									@unlink(__HONOR_IMAGE_PATH."/".$honorimage['Honorimage']['image']);
									@unlink(__HONOR_IMAGE_PATH."/".__UPLOAD_THUMB."/".$honorimage['Honorimage']['image']);
								}
							}
						}
					}
					else{
						foreach($honorimages as $honorimage){
							if(!$this->Honor->Honorimage->delete($honorimage['Honorimage']['id']))
							throw new Exception(__d(__HONOR_LOCALE,'the_honor_image_not_saved'));
							else
							{
								@unlink(__HONOR_IMAGE_PATH."/".$honorimage['Honorimage']['image']);
								@unlink(__HONOR_IMAGE_PATH."/".__UPLOAD_THUMB."/".$honorimage['Honorimage']['image']);
							}
						}
					}
				}


				if(!empty($this->request->data['Honorimage']['id']))
				{

					foreach($this->request->data['Honorimage']['id'] as $key => $value){

						if($this->request->data['Honorimage']['image'][$key]['size'] > 0)
						{

							@unlink(__HONOR_IMAGE_PATH."/".$this->request->data['Honorimage']['old_image'][$key]);
							@unlink(__HONOR_IMAGE_PATH."/".__UPLOAD_THUMB."/".$this->request->data['Honorimage']['old_image'][$key]);
							$output = $this->_picture($this->request->data['Honorimage']['image'][$key],$key);
							if(!$output['error']) $image = $output['filename'];
							else
							{
								$image = '';
								if(!empty($image_list))
								{
									foreach($image_list as $img){
										@unlink(__HONOR_IMAGE_PATH."/".$img);
										@unlink(__HONOR_IMAGE_PATH."/".__UPLOAD_THUMB."/".$img);
									}
								}
								throw new Exception($output['message'].'  '.__d(__HONOR_LOCALE,'image_name').' '.$this->request->data['Honorimage']['image'][$key]['name']);
							}

							$image_list[] = $image;
						}
						else $image = $this->request->data['Honorimage']['old_image'][$key];

						$ret   = $this->Honor->Honorimage->updateAll(
							array('Honorimage.image'=> '"'.$image.'"'	),   //fields to update
							array('Honorimage.id'=> $value )  //condition
						);
						if(!$ret)
						{
							throw new Exception(__d(__HONOR_LOCALE,'the_honor_image_not_saved'));
						}


						$this->Honorimagetranslation->recursive = - 1;
						$options = array();
						$options['conditions'] = array(
							"Honorimagetranslation.honorimage_id"=> $value,
							"Honorimagetranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
						);
						$count = $this->Honorimagetranslation->find('count',$options);
						/*
						* @honor translate
						*/
						if($count==0){
							$HonorimagetranslationData = array();
							$this->Honorimagetranslation->recursive = - 1;
							$HonorimagetranslationData['Honorimagetranslation']['honorimage_id'] = $value;
							$HonorimagetranslationData['Honorimagetranslation']['language_id'] = $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID);
							$HonorimagetranslationData['Honorimagetranslation']['title'] = trim($this->request->data['Honorimage']['title'][$key]);
							$this->Honorimagetranslation->create();

							if(!$this->Honorimagetranslation->save($HonorimagetranslationData))
								throw new Exception(__d(__BLOG_LOCALE,'the_honor_could_not_be_saved'));
						}else

						$ret   = $this->Honorimagetranslation->updateAll(
							array('Honorimagetranslation.title'=> '"'.$this->request->data['Honorimage']['title'][$key].'"'
							),   //fields to update
							array('Honorimagetranslation.honorimage_id'=> $value,'Honorimagetranslation.language_id'=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID) )  //condition
						);
						if(!$ret)
						{
							throw new Exception(__d(__HONOR_LOCALE,'the_honor_image_not_saved'));
						}
					}
				}




				if(!empty($this->request->data['Honorimage']['id']))
				{
					foreach($this->request->data['Honorimage']['id'] as $key => $value){
						unset($this->request->data['Honorimage']['title'][$key]);
						unset($this->request->data['Honorimage']['image'][$key]);
					}
				}



				$data = array();
				if(!empty($this->request->data['Honorimage']['image']))
				{

					foreach($this->request->data['Honorimage']['image'] as $key => $value){
						$output = $this->_picture($value,$key);
						if(!$output['error']) $image = $output['filename'];
						else
						{
							$image = '';
							if(!empty($image_list))
							{
								foreach($image_list as $img){
									@unlink(__HONOR_IMAGE_PATH."/".$img);
									@unlink(__HONOR_IMAGE_PATH."/".__UPLOAD_THUMB."/".$img);
								}
							}
							throw new Exception($output['message'].'  '.__d(__HONOR_LOCALE,'image_name').' '.$value['name']);
						}

						$image_list[] = $image;

						$data = array('Honorimage' => array(
								'image'     => $image ,
								'honor_id'=> $id
							));
						$this->Honor->Honorimage->create();
						if(!$this->Honor->Honorimage->save($data))
							throw new Exception(__d(__HONOR_LOCALE,'the_honor_image_not_saved'));

						$honorimage_id = $this->Honor->Honorimage->getLastInsertID();

						$datatranslate = array('Honorimagetranslation' => array(
								'title'      => $this->request->data['Honorimage']['title'][$key],
								'honorimage_id' => $honorimage_id,
								'language_id'=> $this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
							));
						$this->Honorimagetranslation->create();
						if(!$this->Honorimagetranslation->save($datatranslate))
							throw new Exception(__d(__HONOR_LOCALE,'the_honor_image_not_saved'));

					}

				}


				// image opration


				$datasource->commit();
				$this->Redirect->flashSuccess(__d(__HONOR_LOCALE,'the_honor_has_been_saved'),array('action'=>'index'));

			} catch(Exception $e)
			{
				$datasource->rollback();
				$this->Redirect->flashWarning($e->getMessage(),array('action'=>'index'));
			}

		}
		else
		{
			$this->_set_honor($id);

			$this->Honor->Honorimage->recursive = -1;
			$options=array();
			$options['fields'] = array(
					'Honorimage.id',
					'Honorimagetranslation.title',
					'Honorimage.image'
				   );
			$options['joins'] = array(
			  array(
		        'table' => 'honorimagetranslations',
				'alias' => 'Honorimagetranslation',
				'type' => 'left',
				'conditions' => array(
					'Honorimage.id = Honorimagetranslation.honorimage_id ',
					'Honorimagetranslation.language_id  = '.$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID),
					)
			   )
			  ) ;
			$options['conditions'] = array(
				'Honorimage.honor_id' => $id
				);
			$honorimages = $this->Honor->Honorimage->find('all',$options);
		    $this->set('honorimages', $honorimages);
		}


	}

	function _set_honor($id)
	{
		$this->Honor->recursive = - 1;
		$this->Honor->id = $id;
		if(!$this->Honor->exists()){
			$this->Session->setFlash(__('invalid_id_for_honor'));
			return;
		}

		/*
		* Test allowing to not override submitted data
		*/
		if(empty($this->request->data)){

			$this->Honor->recursive = - 1;
			$options = array();
			$options['fields'] = array(
				'Honor.id',
				'Honortranslation.title',
				'Honortranslation.detail',
				'Honor.status',
				'Honor.created',
			);
			$options['joins'] = array(

				array('table'     => 'honortranslations',
					'alias'     => 'Honortranslation',
					'type'      => 'left',
					'conditions' => array(
						'Honor.id = Honortranslation.honor_id'
					)
				)
			);

			$options['conditions'] = array(
				"Honor.id"=> $id,
				"Honortranslation.language_id"=>$this->Cookie->read(__ADMIN_LANG_DEFAULT_ID)
			);

			$honor      = $this->Honor->find('first',$options);

			//$this->request->data = $this->Honor->findById($id);
		}
		if(empty($honor)){
			$honor = array(
				"Honor" => array(
					"id" => $id,
					"status"=>1,
				),
				"Honortranslation" => array(
					"title" => "",
				)
			);
		}
		$this->set('honor', $honor);
		$this->request->data = $honor;

		return $honor;
	}

	/**
	* admin_delete method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public
	function admin_delete($id = null)
	{
		$this->Honor->id = $id;
		if(!$this->Honor->exists()){
			$this->Redirect->flashWarning(__d(__HONOR_LOCALE,'invalid_honor'));
		}
		$this->Honor->Honorimage->recursive = -1;
		$options['fields'] = array(
			'Honorimage.id',
			'Honorimage.image'
		   );

		$options['conditions'] = array(
			'Honorimage.honor_id'=>$id
		);
		$images = $this->Honor->Honorimage->find('all',$options);
		if($this->Honor->delete()){
			if(!empty($images)){
			 	foreach($images as $img){
					@unlink(__HONOR_IMAGE_PATH."/".$img['Honorimage']['image']);
					@unlink(__HONOR_IMAGE_PATH."/".__UPLOAD_THUMB."/".$img['Honorimage']['image']);
				}
			 }

			$this->Honor->Honorimage->deleteAll(array('Honorimage.honor_id'=>$id),FALSE);

			$this->Redirect->flashSuccess(__d(__HONOR_LOCALE,'the_honor_has_been_deleted'));
		}
		else
		{
			$this->Redirect->flashWarning(__d(__HONOR_LOCALE,'the_honor_could_not_be_deleted_please_try_again'));
		}
		return $this->redirect(array('action'=> 'index'));
	}


	function _picture($data,$index)
	{
		App::uses('Sanitize', 'Utility');

		$output = array();

		if($data['size'] > 0)
		{
			$ext      = $this->Httpupload->get_extension($data['name']);
			$filename = md5(rand().$_SERVER['REMOTE_ADDR']);
			if(file_exists(__HONOR_IMAGE_PATH.$filename.'.'.$ext))				$filename = md5(rand().$_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('Honorimage');
			$this->Httpupload->setuploadindex($index);
			$this->Httpupload->setuploaddir(__HONOR_IMAGE_PATH);
			$this->Httpupload->setuploadname('image');
			$this->Httpupload->settargetfile($filename.'.'.$ext);
			$this->Httpupload->setmaxsize(__UPLOAD_IMAGE_MAX_SIZE);
			$this->Httpupload->setimagemaxsize(__UPLOAD_IMAGE_MAX_WIDTH,__UPLOAD_IMAGE_MAX_HEIGHT);
			$this->Httpupload->allowExt = __UPLOAD_IMAGE_EXTENSION;
			$this->Httpupload->create_thumb = true;
			$this->Httpupload->thumb_folder = __UPLOAD_THUMB;
			$this->Httpupload->thumb_width = 180;
			$this->Httpupload->thumb_height = 120;
			if(!$this->Httpupload->upload())
			{
				return array('error'   =>true,'filename'=>'','message' =>$this->Httpupload->get_error());
			}
			$filename .= '.'.$ext;

		}
		else return array('error'   =>true,'filename'=>'','message' =>'');

		return array('error'   =>false,'filename'=>$filename);
	}


	function index($category_id){

		$this->Honor->Honorcategory->recursive=-1;
		$options['fields'] = array(
				'Honorcategory.id',
				'Honorcategory.title'
			   );
		$options['conditions'] = array(
			"OR" => array('Honorcategory.id'=> $category_id,'Honorcategory.slug'=> $category_id)
			);
		$category = $this->Honor->Honorcategory->find('first',$options);

		$this->set('title_for_layout',__d(__HONOR,'honors').' '.$category['Honorcategory']['title']);
		$this->set('description_for_layout',$category['Honorcategory']['title']);
		$this->set('keywords_for_layout',$category['Honorcategory']['title']);

		$options = array();
		$this->Honor->recursive = - 1;
		$options['fields'] = array(
			'Honor.id',
			'Honor.title',
			'Honor.mini_detail',
			'(select image from honorimages where honor_id = Honor.id limit 0,1)as image'
		);
		$options['conditions'] = array(
			'Honor.status'=> 1,
			'Honor.honor_category_id'=> $category['Honorcategory']['id']
		);
		$options['order'] = array(
			'Honor.id'=>'desc'
		);
		//$options['limit'] = 5;
		$honors = $this->Honor->find('all',$options);
		$this->set('honors',$honors);
		$this->set('category',$category);
	}


	public function search()
	{
		//$this->request->data = Sanitize::clean($this->request->data);

		$itemspp_filter='';
		$categoryid_filter='';
		$search_honors='';

		if(!empty($_GET['search']))
			$search_honors = Sanitize::clean($_GET['search']);

		if(!empty($_GET['itemspp_filter']))
			$itemspp_filter = Sanitize::clean($_GET['itemspp_filter']);
		if(!empty($_GET['categoryid_filter']))
			$categoryid_filter = Sanitize::clean($_GET['categoryid_filter']);


		$this->set('itemspp_filter',$itemspp_filter);
		$this->set('categoryid_filter',$categoryid_filter);


		$honorcategory = $this->Honor->_getCategories(0);
		$this->set('honorcategory',$honorcategory);
		// ---------------------------------------------------------------
		$_limit=20;
		if($itemspp_filter=='1')
			$_limit=6;


		if(!empty($_REQUEST['page']))
		{
			$page = $_REQUEST['page'];
		}
		else $page = 1;

		if(isset($page)){
			$first = ($page - 1) * $_limit;
		}
		else $first = 0;


		$_Order='ASC';


		$this->loadModel('Honorimage');
		$this->Honor->recursive = -1;

		$options['fields'] = array(
			'Honor.id',
			'Honor.title',
			'(select image from  honorimages where honor_id = Honor.id limit 0,1) as image',
			'Honorcategory.title as CatTitle',
			'Honorcategory.id',
		   );



		if($categoryid_filter!='')
		{
			$categories = $this->Honor->_getCategories($categoryid_filter);
			$ids= array($categoryid_filter);
			if(!empty($categories)){
				foreach($categories as $category){
					$ids[]=$category['id'];
				}
			}


			$options['conditions'] = array(
				'OR' => array(
		            'Honorcategory.id'=> $categoryid_filter,
		            'Honorcategory.id IN'=> $ids,
		        )

			);
		}

		if($search_honors!='')
		{
			if(!empty($options['conditions'])){
				array_push($options['conditions'],array('Honor.title like '=> '%'.$search_honors.'%'));
			}else{
				$options['conditions'] = array('Honor.title like '=> '%'.$search_honors.'%');
			}
		}


		$options['joins'] = array(
			array(
				'table' => 'honorcategories',
				'alias' => 'Honorcategory',
				'type' => 'LEFT',
				'conditions' => array('Honor.honor_category_id = Honorcategory.id')
			)
		);

		$total_count = $this->Honor->find('count',$options);

		$options['limit'] = $_limit;
		$options['offset'] = $first;

		$honors = $this->Honor->find('all',$options);
		$this->set('honors',$honors);
		$this->set('total_count',$total_count);
		$this->set('limit',$_limit);


		$options = array();
		$this->Honor->recursive = - 1;
		$options['fields'] = array(
			'Honor.id',
			'Honor.title',
			'Honor.mini_detail',
			'(select image from honorimages where honor_id = Honor.id limit 0,1)as image'
		);
		$options['conditions'] = array(
			'Honor.status'=> 1
		);
		$options['order'] = array(
			'Honor.id'=>'desc'
		);
		$options['limit'] = 5;
		$lasthonors = $this->Honor->find('all',$options);
		$this->set('lasthonors',$lasthonors);

		$this->set('title_for_layout','محصولات');
		$this->set('description_for_layout','محصولات');
	}


	public function view(){
		$this->Honor->recursive = -1;

		$options = array();
		$options['fields'] = array(
			'Honor.id',
			'Honortranslation.title',
			'Honortranslation.detail'
		);

		$options['joins'] = array(
			array('table'     => 'honortranslations',
				'alias'     => 'Honortranslation',
				'type'      => 'left',
				'conditions' => array(
					'Honor.id = Honortranslation.honor_id'
				  )
				),
			array('table'     => 'languages',
				'alias'     => 'Language',
				'type'      => 'left',
				'conditions' => array(
					'Language.id = Honortranslation.language_id'
				)
			  )
		);

		$options['conditions'] = array(
			'Honor.status'=> 1,
			'Language.code'=>$this->Session->read('Config.language')
		);
		/*$options['order'] = array(
			'Honor.id'=>'asc'
		);*/
		$honor = $this->Honor->find('first',$options);

		//--------------------------------------------------------
		$options = array();
		$this->Honor->Honorimage->recursive = - 1;
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
			'Language.code'=>$this->Session->read('Config.language')
		);
		$options['order'] = array(
			'Honorimage.id'=>'asc'
		);
		//$options['limit'] = 5;
		$honorimages = $this->Honor->Honorimage->find('all',$options);

		$this->set('honorimages',$honorimages);
		$this->set('honor',$honor);
		$this->set('title_for_layout',__d(__HONOR_LOCALE,'last_honors'));
		$this->set('description_for_layout',__d(__HONOR_LOCALE,'last_honors'));
	}

}
?>
