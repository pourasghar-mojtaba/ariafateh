<?php
App::uses('AppModel', 'Model');
/**
 * Setting Model
 *
 */
class Setting extends AppModel {

 function _getSetting(){
 	return $this->find('first');
 }
	

}
?>