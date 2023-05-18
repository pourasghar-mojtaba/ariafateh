<script
	type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type":"WebPage",
  "name": "<?php echo __('news_and_magazin'); ?>" ,
  "url":"<?php echo __SITE_URL; ?>blogs/last",
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
		"name": "<?php echo __('blogs'); ?>",
		"item": "<?php echo __SITE_URL . 'blogs/last'; ?>"
	  }
  ]
}



</script>
<?php echo $this->Html->css(__SITE_URL . __THEME_PATH . '/js/custom-scroll/jquery-scrollbar.css'); ?>
<main>
	<section>
		<div class="page-preview-box">
			<img src="<?php echo __SITE_URL . __THEME_PATH; ?>img/dominik-luckma.jpg" alt="">
			<h1 class="page-preview-title">
				<a href="<?php echo __SITE_URL; ?>"><?php echo __('home') ?></a>
				<i class="fal fa-angle-left"></i>
				<?php echo __d(__BLOG_LOCALE, 'weblog') ?>
				<i class="fal fa-angle-down"></i>
			</h1>

		</div>
		<div class="global-main-container introduct-holding-container container-fluid justify-content-center">
			<div class="side-bar col-lg-3 col-md-4">
				<div class="side-bar-panel">
					<div class="side-bar-search-box">
						<input type="text" class="form-control search-control" value="جستجو">
						<span class="search-icon">
						<i class="fal fa-search"></i>
					  </span>
					</div>
				</div>

				<div class="side-bar-panel">
					<div class="side-bar-panel-header">
						<h3 class="side-bar-title">
							<?php echo __d(__BLOG_LOCALE, 'the_most_viewed_blogs') ?>
						</h3>
					</div>
					<div class="post-option-box scrollbar-inner">
						<?php
							foreach ($bestviewedblogs as $blog) {
								?>
								<div class="item-option">
									<div class="thumbnail-post col-md-3 col-4">
										<img src="<?php echo __SITE_URL . __BLOG_IMAGE_URL .__UPLOAD_BLOG_THUMB. '/' . $blog['Blog']['image']; ?>" alt="">
									</div>
									<div class="content-post col-md-9 col-8">
										<div class="post-date-box col-12">
											<span class="post-date-title"><?php echo __d(__BLOG_LOCALE, 'date') ?>:</span>
											<span class="post-date">
												<?php echo $this->Cms->show_persian_date("j", strtotime($blog['Blog']['created'])); ?>
												<?php echo $this->Cms->show_persian_date("F", strtotime($blog['Blog']['created'])); ?>
											</span>
										</div>
										<p>
											<a href="<?php echo __SITE_URL . "blog/" . $blog['Blog']['slug']; ?>">
												<?php echo $blog['Blogtranslation']['title']; ?>
											</a>
										</p>
									</div>

								</div>
								<?php
							}
						?>
					</div>
				</div>
				<div class="side-bar-panel">
					<div class="side-bar-panel-header">
						<h3 class="side-bar-title">
							<?php echo __d(__BLOG_LOCALE, 'tags') ?>
						</h3>
					</div>
					<div class="item-option-box item-hashtag-box">
						<?php
							foreach ($besttags as $tag) {
								?>
								<div class="hashtag-box col-lg-4 col-sm-6">
									<a href="#" class="hashtag-link"><?php echo $tag['BlogTag']['title'] ?>#</a>
								</div>
								<?php
							}
						?>
					</div>
				</div>
			</div>
			<div class="post-main-box col-lg-9 col-md-8">
				<!-- post main -->
				<?php
				foreach ($blogs as $blog) {
					?>


					<div class="post-panel-box justify-content-md-start justify-content-center">
						<div class="post-image-col col-md-3 col-8">
							<img src="<?php echo __SITE_URL . __BLOG_IMAGE_URL . '/' . $blog['Blog']['image']; ?>"
								 alt="<?php echo $blog['Blogtranslation']['title']; ?>">
						</div>
						<div class="post-content-box col-md-9 col-12">
							<div class="post-header-box">
								<h2 class="post-header">
									<a href="<?php echo __SITE_URL . "blog/" . $blog['Blog']['slug']; ?>">
										<?php echo $blog['Blogtranslation']['title']; ?>
									</a>
								</h2>
							</div>
							<div class="post-content">

								<p>
									<?php echo $blog['Blogtranslation']['little_detail']; ?>
								</p>

							</div>
						</div>
						<div class="separator-post">
							<div class="separator"></div>
						</div>
						<div class="post-detail-row">
							<div class="post-date-box">
								<span class="post-date-title"><?php echo __d(__BLOG_LOCALE, 'date') ?>:</span>
								<span class="post-date">
										<?php echo $this->Cms->show_persian_date("j", strtotime($blog['Blog']['created'])); ?>
										<?php echo $this->Cms->show_persian_date("F", strtotime($blog['Blog']['created'])); ?>
									</span>

							</div>
							<div class="post-view-box">
								<span class="post-view-title"><?php echo __d(__BLOG_LOCALE, 'num_viewed') ?>: </span>
								<span class="post-view"><?php echo $blog['Blog']['num_viewed']; ?></span>
							</div>
						</div>
						<a href="<?php echo __SITE_URL . "blog/" . $blog['Blog']['slug']; ?>" class="more-view-link">
								<span class="more-view-icon">
								  <i class="fas fa-plus"></i>
								</span>
							<?php echo __d(__BLOG_LOCALE, 'more') ?>
						</a>
					</div>



					<?php
				}
				?>
			</div>
			<nav aria-label="Page navigation" class="pagination-main">

				<?php
				if (!empty($blogs)) {
					if (!empty($_REQUEST['page'])) {
						$page = $_REQUEST['page'];
					} else $page = 1;

					$url_str = __SITE_URL . __BLOG . '/blogs/last?';
					$this->Paginate->with_hide($total_count, $page, $limit, $url_str);
				}
				?>

			</nav>
			<!-- end post main -->
		</div>


	</section>
</main>
<?php
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/custom-scroll/jquery-scrollbar.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/pagination.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/sidebar.js');
?>







