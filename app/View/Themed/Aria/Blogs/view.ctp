
<script type = "application/ld+json">
  {
    "@context":"https://schema.org",
    "@type":"NewsArticle",
    "inLanguage":"fa-IR",
    "mainEntityOfPage":{
       "@type": "WebPage",
       "name":"<?php echo $blog['Blogtranslation']['title']; ?>",
       "url":"<?php echo __SITE_URL.'blog/'.$blog['Blog']['slug']; ?>"
     },
    "headline":"<?php echo $blog['Blogtranslation']['title']; ?>",
    "name":"<?php echo $blog['Blogtranslation']['title']; ?>",
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
  		"url":"<?php echo __SITE_URL.__BLOG_IMAGE_URL.'/'.$blog['Blog']['image']; ?>",
  		"width":500,
  		"height":500
        },
    "datePublished":"<?php echo $blog['Blog']['created']; ?>",
    "dateModified":"<?php echo $blog['Blog']['created']; ?>",
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
    "description":"<?php echo $blog['Blog']['little_detail']; ?>"
  }
  </script>

<script type="application/ld+json">{
    "@context": "http://schema.org",
    "@type": "Article",
    "headline": "<?php echo $blog['Blogtranslation']['title']; ?>",
    "articlebody":"<?php echo $blog['Blog']['detail']; ?>",
    "name": "<?php echo $blog['Blogtranslation']['title']; ?>",
    "mainEntityOfPage": {
        "@type": "WebPage",
        "name":"<?php echo $blog['Blogtranslation']['title']; ?>",
        "id": "<?php echo __SITE_URL.'blog/'.$blog['Blog']['slug']; ?>"
    },
    "image": {
        "@type": "ImageObject",
        "url": "<?php echo __SITE_URL.__BLOG_IMAGE_URL.'/'.$blog['Blog']['image']; ?>",
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

    "datePublished": "<?php echo $blog['Blog']['created']; ?>",
    "dateModified": "<?php echo $blog['Blog']['created']; ?>",
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
    "description": "<?php echo $blog['Blog']['little_detail']; ?>"
}</script>

<script type="application/ld+json">
{
  "@context": "http://schema.org/",
  "@type": "WebPage",
  "name": "<?php echo $blog['Blogtranslation']['title']; ?>",
  "publisher": "<?php echo __('picosite'); ?>",
  "url": "<?php echo __SITE_URL.'blog/'.$blog['Blog']['slug']; ?>"
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
		"item": "<?php echo __SITE_URL.'blogs/last'; ?>"
	  },
	  {
		"@type": "ListItem",
		"position": 3,
		"name": "<?php echo $blog['Blogtranslation']['title']; ?>",
		"item": "<?php echo __SITE_URL.'blog/'.$blog['Blog']['slug']; ?>"
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
				<?php echo $blog['Blogtranslation']['title']; ?>
				<i class="fal fa-angle-down"></i>
			</h1>

		</div>
		<div class="global-main-container introduct-holding-container container-fluid justify-content-center">
			<div class="side-bar col-lg-3 col-md-4">
				<div class="side-bar-panel">
					<div class="side-bar-panel-header">
						<h3 class="side-bar-title">
							<?php echo __d(__BLOG_LOCALE, 'last_blogs') ?>
						</h3>
					</div>
					<div class="post-option-box scrollbar-inner">
						<?php
						foreach ($last_blogs as $last_blog) {
							?>
							<div class="item-option">
								<div class="post-date-box col-12">
									<span class="post-date-title"><?php echo __d(__BLOG_LOCALE, 'date') ?>:</span>
									<span class="post-date">
											<?php echo $this->Cms->show_persian_date("j", strtotime($last_blog['Blog']['created'])); ?>
											<?php echo $this->Cms->show_persian_date("F", strtotime($last_blog['Blog']['created'])); ?>
										</span>
								</div>
								<div class="thumbnail-post col-md-3 col-4">
									<img src="<?php echo __SITE_URL . __BLOG_IMAGE_URL .__UPLOAD_BLOG_THUMB. '/' . $last_blog['Blog']['image']; ?>" alt="">
								</div>
								<div class="content-post col-md-9 col-8">
									<p>
										<a href="<?php echo __SITE_URL . "blog/" . $last_blog['Blog']['slug']; ?>">
											<?php echo $last_blog['Blogtranslation']['title']; ?>
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
							<?php echo __d(__BLOG_LOCALE, 'similar_blog') ?>
						</h3>
					</div>
					<div class="post-option-box scrollbar-inner">
						<?php
						foreach ($similar_blogs as $similar_blog) {
							?>
							<div class="item-option">
								<div class="post-date-box col-12">
									<span class="post-date-title"><?php echo __d(__BLOG_LOCALE, 'date') ?>:</span>
									<span class="post-date">
											<?php echo $this->Cms->show_persian_date("j", strtotime($similar_blog['Blog']['created'])); ?>
											<?php echo $this->Cms->show_persian_date("F", strtotime($similar_blog['Blog']['created'])); ?>
										</span>
								</div>
								<div class="thumbnail-post col-md-3 col-4">
									<img src="<?php echo __SITE_URL . __BLOG_IMAGE_URL .__UPLOAD_BLOG_THUMB. '/' . $similar_blog['Blog']['image']; ?>" alt="">
								</div>
								<div class="content-post col-md-9 col-8">
									<p>
										<a href="<?php echo __SITE_URL . "blog/" . $similar_blog['Blog']['slug']; ?>">
											<?php echo $similar_blog['Blogtranslation']['title']; ?>
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
			<!-- post single main -->
			<div class="post-main-box col-lg-9 col-md-8">

				<div class="post-single-panel-box justify-content-md-start justify-content-center">
					<div class="post-single-image-col col-12">
						<img src="<?php echo __SITE_URL.__BLOG_IMAGE_URL.'/'.$blog['Blog']['image']; ?>" alt="<?php echo $blog['Blogtranslation']['title']; ?>">
					</div>
					<div class="post-single-detail-box justify-content-md-end justify-content-center">
						<!--<div class="post-comment-number-box">
							<span class="post-comment-title">تعداد نظرات</span>
							<span class="post-comment">۲۰</span>
						</div>-->
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
					<div class="post-single-content-box">
						<h3 class="post-single-header">
							<a href="#"><?php echo $blog['Blogtranslation']['title']; ?></a>
						</h3>
						<article class="post-single-article">
							<p>
								<?php
									echo $blog['Blogtranslation']['little_detail'];
									echo $this->Cms->convert_character_editor($blog['Blogtranslation']['detail']);
								?>
							</p>
						</article>
					</div>
					<div class="separator-post">
						<div class="separator"></div>
					</div>
				</div>
				<!-- start comments box  -->
				<!--<div class="main-user-comment">
					<h2 class="default-heading">نظرات شما</h2>
					<div class="last-comment-box">
						<h3 class="last-comment-title">آخرین نظرات</h3>
						<div class="last-comment-panel">
							<p class="last-comment-text">شرکت مینای کویر سماء در زمینه اکتشاف،
								ستخراج و فرآوری مواد معدنی در استان‌های یزد، کرمان و آذربایجان غربی فعالیت می‌کند.
								از محدوده‌های بزرگ این شرکت می‌توان به کشف بالغ بر ۱۰۰ میلیون
								تن سنگ آهن پلاسربا عیار ۱۲ درصد در شهرستان مروست استان یزد اشاره کرد که در حال
								اجرای سرمایه‌گذاری می‌باشد. در ضمن این شرکت در بحث معادن سرب و روی
								و مس نیز ورود کرده که در حال اکتشاف می‌باشد.</p>
							<div class="comment-panel-detail-box">
								<div class="date-box">
									<span class="date-title">تاریخ</span>
									<span class="date">۱۳۹۹/۰۹/۲۷</span>
								</div>
								<div class="user-box"><a href="#" class="user-title">
										علی رستمی
									</a></div>
							</div>
						</div>
					</div>
					<div class="comment-form-box">
						<h2 class="default-heading">نظرات</h2>
						<div class="form-section">
							<form action="#" class="main-form justify-content-center comment-form">
								<div class="form-group col-lg-6 col-10">
									<div class=" col-12 col-form-input">
										<input type="text" class="form-control" value="نام و نام خانوادگی">
									</div>
								</div>
								<div class="form-group col-lg-6 col-10">
									<div class=" col-12 col-form-input">
										<input type="text" class="form-control" value="پست الکترونیکی">
									</div>
								</div>
								<div class="form-group col-lg-6 col-10">
									<div class="col-12 col-form-input">
										<input type="text" class="form-control" value="تلفن همراه">
									</div>
								</div>
								<div class="form-group col-lg-6 col-10">
									<div class="col-12 col-form-input">
										<input type="text" class="form-control" value="وب سایت">
									</div>
								</div>
								<div class="col-lg-6 col-10 col-form-input comment-textarea">
									<textarea class="form-control textarea-control" rows="5" placeholder="متن پیام"></textarea>
								</div>

								<div class="form-group file-button-box col-lg-6 col-10  justify-content-center ">
									<button class="btn btn-danger btn-file-save">ثبت نظر</button>
								</div>
							</form>
						</div>
					</div>
				</div>-->
				<!-- end comments box -->

			</div>
			<!-- end post main -->
		</div>




	</section>
</main>

<?php
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/custom-scroll/jquery-scrollbar.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/pagination.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/sidebar.js');
?>

