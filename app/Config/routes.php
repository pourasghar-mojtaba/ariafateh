<?php

Router::connect('/', array(
	'controller' => 'pages',
	'action' => 'display',
	'home'));

//Router::connect(' / pages/*', array('controller' => 'pages', 'action' => 'display'));
Router::connect('/admin', array(
	'controller' => 'users',
	'action' => 'dashboard',
	'admin' => true));
Router::connect('/:language/:controller/:action/*', array(), array('language' =>
	'[a-z]{3}'));


Router::connect('/blog/:slug',
	array(
		'plugin' => 'blog',
		'controller' => 'blogs',
		'action' => 'view'
	),
	array(
		'pass' => array('slug')
	));

Router::connect('/company/:slug',
	array(
		'plugin' => 'company',
		'controller' => 'companies',
		'action' => 'view'
	),
	array(
		'pass' => array('slug')
	));

Router::connect('/project/:slug',
	array(
		'plugin' => 'project',
		'controller' => 'projects',
		'action' => 'view'
	),
	array(
		'pass' => array('slug')
	));
Router::connect('/honor/:slug',
	array(
		'plugin' => 'honor',
		'controller' => 'honors',
		'action' => 'view'
	),
	array(
		'pass' => array('slug')
	));

Router::connect('/employment',
	array(
		'plugin' => 'employment',
		'controller' => 'employments',
		'action' => 'index'
	),
	array(
		//'pass' => array('slug')
	));

Router::connect('/investment',
	array(
		'plugin' => 'investment',
		'controller' => 'investments',
		'action' => 'index'
	),
	array(
		//'pass' => array('slug')
	));

Router::connect('/sitemap.xml', array('controller' => 'sitemaps', 'action' => 'index', 'ext' => 'xml'));
Router::connect('/rss.xml', array('controller' => 'feeds', 'action' => 'index', 'ext' => 'xml'));
Router::parseExtensions('rss');
CakePlugin::routes();

require CAKE . 'Config' . DS . 'routes.php';
