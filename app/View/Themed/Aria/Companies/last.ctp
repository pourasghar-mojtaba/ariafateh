

<script
	type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type":"WebPage",
  "name": "<?php echo __d(__PROJECT, 'projects') . ' ' . $category['Projectcategory']['title'].__('default_title'); ?>" ,
  "url":"<?php echo __SITE_URL.'project/projects/index/'.$category['Projectcategory']['title']; ?>",
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
		"item": "<?php echo __SITE_URL.'project/projects/index/'.$category['Projectcategory']['title']; ?>"
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
		<div class="global-main-container container-fluid justify-content-center" id="holding">
			<?php
				foreach ($companies as $company) {
					?>
					<div class="global-column col-lg-3 col-md-4 col-sm-10 col-12">
						<div class="column-frame-box">
							<div class="column-image-box">
								<img src="<?php echo __SITE_URL . __COMPANY_IMAGE_URL . '/' . $company['Company']['image']; ?>" alt="<?php echo $company['Companytranslation']['title']; ?>">
							</div>
							<div class="column-title-box">
								<h3 class="column-title">
									<a href="<?php echo __SITE_URL . "company/" . str_replace(' ','-',$company['Companytranslation']['title']); ?>">
										<?php echo $company['Companytranslation']['title']; ?>
									</a>
								</h3>
							</div>
							<div class="column-content-box">
								<p class="column-content">

								</p>
							</div>
							<div class="column-more-box">
								<a href="<?php echo __SITE_URL . "company/" . str_replace(' ','-',$company['Companytranslation']['title']); ?>"><?php echo __('more'); ?></a>
							</div>
						</div>
					</div>
					<?php
				}
			?>
			<nav aria-label="Page navigation" class="pagination-main">

				<?php
				if (!empty($companies)) {
					if (!empty($_REQUEST['page'])) {
						$page = $_REQUEST['page'];
					} else $page = 1;

					$url_str = __SITE_URL . __COMPANY . '/companies/last?';
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
