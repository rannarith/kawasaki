<?php include_once "admin_userinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($feature_grid)) $feature_grid = new cfeature_grid();

// Page init
$feature_grid->Page_Init();

// Page main
$feature_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$feature_grid->Page_Render();
?>
<?php if ($feature->Export == "") { ?>
<script type="text/javascript">

// Form object
var ffeaturegrid = new ew_Form("ffeaturegrid", "grid");
ffeaturegrid.FormKeyCountName = '<?php echo $feature_grid->FormKeyCountName ?>';

// Validate form
ffeaturegrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_top_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $feature->top_title->FldCaption(), $feature->top_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $feature->title->FldCaption(), $feature->title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_model_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $feature->model_id->FldCaption(), $feature->model_id->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "__thumbnail");
			elm = this.GetElements("fn_x" + infix + "__thumbnail");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $feature->_thumbnail->FldCaption(), $feature->_thumbnail->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_f_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $feature->f_order->FldCaption(), $feature->f_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_f_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($feature->f_order->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
ffeaturegrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "top_title", false)) return false;
	if (ew_ValueChanged(fobj, infix, "title", false)) return false;
	if (ew_ValueChanged(fobj, infix, "model_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "_thumbnail", false)) return false;
	if (ew_ValueChanged(fobj, infix, "f_order", false)) return false;
	return true;
}

// Form_CustomValidate event
ffeaturegrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ffeaturegrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ffeaturegrid.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"model"};
ffeaturegrid.Lists["x_model_id"].Data = "<?php echo $feature_grid->model_id->LookupFilterQuery(FALSE, "grid") ?>";

// Form object for search
</script>
<?php } ?>
<?php
if ($feature->CurrentAction == "gridadd") {
	if ($feature->CurrentMode == "copy") {
		$bSelectLimit = $feature_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$feature_grid->TotalRecs = $feature->ListRecordCount();
			$feature_grid->Recordset = $feature_grid->LoadRecordset($feature_grid->StartRec-1, $feature_grid->DisplayRecs);
		} else {
			if ($feature_grid->Recordset = $feature_grid->LoadRecordset())
				$feature_grid->TotalRecs = $feature_grid->Recordset->RecordCount();
		}
		$feature_grid->StartRec = 1;
		$feature_grid->DisplayRecs = $feature_grid->TotalRecs;
	} else {
		$feature->CurrentFilter = "0=1";
		$feature_grid->StartRec = 1;
		$feature_grid->DisplayRecs = $feature->GridAddRowCount;
	}
	$feature_grid->TotalRecs = $feature_grid->DisplayRecs;
	$feature_grid->StopRec = $feature_grid->DisplayRecs;
} else {
	$bSelectLimit = $feature_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($feature_grid->TotalRecs <= 0)
			$feature_grid->TotalRecs = $feature->ListRecordCount();
	} else {
		if (!$feature_grid->Recordset && ($feature_grid->Recordset = $feature_grid->LoadRecordset()))
			$feature_grid->TotalRecs = $feature_grid->Recordset->RecordCount();
	}
	$feature_grid->StartRec = 1;
	$feature_grid->DisplayRecs = $feature_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$feature_grid->Recordset = $feature_grid->LoadRecordset($feature_grid->StartRec-1, $feature_grid->DisplayRecs);

	// Set no record found message
	if ($feature->CurrentAction == "" && $feature_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$feature_grid->setWarningMessage(ew_DeniedMsg());
		if ($feature_grid->SearchWhere == "0=101")
			$feature_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$feature_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$feature_grid->RenderOtherOptions();
?>
<?php $feature_grid->ShowPageHeader(); ?>
<?php
$feature_grid->ShowMessage();
?>
<?php if ($feature_grid->TotalRecs > 0 || $feature->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($feature_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> feature">
<div id="ffeaturegrid" class="ewForm ewListForm form-inline">
<?php if ($feature_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($feature_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_feature" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_featuregrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$feature_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$feature_grid->RenderListOptions();

// Render list options (header, left)
$feature_grid->ListOptions->Render("header", "left");
?>
<?php if ($feature->feature_id->Visible) { // feature_id ?>
	<?php if ($feature->SortUrl($feature->feature_id) == "") { ?>
		<th data-name="feature_id" class="<?php echo $feature->feature_id->HeaderCellClass() ?>"><div id="elh_feature_feature_id" class="feature_feature_id"><div class="ewTableHeaderCaption"><?php echo $feature->feature_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="feature_id" class="<?php echo $feature->feature_id->HeaderCellClass() ?>"><div><div id="elh_feature_feature_id" class="feature_feature_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $feature->feature_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($feature->feature_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($feature->feature_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($feature->top_title->Visible) { // top_title ?>
	<?php if ($feature->SortUrl($feature->top_title) == "") { ?>
		<th data-name="top_title" class="<?php echo $feature->top_title->HeaderCellClass() ?>"><div id="elh_feature_top_title" class="feature_top_title"><div class="ewTableHeaderCaption"><?php echo $feature->top_title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="top_title" class="<?php echo $feature->top_title->HeaderCellClass() ?>"><div><div id="elh_feature_top_title" class="feature_top_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $feature->top_title->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($feature->top_title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($feature->top_title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($feature->title->Visible) { // title ?>
	<?php if ($feature->SortUrl($feature->title) == "") { ?>
		<th data-name="title" class="<?php echo $feature->title->HeaderCellClass() ?>"><div id="elh_feature_title" class="feature_title"><div class="ewTableHeaderCaption"><?php echo $feature->title->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="title" class="<?php echo $feature->title->HeaderCellClass() ?>"><div><div id="elh_feature_title" class="feature_title">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $feature->title->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($feature->title->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($feature->title->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($feature->model_id->Visible) { // model_id ?>
	<?php if ($feature->SortUrl($feature->model_id) == "") { ?>
		<th data-name="model_id" class="<?php echo $feature->model_id->HeaderCellClass() ?>"><div id="elh_feature_model_id" class="feature_model_id"><div class="ewTableHeaderCaption"><?php echo $feature->model_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="model_id" class="<?php echo $feature->model_id->HeaderCellClass() ?>"><div><div id="elh_feature_model_id" class="feature_model_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $feature->model_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($feature->model_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($feature->model_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($feature->_thumbnail->Visible) { // thumbnail ?>
	<?php if ($feature->SortUrl($feature->_thumbnail) == "") { ?>
		<th data-name="_thumbnail" class="<?php echo $feature->_thumbnail->HeaderCellClass() ?>"><div id="elh_feature__thumbnail" class="feature__thumbnail"><div class="ewTableHeaderCaption"><?php echo $feature->_thumbnail->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_thumbnail" class="<?php echo $feature->_thumbnail->HeaderCellClass() ?>"><div><div id="elh_feature__thumbnail" class="feature__thumbnail">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $feature->_thumbnail->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($feature->_thumbnail->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($feature->_thumbnail->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($feature->f_order->Visible) { // f_order ?>
	<?php if ($feature->SortUrl($feature->f_order) == "") { ?>
		<th data-name="f_order" class="<?php echo $feature->f_order->HeaderCellClass() ?>"><div id="elh_feature_f_order" class="feature_f_order"><div class="ewTableHeaderCaption"><?php echo $feature->f_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="f_order" class="<?php echo $feature->f_order->HeaderCellClass() ?>"><div><div id="elh_feature_f_order" class="feature_f_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $feature->f_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($feature->f_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($feature->f_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$feature_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$feature_grid->StartRec = 1;
$feature_grid->StopRec = $feature_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($feature_grid->FormKeyCountName) && ($feature->CurrentAction == "gridadd" || $feature->CurrentAction == "gridedit" || $feature->CurrentAction == "F")) {
		$feature_grid->KeyCount = $objForm->GetValue($feature_grid->FormKeyCountName);
		$feature_grid->StopRec = $feature_grid->StartRec + $feature_grid->KeyCount - 1;
	}
}
$feature_grid->RecCnt = $feature_grid->StartRec - 1;
if ($feature_grid->Recordset && !$feature_grid->Recordset->EOF) {
	$feature_grid->Recordset->MoveFirst();
	$bSelectLimit = $feature_grid->UseSelectLimit;
	if (!$bSelectLimit && $feature_grid->StartRec > 1)
		$feature_grid->Recordset->Move($feature_grid->StartRec - 1);
} elseif (!$feature->AllowAddDeleteRow && $feature_grid->StopRec == 0) {
	$feature_grid->StopRec = $feature->GridAddRowCount;
}

// Initialize aggregate
$feature->RowType = EW_ROWTYPE_AGGREGATEINIT;
$feature->ResetAttrs();
$feature_grid->RenderRow();
if ($feature->CurrentAction == "gridadd")
	$feature_grid->RowIndex = 0;
if ($feature->CurrentAction == "gridedit")
	$feature_grid->RowIndex = 0;
while ($feature_grid->RecCnt < $feature_grid->StopRec) {
	$feature_grid->RecCnt++;
	if (intval($feature_grid->RecCnt) >= intval($feature_grid->StartRec)) {
		$feature_grid->RowCnt++;
		if ($feature->CurrentAction == "gridadd" || $feature->CurrentAction == "gridedit" || $feature->CurrentAction == "F") {
			$feature_grid->RowIndex++;
			$objForm->Index = $feature_grid->RowIndex;
			if ($objForm->HasValue($feature_grid->FormActionName))
				$feature_grid->RowAction = strval($objForm->GetValue($feature_grid->FormActionName));
			elseif ($feature->CurrentAction == "gridadd")
				$feature_grid->RowAction = "insert";
			else
				$feature_grid->RowAction = "";
		}

		// Set up key count
		$feature_grid->KeyCount = $feature_grid->RowIndex;

		// Init row class and style
		$feature->ResetAttrs();
		$feature->CssClass = "";
		if ($feature->CurrentAction == "gridadd") {
			if ($feature->CurrentMode == "copy") {
				$feature_grid->LoadRowValues($feature_grid->Recordset); // Load row values
				$feature_grid->SetRecordKey($feature_grid->RowOldKey, $feature_grid->Recordset); // Set old record key
			} else {
				$feature_grid->LoadRowValues(); // Load default values
				$feature_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$feature_grid->LoadRowValues($feature_grid->Recordset); // Load row values
		}
		$feature->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($feature->CurrentAction == "gridadd") // Grid add
			$feature->RowType = EW_ROWTYPE_ADD; // Render add
		if ($feature->CurrentAction == "gridadd" && $feature->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$feature_grid->RestoreCurrentRowFormValues($feature_grid->RowIndex); // Restore form values
		if ($feature->CurrentAction == "gridedit") { // Grid edit
			if ($feature->EventCancelled) {
				$feature_grid->RestoreCurrentRowFormValues($feature_grid->RowIndex); // Restore form values
			}
			if ($feature_grid->RowAction == "insert")
				$feature->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$feature->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($feature->CurrentAction == "gridedit" && ($feature->RowType == EW_ROWTYPE_EDIT || $feature->RowType == EW_ROWTYPE_ADD) && $feature->EventCancelled) // Update failed
			$feature_grid->RestoreCurrentRowFormValues($feature_grid->RowIndex); // Restore form values
		if ($feature->RowType == EW_ROWTYPE_EDIT) // Edit row
			$feature_grid->EditRowCnt++;
		if ($feature->CurrentAction == "F") // Confirm row
			$feature_grid->RestoreCurrentRowFormValues($feature_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$feature->RowAttrs = array_merge($feature->RowAttrs, array('data-rowindex'=>$feature_grid->RowCnt, 'id'=>'r' . $feature_grid->RowCnt . '_feature', 'data-rowtype'=>$feature->RowType));

		// Render row
		$feature_grid->RenderRow();

		// Render list options
		$feature_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($feature_grid->RowAction <> "delete" && $feature_grid->RowAction <> "insertdelete" && !($feature_grid->RowAction == "insert" && $feature->CurrentAction == "F" && $feature_grid->EmptyRow())) {
?>
	<tr<?php echo $feature->RowAttributes() ?>>
<?php

// Render list options (body, left)
$feature_grid->ListOptions->Render("body", "left", $feature_grid->RowCnt);
?>
	<?php if ($feature->feature_id->Visible) { // feature_id ?>
		<td data-name="feature_id"<?php echo $feature->feature_id->CellAttributes() ?>>
<?php if ($feature->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="feature" data-field="x_feature_id" name="o<?php echo $feature_grid->RowIndex ?>_feature_id" id="o<?php echo $feature_grid->RowIndex ?>_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->OldValue) ?>">
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_feature_id" class="form-group feature_feature_id">
<span<?php echo $feature->feature_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $feature->feature_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="feature" data-field="x_feature_id" name="x<?php echo $feature_grid->RowIndex ?>_feature_id" id="x<?php echo $feature_grid->RowIndex ?>_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->CurrentValue) ?>">
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_feature_id" class="feature_feature_id">
<span<?php echo $feature->feature_id->ViewAttributes() ?>>
<?php echo $feature->feature_id->ListViewValue() ?></span>
</span>
<?php if ($feature->CurrentAction <> "F") { ?>
<input type="hidden" data-table="feature" data-field="x_feature_id" name="x<?php echo $feature_grid->RowIndex ?>_feature_id" id="x<?php echo $feature_grid->RowIndex ?>_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->FormValue) ?>">
<input type="hidden" data-table="feature" data-field="x_feature_id" name="o<?php echo $feature_grid->RowIndex ?>_feature_id" id="o<?php echo $feature_grid->RowIndex ?>_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="feature" data-field="x_feature_id" name="ffeaturegrid$x<?php echo $feature_grid->RowIndex ?>_feature_id" id="ffeaturegrid$x<?php echo $feature_grid->RowIndex ?>_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->FormValue) ?>">
<input type="hidden" data-table="feature" data-field="x_feature_id" name="ffeaturegrid$o<?php echo $feature_grid->RowIndex ?>_feature_id" id="ffeaturegrid$o<?php echo $feature_grid->RowIndex ?>_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($feature->top_title->Visible) { // top_title ?>
		<td data-name="top_title"<?php echo $feature->top_title->CellAttributes() ?>>
<?php if ($feature->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_top_title" class="form-group feature_top_title">
<input type="text" data-table="feature" data-field="x_top_title" name="x<?php echo $feature_grid->RowIndex ?>_top_title" id="x<?php echo $feature_grid->RowIndex ?>_top_title" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($feature->top_title->getPlaceHolder()) ?>" value="<?php echo $feature->top_title->EditValue ?>"<?php echo $feature->top_title->EditAttributes() ?>>
</span>
<input type="hidden" data-table="feature" data-field="x_top_title" name="o<?php echo $feature_grid->RowIndex ?>_top_title" id="o<?php echo $feature_grid->RowIndex ?>_top_title" value="<?php echo ew_HtmlEncode($feature->top_title->OldValue) ?>">
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_top_title" class="form-group feature_top_title">
<input type="text" data-table="feature" data-field="x_top_title" name="x<?php echo $feature_grid->RowIndex ?>_top_title" id="x<?php echo $feature_grid->RowIndex ?>_top_title" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($feature->top_title->getPlaceHolder()) ?>" value="<?php echo $feature->top_title->EditValue ?>"<?php echo $feature->top_title->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_top_title" class="feature_top_title">
<span<?php echo $feature->top_title->ViewAttributes() ?>>
<?php echo $feature->top_title->ListViewValue() ?></span>
</span>
<?php if ($feature->CurrentAction <> "F") { ?>
<input type="hidden" data-table="feature" data-field="x_top_title" name="x<?php echo $feature_grid->RowIndex ?>_top_title" id="x<?php echo $feature_grid->RowIndex ?>_top_title" value="<?php echo ew_HtmlEncode($feature->top_title->FormValue) ?>">
<input type="hidden" data-table="feature" data-field="x_top_title" name="o<?php echo $feature_grid->RowIndex ?>_top_title" id="o<?php echo $feature_grid->RowIndex ?>_top_title" value="<?php echo ew_HtmlEncode($feature->top_title->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="feature" data-field="x_top_title" name="ffeaturegrid$x<?php echo $feature_grid->RowIndex ?>_top_title" id="ffeaturegrid$x<?php echo $feature_grid->RowIndex ?>_top_title" value="<?php echo ew_HtmlEncode($feature->top_title->FormValue) ?>">
<input type="hidden" data-table="feature" data-field="x_top_title" name="ffeaturegrid$o<?php echo $feature_grid->RowIndex ?>_top_title" id="ffeaturegrid$o<?php echo $feature_grid->RowIndex ?>_top_title" value="<?php echo ew_HtmlEncode($feature->top_title->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($feature->title->Visible) { // title ?>
		<td data-name="title"<?php echo $feature->title->CellAttributes() ?>>
<?php if ($feature->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_title" class="form-group feature_title">
<input type="text" data-table="feature" data-field="x_title" name="x<?php echo $feature_grid->RowIndex ?>_title" id="x<?php echo $feature_grid->RowIndex ?>_title" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($feature->title->getPlaceHolder()) ?>" value="<?php echo $feature->title->EditValue ?>"<?php echo $feature->title->EditAttributes() ?>>
</span>
<input type="hidden" data-table="feature" data-field="x_title" name="o<?php echo $feature_grid->RowIndex ?>_title" id="o<?php echo $feature_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($feature->title->OldValue) ?>">
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_title" class="form-group feature_title">
<input type="text" data-table="feature" data-field="x_title" name="x<?php echo $feature_grid->RowIndex ?>_title" id="x<?php echo $feature_grid->RowIndex ?>_title" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($feature->title->getPlaceHolder()) ?>" value="<?php echo $feature->title->EditValue ?>"<?php echo $feature->title->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_title" class="feature_title">
<span<?php echo $feature->title->ViewAttributes() ?>>
<?php echo $feature->title->ListViewValue() ?></span>
</span>
<?php if ($feature->CurrentAction <> "F") { ?>
<input type="hidden" data-table="feature" data-field="x_title" name="x<?php echo $feature_grid->RowIndex ?>_title" id="x<?php echo $feature_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($feature->title->FormValue) ?>">
<input type="hidden" data-table="feature" data-field="x_title" name="o<?php echo $feature_grid->RowIndex ?>_title" id="o<?php echo $feature_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($feature->title->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="feature" data-field="x_title" name="ffeaturegrid$x<?php echo $feature_grid->RowIndex ?>_title" id="ffeaturegrid$x<?php echo $feature_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($feature->title->FormValue) ?>">
<input type="hidden" data-table="feature" data-field="x_title" name="ffeaturegrid$o<?php echo $feature_grid->RowIndex ?>_title" id="ffeaturegrid$o<?php echo $feature_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($feature->title->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($feature->model_id->Visible) { // model_id ?>
		<td data-name="model_id"<?php echo $feature->model_id->CellAttributes() ?>>
<?php if ($feature->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($feature->model_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_model_id" class="form-group feature_model_id">
<span<?php echo $feature->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $feature->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $feature_grid->RowIndex ?>_model_id" name="x<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_model_id" class="form-group feature_model_id">
<select data-table="feature" data-field="x_model_id" data-value-separator="<?php echo $feature->model_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $feature_grid->RowIndex ?>_model_id" name="x<?php echo $feature_grid->RowIndex ?>_model_id"<?php echo $feature->model_id->EditAttributes() ?>>
<?php echo $feature->model_id->SelectOptionListHtml("x<?php echo $feature_grid->RowIndex ?>_model_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="feature" data-field="x_model_id" name="o<?php echo $feature_grid->RowIndex ?>_model_id" id="o<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->OldValue) ?>">
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($feature->model_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_model_id" class="form-group feature_model_id">
<span<?php echo $feature->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $feature->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $feature_grid->RowIndex ?>_model_id" name="x<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_model_id" class="form-group feature_model_id">
<select data-table="feature" data-field="x_model_id" data-value-separator="<?php echo $feature->model_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $feature_grid->RowIndex ?>_model_id" name="x<?php echo $feature_grid->RowIndex ?>_model_id"<?php echo $feature->model_id->EditAttributes() ?>>
<?php echo $feature->model_id->SelectOptionListHtml("x<?php echo $feature_grid->RowIndex ?>_model_id") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_model_id" class="feature_model_id">
<span<?php echo $feature->model_id->ViewAttributes() ?>>
<?php echo $feature->model_id->ListViewValue() ?></span>
</span>
<?php if ($feature->CurrentAction <> "F") { ?>
<input type="hidden" data-table="feature" data-field="x_model_id" name="x<?php echo $feature_grid->RowIndex ?>_model_id" id="x<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->FormValue) ?>">
<input type="hidden" data-table="feature" data-field="x_model_id" name="o<?php echo $feature_grid->RowIndex ?>_model_id" id="o<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="feature" data-field="x_model_id" name="ffeaturegrid$x<?php echo $feature_grid->RowIndex ?>_model_id" id="ffeaturegrid$x<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->FormValue) ?>">
<input type="hidden" data-table="feature" data-field="x_model_id" name="ffeaturegrid$o<?php echo $feature_grid->RowIndex ?>_model_id" id="ffeaturegrid$o<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($feature->_thumbnail->Visible) { // thumbnail ?>
		<td data-name="_thumbnail"<?php echo $feature->_thumbnail->CellAttributes() ?>>
<?php if ($feature_grid->RowAction == "insert") { // Add record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature__thumbnail" class="form-group feature__thumbnail">
<div id="fd_x<?php echo $feature_grid->RowIndex ?>__thumbnail">
<span title="<?php echo $feature->_thumbnail->FldTitle() ? $feature->_thumbnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($feature->_thumbnail->ReadOnly || $feature->_thumbnail->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="feature" data-field="x__thumbnail" name="x<?php echo $feature_grid->RowIndex ?>__thumbnail" id="x<?php echo $feature_grid->RowIndex ?>__thumbnail"<?php echo $feature->_thumbnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fn_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="<?php echo $feature->_thumbnail->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fa_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="0">
<input type="hidden" name="fs_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fs_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="150">
<input type="hidden" name="fx_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fx_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="<?php echo $feature->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fm_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="<?php echo $feature->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $feature_grid->RowIndex ?>__thumbnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="feature" data-field="x__thumbnail" name="o<?php echo $feature_grid->RowIndex ?>__thumbnail" id="o<?php echo $feature_grid->RowIndex ?>__thumbnail" value="<?php echo ew_HtmlEncode($feature->_thumbnail->OldValue) ?>">
<?php } elseif ($feature->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature__thumbnail" class="feature__thumbnail">
<span>
<?php echo ew_GetFileViewTag($feature->_thumbnail, $feature->_thumbnail->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature__thumbnail" class="form-group feature__thumbnail">
<div id="fd_x<?php echo $feature_grid->RowIndex ?>__thumbnail">
<span title="<?php echo $feature->_thumbnail->FldTitle() ? $feature->_thumbnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($feature->_thumbnail->ReadOnly || $feature->_thumbnail->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="feature" data-field="x__thumbnail" name="x<?php echo $feature_grid->RowIndex ?>__thumbnail" id="x<?php echo $feature_grid->RowIndex ?>__thumbnail"<?php echo $feature->_thumbnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fn_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="<?php echo $feature->_thumbnail->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $feature_grid->RowIndex ?>__thumbnail"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fa_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fa_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fs_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="150">
<input type="hidden" name="fx_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fx_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="<?php echo $feature->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fm_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="<?php echo $feature->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $feature_grid->RowIndex ?>__thumbnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($feature->f_order->Visible) { // f_order ?>
		<td data-name="f_order"<?php echo $feature->f_order->CellAttributes() ?>>
<?php if ($feature->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_f_order" class="form-group feature_f_order">
<input type="text" data-table="feature" data-field="x_f_order" name="x<?php echo $feature_grid->RowIndex ?>_f_order" id="x<?php echo $feature_grid->RowIndex ?>_f_order" size="30" placeholder="<?php echo ew_HtmlEncode($feature->f_order->getPlaceHolder()) ?>" value="<?php echo $feature->f_order->EditValue ?>"<?php echo $feature->f_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="feature" data-field="x_f_order" name="o<?php echo $feature_grid->RowIndex ?>_f_order" id="o<?php echo $feature_grid->RowIndex ?>_f_order" value="<?php echo ew_HtmlEncode($feature->f_order->OldValue) ?>">
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_f_order" class="form-group feature_f_order">
<input type="text" data-table="feature" data-field="x_f_order" name="x<?php echo $feature_grid->RowIndex ?>_f_order" id="x<?php echo $feature_grid->RowIndex ?>_f_order" size="30" placeholder="<?php echo ew_HtmlEncode($feature->f_order->getPlaceHolder()) ?>" value="<?php echo $feature->f_order->EditValue ?>"<?php echo $feature->f_order->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $feature_grid->RowCnt ?>_feature_f_order" class="feature_f_order">
<span<?php echo $feature->f_order->ViewAttributes() ?>>
<?php echo $feature->f_order->ListViewValue() ?></span>
</span>
<?php if ($feature->CurrentAction <> "F") { ?>
<input type="hidden" data-table="feature" data-field="x_f_order" name="x<?php echo $feature_grid->RowIndex ?>_f_order" id="x<?php echo $feature_grid->RowIndex ?>_f_order" value="<?php echo ew_HtmlEncode($feature->f_order->FormValue) ?>">
<input type="hidden" data-table="feature" data-field="x_f_order" name="o<?php echo $feature_grid->RowIndex ?>_f_order" id="o<?php echo $feature_grid->RowIndex ?>_f_order" value="<?php echo ew_HtmlEncode($feature->f_order->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="feature" data-field="x_f_order" name="ffeaturegrid$x<?php echo $feature_grid->RowIndex ?>_f_order" id="ffeaturegrid$x<?php echo $feature_grid->RowIndex ?>_f_order" value="<?php echo ew_HtmlEncode($feature->f_order->FormValue) ?>">
<input type="hidden" data-table="feature" data-field="x_f_order" name="ffeaturegrid$o<?php echo $feature_grid->RowIndex ?>_f_order" id="ffeaturegrid$o<?php echo $feature_grid->RowIndex ?>_f_order" value="<?php echo ew_HtmlEncode($feature->f_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$feature_grid->ListOptions->Render("body", "right", $feature_grid->RowCnt);
?>
	</tr>
<?php if ($feature->RowType == EW_ROWTYPE_ADD || $feature->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
ffeaturegrid.UpdateOpts(<?php echo $feature_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($feature->CurrentAction <> "gridadd" || $feature->CurrentMode == "copy")
		if (!$feature_grid->Recordset->EOF) $feature_grid->Recordset->MoveNext();
}
?>
<?php
	if ($feature->CurrentMode == "add" || $feature->CurrentMode == "copy" || $feature->CurrentMode == "edit") {
		$feature_grid->RowIndex = '$rowindex$';
		$feature_grid->LoadRowValues();

		// Set row properties
		$feature->ResetAttrs();
		$feature->RowAttrs = array_merge($feature->RowAttrs, array('data-rowindex'=>$feature_grid->RowIndex, 'id'=>'r0_feature', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($feature->RowAttrs["class"], "ewTemplate");
		$feature->RowType = EW_ROWTYPE_ADD;

		// Render row
		$feature_grid->RenderRow();

		// Render list options
		$feature_grid->RenderListOptions();
		$feature_grid->StartRowCnt = 0;
?>
	<tr<?php echo $feature->RowAttributes() ?>>
<?php

// Render list options (body, left)
$feature_grid->ListOptions->Render("body", "left", $feature_grid->RowIndex);
?>
	<?php if ($feature->feature_id->Visible) { // feature_id ?>
		<td data-name="feature_id">
<?php if ($feature->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_feature_feature_id" class="form-group feature_feature_id">
<span<?php echo $feature->feature_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $feature->feature_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="feature" data-field="x_feature_id" name="x<?php echo $feature_grid->RowIndex ?>_feature_id" id="x<?php echo $feature_grid->RowIndex ?>_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="feature" data-field="x_feature_id" name="o<?php echo $feature_grid->RowIndex ?>_feature_id" id="o<?php echo $feature_grid->RowIndex ?>_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($feature->top_title->Visible) { // top_title ?>
		<td data-name="top_title">
<?php if ($feature->CurrentAction <> "F") { ?>
<span id="el$rowindex$_feature_top_title" class="form-group feature_top_title">
<input type="text" data-table="feature" data-field="x_top_title" name="x<?php echo $feature_grid->RowIndex ?>_top_title" id="x<?php echo $feature_grid->RowIndex ?>_top_title" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($feature->top_title->getPlaceHolder()) ?>" value="<?php echo $feature->top_title->EditValue ?>"<?php echo $feature->top_title->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_feature_top_title" class="form-group feature_top_title">
<span<?php echo $feature->top_title->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $feature->top_title->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="feature" data-field="x_top_title" name="x<?php echo $feature_grid->RowIndex ?>_top_title" id="x<?php echo $feature_grid->RowIndex ?>_top_title" value="<?php echo ew_HtmlEncode($feature->top_title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="feature" data-field="x_top_title" name="o<?php echo $feature_grid->RowIndex ?>_top_title" id="o<?php echo $feature_grid->RowIndex ?>_top_title" value="<?php echo ew_HtmlEncode($feature->top_title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($feature->title->Visible) { // title ?>
		<td data-name="title">
<?php if ($feature->CurrentAction <> "F") { ?>
<span id="el$rowindex$_feature_title" class="form-group feature_title">
<input type="text" data-table="feature" data-field="x_title" name="x<?php echo $feature_grid->RowIndex ?>_title" id="x<?php echo $feature_grid->RowIndex ?>_title" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($feature->title->getPlaceHolder()) ?>" value="<?php echo $feature->title->EditValue ?>"<?php echo $feature->title->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_feature_title" class="form-group feature_title">
<span<?php echo $feature->title->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $feature->title->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="feature" data-field="x_title" name="x<?php echo $feature_grid->RowIndex ?>_title" id="x<?php echo $feature_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($feature->title->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="feature" data-field="x_title" name="o<?php echo $feature_grid->RowIndex ?>_title" id="o<?php echo $feature_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($feature->title->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($feature->model_id->Visible) { // model_id ?>
		<td data-name="model_id">
<?php if ($feature->CurrentAction <> "F") { ?>
<?php if ($feature->model_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_feature_model_id" class="form-group feature_model_id">
<span<?php echo $feature->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $feature->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $feature_grid->RowIndex ?>_model_id" name="x<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_feature_model_id" class="form-group feature_model_id">
<select data-table="feature" data-field="x_model_id" data-value-separator="<?php echo $feature->model_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $feature_grid->RowIndex ?>_model_id" name="x<?php echo $feature_grid->RowIndex ?>_model_id"<?php echo $feature->model_id->EditAttributes() ?>>
<?php echo $feature->model_id->SelectOptionListHtml("x<?php echo $feature_grid->RowIndex ?>_model_id") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_feature_model_id" class="form-group feature_model_id">
<span<?php echo $feature->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $feature->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="feature" data-field="x_model_id" name="x<?php echo $feature_grid->RowIndex ?>_model_id" id="x<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="feature" data-field="x_model_id" name="o<?php echo $feature_grid->RowIndex ?>_model_id" id="o<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($feature->_thumbnail->Visible) { // thumbnail ?>
		<td data-name="_thumbnail">
<span id="el$rowindex$_feature__thumbnail" class="form-group feature__thumbnail">
<div id="fd_x<?php echo $feature_grid->RowIndex ?>__thumbnail">
<span title="<?php echo $feature->_thumbnail->FldTitle() ? $feature->_thumbnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($feature->_thumbnail->ReadOnly || $feature->_thumbnail->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="feature" data-field="x__thumbnail" name="x<?php echo $feature_grid->RowIndex ?>__thumbnail" id="x<?php echo $feature_grid->RowIndex ?>__thumbnail"<?php echo $feature->_thumbnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fn_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="<?php echo $feature->_thumbnail->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fa_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="0">
<input type="hidden" name="fs_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fs_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="150">
<input type="hidden" name="fx_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fx_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="<?php echo $feature->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $feature_grid->RowIndex ?>__thumbnail" id= "fm_x<?php echo $feature_grid->RowIndex ?>__thumbnail" value="<?php echo $feature->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $feature_grid->RowIndex ?>__thumbnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="feature" data-field="x__thumbnail" name="o<?php echo $feature_grid->RowIndex ?>__thumbnail" id="o<?php echo $feature_grid->RowIndex ?>__thumbnail" value="<?php echo ew_HtmlEncode($feature->_thumbnail->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($feature->f_order->Visible) { // f_order ?>
		<td data-name="f_order">
<?php if ($feature->CurrentAction <> "F") { ?>
<span id="el$rowindex$_feature_f_order" class="form-group feature_f_order">
<input type="text" data-table="feature" data-field="x_f_order" name="x<?php echo $feature_grid->RowIndex ?>_f_order" id="x<?php echo $feature_grid->RowIndex ?>_f_order" size="30" placeholder="<?php echo ew_HtmlEncode($feature->f_order->getPlaceHolder()) ?>" value="<?php echo $feature->f_order->EditValue ?>"<?php echo $feature->f_order->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_feature_f_order" class="form-group feature_f_order">
<span<?php echo $feature->f_order->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $feature->f_order->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="feature" data-field="x_f_order" name="x<?php echo $feature_grid->RowIndex ?>_f_order" id="x<?php echo $feature_grid->RowIndex ?>_f_order" value="<?php echo ew_HtmlEncode($feature->f_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="feature" data-field="x_f_order" name="o<?php echo $feature_grid->RowIndex ?>_f_order" id="o<?php echo $feature_grid->RowIndex ?>_f_order" value="<?php echo ew_HtmlEncode($feature->f_order->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$feature_grid->ListOptions->Render("body", "right", $feature_grid->RowIndex);
?>
<script type="text/javascript">
ffeaturegrid.UpdateOpts(<?php echo $feature_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($feature->CurrentMode == "add" || $feature->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $feature_grid->FormKeyCountName ?>" id="<?php echo $feature_grid->FormKeyCountName ?>" value="<?php echo $feature_grid->KeyCount ?>">
<?php echo $feature_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($feature->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $feature_grid->FormKeyCountName ?>" id="<?php echo $feature_grid->FormKeyCountName ?>" value="<?php echo $feature_grid->KeyCount ?>">
<?php echo $feature_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($feature->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="ffeaturegrid">
</div>
<?php

// Close recordset
if ($feature_grid->Recordset)
	$feature_grid->Recordset->Close();
?>
<?php if ($feature_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($feature_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($feature_grid->TotalRecs == 0 && $feature->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($feature_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($feature->Export == "") { ?>
<script type="text/javascript">
ffeaturegrid.Init();
</script>
<?php } ?>
<?php
$feature_grid->Page_Terminate();
?>
