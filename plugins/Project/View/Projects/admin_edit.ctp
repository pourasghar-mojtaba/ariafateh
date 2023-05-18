<?php
echo $this->Html->css('/' . __PROJECT . '/css/addrow');
echo $this->Html->script('/js/admin/ckeditor415/ckeditor');

echo $this->Form->create('Project', array('enctype' => 'multipart/form-data'));
?>
<?php
$items = array();
$items['title'] = __d(__PROJECT_LOCALE, 'edit_project');
$items['link'] = array('title' => __d(__PROJECT_LOCALE, 'project_list'), 'url' => __SITE_URL . 'admin/' . __PROJECT . '/projects/index');
echo $this->element('Admin/add_edit_header', array('items' => $items));
$category_list = $this->Project->categoryToList($projectcategories);
?>
<div class="col-md-6">
</div>
<div class="col-md-6">
	<?php

	echo $this->Form->input('id');
	echo $this->Form->input('project_category_id', array(
		'type' => 'select',
		'options' => $category_list,
		'default' => $this->request->data['Project']['project_category_id'],
		'label' => __d(__PROJECT_LOCALE, 'parent'),
		'class' => 'form-control input-sm'
	));
	echo $this->Form->input('company_id', array(
		'type' => 'select',
		'options' => $companies,
		'label' => __d(__PROJECT_LOCALE, 'company'),
		'class' => 'form-control input-sm',
		'value' => $this->request->data['Project']['company_id']
	));

	echo $this->Form->input('title', array(
		'type' => 'text',
		'label' => __d(__PROJECT_LOCALE, 'title'),
		'class' => 'form-control',
		'name' => 'data[Projecttranslation][title]',
		'value' => $this->request->data['Projecttranslation']['title']
	));
	echo $this->Form->input('slug', array(
		'type' => 'text',
		'label' => __d(__PROJECT_LOCALE, 'slug'),
		'class' => 'form-control',
		'dir' => 'ltr'
	));
	echo $this->Form->input('mini_detail', array(
		'type' => 'textarea',
		'id' => 'mini_detail',
		'label' => __d(__PROJECT_LOCALE, 'mini_detail'),
		'class' => 'form-control',
		'name' => 'data[Projecttranslation][mini_detail]',
		'value' => $this->request->data['Projecttranslation']['mini_detail']
	));
	echo $this->Form->input('detail', array(
		'type' => 'textarea',
		'label' => __d(__PROJECT_LOCALE, 'detail'),
		'id' => 'detail',
		'class' => 'form-control',
		'value' => $this->Cms->convert_character_editor($this->request->data['Projecttranslation']['detail']),
		'class' => 'form-control',
		'name' => 'data[Projecttranslation][detail]'
	));
	echo $this->Form->input('video', array(
		'type' => 'file',
		'label' => __d(__PROJECT_LOCALE, 'video'),
		'class' => 'form-control'
	));
	if (!empty($this->request->data['Project']['video'])) {
		?>
		<video id="video" controls="controls" style="width:200px;height: 200px">
			<source
				src="<?php echo __SITE_URL . __PROJECT; ?>/uploads/<?php echo $this->request->data['Project']['video']; ?>">
		</video>&nbsp;&nbsp;
		<a style="color: #9f191f"
		   href="<?php echo __SITE_URL . 'admin/project/projects/deletevideo/' . $this->request->data['Project']['id']; ?>">
			<?php echo __d(__PROJECT_LOCALE, 'delete_video'); ?>
		</a>
		<?php
	}
	?>
	<div style="clear: both"></div>
	<tr>
		<td colspan="5">
			<label class="control-label" for="focusedInput">
				<?php echo __d(__PROJECT_LOCALE, 'project_images') ?> :
			</label>
			<table id="expense_table" class="expense_table" cellspacing="0" cellpadding="0" width="500">
				<thead>
				<tr>
					<th>
						<?php echo __d(__PROJECT_LOCALE, 'image'); ?>
					</th>
					<th>
						<?php echo __d(__PROJECT_LOCALE, 'title'); ?>
					</th>
					<th>
						&nbsp;
					</th>
				</tr>
				</thead>
				<tbody>
				<?php
				if (!empty($projectimages)) {
					foreach ($projectimages as $projectimage) {
						echo "
							<tr>
							<td>
							<input type='file' class='form-control' name='data[Projectimage][image][]' id='image_no_01' maxlength='255'  />
							</td>
							<td>
							<input type='text' class='form-control' name='data[Projectimage][title][]' id='title_no_01'
							maxlength='255' value='" . $projectimage['Projectimagetranslation']['title'] . "' />
							</td>";
						if (fileExistsInPath(__PROJECT_IMAGE_PATH . $projectimage['Projectimage']['image']) && $projectimage['Projectimage']['image'] != '') {
							echo "<td><a target='_blank' href= '" . __SITE_URL . __PROJECT_IMAGE_URL . $projectimage['Projectimage']['image'] . "' >";
							echo $this->Html->image('/' . __PROJECT_IMAGE_URL . $projectimage['Projectimage']['image'], array('id' => 'image_img', 'height' => 100));
							echo "</a></td>";
						}


						echo "<td><input type='button' value='Delete' class='del_ExpenseRow' /></td>";
						echo "<input type='hidden' value='" . $projectimage['Projectimage']['id'] . "' name='data[Projectimage][id][]'>";
						echo "<input type='hidden' value='" . $projectimage['Projectimage']['image'] . "' name='data[Projectimage][old_image][]'>";

						echo "</tr>";
					}
				} else {
					echo "
						<tr>
						<td>
						<input type='file' name='data[Projectimage][image][]' id='image_no_01' maxlength='255'  />
						</td>
						<td>
						<input type='text' name='data[Projectimage][title][]' id='title_no_01' maxlength='255'  />
						</td>
						<td>&nbsp;</td>
						</tr>
						";
				}

				?>

				</tbody>
			</table>

			<input type="button" value="<?php echo __d(__PROJECT_LOCALE, 'add_image'); ?>" id="add_ExpenseRow"/>
		</td>
	</tr>
	<?php
	echo $this->Form->input('status', array(
		'type' => 'select',
		'options' => array(1 => __('active'), 0 => __('inactive')),
		'label' => __('status'),
		'default' => '1',
		'class' => 'form-control input-sm'
	));
	?>
</div>

<?php
echo $this->element('Admin/add_edit_footer', array('items' => ''));
?>
<?php echo $this->Form->end(); ?>
<script>
    $(function () {
        // GET ID OF last row and increment it by one
        var $lastChar = 1, $newRow;
        $get_lastID = function () {
            var $id = $('.expense_table tr:last-child td:first-child input').attr("id");
            $lastChar = parseInt($id.substr($id.length - 2), 10);
            console.log('GET id: ' + $lastChar + ' | $id :' + $id);
            $lastChar = $lastChar + 1;
            $newRow = "<tr> \
				<td><input type='file' name='data[Projectimage][image][]' class='form-control' id='image_no_0" + $lastChar + "' maxlength='255' /></td> \<td><input type='text' class='form-control' name='data[Projectimage][title][]' id='title_no_0" + $lastChar + "' maxlength='255' /></td> \<td><input type='button' value='Delete' class='del_ExpenseRow' /></td> \
				</tr>"
            return $newRow;
        }

        // ***** -- START ADDING NEW ROWS
        $('#add_ExpenseRow').click(function () {
            //if($lastChar <= 9){
            $get_lastID();
            $('.expense_table tbody').append($newRow);
            /*} else {
			alert("Reached Maximum Rows!");
			};*/
        });

        $("body").on("click", '.del_ExpenseRow', function () {
            $(this).closest('tr').remove();
            $lastChar = $lastChar - 2;
        });
    });


    CKEDITOR.replace('detail', {
        extraPlugins: 'html5video,html5audio'
    });

    CKEDITOR.replace('mini_detail', {
        extraPlugins: 'html5video,html5audio'
    });

</script>
