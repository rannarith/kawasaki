<?php include_once "admin_userinfo.php" ?>
<?php

// Create page object
if (!isset($news_gallery_grid)) $news_gallery_grid = new cnews_gallery_grid();

// Page init
$news_gallery_grid->Page_Init();

// Page main
$news_gallery_grid->Page_Main();
?>
<?php if ($news_gallery->Export == "") { ?>
<script type="text/javascript">

// Page object
var news_gallery_grid = new ew_Page("news_gallery_grid");
news_gallery_grid.PageID = "grid"; // Page ID
var EW_PAGE_ID = news_gallery_grid.PageID; // For backward compatibility

// Form object
var fnews_gallerygrid = new ew_Form("fnews_gallerygrid");

// Validate form
fnews_gallerygrid.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_news_id"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($news_gallery->news_id->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_image"];
		aelm = fobj.elements["a" + infix + "_image"];
		var chk_image = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_image && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($news_gallery->image->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_image"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_g_status"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($news_gallery->g_status->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_g_order"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($news_gallery->g_order->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_g_order"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($news_gallery->g_order->FldErrMsg()) ?>");

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
fnews_gallerygrid.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "news_id", false)) return false;
	if (ew_ValueChanged(fobj, infix, "image", false)) return false;
	if (ew_ValueChanged(fobj, infix, "g_status", false)) return false;
	if (ew_ValueChanged(fobj, infix, "g_order", false)) return false;
	return true;
}

// Form_CustomValidate event
fnews_gallerygrid.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fnews_gallerygrid.ValidateRequired = true;
<?php } else { ?>
fnews_gallerygrid.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fnews_gallerygrid.Lists["x_news_id"] = {"LinkField":"x_news_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<?php } ?>
<?php
if ($news_gallery->CurrentAction == "gridadd") {
	if ($news_gallery->CurrentMode == "copy") {
		$bSelectLimit = EW_SELECT_LIMIT;
		if ($bSelectLimit) {
			$news_gallery_grid->TotalRecs = $news_gallery->SelectRecordCount();
			$news_gallery_grid->Recordset = $news_gallery_grid->LoadRecordset($news_gallery_grid->StartRec-1, $news_gallery_grid->DisplayRecs);
		} else {
			if ($news_gallery_grid->Recordset = $news_gallery_grid->LoadRecordset())
				$news_gallery_grid->TotalRecs = $news_gallery_grid->Recordset->RecordCount();
		}
		$news_gallery_grid->StartRec = 1;
		$news_gallery_grid->DisplayRecs = $news_gallery_grid->TotalRecs;
	} else {
		$news_gallery->CurrentFilter = "0=1";
		$news_gallery_grid->StartRec = 1;
		$news_gallery_grid->DisplayRecs = $news_gallery->GridAddRowCount;
	}
	$news_gallery_grid->TotalRecs = $news_gallery_grid->DisplayRecs;
	$news_gallery_grid->StopRec = $news_gallery_grid->DisplayRecs;
} else {
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$news_gallery_grid->TotalRecs = $news_gallery->SelectRecordCount();
	} else {
		if ($news_gallery_grid->Recordset = $news_gallery_grid->LoadRecordset())
			$news_gallery_grid->TotalRecs = $news_gallery_grid->Recordset->RecordCount();
	}
	$news_gallery_grid->StartRec = 1;
	$news_gallery_grid->DisplayRecs = $news_gallery_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$news_gallery_grid->Recordset = $news_gallery_grid->LoadRecordset($news_gallery_grid->StartRec-1, $news_gallery_grid->DisplayRecs);
}
?>
<p style="white-space: nowrap;"><span class="ewTitle ewTableTitle"><?php if ($news_gallery->CurrentMode == "add" || $news_gallery->CurrentMode == "copy") { ?><?php echo $Language->Phrase("Add") ?><?php } elseif ($news_gallery->CurrentMode == "edit") { ?><?php echo $Language->Phrase("Edit") ?><?php } ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $news_gallery->TableCaption() ?></span></p>
</p>
<?php $news_gallery_grid->ShowPageHeader(); ?>
<?php
$news_gallery_grid->ShowMessage();
?>
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div id="fnews_gallerygrid" class="ewForm">
<?php if (($news_gallery->CurrentMode == "add" || $news_gallery->CurrentMode == "copy" || $news_gallery->CurrentMode == "edit") && $news_gallery->CurrentAction != "F") { // add/copy/edit mode ?>
<div class="ewGridUpperPanel">
<?php if ($news_gallery->AllowAddDeleteRow) { ?>
<?php if ($Security->IsLoggedIn()) { ?>
<span class="phpmaker">
<a href="javascript:void(0);" onclick="ew_AddGridRow(this);"><img src='phpimages/addblankrow.gif' alt='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' title='<?php echo ew_HtmlEncode($Language->Phrase("AddBlankRow")) ?>' width='16' height='16' border='0'></a>&nbsp;&nbsp;
</span>
<?php } ?>
<?php } ?>
</div>
<?php } ?>
<div id="gmp_news_gallery" class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_news_gallerygrid" class="ewTable ewTableSeparate">
<?php echo $news_gallery->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$news_gallery_grid->RenderListOptions();

// Render list options (header, left)
$news_gallery_grid->ListOptions->Render("header", "left");
?>
<?php if ($news_gallery->ng_id->Visible) { // ng_id ?>
	<?php if ($news_gallery->SortUrl($news_gallery->ng_id) == "") { ?>
		<td><span id="elh_news_gallery_ng_id" class="news_gallery_ng_id"><?php echo $news_gallery->ng_id->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_news_gallery_ng_id" class="news_gallery_ng_id">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $news_gallery->ng_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($news_gallery->ng_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($news_gallery->ng_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($news_gallery->news_id->Visible) { // news_id ?>
	<?php if ($news_gallery->SortUrl($news_gallery->news_id) == "") { ?>
		<td><span id="elh_news_gallery_news_id" class="news_gallery_news_id"><?php echo $news_gallery->news_id->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_news_gallery_news_id" class="news_gallery_news_id">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $news_gallery->news_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($news_gallery->news_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($news_gallery->news_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($news_gallery->image->Visible) { // image ?>
	<?php if ($news_gallery->SortUrl($news_gallery->image) == "") { ?>
		<td><span id="elh_news_gallery_image" class="news_gallery_image"><?php echo $news_gallery->image->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_news_gallery_image" class="news_gallery_image">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $news_gallery->image->FldCaption() ?></td><td style="width: 10px;"><?php if ($news_gallery->image->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($news_gallery->image->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($news_gallery->g_status->Visible) { // g_status ?>
	<?php if ($news_gallery->SortUrl($news_gallery->g_status) == "") { ?>
		<td><span id="elh_news_gallery_g_status" class="news_gallery_g_status"><?php echo $news_gallery->g_status->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_news_gallery_g_status" class="news_gallery_g_status">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $news_gallery->g_status->FldCaption() ?></td><td style="width: 10px;"><?php if ($news_gallery->g_status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($news_gallery->g_status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($news_gallery->g_order->Visible) { // g_order ?>
	<?php if ($news_gallery->SortUrl($news_gallery->g_order) == "") { ?>
		<td><span id="elh_news_gallery_g_order" class="news_gallery_g_order"><?php echo $news_gallery->g_order->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div><span id="elh_news_gallery_g_order" class="news_gallery_g_order">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $news_gallery->g_order->FldCaption() ?></td><td style="width: 10px;"><?php if ($news_gallery->g_order->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($news_gallery->g_order->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$news_gallery_grid->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
$news_gallery_grid->StartRec = 1;
$news_gallery_grid->StopRec = $news_gallery_grid->TotalRecs; // Show all records

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue("key_count") && ($news_gallery->CurrentAction == "gridadd" || $news_gallery->CurrentAction == "gridedit" || $news_gallery->CurrentAction == "F")) {
		$news_gallery_grid->KeyCount = $objForm->GetValue("key_count");
		$news_gallery_grid->StopRec = $news_gallery_grid->KeyCount;
	}
}
$news_gallery_grid->RecCnt = $news_gallery_grid->StartRec - 1;
if ($news_gallery_grid->Recordset && !$news_gallery_grid->Recordset->EOF) {
	$news_gallery_grid->Recordset->MoveFirst();
	if (!$bSelectLimit && $news_gallery_grid->StartRec > 1)
		$news_gallery_grid->Recordset->Move($news_gallery_grid->StartRec - 1);
} elseif (!$news_gallery->AllowAddDeleteRow && $news_gallery_grid->StopRec == 0) {
	$news_gallery_grid->StopRec = $news_gallery->GridAddRowCount;
}

// Initialize aggregate
$news_gallery->RowType = EW_ROWTYPE_AGGREGATEINIT;
$news_gallery->ResetAttrs();
$news_gallery_grid->RenderRow();
if ($news_gallery->CurrentAction == "gridadd")
	$news_gallery_grid->RowIndex = 0;
if ($news_gallery->CurrentAction == "gridedit")
	$news_gallery_grid->RowIndex = 0;
while ($news_gallery_grid->RecCnt < $news_gallery_grid->StopRec) {
	$news_gallery_grid->RecCnt++;
	if (intval($news_gallery_grid->RecCnt) >= intval($news_gallery_grid->StartRec)) {
		$news_gallery_grid->RowCnt++;
		if ($news_gallery->CurrentAction == "gridadd" || $news_gallery->CurrentAction == "gridedit" || $news_gallery->CurrentAction == "F") {
			$news_gallery_grid->RowIndex++;
			$objForm->Index = $news_gallery_grid->RowIndex;
			if ($objForm->HasValue("k_action"))
				$news_gallery_grid->RowAction = strval($objForm->GetValue("k_action"));
			elseif ($news_gallery->CurrentAction == "gridadd")
				$news_gallery_grid->RowAction = "insert";
			else
				$news_gallery_grid->RowAction = "";
		}

		// Set up key count
		$news_gallery_grid->KeyCount = $news_gallery_grid->RowIndex;

		// Init row class and style
		$news_gallery->ResetAttrs();
		$news_gallery->CssClass = "";
		if ($news_gallery->CurrentAction == "gridadd") {
			if ($news_gallery->CurrentMode == "copy") {
				$news_gallery_grid->LoadRowValues($news_gallery_grid->Recordset); // Load row values
				$news_gallery_grid->SetRecordKey($news_gallery_grid->RowOldKey, $news_gallery_grid->Recordset); // Set old record key
			} else {
				$news_gallery_grid->LoadDefaultValues(); // Load default values
				$news_gallery_grid->RowOldKey = ""; // Clear old key value
			}
		} elseif ($news_gallery->CurrentAction == "gridedit") {
			$news_gallery_grid->LoadRowValues($news_gallery_grid->Recordset); // Load row values
		}
		$news_gallery->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($news_gallery->CurrentAction == "gridadd") // Grid add
			$news_gallery->RowType = EW_ROWTYPE_ADD; // Render add
		if ($news_gallery->CurrentAction == "gridadd" && $news_gallery->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$news_gallery_grid->RestoreCurrentRowFormValues($news_gallery_grid->RowIndex); // Restore form values
		if ($news_gallery->CurrentAction == "gridedit") { // Grid edit
			if ($news_gallery->EventCancelled) {
				$news_gallery_grid->RestoreCurrentRowFormValues($news_gallery_grid->RowIndex); // Restore form values
			}
			if ($news_gallery_grid->RowAction == "insert")
				$news_gallery->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$news_gallery->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($news_gallery->CurrentAction == "gridedit" && ($news_gallery->RowType == EW_ROWTYPE_EDIT || $news_gallery->RowType == EW_ROWTYPE_ADD) && $news_gallery->EventCancelled) // Update failed
			$news_gallery_grid->RestoreCurrentRowFormValues($news_gallery_grid->RowIndex); // Restore form values
		if ($news_gallery->RowType == EW_ROWTYPE_EDIT) // Edit row
			$news_gallery_grid->EditRowCnt++;
		if ($news_gallery->CurrentAction == "F") // Confirm row
			$news_gallery_grid->RestoreCurrentRowFormValues($news_gallery_grid->RowIndex); // Restore form values

		// Set up row id / data-rowindex
		$news_gallery->RowAttrs = array_merge($news_gallery->RowAttrs, array('data-rowindex'=>$news_gallery_grid->RowCnt, 'id'=>'r' . $news_gallery_grid->RowCnt . '_news_gallery', 'data-rowtype'=>$news_gallery->RowType));

		// Render row
		$news_gallery_grid->RenderRow();

		// Render list options
		$news_gallery_grid->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($news_gallery_grid->RowAction <> "delete" && $news_gallery_grid->RowAction <> "insertdelete" && !($news_gallery_grid->RowAction == "insert" && $news_gallery->CurrentAction == "F" && $news_gallery_grid->EmptyRow())) {
?>
	<tr<?php echo $news_gallery->RowAttributes() ?>>
<?php

// Render list options (body, left)
$news_gallery_grid->ListOptions->Render("body", "left", $news_gallery_grid->RowCnt);
?>
	<?php if ($news_gallery->ng_id->Visible) { // ng_id ?>
		<td<?php echo $news_gallery->ng_id->CellAttributes() ?>><span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_ng_id" class="news_gallery_ng_id">
<?php if ($news_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" name="o<?php echo $news_gallery_grid->RowIndex ?>_ng_id" id="o<?php echo $news_gallery_grid->RowIndex ?>_ng_id" value="<?php echo ew_HtmlEncode($news_gallery->ng_id->OldValue) ?>">
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span<?php echo $news_gallery->ng_id->ViewAttributes() ?>>
<?php echo $news_gallery->ng_id->EditValue ?></span>
<input type="hidden" name="x<?php echo $news_gallery_grid->RowIndex ?>_ng_id" id="x<?php echo $news_gallery_grid->RowIndex ?>_ng_id" value="<?php echo ew_HtmlEncode($news_gallery->ng_id->CurrentValue) ?>">
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $news_gallery->ng_id->ViewAttributes() ?>>
<?php echo $news_gallery->ng_id->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $news_gallery_grid->RowIndex ?>_ng_id" id="x<?php echo $news_gallery_grid->RowIndex ?>_ng_id" value="<?php echo ew_HtmlEncode($news_gallery->ng_id->FormValue) ?>">
<input type="hidden" name="o<?php echo $news_gallery_grid->RowIndex ?>_ng_id" id="o<?php echo $news_gallery_grid->RowIndex ?>_ng_id" value="<?php echo ew_HtmlEncode($news_gallery->ng_id->OldValue) ?>">
<?php } ?>
<a name="<?php echo $news_gallery_grid->PageObjName . "_row_" . $news_gallery_grid->RowCnt ?>" id="<?php echo $news_gallery_grid->PageObjName . "_row_" . $news_gallery_grid->RowCnt ?>"></a></span></td>
	<?php } ?>
	<?php if ($news_gallery->news_id->Visible) { // news_id ?>
		<td<?php echo $news_gallery->news_id->CellAttributes() ?>><span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_news_id" class="news_gallery_news_id">
<?php if ($news_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($news_gallery->news_id->getSessionValue() <> "") { ?>
<span<?php echo $news_gallery->news_id->ViewAttributes() ?>>
<?php echo $news_gallery->news_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id"<?php echo $news_gallery->news_id->EditAttributes() ?>>
<?php
if (is_array($news_gallery->news_id->EditValue)) {
	$arwrk = $news_gallery->news_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($news_gallery->news_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $news_gallery->news_id->OldValue = "";
?>
</select>
<script type="text/javascript">
fnews_gallerygrid.Lists["x_news_id"].Options = <?php echo (is_array($news_gallery->news_id->EditValue)) ? ew_ArrayToJson($news_gallery->news_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<input type="hidden" name="o<?php echo $news_gallery_grid->RowIndex ?>_news_id" id="o<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->OldValue) ?>">
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($news_gallery->news_id->getSessionValue() <> "") { ?>
<span<?php echo $news_gallery->news_id->ViewAttributes() ?>>
<?php echo $news_gallery->news_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id"<?php echo $news_gallery->news_id->EditAttributes() ?>>
<?php
if (is_array($news_gallery->news_id->EditValue)) {
	$arwrk = $news_gallery->news_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($news_gallery->news_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $news_gallery->news_id->OldValue = "";
?>
</select>
<script type="text/javascript">
fnews_gallerygrid.Lists["x_news_id"].Options = <?php echo (is_array($news_gallery->news_id->EditValue)) ? ew_ArrayToJson($news_gallery->news_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $news_gallery->news_id->ViewAttributes() ?>>
<?php echo $news_gallery->news_id->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->FormValue) ?>">
<input type="hidden" name="o<?php echo $news_gallery_grid->RowIndex ?>_news_id" id="o<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->OldValue) ?>">
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($news_gallery->image->Visible) { // image ?>
		<td<?php echo $news_gallery->image->CellAttributes() ?>><span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_image" class="news_gallery_image">
<?php if ($news_gallery_grid->RowAction == "insert") { // Add record ?>
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<div id="old_x<?php echo $news_gallery_grid->RowIndex ?>_image">
<?php if ($news_gallery->image->LinkAttributes() <> "") { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $news_gallery->image->UploadPath) . $news_gallery->image->Upload->DbValue ?>" border="0"<?php echo $news_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($news_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $news_gallery->image->UploadPath) . $news_gallery->image->Upload->DbValue ?>" border="0"<?php echo $news_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($news_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x<?php echo $news_gallery_grid->RowIndex ?>_image">
<?php if ($news_gallery->image->ReadOnly) { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<input type="hidden" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<label><input type="radio" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $news_gallery->image->EditAttrs["onchange"] = "this.form.a" . $news_gallery_grid->RowIndex . "_image[2].checked=true;" . @$news_gallery->image->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="3">
<?php } ?>
<input type="file" name="x<?php echo $news_gallery_grid->RowIndex ?>_image" id="x<?php echo $news_gallery_grid->RowIndex ?>_image" size="30"<?php echo $news_gallery->image->EditAttributes() ?>>
<?php } ?>
</div>
<?php } else { ?>
<input type="hidden" name="a_image" id="a_image" value="<?php echo $news_gallery->image->Upload->Action ?>">
<?php
if ($news_gallery->image->Upload->Action == "1") {
	if (!ew_Empty($news_gallery->image->Upload->DbValue)) {
?>
<img src="ewbv9.php?tbl=<?php echo $news_gallery->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $news_gallery_grid->RowIndex ?>&db=1&file=1&path=<?php echo urlencode($news_gallery->image->UploadPath) ?>" alt="" border="0">
<?php
	}
} elseif ($news_gallery->image->Upload->Action == "2") {
} else {
	if (!ew_Empty($news_gallery->image->Upload->Value)) {
?>
<img src="ewbv9.php?tbl=<?php echo $news_gallery->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $news_gallery_grid->RowIndex ?>" alt="" border="0" width=250>
<?php
	}
}
?>
<?php } ?>
<input type="hidden" name="o<?php echo $news_gallery_grid->RowIndex ?>_image" id="o<?php echo $news_gallery_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($news_gallery->image->OldValue) ?>">
<?php } else { // Edit record ?>
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<div id="old_x<?php echo $news_gallery_grid->RowIndex ?>_image">
<?php if ($news_gallery->image->LinkAttributes() <> "") { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $news_gallery->image->UploadPath) . $news_gallery->image->Upload->DbValue ?>" border="0"<?php echo $news_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($news_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $news_gallery->image->UploadPath) . $news_gallery->image->Upload->DbValue ?>" border="0"<?php echo $news_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($news_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x<?php echo $news_gallery_grid->RowIndex ?>_image">
<?php if ($news_gallery->image->ReadOnly) { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<input type="hidden" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<label><input type="radio" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $news_gallery->image->EditAttrs["onchange"] = "this.form.a" . $news_gallery_grid->RowIndex . "_image[2].checked=true;" . @$news_gallery->image->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="3">
<?php } ?>
<input type="file" name="x<?php echo $news_gallery_grid->RowIndex ?>_image" id="x<?php echo $news_gallery_grid->RowIndex ?>_image" size="30"<?php echo $news_gallery->image->EditAttributes() ?>>
<?php } ?>
</div>
<?php } else { ?>
<div id="old_x<?php echo $news_gallery_grid->RowIndex ?>_image">
<?php if ($news_gallery->image->LinkAttributes() <> "") { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $news_gallery->image->UploadPath) . $news_gallery->image->Upload->DbValue ?>" border="0"<?php echo $news_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($news_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $news_gallery->image->UploadPath) . $news_gallery->image->Upload->DbValue ?>" border="0"<?php echo $news_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($news_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
<?php if (!ew_Empty($news_gallery->image->Upload->DbValue) && $news_gallery->image->Upload->Action == "3") echo "[" . $Language->Phrase("Old") . "]"; ?>
</div>
<div id="new_x<?php echo $news_gallery_grid->RowIndex ?>_image">
<input type="hidden" name="a_image" id="a_image" value="<?php echo $news_gallery->image->Upload->Action ?>">
<?php
if ($news_gallery->image->Upload->Action == "1") {
	echo "[" . $Language->Phrase("Keep") . "]";
} elseif ($news_gallery->image->Upload->Action == "2") {
	echo "[" . $Language->Phrase("Remove") . "]";
} else {
	if (!ew_Empty($news_gallery->image->Upload->Value)) {
?>
<img src="ewbv9.php?tbl=<?php echo $news_gallery->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $news_gallery_grid->RowIndex ?>" alt="" border="0" width=250>
<?php
	}
}
?>
<?php if (!ew_Empty($news_gallery->image->Upload->DbValue) && $news_gallery->image->Upload->Action == "3") echo "[" . $Language->Phrase("New") . "]"; ?>
</div>
<?php } ?>
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($news_gallery->g_status->Visible) { // g_status ?>
		<td<?php echo $news_gallery->g_status->CellAttributes() ?>><span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_g_status" class="news_gallery_g_status">
<?php if ($news_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<select id="x<?php echo $news_gallery_grid->RowIndex ?>_g_status" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_status"<?php echo $news_gallery->g_status->EditAttributes() ?>>
<?php
if (is_array($news_gallery->g_status->EditValue)) {
	$arwrk = $news_gallery->g_status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($news_gallery->g_status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $news_gallery->g_status->OldValue = "";
?>
</select>
<input type="hidden" name="o<?php echo $news_gallery_grid->RowIndex ?>_g_status" id="o<?php echo $news_gallery_grid->RowIndex ?>_g_status" value="<?php echo ew_HtmlEncode($news_gallery->g_status->OldValue) ?>">
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<select id="x<?php echo $news_gallery_grid->RowIndex ?>_g_status" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_status"<?php echo $news_gallery->g_status->EditAttributes() ?>>
<?php
if (is_array($news_gallery->g_status->EditValue)) {
	$arwrk = $news_gallery->g_status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($news_gallery->g_status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $news_gallery->g_status->OldValue = "";
?>
</select>
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $news_gallery->g_status->ViewAttributes() ?>>
<?php echo $news_gallery->g_status->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_status" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_status" value="<?php echo ew_HtmlEncode($news_gallery->g_status->FormValue) ?>">
<input type="hidden" name="o<?php echo $news_gallery_grid->RowIndex ?>_g_status" id="o<?php echo $news_gallery_grid->RowIndex ?>_g_status" value="<?php echo ew_HtmlEncode($news_gallery->g_status->OldValue) ?>">
<?php } ?>
</span></td>
	<?php } ?>
	<?php if ($news_gallery->g_order->Visible) { // g_order ?>
		<td<?php echo $news_gallery->g_order->CellAttributes() ?>><span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_g_order" class="news_gallery_g_order">
<?php if ($news_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="text" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" size="30" value="<?php echo $news_gallery->g_order->EditValue ?>"<?php echo $news_gallery->g_order->EditAttributes() ?>>
<input type="hidden" name="o<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="o<?php echo $news_gallery_grid->RowIndex ?>_g_order" value="<?php echo ew_HtmlEncode($news_gallery->g_order->OldValue) ?>">
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<input type="text" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" size="30" value="<?php echo $news_gallery->g_order->EditValue ?>"<?php echo $news_gallery->g_order->EditAttributes() ?>>
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span<?php echo $news_gallery->g_order->ViewAttributes() ?>>
<?php echo $news_gallery->g_order->ListViewValue() ?></span>
<input type="hidden" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" value="<?php echo ew_HtmlEncode($news_gallery->g_order->FormValue) ?>">
<input type="hidden" name="o<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="o<?php echo $news_gallery_grid->RowIndex ?>_g_order" value="<?php echo ew_HtmlEncode($news_gallery->g_order->OldValue) ?>">
<?php } ?>
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$news_gallery_grid->ListOptions->Render("body", "right", $news_gallery_grid->RowCnt);
?>
	</tr>
<?php if ($news_gallery->RowType == EW_ROWTYPE_ADD || $news_gallery->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fnews_gallerygrid.UpdateOpts(<?php echo $news_gallery_grid->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($news_gallery->CurrentAction <> "gridadd" || $news_gallery->CurrentMode == "copy")
		if (!$news_gallery_grid->Recordset->EOF) $news_gallery_grid->Recordset->MoveNext();
}
?>
<?php
	if ($news_gallery->CurrentMode == "add" || $news_gallery->CurrentMode == "copy" || $news_gallery->CurrentMode == "edit") {
		$news_gallery_grid->RowIndex = '$rowindex$';
		$news_gallery_grid->LoadDefaultValues();

		// Set row properties
		$news_gallery->ResetAttrs();
		$news_gallery->RowAttrs = array_merge($news_gallery->RowAttrs, array('data-rowindex'=>$news_gallery_grid->RowIndex, 'id'=>'r0_news_gallery', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($news_gallery->RowAttrs["class"], "ewTemplate");
		$news_gallery->RowType = EW_ROWTYPE_ADD;

		// Render row
		$news_gallery_grid->RenderRow();

		// Render list options
		$news_gallery_grid->RenderListOptions();
		$news_gallery_grid->StartRowCnt = 0;
?>
	<tr<?php echo $news_gallery->RowAttributes() ?>>
<?php

// Render list options (body, left)
$news_gallery_grid->ListOptions->Render("body", "left", $news_gallery_grid->RowIndex);
?>
	<?php if ($news_gallery->ng_id->Visible) { // ng_id ?>
		<td><span id="el$rowindex$_news_gallery_ng_id" class="news_gallery_ng_id">
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<?php } else { ?>
<span<?php echo $news_gallery->ng_id->ViewAttributes() ?>>
<?php echo $news_gallery->ng_id->ViewValue ?></span>
<input type="hidden" name="x<?php echo $news_gallery_grid->RowIndex ?>_ng_id" id="x<?php echo $news_gallery_grid->RowIndex ?>_ng_id" value="<?php echo ew_HtmlEncode($news_gallery->ng_id->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $news_gallery_grid->RowIndex ?>_ng_id" id="o<?php echo $news_gallery_grid->RowIndex ?>_ng_id" value="<?php echo ew_HtmlEncode($news_gallery->ng_id->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($news_gallery->news_id->Visible) { // news_id ?>
		<td><span id="el$rowindex$_news_gallery_news_id" class="news_gallery_news_id">
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<?php if ($news_gallery->news_id->getSessionValue() <> "") { ?>
<span<?php echo $news_gallery->news_id->ViewAttributes() ?>>
<?php echo $news_gallery->news_id->ListViewValue() ?></span>
<input type="hidden" id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id"<?php echo $news_gallery->news_id->EditAttributes() ?>>
<?php
if (is_array($news_gallery->news_id->EditValue)) {
	$arwrk = $news_gallery->news_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($news_gallery->news_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $news_gallery->news_id->OldValue = "";
?>
</select>
<script type="text/javascript">
fnews_gallerygrid.Lists["x_news_id"].Options = <?php echo (is_array($news_gallery->news_id->EditValue)) ? ew_ArrayToJson($news_gallery->news_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
<?php } else { ?>
<span<?php echo $news_gallery->news_id->ViewAttributes() ?>>
<?php echo $news_gallery->news_id->ViewValue ?></span>
<input type="hidden" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $news_gallery_grid->RowIndex ?>_news_id" id="o<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($news_gallery->image->Visible) { // image ?>
		<td><span id="el$rowindex$_news_gallery_image" class="news_gallery_image">
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<div id="old_x<?php echo $news_gallery_grid->RowIndex ?>_image">
<?php if ($news_gallery->image->LinkAttributes() <> "") { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $news_gallery->image->UploadPath) . $news_gallery->image->Upload->DbValue ?>" border="0"<?php echo $news_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($news_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $news_gallery->image->UploadPath) . $news_gallery->image->Upload->DbValue ?>" border="0"<?php echo $news_gallery->image->ViewAttributes() ?>>
<?php } elseif (!in_array($news_gallery->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x<?php echo $news_gallery_grid->RowIndex ?>_image">
<?php if ($news_gallery->image->ReadOnly) { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<input type="hidden" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<label><input type="radio" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $news_gallery->image->EditAttrs["onchange"] = "this.form.a" . $news_gallery_grid->RowIndex . "_image[2].checked=true;" . @$news_gallery->image->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a<?php echo $news_gallery_grid->RowIndex ?>_image" id="a<?php echo $news_gallery_grid->RowIndex ?>_image" value="3">
<?php } ?>
<input type="file" name="x<?php echo $news_gallery_grid->RowIndex ?>_image" id="x<?php echo $news_gallery_grid->RowIndex ?>_image" size="30"<?php echo $news_gallery->image->EditAttributes() ?>>
<?php } ?>
</div>
<?php } else { ?>
<input type="hidden" name="a_image" id="a_image" value="<?php echo $news_gallery->image->Upload->Action ?>">
<?php
if ($news_gallery->image->Upload->Action == "1") {
	if (!ew_Empty($news_gallery->image->Upload->DbValue)) {
?>
<img src="ewbv9.php?tbl=<?php echo $news_gallery->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $news_gallery_grid->RowIndex ?>&db=1&file=1&path=<?php echo urlencode($news_gallery->image->UploadPath) ?>" alt="" border="0">
<?php
	}
} elseif ($news_gallery->image->Upload->Action == "2") {
} else {
	if (!ew_Empty($news_gallery->image->Upload->Value)) {
?>
<img src="ewbv9.php?tbl=<?php echo $news_gallery->TableVar ?>&fld=x_image&rnd=<?php echo ew_Random() ?>&idx=<?php echo $news_gallery_grid->RowIndex ?>" alt="" border="0" width=250>
<?php
	}
}
?>
<?php } ?>
<input type="hidden" name="o<?php echo $news_gallery_grid->RowIndex ?>_image" id="o<?php echo $news_gallery_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($news_gallery->image->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($news_gallery->g_status->Visible) { // g_status ?>
		<td><span id="el$rowindex$_news_gallery_g_status" class="news_gallery_g_status">
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<select id="x<?php echo $news_gallery_grid->RowIndex ?>_g_status" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_status"<?php echo $news_gallery->g_status->EditAttributes() ?>>
<?php
if (is_array($news_gallery->g_status->EditValue)) {
	$arwrk = $news_gallery->g_status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($news_gallery->g_status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
if (@$emptywrk) $news_gallery->g_status->OldValue = "";
?>
</select>
<?php } else { ?>
<span<?php echo $news_gallery->g_status->ViewAttributes() ?>>
<?php echo $news_gallery->g_status->ViewValue ?></span>
<input type="hidden" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_status" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_status" value="<?php echo ew_HtmlEncode($news_gallery->g_status->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $news_gallery_grid->RowIndex ?>_g_status" id="o<?php echo $news_gallery_grid->RowIndex ?>_g_status" value="<?php echo ew_HtmlEncode($news_gallery->g_status->OldValue) ?>">
</span></td>
	<?php } ?>
	<?php if ($news_gallery->g_order->Visible) { // g_order ?>
		<td><span id="el$rowindex$_news_gallery_g_order" class="news_gallery_g_order">
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<input type="text" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" size="30" value="<?php echo $news_gallery->g_order->EditValue ?>"<?php echo $news_gallery->g_order->EditAttributes() ?>>
<?php } else { ?>
<span<?php echo $news_gallery->g_order->ViewAttributes() ?>>
<?php echo $news_gallery->g_order->ViewValue ?></span>
<input type="hidden" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" value="<?php echo ew_HtmlEncode($news_gallery->g_order->FormValue) ?>">
<?php } ?>
<input type="hidden" name="o<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="o<?php echo $news_gallery_grid->RowIndex ?>_g_order" value="<?php echo ew_HtmlEncode($news_gallery->g_order->OldValue) ?>">
</span></td>
	<?php } ?>
<?php

// Render list options (body, right)
$news_gallery_grid->ListOptions->Render("body", "right", $news_gallery_grid->RowCnt);
?>
<script type="text/javascript">
fnews_gallerygrid.UpdateOpts(<?php echo $news_gallery_grid->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php if ($news_gallery->CurrentMode == "add" || $news_gallery->CurrentMode == "copy") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $news_gallery_grid->KeyCount ?>">
<?php echo $news_gallery_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($news_gallery->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="key_count" id="key_count" value="<?php echo $news_gallery_grid->KeyCount ?>">
<?php echo $news_gallery_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($news_gallery->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" id="detailpage" value="fnews_gallerygrid">
</div>
<?php

// Close recordset
if ($news_gallery_grid->Recordset)
	$news_gallery_grid->Recordset->Close();
?>
</div>
</td></tr></table>
<?php if ($news_gallery->Export == "") { ?>
<script type="text/javascript">
fnews_gallerygrid.Init();
</script>
<?php } ?>
<?php
$news_gallery_grid->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php
$news_gallery_grid->Page_Terminate();
$Page = &$MasterPage;
?>
