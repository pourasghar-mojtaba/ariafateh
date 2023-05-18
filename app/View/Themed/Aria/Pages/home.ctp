<script type="application/ld+json" class="next-head">{
		"@context": "http://www.schema.org",
		"@type": "Organization",
		"name": "picosite",
		"url": "<?php echo __SITE_URL; ?>",
		"logo": "<?php echo __SITE_URL; ?>img/logo.png",
		"description": "<?php echo $description_for_layout; ?>",
		"address": {
			"@type": "PostalAddress",
			"streetAddress": "اتوبان کردستان جنوب. خیابان شیراز جنوبی-خیابان زرتشتیان-پلاک ۴- واحد ۳",
			"addressLocality": "تهران",
			"addressRegion": "تهران",
			"postalCode": "1459973811",
			"addressCountry": "ايران"
		},
		"contactPoint": {
			"@type": "ContactPoint",
			"contactType": "customer service",
			"telephone": "+98921-2775795"
		},
		"sameAs": [
			"https://twitter.com/picosite",
			"https://www.instagram.com/picosite/",
			"https://www.linkedin.com/company/picosite"
		]
	}


</script>
<main>

	<section>
		<!-- start main slider -->
		<div class="main-slider-box">
			<div class="main-slider owl-carousel">
				<?php $this->Plugin->run_hook('last_slider', array("lang" => $this->Session->read('Config.language'))); ?>
			</div>
		</div>
		<!-- end main slider -->
		<!-- start feattures container -->
		<div class="container-fluid features-section">
			<div class="row">
				<div class="col-md-14 col-sm-3 col-6">
					<div class="features-item">
						<div class="features-icon-box">
							<a href="<?php echo __SITE_URL.'/pages/about' ?>" class="features-icon-link">
								<span class="features-icon icon-holding"></span>
							</a>
						</div>
						<div class="features-title-box">
							<a href="<?php echo __SITE_URL.'/pages/about' ?>" class="features-icon-link">
								<h3 class="features-title"><?php echo __('holding'); ?></h3>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-14 col-sm-3 col-6">
					<div class="features-item">
						<div class="features-icon-box">
							<a href="<?php echo __SITE_URL.__BLOG.'/blogs/last' ?>" class="features-icon-link">
								<span class="features-icon icon-news"></span>
							</a>

						</div>
						<div class="features-title-box">
							<a href="#" class="features-icon-link">
								<h3 class="features-title"><?php echo __d(__BLOG_LOCALE,'news'); ?></h3>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-14 col-sm-3 col-6">
					<div class="features-item">
						<div class="features-icon-box">
							<a href="<?php echo __SITE_URL.'/honor/honors/view' ?>" class="features-icon-link">
								<span class="features-icon icon-winner"></span>
							</a>
						</div>
						<div class="features-title-box">
							<a href="#" class="features-icon-link">
								<h3 class="features-title"> <?php echo __('honors'); ?></h3>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-14 col-sm-3 col-6">
					<div class="features-item">
						<div class="features-icon-box">
							<a href="<?php echo __SITE_URL.__PROJECT.'/projects/last' ?>" class="features-icon-link">
								<span class="features-icon icon-project"></span>
							</a>

						</div>
						<div class="features-title-box">
							<a href="#" class="features-icon-link">
								<h3 class="features-title"><?php echo __d(__PROJECT_LOCALE,'projects') ?></h3>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-14 col-sm-3 col-6">
					<div class="features-item">
						<div class="features-icon-box">
							<a href="<?php echo __SITE_URL.__COMPANY.'/companies/last' ?>" class="features-icon-link">
								<span class="features-icon icon-factory"></span>
							</a>
						</div>
						<div class="features-title-box">
							<a href="<?php echo __SITE_URL.__COMPANY.'/companies/last' ?>" class="features-icon-link">
								<h3 class="features-title"><?php echo __d(__COMPANY_LOCALE,'companies') ?></h3>
							</a>
						</div>
					</div>
				</div>
				<div class="col-md-14 col-sm-3 col-6">
					<div class="features-item">
						<div class="features-icon-box">
							<a href="<?php echo __SITE_URL.'uploads/catalogue-ariafateh-fa.pdf' ?>" class="features-icon-link">
								<span class="features-icon icon-catalog"></span>
							</a>

						</div>
						<div class="features-title-box">
							<a href="<?php echo __SITE_URL.'/pages/catalog' ?>" class="features-icon-link">
								<h3 class="features-title"><?php echo __('catalog'); ?></h3>
							</a>
						</div>
					</div>
				</div>

			</div>
		</div>
		<!-- end features container -->
		<div class="content-container container-fluid">
			<?php $this->Plugin->run_hook('last_companies', array("lang" => $this->Session->read('Config.language'))); ?>
		</div>
		<!-- start new project carousel -->
		<div class="content-container container-fluid">
			<?php $this->Plugin->run_hook('home_projects', array("lang" => $this->Session->read('Config.language'))); ?>
		</div>
		<!-- end new project carousel -->
		<!-- start company carousel  -->

		<!-- end company carousel -->
		<!-- teaser start -->
		<div class="content-container container-fluid gray-container">
			<div class="section-block-box">
				<div class="col-lg-6 col-md-5 col-sm-10 col-12 block-column-box">
					<div class="teaser-main-box">
						<img src="<?php echo __SITE_URL . __THEME_PATH; ?>img/tv.png" alt="tv" class="teaser-main-img">
					</div>
				</div>
				<div class="col-lg-6 col-md-7 col-sm-10 col-12  block-column-box">
					<article class="col-lg-8 col-md-9 col-sm-10 col-12">
						<p class="text-content-block">
							شرکت سرمایه‌گذاری آریا فاتح خاورمیانه، فعالیت خود را
							از حدود سه دهه‌ی پیش آغاز کرده است. این گروه یکی از بزرگ‌ترین و موفق‌ترین
							شرکت‌های سرمایه‌گذاری در حوزه‌ی معادن، أخذ مجوزهای اکتشافی، بهره‌برداری
							محدوده‌های معدنی، تأسیس کارخانجات کانی آرایی و فرآوری مواد و … می‌باشد.
						</p>
					</article>
					<div class="more-button-row col-md-6 col-sm-10 col-12 ">
						<a href="#" class="btn-more-link">اطلاعات بیشتر</a>
					</div>
				</div>
			</div>
		</div>
		<!-- teaser end -->
		<!-- start present main -->
		<div class="content-container container-fluid gray-container">
			<div class="content-main-box present-main justify-content-lg-start justify-content-center">
				<!-- winner section -->
				<div class="winner-main-section col-lg-7 col-md-9 col-sm-10 col-12">
					<div class="winner-main">
						<?php $this->Plugin->run_hook('home_honors', array("lang" => $this->Session->read('Config.language'), 'cms' => $this->Cms)); ?>
					</div>
					<!-- end winner section		 -->
				</div>
				<!-- last news -->
				<div class="last-news-section col-lg-5 col-md-9 col-sm-10 col-12">
					<div class="last-news-main">
						<?php $this->Plugin->run_hook('last_blogs', array("lang" => $this->Session->read('Config.language'), 'cms' => $this->Cms)); ?>
					</div>
				</div>
				<!-- end last news -->
			</div>
		</div>
		<!-- end present main -->
		<!-- start help -->
		<div class="help-container container-fluid gray-container" id="help-tab">
			<ul class="list-unstyled">
				<li class="help-item active"><a href="#tabs-1">فعالیت های سرمایه گذاری</a>
					<span class="help-arrow"></span>
				</li>
				<li class="help-item">
					<a href="#tabs-2">فعالیت های اکتشافی</a>
					<span class="help-arrow"></span>
				</li>
				<li class="help-item"><a href="#tabs-3">فعالیت های استخراجی</a>
					<span class="help-arrow"></span>
				</li>
				<li class="help-item"><a href="#tabs-4">فعالیت های فرآوری</a>
					<span class="help-arrow"></span>
				</li>
				<li class="help-item"><a href="#tabs-5">فعالیت های بازرگانی</a>
					<span class="help-arrow"></span>
				</li>
			</ul>
			<div id="tabs-1">
				<p>
					شركت سرمایه‌گذاری آريا فاتح خاورميانه در زمينه فعالیت‌های معدني سرمايه‌گذاري گسترده‌اي نموده است،
					شرکت‌های زیرمجموعه آریا فاتح اجراي بيش از ۳۵ پروژه معدني را عهده‌دار هستند. اين پروژه‌ها در سراسر
					ايران گسترده‌اند. در حال حاضر عمده تمرکز این شرکت در
					استان‌هاي كرمان،‌ يزد، كردستان، خراسان و آذربايجان غربي و شرقي قرار دارد.
				</p>
			</div>
			<div id="tabs-2">
				<p>
					سرزمینمان ایران جزو ده کشور برتر از لحاظ دارا بودن ذخایر معدنی در دنیا به شمار
					می‌رود، توسعه معادن می‌تواند نیروی
					محرکه رشد و توسعه اقتصاد کشور و عامل مهم اشتغال‌زایی باشد.
					سرمايه‌گذاري آريا فاتح خاورميانه
					بر مبناي راهبردهاي معدني خود، اكتشاف را عامل اصلي توسعه و
					رشد در حوزه معدن قرار داده است، ‌اين گروه سرمايه‌گذاري با
					اتکا به بیش از دو دهه تجربه خود در حوزه معادن و با
					استفاده از نيروي كار متخصص فعال در
					اين صنعت، ‌عملكرد قابل ملاحظه‌اي در گردآوري
					اطلاعات اكتشافي و تحليلي داشته است. استراتژي اكتشافي گروه سرمايه‌گذاري
					آريا فاتح براساس نياز كشور و صنعت و برپايه ذخيره‌هاي فلزي شامل طلا،‌
					مس،‌ نيكل، آهن، سرب و روي و موليبدن شكل گرفته است.


				</p>
			</div>
			<div id="tabs-3">
				<p>
					شرکت سرمایه‌گذاری
					آریا فاتح خاورمیانه با در اختیار داشتن بزرگترین ناوگان‌ ماشین آلات سنگین معدنی
					و راهسازی بخش خصوصی در کشور، عملیات استخراج و باطله‌برداری در معادن مختلف داخلی
					و خارجی را از اوایل دهه‌ی هفتاد به صورت مستمر انجام داده است. شرکت‌های تابعه
					آریا فاتح موفق شده‌اند تا کنون بیش از ۸۰۰ میلیون تن عملیات باطله‌برداری
					را در معادن مختلف با موفقیت به انجام برسانند. هم اکنون این گروه قادر
					است عملیات باطله‌برداری با ظرفیت بیش از ۱۲۰ میلیون تن در سال را پوشش دهد.

				</p>
			</div>
			<div id="tabs-4">
				<p>
					ایجاد ارزش افزوده در حوزه مواد معدنی
					و جلوگیری از خام فروشی یکی از اهداف استراتژیک شرکت سرمایه‌گذاری آریا
					فاتح خاورمیانه است. هم اکنون این شرکت با احداث کارخانه‌های متعدد خردایش و فرآوری در تلاش
					است تا مواد معدنی را به محصولاتی با ارزش افزوده بالا تبدیل کند. سرمایه‌گذاری کلان
					در حوزه فرآوری و احداث کارخانجات ذوب در کنار معادن مختلف و تکمیل زنجیره
					ارزش برای محصولات مختلف از برنامه‌های استراتژیک و بلندمدت این گروه است.

				</p>
			</div>
			<div id="tabs-5">
				<p>
					توجه تخصصی و همه جانبه به فرآیند صادرات محصولات مختلف معدنی و نیز تلاش در جهت توسعه صادرات
					غیرنفتی و مباحث ارز آوری از عواملی است که باعث شده، شرکت سرمایه‌گذاری آریا فاتح خاورمیانه
					نگاهی دقیق به فعالیت‌های بازرگانی خود داشته باشد. تلاش در جهت خودکفایی کشور، ارزآوری
					و سرمایه‌گذاری مجدد در داخل کشور ما را بر آن داشته است تا با کمک متخصصان و صاحب‌نظران
					این حوزه فرآیندهای بازرگانی قدرتمندی در همه‌ی زیرمجموعه‌های گروه پیاده‌سازی نماییم.


				</p>
			</div>

		</div>
		<!-- end help -->
	</section>
</main>
