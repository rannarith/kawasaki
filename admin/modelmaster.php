<?php

// model_id
// model_name
// price
// model_year
// thumbnail
// category_id
// m_order
// status
// is_feature
// is_available

?>
<?php if ($model->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_modelmaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($model->model_id->Visible) { // model_id ?>
		<tr id="r_model_id">
			<td class="col-sm-2"><?php echo $model->model_id->FldCaption() ?></td>
			<td<?php echo $model->model_id->CellAttributes() ?>>
<span id="el_model_model_id">
<span<?php echo $model->model_id->ViewAttributes() ?>>
<?php echo $model->model_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($model->model_name->Visible) { // model_name ?>
		<tr id="r_model_name">
			<td class="col-sm-2"><?php echo $model->model_name->FldCaption() ?></td>
			<td<?php echo $model->model_name->CellAttributes() ?>>
<span id="el_model_model_name">
<span<?php echo $model->model_name->ViewAttributes() ?>>
<?php echo $model->model_name->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($model->price->Visible) { // price ?>
		<tr id="r_price">
			<td class="col-sm-2"><?php echo $model->price->FldCaption() ?></td>
			<td<?php echo $model->price->CellAttributes() ?>>
<span id="el_model_price">
<span<?php echo $model->price->ViewAttributes() ?>>
<?php echo $model->price->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($model->model_year->Visible) { // model_year ?>
		<tr id="r_model_year">
			<td class="col-sm-2"><?php echo $model->model_year->FldCaption() ?></td>
			<td<?php echo $model->model_year->CellAttributes() ?>>
<span id="el_model_model_year">
<span<?php echo $model->model_year->ViewAttributes() ?>>
<?php echo $model->model_year->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($model->_thumbnail->Visible) { // thumbnail ?>
		<tr id="r__thumbnail">
			<td class="col-sm-2"><?php echo $model->_thumbnail->FldCaption() ?></td>
			<td<?php echo $model->_thumbnail->CellAttributes() ?>>
<span id="el_model__thumbnail">
<span>
<?php echo ew_GetFileViewTag($model->_thumbnail, $model->_thumbnail->ListViewValue()) ?>
</span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($model->category_id->Visible) { // category_id ?>
		<tr id="r_category_id">
			<td class="col-sm-2"><?php echo $model->category_id->FldCaption() ?></td>
			<td<?php echo $model->category_id->CellAttributes() ?>>
<span id="el_model_category_id">
<span<?php echo $model->category_id->ViewAttributes() ?>>
<?php echo $model->category_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($model->m_order->Visible) { // m_order ?>
		<tr id="r_m_order">
			<td class="col-sm-2"><?php echo $model->m_order->FldCaption() ?></td>
			<td<?php echo $model->m_order->CellAttributes() ?>>
<span id="el_model_m_order">
<span<?php echo $model->m_order->ViewAttributes() ?>>
<?php echo $model->m_order->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($model->status->Visible) { // status ?>
		<tr id="r_status">
			<td class="col-sm-2"><?php echo $model->status->FldCaption() ?></td>
			<td<?php echo $model->status->CellAttributes() ?>>
<span id="el_model_status">
<span<?php echo $model->status->ViewAttributes() ?>>
<?php echo $model->status->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($model->is_feature->Visible) { // is_feature ?>
		<tr id="r_is_feature">
			<td class="col-sm-2"><?php echo $model->is_feature->FldCaption() ?></td>
			<td<?php echo $model->is_feature->CellAttributes() ?>>
<span id="el_model_is_feature">
<span<?php echo $model->is_feature->ViewAttributes() ?>>
<?php echo $model->is_feature->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($model->is_available->Visible) { // is_available ?>
		<tr id="r_is_available">
			<td class="col-sm-2"><?php echo $model->is_available->FldCaption() ?></td>
			<td<?php echo $model->is_available->CellAttributes() ?>>
<span id="el_model_is_available">
<span<?php echo $model->is_available->ViewAttributes() ?>>
<?php echo $model->is_available->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
