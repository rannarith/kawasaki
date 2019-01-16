<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg14.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql14.php") ?>
<?php include_once "phpfn14.php" ?>
<?php include_once "accessoryinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "userfn14.php" ?>
<?php

//
// Page class
//

$accessory_delete = NULL; // Initialize page object first

class caccessory_delete extends caccessory {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = '{086EEFE9-31D6-48E2-919A-4B361863B384}';

	// Table name
	var $TableName = 'accessory';

	// Page object name
	var $PageObjName = 'accessory_delete';

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

		// Table object (accessory)
		if (!isset($GLOBALS["accessory"]) || get_class($GLOBALS["accessory"]) == "caccessory") {
			$GLOBALS["accessory"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["accessory"];
		}

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'accessory', TRUE);

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

		// User profile
		$UserProfile = new cUserProfile();

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanDelete()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("accessorylist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}

		// NOTE: Security object may be needed in other part of the script, skip set to Nothing
		// 
		// Security = null;
		// 

		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->acs_id->SetVisibility();
		if ($this->IsAdd() || $this->IsCopy() || $this->IsGridAdd())
			$this->acs_id->Visible = FALSE;
		$this->model_id->SetVisibility();
		$this->title->SetVisibility();
		$this->price->SetVisibility();
		$this->_thumbnail->SetVisibility();
		$this->type->SetVisibility();
		$this->status->SetVisibility();
		$this->is_new->SetVisibility();
		$this->wish_list->SetVisibility();

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
		global $EW_EXPORT, $accessory;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($accessory);
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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $StartRec;
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $StartRowCnt = 1;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("accessorylist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in accessory class, accessoryinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} elseif (@$_GET["a_delete"] == "1") {
			$this->CurrentAction = "D"; // Delete record directly
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		if ($this->CurrentAction == "D") {
			$this->SendEmail = TRUE; // Send email on delete success
			if ($this->DeleteRows()) { // Delete rows
				if ($this->getSuccessMessage() == "")
					$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
				$this->Page_Terminate($this->getReturnUrl()); // Return to caller
			} else { // Delete failed
				$this->CurrentAction = "I"; // Display record
			}
		}
		if ($this->CurrentAction == "I") { // Load records for display
			if ($this->Recordset = $this->LoadRecordset())
				$this->TotalRecs = $this->Recordset->RecordCount(); // Get record count
			if ($this->TotalRecs <= 0) { // No record found, exit
				if ($this->Recordset)
					$this->Recordset->Close();
				$this->Page_Terminate("accessorylist.php"); // Return to list
			}
		}
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
		$this->acs_id->setDbValue($row['acs_id']);
		$this->model_id->setDbValue($row['model_id']);
		$this->title->setDbValue($row['title']);
		$this->price->setDbValue($row['price']);
		$this->_thumbnail->Upload->DbValue = $row['thumbnail'];
		$this->_thumbnail->setDbValue($this->_thumbnail->Upload->DbValue);
		$this->short_des->setDbValue($row['short_des']);
		$this->long_des->setDbValue($row['long_des']);
		$this->type->setDbValue($row['type']);
		$this->status->setDbValue($row['status']);
		$this->is_new->setDbValue($row['is_new']);
		$this->wish_list->setDbValue($row['wish_list']);
	}

	// Return a row with default values
	function NewRow() {
		$row = array();
		$row['acs_id'] = NULL;
		$row['model_id'] = NULL;
		$row['title'] = NULL;
		$row['price'] = NULL;
		$row['thumbnail'] = NULL;
		$row['short_des'] = NULL;
		$row['long_des'] = NULL;
		$row['type'] = NULL;
		$row['status'] = NULL;
		$row['is_new'] = NULL;
		$row['wish_list'] = NULL;
		return $row;
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF)
			return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->acs_id->DbValue = $row['acs_id'];
		$this->model_id->DbValue = $row['model_id'];
		$this->title->DbValue = $row['title'];
		$this->price->DbValue = $row['price'];
		$this->_thumbnail->Upload->DbValue = $row['thumbnail'];
		$this->short_des->DbValue = $row['short_des'];
		$this->long_des->DbValue = $row['long_des'];
		$this->type->DbValue = $row['type'];
		$this->status->DbValue = $row['status'];
		$this->is_new->DbValue = $row['is_new'];
		$this->wish_list->DbValue = $row['wish_list'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// acs_id
		// model_id
		// title
		// price
		// thumbnail
		// short_des
		// long_des
		// type
		// status
		// is_new
		// wish_list

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// acs_id
		$this->acs_id->ViewValue = $this->acs_id->CurrentValue;
		$this->acs_id->ViewCustomAttributes = "";

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

		// title
		$this->title->ViewValue = $this->title->CurrentValue;
		$this->title->ViewCustomAttributes = "";

		// price
		$this->price->ViewValue = $this->price->CurrentValue;
		$this->price->ViewCustomAttributes = "";

		// thumbnail
		$this->_thumbnail->UploadPath = '../assets/images/accessory/';
		if (!ew_Empty($this->_thumbnail->Upload->DbValue)) {
			$this->_thumbnail->ImageWidth = 200;
			$this->_thumbnail->ImageHeight = 0;
			$this->_thumbnail->ImageAlt = $this->_thumbnail->FldAlt();
			$this->_thumbnail->ViewValue = $this->_thumbnail->Upload->DbValue;
		} else {
			$this->_thumbnail->ViewValue = "";
		}
		$this->_thumbnail->ViewCustomAttributes = "";

		// type
		if (strval($this->type->CurrentValue) <> "") {
			$this->type->ViewValue = "";
			$arwrk = explode(",", strval($this->type->CurrentValue));
			$cnt = count($arwrk);
			for ($ari = 0; $ari < $cnt; $ari++) {
				$this->type->ViewValue .= $this->type->OptionCaption(trim($arwrk[$ari]));
				if ($ari < $cnt-1) $this->type->ViewValue .= ew_ViewOptionSeparator($ari);
			}
		} else {
			$this->type->ViewValue = NULL;
		}
		$this->type->ViewCustomAttributes = "";

		// status
		if (strval($this->status->CurrentValue) <> "") {
			$this->status->ViewValue = $this->status->OptionCaption($this->status->CurrentValue);
		} else {
			$this->status->ViewValue = NULL;
		}
		$this->status->ViewCustomAttributes = "";

		// is_new
		$this->is_new->ViewValue = $this->is_new->CurrentValue;
		$this->is_new->ViewCustomAttributes = "";

		// wish_list
		$this->wish_list->ViewValue = $this->wish_list->CurrentValue;
		$this->wish_list->ViewCustomAttributes = "";

			// acs_id
			$this->acs_id->LinkCustomAttributes = "";
			$this->acs_id->HrefValue = "";
			$this->acs_id->TooltipValue = "";

			// model_id
			$this->model_id->LinkCustomAttributes = "";
			$this->model_id->HrefValue = "";
			$this->model_id->TooltipValue = "";

			// title
			$this->title->LinkCustomAttributes = "";
			$this->title->HrefValue = "";
			$this->title->TooltipValue = "";

			// price
			$this->price->LinkCustomAttributes = "";
			$this->price->HrefValue = "";
			$this->price->TooltipValue = "";

			// thumbnail
			$this->_thumbnail->LinkCustomAttributes = "";
			$this->_thumbnail->UploadPath = '../assets/images/accessory/';
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
				$this->_thumbnail->LinkAttrs["data-rel"] = "accessory_x__thumbnail";
				ew_AppendClass($this->_thumbnail->LinkAttrs["class"], "ewLightbox");
			}

			// type
			$this->type->LinkCustomAttributes = "";
			$this->type->HrefValue = "";
			$this->type->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";

			// is_new
			$this->is_new->LinkCustomAttributes = "";
			$this->is_new->HrefValue = "";
			$this->is_new->TooltipValue = "";

			// wish_list
			$this->wish_list->LinkCustomAttributes = "";
			$this->wish_list->HrefValue = "";
			$this->wish_list->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		}
		$rows = ($rs) ? $rs->GetRows() : array();
		$conn->BeginTrans();

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['acs_id'];

				// Delete old files
				$this->LoadDbValues($row);
				$this->_thumbnail->OldUploadPath = '../assets/images/accessory/';
				$OldFiles = ew_Empty($row['thumbnail']) ? array() : array($row['thumbnail']);
				$OldFileCount = count($OldFiles);
				for ($i = 0; $i < $OldFileCount; $i++) {
					if (file_exists($this->_thumbnail->OldPhysicalUploadPath() . $OldFiles[$i]))
						@unlink($this->_thumbnail->OldPhysicalUploadPath() . $OldFiles[$i]);
				}
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		}
		if (!$DeleteRows) {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			$conn->CommitTrans(); // Commit the changes
		} else {
			$conn->RollbackTrans(); // Rollback changes
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("accessorylist.php"), "", $this->TableVar, TRUE);
		$PageId = "delete";
		$Breadcrumb->Add("delete", $PageId, $url);
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($accessory_delete)) $accessory_delete = new caccessory_delete();

// Page init
$accessory_delete->Page_Init();

// Page main
$accessory_delete->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$accessory_delete->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "delete";
var CurrentForm = faccessorydelete = new ew_Form("faccessorydelete", "delete");

// Form_CustomValidate event
faccessorydelete.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid.
 	return true;
 }

// Use JavaScript validation or not
faccessorydelete.ValidateRequired = <?php echo json_encode(EW_CLIENT_VALIDATE) ?>;

// Dynamic selection lists
faccessorydelete.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":true,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"model"};
faccessorydelete.Lists["x_model_id"].Data = "<?php echo $accessory_delete->model_id->LookupFilterQuery(FALSE, "delete") ?>";
faccessorydelete.Lists["x_type[]"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
faccessorydelete.Lists["x_type[]"].Options = <?php echo json_encode($accessory_delete->type->Options()) ?>;
faccessorydelete.Lists["x_status"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
faccessorydelete.Lists["x_status"].Options = <?php echo json_encode($accessory_delete->status->Options()) ?>;

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php $accessory_delete->ShowPageHeader(); ?>
<?php
$accessory_delete->ShowMessage();
?>
<form name="faccessorydelete" id="faccessorydelete" class="form-inline ewForm ewDeleteForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($accessory_delete->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $accessory_delete->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="accessory">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($accessory_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="box ewBox ewGrid">
<div class="<?php if (ew_IsResponsiveLayout()) { ?>table-responsive <?php } ?>ewGridMiddlePanel">
<table class="table ewTable">
	<thead>
	<tr class="ewTableHeader">
<?php if ($accessory->acs_id->Visible) { // acs_id ?>
		<th class="<?php echo $accessory->acs_id->HeaderCellClass() ?>"><span id="elh_accessory_acs_id" class="accessory_acs_id"><?php echo $accessory->acs_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($accessory->model_id->Visible) { // model_id ?>
		<th class="<?php echo $accessory->model_id->HeaderCellClass() ?>"><span id="elh_accessory_model_id" class="accessory_model_id"><?php echo $accessory->model_id->FldCaption() ?></span></th>
<?php } ?>
<?php if ($accessory->title->Visible) { // title ?>
		<th class="<?php echo $accessory->title->HeaderCellClass() ?>"><span id="elh_accessory_title" class="accessory_title"><?php echo $accessory->title->FldCaption() ?></span></th>
<?php } ?>
<?php if ($accessory->price->Visible) { // price ?>
		<th class="<?php echo $accessory->price->HeaderCellClass() ?>"><span id="elh_accessory_price" class="accessory_price"><?php echo $accessory->price->FldCaption() ?></span></th>
<?php } ?>
<?php if ($accessory->_thumbnail->Visible) { // thumbnail ?>
		<th class="<?php echo $accessory->_thumbnail->HeaderCellClass() ?>"><span id="elh_accessory__thumbnail" class="accessory__thumbnail"><?php echo $accessory->_thumbnail->FldCaption() ?></span></th>
<?php } ?>
<?php if ($accessory->type->Visible) { // type ?>
		<th class="<?php echo $accessory->type->HeaderCellClass() ?>"><span id="elh_accessory_type" class="accessory_type"><?php echo $accessory->type->FldCaption() ?></span></th>
<?php } ?>
<?php if ($accessory->status->Visible) { // status ?>
		<th class="<?php echo $accessory->status->HeaderCellClass() ?>"><span id="elh_accessory_status" class="accessory_status"><?php echo $accessory->status->FldCaption() ?></span></th>
<?php } ?>
<?php if ($accessory->is_new->Visible) { // is_new ?>
		<th class="<?php echo $accessory->is_new->HeaderCellClass() ?>"><span id="elh_accessory_is_new" class="accessory_is_new"><?php echo $accessory->is_new->FldCaption() ?></span></th>
<?php } ?>
<?php if ($accessory->wish_list->Visible) { // wish_list ?>
		<th class="<?php echo $accessory->wish_list->HeaderCellClass() ?>"><span id="elh_accessory_wish_list" class="accessory_wish_list"><?php echo $accessory->wish_list->FldCaption() ?></span></th>
<?php } ?>
	</tr>
	</thead>
	<tbody>
<?php
$accessory_delete->RecCnt = 0;
$i = 0;
while (!$accessory_delete->Recordset->EOF) {
	$accessory_delete->RecCnt++;
	$accessory_delete->RowCnt++;

	// Set row properties
	$accessory->ResetAttrs();
	$accessory->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$accessory_delete->LoadRowValues($accessory_delete->Recordset);

	// Render row
	$accessory_delete->RenderRow();
?>
	<tr<?php echo $accessory->RowAttributes() ?>>
<?php if ($accessory->acs_id->Visible) { // acs_id ?>
		<td<?php echo $accessory->acs_id->CellAttributes() ?>>
<span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_acs_id" class="accessory_acs_id">
<span<?php echo $accessory->acs_id->ViewAttributes() ?>>
<?php echo $accessory->acs_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($accessory->model_id->Visible) { // model_id ?>
		<td<?php echo $accessory->model_id->CellAttributes() ?>>
<span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_model_id" class="accessory_model_id">
<span<?php echo $accessory->model_id->ViewAttributes() ?>>
<?php echo $accessory->model_id->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($accessory->title->Visible) { // title ?>
		<td<?php echo $accessory->title->CellAttributes() ?>>
<span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_title" class="accessory_title">
<span<?php echo $accessory->title->ViewAttributes() ?>>
<?php echo $accessory->title->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($accessory->price->Visible) { // price ?>
		<td<?php echo $accessory->price->CellAttributes() ?>>
<span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_price" class="accessory_price">
<span<?php echo $accessory->price->ViewAttributes() ?>>
<?php echo $accessory->price->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($accessory->_thumbnail->Visible) { // thumbnail ?>
		<td<?php echo $accessory->_thumbnail->CellAttributes() ?>>
<span id="el<?php echo $accessory_delete->RowCnt ?>_accessory__thumbnail" class="accessory__thumbnail">
<span>
<?php echo ew_GetFileViewTag($accessory->_thumbnail, $accessory->_thumbnail->ListViewValue()) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($accessory->type->Visible) { // type ?>
		<td<?php echo $accessory->type->CellAttributes() ?>>
<span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_type" class="accessory_type">
<span<?php echo $accessory->type->ViewAttributes() ?>>
<?php echo $accessory->type->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($accessory->status->Visible) { // status ?>
		<td<?php echo $accessory->status->CellAttributes() ?>>
<span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_status" class="accessory_status">
<span<?php echo $accessory->status->ViewAttributes() ?>>
<?php echo $accessory->status->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($accessory->is_new->Visible) { // is_new ?>
		<td<?php echo $accessory->is_new->CellAttributes() ?>>
<span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_is_new" class="accessory_is_new">
<span<?php echo $accessory->is_new->ViewAttributes() ?>>
<?php echo $accessory->is_new->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($accessory->wish_list->Visible) { // wish_list ?>
		<td<?php echo $accessory->wish_list->CellAttributes() ?>>
<span id="el<?php echo $accessory_delete->RowCnt ?>_accessory_wish_list" class="accessory_wish_list">
<span<?php echo $accessory->wish_list->ViewAttributes() ?>>
<?php echo $accessory->wish_list->ListViewValue() ?></span>
</span>
</td>
<?php } ?>
	</tr>
<?php
	$accessory_delete->Recordset->MoveNext();
}
$accessory_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("DeleteBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $accessory_delete->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
</div>
</form>
<script type="text/javascript">
faccessorydelete.Init();
</script>
<?php
$accessory_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$accessory_delete->Page_Terminate();
?>
