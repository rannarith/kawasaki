<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "featureinfo.php" ?>
<?php include_once "modelinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$feature_add = NULL; // Initialize page object first

class cfeature_add extends cfeature {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'feature';

	// Page object name
	var $PageObjName = 'feature_add';

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

		// Table object (feature)
		if (!isset($GLOBALS["feature"])) {
			$GLOBALS["feature"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["feature"];
		}

		// Table object (model)
		if (!isset($GLOBALS['model'])) $GLOBALS['model'] = new cmodel();

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'feature', TRUE);

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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Set up master/detail parameters
		$this->SetUpMasterParms();

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["feature_id"] != "") {
				$this->feature_id->setQueryStringValue($_GET["feature_id"]);
				$this->setKey("feature_id", $this->feature_id->CurrentValue); // Set up key
			} else {
				$this->setKey("feature_id", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("featurelist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "featureview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
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

	// Load default values
	function LoadDefaultValues() {
		$this->top_title->CurrentValue = NULL;
		$this->top_title->OldValue = $this->top_title->CurrentValue;
		$this->title->CurrentValue = NULL;
		$this->title->OldValue = $this->title->CurrentValue;
		$this->model_id->CurrentValue = NULL;
		$this->model_id->OldValue = $this->model_id->CurrentValue;
		$this->thumbnail->Upload->DbValue = NULL;
		$this->thumbnail->OldValue = $this->thumbnail->Upload->DbValue;
		$this->thumbnail->CurrentValue = NULL; // Clear file related field
		$this->long_des->CurrentValue = NULL;
		$this->long_des->OldValue = $this->long_des->CurrentValue;
		$this->f_order->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->top_title->FldIsDetailKey) {
			$this->top_title->setFormValue($objForm->GetValue("x_top_title"));
		}
		if (!$this->title->FldIsDetailKey) {
			$this->title->setFormValue($objForm->GetValue("x_title"));
		}
		if (!$this->model_id->FldIsDetailKey) {
			$this->model_id->setFormValue($objForm->GetValue("x_model_id"));
		}
		if (!$this->long_des->FldIsDetailKey) {
			$this->long_des->setFormValue($objForm->GetValue("x_long_des"));
		}
		if (!$this->f_order->FldIsDetailKey) {
			$this->f_order->setFormValue($objForm->GetValue("x_f_order"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->top_title->CurrentValue = $this->top_title->FormValue;
		$this->title->CurrentValue = $this->title->FormValue;
		$this->model_id->CurrentValue = $this->model_id->FormValue;
		$this->long_des->CurrentValue = $this->long_des->FormValue;
		$this->f_order->CurrentValue = $this->f_order->FormValue;
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
		$this->feature_id->setDbValue($rs->fields('feature_id'));
		$this->top_title->setDbValue($rs->fields('top_title'));
		$this->title->setDbValue($rs->fields('title'));
		$this->model_id->setDbValue($rs->fields('model_id'));
		$this->thumbnail->Upload->DbValue = $rs->fields('thumbnail');
		$this->long_des->setDbValue($rs->fields('long_des'));
		$this->f_order->setDbValue($rs->fields('f_order'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("feature_id")) <> "")
			$this->feature_id->CurrentValue = $this->getKey("feature_id"); // feature_id
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$this->OldRecordset = ew_LoadRecordset($sSql);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// feature_id
		// top_title
		// title
		// model_id
		// thumbnail
		// long_des
		// f_order

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// feature_id
			$this->feature_id->ViewValue = $this->feature_id->CurrentValue;
			$this->feature_id->ViewCustomAttributes = "";

			// top_title
			$this->top_title->ViewValue = $this->top_title->CurrentValue;
			$this->top_title->ViewCustomAttributes = "";

			// title
			$this->title->ViewValue = $this->title->CurrentValue;
			$this->title->ViewCustomAttributes = "";

			// model_id
			if (strval($this->model_id->CurrentValue) <> "") {
				$sFilterWrk = "`model_id`" . ew_SearchString("=", $this->model_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `model_id`, `model_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `model`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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

			// thumbnail
			$this->thumbnail->UploadPath = '../assets/images/feature/';
			if (!ew_Empty($this->thumbnail->Upload->DbValue)) {
				$this->thumbnail->ViewValue = $this->thumbnail->Upload->DbValue;
				$this->thumbnail->ImageWidth = 300;
				$this->thumbnail->ImageHeight = 0;
				$this->thumbnail->ImageAlt = $this->thumbnail->FldAlt();
			} else {
				$this->thumbnail->ViewValue = "";
			}
			$this->thumbnail->ViewCustomAttributes = "";

			// long_des
			$this->long_des->ViewValue = $this->long_des->CurrentValue;
			$this->long_des->ViewCustomAttributes = "";

			// f_order
			$this->f_order->ViewValue = $this->f_order->CurrentValue;
			$this->f_order->ViewCustomAttributes = "";

			// top_title
			$this->top_title->LinkCustomAttributes = "";
			$this->top_title->HrefValue = "";
			$this->top_title->TooltipValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// model_id
			$this->model_id->LinkCustomAttributes = "";
			$this->model_id->HrefValue = "";
			$this->model_id->TooltipValue = "";

			// thumbnail
			$this->thumbnail->LinkCustomAttributes = "";
			$this->thumbnail->HrefValue = "";
			$this->thumbnail->TooltipValue = "";

			// long_des
			$this->long_des->LinkCustomAttributes = "";
			$this->long_des->HrefValue = "";
			$this->long_des->TooltipValue = "";

			// f_order
			$this->f_order->LinkCustomAttributes = "";
			$this->f_order->HrefValue = "";
			$this->f_order->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// top_title
			$this->top_title->EditCustomAttributes = "";
			$this->top_title->EditValue = ew_HtmlEncode($this->top_title->CurrentValue);

			// title
			$this->title->EditCustomAttributes = "";
			$this->title->EditValue = ew_HtmlEncode($this->title->CurrentValue);

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
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->model_id->EditValue = $arwrk;
			}

			// thumbnail
			$this->thumbnail->EditCustomAttributes = "";
			$this->thumbnail->UploadPath = '../assets/images/feature/';
			if (!ew_Empty($this->thumbnail->Upload->DbValue)) {
				$this->thumbnail->EditValue = $this->thumbnail->Upload->DbValue;
				$this->thumbnail->ImageWidth = 300;
				$this->thumbnail->ImageHeight = 0;
				$this->thumbnail->ImageAlt = $this->thumbnail->FldAlt();
			} else {
				$this->thumbnail->EditValue = "";
			}

			// long_des
			$this->long_des->EditCustomAttributes = "";
			$this->long_des->EditValue = ew_HtmlEncode($this->long_des->CurrentValue);

			// f_order
			$this->f_order->EditCustomAttributes = "";
			$this->f_order->EditValue = ew_HtmlEncode($this->f_order->CurrentValue);

			// Edit refer script
			// top_title

			$this->top_title->HrefValue = "";

			// title
			$this->title->HrefValue = "";

			// model_id
			$this->model_id->HrefValue = "";

			// thumbnail
			$this->thumbnail->HrefValue = "";

			// long_des
			$this->long_des->HrefValue = "";

			// f_order
			$this->f_order->HrefValue = "";
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
		if (!is_null($this->top_title->FormValue) && $this->top_title->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->top_title->FldCaption());
		}
		if (!is_null($this->title->FormValue) && $this->title->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->title->FldCaption());
		}
		if (!is_null($this->model_id->FormValue) && $this->model_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->model_id->FldCaption());
		}
		if ($this->thumbnail->Upload->Action == "3" && is_null($this->thumbnail->Upload->Value)) {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->thumbnail->FldCaption());
		}
		if (!is_null($this->f_order->FormValue) && $this->f_order->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->f_order->FldCaption());
		}
		if (!ew_CheckInteger($this->f_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->f_order->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;
		$rsnew = array();

		// top_title
		$this->top_title->SetDbValueDef($rsnew, $this->top_title->CurrentValue, NULL, FALSE);

		// title
		$this->title->SetDbValueDef($rsnew, $this->title->CurrentValue, NULL, FALSE);

		// model_id
		$this->model_id->SetDbValueDef($rsnew, $this->model_id->CurrentValue, 0, FALSE);

		// thumbnail
		$this->thumbnail->UploadPath = '../assets/images/feature/';
		if ($this->thumbnail->Upload->Action == "1") { // Keep
			if ($rsold) {
				$rsnew['thumbnail'] = $rsold->fields['thumbnail'];
			}
		} elseif ($this->thumbnail->Upload->Action == "2" || $this->thumbnail->Upload->Action == "3") { // Update/Remove
		if (is_null($this->thumbnail->Upload->Value)) {
			$rsnew['thumbnail'] = NULL;
		} else {
			$rsnew['thumbnail'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->thumbnail->UploadPath), $this->thumbnail->Upload->FileName);
		}
		}

		// long_des
		$this->long_des->SetDbValueDef($rsnew, $this->long_des->CurrentValue, NULL, FALSE);

		// f_order
		$this->f_order->SetDbValueDef($rsnew, $this->f_order->CurrentValue, 0, strval($this->f_order->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
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
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}

		// Get insert id if necessary
		if ($AddRow) {
			$this->feature_id->setDbValue($conn->Insert_ID());
			$rsnew['feature_id'] = $this->feature_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}

		// thumbnail
		$this->thumbnail->Upload->RemoveFromSession(); // Remove file value from Session
		return $AddRow;
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
if (!isset($feature_add)) $feature_add = new cfeature_add();

// Page init
$feature_add->Page_Init();

// Page main
$feature_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var feature_add = new ew_Page("feature_add");
feature_add.PageID = "add"; // Page ID
var EW_PAGE_ID = feature_add.PageID; // For backward compatibility

// Form object
var ffeatureadd = new ew_Form("ffeatureadd");

// Validate form
ffeatureadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_top_title"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($feature->top_title->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_title"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($feature->title->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_model_id"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($feature->model_id->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_thumbnail"];
		aelm = fobj.elements["a" + infix + "_thumbnail"];
		var chk_thumbnail = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_thumbnail && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($feature->thumbnail->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_thumbnail"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_f_order"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($feature->f_order->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_f_order"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($feature->f_order->FldErrMsg()) ?>");

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
ffeatureadd.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ffeatureadd.ValidateRequired = true;
<?php } else { ?>
ffeatureadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ffeatureadd.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $feature->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $feature->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $feature_add->ShowPageHeader(); ?>
<?php
$feature_add->ShowMessage();
?>
<form name="ffeatureadd" id="ffeatureadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" enctype="multipart/form-data" onsubmit="return ewForms[this.id].Submit();">
<p>
<input type="hidden" name="t" value="feature">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_featureadd" class="ewTable">
<?php if ($feature->top_title->Visible) { // top_title ?>
	<tr id="r_top_title"<?php echo $feature->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_feature_top_title"><?php echo $feature->top_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $feature->top_title->CellAttributes() ?>><span id="el_feature_top_title">
<input type="text" name="x_top_title" id="x_top_title" size="30" maxlength="150" value="<?php echo $feature->top_title->EditValue ?>"<?php echo $feature->top_title->EditAttributes() ?>>
</span><?php echo $feature->top_title->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($feature->title->Visible) { // title ?>
	<tr id="r_title"<?php echo $feature->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_feature_title"><?php echo $feature->title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $feature->title->CellAttributes() ?>><span id="el_feature_title">
<input type="text" name="x_title" id="x_title" size="30" maxlength="50" value="<?php echo $feature->title->EditValue ?>"<?php echo $feature->title->EditAttributes() ?>>
</span><?php echo $feature->title->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($feature->model_id->Visible) { // model_id ?>
	<tr id="r_model_id"<?php echo $feature->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_feature_model_id"><?php echo $feature->model_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $feature->model_id->CellAttributes() ?>><span id="el_feature_model_id">
<?php if ($feature->model_id->getSessionValue() <> "") { ?>
<span<?php echo $feature->model_id->ViewAttributes() ?>>
<?php echo $feature->model_id->ViewValue ?></span>
<input type="hidden" id="x_model_id" name="x_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x_model_id" name="x_model_id"<?php echo $feature->model_id->EditAttributes() ?>>
<?php
if (is_array($feature->model_id->EditValue)) {
	$arwrk = $feature->model_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($feature->model_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
ffeatureadd.Lists["x_model_id"].Options = <?php echo (is_array($feature->model_id->EditValue)) ? ew_ArrayToJson($feature->model_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
</span><?php echo $feature->model_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($feature->thumbnail->Visible) { // thumbnail ?>
	<tr id="r_thumbnail"<?php echo $feature->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_feature_thumbnail"><?php echo $feature->thumbnail->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $feature->thumbnail->CellAttributes() ?>><span id="el_feature_thumbnail">
<div id="old_x_thumbnail">
<?php if ($feature->thumbnail->LinkAttributes() <> "") { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $feature->thumbnail->UploadPath) . $feature->thumbnail->Upload->DbValue ?>" border="0"<?php echo $feature->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($feature->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $feature->thumbnail->UploadPath) . $feature->thumbnail->Upload->DbValue ?>" border="0"<?php echo $feature->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($feature->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x_thumbnail">
<?php if ($feature->thumbnail->ReadOnly) { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<input type="hidden" name="a_thumbnail" id="a_thumbnail" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($feature->thumbnail->Upload->DbValue)) { ?>
<label><input type="radio" name="a_thumbnail" id="a_thumbnail" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_thumbnail" id="a_thumbnail" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_thumbnail" id="a_thumbnail" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $feature->thumbnail->EditAttrs["onchange"] = "this.form.a_thumbnail[2].checked=true;" . @$feature->thumbnail->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_thumbnail" id="a_thumbnail" value="3">
<?php } ?>
<input type="file" name="x_thumbnail" id="x_thumbnail" size="30"<?php echo $feature->thumbnail->EditAttributes() ?>>
<?php } ?>
</div>
</span><?php echo $feature->thumbnail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($feature->long_des->Visible) { // long_des ?>
	<tr id="r_long_des"<?php echo $feature->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_feature_long_des"><?php echo $feature->long_des->FldCaption() ?></span></td>
		<td<?php echo $feature->long_des->CellAttributes() ?>><span id="el_feature_long_des">
<textarea name="x_long_des" id="x_long_des" cols="50" rows="6"<?php echo $feature->long_des->EditAttributes() ?>><?php echo $feature->long_des->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ffeatureadd", "x_long_des", 50, 6, <?php echo ($feature->long_des->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $feature->long_des->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($feature->f_order->Visible) { // f_order ?>
	<tr id="r_f_order"<?php echo $feature->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_feature_f_order"><?php echo $feature->f_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $feature->f_order->CellAttributes() ?>><span id="el_feature_f_order">
<input type="text" name="x_f_order" id="x_f_order" size="30" value="<?php echo $feature->f_order->EditValue ?>"<?php echo $feature->f_order->EditAttributes() ?>>
</span><?php echo $feature->f_order->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
ffeatureadd.Init();
</script>
<?php
$feature_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$feature_add->Page_Terminate();
?>
