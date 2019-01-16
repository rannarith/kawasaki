<?php include_once "admin_userinfo.php" ?>
<?php

// Create page object
if (!isset($model_gallery_grid)) $model_gallery_grid = new cmodel_gallery_grid();

// Page init
$model_gallery_grid->Page_Init();

// Page main
$model_gallery_grid->Page_Main();
?>
<?php if ($model_gallery->Export == "") { ?>
<script type="text/javascript">

// Page object
var model_gallery_grid = new ew_Page("model_gallery_grid");
model_gallery_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = model_gallery_grid.PageID; // For backward compatibility

// Form object
var fmodel_gallerygrid = new ew_Form("fmodel_gallerygrid");

// Validate form
fmodel_gallerygrid.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_model_id"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model_gallery->model_id->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_image"];
		aelm = fobj.elements["a" + infix + "_image"];
		var chk_image = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_image && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model_gallery->image->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_image"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_img_order"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model_gallery->img_order->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_img_order"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($model_gallery->img_order->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_status"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model_gallery->status->FldCaption()) ?>");

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
<?php if (EW_CLIENT_VALIDATE) { ?>
fmodel_gallerygrid.ValidateRequired = true;
<?php } else { ?>
fmodel_gallerygrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmodel_gallerygrid.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($model_gallery->CurrentAction == "gridadd") {
	if ($model_gallery->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$model_gallery_grid->TotalRecs = $model_gallery->SelectRecordCount();
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
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$model_gallery_grid->TotalRecs = $model_gallery->SelectRecordCount();
	} else {
		if ($model_gallery_grid->Recordset = $model_gallery_grid->LoadRecordset())
			$model_gallery_grid->TotalRecs = $model_gallery_grid->Recordset->RecordCount();
	}
	$model_gallery_grid->StartRec = 1;
	$model_gallery_grid->DisplayRecs = $model_gallery_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$model_gallery_grid->Recordset = $model_gallery_grid->LoadRecordset($model_gallery_grid->StartRec-1, $model_gallery_grid->DisplayRecs);
}
?>
<p style="white-space: nowrap;"><span class="ewTitle ewTableTitle"><?php if ($model_gallery->CurrentMode == "add" || $model_gallery->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($model_gallery->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $model_gallery->TableCaption() ?></span></p>
</p>
<?php $model_gallery_grid->ShowPageHeader(); ?>
<?php
$model_gallery_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fmodel_gallerygrid" class="ewForm">
<?php if (($model_gallery->CurrentMode == "add" || $model_gallery->CurrentMode == "copy" || $model_gallery->CurrentMode == "edit") && $model_gallery->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
<?php if ($model_gallery->AllowAddDeleteRow) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' border='0'></a>&nbsp;&nbsp;
</span>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
<div id="gmp_model_gallery" class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_model_gallerygrid" class="ewTable ewTableSeparate">
<?php echo $model_gallery->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$model_gallery_grid->RenderListOptions();

// Render list options (header, left)
$model_gallery_grid->ListOptions->Render("header", "left");
?>
<?php if ($model_gallery->gallery_id->Visible) { // gallery_id ?>
	<?php if ($model_gallery->SortUrl($model_gallery->gallery_id) == "") { ?>
		<td><span id="elh_model_gallery_gallery_id" class="model_gallery_gallery_id"><?php echo $model_gallery->gallery_id->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_model_gallery_gallery_id" class="model_gallery_gallery_id">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model_gallery->gallery_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($model_gallery->gallery_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model_gallery->gallery_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model_gallery->model_id->Visible) { // model_id ?>
	<?php if ($model_gallery->SortUrl($model_gallery->model_id) == "") { ?>
		<td><span id="elh_model_gallery_model_id" class="model_gallery_model_id"><?php echo $model_gallery->model_id->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_model_gallery_model_id" class="model_gallery_model_id">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model_gallery->model_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($model_gallery->model_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model_gallery->model_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model_gallery->image->Visible) { // image ?>
	<?php if ($model_gallery->SortUrl($model_gallery->image) == "") { ?>
		<td><span id="elh_model_gallery_image" class="model_gallery_image"><?php echo $model_gallery->image->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_model_gallery_image" class="model_gallery_image">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model_gallery->image->FldCaption() ?></td><td style="width: 10px;"><?php if ($model_gallery->image->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model_gallery->image->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model_gallery->img_order->Visible) { // img_order ?>
	<?php if ($model_gallery->SortUrl($model_gallery->img_order) == "") { ?>
		<td><span id="elh_model_gallery_img_order" class="model_gallery_img_order"><?php echo $model_gallery->img_order->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_model_gallery_img_order" class="model_gallery_img_order">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model_gallery->img_order->FldCaption() ?></td><td style="width: 10px;"><?php if ($model_gallery->img_order->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model_gallery->img_order->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model_gallery->status->Visible) { // status ?>
	<?php if ($model_gallery->SortUrl($model_gallery->status) == "") { ?>
		<td><span id="elh_model_gallery_status" class="model_gallery_status"><?php echo $model_gallery->status->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_model_gallery_status" class="model_gallery_status">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model_gallery->status->FldCaption() ?></td><td style="width: 10px;"><?php if ($model_gallery->status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model_gallery->status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
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
	if ($objForm->HasValue("key_count") && ($model_gallery->CurrentAction == "gridadd" || $model_gallery->CurrentAction == "gridedit" || $model_gallery->CurrentAction == "F")) {
		$model_gallery_grid->KeyCount = $objForm->GetValue("key_count");
		$model_gallery_grid->StopRec = $model_gallery_grid->KeyCount;
	}
}
$model_gallery_grid->RecCnt = $model_gallery_grid->StartRec - 1;
if ($model_gallery_grid->Recordset && !$model_gallery_grid->Recordset->EOF) {
	$model_gallery_grid->Recordset->MoveFirst();
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
			if ($objForm->HasValue("k_action"))
				$model_gallery_grid->RowAction = strval($objForm->GetValue("k_action"));
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
				$model_gallery_grid->LoadDefaultValues(); // Load default values
				$model_gallery_grid->RowOldKey = ""; // Clear old key value
			}
		} elseif ($model_gallery->CurrentAction == "gridedit") {
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
		<td<?php echo $model_gallery->gallery_id->CellAttributes() ?>><span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_gallery_id" class="model_gallery_gallery_id">
<?php if ($model_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" id="o<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" value="<?php echo ew_HtmlEncode($model_gallery->gallery_id->OldValue) ?>">
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $model_gallery->gallery_id->ViewAttributes() ?>>
<?php echo $model_gallery->gallery_id->EditValue ?></span>
<input type="hidden" name="x<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" id="x<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" value="<?php echo ew_HtmlEncode($model_gallery->gallery_id->CurrentValue) ?>">
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $model_gallery->gallery_id->ViewAttributes() ?>>
<?php echo $model_gallery->gallery_id->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" id="x<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" value="<?php echo ew_HtmlEncode($model_gallery->gallery_id->FormValue) ?>">
<input type="hidden" name="o<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" id="o<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" value="<?php echo ew_HtmlEncode($model_gallery->gallery_id->OldValue) ?>">
<?php } ?>
<a name="<?php echo $model_gallery_grid->PageObjName . "_row_" . $model_gallery_grid->RowCnt ?>" id="<?php echo $model_gallery_grid->PageObjName . "_row_" . $model_gallery_grid->RowCnt ?>"></a></span></td>
	<?php } ?>
	<?php if ($model_gallery->model_id->Visible) { // model_id ?>
		<td<?php echo $model_gallery->model_id->CellAttributes() ?>><span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_model_id" class="model_gallery_model_id">
<?php if ($model_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($model_gallery->model_id->getSessionValue() <> "") { ?>
<span<?php echo $model_gallery->model_id->ViewAttributes() ?>>
<?php echo $model_gallery->model_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id"<?php echo $model_gallery->model_id->EditAttributes() ?>>
<?php
if (is_array($model_gallery->model_id->EditValue)) {
	$arwrk = $model_gallery->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model_gallery->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $model_gallery->model_id->OldValue = "";
?>
</select>
<script type="text/javascript">
fmodel_gallerygrid.Lists["x_model_id"].Options = <?php echo (is_array($model_gallery->model_id->EditValue)) ? ew_ArrayToJson($model_gallery->model_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<input type="hidden" name="o<?php echo $model_gallery_grid->RowIndex ?>_model_id" id="o<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->OldValue) ?>">
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($model_gallery->model_id->getSessionValue() <> "") { ?>
<span<?php echo $model_gallery->model_id->ViewAttributes() ?>>
<?php echo $model_gallery->model_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id"<?php echo $model_gallery->model_id->EditAttributes() ?>>
<?php
if (is_array($model_gallery->model_id->EditValue)) {
	$arwrk = $model_gallery->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model_gallery->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $model_gallery->model_id->OldValue = "";
?>
</select>
<script type="text/javascript">
fmodel_gallerygrid.Lists["x_model_id"].Options = <?php echo (is_array($model_gallery->model_id->EditValue)) ? ew_ArrayToJson($model_gallery->model_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $model_gallery->model_id->ViewAttributes() ?>>
<?php echo $model_gallery->model_id->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->FormValue) ?>">
<input type="hidden" name="o<?php echo $model_gallery_grid->RowIndex ?>_model_id" id="o<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->OldValue) ?>">
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($model_gallery->image->Visible) { // image ?>
		<td<?php echo $model_gallery->image->CellAttributes() ?>><span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_image" class="model_gallery_image">
<?php if ($model_gallery_grid->RowAction == "insert") { // Add record ?>
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<div id="old_x<?php echo $model_gallery_grid->RowIndex ?>_image">
<?php if ($model_gallery->image->LinkAttributes() <> "") { ?>
<?php if (!empty($model_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_gallery->image->UploadPath) . $model_gallery->image->Upload->DbValue ?>" border="0"<?php echo $model_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_gallery->image->UploadPath) . $model_gallery->image->Upload->DbValue ?>" border="0"<?php echo $model_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x<?php echo $model_gallery_grid->RowIndex ?>_image">
<?php if ($model_gallery->image->ReadOnly) { ?>
<?php if (!empty($model_gallery->image->Upload->DbValue)) { ?>
<input type="hidden" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_gallery->image->Upload->DbValue)) { ?>
<label><input type="radio" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $model_gallery->image->EditAttrs["onchange"] = "this.form.a" . $model_gallery_grid->RowIndex . "_image[2].checked=true;" . @$model_gallery->image->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="3">
<?php } ?>
<input type="file" name="x<?php echo $model_gallery_grid->RowIndex ?>_image" id="x<?php echo $model_gallery_grid->RowIndex ?>_image" size="30"<?php echo $model_gallery->image->EditAttributes() ?>>
<?php } ?>
</div>
<?php } else { ?>
<input type="hidden" name="a_image" id="a_image" value="<?php echo $model_gallery->image->Upload->Action ?>">
<?php
if ($model_gallery->image->Upload->Action == "1") {
	if (!ew_Empty($model_gallery->image->Upload->DbValue)) {
?>
<img src="ewbv9.php?tbl=<?php echo $model_gallery->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $model_gallery_grid->RowIndex ?>&db=1&file=1&path=<?php echo urlencode($model_gallery->image->UploadPath) ?>" alt="" border="0">
<?php
	}
} elseif ($model_gallery->image->Upload->Action == "2") {
} else {
	if (!ew_Empty($model_gallery->image->Upload->Value)) {
?>
<img src="ewbv9.php?tbl=<?php echo $model_gallery->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $model_gallery_grid->RowIndex ?>" alt="" border="0" width=300>
<?php
	}
}
?>
<?php } ?>
<input type="hidden" name="o<?php echo $model_gallery_grid->RowIndex ?>_image" id="o<?php echo $model_gallery_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($model_gallery->image->OldValue) ?>">
<?php } else { // Edit record ?>
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<div id="old_x<?php echo $model_gallery_grid->RowIndex ?>_image">
<?php if ($model_gallery->image->LinkAttributes() <> "") { ?>
<?php if (!empty($model_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_gallery->image->UploadPath) . $model_gallery->image->Upload->DbValue ?>" border="0"<?php echo $model_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_gallery->image->UploadPath) . $model_gallery->image->Upload->DbValue ?>" border="0"<?php echo $model_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x<?php echo $model_gallery_grid->RowIndex ?>_image">
<?php if ($model_gallery->image->ReadOnly) { ?>
<?php if (!empty($model_gallery->image->Upload->DbValue)) { ?>
<input type="hidden" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_gallery->image->Upload->DbValue)) { ?>
<label><input type="radio" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $model_gallery->image->EditAttrs["onchange"] = "this.form.a" . $model_gallery_grid->RowIndex . "_image[2].checked=true;" . @$model_gallery->image->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="3">
<?php } ?>
<input type="file" name="x<?php echo $model_gallery_grid->RowIndex ?>_image" id="x<?php echo $model_gallery_grid->RowIndex ?>_image" size="30"<?php echo $model_gallery->image->EditAttributes() ?>>
<?php } ?>
</div>
<?php } else { ?>
<div id="old_x<?php echo $model_gallery_grid->RowIndex ?>_image">
<?php if ($model_gallery->image->LinkAttributes() <> "") { ?>
<?php if (!empty($model_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_gallery->image->UploadPath) . $model_gallery->image->Upload->DbValue ?>" border="0"<?php echo $model_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_gallery->image->UploadPath) . $model_gallery->image->Upload->DbValue ?>" border="0"<?php echo $model_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
<?php if (!ew_Empty($model_gallery->image->Upload->DbValue) && $model_gallery->image->Upload->Action == "3") echo "[" . $Language->Phrase("Old") . "]"; ?>
</div>
<div id="new_x<?php echo $model_gallery_grid->RowIndex ?>_image">
<input type="hidden" name="a_image" id="a_image" value="<?php echo $model_gallery->image->Upload->Action ?>">
<?php
if ($model_gallery->image->Upload->Action == "1") {
	echo "[" . $Language->Phrase("Keep") . "]";
} elseif ($model_gallery->image->Upload->Action == "2") {
	echo "[" . $Language->Phrase("Remove") . "]";
} else {
	if (!ew_Empty($model_gallery->image->Upload->Value)) {
?>
<img src="ewbv9.php?tbl=<?php echo $model_gallery->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $model_gallery_grid->RowIndex ?>" alt="" border="0" width=300>
<?php
	}
}
?>
<?php if (!ew_Empty($model_gallery->image->Upload->DbValue) && $model_gallery->image->Upload->Action == "3") echo "[" . $Language->Phrase("New") . "]"; ?>
</div>
<?php } ?>
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($model_gallery->img_order->Visible) { // img_order ?>
		<td<?php echo $model_gallery->img_order->CellAttributes() ?>><span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_img_order" class="model_gallery_img_order">
<?php if ($model_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" size="30" value="<?php echo $model_gallery->img_order->EditValue ?>"<?php echo $model_gallery->img_order->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="o<?php echo $model_gallery_grid->RowIndex ?>_img_order" value="<?php echo ew_HtmlEncode($model_gallery->img_order->OldValue) ?>">
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" size="30" value="<?php echo $model_gallery->img_order->EditValue ?>"<?php echo $model_gallery->img_order->EditAttributes() ?>>
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $model_gallery->img_order->ViewAttributes() ?>>
<?php echo $model_gallery->img_order->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" value="<?php echo ew_HtmlEncode($model_gallery->img_order->FormValue) ?>">
<input type="hidden" name="o<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="o<?php echo $model_gallery_grid->RowIndex ?>_img_order" value="<?php echo ew_HtmlEncode($model_gallery->img_order->OldValue) ?>">
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($model_gallery->status->Visible) { // status ?>
		<td<?php echo $model_gallery->status->CellAttributes() ?>><span id="el<?php echo $model_gallery_grid->RowCnt ?>_model_gallery_status" class="model_gallery_status">
<?php if ($model_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $model_gallery_grid->RowIndex ?>_status" name="x<?php echo $model_gallery_grid->RowIndex ?>_status"<?php echo $model_gallery->status->EditAttributes() ?>>
<?php
if (is_array($model_gallery->status->EditValue)) {
	$arwrk = $model_gallery->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model_gallery->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $model_gallery->status->OldValue = "";
?>
</select>
<input type="hidden" name="o<?php echo $model_gallery_grid->RowIndex ?>_status" id="o<?php echo $model_gallery_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model_gallery->status->OldValue) ?>">
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $model_gallery_grid->RowIndex ?>_status" name="x<?php echo $model_gallery_grid->RowIndex ?>_status"<?php echo $model_gallery->status->EditAttributes() ?>>
<?php
if (is_array($model_gallery->status->EditValue)) {
	$arwrk = $model_gallery->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model_gallery->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $model_gallery->status->OldValue = "";
?>
</select>
<?php } ?>
<?php if ($model_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $model_gallery->status->ViewAttributes() ?>>
<?php echo $model_gallery->status->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $model_gallery_grid->RowIndex ?>_status" id="x<?php echo $model_gallery_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model_gallery->status->FormValue) ?>">
<input type="hidden" name="o<?php echo $model_gallery_grid->RowIndex ?>_status" id="o<?php echo $model_gallery_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model_gallery->status->OldValue) ?>">
<?php } ?>
</span></td>
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
		$model_gallery_grid->LoadDefaultValues();

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
		<td><span id="el$rowindex$_model_gallery_gallery_id" class="model_gallery_gallery_id">
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<?php } else { ?>
<span<?php echo $model_gallery->gallery_id->ViewAttributes() ?>>
<?php echo $model_gallery->gallery_id->ViewValue ?></span>
<input type="hidden" name="x<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" id="x<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" value="<?php echo ew_HtmlEncode($model_gallery->gallery_id->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" id="o<?php echo $model_gallery_grid->RowIndex ?>_gallery_id" value="<?php echo ew_HtmlEncode($model_gallery->gallery_id->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($model_gallery->model_id->Visible) { // model_id ?>
		<td><span id="el$rowindex$_model_gallery_model_id" class="model_gallery_model_id">
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<?php if ($model_gallery->model_id->getSessionValue() <> "") { ?>
<span<?php echo $model_gallery->model_id->ViewAttributes() ?>>
<?php echo $model_gallery->model_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id"<?php echo $model_gallery->model_id->EditAttributes() ?>>
<?php
if (is_array($model_gallery->model_id->EditValue)) {
	$arwrk = $model_gallery->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model_gallery->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $model_gallery->model_id->OldValue = "";
?>
</select>
<script type="text/javascript">
fmodel_gallerygrid.Lists["x_model_id"].Options = <?php echo (is_array($model_gallery->model_id->EditValue)) ? ew_ArrayToJson($model_gallery->model_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php } else { ?>
<span<?php echo $model_gallery->model_id->ViewAttributes() ?>>
<?php echo $model_gallery->model_id->ViewValue ?></span>
<input type="hidden" name="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" id="x<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $model_gallery_grid->RowIndex ?>_model_id" id="o<?php echo $model_gallery_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($model_gallery->model_id->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($model_gallery->image->Visible) { // image ?>
		<td><span id="el$rowindex$_model_gallery_image" class="model_gallery_image">
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<div id="old_x<?php echo $model_gallery_grid->RowIndex ?>_image">
<?php if ($model_gallery->image->LinkAttributes() <> "") { ?>
<?php if (!empty($model_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_gallery->image->UploadPath) . $model_gallery->image->Upload->DbValue ?>" border="0"<?php echo $model_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_gallery->image->UploadPath) . $model_gallery->image->Upload->DbValue ?>" border="0"<?php echo $model_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x<?php echo $model_gallery_grid->RowIndex ?>_image">
<?php if ($model_gallery->image->ReadOnly) { ?>
<?php if (!empty($model_gallery->image->Upload->DbValue)) { ?>
<input type="hidden" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_gallery->image->Upload->DbValue)) { ?>
<label><input type="radio" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $model_gallery->image->EditAttrs["onchange"] = "this.form.a" . $model_gallery_grid->RowIndex . "_image[2].checked=true;" . @$model_gallery->image->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a<?php echo $model_gallery_grid->RowIndex ?>_image" id="a<?php echo $model_gallery_grid->RowIndex ?>_image" value="3">
<?php } ?>
<input type="file" name="x<?php echo $model_gallery_grid->RowIndex ?>_image" id="x<?php echo $model_gallery_grid->RowIndex ?>_image" size="30"<?php echo $model_gallery->image->EditAttributes() ?>>
<?php } ?>
</div>
<?php } else { ?>
<input type="hidden" name="a_image" id="a_image" value="<?php echo $model_gallery->image->Upload->Action ?>">
<?php
if ($model_gallery->image->Upload->Action == "1") {
	if (!ew_Empty($model_gallery->image->Upload->DbValue)) {
?>
<img src="ewbv9.php?tbl=<?php echo $model_gallery->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $model_gallery_grid->RowIndex ?>&db=1&file=1&path=<?php echo urlencode($model_gallery->image->UploadPath) ?>" alt="" border="0">
<?php
	}
} elseif ($model_gallery->image->Upload->Action == "2") {
} else {
	if (!ew_Empty($model_gallery->image->Upload->Value)) {
?>
<img src="ewbv9.php?tbl=<?php echo $model_gallery->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $model_gallery_grid->RowIndex ?>" alt="" border="0" width=300>
<?php
	}
}
?>
<?php } ?>
<input type="hidden" name="o<?php echo $model_gallery_grid->RowIndex ?>_image" id="o<?php echo $model_gallery_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($model_gallery->image->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($model_gallery->img_order->Visible) { // img_order ?>
		<td><span id="el$rowindex$_model_gallery_img_order" class="model_gallery_img_order">
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" size="30" value="<?php echo $model_gallery->img_order->EditValue ?>"<?php echo $model_gallery->img_order->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $model_gallery->img_order->ViewAttributes() ?>>
<?php echo $model_gallery->img_order->ViewValue ?></span>
<input type="hidden" name="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="x<?php echo $model_gallery_grid->RowIndex ?>_img_order" value="<?php echo ew_HtmlEncode($model_gallery->img_order->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $model_gallery_grid->RowIndex ?>_img_order" id="o<?php echo $model_gallery_grid->RowIndex ?>_img_order" value="<?php echo ew_HtmlEncode($model_gallery->img_order->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($model_gallery->status->Visible) { // status ?>
		<td><span id="el$rowindex$_model_gallery_status" class="model_gallery_status">
<?php if ($model_gallery->CurrentAction <> "F") { ?>
<select id="x<?php echo $model_gallery_grid->RowIndex ?>_status" name="x<?php echo $model_gallery_grid->RowIndex ?>_status"<?php echo $model_gallery->status->EditAttributes() ?>>
<?php
if (is_array($model_gallery->status->EditValue)) {
	$arwrk = $model_gallery->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model_gallery->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $model_gallery->status->OldValue = "";
?>
</select>
<?php } else { ?>
<span<?php echo $model_gallery->status->ViewAttributes() ?>>
<?php echo $model_gallery->status->ViewValue ?></span>
<input type="hidden" name="x<?php echo $model_gallery_grid->RowIndex ?>_status" id="x<?php echo $model_gallery_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model_gallery->status->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $model_gallery_grid->RowIndex ?>_status" id="o<?php echo $model_gallery_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($model_gallery->status->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$model_gallery_grid->ListOptions->Render("body", "right", $model_gallery_grid->RowCnt);
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
<input type="hidden" name="key_count" id="key_count" value="<?php echo $model_gallery_grid->KeyCount ?>">
<?php echo $model_gallery_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($model_gallery->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $model_gallery_grid->KeyCount ?>">
<?php echo $model_gallery_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($model_gallery->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="fmodel_gallerygrid">
</div>
<?php

// Close recordset
if ($model_gallery_grid->Recordset)
	$model_gallery_grid->Recordset->Close();
?>
</div>
</td></tr></table>
<?php if ($model_gallery->Export == "") { ?>
<script type="text/javascript">
fmodel_gallerygrid.Init();
</script>
<?php } ?>
<?php
$model_gallery_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$model_gallery_grid->Page_Terminate();
$Page = &$MasterPage;
?>
