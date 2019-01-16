<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "company_infoinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$company_info_edit = NULL; // Initialize page object first

class ccompany_info_edit extends ccompany_info {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'company_info';

	// Page object name
	var $PageObjName = 'company_info_edit';

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

		// Table object (company_info)
		if (!isset($GLOBALS["company_info"])) {
			$GLOBALS["company_info"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["company_info"];
		}

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'company_info', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"];
		$this->cid->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["cid"] <> "")
			$this->cid->setQueryStringValue($_GET["cid"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->cid->CurrentValue == "")
			$this->Page_Terminate("company_infolist.php"); // Invalid key, return to list

		// Validate form if post back
		if (@$_POST["a_edit"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("company_infolist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$sReturnUrl = $this->getReturnUrl();
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Restore form values if update failed
				}
		}

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm;

		// Get upload data
		$index = $objForm->Index; // Save form index
		$objForm->Index = -1;
		$confirmPage = (strval($objForm->GetValue("a_confirm")) <> "");
		$objForm->Index = $index; // Restore form index
		$this->logo->Upload->Index = $objForm->Index;
		$this->logo->Upload->RestoreDbFromSession();
		if ($confirmPage) { // Post from confirm page
			$this->logo->Upload->RestoreFromSession();
		} else {
			if ($this->logo->Upload->UploadFile()) {

				// No action required
			} else {
				echo $this->logo->Upload->Message;
				$this->Page_Terminate();
				exit();
			}
			$this->logo->Upload->SaveToSession();
			$this->logo->CurrentValue = $this->logo->Upload->FileName;
		}
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->cid->FldIsDetailKey)
			$this->cid->setFormValue($objForm->GetValue("x_cid"));
		if (!$this->company_name->FldIsDetailKey) {
			$this->company_name->setFormValue($objForm->GetValue("x_company_name"));
		}
		if (!$this->address->FldIsDetailKey) {
			$this->address->setFormValue($objForm->GetValue("x_address"));
		}
		if (!$this->_email->FldIsDetailKey) {
			$this->_email->setFormValue($objForm->GetValue("x__email"));
		}
		if (!$this->phone_number->FldIsDetailKey) {
			$this->phone_number->setFormValue($objForm->GetValue("x_phone_number"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->cid->CurrentValue = $this->cid->FormValue;
		$this->company_name->CurrentValue = $this->company_name->FormValue;
		$this->address->CurrentValue = $this->address->FormValue;
		$this->_email->CurrentValue = $this->_email->FormValue;
		$this->phone_number->CurrentValue = $this->phone_number->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
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
		$this->cid->setDbValue($rs->fields('cid'));
		$this->company_name->setDbValue($rs->fields('company_name'));
		$this->logo->Upload->DbValue = $rs->fields('logo');
		$this->address->setDbValue($rs->fields('address'));
		$this->_email->setDbValue($rs->fields('email'));
		$this->phone_number->setDbValue($rs->fields('phone_number'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// cid
		// company_name
		// logo
		// address
		// email
		// phone_number
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// cid
			$this->cid->ViewValue = $this->cid->CurrentValue;
			$this->cid->ViewCustomAttributes = "";

			// company_name
			$this->company_name->ViewValue = $this->company_name->CurrentValue;
			$this->company_name->ViewCustomAttributes = "";

			// logo
			$this->logo->UploadPath = '../assets/images/';
			if (!ew_Empty($this->logo->Upload->DbValue)) {
				$this->logo->ViewValue = $this->logo->Upload->DbValue;
				$this->logo->ImageWidth = 100;
				$this->logo->ImageHeight = 0;
				$this->logo->ImageAlt = $this->logo->FldAlt();
			} else {
				$this->logo->ViewValue = "";
			}
			$this->logo->ViewCustomAttributes = "";

			// address
			$this->address->ViewValue = $this->address->CurrentValue;
			$this->address->ViewCustomAttributes = "";

			// email
			$this->_email->ViewValue = $this->_email->CurrentValue;
			$this->_email->ViewCustomAttributes = "";

			// phone_number
			$this->phone_number->ViewValue = $this->phone_number->CurrentValue;
			$this->phone_number->ViewCustomAttributes = "";

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

			// cid
			$this->cid->LinkCustomAttributes = "";
			$this->cid->HrefValue = "";
			$this->cid->TooltipValue = "";

			// company_name
			$this->company_name->LinkCustomAttributes = "";
			$this->company_name->HrefValue = "";
			$this->company_name->TooltipValue = "";

			// logo
			$this->logo->LinkCustomAttributes = "";
			$this->logo->HrefValue = "";
			$this->logo->TooltipValue = "";

			// address
			$this->address->LinkCustomAttributes = "";
			$this->address->HrefValue = "";
			$this->address->TooltipValue = "";

			// email
			$this->_email->LinkCustomAttributes = "";
			$this->_email->HrefValue = "";
			$this->_email->TooltipValue = "";

			// phone_number
			$this->phone_number->LinkCustomAttributes = "";
			$this->phone_number->HrefValue = "";
			$this->phone_number->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// cid
			$this->cid->EditCustomAttributes = "";
			$this->cid->EditValue = $this->cid->CurrentValue;
			$this->cid->ViewCustomAttributes = "";

			// company_name
			$this->company_name->EditCustomAttributes = "";
			$this->company_name->EditValue = ew_HtmlEncode($this->company_name->CurrentValue);

			// logo
			$this->logo->EditCustomAttributes = "";
			$this->logo->UploadPath = '../assets/images/';
			if (!ew_Empty($this->logo->Upload->DbValue)) {
				$this->logo->EditValue = $this->logo->Upload->DbValue;
				$this->logo->ImageWidth = 100;
				$this->logo->ImageHeight = 0;
				$this->logo->ImageAlt = $this->logo->FldAlt();
			} else {
				$this->logo->EditValue = "";
			}

			// address
			$this->address->EditCustomAttributes = "";
			$this->address->EditValue = ew_HtmlEncode($this->address->CurrentValue);

			// email
			$this->_email->EditCustomAttributes = "";
			$this->_email->EditValue = ew_HtmlEncode($this->_email->CurrentValue);

			// phone_number
			$this->phone_number->EditCustomAttributes = "";
			$this->phone_number->EditValue = ew_HtmlEncode($this->phone_number->CurrentValue);

			// status
			$this->status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->status->FldTagValue(1), $this->status->FldTagCaption(1) <> "" ? $this->status->FldTagCaption(1) : $this->status->FldTagValue(1));
			$arwrk[] = array($this->status->FldTagValue(2), $this->status->FldTagCaption(2) <> "" ? $this->status->FldTagCaption(2) : $this->status->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->status->EditValue = $arwrk;

			// Edit refer script
			// cid

			$this->cid->HrefValue = "";

			// company_name
			$this->company_name->HrefValue = "";

			// logo
			$this->logo->HrefValue = "";

			// address
			$this->address->HrefValue = "";

			// email
			$this->_email->HrefValue = "";

			// phone_number
			$this->phone_number->HrefValue = "";

			// status
			$this->status->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";
		if (!ew_CheckFileType($this->logo->Upload->FileName)) {
			ew_AddMessage($gsFormError, $Language->Phrase("WrongFileType"));
		}
		if ($this->logo->Upload->FileSize > 0 && EW_MAX_FILE_SIZE > 0 && $this->logo->Upload->FileSize > EW_MAX_FILE_SIZE) {
			ew_AddMessage($gsFormError, str_replace("%s", EW_MAX_FILE_SIZE, $Language->Phrase("MaxFileSize")));
		}
		if (in_array($this->logo->Upload->Error, array(1, 2, 3, 6, 7, 8))) {
			ew_AddMessage($gsFormError, $Language->Phrase("PhpUploadErr" . $this->logo->Upload->Error));
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($this->company_name->FormValue) && $this->company_name->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->company_name->FldCaption());
		}
		if ($this->logo->Upload->Action == "3" && is_null($this->logo->Upload->Value)) {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->logo->FldCaption());
		}
		if (!is_null($this->status->FormValue) && $this->status->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->status->FldCaption());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	// Update record based on key values
	function EditRow() {
		global $conn, $Security, $Language;
		$sFilter = $this->KeyFilter();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$rsnew = array();

			// company_name
			$this->company_name->SetDbValueDef($rsnew, $this->company_name->CurrentValue, NULL, $this->company_name->ReadOnly);

			// logo
			if (!($this->logo->ReadOnly)) {
			$this->logo->UploadPath = '../assets/images/';
			if ($this->logo->Upload->Action == "1") { // Keep
			} elseif ($this->logo->Upload->Action == "2" || $this->logo->Upload->Action == "3") { // Update/Remove
			$this->logo->Upload->DbValue = $rs->fields('logo'); // Get original value
			if (is_null($this->logo->Upload->Value)) {
				$rsnew['logo'] = NULL;
			} else {
				if ($this->logo->Upload->FileName == $this->logo->Upload->DbValue) { // Upload file name same as old file name
					$rsnew['logo'] = $this->logo->Upload->FileName;
				} else {
					$rsnew['logo'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->logo->UploadPath), $this->logo->Upload->FileName);
				}
			}
			}
			}

			// address
			$this->address->SetDbValueDef($rsnew, $this->address->CurrentValue, NULL, $this->address->ReadOnly);

			// email
			$this->_email->SetDbValueDef($rsnew, $this->_email->CurrentValue, NULL, $this->_email->ReadOnly);

			// phone_number
			$this->phone_number->SetDbValueDef($rsnew, $this->phone_number->CurrentValue, NULL, $this->phone_number->ReadOnly);

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, 0, $this->status->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				if (!ew_Empty($this->logo->Upload->Value)) {
					if ($this->logo->Upload->FileName == $this->logo->Upload->DbValue) { // Overwrite if same file name
						$this->logo->Upload->SaveToFile($this->logo->UploadPath, $rsnew['logo'], TRUE);
						$this->logo->Upload->DbValue = ""; // No need to delete any more
					} else {
						$this->logo->Upload->SaveToFile($this->logo->UploadPath, $rsnew['logo'], FALSE);
					}
				}
				if ($this->logo->Upload->Action == "2" || $this->logo->Upload->Action == "3") { // Update/Remove
					if ($this->logo->Upload->DbValue <> "")
						@unlink(ew_UploadPathEx(TRUE, $this->logo->UploadPath) . $this->logo->Upload->DbValue);
				}
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		$rs->Close();

		// logo
		$this->logo->Upload->RemoveFromSession(); // Remove file value from Session
		return $EditRow;
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

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($company_info_edit)) $company_info_edit = new ccompany_info_edit();

// Page init
$company_info_edit->Page_Init();

// Page main
$company_info_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var company_info_edit = new ew_Page("company_info_edit");
company_info_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = company_info_edit.PageID; // For backward compatibility

// Form object
var fcompany_infoedit = new ew_Form("fcompany_infoedit");

// Validate form
fcompany_infoedit.Validate = function(fobj) {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	fobj = fobj || this.Form;
	this.PostAutoSuggest();	
	if (fobj.a_confirm && fobj.a_confirm.value == "F")
		return true;
	var elm, aelm;
	var rowcnt = 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // rowcnt == 0 => Inline-Add
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = "";
		elm = fobj.elements["x" + infix + "_company_name"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($company_info->company_name->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_logo"];
		aelm = fobj.elements["a" + infix + "_logo"];
		var chk_logo = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_logo && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($company_info->logo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_logo"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_status"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($company_info->status->FldCaption()) ?>");

		// Set up row object
		ew_ElementsToRow(fobj, infix);

		// Fire Form_CustomValidate event
		if (!this.Form_CustomValidate(fobj))
			return false;
	}

	// Process detail page
	if (fobj.detailpage && fobj.detailpage.value && ewForms[fobj.detailpage.value])
		return ewForms[fobj.detailpage.value].Validate(fobj);
	return true;
}

// Form_CustomValidate event
fcompany_infoedit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fcompany_infoedit.ValidateRequired = true;
<?php } else { ?>
fcompany_infoedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $company_info->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $company_info->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $company_info_edit->ShowPageHeader(); ?>
<?php
$company_info_edit->ShowMessage();
?>
<form name="fcompany_infoedit" id="fcompany_infoedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" enctype="multipart/form-data" onsubmit="return ewForms[this.id].Submit();">
<p>
<input type="hidden" name="t" value="company_info">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_company_infoedit" class="ewTable">
<?php if ($company_info->cid->Visible) { // cid ?>
	<tr id="r_cid"<?php echo $company_info->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_company_info_cid"><?php echo $company_info->cid->FldCaption() ?></span></td>
		<td<?php echo $company_info->cid->CellAttributes() ?>><span id="el_company_info_cid">
<span<?php echo $company_info->cid->ViewAttributes() ?>>
<?php echo $company_info->cid->EditValue ?></span>
<input type="hidden" name="x_cid" id="x_cid" value="<?php echo ew_HtmlEncode($company_info->cid->CurrentValue) ?>">
</span><?php echo $company_info->cid->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($company_info->company_name->Visible) { // company_name ?>
	<tr id="r_company_name"<?php echo $company_info->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_company_info_company_name"><?php echo $company_info->company_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $company_info->company_name->CellAttributes() ?>><span id="el_company_info_company_name">
<input type="text" name="x_company_name" id="x_company_name" size="30" maxlength="150" value="<?php echo $company_info->company_name->EditValue ?>"<?php echo $company_info->company_name->EditAttributes() ?>>
</span><?php echo $company_info->company_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($company_info->logo->Visible) { // logo ?>
	<tr id="r_logo"<?php echo $company_info->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_company_info_logo"><?php echo $company_info->logo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $company_info->logo->CellAttributes() ?>><span id="el_company_info_logo">
<div id="old_x_logo">
<?php if ($company_info->logo->LinkAttributes() <> "") { ?>
<?php if (!empty($company_info->logo->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $company_info->logo->UploadPath) . $company_info->logo->Upload->DbValue ?>" border="0"<?php echo $company_info->logo->ViewAttributes() ?>>
<?php } elseif (!in_array($company_info->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($company_info->logo->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $company_info->logo->UploadPath) . $company_info->logo->Upload->DbValue ?>" border="0"<?php echo $company_info->logo->ViewAttributes() ?>>
<?php } elseif (!in_array($company_info->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x_logo">
<?php if ($company_info->logo->ReadOnly) { ?>
<?php if (!empty($company_info->logo->Upload->DbValue)) { ?>
<input type="hidden" name="a_logo" id="a_logo" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($company_info->logo->Upload->DbValue)) { ?>
<label><input type="radio" name="a_logo" id="a_logo" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_logo" id="a_logo" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_logo" id="a_logo" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $company_info->logo->EditAttrs["onchange"] = "this.form.a_logo[2].checked=true;" . @$company_info->logo->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_logo" id="a_logo" value="3">
<?php } ?>
<input type="file" name="x_logo" id="x_logo" size="30"<?php echo $company_info->logo->EditAttributes() ?>>
<?php } ?>
</div>
</span><?php echo $company_info->logo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($company_info->address->Visible) { // address ?>
	<tr id="r_address"<?php echo $company_info->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_company_info_address"><?php echo $company_info->address->FldCaption() ?></span></td>
		<td<?php echo $company_info->address->CellAttributes() ?>><span id="el_company_info_address">
<textarea name="x_address" id="x_address" cols="55" rows="7"<?php echo $company_info->address->EditAttributes() ?>><?php echo $company_info->address->EditValue ?></textarea>
</span><?php echo $company_info->address->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($company_info->_email->Visible) { // email ?>
	<tr id="r__email"<?php echo $company_info->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_company_info__email"><?php echo $company_info->_email->FldCaption() ?></span></td>
		<td<?php echo $company_info->_email->CellAttributes() ?>><span id="el_company_info__email">
<input type="text" name="x__email" id="x__email" size="30" maxlength="120" value="<?php echo $company_info->_email->EditValue ?>"<?php echo $company_info->_email->EditAttributes() ?>>
</span><?php echo $company_info->_email->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($company_info->phone_number->Visible) { // phone_number ?>
	<tr id="r_phone_number"<?php echo $company_info->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_company_info_phone_number"><?php echo $company_info->phone_number->FldCaption() ?></span></td>
		<td<?php echo $company_info->phone_number->CellAttributes() ?>><span id="el_company_info_phone_number">
<input type="text" name="x_phone_number" id="x_phone_number" size="30" maxlength="100" value="<?php echo $company_info->phone_number->EditValue ?>"<?php echo $company_info->phone_number->EditAttributes() ?>>
</span><?php echo $company_info->phone_number->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($company_info->status->Visible) { // status ?>
	<tr id="r_status"<?php echo $company_info->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_company_info_status"><?php echo $company_info->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $company_info->status->CellAttributes() ?>><span id="el_company_info_status">
<select id="x_status" name="x_status"<?php echo $company_info->status->EditAttributes() ?>>
<?php
if (is_array($company_info->status->EditValue)) {
	$arwrk = $company_info->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($company_info->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
		if ($selwrk <> "") $emptywrk = FALSE;
?>
<option value="<?php echo ew_HtmlEncode($arwrk[$rowcntwrk][0]) ?>"<?php echo $selwrk ?>>
<?php echo $arwrk[$rowcntwrk][1] ?>
</option>
<?php
	}
}
?>
</select>
</span><?php echo $company_info->status->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
fcompany_infoedit.Init();
</script>
<?php
$company_info_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$company_info_edit->Page_Terminate();
?>
