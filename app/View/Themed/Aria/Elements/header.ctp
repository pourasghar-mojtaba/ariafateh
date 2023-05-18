<?php


echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/icomoon.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/fontawesome.min.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/solid.min.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/brands.min.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/light.min.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/animate.min.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/lightSweep.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . '/js/jquery-ui/jquery-ui.min.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/bootstrap.min.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . '/js/owlcarousel/owl.carousel.min.css');
echo $this->Html->css(__SITE_URL . __THEME_PATH . '/js/owlcarousel/owl.theme.default.min.css');

if ($locale == 'fas')
	echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/style.css');
else echo $this->Html->css(__SITE_URL . __THEME_PATH . 'css/style-en.css');

echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/jquery.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/jquery-ui/jquery-ui.min.js');


echo $this->html->script('component');
echo $this->html->script('global');

$this->Plugin->run_hook('header_library');
$User_Info = $this->Session->read('User_Info');

?>
<header>
	<?php
	//echo $this->Html->link('English', array('language' => 'eng'));
	//echo $this->Html->link('فارسی', array('language' => 'fas'));
	?>
	<div class="header-section">

		<nav class="main-nav navbar navbar-light navbar-expand-lg">

			<!-- logo start -->
			<div class="main-logo col-lg-2 col-md-3 justify-content-md-start justify-content-center">
				<a href="#" class="logo-link">
					<img src="<?php echo __SITE_URL . __THEME_PATH; ?>img/logo-ariafateh-h.png" alt="logo-ariafateh">
				</a>
			</div>
			<!-- end logo -->


			<div class="collapse navbar-collapse" id="mainNavbar">
				<ul class="navbar-nav">

					<li class="nav-item active">
						<a class="nav-link" href="<?php echo __SITE_URL; ?>"><?php echo __('home') ?> </a>
					</li>
					<?php $this->Plugin->run_hook('user_menu', array("lang" => $this->Session->read('Config.language'))); ?>
					<li class="nav-item">
						<?php echo $this->Html->link(__d('user', 'about_us'), __SITE_URL . 'pages/about/', array('class' => 'nav-link')) ?>
					</li>
					<li class="nav-item">
						<?php echo $this->Html->link(__d('user', 'contact_us'), __SITE_URL . 'pages/contact_us/', array('class' => 'nav-link')) ?>
					</li>

				</ul>
			</div>
			<div class="header-option-box col-lg-3 col-md-8 justify-content-md-end justify-content-center">
				<div class="option-top-row justify-content-md-end justify-content-center">

					<div class="search-header-box">
						<input type="text" class="form-control search-control" value=""
							   placeholder="<?php echo __('search'); ?>">
						<span class="search-icon">
				    <i class="fal fa-search"></i>
				  </span>
					</div>

				</div>
				<div class="option-bottom-row">
					<a href="<?php echo __SITE_URL . 'uploads/catalogue-ariafateh-fa.pdf' ?>"
					   class="option-catalog-link"><?php echo __('catalog'); ?></a>
					<div class="language-box">
						<?php
						echo $this->Html->image("England-Flag.png", array(
							"alt" => "English",
							'url' => array('language' => 'eng')
						));
						?>
						<?php
						echo $this->Html->image("Iran-Flag.png", array(
							"alt" => "فارسی",
							'url' => array('language' => 'fas')
						));
						?>
					</div>
				</div>
			</div>
			<div class="mobile-menu-bar">
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNavbar"
						aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
			</div>


		</nav>

	</div>
</header>





