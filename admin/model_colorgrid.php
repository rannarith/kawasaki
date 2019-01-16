<?php include_once "admin_userinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($model_color_grid)) $model_color_grid = new cmodel_color_grid();

// Page init
$model_color_grid->Page_Init();

// Page main
$model_color_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$model_color_grid->Page_Render();
?>
<?php if ($model_color->Export == "") { ?>
<script type="text/javascript">

// Form object
var fmodel_colorgrid = new ew_Form("fmodel_colorgrid", "grid");
fmodel_colorgrid.FormKeyCountName = '<?php echo $model_color_grid->FormKeyCountName ?>';

// Validate form
fmodel_colorgrid.Validate = function() {
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
			felm = this.GetElements("x" + infix + "_image");
			elm = this.GetElements("fn_x" + infix + "_image");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $model_color->image->FldCaption(), $model_color->image->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_model_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model_color->model_id->FldCaption(), $model_color->model_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_color_code");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model_color->color_code->FldCaption(), $model_color->color_code->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_m_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model_color->m_order->FldCaption(), $model_color->m_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_m_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($model_color->m_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_m_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model_color->m_status->FldCaption(), $model_color->m_status->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fmodel_colorgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "image", false)) return false;
	if (ew_ValueChanged(fobj, infix, "model_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "color_code", false)) return false;
	if (ew_ValueChanged(fobj, infix, "m_order", false)) return false;
	if (ew_ValueChanged(fobj, infix, "m_status", false)) return false;
	return true;
}

// Form_CustomValidate event
fmodel_colorgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fmodel_colorgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fmodel_colorgrid.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"model"};
fmodel_colorgrid.Lists["x_model_id"].Data = "<?php echo $model_color_grid->model_id->LookupFilterQuery(FALSE, "grid") ?>";
fmodel_colorgrid.Lists["x_m_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodel_colorgrid.Lists["x_m_status"].Options = <?php echo json_encode($model_color_grid->m_status->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($model_color->CurrentAction == "gridadd") {
	if ($model_color->CurrentMode == "copy") {
		$bSelectLimit = $model_color_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$model_color_grid->TotalRecs = $model_color->ListRecordCount();
			$model_color_grid->Recordset = $model_color_grid->LoadRecordset($model_color_grid->StartRec-1, $model_color_grid->DisplayRecs);
		} else {
			if ($model_color_grid->Recordset = $model_color_grid->LoadRecordset())
				$model_color_grid->TotalRecs = $model_color_grid->Recordset->RecordCount();
		}
		$model_color_grid->StartRec = 1;
		$model_color_grid->DisplayRecs = $model_color_grid->TotalRecs;
	} else {
		$model_color->CurrentFilter = "0=1";
		$model_color_grid->StartRec = 1;
		$model_color_grid->DisplayRecs = $model_color->GridAddRowCount;
	}
	$model_color_grid->TotalRecs = $model_color_grid->DisplayRecs;
	$model_color_grid->StopRec = $model_color_grid->DisplayRecs;
} else {
	$bSelectLimit = $model_color_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($model_color_grid->TotalRecs <= 0)
			$model_color_grid->TotalRecs = $model_color->ListRecordCount();
	} else {
		if (!$model_color_grid->Recordset && ($model_color_grid->Recordset = $model_color_grid->LoadRecordset()))
			$model_color_grid->TotalRecs = $model_color_grid->Recordset->RecordCount();
	}
	$model_color_grid->StartRec = 1;
	$model_color_grid->DisplayRecs = $model_color_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$model_color_grid->Recordset = $model_color_grid->LoadRecordset($model_color_grid->StartRec-1, $model_color_grid->DisplayRecs);

	// Set no record found message
	if ($model_color->CurrentAction == "" && $model_color_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$model_color_grid->setWarningMessage(ew_DeniedMsg());
		if ($model_color_grid->SearchWhere == "0=101")
			$model_color_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$model_color_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$model_color_grid->RenderOtherOptions();
?>
<?php $model_color_grid->ShowPageHeader(); ?>
<?php
$model_color_grid->ShowMessage();
?>
<?php if ($model_color_grid->TotalRecs > 0 || $model_color->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($model_color_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> model_color">
<div id="fmodel_colorgrid" class="ewForm ewListForm form-inline">
<?php if ($model_color_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($model_color_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_model_color" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_model_colorgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$model_color_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$model_color_grid->RenderListOptions();

// Render list options (header, left)
$model_color_grid->ListOptions->Render("header", "left");
?>
<?php if ($model_color->mc_id->Visible) { // mc_id ?>
	<?php if ($model_color->SortUrl($model_color->mc_id) == "") { ?>
		<th data-name="mc_id" class="<?php echo $model_color->mc_id->HeaderCellClass() ?>"><div id="elh_model_color_mc_id" class="model_color_mc_id"><div class="ewTableHeaderCaption"><?php echo $model_color->mc_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="mc_id" class="<?php echo $model_color->mc_id->HeaderCellClass() ?>"><div><div id="elh_model_color_mc_id" class="model_color_mc_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model_color->mc_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model_color->mc_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model_color->mc_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model_color->image->Visible) { // image ?>
	<?php if ($model_color->SortUrl($model_color->image) == "") { ?>
		<th data-name="image" class="<?php echo $model_color->image->HeaderCellClass() ?>"><div id="elh_model_color_image" class="model_color_image"><div class="ewTableHeaderCaption"><?php echo $model_color->image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="image" class="<?php echo $model_color->image->HeaderCellClass() ?>"><div><div id="elh_model_color_image" class="model_color_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model_color->image->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model_color->image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model_color->image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model_color->model_id->Visible) { // model_id ?>
	<?php if ($model_color->SortUrl($model_color->model_id) == "") { ?>
		<th data-name="model_id" class="<?php echo $model_color->model_id->HeaderCellClass() ?>"><div id="elh_model_color_model_id" class="model_color_model_id"><div class="ewTableHeaderCaption"><?php echo $model_color->model_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="model_id" class="<?php echo $model_color->model_id->HeaderCellClass() ?>"><div><div id="elh_model_color_model_id" class="model_color_model_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model_color->model_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model_color->model_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model_color->model_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model_color->color_code->Visible) { // color_code ?>
	<?php if ($model_color->SortUrl($model_color->color_code) == "") { ?>
		<th data-name="color_code" class="<?php echo $model_color->color_code->HeaderCellClass() ?>"><div id="elh_model_color_color_code" class="model_color_color_code"><div class="ewTableHeaderCaption"><?php echo $model_color->color_code->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="color_code" class="<?php echo $model_color->color_code->HeaderCellClass() ?>"><div><div id="elh_model_color_color_code" class="model_color_color_code">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model_color->color_code->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model_color->color_code->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model_color->color_code->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model_color->m_order->Visible) { // m_order ?>
	<?php if ($model_color->SortUrl($model_color->m_order) == "") { ?>
		<th data-name="m_order" class="<?php echo $model_color->m_order->HeaderCellClass() ?>"><div id="elh_model_color_m_order" class="model_color_m_order"><div class="ewTableHeaderCaption"><?php echo $model_color->m_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="m_order" class="<?php echo $model_color->m_order->HeaderCellClass() ?>"><div><div id="elh_model_color_m_order" class="model_color_m_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model_color->m_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model_color->m_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model_color->m_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model_color->m_status->Visible) { // m_status ?>
	<?php if ($model_color->SortUrl($model_color->m_status) == "") { ?>
		<th data-name="m_status" class="<?php echo $model_color->m_status->HeaderCellClass() ?>"><div id="elh_model_color_m_status" class="model_color_m_status"><div class="ewTableHeaderCaption"><?php echo $model_color->m_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="m_status" class="<?php echo $model_color->m_status->HeaderCellClass() ?>"><div><div id="elh_model_color_m_status" class="model_color_m_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model_color->m_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model_color->m_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model_color->m_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$model_color_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$model_color_grid->StartRec = 1;
$model_color_grid->StopRec = $model_color_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($model_color_grid->FormKeyCountName) && ($model_color->CurrentAction == "gridadd" || $model_color->CurrentAction == "gridedit" || $model_color->CurrentAction == "F")) {
		$model_color_grid->KeyCount = $objForm->GetValue($model_color_grid->FormKeyCountName);
		$model_color_grid->StopRec = $model_color_grid->StartRec + $model_color_grid->KeyCount - 1;
	}
}
$model_color_grid->RecCnt = $model_color_grid->StartRec - 1;
if ($model_color_grid->Recordset && !$model_color_grid->Recordset->EOF) {
	$model_color_grid->Recordset->MoveFirst();
	$bSelectLimit = $model_color_grid->UseSelectLimit;
	if (!$bSelectLimit && $model_color_grid->StartRec > 1)
		$model_color_grid->Recordset->Move($model_color_grid->StartRec - 1);
} elseif (!$model_color->AllowAddDeleteRow && $model_color_grid->StopRec == 0) {
	$model_color_grid->StopRec = $model_color->GridAddRowCount;
}

// Initialize aggregate
$model_color->RowType = EW_ROWTYPE_AGGREGATEINIT;
$model_color->ResetAttrs();
$model_color_grid->RenderRow();
if ($model_color->CurrentAction == "gridadd")
	$model_color_grid->RowIndex = 0;
if ($model_color->CurrentAction == "gridedit")
	$model_color_grid->RowIndex = 0;
while ($model_color_grid->RecCnt < $model_color_grid->StopRec) {
	$model_color_grid->RecCnt++;
	if (intval($model_color_grid->RecCnt) >= intval($model_color_grid->StartRec)) {
		$model_color_grid->RowCnt++;
		if ($model_color->CurrentAction == "gridadd" || $model_color->CurrentAction == "gridedit" || $model_color->CurrentAction == "F") {
			$model_color_grid->RowIndex++;
			$objForm->Index = $model_color_grid->RowIndex;
			if ($objForm->HasValue($model_color_grid->FormActionName))
				$model_color_grid->RowAction = strval($objForm->GetValue($model_color_grid->FormActionName));
			elseif ($model_color->CurrentAction == "gridadd")
				$model_color_grid->RowAction = "insert";
			else
				$model_color_grid->RowAction = "";
		}

		// Set up key count
		$model_color_grid->KeyCount = $model_color_grid->RowIndex;

		// Init row class and style
		$model_color->ResetAttrs();
		$model_color->CssClass = "";
		if ($model_color->CurrentAction == "gridadd") {
			if ($model_color->CurrentMode == "copy") {
				$model_color_grid->LoadRowValues($model_color_grid->Recordset); // Load row values
				$model_color_grid->SetRecordKey($model_color_grid->RowOldKey, $model_color_grid->Recordset); // Set old record key
			} else {
				$model_color_grid->LoadRowValues(); // Load default values
				$model_color_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$model_color_grid->LoadRowValues($model_color_grid->Recordset); // Load row values
		}
		$model_color->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($model_color->CurrentAction == "gridadd") // Grid add
			$model_color->RowType = EW_ROWTYPE_ADD; // Render add
		if ($model_color->CurrentAction == "gridadd" && $model_color->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$model_color_grid->RestoreCurrentRowFormValues($model_color_grid->RowIndex); // Restore form values
		if ($model_color->CurrentAction == "gridedit") { // Grid edit
			if ($model_color->EventCancelled) {
				$model_color_grid->RestoreCurrentRowFormValues($model_color_grid->RowIndex); // Restore form values
			}
			if ($model_color_grid->RowAction == "insert")
				$model_color->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$model_color->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($model_color->CurrentAction == "gridedit" && ($model_color->RowType == EW_ROWTYPE_EDIT || $model_color->RowType == EW_ROWTYPE_ADD) && $model_color->EventCancelled) // Update failed
			$model_color_grid->RestoreCurrentRowFormValues($model_color_grid->RowIndex); // Restore form values
		if ($model_color->RowType == EW_ROWTYPE_EDIT) // Edit row
			$model_color_grid->EditRowCnt++;
		if ($model_color->CurrentAction == "F") // Confirm row
			$model_color_grid->RestoreCurrentRowFormValues($model_color_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$model_color->RowAttrs = array_merge($model_color->RowAttrs, array('data-rowindex'=>$model_color_grid->RowCnt, 'id'=>'r' . $model_color_grid->RowCnt . '_model_color', 'data-rowtype'=>$model_color->RowType));

		// Render row
		$model_color_grid->RenderRow();

		// Render list options
		$model_color_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($model_color_grid->RowAction <> "delete" && $model_color_grid->RowAction <> "insertdelete" && !($model_color_grid->RowAction == "insert" && $model_color->CurrentAction == "F" && $model_color_grid->EmptyRow())) {
?>
	<tr<?php echo $model_color->RowAttributes() ?>>
<?php

// Render list options (body, left)
$model_color_grid->ListOptions->Render("body", "left", $model_color_grid->RowCnt);
?>
	<?php if ($model_color->mc_id->Visible) { // mc_id ?>
		<td data-name="mc_id"<?php echo $model_color->mc_id->CellAttributes() ?>>
<?php if ($model_color->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="model_color" data-field="x_mc_id" name="o<?php echo $model_color_grid->RowIndex ?>_mc_id" id="o<?php echo $model_color_grid->RowIndex ?>_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->OldValue) ?>">
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_mc_id" class="form-group model_color_mc_id">
<span<?php echo $model_color->mc_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_color->mc_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="model_color" data-field="x_mc_id" name="x<?php echo $model_color_grid->RowIndex ?>_mc_id" id="x<?php echo $model_color_grid->RowIndex ?>_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->CurrentValue) ?>">
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_mc_id" class="model_color_mc_id">
<span<?php echo $model_color->mc_id->ViewAttributes() ?>>
<?php echo $model_color->mc_id->ListViewValue() ?></span>
</span>
<?php if ($model_color->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model_color" data-field="x_mc_id" name="x<?php echo $model_color_grid->RowIndex ?>_mc_id" id="x<?php echo $model_color_grid->RowIndex ?>_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->FormValue) ?>">
<input type="hidden" data-table="model_color" data-field="x_mc_id" name="o<?php echo $model_color_grid->RowIndex ?>_mc_id" id="o<?php echo $model_color_grid->RowIndex ?>_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model_color" data-field="x_mc_id" name="fmodel_colorgrid$x<?php echo $model_color_grid->RowIndex ?>_mc_id" id="fmodel_colorgrid$x<?php echo $model_color_grid->RowIndex ?>_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->FormValue) ?>">
<input type="hidden" data-table="model_color" data-field="x_mc_id" name="fmodel_colorgrid$o<?php echo $model_color_grid->RowIndex ?>_mc_id" id="fmodel_colorgrid$o<?php echo $model_color_grid->RowIndex ?>_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model_color->image->Visible) { // image ?>
		<td data-name="image"<?php echo $model_color->image->CellAttributes() ?>>
<?php if ($model_color_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_model_color_image" class="form-group model_color_image">
<div id="fd_x<?php echo $model_color_grid->RowIndex ?>_image">
<span title="<?php echo $model_color->image->FldTitle() ? $model_color->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model_color->image->ReadOnly || $model_color->image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="model_color" data-field="x_image" name="x<?php echo $model_color_grid->RowIndex ?>_image" id="x<?php echo $model_color_grid->RowIndex ?>_image"<?php echo $model_color->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fn_x<?php echo $model_color_grid->RowIndex ?>_image" value="<?php echo $model_color->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fa_x<?php echo $model_color_grid->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fs_x<?php echo $model_color_grid->RowIndex ?>_image" value="100">
<input type="hidden" name="fx_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fx_x<?php echo $model_color_grid->RowIndex ?>_image" value="<?php echo $model_color->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fm_x<?php echo $model_color_grid->RowIndex ?>_image" value="<?php echo $model_color->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $model_color_grid->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="model_color" data-field="x_image" name="o<?php echo $model_color_grid->RowIndex ?>_image" id="o<?php echo $model_color_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($model_color->image->OldValue) ?>">
<?php } elseif ($model_color->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_image" class="model_color_image">
<span>
<?php echo ew_GetFileViewTag($model_color->image, $model_color->image->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_image" class="form-group model_color_image">
<div id="fd_x<?php echo $model_color_grid->RowIndex ?>_image">
<span title="<?php echo $model_color->image->FldTitle() ? $model_color->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model_color->image->ReadOnly || $model_color->image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="model_color" data-field="x_image" name="x<?php echo $model_color_grid->RowIndex ?>_image" id="x<?php echo $model_color_grid->RowIndex ?>_image"<?php echo $model_color->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fn_x<?php echo $model_color_grid->RowIndex ?>_image" value="<?php echo $model_color->image->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $model_color_grid->RowIndex ?>_image"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fa_x<?php echo $model_color_grid->RowIndex ?>_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fa_x<?php echo $model_color_grid->RowIndex ?>_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fs_x<?php echo $model_color_grid->RowIndex ?>_image" value="100">
<input type="hidden" name="fx_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fx_x<?php echo $model_color_grid->RowIndex ?>_image" value="<?php echo $model_color->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fm_x<?php echo $model_color_grid->RowIndex ?>_image" value="<?php echo $model_color->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $model_color_grid->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model_color->model_id->Visible) { // model_id ?>
		<td data-name="model_id"<?php echo $model_color->model_id->CellAttributes() ?>>
<?php if ($model_color->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($model_color->model_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_model_id" class="form-group model_color_model_id">
<span<?php echo $model_color->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_color->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $model_color_grid->RowIndex ?>_model_id" name="x<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_model_id" class="form-group model_color_model_id">
<select data-table="model_color" data-field="x_model_id" data-value-separator="<?php echo $model_color->model_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_color_grid->RowIndex ?>_model_id" name="x<?php echo $model_color_grid->RowIndex ?>_model_id"<?php echo $model_color->model_id->EditAttributes() ?>>
<?php echo $model_color->model_id->SelectOptionListHtml("x<?php echo $model_color_grid->RowIndex ?>_model_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="model_color" data-field="x_model_id" name="o<?php echo $model_color_grid->RowIndex ?>_model_id" id="o<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->OldValue) ?>">
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($model_color->model_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_model_id" class="form-group model_color_model_id">
<span<?php echo $model_color->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_color->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $model_color_grid->RowIndex ?>_model_id" name="x<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_model_id" class="form-group model_color_model_id">
<select data-table="model_color" data-field="x_model_id" data-value-separator="<?php echo $model_color->model_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_color_grid->RowIndex ?>_model_id" name="x<?php echo $model_color_grid->RowIndex ?>_model_id"<?php echo $model_color->model_id->EditAttributes() ?>>
<?php echo $model_color->model_id->SelectOptionListHtml("x<?php echo $model_color_grid->RowIndex ?>_model_id") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_model_id" class="model_color_model_id">
<span<?php echo $model_color->model_id->ViewAttributes() ?>>
<?php echo $model_color->model_id->ListViewValue() ?></span>
</span>
<?php if ($model_color->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model_color" data-field="x_model_id" name="x<?php echo $model_color_grid->RowIndex ?>_model_id" id="x<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->FormValue) ?>">
<input type="hidden" data-table="model_color" data-field="x_model_id" name="o<?php echo $model_color_grid->RowIndex ?>_model_id" id="o<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model_color" data-field="x_model_id" name="fmodel_colorgrid$x<?php echo $model_color_grid->RowIndex ?>_model_id" id="fmodel_colorgrid$x<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->FormValue) ?>">
<input type="hidden" data-table="model_color" data-field="x_model_id" name="fmodel_colorgrid$o<?php echo $model_color_grid->RowIndex ?>_model_id" id="fmodel_colorgrid$o<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model_color->color_code->Visible) { // color_code ?>
		<td data-name="color_code"<?php echo $model_color->color_code->CellAttributes() ?>>
<?php if ($model_color->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_color_code" class="form-group model_color_color_code">
<input type="text" data-table="model_color" data-field="x_color_code" name="x<?php echo $model_color_grid->RowIndex ?>_color_code" id="x<?php echo $model_color_grid->RowIndex ?>_color_code" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($model_color->color_code->getPlaceHolder()) ?>" value="<?php echo $model_color->color_code->EditValue ?>"<?php echo $model_color->color_code->EditAttributes() ?>>
</span>
<input type="hidden" data-table="model_color" data-field="x_color_code" name="o<?php echo $model_color_grid->RowIndex ?>_color_code" id="o<?php echo $model_color_grid->RowIndex ?>_color_code" value="<?php echo ew_HtmlEncode($model_color->color_code->OldValue) ?>">
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_color_code" class="form-group model_color_color_code">
<input type="text" data-table="model_color" data-field="x_color_code" name="x<?php echo $model_color_grid->RowIndex ?>_color_code" id="x<?php echo $model_color_grid->RowIndex ?>_color_code" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($model_color->color_code->getPlaceHolder()) ?>" value="<?php echo $model_color->color_code->EditValue ?>"<?php echo $model_color->color_code->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_color_code" class="model_color_color_code">
<span<?php echo $model_color->color_code->ViewAttributes() ?>>
<?php echo $model_color->color_code->ListViewValue() ?></span>
</span>
<?php if ($model_color->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model_color" data-field="x_color_code" name="x<?php echo $model_color_grid->RowIndex ?>_color_code" id="x<?php echo $model_color_grid->RowIndex ?>_color_code" value="<?php echo ew_HtmlEncode($model_color->color_code->FormValue) ?>">
<input type="hidden" data-table="model_color" data-field="x_color_code" name="o<?php echo $model_color_grid->RowIndex ?>_color_code" id="o<?php echo $model_color_grid->RowIndex ?>_color_code" value="<?php echo ew_HtmlEncode($model_color->color_code->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model_color" data-field="x_color_code" name="fmodel_colorgrid$x<?php echo $model_color_grid->RowIndex ?>_color_code" id="fmodel_colorgrid$x<?php echo $model_color_grid->RowIndex ?>_color_code" value="<?php echo ew_HtmlEncode($model_color->color_code->FormValue) ?>">
<input type="hidden" data-table="model_color" data-field="x_color_code" name="fmodel_colorgrid$o<?php echo $model_color_grid->RowIndex ?>_color_code" id="fmodel_colorgrid$o<?php echo $model_color_grid->RowIndex ?>_color_code" value="<?php echo ew_HtmlEncode($model_color->color_code->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model_color->m_order->Visible) { // m_order ?>
		<td data-name="m_order"<?php echo $model_color->m_order->CellAttributes() ?>>
<?php if ($model_color->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_m_order" class="form-group model_color_m_order">
<input type="text" data-table="model_color" data-field="x_m_order" name="x<?php echo $model_color_grid->RowIndex ?>_m_order" id="x<?php echo $model_color_grid->RowIndex ?>_m_order" size="30" placeholder="<?php echo ew_HtmlEncode($model_color->m_order->getPlaceHolder()) ?>" value="<?php echo $model_color->m_order->EditValue ?>"<?php echo $model_color->m_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="model_color" data-field="x_m_order" name="o<?php echo $model_color_grid->RowIndex ?>_m_order" id="o<?php echo $model_color_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model_color->m_order->OldValue) ?>">
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_m_order" class="form-group model_color_m_order">
<input type="text" data-table="model_color" data-field="x_m_order" name="x<?php echo $model_color_grid->RowIndex ?>_m_order" id="x<?php echo $model_color_grid->RowIndex ?>_m_order" size="30" placeholder="<?php echo ew_HtmlEncode($model_color->m_order->getPlaceHolder()) ?>" value="<?php echo $model_color->m_order->EditValue ?>"<?php echo $model_color->m_order->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_m_order" class="model_color_m_order">
<span<?php echo $model_color->m_order->ViewAttributes() ?>>
<?php echo $model_color->m_order->ListViewValue() ?></span>
</span>
<?php if ($model_color->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model_color" data-field="x_m_order" name="x<?php echo $model_color_grid->RowIndex ?>_m_order" id="x<?php echo $model_color_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model_color->m_order->FormValue) ?>">
<input type="hidden" data-table="model_color" data-field="x_m_order" name="o<?php echo $model_color_grid->RowIndex ?>_m_order" id="o<?php echo $model_color_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model_color->m_order->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model_color" data-field="x_m_order" name="fmodel_colorgrid$x<?php echo $model_color_grid->RowIndex ?>_m_order" id="fmodel_colorgrid$x<?php echo $model_color_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model_color->m_order->FormValue) ?>">
<input type="hidden" data-table="model_color" data-field="x_m_order" name="fmodel_colorgrid$o<?php echo $model_color_grid->RowIndex ?>_m_order" id="fmodel_colorgrid$o<?php echo $model_color_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model_color->m_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model_color->m_status->Visible) { // m_status ?>
		<td data-name="m_status"<?php echo $model_color->m_status->CellAttributes() ?>>
<?php if ($model_color->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_m_status" class="form-group model_color_m_status">
<select data-table="model_color" data-field="x_m_status" data-value-separator="<?php echo $model_color->m_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_color_grid->RowIndex ?>_m_status" name="x<?php echo $model_color_grid->RowIndex ?>_m_status"<?php echo $model_color->m_status->EditAttributes() ?>>
<?php echo $model_color->m_status->SelectOptionListHtml("x<?php echo $model_color_grid->RowIndex ?>_m_status") ?>
</select>
</span>
<input type="hidden" data-table="model_color" data-field="x_m_status" name="o<?php echo $model_color_grid->RowIndex ?>_m_status" id="o<?php echo $model_color_grid->RowIndex ?>_m_status" value="<?php echo ew_HtmlEncode($model_color->m_status->OldValue) ?>">
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_m_status" class="form-group model_color_m_status">
<select data-table="model_color" data-field="x_m_status" data-value-separator="<?php echo $model_color->m_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_color_grid->RowIndex ?>_m_status" name="x<?php echo $model_color_grid->RowIndex ?>_m_status"<?php echo $model_color->m_status->EditAttributes() ?>>
<?php echo $model_color->m_status->SelectOptionListHtml("x<?php echo $model_color_grid->RowIndex ?>_m_status") ?>
</select>
</span>
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_m_status" class="model_color_m_status">
<span<?php echo $model_color->m_status->ViewAttributes() ?>>
<?php echo $model_color->m_status->ListViewValue() ?></span>
</span>
<?php if ($model_color->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model_color" data-field="x_m_status" name="x<?php echo $model_color_grid->RowIndex ?>_m_status" id="x<?php echo $model_color_grid->RowIndex ?>_m_status" value="<?php echo ew_HtmlEncode($model_color->m_status->FormValue) ?>">
<input type="hidden" data-table="model_color" data-field="x_m_status" name="o<?php echo $model_color_grid->RowIndex ?>_m_status" id="o<?php echo $model_color_grid->RowIndex ?>_m_status" value="<?php echo ew_HtmlEncode($model_color->m_status->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model_color" data-field="x_m_status" name="fmodel_colorgrid$x<?php echo $model_color_grid->RowIndex ?>_m_status" id="fmodel_colorgrid$x<?php echo $model_color_grid->RowIndex ?>_m_status" value="<?php echo ew_HtmlEncode($model_color->m_status->FormValue) ?>">
<input type="hidden" data-table="model_color" data-field="x_m_status" name="fmodel_colorgrid$o<?php echo $model_color_grid->RowIndex ?>_m_status" id="fmodel_colorgrid$o<?php echo $model_color_grid->RowIndex ?>_m_status" value="<?php echo ew_HtmlEncode($model_color->m_status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$model_color_grid->ListOptions->Render("body", "right", $model_color_grid->RowCnt);
?>
	</tr>
<?php if ($model_color->RowType == EW_ROWTYPE_ADD || $model_color->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fmodel_colorgrid.UpdateOpts(<?php echo $model_color_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($model_color->CurrentAction <> "gridadd" || $model_color->CurrentMode == "copy")
		if (!$model_color_grid->Recordset->EOF) $model_color_grid->Recordset->MoveNext();
}
?>
<?php
	if ($model_color->CurrentMode == "add" || $model_color->CurrentMode == "copy" || $model_color->CurrentMode == "edit") {
		$model_color_grid->RowIndex = '$rowindex$';
		$model_color_grid->LoadRowValues();

		// Set row properties
		$model_color->ResetAttrs();
		$model_color->RowAttrs = array_merge($model_color->RowAttrs, array('data-rowindex'=>$model_color_grid->RowIndex, 'id'=>'r0_model_color', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($model_color->RowAttrs["class"], "ewTemplate");
		$model_color->RowType = EW_ROWTYPE_ADD;

		// Render row
		$model_color_grid->RenderRow();

		// Render list options
		$model_color_grid->RenderListOptions();
		$model_color_grid->StartRowCnt = 0;
?>
	<tr<?php echo $model_color->RowAttributes() ?>>
<?php

// Render list options (body, left)
$model_color_grid->ListOptions->Render("body", "left", $model_color_grid->RowIndex);
?>
	<?php if ($model_color->mc_id->Visible) { // mc_id ?>
		<td data-name="mc_id">
<?php if ($model_color->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_model_color_mc_id" class="form-group model_color_mc_id">
<span<?php echo $model_color->mc_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_color->mc_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model_color" data-field="x_mc_id" name="x<?php echo $model_color_grid->RowIndex ?>_mc_id" id="x<?php echo $model_color_grid->RowIndex ?>_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model_color" data-field="x_mc_id" name="o<?php echo $model_color_grid->RowIndex ?>_mc_id" id="o<?php echo $model_color_grid->RowIndex ?>_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model_color->image->Visible) { // image ?>
		<td data-name="image">
<span id="el$rowindex$_model_color_image" class="form-group model_color_image">
<div id="fd_x<?php echo $model_color_grid->RowIndex ?>_image">
<span title="<?php echo $model_color->image->FldTitle() ? $model_color->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model_color->image->ReadOnly || $model_color->image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="model_color" data-field="x_image" name="x<?php echo $model_color_grid->RowIndex ?>_image" id="x<?php echo $model_color_grid->RowIndex ?>_image"<?php echo $model_color->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fn_x<?php echo $model_color_grid->RowIndex ?>_image" value="<?php echo $model_color->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fa_x<?php echo $model_color_grid->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fs_x<?php echo $model_color_grid->RowIndex ?>_image" value="100">
<input type="hidden" name="fx_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fx_x<?php echo $model_color_grid->RowIndex ?>_image" value="<?php echo $model_color->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $model_color_grid->RowIndex ?>_image" id= "fm_x<?php echo $model_color_grid->RowIndex ?>_image" value="<?php echo $model_color->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $model_color_grid->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="model_color" data-field="x_image" name="o<?php echo $model_color_grid->RowIndex ?>_image" id="o<?php echo $model_color_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($model_color->image->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model_color->model_id->Visible) { // model_id ?>
		<td data-name="model_id">
<?php if ($model_color->CurrentAction <> "F") { ?>
<?php if ($model_color->model_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_model_color_model_id" class="form-group model_color_model_id">
<span<?php echo $model_color->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_color->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $model_color_grid->RowIndex ?>_model_id" name="x<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_model_color_model_id" class="form-group model_color_model_id">
<select data-table="model_color" data-field="x_model_id" data-value-separator="<?php echo $model_color->model_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_color_grid->RowIndex ?>_model_id" name="x<?php echo $model_color_grid->RowIndex ?>_model_id"<?php echo $model_color->model_id->EditAttributes() ?>>
<?php echo $model_color->model_id->SelectOptionListHtml("x<?php echo $model_color_grid->RowIndex ?>_model_id") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_model_color_model_id" class="form-group model_color_model_id">
<span<?php echo $model_color->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_color->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model_color" data-field="x_model_id" name="x<?php echo $model_color_grid->RowIndex ?>_model_id" id="x<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model_color" data-field="x_model_id" name="o<?php echo $model_color_grid->RowIndex ?>_model_id" id="o<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model_color->color_code->Visible) { // color_code ?>
		<td data-name="color_code">
<?php if ($model_color->CurrentAction <> "F") { ?>
<span id="el$rowindex$_model_color_color_code" class="form-group model_color_color_code">
<input type="text" data-table="model_color" data-field="x_color_code" name="x<?php echo $model_color_grid->RowIndex ?>_color_code" id="x<?php echo $model_color_grid->RowIndex ?>_color_code" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($model_color->color_code->getPlaceHolder()) ?>" value="<?php echo $model_color->color_code->EditValue ?>"<?php echo $model_color->color_code->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_model_color_color_code" class="form-group model_color_color_code">
<span<?php echo $model_color->color_code->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_color->color_code->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model_color" data-field="x_color_code" name="x<?php echo $model_color_grid->RowIndex ?>_color_code" id="x<?php echo $model_color_grid->RowIndex ?>_color_code" value="<?php echo ew_HtmlEncode($model_color->color_code->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model_color" data-field="x_color_code" name="o<?php echo $model_color_grid->RowIndex ?>_color_code" id="o<?php echo $model_color_grid->RowIndex ?>_color_code" value="<?php echo ew_HtmlEncode($model_color->color_code->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model_color->m_order->Visible) { // m_order ?>
		<td data-name="m_order">
<?php if ($model_color->CurrentAction <> "F") { ?>
<span id="el$rowindex$_model_color_m_order" class="form-group model_color_m_order">
<input type="text" data-table="model_color" data-field="x_m_order" name="x<?php echo $model_color_grid->RowIndex ?>_m_order" id="x<?php echo $model_color_grid->RowIndex ?>_m_order" size="30" placeholder="<?php echo ew_HtmlEncode($model_color->m_order->getPlaceHolder()) ?>" value="<?php echo $model_color->m_order->EditValue ?>"<?php echo $model_color->m_order->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_model_color_m_order" class="form-group model_color_m_order">
<span<?php echo $model_color->m_order->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_color->m_order->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model_color" data-field="x_m_order" name="x<?php echo $model_color_grid->RowIndex ?>_m_order" id="x<?php echo $model_color_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model_color->m_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model_color" data-field="x_m_order" name="o<?php echo $model_color_grid->RowIndex ?>_m_order" id="o<?php echo $model_color_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model_color->m_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model_color->m_status->Visible) { // m_status ?>
		<td data-name="m_status">
<?php if ($model_color->CurrentAction <> "F") { ?>
<span id="el$rowindex$_model_color_m_status" class="form-group model_color_m_status">
<select data-table="model_color" data-field="x_m_status" data-value-separator="<?php echo $model_color->m_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_color_grid->RowIndex ?>_m_status" name="x<?php echo $model_color_grid->RowIndex ?>_m_status"<?php echo $model_color->m_status->EditAttributes() ?>>
<?php echo $model_color->m_status->SelectOptionListHtml("x<?php echo $model_color_grid->RowIndex ?>_m_status") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_model_color_m_status" class="form-group model_color_m_status">
<span<?php echo $model_color->m_status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model_color->m_status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model_color" data-field="x_m_status" name="x<?php echo $model_color_grid->RowIndex ?>_m_status" id="x<?php echo $model_color_grid->RowIndex ?>_m_status" value="<?php echo ew_HtmlEncode($model_color->m_status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model_color" data-field="x_m_status" name="o<?php echo $model_color_grid->RowIndex ?>_m_status" id="o<?php echo $model_color_grid->RowIndex ?>_m_status" value="<?php echo ew_HtmlEncode($model_color->m_status->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$model_color_grid->ListOptions->Render("body", "right", $model_color_grid->RowIndex);
?>
<script type="text/javascript">
fmodel_colorgrid.UpdateOpts(<?php echo $model_color_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($model_color->CurrentMode == "add" || $model_color->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $model_color_grid->FormKeyCountName ?>" id="<?php echo $model_color_grid->FormKeyCountName ?>" value="<?php echo $model_color_grid->KeyCount ?>">
<?php echo $model_color_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($model_color->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $model_color_grid->FormKeyCountName ?>" id="<?php echo $model_color_grid->FormKeyCountName ?>" value="<?php echo $model_color_grid->KeyCount ?>">
<?php echo $model_color_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($model_color->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmodel_colorgrid">
</div>
<?php

// Close recordset
if ($model_color_grid->Recordset)
	$model_color_grid->Recordset->Close();
?>
<?php if ($model_color_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($model_color_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($model_color_grid->TotalRecs == 0 && $model_color->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($model_color_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($model_color->Export == "") { ?>
<script type="text/javascript">
fmodel_colorgrid.Init();
</script>
<?php } ?>
<?php
$model_color_grid->Page_Terminate();
?>
