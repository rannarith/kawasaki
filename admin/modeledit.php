<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "modelinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "model_categoryinfo.php" ?>
<?php include_once "model_colorgridcls.php" ?>
<?php include_once "model_gallerygridcls.php" ?>
<?php include_once "featuregridcls.php" ?>
<?php include_once "specificationgridcls.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$model_edit = NULL; // Initialize page object first

class cmodel_edit extends cmodel {

	// Page ID
	var $PageID = 'edit';

	// Project ID
	var $ProjectID = '{086EEFE9-31D6-48E2-919A-4B361863B384}';

	// Table name
	var $TableName = 'model';

	// Page object name
	var $PageObjName = 'model_edit';

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

		// Table object (model)
		if (!isset($GLOBALS["model"]) || get_class($GLOBALS["model"]) == "cmodel") {
			$GLOBALS["model"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["model"];
		}

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Table object (model_category)
		if (!isset($GLOBALS['model_category'])) $GLOBALS['model_category'] = new cmodel_category();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'edit', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'model', TRUE);

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
				$this->Page_Terminate(ew_GetUrl("modellist.php"));
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
		$this->model_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->model_id->Visible = FALSE;
		$this->model_name->SetVisibility();
		$this->price->SetVisibility();
		$this->displacement->SetVisibility();
		$this->url_slug->SetVisibility();
		$this->model_logo->SetVisibility();
		$this->model_year->SetVisibility();
		$this->icon_menu->SetVisibility();
		$this->_thumbnail->SetVisibility();
		$this->full_image->SetVisibility();
		$this->description->SetVisibility();
		$this->youtube_url->SetVisibility();
		$this->category_id->SetVisibility();
		$this->m_order->SetVisibility();
		$this->seo_description->SetVisibility();
		$this->seo_keyword->SetVisibility();
		$this->status->SetVisibility();
		$this->is_feature->SetVisibility();
		$this->is_available->SetVisibility();

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

			// Get the keys for master table
			$sDetailTblVar = $this->getCurrentDetailTable();
			if ($sDetailTblVar <> "") {
				$DetailTblVar = explode(",", $sDetailTblVar);
				if (in_array("model_color", $DetailTblVar)) {

					// Process auto fill for detail table 'model_color'
					if (preg_match('/^fmodel_color(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["model_color_grid"])) $GLOBALS["model_color_grid"] = new cmodel_color_grid;
						$GLOBALS["model_color_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
				if (in_array("model_gallery", $DetailTblVar)) {

					// Process auto fill for detail table 'model_gallery'
					if (preg_match('/^fmodel_gallery(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["model_gallery_grid"])) $GLOBALS["model_gallery_grid"] = new cmodel_gallery_grid;
						$GLOBALS["model_gallery_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
				if (in_array("feature", $DetailTblVar)) {

					// Process auto fill for detail table 'feature'
					if (preg_match('/^ffeature(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["feature_grid"])) $GLOBALS["feature_grid"] = new cfeature_grid;
						$GLOBALS["feature_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
				if (in_array("specification", $DetailTblVar)) {

					// Process auto fill for detail table 'specification'
					if (preg_match('/^fspecification(grid|add|addopt|edit|update|search)$/', @$_POST["form"])) {
						if (!isset($GLOBALS["specification_grid"])) $GLOBALS["specification_grid"] = new cspecification_grid;
						$GLOBALS["specification_grid"]->Page_Init();
						$this->Page_Terminate();
						exit();
					}
				}
			}
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
			if ($this->IsModal) { // Show as modal
				$row = array("url" => $url, "modal" => "1");
				$pageName = ew_GetPageName($url);
				if ($pageName != $this->GetListUrl()) { // Not List page
					$row["caption"] = $this->GetModalCaption($pageName);
					if ($pageName == "modelview.php")
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
			if ($objForm->HasValue("x_model_id")) {
				$this->model_id->setFormValue($objForm->GetValue("x_model_id"));
			}
		} else {
			$this->CurrentAction = "I"; // Default action is display

			// Load key from QueryString
			$loadByQuery = FALSE;
			if (isset($_GET["model_id"])) {
				$this->model_id->setQueryStringValue($_GET["model_id"]);
				$loadByQuery = TRUE;
			} else {
				$this->model_id->CurrentValue = NULL;
			}
		}

		// Set up master detail parameters
		$this->SetupMasterParms();

		// Load current record
		$loaded = $this->LoadRow();

		// Process form if post back
		if ($postBack) {
			$this->LoadFormValues(); // Get form values

			// Set up detail parameters
			$this->SetupDetailParms();
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
					$this->Page_Terminate("modellist.php"); // No matching record, return to list
				}

				// Set up detail parameters
				$this->SetupDetailParms();
				break;
			Case "U": // Update
				if ($this->getCurrentDetailTable() <> "") // Master/detail edit
					$sReturnUrl = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $this->getCurrentDetailTable()); // Master/Detail view page
				else
					$sReturnUrl = $this->getReturnUrl();
				if (ew_GetPageName($sReturnUrl) == "modellist.php")
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

					// Set up detail parameters
					$this->SetupDetailParms();
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
		$this->model_logo->Upload->Index = $objForm->Index;
		$this->model_logo->Upload->UploadFile();
		$this->model_logo->CurrentValue = $this->model_logo->Upload->FileName;
		$this->icon_menu->Upload->Index = $objForm->Index;
		$this->icon_menu->Upload->UploadFile();
		$this->icon_menu->CurrentValue = $this->icon_menu->Upload->FileName;
		$this->_thumbnail->Upload->Index = $objForm->Index;
		$this->_thumbnail->Upload->UploadFile();
		$this->_thumbnail->CurrentValue = $this->_thumbnail->Upload->FileName;
		$this->full_image->Upload->Index = $objForm->Index;
		$this->full_image->Upload->UploadFile();
		$this->full_image->CurrentValue = $this->full_image->Upload->FileName;
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
		if (!$this->price->FldIsDetailKey) {
			$this->price->setFormValue($objForm->GetValue("x_price"));
		}
		if (!$this->displacement->FldIsDetailKey) {
			$this->displacement->setFormValue($objForm->GetValue("x_displacement"));
		}
		if (!$this->url_slug->FldIsDetailKey) {
			$this->url_slug->setFormValue($objForm->GetValue("x_url_slug"));
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
		if (!$this->seo_description->FldIsDetailKey) {
			$this->seo_description->setFormValue($objForm->GetValue("x_seo_description"));
		}
		if (!$this->seo_keyword->FldIsDetailKey) {
			$this->seo_keyword->setFormValue($objForm->GetValue("x_seo_keyword"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
		if (!$this->is_feature->FldIsDetailKey) {
			$this->is_feature->setFormValue($objForm->GetValue("x_is_feature"));
		}
		if (!$this->is_available->FldIsDetailKey) {
			$this->is_available->setFormValue($objForm->GetValue("x_is_available"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->model_id->CurrentValue = $this->model_id->FormValue;
		$this->model_name->CurrentValue = $this->model_name->FormValue;
		$this->price->CurrentValue = $this->price->FormValue;
		$this->displacement->CurrentValue = $this->displacement->FormValue;
		$this->url_slug->CurrentValue = $this->url_slug->FormValue;
		$this->model_year->CurrentValue = $this->model_year->FormValue;
		$this->description->CurrentValue = $this->description->FormValue;
		$this->youtube_url->CurrentValue = $this->youtube_url->FormValue;
		$this->category_id->CurrentValue = $this->category_id->FormValue;
		$this->m_order->CurrentValue = $this->m_order->FormValue;
		$this->seo_description->CurrentValue = $this->seo_description->FormValue;
		$this->seo_keyword->CurrentValue = $this->seo_keyword->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
		$this->is_feature->CurrentValue = $this->is_feature->FormValue;
		$this->is_available->CurrentValue = $this->is_available->FormValue;
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
		$this->model_id->setDbValue($row['model_id']);
		$this->model_name->setDbValue($row['model_name']);
		$this->price->setDbValue($row['price']);
		$this->displacement->setDbValue($row['displacement']);
		$this->url_slug->setDbValue($row['url_slug']);
		$this->model_logo->Upload->DbValue = $row['model_logo'];
		$this->model_logo->setDbValue($this->model_logo->Upload->DbValue);
		$this->model_year->setDbValue($row['model_year']);
		$this->icon_menu->Upload->DbValue = $row['icon_menu'];
		$this->icon_menu->setDbValue($this->icon_menu->Upload->DbValue);
		$this->_thumbnail->Upload->DbValue = $row['thumbnail'];
		$this->_thumbnail->setDbValue($this->_thumbnail->Upload->DbValue);
		$this->full_image->Upload->DbValue = $row['full_image'];
		$this->full_image->setDbValue($this->full_image->Upload->DbValue);
		$this->description->setDbValue($row['description']);
		$this->youtube_url->setDbValue($row['youtube_url']);
		$this->category_id->setDbValue($row['category_id']);
		$this->m_order->setDbValue($row['m_order']);
		$this->seo_description->setDbValue($row['seo_description']);
		$this->seo_keyword->setDbValue($row['seo_keyword']);
		$this->status->setDbValue($row['status']);
		$this->is_feature->setDbValue($row['is_feature']);
		$this->is_available->setDbValue($row['is_available']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['model_id'] = NULL;
		$row['model_name'] = NULL;
		$row['price'] = NULL;
		$row['displacement'] = NULL;
		$row['url_slug'] = NULL;
		$row['model_logo'] = NULL;
		$row['model_year'] = NULL;
		$row['icon_menu'] = NULL;
		$row['thumbnail'] = NULL;
		$row['full_image'] = NULL;
		$row['description'] = NULL;
		$row['youtube_url'] = NULL;
		$row['category_id'] = NULL;
		$row['m_order'] = NULL;
		$row['seo_description'] = NULL;
		$row['seo_keyword'] = NULL;
		$row['status'] = NULL;
		$row['is_feature'] = NULL;
		$row['is_available'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->model_id->DbValue = $row['model_id'];
		$this->model_name->DbValue = $row['model_name'];
		$this->price->DbValue = $row['price'];
		$this->displacement->DbValue = $row['displacement'];
		$this->url_slug->DbValue = $row['url_slug'];
		$this->model_logo->Upload->DbValue = $row['model_logo'];
		$this->model_year->DbValue = $row['model_year'];
		$this->icon_menu->Upload->DbValue = $row['icon_menu'];
		$this->_thumbnail->Upload->DbValue = $row['thumbnail'];
		$this->full_image->Upload->DbValue = $row['full_image'];
		$this->description->DbValue = $row['description'];
		$this->youtube_url->DbValue = $row['youtube_url'];
		$this->category_id->DbValue = $row['category_id'];
		$this->m_order->DbValue = $row['m_order'];
		$this->seo_description->DbValue = $row['seo_description'];
		$this->seo_keyword->DbValue = $row['seo_keyword'];
		$this->status->DbValue = $row['status'];
		$this->is_feature->DbValue = $row['is_feature'];
		$this->is_available->DbValue = $row['is_available'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("model_id")) <> "")
			$this->model_id->CurrentValue = $this->getKey("model_id"); // model_id
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
		// Convert decimal values if posted back

		if ($this->price->FormValue == $this->price->CurrentValue && is_numeric(ew_StrToFloat($this->price->CurrentValue)))
			$this->price->CurrentValue = ew_StrToFloat($this->price->CurrentValue);

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// model_id
		// model_name
		// price
		// displacement
		// url_slug
		// model_logo
		// model_year
		// icon_menu
		// thumbnail
		// full_image
		// description
		// youtube_url
		// category_id
		// m_order
		// seo_description
		// seo_keyword
		// status
		// is_feature
		// is_available

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// model_id
		$this->model_id->ViewValue = $this->model_id->CurrentValue;
		$this->model_id->ViewCustomAttributes = "";

		// model_name
		$this->model_name->ViewValue = $this->model_name->CurrentValue;
		$this->model_name->ViewCustomAttributes = "";

		// price
		$this->price->ViewValue = $this->price->CurrentValue;
		$this->price->ViewCustomAttributes = "";

		// displacement
		$this->displacement->ViewValue = $this->displacement->CurrentValue;
		$this->displacement->ViewCustomAttributes = "";

		// url_slug
		$this->url_slug->ViewValue = $this->url_slug->CurrentValue;
		$this->url_slug->ViewCustomAttributes = "";

		// model_logo
		$this->model_logo->UploadPath = '../assets/images/model_thumbnail/';
		if (!ew_Empty($this->model_logo->Upload->DbValue)) {
			$this->model_logo->ImageWidth = 90;
			$this->model_logo->ImageHeight = 0;
			$this->model_logo->ImageAlt = $this->model_logo->FldAlt();
			$this->model_logo->ViewValue = $this->model_logo->Upload->DbValue;
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
			$this->icon_menu->ImageWidth = 150;
			$this->icon_menu->ImageHeight = 0;
			$this->icon_menu->ImageAlt = $this->icon_menu->FldAlt();
			$this->icon_menu->ViewValue = $this->icon_menu->Upload->DbValue;
		} else {
			$this->icon_menu->ViewValue = "";
		}
		$this->icon_menu->ViewCustomAttributes = "";

		// thumbnail
		$this->_thumbnail->UploadPath = '../assets/images/model_thumbnail/';
		if (!ew_Empty($this->_thumbnail->Upload->DbValue)) {
			$this->_thumbnail->ImageWidth = 200;
			$this->_thumbnail->ImageHeight = 0;
			$this->_thumbnail->ImageAlt = $this->_thumbnail->FldAlt();
			$this->_thumbnail->ViewValue = $this->_thumbnail->Upload->DbValue;
		} else {
			$this->_thumbnail->ViewValue = "";
		}
		$this->_thumbnail->ViewCustomAttributes = "";

		// full_image
		$this->full_image->UploadPath = '../assets/images/model/';
		if (!ew_Empty($this->full_image->Upload->DbValue)) {
			$this->full_image->ImageWidth = 200;
			$this->full_image->ImageHeight = 0;
			$this->full_image->ImageAlt = $this->full_image->FldAlt();
			$this->full_image->ViewValue = $this->full_image->Upload->DbValue;
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
			$sFilterWrk = "`category_id`" . ew_SearchString("=", $this->category_id->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `category_id`, `category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `model_category`";
		$sWhereWrk = "";
		$this->category_id->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->category_id, $sWhereWrk); // Call Lookup Selecting
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

		// seo_description
		$this->seo_description->ViewValue = $this->seo_description->CurrentValue;
		$this->seo_description->ViewCustomAttributes = "";

		// seo_keyword
		$this->seo_keyword->ViewValue = $this->seo_keyword->CurrentValue;
		$this->seo_keyword->ViewCustomAttributes = "";

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = $this->status->OptionCaption($this->status->CurrentValue);
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

		// is_feature
		if (strval($this->is_feature->CurrentValue) <> "") {
			$this->is_feature->ViewValue = $this->is_feature->OptionCaption($this->is_feature->CurrentValue);
		} else {
			$this->is_feature->ViewValue = NULL;
		}
		$this->is_feature->ViewCustomAttributes = "";

		// is_available
		if (strval($this->is_available->CurrentValue) <> "") {
			$this->is_available->ViewValue = $this->is_available->OptionCaption($this->is_available->CurrentValue);
		} else {
			$this->is_available->ViewValue = NULL;
		}
		$this->is_available->ViewCustomAttributes = "";

			// model_id
			$this->model_id->LinkCustomAttributes = "";
			$this->model_id->HrefValue = "";
			$this->model_id->TooltipValue = "";

			// model_name
			$this->model_name->LinkCustomAttributes = "";
			$this->model_name->HrefValue = "";
			$this->model_name->TooltipValue = "";

			// price
			$this->price->LinkCustomAttributes = "";
			$this->price->HrefValue = "";
			$this->price->TooltipValue = "";

			// displacement
			$this->displacement->LinkCustomAttributes = "";
			$this->displacement->HrefValue = "";
			$this->displacement->TooltipValue = "";

			// url_slug
			$this->url_slug->LinkCustomAttributes = "";
			$this->url_slug->HrefValue = "";
			$this->url_slug->TooltipValue = "";

			// model_logo
			$this->model_logo->LinkCustomAttributes = "";
			$this->model_logo->UploadPath = '../assets/images/model_thumbnail/';
			if (!ew_Empty($this->model_logo->Upload->DbValue)) {
				$this->model_logo->HrefValue = ew_GetFileUploadUrl($this->model_logo, $this->model_logo->Upload->DbValue); // Add prefix/suffix
				$this->model_logo->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->model_logo->HrefValue = ew_FullUrl($this->model_logo->HrefValue, "href");
			} else {
				$this->model_logo->HrefValue = "";
			}
			$this->model_logo->HrefValue2 = $this->model_logo->UploadPath . $this->model_logo->Upload->DbValue;
			$this->model_logo->TooltipValue = "";
			if ($this->model_logo->UseColorbox) {
				if (ew_Empty($this->model_logo->TooltipValue))
					$this->model_logo->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->model_logo->LinkAttrs["data-rel"] = "model_x_model_logo";
				ew_AppendClass($this->model_logo->LinkAttrs["class"], "ewLightbox");
			}

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
				if ($this->Export <> "") $this->icon_menu->HrefValue = ew_FullUrl($this->icon_menu->HrefValue, "href");
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
			$this->_thumbnail->UploadPath = '../assets/images/model_thumbnail/';
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
				$this->_thumbnail->LinkAttrs["data-rel"] = "model_x__thumbnail";
				ew_AppendClass($this->_thumbnail->LinkAttrs["class"], "ewLightbox");
			}

			// full_image
			$this->full_image->LinkCustomAttributes = "";
			$this->full_image->UploadPath = '../assets/images/model/';
			if (!ew_Empty($this->full_image->Upload->DbValue)) {
				$this->full_image->HrefValue = ew_GetFileUploadUrl($this->full_image, $this->full_image->Upload->DbValue); // Add prefix/suffix
				$this->full_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->full_image->HrefValue = ew_FullUrl($this->full_image->HrefValue, "href");
			} else {
				$this->full_image->HrefValue = "";
			}
			$this->full_image->HrefValue2 = $this->full_image->UploadPath . $this->full_image->Upload->DbValue;
			$this->full_image->TooltipValue = "";
			if ($this->full_image->UseColorbox) {
				if (ew_Empty($this->full_image->TooltipValue))
					$this->full_image->LinkAttrs["title"] = $Language->Phrase("ViewImageGallery");
				$this->full_image->LinkAttrs["data-rel"] = "model_x_full_image";
				ew_AppendClass($this->full_image->LinkAttrs["class"], "ewLightbox");
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

			// seo_description
			$this->seo_description->LinkCustomAttributes = "";
			$this->seo_description->HrefValue = "";
			$this->seo_description->TooltipValue = "";

			// seo_keyword
			$this->seo_keyword->LinkCustomAttributes = "";
			$this->seo_keyword->HrefValue = "";
			$this->seo_keyword->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// is_feature
			$this->is_feature->LinkCustomAttributes = "";
			$this->is_feature->HrefValue = "";
			$this->is_feature->TooltipValue = "";

			// is_available
			$this->is_available->LinkCustomAttributes = "";
			$this->is_available->HrefValue = "";
			$this->is_available->TooltipValue = "";
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

			// price
			$this->price->EditAttrs["class"] = "form-control";
			$this->price->EditCustomAttributes = "";
			$this->price->EditValue = ew_HtmlEncode($this->price->CurrentValue);
			$this->price->PlaceHolder = ew_RemoveHtml($this->price->FldCaption());
			if (strval($this->price->EditValue) <> "" && is_numeric($this->price->EditValue)) $this->price->EditValue = ew_FormatNumber($this->price->EditValue, -2, -1, -2, 0);

			// displacement
			$this->displacement->EditAttrs["class"] = "form-control";
			$this->displacement->EditCustomAttributes = "";
			$this->displacement->EditValue = ew_HtmlEncode($this->displacement->CurrentValue);
			$this->displacement->PlaceHolder = ew_RemoveHtml($this->displacement->FldCaption());

			// url_slug
			$this->url_slug->EditAttrs["class"] = "form-control";
			$this->url_slug->EditCustomAttributes = "";
			$this->url_slug->EditValue = ew_HtmlEncode($this->url_slug->CurrentValue);
			$this->url_slug->PlaceHolder = ew_RemoveHtml($this->url_slug->FldCaption());

			// model_logo
			$this->model_logo->EditAttrs["class"] = "form-control";
			$this->model_logo->EditCustomAttributes = "";
			$this->model_logo->UploadPath = '../assets/images/model_thumbnail/';
			if (!ew_Empty($this->model_logo->Upload->DbValue)) {
				$this->model_logo->ImageWidth = 90;
				$this->model_logo->ImageHeight = 0;
				$this->model_logo->ImageAlt = $this->model_logo->FldAlt();
				$this->model_logo->EditValue = $this->model_logo->Upload->DbValue;
			} else {
				$this->model_logo->EditValue = "";
			}
			if (!ew_Empty($this->model_logo->CurrentValue))
					$this->model_logo->Upload->FileName = $this->model_logo->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->model_logo);

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
				$this->icon_menu->ImageWidth = 150;
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
			$this->_thumbnail->UploadPath = '../assets/images/model_thumbnail/';
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

			// full_image
			$this->full_image->EditAttrs["class"] = "form-control";
			$this->full_image->EditCustomAttributes = "";
			$this->full_image->UploadPath = '../assets/images/model/';
			if (!ew_Empty($this->full_image->Upload->DbValue)) {
				$this->full_image->ImageWidth = 200;
				$this->full_image->ImageHeight = 0;
				$this->full_image->ImageAlt = $this->full_image->FldAlt();
				$this->full_image->EditValue = $this->full_image->Upload->DbValue;
			} else {
				$this->full_image->EditValue = "";
			}
			if (!ew_Empty($this->full_image->CurrentValue))
					$this->full_image->Upload->FileName = $this->full_image->CurrentValue;
			if ($this->CurrentAction == "I" && !$this->EventCancelled) ew_RenderUploadField($this->full_image);

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
			if ($this->category_id->getSessionValue() <> "") {
				$this->category_id->CurrentValue = $this->category_id->getSessionValue();
			if (strval($this->category_id->CurrentValue) <> "") {
				$sFilterWrk = "`category_id`" . ew_SearchString("=", $this->category_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			$sSqlWrk = "SELECT `category_id`, `category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `model_category`";
			$sWhereWrk = "";
			$this->category_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->category_id, $sWhereWrk); // Call Lookup Selecting
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
			} else {
			if (trim(strval($this->category_id->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`category_id`" . ew_SearchString("=", $this->category_id->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `category_id`, `category_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `model_category`";
			$sWhereWrk = "";
			$this->category_id->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->category_id, $sWhereWrk); // Call Lookup Selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `category_name` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->category_id->EditValue = $arwrk;
			}

			// m_order
			$this->m_order->EditAttrs["class"] = "form-control";
			$this->m_order->EditCustomAttributes = "";
			$this->m_order->EditValue = ew_HtmlEncode($this->m_order->CurrentValue);
			$this->m_order->PlaceHolder = ew_RemoveHtml($this->m_order->FldCaption());

			// seo_description
			$this->seo_description->EditAttrs["class"] = "form-control";
			$this->seo_description->EditCustomAttributes = "";
			$this->seo_description->EditValue = ew_HtmlEncode($this->seo_description->CurrentValue);
			$this->seo_description->PlaceHolder = ew_RemoveHtml($this->seo_description->FldCaption());

			// seo_keyword
			$this->seo_keyword->EditAttrs["class"] = "form-control";
			$this->seo_keyword->EditCustomAttributes = "";
			$this->seo_keyword->EditValue = ew_HtmlEncode($this->seo_keyword->CurrentValue);
			$this->seo_keyword->PlaceHolder = ew_RemoveHtml($this->seo_keyword->FldCaption());

			// status
			$this->status->EditAttrs["class"] = "form-control";
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = $this->status->Options(TRUE);

			// is_feature
			$this->is_feature->EditCustomAttributes = "";
			$this->is_feature->EditValue = $this->is_feature->Options(FALSE);

			// is_available
			$this->is_available->EditCustomAttributes = "";
			$this->is_available->EditValue = $this->is_available->Options(FALSE);

			// Edit refer script
			// model_id

			$this->model_id->LinkCustomAttributes = "";
			$this->model_id->HrefValue = "";

			// model_name
			$this->model_name->LinkCustomAttributes = "";
			$this->model_name->HrefValue = "";

			// price
			$this->price->LinkCustomAttributes = "";
			$this->price->HrefValue = "";

			// displacement
			$this->displacement->LinkCustomAttributes = "";
			$this->displacement->HrefValue = "";

			// url_slug
			$this->url_slug->LinkCustomAttributes = "";
			$this->url_slug->HrefValue = "";

			// model_logo
			$this->model_logo->LinkCustomAttributes = "";
			$this->model_logo->UploadPath = '../assets/images/model_thumbnail/';
			if (!ew_Empty($this->model_logo->Upload->DbValue)) {
				$this->model_logo->HrefValue = ew_GetFileUploadUrl($this->model_logo, $this->model_logo->Upload->DbValue); // Add prefix/suffix
				$this->model_logo->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->model_logo->HrefValue = ew_FullUrl($this->model_logo->HrefValue, "href");
			} else {
				$this->model_logo->HrefValue = "";
			}
			$this->model_logo->HrefValue2 = $this->model_logo->UploadPath . $this->model_logo->Upload->DbValue;

			// model_year
			$this->model_year->LinkCustomAttributes = "";
			$this->model_year->HrefValue = "";

			// icon_menu
			$this->icon_menu->LinkCustomAttributes = "";
			$this->icon_menu->UploadPath = '../assets/images/model_menu/';
			if (!ew_Empty($this->icon_menu->Upload->DbValue)) {
				$this->icon_menu->HrefValue = ew_GetFileUploadUrl($this->icon_menu, $this->icon_menu->Upload->DbValue); // Add prefix/suffix
				$this->icon_menu->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->icon_menu->HrefValue = ew_FullUrl($this->icon_menu->HrefValue, "href");
			} else {
				$this->icon_menu->HrefValue = "";
			}
			$this->icon_menu->HrefValue2 = $this->icon_menu->UploadPath . $this->icon_menu->Upload->DbValue;

			// thumbnail
			$this->_thumbnail->LinkCustomAttributes = "";
			$this->_thumbnail->UploadPath = '../assets/images/model_thumbnail/';
			if (!ew_Empty($this->_thumbnail->Upload->DbValue)) {
				$this->_thumbnail->HrefValue = ew_GetFileUploadUrl($this->_thumbnail, $this->_thumbnail->Upload->DbValue); // Add prefix/suffix
				$this->_thumbnail->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->_thumbnail->HrefValue = ew_FullUrl($this->_thumbnail->HrefValue, "href");
			} else {
				$this->_thumbnail->HrefValue = "";
			}
			$this->_thumbnail->HrefValue2 = $this->_thumbnail->UploadPath . $this->_thumbnail->Upload->DbValue;

			// full_image
			$this->full_image->LinkCustomAttributes = "";
			$this->full_image->UploadPath = '../assets/images/model/';
			if (!ew_Empty($this->full_image->Upload->DbValue)) {
				$this->full_image->HrefValue = ew_GetFileUploadUrl($this->full_image, $this->full_image->Upload->DbValue); // Add prefix/suffix
				$this->full_image->LinkAttrs["target"] = ""; // Add target
				if ($this->Export <> "") $this->full_image->HrefValue = ew_FullUrl($this->full_image->HrefValue, "href");
			} else {
				$this->full_image->HrefValue = "";
			}
			$this->full_image->HrefValue2 = $this->full_image->UploadPath . $this->full_image->Upload->DbValue;

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

			// seo_description
			$this->seo_description->LinkCustomAttributes = "";
			$this->seo_description->HrefValue = "";

			// seo_keyword
			$this->seo_keyword->LinkCustomAttributes = "";
			$this->seo_keyword->HrefValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";

			// is_feature
			$this->is_feature->LinkCustomAttributes = "";
			$this->is_feature->HrefValue = "";

			// is_available
			$this->is_available->LinkCustomAttributes = "";
			$this->is_available->HrefValue = "";
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
		if (!$this->model_name->FldIsDetailKey && !is_null($this->model_name->FormValue) && $this->model_name->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->model_name->FldCaption(), $this->model_name->ReqErrMsg));
		}
		if (!$this->price->FldIsDetailKey && !is_null($this->price->FormValue) && $this->price->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->price->FldCaption(), $this->price->ReqErrMsg));
		}
		if (!ew_CheckNumber($this->price->FormValue)) {
			ew_AddMessage($gsFormError, $this->price->FldErrMsg());
		}
		if (!$this->url_slug->FldIsDetailKey && !is_null($this->url_slug->FormValue) && $this->url_slug->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->url_slug->FldCaption(), $this->url_slug->ReqErrMsg));
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

		// Validate detail grid
		$DetailTblVar = explode(",", $this->getCurrentDetailTable());
		if (in_array("model_color", $DetailTblVar) && $GLOBALS["model_color"]->DetailEdit) {
			if (!isset($GLOBALS["model_color_grid"])) $GLOBALS["model_color_grid"] = new cmodel_color_grid(); // get detail page object
			$GLOBALS["model_color_grid"]->ValidateGridForm();
		}
		if (in_array("model_gallery", $DetailTblVar) && $GLOBALS["model_gallery"]->DetailEdit) {
			if (!isset($GLOBALS["model_gallery_grid"])) $GLOBALS["model_gallery_grid"] = new cmodel_gallery_grid(); // get detail page object
			$GLOBALS["model_gallery_grid"]->ValidateGridForm();
		}
		if (in_array("feature", $DetailTblVar) && $GLOBALS["feature"]->DetailEdit) {
			if (!isset($GLOBALS["feature_grid"])) $GLOBALS["feature_grid"] = new cfeature_grid(); // get detail page object
			$GLOBALS["feature_grid"]->ValidateGridForm();
		}
		if (in_array("specification", $DetailTblVar) && $GLOBALS["specification"]->DetailEdit) {
			if (!isset($GLOBALS["specification_grid"])) $GLOBALS["specification_grid"] = new cspecification_grid(); // get detail page object
			$GLOBALS["specification_grid"]->ValidateGridForm();
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
		if ($this->url_slug->CurrentValue <> "") { // Check field with unique index
			$sFilterChk = "(`url_slug` = '" . ew_AdjustSql($this->url_slug->CurrentValue, $this->DBID) . "')";
			$sFilterChk .= " AND NOT (" . $sFilter . ")";
			$this->CurrentFilter = $sFilterChk;
			$sSqlChk = $this->SQL();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rsChk = $conn->Execute($sSqlChk);
			$conn->raiseErrorFn = '';
			if ($rsChk === FALSE) {
				return FALSE;
			} elseif (!$rsChk->EOF) {
				$sIdxErrMsg = str_replace("%f", $this->url_slug->FldCaption(), $Language->Phrase("DupIndex"));
				$sIdxErrMsg = str_replace("%v", $this->url_slug->CurrentValue, $sIdxErrMsg);
				$this->setFailureMessage($sIdxErrMsg);
				$rsChk->Close();
				return FALSE;
			}
			$rsChk->Close();
		}
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

			// Begin transaction
			if ($this->getCurrentDetailTable() <> "")
				$conn->BeginTrans();

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$this->model_logo->OldUploadPath = '../assets/images/model_thumbnail/';
			$this->model_logo->UploadPath = $this->model_logo->OldUploadPath;
			$this->icon_menu->OldUploadPath = '../assets/images/model_menu/';
			$this->icon_menu->UploadPath = $this->icon_menu->OldUploadPath;
			$this->_thumbnail->OldUploadPath = '../assets/images/model_thumbnail/';
			$this->_thumbnail->UploadPath = $this->_thumbnail->OldUploadPath;
			$this->full_image->OldUploadPath = '../assets/images/model/';
			$this->full_image->UploadPath = $this->full_image->OldUploadPath;
			$rsnew = array();

			// model_name
			$this->model_name->SetDbValueDef($rsnew, $this->model_name->CurrentValue, NULL, $this->model_name->ReadOnly);

			// price
			$this->price->SetDbValueDef($rsnew, $this->price->CurrentValue, 0, $this->price->ReadOnly);

			// displacement
			$this->displacement->SetDbValueDef($rsnew, $this->displacement->CurrentValue, NULL, $this->displacement->ReadOnly);

			// url_slug
			$this->url_slug->SetDbValueDef($rsnew, $this->url_slug->CurrentValue, NULL, $this->url_slug->ReadOnly);

			// model_logo
			if ($this->model_logo->Visible && !$this->model_logo->ReadOnly && !$this->model_logo->Upload->KeepFile) {
				$this->model_logo->Upload->DbValue = $rsold['model_logo']; // Get original value
				if ($this->model_logo->Upload->FileName == "") {
					$rsnew['model_logo'] = NULL;
				} else {
					$rsnew['model_logo'] = $this->model_logo->Upload->FileName;
				}
			}

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

			// full_image
			if ($this->full_image->Visible && !$this->full_image->ReadOnly && !$this->full_image->Upload->KeepFile) {
				$this->full_image->Upload->DbValue = $rsold['full_image']; // Get original value
				if ($this->full_image->Upload->FileName == "") {
					$rsnew['full_image'] = NULL;
				} else {
					$rsnew['full_image'] = $this->full_image->Upload->FileName;
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

			// seo_description
			$this->seo_description->SetDbValueDef($rsnew, $this->seo_description->CurrentValue, NULL, $this->seo_description->ReadOnly);

			// seo_keyword
			$this->seo_keyword->SetDbValueDef($rsnew, $this->seo_keyword->CurrentValue, NULL, $this->seo_keyword->ReadOnly);

			// status
			$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, 0, $this->status->ReadOnly);

			// is_feature
			$this->is_feature->SetDbValueDef($rsnew, $this->is_feature->CurrentValue, 0, $this->is_feature->ReadOnly);

			// is_available
			$this->is_available->SetDbValueDef($rsnew, $this->is_available->CurrentValue, 0, $this->is_available->ReadOnly);

			// Check referential integrity for master table 'model_category'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_model_category();
			$KeyValue = isset($rsnew['category_id']) ? $rsnew['category_id'] : $rsold['category_id'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@category_id@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				if (!isset($GLOBALS["model_category"])) $GLOBALS["model_category"] = new cmodel_category();
				$rsmaster = $GLOBALS["model_category"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "model_category", $Language->Phrase("RelatedRecordRequired"));
				$this->setFailureMessage($sRelatedRecordMsg);
				$rs->Close();
				return FALSE;
			}
			if ($this->model_logo->Visible && !$this->model_logo->Upload->KeepFile) {
				$this->model_logo->UploadPath = '../assets/images/model_thumbnail/';
				$OldFiles = ew_Empty($this->model_logo->Upload->DbValue) ? array() : array($this->model_logo->Upload->DbValue);
				if (!ew_Empty($this->model_logo->Upload->FileName)) {
					$NewFiles = array($this->model_logo->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->model_logo->Upload->Index < 0) ? $this->model_logo->FldVar : substr($this->model_logo->FldVar, 0, 1) . $this->model_logo->Upload->Index . substr($this->model_logo->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->model_logo->TblVar) . $file)) {
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
								$file1 = ew_UploadFileNameEx($this->model_logo->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->model_logo->TblVar) . $file1) || file_exists($this->model_logo->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->model_logo->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->model_logo->TblVar) . $file, ew_UploadTempPath($fldvar, $this->model_logo->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->model_logo->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->model_logo->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->model_logo->SetDbValueDef($rsnew, $this->model_logo->Upload->FileName, NULL, $this->model_logo->ReadOnly);
				}
			}
			if ($this->icon_menu->Visible && !$this->icon_menu->Upload->KeepFile) {
				$this->icon_menu->UploadPath = '../assets/images/model_menu/';
				$OldFiles = ew_Empty($this->icon_menu->Upload->DbValue) ? array() : array($this->icon_menu->Upload->DbValue);
				if (!ew_Empty($this->icon_menu->Upload->FileName)) {
					$NewFiles = array($this->icon_menu->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->icon_menu->Upload->Index < 0) ? $this->icon_menu->FldVar : substr($this->icon_menu->FldVar, 0, 1) . $this->icon_menu->Upload->Index . substr($this->icon_menu->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->icon_menu->TblVar) . $file)) {
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
								$file1 = ew_UploadFileNameEx($this->icon_menu->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->icon_menu->TblVar) . $file1) || file_exists($this->icon_menu->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->icon_menu->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->icon_menu->TblVar) . $file, ew_UploadTempPath($fldvar, $this->icon_menu->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->icon_menu->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->icon_menu->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->icon_menu->SetDbValueDef($rsnew, $this->icon_menu->Upload->FileName, NULL, $this->icon_menu->ReadOnly);
				}
			}
			if ($this->_thumbnail->Visible && !$this->_thumbnail->Upload->KeepFile) {
				$this->_thumbnail->UploadPath = '../assets/images/model_thumbnail/';
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
			if ($this->full_image->Visible && !$this->full_image->Upload->KeepFile) {
				$this->full_image->UploadPath = '../assets/images/model/';
				$OldFiles = ew_Empty($this->full_image->Upload->DbValue) ? array() : array($this->full_image->Upload->DbValue);
				if (!ew_Empty($this->full_image->Upload->FileName)) {
					$NewFiles = array($this->full_image->Upload->FileName);
					$NewFileCount = count($NewFiles);
					for ($i = 0; $i < $NewFileCount; $i++) {
						$fldvar = ($this->full_image->Upload->Index < 0) ? $this->full_image->FldVar : substr($this->full_image->FldVar, 0, 1) . $this->full_image->Upload->Index . substr($this->full_image->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->full_image->TblVar) . $file)) {
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
								$file1 = ew_UploadFileNameEx($this->full_image->PhysicalUploadPath(), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->full_image->TblVar) . $file1) || file_exists($this->full_image->PhysicalUploadPath() . $file1)) // Make sure no file name clash
										$file1 = ew_UniqueFilename($this->full_image->PhysicalUploadPath(), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->full_image->TblVar) . $file, ew_UploadTempPath($fldvar, $this->full_image->TblVar) . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
					$this->full_image->Upload->DbValue = empty($OldFiles) ? "" : implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $OldFiles);
					$this->full_image->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$this->full_image->SetDbValueDef($rsnew, $this->full_image->Upload->FileName, NULL, $this->full_image->ReadOnly);
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
					if ($this->model_logo->Visible && !$this->model_logo->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->model_logo->Upload->DbValue) ? array() : array($this->model_logo->Upload->DbValue);
						if (!ew_Empty($this->model_logo->Upload->FileName)) {
							$NewFiles = array($this->model_logo->Upload->FileName);
							$NewFiles2 = array($rsnew['model_logo']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->model_logo->Upload->Index < 0) ? $this->model_logo->FldVar : substr($this->model_logo->FldVar, 0, 1) . $this->model_logo->Upload->Index . substr($this->model_logo->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->model_logo->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->model_logo->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
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
								@unlink($this->model_logo->OldPhysicalUploadPath() . $OldFiles[$i]);
						}
					}
					if ($this->icon_menu->Visible && !$this->icon_menu->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->icon_menu->Upload->DbValue) ? array() : array($this->icon_menu->Upload->DbValue);
						if (!ew_Empty($this->icon_menu->Upload->FileName)) {
							$NewFiles = array($this->icon_menu->Upload->FileName);
							$NewFiles2 = array($rsnew['icon_menu']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->icon_menu->Upload->Index < 0) ? $this->icon_menu->FldVar : substr($this->icon_menu->FldVar, 0, 1) . $this->icon_menu->Upload->Index . substr($this->icon_menu->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->icon_menu->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->icon_menu->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
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
								@unlink($this->icon_menu->OldPhysicalUploadPath() . $OldFiles[$i]);
						}
					}
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
					if ($this->full_image->Visible && !$this->full_image->Upload->KeepFile) {
						$OldFiles = ew_Empty($this->full_image->Upload->DbValue) ? array() : array($this->full_image->Upload->DbValue);
						if (!ew_Empty($this->full_image->Upload->FileName)) {
							$NewFiles = array($this->full_image->Upload->FileName);
							$NewFiles2 = array($rsnew['full_image']);
							$NewFileCount = count($NewFiles);
							for ($i = 0; $i < $NewFileCount; $i++) {
								$fldvar = ($this->full_image->Upload->Index < 0) ? $this->full_image->FldVar : substr($this->full_image->FldVar, 0, 1) . $this->full_image->Upload->Index . substr($this->full_image->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->full_image->TblVar) . $NewFiles[$i];
									if (file_exists($file)) {
										if (@$NewFiles2[$i] <> "") // Use correct file name
											$NewFiles[$i] = $NewFiles2[$i];
										if (!$this->full_image->Upload->SaveToFile($NewFiles[$i], TRUE, $i)) { // Just replace
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
								@unlink($this->full_image->OldPhysicalUploadPath() . $OldFiles[$i]);
						}
					}
				}

				// Update detail records
				$DetailTblVar = explode(",", $this->getCurrentDetailTable());
				if ($EditRow) {
					if (in_array("model_color", $DetailTblVar) && $GLOBALS["model_color"]->DetailEdit) {
						if (!isset($GLOBALS["model_color_grid"])) $GLOBALS["model_color_grid"] = new cmodel_color_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "model_color"); // Load user level of detail table
						$EditRow = $GLOBALS["model_color_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}
				if ($EditRow) {
					if (in_array("model_gallery", $DetailTblVar) && $GLOBALS["model_gallery"]->DetailEdit) {
						if (!isset($GLOBALS["model_gallery_grid"])) $GLOBALS["model_gallery_grid"] = new cmodel_gallery_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "model_gallery"); // Load user level of detail table
						$EditRow = $GLOBALS["model_gallery_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}
				if ($EditRow) {
					if (in_array("feature", $DetailTblVar) && $GLOBALS["feature"]->DetailEdit) {
						if (!isset($GLOBALS["feature_grid"])) $GLOBALS["feature_grid"] = new cfeature_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "feature"); // Load user level of detail table
						$EditRow = $GLOBALS["feature_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
					}
				}
				if ($EditRow) {
					if (in_array("specification", $DetailTblVar) && $GLOBALS["specification"]->DetailEdit) {
						if (!isset($GLOBALS["specification_grid"])) $GLOBALS["specification_grid"] = new cspecification_grid(); // Get detail page object
						$Security->LoadCurrentUserLevel($this->ProjectID . "specification"); // Load user level of detail table
						$EditRow = $GLOBALS["specification_grid"]->GridUpdate();
						$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName); // Restore user level of master table
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
		ew_CleanUploadTempPath($this->model_logo, $this->model_logo->Upload->Index);

		// icon_menu
		ew_CleanUploadTempPath($this->icon_menu, $this->icon_menu->Upload->Index);

		// thumbnail
		ew_CleanUploadTempPath($this->_thumbnail, $this->_thumbnail->Upload->Index);

		// full_image
		ew_CleanUploadTempPath($this->full_image, $this->full_image->Upload->Index);
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
			if ($sMasterTblVar == "model_category") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_category_id"] <> "") {
					$GLOBALS["model_category"]->category_id->setQueryStringValue($_GET["fk_category_id"]);
					$this->category_id->setQueryStringValue($GLOBALS["model_category"]->category_id->QueryStringValue);
					$this->category_id->setSessionValue($this->category_id->QueryStringValue);
					if (!is_numeric($GLOBALS["model_category"]->category_id->QueryStringValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar == "model_category") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_category_id"] <> "") {
					$GLOBALS["model_category"]->category_id->setFormValue($_POST["fk_category_id"]);
					$this->category_id->setFormValue($GLOBALS["model_category"]->category_id->FormValue);
					$this->category_id->setSessionValue($this->category_id->FormValue);
					if (!is_numeric($GLOBALS["model_category"]->category_id->FormValue)) $bValidMaster = FALSE;
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
			if ($sMasterTblVar <> "model_category") {
				if ($this->category_id->CurrentValue == "") $this->category_id->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
	}

	// Set up detail parms based on QueryString
	function SetupDetailParms() {

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_DETAIL])) {
			$sDetailTblVar = $_GET[EW_TABLE_SHOW_DETAIL];
			$this->setCurrentDetailTable($sDetailTblVar);
		} else {
			$sDetailTblVar = $this->getCurrentDetailTable();
		}
		if ($sDetailTblVar <> "") {
			$DetailTblVar = explode(",", $sDetailTblVar);
			if (in_array("model_color", $DetailTblVar)) {
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
			if (in_array("model_gallery", $DetailTblVar)) {
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
			if (in_array("feature", $DetailTblVar)) {
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
			if (in_array("specification", $DetailTblVar)) {
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
		}
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
			$fld->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => '`category_id` IN ({filter_value})', "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->category_id, $sWhereWrk); // Call Lookup Selecting
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
			elm = this.GetElements("x" + infix + "_price");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model->price->FldCaption(), $model->price->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_price");
			if (elm && !ew_CheckNumber(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($model->price->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_url_slug");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $model->url_slug->FldCaption(), $model->url_slug->ReqErrMsg)) ?>");
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
fmodeledit.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fmodeledit.Lists["x_category_id"] = {"LinkField":"x_category_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_category_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"model_category"};
fmodeledit.Lists["x_category_id"].Data = "<?php echo $model_edit->category_id->LookupFilterQuery(FALSE, "edit") ?>";
fmodeledit.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodeledit.Lists["x_status"].Options = <?php echo json_encode($model_edit->status->Options()) ?>;
fmodeledit.Lists["x_is_feature"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodeledit.Lists["x_is_feature"].Options = <?php echo json_encode($model_edit->is_feature->Options()) ?>;
fmodeledit.Lists["x_is_available"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodeledit.Lists["x_is_available"].Options = <?php echo json_encode($model_edit->is_available->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
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
<input type="hidden" name="modal" value="<?php echo intval($model_edit->IsModal) ?>">
<?php if ($model->getCurrentMasterTable() == "model_category") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="model_category">
<input type="hidden" name="fk_category_id" value="<?php echo $model->category_id->getSessionValue() ?>">
<?php } ?>
<div class="ewEditDiv"><!-- page* -->
<?php if ($model->model_id->Visible) { // model_id ?>
	<div id="r_model_id" class="form-group">
		<label id="elh_model_model_id" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->model_id->FldCaption() ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->model_id->CellAttributes() ?>>
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
		<label id="elh_model_model_name" for="x_model_name" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->model_name->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->model_name->CellAttributes() ?>>
<span id="el_model_model_name">
<input type="text" data-table="model" data-field="x_model_name" name="x_model_name" id="x_model_name" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($model->model_name->getPlaceHolder()) ?>" value="<?php echo $model->model_name->EditValue ?>"<?php echo $model->model_name->EditAttributes() ?>>
</span>
<?php echo $model->model_name->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->price->Visible) { // price ?>
	<div id="r_price" class="form-group">
		<label id="elh_model_price" for="x_price" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->price->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->price->CellAttributes() ?>>
<span id="el_model_price">
<input type="text" data-table="model" data-field="x_price" name="x_price" id="x_price" size="30" placeholder="<?php echo ew_HtmlEncode($model->price->getPlaceHolder()) ?>" value="<?php echo $model->price->EditValue ?>"<?php echo $model->price->EditAttributes() ?>>
</span>
<?php echo $model->price->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->displacement->Visible) { // displacement ?>
	<div id="r_displacement" class="form-group">
		<label id="elh_model_displacement" for="x_displacement" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->displacement->FldCaption() ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->displacement->CellAttributes() ?>>
<span id="el_model_displacement">
<input type="text" data-table="model" data-field="x_displacement" name="x_displacement" id="x_displacement" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($model->displacement->getPlaceHolder()) ?>" value="<?php echo $model->displacement->EditValue ?>"<?php echo $model->displacement->EditAttributes() ?>>
</span>
<?php echo $model->displacement->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->url_slug->Visible) { // url_slug ?>
	<div id="r_url_slug" class="form-group">
		<label id="elh_model_url_slug" for="x_url_slug" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->url_slug->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->url_slug->CellAttributes() ?>>
<span id="el_model_url_slug">
<input type="text" data-table="model" data-field="x_url_slug" name="x_url_slug" id="x_url_slug" size="30" maxlength="200" placeholder="<?php echo ew_HtmlEncode($model->url_slug->getPlaceHolder()) ?>" value="<?php echo $model->url_slug->EditValue ?>"<?php echo $model->url_slug->EditAttributes() ?>>
</span>
<?php echo $model->url_slug->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->model_logo->Visible) { // model_logo ?>
	<div id="r_model_logo" class="form-group">
		<label id="elh_model_model_logo" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->model_logo->FldCaption() ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->model_logo->CellAttributes() ?>>
<span id="el_model_model_logo">
<div id="fd_x_model_logo">
<span title="<?php echo $model->model_logo->FldTitle() ? $model->model_logo->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model->model_logo->ReadOnly || $model->model_logo->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="model" data-field="x_model_logo" name="x_model_logo" id="x_model_logo"<?php echo $model->model_logo->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_model_logo" id= "fn_x_model_logo" value="<?php echo $model->model_logo->Upload->FileName ?>">
<?php if (@$_POST["fa_x_model_logo"] == "0") { ?>
<input type="hidden" name="fa_x_model_logo" id= "fa_x_model_logo" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_model_logo" id= "fa_x_model_logo" value="1">
<?php } ?>
<input type="hidden" name="fs_x_model_logo" id= "fs_x_model_logo" value="150">
<input type="hidden" name="fx_x_model_logo" id= "fx_x_model_logo" value="<?php echo $model->model_logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_model_logo" id= "fm_x_model_logo" value="<?php echo $model->model_logo->UploadMaxFileSize ?>">
</div>
<table id="ft_x_model_logo" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $model->model_logo->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->model_year->Visible) { // model_year ?>
	<div id="r_model_year" class="form-group">
		<label id="elh_model_model_year" for="x_model_year" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->model_year->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->model_year->CellAttributes() ?>>
<span id="el_model_model_year">
<input type="text" data-table="model" data-field="x_model_year" name="x_model_year" id="x_model_year" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($model->model_year->getPlaceHolder()) ?>" value="<?php echo $model->model_year->EditValue ?>"<?php echo $model->model_year->EditAttributes() ?>>
</span>
<?php echo $model->model_year->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->icon_menu->Visible) { // icon_menu ?>
	<div id="r_icon_menu" class="form-group">
		<label id="elh_model_icon_menu" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->icon_menu->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->icon_menu->CellAttributes() ?>>
<span id="el_model_icon_menu">
<div id="fd_x_icon_menu">
<span title="<?php echo $model->icon_menu->FldTitle() ? $model->icon_menu->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model->icon_menu->ReadOnly || $model->icon_menu->Disabled) echo " hide"; ?>" data-trigger="hover">
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
		<label id="elh_model__thumbnail" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->_thumbnail->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->_thumbnail->CellAttributes() ?>>
<span id="el_model__thumbnail">
<div id="fd_x__thumbnail">
<span title="<?php echo $model->_thumbnail->FldTitle() ? $model->_thumbnail->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model->_thumbnail->ReadOnly || $model->_thumbnail->Disabled) echo " hide"; ?>" data-trigger="hover">
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
<?php if ($model->full_image->Visible) { // full_image ?>
	<div id="r_full_image" class="form-group">
		<label id="elh_model_full_image" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->full_image->FldCaption() ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->full_image->CellAttributes() ?>>
<span id="el_model_full_image">
<div id="fd_x_full_image">
<span title="<?php echo $model->full_image->FldTitle() ? $model->full_image->FldTitle() : $Language->Phrase("ChooseFile") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($model->full_image->ReadOnly || $model->full_image->Disabled) echo " hide"; ?>" data-trigger="hover">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="model" data-field="x_full_image" name="x_full_image" id="x_full_image"<?php echo $model->full_image->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x_full_image" id= "fn_x_full_image" value="<?php echo $model->full_image->Upload->FileName ?>">
<?php if (@$_POST["fa_x_full_image"] == "0") { ?>
<input type="hidden" name="fa_x_full_image" id= "fa_x_full_image" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x_full_image" id= "fa_x_full_image" value="1">
<?php } ?>
<input type="hidden" name="fs_x_full_image" id= "fs_x_full_image" value="150">
<input type="hidden" name="fx_x_full_image" id= "fx_x_full_image" value="<?php echo $model->full_image->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_full_image" id= "fm_x_full_image" value="<?php echo $model->full_image->UploadMaxFileSize ?>">
</div>
<table id="ft_x_full_image" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php echo $model->full_image->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->description->Visible) { // description ?>
	<div id="r_description" class="form-group">
		<label id="elh_model_description" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->description->FldCaption() ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->description->CellAttributes() ?>>
<span id="el_model_description">
<?php ew_AppendClass($model->description->EditAttrs["class"], "editor"); ?>
<textarea data-table="model" data-field="x_description" name="x_description" id="x_description" cols="45" rows="6" placeholder="<?php echo ew_HtmlEncode($model->description->getPlaceHolder()) ?>"<?php echo $model->description->EditAttributes() ?>><?php echo $model->description->EditValue ?></textarea>
<script type="text/javascript">
ew_CreateEditor("fmodeledit", "x_description", 45, 6, <?php echo ($model->description->ReadOnly || FALSE) ? "true" : "false" ?>);
</script>
</span>
<?php echo $model->description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->youtube_url->Visible) { // youtube_url ?>
	<div id="r_youtube_url" class="form-group">
		<label id="elh_model_youtube_url" for="x_youtube_url" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->youtube_url->FldCaption() ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->youtube_url->CellAttributes() ?>>
<span id="el_model_youtube_url">
<input type="text" data-table="model" data-field="x_youtube_url" name="x_youtube_url" id="x_youtube_url" size="30" maxlength="150" placeholder="<?php echo ew_HtmlEncode($model->youtube_url->getPlaceHolder()) ?>" value="<?php echo $model->youtube_url->EditValue ?>"<?php echo $model->youtube_url->EditAttributes() ?>>
</span>
<?php echo $model->youtube_url->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->category_id->Visible) { // category_id ?>
	<div id="r_category_id" class="form-group">
		<label id="elh_model_category_id" for="x_category_id" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->category_id->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->category_id->CellAttributes() ?>>
<?php if ($model->category_id->getSessionValue() <> "") { ?>
<span id="el_model_category_id">
<span<?php echo $model->category_id->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $model->category_id->ViewValue ?></p></span>
</span>
<input type="hidden" id="x_category_id" name="x_category_id" value="<?php echo ew_HtmlEncode($model->category_id->CurrentValue) ?>">
<?php } else { ?>
<span id="el_model_category_id">
<select data-table="model" data-field="x_category_id" data-value-separator="<?php echo $model->category_id->DisplayValueSeparatorAttribute() ?>" id="x_category_id" name="x_category_id"<?php echo $model->category_id->EditAttributes() ?>>
<?php echo $model->category_id->SelectOptionListHtml("x_category_id") ?>
</select>
</span>
<?php } ?>
<?php echo $model->category_id->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->m_order->Visible) { // m_order ?>
	<div id="r_m_order" class="form-group">
		<label id="elh_model_m_order" for="x_m_order" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->m_order->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->m_order->CellAttributes() ?>>
<span id="el_model_m_order">
<input type="text" data-table="model" data-field="x_m_order" name="x_m_order" id="x_m_order" size="30" placeholder="<?php echo ew_HtmlEncode($model->m_order->getPlaceHolder()) ?>" value="<?php echo $model->m_order->EditValue ?>"<?php echo $model->m_order->EditAttributes() ?>>
</span>
<?php echo $model->m_order->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->seo_description->Visible) { // seo_description ?>
	<div id="r_seo_description" class="form-group">
		<label id="elh_model_seo_description" for="x_seo_description" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->seo_description->FldCaption() ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->seo_description->CellAttributes() ?>>
<span id="el_model_seo_description">
<input type="text" data-table="model" data-field="x_seo_description" name="x_seo_description" id="x_seo_description" size="30" maxlength="156" placeholder="<?php echo ew_HtmlEncode($model->seo_description->getPlaceHolder()) ?>" value="<?php echo $model->seo_description->EditValue ?>"<?php echo $model->seo_description->EditAttributes() ?>>
</span>
<?php echo $model->seo_description->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->seo_keyword->Visible) { // seo_keyword ?>
	<div id="r_seo_keyword" class="form-group">
		<label id="elh_model_seo_keyword" for="x_seo_keyword" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->seo_keyword->FldCaption() ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->seo_keyword->CellAttributes() ?>>
<span id="el_model_seo_keyword">
<input type="text" data-table="model" data-field="x_seo_keyword" name="x_seo_keyword" id="x_seo_keyword" size="30" maxlength="160" placeholder="<?php echo ew_HtmlEncode($model->seo_keyword->getPlaceHolder()) ?>" value="<?php echo $model->seo_keyword->EditValue ?>"<?php echo $model->seo_keyword->EditAttributes() ?>>
</span>
<?php echo $model->seo_keyword->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->status->Visible) { // status ?>
	<div id="r_status" class="form-group">
		<label id="elh_model_status" for="x_status" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->status->FldCaption() ?><?php echo $Language->Phrase("FieldRequiredIndicator") ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->status->CellAttributes() ?>>
<span id="el_model_status">
<select data-table="model" data-field="x_status" data-value-separator="<?php echo $model->status->DisplayValueSeparatorAttribute() ?>" id="x_status" name="x_status"<?php echo $model->status->EditAttributes() ?>>
<?php echo $model->status->SelectOptionListHtml("x_status") ?>
</select>
</span>
<?php echo $model->status->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->is_feature->Visible) { // is_feature ?>
	<div id="r_is_feature" class="form-group">
		<label id="elh_model_is_feature" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->is_feature->FldCaption() ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->is_feature->CellAttributes() ?>>
<span id="el_model_is_feature">
<div id="tp_x_is_feature" class="ewTemplate"><input type="radio" data-table="model" data-field="x_is_feature" data-value-separator="<?php echo $model->is_feature->DisplayValueSeparatorAttribute() ?>" name="x_is_feature" id="x_is_feature" value="{value}"<?php echo $model->is_feature->EditAttributes() ?>></div>
<div id="dsl_x_is_feature" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $model->is_feature->RadioButtonListHtml(FALSE, "x_is_feature") ?>
</div></div>
</span>
<?php echo $model->is_feature->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($model->is_available->Visible) { // is_available ?>
	<div id="r_is_available" class="form-group">
		<label id="elh_model_is_available" class="<?php echo $model_edit->LeftColumnClass ?>"><?php echo $model->is_available->FldCaption() ?></label>
		<div class="<?php echo $model_edit->RightColumnClass ?>"><div<?php echo $model->is_available->CellAttributes() ?>>
<span id="el_model_is_available">
<div id="tp_x_is_available" class="ewTemplate"><input type="radio" data-table="model" data-field="x_is_available" data-value-separator="<?php echo $model->is_available->DisplayValueSeparatorAttribute() ?>" name="x_is_available" id="x_is_available" value="{value}"<?php echo $model->is_available->EditAttributes() ?>></div>
<div id="dsl_x_is_available" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $model->is_available->RadioButtonListHtml(FALSE, "x_is_available") ?>
</div></div>
</span>
<?php echo $model->is_available->CustomMsg ?></div></div>
	</div>
<?php } ?>
</div><!-- /page* -->
<?php
	if (in_array("model_color", explode(",", $model->getCurrentDetailTable())) && $model_color->DetailEdit) {
?>
<?php if ($model->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("model_color", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "model_colorgrid.php" ?>
<?php } ?>
<?php
	if (in_array("model_gallery", explode(",", $model->getCurrentDetailTable())) && $model_gallery->DetailEdit) {
?>
<?php if ($model->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("model_gallery", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "model_gallerygrid.php" ?>
<?php } ?>
<?php
	if (in_array("feature", explode(",", $model->getCurrentDetailTable())) && $feature->DetailEdit) {
?>
<?php if ($model->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("feature", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "featuregrid.php" ?>
<?php } ?>
<?php
	if (in_array("specification", explode(",", $model->getCurrentDetailTable())) && $specification->DetailEdit) {
?>
<?php if ($model->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("specification", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "specificationgrid.php" ?>
<?php } ?>
<?php if (!$model_edit->IsModal) { ?>
<div class="form-group"><!-- buttons .form-group -->
	<div class="<?php echo $model_edit->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("SaveBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $model_edit->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
	</div><!-- /buttons offset -->
</div><!-- /buttons .form-group -->
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
