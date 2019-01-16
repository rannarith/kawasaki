<?php include_once "admin_userinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($model_gallery_grid)) $model_gallery_grid = new cmodel_gallery_grid();

// Page init
$model_gallery_grid->Page_Init();

// Page main
$model_gallery_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$model_gallery_grid->Page_Render();
?>
<?php if ($model_gallery->Export == "") { ?>
<script type="text/javascript">

// Form object
var fmodel_gallerygrid = new ew_Form("fmodel_gallerygrid", "grid");
fmodel_gallerygrid.FormKeyCountName = '<?php echo $model_gallery_grid->FormKeyCountName ?>';

// Validate form
fmodel_gallerygrid.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_model_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model_gallery->model_id->FldCaption(), $model_gallery->model_id->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_image");
			elm = this.GetElements("fn_x" + infix + "_image");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $model_gallery->image->FldCaption(), $model_gallery->image->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_img_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model_gallery->img_order->FldCaption(), $model_gallery->img_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_img_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($model_gallery->img_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model_gallery->status->FldCaption(), $model_gallery->status->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fmodel_gallerygrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "model_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "image", false)) return false;
	if (ew_ValueChanged(fobj, infix, "img_order", false)) return false;
	if (ew_ValueChanged(fobj, infix, "status", false)) return false;
	return true;
}

// Form_CustomValidate event
fmodel_gallerygrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fmodel_gallerygrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fmodel_gallerygrid.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"model"};
fmodel_gallerygrid.Lists["x_model_id"].Data = "<?php echo $model_gallery_grid->model_id->LookupFilterQuery(FALSE, "grid") ?>";
fmodel_gallerygrid.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodel_gallerygrid.Lists["x_status"].Options = <?php echo json_encode($model_gallery_grid->status->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($model_gallery->CurrentAction == "gridadd") {
	if ($model_gallery->CurrentMode == "copy") {
		$bSelectLimit = $model_gallery_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$model_gallery_grid->TotalRecs = $model_gallery->ListRecordCount();
			$model_gallery_grid->Recordset = $model_gallery_grid->LoadRecordset($model_gallery_grid->StartRec-1, $model_gallery_grid->DisplayRecs);
		} else {
			if ($model_gallery_grid->Recordset = $model_gallery_grid->LoadRecordset())
				$model_gallery_grid->TotalRecs = $model_gallery_grid->Recordset->RecordCount();
		}
		$model_gallery_grid->StartRec = 1;
		$model_gallery_grid->DisplayRecs = $model_gallery_grid->TotalRecs;
	} else {
		$model_gallery->CurrentFilter = "0=1";
		$model_gallery_grid->StartRec = 1;
		$model_gallery_grid->DisplayRecs = $model_gallery->GridAddRowCount;
	}
	$model_gallery_grid->TotalRecs = $model_gallery_grid->DisplayRecs;
	$model_gallery_grid->StopRec = $model_gallery_grid->DisplayRecs;
} else {
	$bSelectLimit = $model_gallery_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($model_gallery_grid->TotalRecs <= 0)
			$model_gallery_grid->TotalRecs = $model_gallery->ListRecordCount();
	} else {
		if (!$model_gallery_grid->Recordset && ($model_gallery_grid->Recordset = $model_gallery_grid->LoadRecordset()))
			$model_gallery_grid->TotalRecs = $model_gallery_grid->Recordset->RecordCount();
	}
	$model_gallery_grid->StartRec = 1;
	$model_gallery_grid->DisplayRecs = $model_gallery_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$model_gallery_grid->Recordset = $model_gallery_grid->LoadRecordset($model_gallery_grid->StartRec-1, $model_gallery_grid->DisplayRecs);

	// Set no record found message
	if ($model_gallery->CurrentAction == "" && $model_gallery_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$model_gallery_grid->setWarningMessage(ew_DeniedMsg());
		if ($model_gallery_grid->SearchWhere == "0=101")
			$model_gallery_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$model_gallery_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$model_gallery_grid->RenderOtherOptions();
?>
<?php $model_gallery_grid->ShowPageHeader(); ?>
<?php
$model_gallery_grid->ShowMessage();
?>
<?php if ($model_gallery_grid->TotalRecs > 0 || $model_gallery->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($model_gallery_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> model_gallery">
<div id="fmodel_gallerygrid" class="ewForm ewListForm form-inline">
<?php if ($model_gallery_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($model_gallery_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_model_gallery" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_model_gallerygrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$model_gallery_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$model_gallery_grid->RenderListOptions();

// Render list options (header, left)
$model_gallery_grid->ListOptions->Render("header", "left");
?>
<?php if ($model_gallery->gallery_id->Visible) { // gallery_id ?>
	<?php if ($model_gallery->SortUrl($model_gallery->gallery_id) == "") { ?>
		<th data-name="gallery_id" class="<?php echo $model_gallery->gallery_id->HeaderCellClass() ?>"><div id="elh_model_gallery_gallery_id" class="model_gallery_gallery_id"><div class="ewTableHeaderCaption"><?php echo $model_gallery->gallery_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="gallery_id" class="<?php echo $model_gallery->gallery_id->HeaderCellClass() ?>"><div><div id="elh_model_gallery_gallery_id" class="model_gallery_gallery_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model_gallery->gallery_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model_gallery->gallery_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model_gallery->gallery_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model_gallery->model_id->Visible) { // model_id ?>
	<?php if ($model_gallery->SortUrl($model_gallery->model_id) == "") { ?>
		<th data-name="model_id" class="<?php echo $model_gallery->model_id->HeaderCellClass() ?>"><div id="elh_model_gallery_model_id" class="model_gallery_model_id"><div class="ewTableHeaderCaption"><?php echo $model_gallery->model_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="model_id" class="<?php echo $model_gallery->model_id->HeaderCellClass() ?>"><div><div id="elh_model_gallery_model_id" class="model_gallery_model_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model_gallery->model_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model_gallery->model_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model_gallery->model_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model_gallery->image->Visible) { // image ?>
	<?php if ($model_gallery->SortUrl($model_gallery->image) == "") { ?>
		<th data-name="image" class="<?php echo $model_gallery->image->HeaderCellClass() ?>"><div id="elh_model_gallery_image" class="model_gallery_image"><div class="ewTableHeaderCaption"><?php echo $model_gallery->image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="image" class="<?php echo $model_gallery->image->HeaderCellClass() ?>"><div><div id="elh_model_gallery_image" class="model_gallery_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model_gallery->image->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model_gallery->image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model_gallery->image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model_gallery->img_order->Visible) { // img_order ?>
	<?php if ($model_gallery->SortUrl($model_gallery->img_order) == "") { ?>
		<th data-name="img_order" class="<?php echo $model_gallery->img_order->HeaderCellClass() ?>"><div id="elh_model_gallery_img_order" class="model_gallery_img_order"><div class="ewTableHeaderCaption"><?php echo $model_gallery->img_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="img_order" class="<?php echo $model_gallery->img_order->HeaderCellClass() ?>"><div><div id="elh_model_gallery_img_order" class="model_gallery_img_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model_gallery->img_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model_gallery->img_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model_gallery->img_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model_gallery->status->Visible) { // status ?>
	<?php if ($model_gallery->SortUrl($model_gallery->status) == "") { ?>
		<th data-name="status" class="<?php echo $model_gallery->status->HeaderCellClass() ?>"><div id="elh_model_gallery_status" class="model_gallery_status"><div class="ewTableHeaderCaption"><?php echo $model_gallery->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $model_gallery->status->HeaderCellClass() ?>"><div><div id="elh_model_gallery_status" class="model_gallery_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model_gallery->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model_gallery->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model_gallery->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$model_gallery_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$model_gallery_grid->StartRec = 1;
$model_gallery_grid->StopRec = $model_gallery_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($model_gallery_grid->FormKeyCountName) && ($model_gallery->CurrentAction == "gridadd" || $model_gallery->CurrentAction == "gridedit" || $model_gallery->CurrentAction == "F")) {
		$model_gallery_grid->KeyCount = $objForm->GetValue($model_gallery_grid->FormKeyCountName);
		$model_gallery_grid->StopRec = $model_gallery_grid->StartRec + $model_gallery_grid->KeyCount - 1;
	}
}
$model_gallery_grid->RecCnt = $model_gallery_grid->StartRec - 1;
if ($model_gallery_grid->Recordset && !$model_gallery_grid->Recordset->EOF) {
	$model_gallery_grid->Recordset->MoveFirst();
	$bSelectLimit = $model_gallery_grid->UseSelectLimit;
	if (!$bSelectLimit && $model_gallery_grid->StartRec > 1)
		$model_gallery_grid->Recordset->Move($model_gallery_grid->StartRec - 1);
} elseif (!$model_gallery->AllowAddDeleteRow && $model_gallery_grid->StopRec == 0) {
	$model_gallery_grid->StopRec = $model_gallery->GridAddRowCount;
}

// Initialize aggregate
$model_gallery->RowType = EW_ROWTYPE_AGGREGATEINIT;
$model_gallery->ResetAttrs();
$model_gallery_grid->RenderRow();
if ($model_gallery->CurrentAction == "gridadd")
	$model_gallery_grid->RowIndex = 0;
if ($model_gallery->CurrentAction == "gridedit")
	$model_gallery_grid->RowIndex = 0;
while ($model_gallery_grid->RecCnt < $model_gallery_grid->StopRec) {
	$model_gallery_grid->RecCnt++;
	if (intval($model_gallery_grid->RecCnt) >= intval($model_gallery_grid->StartRec)) {
		$model_gallery_grid->RowCnt++;
		if ($model_gallery->CurrentAction == "gridadd" || $model_gallery->CurrentAction == "gridedit" || $model_gallery->CurrentAction == "F") {
			$model_gallery_grid->RowIndex++;
			$objForm->Index = $model_gallery_grid->RowIndex;
			if ($objForm->HasValue($model_gallery_grid->FormActionName))
				$model_gallery_grid->RowAction = strval($objForm->GetValue($model_gallery_grid->FormActionName));
			elseif ($model_gallery->CurrentAction == "gridadd")
				$model_gallery_grid->RowAction = "insert";
			else
				$model_gallery_grid->RowAction = "";
		}

		// Set up key count
		$model_gallery_grid->KeyCount = $model_gallery_grid->RowIndex;

		// Init row class and style
		$model_gallery->ResetAttrs();
		$model_gallery->CssClass = "";
		if ($model_gallery->CurrentAction == "gridadd") {
			if ($model_gallery->CurrentMode == "copy") {
				$model_gallery_grid->LoadRowValues($model_gallery_grid->Recordset); // Load row values
				$model_gallery_grid->SetRecordKey($model_gallery_grid->RowOldKey, $model_gallery_grid->Recordset); // Set old record key
			} else {
				$model_gallery_grid->LoadRowValues(); // Load default values
				$model_gallery_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$model_gallery_grid->LoadRowValues($model_gallery_grid->Recordset); // Load row values
		}
		$model_gallery->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($model_gallery->CurrentAction == "gridadd") // Grid add
			$model_gallery->RowType = EW_ROWTYPE_ADD; // Render add
		if ($model_gallery->CurrentAction == "gridadd" && $model_gallery->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$model_gallery_grid->RestoreCurrentRowFormValues($model_gallery_grid->RowIndex); // Restore form values
		if ($model_gallery->CurrentAction == "gridedit") { // Grid edit
			if ($model_gallery->EventCancelled) {
				$model_gallery_grid->RestoreCurrentRowFormValues($model_gallery_grid->RowIndex); // Restore form values
			}
			if ($model_gallery_grid->RowAction == "insert")
				$model_gallery->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$model_gallery->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($model_gallery->CurrentAction == "gridedit" && ($model_gallery->RowType == EW_ROWTYPE_EDIT || $model_gallery->RowType == EW_ROWTYPE_ADD) && $model_gallery->EventCancelled) // Update failed
			$model_gallery_grid->RestoreCurrentRowFormValues($model_gallery_grid->RowIndex); // Restore form values
		if ($model_gallery->RowType == EW_ROWTYPE_EDIT) // Edit row
			$model_gallery_grid->EditRowCnt++;
		if ($model_gallery->CurrentAction == "F") // Confirm row
			$model_gallery_grid->RestoreCurrentRowFormValues($model_gallery_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$model_gallery->RowAttrs = array_merge($model_gallery->RowAttrs, array('data-rowindex'=>$model_gallery_grid->RowCnt, 'id'=>'r' . $model_gallery_grid->RowCnt . '_model_gallery', 'data-rowtype'=>$model_gallery->RowType));

		// Render row
		$model_gallery_grid->RenderRow();

		// Render list options
		$model_gallery_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($model_gallery_grid->RowAction <> "delete" && $model_gallery_grid->RowAction <> "insertdelete" && !($model_gallery_grid->RowAction == "insert" && $model_gallery->CurrentAction == "F" && $model_gallery_grid->EmptyRow())) {
?>
	<tr<?php echo $model_gallery->RowAttributes() ?>>
<?php

// Render list options (body, left)
$model_gallery_grid->ListOptions->Render("body", "left", $model_gallery_grid->RowCnt);
?>
	<?php if ($model_gallery->gallery_id->Visible) { // gallery_id ?>
		<td data-name="gallery_id"<?php echo $model_gallery->gallery_id->CellAttributes() ?>>
<?php if ($model_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="model_gallery" data-field="x_gallery_id" name="o<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" id="o<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" value="<?php echo ew_HtmlEncode($model_gallery->gallery_id->OldValue) ?>">
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_gallery_id" class="form-group model_gallery_gallery_id">
<span<?php echo $model_gallery->gallery_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_gallery->gallery_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="model_gallery" data-field="x_gallery_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" id="x<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" value="<?php echo ew_HtmlEncode($model_gallery->gallery_id->CurrentValue) ?>">
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_gallery_id" class="model_gallery_gallery_id">
<span<?php echo $model_gallery->gallery_id->ViewAttributes() ?>>
<?php echo $model_gallery->gallery_id->ListViewValue() ?></span>
</span>
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model_gallery" data-field="x_gallery_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" id="x<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" value="<?php echo ew_HtmlEncode($model_gallery->gallery_id->FormValue) ?>">
<input type="hidden" data-table="model_gallery" data-field="x_gallery_id" name="o<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" id="o<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" value="<?php echo ew_HtmlEncode($model_gallery->gallery_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model_gallery" data-field="x_gallery_id" name="fmodel_gallerygrid$x<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" id="fmodel_gallerygrid$x<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" value="<?php echo ew_HtmlEncode($model_gallery->gallery_id->FormValue) ?>">
<input type="hidden" data-table="model_gallery" data-field="x_gallery_id" name="fmodel_gallerygrid$o<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" id="fmodel_gallerygrid$o<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" value="<?php echo ew_HtmlEncode($model_gallery->gallery_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model_gallery->model_id->Visible) { // model_id ?>
		<td data-name="model_id"<?php echo $model_gallery->model_id->CellAttributes() ?>>
<?php if ($model_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($model_gallery->model_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_model_id" class="form-group model_gallery_model_id">
<span<?php echo $model_gallery->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_gallery->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_model_id" class="form-group model_gallery_model_id">
<select data-table="model_gallery" data-field="x_model_id" data-value-separator="<?php echo $model_gallery->model_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id"<?php echo $model_gallery->model_id->EditAttributes() ?>>
<?php echo $model_gallery->model_id->SelectOptionListHtml("x<?php echo $model_gallery_grid->RowIndex ?>_model_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="model_gallery" data-field="x_model_id" name="o<?php echo $model_gallery_grid->RowIndex ?>_model_id" id="o<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->OldValue) ?>">
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($model_gallery->model_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_model_id" class="form-group model_gallery_model_id">
<span<?php echo $model_gallery->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_gallery->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_model_id" class="form-group model_gallery_model_id">
<select data-table="model_gallery" data-field="x_model_id" data-value-separator="<?php echo $model_gallery->model_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id"<?php echo $model_gallery->model_id->EditAttributes() ?>>
<?php echo $model_gallery->model_id->SelectOptionListHtml("x<?php echo $model_gallery_grid->RowIndex ?>_model_id") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_model_id" class="model_gallery_model_id">
<span<?php echo $model_gallery->model_id->ViewAttributes() ?>>
<?php echo $model_gallery->model_id->ListViewValue() ?></span>
</span>
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model_gallery" data-field="x_model_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->FormValue) ?>">
<input type="hidden" data-table="model_gallery" data-field="x_model_id" name="o<?php echo $model_gallery_grid->RowIndex ?>_model_id" id="o<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model_gallery" data-field="x_model_id" name="fmodel_gallerygrid$x<?php echo $model_gallery_grid->RowIndex ?>_model_id" id="fmodel_gallerygrid$x<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->FormValue) ?>">
<input type="hidden" data-table="model_gallery" data-field="x_model_id" name="fmodel_gallerygrid$o<?php echo $model_gallery_grid->RowIndex ?>_model_id" id="fmodel_gallerygrid$o<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model_gallery->image->Visible) { // image ?>
		<td data-name="image"<?php echo $model_gallery->image->CellAttributes() ?>>
<?php if ($model_gallery_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_model_gallery_image" class="form-group model_gallery_image">
<div id="fd_x<?php echo $model_gallery_grid->RowIndex ?>_image">
<span title="<?php echo $model_gallery->image->FldTitle() ? $model_gallery->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model_gallery->image->ReadOnly || $model_gallery->image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="model_gallery" data-field="x_image" name="x<?php echo $model_gallery_grid->RowIndex ?>_image" id="x<?php echo $model_gallery_grid->RowIndex ?>_image"<?php echo $model_gallery->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fn_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="<?php echo $model_gallery->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fa_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fs_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="150">
<input type="hidden" name="fx_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fx_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="<?php echo $model_gallery->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fm_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="<?php echo $model_gallery->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $model_gallery_grid->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="model_gallery" data-field="x_image" name="o<?php echo $model_gallery_grid->RowIndex ?>_image" id="o<?php echo $model_gallery_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($model_gallery->image->OldValue) ?>">
<?php } elseif ($model_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_image" class="model_gallery_image">
<span>
<?php echo ew_GetFileViewTag($model_gallery->image, $model_gallery->image->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_image" class="form-group model_gallery_image">
<div id="fd_x<?php echo $model_gallery_grid->RowIndex ?>_image">
<span title="<?php echo $model_gallery->image->FldTitle() ? $model_gallery->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model_gallery->image->ReadOnly || $model_gallery->image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="model_gallery" data-field="x_image" name="x<?php echo $model_gallery_grid->RowIndex ?>_image" id="x<?php echo $model_gallery_grid->RowIndex ?>_image"<?php echo $model_gallery->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fn_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="<?php echo $model_gallery->image->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $model_gallery_grid->RowIndex ?>_image"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fa_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fa_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fs_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="150">
<input type="hidden" name="fx_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fx_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="<?php echo $model_gallery->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fm_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="<?php echo $model_gallery->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $model_gallery_grid->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model_gallery->img_order->Visible) { // img_order ?>
		<td data-name="img_order"<?php echo $model_gallery->img_order->CellAttributes() ?>>
<?php if ($model_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_img_order" class="form-group model_gallery_img_order">
<input type="text" data-table="model_gallery" data-field="x_img_order" name="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" size="30" placeholder="<?php echo ew_HtmlEncode($model_gallery->img_order->getPlaceHolder()) ?>" value="<?php echo $model_gallery->img_order->EditValue ?>"<?php echo $model_gallery->img_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="model_gallery" data-field="x_img_order" name="o<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="o<?php echo $model_gallery_grid->RowIndex ?>_img_order" value="<?php echo ew_HtmlEncode($model_gallery->img_order->OldValue) ?>">
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_img_order" class="form-group model_gallery_img_order">
<input type="text" data-table="model_gallery" data-field="x_img_order" name="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" size="30" placeholder="<?php echo ew_HtmlEncode($model_gallery->img_order->getPlaceHolder()) ?>" value="<?php echo $model_gallery->img_order->EditValue ?>"<?php echo $model_gallery->img_order->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_img_order" class="model_gallery_img_order">
<span<?php echo $model_gallery->img_order->ViewAttributes() ?>>
<?php echo $model_gallery->img_order->ListViewValue() ?></span>
</span>
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model_gallery" data-field="x_img_order" name="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" value="<?php echo ew_HtmlEncode($model_gallery->img_order->FormValue) ?>">
<input type="hidden" data-table="model_gallery" data-field="x_img_order" name="o<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="o<?php echo $model_gallery_grid->RowIndex ?>_img_order" value="<?php echo ew_HtmlEncode($model_gallery->img_order->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model_gallery" data-field="x_img_order" name="fmodel_gallerygrid$x<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="fmodel_gallerygrid$x<?php echo $model_gallery_grid->RowIndex ?>_img_order" value="<?php echo ew_HtmlEncode($model_gallery->img_order->FormValue) ?>">
<input type="hidden" data-table="model_gallery" data-field="x_img_order" name="fmodel_gallerygrid$o<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="fmodel_gallerygrid$o<?php echo $model_gallery_grid->RowIndex ?>_img_order" value="<?php echo ew_HtmlEncode($model_gallery->img_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model_gallery->status->Visible) { // status ?>
		<td data-name="status"<?php echo $model_gallery->status->CellAttributes() ?>>
<?php if ($model_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_status" class="form-group model_gallery_status">
<select data-table="model_gallery" data-field="x_status" data-value-separator="<?php echo $model_gallery->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_gallery_grid->RowIndex ?>_status" name="x<?php echo $model_gallery_grid->RowIndex ?>_status"<?php echo $model_gallery->status->EditAttributes() ?>>
<?php echo $model_gallery->status->SelectOptionListHtml("x<?php echo $model_gallery_grid->RowIndex ?>_status") ?>
</select>
</span>
<input type="hidden" data-table="model_gallery" data-field="x_status" name="o<?php echo $model_gallery_grid->RowIndex ?>_status" id="o<?php echo $model_gallery_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model_gallery->status->OldValue) ?>">
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_status" class="form-group model_gallery_status">
<select data-table="model_gallery" data-field="x_status" data-value-separator="<?php echo $model_gallery->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_gallery_grid->RowIndex ?>_status" name="x<?php echo $model_gallery_grid->RowIndex ?>_status"<?php echo $model_gallery->status->EditAttributes() ?>>
<?php echo $model_gallery->status->SelectOptionListHtml("x<?php echo $model_gallery_grid->RowIndex ?>_status") ?>
</select>
</span>
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_status" class="model_gallery_status">
<span<?php echo $model_gallery->status->ViewAttributes() ?>>
<?php echo $model_gallery->status->ListViewValue() ?></span>
</span>
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model_gallery" data-field="x_status" name="x<?php echo $model_gallery_grid->RowIndex ?>_status" id="x<?php echo $model_gallery_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model_gallery->status->FormValue) ?>">
<input type="hidden" data-table="model_gallery" data-field="x_status" name="o<?php echo $model_gallery_grid->RowIndex ?>_status" id="o<?php echo $model_gallery_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model_gallery->status->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model_gallery" data-field="x_status" name="fmodel_gallerygrid$x<?php echo $model_gallery_grid->RowIndex ?>_status" id="fmodel_gallerygrid$x<?php echo $model_gallery_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model_gallery->status->FormValue) ?>">
<input type="hidden" data-table="model_gallery" data-field="x_status" name="fmodel_gallerygrid$o<?php echo $model_gallery_grid->RowIndex ?>_status" id="fmodel_gallerygrid$o<?php echo $model_gallery_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model_gallery->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$model_gallery_grid->ListOptions->Render("body", "right", $model_gallery_grid->RowCnt);
?>
	</tr>
<?php if ($model_gallery->RowType == EW_ROWTYPE_ADD || $model_gallery->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fmodel_gallerygrid.UpdateOpts(<?php echo $model_gallery_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($model_gallery->CurrentAction <> "gridadd" || $model_gallery->CurrentMode == "copy")
		if (!$model_gallery_grid->Recordset->EOF) $model_gallery_grid->Recordset->MoveNext();
}
?>
<?php
	if ($model_gallery->CurrentMode == "add" || $model_gallery->CurrentMode == "copy" || $model_gallery->CurrentMode == "edit") {
		$model_gallery_grid->RowIndex = '$rowindex$';
		$model_gallery_grid->LoadRowValues();

		// Set row properties
		$model_gallery->ResetAttrs();
		$model_gallery->RowAttrs = array_merge($model_gallery->RowAttrs, array('data-rowindex'=>$model_gallery_grid->RowIndex, 'id'=>'r0_model_gallery', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($model_gallery->RowAttrs["class"], "ewTemplate");
		$model_gallery->RowType = EW_ROWTYPE_ADD;

		// Render row
		$model_gallery_grid->RenderRow();

		// Render list options
		$model_gallery_grid->RenderListOptions();
		$model_gallery_grid->StartRowCnt = 0;
?>
	<tr<?php echo $model_gallery->RowAttributes() ?>>
<?php

// Render list options (body, left)
$model_gallery_grid->ListOptions->Render("body", "left", $model_gallery_grid->RowIndex);
?>
	<?php if ($model_gallery->gallery_id->Visible) { // gallery_id ?>
		<td data-name="gallery_id">
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_model_gallery_gallery_id" class="form-group model_gallery_gallery_id">
<span<?php echo $model_gallery->gallery_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_gallery->gallery_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model_gallery" data-field="x_gallery_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" id="x<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" value="<?php echo ew_HtmlEncode($model_gallery->gallery_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model_gallery" data-field="x_gallery_id" name="o<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" id="o<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" value="<?php echo ew_HtmlEncode($model_gallery->gallery_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model_gallery->model_id->Visible) { // model_id ?>
		<td data-name="model_id">
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<?php if ($model_gallery->model_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_model_gallery_model_id" class="form-group model_gallery_model_id">
<span<?php echo $model_gallery->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_gallery->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_model_gallery_model_id" class="form-group model_gallery_model_id">
<select data-table="model_gallery" data-field="x_model_id" data-value-separator="<?php echo $model_gallery->model_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id"<?php echo $model_gallery->model_id->EditAttributes() ?>>
<?php echo $model_gallery->model_id->SelectOptionListHtml("x<?php echo $model_gallery_grid->RowIndex ?>_model_id") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_model_gallery_model_id" class="form-group model_gallery_model_id">
<span<?php echo $model_gallery->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_gallery->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model_gallery" data-field="x_model_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model_gallery" data-field="x_model_id" name="o<?php echo $model_gallery_grid->RowIndex ?>_model_id" id="o<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model_gallery->image->Visible) { // image ?>
		<td data-name="image">
<span id="el$rowindex$_model_gallery_image" class="form-group model_gallery_image">
<div id="fd_x<?php echo $model_gallery_grid->RowIndex ?>_image">
<span title="<?php echo $model_gallery->image->FldTitle() ? $model_gallery->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model_gallery->image->ReadOnly || $model_gallery->image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="model_gallery" data-field="x_image" name="x<?php echo $model_gallery_grid->RowIndex ?>_image" id="x<?php echo $model_gallery_grid->RowIndex ?>_image"<?php echo $model_gallery->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fn_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="<?php echo $model_gallery->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fa_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fs_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="150">
<input type="hidden" name="fx_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fx_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="<?php echo $model_gallery->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $model_gallery_grid->RowIndex ?>_image" id= "fm_x<?php echo $model_gallery_grid->RowIndex ?>_image" value="<?php echo $model_gallery->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $model_gallery_grid->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="model_gallery" data-field="x_image" name="o<?php echo $model_gallery_grid->RowIndex ?>_image" id="o<?php echo $model_gallery_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($model_gallery->image->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model_gallery->img_order->Visible) { // img_order ?>
		<td data-name="img_order">
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<span id="el$rowindex$_model_gallery_img_order" class="form-group model_gallery_img_order">
<input type="text" data-table="model_gallery" data-field="x_img_order" name="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" size="30" placeholder="<?php echo ew_HtmlEncode($model_gallery->img_order->getPlaceHolder()) ?>" value="<?php echo $model_gallery->img_order->EditValue ?>"<?php echo $model_gallery->img_order->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_model_gallery_img_order" class="form-group model_gallery_img_order">
<span<?php echo $model_gallery->img_order->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_gallery->img_order->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model_gallery" data-field="x_img_order" name="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" value="<?php echo ew_HtmlEncode($model_gallery->img_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model_gallery" data-field="x_img_order" name="o<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="o<?php echo $model_gallery_grid->RowIndex ?>_img_order" value="<?php echo ew_HtmlEncode($model_gallery->img_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model_gallery->status->Visible) { // status ?>
		<td data-name="status">
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<span id="el$rowindex$_model_gallery_status" class="form-group model_gallery_status">
<select data-table="model_gallery" data-field="x_status" data-value-separator="<?php echo $model_gallery->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_gallery_grid->RowIndex ?>_status" name="x<?php echo $model_gallery_grid->RowIndex ?>_status"<?php echo $model_gallery->status->EditAttributes() ?>>
<?php echo $model_gallery->status->SelectOptionListHtml("x<?php echo $model_gallery_grid->RowIndex ?>_status") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_model_gallery_status" class="form-group model_gallery_status">
<span<?php echo $model_gallery->status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_gallery->status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model_gallery" data-field="x_status" name="x<?php echo $model_gallery_grid->RowIndex ?>_status" id="x<?php echo $model_gallery_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model_gallery->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model_gallery" data-field="x_status" name="o<?php echo $model_gallery_grid->RowIndex ?>_status" id="o<?php echo $model_gallery_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model_gallery->status->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$model_gallery_grid->ListOptions->Render("body", "right", $model_gallery_grid->RowIndex);
?>
<script type="text/javascript">
fmodel_gallerygrid.UpdateOpts(<?php echo $model_gallery_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($model_gallery->CurrentMode == "add" || $model_gallery->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $model_gallery_grid->FormKeyCountName ?>" id="<?php echo $model_gallery_grid->FormKeyCountName ?>" value="<?php echo $model_gallery_grid->KeyCount ?>">
<?php echo $model_gallery_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($model_gallery->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $model_gallery_grid->FormKeyCountName ?>" id="<?php echo $model_gallery_grid->FormKeyCountName ?>" value="<?php echo $model_gallery_grid->KeyCount ?>">
<?php echo $model_gallery_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($model_gallery->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmodel_gallerygrid">
</div>
<?php

// Close recordset
if ($model_gallery_grid->Recordset)
	$model_gallery_grid->Recordset->Close();
?>
<?php if ($model_gallery_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($model_gallery_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($model_gallery_grid->TotalRecs == 0 && $model_gallery->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($model_gallery_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($model_gallery->Export == "") { ?>
<script type="text/javascript">
fmodel_gallerygrid.Init();
</script>
<?php } ?>
<?php
$model_gallery_grid->Page_Terminate();
?>
