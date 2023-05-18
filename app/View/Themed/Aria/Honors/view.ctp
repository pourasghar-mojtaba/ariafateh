<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "WebPage",
  "name": "<?php echo $honor['Honortranslation']['title']; ?>",
  "publisher": "<?php echo __('picosite'); ?>",
  "url": "<?php echo __SITE_URL . '/honor/honors/view'; ?>"
}

</script>

<?php echo $this->Html->css(__SITE_URL . __THEME_PATH . 'js/custom-scroll/jquery-scrollbar.css'); ?>
<?php echo $this->Html->css(__SITE_URL . __THEME_PATH . 'js/lightbox/lightbox.min.css'); ?>

<main>
	<section>
		<div class="page-preview-box">
			<img src="<?php echo __SITE_URL . __THEME_PATH; ?>img/awards-heading.jpg" alt="awards">
			<h1 class="page-preview-title">
				<a href="<?php echo __SITE_URL; ?>"><?php echo __('home') ?></a>
				<i class="fal fa-angle-left"></i>
				<?php echo $honor['Honortranslation']['title']; ?>
				<i class="fal fa-angle-down"></i>
			</h1>

		</div>
		<div class="global-main-container container-fluid">
			<div class="project-heading">

				<div
					class="project-column-box col-lg-3 col-md-4 col-sm-8 col-12 justify-content-md-start justify-content-center">
					<div class="project-image-box justify-content-md-start justify-content-center">
						<img src="<?php echo __SITE_URL . __THEME_PATH; ?>img/awarde-06.jpg" alt="">
					</div>
				</div>
				<div
					class="project-column-box col-md-8 col-sm-8 col-12 justify-content-md-start justify-content-center">
					<h1 class="project-header-title justify-content-md-start justify-content-center"><a href="#">
							<?php echo $honor['Honortranslation']['title']; ?>
						</a></h1>
					<div class="winner-separate"></div>
					<div class="project-content-box justify-content-md-start justify-content-center">
						<p>
							<?php echo $this->Cms->convert_character_editor($honor['Honortranslation']['detail']); ?>
						</p>
					</div>
				</div>


			</div>

		</div>
		<!-- start new project carousel -->
		<div class="content-container container-fluid">
			<div class="content-title-row">
				<h3 class="content-title"><?php echo __d(__HONOR_LOCALE, 'honors_gallery') ?></h3>
			</div>
			<div class="content-main-box">

				<div class="main-carousel-box owl-carousel" id="awards-carousel">
					<?php
					foreach ($honorimages as $honorimage) {
						?>
						<div class="carousel-col-box">
							<div class="col-item-box">
								<div class="carousel-img-box">
									<a class="link-photo" data-lightbox="img" href="<?php echo __SITE_URL . __HONOR_IMAGE_URL . $honorimage['Honorimage']['image']; ?>" title="">
										<img
											src="<?php echo __SITE_URL . __HONOR_IMAGE_URL . $honorimage['Honorimage']['image']; ?>"
											alt="<?php echo $honorimage['Honorimagetranslation']['title']; ?>">
									</a>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
		<!-- end new project carousel -->

	</section>
</main>
<?php
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/owlcarousel/owl.carousel.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/lightbox/lightbox.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/awards-carousel.js');
?>
