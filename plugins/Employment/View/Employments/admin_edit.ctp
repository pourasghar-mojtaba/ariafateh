<?php
echo $this->Form->create('Employment',array('enctype'=>'multipart/form-data'));
echo $this->Html->script('/js/admin/ckeditor415/ckeditor');
?>
<?php
$items = array();
$items['title'] = __d(__EMPLOYMENT_LOCALE,'edit_company');
$items['link'] = array('title'=>__d(__EMPLOYMENT_LOCALE,'company_list'),'url'  =>__SITE_URL.'admin/'.__EMPLOYMENT.'/links/index');
echo $this->element('Admin/add_edit_header', array('items'=>$items) );

?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php

	echo $this->Form->input('id');

	echo  $this->Form->input('title', array(
			'type' => 'text',
			'label'=> __d(__EMPLOYMENT_LOCALE,'title'),
			'class'=> 'form-control',
			'value'=> $this->request->data['Employmenttranslation']['title'],
			'name' => 'data[Employmenttranslation][title]'
		));


	$user_image = '';
		$width      = 200;
		$height     = 200;
		$image      = $this->request->data['Employment']['image'];
		if(fileExistsInPath(__EMPLOYMENT_IMAGE_PATH.$image ) && $image != '' ){
			$user_image = $this->Html->image('/'.__EMPLOYMENT_IMAGE_URL.$image,array('width' =>$width,'height'=>$height,'id'=>'blog_thumb_image_'.$this->request->data['Employment']['id']));
		}
		else
		{
			$user_image = $this->Html->image('/'.__EMPLOYMENT.'/new_blog.png',array('width' =>$width,'height'=>$height,'alt'   =>''));
		}
		echo $user_image;
	echo  $this->Form->input('image', array(
			'type' => 'file',
			'id' => 'company_image',
			'label'=> __d(__EMPLOYMENT_LOCALE,'image'),
			'class'=> 'form-control'
		));
	echo  $this->Form->input('arrangment', array(
			'type' => 'number',
			'label'=> __d(__EMPLOYMENT_LOCALE,'arrangment'),
			'class'=> 'form-control'
		));

	echo  $this->Form->input('status', array(
			'type'   => 'select',
			'options'=> array(1=>__('active'),0=>__('inactive')),
			'label'  => __('status'),
			'default'=>'1',
			'class'  => 'form-control input-sm'
		));
	?>
</div>
<div class="col-md-12">
	<?php
	echo $this->Form->input('detail', array(
		'type' => 'textarea',
		'label' => __d(__EMPLOYMENT_LOCALE, 'detail'),
		'id' => 'detail',
		'class' => 'form-control',
		'value'=>$this->Cms->convert_character_editor($this->request->data['Employmenttranslation']['detail']),
		'name' => 'data[Employmenttranslation][detail]'
	));
	?>
</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items'=>'') );
?>
<script>
    CKEDITOR.replace( 'detail' );
</script>
<?php echo $this->Form->end(); ?>
