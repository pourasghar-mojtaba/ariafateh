<?php

App::uses('AppController', 'Controller');
App::uses('Sanitize', 'Utility');
/**
* Users Controller
*
* @property User $User
* @property PaginatorComponent $Paginator
*/
class UsersController extends AppController
{

	public function beforeFilter() {
		parent::beforeFilter();

		$this->Auth->allow(array('register','login','recaptcha','logout','captcha_image'));

		$this->_add_admin_member_permision(array('admin_user_search','admin_dashboard'));

		$this->_add_member_permision(array('edit_profile','edit_address','edit_password'));
	 }


	/**
	* Components
	*
	* @var array
	*/
	public $components = array('Paginator','Httpupload');
	public $helpers = array('AdminHtml'=>array('action'=>'User'));
	/**
	* index method
	*
	* @return void
	*/

	public function register(){
		$error = false;

		if($this->request->is('post'))
		{

			/*if($this->request->data['User']['captcha'] != $this->Session->read('captcha'))
			{
				$this->Session->setFlash(__('incorrect_captcha'),'error');
				return FALSE;
			}*/

			$this->request->data['User']['role_id'] = 2;	// user role
			$password = $this->request->data['User']['password'];

			$this->request->data = Sanitize::clean($this->request->data);

			$register_key = $this->Cms->random_number(4);

			$this->request->data['User']['register_key'] = $register_key;


			if(!$this->_check_mobile($this->request->data['User']['mobile'])){
				$this->Session->setFlash(__('exist_mobile'),'error');
				return FALSE;
			}

			if($error != TRUE){
				$this->User->create();
				if($this->User->save($this->request->data))
				{
					//$this->Session->write('Register',array('register_email'=> $this->request->data['User']['email'],'register_key'  => $register_key));
						App::import('Vendor','nusoap', array('file'=>'nusoap'.DS.'lib'.DS.'nusoap.php'));

						$userName = __SMS_USER;
						$password = __SMS_PASSWORD;
						//$lineNumber = $_POST ['lineNumber'];
						$to       = $this->request->data['User']['mobile'];

						$text     = __('you_register_sucess_with_mobile').$register_key;

						date_default_timezone_set('Asia/Tehran');
						$client   = new SoapClient(__SMS_WEB_SERVICE_ADDRESS);

						$parameters['userName'] = $userName;
						$parameters['password'] = $password;
						$parameters['mobileNos'] = array(doubleval($to));
						$parameters['messages'] = array($text);
						$parameters['lineNumber'] = __LINE_NUMBER;
						$parameters['sendDateTime'] = date("Y-m-d")."T".date("H:i:s");
						print_r($client->SendMessageWithLineNumber($parameters));
						$this->redirect('/users/confirmation_mobile/'.$this->request->data['User']['mobile']);
				}
				else
				{
					$this->Session->setFlash(__('register_not_successfully'),'error');
				}
			}

		}

		$this->set('title_for_layout',__('register'));
		$this->set('description_for_layout',__('register'));
		$this->set('keywords_for_layout',__('register'));
	}

	public
	function _check_mobile($mobile)
	{
		$this->User->recursive = - 1;
		$result = $this->User->find('count', array('conditions' => array('User.mobile'=> $mobile)));
		if($result >= 1)
		{
			return false;
		}
		return TRUE;
	}

	public function login() {
		if($this->request->is('post'))
		{
			$user_name = $this->request->data['User']['user_name'];
			if($this->Auth->login()){
				$ret = $this->User->updateAll(
					array('User.last_login'=>'"'.date('Y-m-d H:i:s').'"'),   //fields to update
					array('User.user_name'=> $user_name)  //condition
				);

				$fields = array(
					'User.id',
					'User.name',
					'User.sex',
					'User.age',
					'User.email',
					'User.image',
					'User.user_name',
					'User.mobile',
					'User.created'
				);

				$options['conditions'] = array(
					'User.user_name'=> $user_name
				);
				$user = $this->User->find('first',$options);

				$this->Session->write('User_Info',array(
					'id'          => $user['User']['id'] ,
					'name'        => !empty($user['User']['name'])?$user['User']['name']:$user['User']['user_name'] ,
					'sex'         => $user['User']['sex'] ,
					'age'         => $user['User']['age'],
					'email'       => $user['User']['email'],
					'image'       => $user['User']['image'],
					'user_name'   => $user['User']['user_name']
				));

				$this->redirect(array('controller' => 'pages','action' => 'display'));
			}else{
				$this->Redirect->flashWarning(__('please_enter_valid_username_and_password'));
			}
		}
		$this->set('title_for_layout',__('login'));
		$this->set('description_for_layout',__('login'));
		$this->set('keywords_for_layout',__('login'));
	}

	function logout()
	{
		$this->Session->destroy();
		$this->Session->delete('User_Info');
		$this->Auth->logout();
		$this->redirect(array('controller' => 'pages','action' => 'display'));
	}
	public function edit_profile(){
		$User_Info = $this->Session->read('User_Info');
		$this->User->id = $User_Info['id'];

		if(($this->request->is('post') || $this->request->is('put')))
		{

			//pr($this->request->data);exit();
			$datasource = $this->User->getDataSource();
			try
			{
				$datasource->begin();

				if(isset($this->request->data['User']['name']) && trim($this->request->data['User']['name']) == '' && $this->request->is('post'))
				 throw new Exception(__('invalid_name'),2);

				if(!$this->User->exists())
					throw new Exception(__('invalid_id_for_user'),3);

				$this->request->data['User']['id'] = $User_Info['id'];
				if($this->User->save($this->request->data))
				{

					$this->Session->write('User_Info',array(
						'id'          => $User_Info['id'] ,
						'name'        => !empty($this->request->data['User']['name'])?$this->request->data['User']['name']:$this->request->data['User']['user_name'] ,
						'sex'         => $this->request->data['User']['sex'] ,
						'age'         => $User_Info['age'],
						'email'       => $this->request->data['User']['email'],
						'image'       => $User_Info['image'],
						'user_name'   => $this->request->data['User']['user_name']
					));
				}
				else
				{
					throw new Exception(__('edit_profile_notsuccessfull'),4);
				}

				$datasource->commit();

				$this->Redirect->flashSuccess(__('edit_profile_successfull'));

			} catch(Exception $e){
				$datasource->rollback();
				if(in_array($e->getCode(),array(1,2,3,4,5,6,7,8,9,10))){
					$this->Session->setFlash($e->getMessage(),'error');
				}
				else

				$this->Redirect->flashWarning(__('edit_profile_notsuccessfull'));
			}
		}


		$options['fields'] = array(
			'User.id',
			'User.name',
			'User.sex',
			'User.age',
			'User.email',
			'User.image',
			'User.user_name',
			'User.mobile',
		);
		$options['conditions'] = array(
			'User.id '=> $User_Info['id']
		);
		$user = $this->User->find('first',$options);
		$this->request->data = $user;
		$this->set(compact('user'));

		$this->set('title_for_layout',__('edit_all_info'));
		$this->set('description_for_layout',__('edit_profile_description'));
		$this->set('keywords_for_layout',__('edit_all_info'));

	}

	function edit_password($id = null)
	{
		$this->User->recursive = - 1;
		$User_Info = $this->Session->read('User_Info');

		$this->User->id = $User_Info['id'];
		if(!$this->User->exists())
		{
			throw new NotFoundException(__('invalid_id_for_user'));
		}

		if($this->request->is('post') || $this->request->is('put'))
		{

			$this->request->data['User']['password'] = $this->request->data['User']['new_password'] ;
			$new_pass = $this->request->data['User']['password'];
			$result   = $this->User->find('count', array('conditions' => array('User.password'=>AuthComponent::password($this->request->data['User']['old_password']),'User.id'      =>$User_Info['id'])));

			if($result <= 0){
				$this->Redirect->flashWarning(__('not_valid_password'));
			}
			else
			{
				$this->request->data = Sanitize::clean($this->request->data);
				if($this->User->save($this->request->data))
				{
					$this->Redirect->flashSuccess(__('edit_password_successfull'),array('action'=>'logout','controller'=>'users'));
					/*$register_email = $User_Info['name'];
					if(!empty($register_email))
					{

						try
						{
							$Email = new CakeEmail();
							$Email->template('forgetpass_sendemail', 'sendemail_layout');
							$Email->subject(__('change_password'));
							$Email->emailFormat('html');
							$Email->to($register_email);
							$Email->from(array(__Email=> __Email_Name));
							$Email->viewVars(array('name'    =>$User_Info['name'],'password'=>$new_pass,'email'   =>$register_email));
							$Email->send();
							$this->Session->write('send_status',1);

						} catch(Exception $e){
							$this->Session->write('send_status',0);
						}

					}*/
				}
				else
				{
					$this->Redirect->flashWarning(__('edit_password_notsuccessfull'));
				}
			}
		}

		$this->set('title_for_layout',__('edit_password'));
		$this->set('description_for_layout',__('edit_password_description'));
		$this->set('keywords_for_layout',__('edit_password'));

	}

	public function edit_address(){

	}
	public
	function index()
	{
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

	/**
	* view method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public
	function view($id = null)
	{
		if(!$this->User->exists($id)){
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey=> $id));
		$this->set('user', $this->User->find('first', $options));
	}

	/**
	* add method
	*
	* @return void
	*/
	public
	function add()
	{
		if($this->request->is('post')){
			$this->User->create();
			if($this->User->save($this->request->data)){
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action'=> 'index'));
			}
			else
			{
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		$roles = $this->User->Role->find('list');
		$this->set(compact('roles'));
	}

	/**
	* edit method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public
	function edit($id = null)
	{
		if(!$this->User->exists($id)){
			throw new NotFoundException(__('Invalid user'));
		}
		if($this->request->is(array('post', 'put'))){
			if($this->User->save($this->request->data)){
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action'=> 'index'));
			}
			else
			{
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
		else
		{
			$options = array('conditions' => array('User.' . $this->User->primaryKey=> $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$roles = $this->User->Role->find('list');
		$this->set(compact('roles'));
	}

	/**
	* delete method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public
	function delete($id = null)
	{
		$this->User->id = $id;
		if(!$this->User->exists()){
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if($this->User->delete()){
			$this->Flash->success(__('The user has been deleted.'));
		}
		else
		{
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action'=> 'index'));
	}

	public
	function admin_dashboard()
	{
		$this->set('title_for_layout',__('panel_name'));

		$this->User->recursive = - 1;
		$options['conditions'] = array(
			'User.role_id' => 2,
			'User.status' => 1,
		);
		$user_count = $this->User->find('count',$options);
		$this->set('user_count',$user_count);

		$options = array();
		$options['fields'] = array(
			'date(User.created) as created',
			'count(*) as qty',
		);
		$options['conditions'] = array(
			'User.status' => 1,
			'User.role_id' => 2,
			'User.created BETWEEN ? AND ?' => array($this->CmsDate->subdayWithoutTime(date("Y-m-d"),30), $this->CmsDate->adddayWithoutTime(date("Y-m-d"),1))
		);
		$options['group'] = 'date(User.created)';
		$chart_users = $this->User->find('all',$options);
		$this->set('chart_users',$chart_users);


		$options = array();
		$this->User->Userloglogin->recursive = - 1;
		$options['fields'] = array(
			'date(Userloglogin.created) as created',
			'Userloglogin.count_login',
			'Userloglogin.user_id',
			'User.name',
		);
		$options['joins'] = array(
			array('table'     => 'users',
				'alias'     => 'User',
				'type'      => 'LEFT',
				'conditions' => array(
					'User.id = Userloglogin.user_id ',
				)
			)
		);
		$options['conditions'] = array(
			'Userloglogin.role_id' => 4,
			'Userloglogin.created BETWEEN ? AND ?' => array($this->CmsDate->subdayWithoutTime(date("Y-m-d"),7), $this->CmsDate->adddayWithoutTime(date("Y-m-d"),1))
		);
		$options['group'] = array('date(Userloglogin.created)','`Userloglogin`.`count_login`','`Userloglogin`.`user_id`','User.name');
		$chart_loginusers = $this->User->Userloglogin->find('all',$options);
		$this->set('chart_loginusers',$chart_loginusers);


		$options = array();
	    $this->loadModel('Siteinformation');
		$options = array();
		$this->Siteinformation->recursive = - 1;
		$options['fields'] = array(

			'Siteinformation.referer_host',
			'count(*) as qty',

		);
		$options['conditions'] = array(
			'Siteinformation.referer_host <>'=> null
		);
		$options['group'] = 'Siteinformation.referer_host';
		$siteinformations = $this->Siteinformation->find('all',$options);
		$this->set('siteinformations',$siteinformations);

	}


	function _get_login_log($id,$role_id)
	{
		$this->User->Userloglogin->recursive = - 1;
		$option['conditions'] = array(
			'Userloglogin.user_id'      => $id ,
			'date(Userloglogin.created)'=> date('Y-m-d')
		);

		$count = $this->User->Userloglogin->find('count',$option);

		if($count == 0){
			$this->request->data['Userloglogin']['user_id'] = $id;
			$this->request->data['Userloglogin']['role_id'] = $role_id;
			if(!$this->User->Userloglogin->save($this->request->data)){
				/* set log */
				Controller::loadModel('Errorlog');
				$this->Errorlog->get_log('UserlogloginsController','Can not insert in Userloglogin , user_id='.$id);
				/* set log */
			}
		}
		else
		{

			/*$ret= $this->User->Userloglogin->updateAll(
			array( 'Userloglogin.modified' =>'"'.date('Y-m-d H:i:s').'"' ,'Userloglogin.count_login' =>'Userloglogin.count_login + 1'),   //fields to update
			array( 'Userloglogin.user_id' => $id , 'date(Userloglogin.created)' => '"'.date('Y-m-d').'"')  //condition
			);*/


			$ret = $this->User->Userloglogin->query("
				UPDATE userloglogins as Userloglogin set
				Userloglogin.modified ='".date('Y-m-d H:i:s')."' ,
				Userloglogin.count_login = Userloglogin.count_login +1
				where  Userloglogin.user_id  = ".$id."
				and  date(Userloglogin.created) =  '".date('Y-m-d')."'
				");

			/*if(!$ret){

			Controller::loadModel('Errorlog');
			$this->Errorlog->get_log('UserlogloginsController','Can not update in Userloglogin , user_id='.$id);

			} */
		}
	}

	public
	function admin_login()
	{
		//pr($_SESSION['encoded_captcha']);
		//pr($this->Session->read('AdminUser_Info'));
		$this->set('title_for_layout',__('panel_name'));
		if($this->request->is('post'))
		{
			if($this->request->data['User']['login_email'] == '' || $this->request->data['User']['login_password'] == ''){
				$this->Redirect->flashWarning(__('insert_information'));
				return;
			}

			if(md5($this->request->data['User']['captcha'].'DYhG93b') != $this->Session->read('encoded_captcha'))
			{
				$this->Redirect->flashWarning(__('insert_captcha'));
				return;
			}

			//pr($this->request->data);return;

			$email      = $this->request->data['User']['login_email'];
			$conditions = array('User.email'=> $email);
			$ret = $this->User->find('first',array('fields'                        =>array('role_id'),'conditions'=> $conditions));

			if(empty($ret)){
				$this->Redirect->flashWarning(__('please_enter_valid_username_and_password'));
				return;
			}

			if($ret['User']['role_id'] == 2)
			{
				$this->Redirect->flashWarning(__('can_not_login_in_admin'));
				return;
			}
			$this->request->data['User']['email'] = $this->request->data['User']['login_email'];
			$this->request->data['User']['password'] = $this->request->data['User']['login_password'];
			$this->request->data = Sanitize::clean($this->request->data);

			if($this->Auth->login()){

				$user = $this->User->_getUser($this->request->data['User']['email']);

				$this->Session->write('AdminUser_Info',array(
						'id'     => $user['User']['id'] ,
						'name'   => $user['User']['name'] ,
						'email'  => $user['User']['email'],
						'role_id'=> $user['User']['role_id']
					));
				if($ret['User']['role_id'] == 4)
					$this->_get_login_log($user['User']['id'],4);
				// pr($this->Session->read('AdminUser_Info'));exit();
				$this->redirect($this->Auth->redirect());
				exit();
			}
			else
			{
				$this->Redirect->flashWarning(__('please_enter_valid_username_and_password'));
			}
		}
		//else $this->Redirect->flashWarning(__('please_login_with_your_email_and_password')); *
	}

	function admin_logout()
	{
		$this->Session->delete('AdminUser_Info');
		$this->redirect($this->Auth->logout());
	}
	/**
	* admin_index method
	*
	* @return void
	*/
	public
	function admin_index()
	{
		$this->set('title_for_layout',__('users'));
		$this->User->recursive = - 1;
		if(isset($_REQUEST['filter']))
		{
			$limit = $_REQUEST['filter'];
		}
		else $limit = 50;

		if(isset($this->request->data['User']['search']))
		{
			$this->request->data = Sanitize::clean($this->request->data);
			$this->paginate = array(
				'fields'                    =>array(
					'User.id',
					'User.name',
					'User.user_name',
					'User.email',
					'User.status',
					'User.created',
					'Role.name'
				),
				'joins'                    =>array(array('table'     => 'roles',
						'alias'     => 'Role',
						'type'      => 'LEFT',
						'conditions' => array(
							'Role.id = User.role_id ',
						)
					)),
				'conditions' => array('User.name LIKE' => ''.$this->request->data['User']['search'].'%' ,'User.role_id <>'=>1),
				'limit'     => $limit,
				'order'                          => array(
					'User.id'=> 'desc'
				)
			);
		}
		else
		{
			$this->paginate = array(
				'fields'                    =>array(
					'User.id',
					'User.name',
					'User.user_name',
					'User.email',
					'User.status',
					'User.created',
					'Role.name'
				),
				'joins'                         =>array(array('table'     => 'roles',
						'alias'     => 'Role',
						'type'      => 'LEFT',
						'conditions' => array(
							'Role.id = User.role_id ',
						)
					)),
				'conditions' => array('User.role_id <> 1 '),
				'limit'     => $limit,
				'order'                          => array(
					'User.id'=> 'desc'
				)
			);
		}
		$users = $this->paginate('User');
		$this->set(compact('users'));
	}

	/**
	* admin_view method
	*
	* @throws NotFoundException
	* @param string $id
	* @return void
	*/
	public
	function admin_view($id = null)
	{
		if(!$this->User->exists($id)){
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey=> $id));
		$this->set('user', $this->User->find('first', $options));
	}

	function _image_picture()
	{
		App::uses('Sanitize', 'Utility');

		$output = array();
		$data = Sanitize::clean($this->request->data);
		$file = $data['User']['image'];

		if($file['size'] > 0){
			$ext      = $this->Httpupload->get_extension($file['name']);
			$filename = md5(rand().$_SERVER['REMOTE_ADDR']);
			if(file_exists(__USER_IMAGE_PATH.$filename.'.'.$ext))				$filename = md5(rand().$_SERVER[REMOTE_ADDR]);

			$this->Httpupload->setmodel('User');
			$this->Httpupload->setuploaddir(__USER_IMAGE_PATH);
			$this->Httpupload->setuploadname('image');
			$this->Httpupload->settargetfile($filename.'.'.$ext);
			$this->Httpupload->setmaxsize(__UPLOAD_IMAGE_MAX_SIZE);
			$this->Httpupload->setimagemaxsize(__UPLOAD_IMAGE_MAX_WIDTH,__UPLOAD_IMAGE_MAX_HEIGHT);
			$this->Httpupload->allowExt = __UPLOAD_IMAGE_EXTENSION;
			$this->Httpupload->create_thumb = true;
			$this->Httpupload->thumb_folder = __UPLOAD_THUMB;
			$this->Httpupload->thumb_width = 120;
			$this->Httpupload->thumb_height = 120;
			if(!$this->Httpupload->upload()){
				return array('error'   =>true,'filename'=>'','message' =>$this->Httpupload->get_error());
			}
			$filename .= '.'.$ext;

		}
		return array('error'   =>false,'filename'=>$filename);
	}

	/**
	* admin_add method
	*
	* @return void
	*/
	public
	function admin_add()
	{
		$this->set('title_for_layout',__('add_user'));
		if($this->request->is('post')){
			$data = Sanitize::clean($this->request->data);
			$file = $data['User']['image'];
			if($file['size'] > 0)
			{
				$output   = $this->_image_picture();
				if(!$output['error']) $this->request->data['User']['image'] = $output['filename'];
				else $this->request->data['User']['image'] = '';
			}
			else $this->request->data['User']['image'] = '';
			$this->User->create();
			if($this->User->save($this->request->data)){
				$this->Redirect->flashSuccess(__('the_user_has_been_saved'));
			}
			else
			{
				if($file['size'] > 0)
				{
					@unlink(__USER_IMAGE_PATH.$output['filename']);
					@unlink(__USER_IMAGE_PATH.__UPLOAD_THUMB."/".$output['filename']);
				}
				$this->Redirect->flashWarning(__('the_user_could_not_be_saved_Please_try_again'));
			}
		}
		$roles = $this->User->Role->find('list',array('conditions'=>'Role.id <>1'));
		$this->set(compact('roles'));
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
		$this->set('title_for_layout',__('edit_user'));
		if(!$this->User->exists($id)){
			$this->Redirect->flashWarning(__('invalid_user'));
		}
		if($this->request->is(array('post', 'put'))){
			$data = Sanitize::clean($this->request->data);
			$file = $data['User']['image'];
			$result= $this->User->findById($id);
			if($file['size'] > 0){

				$filename = $result['User']['image'];
				@unlink(__USER_IMAGE_PATH.$filename);
				@unlink(__USER_IMAGE_PATH.__UPLOAD_THUMB."/".$filename);

				$output   = $this->_image_picture();
				if(!$output['error']) $this->request->data['User']['image'] = $output['filename'];
				else $this->request->data['User']['image'] = '';
			}
			else $this->request->data['User']['image'] = $this->request->data['User']['old_image'];

			if(trim($_POST['password']) != ''){
				$this->request->data['User']['password'] = $_POST['password'];
			}

			if($this->User->save($this->request->data)){
				$this->Redirect->flashSuccess(__('the_user_has_been_saved'));
				return $this->redirect(array('action'=> 'index'));
			}
			else
			{
				if($file['size'] > 0){
					@unlink(__USER_IMAGE_PATH."/".$output['filename']);
					@unlink(__USER_IMAGE_PATH."/".__UPLOAD_THUMB."/".$output['filename']);
				}
				$this->Redirect->flashWarning(__('the_user_could_not_be_saved_Please_try_again'));
			}
		}
		else
		{
			$options = array('conditions' => array('User.' . $this->User->primaryKey=> $id));
			$this->request->data = $this->User->find('first', $options);
		}
		$roles = $this->User->Role->find('list',array('conditions'=>'Role.id <>1'));
		$this->set(compact('roles'));
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
		$this->User->id = $id;
		if(!$this->User->exists()){
			$this->Redirect->flashWarning(__('invalid_user'));
		}
		$result= $this->User->findById($id);
		if($this->User->delete()){
			$filename=$result['User']['image'];
			@unlink(__USER_IMAGE_PATH.$filename);
			@unlink(__USER_IMAGE_PATH.__UPLOAD_THUMB."/".$filename);
			$this->Redirect->flashSuccess(__('the_user_has_been_deleted'));
		}
		else
		{
			$this->Redirect->flashWarning(__('the_user_could_not_be_deleted_please_try_again'));
		}
		return $this->redirect(array('action'=> 'index'));
	}

	public
	function captcha_image()
	{
		/*App::import('Vendor', 'captcha/captcha');
		$captcha = new captcha();
		$captcha->show_captcha();*/
		App::import('Vendor', 'jdf');
		$timezone = 0;//برای 3:30 عدد 12600 و برای 4:30 عدد 16200 را تنظیم کنید
		$now      = date("Y-m-d", $time + $timezone);
		$time     = date("H:i:s", $time + $timezone);
		list($year, $month, $day) = explode('-', $now);
		list($hour, $minute, $second) = explode(':', $time);
		$timestamp   = mktime($hour, $minute, $second, $month, $day, $year);
		$jalali_date = jdate("Y/m/d - H:i",$timestamp);
		pr($jalali_date);
		$this->autoRender = false;
	}
	public
	function recaptcha()
	{
		App::import('Vendor', 'recaptcha/captcha');
		$captcha_str=CAPTCHA::show(array(
				'font'=>
				array(
					0=>ROOT . DS . 'vendors' . DS.'recaptcha'.DS.'fonts/1.ttf',
					1=>ROOT . DS . 'vendors' . DS.'recaptcha'.DS.'fonts/2.ttf',
					2=>ROOT . DS . 'vendors' . DS.'recaptcha'.DS.'fonts/1.ttf',
					3=>ROOT . DS . 'vendors' . DS.'recaptcha'.DS.'fonts/2.ttf',
					4=>ROOT . DS . 'vendors' . DS.'recaptcha'.DS.'fonts/1.ttf',
				)
			)
		);
	}
}
?>
