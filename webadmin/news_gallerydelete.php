<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "news_galleryinfo.php" ?>
<?php include_once "newsinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$news_gallery_delete = NULL; // Initialize page object first

class cnews_gallery_delete extends cnews_gallery {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'news_gallery';

	// Page object name
	var $PageObjName = 'news_gallery_delete';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			$html .= "<p class=\"ewMessage\">" . $sMessage . "</p>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewWarningIcon\"></td><td class=\"ewWarningMessage\">" . $sWarningMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewSuccessIcon\"></td><td class=\"ewSuccessMessage\">" . $sSuccessMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			$html .= "<table class=\"ewMessageTable\"><tr><td class=\"ewErrorIcon\"></td><td class=\"ewErrorMessage\">" . $sErrorMessage . "</td></tr></table>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}		
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p class=\"phpmaker\">" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Fotoer exists, display
			echo "<p class=\"phpmaker\">" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (news_gallery)
		if (!isset($GLOBALS["news_gallery"])) {
			$GLOBALS["news_gallery"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["news_gallery"];
		}

		// Table object (news)
		if (!isset($GLOBALS['news'])) $GLOBALS['news'] = new cnews();

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'news_gallery', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if (!$Security->IsLoggedIn()) {
			$Security->SaveLastUrl();
			$this->Page_Terminate("login.php");
		}
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"];
		$this->ng_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $conn;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

		 // Close connection
		$conn->Close();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("news_gallerylist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in news_gallery class, news_galleryinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		global $conn;
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->ng_id->setDbValue($rs->fields('ng_id'));
		$this->news_id->setDbValue($rs->fields('news_id'));
		$this->image->Upload->DbValue = $rs->fields('image');
		$this->g_status->setDbValue($rs->fields('g_status'));
		$this->g_order->setDbValue($rs->fields('g_order'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// ng_id
		// news_id
		// image
		// g_status
		// g_order

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// ng_id
			$this->ng_id->ViewValue = $this->ng_id->CurrentValue;
			$this->ng_id->ViewCustomAttributes = "";

			// news_id
			if (strval($this->news_id->CurrentValue) <> "") {
				$sFilterWrk = "`news_id`" . ew_SearchString("=", $this->news_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `news_id`, `title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `news`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `news_id` DESC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->news_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->news_id->ViewValue = $this->news_id->CurrentValue;
				}
			} else {
				$this->news_id->ViewValue = NULL;
			}
			$this->news_id->ViewCustomAttributes = "";

			// image
			$this->image->UploadPath = '../assets/images/news_gallery/';
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->ViewValue = $this->image->Upload->DbValue;
				$this->image->ImageWidth = 250;
				$this->image->ImageHeight = 0;
				$this->image->ImageAlt = $this->image->FldAlt();
			} else {
				$this->image->ViewValue = "";
			}
			$this->image->ViewCustomAttributes = "";

			// g_status
			if (strval($this->g_status->CurrentValue) <> "") {
				switch ($this->g_status->CurrentValue) {
					case $this->g_status->FldTagValue(1):
						$this->g_status->ViewValue = $this->g_status->FldTagCaption(1) <> "" ? $this->g_status->FldTagCaption(1) : $this->g_status->CurrentValue;
						break;
					case $this->g_status->FldTagValue(2):
						$this->g_status->ViewValue = $this->g_status->FldTagCaption(2) <> "" ? $this->g_status->FldTagCaption(2) : $this->g_status->CurrentValue;
						break;
					default:
						$this->g_status->ViewValue = $this->g_status->CurrentValue;
				}
			} else {
				$this->g_status->ViewValue = NULL;
			}
			$this->g_status->ViewCustomAttributes = "";

			// g_order
			$this->g_order->ViewValue = $this->g_order->CurrentValue;
			$this->g_order->ViewCustomAttributes = "";

			// ng_id
			$this->ng_id->LinkCustomAttributes = "";
			$this->ng_id->HrefValue = "";
			$this->ng_id->TooltipValue = "";

			// news_id
			$this->news_id->LinkCustomAttributes = "";
			$this->news_id->HrefValue = "";
			$this->news_id->TooltipValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";
			$this->image->TooltipValue = "";

			// g_status
			$this->g_status->LinkCustomAttributes = "";
			$this->g_status->HrefValue = "";
			$this->g_status->TooltipValue = "";

			// g_order
			$this->g_order->LinkCustomAttributes = "";
			$this->g_order->HrefValue = "";
			$this->g_order->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		} else {
			$this->LoadRowValues($rs); // Load row values
		}
		$conn->BeginTrans();

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['ng_id'];
				$this->image->UploadPath = '../assets/images/news_gallery/';
				@unlink(ew_UploadPathEx(TRUE, $this->image->UploadPath) . $row['image']);
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($news_gallery_delete)) $news_gallery_delete = new cnews_gallery_delete();

// Page init
$news_gallery_delete->Page_Init();

// Page main
$news_gallery_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var news_gallery_delete = new ew_Page("news_gallery_delete");
news_gallery_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = news_gallery_delete.PageID; // For backward compatibility

// Form object
var fnews_gallerydelete = new ew_Form("fnews_gallerydelete");

// Form_CustomValidate event
fnews_gallerydelete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fnews_gallerydelete.ValidateRequired = true;
<?php } else { ?>
fnews_gallerydelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fnews_gallerydelete.Lists["x_news_id"] = {"LinkField":"x_news_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($news_gallery_delete->Recordset = $news_gallery_delete->LoadRecordset())
	$news_gallery_deleteTotalRecs = $news_gallery_delete->Recordset->RecordCount(); // Get record count
if ($news_gallery_deleteTotalRecs <= 0) { // No record found, exit
	if ($news_gallery_delete->Recordset)
		$news_gallery_delete->Recordset->Close();
	$news_gallery_delete->Page_Terminate("news_gallerylist.php"); // Return to list
}
?>
<p><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $news_gallery->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $news_gallery->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $news_gallery_delete->ShowPageHeader(); ?>
<?php
$news_gallery_delete->ShowMessage();
?>
<form name="fnews_gallerydelete" id="fnews_gallerydelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" value="news_gallery">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($news_gallery_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_news_gallerydelete" class="ewTable ewTableSeparate">
<?php echo $news_gallery->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_news_gallery_ng_id" class="news_gallery_ng_id"><?php echo $news_gallery->ng_id->FldCaption() ?></span></td>
		<td><span id="elh_news_gallery_news_id" class="news_gallery_news_id"><?php echo $news_gallery->news_id->FldCaption() ?></span></td>
		<td><span id="elh_news_gallery_image" class="news_gallery_image"><?php echo $news_gallery->image->FldCaption() ?></span></td>
		<td><span id="elh_news_gallery_g_status" class="news_gallery_g_status"><?php echo $news_gallery->g_status->FldCaption() ?></span></td>
		<td><span id="elh_news_gallery_g_order" class="news_gallery_g_order"><?php echo $news_gallery->g_order->FldCaption() ?></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$news_gallery_delete->RecCnt = 0;
$i = 0;
while (!$news_gallery_delete->Recordset->EOF) {
	$news_gallery_delete->RecCnt++;
	$news_gallery_delete->RowCnt++;

	// Set row properties
	$news_gallery->ResetAttrs();
	$news_gallery->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$news_gallery_delete->LoadRowValues($news_gallery_delete->Recordset);

	// Render row
	$news_gallery_delete->RenderRow();
?>
	<tr<?php echo $news_gallery->RowAttributes() ?>>
		<td<?php echo $news_gallery->ng_id->CellAttributes() ?>><span id="el<?php echo $news_gallery_delete->RowCnt ?>_news_gallery_ng_id" class="news_gallery_ng_id">
<span<?php echo $news_gallery->ng_id->ViewAttributes() ?>>
<?php echo $news_gallery->ng_id->ListViewValue() ?></span>
</span></td>
		<td<?php echo $news_gallery->news_id->CellAttributes() ?>><span id="el<?php echo $news_gallery_delete->RowCnt ?>_news_gallery_news_id" class="news_gallery_news_id">
<span<?php echo $news_gallery->news_id->ViewAttributes() ?>>
<?php echo $news_gallery->news_id->ListViewValue() ?></span>
</span></td>
		<td<?php echo $news_gallery->image->CellAttributes() ?>><span id="el<?php echo $news_gallery_delete->RowCnt ?>_news_gallery_image" class="news_gallery_image">
<span>
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
</span>
</span></td>
		<td<?php echo $news_gallery->g_status->CellAttributes() ?>><span id="el<?php echo $news_gallery_delete->RowCnt ?>_news_gallery_g_status" class="news_gallery_g_status">
<span<?php echo $news_gallery->g_status->ViewAttributes() ?>>
<?php echo $news_gallery->g_status->ListViewValue() ?></span>
</span></td>
		<td<?php echo $news_gallery->g_order->CellAttributes() ?>><span id="el<?php echo $news_gallery_delete->RowCnt ?>_news_gallery_g_order" class="news_gallery_g_order">
<span<?php echo $news_gallery->g_order->ViewAttributes() ?>>
<?php echo $news_gallery->g_order->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$news_gallery_delete->Recordset->MoveNext();
}
$news_gallery_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
fnews_gallerydelete.Init();
</script>
<?php
$news_gallery_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$news_gallery_delete->Page_Terminate();
?>
