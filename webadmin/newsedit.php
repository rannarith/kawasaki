<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "newsinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "news_gallerygridcls.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$news_edit = NULL; // Initialize page object first

class cnews_edit extends cnews {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'news';

	// Page object name
	var $PageObjName = 'news_edit';

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

		// Table object (news)
		if (!isset($GLOBALS["news"])) {
			$GLOBALS["news"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["news"];
		}

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'news', TRUE);

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
		$this->news_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
		if (@$_GET["news_id"] <> "")
			$this->news_id->setQueryStringValue($_GET["news_id"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->news_id->CurrentValue == "")
			$this->Page_Terminate("newslist.php"); // Invalid key, return to list

		// Set up detail parameters
		$this->SetUpDetailParms();

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
					$this->Page_Terminate("newslist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					if ($this->getCurrentDetailTable() <> "") // Master/detail edit
						$sReturnUrl = $this->GetDetailUrl();
					else
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
		if (!$this->news_id->FldIsDetailKey)
			$this->news_id->setFormValue($objForm->GetValue("x_news_id"));
		if (!$this->title->FldIsDetailKey) {
			$this->title->setFormValue($objForm->GetValue("x_title"));
		}
		if (!$this->short_des->FldIsDetailKey) {
			$this->short_des->setFormValue($objForm->GetValue("x_short_des"));
		}
		if (!$this->long_des->FldIsDetailKey) {
			$this->long_des->setFormValue($objForm->GetValue("x_long_des"));
		}
		if (!$this->youtube_url->FldIsDetailKey) {
			$this->youtube_url->setFormValue($objForm->GetValue("x_youtube_url"));
		}
		if (!$this->news_date->FldIsDetailKey) {
			$this->news_date->setFormValue($objForm->GetValue("x_news_date"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->news_id->CurrentValue = $this->news_id->FormValue;
		$this->title->CurrentValue = $this->title->FormValue;
		$this->short_des->CurrentValue = $this->short_des->FormValue;
		$this->long_des->CurrentValue = $this->long_des->FormValue;
		$this->youtube_url->CurrentValue = $this->youtube_url->FormValue;
		$this->news_date->CurrentValue = $this->news_date->FormValue;
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
		$this->news_id->setDbValue($rs->fields('news_id'));
		$this->thumbnail->Upload->DbValue = $rs->fields('thumbnail');
		$this->title->setDbValue($rs->fields('title'));
		$this->short_des->setDbValue($rs->fields('short_des'));
		$this->long_des->setDbValue($rs->fields('long_des'));
		$this->youtube_url->setDbValue($rs->fields('youtube_url'));
		$this->news_date->setDbValue($rs->fields('news_date'));
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
		// news_id
		// thumbnail
		// title
		// short_des
		// long_des
		// youtube_url
		// news_date
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// news_id
			$this->news_id->ViewValue = $this->news_id->CurrentValue;
			$this->news_id->ViewCustomAttributes = "";

			// thumbnail
			$this->thumbnail->UploadPath = '../assets/images/news/';
			if (!ew_Empty($this->thumbnail->Upload->DbValue)) {
				$this->thumbnail->ViewValue = $this->thumbnail->Upload->DbValue;
				$this->thumbnail->ImageWidth = 200;
				$this->thumbnail->ImageHeight = 0;
				$this->thumbnail->ImageAlt = $this->thumbnail->FldAlt();
			} else {
				$this->thumbnail->ViewValue = "";
			}
			$this->thumbnail->ViewCustomAttributes = "";

			// title
			$this->title->ViewValue = $this->title->CurrentValue;
			$this->title->ViewCustomAttributes = "";

			// short_des
			$this->short_des->ViewValue = $this->short_des->CurrentValue;
			$this->short_des->ViewCustomAttributes = "";

			// long_des
			$this->long_des->ViewValue = $this->long_des->CurrentValue;
			$this->long_des->ViewCustomAttributes = "";

			// youtube_url
			$this->youtube_url->ViewValue = $this->youtube_url->CurrentValue;
			$this->youtube_url->ViewCustomAttributes = "";

			// news_date
			$this->news_date->ViewValue = $this->news_date->CurrentValue;
			$this->news_date->ViewCustomAttributes = "";

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

			// news_id
			$this->news_id->LinkCustomAttributes = "";
			$this->news_id->HrefValue = "";
			$this->news_id->TooltipValue = "";

			// thumbnail
			$this->thumbnail->LinkCustomAttributes = "";
			$this->thumbnail->HrefValue = "";
			$this->thumbnail->TooltipValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// short_des
			$this->short_des->LinkCustomAttributes = "";
			$this->short_des->HrefValue = "";
			$this->short_des->TooltipValue = "";

			// long_des
			$this->long_des->LinkCustomAttributes = "";
			$this->long_des->HrefValue = "";
			$this->long_des->TooltipValue = "";

			// youtube_url
			$this->youtube_url->LinkCustomAttributes = "";
			$this->youtube_url->HrefValue = "";
			$this->youtube_url->TooltipValue = "";

			// news_date
			$this->news_date->LinkCustomAttributes = "";
			$this->news_date->HrefValue = "";
			$this->news_date->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// news_id
			$this->news_id->EditCustomAttributes = "";
			$this->news_id->EditValue = $this->news_id->CurrentValue;
			$this->news_id->ViewCustomAttributes = "";

			// thumbnail
			$this->thumbnail->EditCustomAttributes = "";
			$this->thumbnail->UploadPath = '../assets/images/news/';
			if (!ew_Empty($this->thumbnail->Upload->DbValue)) {
				$this->thumbnail->EditValue = $this->thumbnail->Upload->DbValue;
				$this->thumbnail->ImageWidth = 200;
				$this->thumbnail->ImageHeight = 0;
				$this->thumbnail->ImageAlt = $this->thumbnail->FldAlt();
			} else {
				$this->thumbnail->EditValue = "";
			}

			// title
			$this->title->EditCustomAttributes = "";
			$this->title->EditValue = ew_HtmlEncode($this->title->CurrentValue);

			// short_des
			$this->short_des->EditCustomAttributes = "";
			$this->short_des->EditValue = ew_HtmlEncode($this->short_des->CurrentValue);

			// long_des
			$this->long_des->EditCustomAttributes = "";
			$this->long_des->EditValue = ew_HtmlEncode($this->long_des->CurrentValue);

			// youtube_url
			$this->youtube_url->EditCustomAttributes = "";
			$this->youtube_url->EditValue = ew_HtmlEncode($this->youtube_url->CurrentValue);

			// news_date
			$this->news_date->EditCustomAttributes = "";
			$this->news_date->EditValue = ew_HtmlEncode($this->news_date->CurrentValue);

			// status
			$this->status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->status->FldTagValue(1), $this->status->FldTagCaption(1) <> "" ? $this->status->FldTagCaption(1) : $this->status->FldTagValue(1));
			$arwrk[] = array($this->status->FldTagValue(2), $this->status->FldTagCaption(2) <> "" ? $this->status->FldTagCaption(2) : $this->status->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->status->EditValue = $arwrk;

			// Edit refer script
			// news_id

			$this->news_id->HrefValue = "";

			// thumbnail
			$this->thumbnail->HrefValue = "";

			// title
			$this->title->HrefValue = "";

			// short_des
			$this->short_des->HrefValue = "";

			// long_des
			$this->long_des->HrefValue = "";

			// youtube_url
			$this->youtube_url->HrefValue = "";

			// news_date
			$this->news_date->HrefValue = "";

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
		if ($this->thumbnail->Upload->Action == "3" && is_null($this->thumbnail->Upload->Value)) {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->thumbnail->FldCaption());
		}
		if (!is_null($this->title->FormValue) && $this->title->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->title->FldCaption());
		}
		if (!is_null($this->news_date->FormValue) && $this->news_date->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->news_date->FldCaption());
		}
		if (!ew_CheckEuroDate($this->news_date->FormValue)) {
			ew_AddMessage($gsFormError, $this->news_date->FldErrMsg());
		}
		if (!is_null($this->status->FormValue) && $this->status->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->status->FldCaption());
		}

		// Validate detail grid
		if ($this->getCurrentDetailTable() == "news_gallery" && $GLOBALS["news_gallery"]->DetailEdit) {
			if (!isset($GLOBALS["news_gallery_grid"])) $GLOBALS["news_gallery_grid"] = new cnews_gallery_grid(); // get detail page object
			$GLOBALS["news_gallery_grid"]->ValidateGridForm();
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$rsnew = array();

			// thumbnail
			if (!($this->thumbnail->ReadOnly)) {
			$this->thumbnail->UploadPath = '../assets/images/news/';
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

			// title
			$this->title->SetDbValueDef($rsnew, $this->title->CurrentValue, NULL, $this->title->ReadOnly);

			// short_des
			$this->short_des->SetDbValueDef($rsnew, $this->short_des->CurrentValue, NULL, $this->short_des->ReadOnly);

			// long_des
			$this->long_des->SetDbValueDef($rsnew, $this->long_des->CurrentValue, NULL, $this->long_des->ReadOnly);

			// youtube_url
			$this->youtube_url->SetDbValueDef($rsnew, $this->youtube_url->CurrentValue, NULL, $this->youtube_url->ReadOnly);

			// news_date
			$this->news_date->SetDbValueDef($rsnew, $this->news_date->CurrentValue, NULL, $this->news_date->ReadOnly);

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, 0, $this->status->ReadOnly);

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

				// Update detail records
				if ($EditRow) {
					if ($this->getCurrentDetailTable() == "news_gallery" && $GLOBALS["news_gallery"]->DetailEdit) {
						if (!isset($GLOBALS["news_gallery_grid"])) $GLOBALS["news_gallery_grid"] = new cnews_gallery_grid(); // get detail page object
						$EditRow = $GLOBALS["news_gallery_grid"]->GridUpdate();
					}
				}

				// Commit/Rollback transaction
				if ($this->getCurrentDetailTable() <> "") {
					if ($EditRow) {
						$conn->CommitTrans(); // Commit transaction
					} else {
						$conn->RollbackTrans(); // Rollback transaction
					}
				}
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

	// Set up detail parms based on QueryString
	function SetUpDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			if ($sDetailTblVar == "news_gallery") {
				if (!isset($GLOBALS["news_gallery_grid"]))
					$GLOBALS["news_gallery_grid"] = new cnews_gallery_grid;
				if ($GLOBALS["news_gallery_grid"]->DetailEdit) {
					$GLOBALS["news_gallery_grid"]->CurrentMode = "edit";
					$GLOBALS["news_gallery_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["news_gallery_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["news_gallery_grid"]->setStartRecordNumber(1);
					$GLOBALS["news_gallery_grid"]->news_id->FldIsDetailKey = TRUE;
					$GLOBALS["news_gallery_grid"]->news_id->CurrentValue = $this->news_id->CurrentValue;
					$GLOBALS["news_gallery_grid"]->news_id->setSessionValue($GLOBALS["news_gallery_grid"]->news_id->CurrentValue);
				}
			}
		}
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
if (!isset($news_edit)) $news_edit = new cnews_edit();

// Page init
$news_edit->Page_Init();

// Page main
$news_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var news_edit = new ew_Page("news_edit");
news_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = news_edit.PageID; // For backward compatibility

// Form object
var fnewsedit = new ew_Form("fnewsedit");

// Validate form
fnewsedit.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_thumbnail"];
		aelm = fobj.elements["a" + infix + "_thumbnail"];
		var chk_thumbnail = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_thumbnail && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($news->thumbnail->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_thumbnail"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_title"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($news->title->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_news_date"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($news->news_date->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_news_date"];
		if (elm && !ew_CheckEuroDate(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($news->news_date->FldErrMsg()) ?>");
		elm = fobj.elements["x" + infix + "_status"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($news->status->FldCaption()) ?>");

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
fnewsedit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fnewsedit.ValidateRequired = true;
<?php } else { ?>
fnewsedit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $news->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $news->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $news_edit->ShowPageHeader(); ?>
<?php
$news_edit->ShowMessage();
?>
<form name="fnewsedit" id="fnewsedit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" enctype="multipart/form-data" onsubmit="return ewForms[this.id].Submit();">
<p>
<input type="hidden" name="t" value="news">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_newsedit" class="ewTable">
<?php if ($news->news_id->Visible) { // news_id ?>
	<tr id="r_news_id"<?php echo $news->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_news_id"><?php echo $news->news_id->FldCaption() ?></span></td>
		<td<?php echo $news->news_id->CellAttributes() ?>><span id="el_news_news_id">
<span<?php echo $news->news_id->ViewAttributes() ?>>
<?php echo $news->news_id->EditValue ?></span>
<input type="hidden" name="x_news_id" id="x_news_id" value="<?php echo ew_HtmlEncode($news->news_id->CurrentValue) ?>">
</span><?php echo $news->news_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($news->thumbnail->Visible) { // thumbnail ?>
	<tr id="r_thumbnail"<?php echo $news->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_thumbnail"><?php echo $news->thumbnail->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $news->thumbnail->CellAttributes() ?>><span id="el_news_thumbnail">
<div id="old_x_thumbnail">
<?php if ($news->thumbnail->LinkAttributes() <> "") { ?>
<?php if (!empty($news->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $news->thumbnail->UploadPath) . $news->thumbnail->Upload->DbValue ?>" border="0"<?php echo $news->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($news->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($news->thumbnail->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $news->thumbnail->UploadPath) . $news->thumbnail->Upload->DbValue ?>" border="0"<?php echo $news->thumbnail->ViewAttributes() ?>>
<?php } elseif (!in_array($news->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</div>
<div id="new_x_thumbnail">
<?php if ($news->thumbnail->ReadOnly) { ?>
<?php if (!empty($news->thumbnail->Upload->DbValue)) { ?>
<input type="hidden" name="a_thumbnail" id="a_thumbnail" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($news->thumbnail->Upload->DbValue)) { ?>
<label><input type="radio" name="a_thumbnail" id="a_thumbnail" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_thumbnail" id="a_thumbnail" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_thumbnail" id="a_thumbnail" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $news->thumbnail->EditAttrs["onchange"] = "this.form.a_thumbnail[2].checked=true;" . @$news->thumbnail->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_thumbnail" id="a_thumbnail" value="3">
<?php } ?>
<input type="file" name="x_thumbnail" id="x_thumbnail" size="30"<?php echo $news->thumbnail->EditAttributes() ?>>
<?php } ?>
</div>
</span><?php echo $news->thumbnail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($news->title->Visible) { // title ?>
	<tr id="r_title"<?php echo $news->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_title"><?php echo $news->title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $news->title->CellAttributes() ?>><span id="el_news_title">
<input type="text" name="x_title" id="x_title" size="30" maxlength="200" value="<?php echo $news->title->EditValue ?>"<?php echo $news->title->EditAttributes() ?>>
</span><?php echo $news->title->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($news->short_des->Visible) { // short_des ?>
	<tr id="r_short_des"<?php echo $news->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_short_des"><?php echo $news->short_des->FldCaption() ?></span></td>
		<td<?php echo $news->short_des->CellAttributes() ?>><span id="el_news_short_des">
<textarea name="x_short_des" id="x_short_des" cols="35" rows="4"<?php echo $news->short_des->EditAttributes() ?>><?php echo $news->short_des->EditValue ?></textarea>
</span><?php echo $news->short_des->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($news->long_des->Visible) { // long_des ?>
	<tr id="r_long_des"<?php echo $news->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_long_des"><?php echo $news->long_des->FldCaption() ?></span></td>
		<td<?php echo $news->long_des->CellAttributes() ?>><span id="el_news_long_des">
<textarea name="x_long_des" id="x_long_des" cols="55" rows="6"<?php echo $news->long_des->EditAttributes() ?>><?php echo $news->long_des->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fnewsedit", "x_long_des", 55, 6, <?php echo ($news->long_des->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $news->long_des->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($news->youtube_url->Visible) { // youtube_url ?>
	<tr id="r_youtube_url"<?php echo $news->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_youtube_url"><?php echo $news->youtube_url->FldCaption() ?></span></td>
		<td<?php echo $news->youtube_url->CellAttributes() ?>><span id="el_news_youtube_url">
<input type="text" name="x_youtube_url" id="x_youtube_url" size="30" maxlength="150" value="<?php echo $news->youtube_url->EditValue ?>"<?php echo $news->youtube_url->EditAttributes() ?>>
</span><?php echo $news->youtube_url->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($news->news_date->Visible) { // news_date ?>
	<tr id="r_news_date"<?php echo $news->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_news_date"><?php echo $news->news_date->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $news->news_date->CellAttributes() ?>><span id="el_news_news_date">
<input type="text" name="x_news_date" id="x_news_date" size="30" maxlength="30" value="<?php echo $news->news_date->EditValue ?>"<?php echo $news->news_date->EditAttributes() ?>>
<?php if (!$news->news_date->ReadOnly && !$news->news_date->Disabled && @$news->news_date->EditAttrs["readonly"] == "" && @$news->news_date->EditAttrs["disabled"] == "") { ?>
&nbsp;<img src="phpimages/calendar.png" id="fnewsedit$x_news_date$" name="fnewsedit$x_news_date$" alt="<?php echo $Language->Phrase("PickDate") ?>" title="<?php echo $Language->Phrase("PickDate") ?>" class="ewCalendar">
<script type="text/javascript">
ew_CreateCalendar("fnewsedit", "x_news_date", "%d/%m/%Y");
</script>
<?php } ?>
</span><?php echo $news->news_date->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($news->status->Visible) { // status ?>
	<tr id="r_status"<?php echo $news->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_news_status"><?php echo $news->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $news->status->CellAttributes() ?>><span id="el_news_status">
<select id="x_status" name="x_status"<?php echo $news->status->EditAttributes() ?>>
<?php
if (is_array($news->status->EditValue)) {
	$arwrk = $news->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($news->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $news->status->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($news->getCurrentDetailTable() == "news_gallery" && $news_gallery->DetailEdit) { ?>
<br>
<?php include_once "news_gallerygrid.php" ?>
<br>
<?php } ?>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
fnewsedit.Init();
</script>
<?php
$news_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$news_edit->Page_Terminate();
?>
