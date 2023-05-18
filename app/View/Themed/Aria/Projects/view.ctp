
<script type = "application/ld+json">
  {
    "@context":"https://schema.org",
    "@type":"NewsArticle",
    "inLanguage":"fa-IR",
    "mainEntityOfPage":{
       "@type": "WebPage",
       "name":"<?php echo $project['Project']['title'].__('default_title'); ?>",
       "url":"<?php echo __SITE_URL.'project/'.$project['Project']['slug']; ?>"
     },
    "headline":"<?php echo $project['Project']['title'].__('default_title'); ?>",
    "name":"<?php echo $project['Project']['title'].__('default_title'); ?>",
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
  		"url":"<?php echo __SITE_URL.__BLOG_IMAGE_URL.'/'.$images[0]['Projectimage']['image']; ?>",
  		"width":500,
  		"height":500
        },
    "datePublished":"<?php echo $project['Project']['created']; ?>",
    "dateModified":"<?php echo $project['Project']['created']; ?>",
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
    "description":"<?php echo $project['Project']['mini_detail']; ?>"
  }
  </script>

<script type="application/ld+json">{
    "@context": "http://schema.org",
    "@type": "Article",
    "headline": "<?php echo $project['Project']['title'].__('default_title'); ?>",
    "articlebody":"<?php echo $project['Project']['detail']; ?>",
    "name": "<?php echo $project['Project']['title'].__('default_title'); ?>",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "name":"<?php echo $project['Project']['title'].__('default_title'); ?>",
        "id": "<?php echo __SITE_URL.'project/'.$project['Project']['slug']; ?>"
    },
    "image": {
        "@type": "ImageObject",
        "url": "<?php echo __SITE_URL.__BLOG_IMAGE_URL.'/'.$images[0]['Projectimage']['image']; ?>",
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

    "datePublished": "<?php echo $project['Project']['created']; ?>",
    "dateModified": "<?php echo $project['Project']['created']; ?>",
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
    "description": "<?php echo $project['Project']['mini_detail']; ?>"
}</script>

<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "WebPage",
  "name": "<?php echo $project['Project']['title'].__('default_title'); ?>",
  "publisher": "<?php echo __('picosite'); ?>",
  "url": "<?php echo __SITE_URL.'project/'.$project['Project']['slug']; ?>"
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
	  },
	  {
		"@type": "ListItem",
		"position": 3,
		"name": "<?php echo $project['Project']['title'].__('default_title'); ?>",
		"item": "<?php echo __SITE_URL.'project/'.$project['Project']['slug']; ?>"
	  }
  ]
}
</script>
<?php echo $this->Html->css(__SITE_URL . __THEME_PATH . '/js/jssor/jssor.css'); ?>
<main>
	<section>
		<div class="page-preview-box">
			<img src="<?php echo __SITE_URL.__THEME_PATH;?>img/dominik-luckma.jpg" alt="">
			<h1 class="page-preview-title">
				<a href="<?php echo __SITE_URL; ?>"><?php echo __('home') ?></a>
				<i class="fal fa-angle-left"></i>
				<?php echo $project['Projecttranslation']['title']; ?>
				<i class="fal fa-angle-down"></i>
			</h1>

		</div>
		<div class="global-main-container container">
			<section class="main  project-slider-main">
				<div id="jssor_1"
					 style="position:relative;margin:0 auto;top:0px;left:0px;width:980px;height:480px;overflow:hidden;visibility:hidden;">
					<!-- Loading Screen -->
					<div data-u="loading" class="jssorl-009-spin"
						 style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
						<img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;"
							 src="<?php echo __SITE_URL.__THEME_PATH;?>img/spin.svg"/>
					</div>
					<div data-u="slides"
						 style="cursor:default;position:relative;top:0px;left:0px;width:980px;height:380px;overflow:hidden;">
						<?php
							foreach ($images as $image) {
								?>
								<div>
									<img data-u="image"
										 src="<?php echo __SITE_URL . __PROJECT_IMAGE_URL . '/' . $image['Projectimage']['image']; ?>"/>
									<img data-u="thumb"
										 src="<?php echo __SITE_URL . __PROJECT_IMAGE_URL .__UPLOAD_THUMB. '/' . $image['Projectimage']['image']; ?>"/>
								</div>
								<?php
							}
						?>

					</div>
					<a data-scale="0" href="https://www.jssor.com" style="display:none;position:absolute;">web
						animation</a>
					<!-- Thumbnail Navigator -->
					<div data-u="thumbnavigator" class="jssort101"
						 style="position:absolute;left:0px;bottom:0px;width:980px;height:100px;background-color:#000;"
						 data-autocenter="1" data-scale-bottom="0.75">
						<div data-u="slides">
							<div data-u="prototype" class="p" style="width:190px;height:90px;">
								<div data-u="thumbnailtemplate" class="t"></div>
								<svg viewbox="0 0 16000 16000" class="cv">
									<circle class="a" cx="8000" cy="8000" r="3238.1"></circle>
									<line class="a" x1="6190.5" y1="8000" x2="9809.5" y2="8000"></line>
									<line class="a" x1="8000" y1="9809.5" x2="8000" y2="6190.5"></line>
								</svg>
							</div>
						</div>
					</div>
					<!-- Arrow Navigator -->
					<div data-u="arrowleft" class="jssora106" style="width:55px;height:55px;top:162px;left:30px;"
						 data-scale="0.75">
						<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
							<circle class="c" cx="8000" cy="8000" r="6260.9"></circle>
							<polyline class="a" points="7930.4,5495.7 5426.1,8000 7930.4,10504.3 "></polyline>
							<line class="a" x1="10573.9" y1="8000" x2="5426.1" y2="8000"></line>
						</svg>
					</div>
					<div data-u="arrowright" class="jssora106" style="width:55px;height:55px;top:162px;right:30px;"
						 data-scale="0.75">
						<svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
							<circle class="c" cx="8000" cy="8000" r="6260.9"></circle>
							<polyline class="a" points="8069.6,5495.7 10573.9,8000 8069.6,10504.3 "></polyline>
							<line class="a" x1="5426.1" y1="8000" x2="10573.9" y2="8000"></line>
						</svg>
					</div>
				</div>
			</section>
		</div>
		<div class="global-main-container container">
			<div class="project-heading">
				<div class="project-column-box col-12 justify-content-md-start justify-content-center">
					<h1 class="project-header-title justify-content-md-start justify-content-center"><a href="#">
							<?php echo $project['Projecttranslation']['title']; ?>
						</a></h1>
					<div class="project-content-box justify-content-md-start justify-content-center">
						<p>
							<?php
							echo $project['Projecttranslation']['mini_detail'];
							echo $this->Cms->convert_character_editor($project['Projecttranslation']['detail']);
							?>
						</p>
					</div>
				</div>


			</div>

		</div>



	</section>
</main>
<?php
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/jssor/jssor.slider-28.0.0.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/jssor/jssor.js');
?>
