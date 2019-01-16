<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "modelinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$model_edit = NULL; // Initialize page object first

class cmodel_edit extends cmodel {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = "{BE8C113E-D6C5-4712-BA29-D5C99D7D07A2}";

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

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
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
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
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
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (model)
		if (!isset($GLOBALS["model"]) || get_class($GLOBALS["model"]) == "cmodel") {
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
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (admin_user)
		if (!isset($UserTable)) {
			$UserTable = new cadmin_user();
			$UserTableConn = Conn($UserTable->DBID);
		}
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("modellist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->model_id->SetVisibility();
		$this->model_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->model_name->SetVisibility();
		$this->model_year->SetVisibility();
		$this->icon_menu->SetVisibility();
		$this->_thumbnail->SetVisibility();
		$this->description->SetVisibility();
		$this->youtube_url->SetVisibility();
		$this->category_id->SetVisibility();
		$this->m_order->SetVisibility();
		$this->status->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $model;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($model);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Load key from QueryString
		if (@$_GET["model_id"] <> "") {
			$this->model_id->setQueryStringValue($_GET["model_id"]);
		}

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Process form if post back
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			$this->LoadFormValues(); // Get form values
		} else {
			$this->CurrentAction = "I"; // Default action is display
		}

		// Check if valid key
		if ($this->model_id->CurrentValue == "") {
			$this->Page_Terminate("modellist.php"); // Invalid key, return to list
		}

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
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "modellist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to list page with correct master key if necessary
				$this->SendEmail = TRUE; // Send email on update success
				if ($this->EditRow()) { // Update record based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Update success
					$this->Page_Terminate($sReturnUrl); // Return to caller
				} elseif ($this->getFailureMessage() == $Language->Phrase("NoRecord")) {
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

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
		$this->icon_menu->Upload->Index = $objForm->Index;
		$this->icon_menu->Upload->UploadFile();
		$this->icon_menu->CurrentValue = $this->icon_menu->Upload->FileName;
		$this->_thumbnail->Upload->Index = $objForm->Index;
		$this->_thumbnail->Upload->UploadFile();
		$this->_thumbnail->CurrentValue = $this->_thumbnail->Upload->FileName;
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
		if (!$this->m_order->FldIsDetailKey) {
			$this->m_order->setFormValue($objForm->GetValue("x_m_order"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
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
		$this->m_order->CurrentValue = $this->m_order->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->model_id->setDbValue($rs->fields('model_id'));
		$this->model_name->setDbValue($rs->fields('model_name'));
		$this->model_year->setDbValue($rs->fields('model_year'));
		$this->icon_menu->Upload->DbValue = $rs->fields('icon_menu');
		$this->icon_menu->CurrentValue = $this->icon_menu->Upload->DbValue;
		$this->_thumbnail->Upload->DbValue = $rs->fields('thumbnail');
		$this->_thumbnail->CurrentValue = $this->_thumbnail->Upload->DbValue;
		$this->description->setDbValue($rs->fields('description'));
		$this->youtube_url->setDbValue($rs->fields('youtube_url'));
		$this->category_id->setDbValue($rs->fields('category_id'));
		$this->m_order->setDbValue($rs->fields('m_order'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->model_id->DbValue = $row['model_id'];
		$this->model_name->DbValue = $row['model_name'];
		$this->model_year->DbValue = $row['model_year'];
		$this->icon_menu->Upload->DbValue = $row['icon_menu'];
		$this->_thumbnail->Upload->DbValue = $row['thumbnail'];
		$this->description->DbValue = $row['description'];
		$this->youtube_url->DbValue = $row['youtube_url'];
		$this->category_id->DbValue = $row['category_id'];
		$this->m_order->DbValue = $row['m_order'];
		$this->status->DbValue = $row['status'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// model_id
		// model_name
		// model_year
		// icon_menu
		// thumbnail
		// description
		// youtube_url
		// category_id
		// m_order
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// model_id
		$this->model_id->ViewValue = $this->model_id->CurrentValue;
		$this->model_id->ViewCustomAttributes = "";

		// model_name
		$this->model_name->ViewValue = $this->model_name->CurrentValue;
		$this->model_name->ViewCustomAttributes = "";

		// model_year
		$this->model_year->ViewValue = $this->model_year->CurrentValue;
		$this->model_year->ViewCustomAttributes = "";

		// icon_menu
		$this->icon_menu->UploadPath = '../assets/images/model_menu/';
		if (!ew_Empty($this->icon_menu->Upload->DbValue)) {
			$this->icon_menu->ImageWidth = 100;
			$this->icon_menu->ImageHeight = 0;
			$this->icon_menu->ImageAlt = $this->icon_menu->FldAlt();
			$this->icon_menu->ViewValue = $this->icon_menu->Upload->DbValue;
		} else {
			$this->icon_menu->ViewValue = "";
		}
		$this->icon_menu->ViewCustomAttributes = "";

		// thumbnail
		$this->_thumbnail->UploadPath = '../assets/images/model/';
		if (!ew_Empty($this->_thumbnail->Upload->DbValue)) {
			$this->_thumbnail->ImageWidth = 200;
			$this->_thumbnail->ImageHeight = 0;
			$this->_thumbnail->ImageAlt = $this->_thumbnail->FldAlt();
			$this->_thumbnail->ViewValue = $this->_thumbnail->Upload->DbValue;
		} else {
			$this->_thumbnail->ViewValue = "";
		}
		$this->_thumbnail->ViewCustomAttributes = "";

		// description
		$this->description->ViewValue = $this->description->CurrentValue;
		$this->description->ViewCustomAttributes = "";

		// youtube_url
		$this->youtube_url->ViewValue = $this->youtube_url->CurrentValue;
		$this->youtube_url->ViewCustomAttributes = "";

		// category_id
		if (strval($this->category_id->CurrentValue) <> "") {
			$sFilterWrk = "`category_id`" . ew_SearchString("=", $this->category_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `category_id`, `category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `model_category`";
		$sWhereWrk = "";
		$this->category_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->category_id, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `category_name` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->category_id->ViewValue = $this->category_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->category_id->ViewValue = $this->category_id->CurrentValue;
			}
		} else {
			$this->category_id->ViewValue = NULL;
		}
		$this->category_id->ViewCustomAttributes = "";

		// m_order
		$this->m_order->ViewValue = $this->m_order->CurrentValue;
		$this->m_order->ViewCustomAttributes = "";

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = $this->status->OptionCaption($this->status->CurrentValue);
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

			// model_id
			$this->model_id->LinkCustomAttributes = "";
			$this->model_id->HrefValue = "";
			$this->model_id->TooltipValue = "";

			// model_name
			$this->model_name->LinkCustomAttributes = "";
			$this->model_name->HrefValue = "";
			$this->model_name->TooltipValue = "";

			// model_year
			$this->model_year->LinkCustomAttributes = "";
			$this->model_year->HrefValue = "";
			$this->model_year->TooltipValue = "";

			// icon_menu
			$this->icon_menu->LinkCustomAttributes = "";
			$this->icon_menu->UploadPath = '../assets/images/model_menu/';
			if (!ew_Empty($this->icon_menu->Upload->DbValue)) {
				$this->icon_menu->HrefValue = ew_GetFileUploadUrl($this->icon_menu, $this->icon_menu->Upload->DbValue); // Add prefix/suffix
				$this->icon_menu->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->icon_menu->HrefValue = ew_ConvertFullUrl($this->icon_menu->HrefValue);
			} else {
				$this->icon_menu->HrefValue = "";
			}
			$this->icon_menu->HrefValue2 = $this->icon_menu->UploadPath . $this->icon_menu->Upload->DbValue;
			$this->icon_menu->TooltipValue = "";
			if ($this->icon_menu->UseColorbox) {
				if (ew_Empty($this->icon_menu->TooltipValue))
					$this->icon_menu->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->icon_menu->LinkAttrs["data-rel"] = "model_x_icon_menu";
				ew_AppendClass($this->icon_menu->LinkAttrs["class"], "ewLightbox");
			}

			// thumbnail
			$this->_thumbnail->LinkCustomAttributes = "";
			$this->_thumbnail->UploadPath = '../assets/images/model/';
			if (!ew_Empty($this->_thumbnail->Upload->DbValue)) {
				$this->_thumbnail->HrefValue = ew_GetFileUploadUrl($this->_thumbnail, $this->_thumbnail->Upload->DbValue); // Add prefix/suffix
				$this->_thumbnail->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->_thumbnail->HrefValue = ew_ConvertFullUrl($this->_thumbnail->HrefValue);
			} else {
				$this->_thumbnail->HrefValue = "";
			}
			$this->_thumbnail->HrefValue2 = $this->_thumbnail->UploadPath . $this->_thumbnail->Upload->DbValue;
			$this->_thumbnail->TooltipValue = "";
			if ($this->_thumbnail->UseColorbox) {
				if (ew_Empty($this->_thumbnail->TooltipValue))
					$this->_thumbnail->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->_thumbnail->LinkAttrs["data-rel"] = "model_x__thumbnail";
				ew_AppendClass($this->_thumbnail->LinkAttrs["class"], "ewLightbox");
			}

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

			// m_order
			$this->m_order->LinkCustomAttributes = "";
			$this->m_order->HrefValue = "";
			$this->m_order->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// model_id
			$this->model_id->EditAttrs["class"] = "form-control";
			$this->model_id->EditCustomAttributes = "";
			$this->model_id->EditValue = $this->model_id->CurrentValue;
			$this->model_id->ViewCustomAttributes = "";

			// model_name
			$this->model_name->EditAttrs["class"] = "form-control";
			$this->model_name->EditCustomAttributes = "";
			$this->model_name->EditValue = ew_HtmlEncode($this->model_name->CurrentValue);
			$this->model_name->PlaceHolder = ew_RemoveHtml($this->model_name->FldCaption());

			// model_year
			$this->model_year->EditAttrs["class"] = "form-control";
			$this->model_year->EditCustomAttributes = "";
			$this->model_year->EditValue = ew_HtmlEncode($this->model_year->CurrentValue);
			$this->model_year->PlaceHolder = ew_RemoveHtml($this->model_year->FldCaption());

			// icon_menu
			$this->icon_menu->EditAttrs["class"] = "form-control";
			$this->icon_menu->EditCustomAttributes = "";
			$this->icon_menu->UploadPath = '../assets/images/model_menu/';
			if (!ew_Empty($this->icon_menu->Upload->DbValue)) {
				$this->icon_menu->ImageWidth = 100;
				$this->icon_menu->ImageHeight = 0;
				$this->icon_menu->ImageAlt = $this->icon_menu->FldAlt();
				$this->icon_menu->EditValue = $this->icon_menu->Upload->DbValue;
			} else {
				$this->icon_menu->EditValue = "";
			}
			if (!ew_Empty($this->icon_menu->CurrentValue))
				$this->icon_menu->Upload->FileName = $this->icon_menu->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->icon_menu);

			// thumbnail
			$this->_thumbnail->EditAttrs["class"] = "form-control";
			$this->_thumbnail->EditCustomAttributes = "";
			$this->_thumbnail->UploadPath = '../assets/images/model/';
			if (!ew_Empty($this->_thumbnail->Upload->DbValue)) {
				$this->_thumbnail->ImageWidth = 200;
				$this->_thumbnail->ImageHeight = 0;
				$this->_thumbnail->ImageAlt = $this->_thumbnail->FldAlt();
				$this->_thumbnail->EditValue = $this->_thumbnail->Upload->DbValue;
			} else {
				$this->_thumbnail->EditValue = "";
			}
			if (!ew_Empty($this->_thumbnail->CurrentValue))
				$this->_thumbnail->Upload->FileName = $this->_thumbnail->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->_thumbnail);

			// description
			$this->description->EditAttrs["class"] = "form-control";
			$this->description->EditCustomAttributes = "";
			$this->description->EditValue = ew_HtmlEncode($this->description->CurrentValue);
			$this->description->PlaceHolder = ew_RemoveHtml($this->description->FldCaption());

			// youtube_url
			$this->youtube_url->EditAttrs["class"] = "form-control";
			$this->youtube_url->EditCustomAttributes = "";
			$this->youtube_url->EditValue = ew_HtmlEncode($this->youtube_url->CurrentValue);
			$this->youtube_url->PlaceHolder = ew_RemoveHtml($this->youtube_url->FldCaption());

			// category_id
			$this->category_id->EditAttrs["class"] = "form-control";
			$this->category_id->EditCustomAttributes = "";
			if (trim(strval($this->category_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`category_id`" . ew_SearchString("=", $this->category_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `category_id`, `category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `model_category`";
			$sWhereWrk = "";
			$this->category_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->category_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `category_name` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->category_id->EditValue = $arwrk;

			// m_order
			$this->m_order->EditAttrs["class"] = "form-control";
			$this->m_order->EditCustomAttributes = "";
			$this->m_order->EditValue = ew_HtmlEncode($this->m_order->CurrentValue);
			$this->m_order->PlaceHolder = ew_RemoveHtml($this->m_order->FldCaption());

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(TRUE);

			// Edit refer script
			// model_id

			$this->model_id->LinkCustomAttributes = "";
			$this->model_id->HrefValue = "";

			// model_name
			$this->model_name->LinkCustomAttributes = "";
			$this->model_name->HrefValue = "";

			// model_year
			$this->model_year->LinkCustomAttributes = "";
			$this->model_year->HrefValue = "";

			// icon_menu
			$this->icon_menu->LinkCustomAttributes = "";
			$this->icon_menu->UploadPath = '../assets/images/model_menu/';
			if (!ew_Empty($this->icon_menu->Upload->DbValue)) {
				$this->icon_menu->HrefValue = ew_GetFileUploadUrl($this->icon_menu, $this->icon_menu->Upload->DbValue); // Add prefix/suffix
				$this->icon_menu->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->icon_menu->HrefValue = ew_ConvertFullUrl($this->icon_menu->HrefValue);
			} else {
				$this->icon_menu->HrefValue = "";
			}
			$this->icon_menu->HrefValue2 = $this->icon_menu->UploadPath . $this->icon_menu->Upload->DbValue;

			// thumbnail
			$this->_thumbnail->LinkCustomAttributes = "";
			$this->_thumbnail->UploadPath = '../assets/images/model/';
			if (!ew_Empty($this->_thumbnail->Upload->DbValue)) {
				$this->_thumbnail->HrefValue = ew_GetFileUploadUrl($this->_thumbnail, $this->_thumbnail->Upload->DbValue); // Add prefix/suffix
				$this->_thumbnail->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->_thumbnail->HrefValue = ew_ConvertFullUrl($this->_thumbnail->HrefValue);
			} else {
				$this->_thumbnail->HrefValue = "";
			}
			$this->_thumbnail->HrefValue2 = $this->_thumbnail->UploadPath . $this->_thumbnail->Upload->DbValue;

			// description
			$this->description->LinkCustomAttributes = "";
			$this->description->HrefValue = "";

			// youtube_url
			$this->youtube_url->LinkCustomAttributes = "";
			$this->youtube_url->HrefValue = "";

			// category_id
			$this->category_id->LinkCustomAttributes = "";
			$this->category_id->HrefValue = "";

			// m_order
			$this->m_order->LinkCustomAttributes = "";
			$this->m_order->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
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

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->model_name->FldIsDetailKey && !is_null($this->model_name->FormValue) && $this->model_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->model_name->FldCaption(), $this->model_name->ReqErrMsg));
		}
		if (!$this->model_year->FldIsDetailKey && !is_null($this->model_year->FormValue) && $this->model_year->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->model_year->FldCaption(), $this->model_year->ReqErrMsg));
		}
		if ($this->icon_menu->Upload->FileName == "" && !$this->icon_menu->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->icon_menu->FldCaption(), $this->icon_menu->ReqErrMsg));
		}
		if ($this->_thumbnail->Upload->FileName == "" && !$this->_thumbnail->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_thumbnail->FldCaption(), $this->_thumbnail->ReqErrMsg));
		}
		if (!$this->category_id->FldIsDetailKey && !is_null($this->category_id->FormValue) && $this->category_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->category_id->FldCaption(), $this->category_id->ReqErrMsg));
		}
		if (!$this->m_order->FldIsDetailKey && !is_null($this->m_order->FormValue) && $this->m_order->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->m_order->FldCaption(), $this->m_order->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->m_order->FormValue)) {
			ew_AddMessage($gsFormError, $this->m_order->FldErrMsg());
		}
		if (!$this->status->FldIsDetailKey && !is_null($this->status->FormValue) && $this->status->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->status->FldCaption(), $this->status->ReqErrMsg));
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
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$this->icon_menu->OldUploadPath = '../assets/images/model_menu/';
			$this->icon_menu->UploadPath = $this->icon_menu->OldUploadPath;
			$this->_thumbnail->OldUploadPath = '../assets/images/model/';
			$this->_thumbnail->UploadPath = $this->_thumbnail->OldUploadPath;
			$rsnew = array();

			// model_name
			$this->model_name->SetDbValueDef($rsnew, $this->model_name->CurrentValue, NULL, $this->model_name->ReadOnly);

			// model_year
			$this->model_year->SetDbValueDef($rsnew, $this->model_year->CurrentValue, NULL, $this->model_year->ReadOnly);

			// icon_menu
			if ($this->icon_menu->Visible && !$this->icon_menu->ReadOnly && !$this->icon_menu->Upload->KeepFile) {
				$this->icon_menu->Upload->DbValue = $rsold['icon_menu']; // Get original value
				if ($this->icon_menu->Upload->FileName == "") {
					$rsnew['icon_menu'] = NULL;
				} else {
					$rsnew['icon_menu'] = $this->icon_menu->Upload->FileName;
				}
			}

			// thumbnail
			if ($this->_thumbnail->Visible && !$this->_thumbnail->ReadOnly && !$this->_thumbnail->Upload->KeepFile) {
				$this->_thumbnail->Upload->DbValue = $rsold['thumbnail']; // Get original value
				if ($this->_thumbnail->Upload->FileName == "") {
					$rsnew['thumbnail'] = NULL;
				} else {
					$rsnew['thumbnail'] = $this->_thumbnail->Upload->FileName;
				}
			}

			// description
			$this->description->SetDbValueDef($rsnew, $this->description->CurrentValue, NULL, $this->description->ReadOnly);

			// youtube_url
			$this->youtube_url->SetDbValueDef($rsnew, $this->youtube_url->CurrentValue, NULL, $this->youtube_url->ReadOnly);

			// category_id
			$this->category_id->SetDbValueDef($rsnew, $this->category_id->CurrentValue, 0, $this->category_id->ReadOnly);

			// m_order
			$this->m_order->SetDbValueDef($rsnew, $this->m_order->CurrentValue, 0, $this->m_order->ReadOnly);

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, 0, $this->status->ReadOnly);
			if ($this->icon_menu->Visible && !$this->icon_menu->Upload->KeepFile) {
				$this->icon_menu->UploadPath = '../assets/images/model_menu/';
				if (!ew_Empty($this->icon_menu->Upload->Value)) {
					if ($this->icon_menu->Upload->FileName == $this->icon_menu->Upload->DbValue) { // Overwrite if same file name
						$this->icon_menu->Upload->DbValue = ""; // No need to delete any more
					} else {
						$rsnew['icon_menu'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->icon_menu->UploadPath), $rsnew['icon_menu']); // Get new file name
					}
				}
			}
			if ($this->_thumbnail->Visible && !$this->_thumbnail->Upload->KeepFile) {
				$this->_thumbnail->UploadPath = '../assets/images/model/';
				if (!ew_Empty($this->_thumbnail->Upload->Value)) {
					if ($this->_thumbnail->Upload->FileName == $this->_thumbnail->Upload->DbValue) { // Overwrite if same file name
						$this->_thumbnail->Upload->DbValue = ""; // No need to delete any more
					} else {
						$rsnew['thumbnail'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->_thumbnail->UploadPath), $rsnew['thumbnail']); // Get new file name
					}
				}
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
					if ($this->icon_menu->Visible && !$this->icon_menu->Upload->KeepFile) {
						if (!ew_Empty($this->icon_menu->Upload->Value)) {
							$this->icon_menu->Upload->SaveToFile($this->icon_menu->UploadPath, $rsnew['icon_menu'], TRUE);
						}
						if ($this->icon_menu->Upload->DbValue <> "")
							@unlink(ew_UploadPathEx(TRUE, $this->icon_menu->OldUploadPath) . $this->icon_menu->Upload->DbValue);
					}
					if ($this->_thumbnail->Visible && !$this->_thumbnail->Upload->KeepFile) {
						if (!ew_Empty($this->_thumbnail->Upload->Value)) {
							$this->_thumbnail->Upload->SaveToFile($this->_thumbnail->UploadPath, $rsnew['thumbnail'], TRUE);
						}
						if ($this->_thumbnail->Upload->DbValue <> "")
							@unlink(ew_UploadPathEx(TRUE, $this->_thumbnail->OldUploadPath) . $this->_thumbnail->Upload->DbValue);
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

		// icon_menu
		ew_CleanUploadTempPath($this->icon_menu, $this->icon_menu->Upload->Index);

		// thumbnail
		ew_CleanUploadTempPath($this->_thumbnail, $this->_thumbnail->Upload->Index);
		return $EditRow;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("modellist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_category_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `category_id` AS `LinkFld`, `category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `model_category`";
			$sWhereWrk = "";
			$this->category_id->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`category_id` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->category_id, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `category_name` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
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

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$model_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = fmodeledit = new ew_Form("fmodeledit", "edit");

// Validate form
fmodeledit.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_model_name");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model->model_name->FldCaption(), $model->model_name->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_model_year");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model->model_year->FldCaption(), $model->model_year->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "_icon_menu");
			elm = this.GetElements("fn_x" + infix + "_icon_menu");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $model->icon_menu->FldCaption(), $model->icon_menu->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "__thumbnail");
			elm = this.GetElements("fn_x" + infix + "__thumbnail");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $model->_thumbnail->FldCaption(), $model->_thumbnail->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_category_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model->category_id->FldCaption(), $model->category_id->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_m_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model->m_order->FldCaption(), $model->m_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_m_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($model->m_order->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_status");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model->status->FldCaption(), $model->status->ReqErrMsg)) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}

	// Process detail forms
	var dfs = $fobj.find("input[name='detailpage']").get();
	for (var i = 0; i < dfs.length; i++) {
		var df = dfs[i], val = df.value;
		if (val && ewForms[val])
			if (!ewForms[val].Validate())
				return false;
	}
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
fmodeledit.Lists["x_category_id"] = {"LinkField":"x_category_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_category_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"model_category"};
fmodeledit.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodeledit.Lists["x_status"].Options = <?php echo json_encode($model->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$model_edit->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $model_edit->ShowPageHeader(); ?>
<?php
$model_edit->ShowMessage();
?>
<form name="fmodeledit" id="fmodeledit" class="<?php echo $model_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($model_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $model_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="model">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<?php if ($model_edit->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div>
<?php if ($model->model_id->Visible) { // model_id ?>
	<div id="r_model_id" class="form-group">
		<label id="elh_model_model_id" class="col-sm-2 control-label ewLabel"><?php echo $model->model_id->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $model->model_id->CellAttributes() ?>>
<span id="el_model_model_id">
<span<?php echo $model->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->model_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="model" data-field="x_model_id" name="x_model_id" id="x_model_id" value="<?php echo ew_HtmlEncode($model->model_id->CurrentValue) ?>">
<?php echo $model->model_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->model_name->Visible) { // model_name ?>
	<div id="r_model_name" class="form-group">
		<label id="elh_model_model_name" for="x_model_name" class="col-sm-2 control-label ewLabel"><?php echo $model->model_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $model->model_name->CellAttributes() ?>>
<span id="el_model_model_name">
<input type="text" data-table="model" data-field="x_model_name" name="x_model_name" id="x_model_name" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($model->model_name->getPlaceHolder()) ?>" value="<?php echo $model->model_name->EditValue ?>"<?php echo $model->model_name->EditAttributes() ?>>
</span>
<?php echo $model->model_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->model_year->Visible) { // model_year ?>
	<div id="r_model_year" class="form-group">
		<label id="elh_model_model_year" for="x_model_year" class="col-sm-2 control-label ewLabel"><?php echo $model->model_year->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $model->model_year->CellAttributes() ?>>
<span id="el_model_model_year">
<input type="text" data-table="model" data-field="x_model_year" name="x_model_year" id="x_model_year" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($model->model_year->getPlaceHolder()) ?>" value="<?php echo $model->model_year->EditValue ?>"<?php echo $model->model_year->EditAttributes() ?>>
</span>
<?php echo $model->model_year->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->icon_menu->Visible) { // icon_menu ?>
	<div id="r_icon_menu" class="form-group">
		<label id="elh_model_icon_menu" class="col-sm-2 control-label ewLabel"><?php echo $model->icon_menu->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $model->icon_menu->CellAttributes() ?>>
<span id="el_model_icon_menu">
<div id="fd_x_icon_menu">
<span title="<?php echo $model->icon_menu->FldTitle() ? $model->icon_menu->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model->icon_menu->ReadOnly || $model->icon_menu->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="model" data-field="x_icon_menu" name="x_icon_menu" id="x_icon_menu"<?php echo $model->icon_menu->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_icon_menu" id= "fn_x_icon_menu" value="<?php echo $model->icon_menu->Upload->FileName ?>">
<?php if (@$_POST["fa_x_icon_menu"] == "0") { ?>
<input type="hidden" name="fa_x_icon_menu" id= "fa_x_icon_menu" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_icon_menu" id= "fa_x_icon_menu" value="1">
<?php } ?>
<input type="hidden" name="fs_x_icon_menu" id= "fs_x_icon_menu" value="150">
<input type="hidden" name="fx_x_icon_menu" id= "fx_x_icon_menu" value="<?php echo $model->icon_menu->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_icon_menu" id= "fm_x_icon_menu" value="<?php echo $model->icon_menu->UploadMaxFileSize ?>">
</div>
<table id="ft_x_icon_menu" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $model->icon_menu->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->_thumbnail->Visible) { // thumbnail ?>
	<div id="r__thumbnail" class="form-group">
		<label id="elh_model__thumbnail" class="col-sm-2 control-label ewLabel"><?php echo $model->_thumbnail->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $model->_thumbnail->CellAttributes() ?>>
<span id="el_model__thumbnail">
<div id="fd_x__thumbnail">
<span title="<?php echo $model->_thumbnail->FldTitle() ? $model->_thumbnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model->_thumbnail->ReadOnly || $model->_thumbnail->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="model" data-field="x__thumbnail" name="x__thumbnail" id="x__thumbnail"<?php echo $model->_thumbnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x__thumbnail" id= "fn_x__thumbnail" value="<?php echo $model->_thumbnail->Upload->FileName ?>">
<?php if (@$_POST["fa_x__thumbnail"] == "0") { ?>
<input type="hidden" name="fa_x__thumbnail" id= "fa_x__thumbnail" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x__thumbnail" id= "fa_x__thumbnail" value="1">
<?php } ?>
<input type="hidden" name="fs_x__thumbnail" id= "fs_x__thumbnail" value="150">
<input type="hidden" name="fx_x__thumbnail" id= "fx_x__thumbnail" value="<?php echo $model->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x__thumbnail" id= "fm_x__thumbnail" value="<?php echo $model->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x__thumbnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $model->_thumbnail->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->description->Visible) { // description ?>
	<div id="r_description" class="form-group">
		<label id="elh_model_description" class="col-sm-2 control-label ewLabel"><?php echo $model->description->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $model->description->CellAttributes() ?>>
<span id="el_model_description">
<?php ew_AppendClass($model->description->EditAttrs["class"], "editor"); ?>
<textarea data-table="model" data-field="x_description" name="x_description" id="x_description" cols="55" rows="6" placeholder="<?php echo ew_HtmlEncode($model->description->getPlaceHolder()) ?>"<?php echo $model->description->EditAttributes() ?>><?php echo $model->description->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fmodeledit", "x_description", 55, 6, <?php echo ($model->description->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $model->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->youtube_url->Visible) { // youtube_url ?>
	<div id="r_youtube_url" class="form-group">
		<label id="elh_model_youtube_url" for="x_youtube_url" class="col-sm-2 control-label ewLabel"><?php echo $model->youtube_url->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $model->youtube_url->CellAttributes() ?>>
<span id="el_model_youtube_url">
<input type="text" data-table="model" data-field="x_youtube_url" name="x_youtube_url" id="x_youtube_url" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($model->youtube_url->getPlaceHolder()) ?>" value="<?php echo $model->youtube_url->EditValue ?>"<?php echo $model->youtube_url->EditAttributes() ?>>
</span>
<?php echo $model->youtube_url->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->category_id->Visible) { // category_id ?>
	<div id="r_category_id" class="form-group">
		<label id="elh_model_category_id" for="x_category_id" class="col-sm-2 control-label ewLabel"><?php echo $model->category_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $model->category_id->CellAttributes() ?>>
<span id="el_model_category_id">
<select data-table="model" data-field="x_category_id" data-value-separator="<?php echo $model->category_id->DisplayValueSeparatorAttribute() ?>" id="x_category_id" name="x_category_id"<?php echo $model->category_id->EditAttributes() ?>>
<?php echo $model->category_id->SelectOptionListHtml("x_category_id") ?>
</select>
<input type="hidden" name="s_x_category_id" id="s_x_category_id" value="<?php echo $model->category_id->LookupFilterQuery() ?>">
</span>
<?php echo $model->category_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->m_order->Visible) { // m_order ?>
	<div id="r_m_order" class="form-group">
		<label id="elh_model_m_order" for="x_m_order" class="col-sm-2 control-label ewLabel"><?php echo $model->m_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $model->m_order->CellAttributes() ?>>
<span id="el_model_m_order">
<input type="text" data-table="model" data-field="x_m_order" name="x_m_order" id="x_m_order" size="30" placeholder="<?php echo ew_HtmlEncode($model->m_order->getPlaceHolder()) ?>" value="<?php echo $model->m_order->EditValue ?>"<?php echo $model->m_order->EditAttributes() ?>>
</span>
<?php echo $model->m_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_model_status" for="x_status" class="col-sm-2 control-label ewLabel"><?php echo $model->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="col-sm-10"><div<?php echo $model->status->CellAttributes() ?>>
<span id="el_model_status">
<select data-table="model" data-field="x_status" data-value-separator="<?php echo $model->status->DisplayValueSeparatorAttribute() ?>" id="x_status" name="x_status"<?php echo $model->status->EditAttributes() ?>>
<?php echo $model->status->SelectOptionListHtml("x_status") ?>
</select>
</span>
<?php echo $model->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div>
<?php if (!$model_edit->IsModal) { ?>
<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $model_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div>
</div>
<?php } ?>
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
