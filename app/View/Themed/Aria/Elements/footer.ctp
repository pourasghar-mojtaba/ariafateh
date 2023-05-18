<footer class="footer">
	<div class="container-fluid main-footer">
		<div class="footer-column col-lg-4 col-sm-6 col-12 align-items-lg-start align-items-center">
			<h4 class="mb-4 d-flex flex-column align-items-lg-start align-items-center justify-content-around footer-column-title">آریا فاتح خاورمیانه</h4>
			<ul class="list-unstyled">
				<li class="mt-1 d-flex flex-column align-items-lg-start align-items-center justify-content-around">
					<h4 class="footer-column-link">
					<span class="footer-circle-icon">
					<i class="fas fa-circle"></i>
					</span>
						<a href="#">تازه ترین ها</a>
					</h4>
				</li>
				<li class="mt-1 d-flex flex-column align-items-lg-start align-items-center justify-content-around">
					<h4 class="footer-column-link">
				  <span class="footer-circle-icon">
				  <i class="fas fa-circle"></i>
				  </span>
						<a href="#">شرکت ها</a>
					</h4>
				</li>
				<li class="mt-1 d-flex flex-column align-items-lg-start align-items-center justify-content-around">
					<h4 class="footer-column-link">
				  <span class="footer-circle-icon">
				  <i class="fas fa-circle"></i>
				  </span>
						<a href="#">آخرین پروژه ها</a>
					</h4>
				</li>
				<li class="mt-1 d-flex flex-column align-items-lg-start align-items-center justify-content-around">
					<h4 class="footer-column-link">
				  <span class="footer-circle-icon">
				  <i class="fas fa-circle"></i>
				  </span>
						<a href="#">آخرین افتخارات</a>
					</h4>
				</li>
				<li class="mt-1 d-flex flex-column align-items-lg-start align-items-center justify-content-around">
					<h4 class="footer-column-link">
				  <span class="footer-circle-icon">
				  <i class="fas fa-circle"></i>
				  </span>
						<a href="#">فعالیت ها</a>
					</h4>
				</li>
			</ul>
			<div class="footer-logo-row justify-content-lg-start justify-content-center">
				<a href="#">
					<img src="<?php echo __SITE_URL.__THEME_PATH;?>img/smd.png" alt="نشان ثبت">
				</a>
			</div>
		</div>
		<div class="footer-column col-lg-4 col-sm-6 col-12 align-items-lg-start align-items-center">
			<h4 class="mb-4 d-flex flex-column align-items-lg-start align-items-center justify-content-around footer-column-title">تماس با ما</h4>
			<ul class="list-unstyled align-items-lg-start align-items-center">
				<li class="mt-1 d-flex flex-column align-items-lg-start align-items-center justify-content-around">
					<h4 class="footer-column-link ">
					<span class="footer-contact-icon">
						<i class="fas fa-mobile-alt"></i>
					</span>
						<span class="footer-contact-text">(021)8-88731047</span>
					</h4>
				</li>
				<li class="mt-1 d-flex flex-column align-items-lg-start align-items-center justify-content-around">
					<h4 class="footer-column-link ">
				   <span class="footer-contact-icon">
					<i class="fas fa-envelope"></i>
				   </span>
						<span class="footer-contact-text">info@arifateh.co</span>
					</h4>
				</li>
				<li class="mt-1 d-flex flex-column align-items-lg-start align-items-center justify-content-around">
					<h4 class="footer-column-link ">

						<span class="footer-contact-text">آدرس</span>
					</h4>
				</li>
				<li class="mt-1 d-flex flex-column align-items-lg-start align-items-center justify-content-around">
					<h4 class="footer-column-link align-items-lg-start align-items-center">
						<div class="footer-address-box justify-content-lg-start justify-content-center">

						<span class="footer-contact-icon">
							<i class="fas fa-map-marker-alt"></i>
						</span>
							<span class="footer-contact-text">
							تهران- خیابان شهید بهشتی- بعد از خیابان میرعماد- پلاک 290
						</span>
						</div>
					</h4>
				</li>

			</ul>
		</div>
		<div class="footer-column col-lg-4 col-sm-6 col-12 align-items-lg-end align-items-center justify-content-center">
			<div class="footer-location-box">
				<img src="<?php echo __SITE_URL.__THEME_PATH;?>img/map.PNG" alt="map">
			</div>
		</div>
	</div>
	<div class="container-fluid main-author">
		<h4 class="author-text">تمامی حقوق این سایت متعلق به شرکت سرمایه گذاری آریا فاتح خاور میانه میباشد.</h4>
	</div>
</footer>
<?php
	echo $this->Html->script(__SITE_URL.__THEME_PATH.'js/bootstrap.min.js');
	echo $this->Html->script(__SITE_URL.__THEME_PATH.'js/owlcarousel/owl.carousel.min.js');
	echo $this->Html->script(__SITE_URL.__THEME_PATH.'js/navbar.js');
	echo $this->Html->script(__SITE_URL.__THEME_PATH.'js/index.js');
?>
