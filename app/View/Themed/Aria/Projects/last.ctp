

<script
	type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type":"WebPage",
  "name": "<?php echo __d(__PROJECT, 'projects') . ' ' . $category['Projectcategory']['title'].__('default_title'); ?>" ,
  "url":"<?php echo __SITE_URL.'project/projects/index/'.$category['Projectcategory']['slug']; ?>",
  "description": "<?php echo $description_for_layout; ?>"
}

</script>

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
		"name": "<?php echo __('projects'); ?>",
		"item": "<?php echo __SITE_URL.'project/projects/index/'.$category['Projectcategory']['slug']; ?>"
	  }
  ]
}

</script>
<main>
	<section>
		<div class="page-preview-box">
			<img src="<?php echo __SITE_URL.__THEME_PATH;?>img/dominik-luckma.jpg" alt="">
			<h1 class="page-preview-title">
				<a href="<?php echo __SITE_URL; ?>"><?php echo __('home') ?></a>
				<i class="fal fa-angle-left"></i>
				<?php echo __d(__PROJECT_LOCALE,'projects'); ?>
				<i class="fal fa-angle-down"></i>
			</h1>

		</div>
		<div class="global-main-container container-fluid">
			<div class="project-heading">
				<div class="project-column-box col-md-6 col-sm-8 col-12 justify-content-md-start justify-content-center">
					<h1 class="project-header-title justify-content-md-start justify-content-center"><a href="#">
							پروژه ها
						</a></h1>
					<div class="project-content-box justify-content-md-start justify-content-center">
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
					</div>
				</div>
				<div class="project-column-box col-md-6 col-sm-8 col-12 justify-content-md-start justify-content-center">
					<div class="project-image-box justify-content-md-start justify-content-center">
						<img src="<?php echo __SITE_URL.__THEME_PATH;?>img/project-header.png" alt="">
					</div>
				</div>


			</div>

		</div>
		<div class="global-main-container container-fluid justify-content-center" id="project-main">
			<?php
			foreach ($projects as $project) {
				?>
				<div class="global-column col-lg-3 col-md-4 col-sm-6 col-12">
					<div class="column-frame-box">
						<div class="column-gray-box"></div>
						<div class="column-image-box">
							<img src="<?php echo __SITE_URL . __PROJECT_IMAGE_URL . '/' . $project['0']['image']; ?>" alt="<?php echo $project['Projecttranslation']['title']; ?>">
						</div>
						<div class="column-date-box">
							<a href="<?php echo __SITE_URL.__PROJECT.'/'.$project['Project']['slug']; ?>">
							<span class="date-title-box"> <?php echo $project['Projecttranslation']['title']; ?> | &nbsp;</span>
							<span class="date-box"><?php echo $project['Companytranslation']['title']; ?></span>
							</a>
						</div>
						<div class="column-content-box">
							<div class="column-content">
								<?php echo $project['Projecttranslation']['mini_detail']; ?>
							</div>
						</div>

					</div>
				</div>
				<?php
			}
			?>
			<nav aria-label="Page navigation" class="pagination-main">
				<?php
				if (!empty($projects)) {
					if (!empty($_REQUEST['page'])) {
						$page = $_REQUEST['page'];
					} else $page = 1;

					$url_str = __SITE_URL . __PROJECT. '/projects/last?';
					$this->Paginate->with_hide($total_count, $page, $limit, $url_str);
				}
				?>
			</nav>
		</div>


	</section>
</main>
<?php
echo $this->Html->script(__SITE_URL.__THEME_PATH.'js/project.js');
?>
