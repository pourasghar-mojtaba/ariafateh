<?php

$info_array = array(
	"description"=>  __d(__EMPLOYMENT_LOCALE,'employment_plugin_detail') ,
	"website"    => "picosite.ir",
	"author"     => __d(__EMPLOYMENT_LOCALE,'plugin_creator'),
	"email"      => "info@picosite.ir",
	"version"    => "1.0",
);

$install_query_array[] = "
CREATE TABLE IF NOT EXISTS `employments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` VARCHAR(200) NULL DEFAULT NULL,
  `mobile` VARCHAR(200) NULL DEFAULT NULL,
  `phone` VARCHAR(200) NULL DEFAULT NULL,
  `email` VARCHAR(300) NULL DEFAULT NULL,
  `arrangment` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;
";

$install_query_array[] = "
	
CREATE TABLE `employmenttranslations` (
  `employment_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `job` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `message` varchar(5000) COLLATE utf8_persian_ci  NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `employmenttranslations`
  ADD PRIMARY KEY (`employment_id`,`language_id`);
";

$remove_query_array[]="DROP TABLE `employments` ";
$remove_query_array[]="DROP TABLE `employmenttranslations` ";

$install_menu_query[] = array("name"=>__d(__EMPLOYMENT_LOCALE,'employment_managment'),"controller"=>'employments',"action"=>"admin_index","action_name"=>__d(__EMPLOYMENT_LOCALE,'employment_list'));
$install_menu_query[] = array("name"=>__d(__EMPLOYMENT_LOCALE,'employment_managment'),"controller"=>'employments',"action"=>"admin_add","action_name"=>__d(__EMPLOYMENT_LOCALE,'add_employment'));
$install_menu_query[] = array("name"=>__d(__EMPLOYMENT_LOCALE,'employment_managment'),"controller"=>'employments',"action"=>"admin_edit","action_name"=>__d(__EMPLOYMENT_LOCALE,'edit_employment'));
$install_menu_query[] = array("name"=>__d(__EMPLOYMENT_LOCALE,'employment_managment'),"controller"=>'employments',"action"=>"admin_delete","action_name"=>__d(__EMPLOYMENT_LOCALE,'delete_employment'));
$remove_menu_query[] = array("controller"=>'employments');

?>
