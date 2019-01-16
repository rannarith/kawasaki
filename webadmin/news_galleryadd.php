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

$news_gallery_add = NULL; // Initialize page object first

class cnews_gallery_add extends cnews_gallery {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'news_gallery';

	// Page object name
	var $PageObjName = 'news_gallery_add';

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
			define("EW_PAGE_ID", 'add', TRUE);

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
			if (@$_GET["ng_id"] != "") {
				$this->ng_id->setQueryStringValue($_GET["ng_id"]);
				$this->setKey("ng_id", $this->ng_id->CurrentValue); // Set up key
			} else {
				$this->setKey("ng_id", ""); // Clear key
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
					$this->Page_Terminate("news_gallerylist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "news_galleryview.php")
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

	// Load default values
	function LoadDefaultValues() {
		$this->news_id->CurrentValue = NULL;
		$this->news_id->OldValue = $this->news_id->CurrentValue;
		$this->image->Upload->DbValue = NULL;
		$this->image->OldValue = $this->image->Upload->DbValue;
		$this->image->CurrentValue = NULL; // Clear file related field
		$this->g_status->CurrentValue = 1;
		$this->g_order->CurrentValue = 0;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->news_id->FldIsDetailKey) {
			$this->news_id->setFormValue($objForm->GetValue("x_news_id"));
		}
		if (!$this->g_status->FldIsDetailKey) {
			$this->g_status->setFormValue($objForm->GetValue("x_g_status"));
		}
		if (!$this->g_order->FldIsDetailKey) {
			$this->g_order->setFormValue($objForm->GetValue("x_g_order"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->news_id->CurrentValue = $this->news_id->FormValue;
		$this->g_status->CurrentValue = $this->g_status->FormValue;
		$this->g_order->CurrentValue = $this->g_order->FormValue;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("ng_id")) <> "")
			$this->ng_id->CurrentValue = $this->getKey("ng_id"); // ng_id
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
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// news_id
			$this->news_id->EditCustomAttributes = "";
			if ($this->news_id->getSessionValue() <> "") {
				$this->news_id->CurrentValue = $this->news_id->getSessionValue();
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
			} else {
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `news_id`, `title` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `news`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `news_id` DESC";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->news_id->EditValue = $arwrk;
			}

			// image
			$this->image->EditCustomAttributes = "";
			$this->image->UploadPath = '../assets/images/news_gallery/';
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->EditValue = $this->image->Upload->DbValue;
				$this->image->ImageWidth = 250;
				$this->image->ImageHeight = 0;
				$this->image->ImageAlt = $this->image->FldAlt();
			} else {
				$this->image->EditValue = "";
			}

			// g_status
			$this->g_status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->g_status->FldTagValue(1), $this->g_status->FldTagCaption(1) <> "" ? $this->g_status->FldTagCaption(1) : $this->g_status->FldTagValue(1));
			$arwrk[] = array($this->g_status->FldTagValue(2), $this->g_status->FldTagCaption(2) <> "" ? $this->g_status->FldTagCaption(2) : $this->g_status->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->g_status->EditValue = $arwrk;

			// g_order
			$this->g_order->EditCustomAttributes = "";
			$this->g_order->EditValue = ew_HtmlEncode($this->g_order->CurrentValue);

			// Edit refer script
			// news_id

			$this->news_id->HrefValue = "";

			// image
			$this->image->HrefValue = "";

			// g_status
			$this->g_status->HrefValue = "";

			// g_order
			$this->g_order->HrefValue = "";
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
		if (!is_null($this->news_id->FormValue) && $this->news_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->news_id->FldCaption());
		}
		if ($this->image->Upload->Action == "3" && is_null($this->image->Upload->Value)) {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->image->FldCaption());
		}
		if (!is_null($this->g_status->FormValue) && $this->g_status->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->g_status->FldCaption());
		}
		if (!is_null($this->g_order->FormValue) && $this->g_order->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->g_order->FldCaption());
		}
		if (!ew_CheckInteger($this->g_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->g_order->FldErrMsg());
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

		// news_id
		$this->news_id->SetDbValueDef($rsnew, $this->news_id->CurrentValue, 0, FALSE);

		// image
		$this->image->UploadPath = '../assets/images/news_gallery/';
		if ($this->image->Upload->Action == "1") { // Keep
			if ($rsold) {
				$rsnew['image'] = $rsold->fields['image'];
			}
		} elseif ($this->image->Upload->Action == "2" || $this->image->Upload->Action == "3") { // Update/Remove
		if (is_null($this->image->Upload->Value)) {
			$rsnew['image'] = NULL;
		} else {
			$rsnew['image'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->image->UploadPath), $this->image->Upload->FileName);
		}
		}

		// g_status
		$this->g_status->SetDbValueDef($rsnew, $this->g_status->CurrentValue, 0, strval($this->g_status->CurrentValue) == "");

		// g_order
		$this->g_order->SetDbValueDef($rsnew, $this->g_order->CurrentValue, 0, strval($this->g_order->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
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
			$this->ng_id->setDbValue($conn->Insert_ID());
			$rsnew['ng_id'] = $this->ng_id->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}

		// image
		$this->image->Upload->RemoveFromSession(); // Remove file value from Session
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
			if ($sMasterTblVar == "news") {
				$bValidMaster = TRUE;
				if (@$_GET["news_id"] <> "") {
					$GLOBALS["news"]->news_id->setQueryStringValue($_GET["news_id"]);
					$this->news_id->setQueryStringValue($GLOBALS["news"]->news_id->QueryStringValue);
					$this->news_id->setSessionValue($this->news_id->QueryStringValue);
					if (!is_numeric($GLOBALS["news"]->news_id->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "news") {
				if ($this->news_id->QueryStringValue == "") $this->news_id->setSessionValue("");
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
if (!isset($news_gallery_add)) $news_gallery_add = new cnews_gallery_add();

// Page init
$news_gallery_add->Page_Init();

// Page main
$news_gallery_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var news_gallery_add = new ew_Page("news_gallery_add");
news_gallery_add.PageID = "add"; // Page ID
var EW_PAGE_ID = news_gallery_add.PageID; // For backward compatibility

// Form object
var fnews_galleryadd = new ew_Form("fnews_galleryadd");

// Validate form
fnews_galleryadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_news_id"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($news_gallery->news_id->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_image"];
		aelm = fobj.elements["a" + infix + "_image"];
		var chk_image = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_image && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($news_gallery->image->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_image"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_g_status"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($news_gallery->g_status->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_g_order"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($news_gallery->g_order->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_g_order"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($news_gallery->g_order->FldErrMsg()) ?>");

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
fnews_galleryadd.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fnews_galleryadd.ValidateRequired = true;
<?php } else { ?>
fnews_galleryadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fnews_galleryadd.Lists["x_news_id"] = {"LinkField":"x_news_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_title","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $news_gallery->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $news_gallery->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $news_gallery_add->ShowPageHeader(); ?>
<?php
$news_gallery_add->ShowMessage();
?>
<form name="fnews_galleryadd" id="fnews_galleryadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" enctype="multipart/form-data" onsubmit="return ewForms[this.id].Submit();">
<p>
<input type="hidden" name="t" value="news_gallery">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_news_galleryadd" class="ewTable">
<?php if ($news_gallery->news_id->Visible) { // news_id ?>
	<tr id="r_news_id"<?php echo $news_gallery->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_gallery_news_id"><?php echo $news_gallery->news_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $news_gallery->news_id->CellAttributes() ?>><span id="el_news_gallery_news_id">
<?php if ($news_gallery->news_id->getSessionValue() <> "") { ?>
<span<?php echo $news_gallery->news_id->ViewAttributes() ?>>
<?php echo $news_gallery->news_id->ViewValue ?></span>
<input type="hidden" id="x_news_id" name="x_news_id" value="<?php echo ew_HtmlEncode($news_gallery->news_id->CurrentValue) ?>">
<?php } else { ?>
<select id="x_news_id" name="x_news_id"<?php echo $news_gallery->news_id->EditAttributes() ?>>
<?php
if (is_array($news_gallery->news_id->EditValue)) {
	$arwrk = $news_gallery->news_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($news_gallery->news_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fnews_galleryadd.Lists["x_news_id"].Options = <?php echo (is_array($news_gallery->news_id->EditValue)) ? ew_ArrayToJson($news_gallery->news_id->EditValue, 1) : "[]" ?>;
</script>
<?php } ?>
</span><?php echo $news_gallery->news_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($news_gallery->image->Visible) { // image ?>
	<tr id="r_image"<?php echo $news_gallery->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_gallery_image"><?php echo $news_gallery->image->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $news_gallery->image->CellAttributes() ?>><span id="el_news_gallery_image">
<div id="old_x_image">
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
</div>
<div id="new_x_image">
<?php if ($news_gallery->image->ReadOnly) { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<input type="hidden" name="a_image" id="a_image" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($news_gallery->image->Upload->DbValue)) { ?>
<label><input type="radio" name="a_image" id="a_image" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_image" id="a_image" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_image" id="a_image" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $news_gallery->image->EditAttrs["onchange"] = "this.form.a_image[2].checked=true;" . @$news_gallery->image->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_image" id="a_image" value="3">
<?php } ?>
<input type="file" name="x_image" id="x_image" size="30"<?php echo $news_gallery->image->EditAttributes() ?>>
<?php } ?>
</div>
</span><?php echo $news_gallery->image->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($news_gallery->g_status->Visible) { // g_status ?>
	<tr id="r_g_status"<?php echo $news_gallery->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_gallery_g_status"><?php echo $news_gallery->g_status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $news_gallery->g_status->CellAttributes() ?>><span id="el_news_gallery_g_status">
<select id="x_g_status" name="x_g_status"<?php echo $news_gallery->g_status->EditAttributes() ?>>
<?php
if (is_array($news_gallery->g_status->EditValue)) {
	$arwrk = $news_gallery->g_status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($news_gallery->g_status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $news_gallery->g_status->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($news_gallery->g_order->Visible) { // g_order ?>
	<tr id="r_g_order"<?php echo $news_gallery->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_gallery_g_order"><?php echo $news_gallery->g_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $news_gallery->g_order->CellAttributes() ?>><span id="el_news_gallery_g_order">
<input type="text" name="x_g_order" id="x_g_order" size="30" value="<?php echo $news_gallery->g_order->EditValue ?>"<?php echo $news_gallery->g_order->EditAttributes() ?>>
</span><?php echo $news_gallery->g_order->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
fnews_galleryadd.Init();
</script>
<?php
$news_gallery_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$news_gallery_add->Page_Terminate();
?>
