<?php include_once "admin_userinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($specification_grid)) $specification_grid = new cspecification_grid();

// Page init
$specification_grid->Page_Init();

// Page main
$specification_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$specification_grid->Page_Render();
?>
<?php if ($specification->Export == "") { ?>
<script type="text/javascript">

// Form object
var fspecificationgrid = new ew_Form("fspecificationgrid", "grid");
fspecificationgrid.FormKeyCountName = '<?php echo $specification_grid->FormKeyCountName ?>';

// Validate form
fspecificationgrid.Validate = function() {
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
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $specification->model_id->FldCaption(), $specification->model_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $specification->title->FldCaption(), $specification->title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $specification->s_order->FldCaption(), $specification->s_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_s_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($specification->s_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $specification->status->FldCaption(), $specification->status->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fspecificationgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "model_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "title", false)) return false;
	if (ew_ValueChanged(fobj, infix, "s_order", false)) return false;
	if (ew_ValueChanged(fobj, infix, "status", false)) return false;
	return true;
}

// Form_CustomValidate event
fspecificationgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fspecificationgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fspecificationgrid.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"model"};
fspecificationgrid.Lists["x_model_id"].Data = "<?php echo $specification_grid->model_id->LookupFilterQuery(FALSE, "grid") ?>";
fspecificationgrid.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fspecificationgrid.Lists["x_status"].Options = <?php echo json_encode($specification_grid->status->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($specification->CurrentAction == "gridadd") {
	if ($specification->CurrentMode == "copy") {
		$bSelectLimit = $specification_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$specification_grid->TotalRecs = $specification->ListRecordCount();
			$specification_grid->Recordset = $specification_grid->LoadRecordset($specification_grid->StartRec-1, $specification_grid->DisplayRecs);
		} else {
			if ($specification_grid->Recordset = $specification_grid->LoadRecordset())
				$specification_grid->TotalRecs = $specification_grid->Recordset->RecordCount();
		}
		$specification_grid->StartRec = 1;
		$specification_grid->DisplayRecs = $specification_grid->TotalRecs;
	} else {
		$specification->CurrentFilter = "0=1";
		$specification_grid->StartRec = 1;
		$specification_grid->DisplayRecs = $specification->GridAddRowCount;
	}
	$specification_grid->TotalRecs = $specification_grid->DisplayRecs;
	$specification_grid->StopRec = $specification_grid->DisplayRecs;
} else {
	$bSelectLimit = $specification_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($specification_grid->TotalRecs <= 0)
			$specification_grid->TotalRecs = $specification->ListRecordCount();
	} else {
		if (!$specification_grid->Recordset && ($specification_grid->Recordset = $specification_grid->LoadRecordset()))
			$specification_grid->TotalRecs = $specification_grid->Recordset->RecordCount();
	}
	$specification_grid->StartRec = 1;
	$specification_grid->DisplayRecs = $specification_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$specification_grid->Recordset = $specification_grid->LoadRecordset($specification_grid->StartRec-1, $specification_grid->DisplayRecs);

	// Set no record found message
	if ($specification->CurrentAction == "" && $specification_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$specification_grid->setWarningMessage(ew_DeniedMsg());
		if ($specification_grid->SearchWhere == "0=101")
			$specification_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$specification_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$specification_grid->RenderOtherOptions();
?>
<?php $specification_grid->ShowPageHeader(); ?>
<?php
$specification_grid->ShowMessage();
?>
<?php if ($specification_grid->TotalRecs > 0 || $specification->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($specification_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> specification">
<div id="fspecificationgrid" class="ewForm ewListForm form-inline">
<?php if ($specification_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($specification_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_specification" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_specificationgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$specification_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$specification_grid->RenderListOptions();

// Render list options (header, left)
$specification_grid->ListOptions->Render("header", "left");
?>
<?php if ($specification->spec_id->Visible) { // spec_id ?>
	<?php if ($specification->SortUrl($specification->spec_id) == "") { ?>
		<th data-name="spec_id" class="<?php echo $specification->spec_id->HeaderCellClass() ?>"><div id="elh_specification_spec_id" class="specification_spec_id"><div class="ewTableHeaderCaption"><?php echo $specification->spec_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="spec_id" class="<?php echo $specification->spec_id->HeaderCellClass() ?>"><div><div id="elh_specification_spec_id" class="specification_spec_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $specification->spec_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($specification->spec_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($specification->spec_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($specification->model_id->Visible) { // model_id ?>
	<?php if ($specification->SortUrl($specification->model_id) == "") { ?>
		<th data-name="model_id" class="<?php echo $specification->model_id->HeaderCellClass() ?>"><div id="elh_specification_model_id" class="specification_model_id"><div class="ewTableHeaderCaption"><?php echo $specification->model_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="model_id" class="<?php echo $specification->model_id->HeaderCellClass() ?>"><div><div id="elh_specification_model_id" class="specification_model_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $specification->model_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($specification->model_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($specification->model_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($specification->title->Visible) { // title ?>
	<?php if ($specification->SortUrl($specification->title) == "") { ?>
		<th data-name="title" class="<?php echo $specification->title->HeaderCellClass() ?>"><div id="elh_specification_title" class="specification_title"><div class="ewTableHeaderCaption"><?php echo $specification->title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="title" class="<?php echo $specification->title->HeaderCellClass() ?>"><div><div id="elh_specification_title" class="specification_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $specification->title->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($specification->title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($specification->title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($specification->s_order->Visible) { // s_order ?>
	<?php if ($specification->SortUrl($specification->s_order) == "") { ?>
		<th data-name="s_order" class="<?php echo $specification->s_order->HeaderCellClass() ?>"><div id="elh_specification_s_order" class="specification_s_order"><div class="ewTableHeaderCaption"><?php echo $specification->s_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="s_order" class="<?php echo $specification->s_order->HeaderCellClass() ?>"><div><div id="elh_specification_s_order" class="specification_s_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $specification->s_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($specification->s_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($specification->s_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($specification->status->Visible) { // status ?>
	<?php if ($specification->SortUrl($specification->status) == "") { ?>
		<th data-name="status" class="<?php echo $specification->status->HeaderCellClass() ?>"><div id="elh_specification_status" class="specification_status"><div class="ewTableHeaderCaption"><?php echo $specification->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $specification->status->HeaderCellClass() ?>"><div><div id="elh_specification_status" class="specification_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $specification->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($specification->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($specification->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$specification_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$specification_grid->StartRec = 1;
$specification_grid->StopRec = $specification_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($specification_grid->FormKeyCountName) && ($specification->CurrentAction == "gridadd" || $specification->CurrentAction == "gridedit" || $specification->CurrentAction == "F")) {
		$specification_grid->KeyCount = $objForm->GetValue($specification_grid->FormKeyCountName);
		$specification_grid->StopRec = $specification_grid->StartRec + $specification_grid->KeyCount - 1;
	}
}
$specification_grid->RecCnt = $specification_grid->StartRec - 1;
if ($specification_grid->Recordset && !$specification_grid->Recordset->EOF) {
	$specification_grid->Recordset->MoveFirst();
	$bSelectLimit = $specification_grid->UseSelectLimit;
	if (!$bSelectLimit && $specification_grid->StartRec > 1)
		$specification_grid->Recordset->Move($specification_grid->StartRec - 1);
} elseif (!$specification->AllowAddDeleteRow && $specification_grid->StopRec == 0) {
	$specification_grid->StopRec = $specification->GridAddRowCount;
}

// Initialize aggregate
$specification->RowType = EW_ROWTYPE_AGGREGATEINIT;
$specification->ResetAttrs();
$specification_grid->RenderRow();
if ($specification->CurrentAction == "gridadd")
	$specification_grid->RowIndex = 0;
if ($specification->CurrentAction == "gridedit")
	$specification_grid->RowIndex = 0;
while ($specification_grid->RecCnt < $specification_grid->StopRec) {
	$specification_grid->RecCnt++;
	if (intval($specification_grid->RecCnt) >= intval($specification_grid->StartRec)) {
		$specification_grid->RowCnt++;
		if ($specification->CurrentAction == "gridadd" || $specification->CurrentAction == "gridedit" || $specification->CurrentAction == "F") {
			$specification_grid->RowIndex++;
			$objForm->Index = $specification_grid->RowIndex;
			if ($objForm->HasValue($specification_grid->FormActionName))
				$specification_grid->RowAction = strval($objForm->GetValue($specification_grid->FormActionName));
			elseif ($specification->CurrentAction == "gridadd")
				$specification_grid->RowAction = "insert";
			else
				$specification_grid->RowAction = "";
		}

		// Set up key count
		$specification_grid->KeyCount = $specification_grid->RowIndex;

		// Init row class and style
		$specification->ResetAttrs();
		$specification->CssClass = "";
		if ($specification->CurrentAction == "gridadd") {
			if ($specification->CurrentMode == "copy") {
				$specification_grid->LoadRowValues($specification_grid->Recordset); // Load row values
				$specification_grid->SetRecordKey($specification_grid->RowOldKey, $specification_grid->Recordset); // Set old record key
			} else {
				$specification_grid->LoadRowValues(); // Load default values
				$specification_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$specification_grid->LoadRowValues($specification_grid->Recordset); // Load row values
		}
		$specification->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($specification->CurrentAction == "gridadd") // Grid add
			$specification->RowType = EW_ROWTYPE_ADD; // Render add
		if ($specification->CurrentAction == "gridadd" && $specification->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$specification_grid->RestoreCurrentRowFormValues($specification_grid->RowIndex); // Restore form values
		if ($specification->CurrentAction == "gridedit") { // Grid edit
			if ($specification->EventCancelled) {
				$specification_grid->RestoreCurrentRowFormValues($specification_grid->RowIndex); // Restore form values
			}
			if ($specification_grid->RowAction == "insert")
				$specification->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$specification->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($specification->CurrentAction == "gridedit" && ($specification->RowType == EW_ROWTYPE_EDIT || $specification->RowType == EW_ROWTYPE_ADD) && $specification->EventCancelled) // Update failed
			$specification_grid->RestoreCurrentRowFormValues($specification_grid->RowIndex); // Restore form values
		if ($specification->RowType == EW_ROWTYPE_EDIT) // Edit row
			$specification_grid->EditRowCnt++;
		if ($specification->CurrentAction == "F") // Confirm row
			$specification_grid->RestoreCurrentRowFormValues($specification_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$specification->RowAttrs = array_merge($specification->RowAttrs, array('data-rowindex'=>$specification_grid->RowCnt, 'id'=>'r' . $specification_grid->RowCnt . '_specification', 'data-rowtype'=>$specification->RowType));

		// Render row
		$specification_grid->RenderRow();

		// Render list options
		$specification_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($specification_grid->RowAction <> "delete" && $specification_grid->RowAction <> "insertdelete" && !($specification_grid->RowAction == "insert" && $specification->CurrentAction == "F" && $specification_grid->EmptyRow())) {
?>
	<tr<?php echo $specification->RowAttributes() ?>>
<?php

// Render list options (body, left)
$specification_grid->ListOptions->Render("body", "left", $specification_grid->RowCnt);
?>
	<?php if ($specification->spec_id->Visible) { // spec_id ?>
		<td data-name="spec_id"<?php echo $specification->spec_id->CellAttributes() ?>>
<?php if ($specification->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="specification" data-field="x_spec_id" name="o<?php echo $specification_grid->RowIndex ?>_spec_id" id="o<?php echo $specification_grid->RowIndex ?>_spec_id" value="<?php echo ew_HtmlEncode($specification->spec_id->OldValue) ?>">
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_spec_id" class="form-group specification_spec_id">
<span<?php echo $specification->spec_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $specification->spec_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="specification" data-field="x_spec_id" name="x<?php echo $specification_grid->RowIndex ?>_spec_id" id="x<?php echo $specification_grid->RowIndex ?>_spec_id" value="<?php echo ew_HtmlEncode($specification->spec_id->CurrentValue) ?>">
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_spec_id" class="specification_spec_id">
<span<?php echo $specification->spec_id->ViewAttributes() ?>>
<?php echo $specification->spec_id->ListViewValue() ?></span>
</span>
<?php if ($specification->CurrentAction <> "F") { ?>
<input type="hidden" data-table="specification" data-field="x_spec_id" name="x<?php echo $specification_grid->RowIndex ?>_spec_id" id="x<?php echo $specification_grid->RowIndex ?>_spec_id" value="<?php echo ew_HtmlEncode($specification->spec_id->FormValue) ?>">
<input type="hidden" data-table="specification" data-field="x_spec_id" name="o<?php echo $specification_grid->RowIndex ?>_spec_id" id="o<?php echo $specification_grid->RowIndex ?>_spec_id" value="<?php echo ew_HtmlEncode($specification->spec_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="specification" data-field="x_spec_id" name="fspecificationgrid$x<?php echo $specification_grid->RowIndex ?>_spec_id" id="fspecificationgrid$x<?php echo $specification_grid->RowIndex ?>_spec_id" value="<?php echo ew_HtmlEncode($specification->spec_id->FormValue) ?>">
<input type="hidden" data-table="specification" data-field="x_spec_id" name="fspecificationgrid$o<?php echo $specification_grid->RowIndex ?>_spec_id" id="fspecificationgrid$o<?php echo $specification_grid->RowIndex ?>_spec_id" value="<?php echo ew_HtmlEncode($specification->spec_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($specification->model_id->Visible) { // model_id ?>
		<td data-name="model_id"<?php echo $specification->model_id->CellAttributes() ?>>
<?php if ($specification->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($specification->model_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_model_id" class="form-group specification_model_id">
<span<?php echo $specification->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $specification->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $specification_grid->RowIndex ?>_model_id" name="x<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_model_id" class="form-group specification_model_id">
<select data-table="specification" data-field="x_model_id" data-value-separator="<?php echo $specification->model_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $specification_grid->RowIndex ?>_model_id" name="x<?php echo $specification_grid->RowIndex ?>_model_id"<?php echo $specification->model_id->EditAttributes() ?>>
<?php echo $specification->model_id->SelectOptionListHtml("x<?php echo $specification_grid->RowIndex ?>_model_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="specification" data-field="x_model_id" name="o<?php echo $specification_grid->RowIndex ?>_model_id" id="o<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->OldValue) ?>">
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($specification->model_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_model_id" class="form-group specification_model_id">
<span<?php echo $specification->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $specification->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $specification_grid->RowIndex ?>_model_id" name="x<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_model_id" class="form-group specification_model_id">
<select data-table="specification" data-field="x_model_id" data-value-separator="<?php echo $specification->model_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $specification_grid->RowIndex ?>_model_id" name="x<?php echo $specification_grid->RowIndex ?>_model_id"<?php echo $specification->model_id->EditAttributes() ?>>
<?php echo $specification->model_id->SelectOptionListHtml("x<?php echo $specification_grid->RowIndex ?>_model_id") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_model_id" class="specification_model_id">
<span<?php echo $specification->model_id->ViewAttributes() ?>>
<?php echo $specification->model_id->ListViewValue() ?></span>
</span>
<?php if ($specification->CurrentAction <> "F") { ?>
<input type="hidden" data-table="specification" data-field="x_model_id" name="x<?php echo $specification_grid->RowIndex ?>_model_id" id="x<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->FormValue) ?>">
<input type="hidden" data-table="specification" data-field="x_model_id" name="o<?php echo $specification_grid->RowIndex ?>_model_id" id="o<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="specification" data-field="x_model_id" name="fspecificationgrid$x<?php echo $specification_grid->RowIndex ?>_model_id" id="fspecificationgrid$x<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->FormValue) ?>">
<input type="hidden" data-table="specification" data-field="x_model_id" name="fspecificationgrid$o<?php echo $specification_grid->RowIndex ?>_model_id" id="fspecificationgrid$o<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($specification->title->Visible) { // title ?>
		<td data-name="title"<?php echo $specification->title->CellAttributes() ?>>
<?php if ($specification->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_title" class="form-group specification_title">
<input type="text" data-table="specification" data-field="x_title" name="x<?php echo $specification_grid->RowIndex ?>_title" id="x<?php echo $specification_grid->RowIndex ?>_title" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($specification->title->getPlaceHolder()) ?>" value="<?php echo $specification->title->EditValue ?>"<?php echo $specification->title->EditAttributes() ?>>
</span>
<input type="hidden" data-table="specification" data-field="x_title" name="o<?php echo $specification_grid->RowIndex ?>_title" id="o<?php echo $specification_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($specification->title->OldValue) ?>">
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_title" class="form-group specification_title">
<input type="text" data-table="specification" data-field="x_title" name="x<?php echo $specification_grid->RowIndex ?>_title" id="x<?php echo $specification_grid->RowIndex ?>_title" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($specification->title->getPlaceHolder()) ?>" value="<?php echo $specification->title->EditValue ?>"<?php echo $specification->title->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_title" class="specification_title">
<span<?php echo $specification->title->ViewAttributes() ?>>
<?php echo $specification->title->ListViewValue() ?></span>
</span>
<?php if ($specification->CurrentAction <> "F") { ?>
<input type="hidden" data-table="specification" data-field="x_title" name="x<?php echo $specification_grid->RowIndex ?>_title" id="x<?php echo $specification_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($specification->title->FormValue) ?>">
<input type="hidden" data-table="specification" data-field="x_title" name="o<?php echo $specification_grid->RowIndex ?>_title" id="o<?php echo $specification_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($specification->title->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="specification" data-field="x_title" name="fspecificationgrid$x<?php echo $specification_grid->RowIndex ?>_title" id="fspecificationgrid$x<?php echo $specification_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($specification->title->FormValue) ?>">
<input type="hidden" data-table="specification" data-field="x_title" name="fspecificationgrid$o<?php echo $specification_grid->RowIndex ?>_title" id="fspecificationgrid$o<?php echo $specification_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($specification->title->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($specification->s_order->Visible) { // s_order ?>
		<td data-name="s_order"<?php echo $specification->s_order->CellAttributes() ?>>
<?php if ($specification->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_s_order" class="form-group specification_s_order">
<input type="text" data-table="specification" data-field="x_s_order" name="x<?php echo $specification_grid->RowIndex ?>_s_order" id="x<?php echo $specification_grid->RowIndex ?>_s_order" size="30" placeholder="<?php echo ew_HtmlEncode($specification->s_order->getPlaceHolder()) ?>" value="<?php echo $specification->s_order->EditValue ?>"<?php echo $specification->s_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="specification" data-field="x_s_order" name="o<?php echo $specification_grid->RowIndex ?>_s_order" id="o<?php echo $specification_grid->RowIndex ?>_s_order" value="<?php echo ew_HtmlEncode($specification->s_order->OldValue) ?>">
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_s_order" class="form-group specification_s_order">
<input type="text" data-table="specification" data-field="x_s_order" name="x<?php echo $specification_grid->RowIndex ?>_s_order" id="x<?php echo $specification_grid->RowIndex ?>_s_order" size="30" placeholder="<?php echo ew_HtmlEncode($specification->s_order->getPlaceHolder()) ?>" value="<?php echo $specification->s_order->EditValue ?>"<?php echo $specification->s_order->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_s_order" class="specification_s_order">
<span<?php echo $specification->s_order->ViewAttributes() ?>>
<?php echo $specification->s_order->ListViewValue() ?></span>
</span>
<?php if ($specification->CurrentAction <> "F") { ?>
<input type="hidden" data-table="specification" data-field="x_s_order" name="x<?php echo $specification_grid->RowIndex ?>_s_order" id="x<?php echo $specification_grid->RowIndex ?>_s_order" value="<?php echo ew_HtmlEncode($specification->s_order->FormValue) ?>">
<input type="hidden" data-table="specification" data-field="x_s_order" name="o<?php echo $specification_grid->RowIndex ?>_s_order" id="o<?php echo $specification_grid->RowIndex ?>_s_order" value="<?php echo ew_HtmlEncode($specification->s_order->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="specification" data-field="x_s_order" name="fspecificationgrid$x<?php echo $specification_grid->RowIndex ?>_s_order" id="fspecificationgrid$x<?php echo $specification_grid->RowIndex ?>_s_order" value="<?php echo ew_HtmlEncode($specification->s_order->FormValue) ?>">
<input type="hidden" data-table="specification" data-field="x_s_order" name="fspecificationgrid$o<?php echo $specification_grid->RowIndex ?>_s_order" id="fspecificationgrid$o<?php echo $specification_grid->RowIndex ?>_s_order" value="<?php echo ew_HtmlEncode($specification->s_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($specification->status->Visible) { // status ?>
		<td data-name="status"<?php echo $specification->status->CellAttributes() ?>>
<?php if ($specification->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_status" class="form-group specification_status">
<select data-table="specification" data-field="x_status" data-value-separator="<?php echo $specification->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $specification_grid->RowIndex ?>_status" name="x<?php echo $specification_grid->RowIndex ?>_status"<?php echo $specification->status->EditAttributes() ?>>
<?php echo $specification->status->SelectOptionListHtml("x<?php echo $specification_grid->RowIndex ?>_status") ?>
</select>
</span>
<input type="hidden" data-table="specification" data-field="x_status" name="o<?php echo $specification_grid->RowIndex ?>_status" id="o<?php echo $specification_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($specification->status->OldValue) ?>">
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_status" class="form-group specification_status">
<select data-table="specification" data-field="x_status" data-value-separator="<?php echo $specification->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $specification_grid->RowIndex ?>_status" name="x<?php echo $specification_grid->RowIndex ?>_status"<?php echo $specification->status->EditAttributes() ?>>
<?php echo $specification->status->SelectOptionListHtml("x<?php echo $specification_grid->RowIndex ?>_status") ?>
</select>
</span>
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $specification_grid->RowCnt ?>_specification_status" class="specification_status">
<span<?php echo $specification->status->ViewAttributes() ?>>
<?php echo $specification->status->ListViewValue() ?></span>
</span>
<?php if ($specification->CurrentAction <> "F") { ?>
<input type="hidden" data-table="specification" data-field="x_status" name="x<?php echo $specification_grid->RowIndex ?>_status" id="x<?php echo $specification_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($specification->status->FormValue) ?>">
<input type="hidden" data-table="specification" data-field="x_status" name="o<?php echo $specification_grid->RowIndex ?>_status" id="o<?php echo $specification_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($specification->status->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="specification" data-field="x_status" name="fspecificationgrid$x<?php echo $specification_grid->RowIndex ?>_status" id="fspecificationgrid$x<?php echo $specification_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($specification->status->FormValue) ?>">
<input type="hidden" data-table="specification" data-field="x_status" name="fspecificationgrid$o<?php echo $specification_grid->RowIndex ?>_status" id="fspecificationgrid$o<?php echo $specification_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($specification->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$specification_grid->ListOptions->Render("body", "right", $specification_grid->RowCnt);
?>
	</tr>
<?php if ($specification->RowType == EW_ROWTYPE_ADD || $specification->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fspecificationgrid.UpdateOpts(<?php echo $specification_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($specification->CurrentAction <> "gridadd" || $specification->CurrentMode == "copy")
		if (!$specification_grid->Recordset->EOF) $specification_grid->Recordset->MoveNext();
}
?>
<?php
	if ($specification->CurrentMode == "add" || $specification->CurrentMode == "copy" || $specification->CurrentMode == "edit") {
		$specification_grid->RowIndex = '$rowindex$';
		$specification_grid->LoadRowValues();

		// Set row properties
		$specification->ResetAttrs();
		$specification->RowAttrs = array_merge($specification->RowAttrs, array('data-rowindex'=>$specification_grid->RowIndex, 'id'=>'r0_specification', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($specification->RowAttrs["class"], "ewTemplate");
		$specification->RowType = EW_ROWTYPE_ADD;

		// Render row
		$specification_grid->RenderRow();

		// Render list options
		$specification_grid->RenderListOptions();
		$specification_grid->StartRowCnt = 0;
?>
	<tr<?php echo $specification->RowAttributes() ?>>
<?php

// Render list options (body, left)
$specification_grid->ListOptions->Render("body", "left", $specification_grid->RowIndex);
?>
	<?php if ($specification->spec_id->Visible) { // spec_id ?>
		<td data-name="spec_id">
<?php if ($specification->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_specification_spec_id" class="form-group specification_spec_id">
<span<?php echo $specification->spec_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $specification->spec_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="specification" data-field="x_spec_id" name="x<?php echo $specification_grid->RowIndex ?>_spec_id" id="x<?php echo $specification_grid->RowIndex ?>_spec_id" value="<?php echo ew_HtmlEncode($specification->spec_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="specification" data-field="x_spec_id" name="o<?php echo $specification_grid->RowIndex ?>_spec_id" id="o<?php echo $specification_grid->RowIndex ?>_spec_id" value="<?php echo ew_HtmlEncode($specification->spec_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($specification->model_id->Visible) { // model_id ?>
		<td data-name="model_id">
<?php if ($specification->CurrentAction <> "F") { ?>
<?php if ($specification->model_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_specification_model_id" class="form-group specification_model_id">
<span<?php echo $specification->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $specification->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $specification_grid->RowIndex ?>_model_id" name="x<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_specification_model_id" class="form-group specification_model_id">
<select data-table="specification" data-field="x_model_id" data-value-separator="<?php echo $specification->model_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $specification_grid->RowIndex ?>_model_id" name="x<?php echo $specification_grid->RowIndex ?>_model_id"<?php echo $specification->model_id->EditAttributes() ?>>
<?php echo $specification->model_id->SelectOptionListHtml("x<?php echo $specification_grid->RowIndex ?>_model_id") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_specification_model_id" class="form-group specification_model_id">
<span<?php echo $specification->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $specification->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="specification" data-field="x_model_id" name="x<?php echo $specification_grid->RowIndex ?>_model_id" id="x<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="specification" data-field="x_model_id" name="o<?php echo $specification_grid->RowIndex ?>_model_id" id="o<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($specification->title->Visible) { // title ?>
		<td data-name="title">
<?php if ($specification->CurrentAction <> "F") { ?>
<span id="el$rowindex$_specification_title" class="form-group specification_title">
<input type="text" data-table="specification" data-field="x_title" name="x<?php echo $specification_grid->RowIndex ?>_title" id="x<?php echo $specification_grid->RowIndex ?>_title" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($specification->title->getPlaceHolder()) ?>" value="<?php echo $specification->title->EditValue ?>"<?php echo $specification->title->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_specification_title" class="form-group specification_title">
<span<?php echo $specification->title->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $specification->title->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="specification" data-field="x_title" name="x<?php echo $specification_grid->RowIndex ?>_title" id="x<?php echo $specification_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($specification->title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="specification" data-field="x_title" name="o<?php echo $specification_grid->RowIndex ?>_title" id="o<?php echo $specification_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($specification->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($specification->s_order->Visible) { // s_order ?>
		<td data-name="s_order">
<?php if ($specification->CurrentAction <> "F") { ?>
<span id="el$rowindex$_specification_s_order" class="form-group specification_s_order">
<input type="text" data-table="specification" data-field="x_s_order" name="x<?php echo $specification_grid->RowIndex ?>_s_order" id="x<?php echo $specification_grid->RowIndex ?>_s_order" size="30" placeholder="<?php echo ew_HtmlEncode($specification->s_order->getPlaceHolder()) ?>" value="<?php echo $specification->s_order->EditValue ?>"<?php echo $specification->s_order->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_specification_s_order" class="form-group specification_s_order">
<span<?php echo $specification->s_order->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $specification->s_order->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="specification" data-field="x_s_order" name="x<?php echo $specification_grid->RowIndex ?>_s_order" id="x<?php echo $specification_grid->RowIndex ?>_s_order" value="<?php echo ew_HtmlEncode($specification->s_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="specification" data-field="x_s_order" name="o<?php echo $specification_grid->RowIndex ?>_s_order" id="o<?php echo $specification_grid->RowIndex ?>_s_order" value="<?php echo ew_HtmlEncode($specification->s_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($specification->status->Visible) { // status ?>
		<td data-name="status">
<?php if ($specification->CurrentAction <> "F") { ?>
<span id="el$rowindex$_specification_status" class="form-group specification_status">
<select data-table="specification" data-field="x_status" data-value-separator="<?php echo $specification->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $specification_grid->RowIndex ?>_status" name="x<?php echo $specification_grid->RowIndex ?>_status"<?php echo $specification->status->EditAttributes() ?>>
<?php echo $specification->status->SelectOptionListHtml("x<?php echo $specification_grid->RowIndex ?>_status") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_specification_status" class="form-group specification_status">
<span<?php echo $specification->status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $specification->status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="specification" data-field="x_status" name="x<?php echo $specification_grid->RowIndex ?>_status" id="x<?php echo $specification_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($specification->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="specification" data-field="x_status" name="o<?php echo $specification_grid->RowIndex ?>_status" id="o<?php echo $specification_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($specification->status->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$specification_grid->ListOptions->Render("body", "right", $specification_grid->RowIndex);
?>
<script type="text/javascript">
fspecificationgrid.UpdateOpts(<?php echo $specification_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($specification->CurrentMode == "add" || $specification->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $specification_grid->FormKeyCountName ?>" id="<?php echo $specification_grid->FormKeyCountName ?>" value="<?php echo $specification_grid->KeyCount ?>">
<?php echo $specification_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($specification->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $specification_grid->FormKeyCountName ?>" id="<?php echo $specification_grid->FormKeyCountName ?>" value="<?php echo $specification_grid->KeyCount ?>">
<?php echo $specification_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($specification->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fspecificationgrid">
</div>
<?php

// Close recordset
if ($specification_grid->Recordset)
	$specification_grid->Recordset->Close();
?>
<?php if ($specification_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($specification_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($specification_grid->TotalRecs == 0 && $specification->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($specification_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($specification->Export == "") { ?>
<script type="text/javascript">
fspecificationgrid.Init();
</script>
<?php } ?>
<?php
$specification_grid->Page_Terminate();
?>
