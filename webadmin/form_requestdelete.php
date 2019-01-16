<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "form_requestinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$form_request_delete = NULL; // Initialize page object first

class cform_request_delete extends cform_request {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'form_request';

	// Page object name
	var $PageObjName = 'form_request_delete';

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

		// Table object (form_request)
		if (!isset($GLOBALS["form_request"])) {
			$GLOBALS["form_request"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["form_request"];
		}

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'form_request', TRUE);

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
		$this->fr_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
			$this->Page_Terminate("form_requestlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in form_request class, form_requestinfo.php

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
		$this->fr_id->setDbValue($rs->fields('fr_id'));
		$this->fullname->setDbValue($rs->fields('fullname'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->phone->setDbValue($rs->fields('phone'));
		$this->model->setDbValue($rs->fields('model'));
		$this->message->setDbValue($rs->fields('message'));
		$this->date_submit->setDbValue($rs->fields('date_submit'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// fr_id
		// fullname
		// email
		// phone
		// model
		// message
		// date_submit

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// fr_id
			$this->fr_id->ViewValue = $this->fr_id->CurrentValue;
			$this->fr_id->ViewCustomAttributes = "";

			// fullname
			$this->fullname->ViewValue = $this->fullname->CurrentValue;
			$this->fullname->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// phone
			$this->phone->ViewValue = $this->phone->CurrentValue;
			$this->phone->ViewCustomAttributes = "";

			// model
			$this->model->ViewValue = $this->model->CurrentValue;
			$this->model->ViewCustomAttributes = "";

			// date_submit
			$this->date_submit->ViewValue = $this->date_submit->CurrentValue;
			$this->date_submit->ViewValue = ew_FormatDateTime($this->date_submit->ViewValue, 5);
			$this->date_submit->ViewCustomAttributes = "";

			// fr_id
			$this->fr_id->LinkCustomAttributes = "";
			$this->fr_id->HrefValue = "";
			$this->fr_id->TooltipValue = "";

			// fullname
			$this->fullname->LinkCustomAttributes = "";
			$this->fullname->HrefValue = "";
			$this->fullname->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// phone
			$this->phone->LinkCustomAttributes = "";
			$this->phone->HrefValue = "";
			$this->phone->TooltipValue = "";

			// model
			$this->model->LinkCustomAttributes = "";
			$this->model->HrefValue = "";
			$this->model->TooltipValue = "";

			// date_submit
			$this->date_submit->LinkCustomAttributes = "";
			$this->date_submit->HrefValue = "";
			$this->date_submit->TooltipValue = "";
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
				$sThisKey .= $row['fr_id'];
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
if (!isset($form_request_delete)) $form_request_delete = new cform_request_delete();

// Page init
$form_request_delete->Page_Init();

// Page main
$form_request_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var form_request_delete = new ew_Page("form_request_delete");
form_request_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = form_request_delete.PageID; // For backward compatibility

// Form object
var fform_requestdelete = new ew_Form("fform_requestdelete");

// Form_CustomValidate event
fform_requestdelete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fform_requestdelete.ValidateRequired = true;
<?php } else { ?>
fform_requestdelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($form_request_delete->Recordset = $form_request_delete->LoadRecordset())
	$form_request_deleteTotalRecs = $form_request_delete->Recordset->RecordCount(); // Get record count
if ($form_request_deleteTotalRecs <= 0) { // No record found, exit
	if ($form_request_delete->Recordset)
		$form_request_delete->Recordset->Close();
	$form_request_delete->Page_Terminate("form_requestlist.php"); // Return to list
}
?>
<p><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $form_request->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $form_request->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $form_request_delete->ShowPageHeader(); ?>
<?php
$form_request_delete->ShowMessage();
?>
<form name="fform_requestdelete" id="fform_requestdelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" value="form_request">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($form_request_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_form_requestdelete" class="ewTable ewTableSeparate">
<?php echo $form_request->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_form_request_fr_id" class="form_request_fr_id"><?php echo $form_request->fr_id->FldCaption() ?></span></td>
		<td><span id="elh_form_request_fullname" class="form_request_fullname"><?php echo $form_request->fullname->FldCaption() ?></span></td>
		<td><span id="elh_form_request__email" class="form_request__email"><?php echo $form_request->_email->FldCaption() ?></span></td>
		<td><span id="elh_form_request_phone" class="form_request_phone"><?php echo $form_request->phone->FldCaption() ?></span></td>
		<td><span id="elh_form_request_model" class="form_request_model"><?php echo $form_request->model->FldCaption() ?></span></td>
		<td><span id="elh_form_request_date_submit" class="form_request_date_submit"><?php echo $form_request->date_submit->FldCaption() ?></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$form_request_delete->RecCnt = 0;
$i = 0;
while (!$form_request_delete->Recordset->EOF) {
	$form_request_delete->RecCnt++;
	$form_request_delete->RowCnt++;

	// Set row properties
	$form_request->ResetAttrs();
	$form_request->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$form_request_delete->LoadRowValues($form_request_delete->Recordset);

	// Render row
	$form_request_delete->RenderRow();
?>
	<tr<?php echo $form_request->RowAttributes() ?>>
		<td<?php echo $form_request->fr_id->CellAttributes() ?>><span id="el<?php echo $form_request_delete->RowCnt ?>_form_request_fr_id" class="form_request_fr_id">
<span<?php echo $form_request->fr_id->ViewAttributes() ?>>
<?php echo $form_request->fr_id->ListViewValue() ?></span>
</span></td>
		<td<?php echo $form_request->fullname->CellAttributes() ?>><span id="el<?php echo $form_request_delete->RowCnt ?>_form_request_fullname" class="form_request_fullname">
<span<?php echo $form_request->fullname->ViewAttributes() ?>>
<?php echo $form_request->fullname->ListViewValue() ?></span>
</span></td>
		<td<?php echo $form_request->_email->CellAttributes() ?>><span id="el<?php echo $form_request_delete->RowCnt ?>_form_request__email" class="form_request__email">
<span<?php echo $form_request->_email->ViewAttributes() ?>>
<?php echo $form_request->_email->ListViewValue() ?></span>
</span></td>
		<td<?php echo $form_request->phone->CellAttributes() ?>><span id="el<?php echo $form_request_delete->RowCnt ?>_form_request_phone" class="form_request_phone">
<span<?php echo $form_request->phone->ViewAttributes() ?>>
<?php echo $form_request->phone->ListViewValue() ?></span>
</span></td>
		<td<?php echo $form_request->model->CellAttributes() ?>><span id="el<?php echo $form_request_delete->RowCnt ?>_form_request_model" class="form_request_model">
<span<?php echo $form_request->model->ViewAttributes() ?>>
<?php echo $form_request->model->ListViewValue() ?></span>
</span></td>
		<td<?php echo $form_request->date_submit->CellAttributes() ?>><span id="el<?php echo $form_request_delete->RowCnt ?>_form_request_date_submit" class="form_request_date_submit">
<span<?php echo $form_request->date_submit->ViewAttributes() ?>>
<?php echo $form_request->date_submit->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$form_request_delete->Recordset->MoveNext();
}
$form_request_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
fform_requestdelete.Init();
</script>
<?php
$form_request_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$form_request_delete->Page_Terminate();
?>
