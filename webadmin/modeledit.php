<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "modelinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "specificationgridcls.php" ?>
<?php include_once "featuregridcls.php" ?>
<?php include_once "model_gallerygridcls.php" ?>
<?php include_once "model_colorgridcls.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$model_edit = NULL; // Initialize page object first

class cmodel_edit extends cmodel {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'model';

	// Page object name
	var $PageObjName = 'model_edit';

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
			define("EW_PAGE_ID", 'edit', TRUE);

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

		// Create form object
		$objForm = new cFormObj();
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
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Load key from QueryString
		if (@$_GET["model_id"] <> "")
			$this->model_id->setQueryStringValue($_GET["model_id"]);

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->model_id->CurrentValue == "")
			$this->Page_Terminate("modellist.php"); // Invalid key, return to list

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
					$this->Page_Terminate("modellist.php"); // No matching record, return to list
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
		$this->model_logo->Upload->Index = $objForm->Index;
		$this->model_logo->Upload->RestoreDbFromSession();
		if ($confirmPage) { // Post from confirm page
			$this->model_logo->Upload->RestoreFromSession();
		} else {
			if ($this->model_logo->Upload->UploadFile()) {

				// No action required
			} else {
				echo $this->model_logo->Upload->Message;
				$this->Page_Terminate();
				exit();
			}
			$this->model_logo->Upload->SaveToSession();
			$this->model_logo->CurrentValue = $this->model_logo->Upload->FileName;
		}
		$this->icon_menu->Upload->Index = $objForm->Index;
		$this->icon_menu->Upload->RestoreDbFromSession();
		if ($confirmPage) { // Post from confirm page
			$this->icon_menu->Upload->RestoreFromSession();
		} else {
			if ($this->icon_menu->Upload->UploadFile()) {

				// No action required
			} else {
				echo $this->icon_menu->Upload->Message;
				$this->Page_Terminate();
				exit();
			}
			$this->icon_menu->Upload->SaveToSession();
			$this->icon_menu->CurrentValue = $this->icon_menu->Upload->FileName;
		}
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
		$this->full_image->Upload->Index = $objForm->Index;
		$this->full_image->Upload->RestoreDbFromSession();
		if ($confirmPage) { // Post from confirm page
			$this->full_image->Upload->RestoreFromSession();
		} else {
			if ($this->full_image->Upload->UploadFile()) {

				// No action required
			} else {
				echo $this->full_image->Upload->Message;
				$this->Page_Terminate();
				exit();
			}
			$this->full_image->Upload->SaveToSession();
			$this->full_image->CurrentValue = $this->full_image->Upload->FileName;
		}
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->model_id->FldIsDetailKey)
			$this->model_id->setFormValue($objForm->GetValue("x_model_id"));
		if (!$this->model_name->FldIsDetailKey) {
			$this->model_name->setFormValue($objForm->GetValue("x_model_name"));
		}
		if (!$this->model_year->FldIsDetailKey) {
			$this->model_year->setFormValue($objForm->GetValue("x_model_year"));
		}
		if (!$this->description->FldIsDetailKey) {
			$this->description->setFormValue($objForm->GetValue("x_description"));
		}
		if (!$this->youtube_url->FldIsDetailKey) {
			$this->youtube_url->setFormValue($objForm->GetValue("x_youtube_url"));
		}
		if (!$this->category_id->FldIsDetailKey) {
			$this->category_id->setFormValue($objForm->GetValue("x_category_id"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->m_order->FldIsDetailKey) {
			$this->m_order->setFormValue($objForm->GetValue("x_m_order"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadRow();
		$this->model_id->CurrentValue = $this->model_id->FormValue;
		$this->model_name->CurrentValue = $this->model_name->FormValue;
		$this->model_year->CurrentValue = $this->model_year->FormValue;
		$this->description->CurrentValue = $this->description->FormValue;
		$this->youtube_url->CurrentValue = $this->youtube_url->FormValue;
		$this->category_id->CurrentValue = $this->category_id->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->m_order->CurrentValue = $this->m_order->FormValue;
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

			// description
			$this->description->ViewValue = $this->description->CurrentValue;
			$this->description->ViewCustomAttributes = "";

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

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";
			$this->description->TooltipValue = "";

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
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// model_id
			$this->model_id->EditCustomAttributes = "";
			$this->model_id->EditValue = $this->model_id->CurrentValue;
			$this->model_id->ViewCustomAttributes = "";

			// model_name
			$this->model_name->EditCustomAttributes = "";
			$this->model_name->EditValue = ew_HtmlEncode($this->model_name->CurrentValue);

			// model_logo
			$this->model_logo->EditCustomAttributes = "";
			$this->model_logo->UploadPath = '../assets/images/model_thumbnail/';
			if (!ew_Empty($this->model_logo->Upload->DbValue)) {
				$this->model_logo->EditValue = $this->model_logo->Upload->DbValue;
				$this->model_logo->ImageWidth = 100;
				$this->model_logo->ImageHeight = 0;
				$this->model_logo->ImageAlt = $this->model_logo->FldAlt();
			} else {
				$this->model_logo->EditValue = "";
			}

			// model_year
			$this->model_year->EditCustomAttributes = "";
			$this->model_year->EditValue = ew_HtmlEncode($this->model_year->CurrentValue);

			// icon_menu
			$this->icon_menu->EditCustomAttributes = "";
			$this->icon_menu->UploadPath = '../assets/images/model_menu/';
			if (!ew_Empty($this->icon_menu->Upload->DbValue)) {
				$this->icon_menu->EditValue = $this->icon_menu->Upload->DbValue;
				$this->icon_menu->ImageWidth = 200;
				$this->icon_menu->ImageHeight = 0;
				$this->icon_menu->ImageAlt = $this->icon_menu->FldAlt();
			} else {
				$this->icon_menu->EditValue = "";
			}

			// thumbnail
			$this->thumbnail->EditCustomAttributes = "";
			$this->thumbnail->UploadPath = '../assets/images/model_thumbnail/';
			if (!ew_Empty($this->thumbnail->Upload->DbValue)) {
				$this->thumbnail->EditValue = $this->thumbnail->Upload->DbValue;
				$this->thumbnail->ImageWidth = 200;
				$this->thumbnail->ImageHeight = 0;
				$this->thumbnail->ImageAlt = $this->thumbnail->FldAlt();
			} else {
				$this->thumbnail->EditValue = "";
			}

			// full_image
			$this->full_image->EditCustomAttributes = "";
			$this->full_image->UploadPath = '../assets/images/model/';
			if (!ew_Empty($this->full_image->Upload->DbValue)) {
				$this->full_image->EditValue = $this->full_image->Upload->DbValue;
				$this->full_image->ImageWidth = 300;
				$this->full_image->ImageHeight = 0;
				$this->full_image->ImageAlt = $this->full_image->FldAlt();
			} else {
				$this->full_image->EditValue = "";
			}

			// description
			$this->description->EditCustomAttributes = "";
			$this->description->EditValue = ew_HtmlEncode($this->description->CurrentValue);

			// youtube_url
			$this->youtube_url->EditCustomAttributes = "";
			$this->youtube_url->EditValue = ew_HtmlEncode($this->youtube_url->CurrentValue);

			// category_id
			$this->category_id->EditCustomAttributes = "";
			$sFilterWrk = "";
			$sSqlWrk = "SELECT `category_id`, `category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `model_category`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `category_name` ASC";
			$rswrk = $conn->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect"), "", "", "", "", "", "", ""));
			$this->category_id->EditValue = $arwrk;

			// status
			$this->status->EditCustomAttributes = "";
			$arwrk = array();
			$arwrk[] = array($this->status->FldTagValue(1), $this->status->FldTagCaption(1) <> "" ? $this->status->FldTagCaption(1) : $this->status->FldTagValue(1));
			$arwrk[] = array($this->status->FldTagValue(2), $this->status->FldTagCaption(2) <> "" ? $this->status->FldTagCaption(2) : $this->status->FldTagValue(2));
			array_unshift($arwrk, array("", $Language->Phrase("PleaseSelect")));
			$this->status->EditValue = $arwrk;

			// m_order
			$this->m_order->EditCustomAttributes = "";
			$this->m_order->EditValue = ew_HtmlEncode($this->m_order->CurrentValue);

			// Edit refer script
			// model_id

			$this->model_id->HrefValue = "";

			// model_name
			$this->model_name->HrefValue = "";

			// model_logo
			$this->model_logo->HrefValue = "";

			// model_year
			$this->model_year->HrefValue = "";

			// icon_menu
			$this->icon_menu->HrefValue = "";

			// thumbnail
			$this->thumbnail->HrefValue = "";

			// full_image
			$this->full_image->HrefValue = "";

			// description
			$this->description->HrefValue = "";

			// youtube_url
			$this->youtube_url->HrefValue = "";

			// category_id
			$this->category_id->HrefValue = "";

			// status
			$this->status->HrefValue = "";

			// m_order
			$this->m_order->HrefValue = "";
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
		if (!ew_CheckFileType($this->model_logo->Upload->FileName)) {
			ew_AddMessage($gsFormError, $Language->Phrase("WrongFileType"));
		}
		if ($this->model_logo->Upload->FileSize > 0 && EW_MAX_FILE_SIZE > 0 && $this->model_logo->Upload->FileSize > EW_MAX_FILE_SIZE) {
			ew_AddMessage($gsFormError, str_replace("%s", EW_MAX_FILE_SIZE, $Language->Phrase("MaxFileSize")));
		}
		if (in_array($this->model_logo->Upload->Error, array(1, 2, 3, 6, 7, 8))) {
			ew_AddMessage($gsFormError, $Language->Phrase("PhpUploadErr" . $this->model_logo->Upload->Error));
		}
		if (!ew_CheckFileType($this->icon_menu->Upload->FileName)) {
			ew_AddMessage($gsFormError, $Language->Phrase("WrongFileType"));
		}
		if ($this->icon_menu->Upload->FileSize > 0 && EW_MAX_FILE_SIZE > 0 && $this->icon_menu->Upload->FileSize > EW_MAX_FILE_SIZE) {
			ew_AddMessage($gsFormError, str_replace("%s", EW_MAX_FILE_SIZE, $Language->Phrase("MaxFileSize")));
		}
		if (in_array($this->icon_menu->Upload->Error, array(1, 2, 3, 6, 7, 8))) {
			ew_AddMessage($gsFormError, $Language->Phrase("PhpUploadErr" . $this->icon_menu->Upload->Error));
		}
		if (!ew_CheckFileType($this->thumbnail->Upload->FileName)) {
			ew_AddMessage($gsFormError, $Language->Phrase("WrongFileType"));
		}
		if ($this->thumbnail->Upload->FileSize > 0 && EW_MAX_FILE_SIZE > 0 && $this->thumbnail->Upload->FileSize > EW_MAX_FILE_SIZE) {
			ew_AddMessage($gsFormError, str_replace("%s", EW_MAX_FILE_SIZE, $Language->Phrase("MaxFileSize")));
		}
		if (in_array($this->thumbnail->Upload->Error, array(1, 2, 3, 6, 7, 8))) {
			ew_AddMessage($gsFormError, $Language->Phrase("PhpUploadErr" . $this->thumbnail->Upload->Error));
		}
		if (!ew_CheckFileType($this->full_image->Upload->FileName)) {
			ew_AddMessage($gsFormError, $Language->Phrase("WrongFileType"));
		}
		if ($this->full_image->Upload->FileSize > 0 && EW_MAX_FILE_SIZE > 0 && $this->full_image->Upload->FileSize > EW_MAX_FILE_SIZE) {
			ew_AddMessage($gsFormError, str_replace("%s", EW_MAX_FILE_SIZE, $Language->Phrase("MaxFileSize")));
		}
		if (in_array($this->full_image->Upload->Error, array(1, 2, 3, 6, 7, 8))) {
			ew_AddMessage($gsFormError, $Language->Phrase("PhpUploadErr" . $this->full_image->Upload->Error));
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!is_null($this->model_name->FormValue) && $this->model_name->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->model_name->FldCaption());
		}
		if ($this->model_logo->Upload->Action == "3" && is_null($this->model_logo->Upload->Value)) {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->model_logo->FldCaption());
		}
		if (!is_null($this->model_year->FormValue) && $this->model_year->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->model_year->FldCaption());
		}
		if ($this->icon_menu->Upload->Action == "3" && is_null($this->icon_menu->Upload->Value)) {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->icon_menu->FldCaption());
		}
		if ($this->thumbnail->Upload->Action == "3" && is_null($this->thumbnail->Upload->Value)) {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->thumbnail->FldCaption());
		}
		if ($this->full_image->Upload->Action == "3" && is_null($this->full_image->Upload->Value)) {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->full_image->FldCaption());
		}
		if (!is_null($this->category_id->FormValue) && $this->category_id->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->category_id->FldCaption());
		}
		if (!is_null($this->status->FormValue) && $this->status->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->status->FldCaption());
		}
		if (!is_null($this->m_order->FormValue) && $this->m_order->FormValue == "") {
			ew_AddMessage($gsFormError, $Language->Phrase("EnterRequiredField") . " - " . $this->m_order->FldCaption());
		}
		if (!ew_CheckInteger($this->m_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->m_order->FldErrMsg());
		}

		// Validate detail grid
		if ($this->getCurrentDetailTable() == "specification" && $GLOBALS["specification"]->DetailEdit) {
			if (!isset($GLOBALS["specification_grid"])) $GLOBALS["specification_grid"] = new cspecification_grid(); // get detail page object
			$GLOBALS["specification_grid"]->ValidateGridForm();
		}
		if ($this->getCurrentDetailTable() == "feature" && $GLOBALS["feature"]->DetailEdit) {
			if (!isset($GLOBALS["feature_grid"])) $GLOBALS["feature_grid"] = new cfeature_grid(); // get detail page object
			$GLOBALS["feature_grid"]->ValidateGridForm();
		}
		if ($this->getCurrentDetailTable() == "model_gallery" && $GLOBALS["model_gallery"]->DetailEdit) {
			if (!isset($GLOBALS["model_gallery_grid"])) $GLOBALS["model_gallery_grid"] = new cmodel_gallery_grid(); // get detail page object
			$GLOBALS["model_gallery_grid"]->ValidateGridForm();
		}
		if ($this->getCurrentDetailTable() == "model_color" && $GLOBALS["model_color"]->DetailEdit) {
			if (!isset($GLOBALS["model_color_grid"])) $GLOBALS["model_color_grid"] = new cmodel_color_grid(); // get detail page object
			$GLOBALS["model_color_grid"]->ValidateGridForm();
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

			// model_name
			$this->model_name->SetDbValueDef($rsnew, $this->model_name->CurrentValue, NULL, $this->model_name->ReadOnly);

			// model_logo
			if (!($this->model_logo->ReadOnly)) {
			$this->model_logo->UploadPath = '../assets/images/model_thumbnail/';
			if ($this->model_logo->Upload->Action == "1") { // Keep
			} elseif ($this->model_logo->Upload->Action == "2" || $this->model_logo->Upload->Action == "3") { // Update/Remove
			$this->model_logo->Upload->DbValue = $rs->fields('model_logo'); // Get original value
			if (is_null($this->model_logo->Upload->Value)) {
				$rsnew['model_logo'] = NULL;
			} else {
				if ($this->model_logo->Upload->FileName == $this->model_logo->Upload->DbValue) { // Upload file name same as old file name
					$rsnew['model_logo'] = $this->model_logo->Upload->FileName;
				} else {
					$rsnew['model_logo'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->model_logo->UploadPath), $this->model_logo->Upload->FileName);
				}
			}
			}
			}

			// model_year
			$this->model_year->SetDbValueDef($rsnew, $this->model_year->CurrentValue, NULL, $this->model_year->ReadOnly);

			// icon_menu
			if (!($this->icon_menu->ReadOnly)) {
			$this->icon_menu->UploadPath = '../assets/images/model_menu/';
			if ($this->icon_menu->Upload->Action == "1") { // Keep
			} elseif ($this->icon_menu->Upload->Action == "2" || $this->icon_menu->Upload->Action == "3") { // Update/Remove
			$this->icon_menu->Upload->DbValue = $rs->fields('icon_menu'); // Get original value
			if (is_null($this->icon_menu->Upload->Value)) {
				$rsnew['icon_menu'] = NULL;
			} else {
				if ($this->icon_menu->Upload->FileName == $this->icon_menu->Upload->DbValue) { // Upload file name same as old file name
					$rsnew['icon_menu'] = $this->icon_menu->Upload->FileName;
				} else {
					$rsnew['icon_menu'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->icon_menu->UploadPath), $this->icon_menu->Upload->FileName);
				}
			}
			}
			}

			// thumbnail
			if (!($this->thumbnail->ReadOnly)) {
			$this->thumbnail->UploadPath = '../assets/images/model_thumbnail/';
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

			// full_image
			if (!($this->full_image->ReadOnly)) {
			$this->full_image->UploadPath = '../assets/images/model/';
			if ($this->full_image->Upload->Action == "1") { // Keep
			} elseif ($this->full_image->Upload->Action == "2" || $this->full_image->Upload->Action == "3") { // Update/Remove
			$this->full_image->Upload->DbValue = $rs->fields('full_image'); // Get original value
			if (is_null($this->full_image->Upload->Value)) {
				$rsnew['full_image'] = NULL;
			} else {
				if ($this->full_image->Upload->FileName == $this->full_image->Upload->DbValue) { // Upload file name same as old file name
					$rsnew['full_image'] = $this->full_image->Upload->FileName;
				} else {
					$rsnew['full_image'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->full_image->UploadPath), $this->full_image->Upload->FileName);
				}
			}
			}
			}

			// description
			$this->description->SetDbValueDef($rsnew, $this->description->CurrentValue, NULL, $this->description->ReadOnly);

			// youtube_url
			$this->youtube_url->SetDbValueDef($rsnew, $this->youtube_url->CurrentValue, NULL, $this->youtube_url->ReadOnly);

			// category_id
			$this->category_id->SetDbValueDef($rsnew, $this->category_id->CurrentValue, 0, $this->category_id->ReadOnly);

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, 0, $this->status->ReadOnly);

			// m_order
			$this->m_order->SetDbValueDef($rsnew, $this->m_order->CurrentValue, 0, $this->m_order->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				if (!ew_Empty($this->model_logo->Upload->Value)) {
					if ($this->model_logo->Upload->FileName == $this->model_logo->Upload->DbValue) { // Overwrite if same file name
						$this->model_logo->Upload->SaveToFile($this->model_logo->UploadPath, $rsnew['model_logo'], TRUE);
						$this->model_logo->Upload->DbValue = ""; // No need to delete any more
					} else {
						$this->model_logo->Upload->SaveToFile($this->model_logo->UploadPath, $rsnew['model_logo'], FALSE);
					}
				}
				if ($this->model_logo->Upload->Action == "2" || $this->model_logo->Upload->Action == "3") { // Update/Remove
					if ($this->model_logo->Upload->DbValue <> "")
						@unlink(ew_UploadPathEx(TRUE, $this->model_logo->UploadPath) . $this->model_logo->Upload->DbValue);
				}
				if (!ew_Empty($this->icon_menu->Upload->Value)) {
					if ($this->icon_menu->Upload->FileName == $this->icon_menu->Upload->DbValue) { // Overwrite if same file name
						$this->icon_menu->Upload->SaveToFile($this->icon_menu->UploadPath, $rsnew['icon_menu'], TRUE);
						$this->icon_menu->Upload->DbValue = ""; // No need to delete any more
					} else {
						$this->icon_menu->Upload->SaveToFile($this->icon_menu->UploadPath, $rsnew['icon_menu'], FALSE);
					}
				}
				if ($this->icon_menu->Upload->Action == "2" || $this->icon_menu->Upload->Action == "3") { // Update/Remove
					if ($this->icon_menu->Upload->DbValue <> "")
						@unlink(ew_UploadPathEx(TRUE, $this->icon_menu->UploadPath) . $this->icon_menu->Upload->DbValue);
				}
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
				if (!ew_Empty($this->full_image->Upload->Value)) {
					if ($this->full_image->Upload->FileName == $this->full_image->Upload->DbValue) { // Overwrite if same file name
						$this->full_image->Upload->SaveToFile($this->full_image->UploadPath, $rsnew['full_image'], TRUE);
						$this->full_image->Upload->DbValue = ""; // No need to delete any more
					} else {
						$this->full_image->Upload->SaveToFile($this->full_image->UploadPath, $rsnew['full_image'], FALSE);
					}
				}
				if ($this->full_image->Upload->Action == "2" || $this->full_image->Upload->Action == "3") { // Update/Remove
					if ($this->full_image->Upload->DbValue <> "")
						@unlink(ew_UploadPathEx(TRUE, $this->full_image->UploadPath) . $this->full_image->Upload->DbValue);
				}
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';

				// Update detail records
				if ($EditRow) {
					if ($this->getCurrentDetailTable() == "specification" && $GLOBALS["specification"]->DetailEdit) {
						if (!isset($GLOBALS["specification_grid"])) $GLOBALS["specification_grid"] = new cspecification_grid(); // get detail page object
						$EditRow = $GLOBALS["specification_grid"]->GridUpdate();
					}
					if ($this->getCurrentDetailTable() == "feature" && $GLOBALS["feature"]->DetailEdit) {
						if (!isset($GLOBALS["feature_grid"])) $GLOBALS["feature_grid"] = new cfeature_grid(); // get detail page object
						$EditRow = $GLOBALS["feature_grid"]->GridUpdate();
					}
					if ($this->getCurrentDetailTable() == "model_gallery" && $GLOBALS["model_gallery"]->DetailEdit) {
						if (!isset($GLOBALS["model_gallery_grid"])) $GLOBALS["model_gallery_grid"] = new cmodel_gallery_grid(); // get detail page object
						$EditRow = $GLOBALS["model_gallery_grid"]->GridUpdate();
					}
					if ($this->getCurrentDetailTable() == "model_color" && $GLOBALS["model_color"]->DetailEdit) {
						if (!isset($GLOBALS["model_color_grid"])) $GLOBALS["model_color_grid"] = new cmodel_color_grid(); // get detail page object
						$EditRow = $GLOBALS["model_color_grid"]->GridUpdate();
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

		// model_logo
		$this->model_logo->Upload->RemoveFromSession(); // Remove file value from Session

		// icon_menu
		$this->icon_menu->Upload->RemoveFromSession(); // Remove file value from Session

		// thumbnail
		$this->thumbnail->Upload->RemoveFromSession(); // Remove file value from Session

		// full_image
		$this->full_image->Upload->RemoveFromSession(); // Remove file value from Session
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
			if ($sDetailTblVar == "specification") {
				if (!isset($GLOBALS["specification_grid"]))
					$GLOBALS["specification_grid"] = new cspecification_grid;
				if ($GLOBALS["specification_grid"]->DetailEdit) {
					$GLOBALS["specification_grid"]->CurrentMode = "edit";
					$GLOBALS["specification_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["specification_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["specification_grid"]->setStartRecordNumber(1);
					$GLOBALS["specification_grid"]->model_id->FldIsDetailKey = TRUE;
					$GLOBALS["specification_grid"]->model_id->CurrentValue = $this->model_id->CurrentValue;
					$GLOBALS["specification_grid"]->model_id->setSessionValue($GLOBALS["specification_grid"]->model_id->CurrentValue);
				}
			}
			if ($sDetailTblVar == "feature") {
				if (!isset($GLOBALS["feature_grid"]))
					$GLOBALS["feature_grid"] = new cfeature_grid;
				if ($GLOBALS["feature_grid"]->DetailEdit) {
					$GLOBALS["feature_grid"]->CurrentMode = "edit";
					$GLOBALS["feature_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["feature_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["feature_grid"]->setStartRecordNumber(1);
					$GLOBALS["feature_grid"]->model_id->FldIsDetailKey = TRUE;
					$GLOBALS["feature_grid"]->model_id->CurrentValue = $this->model_id->CurrentValue;
					$GLOBALS["feature_grid"]->model_id->setSessionValue($GLOBALS["feature_grid"]->model_id->CurrentValue);
				}
			}
			if ($sDetailTblVar == "model_gallery") {
				if (!isset($GLOBALS["model_gallery_grid"]))
					$GLOBALS["model_gallery_grid"] = new cmodel_gallery_grid;
				if ($GLOBALS["model_gallery_grid"]->DetailEdit) {
					$GLOBALS["model_gallery_grid"]->CurrentMode = "edit";
					$GLOBALS["model_gallery_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["model_gallery_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["model_gallery_grid"]->setStartRecordNumber(1);
					$GLOBALS["model_gallery_grid"]->model_id->FldIsDetailKey = TRUE;
					$GLOBALS["model_gallery_grid"]->model_id->CurrentValue = $this->model_id->CurrentValue;
					$GLOBALS["model_gallery_grid"]->model_id->setSessionValue($GLOBALS["model_gallery_grid"]->model_id->CurrentValue);
				}
			}
			if ($sDetailTblVar == "model_color") {
				if (!isset($GLOBALS["model_color_grid"]))
					$GLOBALS["model_color_grid"] = new cmodel_color_grid;
				if ($GLOBALS["model_color_grid"]->DetailEdit) {
					$GLOBALS["model_color_grid"]->CurrentMode = "edit";
					$GLOBALS["model_color_grid"]->CurrentAction = "gridedit";

					// Save current master table to detail table
					$GLOBALS["model_color_grid"]->setCurrentMasterTable($this->TableVar);
					$GLOBALS["model_color_grid"]->setStartRecordNumber(1);
					$GLOBALS["model_color_grid"]->model_id->FldIsDetailKey = TRUE;
					$GLOBALS["model_color_grid"]->model_id->CurrentValue = $this->model_id->CurrentValue;
					$GLOBALS["model_color_grid"]->model_id->setSessionValue($GLOBALS["model_color_grid"]->model_id->CurrentValue);
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
if (!isset($model_edit)) $model_edit = new cmodel_edit();

// Page init
$model_edit->Page_Init();

// Page main
$model_edit->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var model_edit = new ew_Page("model_edit");
model_edit.PageID = "edit"; // Page ID
var EW_PAGE_ID = model_edit.PageID; // For backward compatibility

// Form object
var fmodeledit = new ew_Form("fmodeledit");

// Validate form
fmodeledit.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_model_name"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model->model_name->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_model_logo"];
		aelm = fobj.elements["a" + infix + "_model_logo"];
		var chk_model_logo = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_model_logo && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model->model_logo->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_model_logo"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_model_year"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model->model_year->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_icon_menu"];
		aelm = fobj.elements["a" + infix + "_icon_menu"];
		var chk_icon_menu = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_icon_menu && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model->icon_menu->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_icon_menu"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_thumbnail"];
		aelm = fobj.elements["a" + infix + "_thumbnail"];
		var chk_thumbnail = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_thumbnail && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model->thumbnail->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_thumbnail"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_full_image"];
		aelm = fobj.elements["a" + infix + "_full_image"];
		var chk_full_image = (aelm && aelm[0])?(aelm[2].checked):true;
		if (elm && chk_full_image && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model->full_image->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_full_image"];
		if (elm && !ew_CheckFileType(elm.value))
			return ew_OnError(this, elm, ewLanguage.Phrase("WrongFileType"));
		elm = fobj.elements["x" + infix + "_category_id"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model->category_id->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_status"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model->status->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_m_order"];
		if (elm && !ew_HasValue(elm))
			return ew_OnError(this, elm, ewLanguage.Phrase("EnterRequiredField") + " - <?php echo ew_JsEncode2($model->m_order->FldCaption()) ?>");
		elm = fobj.elements["x" + infix + "_m_order"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($model->m_order->FldErrMsg()) ?>");

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
fmodeledit.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmodeledit.ValidateRequired = true;
<?php } else { ?>
fmodeledit.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmodeledit.Lists["x_category_id"] = {"LinkField":"x_category_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_category_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Edit") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $model->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $model->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $model_edit->ShowPageHeader(); ?>
<?php
$model_edit->ShowMessage();
?>
<form name="fmodeledit" id="fmodeledit" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" enctype="multipart/form-data" onsubmit="return ewForms[this.id].Submit();">
<p>
<input type="hidden" name="t" value="model">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_modeledit" class="ewTable">
<?php if ($model->model_id->Visible) { // model_id ?>
	<tr id="r_model_id"<?php echo $model->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_model_id"><?php echo $model->model_id->FldCaption() ?></span></td>
		<td<?php echo $model->model_id->CellAttributes() ?>><span id="el_model_model_id">
<span<?php echo $model->model_id->ViewAttributes() ?>>
<?php echo $model->model_id->EditValue ?></span>
<input type="hidden" name="x_model_id" id="x_model_id" value="<?php echo ew_HtmlEncode($model->model_id->CurrentValue) ?>">
</span><?php echo $model->model_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model->model_name->Visible) { // model_name ?>
	<tr id="r_model_name"<?php echo $model->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_model_name"><?php echo $model->model_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $model->model_name->CellAttributes() ?>><span id="el_model_model_name">
<input type="text" name="x_model_name" id="x_model_name" size="30" maxlength="100" value="<?php echo $model->model_name->EditValue ?>"<?php echo $model->model_name->EditAttributes() ?>>
</span><?php echo $model->model_name->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model->model_logo->Visible) { // model_logo ?>
	<tr id="r_model_logo"<?php echo $model->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_model_logo"><?php echo $model->model_logo->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $model->model_logo->CellAttributes() ?>><span id="el_model_model_logo">
<div id="old_x_model_logo">
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
</div>
<div id="new_x_model_logo">
<?php if ($model->model_logo->ReadOnly) { ?>
<?php if (!empty($model->model_logo->Upload->DbValue)) { ?>
<input type="hidden" name="a_model_logo" id="a_model_logo" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($model->model_logo->Upload->DbValue)) { ?>
<label><input type="radio" name="a_model_logo" id="a_model_logo" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_model_logo" id="a_model_logo" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_model_logo" id="a_model_logo" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $model->model_logo->EditAttrs["onchange"] = "this.form.a_model_logo[2].checked=true;" . @$model->model_logo->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_model_logo" id="a_model_logo" value="3">
<?php } ?>
<input type="file" name="x_model_logo" id="x_model_logo" size="30"<?php echo $model->model_logo->EditAttributes() ?>>
<?php } ?>
</div>
</span><?php echo $model->model_logo->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model->model_year->Visible) { // model_year ?>
	<tr id="r_model_year"<?php echo $model->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_model_year"><?php echo $model->model_year->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $model->model_year->CellAttributes() ?>><span id="el_model_model_year">
<input type="text" name="x_model_year" id="x_model_year" size="30" maxlength="10" value="<?php echo $model->model_year->EditValue ?>"<?php echo $model->model_year->EditAttributes() ?>>
</span><?php echo $model->model_year->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model->icon_menu->Visible) { // icon_menu ?>
	<tr id="r_icon_menu"<?php echo $model->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_icon_menu"><?php echo $model->icon_menu->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $model->icon_menu->CellAttributes() ?>><span id="el_model_icon_menu">
<div id="old_x_icon_menu">
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
</div>
<div id="new_x_icon_menu">
<?php if ($model->icon_menu->ReadOnly) { ?>
<?php if (!empty($model->icon_menu->Upload->DbValue)) { ?>
<input type="hidden" name="a_icon_menu" id="a_icon_menu" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($model->icon_menu->Upload->DbValue)) { ?>
<label><input type="radio" name="a_icon_menu" id="a_icon_menu" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_icon_menu" id="a_icon_menu" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_icon_menu" id="a_icon_menu" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $model->icon_menu->EditAttrs["onchange"] = "this.form.a_icon_menu[2].checked=true;" . @$model->icon_menu->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_icon_menu" id="a_icon_menu" value="3">
<?php } ?>
<input type="file" name="x_icon_menu" id="x_icon_menu" size="30"<?php echo $model->icon_menu->EditAttributes() ?>>
<?php } ?>
</div>
</span><?php echo $model->icon_menu->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model->thumbnail->Visible) { // thumbnail ?>
	<tr id="r_thumbnail"<?php echo $model->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_thumbnail"><?php echo $model->thumbnail->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $model->thumbnail->CellAttributes() ?>><span id="el_model_thumbnail">
<div id="old_x_thumbnail">
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
</div>
<div id="new_x_thumbnail">
<?php if ($model->thumbnail->ReadOnly) { ?>
<?php if (!empty($model->thumbnail->Upload->DbValue)) { ?>
<input type="hidden" name="a_thumbnail" id="a_thumbnail" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($model->thumbnail->Upload->DbValue)) { ?>
<label><input type="radio" name="a_thumbnail" id="a_thumbnail" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_thumbnail" id="a_thumbnail" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_thumbnail" id="a_thumbnail" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $model->thumbnail->EditAttrs["onchange"] = "this.form.a_thumbnail[2].checked=true;" . @$model->thumbnail->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_thumbnail" id="a_thumbnail" value="3">
<?php } ?>
<input type="file" name="x_thumbnail" id="x_thumbnail" size="30"<?php echo $model->thumbnail->EditAttributes() ?>>
<?php } ?>
</div>
</span><?php echo $model->thumbnail->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model->full_image->Visible) { // full_image ?>
	<tr id="r_full_image"<?php echo $model->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_full_image"><?php echo $model->full_image->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $model->full_image->CellAttributes() ?>><span id="el_model_full_image">
<div id="old_x_full_image">
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
</div>
<div id="new_x_full_image">
<?php if ($model->full_image->ReadOnly) { ?>
<?php if (!empty($model->full_image->Upload->DbValue)) { ?>
<input type="hidden" name="a_full_image" id="a_full_image" value="1">
<?php } ?>
<?php } else { ?>
<?php if (!empty($model->full_image->Upload->DbValue)) { ?>
<label><input type="radio" name="a_full_image" id="a_full_image" value="1" checked="checked"><?php echo $Language->Phrase("Keep") ?></label>&nbsp;
<label><input type="radio" name="a_full_image" id="a_full_image" value="2" disabled="disabled"><?php echo $Language->Phrase("Remove") ?></label>&nbsp;
<label><input type="radio" name="a_full_image" id="a_full_image" value="3"><?php echo $Language->Phrase("Replace") ?><br></label>
<?php $model->full_image->EditAttrs["onchange"] = "this.form.a_full_image[2].checked=true;" . @$model->full_image->EditAttrs["onchange"]; ?>
<?php } else { ?>
<input type="hidden" name="a_full_image" id="a_full_image" value="3">
<?php } ?>
<input type="file" name="x_full_image" id="x_full_image" size="30"<?php echo $model->full_image->EditAttributes() ?>>
<?php } ?>
</div>
</span><?php echo $model->full_image->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model->description->Visible) { // description ?>
	<tr id="r_description"<?php echo $model->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_description"><?php echo $model->description->FldCaption() ?></span></td>
		<td<?php echo $model->description->CellAttributes() ?>><span id="el_model_description">
<textarea name="x_description" id="x_description" cols="50" rows="6"<?php echo $model->description->EditAttributes() ?>><?php echo $model->description->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fmodeledit", "x_description", 50, 6, <?php echo ($model->description->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span><?php echo $model->description->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model->youtube_url->Visible) { // youtube_url ?>
	<tr id="r_youtube_url"<?php echo $model->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_youtube_url"><?php echo $model->youtube_url->FldCaption() ?></span></td>
		<td<?php echo $model->youtube_url->CellAttributes() ?>><span id="el_model_youtube_url">
<input type="text" name="x_youtube_url" id="x_youtube_url" size="30" maxlength="150" value="<?php echo $model->youtube_url->EditValue ?>"<?php echo $model->youtube_url->EditAttributes() ?>>
</span><?php echo $model->youtube_url->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model->category_id->Visible) { // category_id ?>
	<tr id="r_category_id"<?php echo $model->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_category_id"><?php echo $model->category_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $model->category_id->CellAttributes() ?>><span id="el_model_category_id">
<select id="x_category_id" name="x_category_id"<?php echo $model->category_id->EditAttributes() ?>>
<?php
if (is_array($model->category_id->EditValue)) {
	$arwrk = $model->category_id->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model->category_id->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
fmodeledit.Lists["x_category_id"].Options = <?php echo (is_array($model->category_id->EditValue)) ? ew_ArrayToJson($model->category_id->EditValue, 1) : "[]" ?>;
</script>
</span><?php echo $model->category_id->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model->status->Visible) { // status ?>
	<tr id="r_status"<?php echo $model->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_status"><?php echo $model->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $model->status->CellAttributes() ?>><span id="el_model_status">
<select id="x_status" name="x_status"<?php echo $model->status->EditAttributes() ?>>
<?php
if (is_array($model->status->EditValue)) {
	$arwrk = $model->status->EditValue;
	$rowswrk = count($arwrk);
	$emptywrk = TRUE;
	for ($rowcntwrk = 0; $rowcntwrk < $rowswrk; $rowcntwrk++) {
		$selwrk = (strval($model->status->CurrentValue) == strval($arwrk[$rowcntwrk][0])) ? " selected=\"selected\"" : "";
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
</span><?php echo $model->status->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($model->m_order->Visible) { // m_order ?>
	<tr id="r_m_order"<?php echo $model->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_model_m_order"><?php echo $model->m_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></span></td>
		<td<?php echo $model->m_order->CellAttributes() ?>><span id="el_model_m_order">
<input type="text" name="x_m_order" id="x_m_order" size="30" value="<?php echo $model->m_order->EditValue ?>"<?php echo $model->m_order->EditAttributes() ?>>
</span><?php echo $model->m_order->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<?php if ($model->getCurrentDetailTable() == "specification" && $specification->DetailEdit) { ?>
<br>
<?php include_once "specificationgrid.php" ?>
<br>
<?php } ?>
<?php if ($model->getCurrentDetailTable() == "feature" && $feature->DetailEdit) { ?>
<br>
<?php include_once "featuregrid.php" ?>
<br>
<?php } ?>
<?php if ($model->getCurrentDetailTable() == "model_gallery" && $model_gallery->DetailEdit) { ?>
<br>
<?php include_once "model_gallerygrid.php" ?>
<br>
<?php } ?>
<?php if ($model->getCurrentDetailTable() == "model_color" && $model_color->DetailEdit) { ?>
<br>
<?php include_once "model_colorgrid.php" ?>
<br>
<?php } ?>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("EditBtn")) ?>">
</form>
<script type="text/javascript">
fmodeledit.Init();
</script>
<?php
$model_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$model_edit->Page_Terminate();
?>
