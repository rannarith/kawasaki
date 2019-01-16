<?php include_once "admin_userinfo.php" ?>
<?php

// Create page object
if (!isset($specification_grid)) $specification_grid = new cspecification_grid();

// Page init
$specification_grid->Page_Init();

// Page main
$specification_grid->Page_Main();
?>
<?php if ($specification->Export == "") { ?>
<script type="text/javascript">

// Page object
var specification_grid = new ew_Page("specification_grid");
specification_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = specification_grid.PageID; // For backward compatibility

// Form object
var fspecificationgrid = new ew_Form("fspecificationgrid");

// Validate form
fspecificationgrid.Validate = function(fobj) {
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
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($specification->model_id->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_title"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($specification->title->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_s_order"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($specification->s_order->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_s_order"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($specification->s_order->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_status"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($specification->status->FldCaption()) ?>");

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
<?php if (EW_CLIENT_VALIDATE) { ?>
fspecificationgrid.ValidateRequired = true;
<?php } else { ?>
fspecificationgrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fspecificationgrid.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($specification->CurrentAction == "gridadd") {
	if ($specification->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$specification_grid->TotalRecs = $specification->SelectRecordCount();
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
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$specification_grid->TotalRecs = $specification->SelectRecordCount();
	} else {
		if ($specification_grid->Recordset = $specification_grid->LoadRecordset())
			$specification_grid->TotalRecs = $specification_grid->Recordset->RecordCount();
	}
	$specification_grid->StartRec = 1;
	$specification_grid->DisplayRecs = $specification_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$specification_grid->Recordset = $specification_grid->LoadRecordset($specification_grid->StartRec-1, $specification_grid->DisplayRecs);
}
?>
<p style="white-space: nowrap;"><span class="ewTitle ewTableTitle"><?php if ($specification->CurrentMode == "add" || $specification->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($specification->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $specification->TableCaption() ?></span></p>
</p>
<?php $specification_grid->ShowPageHeader(); ?>
<?php
$specification_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fspecificationgrid" class="ewForm">
<?php if (($specification->CurrentMode == "add" || $specification->CurrentMode == "copy" || $specification->CurrentMode == "edit") && $specification->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
<?php if ($specification->AllowAddDeleteRow) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' border='0'></a>&nbsp;&nbsp;
</span>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
<div id="gmp_specification" class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_specificationgrid" class="ewTable ewTableSeparate">
<?php echo $specification->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$specification_grid->RenderListOptions();

// Render list options (header, left)
$specification_grid->ListOptions->Render("header", "left");
?>
<?php if ($specification->spec_id->Visible) { // spec_id ?>
	<?php if ($specification->SortUrl($specification->spec_id) == "") { ?>
		<td><span id="elh_specification_spec_id" class="specification_spec_id"><?php echo $specification->spec_id->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_specification_spec_id" class="specification_spec_id">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $specification->spec_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($specification->spec_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($specification->spec_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($specification->model_id->Visible) { // model_id ?>
	<?php if ($specification->SortUrl($specification->model_id) == "") { ?>
		<td><span id="elh_specification_model_id" class="specification_model_id"><?php echo $specification->model_id->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_specification_model_id" class="specification_model_id">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $specification->model_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($specification->model_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($specification->model_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($specification->title->Visible) { // title ?>
	<?php if ($specification->SortUrl($specification->title) == "") { ?>
		<td><span id="elh_specification_title" class="specification_title"><?php echo $specification->title->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_specification_title" class="specification_title">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $specification->title->FldCaption() ?></td><td style="width: 10px;"><?php if ($specification->title->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($specification->title->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($specification->s_order->Visible) { // s_order ?>
	<?php if ($specification->SortUrl($specification->s_order) == "") { ?>
		<td><span id="elh_specification_s_order" class="specification_s_order"><?php echo $specification->s_order->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_specification_s_order" class="specification_s_order">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $specification->s_order->FldCaption() ?></td><td style="width: 10px;"><?php if ($specification->s_order->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($specification->s_order->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($specification->status->Visible) { // status ?>
	<?php if ($specification->SortUrl($specification->status) == "") { ?>
		<td><span id="elh_specification_status" class="specification_status"><?php echo $specification->status->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_specification_status" class="specification_status">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $specification->status->FldCaption() ?></td><td style="width: 10px;"><?php if ($specification->status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($specification->status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
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
	if ($objForm->HasValue("key_count") && ($specification->CurrentAction == "gridadd" || $specification->CurrentAction == "gridedit" || $specification->CurrentAction == "F")) {
		$specification_grid->KeyCount = $objForm->GetValue("key_count");
		$specification_grid->StopRec = $specification_grid->KeyCount;
	}
}
$specification_grid->RecCnt = $specification_grid->StartRec - 1;
if ($specification_grid->Recordset && !$specification_grid->Recordset->EOF) {
	$specification_grid->Recordset->MoveFirst();
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
			if ($objForm->HasValue("k_action"))
				$specification_grid->RowAction = strval($objForm->GetValue("k_action"));
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
				$specification_grid->LoadDefaultValues(); // Load default values
				$specification_grid->RowOldKey = ""; // Clear old key value
			}
		} elseif ($specification->CurrentAction == "gridedit") {
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
		<td<?php echo $specification->spec_id->CellAttributes() ?>><span id="el<?php echo $specification_grid->RowCnt ?>_specification_spec_id" class="specification_spec_id">
<?php if ($specification->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_spec_id" id="o<?php echo $specification_grid->RowIndex ?>_spec_id" value="<?php echo ew_HtmlEncode($specification->spec_id->OldValue) ?>">
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $specification->spec_id->ViewAttributes() ?>>
<?php echo $specification->spec_id->EditValue ?></span>
<input type="hidden" name="x<?php echo $specification_grid->RowIndex ?>_spec_id" id="x<?php echo $specification_grid->RowIndex ?>_spec_id" value="<?php echo ew_HtmlEncode($specification->spec_id->CurrentValue) ?>">
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $specification->spec_id->ViewAttributes() ?>>
<?php echo $specification->spec_id->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $specification_grid->RowIndex ?>_spec_id" id="x<?php echo $specification_grid->RowIndex ?>_spec_id" value="<?php echo ew_HtmlEncode($specification->spec_id->FormValue) ?>">
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_spec_id" id="o<?php echo $specification_grid->RowIndex ?>_spec_id" value="<?php echo ew_HtmlEncode($specification->spec_id->OldValue) ?>">
<?php } ?>
<a name="<?php echo $specification_grid->PageObjName . "_row_" . $specification_grid->RowCnt ?>" id="<?php echo $specification_grid->PageObjName . "_row_" . $specification_grid->RowCnt ?>"></a></span></td>
	<?php } ?>
	<?php if ($specification->model_id->Visible) { // model_id ?>
		<td<?php echo $specification->model_id->CellAttributes() ?>><span id="el<?php echo $specification_grid->RowCnt ?>_specification_model_id" class="specification_model_id">
<?php if ($specification->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($specification->model_id->getSessionValue() <> "") { ?>
<span<?php echo $specification->model_id->ViewAttributes() ?>>
<?php echo $specification->model_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $specification_grid->RowIndex ?>_model_id" name="x<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $specification_grid->RowIndex ?>_model_id" name="x<?php echo $specification_grid->RowIndex ?>_model_id"<?php echo $specification->model_id->EditAttributes() ?>>
<?php
if (is_array($specification->model_id->EditValue)) {
	$arwrk = $specification->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($specification->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $specification->model_id->OldValue = "";
?>
</select>
<script type="text/javascript">
fspecificationgrid.Lists["x_model_id"].Options = <?php echo (is_array($specification->model_id->EditValue)) ? ew_ArrayToJson($specification->model_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_model_id" id="o<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->OldValue) ?>">
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($specification->model_id->getSessionValue() <> "") { ?>
<span<?php echo $specification->model_id->ViewAttributes() ?>>
<?php echo $specification->model_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $specification_grid->RowIndex ?>_model_id" name="x<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $specification_grid->RowIndex ?>_model_id" name="x<?php echo $specification_grid->RowIndex ?>_model_id"<?php echo $specification->model_id->EditAttributes() ?>>
<?php
if (is_array($specification->model_id->EditValue)) {
	$arwrk = $specification->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($specification->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $specification->model_id->OldValue = "";
?>
</select>
<script type="text/javascript">
fspecificationgrid.Lists["x_model_id"].Options = <?php echo (is_array($specification->model_id->EditValue)) ? ew_ArrayToJson($specification->model_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $specification->model_id->ViewAttributes() ?>>
<?php echo $specification->model_id->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $specification_grid->RowIndex ?>_model_id" id="x<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->FormValue) ?>">
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_model_id" id="o<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->OldValue) ?>">
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($specification->title->Visible) { // title ?>
		<td<?php echo $specification->title->CellAttributes() ?>><span id="el<?php echo $specification_grid->RowCnt ?>_specification_title" class="specification_title">
<?php if ($specification->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $specification_grid->RowIndex ?>_title" id="x<?php echo $specification_grid->RowIndex ?>_title" size="30" maxlength="150" value="<?php echo $specification->title->EditValue ?>"<?php echo $specification->title->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_title" id="o<?php echo $specification_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($specification->title->OldValue) ?>">
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $specification_grid->RowIndex ?>_title" id="x<?php echo $specification_grid->RowIndex ?>_title" size="30" maxlength="150" value="<?php echo $specification->title->EditValue ?>"<?php echo $specification->title->EditAttributes() ?>>
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $specification->title->ViewAttributes() ?>>
<?php echo $specification->title->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $specification_grid->RowIndex ?>_title" id="x<?php echo $specification_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($specification->title->FormValue) ?>">
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_title" id="o<?php echo $specification_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($specification->title->OldValue) ?>">
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($specification->s_order->Visible) { // s_order ?>
		<td<?php echo $specification->s_order->CellAttributes() ?>><span id="el<?php echo $specification_grid->RowCnt ?>_specification_s_order" class="specification_s_order">
<?php if ($specification->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $specification_grid->RowIndex ?>_s_order" id="x<?php echo $specification_grid->RowIndex ?>_s_order" size="30" value="<?php echo $specification->s_order->EditValue ?>"<?php echo $specification->s_order->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_s_order" id="o<?php echo $specification_grid->RowIndex ?>_s_order" value="<?php echo ew_HtmlEncode($specification->s_order->OldValue) ?>">
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $specification_grid->RowIndex ?>_s_order" id="x<?php echo $specification_grid->RowIndex ?>_s_order" size="30" value="<?php echo $specification->s_order->EditValue ?>"<?php echo $specification->s_order->EditAttributes() ?>>
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $specification->s_order->ViewAttributes() ?>>
<?php echo $specification->s_order->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $specification_grid->RowIndex ?>_s_order" id="x<?php echo $specification_grid->RowIndex ?>_s_order" value="<?php echo ew_HtmlEncode($specification->s_order->FormValue) ?>">
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_s_order" id="o<?php echo $specification_grid->RowIndex ?>_s_order" value="<?php echo ew_HtmlEncode($specification->s_order->OldValue) ?>">
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($specification->status->Visible) { // status ?>
		<td<?php echo $specification->status->CellAttributes() ?>><span id="el<?php echo $specification_grid->RowCnt ?>_specification_status" class="specification_status">
<?php if ($specification->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $specification_grid->RowIndex ?>_status" name="x<?php echo $specification_grid->RowIndex ?>_status"<?php echo $specification->status->EditAttributes() ?>>
<?php
if (is_array($specification->status->EditValue)) {
	$arwrk = $specification->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($specification->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $specification->status->OldValue = "";
?>
</select>
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_status" id="o<?php echo $specification_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($specification->status->OldValue) ?>">
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $specification_grid->RowIndex ?>_status" name="x<?php echo $specification_grid->RowIndex ?>_status"<?php echo $specification->status->EditAttributes() ?>>
<?php
if (is_array($specification->status->EditValue)) {
	$arwrk = $specification->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($specification->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $specification->status->OldValue = "";
?>
</select>
<?php } ?>
<?php if ($specification->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $specification->status->ViewAttributes() ?>>
<?php echo $specification->status->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $specification_grid->RowIndex ?>_status" id="x<?php echo $specification_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($specification->status->FormValue) ?>">
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_status" id="o<?php echo $specification_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($specification->status->OldValue) ?>">
<?php } ?>
</span></td>
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
		$specification_grid->LoadDefaultValues();

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
		<td><span id="el$rowindex$_specification_spec_id" class="specification_spec_id">
<?php if ($specification->CurrentAction <> "F") { ?>
<?php } else { ?>
<span<?php echo $specification->spec_id->ViewAttributes() ?>>
<?php echo $specification->spec_id->ViewValue ?></span>
<input type="hidden" name="x<?php echo $specification_grid->RowIndex ?>_spec_id" id="x<?php echo $specification_grid->RowIndex ?>_spec_id" value="<?php echo ew_HtmlEncode($specification->spec_id->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_spec_id" id="o<?php echo $specification_grid->RowIndex ?>_spec_id" value="<?php echo ew_HtmlEncode($specification->spec_id->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($specification->model_id->Visible) { // model_id ?>
		<td><span id="el$rowindex$_specification_model_id" class="specification_model_id">
<?php if ($specification->CurrentAction <> "F") { ?>
<?php if ($specification->model_id->getSessionValue() <> "") { ?>
<span<?php echo $specification->model_id->ViewAttributes() ?>>
<?php echo $specification->model_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $specification_grid->RowIndex ?>_model_id" name="x<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $specification_grid->RowIndex ?>_model_id" name="x<?php echo $specification_grid->RowIndex ?>_model_id"<?php echo $specification->model_id->EditAttributes() ?>>
<?php
if (is_array($specification->model_id->EditValue)) {
	$arwrk = $specification->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($specification->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $specification->model_id->OldValue = "";
?>
</select>
<script type="text/javascript">
fspecificationgrid.Lists["x_model_id"].Options = <?php echo (is_array($specification->model_id->EditValue)) ? ew_ArrayToJson($specification->model_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php } else { ?>
<span<?php echo $specification->model_id->ViewAttributes() ?>>
<?php echo $specification->model_id->ViewValue ?></span>
<input type="hidden" name="x<?php echo $specification_grid->RowIndex ?>_model_id" id="x<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_model_id" id="o<?php echo $specification_grid->RowIndex ?>_model_id" value="<?php echo ew_HtmlEncode($specification->model_id->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($specification->title->Visible) { // title ?>
		<td><span id="el$rowindex$_specification_title" class="specification_title">
<?php if ($specification->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $specification_grid->RowIndex ?>_title" id="x<?php echo $specification_grid->RowIndex ?>_title" size="30" maxlength="150" value="<?php echo $specification->title->EditValue ?>"<?php echo $specification->title->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $specification->title->ViewAttributes() ?>>
<?php echo $specification->title->ViewValue ?></span>
<input type="hidden" name="x<?php echo $specification_grid->RowIndex ?>_title" id="x<?php echo $specification_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($specification->title->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_title" id="o<?php echo $specification_grid->RowIndex ?>_title" value="<?php echo ew_HtmlEncode($specification->title->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($specification->s_order->Visible) { // s_order ?>
		<td><span id="el$rowindex$_specification_s_order" class="specification_s_order">
<?php if ($specification->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $specification_grid->RowIndex ?>_s_order" id="x<?php echo $specification_grid->RowIndex ?>_s_order" size="30" value="<?php echo $specification->s_order->EditValue ?>"<?php echo $specification->s_order->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $specification->s_order->ViewAttributes() ?>>
<?php echo $specification->s_order->ViewValue ?></span>
<input type="hidden" name="x<?php echo $specification_grid->RowIndex ?>_s_order" id="x<?php echo $specification_grid->RowIndex ?>_s_order" value="<?php echo ew_HtmlEncode($specification->s_order->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_s_order" id="o<?php echo $specification_grid->RowIndex ?>_s_order" value="<?php echo ew_HtmlEncode($specification->s_order->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($specification->status->Visible) { // status ?>
		<td><span id="el$rowindex$_specification_status" class="specification_status">
<?php if ($specification->CurrentAction <> "F") { ?>
<select id="x<?php echo $specification_grid->RowIndex ?>_status" name="x<?php echo $specification_grid->RowIndex ?>_status"<?php echo $specification->status->EditAttributes() ?>>
<?php
if (is_array($specification->status->EditValue)) {
	$arwrk = $specification->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($specification->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $specification->status->OldValue = "";
?>
</select>
<?php } else { ?>
<span<?php echo $specification->status->ViewAttributes() ?>>
<?php echo $specification->status->ViewValue ?></span>
<input type="hidden" name="x<?php echo $specification_grid->RowIndex ?>_status" id="x<?php echo $specification_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($specification->status->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $specification_grid->RowIndex ?>_status" id="o<?php echo $specification_grid->RowIndex ?>_status" value="<?php echo ew_HtmlEncode($specification->status->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$specification_grid->ListOptions->Render("body", "right", $specification_grid->RowCnt);
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
<input type="hidden" name="key_count" id="key_count" value="<?php echo $specification_grid->KeyCount ?>">
<?php echo $specification_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($specification->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $specification_grid->KeyCount ?>">
<?php echo $specification_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($specification->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="fspecificationgrid">
</div>
<?php

// Close recordset
if ($specification_grid->Recordset)
	$specification_grid->Recordset->Close();
?>
</div>
</td></tr></table>
<?php if ($specification->Export == "") { ?>
<script type="text/javascript">
fspecificationgrid.Init();
</script>
<?php } ?>
<?php
$specification_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$specification_grid->Page_Terminate();
$Page = &$MasterPage;
?>
