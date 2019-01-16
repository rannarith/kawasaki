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

$news_gallery_view = NULL; // Initialize page object first

class cnews_gallery_view extends cnews_gallery {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'news_gallery';

	// Page object name
	var $PageObjName = 'news_gallery_view';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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
		$KeyUrl = "";
		if (@$_GET["ng_id"] <> "") {
			$this->RecKey["ng_id"] = $_GET["ng_id"];
			$KeyUrl .= "&ng_id=" . urlencode($this->RecKey["ng_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (news)
		if (!isset($GLOBALS['news'])) $GLOBALS['news'] = new cnews();

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'news_gallery', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->TagClassName = "ewExportOption";
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
	var $ExportOptions; // Export options
	var $DisplayRecs = 1;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["ng_id"] <> "") {
				$this->ng_id->setQueryStringValue($_GET["ng_id"]);
				$this->RecKey["ng_id"] = $this->ng_id->QueryStringValue;
			} else {
				$sReturnUrl = "news_gallerylist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "news_gallerylist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "news_gallerylist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
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
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();

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
if (!isset($news_gallery_view)) $news_gallery_view = new cnews_gallery_view();

// Page init
$news_gallery_view->Page_Init();

// Page main
$news_gallery_view->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var news_gallery_view = new ew_Page("news_gallery_view");
news_gallery_view.PageID = "view"; // Page ID
var EW_PAGE_ID = news_gallery_view.PageID; // For backward compatibility

// Form object
var fnews_galleryview = new ew_Form("fnews_galleryview");

// Form_CustomValidate event
fnews_galleryview.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fnews_galleryview.ValidateRequired = true;
<?php } else { ?>
fnews_galleryview.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fnews_galleryview.Lists["x_news_id"] = {"LinkField":"x_news_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("View") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $news_gallery->TableCaption() ?>&nbsp;&nbsp;</span><?php $news_gallery_view->ExportOptions->Render("body"); ?>
</p>
<p class="phpmaker">
<a href="<?php echo $news_gallery_view->ListUrl ?>"><?php echo $Language->Phrase("BackToList") ?></a>&nbsp;
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($news_gallery_view->AddUrl <> "") { ?>
<a href="<?php echo $news_gallery_view->AddUrl ?>"><?php echo $Language->Phrase("ViewPageAddLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($news_gallery_view->EditUrl <> "") { ?>
<a href="<?php echo $news_gallery_view->EditUrl ?>"><?php echo $Language->Phrase("ViewPageEditLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($news_gallery_view->CopyUrl <> "") { ?>
<a href="<?php echo $news_gallery_view->CopyUrl ?>"><?php echo $Language->Phrase("ViewPageCopyLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($news_gallery_view->DeleteUrl <> "") { ?>
<a href="<?php echo $news_gallery_view->DeleteUrl ?>"><?php echo $Language->Phrase("ViewPageDeleteLink") ?></a>&nbsp;
<?php } ?>
<?php } ?>
</p>
<?php $news_gallery_view->ShowPageHeader(); ?>
<?php
$news_gallery_view->ShowMessage();
?>
<form name="fnews_galleryview" id="fnews_galleryview" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="news_gallery">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_news_galleryview" class="ewTable">
<?php if ($news_gallery->ng_id->Visible) { // ng_id ?>
	<tr id="r_ng_id"<?php echo $news_gallery->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_gallery_ng_id"><?php echo $news_gallery->ng_id->FldCaption() ?></span></td>
		<td<?php echo $news_gallery->ng_id->CellAttributes() ?>><span id="el_news_gallery_ng_id">
<span<?php echo $news_gallery->ng_id->ViewAttributes() ?>>
<?php echo $news_gallery->ng_id->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($news_gallery->news_id->Visible) { // news_id ?>
	<tr id="r_news_id"<?php echo $news_gallery->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_gallery_news_id"><?php echo $news_gallery->news_id->FldCaption() ?></span></td>
		<td<?php echo $news_gallery->news_id->CellAttributes() ?>><span id="el_news_gallery_news_id">
<span<?php echo $news_gallery->news_id->ViewAttributes() ?>>
<?php echo $news_gallery->news_id->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($news_gallery->image->Visible) { // image ?>
	<tr id="r_image"<?php echo $news_gallery->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_gallery_image"><?php echo $news_gallery->image->FldCaption() ?></span></td>
		<td<?php echo $news_gallery->image->CellAttributes() ?>><span id="el_news_gallery_image">
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
	</tr>
<?php } ?>
<?php if ($news_gallery->g_status->Visible) { // g_status ?>
	<tr id="r_g_status"<?php echo $news_gallery->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_gallery_g_status"><?php echo $news_gallery->g_status->FldCaption() ?></span></td>
		<td<?php echo $news_gallery->g_status->CellAttributes() ?>><span id="el_news_gallery_g_status">
<span<?php echo $news_gallery->g_status->ViewAttributes() ?>>
<?php echo $news_gallery->g_status->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
<?php if ($news_gallery->g_order->Visible) { // g_order ?>
	<tr id="r_g_order"<?php echo $news_gallery->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_gallery_g_order"><?php echo $news_gallery->g_order->FldCaption() ?></span></td>
		<td<?php echo $news_gallery->g_order->CellAttributes() ?>><span id="el_news_gallery_g_order">
<span<?php echo $news_gallery->g_order->ViewAttributes() ?>>
<?php echo $news_gallery->g_order->ViewValue ?></span>
</span></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
</form>
<p>
<script type="text/javascript">
fnews_galleryview.Init();
</script>
<?php
$news_gallery_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$news_gallery_view->Page_Terminate();
?>
