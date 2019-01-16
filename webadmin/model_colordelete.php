<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "model_colorinfo.php" ?>
<?php include_once "modelinfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$model_color_delete = NULL; // Initialize page object first

class cmodel_color_delete extends cmodel_color {

	// Page ID
	var $PageID = 'delete';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'model_color';

	// Page object name
	var $PageObjName = 'model_color_delete';

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

		// Table object (model_color)
		if (!isset($GLOBALS["model_color"])) {
			$GLOBALS["model_color"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["model_color"];
		}

		// Table object (model)
		if (!isset($GLOBALS['model'])) $GLOBALS['model'] = new cmodel();

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'delete', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'model_color', TRUE);

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
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"];
		$this->mc_id->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();

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
	var $TotalRecs = 0;
	var $RecCnt;
	var $RecKeys = array();
	var $Recordset;
	var $RowCnt = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $Language;

		// Load key parameters
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		$sFilter = $this->GetKeyFilter();
		if ($sFilter == "")
			$this->Page_Terminate("model_colorlist.php"); // Prevent SQL injection, return to list

		// Set up filter (SQL WHHERE clause) and get return SQL
		// SQL constructor in model_color class, model_colorinfo.php

		$this->CurrentFilter = $sFilter;

		// Get action
		if (@$_POST["a_delete"] <> "") {
			$this->CurrentAction = $_POST["a_delete"];
		} else {
			$this->CurrentAction = "I"; // Display record
		}
		switch ($this->CurrentAction) {
			case "D": // Delete
				$this->SendEmail = TRUE; // Send email on delete success
				if ($this->DeleteRows()) { // delete rows
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("DeleteSuccess")); // Set up success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				}
		}
	}

// No functions
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
		$this->mc_id->setDbValue($rs->fields('mc_id'));
		$this->image->Upload->DbValue = $rs->fields('image');
		$this->model_id->setDbValue($rs->fields('model_id'));
		$this->color_code->setDbValue($rs->fields('color_code'));
		$this->m_order->setDbValue($rs->fields('m_order'));
		$this->m_status->setDbValue($rs->fields('m_status'));
	}

	// Render row values based on field settings
	function RenderRow() {
		global $conn, $Security, $Language;
		global $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// mc_id
		// image
		// model_id
		// color_code
		// m_order
		// m_status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// mc_id
			$this->mc_id->ViewValue = $this->mc_id->CurrentValue;
			$this->mc_id->ViewCustomAttributes = "";

			// image
			$this->image->UploadPath = '../assets/images/model_color/';
			if (!ew_Empty($this->image->Upload->DbValue)) {
				$this->image->ViewValue = $this->image->Upload->DbValue;
				$this->image->ImageWidth = 200;
				$this->image->ImageHeight = 0;
				$this->image->ImageAlt = $this->image->FldAlt();
			} else {
				$this->image->ViewValue = "";
			}
			$this->image->ViewCustomAttributes = "";

			// model_id
			if (strval($this->model_id->CurrentValue) <> "") {
				$sFilterWrk = "`model_id`" . ew_SearchString("=", $this->model_id->CurrentValue, EW_DATATYPE_NUMBER);
			$sSqlWrk = "SELECT `model_id`, `model_name` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `model`";
			$sWhereWrk = "";
			if ($sFilterWrk <> "") {
				ew_AddFilter($sWhereWrk, $sFilterWrk);
			}
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `model_name` ASC";
				$rswrk = $conn->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$this->model_id->ViewValue = $rswrk->fields('DispFld');
					$rswrk->Close();
				} else {
					$this->model_id->ViewValue = $this->model_id->CurrentValue;
				}
			} else {
				$this->model_id->ViewValue = NULL;
			}
			$this->model_id->ViewCustomAttributes = "";

			// color_code
			$this->color_code->ViewValue = $this->color_code->CurrentValue;
			$this->color_code->ViewCustomAttributes = "";

			// m_order
			$this->m_order->ViewValue = $this->m_order->CurrentValue;
			$this->m_order->ViewCustomAttributes = "";

			// m_status
			if (strval($this->m_status->CurrentValue) <> "") {
				switch ($this->m_status->CurrentValue) {
					case $this->m_status->FldTagValue(1):
						$this->m_status->ViewValue = $this->m_status->FldTagCaption(1) <> "" ? $this->m_status->FldTagCaption(1) : $this->m_status->CurrentValue;
						break;
					case $this->m_status->FldTagValue(2):
						$this->m_status->ViewValue = $this->m_status->FldTagCaption(2) <> "" ? $this->m_status->FldTagCaption(2) : $this->m_status->CurrentValue;
						break;
					default:
						$this->m_status->ViewValue = $this->m_status->CurrentValue;
				}
			} else {
				$this->m_status->ViewValue = NULL;
			}
			$this->m_status->ViewCustomAttributes = "";

			// mc_id
			$this->mc_id->LinkCustomAttributes = "";
			$this->mc_id->HrefValue = "";
			$this->mc_id->TooltipValue = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";
			$this->image->TooltipValue = "";

			// model_id
			$this->model_id->LinkCustomAttributes = "";
			$this->model_id->HrefValue = "";
			$this->model_id->TooltipValue = "";

			// color_code
			$this->color_code->LinkCustomAttributes = "";
			$this->color_code->HrefValue = "";
			$this->color_code->TooltipValue = "";

			// m_order
			$this->m_order->LinkCustomAttributes = "";
			$this->m_order->HrefValue = "";
			$this->m_order->TooltipValue = "";

			// m_status
			$this->m_status->LinkCustomAttributes = "";
			$this->m_status->HrefValue = "";
			$this->m_status->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
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
		$conn->BeginTrans();

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
				$sThisKey .= $row['mc_id'];
				$this->image->UploadPath = '../assets/images/model_color/';
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
}
?>
<?php ew_Header(FALSE) ?>
<?php

// Create page object
if (!isset($model_color_delete)) $model_color_delete = new cmodel_color_delete();

// Page init
$model_color_delete->Page_Init();

// Page main
$model_color_delete->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var model_color_delete = new ew_Page("model_color_delete");
model_color_delete.PageID = "delete"; // Page ID
var EW_PAGE_ID = model_color_delete.PageID; // For backward compatibility

// Form object
var fmodel_colordelete = new ew_Form("fmodel_colordelete");

// Form_CustomValidate event
fmodel_colordelete.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fmodel_colordelete.ValidateRequired = true;
<?php } else { ?>
fmodel_colordelete.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fmodel_colordelete.Lists["x_model_id"] = {"LinkField":"x_model_id","Ajax":null,"AutoFill":false,"DisplayFields":["x_model_name","","",""],"ParentFields":[],"FilterFields":[],"Options":[]};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php

// Load records for display
if ($model_color_delete->Recordset = $model_color_delete->LoadRecordset())
	$model_color_deleteTotalRecs = $model_color_delete->Recordset->RecordCount(); // Get record count
if ($model_color_deleteTotalRecs <= 0) { // No record found, exit
	if ($model_color_delete->Recordset)
		$model_color_delete->Recordset->Close();
	$model_color_delete->Page_Terminate("model_colorlist.php"); // Return to list
}
?>
<p><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Delete") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $model_color->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $model_color->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $model_color_delete->ShowPageHeader(); ?>
<?php
$model_color_delete->ShowMessage();
?>
<form name="fmodel_colordelete" id="fmodel_colordelete" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<p>
<input type="hidden" name="t" value="model_color">
<input type="hidden" name="a_delete" id="a_delete" value="D">
<?php foreach ($model_color_delete->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<table class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_model_colordelete" class="ewTable ewTableSeparate">
<?php echo $model_color->TableCustomInnerHtml ?>
	<thead>
	<tr class="ewTableHeader">
		<td><span id="elh_model_color_mc_id" class="model_color_mc_id"><?php echo $model_color->mc_id->FldCaption() ?></span></td>
		<td><span id="elh_model_color_image" class="model_color_image"><?php echo $model_color->image->FldCaption() ?></span></td>
		<td><span id="elh_model_color_model_id" class="model_color_model_id"><?php echo $model_color->model_id->FldCaption() ?></span></td>
		<td><span id="elh_model_color_color_code" class="model_color_color_code"><?php echo $model_color->color_code->FldCaption() ?></span></td>
		<td><span id="elh_model_color_m_order" class="model_color_m_order"><?php echo $model_color->m_order->FldCaption() ?></span></td>
		<td><span id="elh_model_color_m_status" class="model_color_m_status"><?php echo $model_color->m_status->FldCaption() ?></span></td>
	</tr>
	</thead>
	<tbody>
<?php
$model_color_delete->RecCnt = 0;
$i = 0;
while (!$model_color_delete->Recordset->EOF) {
	$model_color_delete->RecCnt++;
	$model_color_delete->RowCnt++;

	// Set row properties
	$model_color->ResetAttrs();
	$model_color->RowType = EW_ROWTYPE_VIEW; // View

	// Get the field contents
	$model_color_delete->LoadRowValues($model_color_delete->Recordset);

	// Render row
	$model_color_delete->RenderRow();
?>
	<tr<?php echo $model_color->RowAttributes() ?>>
		<td<?php echo $model_color->mc_id->CellAttributes() ?>><span id="el<?php echo $model_color_delete->RowCnt ?>_model_color_mc_id" class="model_color_mc_id">
<span<?php echo $model_color->mc_id->ViewAttributes() ?>>
<?php echo $model_color->mc_id->ListViewValue() ?></span>
</span></td>
		<td<?php echo $model_color->image->CellAttributes() ?>><span id="el<?php echo $model_color_delete->RowCnt ?>_model_color_image" class="model_color_image">
<span>
<?php if ($model_color->image->LinkAttributes() <> "") { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_color->image->UploadPath) . $model_color->image->Upload->DbValue ?>" border="0"<?php echo $model_color->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_color->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } else { ?>
<?php if (!empty($model_color->image->Upload->DbValue)) { ?>
<img src="<?php echo ew_UploadPathEx(FALSE, $model_color->image->UploadPath) . $model_color->image->Upload->DbValue ?>" border="0"<?php echo $model_color->image->ViewAttributes() ?>>
<?php } elseif (!in_array($model_color->CurrentAction, array("I", "edit", "gridedit"))) { ?>	
&nbsp;
<?php } ?>
<?php } ?>
</span>
</span></td>
		<td<?php echo $model_color->model_id->CellAttributes() ?>><span id="el<?php echo $model_color_delete->RowCnt ?>_model_color_model_id" class="model_color_model_id">
<span<?php echo $model_color->model_id->ViewAttributes() ?>>
<?php echo $model_color->model_id->ListViewValue() ?></span>
</span></td>
		<td<?php echo $model_color->color_code->CellAttributes() ?>><span id="el<?php echo $model_color_delete->RowCnt ?>_model_color_color_code" class="model_color_color_code">
<span<?php echo $model_color->color_code->ViewAttributes() ?>>
<?php echo $model_color->color_code->ListViewValue() ?></span>
</span></td>
		<td<?php echo $model_color->m_order->CellAttributes() ?>><span id="el<?php echo $model_color_delete->RowCnt ?>_model_color_m_order" class="model_color_m_order">
<span<?php echo $model_color->m_order->ViewAttributes() ?>>
<?php echo $model_color->m_order->ListViewValue() ?></span>
</span></td>
		<td<?php echo $model_color->m_status->CellAttributes() ?>><span id="el<?php echo $model_color_delete->RowCnt ?>_model_color_m_status" class="model_color_m_status">
<span<?php echo $model_color->m_status->ViewAttributes() ?>>
<?php echo $model_color->m_status->ListViewValue() ?></span>
</span></td>
	</tr>
<?php
	$model_color_delete->Recordset->MoveNext();
}
$model_color_delete->Recordset->Close();
?>
</tbody>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="Action" value="<?php echo ew_BtnCaption($Language->Phrase("DeleteBtn")) ?>">
</form>
<script type="text/javascript">
fmodel_colordelete.Init();
</script>
<?php
$model_color_delete->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$model_color_delete->Page_Terminate();
?>
