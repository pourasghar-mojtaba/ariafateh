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
			<img src="<?php echo __SITE_URL . __THEME_PATH; ?>img/dominik-luckma.jpg" alt="">
			<h1 class="main-title"><a href="#">تماس با ما</a></h1>
			<h1 class="page-preview-title">
				<a href="<?php echo __SITE_URL; ?>"><?php echo __('home') ?></a>
				<i class="fal fa-angle-left"></i>
				<?php echo __d('user', 'contact_us'); ?>
				<i class="fal fa-angle-down"></i>
			</h1>


		</div>

		<!-- sarmayeh form -->
		<div class="global-main-container container contact-container">

			<div class="contact-heading-box">
				<img src="<?php echo __SITE_URL . __THEME_PATH; ?>img/undraw_contact_us.png" alt="">
			</div>
			<div class="form-section col-md-6 col-sm-10">
				<div class="contact-sub-title justify-content-md-start justify-content-center">
					<h2 class="contact-sub-title-text">فرم تماس </h2>
				</div>
					<?php echo $this->Form->create('Contactmessage', array('id' => 'RegisterForm', 'enctype' => 'multipart/form-data', 'class' => 'main-form justify-content-center'
					, 'onsubmit' => 'return check_field()', 'url' => "/contactmessages/sendmessage")); ?>

					<?php
					if ($this->Session->check('Message.flash')) {
						echo $this->Session->flash();
					}
					?>
					<div class="form-group col-12">
						<div class="col-sm-10 col-12 col-form-input">
							<?php
							echo  $this->Form->input('name', array(
								'type'       => 'text',
								'label'      => '',
								'placeholder'=>__('enter_name'),
								'class'      => 'form-control',
								'required'   => 'required'
							));
							?>
						</div>
					</div>
					<div class="form-group col-12">
						<div class="col-sm-10 col-12 col-form-input">
							<?php
							echo  $this->Form->input('email', array(
								'type'       => 'text',
								'label'      => '',
								'placeholder'=>__('enter_email'),
								'class'      => 'form-control',
								'required'   => 'required'
							));
							?>
						</div>
					</div>
					<div class="form-group col-12">
						<div class="col-sm-10 col-12 col-form-input">
							<?php
							echo  $this->Form->input('subject', array(
								'type'       => 'text',
								'label'      => '',
								'placeholder'=>__('subject'),
								'class'      => 'form-control',
								'required'   => 'required'
							));
							?>
						</div>
					</div>
					<div class="col-12 col-form-input comment-textarea">
						<?php
						echo  $this->Form->input('message', array(
							'type'       => 'textarea',
							'label'      => '',
							'placeholder'=>__('message'),
							'class'      => 'form-control',
							'required'   => 'required'
						));
						?>
					</div>
					<div class="col-12 col-form-input comment-textarea">
						<img id="captcha" src="<?php echo __SITE_URL ?>captcha/advanced-captcha.php" alt="" />
						<?php
						echo  $this->Form->input('captcha', array(
							'type'       => 'text',
							'label'      => '',
							'placeholder'=>__('captcha'),
							'class'      => 'form-control',
							'required'   => 'required'
						));
						?>
					</div>

					<div class="form-group file-button-box col-12 justify-content-lg-start justify-content-center ">
						<button class="btn btn-danger btn-file-save"><?php echo __('Send_request'); ?></button>
					</div>
				</form>
			</div>
			<div class="contact-info-section col-md-6 col-sm-10">
				<div class="contact-sub-title justify-content-md-start justify-content-center">
					<h2 class="contact-sub-title-text">اطلاعات تماس </h2>
				</div>
				<div class="contact-info-group col-12">
					<div class="contact-info-panel col-sm-10 col-12">
						<div class="contact-info-label"> شماره ثابت
							<span class="contact-info-text">۸۸۷۳۱۰۴۷ - ۰۲۱</span>
						</div>
					</div>
				</div>
				<div class="contact-info-group col-12">
					<div class="contact-info-panel col-sm-10 col-12">
						<div class="contact-info-label">ایمیل
							<span class="contact-info-text">info@ariafateh.com</span>
						</div>
					</div>
				</div>
				<div class="contact-info-group col-12">
					<div class="contact-info-panel col-sm-10 col-12">
						<div class="contact-info-label">آدرس
							تهران- شهید بهشتی- بعد از خیابان میرعماد- پلاک 290
						</div>
					</div>
				</div>
				<div class="contact-info-group col-12">
					<div class="contact-info-panel col-sm-10 col-12">
						<div class="contact-info-location"><img
								src="<?php echo __SITE_URL . __THEME_PATH; ?>img/map.PNG" alt="map"></div>
					</div>
				</div>
			</div>

		</div>


	</section>
</main>

