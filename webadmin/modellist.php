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

$model_list = NULL; // Initialize page object first

class cmodel_list extends cmodel {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'model';

	// Page object name
	var $PageObjName = 'model_list';

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

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'model', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "span";
		$this->ExportOptions->TagClassName = "ewExportOption";
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

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();
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

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $DisplayRecs = 20;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
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
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $RestoreSearch;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";
		if ($this->IsPageRequest()) { // Validate request

			// Handle reset command
			$this->ResetCmd();

			// Hide all options
			if ($this->Export <> "" ||
				$this->CurrentAction == "gridadd" ||
				$this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ExportOptions->HideAllOptions();
			}

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Restore search parms from Session
			$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if ($sSrchBasic == "" && $sSrchAdvanced == "") {

			// Load basic search from default
			$this->BasicSearchKeyword = $this->BasicSearchKeywordDefault;
			$this->BasicSearchType = $this->BasicSearchTypeDefault;
			$this->setSessionBasicSearchType($this->BasicSearchTypeDefault);
			if ($this->BasicSearchKeyword != "")
				$sSrchBasic = $this->BasicSearchWhere();
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->SearchWhere <> "") {
			if ($sSrchBasic == "")
				$this->ResetBasicSearchParms();
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			if (!$this->RestoreSearch) {
				$this->StartRec = 1; // Reset start record counter
				$this->setStartRecordNumber($this->StartRec);
			}

		//} else {
		} elseif ($this->RestoreSearch) {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue("k_key"));
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
			$rowindex++; // next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue("k_key"));
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

	// Return basic search SQL
	function BasicSearchSQL($Keyword) {
		$sKeyword = ew_AdjustSql($Keyword);
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->model_name, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->model_logo, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->model_year, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->icon_menu, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->thumbnail, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->full_image, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->description, $Keyword);
		$this->BuildBasicSearchSQL($sWhere, $this->youtube_url, $Keyword);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $Keyword) {
		if ($Keyword == EW_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NULL";
		} elseif ($Keyword == EW_NOT_NULL_VALUE) {
			$sWrk = $Fld->FldExpression . " IS NOT NULL";
		} else {
			$sFldExpression = ($Fld->FldVirtualExpression <> $Fld->FldExpression) ? $Fld->FldVirtualExpression : $Fld->FldBasicSearchExpression;
			$sWrk = $sFldExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING));
		}
		if ($Where <> "") $Where .= " OR ";
		$Where .= $sWrk;
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere() {
		global $Security;
		$sSearchStr = "";
		$sSearchKeyword = $this->BasicSearchKeyword;
		$sSearchType = $this->BasicSearchType;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				while (strpos($sSearch, "  ") !== FALSE)
					$sSearch = str_replace("  ", " ", $sSearch);
				$arKeyword = explode(" ", trim($sSearch));
				foreach ($arKeyword as $sKeyword) {
					if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
					$sSearchStr .= "(" . $this->BasicSearchSQL($sKeyword) . ")";
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL($sSearch);
			}
		}
		if ($sSearchKeyword <> "") {
			$this->setSessionBasicSearchKeyword($sSearchKeyword);
			$this->setSessionBasicSearchType($sSearchType);
		}
		return $sSearchStr;
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
		$this->setSessionBasicSearchKeyword("");
		$this->setSessionBasicSearchType($this->BasicSearchTypeDefault);
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$bRestore = TRUE;
		if ($this->BasicSearchKeyword <> "") $bRestore = FALSE;
		$this->RestoreSearch = $bRestore;
		if ($bRestore) {

			// Restore basic search values
			$this->BasicSearchKeyword = $this->getSessionBasicSearchKeyword();
			if ($this->getSessionBasicSearchType() == "") $this->setSessionBasicSearchType("=");
			$this->BasicSearchType = $this->getSessionBasicSearchType();
		}
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->model_id); // model_id
			$this->UpdateSort($this->model_name); // model_name
			$this->UpdateSort($this->model_logo); // model_logo
			$this->UpdateSort($this->model_year); // model_year
			$this->UpdateSort($this->icon_menu); // icon_menu
			$this->UpdateSort($this->thumbnail); // thumbnail
			$this->UpdateSort($this->full_image); // full_image
			$this->UpdateSort($this->youtube_url); // youtube_url
			$this->UpdateSort($this->category_id); // category_id
			$this->UpdateSort($this->status); // status
			$this->UpdateSort($this->m_order); // m_order
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->SqlOrderBy() <> "") {
				$sOrderBy = $this->SqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
				$this->model_id->setSort("DESC");
			}
		}
	}

	// Reset command
	// cmd=reset (Reset search parameters)
	// cmd=resetall (Reset search and master/detail parameters)
	// cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Get reset command
		if (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];

			// Reset search criteria
			if (strtolower($sCmd) == "reset" || strtolower($sCmd) == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->model_id->setSort("");
				$this->model_name->setSort("");
				$this->model_logo->setSort("");
				$this->model_year->setSort("");
				$this->icon_menu->setSort("");
				$this->thumbnail->setSort("");
				$this->full_image->setSort("");
				$this->youtube_url->setSort("");
				$this->category_id->setSort("");
				$this->status->setSort("");
				$this->m_order->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "delete"
		$item = &$this->ListOptions->Add("delete");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;

		// "detail_specification"
		$item = &$this->ListOptions->Add("detail_specification");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;
		if (!isset($GLOBALS["specification_grid"])) $GLOBALS["specification_grid"] = new cspecification_grid;

		// "detail_feature"
		$item = &$this->ListOptions->Add("detail_feature");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;
		if (!isset($GLOBALS["feature_grid"])) $GLOBALS["feature_grid"] = new cfeature_grid;

		// "detail_model_gallery"
		$item = &$this->ListOptions->Add("detail_model_gallery");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;
		if (!isset($GLOBALS["model_gallery_grid"])) $GLOBALS["model_gallery_grid"] = new cmodel_gallery_grid;

		// "detail_model_color"
		$item = &$this->ListOptions->Add("detail_model_color");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->IsLoggedIn();
		$item->OnLeft = FALSE;
		if (!isset($GLOBALS["model_color_grid"])) $GLOBALS["model_color_grid"] = new cmodel_color_grid;

		// Call ListOptions_Load event
		$this->ListOptions_Load();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"" . $this->EditUrl . "\">" . "<img src=\"phpimages/edit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . "</a>";
		}

		// "delete"
		$oListOpt = &$this->ListOptions->Items["delete"];
		if ($Security->IsLoggedIn())
			$oListOpt->Body = "<a class=\"ewRowLink\"" . "" . " href=\"" . $this->DeleteUrl . "\">" . "<img src=\"phpimages/delete.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DeleteLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DeleteLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . "</a>";

		// "detail_specification"
		$oListOpt = &$this->ListOptions->Items["detail_specification"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<img src=\"phpimages/detail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . $Language->TablePhrase("specification", "TblCaption");
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"specificationlist.php?" . EW_TABLE_SHOW_MASTER . "=model&model_id=" . urlencode(strval($this->model_id->CurrentValue)) . "\">" . $oListOpt->Body . "</a>";
			$links = "";
			if ($GLOBALS["specification_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
				$links .= "<a class=\"ewRowLink\" href=\"" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=specification") . "\">" . "<img src=\"phpimages/edit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . "</a>&nbsp;";
			if ($links <> "") $oListOpt->Body .= "<br>" . $links;
		}

		// "detail_feature"
		$oListOpt = &$this->ListOptions->Items["detail_feature"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<img src=\"phpimages/detail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . $Language->TablePhrase("feature", "TblCaption");
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"featurelist.php?" . EW_TABLE_SHOW_MASTER . "=model&model_id=" . urlencode(strval($this->model_id->CurrentValue)) . "\">" . $oListOpt->Body . "</a>";
			$links = "";
			if ($GLOBALS["feature_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
				$links .= "<a class=\"ewRowLink\" href=\"" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=feature") . "\">" . "<img src=\"phpimages/edit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . "</a>&nbsp;";
			if ($links <> "") $oListOpt->Body .= "<br>" . $links;
		}

		// "detail_model_gallery"
		$oListOpt = &$this->ListOptions->Items["detail_model_gallery"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<img src=\"phpimages/detail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . $Language->TablePhrase("model_gallery", "TblCaption");
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"model_gallerylist.php?" . EW_TABLE_SHOW_MASTER . "=model&model_id=" . urlencode(strval($this->model_id->CurrentValue)) . "\">" . $oListOpt->Body . "</a>";
			$links = "";
			if ($GLOBALS["model_gallery_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
				$links .= "<a class=\"ewRowLink\" href=\"" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=model_gallery") . "\">" . "<img src=\"phpimages/edit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . "</a>&nbsp;";
			if ($links <> "") $oListOpt->Body .= "<br>" . $links;
		}

		// "detail_model_color"
		$oListOpt = &$this->ListOptions->Items["detail_model_color"];
		if ($Security->IsLoggedIn()) {
			$oListOpt->Body = "<img src=\"phpimages/detail.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DetailLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . $Language->TablePhrase("model_color", "TblCaption");
			$oListOpt->Body = "<a class=\"ewRowLink\" href=\"model_colorlist.php?" . EW_TABLE_SHOW_MASTER . "=model&model_id=" . urlencode(strval($this->model_id->CurrentValue)) . "\">" . $oListOpt->Body . "</a>";
			$links = "";
			if ($GLOBALS["model_color_grid"]->DetailEdit && $Security->IsLoggedIn() && $Security->IsLoggedIn())
				$links .= "<a class=\"ewRowLink\" href=\"" . $this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=model_color") . "\">" . "<img src=\"phpimages/edit.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("EditLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . "</a>&nbsp;";
			if ($links <> "") $oListOpt->Body .= "<br>" . $links;
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
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

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearchKeyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		$this->BasicSearchType = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {
		global $conn;

		// Call Recordset Selecting event
		$this->Recordset_Selecting($this->CurrentFilter);

		// Load List page SQL
		$sSql = $this->SelectSQL();
		if ($offset > -1 && $rowcnt > -1)
			$sSql .= " LIMIT $rowcnt OFFSET $offset";

		// Load recordset
		$rs = ew_LoadRecordset($sSql);

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
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

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("model_id")) <> "")
			$this->model_id->CurrentValue = $this->getKey("model_id"); // model_id
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
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

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
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

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
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var model_list = new ew_Page("model_list");
model_list.PageID = "list"; // Page ID
var EW_PAGE_ID = model_list.PageID; // For backward compatibility

// Form object
var fmodellist = new ew_Form("fmodellist");

// Form_CustomValidate event
fmodellist.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmodellist.ValidateRequired = true;
<?php } else { ?>
fmodellist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmodellist.Lists["x_category_id"] = {"LinkField":"x_category_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_category_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
var fmodellistsrch = new ew_Form("fmodellistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php
	$bSelectLimit = EW_SELECT_LIMIT;
	if ($bSelectLimit) {
		$model_list->TotalRecs = $model->SelectRecordCount();
	} else {
		if ($model_list->Recordset = $model_list->LoadRecordset())
			$model_list->TotalRecs = $model_list->Recordset->RecordCount();
	}
	$model_list->StartRec = 1;
	if ($model_list->DisplayRecs <= 0 || ($model->Export <> "" && $model->ExportAll)) // Display all records
		$model_list->DisplayRecs = $model_list->TotalRecs;
	if (!($model->Export <> "" && $model->ExportAll))
		$model_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$model_list->Recordset = $model_list->LoadRecordset($model_list->StartRec-1, $model_list->DisplayRecs);
?>
<p style="white-space: nowrap;"><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $model->TableCaption() ?>&nbsp;&nbsp;</span>
<?php $model_list->ExportOptions->Render("body"); ?>
</p>
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($model->Export == "" && $model->CurrentAction == "") { ?>
<form name="fmodellistsrch" id="fmodellistsrch" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<a href="javascript:fmodellistsrch.ToggleSearchPanel();" style="text-decoration: none;"><img id="fmodellistsrch_SearchImage" src="phpimages/collapse.gif" alt="" width="9" height="9" border="0"></a><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("Search") ?></span><br>
<div id="fmodellistsrch_SearchPanel">
<input type="hidden" name="t" value="model">
<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" size="20" value="<?php echo ew_HtmlEncode($model->getSessionBasicSearchKeyword()) ?>">
	<input type="submit" name="btnsubmit" id="btnsubmit" value="<?php echo ew_BtnCaption($Language->Phrase("QuickSearchBtn")) ?>">&nbsp;
	<a href="<?php echo $model_list->PageUrl() ?>cmd=reset"><?php echo $Language->Phrase("ShowAll") ?></a>&nbsp;
</div>
<div id="xsr_2" class="ewRow">
	<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="="<?php if ($model->getSessionBasicSearchType() == "=") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("ExactPhrase") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="AND"<?php if ($model->getSessionBasicSearchType() == "AND") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AllWord") ?></label>&nbsp;&nbsp;<label><input type="radio" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="OR"<?php if ($model->getSessionBasicSearchType() == "OR") { ?> checked="checked"<?php } ?>><?php echo $Language->Phrase("AnyWord") ?></label>
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
<br>
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridUpperPanel">
<?php if ($model->CurrentAction <> "gridadd" && $model->CurrentAction <> "gridedit") { ?>
<form name="ewpagerform" id="ewpagerform" class="ewForm" action="<?php echo ew_CurrentPage() ?>">
<table border="0" cellspacing="0" cellpadding="0" class="ewPager">
	<tr>
		<td nowrap>
<?php if (!isset($model_list->Pager)) $model_list->Pager = new cPrevNextPager($model_list->StartRec, $model_list->DisplayRecs, $model_list->TotalRecs) ?>
<?php if ($model_list->Pager->RecordCount > 0) { ?>
	<table border="0" cellspacing="0" cellpadding="0"><tr><td><span class="phpmaker"><?php echo $Language->Phrase("Page") ?>&nbsp;</span></td>
<!--first page button-->
	<?php if ($model_list->Pager->FirstButton->Enabled) { ?>
	<td><a href="<?php echo $model_list->PageUrl() ?>start=<?php echo $model_list->Pager->FirstButton->Start ?>"><img src="phpimages/first.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/firstdisab.gif" alt="<?php echo $Language->Phrase("PagerFirst") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--previous page button-->
	<?php if ($model_list->Pager->PrevButton->Enabled) { ?>
	<td><a href="<?php echo $model_list->PageUrl() ?>start=<?php echo $model_list->Pager->PrevButton->Start ?>"><img src="phpimages/prev.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></a></td>
	<?php } else { ?>
	<td><img src="phpimages/prevdisab.gif" alt="<?php echo $Language->Phrase("PagerPrevious") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--current page number-->
	<td><input type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" id="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $model_list->Pager->CurrentPage ?>" size="4"></td>
<!--next page button-->
	<?php if ($model_list->Pager->NextButton->Enabled) { ?>
	<td><a href="<?php echo $model_list->PageUrl() ?>start=<?php echo $model_list->Pager->NextButton->Start ?>"><img src="phpimages/next.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/nextdisab.gif" alt="<?php echo $Language->Phrase("PagerNext") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
<!--last page button-->
	<?php if ($model_list->Pager->LastButton->Enabled) { ?>
	<td><a href="<?php echo $model_list->PageUrl() ?>start=<?php echo $model_list->Pager->LastButton->Start ?>"><img src="phpimages/last.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></a></td>	
	<?php } else { ?>
	<td><img src="phpimages/lastdisab.gif" alt="<?php echo $Language->Phrase("PagerLast") ?>" width="16" height="16" border="0"></td>
	<?php } ?>
	<td><span class="phpmaker">&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $model_list->Pager->PageCount ?></span></td>
	</tr></table>
	</td>	
	<td>&nbsp;&nbsp;&nbsp;&nbsp;</td>
	<td>
	<span class="phpmaker"><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $model_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $model_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $model_list->Pager->RecordCount ?></span>
<?php } else { ?>
	<?php if ($model_list->SearchWhere == "0=101") { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("EnterSearchCriteria") ?></span>
	<?php } else { ?>
	<span class="phpmaker"><?php echo $Language->Phrase("NoRecord") ?></span>
	<?php } ?>
<?php } ?>
		</td>
	</tr>
</table>
</form>
<?php } ?>
<span class="phpmaker">
<?php if ($Security->IsLoggedIn()) { ?>
<?php if ($model_list->AddUrl <> "") { ?>
<a class="ewGridLink" href="<?php echo $model_list->AddUrl ?>"><?php echo $Language->Phrase("AddLink") ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($specification_grid->DetailAdd && $Security->IsLoggedIn()) { ?>
<a class="ewGridLink" href="<?php echo $model->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=specification" ?>"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $model->TableCaption() ?>/<?php echo $specification->TableCaption() ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($feature_grid->DetailAdd && $Security->IsLoggedIn()) { ?>
<a class="ewGridLink" href="<?php echo $model->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=feature" ?>"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $model->TableCaption() ?>/<?php echo $feature->TableCaption() ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($model_gallery_grid->DetailAdd && $Security->IsLoggedIn()) { ?>
<a class="ewGridLink" href="<?php echo $model->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=model_gallery" ?>"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $model->TableCaption() ?>/<?php echo $model_gallery->TableCaption() ?></a>&nbsp;&nbsp;
<?php } ?>
<?php if ($model_color_grid->DetailAdd && $Security->IsLoggedIn()) { ?>
<a class="ewGridLink" href="<?php echo $model->GetAddUrl() . "?" . EW_TABLE_SHOW_DETAIL . "=model_color" ?>"><?php echo $Language->Phrase("AddLink") ?>&nbsp;<?php echo $model->TableCaption() ?>/<?php echo $model_color->TableCaption() ?></a>&nbsp;&nbsp;
<?php } ?>
<?php } ?>
</span>
</div>
<form name="fmodellist" id="fmodellist" class="ewForm" action="" method="post">
<input type="hidden" name="t" value="model">
<div id="gmp_model" class="ewGridMiddlePanel">
<?php if ($model_list->TotalRecs > 0) { ?>
<table cellspacing="0" id="tbl_modellist" class="ewTable ewTableSeparate">
<?php echo $model->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Render list options
$model_list->RenderListOptions();

// Render list options (header, left)
$model_list->ListOptions->Render("header", "left");
?>
<?php if ($model->model_id->Visible) { // model_id ?>
	<?php if ($model->SortUrl($model->model_id) == "") { ?>
		<td><span id="elh_model_model_id" class="model_model_id"><?php echo $model->model_id->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $model->SortUrl($model->model_id) ?>',1);"><span id="elh_model_model_id" class="model_model_id">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model->model_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($model->model_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model->model_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model->model_name->Visible) { // model_name ?>
	<?php if ($model->SortUrl($model->model_name) == "") { ?>
		<td><span id="elh_model_model_name" class="model_model_name"><?php echo $model->model_name->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $model->SortUrl($model->model_name) ?>',1);"><span id="elh_model_model_name" class="model_model_name">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model->model_name->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($model->model_name->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model->model_name->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model->model_logo->Visible) { // model_logo ?>
	<?php if ($model->SortUrl($model->model_logo) == "") { ?>
		<td><span id="elh_model_model_logo" class="model_model_logo"><?php echo $model->model_logo->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $model->SortUrl($model->model_logo) ?>',1);"><span id="elh_model_model_logo" class="model_model_logo">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model->model_logo->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($model->model_logo->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model->model_logo->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model->model_year->Visible) { // model_year ?>
	<?php if ($model->SortUrl($model->model_year) == "") { ?>
		<td><span id="elh_model_model_year" class="model_model_year"><?php echo $model->model_year->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $model->SortUrl($model->model_year) ?>',1);"><span id="elh_model_model_year" class="model_model_year">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model->model_year->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($model->model_year->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model->model_year->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model->icon_menu->Visible) { // icon_menu ?>
	<?php if ($model->SortUrl($model->icon_menu) == "") { ?>
		<td><span id="elh_model_icon_menu" class="model_icon_menu"><?php echo $model->icon_menu->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $model->SortUrl($model->icon_menu) ?>',1);"><span id="elh_model_icon_menu" class="model_icon_menu">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model->icon_menu->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($model->icon_menu->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model->icon_menu->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model->thumbnail->Visible) { // thumbnail ?>
	<?php if ($model->SortUrl($model->thumbnail) == "") { ?>
		<td><span id="elh_model_thumbnail" class="model_thumbnail"><?php echo $model->thumbnail->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $model->SortUrl($model->thumbnail) ?>',1);"><span id="elh_model_thumbnail" class="model_thumbnail">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model->thumbnail->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($model->thumbnail->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model->thumbnail->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model->full_image->Visible) { // full_image ?>
	<?php if ($model->SortUrl($model->full_image) == "") { ?>
		<td><span id="elh_model_full_image" class="model_full_image"><?php echo $model->full_image->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $model->SortUrl($model->full_image) ?>',1);"><span id="elh_model_full_image" class="model_full_image">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model->full_image->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($model->full_image->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model->full_image->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model->youtube_url->Visible) { // youtube_url ?>
	<?php if ($model->SortUrl($model->youtube_url) == "") { ?>
		<td><span id="elh_model_youtube_url" class="model_youtube_url"><?php echo $model->youtube_url->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $model->SortUrl($model->youtube_url) ?>',1);"><span id="elh_model_youtube_url" class="model_youtube_url">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model->youtube_url->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></td><td style="width: 10px;"><?php if ($model->youtube_url->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model->youtube_url->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model->category_id->Visible) { // category_id ?>
	<?php if ($model->SortUrl($model->category_id) == "") { ?>
		<td><span id="elh_model_category_id" class="model_category_id"><?php echo $model->category_id->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $model->SortUrl($model->category_id) ?>',1);"><span id="elh_model_category_id" class="model_category_id">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model->category_id->FldCaption() ?></td><td style="width: 10px;"><?php if ($model->category_id->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model->category_id->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model->status->Visible) { // status ?>
	<?php if ($model->SortUrl($model->status) == "") { ?>
		<td><span id="elh_model_status" class="model_status"><?php echo $model->status->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $model->SortUrl($model->status) ?>',1);"><span id="elh_model_status" class="model_status">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model->status->FldCaption() ?></td><td style="width: 10px;"><?php if ($model->status->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model->status->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
	<?php } ?>
<?php } ?>		
<?php if ($model->m_order->Visible) { // m_order ?>
	<?php if ($model->SortUrl($model->m_order) == "") { ?>
		<td><span id="elh_model_m_order" class="model_m_order"><?php echo $model->m_order->FldCaption() ?></span></td>
	<?php } else { ?>
		<td><div class="ewPointer" onmousedown="ew_Sort(event,'<?php echo $model->SortUrl($model->m_order) ?>',1);"><span id="elh_model_m_order" class="model_m_order">
			<table cellspacing="0" class="ewTableHeaderBtn"><thead><tr><td><?php echo $model->m_order->FldCaption() ?></td><td style="width: 10px;"><?php if ($model->m_order->getSort() == "ASC") { ?><img src="phpimages/sortup.gif" width="10" height="9" border="0"><?php } elseif ($model->m_order->getSort() == "DESC") { ?><img src="phpimages/sortdown.gif" width="10" height="9" border="0"><?php } ?></td></tr></thead></table>
		</span></div></td>		
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
		<td<?php echo $model->model_id->CellAttributes() ?>><span id="el<?php echo $model_list->RowCnt ?>_model_model_id" class="model_model_id">
<span<?php echo $model->model_id->ViewAttributes() ?>>
<?php echo $model->model_id->ListViewValue() ?></span>
<a name="<?php echo $model_list->PageObjName . "_row_" . $model_list->RowCnt ?>" id="<?php echo $model_list->PageObjName . "_row_" . $model_list->RowCnt ?>"></a></span></td>
	<?php } ?>
	<?php if ($model->model_name->Visible) { // model_name ?>
		<td<?php echo $model->model_name->CellAttributes() ?>><span id="el<?php echo $model_list->RowCnt ?>_model_model_name" class="model_model_name">
<span<?php echo $model->model_name->ViewAttributes() ?>>
<?php echo $model->model_name->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($model->model_logo->Visible) { // model_logo ?>
		<td<?php echo $model->model_logo->CellAttributes() ?>><span id="el<?php echo $model_list->RowCnt ?>_model_model_logo" class="model_model_logo">
<span>
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
</span>
</span></td>
	<?php } ?>
	<?php if ($model->model_year->Visible) { // model_year ?>
		<td<?php echo $model->model_year->CellAttributes() ?>><span id="el<?php echo $model_list->RowCnt ?>_model_model_year" class="model_model_year">
<span<?php echo $model->model_year->ViewAttributes() ?>>
<?php echo $model->model_year->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($model->icon_menu->Visible) { // icon_menu ?>
		<td<?php echo $model->icon_menu->CellAttributes() ?>><span id="el<?php echo $model_list->RowCnt ?>_model_icon_menu" class="model_icon_menu">
<span>
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
</span>
</span></td>
	<?php } ?>
	<?php if ($model->thumbnail->Visible) { // thumbnail ?>
		<td<?php echo $model->thumbnail->CellAttributes() ?>><span id="el<?php echo $model_list->RowCnt ?>_model_thumbnail" class="model_thumbnail">
<span>
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
</span>
</span></td>
	<?php } ?>
	<?php if ($model->full_image->Visible) { // full_image ?>
		<td<?php echo $model->full_image->CellAttributes() ?>><span id="el<?php echo $model_list->RowCnt ?>_model_full_image" class="model_full_image">
<span>
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
</span>
</span></td>
	<?php } ?>
	<?php if ($model->youtube_url->Visible) { // youtube_url ?>
		<td<?php echo $model->youtube_url->CellAttributes() ?>><span id="el<?php echo $model_list->RowCnt ?>_model_youtube_url" class="model_youtube_url">
<span<?php echo $model->youtube_url->ViewAttributes() ?>>
<?php echo $model->youtube_url->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($model->category_id->Visible) { // category_id ?>
		<td<?php echo $model->category_id->CellAttributes() ?>><span id="el<?php echo $model_list->RowCnt ?>_model_category_id" class="model_category_id">
<span<?php echo $model->category_id->ViewAttributes() ?>>
<?php echo $model->category_id->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($model->status->Visible) { // status ?>
		<td<?php echo $model->status->CellAttributes() ?>><span id="el<?php echo $model_list->RowCnt ?>_model_status" class="model_status">
<span<?php echo $model->status->ViewAttributes() ?>>
<?php echo $model->status->ListViewValue() ?></span>
</span></td>
	<?php } ?>
	<?php if ($model->m_order->Visible) { // m_order ?>
		<td<?php echo $model->m_order->CellAttributes() ?>><span id="el<?php echo $model_list->RowCnt ?>_model_m_order" class="model_m_order">
<span<?php echo $model->m_order->ViewAttributes() ?>>
<?php echo $model->m_order->ListViewValue() ?></span>
</span></td>
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
</td></tr></table>
<script type="text/javascript">
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
