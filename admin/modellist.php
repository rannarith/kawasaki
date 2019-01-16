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

$model_list = NULL; // Initialize page object first

class cmodel_list extends cmodel {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = '{086EEFE9-31D6-48E2-919A-4B361863B384}';

	// Table name
	var $TableName = 'model';

	// Page object name
	var $PageObjName = 'model_list';

	// Grid form hidden field names
	var $FormName = 'fmodellist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

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

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

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

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "modeladd.php?" . EW_TABLE_SHOW_DETAIL . "=";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "modeldelete.php";
		$this->MultiUpdateUrl = "modelupdate.php";

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Table object (model_category)
		if (!isset($GLOBALS['model_category'])) $GLOBALS['model_category'] = new cmodel_category();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

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

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fmodellistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
		$this->model_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->model_id->Visible = FALSE;
		$this->model_name->SetVisibility();
		$this->price->SetVisibility();
		$this->model_year->SetVisibility();
		$this->_thumbnail->SetVisibility();
		$this->category_id->SetVisibility();
		$this->m_order->SetVisibility();
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

		// Set up master detail parameters
		$this->SetupMasterParms();

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
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
			ew_SaveDebugMsg();
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $AutoHidePager = EW_AUTO_HIDE_PAGER;
	var $AutoHidePageSizeSelector = EW_AUTO_HIDE_PAGE_SIZE_SELECTOR;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security, $EW_EXPORT;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Process filter list
			$this->ProcessFilterList();

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->Command <> "json" && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetupSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->Command <> "json" && $this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		if ($this->Command <> "json")
			$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif ($this->Command <> "json") {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "model_category") {
			global $model_category;
			$rsmaster = $model_category->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("model_categorylist.php"); // Return to master page
			} else {
				$model_category->LoadListRowValues($rsmaster);
				$model_category->RowType = EW_ROWTYPE_MASTER; // Master row
				$model_category->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter
		if ($this->Command == "json") {
			$this->UseSessionForListSQL = FALSE; // Do not use session for ListSQL
			$this->CurrentFilter = $sFilter;
		} else {
			$this->setSessionWhere($sFilter);
			$this->CurrentFilter = "";
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->ListRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 1) {
			$this->model_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->model_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Initialize
		$sFilterList = "";
		$sSavedFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->model_id->AdvancedSearch->ToJson(), ","); // Field model_id
		$sFilterList = ew_Concat($sFilterList, $this->model_name->AdvancedSearch->ToJson(), ","); // Field model_name
		$sFilterList = ew_Concat($sFilterList, $this->price->AdvancedSearch->ToJson(), ","); // Field price
		$sFilterList = ew_Concat($sFilterList, $this->displacement->AdvancedSearch->ToJson(), ","); // Field displacement
		$sFilterList = ew_Concat($sFilterList, $this->url_slug->AdvancedSearch->ToJson(), ","); // Field url_slug
		$sFilterList = ew_Concat($sFilterList, $this->model_logo->AdvancedSearch->ToJson(), ","); // Field model_logo
		$sFilterList = ew_Concat($sFilterList, $this->model_year->AdvancedSearch->ToJson(), ","); // Field model_year
		$sFilterList = ew_Concat($sFilterList, $this->icon_menu->AdvancedSearch->ToJson(), ","); // Field icon_menu
		$sFilterList = ew_Concat($sFilterList, $this->_thumbnail->AdvancedSearch->ToJson(), ","); // Field thumbnail
		$sFilterList = ew_Concat($sFilterList, $this->full_image->AdvancedSearch->ToJson(), ","); // Field full_image
		$sFilterList = ew_Concat($sFilterList, $this->description->AdvancedSearch->ToJson(), ","); // Field description
		$sFilterList = ew_Concat($sFilterList, $this->youtube_url->AdvancedSearch->ToJson(), ","); // Field youtube_url
		$sFilterList = ew_Concat($sFilterList, $this->category_id->AdvancedSearch->ToJson(), ","); // Field category_id
		$sFilterList = ew_Concat($sFilterList, $this->m_order->AdvancedSearch->ToJson(), ","); // Field m_order
		$sFilterList = ew_Concat($sFilterList, $this->seo_description->AdvancedSearch->ToJson(), ","); // Field seo_description
		$sFilterList = ew_Concat($sFilterList, $this->seo_keyword->AdvancedSearch->ToJson(), ","); // Field seo_keyword
		$sFilterList = ew_Concat($sFilterList, $this->status->AdvancedSearch->ToJson(), ","); // Field status
		$sFilterList = ew_Concat($sFilterList, $this->is_feature->AdvancedSearch->ToJson(), ","); // Field is_feature
		$sFilterList = ew_Concat($sFilterList, $this->is_available->AdvancedSearch->ToJson(), ","); // Field is_available
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["ajax"] == "savefilters") { // Save filter request (Ajax)
			$filters = @$_POST["filters"];
			$UserProfile->SetSearchFilters(CurrentUserName(), "fmodellistsrch", $filters);

			// Clean output buffer
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			echo ew_ArrayToJson(array(array("success" => TRUE))); // Success
			$this->Page_Terminate();
			exit();
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(@$_POST["filter"], TRUE);
		$this->Command = "search";

		// Field model_id
		$this->model_id->AdvancedSearch->SearchValue = @$filter["x_model_id"];
		$this->model_id->AdvancedSearch->SearchOperator = @$filter["z_model_id"];
		$this->model_id->AdvancedSearch->SearchCondition = @$filter["v_model_id"];
		$this->model_id->AdvancedSearch->SearchValue2 = @$filter["y_model_id"];
		$this->model_id->AdvancedSearch->SearchOperator2 = @$filter["w_model_id"];
		$this->model_id->AdvancedSearch->Save();

		// Field model_name
		$this->model_name->AdvancedSearch->SearchValue = @$filter["x_model_name"];
		$this->model_name->AdvancedSearch->SearchOperator = @$filter["z_model_name"];
		$this->model_name->AdvancedSearch->SearchCondition = @$filter["v_model_name"];
		$this->model_name->AdvancedSearch->SearchValue2 = @$filter["y_model_name"];
		$this->model_name->AdvancedSearch->SearchOperator2 = @$filter["w_model_name"];
		$this->model_name->AdvancedSearch->Save();

		// Field price
		$this->price->AdvancedSearch->SearchValue = @$filter["x_price"];
		$this->price->AdvancedSearch->SearchOperator = @$filter["z_price"];
		$this->price->AdvancedSearch->SearchCondition = @$filter["v_price"];
		$this->price->AdvancedSearch->SearchValue2 = @$filter["y_price"];
		$this->price->AdvancedSearch->SearchOperator2 = @$filter["w_price"];
		$this->price->AdvancedSearch->Save();

		// Field displacement
		$this->displacement->AdvancedSearch->SearchValue = @$filter["x_displacement"];
		$this->displacement->AdvancedSearch->SearchOperator = @$filter["z_displacement"];
		$this->displacement->AdvancedSearch->SearchCondition = @$filter["v_displacement"];
		$this->displacement->AdvancedSearch->SearchValue2 = @$filter["y_displacement"];
		$this->displacement->AdvancedSearch->SearchOperator2 = @$filter["w_displacement"];
		$this->displacement->AdvancedSearch->Save();

		// Field url_slug
		$this->url_slug->AdvancedSearch->SearchValue = @$filter["x_url_slug"];
		$this->url_slug->AdvancedSearch->SearchOperator = @$filter["z_url_slug"];
		$this->url_slug->AdvancedSearch->SearchCondition = @$filter["v_url_slug"];
		$this->url_slug->AdvancedSearch->SearchValue2 = @$filter["y_url_slug"];
		$this->url_slug->AdvancedSearch->SearchOperator2 = @$filter["w_url_slug"];
		$this->url_slug->AdvancedSearch->Save();

		// Field model_logo
		$this->model_logo->AdvancedSearch->SearchValue = @$filter["x_model_logo"];
		$this->model_logo->AdvancedSearch->SearchOperator = @$filter["z_model_logo"];
		$this->model_logo->AdvancedSearch->SearchCondition = @$filter["v_model_logo"];
		$this->model_logo->AdvancedSearch->SearchValue2 = @$filter["y_model_logo"];
		$this->model_logo->AdvancedSearch->SearchOperator2 = @$filter["w_model_logo"];
		$this->model_logo->AdvancedSearch->Save();

		// Field model_year
		$this->model_year->AdvancedSearch->SearchValue = @$filter["x_model_year"];
		$this->model_year->AdvancedSearch->SearchOperator = @$filter["z_model_year"];
		$this->model_year->AdvancedSearch->SearchCondition = @$filter["v_model_year"];
		$this->model_year->AdvancedSearch->SearchValue2 = @$filter["y_model_year"];
		$this->model_year->AdvancedSearch->SearchOperator2 = @$filter["w_model_year"];
		$this->model_year->AdvancedSearch->Save();

		// Field icon_menu
		$this->icon_menu->AdvancedSearch->SearchValue = @$filter["x_icon_menu"];
		$this->icon_menu->AdvancedSearch->SearchOperator = @$filter["z_icon_menu"];
		$this->icon_menu->AdvancedSearch->SearchCondition = @$filter["v_icon_menu"];
		$this->icon_menu->AdvancedSearch->SearchValue2 = @$filter["y_icon_menu"];
		$this->icon_menu->AdvancedSearch->SearchOperator2 = @$filter["w_icon_menu"];
		$this->icon_menu->AdvancedSearch->Save();

		// Field thumbnail
		$this->_thumbnail->AdvancedSearch->SearchValue = @$filter["x__thumbnail"];
		$this->_thumbnail->AdvancedSearch->SearchOperator = @$filter["z__thumbnail"];
		$this->_thumbnail->AdvancedSearch->SearchCondition = @$filter["v__thumbnail"];
		$this->_thumbnail->AdvancedSearch->SearchValue2 = @$filter["y__thumbnail"];
		$this->_thumbnail->AdvancedSearch->SearchOperator2 = @$filter["w__thumbnail"];
		$this->_thumbnail->AdvancedSearch->Save();

		// Field full_image
		$this->full_image->AdvancedSearch->SearchValue = @$filter["x_full_image"];
		$this->full_image->AdvancedSearch->SearchOperator = @$filter["z_full_image"];
		$this->full_image->AdvancedSearch->SearchCondition = @$filter["v_full_image"];
		$this->full_image->AdvancedSearch->SearchValue2 = @$filter["y_full_image"];
		$this->full_image->AdvancedSearch->SearchOperator2 = @$filter["w_full_image"];
		$this->full_image->AdvancedSearch->Save();

		// Field description
		$this->description->AdvancedSearch->SearchValue = @$filter["x_description"];
		$this->description->AdvancedSearch->SearchOperator = @$filter["z_description"];
		$this->description->AdvancedSearch->SearchCondition = @$filter["v_description"];
		$this->description->AdvancedSearch->SearchValue2 = @$filter["y_description"];
		$this->description->AdvancedSearch->SearchOperator2 = @$filter["w_description"];
		$this->description->AdvancedSearch->Save();

		// Field youtube_url
		$this->youtube_url->AdvancedSearch->SearchValue = @$filter["x_youtube_url"];
		$this->youtube_url->AdvancedSearch->SearchOperator = @$filter["z_youtube_url"];
		$this->youtube_url->AdvancedSearch->SearchCondition = @$filter["v_youtube_url"];
		$this->youtube_url->AdvancedSearch->SearchValue2 = @$filter["y_youtube_url"];
		$this->youtube_url->AdvancedSearch->SearchOperator2 = @$filter["w_youtube_url"];
		$this->youtube_url->AdvancedSearch->Save();

		// Field category_id
		$this->category_id->AdvancedSearch->SearchValue = @$filter["x_category_id"];
		$this->category_id->AdvancedSearch->SearchOperator = @$filter["z_category_id"];
		$this->category_id->AdvancedSearch->SearchCondition = @$filter["v_category_id"];
		$this->category_id->AdvancedSearch->SearchValue2 = @$filter["y_category_id"];
		$this->category_id->AdvancedSearch->SearchOperator2 = @$filter["w_category_id"];
		$this->category_id->AdvancedSearch->Save();

		// Field m_order
		$this->m_order->AdvancedSearch->SearchValue = @$filter["x_m_order"];
		$this->m_order->AdvancedSearch->SearchOperator = @$filter["z_m_order"];
		$this->m_order->AdvancedSearch->SearchCondition = @$filter["v_m_order"];
		$this->m_order->AdvancedSearch->SearchValue2 = @$filter["y_m_order"];
		$this->m_order->AdvancedSearch->SearchOperator2 = @$filter["w_m_order"];
		$this->m_order->AdvancedSearch->Save();

		// Field seo_description
		$this->seo_description->AdvancedSearch->SearchValue = @$filter["x_seo_description"];
		$this->seo_description->AdvancedSearch->SearchOperator = @$filter["z_seo_description"];
		$this->seo_description->AdvancedSearch->SearchCondition = @$filter["v_seo_description"];
		$this->seo_description->AdvancedSearch->SearchValue2 = @$filter["y_seo_description"];
		$this->seo_description->AdvancedSearch->SearchOperator2 = @$filter["w_seo_description"];
		$this->seo_description->AdvancedSearch->Save();

		// Field seo_keyword
		$this->seo_keyword->AdvancedSearch->SearchValue = @$filter["x_seo_keyword"];
		$this->seo_keyword->AdvancedSearch->SearchOperator = @$filter["z_seo_keyword"];
		$this->seo_keyword->AdvancedSearch->SearchCondition = @$filter["v_seo_keyword"];
		$this->seo_keyword->AdvancedSearch->SearchValue2 = @$filter["y_seo_keyword"];
		$this->seo_keyword->AdvancedSearch->SearchOperator2 = @$filter["w_seo_keyword"];
		$this->seo_keyword->AdvancedSearch->Save();

		// Field status
		$this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
		$this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
		$this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
		$this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
		$this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
		$this->status->AdvancedSearch->Save();

		// Field is_feature
		$this->is_feature->AdvancedSearch->SearchValue = @$filter["x_is_feature"];
		$this->is_feature->AdvancedSearch->SearchOperator = @$filter["z_is_feature"];
		$this->is_feature->AdvancedSearch->SearchCondition = @$filter["v_is_feature"];
		$this->is_feature->AdvancedSearch->SearchValue2 = @$filter["y_is_feature"];
		$this->is_feature->AdvancedSearch->SearchOperator2 = @$filter["w_is_feature"];
		$this->is_feature->AdvancedSearch->Save();

		// Field is_available
		$this->is_available->AdvancedSearch->SearchValue = @$filter["x_is_available"];
		$this->is_available->AdvancedSearch->SearchOperator = @$filter["z_is_available"];
		$this->is_available->AdvancedSearch->SearchCondition = @$filter["v_is_available"];
		$this->is_available->AdvancedSearch->SearchValue2 = @$filter["y_is_available"];
		$this->is_available->AdvancedSearch->SearchOperator2 = @$filter["w_is_available"];
		$this->is_available->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->model_name, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->displacement, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->url_slug, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->model_logo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->model_year, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->icon_menu, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->_thumbnail, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->full_image, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->description, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->youtube_url, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->seo_description, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->seo_keyword, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSQL(&$Where, &$Fld, $arKeywords, $type) {
		global $EW_BASIC_SEARCH_IGNORE_PATTERN;
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if ($EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace($EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .= "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

		// Get search SQL
		if ($sSearchKeyword <> "") {
			$ar = $this->BasicSearch->KeywordList($Default);

			// Search keyword in any fields
			if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
				foreach ($ar as $sKeyword) {
					if ($sKeyword <> "") {
						if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
						$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
					}
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
			}
			if (!$Default && in_array($this->Command, array("", "reset", "resetall"))) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();
	}

	// Set up sort parameters
	function SetupSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = @$_GET["order"];
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->model_id); // model_id
			$this->UpdateSort($this->model_name); // model_name
			$this->UpdateSort($this->price); // price
			$this->UpdateSort($this->model_year); // model_year
			$this->UpdateSort($this->_thumbnail); // thumbnail
			$this->UpdateSort($this->category_id); // category_id
			$this->UpdateSort($this->m_order); // m_order
			$this->UpdateSort($this->status); // status
			$this->UpdateSort($this->is_feature); // is_feature
			$this->UpdateSort($this->is_available); // is_available
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
				$this->category_id->setSort("ASC");
				$this->model_id->setSort("DESC");
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->category_id->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->model_id->setSort("");
				$this->model_name->setSort("");
				$this->price->setSort("");
				$this->model_year->setSort("");
				$this->_thumbnail->setSort("");
				$this->category_id->setSort("");
				$this->m_order->setSort("");
				$this->status->setSort("");
				$this->is_feature->setSort("");
				$this->is_available->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanView();
		$item->OnLeft = FALSE;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = FALSE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->CanDelete();
		$item->OnLeft = FALSE;

		// "detail_model_color"
		$item = &$this->ListOptions->Add("detail_model_color");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'model_color') && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["model_color_grid"])) $GLOBALS["model_color_grid"] = new cmodel_color_grid;

		// "detail_model_gallery"
		$item = &$this->ListOptions->Add("detail_model_gallery");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'model_gallery') && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["model_gallery_grid"])) $GLOBALS["model_gallery_grid"] = new cmodel_gallery_grid;

		// "detail_feature"
		$item = &$this->ListOptions->Add("detail_feature");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'feature') && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["feature_grid"])) $GLOBALS["feature_grid"] = new cfeature_grid;

		// "detail_specification"
		$item = &$this->ListOptions->Add("detail_specification");
		$item->CssClass = "text-nowrap";
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'specification') && !$this->ShowMultipleDetails;
		$item->OnLeft = FALSE;
		$item->ShowInButtonGroup = FALSE;
		if (!isset($GLOBALS["specification_grid"])) $GLOBALS["specification_grid"] = new cspecification_grid;

		// Multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$this->ListOptions->Add("details");
			$item->CssClass = "text-nowrap";
			$item->Visible = $this->ShowMultipleDetails;
			$item->OnLeft = FALSE;
			$item->ShowInButtonGroup = FALSE;
		}

		// Set up detail pages
		$pages = new cSubPages();
		$pages->Add("model_color");
		$pages->Add("model_gallery");
		$pages->Add("feature");
		$pages->Add("specification");
		$this->DetailPages = $pages;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssClass = "text-nowrap";
		$item->OnLeft = FALSE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = FALSE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = FALSE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Call ListOptions_Rendering event
		$this->ListOptions_Rendering();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->CanDelete())
			$oListOpt->Body = "<a class=\"ewRowLink ewDelete\"" . "" . " title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("DeleteLink") . "</a>";
		else
			$oListOpt->Body = "";

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_model_color"
		$oListOpt = &$this->ListOptions->Items["detail_model_color"];
		if ($Security->AllowList(CurrentProjectID() . 'model_color')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("model_color", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("model_colorlist.php?" . EW_TABLE_SHOW_MASTER . "=model&fk_model_id=" . urlencode(strval($this->model_id->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["model_color_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'model_color')) {
				$caption = $Language->Phrase("MasterDetailViewLink");
				$url = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=model_color");
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "model_color";
			}
			if ($GLOBALS["model_color_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'model_color')) {
				$caption = $Language->Phrase("MasterDetailEditLink");
				$url = $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=model_color");
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "model_color";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_model_gallery"
		$oListOpt = &$this->ListOptions->Items["detail_model_gallery"];
		if ($Security->AllowList(CurrentProjectID() . 'model_gallery')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("model_gallery", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("model_gallerylist.php?" . EW_TABLE_SHOW_MASTER . "=model&fk_model_id=" . urlencode(strval($this->model_id->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["model_gallery_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'model_gallery')) {
				$caption = $Language->Phrase("MasterDetailViewLink");
				$url = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=model_gallery");
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "model_gallery";
			}
			if ($GLOBALS["model_gallery_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'model_gallery')) {
				$caption = $Language->Phrase("MasterDetailEditLink");
				$url = $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=model_gallery");
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "model_gallery";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_feature"
		$oListOpt = &$this->ListOptions->Items["detail_feature"];
		if ($Security->AllowList(CurrentProjectID() . 'feature')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("feature", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("featurelist.php?" . EW_TABLE_SHOW_MASTER . "=model&fk_model_id=" . urlencode(strval($this->model_id->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["feature_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'feature')) {
				$caption = $Language->Phrase("MasterDetailViewLink");
				$url = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=feature");
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "feature";
			}
			if ($GLOBALS["feature_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'feature')) {
				$caption = $Language->Phrase("MasterDetailEditLink");
				$url = $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=feature");
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "feature";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}

		// "detail_specification"
		$oListOpt = &$this->ListOptions->Items["detail_specification"];
		if ($Security->AllowList(CurrentProjectID() . 'specification')) {
			$body = $Language->Phrase("DetailLink") . $Language->TablePhrase("specification", "TblCaption");
			$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("specificationlist.php?" . EW_TABLE_SHOW_MASTER . "=model&fk_model_id=" . urlencode(strval($this->model_id->CurrentValue)) . "") . "\">" . $body . "</a>";
			$links = "";
			if ($GLOBALS["specification_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'specification')) {
				$caption = $Language->Phrase("MasterDetailViewLink");
				$url = $this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=specification");
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
				$DetailViewTblVar .= "specification";
			}
			if ($GLOBALS["specification_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'specification')) {
				$caption = $Language->Phrase("MasterDetailEditLink");
				$url = $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=specification");
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . ew_HtmlImageAndText($caption) . "</a></li>";
				if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
				$DetailEditTblVar .= "specification";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
			}
			$body = "<div class=\"btn-group\">" . $body . "</div>";
			$oListOpt->Body = $body;
			if ($this->ShowMultipleDetails) $oListOpt->Visible = FALSE;
		}
		if ($this->ShowMultipleDetails) {
			$body = $Language->Phrase("MultipleMasterDetails");
			$body = "<div class=\"btn-group\">";
			$links = "";
			if ($DetailViewTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailViewTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			}
			if ($DetailEditTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailEditTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			}
			if ($DetailCopyTblVar <> "") {
				$links .= "<li><a class=\"ewRowLink ewDetailCopy\" data-action=\"add\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailCopyLink")) . "\" href=\"" . ew_HtmlEncode($this->GetCopyUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailCopyTblVar)) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailCopyLink")) . "</a></li>";
			}
			if ($links <> "") {
				$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewMasterDetail\" title=\"" . ew_HtmlTitle($Language->Phrase("MultipleMasterDetails")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("MultipleMasterDetails") . "<b class=\"caret\"></b></button>";
				$body .= "<ul class=\"dropdown-menu ewMenu\">". $links . "</ul>";
			}
			$body .= "</div>";

			// Multiple details
			$oListOpt = &$this->ListOptions->Items["details"];
			$oListOpt->Body = $body;
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" class=\"ewMultiSelect\" value=\"" . ew_HtmlEncode($this->model_id->CurrentValue) . "\" onclick=\"ew_ClickMultiCheckbox(event);\">";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());
		$option = $options["detail"];
		$DetailTableLink = "";
		$item = &$option->Add("detailadd_model_color");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=model_color");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["model_color"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["model_color"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'model_color') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "model_color";
		}
		$item = &$option->Add("detailadd_model_gallery");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=model_gallery");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["model_gallery"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["model_gallery"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'model_gallery') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "model_gallery";
		}
		$item = &$option->Add("detailadd_feature");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=feature");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["feature"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["feature"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'feature') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "feature";
		}
		$item = &$option->Add("detailadd_specification");
		$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=specification");
		$caption = $Language->Phrase("Add") . "&nbsp;" . $this->TableCaption() . "/" . $GLOBALS["specification"]->TableCaption();
		$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
		$item->Visible = ($GLOBALS["specification"]->DetailAdd && $Security->AllowAdd(CurrentProjectID() . 'specification') && $Security->CanAdd());
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "specification";
		}

		// Add multiple details
		if ($this->ShowMultipleDetails) {
			$item = &$option->Add("detailsadd");
			$url = $this->GetAddUrl(EW_TABLE_SHOW_DETAIL . "=" . $DetailTableLink);
			$caption = $Language->Phrase("AddMasterDetailLink");
			$item->Body = "<a class=\"ewDetailAddGroup ewDetailAdd\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"" . ew_HtmlEncode($url) . "\">" . $caption . "</a>";
			$item->Visible = ($DetailTableLink <> "" && $Security->CanAdd());

			// Hide single master/detail items
			$ar = explode(",", $DetailTableLink);
			$cnt = count($ar);
			for ($i = 0; $i < $cnt; $i++) {
				if ($item = &$option->GetItem("detailadd_" . $ar[$i]))
					$item->Visible = FALSE;
			}
		}
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fmodellistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fmodellistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fmodellist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fmodellistsrch\">" . $Language->Phrase("SearchLink") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "" && $this->Command == "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->ListSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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

			// model_year
			$this->model_year->LinkCustomAttributes = "";
			$this->model_year->HrefValue = "";
			$this->model_year->TooltipValue = "";

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
				$this->_thumbnail->LinkAttrs["data-rel"] = "model_x" . $this->RowCnt . "__thumbnail";
				ew_AppendClass($this->_thumbnail->LinkAttrs["class"], "ewLightbox");
			}

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

			// is_feature
			$this->is_feature->LinkCustomAttributes = "";
			$this->is_feature->HrefValue = "";
			$this->is_feature->TooltipValue = "";

			// is_available
			$this->is_available->LinkCustomAttributes = "";
			$this->is_available->HrefValue = "";
			$this->is_available->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendering event
	function ListOptions_Rendering() {

		//$GLOBALS["xxx_grid"]->DetailAdd = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailEdit = (...condition...); // Set to TRUE or FALSE conditionally
		//$GLOBALS["xxx_grid"]->DetailView = (...condition...); // Set to TRUE or FALSE conditionally

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example:
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($model_list)) $model_list = new cmodel_list();

// Page init
$model_list->Page_Init();

// Page main
$model_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$model_list->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fmodellist = new ew_Form("fmodellist", "list");
fmodellist.FormKeyCountName = '<?php echo $model_list->FormKeyCountName ?>';

// Form_CustomValidate event
fmodellist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fmodellist.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fmodellist.Lists["x_category_id"] = {"LinkField":"x_category_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_category_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"model_category"};
fmodellist.Lists["x_category_id"].Data = "<?php echo $model_list->category_id->LookupFilterQuery(FALSE, "list") ?>";
fmodellist.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodellist.Lists["x_status"].Options = <?php echo json_encode($model_list->status->Options()) ?>;
fmodellist.Lists["x_is_feature"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodellist.Lists["x_is_feature"].Options = <?php echo json_encode($model_list->is_feature->Options()) ?>;
fmodellist.Lists["x_is_available"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodellist.Lists["x_is_available"].Options = <?php echo json_encode($model_list->is_available->Options()) ?>;

// Form object for search
var CurrentSearchForm = fmodellistsrch = new ew_Form("fmodellistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php if ($model_list->TotalRecs > 0 && $model_list->ExportOptions->Visible()) { ?>
<?php $model_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($model_list->SearchOptions->Visible()) { ?>
<?php $model_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($model_list->FilterOptions->Visible()) { ?>
<?php $model_list->FilterOptions->Render("body") ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php if (($model->Export == "") || (EW_EXPORT_MASTER_RECORD && $model->Export == "print")) { ?>
<?php
if ($model_list->DbMasterFilter <> "" && $model->getCurrentMasterTable() == "model_category") {
	if ($model_list->MasterRecordExists) {
?>
<?php include_once "model_categorymaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
	$bSelectLimit = $model_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($model_list->TotalRecs <= 0)
			$model_list->TotalRecs = $model->ListRecordCount();
	} else {
		if (!$model_list->Recordset && ($model_list->Recordset = $model_list->LoadRecordset()))
			$model_list->TotalRecs = $model_list->Recordset->RecordCount();
	}
	$model_list->StartRec = 1;
	if ($model_list->DisplayRecs <= 0 || ($model->Export <> "" && $model->ExportAll)) // Display all records
		$model_list->DisplayRecs = $model_list->TotalRecs;
	if (!($model->Export <> "" && $model->ExportAll))
		$model_list->SetupStartRec(); // Set up start record position
	if ($bSelectLimit)
		$model_list->Recordset = $model_list->LoadRecordset($model_list->StartRec-1, $model_list->DisplayRecs);

	// Set no record found message
	if ($model->CurrentAction == "" && $model_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$model_list->setWarningMessage(ew_DeniedMsg());
		if ($model_list->SearchWhere == "0=101")
			$model_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$model_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$model_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($model->Export == "" && $model->CurrentAction == "") { ?>
<form name="fmodellistsrch" id="fmodellistsrch" class="form-inline ewForm ewExtSearchForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($model_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fmodellistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="model">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($model_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($model_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $model_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($model_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($model_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($model_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($model_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("SearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $model_list->ShowPageHeader(); ?>
<?php
$model_list->ShowMessage();
?>
<?php if ($model_list->TotalRecs > 0 || $model->CurrentAction <> "") { ?>
<div class="box ewBox ewGrid<?php if ($model_list->IsAddOrEdit()) { ?> ewGridAddEdit<?php } ?> model">
<div class="box-header ewGridUpperPanel">
<?php if ($model->CurrentAction <> "gridadd" && $model->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($model_list->Pager)) $model_list->Pager = new cPrevNextPager($model_list->StartRec, $model_list->DisplayRecs, $model_list->TotalRecs, $model_list->AutoHidePager) ?>
<?php if ($model_list->Pager->RecordCount > 0 && $model_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($model_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $model_list->PageUrl() ?>start=<?php echo $model_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($model_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $model_list->PageUrl() ?>start=<?php echo $model_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $model_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($model_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $model_list->PageUrl() ?>start=<?php echo $model_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($model_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $model_list->PageUrl() ?>start=<?php echo $model_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $model_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($model_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $model_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $model_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $model_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($model_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<form name="fmodellist" id="fmodellist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($model_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $model_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="model">
<?php if ($model->getCurrentMasterTable() == "model_category" && $model->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="model_category">
<input type="hidden" name="fk_category_id" value="<?php echo $model->category_id->getSessionValue() ?>">
<?php } ?>
<div id="gmp_model" class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<?php if ($model_list->TotalRecs > 0 || $model->CurrentAction == "gridedit") { ?>
<table id="tbl_modellist" class="table ewTable">
<thead>
	<tr class="ewTableHeader">
<?php

// Header row
$model_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$model_list->RenderListOptions();

// Render list options (header, left)
$model_list->ListOptions->Render("header", "left");
?>
<?php if ($model->model_id->Visible) { // model_id ?>
	<?php if ($model->SortUrl($model->model_id) == "") { ?>
		<th data-name="model_id" class="<?php echo $model->model_id->HeaderCellClass() ?>"><div id="elh_model_model_id" class="model_model_id"><div class="ewTableHeaderCaption"><?php echo $model->model_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="model_id" class="<?php echo $model->model_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $model->SortUrl($model->model_id) ?>',1);"><div id="elh_model_model_id" class="model_model_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->model_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->model_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->model_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->model_name->Visible) { // model_name ?>
	<?php if ($model->SortUrl($model->model_name) == "") { ?>
		<th data-name="model_name" class="<?php echo $model->model_name->HeaderCellClass() ?>"><div id="elh_model_model_name" class="model_model_name"><div class="ewTableHeaderCaption"><?php echo $model->model_name->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="model_name" class="<?php echo $model->model_name->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $model->SortUrl($model->model_name) ?>',1);"><div id="elh_model_model_name" class="model_model_name">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->model_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($model->model_name->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->model_name->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->price->Visible) { // price ?>
	<?php if ($model->SortUrl($model->price) == "") { ?>
		<th data-name="price" class="<?php echo $model->price->HeaderCellClass() ?>"><div id="elh_model_price" class="model_price"><div class="ewTableHeaderCaption"><?php echo $model->price->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="price" class="<?php echo $model->price->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $model->SortUrl($model->price) ?>',1);"><div id="elh_model_price" class="model_price">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->price->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->price->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->price->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->model_year->Visible) { // model_year ?>
	<?php if ($model->SortUrl($model->model_year) == "") { ?>
		<th data-name="model_year" class="<?php echo $model->model_year->HeaderCellClass() ?>"><div id="elh_model_model_year" class="model_model_year"><div class="ewTableHeaderCaption"><?php echo $model->model_year->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="model_year" class="<?php echo $model->model_year->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $model->SortUrl($model->model_year) ?>',1);"><div id="elh_model_model_year" class="model_model_year">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->model_year->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($model->model_year->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->model_year->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->_thumbnail->Visible) { // thumbnail ?>
	<?php if ($model->SortUrl($model->_thumbnail) == "") { ?>
		<th data-name="_thumbnail" class="<?php echo $model->_thumbnail->HeaderCellClass() ?>"><div id="elh_model__thumbnail" class="model__thumbnail"><div class="ewTableHeaderCaption"><?php echo $model->_thumbnail->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="_thumbnail" class="<?php echo $model->_thumbnail->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $model->SortUrl($model->_thumbnail) ?>',1);"><div id="elh_model__thumbnail" class="model__thumbnail">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->_thumbnail->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($model->_thumbnail->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->_thumbnail->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->category_id->Visible) { // category_id ?>
	<?php if ($model->SortUrl($model->category_id) == "") { ?>
		<th data-name="category_id" class="<?php echo $model->category_id->HeaderCellClass() ?>"><div id="elh_model_category_id" class="model_category_id"><div class="ewTableHeaderCaption"><?php echo $model->category_id->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="category_id" class="<?php echo $model->category_id->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $model->SortUrl($model->category_id) ?>',1);"><div id="elh_model_category_id" class="model_category_id">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->category_id->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->category_id->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->category_id->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->m_order->Visible) { // m_order ?>
	<?php if ($model->SortUrl($model->m_order) == "") { ?>
		<th data-name="m_order" class="<?php echo $model->m_order->HeaderCellClass() ?>"><div id="elh_model_m_order" class="model_m_order"><div class="ewTableHeaderCaption"><?php echo $model->m_order->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="m_order" class="<?php echo $model->m_order->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $model->SortUrl($model->m_order) ?>',1);"><div id="elh_model_m_order" class="model_m_order">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->m_order->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->m_order->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->m_order->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->status->Visible) { // status ?>
	<?php if ($model->SortUrl($model->status) == "") { ?>
		<th data-name="status" class="<?php echo $model->status->HeaderCellClass() ?>"><div id="elh_model_status" class="model_status"><div class="ewTableHeaderCaption"><?php echo $model->status->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="status" class="<?php echo $model->status->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $model->SortUrl($model->status) ?>',1);"><div id="elh_model_status" class="model_status">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->status->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->status->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->status->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->is_feature->Visible) { // is_feature ?>
	<?php if ($model->SortUrl($model->is_feature) == "") { ?>
		<th data-name="is_feature" class="<?php echo $model->is_feature->HeaderCellClass() ?>"><div id="elh_model_is_feature" class="model_is_feature"><div class="ewTableHeaderCaption"><?php echo $model->is_feature->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="is_feature" class="<?php echo $model->is_feature->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $model->SortUrl($model->is_feature) ?>',1);"><div id="elh_model_is_feature" class="model_is_feature">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->is_feature->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->is_feature->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->is_feature->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php if ($model->is_available->Visible) { // is_available ?>
	<?php if ($model->SortUrl($model->is_available) == "") { ?>
		<th data-name="is_available" class="<?php echo $model->is_available->HeaderCellClass() ?>"><div id="elh_model_is_available" class="model_is_available"><div class="ewTableHeaderCaption"><?php echo $model->is_available->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="is_available" class="<?php echo $model->is_available->HeaderCellClass() ?>"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $model->SortUrl($model->is_available) ?>',1);"><div id="elh_model_is_available" class="model_is_available">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $model->is_available->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($model->is_available->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($model->is_available->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
		</div></div></th>
	<?php } ?>
<?php } ?>
<?php

// Render list options (header, right)
$model_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($model->ExportAll && $model->Export <> "") {
	$model_list->StopRec = $model_list->TotalRecs;
} else {

	// Set the last record to display
	if ($model_list->TotalRecs > $model_list->StartRec + $model_list->DisplayRecs - 1)
		$model_list->StopRec = $model_list->StartRec + $model_list->DisplayRecs - 1;
	else
		$model_list->StopRec = $model_list->TotalRecs;
}
$model_list->RecCnt = $model_list->StartRec - 1;
if ($model_list->Recordset && !$model_list->Recordset->EOF) {
	$model_list->Recordset->MoveFirst();
	$bSelectLimit = $model_list->UseSelectLimit;
	if (!$bSelectLimit && $model_list->StartRec > 1)
		$model_list->Recordset->Move($model_list->StartRec - 1);
} elseif (!$model->AllowAddDeleteRow && $model_list->StopRec == 0) {
	$model_list->StopRec = $model->GridAddRowCount;
}

// Initialize aggregate
$model->RowType = EW_ROWTYPE_AGGREGATEINIT;
$model->ResetAttrs();
$model_list->RenderRow();
while ($model_list->RecCnt < $model_list->StopRec) {
	$model_list->RecCnt++;
	if (intval($model_list->RecCnt) >= intval($model_list->StartRec)) {
		$model_list->RowCnt++;

		// Set up key count
		$model_list->KeyCount = $model_list->RowIndex;

		// Init row class and style
		$model->ResetAttrs();
		$model->CssClass = "";
		if ($model->CurrentAction == "gridadd") {
		} else {
			$model_list->LoadRowValues($model_list->Recordset); // Load row values
		}
		$model->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$model->RowAttrs = array_merge($model->RowAttrs, array('data-rowindex'=>$model_list->RowCnt, 'id'=>'r' . $model_list->RowCnt . '_model', 'data-rowtype'=>$model->RowType));

		// Render row
		$model_list->RenderRow();

		// Render list options
		$model_list->RenderListOptions();
?>
	<tr<?php echo $model->RowAttributes() ?>>
<?php

// Render list options (body, left)
$model_list->ListOptions->Render("body", "left", $model_list->RowCnt);
?>
	<?php if ($model->model_id->Visible) { // model_id ?>
		<td data-name="model_id"<?php echo $model->model_id->CellAttributes() ?>>
<span id="el<?php echo $model_list->RowCnt ?>_model_model_id" class="model_model_id">
<span<?php echo $model->model_id->ViewAttributes() ?>>
<?php echo $model->model_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($model->model_name->Visible) { // model_name ?>
		<td data-name="model_name"<?php echo $model->model_name->CellAttributes() ?>>
<span id="el<?php echo $model_list->RowCnt ?>_model_model_name" class="model_model_name">
<span<?php echo $model->model_name->ViewAttributes() ?>>
<?php echo $model->model_name->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($model->price->Visible) { // price ?>
		<td data-name="price"<?php echo $model->price->CellAttributes() ?>>
<span id="el<?php echo $model_list->RowCnt ?>_model_price" class="model_price">
<span<?php echo $model->price->ViewAttributes() ?>>
<?php echo $model->price->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($model->model_year->Visible) { // model_year ?>
		<td data-name="model_year"<?php echo $model->model_year->CellAttributes() ?>>
<span id="el<?php echo $model_list->RowCnt ?>_model_model_year" class="model_model_year">
<span<?php echo $model->model_year->ViewAttributes() ?>>
<?php echo $model->model_year->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($model->_thumbnail->Visible) { // thumbnail ?>
		<td data-name="_thumbnail"<?php echo $model->_thumbnail->CellAttributes() ?>>
<span id="el<?php echo $model_list->RowCnt ?>_model__thumbnail" class="model__thumbnail">
<span>
<?php echo ew_GetFileViewTag($model->_thumbnail, $model->_thumbnail->ListViewValue()) ?>
</span>
</span>
</td>
	<?php } ?>
	<?php if ($model->category_id->Visible) { // category_id ?>
		<td data-name="category_id"<?php echo $model->category_id->CellAttributes() ?>>
<span id="el<?php echo $model_list->RowCnt ?>_model_category_id" class="model_category_id">
<span<?php echo $model->category_id->ViewAttributes() ?>>
<?php echo $model->category_id->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($model->m_order->Visible) { // m_order ?>
		<td data-name="m_order"<?php echo $model->m_order->CellAttributes() ?>>
<span id="el<?php echo $model_list->RowCnt ?>_model_m_order" class="model_m_order">
<span<?php echo $model->m_order->ViewAttributes() ?>>
<?php echo $model->m_order->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($model->status->Visible) { // status ?>
		<td data-name="status"<?php echo $model->status->CellAttributes() ?>>
<span id="el<?php echo $model_list->RowCnt ?>_model_status" class="model_status">
<span<?php echo $model->status->ViewAttributes() ?>>
<?php echo $model->status->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($model->is_feature->Visible) { // is_feature ?>
		<td data-name="is_feature"<?php echo $model->is_feature->CellAttributes() ?>>
<span id="el<?php echo $model_list->RowCnt ?>_model_is_feature" class="model_is_feature">
<span<?php echo $model->is_feature->ViewAttributes() ?>>
<?php echo $model->is_feature->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($model->is_available->Visible) { // is_available ?>
		<td data-name="is_available"<?php echo $model->is_available->CellAttributes() ?>>
<span id="el<?php echo $model_list->RowCnt ?>_model_is_available" class="model_is_available">
<span<?php echo $model->is_available->ViewAttributes() ?>>
<?php echo $model->is_available->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$model_list->ListOptions->Render("body", "right", $model_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($model->CurrentAction <> "gridadd")
		$model_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($model->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($model_list->Recordset)
	$model_list->Recordset->Close();
?>
<div class="box-footer ewGridLowerPanel">
<?php if ($model->CurrentAction <> "gridadd" && $model->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($model_list->Pager)) $model_list->Pager = new cPrevNextPager($model_list->StartRec, $model_list->DisplayRecs, $model_list->TotalRecs, $model_list->AutoHidePager) ?>
<?php if ($model_list->Pager->RecordCount > 0 && $model_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($model_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $model_list->PageUrl() ?>start=<?php echo $model_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($model_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $model_list->PageUrl() ?>start=<?php echo $model_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $model_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($model_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $model_list->PageUrl() ?>start=<?php echo $model_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($model_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $model_list->PageUrl() ?>start=<?php echo $model_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $model_list->Pager->PageCount ?></span>
</div>
<?php } ?>
<?php if ($model_list->Pager->RecordCount > 0) { ?>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $model_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $model_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $model_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($model_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
</div>
<?php } ?>
<?php if ($model_list->TotalRecs == 0 && $model->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($model_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<script type="text/javascript">
fmodellistsrch.FilterList = <?php echo $model_list->GetFilterList() ?>;
fmodellistsrch.Init();
fmodellist.Init();
</script>
<?php
$model_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$model_list->Page_Terminate();
?>
