
<script type = "application/ld+json">
  {
    "@context":"https://schema.org",
    "@type":"NewsArticle",
    "inLanguage":"fa-IR",
    "mainEntityOfPage":{
       "@type": "WebPage",
       "name":"<?php echo $company['Companytranslation']['title']; ?>",
       "url":"<?php echo __SITE_URL.'company/'.$company['Company']['slug']; ?>"
     },
    "headline":"<?php echo $company['Companytranslation']['title']; ?>",
    "name":"<?php echo $company['Companytranslation']['title']; ?>",
    "author":{
  		"@type":"Person",
  		"name":"<?php echo __('picosite'); ?>"
        },
    "creator":{
  		"@type":"Person",
  		"url":"<?php echo __SITE_URL; ?>",
  		"name":"<?php echo __('picosite'); ?>"},
    "image":{
  		"@type":"ImageObject",
  		"url":"<?php echo __SITE_URL.__COMPANY_IMAGE_URL.'/'.$company['Company']['image']; ?>",
  		"width":500,
  		"height":500
        },
    "datePublished":"<?php echo $company['Company']['created']; ?>",
    "dateModified":"<?php echo $company['Company']['created']; ?>",
    "keywords":"<?php echo $keywords_for_layout; ?>",
    "publisher":{
  		"@type":"Organization",
  		"url":"<?php echo __SITE_URL; ?>",
  		"name":"<?php echo __('picosite'); ?>",
  		"logo":{
  			"@type":"ImageObject",
  			"url":"<?php echo __SITE_URL; ?>img/logo.png",
  			"width":500,
  			"height":500
            }
     },
    "articleSection":"<?php echo __('news_and_magazin'); ?>",
    "description":"<?php echo $company['Company']['little_detail']; ?>"
  }
  </script>

<script type="application/ld+json">{
    "@context": "http://schema.org",
    "@type": "Article",
    "headline": "<?php echo $company['Companytranslation']['title']; ?>",
    "articlebody":"<?php echo $company['Company']['detail']; ?>",
    "name": "<?php echo $company['Companytranslation']['title']; ?>",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "name":"<?php echo $company['Companytranslation']['title']; ?>",
        "id": "<?php echo __SITE_URL.'company/'.$company['Company']['slug']; ?>"
    },
    "image": {
        "@type": "ImageObject",
        "url": "<?php echo __SITE_URL.__COMPANY_IMAGE_URL.'/'.$company['Company']['image']; ?>",
        "width": 1200,
        "height": 900
    },
    "author": {
        "@context": "http://schema.org",
        "@type": "Organization",
        "name": "<?php echo __('picosite'); ?>",
        "url": "<?php echo __SITE_URL; ?>",
        "logo": {
            "@type": "ImageObject",
            "url": "<?php echo __SITE_URL; ?>img/logo.png",
            "width": 326,
            "height": 60
        },
        "sameAs": [
            "https://twitter.com/picosite",
            "https://www.instagram.com/picosite/"
        ]
    },

    "datePublished": "<?php echo $company['Company']['created']; ?>",
    "dateModified": "<?php echo $company['Company']['created']; ?>",
    "publisher": {
        "@context": "http://schema.org",
        "@type": "Organization",
        "name": "<?php echo __('picosite'); ?>",
        "url": "<?php echo __SITE_URL; ?>",
        "logo": {
            "@type": "ImageObject",
            "url": "<?php echo __SITE_URL; ?>img/logo.png",
            "width": 326,
            "height": 60
        },
        "sameAs": [
            "https://www.facebook.com/picosite/",
            "https://twitter.com/picosite",
            "https://www.instagram.com/picosite/"
        ]
    },
    "description": "<?php echo $company['Company']['little_detail']; ?>"
}</script>

<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "WebPage",
  "name": "<?php echo $company['Companytranslation']['title']; ?>",
  "publisher": "<?php echo __('picosite'); ?>",
  "url": "<?php echo __SITE_URL.'company/'.$company['Company']['slug']; ?>"
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
		"name": "<?php echo __('news_and_magazin'); ?>",
		"item": "<?php echo __SITE_URL.'companys/last'; ?>"
	  },
	  {
		"@type": "ListItem",
		"position": 3,
		"name": "<?php echo $company['Companytranslation']['title']; ?>",
		"item": "<?php echo __SITE_URL.'company/'.$company['Company']['slug']; ?>"
	  }
  ]
}
</script>
<?php echo $this->Html->css(__SITE_URL . __THEME_PATH . '/js/custom-scroll/jquery-scrollbar.css'); ?>
<main>
	<section>
		<div class="page-preview-box">
			<img src="<?php echo __SITE_URL.__THEME_PATH;?>img/dominik-luckma.jpg" alt="">
			<h1 class="page-preview-title">
				<a href="<?php echo __SITE_URL; ?>"><?php echo __('home') ?></a>
				<i class="fal fa-angle-left"></i>
				<?php echo $company['Companytranslation']['title']; ?>
				<i class="fal fa-angle-down"></i>
			</h1>

		</div>
		<div class="global-main-container container-fluid" id="holding-single-main">
			<div class="single-holding-heading">
				<h1 class="holding-header-title"><a href="#">
						<?php echo $company['Companytranslation']['title']; ?>
					</a></h1>
				<div class="holding-image-box">
					<img src="<?php echo __SITE_URL.__COMPANY_IMAGE_URL.$company['Company']['image'];?>" alt="<?php echo $company['Companytranslation']['detail']; ?>">
				</div>
			</div>
			<div class="holding-content-box">
				<p>
					<?php
						echo $this->Cms->convert_character_editor($company['Companytranslation']['detail']);
					?>
				</p>
			</div>
		</div>
		<div class="global-main-container container-fluid justify-content-center" id="holding-single-main">
			<h2 class="holding-project-title"><?php echo __d(__COMPANY_LOCALE, 'the_projects_completed_and_under_implementation_the_company') ?></h2>
			<?php
				foreach ($projects as $project) {
					?>
					<div class="global-column col-lg-3 col-md-4 col-sm-6 col-12">
						<div class="column-frame-box">
							<div class="column-image-box">
								<img
									src="<?php echo __SITE_URL . __PROJECT_IMAGE_URL . '/' . $project['0']['image']; ?>"
									alt="<?php echo $project['Projecttranslation']['title']; ?>">
							</div>
							<div class="column-date-box">
								<span class="date-title-box"><?php echo __d(__COMPANY_LOCALE, 'date') ?> :</span>
								<span class="date-box">
							<?php echo $this->Cms->show_persian_date("j", strtotime($project['Project']['created'])); ?>
							<?php echo $this->Cms->show_persian_date("F", strtotime($project['Project']['created'])); ?>
						</span>
							</div>
							<div class="column-content-box1">
								<div class="col-12">
									<a href="<?php echo __SITE_URL.__PROJECT."/".$project['Project']['slug']; ?>">
										<?php echo $project['Projecttranslation']['title']; ?></a>
								</div>
								<div class="col-12">
									<?php echo $project['Projecttranslation']['mini_detail']; ?>
								</div>
							</div>

						</div>
					</div>
					<?php
				}
			?>

		</div>


	</section>
</main>


<?php
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/custom-scroll/jquery-scrollbar.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/pagination.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/sidebar.js');
?>

