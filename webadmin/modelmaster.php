<?php

// model_id
// model_name
// model_logo
// model_year
// icon_menu
// thumbnail
// full_image
// youtube_url
// category_id
// status
// m_order

?>
<?php if ($model->Visible) { ?>
<table id="t_model" cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_modelmaster" class="ewTable ewTableSeparate">
	<tbody>
<?php if ($model->model_id->Visible) { // model_id ?>
		<tr id="r_model_id">
			<td class="ewTableHeader"><?php echo $model->model_id->FldCaption() ?></td>
			<td<?php echo $model->model_id->CellAttributes() ?>><span id="el_model_model_id">
<span<?php echo $model->model_id->ViewAttributes() ?>>
<?php echo $model->model_id->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($model->model_name->Visible) { // model_name ?>
		<tr id="r_model_name">
			<td class="ewTableHeader"><?php echo $model->model_name->FldCaption() ?></td>
			<td<?php echo $model->model_name->CellAttributes() ?>><span id="el_model_model_name">
<span<?php echo $model->model_name->ViewAttributes() ?>>
<?php echo $model->model_name->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($model->model_logo->Visible) { // model_logo ?>
		<tr id="r_model_logo">
			<td class="ewTableHeader"><?php echo $model->model_logo->FldCaption() ?></td>
			<td<?php echo $model->model_logo->CellAttributes() ?>><span id="el_model_model_logo">
<span>
<?php if ($model->model_logo->LinkAttributes() <> "") { ?>
<?php if (!empty($model->model_logo->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->model_logo->UploadPath) . $model->model_logo->Upload->DbValue ?>" border="0"<?php echo $model->model_logo->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model->model_logo->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->model_logo->UploadPath) . $model->model_logo->Upload->DbValue ?>" border="0"<?php echo $model->model_logo->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span></td>
		</tr>
<?php } ?>
<?php if ($model->model_year->Visible) { // model_year ?>
		<tr id="r_model_year">
			<td class="ewTableHeader"><?php echo $model->model_year->FldCaption() ?></td>
			<td<?php echo $model->model_year->CellAttributes() ?>><span id="el_model_model_year">
<span<?php echo $model->model_year->ViewAttributes() ?>>
<?php echo $model->model_year->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($model->icon_menu->Visible) { // icon_menu ?>
		<tr id="r_icon_menu">
			<td class="ewTableHeader"><?php echo $model->icon_menu->FldCaption() ?></td>
			<td<?php echo $model->icon_menu->CellAttributes() ?>><span id="el_model_icon_menu">
<span>
<?php if ($model->icon_menu->LinkAttributes() <> "") { ?>
<?php if (!empty($model->icon_menu->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->icon_menu->UploadPath) . $model->icon_menu->Upload->DbValue ?>" border="0"<?php echo $model->icon_menu->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model->icon_menu->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->icon_menu->UploadPath) . $model->icon_menu->Upload->DbValue ?>" border="0"<?php echo $model->icon_menu->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span></td>
		</tr>
<?php } ?>
<?php if ($model->thumbnail->Visible) { // thumbnail ?>
		<tr id="r_thumbnail">
			<td class="ewTableHeader"><?php echo $model->thumbnail->FldCaption() ?></td>
			<td<?php echo $model->thumbnail->CellAttributes() ?>><span id="el_model_thumbnail">
<span>
<?php if ($model->thumbnail->LinkAttributes() <> "") { ?>
<?php if (!empty($model->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->thumbnail->UploadPath) . $model->thumbnail->Upload->DbValue ?>" border="0"<?php echo $model->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->thumbnail->UploadPath) . $model->thumbnail->Upload->DbValue ?>" border="0"<?php echo $model->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span></td>
		</tr>
<?php } ?>
<?php if ($model->full_image->Visible) { // full_image ?>
		<tr id="r_full_image">
			<td class="ewTableHeader"><?php echo $model->full_image->FldCaption() ?></td>
			<td<?php echo $model->full_image->CellAttributes() ?>><span id="el_model_full_image">
<span>
<?php if ($model->full_image->LinkAttributes() <> "") { ?>
<?php if (!empty($model->full_image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->full_image->UploadPath) . $model->full_image->Upload->DbValue ?>" border="0"<?php echo $model->full_image->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model->full_image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->full_image->UploadPath) . $model->full_image->Upload->DbValue ?>" border="0"<?php echo $model->full_image->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span></td>
		</tr>
<?php } ?>
<?php if ($model->youtube_url->Visible) { // youtube_url ?>
		<tr id="r_youtube_url">
			<td class="ewTableHeader"><?php echo $model->youtube_url->FldCaption() ?></td>
			<td<?php echo $model->youtube_url->CellAttributes() ?>><span id="el_model_youtube_url">
<span<?php echo $model->youtube_url->ViewAttributes() ?>>
<?php echo $model->youtube_url->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($model->category_id->Visible) { // category_id ?>
		<tr id="r_category_id">
			<td class="ewTableHeader"><?php echo $model->category_id->FldCaption() ?></td>
			<td<?php echo $model->category_id->CellAttributes() ?>><span id="el_model_category_id">
<span<?php echo $model->category_id->ViewAttributes() ?>>
<?php echo $model->category_id->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($model->status->Visible) { // status ?>
		<tr id="r_status">
			<td class="ewTableHeader"><?php echo $model->status->FldCaption() ?></td>
			<td<?php echo $model->status->CellAttributes() ?>><span id="el_model_status">
<span<?php echo $model->status->ViewAttributes() ?>>
<?php echo $model->status->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
<?php if ($model->m_order->Visible) { // m_order ?>
		<tr id="r_m_order">
			<td class="ewTableHeader"><?php echo $model->m_order->FldCaption() ?></td>
			<td<?php echo $model->m_order->CellAttributes() ?>><span id="el_model_m_order">
<span<?php echo $model->m_order->ViewAttributes() ?>>
<?php echo $model->m_order->ListViewValue() ?></span>
</span></td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
</td></tr></table>
<br>
<?php } ?>
