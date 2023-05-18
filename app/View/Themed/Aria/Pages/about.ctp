
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
	  {
		"@type": "ListItem",
		"position": 1,
		"name": "<?php echo __('picosite'); ?>",
		"item": "<?php echo __SITE_URL; ?>"
	  },
	  {
		"@type": "ListItem",
		"position": 2,
		"name": "<?php echo $page['Page']['title']; ?>",
		"item": "<?php echo "https://www." . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>"
	  }
  ]
}
</script>

<main>
	<section>
		<div class="page-preview-box">
			<img src="<?php echo __SITE_URL.__THEME_PATH;?>img/dominik-luckma.jpg" alt="awards">
			<h1 class="page-preview-title">
				<a href="<?php echo __SITE_URL; ?>"><?php echo __('home') ?></a>
				<i class="fal fa-angle-left"></i>
				<?php echo __d('user', 'about_us'); ?>
				<i class="fal fa-angle-down"></i>
			</h1>

		</div>
		<div class="global-main-container container-fluid">
			<div class="about-heading">
				<h1 class="about-header-title justify-content-md-start justify-content-center"><a href="#">
						درباره ما
					</a></h1>
				<div class="about-column-box col-lg-6 col-md-7 col-sm-8 col-12 justify-content-md-start justify-content-center">

					<div class="about-tab-main">
						<ul class="about-tab-menu" id="about-tab">
							<li><a id="tab1">معرفی هلدینگ</a></li>
							<li><a id="tab2">افتخارات </a></li>
							<li><a id="tab3">کاتالوگ </a></li>
						</ul>
						<div class="about-tab-container justify-content-md-start justify-content-center" id="tab1C">
							<p>
								<?php
									echo $this->Cms->convert_character_editor($page['Page']['body']);
								?>
							</p>
							<a class="about-tab-link" href="#">هلدینگ</a>
						</div>
						<div class="about-tab-container justify-content-md-start justify-content-center" id="tab2C">
							<p>

								لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم
								از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
								و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
								از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
								و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
								و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
								از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
								و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
							</p>
							<a class="about-tab-link" href="#">افتخارات</a>
						</div>
						<div class="about-tab-container justify-content-md-start justify-content-center" id="tab3C">
							<p>

								لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم
								از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
								و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
								از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
								و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
								و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
								از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها
								و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است
							</p>
							<a class="about-tab-link" href="#">کاتالوگ</a>
						</div>
					</div>

				</div>
				<div class="about-column-box col-lg-6 col-md-5 col-sm-8 col-12 justify-content-md-start justify-content-center">
					<div class="about-image-box justify-content-md-start justify-content-center">
						<img src="<?php echo __SITE_URL.__THEME_PATH;?>img/about.png" alt="">
					</div>
				</div>



			</div>

		</div>


	</section>
</main>
<?php
echo $this->Html->script(__SITE_URL.__THEME_PATH.'js/about-tab.js');
?>
