<?php include_once "admin_userinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($model_grid)) $model_grid = new cmodel_grid();

// Page init
$model_grid->Page_Init();

// Page main
$model_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$model_grid->Page_Render();
?>
<?php if ($model->Export == "") { ?>
<script type="text/javascript">

// Form object
var fmodelgrid = new ew_Form("fmodelgrid", "grid");
fmodelgrid.FormKeyCountName = '<?php echo $model_grid->FormKeyCountName ?>';

// Validate form
fmodelgrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_model_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model->model_name->FldCaption(), $model->model_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_price");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model->price->FldCaption(), $model->price->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_price");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($model->price->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_model_year");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model->model_year->FldCaption(), $model->model_year->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "__thumbnail");
			elm = this.GetElements("fn_x" + infix + "__thumbnail");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $model->_thumbnail->FldCaption(), $model->_thumbnail->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_category_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model->category_id->FldCaption(), $model->category_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_m_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model->m_order->FldCaption(), $model->m_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_m_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($model->m_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model->status->FldCaption(), $model->status->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	return true;
}

// Check empty row
fmodelgrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "model_name", false)) return false;
	if (ew_ValueChanged(fobj, infix, "price", false)) return false;
	if (ew_ValueChanged(fobj, infix, "model_year", false)) return false;
	if (ew_ValueChanged(fobj, infix, "_thumbnail", false)) return false;
	if (ew_ValueChanged(fobj, infix, "category_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "m_order", false)) return false;
	if (ew_ValueChanged(fobj, infix, "status", false)) return false;
	if (ew_ValueChanged(fobj, infix, "is_feature", false)) return false;
	if (ew_ValueChanged(fobj, infix, "is_available", false)) return false;
	return true;
}

// Form_CustomValidate event
fmodelgrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fmodelgrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fmodelgrid.Lists["x_category_id"] = {"LinkField":"x_category_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_category_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"model_category"};
fmodelgrid.Lists["x_category_id"].Data = "<?php echo $model_grid->category_id->LookupFilterQuery(FALSE, "grid") ?>";
fmodelgrid.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodelgrid.Lists["x_status"].Options = <?php echo json_encode($model_grid->status->Options()) ?>;
fmodelgrid.Lists["x_is_feature"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodelgrid.Lists["x_is_feature"].Options = <?php echo json_encode($model_grid->is_feature->Options()) ?>;
fmodelgrid.Lists["x_is_available"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodelgrid.Lists["x_is_available"].Options = <?php echo json_encode($model_grid->is_available->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($model->CurrentAction == "gridadd") {
	if ($model->CurrentMode == "copy") {
		$bSelectLimit = $model_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$model_grid->TotalRecs = $model->ListRecordCount();
			$model_grid->Recordset = $model_grid->LoadRecordset($model_grid->StartRec-1, $model_grid->DisplayRecs);
		} else {
			if ($model_grid->Recordset = $model_grid->LoadRecordset())
				$model_grid->TotalRecs = $model_grid->Recordset->RecordCount();
		}
		$model_grid->StartRec = 1;
		$model_grid->DisplayRecs = $model_grid->TotalRecs;
	} else {
		$model->CurrentFilter = "0=1";
		$model_grid->StartRec = 1;
		$model_grid->DisplayRecs = $model->GridAddRowCount;
	}
	$model_grid->TotalRecs = $model_grid->DisplayRecs;
	$model_grid->StopRec = $model_grid->DisplayRecs;
} else {
	$bSelectLimit = $model_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($model_grid->TotalRecs <= 0)
			$model_grid->TotalRecs = $model->ListRecordCount();
	} else {
		if (!$model_grid->Recordset && ($model_grid->Recordset = $model_grid->LoadRecordset()))
			$model_grid->TotalRecs = $model_grid->Recordset->RecordCount();
	}
	$model_grid->StartRec = 1;
	$model_grid->DisplayRecs = $model_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$model_grid->Recordset = $model_grid->LoadRecordset($model_grid->StartRec-1, $model_grid->DisplayRecs);

	// Set no record found message
	if ($model->CurrentAction == "" && $model_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$model_grid->setWarningMessage(ew_DeniedMsg());
		if ($model_grid->SearchWhere == "0=101")
			$model_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$model_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$model_grid->RenderOtherOptions();
?>
<?php $model_grid->ShowPageHeader(); ?>
<?php
$model_grid->ShowMessage();
?>
<?php if ($model_grid->TotalRecs > 0 || $model->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($model_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> model">
<div id="fmodelgrid" class="ewForm ewListForm form-inline">
<?php if ($model_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($model_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_model" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_modelgrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$model_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$model_grid->RenderListOptions();

// Render list options (header, left)
$model_grid->ListOptions->Render("header", "left");
?>
<?php if ($model->model_id->Visible) { // model_id ?>
	<?php if ($model->SortUrl($model->model_id) == "") { ?>
		<th data-name="model_id" class="<?php echo $model->model_id->HeaderCellClass() ?>"><div id="elh_model_model_id" class="model_model_id"><div class="ewTableHeaderCaption"><?php echo $model->model_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="model_id" class="<?php echo $model->model_id->HeaderCellClass() ?>"><div><div id="elh_model_model_id" class="model_model_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->model_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->model_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->model_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->model_name->Visible) { // model_name ?>
	<?php if ($model->SortUrl($model->model_name) == "") { ?>
		<th data-name="model_name" class="<?php echo $model->model_name->HeaderCellClass() ?>"><div id="elh_model_model_name" class="model_model_name"><div class="ewTableHeaderCaption"><?php echo $model->model_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="model_name" class="<?php echo $model->model_name->HeaderCellClass() ?>"><div><div id="elh_model_model_name" class="model_model_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->model_name->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->model_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->model_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->price->Visible) { // price ?>
	<?php if ($model->SortUrl($model->price) == "") { ?>
		<th data-name="price" class="<?php echo $model->price->HeaderCellClass() ?>"><div id="elh_model_price" class="model_price"><div class="ewTableHeaderCaption"><?php echo $model->price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="price" class="<?php echo $model->price->HeaderCellClass() ?>"><div><div id="elh_model_price" class="model_price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->model_year->Visible) { // model_year ?>
	<?php if ($model->SortUrl($model->model_year) == "") { ?>
		<th data-name="model_year" class="<?php echo $model->model_year->HeaderCellClass() ?>"><div id="elh_model_model_year" class="model_model_year"><div class="ewTableHeaderCaption"><?php echo $model->model_year->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="model_year" class="<?php echo $model->model_year->HeaderCellClass() ?>"><div><div id="elh_model_model_year" class="model_model_year">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->model_year->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->model_year->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->model_year->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->_thumbnail->Visible) { // thumbnail ?>
	<?php if ($model->SortUrl($model->_thumbnail) == "") { ?>
		<th data-name="_thumbnail" class="<?php echo $model->_thumbnail->HeaderCellClass() ?>"><div id="elh_model__thumbnail" class="model__thumbnail"><div class="ewTableHeaderCaption"><?php echo $model->_thumbnail->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_thumbnail" class="<?php echo $model->_thumbnail->HeaderCellClass() ?>"><div><div id="elh_model__thumbnail" class="model__thumbnail">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->_thumbnail->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->_thumbnail->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->_thumbnail->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->category_id->Visible) { // category_id ?>
	<?php if ($model->SortUrl($model->category_id) == "") { ?>
		<th data-name="category_id" class="<?php echo $model->category_id->HeaderCellClass() ?>"><div id="elh_model_category_id" class="model_category_id"><div class="ewTableHeaderCaption"><?php echo $model->category_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="category_id" class="<?php echo $model->category_id->HeaderCellClass() ?>"><div><div id="elh_model_category_id" class="model_category_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->category_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->category_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->category_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->m_order->Visible) { // m_order ?>
	<?php if ($model->SortUrl($model->m_order) == "") { ?>
		<th data-name="m_order" class="<?php echo $model->m_order->HeaderCellClass() ?>"><div id="elh_model_m_order" class="model_m_order"><div class="ewTableHeaderCaption"><?php echo $model->m_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="m_order" class="<?php echo $model->m_order->HeaderCellClass() ?>"><div><div id="elh_model_m_order" class="model_m_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->m_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->m_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->m_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->status->Visible) { // status ?>
	<?php if ($model->SortUrl($model->status) == "") { ?>
		<th data-name="status" class="<?php echo $model->status->HeaderCellClass() ?>"><div id="elh_model_status" class="model_status"><div class="ewTableHeaderCaption"><?php echo $model->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $model->status->HeaderCellClass() ?>"><div><div id="elh_model_status" class="model_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->is_feature->Visible) { // is_feature ?>
	<?php if ($model->SortUrl($model->is_feature) == "") { ?>
		<th data-name="is_feature" class="<?php echo $model->is_feature->HeaderCellClass() ?>"><div id="elh_model_is_feature" class="model_is_feature"><div class="ewTableHeaderCaption"><?php echo $model->is_feature->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="is_feature" class="<?php echo $model->is_feature->HeaderCellClass() ?>"><div><div id="elh_model_is_feature" class="model_is_feature">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->is_feature->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->is_feature->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->is_feature->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->is_available->Visible) { // is_available ?>
	<?php if ($model->SortUrl($model->is_available) == "") { ?>
		<th data-name="is_available" class="<?php echo $model->is_available->HeaderCellClass() ?>"><div id="elh_model_is_available" class="model_is_available"><div class="ewTableHeaderCaption"><?php echo $model->is_available->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="is_available" class="<?php echo $model->is_available->HeaderCellClass() ?>"><div><div id="elh_model_is_available" class="model_is_available">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->is_available->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->is_available->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->is_available->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$model_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$model_grid->StartRec = 1;
$model_grid->StopRec = $model_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($model_grid->FormKeyCountName) && ($model->CurrentAction == "gridadd" || $model->CurrentAction == "gridedit" || $model->CurrentAction == "F")) {
		$model_grid->KeyCount = $objForm->GetValue($model_grid->FormKeyCountName);
		$model_grid->StopRec = $model_grid->StartRec + $model_grid->KeyCount - 1;
	}
}
$model_grid->RecCnt = $model_grid->StartRec - 1;
if ($model_grid->Recordset && !$model_grid->Recordset->EOF) {
	$model_grid->Recordset->MoveFirst();
	$bSelectLimit = $model_grid->UseSelectLimit;
	if (!$bSelectLimit && $model_grid->StartRec > 1)
		$model_grid->Recordset->Move($model_grid->StartRec - 1);
} elseif (!$model->AllowAddDeleteRow && $model_grid->StopRec == 0) {
	$model_grid->StopRec = $model->GridAddRowCount;
}

// Initialize aggregate
$model->RowType = EW_ROWTYPE_AGGREGATEINIT;
$model->ResetAttrs();
$model_grid->RenderRow();
if ($model->CurrentAction == "gridadd")
	$model_grid->RowIndex = 0;
if ($model->CurrentAction == "gridedit")
	$model_grid->RowIndex = 0;
while ($model_grid->RecCnt < $model_grid->StopRec) {
	$model_grid->RecCnt++;
	if (intval($model_grid->RecCnt) >= intval($model_grid->StartRec)) {
		$model_grid->RowCnt++;
		if ($model->CurrentAction == "gridadd" || $model->CurrentAction == "gridedit" || $model->CurrentAction == "F") {
			$model_grid->RowIndex++;
			$objForm->Index = $model_grid->RowIndex;
			if ($objForm->HasValue($model_grid->FormActionName))
				$model_grid->RowAction = strval($objForm->GetValue($model_grid->FormActionName));
			elseif ($model->CurrentAction == "gridadd")
				$model_grid->RowAction = "insert";
			else
				$model_grid->RowAction = "";
		}

		// Set up key count
		$model_grid->KeyCount = $model_grid->RowIndex;

		// Init row class and style
		$model->ResetAttrs();
		$model->CssClass = "";
		if ($model->CurrentAction == "gridadd") {
			if ($model->CurrentMode == "copy") {
				$model_grid->LoadRowValues($model_grid->Recordset); // Load row values
				$model_grid->SetRecordKey($model_grid->RowOldKey, $model_grid->Recordset); // Set old record key
			} else {
				$model_grid->LoadRowValues(); // Load default values
				$model_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
			$model_grid->LoadRowValues($model_grid->Recordset); // Load row values
		}
		$model->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($model->CurrentAction == "gridadd") // Grid add
			$model->RowType = EW_ROWTYPE_ADD; // Render add
		if ($model->CurrentAction == "gridadd" && $model->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$model_grid->RestoreCurrentRowFormValues($model_grid->RowIndex); // Restore form values
		if ($model->CurrentAction == "gridedit") { // Grid edit
			if ($model->EventCancelled) {
				$model_grid->RestoreCurrentRowFormValues($model_grid->RowIndex); // Restore form values
			}
			if ($model_grid->RowAction == "insert")
				$model->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$model->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($model->CurrentAction == "gridedit" && ($model->RowType == EW_ROWTYPE_EDIT || $model->RowType == EW_ROWTYPE_ADD) && $model->EventCancelled) // Update failed
			$model_grid->RestoreCurrentRowFormValues($model_grid->RowIndex); // Restore form values
		if ($model->RowType == EW_ROWTYPE_EDIT) // Edit row
			$model_grid->EditRowCnt++;
		if ($model->CurrentAction == "F") // Confirm row
			$model_grid->RestoreCurrentRowFormValues($model_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$model->RowAttrs = array_merge($model->RowAttrs, array('data-rowindex'=>$model_grid->RowCnt, 'id'=>'r' . $model_grid->RowCnt . '_model', 'data-rowtype'=>$model->RowType));

		// Render row
		$model_grid->RenderRow();

		// Render list options
		$model_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($model_grid->RowAction <> "delete" && $model_grid->RowAction <> "insertdelete" && !($model_grid->RowAction == "insert" && $model->CurrentAction == "F" && $model_grid->EmptyRow())) {
?>
	<tr<?php echo $model->RowAttributes() ?>>
<?php

// Render list options (body, left)
$model_grid->ListOptions->Render("body", "left", $model_grid->RowCnt);
?>
	<?php if ($model->model_id->Visible) { // model_id ?>
		<td data-name="model_id"<?php echo $model->model_id->CellAttributes() ?>>
<?php if ($model->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="model" data-field="x_model_id" name="o<?php echo $model_grid->RowIndex ?>_model_id" id="o<?php echo $model_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model->model_id->OldValue) ?>">
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_model_id" class="form-group model_model_id">
<span<?php echo $model->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->model_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="model" data-field="x_model_id" name="x<?php echo $model_grid->RowIndex ?>_model_id" id="x<?php echo $model_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model->model_id->CurrentValue) ?>">
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_model_id" class="model_model_id">
<span<?php echo $model->model_id->ViewAttributes() ?>>
<?php echo $model->model_id->ListViewValue() ?></span>
</span>
<?php if ($model->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model" data-field="x_model_id" name="x<?php echo $model_grid->RowIndex ?>_model_id" id="x<?php echo $model_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model->model_id->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_model_id" name="o<?php echo $model_grid->RowIndex ?>_model_id" id="o<?php echo $model_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model->model_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model" data-field="x_model_id" name="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_model_id" id="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model->model_id->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_model_id" name="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_model_id" id="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model->model_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model->model_name->Visible) { // model_name ?>
		<td data-name="model_name"<?php echo $model->model_name->CellAttributes() ?>>
<?php if ($model->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_model_name" class="form-group model_model_name">
<input type="text" data-table="model" data-field="x_model_name" name="x<?php echo $model_grid->RowIndex ?>_model_name" id="x<?php echo $model_grid->RowIndex ?>_model_name" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($model->model_name->getPlaceHolder()) ?>" value="<?php echo $model->model_name->EditValue ?>"<?php echo $model->model_name->EditAttributes() ?>>
</span>
<input type="hidden" data-table="model" data-field="x_model_name" name="o<?php echo $model_grid->RowIndex ?>_model_name" id="o<?php echo $model_grid->RowIndex ?>_model_name" value="<?php echo ew_HtmlEncode($model->model_name->OldValue) ?>">
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_model_name" class="form-group model_model_name">
<input type="text" data-table="model" data-field="x_model_name" name="x<?php echo $model_grid->RowIndex ?>_model_name" id="x<?php echo $model_grid->RowIndex ?>_model_name" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($model->model_name->getPlaceHolder()) ?>" value="<?php echo $model->model_name->EditValue ?>"<?php echo $model->model_name->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_model_name" class="model_model_name">
<span<?php echo $model->model_name->ViewAttributes() ?>>
<?php echo $model->model_name->ListViewValue() ?></span>
</span>
<?php if ($model->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model" data-field="x_model_name" name="x<?php echo $model_grid->RowIndex ?>_model_name" id="x<?php echo $model_grid->RowIndex ?>_model_name" value="<?php echo ew_HtmlEncode($model->model_name->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_model_name" name="o<?php echo $model_grid->RowIndex ?>_model_name" id="o<?php echo $model_grid->RowIndex ?>_model_name" value="<?php echo ew_HtmlEncode($model->model_name->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model" data-field="x_model_name" name="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_model_name" id="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_model_name" value="<?php echo ew_HtmlEncode($model->model_name->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_model_name" name="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_model_name" id="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_model_name" value="<?php echo ew_HtmlEncode($model->model_name->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model->price->Visible) { // price ?>
		<td data-name="price"<?php echo $model->price->CellAttributes() ?>>
<?php if ($model->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_price" class="form-group model_price">
<input type="text" data-table="model" data-field="x_price" name="x<?php echo $model_grid->RowIndex ?>_price" id="x<?php echo $model_grid->RowIndex ?>_price" size="30" placeholder="<?php echo ew_HtmlEncode($model->price->getPlaceHolder()) ?>" value="<?php echo $model->price->EditValue ?>"<?php echo $model->price->EditAttributes() ?>>
</span>
<input type="hidden" data-table="model" data-field="x_price" name="o<?php echo $model_grid->RowIndex ?>_price" id="o<?php echo $model_grid->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($model->price->OldValue) ?>">
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_price" class="form-group model_price">
<input type="text" data-table="model" data-field="x_price" name="x<?php echo $model_grid->RowIndex ?>_price" id="x<?php echo $model_grid->RowIndex ?>_price" size="30" placeholder="<?php echo ew_HtmlEncode($model->price->getPlaceHolder()) ?>" value="<?php echo $model->price->EditValue ?>"<?php echo $model->price->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_price" class="model_price">
<span<?php echo $model->price->ViewAttributes() ?>>
<?php echo $model->price->ListViewValue() ?></span>
</span>
<?php if ($model->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model" data-field="x_price" name="x<?php echo $model_grid->RowIndex ?>_price" id="x<?php echo $model_grid->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($model->price->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_price" name="o<?php echo $model_grid->RowIndex ?>_price" id="o<?php echo $model_grid->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($model->price->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model" data-field="x_price" name="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_price" id="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($model->price->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_price" name="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_price" id="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($model->price->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model->model_year->Visible) { // model_year ?>
		<td data-name="model_year"<?php echo $model->model_year->CellAttributes() ?>>
<?php if ($model->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_model_year" class="form-group model_model_year">
<input type="text" data-table="model" data-field="x_model_year" name="x<?php echo $model_grid->RowIndex ?>_model_year" id="x<?php echo $model_grid->RowIndex ?>_model_year" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($model->model_year->getPlaceHolder()) ?>" value="<?php echo $model->model_year->EditValue ?>"<?php echo $model->model_year->EditAttributes() ?>>
</span>
<input type="hidden" data-table="model" data-field="x_model_year" name="o<?php echo $model_grid->RowIndex ?>_model_year" id="o<?php echo $model_grid->RowIndex ?>_model_year" value="<?php echo ew_HtmlEncode($model->model_year->OldValue) ?>">
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_model_year" class="form-group model_model_year">
<input type="text" data-table="model" data-field="x_model_year" name="x<?php echo $model_grid->RowIndex ?>_model_year" id="x<?php echo $model_grid->RowIndex ?>_model_year" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($model->model_year->getPlaceHolder()) ?>" value="<?php echo $model->model_year->EditValue ?>"<?php echo $model->model_year->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_model_year" class="model_model_year">
<span<?php echo $model->model_year->ViewAttributes() ?>>
<?php echo $model->model_year->ListViewValue() ?></span>
</span>
<?php if ($model->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model" data-field="x_model_year" name="x<?php echo $model_grid->RowIndex ?>_model_year" id="x<?php echo $model_grid->RowIndex ?>_model_year" value="<?php echo ew_HtmlEncode($model->model_year->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_model_year" name="o<?php echo $model_grid->RowIndex ?>_model_year" id="o<?php echo $model_grid->RowIndex ?>_model_year" value="<?php echo ew_HtmlEncode($model->model_year->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model" data-field="x_model_year" name="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_model_year" id="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_model_year" value="<?php echo ew_HtmlEncode($model->model_year->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_model_year" name="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_model_year" id="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_model_year" value="<?php echo ew_HtmlEncode($model->model_year->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model->_thumbnail->Visible) { // thumbnail ?>
		<td data-name="_thumbnail"<?php echo $model->_thumbnail->CellAttributes() ?>>
<?php if ($model_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_model__thumbnail" class="form-group model__thumbnail">
<div id="fd_x<?php echo $model_grid->RowIndex ?>__thumbnail">
<span title="<?php echo $model->_thumbnail->FldTitle() ? $model->_thumbnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model->_thumbnail->ReadOnly || $model->_thumbnail->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="model" data-field="x__thumbnail" name="x<?php echo $model_grid->RowIndex ?>__thumbnail" id="x<?php echo $model_grid->RowIndex ?>__thumbnail"<?php echo $model->_thumbnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fn_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="<?php echo $model->_thumbnail->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fa_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="0">
<input type="hidden" name="fs_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fs_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="150">
<input type="hidden" name="fx_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fx_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="<?php echo $model->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fm_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="<?php echo $model->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $model_grid->RowIndex ?>__thumbnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="model" data-field="x__thumbnail" name="o<?php echo $model_grid->RowIndex ?>__thumbnail" id="o<?php echo $model_grid->RowIndex ?>__thumbnail" value="<?php echo ew_HtmlEncode($model->_thumbnail->OldValue) ?>">
<?php } elseif ($model->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model__thumbnail" class="model__thumbnail">
<span>
<?php echo ew_GetFileViewTag($model->_thumbnail, $model->_thumbnail->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model__thumbnail" class="form-group model__thumbnail">
<div id="fd_x<?php echo $model_grid->RowIndex ?>__thumbnail">
<span title="<?php echo $model->_thumbnail->FldTitle() ? $model->_thumbnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model->_thumbnail->ReadOnly || $model->_thumbnail->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="model" data-field="x__thumbnail" name="x<?php echo $model_grid->RowIndex ?>__thumbnail" id="x<?php echo $model_grid->RowIndex ?>__thumbnail"<?php echo $model->_thumbnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fn_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="<?php echo $model->_thumbnail->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $model_grid->RowIndex ?>__thumbnail"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fa_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fa_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fs_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="150">
<input type="hidden" name="fx_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fx_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="<?php echo $model->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fm_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="<?php echo $model->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $model_grid->RowIndex ?>__thumbnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model->category_id->Visible) { // category_id ?>
		<td data-name="category_id"<?php echo $model->category_id->CellAttributes() ?>>
<?php if ($model->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($model->category_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_category_id" class="form-group model_category_id">
<span<?php echo $model->category_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->category_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $model_grid->RowIndex ?>_category_id" name="x<?php echo $model_grid->RowIndex ?>_category_id" value="<?php echo ew_HtmlEncode($model->category_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_category_id" class="form-group model_category_id">
<select data-table="model" data-field="x_category_id" data-value-separator="<?php echo $model->category_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_grid->RowIndex ?>_category_id" name="x<?php echo $model_grid->RowIndex ?>_category_id"<?php echo $model->category_id->EditAttributes() ?>>
<?php echo $model->category_id->SelectOptionListHtml("x<?php echo $model_grid->RowIndex ?>_category_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="model" data-field="x_category_id" name="o<?php echo $model_grid->RowIndex ?>_category_id" id="o<?php echo $model_grid->RowIndex ?>_category_id" value="<?php echo ew_HtmlEncode($model->category_id->OldValue) ?>">
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($model->category_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_category_id" class="form-group model_category_id">
<span<?php echo $model->category_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->category_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $model_grid->RowIndex ?>_category_id" name="x<?php echo $model_grid->RowIndex ?>_category_id" value="<?php echo ew_HtmlEncode($model->category_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_category_id" class="form-group model_category_id">
<select data-table="model" data-field="x_category_id" data-value-separator="<?php echo $model->category_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_grid->RowIndex ?>_category_id" name="x<?php echo $model_grid->RowIndex ?>_category_id"<?php echo $model->category_id->EditAttributes() ?>>
<?php echo $model->category_id->SelectOptionListHtml("x<?php echo $model_grid->RowIndex ?>_category_id") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_category_id" class="model_category_id">
<span<?php echo $model->category_id->ViewAttributes() ?>>
<?php echo $model->category_id->ListViewValue() ?></span>
</span>
<?php if ($model->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model" data-field="x_category_id" name="x<?php echo $model_grid->RowIndex ?>_category_id" id="x<?php echo $model_grid->RowIndex ?>_category_id" value="<?php echo ew_HtmlEncode($model->category_id->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_category_id" name="o<?php echo $model_grid->RowIndex ?>_category_id" id="o<?php echo $model_grid->RowIndex ?>_category_id" value="<?php echo ew_HtmlEncode($model->category_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model" data-field="x_category_id" name="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_category_id" id="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_category_id" value="<?php echo ew_HtmlEncode($model->category_id->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_category_id" name="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_category_id" id="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_category_id" value="<?php echo ew_HtmlEncode($model->category_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model->m_order->Visible) { // m_order ?>
		<td data-name="m_order"<?php echo $model->m_order->CellAttributes() ?>>
<?php if ($model->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_m_order" class="form-group model_m_order">
<input type="text" data-table="model" data-field="x_m_order" name="x<?php echo $model_grid->RowIndex ?>_m_order" id="x<?php echo $model_grid->RowIndex ?>_m_order" size="30" placeholder="<?php echo ew_HtmlEncode($model->m_order->getPlaceHolder()) ?>" value="<?php echo $model->m_order->EditValue ?>"<?php echo $model->m_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="model" data-field="x_m_order" name="o<?php echo $model_grid->RowIndex ?>_m_order" id="o<?php echo $model_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model->m_order->OldValue) ?>">
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_m_order" class="form-group model_m_order">
<input type="text" data-table="model" data-field="x_m_order" name="x<?php echo $model_grid->RowIndex ?>_m_order" id="x<?php echo $model_grid->RowIndex ?>_m_order" size="30" placeholder="<?php echo ew_HtmlEncode($model->m_order->getPlaceHolder()) ?>" value="<?php echo $model->m_order->EditValue ?>"<?php echo $model->m_order->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_m_order" class="model_m_order">
<span<?php echo $model->m_order->ViewAttributes() ?>>
<?php echo $model->m_order->ListViewValue() ?></span>
</span>
<?php if ($model->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model" data-field="x_m_order" name="x<?php echo $model_grid->RowIndex ?>_m_order" id="x<?php echo $model_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model->m_order->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_m_order" name="o<?php echo $model_grid->RowIndex ?>_m_order" id="o<?php echo $model_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model->m_order->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model" data-field="x_m_order" name="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_m_order" id="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model->m_order->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_m_order" name="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_m_order" id="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model->m_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model->status->Visible) { // status ?>
		<td data-name="status"<?php echo $model->status->CellAttributes() ?>>
<?php if ($model->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_status" class="form-group model_status">
<select data-table="model" data-field="x_status" data-value-separator="<?php echo $model->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_grid->RowIndex ?>_status" name="x<?php echo $model_grid->RowIndex ?>_status"<?php echo $model->status->EditAttributes() ?>>
<?php echo $model->status->SelectOptionListHtml("x<?php echo $model_grid->RowIndex ?>_status") ?>
</select>
</span>
<input type="hidden" data-table="model" data-field="x_status" name="o<?php echo $model_grid->RowIndex ?>_status" id="o<?php echo $model_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model->status->OldValue) ?>">
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_status" class="form-group model_status">
<select data-table="model" data-field="x_status" data-value-separator="<?php echo $model->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_grid->RowIndex ?>_status" name="x<?php echo $model_grid->RowIndex ?>_status"<?php echo $model->status->EditAttributes() ?>>
<?php echo $model->status->SelectOptionListHtml("x<?php echo $model_grid->RowIndex ?>_status") ?>
</select>
</span>
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_status" class="model_status">
<span<?php echo $model->status->ViewAttributes() ?>>
<?php echo $model->status->ListViewValue() ?></span>
</span>
<?php if ($model->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model" data-field="x_status" name="x<?php echo $model_grid->RowIndex ?>_status" id="x<?php echo $model_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model->status->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_status" name="o<?php echo $model_grid->RowIndex ?>_status" id="o<?php echo $model_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model->status->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model" data-field="x_status" name="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_status" id="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model->status->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_status" name="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_status" id="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model->status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model->is_feature->Visible) { // is_feature ?>
		<td data-name="is_feature"<?php echo $model->is_feature->CellAttributes() ?>>
<?php if ($model->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_is_feature" class="form-group model_is_feature">
<div id="tp_x<?php echo $model_grid->RowIndex ?>_is_feature" class="ewTemplate"><input type="radio" data-table="model" data-field="x_is_feature" data-value-separator="<?php echo $model->is_feature->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $model_grid->RowIndex ?>_is_feature" id="x<?php echo $model_grid->RowIndex ?>_is_feature" value="{value}"<?php echo $model->is_feature->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $model_grid->RowIndex ?>_is_feature" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $model->is_feature->RadioButtonListHtml(FALSE, "x{$model_grid->RowIndex}_is_feature") ?>
</div></div>
</span>
<input type="hidden" data-table="model" data-field="x_is_feature" name="o<?php echo $model_grid->RowIndex ?>_is_feature" id="o<?php echo $model_grid->RowIndex ?>_is_feature" value="<?php echo ew_HtmlEncode($model->is_feature->OldValue) ?>">
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_is_feature" class="form-group model_is_feature">
<div id="tp_x<?php echo $model_grid->RowIndex ?>_is_feature" class="ewTemplate"><input type="radio" data-table="model" data-field="x_is_feature" data-value-separator="<?php echo $model->is_feature->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $model_grid->RowIndex ?>_is_feature" id="x<?php echo $model_grid->RowIndex ?>_is_feature" value="{value}"<?php echo $model->is_feature->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $model_grid->RowIndex ?>_is_feature" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $model->is_feature->RadioButtonListHtml(FALSE, "x{$model_grid->RowIndex}_is_feature") ?>
</div></div>
</span>
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_is_feature" class="model_is_feature">
<span<?php echo $model->is_feature->ViewAttributes() ?>>
<?php echo $model->is_feature->ListViewValue() ?></span>
</span>
<?php if ($model->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model" data-field="x_is_feature" name="x<?php echo $model_grid->RowIndex ?>_is_feature" id="x<?php echo $model_grid->RowIndex ?>_is_feature" value="<?php echo ew_HtmlEncode($model->is_feature->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_is_feature" name="o<?php echo $model_grid->RowIndex ?>_is_feature" id="o<?php echo $model_grid->RowIndex ?>_is_feature" value="<?php echo ew_HtmlEncode($model->is_feature->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model" data-field="x_is_feature" name="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_is_feature" id="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_is_feature" value="<?php echo ew_HtmlEncode($model->is_feature->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_is_feature" name="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_is_feature" id="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_is_feature" value="<?php echo ew_HtmlEncode($model->is_feature->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($model->is_available->Visible) { // is_available ?>
		<td data-name="is_available"<?php echo $model->is_available->CellAttributes() ?>>
<?php if ($model->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_is_available" class="form-group model_is_available">
<div id="tp_x<?php echo $model_grid->RowIndex ?>_is_available" class="ewTemplate"><input type="radio" data-table="model" data-field="x_is_available" data-value-separator="<?php echo $model->is_available->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $model_grid->RowIndex ?>_is_available" id="x<?php echo $model_grid->RowIndex ?>_is_available" value="{value}"<?php echo $model->is_available->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $model_grid->RowIndex ?>_is_available" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $model->is_available->RadioButtonListHtml(FALSE, "x{$model_grid->RowIndex}_is_available") ?>
</div></div>
</span>
<input type="hidden" data-table="model" data-field="x_is_available" name="o<?php echo $model_grid->RowIndex ?>_is_available" id="o<?php echo $model_grid->RowIndex ?>_is_available" value="<?php echo ew_HtmlEncode($model->is_available->OldValue) ?>">
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_is_available" class="form-group model_is_available">
<div id="tp_x<?php echo $model_grid->RowIndex ?>_is_available" class="ewTemplate"><input type="radio" data-table="model" data-field="x_is_available" data-value-separator="<?php echo $model->is_available->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $model_grid->RowIndex ?>_is_available" id="x<?php echo $model_grid->RowIndex ?>_is_available" value="{value}"<?php echo $model->is_available->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $model_grid->RowIndex ?>_is_available" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $model->is_available->RadioButtonListHtml(FALSE, "x{$model_grid->RowIndex}_is_available") ?>
</div></div>
</span>
<?php } ?>
<?php if ($model->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $model_grid->RowCnt ?>_model_is_available" class="model_is_available">
<span<?php echo $model->is_available->ViewAttributes() ?>>
<?php echo $model->is_available->ListViewValue() ?></span>
</span>
<?php if ($model->CurrentAction <> "F") { ?>
<input type="hidden" data-table="model" data-field="x_is_available" name="x<?php echo $model_grid->RowIndex ?>_is_available" id="x<?php echo $model_grid->RowIndex ?>_is_available" value="<?php echo ew_HtmlEncode($model->is_available->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_is_available" name="o<?php echo $model_grid->RowIndex ?>_is_available" id="o<?php echo $model_grid->RowIndex ?>_is_available" value="<?php echo ew_HtmlEncode($model->is_available->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="model" data-field="x_is_available" name="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_is_available" id="fmodelgrid$x<?php echo $model_grid->RowIndex ?>_is_available" value="<?php echo ew_HtmlEncode($model->is_available->FormValue) ?>">
<input type="hidden" data-table="model" data-field="x_is_available" name="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_is_available" id="fmodelgrid$o<?php echo $model_grid->RowIndex ?>_is_available" value="<?php echo ew_HtmlEncode($model->is_available->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$model_grid->ListOptions->Render("body", "right", $model_grid->RowCnt);
?>
	</tr>
<?php if ($model->RowType == EW_ROWTYPE_ADD || $model->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fmodelgrid.UpdateOpts(<?php echo $model_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($model->CurrentAction <> "gridadd" || $model->CurrentMode == "copy")
		if (!$model_grid->Recordset->EOF) $model_grid->Recordset->MoveNext();
}
?>
<?php
	if ($model->CurrentMode == "add" || $model->CurrentMode == "copy" || $model->CurrentMode == "edit") {
		$model_grid->RowIndex = '$rowindex$';
		$model_grid->LoadRowValues();

		// Set row properties
		$model->ResetAttrs();
		$model->RowAttrs = array_merge($model->RowAttrs, array('data-rowindex'=>$model_grid->RowIndex, 'id'=>'r0_model', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($model->RowAttrs["class"], "ewTemplate");
		$model->RowType = EW_ROWTYPE_ADD;

		// Render row
		$model_grid->RenderRow();

		// Render list options
		$model_grid->RenderListOptions();
		$model_grid->StartRowCnt = 0;
?>
	<tr<?php echo $model->RowAttributes() ?>>
<?php

// Render list options (body, left)
$model_grid->ListOptions->Render("body", "left", $model_grid->RowIndex);
?>
	<?php if ($model->model_id->Visible) { // model_id ?>
		<td data-name="model_id">
<?php if ($model->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_model_model_id" class="form-group model_model_id">
<span<?php echo $model->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model" data-field="x_model_id" name="x<?php echo $model_grid->RowIndex ?>_model_id" id="x<?php echo $model_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model->model_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model" data-field="x_model_id" name="o<?php echo $model_grid->RowIndex ?>_model_id" id="o<?php echo $model_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model->model_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model->model_name->Visible) { // model_name ?>
		<td data-name="model_name">
<?php if ($model->CurrentAction <> "F") { ?>
<span id="el$rowindex$_model_model_name" class="form-group model_model_name">
<input type="text" data-table="model" data-field="x_model_name" name="x<?php echo $model_grid->RowIndex ?>_model_name" id="x<?php echo $model_grid->RowIndex ?>_model_name" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($model->model_name->getPlaceHolder()) ?>" value="<?php echo $model->model_name->EditValue ?>"<?php echo $model->model_name->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_model_model_name" class="form-group model_model_name">
<span<?php echo $model->model_name->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->model_name->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model" data-field="x_model_name" name="x<?php echo $model_grid->RowIndex ?>_model_name" id="x<?php echo $model_grid->RowIndex ?>_model_name" value="<?php echo ew_HtmlEncode($model->model_name->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model" data-field="x_model_name" name="o<?php echo $model_grid->RowIndex ?>_model_name" id="o<?php echo $model_grid->RowIndex ?>_model_name" value="<?php echo ew_HtmlEncode($model->model_name->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model->price->Visible) { // price ?>
		<td data-name="price">
<?php if ($model->CurrentAction <> "F") { ?>
<span id="el$rowindex$_model_price" class="form-group model_price">
<input type="text" data-table="model" data-field="x_price" name="x<?php echo $model_grid->RowIndex ?>_price" id="x<?php echo $model_grid->RowIndex ?>_price" size="30" placeholder="<?php echo ew_HtmlEncode($model->price->getPlaceHolder()) ?>" value="<?php echo $model->price->EditValue ?>"<?php echo $model->price->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_model_price" class="form-group model_price">
<span<?php echo $model->price->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->price->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model" data-field="x_price" name="x<?php echo $model_grid->RowIndex ?>_price" id="x<?php echo $model_grid->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($model->price->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model" data-field="x_price" name="o<?php echo $model_grid->RowIndex ?>_price" id="o<?php echo $model_grid->RowIndex ?>_price" value="<?php echo ew_HtmlEncode($model->price->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model->model_year->Visible) { // model_year ?>
		<td data-name="model_year">
<?php if ($model->CurrentAction <> "F") { ?>
<span id="el$rowindex$_model_model_year" class="form-group model_model_year">
<input type="text" data-table="model" data-field="x_model_year" name="x<?php echo $model_grid->RowIndex ?>_model_year" id="x<?php echo $model_grid->RowIndex ?>_model_year" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($model->model_year->getPlaceHolder()) ?>" value="<?php echo $model->model_year->EditValue ?>"<?php echo $model->model_year->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_model_model_year" class="form-group model_model_year">
<span<?php echo $model->model_year->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->model_year->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model" data-field="x_model_year" name="x<?php echo $model_grid->RowIndex ?>_model_year" id="x<?php echo $model_grid->RowIndex ?>_model_year" value="<?php echo ew_HtmlEncode($model->model_year->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model" data-field="x_model_year" name="o<?php echo $model_grid->RowIndex ?>_model_year" id="o<?php echo $model_grid->RowIndex ?>_model_year" value="<?php echo ew_HtmlEncode($model->model_year->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model->_thumbnail->Visible) { // thumbnail ?>
		<td data-name="_thumbnail">
<span id="el$rowindex$_model__thumbnail" class="form-group model__thumbnail">
<div id="fd_x<?php echo $model_grid->RowIndex ?>__thumbnail">
<span title="<?php echo $model->_thumbnail->FldTitle() ? $model->_thumbnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model->_thumbnail->ReadOnly || $model->_thumbnail->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="model" data-field="x__thumbnail" name="x<?php echo $model_grid->RowIndex ?>__thumbnail" id="x<?php echo $model_grid->RowIndex ?>__thumbnail"<?php echo $model->_thumbnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fn_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="<?php echo $model->_thumbnail->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fa_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="0">
<input type="hidden" name="fs_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fs_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="150">
<input type="hidden" name="fx_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fx_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="<?php echo $model->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $model_grid->RowIndex ?>__thumbnail" id= "fm_x<?php echo $model_grid->RowIndex ?>__thumbnail" value="<?php echo $model->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $model_grid->RowIndex ?>__thumbnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="model" data-field="x__thumbnail" name="o<?php echo $model_grid->RowIndex ?>__thumbnail" id="o<?php echo $model_grid->RowIndex ?>__thumbnail" value="<?php echo ew_HtmlEncode($model->_thumbnail->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model->category_id->Visible) { // category_id ?>
		<td data-name="category_id">
<?php if ($model->CurrentAction <> "F") { ?>
<?php if ($model->category_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_model_category_id" class="form-group model_category_id">
<span<?php echo $model->category_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->category_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $model_grid->RowIndex ?>_category_id" name="x<?php echo $model_grid->RowIndex ?>_category_id" value="<?php echo ew_HtmlEncode($model->category_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_model_category_id" class="form-group model_category_id">
<select data-table="model" data-field="x_category_id" data-value-separator="<?php echo $model->category_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_grid->RowIndex ?>_category_id" name="x<?php echo $model_grid->RowIndex ?>_category_id"<?php echo $model->category_id->EditAttributes() ?>>
<?php echo $model->category_id->SelectOptionListHtml("x<?php echo $model_grid->RowIndex ?>_category_id") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_model_category_id" class="form-group model_category_id">
<span<?php echo $model->category_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->category_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model" data-field="x_category_id" name="x<?php echo $model_grid->RowIndex ?>_category_id" id="x<?php echo $model_grid->RowIndex ?>_category_id" value="<?php echo ew_HtmlEncode($model->category_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model" data-field="x_category_id" name="o<?php echo $model_grid->RowIndex ?>_category_id" id="o<?php echo $model_grid->RowIndex ?>_category_id" value="<?php echo ew_HtmlEncode($model->category_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model->m_order->Visible) { // m_order ?>
		<td data-name="m_order">
<?php if ($model->CurrentAction <> "F") { ?>
<span id="el$rowindex$_model_m_order" class="form-group model_m_order">
<input type="text" data-table="model" data-field="x_m_order" name="x<?php echo $model_grid->RowIndex ?>_m_order" id="x<?php echo $model_grid->RowIndex ?>_m_order" size="30" placeholder="<?php echo ew_HtmlEncode($model->m_order->getPlaceHolder()) ?>" value="<?php echo $model->m_order->EditValue ?>"<?php echo $model->m_order->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_model_m_order" class="form-group model_m_order">
<span<?php echo $model->m_order->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->m_order->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model" data-field="x_m_order" name="x<?php echo $model_grid->RowIndex ?>_m_order" id="x<?php echo $model_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model->m_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model" data-field="x_m_order" name="o<?php echo $model_grid->RowIndex ?>_m_order" id="o<?php echo $model_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model->m_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model->status->Visible) { // status ?>
		<td data-name="status">
<?php if ($model->CurrentAction <> "F") { ?>
<span id="el$rowindex$_model_status" class="form-group model_status">
<select data-table="model" data-field="x_status" data-value-separator="<?php echo $model->status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $model_grid->RowIndex ?>_status" name="x<?php echo $model_grid->RowIndex ?>_status"<?php echo $model->status->EditAttributes() ?>>
<?php echo $model->status->SelectOptionListHtml("x<?php echo $model_grid->RowIndex ?>_status") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_model_status" class="form-group model_status">
<span<?php echo $model->status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model" data-field="x_status" name="x<?php echo $model_grid->RowIndex ?>_status" id="x<?php echo $model_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model->status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model" data-field="x_status" name="o<?php echo $model_grid->RowIndex ?>_status" id="o<?php echo $model_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model->status->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model->is_feature->Visible) { // is_feature ?>
		<td data-name="is_feature">
<?php if ($model->CurrentAction <> "F") { ?>
<span id="el$rowindex$_model_is_feature" class="form-group model_is_feature">
<div id="tp_x<?php echo $model_grid->RowIndex ?>_is_feature" class="ewTemplate"><input type="radio" data-table="model" data-field="x_is_feature" data-value-separator="<?php echo $model->is_feature->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $model_grid->RowIndex ?>_is_feature" id="x<?php echo $model_grid->RowIndex ?>_is_feature" value="{value}"<?php echo $model->is_feature->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $model_grid->RowIndex ?>_is_feature" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $model->is_feature->RadioButtonListHtml(FALSE, "x{$model_grid->RowIndex}_is_feature") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_model_is_feature" class="form-group model_is_feature">
<span<?php echo $model->is_feature->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->is_feature->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model" data-field="x_is_feature" name="x<?php echo $model_grid->RowIndex ?>_is_feature" id="x<?php echo $model_grid->RowIndex ?>_is_feature" value="<?php echo ew_HtmlEncode($model->is_feature->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model" data-field="x_is_feature" name="o<?php echo $model_grid->RowIndex ?>_is_feature" id="o<?php echo $model_grid->RowIndex ?>_is_feature" value="<?php echo ew_HtmlEncode($model->is_feature->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($model->is_available->Visible) { // is_available ?>
		<td data-name="is_available">
<?php if ($model->CurrentAction <> "F") { ?>
<span id="el$rowindex$_model_is_available" class="form-group model_is_available">
<div id="tp_x<?php echo $model_grid->RowIndex ?>_is_available" class="ewTemplate"><input type="radio" data-table="model" data-field="x_is_available" data-value-separator="<?php echo $model->is_available->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $model_grid->RowIndex ?>_is_available" id="x<?php echo $model_grid->RowIndex ?>_is_available" value="{value}"<?php echo $model->is_available->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $model_grid->RowIndex ?>_is_available" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $model->is_available->RadioButtonListHtml(FALSE, "x{$model_grid->RowIndex}_is_available") ?>
</div></div>
</span>
<?php } else { ?>
<span id="el$rowindex$_model_is_available" class="form-group model_is_available">
<span<?php echo $model->is_available->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->is_available->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="model" data-field="x_is_available" name="x<?php echo $model_grid->RowIndex ?>_is_available" id="x<?php echo $model_grid->RowIndex ?>_is_available" value="<?php echo ew_HtmlEncode($model->is_available->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="model" data-field="x_is_available" name="o<?php echo $model_grid->RowIndex ?>_is_available" id="o<?php echo $model_grid->RowIndex ?>_is_available" value="<?php echo ew_HtmlEncode($model->is_available->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$model_grid->ListOptions->Render("body", "right", $model_grid->RowIndex);
?>
<script type="text/javascript">
fmodelgrid.UpdateOpts(<?php echo $model_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($model->CurrentMode == "add" || $model->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $model_grid->FormKeyCountName ?>" id="<?php echo $model_grid->FormKeyCountName ?>" value="<?php echo $model_grid->KeyCount ?>">
<?php echo $model_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($model->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $model_grid->FormKeyCountName ?>" id="<?php echo $model_grid->FormKeyCountName ?>" value="<?php echo $model_grid->KeyCount ?>">
<?php echo $model_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($model->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fmodelgrid">
</div>
<?php

// Close recordset
if ($model_grid->Recordset)
	$model_grid->Recordset->Close();
?>
<?php if ($model_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($model_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($model_grid->TotalRecs == 0 && $model->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($model_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($model->Export == "") { ?>
<script type="text/javascript">
fmodelgrid.Init();
</script>
<?php } ?>
<?php
$model_grid->Page_Terminate();
?>
