<?php

echo $this->Form->create('Investment', array('enctype' => 'multipart/form-data'));
echo $this->Html->script('/js/admin/ckeditor415/ckeditor');
?>
<?php
$items = array();
$items['title'] = __d(__INVESTMENT_LOCALE, 'add_investment');
$items['link'] = array('title' => __d(__INVESTMENT_LOCALE, 'investment_list'), 'url' => __SITE_URL . 'admin/product/links/index');
echo $this->element('Admin/add_edit_header', array('items' => $items));

?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php


	echo $this->Form->input('title', array(
		'type' => 'text',
		'label' => __d(__INVESTMENT_LOCALE, 'title'),
		'class' => 'form-control',
		'name' => 'data[Investmenttranslation][title]'
	));

	echo $this->Form->input('image', array(
		'type' => 'file',
		'id' => 'investment_image',
		'label' => __d(__INVESTMENT_LOCALE, 'image'),
		'class' => 'form-control'
	));
	echo $this->Form->input('arrangment', array(
		'type' => 'number',
		'label' => __d(__INVESTMENT_LOCALE, 'arrangment'),
		'class' => 'form-control'
	));

	echo $this->Form->input('status', array(
		'type' => 'select',
		'options' => array(1 => __('active'), 0 => __('inactive')),
		'label' => __('status'),
		'default' => '1',
		'class' => 'form-control input-sm'
	));
	?>
</div>
<div class="col-md-12">
	<?php
	echo $this->Form->input('detail', array(
		'type' => 'textarea',
		'label' => __d(__INVESTMENT_LOCALE, 'detail'),
		'id' => 'detail',
		'class' => 'form-control',
		'name' => 'data[Investmenttranslation][detail]'
	));
	?>
</div>


<?php
echo $this->element('Admin/add_edit_footer', array('items' => ''));
?>
<script>
    CKEDITOR.replace('detail');
</script>
<?php echo $this->Form->end(); ?>
