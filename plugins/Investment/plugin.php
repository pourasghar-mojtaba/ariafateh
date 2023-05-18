<?php

$info_array = array(
	"description"=>  __d(__INVESTMENT_LOCALE,'investment_plugin_detail') ,
	"website"    => "picosite.ir",
	"author"     => __d(__INVESTMENT_LOCALE,'plugin_creator'),
	"email"      => "info@picosite.ir",
	"version"    => "1.0",
);

$install_query_array[] = "
CREATE TABLE IF NOT EXISTS `investments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` VARCHAR(200) NULL DEFAULT NULL,
  `mobile` VARCHAR(200) NULL DEFAULT NULL,
  `arrangment` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci AUTO_INCREMENT=1 ;
";

$install_query_array[] = "
	
CREATE TABLE `investmenttranslations` (
  `investment_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `investmenttranslations`
  ADD PRIMARY KEY (`investment_id`,`language_id`);
";

$remove_query_array[]="DROP TABLE `investments` ";
$remove_query_array[]="DROP TABLE `investmenttranslations` ";

$install_menu_query[] = array("name"=>__d(__INVESTMENT_LOCALE,'investment_managment'),"controller"=>'investments',"action"=>"admin_index","action_name"=>__d(__INVESTMENT_LOCALE,'investment_list'));
//$install_menu_query[] = array("name"=>__d(__INVESTMENT_LOCALE,'investment_managment'),"controller"=>'investments',"action"=>"admin_add","action_name"=>__d(__INVESTMENT_LOCALE,'add_investment'));
$install_menu_query[] = array("name"=>__d(__INVESTMENT_LOCALE,'investment_managment'),"controller"=>'investments',"action"=>"admin_edit","action_name"=>__d(__INVESTMENT_LOCALE,'edit_investment'));
$install_menu_query[] = array("name"=>__d(__INVESTMENT_LOCALE,'investment_managment'),"controller"=>'investments',"action"=>"admin_delete","action_name"=>__d(__INVESTMENT_LOCALE,'delete_investment'));
$remove_menu_query[] = array("controller"=>'investments');

?>
