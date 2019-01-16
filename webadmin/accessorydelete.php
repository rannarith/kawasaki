<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "accessoryinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$accessory_delete = NULL; // Initialize page object first

class caccessory_delete extends caccessory {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'accessory';

	// Page object name
	var $PageObjName = 'accessory_delete';

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

		// Table object (accessory)
		if (!isset($GLOBALS["accessory"])) {
			$GLOBALS["accessory"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["accessory"];
		}

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'accessory', TRUE);

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
		$this->acs_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			$this->Page_Terminate("accessorylist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in accessory class, accessoryinfo.php

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
		$this->acs_id->setDbValue($rs->fields('acs_id'));
		$this->title->setDbValue($rs->fields('title'));
		$this->price->setDbValue($rs->fields('price'));
		$this->thumbnail->Upload->DbValue = $rs->fields('thumbnail');
		$this->short_des->setDbValue($rs->fields('short_des'));
		$this->long_des->setDbValue($rs->fields('long_des'));
		$this->status->setDbValue($rs->fields('status'));
		$this->model_id->setDbValue($rs->fields('model_id'));
		$this->type->setDbValue($rs->fields('type'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// acs_id
		// title
		// price
		// thumbnail
		// short_des
		// long_des
		// status
		// model_id
		// type

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// acs_id
			$this->acs_id->ViewValue = $this->acs_id->CurrentValue;
			$this->acs_id->ViewCustomAttributes = "";

			// title
			$this->title->ViewValue = $this->title->CurrentValue;
			$this->title->ViewCustomAttributes = "";

			// price
			$this->price->ViewValue = $this->price->CurrentValue;
			$this->price->ViewCustomAttributes = "";

			// thumbnail
			$this->thumbnail->UploadPath = '../assets/images/accessory/';
			if (!ew_Empty($this->thumbnail->Upload->DbValue)) {
				$this->thumbnail->ViewValue = $this->thumbnail->Upload->DbValue;
				$this->thumbnail->ImageWidth = 200;
				$this->thumbnail->ImageHeight = 0;
				$this->thumbnail->ImageAlt = $this->thumbnail->FldAlt();
			} else {
				$this->thumbnail->ViewValue = "";
			}
			$this->thumbnail->ViewCustomAttributes = "";

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

			// model_id
			if (strval($this->model_id->CurrentValue) <> "") {
				$sFilterWrk = "`model_id`" . ew_SearchString("=", $this->model_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `model_id`, `model_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `model`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `model_name` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->model_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->model_id->ViewValue = $this->model_id->CurrentValue;
				}
			} else {
				$this->model_id->ViewValue = NULL;
			}
			$this->model_id->ViewCustomAttributes = "";

			// type
			if (strval($this->type->CurrentValue) <> "") {
				switch ($this->type->CurrentValue) {
					case $this->type->FldTagValue(1):
						$this->type->ViewValue = $this->type->FldTagCaption(1) <> "" ? $this->type->FldTagCaption(1) : $this->type->CurrentValue;
						break;
					case $this->type->FldTagValue(2):
						$this->type->ViewValue = $this->type->FldTagCaption(2) <> "" ? $this->type->FldTagCaption(2) : $this->type->CurrentValue;
						break;
					default:
						$this->type->ViewValue = $this->type->CurrentValue;
				}
			} else {
				$this->type->ViewValue = NULL;
			}
			$this->type->ViewCustomAttributes = "";

			// acs_id
			$this->acs_id->LinkCustomAttributes = "";
			$this->acs_id->HrefValue = "";
			$this->acs_id->TooltipValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// price
			$this->price->LinkCustomAttributes = "";
			$this->price->HrefValue = "";
			$this->price->TooltipValue = "";

			// thumbnail
			$this->thumbnail->LinkCustomAttributes = "";
			$this->thumbnail->HrefValue = "";
			$this->thumbnail->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// model_id
			$this->model_id->LinkCustomAttributes = "";
			$this->model_id->HrefValue = "";
			$this->model_id->TooltipValue = "";

			// type
			$this->type->LinkCustomAttributes = "";
			$this->type->HrefValue = "";
			$this->type->TooltipValue = "";
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
				$sThisKey .= $row['acs_id'];
				$this->thumbnail->UploadPath = '../assets/images/accessory/';
				@unlink(ew_UploadPathEx(TRUE, $this->thumbnail->UploadPath) . $row['thumbnail']);
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
if (!isset($accessory_delete)) $accessory_delete = new caccessory_delete();

// Page init
$accessory_delete->Page_Init();

// Page main
$accessory_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var accessory_delete = new ew_Page("accessory_delete");
accessory_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = accessory_delete.PageID; // For backward compatibility

// Form object
var faccessorydelete = new ew_Form("faccessorydelete");

// Form_CustomValidate event
faccessorydelete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faccessorydelete.ValidateRequired = true;
<?php } else { ?>
faccessorydelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faccessorydelete.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($accessory_delete->Recordset = $accessory_delete->LoadRecordset())
	$accessory_deleteTotalRecs = $accessory_delete->Recordset->RecordCount(); // Get record count
if ($accessory_deleteTotalRecs <= 0) { // No record found, exit
	if ($accessory_delete->Recordset)
		$accessory_delete->Recordset->Close();
	$accessory_delete->Page_Terminate("accessorylist.php"); // Return to list
}
?>
<p><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $accessory->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $accessory->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $accessory_delete->ShowPageHeader(); ?>
<?php
$accessory_delete->ShowMessage();
?>
<form name="faccessorydelete" id="faccessorydelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" value="accessory">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($accessory_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_accessorydelete" class="ewTable ewTableSeparate">
<?php echo $accessory->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_accessory_acs_id" class="accessory_acs_id"><?php echo $accessory->acs_id->FldCaption() ?></span></td>
		<td><span id="elh_accessory_title" class="accessory_title"><?php echo $accessory->title->FldCaption() ?></span></td>
		<td><span id="elh_accessory_price" class="accessory_price"><?php echo $accessory->price->FldCaption() ?></span></td>
		<td><span id="elh_accessory_thumbnail" class="accessory_thumbnail"><?php echo $accessory->thumbnail->FldCaption() ?></span></td>
		<td><span id="elh_accessory_status" class="accessory_status"><?php echo $accessory->status->FldCaption() ?></span></td>
		<td><span id="elh_accessory_model_id" class="accessory_model_id"><?php echo $accessory->model_id->FldCaption() ?></span></td>
		<td><span id="elh_accessory_type" class="accessory_type"><?php echo $accessory->type->FldCaption() ?></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$accessory_delete->RecCnt = 0;
$i = 0;
while (!$accessory_delete->Recordset->EOF) {
	$accessory_delete->RecCnt++;
	$accessory_delete->RowCnt++;

	// Set row properties
	$accessory->ResetAttrs();
	$accessory->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$accessory_delete->LoadRowValues($accessory_delete->Recordset);

	// Render row
	$accessory_delete->RenderRow();
?>
	<tr<?php echo $accessory->RowAttributes() ?>>
		<td<?php echo $accessory->acs_id->CellAttributes() ?>><span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_acs_id" class="accessory_acs_id">
<span<?php echo $accessory->acs_id->ViewAttributes() ?>>
<?php echo $accessory->acs_id->ListViewValue() ?></span>
</span></td>
		<td<?php echo $accessory->title->CellAttributes() ?>><span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_title" class="accessory_title">
<span<?php echo $accessory->title->ViewAttributes() ?>>
<?php echo $accessory->title->ListViewValue() ?></span>
</span></td>
		<td<?php echo $accessory->price->CellAttributes() ?>><span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_price" class="accessory_price">
<span<?php echo $accessory->price->ViewAttributes() ?>>
<?php echo $accessory->price->ListViewValue() ?></span>
</span></td>
		<td<?php echo $accessory->thumbnail->CellAttributes() ?>><span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_thumbnail" class="accessory_thumbnail">
<span>
<?php if ($accessory->thumbnail->LinkAttributes() <> "") { ?>
<?php if (!empty($accessory->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $accessory->thumbnail->UploadPath) . $accessory->thumbnail->Upload->DbValue ?>" border="0"<?php echo $accessory->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($accessory->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($accessory->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $accessory->thumbnail->UploadPath) . $accessory->thumbnail->Upload->DbValue ?>" border="0"<?php echo $accessory->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($accessory->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span></td>
		<td<?php echo $accessory->status->CellAttributes() ?>><span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_status" class="accessory_status">
<span<?php echo $accessory->status->ViewAttributes() ?>>
<?php echo $accessory->status->ListViewValue() ?></span>
</span></td>
		<td<?php echo $accessory->model_id->CellAttributes() ?>><span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_model_id" class="accessory_model_id">
<span<?php echo $accessory->model_id->ViewAttributes() ?>>
<?php echo $accessory->model_id->ListViewValue() ?></span>
</span></td>
		<td<?php echo $accessory->type->CellAttributes() ?>><span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_type" class="accessory_type">
<span<?php echo $accessory->type->ViewAttributes() ?>>
<?php echo $accessory->type->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$accessory_delete->Recordset->MoveNext();
}
$accessory_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
faccessorydelete.Init();
</script>
<?php
$accessory_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$accessory_delete->Page_Terminate();
?>
