<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "featureinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "modelinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$feature_edit = NULL; // Initialize page object first

class cfeature_edit extends cfeature {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{086EEFE9-31D6-48E2-919A-4B361863B384}';

	// Table name
	var $TableName = 'feature';

	// Page object name
	var $PageObjName = 'feature_edit';

	// Page headings
	var $Heading = '';
	var $Subheading = '';

	// Page heading
	function PageHeading() {
		global $Language;
		if ($this->Heading <> "")
			return $this->Heading;
		if (method_exists($this, "TableCaption"))
			return $this->TableCaption();
		return "";
	}

	// Page subheading
	function PageSubheading() {
		global $Language;
		if ($this->Subheading <> "")
			return $this->Subheading;
		if ($this->TableName)
			return $Language->Phrase($this->PageID);
		return "";
	}

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
		if (!$this->CheckToken || !ew_IsPost())
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

		// Table object (feature)
		if (!isset($GLOBALS["feature"]) || get_class($GLOBALS["feature"]) == "cfeature") {
			$GLOBALS["feature"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["feature"];
		}

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Table object (model)
		if (!isset($GLOBALS['model'])) $GLOBALS['model'] = new cmodel();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'feature', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"]))
			$GLOBALS["gTimer"] = new cTimer();

		// Debug message
		ew_LoadDebugMsg();

		// Open connection
		if (!isset($conn))
			$conn = ew_Connect($this->DBID);

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

		// Is modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");

		// User profile
		$UserProfile = new cUserProfile();

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
				$this->Page_Terminate(ew_GetUrl("featurelist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 
		// Create form object

		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->feature_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->feature_id->Visible = FALSE;
		$this->top_title->SetVisibility();
		$this->title->SetVisibility();
		$this->model_id->SetVisibility();
		$this->_thumbnail->SetVisibility();
		$this->long_des->SetVisibility();
		$this->f_order->SetVisibility();

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
		global $EW_EXPORT, $feature;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($feature);
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
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "featureview.php")
						$row["view"] = "1";
				} else { // List page should not be shown as modal => error
					$row["error"] = $this->getFailureMessage();
					$this->clearFailureMessage();
				}
				header("Content-Type: application/json; charset=utf-8");
				echo ew_ConvertToUtf8(ew_ArrayToJson(array($row)));
			} else {
				ew_SaveDebugMsg();
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewEditForm";
	var $IsModal = FALSE;
	var $IsMobileOrModal = FALSE;
	var $DbMasterFilter;
	var $DbDetailFilter;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gbSkipHeaderFooter;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$this->IsMobileOrModal = ew_IsMobile() || $this->IsModal;
		$this->FormClassName = "ewForm ewEditForm form-horizontal";
		$sReturnUrl = "";
		$loaded = FALSE;
		$postBack = FALSE;

		// Set up current action and primary key
		if (@$_POST["a_edit"] <> "") {
			$this->CurrentAction = $_POST["a_edit"]; // Get action code
			if ($this->CurrentAction <> "I") // Not reload record, handle as postback
				$postBack = TRUE;

			// Load key from Form
			if ($objForm->HasValue("x_feature_id")) {
				$this->feature_id->setFormValue($objForm->GetValue("x_feature_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["feature_id"])) {
				$this->feature_id->setQueryStringValue($_GET["feature_id"]);
				$loadByQuery = TRUE;
			} else {
				$this->feature_id->CurrentValue = NULL;
			}
		}

		// Set up master detail parameters
		$this->SetupMasterParms();

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values
		}

		// Validate form if post back
		if ($postBack) {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = ""; // Form error, reset action
				$this->setFailureMessage($gsFormError);
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues();
			}
		}

		// Perform current action
		switch ($this->CurrentAction) {
			case "I": // Get a record to display
				if (!$loaded) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("featurelist.php"); // No matching record, return to list
				}
				break;
			Case "U": // Update
				$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "featurelist.php")
					$sReturnUrl = $this->AddMasterUrl($sReturnUrl); // List page, return to List page with correct master key if necessary
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

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Render the record
		$this->RowType = EW_ROWTYPE_EDIT; // Render as Edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Set up starting record parameters
	function SetupStartRec() {
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
		$this->_thumbnail->Upload->Index = $objForm->Index;
		$this->_thumbnail->Upload->UploadFile();
		$this->_thumbnail->CurrentValue = $this->_thumbnail->Upload->FileName;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->feature_id->FldIsDetailKey)
			$this->feature_id->setFormValue($objForm->GetValue("x_feature_id"));
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
		$this->feature_id->CurrentValue = $this->feature_id->FormValue;
		$this->top_title->CurrentValue = $this->top_title->FormValue;
		$this->title->CurrentValue = $this->title->FormValue;
		$this->model_id->CurrentValue = $this->model_id->FormValue;
		$this->long_des->CurrentValue = $this->long_des->FormValue;
		$this->f_order->CurrentValue = $this->f_order->FormValue;
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
	function LoadRowValues($rs = NULL) {
		if ($rs && !$rs->EOF)
			$row = $rs->fields;
		else
			$row = $this->NewRow(); 

		// Call Row Selected event
		$this->Row_Selected($row);
		if (!$rs || $rs->EOF)
			return;
		$this->feature_id->setDbValue($row['feature_id']);
		$this->top_title->setDbValue($row['top_title']);
		$this->title->setDbValue($row['title']);
		$this->model_id->setDbValue($row['model_id']);
		$this->_thumbnail->Upload->DbValue = $row['thumbnail'];
		$this->_thumbnail->setDbValue($this->_thumbnail->Upload->DbValue);
		$this->long_des->setDbValue($row['long_des']);
		$this->f_order->setDbValue($row['f_order']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['feature_id'] = NULL;
		$row['top_title'] = NULL;
		$row['title'] = NULL;
		$row['model_id'] = NULL;
		$row['thumbnail'] = NULL;
		$row['long_des'] = NULL;
		$row['f_order'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->feature_id->DbValue = $row['feature_id'];
		$this->top_title->DbValue = $row['top_title'];
		$this->title->DbValue = $row['title'];
		$this->model_id->DbValue = $row['model_id'];
		$this->_thumbnail->Upload->DbValue = $row['thumbnail'];
		$this->long_des->DbValue = $row['long_des'];
		$this->f_order->DbValue = $row['f_order'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("feature_id")) <> "")
			$this->feature_id->CurrentValue = $this->getKey("feature_id"); // feature_id
		else
			$bValidKey = FALSE;

		// Load old record
		$this->OldRecordset = NULL;
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
		}
		$this->LoadRowValues($this->OldRecordset); // Load row values
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

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
			$sFilterWrk = "`model_id`" . ew_SearchString("=", $this->model_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `model_id`, `model_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `model`";
		$sWhereWrk = "";
		$this->model_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->model_id, $sWhereWrk); // Call Lookup Selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `model_name` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->model_id->ViewValue = $this->model_id->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->model_id->ViewValue = $this->model_id->CurrentValue;
			}
		} else {
			$this->model_id->ViewValue = NULL;
		}
		$this->model_id->ViewCustomAttributes = "";

		// thumbnail
		$this->_thumbnail->UploadPath = '../assets/images/feature/';
		if (!ew_Empty($this->_thumbnail->Upload->DbValue)) {
			$this->_thumbnail->ImageWidth = 200;
			$this->_thumbnail->ImageHeight = 0;
			$this->_thumbnail->ImageAlt = $this->_thumbnail->FldAlt();
			$this->_thumbnail->ViewValue = $this->_thumbnail->Upload->DbValue;
		} else {
			$this->_thumbnail->ViewValue = "";
		}
		$this->_thumbnail->ViewCustomAttributes = "";

		// long_des
		$this->long_des->ViewValue = $this->long_des->CurrentValue;
		$this->long_des->ViewCustomAttributes = "";

		// f_order
		$this->f_order->ViewValue = $this->f_order->CurrentValue;
		$this->f_order->ViewCustomAttributes = "";

			// feature_id
			$this->feature_id->LinkCustomAttributes = "";
			$this->feature_id->HrefValue = "";
			$this->feature_id->TooltipValue = "";

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
			$this->_thumbnail->LinkCustomAttributes = "";
			$this->_thumbnail->UploadPath = '../assets/images/feature/';
			if (!ew_Empty($this->_thumbnail->Upload->DbValue)) {
				$this->_thumbnail->HrefValue = ew_GetFileUploadUrl($this->_thumbnail, $this->_thumbnail->Upload->DbValue); // Add prefix/suffix
				$this->_thumbnail->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->_thumbnail->HrefValue = ew_FullUrl($this->_thumbnail->HrefValue, "href");
			} else {
				$this->_thumbnail->HrefValue = "";
			}
			$this->_thumbnail->HrefValue2 = $this->_thumbnail->UploadPath . $this->_thumbnail->Upload->DbValue;
			$this->_thumbnail->TooltipValue = "";
			if ($this->_thumbnail->UseColorbox) {
				if (ew_Empty($this->_thumbnail->TooltipValue))
					$this->_thumbnail->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->_thumbnail->LinkAttrs["data-rel"] = "feature_x__thumbnail";
				ew_AppendClass($this->_thumbnail->LinkAttrs["class"], "ewLightbox");
			}

			// long_des
			$this->long_des->LinkCustomAttributes = "";
			$this->long_des->HrefValue = "";
			$this->long_des->TooltipValue = "";

			// f_order
			$this->f_order->LinkCustomAttributes = "";
			$this->f_order->HrefValue = "";
			$this->f_order->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// feature_id
			$this->feature_id->EditAttrs["class"] = "form-control";
			$this->feature_id->EditCustomAttributes = "";
			$this->feature_id->EditValue = $this->feature_id->CurrentValue;
			$this->feature_id->ViewCustomAttributes = "";

			// top_title
			$this->top_title->EditAttrs["class"] = "form-control";
			$this->top_title->EditCustomAttributes = "";
			$this->top_title->EditValue = ew_HtmlEncode($this->top_title->CurrentValue);
			$this->top_title->PlaceHolder = ew_RemoveHtml($this->top_title->FldCaption());

			// title
			$this->title->EditAttrs["class"] = "form-control";
			$this->title->EditCustomAttributes = "";
			$this->title->EditValue = ew_HtmlEncode($this->title->CurrentValue);
			$this->title->PlaceHolder = ew_RemoveHtml($this->title->FldCaption());

			// model_id
			$this->model_id->EditAttrs["class"] = "form-control";
			$this->model_id->EditCustomAttributes = "";
			if ($this->model_id->getSessionValue() <> "") {
				$this->model_id->CurrentValue = $this->model_id->getSessionValue();
			if (strval($this->model_id->CurrentValue) <> "") {
				$sFilterWrk = "`model_id`" . ew_SearchString("=", $this->model_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `model_id`, `model_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `model`";
			$sWhereWrk = "";
			$this->model_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->model_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `model_name` ASC";
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = $rswrk->fields('DispFld');
					$this->model_id->ViewValue = $this->model_id->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->model_id->ViewValue = $this->model_id->CurrentValue;
				}
			} else {
				$this->model_id->ViewValue = NULL;
			}
			$this->model_id->ViewCustomAttributes = "";
			} else {
			if (trim(strval($this->model_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`model_id`" . ew_SearchString("=", $this->model_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `model_id`, `model_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `model`";
			$sWhereWrk = "";
			$this->model_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->model_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `model_name` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->model_id->EditValue = $arwrk;
			}

			// thumbnail
			$this->_thumbnail->EditAttrs["class"] = "form-control";
			$this->_thumbnail->EditCustomAttributes = "";
			$this->_thumbnail->UploadPath = '../assets/images/feature/';
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

			// long_des
			$this->long_des->EditAttrs["class"] = "form-control";
			$this->long_des->EditCustomAttributes = "";
			$this->long_des->EditValue = ew_HtmlEncode($this->long_des->CurrentValue);
			$this->long_des->PlaceHolder = ew_RemoveHtml($this->long_des->FldCaption());

			// f_order
			$this->f_order->EditAttrs["class"] = "form-control";
			$this->f_order->EditCustomAttributes = "";
			$this->f_order->EditValue = ew_HtmlEncode($this->f_order->CurrentValue);
			$this->f_order->PlaceHolder = ew_RemoveHtml($this->f_order->FldCaption());

			// Edit refer script
			// feature_id

			$this->feature_id->LinkCustomAttributes = "";
			$this->feature_id->HrefValue = "";

			// top_title
			$this->top_title->LinkCustomAttributes = "";
			$this->top_title->HrefValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";

			// model_id
			$this->model_id->LinkCustomAttributes = "";
			$this->model_id->HrefValue = "";

			// thumbnail
			$this->_thumbnail->LinkCustomAttributes = "";
			$this->_thumbnail->UploadPath = '../assets/images/feature/';
			if (!ew_Empty($this->_thumbnail->Upload->DbValue)) {
				$this->_thumbnail->HrefValue = ew_GetFileUploadUrl($this->_thumbnail, $this->_thumbnail->Upload->DbValue); // Add prefix/suffix
				$this->_thumbnail->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->_thumbnail->HrefValue = ew_FullUrl($this->_thumbnail->HrefValue, "href");
			} else {
				$this->_thumbnail->HrefValue = "";
			}
			$this->_thumbnail->HrefValue2 = $this->_thumbnail->UploadPath . $this->_thumbnail->Upload->DbValue;

			// long_des
			$this->long_des->LinkCustomAttributes = "";
			$this->long_des->HrefValue = "";

			// f_order
			$this->f_order->LinkCustomAttributes = "";
			$this->f_order->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD || $this->RowType == EW_ROWTYPE_EDIT || $this->RowType == EW_ROWTYPE_SEARCH) // Add/Edit/Search row
			$this->SetupFieldTitles();

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
		if (!$this->top_title->FldIsDetailKey && !is_null($this->top_title->FormValue) && $this->top_title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->top_title->FldCaption(), $this->top_title->ReqErrMsg));
		}
		if (!$this->title->FldIsDetailKey && !is_null($this->title->FormValue) && $this->title->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->title->FldCaption(), $this->title->ReqErrMsg));
		}
		if (!$this->model_id->FldIsDetailKey && !is_null($this->model_id->FormValue) && $this->model_id->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->model_id->FldCaption(), $this->model_id->ReqErrMsg));
		}
		if ($this->_thumbnail->Upload->FileName == "" && !$this->_thumbnail->Upload->KeepFile) {
			ew_AddMessage($gsFormError, str_replace("%s", $this->_thumbnail->FldCaption(), $this->_thumbnail->ReqErrMsg));
		}
		if (!$this->f_order->FldIsDetailKey && !is_null($this->f_order->FormValue) && $this->f_order->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->f_order->FldCaption(), $this->f_order->ReqErrMsg));
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
			$this->_thumbnail->OldUploadPath = '../assets/images/feature/';
			$this->_thumbnail->UploadPath = $this->_thumbnail->OldUploadPath;
			$rsnew = array();

			// top_title
			$this->top_title->SetDbValueDef($rsnew, $this->top_title->CurrentValue, NULL, $this->top_title->ReadOnly);

			// title
			$this->title->SetDbValueDef($rsnew, $this->title->CurrentValue, NULL, $this->title->ReadOnly);

			// model_id
			$this->model_id->SetDbValueDef($rsnew, $this->model_id->CurrentValue, 0, $this->model_id->ReadOnly);

			// thumbnail
			if ($this->_thumbnail->Visible && !$this->_thumbnail->ReadOnly && !$this->_thumbnail->Upload->KeepFile) {
				$this->_thumbnail->Upload->DbValue = $rsold['thumbnail']; // Get original value
				if ($this->_thumbnail->Upload->FileName == "") {
					$rsnew['thumbnail'] = NULL;
				} else {
					$rsnew['thumbnail'] = $this->_thumbnail->Upload->FileName;
				}
			}

			// long_des
			$this->long_des->SetDbValueDef($rsnew, $this->long_des->CurrentValue, NULL, $this->long_des->ReadOnly);

			// f_order
			$this->f_order->SetDbValueDef($rsnew, $this->f_order->CurrentValue, 0, $this->f_order->ReadOnly);

			// Check referential integrity for master table 'model'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_model();
			$KeyValue = isset($rsnew['model_id']) ? $rsnew['model_id'] : $rsold['model_id'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@model_id@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				if (!isset($GLOBALS["model"])) $GLOBALS["model"] = new cmodel();
				$rsmaster = $GLOBALS["model"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "model", $Language->Phrase("RelatedRecordRequired"));
				$this->setFailureMessage($sRelatedRecordMsg);
				$rs->Close();
				return FALSE;
			}
			if ($this->_thumbnail->Visible && !$this->_thumbnail->Upload->KeepFile) {
				$this->_thumbnail->UploadPath = '../assets/images/feature/';
				$OldFiles = ew_Empty($this->_thumbnail->Upload->DbValue) ? array() : array($this->_thumbnail->Upload->DbValue);
				if (!ew_Empty($this->_thumbnail->Upload->FileName)) {
					$NewFiles = array($this->_thumbnail->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->_thumbnail->Upload->Index < 0) ? $this->_thumbnail->FldVar : substr($this->_thumbnail->FldVar, 0, 1) . $this->_thumbnail->Upload->Index . substr($this->_thumbnail->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->_thumbnail->TblVar) . $file)) {
								$OldFileFound = FALSE;
								$OldFileCount = count($OldFiles);
								for ($j = 0; $j < $OldFileCount; $j++) {
									$file1 = $OldFiles[$j];
									if ($file1 == $file) { // Old file found, no need to delete anymore
										unset($OldFiles[$j]);
										$OldFileFound = TRUE;
										break;
									}
								}
								if ($OldFileFound) // No need to check if file exists further
									continue;
								$file1 = ew_UploadFileNameEx($this->_thumbnail->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->_thumbnail->TblVar) . $file1) || file_exists($this->_thumbnail->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->_thumbnail->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->_thumbnail->TblVar) . $file, ew_UploadTempPath($fldvar, $this->_thumbnail->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->_thumbnail->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->_thumbnail->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->_thumbnail->SetDbValueDef($rsnew, $this->_thumbnail->Upload->FileName, NULL, $this->_thumbnail->ReadOnly);
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
					if ($this->_thumbnail->Visible && !$this->_thumbnail->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->_thumbnail->Upload->DbValue) ? array() : array($this->_thumbnail->Upload->DbValue);
						if (!ew_Empty($this->_thumbnail->Upload->FileName)) {
							$NewFiles = array($this->_thumbnail->Upload->FileName);
							$NewFiles2 = array($rsnew['thumbnail']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->_thumbnail->Upload->Index < 0) ? $this->_thumbnail->FldVar : substr($this->_thumbnail->FldVar, 0, 1) . $this->_thumbnail->Upload->Index . substr($this->_thumbnail->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->_thumbnail->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->_thumbnail->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
											$this->setFailureMessage($Language->Phrase("UploadErrMsg7"));
											return FALSE;
										}
									}
								}
							}
						} else {
							$NewFiles = array();
						}
						$OldFileCount = count($OldFiles);
						for ($i = 0; $i < $OldFileCount; $i++) {
							if ($OldFiles[$i] <> "" && !in_array($OldFiles[$i], $NewFiles))
								@unlink($this->_thumbnail->OldPhysicalUploadPath() . $OldFiles[$i]);
						}
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
		ew_CleanUploadTempPath($this->_thumbnail, $this->_thumbnail->Upload->Index);
		return $EditRow;
	}

	// Set up master/detail based on QueryString
	function SetupMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "model") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_model_id"] <> "") {
					$GLOBALS["model"]->model_id->setQueryStringValue($_GET["fk_model_id"]);
					$this->model_id->setQueryStringValue($GLOBALS["model"]->model_id->QueryStringValue);
					$this->model_id->setSessionValue($this->model_id->QueryStringValue);
					if (!is_numeric($GLOBALS["model"]->model_id->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "model") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_model_id"] <> "") {
					$GLOBALS["model"]->model_id->setFormValue($_POST["fk_model_id"]);
					$this->model_id->setFormValue($GLOBALS["model"]->model_id->FormValue);
					$this->model_id->setSessionValue($this->model_id->FormValue);
					if (!is_numeric($GLOBALS["model"]->model_id->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);
			$this->setSessionWhere($this->GetDetailFilter());

			// Reset start record counter (new master key)
			if (!$this->IsAddOrEdit()) {
				$this->StartRec = 1;
				$this->setStartRecordNumber($this->StartRec);
			}

			// Clear previous master key from Session
			if ($sMasterTblVar <> "model") {
				if ($this->model_id->CurrentValue == "") $this->model_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("featurelist.php"), "", $this->TableVar, TRUE);
		$PageId = "edit";
		$Breadcrumb->Add("edit", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_model_id":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `model_id` AS `LinkFld`, `model_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `model`";
			$sWhereWrk = "";
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`model_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->model_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `model_name` ASC";
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
if (!isset($feature_edit)) $feature_edit = new cfeature_edit();

// Page init
$feature_edit->Page_Init();

// Page main
$feature_edit->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$feature_edit->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "edit";
var CurrentForm = ffeatureedit = new ew_Form("ffeatureedit", "edit");

// Validate form
ffeatureedit.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_top_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $feature->top_title->FldCaption(), $feature->top_title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_title");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $feature->title->FldCaption(), $feature->title->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_model_id");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $feature->model_id->FldCaption(), $feature->model_id->ReqErrMsg)) ?>");
			felm = this.GetElements("x" + infix + "__thumbnail");
			elm = this.GetElements("fn_x" + infix + "__thumbnail");
			if (felm && elm && !ew_HasValue(elm))
				return this.OnError(felm, "<?php echo ew_JsEncode2(str_replace("%s", $feature->_thumbnail->FldCaption(), $feature->_thumbnail->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_f_order");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $feature->f_order->FldCaption(), $feature->f_order->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_f_order");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($feature->f_order->FldErrMsg()) ?>");

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
ffeatureedit.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
ffeatureedit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
ffeatureedit.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"model"};
ffeatureedit.Lists["x_model_id"].Data = "<?php echo $feature_edit->model_id->LookupFilterQuery(FALSE, "edit") ?>";

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $feature_edit->ShowPageHeader(); ?>
<?php
$feature_edit->ShowMessage();
?>
<form name="ffeatureedit" id="ffeatureedit" class="<?php echo $feature_edit->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($feature_edit->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $feature_edit->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="feature">
<input type="hidden" name="a_edit" id="a_edit" value="U">
<input type="hidden" name="modal" value="<?php echo intval($feature_edit->IsModal) ?>">
<?php if ($feature->getCurrentMasterTable() == "model") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="model">
<input type="hidden" name="fk_model_id" value="<?php echo $feature->model_id->getSessionValue() ?>">
<?php } ?>
<div class="ewEditDiv"><!-- page* -->
<?php if ($feature->feature_id->Visible) { // feature_id ?>
	<div id="r_feature_id" class="form-group">
		<label id="elh_feature_feature_id" class="<?php echo $feature_edit->LeftColumnClass ?>"><?php echo $feature->feature_id->FldCaption() ?></label>
		<div class="<?php echo $feature_edit->RightColumnClass ?>"><div<?php echo $feature->feature_id->CellAttributes() ?>>
<span id="el_feature_feature_id">
<span<?php echo $feature->feature_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $feature->feature_id->EditValue ?></p></span>
</span>
<input type="hidden" data-table="feature" data-field="x_feature_id" name="x_feature_id" id="x_feature_id" value="<?php echo ew_HtmlEncode($feature->feature_id->CurrentValue) ?>">
<?php echo $feature->feature_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($feature->top_title->Visible) { // top_title ?>
	<div id="r_top_title" class="form-group">
		<label id="elh_feature_top_title" for="x_top_title" class="<?php echo $feature_edit->LeftColumnClass ?>"><?php echo $feature->top_title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $feature_edit->RightColumnClass ?>"><div<?php echo $feature->top_title->CellAttributes() ?>>
<span id="el_feature_top_title">
<input type="text" data-table="feature" data-field="x_top_title" name="x_top_title" id="x_top_title" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($feature->top_title->getPlaceHolder()) ?>" value="<?php echo $feature->top_title->EditValue ?>"<?php echo $feature->top_title->EditAttributes() ?>>
</span>
<?php echo $feature->top_title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($feature->title->Visible) { // title ?>
	<div id="r_title" class="form-group">
		<label id="elh_feature_title" for="x_title" class="<?php echo $feature_edit->LeftColumnClass ?>"><?php echo $feature->title->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $feature_edit->RightColumnClass ?>"><div<?php echo $feature->title->CellAttributes() ?>>
<span id="el_feature_title">
<input type="text" data-table="feature" data-field="x_title" name="x_title" id="x_title" size="30" maxlength="50" placeholder="<?php echo ew_HtmlEncode($feature->title->getPlaceHolder()) ?>" value="<?php echo $feature->title->EditValue ?>"<?php echo $feature->title->EditAttributes() ?>>
</span>
<?php echo $feature->title->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($feature->model_id->Visible) { // model_id ?>
	<div id="r_model_id" class="form-group">
		<label id="elh_feature_model_id" for="x_model_id" class="<?php echo $feature_edit->LeftColumnClass ?>"><?php echo $feature->model_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $feature_edit->RightColumnClass ?>"><div<?php echo $feature->model_id->CellAttributes() ?>>
<?php if ($feature->model_id->getSessionValue() <> "") { ?>
<span id="el_feature_model_id">
<span<?php echo $feature->model_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $feature->model_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_model_id" name="x_model_id" value="<?php echo ew_HtmlEncode($feature->model_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_feature_model_id">
<select data-table="feature" data-field="x_model_id" data-value-separator="<?php echo $feature->model_id->DisplayValueSeparatorAttribute() ?>" id="x_model_id" name="x_model_id"<?php echo $feature->model_id->EditAttributes() ?>>
<?php echo $feature->model_id->SelectOptionListHtml("x_model_id") ?>
</select>
</span>
<?php } ?>
<?php echo $feature->model_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($feature->_thumbnail->Visible) { // thumbnail ?>
	<div id="r__thumbnail" class="form-group">
		<label id="elh_feature__thumbnail" class="<?php echo $feature_edit->LeftColumnClass ?>"><?php echo $feature->_thumbnail->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $feature_edit->RightColumnClass ?>"><div<?php echo $feature->_thumbnail->CellAttributes() ?>>
<span id="el_feature__thumbnail">
<div id="fd_x__thumbnail">
<span title="<?php echo $feature->_thumbnail->FldTitle() ? $feature->_thumbnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($feature->_thumbnail->ReadOnly || $feature->_thumbnail->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="feature" data-field="x__thumbnail" name="x__thumbnail" id="x__thumbnail"<?php echo $feature->_thumbnail->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x__thumbnail" id= "fn_x__thumbnail" value="<?php echo $feature->_thumbnail->Upload->FileName ?>">
<?php if (@$_POST["fa_x__thumbnail"] == "0") { ?>
<input type="hidden" name="fa_x__thumbnail" id= "fa_x__thumbnail" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x__thumbnail" id= "fa_x__thumbnail" value="1">
<?php } ?>
<input type="hidden" name="fs_x__thumbnail" id= "fs_x__thumbnail" value="150">
<input type="hidden" name="fx_x__thumbnail" id= "fx_x__thumbnail" value="<?php echo $feature->_thumbnail->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x__thumbnail" id= "fm_x__thumbnail" value="<?php echo $feature->_thumbnail->UploadMaxFileSize ?>">
</div>
<table id="ft_x__thumbnail" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $feature->_thumbnail->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($feature->long_des->Visible) { // long_des ?>
	<div id="r_long_des" class="form-group">
		<label id="elh_feature_long_des" class="<?php echo $feature_edit->LeftColumnClass ?>"><?php echo $feature->long_des->FldCaption() ?></label>
		<div class="<?php echo $feature_edit->RightColumnClass ?>"><div<?php echo $feature->long_des->CellAttributes() ?>>
<span id="el_feature_long_des">
<?php ew_AppendClass($feature->long_des->EditAttrs["class"], "editor"); ?>
<textarea data-table="feature" data-field="x_long_des" name="x_long_des" id="x_long_des" cols="45" rows="6" placeholder="<?php echo ew_HtmlEncode($feature->long_des->getPlaceHolder()) ?>"<?php echo $feature->long_des->EditAttributes() ?>><?php echo $feature->long_des->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("ffeatureedit", "x_long_des", 45, 6, <?php echo ($feature->long_des->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $feature->long_des->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($feature->f_order->Visible) { // f_order ?>
	<div id="r_f_order" class="form-group">
		<label id="elh_feature_f_order" for="x_f_order" class="<?php echo $feature_edit->LeftColumnClass ?>"><?php echo $feature->f_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $feature_edit->RightColumnClass ?>"><div<?php echo $feature->f_order->CellAttributes() ?>>
<span id="el_feature_f_order">
<input type="text" data-table="feature" data-field="x_f_order" name="x_f_order" id="x_f_order" size="30" placeholder="<?php echo ew_HtmlEncode($feature->f_order->getPlaceHolder()) ?>" value="<?php echo $feature->f_order->EditValue ?>"<?php echo $feature->f_order->EditAttributes() ?>>
</span>
<?php echo $feature->f_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$feature_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $feature_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $feature_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
<?php } ?>
</form>
<script type="text/javascript">
ffeatureedit.Init();
</script>
<?php
$feature_edit->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$feature_edit->Page_Terminate();
?>
