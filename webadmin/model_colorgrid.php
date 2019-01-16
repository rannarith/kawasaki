<?php include_once "admin_userinfo.php" ?>
<?php

// Create page object
if (!isset($model_color_grid)) $model_color_grid = new cmodel_color_grid();

// Page init
$model_color_grid->Page_Init();

// Page main
$model_color_grid->Page_Main();
?>
<?php if ($model_color->Export == "") { ?>
<script type="text/javascript">

// Page object
var model_color_grid = new ew_Page("model_color_grid");
model_color_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = model_color_grid.PageID; // For backward compatibility

// Form object
var fmodel_colorgrid = new ew_Form("fmodel_colorgrid");

// Validate form
fmodel_colorgrid.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();	
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var elm, aelm;
	var rowcnt = (fobj.key_count) ? Number(fobj.key_count.value) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // rowcnt == 0 => Inline-Add
	var addcnt = 0;
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = (fobj.key_count) ? String(i) : "";
		var checkrow = (fobj.a_list && fobj.a_list.value == "gridinsert") ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
		elm = fobj.elements["x" + infix + "_image"];
		aelm = fobj.elements["a" + infix + "_image"];
		var chk_image = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_image && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model_color->image->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_image"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_model_id"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model_color->model_id->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_color_code"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model_color->color_code->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_m_order"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model_color->m_order->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_m_order"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($model_color->m_order->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_m_status"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model_color->m_status->FldCaption()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

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
<?php if (EW_CLIENT_VALIDATE) { ?>
fmodel_colorgrid.ValidateRequired = true;
<?php } else { ?>
fmodel_colorgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmodel_colorgrid.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($model_color->CurrentAction == "gridadd") {
	if ($model_color->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$model_color_grid->TotalRecs = $model_color->SelectRecordCount();
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
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$model_color_grid->TotalRecs = $model_color->SelectRecordCount();
	} else {
		if ($model_color_grid->Recordset = $model_color_grid->LoadRecordset())
			$model_color_grid->TotalRecs = $model_color_grid->Recordset->RecordCount();
	}
	$model_color_grid->StartRec = 1;
	$model_color_grid->DisplayRecs = $model_color_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$model_color_grid->Recordset = $model_color_grid->LoadRecordset($model_color_grid->StartRec-1, $model_color_grid->DisplayRecs);
}
?>
<p style="white-space: nowrap;"><span class="ewTitle ewTableTitle"><?php if ($model_color->CurrentMode == "add" || $model_color->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($model_color->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $model_color->TableCaption() ?></span></p>
</p>
<?php $model_color_grid->ShowPageHeader(); ?>
<?php
$model_color_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fmodel_colorgrid" class="ewForm">
<?php if (($model_color->CurrentMode == "add" || $model_color->CurrentMode == "copy" || $model_color->CurrentMode == "edit") && $model_color->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
<?php if ($model_color->AllowAddDeleteRow) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' border='0'></a>&nbsp;&nbsp;
</span>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
<div id="gmp_model_color" class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_model_colorgrid" class="ewTable ewTableSeparate">
<?php echo $model_color->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$model_color_grid->RenderListOptions();

// Render list options (header, left)
$model_color_grid->ListOptions->Render("header", "left");
?>
<?php if ($model_color->mc_id->Visible) { // mc_id ?>
	<?php if ($model_color->SortUrl($model_color->mc_id) == "") { ?>
		<td><span id="elh_model_color_mc_id" class="model_color_mc_id"><?php echo $model_color->mc_id->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_model_color_mc_id" class="model_color_mc_id">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model_color->mc_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($model_color->mc_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model_color->mc_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model_color->image->Visible) { // image ?>
	<?php if ($model_color->SortUrl($model_color->image) == "") { ?>
		<td><span id="elh_model_color_image" class="model_color_image"><?php echo $model_color->image->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_model_color_image" class="model_color_image">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model_color->image->FldCaption() ?></td><td style="width: 10px;"><?php if ($model_color->image->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model_color->image->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model_color->model_id->Visible) { // model_id ?>
	<?php if ($model_color->SortUrl($model_color->model_id) == "") { ?>
		<td><span id="elh_model_color_model_id" class="model_color_model_id"><?php echo $model_color->model_id->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_model_color_model_id" class="model_color_model_id">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model_color->model_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($model_color->model_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model_color->model_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model_color->color_code->Visible) { // color_code ?>
	<?php if ($model_color->SortUrl($model_color->color_code) == "") { ?>
		<td><span id="elh_model_color_color_code" class="model_color_color_code"><?php echo $model_color->color_code->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_model_color_color_code" class="model_color_color_code">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model_color->color_code->FldCaption() ?></td><td style="width: 10px;"><?php if ($model_color->color_code->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model_color->color_code->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model_color->m_order->Visible) { // m_order ?>
	<?php if ($model_color->SortUrl($model_color->m_order) == "") { ?>
		<td><span id="elh_model_color_m_order" class="model_color_m_order"><?php echo $model_color->m_order->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_model_color_m_order" class="model_color_m_order">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model_color->m_order->FldCaption() ?></td><td style="width: 10px;"><?php if ($model_color->m_order->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model_color->m_order->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model_color->m_status->Visible) { // m_status ?>
	<?php if ($model_color->SortUrl($model_color->m_status) == "") { ?>
		<td><span id="elh_model_color_m_status" class="model_color_m_status"><?php echo $model_color->m_status->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_model_color_m_status" class="model_color_m_status">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model_color->m_status->FldCaption() ?></td><td style="width: 10px;"><?php if ($model_color->m_status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model_color->m_status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
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
	if ($objForm->HasValue("key_count") && ($model_color->CurrentAction == "gridadd" || $model_color->CurrentAction == "gridedit" || $model_color->CurrentAction == "F")) {
		$model_color_grid->KeyCount = $objForm->GetValue("key_count");
		$model_color_grid->StopRec = $model_color_grid->KeyCount;
	}
}
$model_color_grid->RecCnt = $model_color_grid->StartRec - 1;
if ($model_color_grid->Recordset && !$model_color_grid->Recordset->EOF) {
	$model_color_grid->Recordset->MoveFirst();
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
			if ($objForm->HasValue("k_action"))
				$model_color_grid->RowAction = strval($objForm->GetValue("k_action"));
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
				$model_color_grid->LoadDefaultValues(); // Load default values
				$model_color_grid->RowOldKey = ""; // Clear old key value
			}
		} elseif ($model_color->CurrentAction == "gridedit") {
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
		<td<?php echo $model_color->mc_id->CellAttributes() ?>><span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_mc_id" class="model_color_mc_id">
<?php if ($model_color->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_mc_id" id="o<?php echo $model_color_grid->RowIndex ?>_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->OldValue) ?>">
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $model_color->mc_id->ViewAttributes() ?>>
<?php echo $model_color->mc_id->EditValue ?></span>
<input type="hidden" name="x<?php echo $model_color_grid->RowIndex ?>_mc_id" id="x<?php echo $model_color_grid->RowIndex ?>_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->CurrentValue) ?>">
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $model_color->mc_id->ViewAttributes() ?>>
<?php echo $model_color->mc_id->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $model_color_grid->RowIndex ?>_mc_id" id="x<?php echo $model_color_grid->RowIndex ?>_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->FormValue) ?>">
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_mc_id" id="o<?php echo $model_color_grid->RowIndex ?>_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->OldValue) ?>">
<?php } ?>
<a name="<?php echo $model_color_grid->PageObjName . "_row_" . $model_color_grid->RowCnt ?>" id="<?php echo $model_color_grid->PageObjName . "_row_" . $model_color_grid->RowCnt ?>"></a></span></td>
	<?php } ?>
	<?php if ($model_color->image->Visible) { // image ?>
		<td<?php echo $model_color->image->CellAttributes() ?>><span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_image" class="model_color_image">
<?php if ($model_color_grid->RowAction == "insert") { // Add record ?>
<?php if ($model_color->CurrentAction <> "F") { ?>
<div id="old_x<?php echo $model_color_grid->RowIndex ?>_image">
<?php if ($model_color->image->LinkAttributes() <> "") { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_color->image->UploadPath) . $model_color->image->Upload->DbValue ?>" border="0"<?php echo $model_color->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_color->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_color->image->UploadPath) . $model_color->image->Upload->DbValue ?>" border="0"<?php echo $model_color->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_color->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x<?php echo $model_color_grid->RowIndex ?>_image">
<?php if ($model_color->image->ReadOnly) { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<input type="hidden" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<label><input type="radio" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $model_color->image->EditAttrs["onchange"] = "this.form.a" . $model_color_grid->RowIndex . "_image[2].checked=true;" . @$model_color->image->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="3">
<?php } ?>
<input type="file" name="x<?php echo $model_color_grid->RowIndex ?>_image" id="x<?php echo $model_color_grid->RowIndex ?>_image" size="30"<?php echo $model_color->image->EditAttributes() ?>>
<?php } ?>
</div>
<?php } else { ?>
<input type="hidden" name="a_image" id="a_image" value="<?php echo $model_color->image->Upload->Action ?>">
<?php
if ($model_color->image->Upload->Action == "1") {
	if (!ew_Empty($model_color->image->Upload->DbValue)) {
?>
<img src="ewbv9.php?tbl=<?php echo $model_color->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $model_color_grid->RowIndex ?>&db=1&file=1&path=<?php echo urlencode($model_color->image->UploadPath) ?>" alt="" border="0">
<?php
	}
} elseif ($model_color->image->Upload->Action == "2") {
} else {
	if (!ew_Empty($model_color->image->Upload->Value)) {
?>
<img src="ewbv9.php?tbl=<?php echo $model_color->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $model_color_grid->RowIndex ?>" alt="" border="0" width=200>
<?php
	}
}
?>
<?php } ?>
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_image" id="o<?php echo $model_color_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($model_color->image->OldValue) ?>">
<?php } else { // Edit record ?>
<?php if ($model_color->CurrentAction <> "F") { ?>
<div id="old_x<?php echo $model_color_grid->RowIndex ?>_image">
<?php if ($model_color->image->LinkAttributes() <> "") { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_color->image->UploadPath) . $model_color->image->Upload->DbValue ?>" border="0"<?php echo $model_color->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_color->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_color->image->UploadPath) . $model_color->image->Upload->DbValue ?>" border="0"<?php echo $model_color->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_color->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x<?php echo $model_color_grid->RowIndex ?>_image">
<?php if ($model_color->image->ReadOnly) { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<input type="hidden" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<label><input type="radio" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $model_color->image->EditAttrs["onchange"] = "this.form.a" . $model_color_grid->RowIndex . "_image[2].checked=true;" . @$model_color->image->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="3">
<?php } ?>
<input type="file" name="x<?php echo $model_color_grid->RowIndex ?>_image" id="x<?php echo $model_color_grid->RowIndex ?>_image" size="30"<?php echo $model_color->image->EditAttributes() ?>>
<?php } ?>
</div>
<?php } else { ?>
<div id="old_x<?php echo $model_color_grid->RowIndex ?>_image">
<?php if ($model_color->image->LinkAttributes() <> "") { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_color->image->UploadPath) . $model_color->image->Upload->DbValue ?>" border="0"<?php echo $model_color->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_color->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_color->image->UploadPath) . $model_color->image->Upload->DbValue ?>" border="0"<?php echo $model_color->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_color->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
<?php if (!ew_Empty($model_color->image->Upload->DbValue) && $model_color->image->Upload->Action == "3") echo "[" . $Language->Phrase("Old") . "]"; ?>
</div>
<div id="new_x<?php echo $model_color_grid->RowIndex ?>_image">
<input type="hidden" name="a_image" id="a_image" value="<?php echo $model_color->image->Upload->Action ?>">
<?php
if ($model_color->image->Upload->Action == "1") {
	echo "[" . $Language->Phrase("Keep") . "]";
} elseif ($model_color->image->Upload->Action == "2") {
	echo "[" . $Language->Phrase("Remove") . "]";
} else {
	if (!ew_Empty($model_color->image->Upload->Value)) {
?>
<img src="ewbv9.php?tbl=<?php echo $model_color->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $model_color_grid->RowIndex ?>" alt="" border="0" width=200>
<?php
	}
}
?>
<?php if (!ew_Empty($model_color->image->Upload->DbValue) && $model_color->image->Upload->Action == "3") echo "[" . $Language->Phrase("New") . "]"; ?>
</div>
<?php } ?>
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($model_color->model_id->Visible) { // model_id ?>
		<td<?php echo $model_color->model_id->CellAttributes() ?>><span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_model_id" class="model_color_model_id">
<?php if ($model_color->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($model_color->model_id->getSessionValue() <> "") { ?>
<span<?php echo $model_color->model_id->ViewAttributes() ?>>
<?php echo $model_color->model_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $model_color_grid->RowIndex ?>_model_id" name="x<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $model_color_grid->RowIndex ?>_model_id" name="x<?php echo $model_color_grid->RowIndex ?>_model_id"<?php echo $model_color->model_id->EditAttributes() ?>>
<?php
if (is_array($model_color->model_id->EditValue)) {
	$arwrk = $model_color->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model_color->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $model_color->model_id->OldValue = "";
?>
</select>
<script type="text/javascript">
fmodel_colorgrid.Lists["x_model_id"].Options = <?php echo (is_array($model_color->model_id->EditValue)) ? ew_ArrayToJson($model_color->model_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_model_id" id="o<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->OldValue) ?>">
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($model_color->model_id->getSessionValue() <> "") { ?>
<span<?php echo $model_color->model_id->ViewAttributes() ?>>
<?php echo $model_color->model_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $model_color_grid->RowIndex ?>_model_id" name="x<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $model_color_grid->RowIndex ?>_model_id" name="x<?php echo $model_color_grid->RowIndex ?>_model_id"<?php echo $model_color->model_id->EditAttributes() ?>>
<?php
if (is_array($model_color->model_id->EditValue)) {
	$arwrk = $model_color->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model_color->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $model_color->model_id->OldValue = "";
?>
</select>
<script type="text/javascript">
fmodel_colorgrid.Lists["x_model_id"].Options = <?php echo (is_array($model_color->model_id->EditValue)) ? ew_ArrayToJson($model_color->model_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $model_color->model_id->ViewAttributes() ?>>
<?php echo $model_color->model_id->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $model_color_grid->RowIndex ?>_model_id" id="x<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->FormValue) ?>">
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_model_id" id="o<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->OldValue) ?>">
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($model_color->color_code->Visible) { // color_code ?>
		<td<?php echo $model_color->color_code->CellAttributes() ?>><span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_color_code" class="model_color_color_code">
<?php if ($model_color->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $model_color_grid->RowIndex ?>_color_code" id="x<?php echo $model_color_grid->RowIndex ?>_color_code" size="30" maxlength="30" value="<?php echo $model_color->color_code->EditValue ?>"<?php echo $model_color->color_code->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_color_code" id="o<?php echo $model_color_grid->RowIndex ?>_color_code" value="<?php echo ew_HtmlEncode($model_color->color_code->OldValue) ?>">
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $model_color_grid->RowIndex ?>_color_code" id="x<?php echo $model_color_grid->RowIndex ?>_color_code" size="30" maxlength="30" value="<?php echo $model_color->color_code->EditValue ?>"<?php echo $model_color->color_code->EditAttributes() ?>>
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $model_color->color_code->ViewAttributes() ?>>
<?php echo $model_color->color_code->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $model_color_grid->RowIndex ?>_color_code" id="x<?php echo $model_color_grid->RowIndex ?>_color_code" value="<?php echo ew_HtmlEncode($model_color->color_code->FormValue) ?>">
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_color_code" id="o<?php echo $model_color_grid->RowIndex ?>_color_code" value="<?php echo ew_HtmlEncode($model_color->color_code->OldValue) ?>">
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($model_color->m_order->Visible) { // m_order ?>
		<td<?php echo $model_color->m_order->CellAttributes() ?>><span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_m_order" class="model_color_m_order">
<?php if ($model_color->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $model_color_grid->RowIndex ?>_m_order" id="x<?php echo $model_color_grid->RowIndex ?>_m_order" size="30" value="<?php echo $model_color->m_order->EditValue ?>"<?php echo $model_color->m_order->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_m_order" id="o<?php echo $model_color_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model_color->m_order->OldValue) ?>">
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $model_color_grid->RowIndex ?>_m_order" id="x<?php echo $model_color_grid->RowIndex ?>_m_order" size="30" value="<?php echo $model_color->m_order->EditValue ?>"<?php echo $model_color->m_order->EditAttributes() ?>>
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $model_color->m_order->ViewAttributes() ?>>
<?php echo $model_color->m_order->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $model_color_grid->RowIndex ?>_m_order" id="x<?php echo $model_color_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model_color->m_order->FormValue) ?>">
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_m_order" id="o<?php echo $model_color_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model_color->m_order->OldValue) ?>">
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($model_color->m_status->Visible) { // m_status ?>
		<td<?php echo $model_color->m_status->CellAttributes() ?>><span id="el<?php echo $model_color_grid->RowCnt ?>_model_color_m_status" class="model_color_m_status">
<?php if ($model_color->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $model_color_grid->RowIndex ?>_m_status" name="x<?php echo $model_color_grid->RowIndex ?>_m_status"<?php echo $model_color->m_status->EditAttributes() ?>>
<?php
if (is_array($model_color->m_status->EditValue)) {
	$arwrk = $model_color->m_status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model_color->m_status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $model_color->m_status->OldValue = "";
?>
</select>
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_m_status" id="o<?php echo $model_color_grid->RowIndex ?>_m_status" value="<?php echo ew_HtmlEncode($model_color->m_status->OldValue) ?>">
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $model_color_grid->RowIndex ?>_m_status" name="x<?php echo $model_color_grid->RowIndex ?>_m_status"<?php echo $model_color->m_status->EditAttributes() ?>>
<?php
if (is_array($model_color->m_status->EditValue)) {
	$arwrk = $model_color->m_status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model_color->m_status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $model_color->m_status->OldValue = "";
?>
</select>
<?php } ?>
<?php if ($model_color->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $model_color->m_status->ViewAttributes() ?>>
<?php echo $model_color->m_status->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $model_color_grid->RowIndex ?>_m_status" id="x<?php echo $model_color_grid->RowIndex ?>_m_status" value="<?php echo ew_HtmlEncode($model_color->m_status->FormValue) ?>">
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_m_status" id="o<?php echo $model_color_grid->RowIndex ?>_m_status" value="<?php echo ew_HtmlEncode($model_color->m_status->OldValue) ?>">
<?php } ?>
</span></td>
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
		$model_color_grid->LoadDefaultValues();

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
		<td><span id="el$rowindex$_model_color_mc_id" class="model_color_mc_id">
<?php if ($model_color->CurrentAction <> "F") { ?>
<?php } else { ?>
<span<?php echo $model_color->mc_id->ViewAttributes() ?>>
<?php echo $model_color->mc_id->ViewValue ?></span>
<input type="hidden" name="x<?php echo $model_color_grid->RowIndex ?>_mc_id" id="x<?php echo $model_color_grid->RowIndex ?>_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_mc_id" id="o<?php echo $model_color_grid->RowIndex ?>_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($model_color->image->Visible) { // image ?>
		<td><span id="el$rowindex$_model_color_image" class="model_color_image">
<?php if ($model_color->CurrentAction <> "F") { ?>
<div id="old_x<?php echo $model_color_grid->RowIndex ?>_image">
<?php if ($model_color->image->LinkAttributes() <> "") { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_color->image->UploadPath) . $model_color->image->Upload->DbValue ?>" border="0"<?php echo $model_color->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_color->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_color->image->UploadPath) . $model_color->image->Upload->DbValue ?>" border="0"<?php echo $model_color->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_color->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x<?php echo $model_color_grid->RowIndex ?>_image">
<?php if ($model_color->image->ReadOnly) { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<input type="hidden" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<label><input type="radio" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $model_color->image->EditAttrs["onchange"] = "this.form.a" . $model_color_grid->RowIndex . "_image[2].checked=true;" . @$model_color->image->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a<?php echo $model_color_grid->RowIndex ?>_image" id="a<?php echo $model_color_grid->RowIndex ?>_image" value="3">
<?php } ?>
<input type="file" name="x<?php echo $model_color_grid->RowIndex ?>_image" id="x<?php echo $model_color_grid->RowIndex ?>_image" size="30"<?php echo $model_color->image->EditAttributes() ?>>
<?php } ?>
</div>
<?php } else { ?>
<input type="hidden" name="a_image" id="a_image" value="<?php echo $model_color->image->Upload->Action ?>">
<?php
if ($model_color->image->Upload->Action == "1") {
	if (!ew_Empty($model_color->image->Upload->DbValue)) {
?>
<img src="ewbv9.php?tbl=<?php echo $model_color->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $model_color_grid->RowIndex ?>&db=1&file=1&path=<?php echo urlencode($model_color->image->UploadPath) ?>" alt="" border="0">
<?php
	}
} elseif ($model_color->image->Upload->Action == "2") {
} else {
	if (!ew_Empty($model_color->image->Upload->Value)) {
?>
<img src="ewbv9.php?tbl=<?php echo $model_color->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $model_color_grid->RowIndex ?>" alt="" border="0" width=200>
<?php
	}
}
?>
<?php } ?>
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_image" id="o<?php echo $model_color_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($model_color->image->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($model_color->model_id->Visible) { // model_id ?>
		<td><span id="el$rowindex$_model_color_model_id" class="model_color_model_id">
<?php if ($model_color->CurrentAction <> "F") { ?>
<?php if ($model_color->model_id->getSessionValue() <> "") { ?>
<span<?php echo $model_color->model_id->ViewAttributes() ?>>
<?php echo $model_color->model_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $model_color_grid->RowIndex ?>_model_id" name="x<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $model_color_grid->RowIndex ?>_model_id" name="x<?php echo $model_color_grid->RowIndex ?>_model_id"<?php echo $model_color->model_id->EditAttributes() ?>>
<?php
if (is_array($model_color->model_id->EditValue)) {
	$arwrk = $model_color->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model_color->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $model_color->model_id->OldValue = "";
?>
</select>
<script type="text/javascript">
fmodel_colorgrid.Lists["x_model_id"].Options = <?php echo (is_array($model_color->model_id->EditValue)) ? ew_ArrayToJson($model_color->model_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php } else { ?>
<span<?php echo $model_color->model_id->ViewAttributes() ?>>
<?php echo $model_color->model_id->ViewValue ?></span>
<input type="hidden" name="x<?php echo $model_color_grid->RowIndex ?>_model_id" id="x<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_model_id" id="o<?php echo $model_color_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($model_color->color_code->Visible) { // color_code ?>
		<td><span id="el$rowindex$_model_color_color_code" class="model_color_color_code">
<?php if ($model_color->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $model_color_grid->RowIndex ?>_color_code" id="x<?php echo $model_color_grid->RowIndex ?>_color_code" size="30" maxlength="30" value="<?php echo $model_color->color_code->EditValue ?>"<?php echo $model_color->color_code->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $model_color->color_code->ViewAttributes() ?>>
<?php echo $model_color->color_code->ViewValue ?></span>
<input type="hidden" name="x<?php echo $model_color_grid->RowIndex ?>_color_code" id="x<?php echo $model_color_grid->RowIndex ?>_color_code" value="<?php echo ew_HtmlEncode($model_color->color_code->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_color_code" id="o<?php echo $model_color_grid->RowIndex ?>_color_code" value="<?php echo ew_HtmlEncode($model_color->color_code->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($model_color->m_order->Visible) { // m_order ?>
		<td><span id="el$rowindex$_model_color_m_order" class="model_color_m_order">
<?php if ($model_color->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $model_color_grid->RowIndex ?>_m_order" id="x<?php echo $model_color_grid->RowIndex ?>_m_order" size="30" value="<?php echo $model_color->m_order->EditValue ?>"<?php echo $model_color->m_order->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $model_color->m_order->ViewAttributes() ?>>
<?php echo $model_color->m_order->ViewValue ?></span>
<input type="hidden" name="x<?php echo $model_color_grid->RowIndex ?>_m_order" id="x<?php echo $model_color_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model_color->m_order->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_m_order" id="o<?php echo $model_color_grid->RowIndex ?>_m_order" value="<?php echo ew_HtmlEncode($model_color->m_order->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($model_color->m_status->Visible) { // m_status ?>
		<td><span id="el$rowindex$_model_color_m_status" class="model_color_m_status">
<?php if ($model_color->CurrentAction <> "F") { ?>
<select id="x<?php echo $model_color_grid->RowIndex ?>_m_status" name="x<?php echo $model_color_grid->RowIndex ?>_m_status"<?php echo $model_color->m_status->EditAttributes() ?>>
<?php
if (is_array($model_color->m_status->EditValue)) {
	$arwrk = $model_color->m_status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model_color->m_status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $model_color->m_status->OldValue = "";
?>
</select>
<?php } else { ?>
<span<?php echo $model_color->m_status->ViewAttributes() ?>>
<?php echo $model_color->m_status->ViewValue ?></span>
<input type="hidden" name="x<?php echo $model_color_grid->RowIndex ?>_m_status" id="x<?php echo $model_color_grid->RowIndex ?>_m_status" value="<?php echo ew_HtmlEncode($model_color->m_status->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $model_color_grid->RowIndex ?>_m_status" id="o<?php echo $model_color_grid->RowIndex ?>_m_status" value="<?php echo ew_HtmlEncode($model_color->m_status->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$model_color_grid->ListOptions->Render("body", "right", $model_color_grid->RowCnt);
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
<input type="hidden" name="key_count" id="key_count" value="<?php echo $model_color_grid->KeyCount ?>">
<?php echo $model_color_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($model_color->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $model_color_grid->KeyCount ?>">
<?php echo $model_color_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($model_color->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="fmodel_colorgrid">
</div>
<?php

// Close recordset
if ($model_color_grid->Recordset)
	$model_color_grid->Recordset->Close();
?>
</div>
</td></tr></table>
<?php if ($model_color->Export == "") { ?>
<script type="text/javascript">
fmodel_colorgrid.Init();
</script>
<?php } ?>
<?php
$model_color_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$model_color_grid->Page_Terminate();
$Page = &$MasterPage;
?>
