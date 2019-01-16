<?php include_once "admin_userinfo.php" ?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($news_gallery_grid)) $news_gallery_grid = new cnews_gallery_grid();

// Page init
$news_gallery_grid->Page_Init();

// Page main
$news_gallery_grid->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$news_gallery_grid->Page_Render();
?>
<?php if ($news_gallery->Export == "") { ?>
<script type="text/javascript">

// Form object
var fnews_gallerygrid = new ew_Form("fnews_gallerygrid", "grid");
fnews_gallerygrid.FormKeyCountName = '<?php echo $news_gallery_grid->FormKeyCountName ?>';

// Validate form
fnews_gallerygrid.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_news_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $news_gallery->news_id->FldCaption(), $news_gallery->news_id->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_image");
			elm = this.GetElements("fn_x" + infix + "_image");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $news_gallery->image->FldCaption(), $news_gallery->image->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_g_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $news_gallery->g_order->FldCaption(), $news_gallery->g_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_g_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($news_gallery->g_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_g_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $news_gallery->g_status->FldCaption(), $news_gallery->g_status->ReqErrMsg)) ?>");

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
	if (ew_ValueChanged(fobj, infix, "g_order", false)) return false;
	if (ew_ValueChanged(fobj, infix, "g_status", false)) return false;
	return true;
}

// Form_CustomValidate event
fnews_gallerygrid.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fnews_gallerygrid.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fnews_gallerygrid.Lists["x_news_id"] = {"LinkField":"x_news_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_title","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"news"};
fnews_gallerygrid.Lists["x_news_id"].Data = "<?php echo $news_gallery_grid->news_id->LookupFilterQuery(FALSE, "grid") ?>";
fnews_gallerygrid.Lists["x_g_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fnews_gallerygrid.Lists["x_g_status"].Options = <?php echo json_encode($news_gallery_grid->g_status->Options()) ?>;

// Form object for search
</script>
<?php } ?>
<?php
if ($news_gallery->CurrentAction == "gridadd") {
	if ($news_gallery->CurrentMode == "copy") {
		$bSelectLimit = $news_gallery_grid->UseSelectLimit;
		if ($bSelectLimit) {
			$news_gallery_grid->TotalRecs = $news_gallery->ListRecordCount();
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
	$bSelectLimit = $news_gallery_grid->UseSelectLimit;
	if ($bSelectLimit) {
		if ($news_gallery_grid->TotalRecs <= 0)
			$news_gallery_grid->TotalRecs = $news_gallery->ListRecordCount();
	} else {
		if (!$news_gallery_grid->Recordset && ($news_gallery_grid->Recordset = $news_gallery_grid->LoadRecordset()))
			$news_gallery_grid->TotalRecs = $news_gallery_grid->Recordset->RecordCount();
	}
	$news_gallery_grid->StartRec = 1;
	$news_gallery_grid->DisplayRecs = $news_gallery_grid->TotalRecs; // Display all records
	if ($bSelectLimit)
		$news_gallery_grid->Recordset = $news_gallery_grid->LoadRecordset($news_gallery_grid->StartRec-1, $news_gallery_grid->DisplayRecs);

	// Set no record found message
	if ($news_gallery->CurrentAction == "" && $news_gallery_grid->TotalRecs == 0) {
		if (!$Security->CanList())
			$news_gallery_grid->setWarningMessage(ew_DeniedMsg());
		if ($news_gallery_grid->SearchWhere == "0=101")
			$news_gallery_grid->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$news_gallery_grid->setWarningMessage($Language->Phrase("NoRecord"));
	}
}
$news_gallery_grid->RenderOtherOptions();
?>
<?php $news_gallery_grid->ShowPageHeader(); ?>
<?php
$news_gallery_grid->ShowMessage();
?>
<?php if ($news_gallery_grid->TotalRecs > 0 || $news_gallery->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($news_gallery_grid->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> news_gallery">
<div id="fnews_gallerygrid" class="ewForm ewListForm form-inline">
<?php if ($news_gallery_grid->ShowOtherOptions) { ?>
<div class="box-header ewGridUpperPanel">
<?php
	foreach ($news_gallery_grid->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<div id="gmp_news_gallery" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table id="tbl_news_gallerygrid" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$news_gallery_grid->RowType = EW_ROWTYPE_HEADER;

// Render list options
$news_gallery_grid->RenderListOptions();

// Render list options (header, left)
$news_gallery_grid->ListOptions->Render("header", "left");
?>
<?php if ($news_gallery->ng_id->Visible) { // ng_id ?>
	<?php if ($news_gallery->SortUrl($news_gallery->ng_id) == "") { ?>
		<th data-name="ng_id" class="<?php echo $news_gallery->ng_id->HeaderCellClass() ?>"><div id="elh_news_gallery_ng_id" class="news_gallery_ng_id"><div class="ewTableHeaderCaption"><?php echo $news_gallery->ng_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="ng_id" class="<?php echo $news_gallery->ng_id->HeaderCellClass() ?>"><div><div id="elh_news_gallery_ng_id" class="news_gallery_ng_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $news_gallery->ng_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($news_gallery->ng_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($news_gallery->ng_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($news_gallery->news_id->Visible) { // news_id ?>
	<?php if ($news_gallery->SortUrl($news_gallery->news_id) == "") { ?>
		<th data-name="news_id" class="<?php echo $news_gallery->news_id->HeaderCellClass() ?>"><div id="elh_news_gallery_news_id" class="news_gallery_news_id"><div class="ewTableHeaderCaption"><?php echo $news_gallery->news_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="news_id" class="<?php echo $news_gallery->news_id->HeaderCellClass() ?>"><div><div id="elh_news_gallery_news_id" class="news_gallery_news_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $news_gallery->news_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($news_gallery->news_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($news_gallery->news_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($news_gallery->image->Visible) { // image ?>
	<?php if ($news_gallery->SortUrl($news_gallery->image) == "") { ?>
		<th data-name="image" class="<?php echo $news_gallery->image->HeaderCellClass() ?>"><div id="elh_news_gallery_image" class="news_gallery_image"><div class="ewTableHeaderCaption"><?php echo $news_gallery->image->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="image" class="<?php echo $news_gallery->image->HeaderCellClass() ?>"><div><div id="elh_news_gallery_image" class="news_gallery_image">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $news_gallery->image->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($news_gallery->image->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($news_gallery->image->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($news_gallery->g_order->Visible) { // g_order ?>
	<?php if ($news_gallery->SortUrl($news_gallery->g_order) == "") { ?>
		<th data-name="g_order" class="<?php echo $news_gallery->g_order->HeaderCellClass() ?>"><div id="elh_news_gallery_g_order" class="news_gallery_g_order"><div class="ewTableHeaderCaption"><?php echo $news_gallery->g_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="g_order" class="<?php echo $news_gallery->g_order->HeaderCellClass() ?>"><div><div id="elh_news_gallery_g_order" class="news_gallery_g_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $news_gallery->g_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($news_gallery->g_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($news_gallery->g_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($news_gallery->g_status->Visible) { // g_status ?>
	<?php if ($news_gallery->SortUrl($news_gallery->g_status) == "") { ?>
		<th data-name="g_status" class="<?php echo $news_gallery->g_status->HeaderCellClass() ?>"><div id="elh_news_gallery_g_status" class="news_gallery_g_status"><div class="ewTableHeaderCaption"><?php echo $news_gallery->g_status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="g_status" class="<?php echo $news_gallery->g_status->HeaderCellClass() ?>"><div><div id="elh_news_gallery_g_status" class="news_gallery_g_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $news_gallery->g_status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($news_gallery->g_status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($news_gallery->g_status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
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
	if ($objForm->HasValue($news_gallery_grid->FormKeyCountName) && ($news_gallery->CurrentAction == "gridadd" || $news_gallery->CurrentAction == "gridedit" || $news_gallery->CurrentAction == "F")) {
		$news_gallery_grid->KeyCount = $objForm->GetValue($news_gallery_grid->FormKeyCountName);
		$news_gallery_grid->StopRec = $news_gallery_grid->StartRec + $news_gallery_grid->KeyCount - 1;
	}
}
$news_gallery_grid->RecCnt = $news_gallery_grid->StartRec - 1;
if ($news_gallery_grid->Recordset && !$news_gallery_grid->Recordset->EOF) {
	$news_gallery_grid->Recordset->MoveFirst();
	$bSelectLimit = $news_gallery_grid->UseSelectLimit;
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
			if ($objForm->HasValue($news_gallery_grid->FormActionName))
				$news_gallery_grid->RowAction = strval($objForm->GetValue($news_gallery_grid->FormActionName));
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
				$news_gallery_grid->LoadRowValues(); // Load default values
				$news_gallery_grid->RowOldKey = ""; // Clear old key value
			}
		} else {
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
		<td data-name="ng_id"<?php echo $news_gallery->ng_id->CellAttributes() ?>>
<?php if ($news_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="news_gallery" data-field="x_ng_id" name="o<?php echo $news_gallery_grid->RowIndex ?>_ng_id" id="o<?php echo $news_gallery_grid->RowIndex ?>_ng_id" value="<?php echo ew_HtmlEncode($news_gallery->ng_id->OldValue) ?>">
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_ng_id" class="form-group news_gallery_ng_id">
<span<?php echo $news_gallery->ng_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $news_gallery->ng_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="news_gallery" data-field="x_ng_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_ng_id" id="x<?php echo $news_gallery_grid->RowIndex ?>_ng_id" value="<?php echo ew_HtmlEncode($news_gallery->ng_id->CurrentValue) ?>">
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_ng_id" class="news_gallery_ng_id">
<span<?php echo $news_gallery->ng_id->ViewAttributes() ?>>
<?php echo $news_gallery->ng_id->ListViewValue() ?></span>
</span>
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<input type="hidden" data-table="news_gallery" data-field="x_ng_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_ng_id" id="x<?php echo $news_gallery_grid->RowIndex ?>_ng_id" value="<?php echo ew_HtmlEncode($news_gallery->ng_id->FormValue) ?>">
<input type="hidden" data-table="news_gallery" data-field="x_ng_id" name="o<?php echo $news_gallery_grid->RowIndex ?>_ng_id" id="o<?php echo $news_gallery_grid->RowIndex ?>_ng_id" value="<?php echo ew_HtmlEncode($news_gallery->ng_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="news_gallery" data-field="x_ng_id" name="fnews_gallerygrid$x<?php echo $news_gallery_grid->RowIndex ?>_ng_id" id="fnews_gallerygrid$x<?php echo $news_gallery_grid->RowIndex ?>_ng_id" value="<?php echo ew_HtmlEncode($news_gallery->ng_id->FormValue) ?>">
<input type="hidden" data-table="news_gallery" data-field="x_ng_id" name="fnews_gallerygrid$o<?php echo $news_gallery_grid->RowIndex ?>_ng_id" id="fnews_gallerygrid$o<?php echo $news_gallery_grid->RowIndex ?>_ng_id" value="<?php echo ew_HtmlEncode($news_gallery->ng_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($news_gallery->news_id->Visible) { // news_id ?>
		<td data-name="news_id"<?php echo $news_gallery->news_id->CellAttributes() ?>>
<?php if ($news_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($news_gallery->news_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_news_id" class="form-group news_gallery_news_id">
<span<?php echo $news_gallery->news_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $news_gallery->news_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_news_id" class="form-group news_gallery_news_id">
<select data-table="news_gallery" data-field="x_news_id" data-value-separator="<?php echo $news_gallery->news_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id"<?php echo $news_gallery->news_id->EditAttributes() ?>>
<?php echo $news_gallery->news_id->SelectOptionListHtml("x<?php echo $news_gallery_grid->RowIndex ?>_news_id") ?>
</select>
</span>
<?php } ?>
<input type="hidden" data-table="news_gallery" data-field="x_news_id" name="o<?php echo $news_gallery_grid->RowIndex ?>_news_id" id="o<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->OldValue) ?>">
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($news_gallery->news_id->getSessionValue() <> "") { ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_news_id" class="form-group news_gallery_news_id">
<span<?php echo $news_gallery->news_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $news_gallery->news_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_news_id" class="form-group news_gallery_news_id">
<select data-table="news_gallery" data-field="x_news_id" data-value-separator="<?php echo $news_gallery->news_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id"<?php echo $news_gallery->news_id->EditAttributes() ?>>
<?php echo $news_gallery->news_id->SelectOptionListHtml("x<?php echo $news_gallery_grid->RowIndex ?>_news_id") ?>
</select>
</span>
<?php } ?>
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_news_id" class="news_gallery_news_id">
<span<?php echo $news_gallery->news_id->ViewAttributes() ?>>
<?php echo $news_gallery->news_id->ListViewValue() ?></span>
</span>
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<input type="hidden" data-table="news_gallery" data-field="x_news_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->FormValue) ?>">
<input type="hidden" data-table="news_gallery" data-field="x_news_id" name="o<?php echo $news_gallery_grid->RowIndex ?>_news_id" id="o<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="news_gallery" data-field="x_news_id" name="fnews_gallerygrid$x<?php echo $news_gallery_grid->RowIndex ?>_news_id" id="fnews_gallerygrid$x<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->FormValue) ?>">
<input type="hidden" data-table="news_gallery" data-field="x_news_id" name="fnews_gallerygrid$o<?php echo $news_gallery_grid->RowIndex ?>_news_id" id="fnews_gallerygrid$o<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($news_gallery->image->Visible) { // image ?>
		<td data-name="image"<?php echo $news_gallery->image->CellAttributes() ?>>
<?php if ($news_gallery_grid->RowAction == "insert") { // Add record ?>
<span id="el$rowindex$_news_gallery_image" class="form-group news_gallery_image">
<div id="fd_x<?php echo $news_gallery_grid->RowIndex ?>_image">
<span title="<?php echo $news_gallery->image->FldTitle() ? $news_gallery->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($news_gallery->image->ReadOnly || $news_gallery->image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="news_gallery" data-field="x_image" name="x<?php echo $news_gallery_grid->RowIndex ?>_image" id="x<?php echo $news_gallery_grid->RowIndex ?>_image"<?php echo $news_gallery->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fn_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="<?php echo $news_gallery->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fa_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fs_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="150">
<input type="hidden" name="fx_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fx_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="<?php echo $news_gallery->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fm_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="<?php echo $news_gallery->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $news_gallery_grid->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="news_gallery" data-field="x_image" name="o<?php echo $news_gallery_grid->RowIndex ?>_image" id="o<?php echo $news_gallery_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($news_gallery->image->OldValue) ?>">
<?php } elseif ($news_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_image" class="news_gallery_image">
<span>
<?php echo ew_GetFileViewTag($news_gallery->image, $news_gallery->image->ListViewValue()) ?>
</span>
</span>
<?php } else  { // Edit record ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_image" class="form-group news_gallery_image">
<div id="fd_x<?php echo $news_gallery_grid->RowIndex ?>_image">
<span title="<?php echo $news_gallery->image->FldTitle() ? $news_gallery->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($news_gallery->image->ReadOnly || $news_gallery->image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="news_gallery" data-field="x_image" name="x<?php echo $news_gallery_grid->RowIndex ?>_image" id="x<?php echo $news_gallery_grid->RowIndex ?>_image"<?php echo $news_gallery->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fn_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="<?php echo $news_gallery->image->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $news_gallery_grid->RowIndex ?>_image"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fa_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fa_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fs_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="150">
<input type="hidden" name="fx_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fx_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="<?php echo $news_gallery->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fm_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="<?php echo $news_gallery->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $news_gallery_grid->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($news_gallery->g_order->Visible) { // g_order ?>
		<td data-name="g_order"<?php echo $news_gallery->g_order->CellAttributes() ?>>
<?php if ($news_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_g_order" class="form-group news_gallery_g_order">
<input type="text" data-table="news_gallery" data-field="x_g_order" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" size="30" placeholder="<?php echo ew_HtmlEncode($news_gallery->g_order->getPlaceHolder()) ?>" value="<?php echo $news_gallery->g_order->EditValue ?>"<?php echo $news_gallery->g_order->EditAttributes() ?>>
</span>
<input type="hidden" data-table="news_gallery" data-field="x_g_order" name="o<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="o<?php echo $news_gallery_grid->RowIndex ?>_g_order" value="<?php echo ew_HtmlEncode($news_gallery->g_order->OldValue) ?>">
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_g_order" class="form-group news_gallery_g_order">
<input type="text" data-table="news_gallery" data-field="x_g_order" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" size="30" placeholder="<?php echo ew_HtmlEncode($news_gallery->g_order->getPlaceHolder()) ?>" value="<?php echo $news_gallery->g_order->EditValue ?>"<?php echo $news_gallery->g_order->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_g_order" class="news_gallery_g_order">
<span<?php echo $news_gallery->g_order->ViewAttributes() ?>>
<?php echo $news_gallery->g_order->ListViewValue() ?></span>
</span>
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<input type="hidden" data-table="news_gallery" data-field="x_g_order" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" value="<?php echo ew_HtmlEncode($news_gallery->g_order->FormValue) ?>">
<input type="hidden" data-table="news_gallery" data-field="x_g_order" name="o<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="o<?php echo $news_gallery_grid->RowIndex ?>_g_order" value="<?php echo ew_HtmlEncode($news_gallery->g_order->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="news_gallery" data-field="x_g_order" name="fnews_gallerygrid$x<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="fnews_gallerygrid$x<?php echo $news_gallery_grid->RowIndex ?>_g_order" value="<?php echo ew_HtmlEncode($news_gallery->g_order->FormValue) ?>">
<input type="hidden" data-table="news_gallery" data-field="x_g_order" name="fnews_gallerygrid$o<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="fnews_gallerygrid$o<?php echo $news_gallery_grid->RowIndex ?>_g_order" value="<?php echo ew_HtmlEncode($news_gallery->g_order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($news_gallery->g_status->Visible) { // g_status ?>
		<td data-name="g_status"<?php echo $news_gallery->g_status->CellAttributes() ?>>
<?php if ($news_gallery->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_g_status" class="form-group news_gallery_g_status">
<select data-table="news_gallery" data-field="x_g_status" data-value-separator="<?php echo $news_gallery->g_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_status" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_status"<?php echo $news_gallery->g_status->EditAttributes() ?>>
<?php echo $news_gallery->g_status->SelectOptionListHtml("x<?php echo $news_gallery_grid->RowIndex ?>_g_status") ?>
</select>
</span>
<input type="hidden" data-table="news_gallery" data-field="x_g_status" name="o<?php echo $news_gallery_grid->RowIndex ?>_g_status" id="o<?php echo $news_gallery_grid->RowIndex ?>_g_status" value="<?php echo ew_HtmlEncode($news_gallery->g_status->OldValue) ?>">
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_g_status" class="form-group news_gallery_g_status">
<select data-table="news_gallery" data-field="x_g_status" data-value-separator="<?php echo $news_gallery->g_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_status" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_status"<?php echo $news_gallery->g_status->EditAttributes() ?>>
<?php echo $news_gallery->g_status->SelectOptionListHtml("x<?php echo $news_gallery_grid->RowIndex ?>_g_status") ?>
</select>
</span>
<?php } ?>
<?php if ($news_gallery->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $news_gallery_grid->RowCnt ?>_news_gallery_g_status" class="news_gallery_g_status">
<span<?php echo $news_gallery->g_status->ViewAttributes() ?>>
<?php echo $news_gallery->g_status->ListViewValue() ?></span>
</span>
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<input type="hidden" data-table="news_gallery" data-field="x_g_status" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_status" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_status" value="<?php echo ew_HtmlEncode($news_gallery->g_status->FormValue) ?>">
<input type="hidden" data-table="news_gallery" data-field="x_g_status" name="o<?php echo $news_gallery_grid->RowIndex ?>_g_status" id="o<?php echo $news_gallery_grid->RowIndex ?>_g_status" value="<?php echo ew_HtmlEncode($news_gallery->g_status->OldValue) ?>">
<?php } else { ?>
<input type="hidden" data-table="news_gallery" data-field="x_g_status" name="fnews_gallerygrid$x<?php echo $news_gallery_grid->RowIndex ?>_g_status" id="fnews_gallerygrid$x<?php echo $news_gallery_grid->RowIndex ?>_g_status" value="<?php echo ew_HtmlEncode($news_gallery->g_status->FormValue) ?>">
<input type="hidden" data-table="news_gallery" data-field="x_g_status" name="fnews_gallerygrid$o<?php echo $news_gallery_grid->RowIndex ?>_g_status" id="fnews_gallerygrid$o<?php echo $news_gallery_grid->RowIndex ?>_g_status" value="<?php echo ew_HtmlEncode($news_gallery->g_status->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
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
		$news_gallery_grid->LoadRowValues();

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
		<td data-name="ng_id">
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<?php } else { ?>
<span id="el$rowindex$_news_gallery_ng_id" class="form-group news_gallery_ng_id">
<span<?php echo $news_gallery->ng_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $news_gallery->ng_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="news_gallery" data-field="x_ng_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_ng_id" id="x<?php echo $news_gallery_grid->RowIndex ?>_ng_id" value="<?php echo ew_HtmlEncode($news_gallery->ng_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="news_gallery" data-field="x_ng_id" name="o<?php echo $news_gallery_grid->RowIndex ?>_ng_id" id="o<?php echo $news_gallery_grid->RowIndex ?>_ng_id" value="<?php echo ew_HtmlEncode($news_gallery->ng_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($news_gallery->news_id->Visible) { // news_id ?>
		<td data-name="news_id">
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<?php if ($news_gallery->news_id->getSessionValue() <> "") { ?>
<span id="el$rowindex$_news_gallery_news_id" class="form-group news_gallery_news_id">
<span<?php echo $news_gallery->news_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $news_gallery->news_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_news_gallery_news_id" class="form-group news_gallery_news_id">
<select data-table="news_gallery" data-field="x_news_id" data-value-separator="<?php echo $news_gallery->news_id->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id"<?php echo $news_gallery->news_id->EditAttributes() ?>>
<?php echo $news_gallery->news_id->SelectOptionListHtml("x<?php echo $news_gallery_grid->RowIndex ?>_news_id") ?>
</select>
</span>
<?php } ?>
<?php } else { ?>
<span id="el$rowindex$_news_gallery_news_id" class="form-group news_gallery_news_id">
<span<?php echo $news_gallery->news_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $news_gallery->news_id->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="news_gallery" data-field="x_news_id" name="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" id="x<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="news_gallery" data-field="x_news_id" name="o<?php echo $news_gallery_grid->RowIndex ?>_news_id" id="o<?php echo $news_gallery_grid->RowIndex ?>_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($news_gallery->image->Visible) { // image ?>
		<td data-name="image">
<span id="el$rowindex$_news_gallery_image" class="form-group news_gallery_image">
<div id="fd_x<?php echo $news_gallery_grid->RowIndex ?>_image">
<span title="<?php echo $news_gallery->image->FldTitle() ? $news_gallery->image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($news_gallery->image->ReadOnly || $news_gallery->image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="news_gallery" data-field="x_image" name="x<?php echo $news_gallery_grid->RowIndex ?>_image" id="x<?php echo $news_gallery_grid->RowIndex ?>_image"<?php echo $news_gallery->image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fn_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="<?php echo $news_gallery->image->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fa_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="0">
<input type="hidden" name="fs_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fs_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="150">
<input type="hidden" name="fx_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fx_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="<?php echo $news_gallery->image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $news_gallery_grid->RowIndex ?>_image" id= "fm_x<?php echo $news_gallery_grid->RowIndex ?>_image" value="<?php echo $news_gallery->image->UploadMaxFileSize ?>">
</div>
<table id="ft_x<?php echo $news_gallery_grid->RowIndex ?>_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="news_gallery" data-field="x_image" name="o<?php echo $news_gallery_grid->RowIndex ?>_image" id="o<?php echo $news_gallery_grid->RowIndex ?>_image" value="<?php echo ew_HtmlEncode($news_gallery->image->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($news_gallery->g_order->Visible) { // g_order ?>
		<td data-name="g_order">
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<span id="el$rowindex$_news_gallery_g_order" class="form-group news_gallery_g_order">
<input type="text" data-table="news_gallery" data-field="x_g_order" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" size="30" placeholder="<?php echo ew_HtmlEncode($news_gallery->g_order->getPlaceHolder()) ?>" value="<?php echo $news_gallery->g_order->EditValue ?>"<?php echo $news_gallery->g_order->EditAttributes() ?>>
</span>
<?php } else { ?>
<span id="el$rowindex$_news_gallery_g_order" class="form-group news_gallery_g_order">
<span<?php echo $news_gallery->g_order->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $news_gallery->g_order->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="news_gallery" data-field="x_g_order" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_order" value="<?php echo ew_HtmlEncode($news_gallery->g_order->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="news_gallery" data-field="x_g_order" name="o<?php echo $news_gallery_grid->RowIndex ?>_g_order" id="o<?php echo $news_gallery_grid->RowIndex ?>_g_order" value="<?php echo ew_HtmlEncode($news_gallery->g_order->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($news_gallery->g_status->Visible) { // g_status ?>
		<td data-name="g_status">
<?php if ($news_gallery->CurrentAction <> "F") { ?>
<span id="el$rowindex$_news_gallery_g_status" class="form-group news_gallery_g_status">
<select data-table="news_gallery" data-field="x_g_status" data-value-separator="<?php echo $news_gallery->g_status->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_status" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_status"<?php echo $news_gallery->g_status->EditAttributes() ?>>
<?php echo $news_gallery->g_status->SelectOptionListHtml("x<?php echo $news_gallery_grid->RowIndex ?>_g_status") ?>
</select>
</span>
<?php } else { ?>
<span id="el$rowindex$_news_gallery_g_status" class="form-group news_gallery_g_status">
<span<?php echo $news_gallery->g_status->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $news_gallery->g_status->ViewValue ?></p></span>
</span>
<input type="hidden" data-table="news_gallery" data-field="x_g_status" name="x<?php echo $news_gallery_grid->RowIndex ?>_g_status" id="x<?php echo $news_gallery_grid->RowIndex ?>_g_status" value="<?php echo ew_HtmlEncode($news_gallery->g_status->FormValue) ?>">
<?php } ?>
<input type="hidden" data-table="news_gallery" data-field="x_g_status" name="o<?php echo $news_gallery_grid->RowIndex ?>_g_status" id="o<?php echo $news_gallery_grid->RowIndex ?>_g_status" value="<?php echo ew_HtmlEncode($news_gallery->g_status->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$news_gallery_grid->ListOptions->Render("body", "right", $news_gallery_grid->RowIndex);
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
<input type="hidden" name="<?php echo $news_gallery_grid->FormKeyCountName ?>" id="<?php echo $news_gallery_grid->FormKeyCountName ?>" value="<?php echo $news_gallery_grid->KeyCount ?>">
<?php echo $news_gallery_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($news_gallery->CurrentMode == "edit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $news_gallery_grid->FormKeyCountName ?>" id="<?php echo $news_gallery_grid->FormKeyCountName ?>" value="<?php echo $news_gallery_grid->KeyCount ?>">
<?php echo $news_gallery_grid->MultiSelectKey ?>
<?php } ?>
<?php if ($news_gallery->CurrentMode == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fnews_gallerygrid">
</div>
<?php

// Close recordset
if ($news_gallery_grid->Recordset)
	$news_gallery_grid->Recordset->Close();
?>
<?php if ($news_gallery_grid->ShowOtherOptions) { ?>
<div class="box-footer ewGridLowerPanel">
<?php
	foreach ($news_gallery_grid->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
<?php } ?>
</div>
</div>
<?php } ?>
<?php if ($news_gallery_grid->TotalRecs == 0 && $news_gallery->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($news_gallery_grid->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($news_gallery->Export == "") { ?>
<script type="text/javascript">
fnews_gallerygrid.Init();
</script>
<?php } ?>
<?php
$news_gallery_grid->Page_Terminate();
?>
