
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
<!-- ============================ Hero Banner  Start================================== -->
<div class="container-fluid breadcrumbs">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<a href="<?php echo __SITE_URL; ?>">
					خانه
				</a>
				<a href="javascript:void(0)">
					<span>
						<i class="ti-arrow-right"></i>
					</span>
					در تماس باشید
				</a>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<!-- ============================ Hero Banner End ================================== -->

<!-- ============================ Who We Are Start ================================== -->
<section>
	<div class="container">

		<?php
			echo $this->Cms->convert_character_editor($page['Page']['body']);
		?>
		<div class="row mb-4">

			<div class="col-lg-4 col-md-4">
				<div class="contact-box">
					<i class="ti-map-alt"></i>
					<h4>دفتر مرکزی</h4>
					خیابان بهشتی،<br>
					آزادگان شرق، تهران
				</div>
			</div>

			<div class="col-lg-4 col-md-4">
				<div class="contact-box">
					<i class="ti-email"></i>
					<h4>ایمیل ها</h4>
					info@picosite.ir
				</div>
			</div>

			<div class="col-lg-4 col-md-4">
				<div class="contact-box">
					<i class="ti-headphone"></i>
					<h4>تماس ها</h4>
					09103559365 -
					09371931737
				</div>
			</div>

		</div>

		<div class="row mt-5">
			<div class="col-lg-5 col-md-5 image-bg ct-img" style="background:url(<?php echo __SITE_URL.__THEME_PATH;?>img/cover.jpg) no-repeat center center;">

			</div>

			<div class="col-lg-7 col-md-7">
				<div class="contact-form">
					<?php echo $this->Form->create('Contactmessage', array('id'      => 'RegisterForm','enctype' =>'multipart/form-data','class'   =>'myForm'
					,'onsubmit'=>'return check_field()','url'     =>"/contactmessages/sendmessage")); ?>

					<?php
					if($this->Session->check('Message.flash')){
						echo $this->Session->flash();
					}
					?>
						<div class="form-row">
							<div class="form-group col-md-6">
								<?php
									echo  $this->Form->input('name', array(
										'type'       => 'text',
										'label'      => __('name'),
										'placeholder'=>__('enter_name'),
										'class'      => 'form-control',
										'required'   => 'required'
									));
								?>
							</div>
							<div class="form-group col-md-6">
								<?php
									echo  $this->Form->input('email', array(
										'type'       => 'text',
										'label'      => __('email'),
										'placeholder'=>__('enter_email'),
										'class'      => 'form-control',
										'required'   => 'required'
									));
								?>
							</div>
						</div>
						<div class="form-group">
							<?php
								echo  $this->Form->input('subject', array(
									'type'       => 'text',
									'label'      => __('subject'),
									'placeholder'=>__('subject'),
									'class'      => 'form-control',
										'required'   => 'required'
								));
							?>
						</div>
						<div class="form-group">
							<?php
								echo  $this->Form->input('message', array(
									'type'       => 'textarea',
									'label'      => __('message'),
									'placeholder'=>__('message'),
									'class'      => 'form-control',
										'required'   => 'required'
								));
							?>
						</div>
						<div class="form-group col-md-3">

							<img id="captcha" src="<?php echo __SITE_URL ?>captcha/advanced-captcha.php" alt="" />
							<?php
								echo  $this->Form->input('captcha', array(
									'type'       => 'text',
									'label'      => __('captcha'),
									'placeholder'=>__('captcha'),
									'class'      => 'form-control',
										'required'   => 'required'
								));
							?>
						</div>
						<button type="submit" class="btn btn-primary"><?php echo __('Send_request'); ?></button>
					</form>
				</div>
			</div>

		</div>

	</div>
</section>
<div class="clearfix"></div>
<!-- ============================ Who We Are End ================================== -->
