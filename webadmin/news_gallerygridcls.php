<?php include_once "news_galleryinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php

//
// Page class
//

$news_gallery_grid = NULL; // Initialize page object first

class cnews_gallery_grid extends cnews_gallery {

	// Page ID
	var $PageID = 'grid';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'news_gallery';

	// Page object name
	var $PageObjName = 'news_gallery_grid';

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
		$GLOBALS["MasterPage"] = &$GLOBALS["Page"];
		$GLOBALS["Page"] = &$this;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (news_gallery)
		if (!isset($GLOBALS["news_gallery"])) {
			$GLOBALS["news_gallery"] = &$this;

//			$GLOBALS["MasterTable"] = &$GLOBALS["Table"];
//			if (!isset($GLOBALS["Table"])) $GLOBALS["Table"] = &$GLOBALS["news_gallery"];

		}

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'grid', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'news_gallery', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect();

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;
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
		$this->ng_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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

//		$GLOBALS["Table"] = &$GLOBALS["MasterTable"];
		if ($url == "")
			return;

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();
		$this->Page_Redirecting($url);

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

			// Set up master detail parameters
			$this->SetUpMasterParms();

			// Hide all options
			if ($this->Export <> "" ||
				$this->CurrentAction == "gridadd" ||
				$this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
			}

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" ||
					$this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
			}

			// Set up sorting order
			$this->SetUpSortOrder();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 20; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Build filter
		$sFilter = "";

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "news") {
			global $news;
			$rsmaster = $news->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("newslist.php"); // Return to master page
			} else {
				$news->LoadListRowValues($rsmaster);
				$news->RowType = EW_ROWTYPE_MASTER; // Master row
				$news->RenderListRow();
				$rsmaster->Close();
			}
		}

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";
	}

	//  Exit inline mode
	function ClearInlineMode() {
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Perform update to grid
	function GridUpdate() {
		global $conn, $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		$sSql = $this->SQL();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue("key_count"));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue("k_key"));
			$rowaction = strval($objForm->GetValue("k_action"));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
		}
		return $bGridUpdate;
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
			$this->ng_id->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->ng_id->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $conn, $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue("key_count"));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue("k_action"));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			if ($rowaction == "insert") {
				$this->RowOldKey = strval($objForm->GetValue("k_oldkey"));
				$this->LoadOldRecord(); // Load old recordset
			}
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->ng_id->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->ClearInlineMode(); // Clear grid add mode and return
			return TRUE;
		}
		if ($bGridInsert) {

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "gridadd"; // Stay in gridadd mode
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_news_id") && $objForm->HasValue("o_news_id") && $this->news_id->CurrentValue <> $this->news_id->OldValue)
			return FALSE;
		if (!ew_Empty($this->image->Upload->Value))
			return FALSE;
		if ($objForm->HasValue("x_g_status") && $objForm->HasValue("o_g_status") && $this->g_status->CurrentValue <> $this->g_status->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_g_order") && $objForm->HasValue("o_g_order") && $this->g_order->CurrentValue <> $this->g_order->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue("key_count"));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue("k_action"));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
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

			// Reset master/detail keys
			if (strtolower($sCmd) == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->news_id->setSessionValue("");
			}

			// Reset sorting order
			if (strtolower($sCmd) == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = FALSE;
			$item->Visible = FALSE; // Default hidden
		}
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// Set up row action and key
		if (is_numeric($this->RowIndex)) {
			$objForm->Index = $this->RowIndex;
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_action\" id=\"k" . $this->RowIndex . "_action\" value=\"" . $this->RowAction . "\">";
			if ($objForm->HasValue("k_oldkey"))
				$this->RowOldKey = strval($objForm->GetValue("k_oldkey"));
			if ($this->RowOldKey <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_oldkey\" id=\"k" . $this->RowIndex . "_oldkey\" value=\"" . ew_HtmlEncode($this->RowOldKey) . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue("k_key");
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_blankrow\" id=\"k" . $this->RowIndex . "_blankrow\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentMode == "add" || $this->CurrentMode == "copy" || $this->CurrentMode == "edit") {
				$oListOpt = &$this->ListOptions->Items["griddelete"];
				$oListOpt->Body = "<a class=\"ewGridLink\" href=\"javascript:void(0);\" onclick=\"ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . "<img src=\"phpimages/delete.gif\" alt=\"" . ew_HtmlEncode($Language->Phrase("DeleteLink")) . "\" title=\"" . ew_HtmlEncode($Language->Phrase("DeleteLink")) . "\" width=\"16\" height=\"16\" border=\"0\">" . "</a>";
			}
		}
		if ($this->CurrentMode == "edit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . $this->ng_id->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();
	}

	// Set record key
	function SetRecordKey(&$key, $rs) {
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs->fields('ng_id');
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
		$this->ng_id->CurrentValue = NULL;
		$this->ng_id->OldValue = $this->ng_id->CurrentValue;
		$this->news_id->CurrentValue = NULL;
		$this->news_id->OldValue = $this->news_id->CurrentValue;
		$this->image->Upload->DbValue = NULL;
		$this->image->OldValue = $this->image->Upload->DbValue;
		$this->image->Upload->Index = $this->RowIndex;
		$this->image->Upload->RemoveDbFromSession();
		$this->g_status->CurrentValue = 1;
		$this->g_status->OldValue = $this->g_status->CurrentValue;
		$this->g_order->CurrentValue = 0;
		$this->g_order->OldValue = $this->g_order->CurrentValue;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->ng_id->FldIsDetailKey && $this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->ng_id->setFormValue($objForm->GetValue("x_ng_id"));
		if (!$this->news_id->FldIsDetailKey) {
			$this->news_id->setFormValue($objForm->GetValue("x_news_id"));
		}
		$this->news_id->setOldValue($objForm->GetValue("o_news_id"));
		if (!$this->g_status->FldIsDetailKey) {
			$this->g_status->setFormValue($objForm->GetValue("x_g_status"));
		}
		$this->g_status->setOldValue($objForm->GetValue("o_g_status"));
		if (!$this->g_order->FldIsDetailKey) {
			$this->g_order->setFormValue($objForm->GetValue("x_g_order"));
		}
		$this->g_order->setOldValue($objForm->GetValue("o_g_order"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "add")
			$this->ng_id->CurrentValue = $this->ng_id->FormValue;
		$this->news_id->CurrentValue = $this->news_id->FormValue;
		$this->g_status->CurrentValue = $this->g_status->FormValue;
		$this->g_order->CurrentValue = $this->g_order->FormValue;
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
		$this->ng_id->setDbValue($rs->fields('ng_id'));
		$this->news_id->setDbValue($rs->fields('news_id'));
		$this->image->Upload->DbValue = $rs->fields('image');
		$this->image->Upload->Index = $this->RowIndex;
		$this->image->Upload->SaveDbToSession();
		$this->g_status->setDbValue($rs->fields('g_status'));
		$this->g_order->setDbValue($rs->fields('g_order'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		$arKeys[] = $this->RowOldKey;
		$cnt = count($arKeys);
		if ($cnt >= 1) {
			if (strval($arKeys[0]) <> "")
				$this->ng_id->CurrentValue = strval($arKeys[0]); // ng_id
			else
				$bValidKey = FALSE;
		} else {
			$bValidKey = FALSE;
		}

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

			// ng_id
			$this->ng_id->LinkCustomAttributes = "";
			$this->ng_id->HrefValue = "";
			$this->ng_id->TooltipValue = "";

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

			// ng_id
			// news_id

			$this->news_id->EditCustomAttributes = "";
			if ($this->news_id->getSessionValue() <> "") {
				$this->news_id->CurrentValue = $this->news_id->getSessionValue();
				$this->news_id->OldValue = $this->news_id->CurrentValue;
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
			// ng_id

			$this->ng_id->HrefValue = "";

			// news_id
			$this->news_id->HrefValue = "";

			// image
			$this->image->HrefValue = "";

			// g_status
			$this->g_status->HrefValue = "";

			// g_order
			$this->g_order->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// ng_id
			$this->ng_id->EditCustomAttributes = "";
			$this->ng_id->EditValue = $this->ng_id->CurrentValue;
			$this->ng_id->ViewCustomAttributes = "";

			// news_id
			$this->news_id->EditCustomAttributes = "";
			if ($this->news_id->getSessionValue() <> "") {
				$this->news_id->CurrentValue = $this->news_id->getSessionValue();
				$this->news_id->OldValue = $this->news_id->CurrentValue;
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
			// ng_id

			$this->ng_id->HrefValue = "";

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

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $conn, $Language, $Security;
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = 'ew_ErrorFn';
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;
		} else {
			$this->LoadRowValues($rs); // Load row values
		}

		// Clone old rows
		$rsold = ($rs) ? $rs->GetRows() : array();
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
				$sThisKey .= $row['ng_id'];
				$this->image->UploadPath = '../assets/images/news_gallery/';
				@unlink(ew_UploadPathEx(TRUE, $this->image->UploadPath) . $row['image']);
				$conn->raiseErrorFn = 'ew_ErrorFn';
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

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
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
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

			// Save old values
			$rsold = &$rs->fields;
			$rsnew = array();

			// news_id
			$this->news_id->SetDbValueDef($rsnew, $this->news_id->CurrentValue, 0, $this->news_id->ReadOnly);

			// image
			if (!($this->image->ReadOnly)) {
			$this->image->UploadPath = '../assets/images/news_gallery/';
			if ($this->image->Upload->Action == "1") { // Keep
			} elseif ($this->image->Upload->Action == "2" || $this->image->Upload->Action == "3") { // Update/Remove
			$this->image->Upload->DbValue = $rs->fields('image'); // Get original value
			if (is_null($this->image->Upload->Value)) {
				$rsnew['image'] = NULL;
			} else {
				if ($this->image->Upload->FileName == $this->image->Upload->DbValue) { // Upload file name same as old file name
					$rsnew['image'] = $this->image->Upload->FileName;
				} else {
					$rsnew['image'] = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->image->UploadPath), $this->image->Upload->FileName);
				}
			}
			}
			}

			// g_status
			$this->g_status->SetDbValueDef($rsnew, $this->g_status->CurrentValue, 0, $this->g_status->ReadOnly);

			// g_order
			$this->g_order->SetDbValueDef($rsnew, $this->g_order->CurrentValue, 0, $this->g_order->ReadOnly);

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
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
				$conn->raiseErrorFn = 'ew_ErrorFn';
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
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

		// image
		$this->image->Upload->RemoveFromSession(); // Remove file value from Session
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;

		// Set up foreign key field value from Session
			if ($this->getCurrentMasterTable() == "news") {
				$this->news_id->CurrentValue = $this->news_id->getSessionValue();
			}
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

		// Hide foreign keys
		$sMasterTblVar = $this->getCurrentMasterTable();
		if ($sMasterTblVar == "news") {
			$this->news_id->Visible = FALSE;
			if ($GLOBALS["news"]->EventCancelled) $this->EventCancelled = TRUE;
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
