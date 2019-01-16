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

$model_view = NULL; // Initialize page object first

class cmodel_view extends cmodel {

	// Page ID
	var $PageID = 'view';

	// Project ID
	var $ProjectID = '{086EEFE9-31D6-48E2-919A-4B361863B384}';

	// Table name
	var $TableName = 'model';

	// Page object name
	var $PageObjName = 'model_view';

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
		$KeyUrl = "";
		if (@$_GET["model_id"] <> "") {
			$this->RecKey["model_id"] = $_GET["model_id"];
			$KeyUrl .= "&amp;model_id=" . urlencode($this->RecKey["model_id"]);
		}
		$this->ExportPrintUrl = $this->PageUrl() . "export=print" . $KeyUrl;
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html" . $KeyUrl;
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel" . $KeyUrl;
		$this->ExportWordUrl = $this->PageUrl() . "export=word" . $KeyUrl;
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml" . $KeyUrl;
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv" . $KeyUrl;
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf" . $KeyUrl;

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Table object (model_category)
		if (!isset($GLOBALS['model_category'])) $GLOBALS['model_category'] = new cmodel_category();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'view', TRUE);

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

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
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
		if (!$Security->CanView()) {
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
	var $ExportOptions; // Export options
	var $OtherOptions = array(); // Other options
	var $DisplayRecs = 1;
	var $DbMasterFilter;
	var $DbDetailFilter;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $RecCnt;
	var $RecKey = array();
	var $IsModal = FALSE;
	var $Recordset;

	//
	// Page main
	//
	function Page_Main() {
		global $Language, $gbSkipHeaderFooter, $EW_EXPORT;

		// Check modal
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;
		$sReturnUrl = "";
		$bMatchRecord = FALSE;

		// Set up master/detail parameters
		$this->SetupMasterParms();
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET["model_id"] <> "") {
				$this->model_id->setQueryStringValue($_GET["model_id"]);
				$this->RecKey["model_id"] = $this->model_id->QueryStringValue;
			} elseif (@$_POST["model_id"] <> "") {
				$this->model_id->setFormValue($_POST["model_id"]);
				$this->RecKey["model_id"] = $this->model_id->FormValue;
			} else {
				$sReturnUrl = "modellist.php"; // Return to list
			}

			// Get action
			$this->CurrentAction = "I"; // Display form
			switch ($this->CurrentAction) {
				case "I": // Get a record to display
					if (!$this->LoadRow()) { // Load record based on key
						if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "")
							$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
						$sReturnUrl = "modellist.php"; // No matching record, return to list
					}
			}
		} else {
			$sReturnUrl = "modellist.php"; // Not page request, return to list
		}
		if ($sReturnUrl <> "")
			$this->Page_Terminate($sReturnUrl);

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Render row
		$this->RowType = EW_ROWTYPE_VIEW;
		$this->ResetAttrs();
		$this->RenderRow();

		// Set up detail parameters
		$this->SetupDetailParms();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = &$options["action"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("ViewPageAddLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->AddUrl) . "'});\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("ViewPageAddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Edit
		$item = &$option->Add("edit");
		$editcaption = ew_HtmlTitle($Language->Phrase("ViewPageEditLink"));
		if ($this->IsModal) // Modal
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "'});\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("ViewPageEditLink") . "</a>";
		$item->Visible = ($this->EditUrl <> "" && $Security->CanEdit());

		// Delete
		$item = &$option->Add("delete");
		if ($this->IsModal) // Handle as inline delete
			$item->Body = "<a onclick=\"return ew_ConfirmDelete(this);\" class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode(ew_UrlAddQuery($this->DeleteUrl, "a_delete=1")) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		else
			$item->Body = "<a class=\"ewAction ewDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("ViewPageDeleteLink")) . "\" href=\"" . ew_HtmlEncode($this->DeleteUrl) . "\">" . $Language->Phrase("ViewPageDeleteLink") . "</a>";
		$item->Visible = ($this->DeleteUrl <> "" && $Security->CanDelete());
		$option = &$options["detail"];
		$DetailTableLink = "";
		$DetailViewTblVar = "";
		$DetailCopyTblVar = "";
		$DetailEditTblVar = "";

		// "detail_model_color"
		$item = &$option->Add("detail_model_color");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("model_color", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("model_colorlist.php?" . EW_TABLE_SHOW_MASTER . "=model&fk_model_id=" . urlencode(strval($this->model_id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["model_color_grid"] && $GLOBALS["model_color_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'model_color')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=model_color")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "model_color";
		}
		if ($GLOBALS["model_color_grid"] && $GLOBALS["model_color_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'model_color')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=model_color")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "model_color";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'model_color');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "model_color";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_model_gallery"
		$item = &$option->Add("detail_model_gallery");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("model_gallery", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("model_gallerylist.php?" . EW_TABLE_SHOW_MASTER . "=model&fk_model_id=" . urlencode(strval($this->model_id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["model_gallery_grid"] && $GLOBALS["model_gallery_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'model_gallery')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=model_gallery")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "model_gallery";
		}
		if ($GLOBALS["model_gallery_grid"] && $GLOBALS["model_gallery_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'model_gallery')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=model_gallery")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "model_gallery";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'model_gallery');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "model_gallery";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_feature"
		$item = &$option->Add("detail_feature");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("feature", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("featurelist.php?" . EW_TABLE_SHOW_MASTER . "=model&fk_model_id=" . urlencode(strval($this->model_id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["feature_grid"] && $GLOBALS["feature_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'feature')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=feature")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "feature";
		}
		if ($GLOBALS["feature_grid"] && $GLOBALS["feature_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'feature')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=feature")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "feature";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'feature');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "feature";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// "detail_specification"
		$item = &$option->Add("detail_specification");
		$body = $Language->Phrase("ViewPageDetailLink") . $Language->TablePhrase("specification", "TblCaption");
		$body = "<a class=\"btn btn-default btn-sm ewRowLink ewDetail\" data-action=\"list\" href=\"" . ew_HtmlEncode("specificationlist.php?" . EW_TABLE_SHOW_MASTER . "=model&fk_model_id=" . urlencode(strval($this->model_id->CurrentValue)) . "") . "\">" . $body . "</a>";
		$links = "";
		if ($GLOBALS["specification_grid"] && $GLOBALS["specification_grid"]->DetailView && $Security->CanView() && $Security->AllowView(CurrentProjectID() . 'specification')) {
			$links .= "<li><a class=\"ewRowLink ewDetailView\" data-action=\"view\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailViewLink")) . "\" href=\"" . ew_HtmlEncode($this->GetViewUrl(EW_TABLE_SHOW_DETAIL . "=specification")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailViewLink")) . "</a></li>";
			if ($DetailViewTblVar <> "") $DetailViewTblVar .= ",";
			$DetailViewTblVar .= "specification";
		}
		if ($GLOBALS["specification_grid"] && $GLOBALS["specification_grid"]->DetailEdit && $Security->CanEdit() && $Security->AllowEdit(CurrentProjectID() . 'specification')) {
			$links .= "<li><a class=\"ewRowLink ewDetailEdit\" data-action=\"edit\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("MasterDetailEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GetEditUrl(EW_TABLE_SHOW_DETAIL . "=specification")) . "\">" . ew_HtmlImageAndText($Language->Phrase("MasterDetailEditLink")) . "</a></li>";
			if ($DetailEditTblVar <> "") $DetailEditTblVar .= ",";
			$DetailEditTblVar .= "specification";
		}
		if ($links <> "") {
			$body .= "<button class=\"dropdown-toggle btn btn-default btn-sm ewDetail\" data-toggle=\"dropdown\"><b class=\"caret\"></b></button>";
			$body .= "<ul class=\"dropdown-menu\">". $links . "</ul>";
		}
		$body = "<div class=\"btn-group\">" . $body . "</div>";
		$item->Body = $body;
		$item->Visible = $Security->AllowList(CurrentProjectID() . 'specification');
		if ($item->Visible) {
			if ($DetailTableLink <> "") $DetailTableLink .= ",";
			$DetailTableLink .= "specification";
		}
		if ($this->ShowMultipleDetails) $item->Visible = FALSE;

		// Multiple details
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
			$oListOpt = &$option->Add("details");
			$oListOpt->Body = $body;
		}

		// Set up detail default
		$option = &$options["detail"];
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$option->UseImageAndText = TRUE;
		$ar = explode(",", $DetailTableLink);
		$cnt = count($ar);
		$option->UseDropDownButton = ($cnt > 1);
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Set up action default
		$option = &$options["action"];
		$option->DropDownButtonPhrase = $Language->Phrase("ButtonActions");
		$option->UseImageAndText = TRUE;
		$option->UseDropDownButton = FALSE;
		$option->UseButtonGroup = TRUE;
		$item = &$option->Add($option->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
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

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->AddUrl = $this->GetAddUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();
		$this->ListUrl = $this->GetListUrl();
		$this->SetupOtherOptions();

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
				if ($GLOBALS["model_color_grid"]->DetailView) {
					$GLOBALS["model_color_grid"]->CurrentMode = "view";

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
				if ($GLOBALS["model_gallery_grid"]->DetailView) {
					$GLOBALS["model_gallery_grid"]->CurrentMode = "view";

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
				if ($GLOBALS["feature_grid"]->DetailView) {
					$GLOBALS["feature_grid"]->CurrentMode = "view";

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
				if ($GLOBALS["specification_grid"]->DetailView) {
					$GLOBALS["specification_grid"]->CurrentMode = "view";

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
		$PageId = "view";
		$Breadcrumb->Add("view", $PageId, $url);
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
if (!isset($model_view)) $model_view = new cmodel_view();

// Page init
$model_view->Page_Init();

// Page main
$model_view->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$model_view->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "view";
var CurrentForm = fmodelview = new ew_Form("fmodelview", "view");

// Form_CustomValidate event
fmodelview.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
fmodelview.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
fmodelview.Lists["x_category_id"] = {"LinkField":"x_category_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_category_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"model_category"};
fmodelview.Lists["x_category_id"].Data = "<?php echo $model_view->category_id->LookupFilterQuery(FALSE, "view") ?>";
fmodelview.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodelview.Lists["x_status"].Options = <?php echo json_encode($model_view->status->Options()) ?>;
fmodelview.Lists["x_is_feature"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodelview.Lists["x_is_feature"].Options = <?php echo json_encode($model_view->is_feature->Options()) ?>;
fmodelview.Lists["x_is_available"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fmodelview.Lists["x_is_available"].Options = <?php echo json_encode($model_view->is_available->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<div class="ewToolbar">
<?php $model_view->ExportOptions->Render("body") ?>
<?php
	foreach ($model_view->OtherOptions as &$option)
		$option->Render("body");
?>
<div class="clearfix"></div>
</div>
<?php $model_view->ShowPageHeader(); ?>
<?php
$model_view->ShowMessage();
?>
<form name="fmodelview" id="fmodelview" class="form-inline ewForm ewViewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($model_view->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $model_view->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="model">
<input type="hidden" name="modal" value="<?php echo intval($model_view->IsModal) ?>">
<table class="table table-striped table-bordered table-hover table-condensed ewViewTable">
<?php if ($model->model_id->Visible) { // model_id ?>
	<tr id="r_model_id">
		<td class="col-sm-2"><span id="elh_model_model_id"><?php echo $model->model_id->FldCaption() ?></span></td>
		<td data-name="model_id"<?php echo $model->model_id->CellAttributes() ?>>
<span id="el_model_model_id">
<span<?php echo $model->model_id->ViewAttributes() ?>>
<?php echo $model->model_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->model_name->Visible) { // model_name ?>
	<tr id="r_model_name">
		<td class="col-sm-2"><span id="elh_model_model_name"><?php echo $model->model_name->FldCaption() ?></span></td>
		<td data-name="model_name"<?php echo $model->model_name->CellAttributes() ?>>
<span id="el_model_model_name">
<span<?php echo $model->model_name->ViewAttributes() ?>>
<?php echo $model->model_name->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->price->Visible) { // price ?>
	<tr id="r_price">
		<td class="col-sm-2"><span id="elh_model_price"><?php echo $model->price->FldCaption() ?></span></td>
		<td data-name="price"<?php echo $model->price->CellAttributes() ?>>
<span id="el_model_price">
<span<?php echo $model->price->ViewAttributes() ?>>
<?php echo $model->price->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->displacement->Visible) { // displacement ?>
	<tr id="r_displacement">
		<td class="col-sm-2"><span id="elh_model_displacement"><?php echo $model->displacement->FldCaption() ?></span></td>
		<td data-name="displacement"<?php echo $model->displacement->CellAttributes() ?>>
<span id="el_model_displacement">
<span<?php echo $model->displacement->ViewAttributes() ?>>
<?php echo $model->displacement->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->url_slug->Visible) { // url_slug ?>
	<tr id="r_url_slug">
		<td class="col-sm-2"><span id="elh_model_url_slug"><?php echo $model->url_slug->FldCaption() ?></span></td>
		<td data-name="url_slug"<?php echo $model->url_slug->CellAttributes() ?>>
<span id="el_model_url_slug">
<span<?php echo $model->url_slug->ViewAttributes() ?>>
<?php echo $model->url_slug->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->model_logo->Visible) { // model_logo ?>
	<tr id="r_model_logo">
		<td class="col-sm-2"><span id="elh_model_model_logo"><?php echo $model->model_logo->FldCaption() ?></span></td>
		<td data-name="model_logo"<?php echo $model->model_logo->CellAttributes() ?>>
<span id="el_model_model_logo">
<span>
<?php echo ew_GetFileViewTag($model->model_logo, $model->model_logo->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->model_year->Visible) { // model_year ?>
	<tr id="r_model_year">
		<td class="col-sm-2"><span id="elh_model_model_year"><?php echo $model->model_year->FldCaption() ?></span></td>
		<td data-name="model_year"<?php echo $model->model_year->CellAttributes() ?>>
<span id="el_model_model_year">
<span<?php echo $model->model_year->ViewAttributes() ?>>
<?php echo $model->model_year->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->icon_menu->Visible) { // icon_menu ?>
	<tr id="r_icon_menu">
		<td class="col-sm-2"><span id="elh_model_icon_menu"><?php echo $model->icon_menu->FldCaption() ?></span></td>
		<td data-name="icon_menu"<?php echo $model->icon_menu->CellAttributes() ?>>
<span id="el_model_icon_menu">
<span>
<?php echo ew_GetFileViewTag($model->icon_menu, $model->icon_menu->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->_thumbnail->Visible) { // thumbnail ?>
	<tr id="r__thumbnail">
		<td class="col-sm-2"><span id="elh_model__thumbnail"><?php echo $model->_thumbnail->FldCaption() ?></span></td>
		<td data-name="_thumbnail"<?php echo $model->_thumbnail->CellAttributes() ?>>
<span id="el_model__thumbnail">
<span>
<?php echo ew_GetFileViewTag($model->_thumbnail, $model->_thumbnail->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->full_image->Visible) { // full_image ?>
	<tr id="r_full_image">
		<td class="col-sm-2"><span id="elh_model_full_image"><?php echo $model->full_image->FldCaption() ?></span></td>
		<td data-name="full_image"<?php echo $model->full_image->CellAttributes() ?>>
<span id="el_model_full_image">
<span>
<?php echo ew_GetFileViewTag($model->full_image, $model->full_image->ViewValue) ?>
</span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->description->Visible) { // description ?>
	<tr id="r_description">
		<td class="col-sm-2"><span id="elh_model_description"><?php echo $model->description->FldCaption() ?></span></td>
		<td data-name="description"<?php echo $model->description->CellAttributes() ?>>
<span id="el_model_description">
<span<?php echo $model->description->ViewAttributes() ?>>
<?php echo $model->description->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->youtube_url->Visible) { // youtube_url ?>
	<tr id="r_youtube_url">
		<td class="col-sm-2"><span id="elh_model_youtube_url"><?php echo $model->youtube_url->FldCaption() ?></span></td>
		<td data-name="youtube_url"<?php echo $model->youtube_url->CellAttributes() ?>>
<span id="el_model_youtube_url">
<span<?php echo $model->youtube_url->ViewAttributes() ?>>
<?php echo $model->youtube_url->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->category_id->Visible) { // category_id ?>
	<tr id="r_category_id">
		<td class="col-sm-2"><span id="elh_model_category_id"><?php echo $model->category_id->FldCaption() ?></span></td>
		<td data-name="category_id"<?php echo $model->category_id->CellAttributes() ?>>
<span id="el_model_category_id">
<span<?php echo $model->category_id->ViewAttributes() ?>>
<?php echo $model->category_id->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->m_order->Visible) { // m_order ?>
	<tr id="r_m_order">
		<td class="col-sm-2"><span id="elh_model_m_order"><?php echo $model->m_order->FldCaption() ?></span></td>
		<td data-name="m_order"<?php echo $model->m_order->CellAttributes() ?>>
<span id="el_model_m_order">
<span<?php echo $model->m_order->ViewAttributes() ?>>
<?php echo $model->m_order->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->seo_description->Visible) { // seo_description ?>
	<tr id="r_seo_description">
		<td class="col-sm-2"><span id="elh_model_seo_description"><?php echo $model->seo_description->FldCaption() ?></span></td>
		<td data-name="seo_description"<?php echo $model->seo_description->CellAttributes() ?>>
<span id="el_model_seo_description">
<span<?php echo $model->seo_description->ViewAttributes() ?>>
<?php echo $model->seo_description->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->seo_keyword->Visible) { // seo_keyword ?>
	<tr id="r_seo_keyword">
		<td class="col-sm-2"><span id="elh_model_seo_keyword"><?php echo $model->seo_keyword->FldCaption() ?></span></td>
		<td data-name="seo_keyword"<?php echo $model->seo_keyword->CellAttributes() ?>>
<span id="el_model_seo_keyword">
<span<?php echo $model->seo_keyword->ViewAttributes() ?>>
<?php echo $model->seo_keyword->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->status->Visible) { // status ?>
	<tr id="r_status">
		<td class="col-sm-2"><span id="elh_model_status"><?php echo $model->status->FldCaption() ?></span></td>
		<td data-name="status"<?php echo $model->status->CellAttributes() ?>>
<span id="el_model_status">
<span<?php echo $model->status->ViewAttributes() ?>>
<?php echo $model->status->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->is_feature->Visible) { // is_feature ?>
	<tr id="r_is_feature">
		<td class="col-sm-2"><span id="elh_model_is_feature"><?php echo $model->is_feature->FldCaption() ?></span></td>
		<td data-name="is_feature"<?php echo $model->is_feature->CellAttributes() ?>>
<span id="el_model_is_feature">
<span<?php echo $model->is_feature->ViewAttributes() ?>>
<?php echo $model->is_feature->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
<?php if ($model->is_available->Visible) { // is_available ?>
	<tr id="r_is_available">
		<td class="col-sm-2"><span id="elh_model_is_available"><?php echo $model->is_available->FldCaption() ?></span></td>
		<td data-name="is_available"<?php echo $model->is_available->CellAttributes() ?>>
<span id="el_model_is_available">
<span<?php echo $model->is_available->ViewAttributes() ?>>
<?php echo $model->is_available->ViewValue ?></span>
</span>
</td>
	</tr>
<?php } ?>
</table>
<?php
	if (in_array("model_color", explode(",", $model->getCurrentDetailTable())) && $model_color->DetailView) {
?>
<?php if ($model->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("model_color", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "model_colorgrid.php" ?>
<?php } ?>
<?php
	if (in_array("model_gallery", explode(",", $model->getCurrentDetailTable())) && $model_gallery->DetailView) {
?>
<?php if ($model->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("model_gallery", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "model_gallerygrid.php" ?>
<?php } ?>
<?php
	if (in_array("feature", explode(",", $model->getCurrentDetailTable())) && $feature->DetailView) {
?>
<?php if ($model->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("feature", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "featuregrid.php" ?>
<?php } ?>
<?php
	if (in_array("specification", explode(",", $model->getCurrentDetailTable())) && $specification->DetailView) {
?>
<?php if ($model->getCurrentDetailTable() <> "") { ?>
<h4 class="ewDetailCaption"><?php echo $Language->TablePhrase("specification", "TblCaption") ?></h4>
<?php } ?>
<?php include_once "specificationgrid.php" ?>
<?php } ?>
</form>
<script type="text/javascript">
fmodelview.Init();
</script>
<?php
$model_view->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$model_view->Page_Terminate();
?>
