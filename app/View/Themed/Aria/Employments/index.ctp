<?php echo $this->Html->css(__SITE_URL . __THEME_PATH . '/js/custom-scroll/jquery-scrollbar.css'); ?>

<main>
	<section>
		<div class="page-preview-box">
			<img src="<?php echo __SITE_URL . __THEME_PATH; ?>img/dominik-luckma.jpg" alt="">
			<h1 class="main-title"><a href="#"><?php echo __d(__EMPLOYMENT_LOCALE, 'employment'); ?></a></h1>
			<h1 class="page-preview-title">
				<a href="<?php echo __SITE_URL; ?>"><?php echo __('home') ?></a>
				<i class="fal fa-angle-left"></i>
				<?php echo __d(__EMPLOYMENT_LOCALE, 'employment'); ?>
				<i class="fal fa-angle-down"></i>
			</h1>


		</div>

		<!-- sarmayeh form -->
		<div class="global-main-container container contact-container">
			<div class="contact-heading-box">
				<div class="employment-message-box">
					<h3 class="message-text"><?php echo __d(__EMPLOYMENT_LOCALE, 'your_place_is_empty'); ?></h3>
				</div>
				<img src="<?php echo __SITE_URL . __THEME_PATH; ?>img/undraw_Hire_re_gn5j.png" alt="">
			</div>
			<div class="form-section employment-form-section">
				<div class="contact-sub-title justify-content-md-start justify-content-center">

				</div>
				<?php echo $this->Form->create('Contactmessage', array('id' => 'RegisterForm', 'enctype' => 'multipart/form-data', 'class' => 'main-form justify-content-lg-start justify-content-center'
				, 'onsubmit' => 'return check_field()', 'url' => "/employment")); ?>

				<?php
				if ($this->Session->check('Message.flash')) {
					echo $this->Session->flash();
				}
				?>
				<div class="form-group col-lg-6 col-10">
					<div class="col-sm-10 col-12 col-form-input">
						<?php
						echo $this->Form->input('name', array(
							'type' => 'text',
							'label' => '',
							'placeholder' => __d(__EMPLOYMENT_LOCALE, 'name'),
							'class' => 'form-control',
							'required' => 'required'
						));
						?>
					</div>
				</div>
				<div class="form-group col-lg-6 col-10">
					<div class="col-sm-10 col-12 col-form-input">
						<?php
						echo $this->Form->input('job', array(
							'type' => 'text',
							'label' => '',
							'placeholder' => __d(__EMPLOYMENT_LOCALE, 'job'),
							'class' => 'form-control',
							'required' => 'required'
						));
						?>
					</div>
				</div>
				<div class="form-group col-lg-6 col-10">
					<div class="col-sm-10 col-12 col-form-input">
						<?php
						echo $this->Form->input('mobile', array(
							'type' => 'text',
							'label' => '',
							'placeholder' => __d(__EMPLOYMENT_LOCALE, 'mobile'),
							'class' => 'form-control',
							'required' => 'required'
						));
						?>
					</div>
				</div>
				<div class="form-group col-lg-6 col-10">
					<div class="col-sm-10 col-12 col-form-input">
						<?php
						echo $this->Form->input('mobile', array(
							'type' => 'text',
							'label' => '',
							'placeholder' => __d(__EMPLOYMENT_LOCALE, 'phone'),
							'class' => 'form-control',
							'required' => 'required'
						));
						?>
					</div>
				</div>
				<div class="form-group col-lg-6 col-10">
					<div class="col-sm-10 col-12 col-form-input">
						<?php
						echo $this->Form->input('email', array(
							'type' => 'email',
							'label' => '',
							'placeholder' => __d(__EMPLOYMENT_LOCALE, 'email'),
							'class' => 'form-control',
							'required' => 'required'
						));
						?>
					</div>
				</div>
				<div class="form-group col-lg-6 col-10">
					<div class="custom-upload-box col-sm-10 col-12 col-form-input">

						<div id="custom_upload" class="btn" onclick="getFile()">فایل رزومه
							<button class="btn-custom-employ">انتخاب فایل</button>
						</div>
						<div style="height: 0px;width: 0px; overflow:hidden;"><input id="upfile" type="file "value="upload" onchange="sub(this)"></div>
					</div>
				</div>
				<div class="col-lg-6 col-10 col-form-input comment-textarea">
						<textarea class="form-control textarea-control employment-textarea col-sm-10 col-12" rows="5"
								  placeholder="متن پیام"></textarea>
				</div>
				<div class="form-group col-lg-6 col-10">
					<div class="employment-cover">
						<img src="<?php echo __SITE_URL . __THEME_PATH; ?>img/undraw_hiring_cyhs.png" alt="">
					</div>
				</div>

				<div
					class="form-group file-button-box col-lg-6 col-12 justify-content-lg-start justify-content-center ">
					<button class="btn btn-danger btn-file-save">ارسال پیام</button>
				</div>
				</form>
			</div>

		</div>


	</section>
</main>

<?php
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/custom-scroll/jquery-scrollbar.min.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/pagination.js');
echo $this->Html->script(__SITE_URL . __THEME_PATH . 'js/sidebar.js');
?>

<script type="text/javascript">


    function getFile() {
        document.getElementById("upfile").click();
    }

    function sub(obj) {
        var file = obj.value;
        var fileName = file.split("\\");
        document.getElementById("yourBtn").innerHTML = fileName[fileName.length - 1];
        document.myForm.submit();
        event.preventDefault();
    }

    $('input').click(function () {
       // $("input").attr("placeholder", "");

    });

</script>
