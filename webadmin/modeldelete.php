<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "modelinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$model_delete = NULL; // Initialize page object first

class cmodel_delete extends cmodel {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'model';

	// Page object name
	var $PageObjName = 'model_delete';

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

		// Table object (model)
		if (!isset($GLOBALS["model"])) {
			$GLOBALS["model"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["model"];
		}

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'model', TRUE);

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
		$this->model_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			$this->Page_Terminate("modellist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in model class, modelinfo.php

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
		$this->model_id->setDbValue($rs->fields('model_id'));
		$this->model_name->setDbValue($rs->fields('model_name'));
		$this->model_logo->Upload->DbValue = $rs->fields('model_logo');
		$this->model_year->setDbValue($rs->fields('model_year'));
		$this->icon_menu->Upload->DbValue = $rs->fields('icon_menu');
		$this->thumbnail->Upload->DbValue = $rs->fields('thumbnail');
		$this->full_image->Upload->DbValue = $rs->fields('full_image');
		$this->description->setDbValue($rs->fields('description'));
		$this->youtube_url->setDbValue($rs->fields('youtube_url'));
		$this->category_id->setDbValue($rs->fields('category_id'));
		$this->status->setDbValue($rs->fields('status'));
		$this->m_order->setDbValue($rs->fields('m_order'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// model_id
		// model_name
		// model_logo
		// model_year
		// icon_menu
		// thumbnail
		// full_image
		// description
		// youtube_url
		// category_id
		// status
		// m_order

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// model_id
			$this->model_id->ViewValue = $this->model_id->CurrentValue;
			$this->model_id->ViewCustomAttributes = "";

			// model_name
			$this->model_name->ViewValue = $this->model_name->CurrentValue;
			$this->model_name->ViewCustomAttributes = "";

			// model_logo
			$this->model_logo->UploadPath = '../assets/images/model_thumbnail/';
			if (!ew_Empty($this->model_logo->Upload->DbValue)) {
				$this->model_logo->ViewValue = $this->model_logo->Upload->DbValue;
				$this->model_logo->ImageWidth = 100;
				$this->model_logo->ImageHeight = 0;
				$this->model_logo->ImageAlt = $this->model_logo->FldAlt();
			} else {
				$this->model_logo->ViewValue = "";
			}
			$this->model_logo->ViewCustomAttributes = "";

			// model_year
			$this->model_year->ViewValue = $this->model_year->CurrentValue;
			$this->model_year->ViewCustomAttributes = "";

			// icon_menu
			$this->icon_menu->UploadPath = '../assets/images/model_menu/';
			if (!ew_Empty($this->icon_menu->Upload->DbValue)) {
				$this->icon_menu->ViewValue = $this->icon_menu->Upload->DbValue;
				$this->icon_menu->ImageWidth = 200;
				$this->icon_menu->ImageHeight = 0;
				$this->icon_menu->ImageAlt = $this->icon_menu->FldAlt();
			} else {
				$this->icon_menu->ViewValue = "";
			}
			$this->icon_menu->ViewCustomAttributes = "";

			// thumbnail
			$this->thumbnail->UploadPath = '../assets/images/model_thumbnail/';
			if (!ew_Empty($this->thumbnail->Upload->DbValue)) {
				$this->thumbnail->ViewValue = $this->thumbnail->Upload->DbValue;
				$this->thumbnail->ImageWidth = 200;
				$this->thumbnail->ImageHeight = 0;
				$this->thumbnail->ImageAlt = $this->thumbnail->FldAlt();
			} else {
				$this->thumbnail->ViewValue = "";
			}
			$this->thumbnail->ViewCustomAttributes = "";

			// full_image
			$this->full_image->UploadPath = '../assets/images/model/';
			if (!ew_Empty($this->full_image->Upload->DbValue)) {
				$this->full_image->ViewValue = $this->full_image->Upload->DbValue;
				$this->full_image->ImageWidth = 300;
				$this->full_image->ImageHeight = 0;
				$this->full_image->ImageAlt = $this->full_image->FldAlt();
			} else {
				$this->full_image->ViewValue = "";
			}
			$this->full_image->ViewCustomAttributes = "";

			// youtube_url
			$this->youtube_url->ViewValue = $this->youtube_url->CurrentValue;
			$this->youtube_url->ViewCustomAttributes = "";

			// category_id
			if (strval($this->category_id->CurrentValue) <> "") {
				$sFilterWrk = "`category_id`" . ew_SearchString("=", $this->category_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `category_id`, `category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `model_category`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `category_name` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->category_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->category_id->ViewValue = $this->category_id->CurrentValue;
				}
			} else {
				$this->category_id->ViewValue = NULL;
			}
			$this->category_id->ViewCustomAttributes = "";

			// status
			if (strval($this->status->CurrentValue) <> "") {
				switch ($this->status->CurrentValue) {
					case $this->status->FldTagValue(1):
						$this->status->ViewValue = $this->status->FldTagCaption(1) <> "" ? $this->status->FldTagCaption(1) : $this->status->CurrentValue;
						break;
					case $this->status->FldTagValue(2):
						$this->status->ViewValue = $this->status->FldTagCaption(2) <> "" ? $this->status->FldTagCaption(2) : $this->status->CurrentValue;
						break;
					default:
						$this->status->ViewValue = $this->status->CurrentValue;
				}
			} else {
				$this->status->ViewValue = NULL;
			}
			$this->status->ViewCustomAttributes = "";

			// m_order
			$this->m_order->ViewValue = $this->m_order->CurrentValue;
			$this->m_order->ViewCustomAttributes = "";

			// model_id
			$this->model_id->LinkCustomAttributes = "";
			$this->model_id->HrefValue = "";
			$this->model_id->TooltipValue = "";

			// model_name
			$this->model_name->LinkCustomAttributes = "";
			$this->model_name->HrefValue = "";
			$this->model_name->TooltipValue = "";

			// model_logo
			$this->model_logo->LinkCustomAttributes = "";
			$this->model_logo->HrefValue = "";
			$this->model_logo->TooltipValue = "";

			// model_year
			$this->model_year->LinkCustomAttributes = "";
			$this->model_year->HrefValue = "";
			$this->model_year->TooltipValue = "";

			// icon_menu
			$this->icon_menu->LinkCustomAttributes = "";
			$this->icon_menu->HrefValue = "";
			$this->icon_menu->TooltipValue = "";

			// thumbnail
			$this->thumbnail->LinkCustomAttributes = "";
			$this->thumbnail->HrefValue = "";
			$this->thumbnail->TooltipValue = "";

			// full_image
			$this->full_image->LinkCustomAttributes = "";
			$this->full_image->HrefValue = "";
			$this->full_image->TooltipValue = "";

			// youtube_url
			$this->youtube_url->LinkCustomAttributes = "";
			$this->youtube_url->HrefValue = "";
			$this->youtube_url->TooltipValue = "";

			// category_id
			$this->category_id->LinkCustomAttributes = "";
			$this->category_id->HrefValue = "";
			$this->category_id->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// m_order
			$this->m_order->LinkCustomAttributes = "";
			$this->m_order->HrefValue = "";
			$this->m_order->TooltipValue = "";
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
				$sThisKey .= $row['model_id'];
				$this->model_logo->UploadPath = '../assets/images/model_thumbnail/';
				@unlink(ew_UploadPathEx(TRUE, $this->model_logo->UploadPath) . $row['model_logo']);
				$this->icon_menu->UploadPath = '../assets/images/model_menu/';
				@unlink(ew_UploadPathEx(TRUE, $this->icon_menu->UploadPath) . $row['icon_menu']);
				$this->thumbnail->UploadPath = '../assets/images/model_thumbnail/';
				@unlink(ew_UploadPathEx(TRUE, $this->thumbnail->UploadPath) . $row['thumbnail']);
				$this->full_image->UploadPath = '../assets/images/model/';
				@unlink(ew_UploadPathEx(TRUE, $this->full_image->UploadPath) . $row['full_image']);
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
if (!isset($model_delete)) $model_delete = new cmodel_delete();

// Page init
$model_delete->Page_Init();

// Page main
$model_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var model_delete = new ew_Page("model_delete");
model_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = model_delete.PageID; // For backward compatibility

// Form object
var fmodeldelete = new ew_Form("fmodeldelete");

// Form_CustomValidate event
fmodeldelete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmodeldelete.ValidateRequired = true;
<?php } else { ?>
fmodeldelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmodeldelete.Lists["x_category_id"] = {"LinkField":"x_category_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_category_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($model_delete->Recordset = $model_delete->LoadRecordset())
	$model_deleteTotalRecs = $model_delete->Recordset->RecordCount(); // Get record count
if ($model_deleteTotalRecs <= 0) { // No record found, exit
	if ($model_delete->Recordset)
		$model_delete->Recordset->Close();
	$model_delete->Page_Terminate("modellist.php"); // Return to list
}
?>
<p><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $model->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $model->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $model_delete->ShowPageHeader(); ?>
<?php
$model_delete->ShowMessage();
?>
<form name="fmodeldelete" id="fmodeldelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" value="model">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($model_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_modeldelete" class="ewTable ewTableSeparate">
<?php echo $model->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_model_model_id" class="model_model_id"><?php echo $model->model_id->FldCaption() ?></span></td>
		<td><span id="elh_model_model_name" class="model_model_name"><?php echo $model->model_name->FldCaption() ?></span></td>
		<td><span id="elh_model_model_logo" class="model_model_logo"><?php echo $model->model_logo->FldCaption() ?></span></td>
		<td><span id="elh_model_model_year" class="model_model_year"><?php echo $model->model_year->FldCaption() ?></span></td>
		<td><span id="elh_model_icon_menu" class="model_icon_menu"><?php echo $model->icon_menu->FldCaption() ?></span></td>
		<td><span id="elh_model_thumbnail" class="model_thumbnail"><?php echo $model->thumbnail->FldCaption() ?></span></td>
		<td><span id="elh_model_full_image" class="model_full_image"><?php echo $model->full_image->FldCaption() ?></span></td>
		<td><span id="elh_model_youtube_url" class="model_youtube_url"><?php echo $model->youtube_url->FldCaption() ?></span></td>
		<td><span id="elh_model_category_id" class="model_category_id"><?php echo $model->category_id->FldCaption() ?></span></td>
		<td><span id="elh_model_status" class="model_status"><?php echo $model->status->FldCaption() ?></span></td>
		<td><span id="elh_model_m_order" class="model_m_order"><?php echo $model->m_order->FldCaption() ?></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$model_delete->RecCnt = 0;
$i = 0;
while (!$model_delete->Recordset->EOF) {
	$model_delete->RecCnt++;
	$model_delete->RowCnt++;

	// Set row properties
	$model->ResetAttrs();
	$model->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$model_delete->LoadRowValues($model_delete->Recordset);

	// Render row
	$model_delete->RenderRow();
?>
	<tr<?php echo $model->RowAttributes() ?>>
		<td<?php echo $model->model_id->CellAttributes() ?>><span id="el<?php echo $model_delete->RowCnt ?>_model_model_id" class="model_model_id">
<span<?php echo $model->model_id->ViewAttributes() ?>>
<?php echo $model->model_id->ListViewValue() ?></span>
</span></td>
		<td<?php echo $model->model_name->CellAttributes() ?>><span id="el<?php echo $model_delete->RowCnt ?>_model_model_name" class="model_model_name">
<span<?php echo $model->model_name->ViewAttributes() ?>>
<?php echo $model->model_name->ListViewValue() ?></span>
</span></td>
		<td<?php echo $model->model_logo->CellAttributes() ?>><span id="el<?php echo $model_delete->RowCnt ?>_model_model_logo" class="model_model_logo">
<span>
<?php if ($model->model_logo->LinkAttributes() <> "") { ?>
<?php if (!empty($model->model_logo->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->model_logo->UploadPath) . $model->model_logo->Upload->DbValue ?>" border="0"<?php echo $model->model_logo->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model->model_logo->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->model_logo->UploadPath) . $model->model_logo->Upload->DbValue ?>" border="0"<?php echo $model->model_logo->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span></td>
		<td<?php echo $model->model_year->CellAttributes() ?>><span id="el<?php echo $model_delete->RowCnt ?>_model_model_year" class="model_model_year">
<span<?php echo $model->model_year->ViewAttributes() ?>>
<?php echo $model->model_year->ListViewValue() ?></span>
</span></td>
		<td<?php echo $model->icon_menu->CellAttributes() ?>><span id="el<?php echo $model_delete->RowCnt ?>_model_icon_menu" class="model_icon_menu">
<span>
<?php if ($model->icon_menu->LinkAttributes() <> "") { ?>
<?php if (!empty($model->icon_menu->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->icon_menu->UploadPath) . $model->icon_menu->Upload->DbValue ?>" border="0"<?php echo $model->icon_menu->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model->icon_menu->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->icon_menu->UploadPath) . $model->icon_menu->Upload->DbValue ?>" border="0"<?php echo $model->icon_menu->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span></td>
		<td<?php echo $model->thumbnail->CellAttributes() ?>><span id="el<?php echo $model_delete->RowCnt ?>_model_thumbnail" class="model_thumbnail">
<span>
<?php if ($model->thumbnail->LinkAttributes() <> "") { ?>
<?php if (!empty($model->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->thumbnail->UploadPath) . $model->thumbnail->Upload->DbValue ?>" border="0"<?php echo $model->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->thumbnail->UploadPath) . $model->thumbnail->Upload->DbValue ?>" border="0"<?php echo $model->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span></td>
		<td<?php echo $model->full_image->CellAttributes() ?>><span id="el<?php echo $model_delete->RowCnt ?>_model_full_image" class="model_full_image">
<span>
<?php if ($model->full_image->LinkAttributes() <> "") { ?>
<?php if (!empty($model->full_image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->full_image->UploadPath) . $model->full_image->Upload->DbValue ?>" border="0"<?php echo $model->full_image->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model->full_image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model->full_image->UploadPath) . $model->full_image->Upload->DbValue ?>" border="0"<?php echo $model->full_image->ViewAttributes() ?>>
<?php } elseif (!in_array($model->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span></td>
		<td<?php echo $model->youtube_url->CellAttributes() ?>><span id="el<?php echo $model_delete->RowCnt ?>_model_youtube_url" class="model_youtube_url">
<span<?php echo $model->youtube_url->ViewAttributes() ?>>
<?php echo $model->youtube_url->ListViewValue() ?></span>
</span></td>
		<td<?php echo $model->category_id->CellAttributes() ?>><span id="el<?php echo $model_delete->RowCnt ?>_model_category_id" class="model_category_id">
<span<?php echo $model->category_id->ViewAttributes() ?>>
<?php echo $model->category_id->ListViewValue() ?></span>
</span></td>
		<td<?php echo $model->status->CellAttributes() ?>><span id="el<?php echo $model_delete->RowCnt ?>_model_status" class="model_status">
<span<?php echo $model->status->ViewAttributes() ?>>
<?php echo $model->status->ListViewValue() ?></span>
</span></td>
		<td<?php echo $model->m_order->CellAttributes() ?>><span id="el<?php echo $model_delete->RowCnt ?>_model_m_order" class="model_m_order">
<span<?php echo $model->m_order->ViewAttributes() ?>>
<?php echo $model->m_order->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$model_delete->Recordset->MoveNext();
}
$model_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
fmodeldelete.Init();
</script>
<?php
$model_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$model_delete->Page_Terminate();
?>
