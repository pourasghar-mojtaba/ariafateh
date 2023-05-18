<?php

$info_array = array(
	"description"=>  __d(__HONOR_LOCALE,'honor_plugin_detail') ,
	"website"    => "atrassystem.com",
	"author"     => __d(__HONOR_LOCALE,'plugin_creator'),
	"email"      => "info@atrassystem.com",
	"version"    => "1.0",
);
$install_query_array[]="
CREATE TABLE `honors` (
  `id` bigint(20) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `honors`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `honors`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1; 
  
";

$install_query_array[] ="
	
CREATE TABLE `honortranslations` (
  `honor_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `detail` varchar(3000) COLLATE utf8_persian_ci  NULL,
  `created` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;


ALTER TABLE `honortranslations`
  ADD PRIMARY KEY (`honor_id`,`language_id`);
";


$install_query_array[] = "

CREATE TABLE `honorimages` (
  `id` bigint(20) NOT NULL,
  `honor_id` bigint(20) NOT NULL,
  `image` varchar(200) COLLATE utf8_persian_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;

ALTER TABLE `honorimages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `honor_id` (`honor_id`);

ALTER TABLE `honorimages`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
  
";
$install_query_array[] ="
	
CREATE TABLE `honorimagetranslations` (
  `honorimage_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `title` varchar(300) COLLATE utf8_persian_ci NOT NULL,
  `created` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_persian_ci;


ALTER TABLE `honorimagetranslations`
  ADD PRIMARY KEY (`honorimage_id`,`language_id`);

";

$remove_query_array[]="DROP TABLE `honors` ";
$remove_query_array[]="DROP TABLE `honortranslations` ";
$remove_query_array[]="DROP TABLE `honorimages` ";
$remove_query_array[]="DROP TABLE `honorimagetranslations` ";

/**
*
 DELIMITER $$
CREATE TRIGGER `delete_honor_relate_table`
AFTER DELETE ON `honors`
FOR EACH ROW
begin
delete from honortranslations where honor_id = old.id;
end
$$
DELIMITER ;

 DELIMITER $$
CREATE TRIGGER `delete_honorimage_relate_tables`
AFTER DELETE ON `honorimages` FOR EACH ROW begin
delete from honorimagetranslations where honorimage_id = old.id;
end;$$
DELIMITER ;

*/
$install_menu_query[] = array("name"=>__d(__HONOR_LOCALE,'honor_managment'),"controller"=>'honors',"action"=>"admin_index","action_name"=>__d(__HONOR_LOCALE,'honor_list'));
$install_menu_query[] = array("name"=>__d(__HONOR_LOCALE,'honor_managment'),"controller"=>'honors',"action"=>"admin_add","action_name"=>__d(__HONOR_LOCALE,'add_honor'));
$install_menu_query[] = array("name"=>__d(__HONOR_LOCALE,'honor_managment'),"controller"=>'honors',"action"=>"admin_edit","action_name"=>__d(__HONOR_LOCALE,'edit_honor'));
$install_menu_query[] = array("name"=>__d(__HONOR_LOCALE,'honor_managment'),"controller"=>'honors',"action"=>"admin_delete","action_name"=>__d(__HONOR_LOCALE,'delete_honor'));
$remove_menu_query[] = array("controller"=>'honors');



?>
