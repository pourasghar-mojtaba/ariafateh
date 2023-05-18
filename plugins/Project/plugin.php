<?php

$info_array = array(
	"description"=>  __d(__PROJECT_LOCALE,'project_plugin_detail') ,
	"website"    => "atrassystem.com",
	"author"     => __d(__PROJECT_LOCALE,'plugin_creator'),
	"email"      => "info@atrassystem.com",
	"version"    => "1.0",
);
$install_query_array[]="
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `company_id` int(11) NOT NULL,
  `project_category_id` int(11) NOT NULL,
  `slug` varchar(300) COLLATE utf8_persian_ci  NULL,
  `video` VARCHAR(300) NULL DEFAULT NULL ,
  `video_image` VARCHAR(300) NULL DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_category_id` (`project_category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;
";

$install_query_array[] = "
	CREATE TABLE `projecttranslations` (
  `project_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `mini_detail` varchar(500) COLLATE utf8_persian_ci NOT NULL,
  `detail` text COLLATE utf8_persian_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `projecttranslations`
  ADD PRIMARY KEY (`project_id`,`language_id`);
";

$install_query_array[] = "
CREATE TABLE IF NOT EXISTS `projectimages` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `project_id` bigint(20) NOT NULL,
  `image` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`project_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;
";


$install_query_array[] = "
	CREATE TABLE `projectimagetranslations` (
  `project_image_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `projectimagetranslations`
  ADD PRIMARY KEY (`project_image_id`,`language_id`);
";

$install_query_array[] = "
CREATE TABLE IF NOT EXISTS `projectcategories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `slug` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `image` VARCHAR(200) NULL DEFAULT NULL,
  `arrangment` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;
";

$install_query_array[] = "
	CREATE TABLE `projectcategorytranslations` (
  `project_category_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `projectcategorytranslations`
  ADD PRIMARY KEY (`project_category_id`,`language_id`);
";


$remove_query_array[]="DROP TABLE `projects` ";
$remove_query_array[]="DROP TABLE `projecttranslations` ";
$remove_query_array[]="DROP TABLE `projectimages` ";
$remove_query_array[]="DROP TABLE `projectimagetranslations` ";
$remove_query_array[]="DROP TABLE `projectcategories` ";
$remove_query_array[]="DROP TABLE `projectcategorytranslations` ";

$install_menu_query[] = array("name"=>__d(__PROJECT_LOCALE,'project_managment'),"controller"=>'projects',"action"=>"admin_index","action_name"=>__d(__PROJECT_LOCALE,'project_list'));
$install_menu_query[] = array("name"=>__d(__PROJECT_LOCALE,'project_managment'),"controller"=>'projects',"action"=>"admin_add","action_name"=>__d(__PROJECT_LOCALE,'add_project'));
$install_menu_query[] = array("name"=>__d(__PROJECT_LOCALE,'project_managment'),"controller"=>'projects',"action"=>"admin_edit","action_name"=>__d(__PROJECT_LOCALE,'edit_project'));
$install_menu_query[] = array("name"=>__d(__PROJECT_LOCALE,'project_managment'),"controller"=>'projects',"action"=>"admin_delete","action_name"=>__d(__PROJECT_LOCALE,'delete_project'));
$install_menu_query[] = array("name"=>__d(__PROJECT_LOCALE,'project_managment'),"controller"=>'projects',"action"=>"admin_deletevideo","action_name"=>__d(__PROJECT_LOCALE,'delete_video'));
$remove_menu_query[] = array("controller"=>'projects');


$install_menu_query[] = array("name"=>__d(__PROJECT_LOCALE,'category_managment'),"controller"=>'projectcategories',"action"=>"admin_index","action_name"=>__d(__PROJECT_LOCALE,'category_list'));
$install_menu_query[] = array("name"=>__d(__PROJECT_LOCALE,'category_managment'),"controller"=>'projectcategories',"action"=>"admin_add","action_name"=>__d(__PROJECT_LOCALE,'add_category'));
$install_menu_query[] = array("name"=>__d(__PROJECT_LOCALE,'category_managment'),"controller"=>'projectcategories',"action"=>"admin_edit","action_name"=>__d(__PROJECT_LOCALE,'edit_category'));
$install_menu_query[] = array("name"=>__d(__PROJECT_LOCALE,'category_managment'),"controller"=>'projectcategories',"action"=>"admin_delete","action_name"=>__d(__PROJECT_LOCALE,'delete_category'));
$remove_menu_query[] = array("controller"=>'projectcategories');

?>
