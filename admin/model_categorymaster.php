<?php

// category_id
// category_name
// c_order
// status

?>
<?php if ($model_category->Visible) { ?>
<div class="ewMasterDiv">
<table id="tbl_model_categorymaster" class="table ewViewTable ewMasterTable ewVertical">
	<tbody>
<?php if ($model_category->category_id->Visible) { // category_id ?>
		<tr id="r_category_id">
			<td class="col-sm-2"><?php echo $model_category->category_id->FldCaption() ?></td>
			<td<?php echo $model_category->category_id->CellAttributes() ?>>
<span id="el_model_category_category_id">
<span<?php echo $model_category->category_id->ViewAttributes() ?>>
<?php echo $model_category->category_id->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($model_category->category_name->Visible) { // category_name ?>
		<tr id="r_category_name">
			<td class="col-sm-2"><?php echo $model_category->category_name->FldCaption() ?></td>
			<td<?php echo $model_category->category_name->CellAttributes() ?>>
<span id="el_model_category_category_name">
<span<?php echo $model_category->category_name->ViewAttributes() ?>>
<?php echo $model_category->category_name->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($model_category->c_order->Visible) { // c_order ?>
		<tr id="r_c_order">
			<td class="col-sm-2"><?php echo $model_category->c_order->FldCaption() ?></td>
			<td<?php echo $model_category->c_order->CellAttributes() ?>>
<span id="el_model_category_c_order">
<span<?php echo $model_category->c_order->ViewAttributes() ?>>
<?php echo $model_category->c_order->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
<?php if ($model_category->status->Visible) { // status ?>
		<tr id="r_status">
			<td class="col-sm-2"><?php echo $model_category->status->FldCaption() ?></td>
			<td<?php echo $model_category->status->CellAttributes() ?>>
<span id="el_model_category_status">
<span<?php echo $model_category->status->ViewAttributes() ?>>
<?php echo $model_category->status->ListViewValue() ?></span>
</span>
</td>
		</tr>
<?php } ?>
	</tbody>
</table>
</div>
<?php } ?>
