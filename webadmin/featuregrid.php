<?php include_once "admin_userinfo.php" ?>
<?php

// Create page object
if (!isset($feature_grid)) $feature_grid = new cfeature_grid();

// Page init
$feature_grid->Page_Init();

// Page main
$feature_grid->Page_Main();
?>
<?php if ($feature->Export == "") { ?>
<script type="text/javascript">

// Page object
var feature_grid = new ew_Page("feature_grid");
feature_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = feature_grid.PageID; // For backward compatibility

// Form object
var ffeaturegrid = new ew_Form("ffeaturegrid");

// Validate form
ffeaturegrid.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_top_title"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($feature->top_title->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_title"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($feature->title->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_model_id"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($feature->model_id->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_thumbnail"];
		aelm = fobj.elements["a" + infix + "_thumbnail"];
		var chk_thumbnail = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_thumbnail && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($feature->thumbnail->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_thumbnail"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_f_order"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($feature->f_order->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_f_order"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($feature->f_order->FldErrMsg()) ?>");

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
ffeaturegrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "top_title", false)) return false;
	if (ew_ValueChanged(fobj, infix, "title", false)) return false;
	if (ew_ValueChanged(fobj, infix, "model_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "thumbnail", false)) return false;
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
<?php if (EW_CLIENT_VALIDATE) { ?>
ffeaturegrid.ValidateRequired = true;
<?php } else { ?>
ffeaturegrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffeaturegrid.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($feature->CurrentAction == "gridadd") {
	if ($feature->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$feature_grid->TotalRecs = $feature->SelectRecordCount();
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
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$feature_grid->TotalRecs = $feature->SelectRecordCount();
	} else {
		if ($feature_grid->Recordset = $feature_grid->LoadRecordset())
			$feature_grid->TotalRecs = $feature_grid->Recordset->RecordCount();
	}
	$feature_grid->StartRec = 1;
	$feature_grid->DisplayRecs = $feature_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$feature_grid->Recordset = $feature_grid->LoadRecordset($feature_grid->StartRec-1, $feature_grid->DisplayRecs);
}
?>
<p style="white-space: nowrap;"><span class="ewTitle ewTableTitle"><?php if ($feature->CurrentMode == "add" || $feature->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($feature->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $feature->TableCaption() ?></span></p>
</p>
<?php $feature_grid->ShowPageHeader(); ?>
<?php
$feature_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="ffeaturegrid" class="ewForm">
<?php if (($feature->CurrentMode == "add" || $feature->CurrentMode == "copy" || $feature->CurrentMode == "edit") && $feature->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
<?php if ($feature->AllowAddDeleteRow) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' border='0'></a>&nbsp;&nbsp;
</span>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
<div id="gmp_feature" class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_featuregrid" class="ewTable ewTableSeparate">
<?php echo $feature->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$feature_grid->RenderListOptions();

// Render list options (header, left)
$feature_grid->ListOptions->Render("header", "left");
?>
<?php if ($feature->feature_id->Visible) { // feature_id ?>
	<?php if ($feature->SortUrl($feature->feature_id) == "") { ?>
		<td><span id="elh_feature_feature_id" class="feature_feature_id"><?php echo $feature->feature_id->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_feature_feature_id" class="feature_feature_id">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $feature->feature_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($feature->feature_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($feature->feature_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($feature->top_title->Visible) { // top_title ?>
	<?php if ($feature->SortUrl($feature->top_title) == "") { ?>
		<td><span id="elh_feature_top_title" class="feature_top_title"><?php echo $feature->top_title->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_feature_top_title" class="feature_top_title">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $feature->top_title->FldCaption() ?></td><td style="width: 10px;"><?php if ($feature->top_title->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($feature->top_title->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($feature->title->Visible) { // title ?>
	<?php if ($feature->SortUrl($feature->title) == "") { ?>
		<td><span id="elh_feature_title" class="feature_title"><?php echo $feature->title->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_feature_title" class="feature_title">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $feature->title->FldCaption() ?></td><td style="width: 10px;"><?php if ($feature->title->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($feature->title->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($feature->model_id->Visible) { // model_id ?>
	<?php if ($feature->SortUrl($feature->model_id) == "") { ?>
		<td><span id="elh_feature_model_id" class="feature_model_id"><?php echo $feature->model_id->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_feature_model_id" class="feature_model_id">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $feature->model_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($feature->model_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($feature->model_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($feature->thumbnail->Visible) { // thumbnail ?>
	<?php if ($feature->SortUrl($feature->thumbnail) == "") { ?>
		<td><span id="elh_feature_thumbnail" class="feature_thumbnail"><?php echo $feature->thumbnail->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_feature_thumbnail" class="feature_thumbnail">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $feature->thumbnail->FldCaption() ?></td><td style="width: 10px;"><?php if ($feature->thumbnail->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($feature->thumbnail->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($feature->f_order->Visible) { // f_order ?>
	<?php if ($feature->SortUrl($feature->f_order) == "") { ?>
		<td><span id="elh_feature_f_order" class="feature_f_order"><?php echo $feature->f_order->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_feature_f_order" class="feature_f_order">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $feature->f_order->FldCaption() ?></td><td style="width: 10px;"><?php if ($feature->f_order->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($feature->f_order->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
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
	if ($objForm->HasValue("key_count") && ($feature->CurrentAction == "gridadd" || $feature->CurrentAction == "gridedit" || $feature->CurrentAction == "F")) {
		$feature_grid->KeyCount = $objForm->GetValue("key_count");
		$feature_grid->StopRec = $feature_grid->KeyCount;
	}
}
$feature_grid->RecCnt = $feature_grid->StartRec - 1;
if ($feature_grid->Recordset && !$feature_grid->Recordset->EOF) {
	$feature_grid->Recordset->MoveFirst();
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
			if ($objForm->HasValue("k_action"))
				$feature_grid->RowAction = strval($objForm->GetValue("k_action"));
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
				$feature_grid->LoadDefaultValues(); // Load default values
				$feature_grid->RowOldKey = ""; // Clear old key value
			}
		} elseif ($feature->CurrentAction == "gridedit") {
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
		<td<?php echo $feature->feature_id->CellAttributes() ?>><span id="el<?php echo $feature_grid->RowCnt ?>_feature_feature_id" class="feature_feature_id">
<?php if ($feature->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_feature_id" id="o<?php echo $feature_grid->RowIndex ?>_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->OldValue) ?>">
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $feature->feature_id->ViewAttributes() ?>>
<?php echo $feature->feature_id->EditValue ?></span>
<input type="hidden" name="x<?php echo $feature_grid->RowIndex ?>_feature_id" id="x<?php echo $feature_grid->RowIndex ?>_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->CurrentValue) ?>">
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $feature->feature_id->ViewAttributes() ?>>
<?php echo $feature->feature_id->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $feature_grid->RowIndex ?>_feature_id" id="x<?php echo $feature_grid->RowIndex ?>_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->FormValue) ?>">
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_feature_id" id="o<?php echo $feature_grid->RowIndex ?>_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->OldValue) ?>">
<?php } ?>
<a name="<?php echo $feature_grid->PageObjName . "_row_" . $feature_grid->RowCnt ?>" id="<?php echo $feature_grid->PageObjName . "_row_" . $feature_grid->RowCnt ?>"></a></span></td>
	<?php } ?>
	<?php if ($feature->top_title->Visible) { // top_title ?>
		<td<?php echo $feature->top_title->CellAttributes() ?>><span id="el<?php echo $feature_grid->RowCnt ?>_feature_top_title" class="feature_top_title">
<?php if ($feature->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $feature_grid->RowIndex ?>_top_title" id="x<?php echo $feature_grid->RowIndex ?>_top_title" size="30" maxlength="150" value="<?php echo $feature->top_title->EditValue ?>"<?php echo $feature->top_title->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_top_title" id="o<?php echo $feature_grid->RowIndex ?>_top_title" value="<?php echo ew_HtmlEncode($feature->top_title->OldValue) ?>">
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $feature_grid->RowIndex ?>_top_title" id="x<?php echo $feature_grid->RowIndex ?>_top_title" size="30" maxlength="150" value="<?php echo $feature->top_title->EditValue ?>"<?php echo $feature->top_title->EditAttributes() ?>>
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $feature->top_title->ViewAttributes() ?>>
<?php echo $feature->top_title->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $feature_grid->RowIndex ?>_top_title" id="x<?php echo $feature_grid->RowIndex ?>_top_title" value="<?php echo ew_HtmlEncode($feature->top_title->FormValue) ?>">
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_top_title" id="o<?php echo $feature_grid->RowIndex ?>_top_title" value="<?php echo ew_HtmlEncode($feature->top_title->OldValue) ?>">
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($feature->title->Visible) { // title ?>
		<td<?php echo $feature->title->CellAttributes() ?>><span id="el<?php echo $feature_grid->RowCnt ?>_feature_title" class="feature_title">
<?php if ($feature->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $feature_grid->RowIndex ?>_title" id="x<?php echo $feature_grid->RowIndex ?>_title" size="30" maxlength="50" value="<?php echo $feature->title->EditValue ?>"<?php echo $feature->title->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_title" id="o<?php echo $feature_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($feature->title->OldValue) ?>">
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $feature_grid->RowIndex ?>_title" id="x<?php echo $feature_grid->RowIndex ?>_title" size="30" maxlength="50" value="<?php echo $feature->title->EditValue ?>"<?php echo $feature->title->EditAttributes() ?>>
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $feature->title->ViewAttributes() ?>>
<?php echo $feature->title->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $feature_grid->RowIndex ?>_title" id="x<?php echo $feature_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($feature->title->FormValue) ?>">
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_title" id="o<?php echo $feature_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($feature->title->OldValue) ?>">
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($feature->model_id->Visible) { // model_id ?>
		<td<?php echo $feature->model_id->CellAttributes() ?>><span id="el<?php echo $feature_grid->RowCnt ?>_feature_model_id" class="feature_model_id">
<?php if ($feature->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($feature->model_id->getSessionValue() <> "") { ?>
<span<?php echo $feature->model_id->ViewAttributes() ?>>
<?php echo $feature->model_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $feature_grid->RowIndex ?>_model_id" name="x<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $feature_grid->RowIndex ?>_model_id" name="x<?php echo $feature_grid->RowIndex ?>_model_id"<?php echo $feature->model_id->EditAttributes() ?>>
<?php
if (is_array($feature->model_id->EditValue)) {
	$arwrk = $feature->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($feature->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $feature->model_id->OldValue = "";
?>
</select>
<script type="text/javascript">
ffeaturegrid.Lists["x_model_id"].Options = <?php echo (is_array($feature->model_id->EditValue)) ? ew_ArrayToJson($feature->model_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_model_id" id="o<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->OldValue) ?>">
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($feature->model_id->getSessionValue() <> "") { ?>
<span<?php echo $feature->model_id->ViewAttributes() ?>>
<?php echo $feature->model_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $feature_grid->RowIndex ?>_model_id" name="x<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $feature_grid->RowIndex ?>_model_id" name="x<?php echo $feature_grid->RowIndex ?>_model_id"<?php echo $feature->model_id->EditAttributes() ?>>
<?php
if (is_array($feature->model_id->EditValue)) {
	$arwrk = $feature->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($feature->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $feature->model_id->OldValue = "";
?>
</select>
<script type="text/javascript">
ffeaturegrid.Lists["x_model_id"].Options = <?php echo (is_array($feature->model_id->EditValue)) ? ew_ArrayToJson($feature->model_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $feature->model_id->ViewAttributes() ?>>
<?php echo $feature->model_id->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $feature_grid->RowIndex ?>_model_id" id="x<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->FormValue) ?>">
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_model_id" id="o<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->OldValue) ?>">
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($feature->thumbnail->Visible) { // thumbnail ?>
		<td<?php echo $feature->thumbnail->CellAttributes() ?>><span id="el<?php echo $feature_grid->RowCnt ?>_feature_thumbnail" class="feature_thumbnail">
<?php if ($feature_grid->RowAction == "insert") { // Add record ?>
<?php if ($feature->CurrentAction <> "F") { ?>
<div id="old_x<?php echo $feature_grid->RowIndex ?>_thumbnail">
<?php if ($feature->thumbnail->LinkAttributes() <> "") { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $feature->thumbnail->UploadPath) . $feature->thumbnail->Upload->DbValue ?>" border="0"<?php echo $feature->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($feature->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $feature->thumbnail->UploadPath) . $feature->thumbnail->Upload->DbValue ?>" border="0"<?php echo $feature->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($feature->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x<?php echo $feature_grid->RowIndex ?>_thumbnail">
<?php if ($feature->thumbnail->ReadOnly) { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<input type="hidden" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<label><input type="radio" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $feature->thumbnail->EditAttrs["onchange"] = "this.form.a" . $feature_grid->RowIndex . "_thumbnail[2].checked=true;" . @$feature->thumbnail->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="3">
<?php } ?>
<input type="file" name="x<?php echo $feature_grid->RowIndex ?>_thumbnail" id="x<?php echo $feature_grid->RowIndex ?>_thumbnail" size="30"<?php echo $feature->thumbnail->EditAttributes() ?>>
<?php } ?>
</div>
<?php } else { ?>
<input type="hidden" name="a_thumbnail" id="a_thumbnail" value="<?php echo $feature->thumbnail->Upload->Action ?>">
<?php
if ($feature->thumbnail->Upload->Action == "1") {
	if (!ew_Empty($feature->thumbnail->Upload->DbValue)) {
?>
<img src="ewbv9.php?tbl=<?php echo $feature->TableVar ?>&fld=x_thumbnail&rnd=<?php echo ew_Random() ?>&idx=<?php echo $feature_grid->RowIndex ?>&db=1&file=1&path=<?php echo urlencode($feature->thumbnail->UploadPath) ?>" alt="" border="0">
<?php
	}
} elseif ($feature->thumbnail->Upload->Action == "2") {
} else {
	if (!ew_Empty($feature->thumbnail->Upload->Value)) {
?>
<img src="ewbv9.php?tbl=<?php echo $feature->TableVar ?>&fld=x_thumbnail&rnd=<?php echo ew_Random() ?>&idx=<?php echo $feature_grid->RowIndex ?>" alt="" border="0" width=300>
<?php
	}
}
?>
<?php } ?>
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_thumbnail" id="o<?php echo $feature_grid->RowIndex ?>_thumbnail" value="<?php echo ew_HtmlEncode($feature->thumbnail->OldValue) ?>">
<?php } else { // Edit record ?>
<?php if ($feature->CurrentAction <> "F") { ?>
<div id="old_x<?php echo $feature_grid->RowIndex ?>_thumbnail">
<?php if ($feature->thumbnail->LinkAttributes() <> "") { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $feature->thumbnail->UploadPath) . $feature->thumbnail->Upload->DbValue ?>" border="0"<?php echo $feature->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($feature->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $feature->thumbnail->UploadPath) . $feature->thumbnail->Upload->DbValue ?>" border="0"<?php echo $feature->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($feature->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x<?php echo $feature_grid->RowIndex ?>_thumbnail">
<?php if ($feature->thumbnail->ReadOnly) { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<input type="hidden" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<label><input type="radio" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $feature->thumbnail->EditAttrs["onchange"] = "this.form.a" . $feature_grid->RowIndex . "_thumbnail[2].checked=true;" . @$feature->thumbnail->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="3">
<?php } ?>
<input type="file" name="x<?php echo $feature_grid->RowIndex ?>_thumbnail" id="x<?php echo $feature_grid->RowIndex ?>_thumbnail" size="30"<?php echo $feature->thumbnail->EditAttributes() ?>>
<?php } ?>
</div>
<?php } else { ?>
<div id="old_x<?php echo $feature_grid->RowIndex ?>_thumbnail">
<?php if ($feature->thumbnail->LinkAttributes() <> "") { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $feature->thumbnail->UploadPath) . $feature->thumbnail->Upload->DbValue ?>" border="0"<?php echo $feature->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($feature->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $feature->thumbnail->UploadPath) . $feature->thumbnail->Upload->DbValue ?>" border="0"<?php echo $feature->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($feature->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
<?php if (!ew_Empty($feature->thumbnail->Upload->DbValue) && $feature->thumbnail->Upload->Action == "3") echo "[" . $Language->Phrase("Old") . "]"; ?>
</div>
<div id="new_x<?php echo $feature_grid->RowIndex ?>_thumbnail">
<input type="hidden" name="a_thumbnail" id="a_thumbnail" value="<?php echo $feature->thumbnail->Upload->Action ?>">
<?php
if ($feature->thumbnail->Upload->Action == "1") {
	echo "[" . $Language->Phrase("Keep") . "]";
} elseif ($feature->thumbnail->Upload->Action == "2") {
	echo "[" . $Language->Phrase("Remove") . "]";
} else {
	if (!ew_Empty($feature->thumbnail->Upload->Value)) {
?>
<img src="ewbv9.php?tbl=<?php echo $feature->TableVar ?>&fld=x_thumbnail&rnd=<?php echo ew_Random() ?>&idx=<?php echo $feature_grid->RowIndex ?>" alt="" border="0" width=300>
<?php
	}
}
?>
<?php if (!ew_Empty($feature->thumbnail->Upload->DbValue) && $feature->thumbnail->Upload->Action == "3") echo "[" . $Language->Phrase("New") . "]"; ?>
</div>
<?php } ?>
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($feature->f_order->Visible) { // f_order ?>
		<td<?php echo $feature->f_order->CellAttributes() ?>><span id="el<?php echo $feature_grid->RowCnt ?>_feature_f_order" class="feature_f_order">
<?php if ($feature->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $feature_grid->RowIndex ?>_f_order" id="x<?php echo $feature_grid->RowIndex ?>_f_order" size="30" value="<?php echo $feature->f_order->EditValue ?>"<?php echo $feature->f_order->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_f_order" id="o<?php echo $feature_grid->RowIndex ?>_f_order" value="<?php echo ew_HtmlEncode($feature->f_order->OldValue) ?>">
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $feature_grid->RowIndex ?>_f_order" id="x<?php echo $feature_grid->RowIndex ?>_f_order" size="30" value="<?php echo $feature->f_order->EditValue ?>"<?php echo $feature->f_order->EditAttributes() ?>>
<?php } ?>
<?php if ($feature->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $feature->f_order->ViewAttributes() ?>>
<?php echo $feature->f_order->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $feature_grid->RowIndex ?>_f_order" id="x<?php echo $feature_grid->RowIndex ?>_f_order" value="<?php echo ew_HtmlEncode($feature->f_order->FormValue) ?>">
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_f_order" id="o<?php echo $feature_grid->RowIndex ?>_f_order" value="<?php echo ew_HtmlEncode($feature->f_order->OldValue) ?>">
<?php } ?>
</span></td>
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
		$feature_grid->LoadDefaultValues();

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
		<td><span id="el$rowindex$_feature_feature_id" class="feature_feature_id">
<?php if ($feature->CurrentAction <> "F") { ?>
<?php } else { ?>
<span<?php echo $feature->feature_id->ViewAttributes() ?>>
<?php echo $feature->feature_id->ViewValue ?></span>
<input type="hidden" name="x<?php echo $feature_grid->RowIndex ?>_feature_id" id="x<?php echo $feature_grid->RowIndex ?>_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_feature_id" id="o<?php echo $feature_grid->RowIndex ?>_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($feature->top_title->Visible) { // top_title ?>
		<td><span id="el$rowindex$_feature_top_title" class="feature_top_title">
<?php if ($feature->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $feature_grid->RowIndex ?>_top_title" id="x<?php echo $feature_grid->RowIndex ?>_top_title" size="30" maxlength="150" value="<?php echo $feature->top_title->EditValue ?>"<?php echo $feature->top_title->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $feature->top_title->ViewAttributes() ?>>
<?php echo $feature->top_title->ViewValue ?></span>
<input type="hidden" name="x<?php echo $feature_grid->RowIndex ?>_top_title" id="x<?php echo $feature_grid->RowIndex ?>_top_title" value="<?php echo ew_HtmlEncode($feature->top_title->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_top_title" id="o<?php echo $feature_grid->RowIndex ?>_top_title" value="<?php echo ew_HtmlEncode($feature->top_title->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($feature->title->Visible) { // title ?>
		<td><span id="el$rowindex$_feature_title" class="feature_title">
<?php if ($feature->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $feature_grid->RowIndex ?>_title" id="x<?php echo $feature_grid->RowIndex ?>_title" size="30" maxlength="50" value="<?php echo $feature->title->EditValue ?>"<?php echo $feature->title->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $feature->title->ViewAttributes() ?>>
<?php echo $feature->title->ViewValue ?></span>
<input type="hidden" name="x<?php echo $feature_grid->RowIndex ?>_title" id="x<?php echo $feature_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($feature->title->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_title" id="o<?php echo $feature_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($feature->title->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($feature->model_id->Visible) { // model_id ?>
		<td><span id="el$rowindex$_feature_model_id" class="feature_model_id">
<?php if ($feature->CurrentAction <> "F") { ?>
<?php if ($feature->model_id->getSessionValue() <> "") { ?>
<span<?php echo $feature->model_id->ViewAttributes() ?>>
<?php echo $feature->model_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $feature_grid->RowIndex ?>_model_id" name="x<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $feature_grid->RowIndex ?>_model_id" name="x<?php echo $feature_grid->RowIndex ?>_model_id"<?php echo $feature->model_id->EditAttributes() ?>>
<?php
if (is_array($feature->model_id->EditValue)) {
	$arwrk = $feature->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($feature->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $feature->model_id->OldValue = "";
?>
</select>
<script type="text/javascript">
ffeaturegrid.Lists["x_model_id"].Options = <?php echo (is_array($feature->model_id->EditValue)) ? ew_ArrayToJson($feature->model_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php } else { ?>
<span<?php echo $feature->model_id->ViewAttributes() ?>>
<?php echo $feature->model_id->ViewValue ?></span>
<input type="hidden" name="x<?php echo $feature_grid->RowIndex ?>_model_id" id="x<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_model_id" id="o<?php echo $feature_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($feature->thumbnail->Visible) { // thumbnail ?>
		<td><span id="el$rowindex$_feature_thumbnail" class="feature_thumbnail">
<?php if ($feature->CurrentAction <> "F") { ?>
<div id="old_x<?php echo $feature_grid->RowIndex ?>_thumbnail">
<?php if ($feature->thumbnail->LinkAttributes() <> "") { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $feature->thumbnail->UploadPath) . $feature->thumbnail->Upload->DbValue ?>" border="0"<?php echo $feature->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($feature->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $feature->thumbnail->UploadPath) . $feature->thumbnail->Upload->DbValue ?>" border="0"<?php echo $feature->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($feature->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x<?php echo $feature_grid->RowIndex ?>_thumbnail">
<?php if ($feature->thumbnail->ReadOnly) { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<input type="hidden" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<label><input type="radio" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $feature->thumbnail->EditAttrs["onchange"] = "this.form.a" . $feature_grid->RowIndex . "_thumbnail[2].checked=true;" . @$feature->thumbnail->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a<?php echo $feature_grid->RowIndex ?>_thumbnail" id="a<?php echo $feature_grid->RowIndex ?>_thumbnail" value="3">
<?php } ?>
<input type="file" name="x<?php echo $feature_grid->RowIndex ?>_thumbnail" id="x<?php echo $feature_grid->RowIndex ?>_thumbnail" size="30"<?php echo $feature->thumbnail->EditAttributes() ?>>
<?php } ?>
</div>
<?php } else { ?>
<input type="hidden" name="a_thumbnail" id="a_thumbnail" value="<?php echo $feature->thumbnail->Upload->Action ?>">
<?php
if ($feature->thumbnail->Upload->Action == "1") {
	if (!ew_Empty($feature->thumbnail->Upload->DbValue)) {
?>
<img src="ewbv9.php?tbl=<?php echo $feature->TableVar ?>&fld=x_thumbnail&rnd=<?php echo ew_Random() ?>&idx=<?php echo $feature_grid->RowIndex ?>&db=1&file=1&path=<?php echo urlencode($feature->thumbnail->UploadPath) ?>" alt="" border="0">
<?php
	}
} elseif ($feature->thumbnail->Upload->Action == "2") {
} else {
	if (!ew_Empty($feature->thumbnail->Upload->Value)) {
?>
<img src="ewbv9.php?tbl=<?php echo $feature->TableVar ?>&fld=x_thumbnail&rnd=<?php echo ew_Random() ?>&idx=<?php echo $feature_grid->RowIndex ?>" alt="" border="0" width=300>
<?php
	}
}
?>
<?php } ?>
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_thumbnail" id="o<?php echo $feature_grid->RowIndex ?>_thumbnail" value="<?php echo ew_HtmlEncode($feature->thumbnail->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($feature->f_order->Visible) { // f_order ?>
		<td><span id="el$rowindex$_feature_f_order" class="feature_f_order">
<?php if ($feature->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $feature_grid->RowIndex ?>_f_order" id="x<?php echo $feature_grid->RowIndex ?>_f_order" size="30" value="<?php echo $feature->f_order->EditValue ?>"<?php echo $feature->f_order->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $feature->f_order->ViewAttributes() ?>>
<?php echo $feature->f_order->ViewValue ?></span>
<input type="hidden" name="x<?php echo $feature_grid->RowIndex ?>_f_order" id="x<?php echo $feature_grid->RowIndex ?>_f_order" value="<?php echo ew_HtmlEncode($feature->f_order->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $feature_grid->RowIndex ?>_f_order" id="o<?php echo $feature_grid->RowIndex ?>_f_order" value="<?php echo ew_HtmlEncode($feature->f_order->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$feature_grid->ListOptions->Render("body", "right", $feature_grid->RowCnt);
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
<input type="hidden" name="key_count" id="key_count" value="<?php echo $feature_grid->KeyCount ?>">
<?php echo $feature_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($feature->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $feature_grid->KeyCount ?>">
<?php echo $feature_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($feature->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="ffeaturegrid">
</div>
<?php

// Close recordset
if ($feature_grid->Recordset)
	$feature_grid->Recordset->Close();
?>
</div>
</td></tr></table>
<?php if ($feature->Export == "") { ?>
<script type="text/javascript">
ffeaturegrid.Init();
</script>
<?php } ?>
<?php
$feature_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$feature_grid->Page_Terminate();
$Page = &$MasterPage;
?>
