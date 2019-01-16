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

$accessory_edit = NULL; // Initialize page object first

class caccessory_edit extends caccessory {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'accessory';

	// Page object name
	var $PageObjName = 'accessory_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
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
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["acs_id"] <> "")
			$this->acs_id->setQueryStringValue($_GET["acs_id"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->acs_id->CurrentValue == "")
			$this->Page_Terminate("accessorylist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("accessorylist.php"); // No matching record, return to list
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
		$this->thumbnail->Upload->Index = $objForm->Index;
		$this->thumbnail->Upload->RestoreDbFromSession();
		if ($confirmPage) { // Post from confirm page
			$this->thumbnail->Upload->RestoreFromSession();
		} else {
			if ($this->thumbnail->Upload->UploadFile()) {

				// No action required
			} else {
				echo $this->thumbnail->Upload->Message;
				$this->Page_Terminate();
				exit();
			}
			$this->thumbnail->Upload->SaveToSession();
			$this->thumbnail->CurrentValue = $this->thumbnail->Upload->FileName;
		}
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->acs_id->FldIsDetailKey)
			$this->acs_id->setFormValue($objForm->GetValue("x_acs_id"));
		if (!$this->title->FldIsDetailKey) {
			$this->title->setFormValue($objForm->GetValue("x_title"));
		}
		if (!$this->price->FldIsDetailKey) {
			$this->price->setFormValue($objForm->GetValue("x_price"));
		}
		if (!$this->short_des->FldIsDetailKey) {
			$this->short_des->setFormValue($objForm->GetValue("x_short_des"));
		}
		if (!$this->long_des->FldIsDetailKey) {
			$this->long_des->setFormValue($objForm->GetValue("x_long_des"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->model_id->FldIsDetailKey) {
			$this->model_id->setFormValue($objForm->GetValue("x_model_id"));
		}
		if (!$this->type->FldIsDetailKey) {
			$this->type->setFormValue($objForm->GetValue("x_type"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->acs_id->CurrentValue = $this->acs_id->FormValue;
		$this->title->CurrentValue = $this->title->FormValue;
		$this->price->CurrentValue = $this->price->FormValue;
		$this->short_des->CurrentValue = $this->short_des->FormValue;
		$this->long_des->CurrentValue = $this->long_des->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->model_id->CurrentValue = $this->model_id->FormValue;
		$this->type->CurrentValue = $this->type->FormValue;
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

			// short_des
			$this->short_des->ViewValue = $this->short_des->CurrentValue;
			$this->short_des->ViewCustomAttributes = "";

			// long_des
			$this->long_des->ViewValue = $this->long_des->CurrentValue;
			$this->long_des->ViewCustomAttributes = "";

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

			// short_des
			$this->short_des->LinkCustomAttributes = "";
			$this->short_des->HrefValue = "";
			$this->short_des->TooltipValue = "";

			// long_des
			$this->long_des->LinkCustomAttributes = "";
			$this->long_des->HrefValue = "";
			$this->long_des->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// acs_id
			$this->acs_id->EditCustomAttributes = "";
			$this->acs_id->EditValue = $this->acs_id->CurrentValue;
			$this->acs_id->ViewCustomAttributes = "";

			// title
			$this->title->EditCustomAttributes = "";
			$this->title->EditValue = ew_HtmlEncode($this->title->CurrentValue);

			// price
			$this->price->EditCustomAttributes = "";
			$this->price->EditValue = ew_HtmlEncode($this->price->CurrentValue);

			// thumbnail
			$this->thumbnail->EditCustomAttributes = "";
			$this->thumbnail->UploadPath = '../assets/images/accessory/';
			if (!ew_Empty($this->thumbnail->Upload->DbValue)) {
				$this->thumbnail->EditValue = $this->thumbnail->Upload->DbValue;
				$this->thumbnail->ImageWidth = 200;
				$this->thumbnail->ImageHeight = 0;
				$this->thumbnail->ImageAlt = $this->thumbnail->FldAlt();
			} else {
				$this->thumbnail->EditValue = "";
			}

			// short_des
			$this->short_des->EditCustomAttributes = "";
			$this->short_des->EditValue = ew_HtmlEncode($this->short_des->CurrentValue);

			// long_des
			$this->long_des->EditCustomAttributes = "";
			$this->long_des->EditValue = ew_HtmlEncode($this->long_des->CurrentValue);

			// status
			$this->status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->status->FldTagValue(1), $this->status->FldTagCaption(1) <> "" ? $this->status->FldTagCaption(1) : $this->status->FldTagValue(1));
			$arwrk[] = array($this->status->FldTagValue(2), $this->status->FldTagCaption(2) <> "" ? $this->status->FldTagCaption(2) : $this->status->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->status->EditValue = $arwrk;

			// model_id
			$this->model_id->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `model_id`, `model_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `model`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `model_name` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->model_id->EditValue = $arwrk;

			// type
			$this->type->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->type->FldTagValue(1), $this->type->FldTagCaption(1) <> "" ? $this->type->FldTagCaption(1) : $this->type->FldTagValue(1));
			$arwrk[] = array($this->type->FldTagValue(2), $this->type->FldTagCaption(2) <> "" ? $this->type->FldTagCaption(2) : $this->type->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->type->EditValue = $arwrk;

			// Edit refer script
			// acs_id

			$this->acs_id->HrefValue = "";

			// title
			$this->title->HrefValue = "";

			// price
			$this->price->HrefValue = "";

			// thumbnail
			$this->thumbnail->HrefValue = "";

			// short_des
			$this->short_des->HrefValue = "";

			// long_des
			$this->long_des->HrefValue = "";

			// status
			$this->status->HrefValue = "";

			// model_id
			$this->model_id->HrefValue = "";

			// type
			$this->type->HrefValue = "";
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
		if (!ew_CheckFileType($this->thumbnail->Upload->FileName)) {
			ew_AddMessage($gsFormError, $Language->Phrase("WrongFileType"));
		}
		if ($this->thumbnail->Upload->FileSize > 0 && EW_MAX_FILE_SIZE > 0 && $this->thumbnail->Upload->FileSize > EW_MAX_FILE_SIZE) {
			ew_AddMessage($gsFormError, str_replace("%s", EW_MAX_FILE_SIZE, $Language->Phrase("MaxFileSize")));
		}
		if (in_array($this->thumbnail->Upload->Error, array(1, 2, 3, 6, 7, 8))) {
			ew_AddMessage($gsFormError, $Language->Phrase("PhpUploadErr" . $this->thumbnail->Upload->Error));
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($this->title->FormValue) && $this->title->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->title->FldCaption());
		}
		if ($this->thumbnail->Upload->Action == "3" && is_null($this->thumbnail->Upload->Value)) {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->thumbnail->FldCaption());
		}
		if (!is_null($this->status->FormValue) && $this->status->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->status->FldCaption());
		}
		if (!is_null($this->type->FormValue) && $this->type->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->type->FldCaption());
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

			// title
			$this->title->SetDbValueDef($rsnew, $this->title->CurrentValue, NULL, $this->title->ReadOnly);

			// price
			$this->price->SetDbValueDef($rsnew, $this->price->CurrentValue, NULL, $this->price->ReadOnly);

			// thumbnail
			if (!($this->thumbnail->ReadOnly)) {
			$this->thumbnail->UploadPath = '../assets/images/accessory/';
			if ($this->thumbnail->Upload->Action == "1") { // Keep
			} elseif ($this->thumbnail->Upload->Action == "2" || $this->thumbnail->Upload->Action == "3") { // Update/Remove
			$this->thumbnail->Upload->DbValue = $rs->fields('thumbnail'); // Get original value
			if (is_null($this->thumbnail->Upload->Value)) {
				$rsnew['thumbnail'] = NULL;
			} else {
				if ($this->thumbnail->Upload->FileName == $this->thumbnail->Upload->DbValue) { // Upload file name same as old file name
					$rsnew['thumbnail'] = $this->thumbnail->Upload->FileName;
				} else {
					$rsnew['thumbnail'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->thumbnail->UploadPath), $this->thumbnail->Upload->FileName);
				}
			}
			}
			}

			// short_des
			$this->short_des->SetDbValueDef($rsnew, $this->short_des->CurrentValue, NULL, $this->short_des->ReadOnly);

			// long_des
			$this->long_des->SetDbValueDef($rsnew, $this->long_des->CurrentValue, NULL, $this->long_des->ReadOnly);

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, 0, $this->status->ReadOnly);

			// model_id
			$this->model_id->SetDbValueDef($rsnew, $this->model_id->CurrentValue, 0, $this->model_id->ReadOnly);

			// type
			$this->type->SetDbValueDef($rsnew, $this->type->CurrentValue, 0, $this->type->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				if (!ew_Empty($this->thumbnail->Upload->Value)) {
					if ($this->thumbnail->Upload->FileName == $this->thumbnail->Upload->DbValue) { // Overwrite if same file name
						$this->thumbnail->Upload->SaveToFile($this->thumbnail->UploadPath, $rsnew['thumbnail'], TRUE);
						$this->thumbnail->Upload->DbValue = ""; // No need to delete any more
					} else {
						$this->thumbnail->Upload->SaveToFile($this->thumbnail->UploadPath, $rsnew['thumbnail'], FALSE);
					}
				}
				if ($this->thumbnail->Upload->Action == "2" || $this->thumbnail->Upload->Action == "3") { // Update/Remove
					if ($this->thumbnail->Upload->DbValue <> "")
						@unlink(ew_UploadPathEx(TRUE, $this->thumbnail->UploadPath) . $this->thumbnail->Upload->DbValue);
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

		// thumbnail
		$this->thumbnail->Upload->RemoveFromSession(); // Remove file value from Session
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
if (!isset($accessory_edit)) $accessory_edit = new caccessory_edit();

// Page init
$accessory_edit->Page_Init();

// Page main
$accessory_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var accessory_edit = new ew_Page("accessory_edit");
accessory_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = accessory_edit.PageID; // For backward compatibility

// Form object
var faccessoryedit = new ew_Form("faccessoryedit");

// Validate form
faccessoryedit.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_title"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($accessory->title->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_thumbnail"];
		aelm = fobj.elements["a" + infix + "_thumbnail"];
		var chk_thumbnail = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_thumbnail && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($accessory->thumbnail->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_thumbnail"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_status"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($accessory->status->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_type"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($accessory->type->FldCaption()) ?>");

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
faccessoryedit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
faccessoryedit.ValidateRequired = true;
<?php } else { ?>
faccessoryedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
faccessoryedit.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $accessory->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $accessory->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $accessory_edit->ShowPageHeader(); ?>
<?php
$accessory_edit->ShowMessage();
?>
<form name="faccessoryedit" id="faccessoryedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" enctype="multipart/form-data" onsubmit="return ewForms[this.id].Submit();">
<p>
<input type="hidden" name="t" value="accessory">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_accessoryedit" class="ewTable">
<?php if ($accessory->acs_id->Visible) { // acs_id ?>
	<tr id="r_acs_id"<?php echo $accessory->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_accessory_acs_id"><?php echo $accessory->acs_id->FldCaption() ?></span></td>
		<td<?php echo $accessory->acs_id->CellAttributes() ?>><span id="el_accessory_acs_id">
<span<?php echo $accessory->acs_id->ViewAttributes() ?>>
<?php echo $accessory->acs_id->EditValue ?></span>
<input type="hidden" name="x_acs_id" id="x_acs_id" value="<?php echo ew_HtmlEncode($accessory->acs_id->CurrentValue) ?>">
</span><?php echo $accessory->acs_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($accessory->title->Visible) { // title ?>
	<tr id="r_title"<?php echo $accessory->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_accessory_title"><?php echo $accessory->title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $accessory->title->CellAttributes() ?>><span id="el_accessory_title">
<input type="text" name="x_title" id="x_title" size="30" maxlength="100" value="<?php echo $accessory->title->EditValue ?>"<?php echo $accessory->title->EditAttributes() ?>>
</span><?php echo $accessory->title->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($accessory->price->Visible) { // price ?>
	<tr id="r_price"<?php echo $accessory->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_accessory_price"><?php echo $accessory->price->FldCaption() ?></span></td>
		<td<?php echo $accessory->price->CellAttributes() ?>><span id="el_accessory_price">
<input type="text" name="x_price" id="x_price" size="30" maxlength="100" value="<?php echo $accessory->price->EditValue ?>"<?php echo $accessory->price->EditAttributes() ?>>
</span><?php echo $accessory->price->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($accessory->thumbnail->Visible) { // thumbnail ?>
	<tr id="r_thumbnail"<?php echo $accessory->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_accessory_thumbnail"><?php echo $accessory->thumbnail->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $accessory->thumbnail->CellAttributes() ?>><span id="el_accessory_thumbnail">
<div id="old_x_thumbnail">
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
</div>
<div id="new_x_thumbnail">
<?php if ($accessory->thumbnail->ReadOnly) { ?>
<?php if (!empty($accessory->thumbnail->Upload->DbValue)) { ?>
<input type="hidden" name="a_thumbnail" id="a_thumbnail" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($accessory->thumbnail->Upload->DbValue)) { ?>
<label><input type="radio" name="a_thumbnail" id="a_thumbnail" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_thumbnail" id="a_thumbnail" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_thumbnail" id="a_thumbnail" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $accessory->thumbnail->EditAttrs["onchange"] = "this.form.a_thumbnail[2].checked=true;" . @$accessory->thumbnail->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_thumbnail" id="a_thumbnail" value="3">
<?php } ?>
<input type="file" name="x_thumbnail" id="x_thumbnail" size="30"<?php echo $accessory->thumbnail->EditAttributes() ?>>
<?php } ?>
</div>
</span><?php echo $accessory->thumbnail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($accessory->short_des->Visible) { // short_des ?>
	<tr id="r_short_des"<?php echo $accessory->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_accessory_short_des"><?php echo $accessory->short_des->FldCaption() ?></span></td>
		<td<?php echo $accessory->short_des->CellAttributes() ?>><span id="el_accessory_short_des">
<textarea name="x_short_des" id="x_short_des" cols="35" rows="4"<?php echo $accessory->short_des->EditAttributes() ?>><?php echo $accessory->short_des->EditValue ?></textarea>
</span><?php echo $accessory->short_des->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($accessory->long_des->Visible) { // long_des ?>
	<tr id="r_long_des"<?php echo $accessory->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_accessory_long_des"><?php echo $accessory->long_des->FldCaption() ?></span></td>
		<td<?php echo $accessory->long_des->CellAttributes() ?>><span id="el_accessory_long_des">
<textarea name="x_long_des" id="x_long_des" cols="50" rows="6"<?php echo $accessory->long_des->EditAttributes() ?>><?php echo $accessory->long_des->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("faccessoryedit", "x_long_des", 50, 6, <?php echo ($accessory->long_des->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $accessory->long_des->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($accessory->status->Visible) { // status ?>
	<tr id="r_status"<?php echo $accessory->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_accessory_status"><?php echo $accessory->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $accessory->status->CellAttributes() ?>><span id="el_accessory_status">
<select id="x_status" name="x_status"<?php echo $accessory->status->EditAttributes() ?>>
<?php
if (is_array($accessory->status->EditValue)) {
	$arwrk = $accessory->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($accessory->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $accessory->status->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($accessory->model_id->Visible) { // model_id ?>
	<tr id="r_model_id"<?php echo $accessory->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_accessory_model_id"><?php echo $accessory->model_id->FldCaption() ?></span></td>
		<td<?php echo $accessory->model_id->CellAttributes() ?>><span id="el_accessory_model_id">
<select id="x_model_id" name="x_model_id"<?php echo $accessory->model_id->EditAttributes() ?>>
<?php
if (is_array($accessory->model_id->EditValue)) {
	$arwrk = $accessory->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($accessory->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
<script type="text/javascript">
faccessoryedit.Lists["x_model_id"].Options = <?php echo (is_array($accessory->model_id->EditValue)) ? ew_ArrayToJson($accessory->model_id->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $accessory->model_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($accessory->type->Visible) { // type ?>
	<tr id="r_type"<?php echo $accessory->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_accessory_type"><?php echo $accessory->type->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $accessory->type->CellAttributes() ?>><span id="el_accessory_type">
<select id="x_type" name="x_type"<?php echo $accessory->type->EditAttributes() ?>>
<?php
if (is_array($accessory->type->EditValue)) {
	$arwrk = $accessory->type->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($accessory->type->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $accessory->type->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
faccessoryedit.Init();
</script>
<?php
$accessory_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$accessory_edit->Page_Terminate();
?>
