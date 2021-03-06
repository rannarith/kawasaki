<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "model_colorinfo.php" ?>
<?php include_once "modelinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$model_color_edit = NULL; // Initialize page object first

class cmodel_color_edit extends cmodel_color {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'model_color';

	// Page object name
	var $PageObjName = 'model_color_edit';

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

		// Table object (model_color)
		if (!isset($GLOBALS["model_color"])) {
			$GLOBALS["model_color"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["model_color"];
		}

		// Table object (model)
		if (!isset($GLOBALS['model'])) $GLOBALS['model'] = new cmodel();

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'model_color', TRUE);

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
		$this->mc_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		if (@$_GET["mc_id"] <> "")
			$this->mc_id->setQueryStringValue($_GET["mc_id"]);

		// Set up master detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->mc_id->CurrentValue == "")
			$this->Page_Terminate("model_colorlist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("model_colorlist.php"); // No matching record, return to list
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
		$this->image->Upload->Index = $objForm->Index;
		$this->image->Upload->RestoreDbFromSession();
		if ($confirmPage) { // Post from confirm page
			$this->image->Upload->RestoreFromSession();
		} else {
			if ($this->image->Upload->UploadFile()) {

				// No action required
			} else {
				echo $this->image->Upload->Message;
				$this->Page_Terminate();
				exit();
			}
			$this->image->Upload->SaveToSession();
			$this->image->CurrentValue = $this->image->Upload->FileName;
		}
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->mc_id->FldIsDetailKey)
			$this->mc_id->setFormValue($objForm->GetValue("x_mc_id"));
		if (!$this->model_id->FldIsDetailKey) {
			$this->model_id->setFormValue($objForm->GetValue("x_model_id"));
		}
		if (!$this->color_code->FldIsDetailKey) {
			$this->color_code->setFormValue($objForm->GetValue("x_color_code"));
		}
		if (!$this->m_order->FldIsDetailKey) {
			$this->m_order->setFormValue($objForm->GetValue("x_m_order"));
		}
		if (!$this->m_status->FldIsDetailKey) {
			$this->m_status->setFormValue($objForm->GetValue("x_m_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->mc_id->CurrentValue = $this->mc_id->FormValue;
		$this->model_id->CurrentValue = $this->model_id->FormValue;
		$this->color_code->CurrentValue = $this->color_code->FormValue;
		$this->m_order->CurrentValue = $this->m_order->FormValue;
		$this->m_status->CurrentValue = $this->m_status->FormValue;
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
		$this->mc_id->setDbValue($rs->fields('mc_id'));
		$this->image->Upload->DbValue = $rs->fields('image');
		$this->model_id->setDbValue($rs->fields('model_id'));
		$this->color_code->setDbValue($rs->fields('color_code'));
		$this->m_order->setDbValue($rs->fields('m_order'));
		$this->m_status->setDbValue($rs->fields('m_status'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// mc_id
		// image
		// model_id
		// color_code
		// m_order
		// m_status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// mc_id
			$this->mc_id->ViewValue = $this->mc_id->CurrentValue;
			$this->mc_id->ViewCustomAttributes = "";

			// image
			$this->image->UploadPath = '../assets/images/model_color/';
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->ViewValue = $this->image->Upload->DbValue;
				$this->image->ImageWidth = 200;
				$this->image->ImageHeight = 0;
				$this->image->ImageAlt = $this->image->FldAlt();
			} else {
				$this->image->ViewValue = "";
			}
			$this->image->ViewCustomAttributes = "";

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

			// color_code
			$this->color_code->ViewValue = $this->color_code->CurrentValue;
			$this->color_code->ViewCustomAttributes = "";

			// m_order
			$this->m_order->ViewValue = $this->m_order->CurrentValue;
			$this->m_order->ViewCustomAttributes = "";

			// m_status
			if (strval($this->m_status->CurrentValue) <> "") {
				switch ($this->m_status->CurrentValue) {
					case $this->m_status->FldTagValue(1):
						$this->m_status->ViewValue = $this->m_status->FldTagCaption(1) <> "" ? $this->m_status->FldTagCaption(1) : $this->m_status->CurrentValue;
						break;
					case $this->m_status->FldTagValue(2):
						$this->m_status->ViewValue = $this->m_status->FldTagCaption(2) <> "" ? $this->m_status->FldTagCaption(2) : $this->m_status->CurrentValue;
						break;
					default:
						$this->m_status->ViewValue = $this->m_status->CurrentValue;
				}
			} else {
				$this->m_status->ViewValue = NULL;
			}
			$this->m_status->ViewCustomAttributes = "";

			// mc_id
			$this->mc_id->LinkCustomAttributes = "";
			$this->mc_id->HrefValue = "";
			$this->mc_id->TooltipValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";
			$this->image->TooltipValue = "";

			// model_id
			$this->model_id->LinkCustomAttributes = "";
			$this->model_id->HrefValue = "";
			$this->model_id->TooltipValue = "";

			// color_code
			$this->color_code->LinkCustomAttributes = "";
			$this->color_code->HrefValue = "";
			$this->color_code->TooltipValue = "";

			// m_order
			$this->m_order->LinkCustomAttributes = "";
			$this->m_order->HrefValue = "";
			$this->m_order->TooltipValue = "";

			// m_status
			$this->m_status->LinkCustomAttributes = "";
			$this->m_status->HrefValue = "";
			$this->m_status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// mc_id
			$this->mc_id->EditCustomAttributes = "";
			$this->mc_id->EditValue = $this->mc_id->CurrentValue;
			$this->mc_id->ViewCustomAttributes = "";

			// image
			$this->image->EditCustomAttributes = "";
			$this->image->UploadPath = '../assets/images/model_color/';
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->EditValue = $this->image->Upload->DbValue;
				$this->image->ImageWidth = 200;
				$this->image->ImageHeight = 0;
				$this->image->ImageAlt = $this->image->FldAlt();
			} else {
				$this->image->EditValue = "";
			}

			// model_id
			$this->model_id->EditCustomAttributes = "";
			if ($this->model_id->getSessionValue() <> "") {
				$this->model_id->CurrentValue = $this->model_id->getSessionValue();
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
			} else {
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
			}

			// color_code
			$this->color_code->EditCustomAttributes = "";
			$this->color_code->EditValue = ew_HtmlEncode($this->color_code->CurrentValue);

			// m_order
			$this->m_order->EditCustomAttributes = "";
			$this->m_order->EditValue = ew_HtmlEncode($this->m_order->CurrentValue);

			// m_status
			$this->m_status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->m_status->FldTagValue(1), $this->m_status->FldTagCaption(1) <> "" ? $this->m_status->FldTagCaption(1) : $this->m_status->FldTagValue(1));
			$arwrk[] = array($this->m_status->FldTagValue(2), $this->m_status->FldTagCaption(2) <> "" ? $this->m_status->FldTagCaption(2) : $this->m_status->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->m_status->EditValue = $arwrk;

			// Edit refer script
			// mc_id

			$this->mc_id->HrefValue = "";

			// image
			$this->image->HrefValue = "";

			// model_id
			$this->model_id->HrefValue = "";

			// color_code
			$this->color_code->HrefValue = "";

			// m_order
			$this->m_order->HrefValue = "";

			// m_status
			$this->m_status->HrefValue = "";
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
		if (!ew_CheckFileType($this->image->Upload->FileName)) {
			ew_AddMessage($gsFormError, $Language->Phrase("WrongFileType"));
		}
		if ($this->image->Upload->FileSize > 0 && EW_MAX_FILE_SIZE > 0 && $this->image->Upload->FileSize > EW_MAX_FILE_SIZE) {
			ew_AddMessage($gsFormError, str_replace("%s", EW_MAX_FILE_SIZE, $Language->Phrase("MaxFileSize")));
		}
		if (in_array($this->image->Upload->Error, array(1, 2, 3, 6, 7, 8))) {
			ew_AddMessage($gsFormError, $Language->Phrase("PhpUploadErr" . $this->image->Upload->Error));
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->image->Upload->Action == "3" && is_null($this->image->Upload->Value)) {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->image->FldCaption());
		}
		if (!is_null($this->model_id->FormValue) && $this->model_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->model_id->FldCaption());
		}
		if (!is_null($this->color_code->FormValue) && $this->color_code->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->color_code->FldCaption());
		}
		if (!is_null($this->m_order->FormValue) && $this->m_order->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->m_order->FldCaption());
		}
		if (!ew_CheckInteger($this->m_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->m_order->FldErrMsg());
		}
		if (!is_null($this->m_status->FormValue) && $this->m_status->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->m_status->FldCaption());
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

			// image
			if (!($this->image->ReadOnly)) {
			$this->image->UploadPath = '../assets/images/model_color/';
			if ($this->image->Upload->Action == "1") { // Keep
			} elseif ($this->image->Upload->Action == "2" || $this->image->Upload->Action == "3") { // Update/Remove
			$this->image->Upload->DbValue = $rs->fields('image'); // Get original value
			if (is_null($this->image->Upload->Value)) {
				$rsnew['image'] = NULL;
			} else {
				if ($this->image->Upload->FileName == $this->image->Upload->DbValue) { // Upload file name same as old file name
					$rsnew['image'] = $this->image->Upload->FileName;
				} else {
					$rsnew['image'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->image->UploadPath), $this->image->Upload->FileName);
				}
			}
			}
			}

			// model_id
			$this->model_id->SetDbValueDef($rsnew, $this->model_id->CurrentValue, 0, $this->model_id->ReadOnly);

			// color_code
			$this->color_code->SetDbValueDef($rsnew, $this->color_code->CurrentValue, NULL, $this->color_code->ReadOnly);

			// m_order
			$this->m_order->SetDbValueDef($rsnew, $this->m_order->CurrentValue, 0, $this->m_order->ReadOnly);

			// m_status
			$this->m_status->SetDbValueDef($rsnew, $this->m_status->CurrentValue, 0, $this->m_status->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				if (!ew_Empty($this->image->Upload->Value)) {
					if ($this->image->Upload->FileName == $this->image->Upload->DbValue) { // Overwrite if same file name
						$this->image->Upload->SaveToFile($this->image->UploadPath, $rsnew['image'], TRUE);
						$this->image->Upload->DbValue = ""; // No need to delete any more
					} else {
						$this->image->Upload->SaveToFile($this->image->UploadPath, $rsnew['image'], FALSE);
					}
				}
				if ($this->image->Upload->Action == "2" || $this->image->Upload->Action == "3") { // Update/Remove
					if ($this->image->Upload->DbValue <> "")
						@unlink(ew_UploadPathEx(TRUE, $this->image->UploadPath) . $this->image->Upload->DbValue);
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

		// image
		$this->image->Upload->RemoveFromSession(); // Remove file value from Session
		return $EditRow;
	}

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (@$_GET[EW_TABLE_SHOW_MASTER] <> "") {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "model") {
				$bValidMaster = TRUE;
				if (@$_GET["model_id"] <> "") {
					$GLOBALS["model"]->model_id->setQueryStringValue($_GET["model_id"]);
					$this->model_id->setQueryStringValue($GLOBALS["model"]->model_id->QueryStringValue);
					$this->model_id->setSessionValue($this->model_id->QueryStringValue);
					if (!is_numeric($GLOBALS["model"]->model_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "model") {
				if ($this->model_id->QueryStringValue == "") $this->model_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); //  Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
if (!isset($model_color_edit)) $model_color_edit = new cmodel_color_edit();

// Page init
$model_color_edit->Page_Init();

// Page main
$model_color_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var model_color_edit = new ew_Page("model_color_edit");
model_color_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = model_color_edit.PageID; // For backward compatibility

// Form object
var fmodel_coloredit = new ew_Form("fmodel_coloredit");

// Validate form
fmodel_coloredit.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_image"];
		aelm = fobj.elements["a" + infix + "_image"];
		var chk_image = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_image && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model_color->image->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_image"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_model_id"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model_color->model_id->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_color_code"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model_color->color_code->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_m_order"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model_color->m_order->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_m_order"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($model_color->m_order->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_m_status"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model_color->m_status->FldCaption()) ?>");

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
fmodel_coloredit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmodel_coloredit.ValidateRequired = true;
<?php } else { ?>
fmodel_coloredit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmodel_coloredit.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $model_color->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $model_color->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $model_color_edit->ShowPageHeader(); ?>
<?php
$model_color_edit->ShowMessage();
?>
<form name="fmodel_coloredit" id="fmodel_coloredit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" enctype="multipart/form-data" onsubmit="return ewForms[this.id].Submit();">
<p>
<input type="hidden" name="t" value="model_color">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_model_coloredit" class="ewTable">
<?php if ($model_color->mc_id->Visible) { // mc_id ?>
	<tr id="r_mc_id"<?php echo $model_color->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_color_mc_id"><?php echo $model_color->mc_id->FldCaption() ?></span></td>
		<td<?php echo $model_color->mc_id->CellAttributes() ?>><span id="el_model_color_mc_id">
<span<?php echo $model_color->mc_id->ViewAttributes() ?>>
<?php echo $model_color->mc_id->EditValue ?></span>
<input type="hidden" name="x_mc_id" id="x_mc_id" value="<?php echo ew_HtmlEncode($model_color->mc_id->CurrentValue) ?>">
</span><?php echo $model_color->mc_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model_color->image->Visible) { // image ?>
	<tr id="r_image"<?php echo $model_color->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_color_image"><?php echo $model_color->image->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $model_color->image->CellAttributes() ?>><span id="el_model_color_image">
<div id="old_x_image">
<?php if ($model_color->image->LinkAttributes() <> "") { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_color->image->UploadPath) . $model_color->image->Upload->DbValue ?>" border="0"<?php echo $model_color->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_color->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_color->image->UploadPath) . $model_color->image->Upload->DbValue ?>" border="0"<?php echo $model_color->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_color->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x_image">
<?php if ($model_color->image->ReadOnly) { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<input type="hidden" name="a_image" id="a_image" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<label><input type="radio" name="a_image" id="a_image" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_image" id="a_image" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_image" id="a_image" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $model_color->image->EditAttrs["onchange"] = "this.form.a_image[2].checked=true;" . @$model_color->image->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_image" id="a_image" value="3">
<?php } ?>
<input type="file" name="x_image" id="x_image" size="30"<?php echo $model_color->image->EditAttributes() ?>>
<?php } ?>
</div>
</span><?php echo $model_color->image->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model_color->model_id->Visible) { // model_id ?>
	<tr id="r_model_id"<?php echo $model_color->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_color_model_id"><?php echo $model_color->model_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $model_color->model_id->CellAttributes() ?>><span id="el_model_color_model_id">
<?php if ($model_color->model_id->getSessionValue() <> "") { ?>
<span<?php echo $model_color->model_id->ViewAttributes() ?>>
<?php echo $model_color->model_id->ViewValue ?></span>
<input type="hidden" id="x_model_id" name="x_model_id" value="<?php echo ew_HtmlEncode($model_color->model_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x_model_id" name="x_model_id"<?php echo $model_color->model_id->EditAttributes() ?>>
<?php
if (is_array($model_color->model_id->EditValue)) {
	$arwrk = $model_color->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model_color->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fmodel_coloredit.Lists["x_model_id"].Options = <?php echo (is_array($model_color->model_id->EditValue)) ? ew_ArrayToJson($model_color->model_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
</span><?php echo $model_color->model_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model_color->color_code->Visible) { // color_code ?>
	<tr id="r_color_code"<?php echo $model_color->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_color_color_code"><?php echo $model_color->color_code->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $model_color->color_code->CellAttributes() ?>><span id="el_model_color_color_code">
<input type="text" name="x_color_code" id="x_color_code" size="30" maxlength="30" value="<?php echo $model_color->color_code->EditValue ?>"<?php echo $model_color->color_code->EditAttributes() ?>>
</span><?php echo $model_color->color_code->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model_color->m_order->Visible) { // m_order ?>
	<tr id="r_m_order"<?php echo $model_color->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_color_m_order"><?php echo $model_color->m_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $model_color->m_order->CellAttributes() ?>><span id="el_model_color_m_order">
<input type="text" name="x_m_order" id="x_m_order" size="30" value="<?php echo $model_color->m_order->EditValue ?>"<?php echo $model_color->m_order->EditAttributes() ?>>
</span><?php echo $model_color->m_order->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model_color->m_status->Visible) { // m_status ?>
	<tr id="r_m_status"<?php echo $model_color->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_color_m_status"><?php echo $model_color->m_status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $model_color->m_status->CellAttributes() ?>><span id="el_model_color_m_status">
<select id="x_m_status" name="x_m_status"<?php echo $model_color->m_status->EditAttributes() ?>>
<?php
if (is_array($model_color->m_status->EditValue)) {
	$arwrk = $model_color->m_status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model_color->m_status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $model_color->m_status->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
fmodel_coloredit.Init();
</script>
<?php
$model_color_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$model_color_edit->Page_Terminate();
?>
