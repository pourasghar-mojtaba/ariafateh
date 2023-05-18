
<?php echo $this->Html->css(__SITE_URL . __THEME_PATH . '/js/custom-scroll/jquery-scrollbar.css'); ?>

<main>
	<section>
		<div class="page-preview-box">
			<img src="<?php echo __SITE_URL.__THEME_PATH;?>img/dominik-luckma.jpg" alt="">
			<h1 class="page-preview-title">
				صفحه نخست<i class="fal fa-angle-left"></i>
				سرمایه گذاری
				<i class="fal fa-angle-down"></i>
			</h1>

		</div>
		<div class="global-main-container container-fluid">
			<div class="project-heading">
				<div class="project-column-box col-md-6 col-sm-8 col-12 justify-content-md-start justify-content-center">
					<h1 class="project-header-title justify-content-md-start justify-content-center"><a href="#">
							سرمایه گذاری
						</a></h1>
					<div class="project-content-box justify-content-md-start justify-content-center">
						<p>
							شركت سرمایه‌گذاری آريا فاتح خاورميانه
							در زمينه فعالیت‌های معدني سرمايه‌گذاري گسترده‌اي نموده است،
							شرکت‌های زیرمجموعه آریا فاتح اجراي بيش از ۳۵ پروژه معدني را
							عهده‌دار هستند. اين پروژه‌ها در سراسر ايران گسترده‌اند.
							در حال حاضر عمده تمرکز این شرکت در استان‌هاي كرمان،‌ يزد،
							كردستان، خراسان و آذربايجان غربي و شرقي قرار دارد.


						</p>
					</div>
				</div>
				<div class="project-column-box col-md-6 col-sm-8 col-12  justify-content-center">
					<div class="project-image-box  justify-content-center">
						<img src="<?php echo __SITE_URL.__THEME_PATH;?>img/logo-investment.png" class="sarmayeh-img" alt="">
					</div>
				</div>
				<div class="project-column-box col-12 justify-content-md-start justify-content-center">

					<div class="project-content-box justify-content-md-start justify-content-center">
						<p>
							هلدینگ آریا فاتح خاورمیانه به عنوان شرکت مادر گروه سرمایه‌گذاری تأسیس گردیده است. فعالیت این گروه در صنعت از طیف گسترده تشکیل شده است که حضور در صنایع فلزی، سنگ‌های زینتی خدمات پیمانکاری معادن و فناوری اطلاعات از این جمله می‌باشد.

							گروه سرمایه‌گذاری آریا فاتح خاورمیانه
							در مدتی کمتر از
							۱ دهه شاهد رشد و توسعه بی‌نظیری بوده است که این مسئله باعث شده تا این گروه
							به عنوان یکی از موفق‌ترین و پرسودترین کارآفرینان در ایران مطرح گردد.
							تأسیس شرکت سهامی آریا فاتح خاورمیانه بیش از هر چیز موجب شد تا
							با ایجاد تمرکز در مدیریت امور مربوطه به شرکت‌های زیر مجموعه،
							امکان برنامه‌ریزی استراتژیک برای سرمایه گذاران فراهم گردد
							و همچنین زمینه برای سازمان‌دهی، مدیریت و به اشتراک گذاری
							اعتبار مالی و دانش فنی شرکت‌های تابعه ایجاد شود.
							امکان برنامه‌ریزی استراتژیک برای سرمایه گذاران فراهم گردد
							و همچنین زمینه برای سازمان‌دهی، مدیریت و به اشتراک گذاری
							اعتبار مالی و دانش فنی شرکت‌های تابعه ایجاد شود.


						</p>
					</div>
				</div>


			</div>

		</div>

		<!-- sarmayeh form -->
		<div class="global-main-container container">
			<div class="form-section">
				<form action="#" class="main-form justify-content-center">
					<div class="form-group col-lg-6 col-10">
						<div class="col-12 col-form-input">
							<input type="text" class="form-control" value="نام و نام خانوادگی">
						</div>
					</div>
					<div class="form-group col-lg-6 col-10">
						<div class="col-12 col-form-input">
							<input type="text" class="form-control" value="پست الکترونیکی">
						</div>
					</div>
					<div class="form-group col-lg-6 col-10">
						<div class="col-12 col-form-input">
							<input type="text" class="form-control" value="تلفن همراه">
						</div>
					</div>
					<div class="form-group col-lg-6 col-10">
						<div class="custom-upload-box col-12 col-form-input">
							<span class="custom-upload-icon"><i class="fal fa-paperclip"></i></span>
							<div id="custom_upload" class="btn" onclick="getFile()">بارگذاری</div>
							<div style="height: 0px;width: 0px; overflow:hidden;"><input id="upfile" type="file" value="upload" onchange="sub(this)"></div>
						</div>
					</div>
					<div class="form-group file-button-box col-12 justify-content-lg-start justify-content-center ">
						<button class="btn btn-danger btn-file-save">ارسال فایل</button>
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
    $('input').click(function(){
        $("input").attr("placeholder", "");

    });

</script>
