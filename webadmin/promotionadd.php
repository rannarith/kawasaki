<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg9.php" ?>
<?php include_once "ewmysql9.php" ?>
<?php include_once "phpfn9.php" ?>
<?php include_once "promotioninfo.php" ?>
<?php include_once "admin_userinfo.php" ?>
<?php include_once "userfn9.php" ?>
<?php

//
// Page class
//

$promotion_add = NULL; // Initialize page object first

class cpromotion_add extends cpromotion {

	// Page ID
	var $PageID = 'add';

	// Project ID
	var $ProjectID = "{5CB4AA5B-9E5D-4D28-80A0-11AF7C90D6A1}";

	// Table name
	var $TableName = 'promotion';

	// Page object name
	var $PageObjName = 'promotion_add';

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

		// Table object (promotion)
		if (!isset($GLOBALS["promotion"])) {
			$GLOBALS["promotion"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["promotion"];
		}

		// Table object (admin_user)
		if (!isset($GLOBALS['admin_user'])) $GLOBALS['admin_user'] = new cadmin_user();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'add', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'promotion', TRUE);

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
	var $DbMasterFilter = "";
	var $DbDetailFilter = "";
	var $Priv = 0;
	var $OldRecordset;
	var $CopyRecord;

	// 
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;

		// Process form if post back
		if (@$_POST["a_add"] <> "") {
			$this->CurrentAction = $_POST["a_add"]; // Get form action
			$this->CopyRecord = $this->LoadOldRecord(); // Load old recordset
			$this->LoadFormValues(); // Load form values
		} else { // Not post back

			// Load key values from QueryString
			$this->CopyRecord = TRUE;
			if (@$_GET["proid"] != "") {
				$this->proid->setQueryStringValue($_GET["proid"]);
				$this->setKey("proid", $this->proid->CurrentValue); // Set up key
			} else {
				$this->setKey("proid", ""); // Clear key
				$this->CopyRecord = FALSE;
			}
			if ($this->CopyRecord) {
				$this->CurrentAction = "C"; // Copy record
			} else {
				$this->CurrentAction = "I"; // Display blank record
				$this->LoadDefaultValues(); // Load default values
			}
		}

		// Validate form if post back
		if (@$_POST["a_add"] <> "") {
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->EventCancelled = TRUE; // Event cancelled
				$this->RestoreFormValues(); // Restore form values
				$this->setFailureMessage($gsFormError);
			}
		}

		// Perform action based on action code
		switch ($this->CurrentAction) {
			case "I": // Blank record, no action required
				break;
			case "C": // Copy an existing record
				if (!$this->LoadRow()) { // Load record based on key
					if ($this->getFailureMessage() == "") $this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
					$this->Page_Terminate("promotionlist.php"); // No matching record, return to list
				}
				break;
			case "A": // Add new record
				$this->SendEmail = TRUE; // Send email on add success
				if ($this->AddRow($this->OldRecordset)) { // Add successful
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up success message
					$sReturnUrl = $this->getReturnUrl();
					if (ew_GetPageName($sReturnUrl) == "promotionview.php")
						$sReturnUrl = $this->GetViewUrl(); // View paging, return to view page with keyurl directly
					$this->Page_Terminate($sReturnUrl); // Clean up and return
				} else {
					$this->EventCancelled = TRUE; // Event cancelled
					$this->RestoreFormValues(); // Add failed, restore form values
				}
		}

		// Render row based on row type
		$this->RowType = EW_ROWTYPE_ADD;  // Render add type

		// Render row
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
	}

	// Load default values
	function LoadDefaultValues() {
		$this->image->CurrentValue = NULL;
		$this->image->OldValue = $this->image->CurrentValue;
		$this->pro_title->CurrentValue = NULL;
		$this->pro_title->OldValue = $this->pro_title->CurrentValue;
		$this->pro_des->CurrentValue = NULL;
		$this->pro_des->OldValue = $this->pro_des->CurrentValue;
		$this->pro_date->CurrentValue = NULL;
		$this->pro_date->OldValue = $this->pro_date->CurrentValue;
		$this->status->CurrentValue = 1;
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->image->FldIsDetailKey) {
			$this->image->setFormValue($objForm->GetValue("x_image"));
		}
		if (!$this->pro_title->FldIsDetailKey) {
			$this->pro_title->setFormValue($objForm->GetValue("x_pro_title"));
		}
		if (!$this->pro_des->FldIsDetailKey) {
			$this->pro_des->setFormValue($objForm->GetValue("x_pro_des"));
		}
		if (!$this->pro_date->FldIsDetailKey) {
			$this->pro_date->setFormValue($objForm->GetValue("x_pro_date"));
		}
		if (!$this->status->FldIsDetailKey) {
			$this->status->setFormValue($objForm->GetValue("x_status"));
		}
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->LoadOldRecord();
		$this->image->CurrentValue = $this->image->FormValue;
		$this->pro_title->CurrentValue = $this->pro_title->FormValue;
		$this->pro_des->CurrentValue = $this->pro_des->FormValue;
		$this->pro_date->CurrentValue = $this->pro_date->FormValue;
		$this->status->CurrentValue = $this->status->FormValue;
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
		$this->proid->setDbValue($rs->fields('proid'));
		$this->image->setDbValue($rs->fields('image'));
		$this->pro_title->setDbValue($rs->fields('pro_title'));
		$this->pro_des->setDbValue($rs->fields('pro_des'));
		$this->pro_date->setDbValue($rs->fields('pro_date'));
		$this->status->setDbValue($rs->fields('status'));
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("proid")) <> "")
			$this->proid->CurrentValue = $this->getKey("proid"); // proid
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
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// proid
		// image
		// pro_title
		// pro_des
		// pro_date
		// status

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

			// proid
			$this->proid->ViewValue = $this->proid->CurrentValue;
			$this->proid->ViewCustomAttributes = "";

			// image
			$this->image->ViewValue = $this->image->CurrentValue;
			$this->image->ViewCustomAttributes = "";

			// pro_title
			$this->pro_title->ViewValue = $this->pro_title->CurrentValue;
			$this->pro_title->ViewCustomAttributes = "";

			// pro_des
			$this->pro_des->ViewValue = $this->pro_des->CurrentValue;
			$this->pro_des->ViewCustomAttributes = "";

			// pro_date
			$this->pro_date->ViewValue = $this->pro_date->CurrentValue;
			$this->pro_date->ViewCustomAttributes = "";

			// status
			$this->status->ViewValue = $this->status->CurrentValue;
			$this->status->ViewCustomAttributes = "";

			// image
			$this->image->LinkCustomAttributes = "";
			$this->image->HrefValue = "";
			$this->image->TooltipValue = "";

			// pro_title
			$this->pro_title->LinkCustomAttributes = "";
			$this->pro_title->HrefValue = "";
			$this->pro_title->TooltipValue = "";

			// pro_des
			$this->pro_des->LinkCustomAttributes = "";
			$this->pro_des->HrefValue = "";
			$this->pro_des->TooltipValue = "";

			// pro_date
			$this->pro_date->LinkCustomAttributes = "";
			$this->pro_date->HrefValue = "";
			$this->pro_date->TooltipValue = "";

			// status
			$this->status->LinkCustomAttributes = "";
			$this->status->HrefValue = "";
			$this->status->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// image
			$this->image->EditCustomAttributes = "";
			$this->image->EditValue = ew_HtmlEncode($this->image->CurrentValue);

			// pro_title
			$this->pro_title->EditCustomAttributes = "";
			$this->pro_title->EditValue = ew_HtmlEncode($this->pro_title->CurrentValue);

			// pro_des
			$this->pro_des->EditCustomAttributes = "";
			$this->pro_des->EditValue = ew_HtmlEncode($this->pro_des->CurrentValue);

			// pro_date
			$this->pro_date->EditCustomAttributes = "";
			$this->pro_date->EditValue = ew_HtmlEncode($this->pro_date->CurrentValue);

			// status
			$this->status->EditCustomAttributes = "";
			$this->status->EditValue = ew_HtmlEncode($this->status->CurrentValue);

			// Edit refer script
			// image

			$this->image->HrefValue = "";

			// pro_title
			$this->pro_title->HrefValue = "";

			// pro_des
			$this->pro_des->HrefValue = "";

			// pro_date
			$this->pro_date->HrefValue = "";

			// status
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
		if (!ew_CheckInteger($this->status->FormValue)) {
			ew_AddMessage($gsFormError, $this->status->FldErrMsg());
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

	// Add record
	function AddRow($rsold = NULL) {
		global $conn, $Language, $Security;
		$rsnew = array();

		// image
		$this->image->SetDbValueDef($rsnew, $this->image->CurrentValue, NULL, FALSE);

		// pro_title
		$this->pro_title->SetDbValueDef($rsnew, $this->pro_title->CurrentValue, NULL, FALSE);

		// pro_des
		$this->pro_des->SetDbValueDef($rsnew, $this->pro_des->CurrentValue, NULL, FALSE);

		// pro_date
		$this->pro_date->SetDbValueDef($rsnew, $this->pro_date->CurrentValue, NULL, FALSE);

		// status
		$this->status->SetDbValueDef($rsnew, $this->status->CurrentValue, NULL, strval($this->status->CurrentValue) == "");

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);
		if ($bInsertRow) {
			$conn->raiseErrorFn = 'ew_ErrorFn';
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
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
			$this->proid->setDbValue($conn->Insert_ID());
			$rsnew['proid'] = $this->proid->DbValue;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
		}
		return $AddRow;
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
if (!isset($promotion_add)) $promotion_add = new cpromotion_add();

// Page init
$promotion_add->Page_Init();

// Page main
$promotion_add->Page_Main();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Page object
var promotion_add = new ew_Page("promotion_add");
promotion_add.PageID = "add"; // Page ID
var EW_PAGE_ID = promotion_add.PageID; // For backward compatibility

// Form object
var fpromotionadd = new ew_Form("fpromotionadd");

// Validate form
fpromotionadd.Validate = function(fobj) {
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
		elm = fobj.elements["x" + infix + "_status"];
		if (elm && !ew_CheckInteger(elm.value))
			return ew_OnError(this, elm, "<?php echo ew_JsEncode2($promotion->status->FldErrMsg()) ?>");

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
fpromotionadd.Form_CustomValidate =  
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpromotionadd.ValidateRequired = true;
<?php } else { ?>
fpromotionadd.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
// Form object for search

</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<p><span class="ewTitle ewTableTitle"><?php echo $Language->Phrase("Add") ?>&nbsp;<?php echo $Language->Phrase("TblTypeTABLE") ?><?php echo $promotion->TableCaption() ?></span></p>
<p class="phpmaker"><a href="<?php echo $promotion->getReturnUrl() ?>"><?php echo $Language->Phrase("GoBack") ?></a></p>
<?php $promotion_add->ShowPageHeader(); ?>
<?php
$promotion_add->ShowMessage();
?>
<form name="fpromotionadd" id="fpromotionadd" class="ewForm" action="<?php echo ew_CurrentPage() ?>" method="post" onsubmit="return ewForms[this.id].Submit();">
<p>
<input type="hidden" name="t" value="promotion">
<input type="hidden" name="a_add" id="a_add" value="A">
<table cellspacing="0" class="ewGrid"><tr><td class="ewGridContent">
<div class="ewGridMiddlePanel">
<table cellspacing="0" id="tbl_promotionadd" class="ewTable">
<?php if ($promotion->image->Visible) { // image ?>
	<tr id="r_image"<?php echo $promotion->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_promotion_image"><?php echo $promotion->image->FldCaption() ?></span></td>
		<td<?php echo $promotion->image->CellAttributes() ?>><span id="el_promotion_image">
<input type="text" name="x_image" id="x_image" size="30" maxlength="150" value="<?php echo $promotion->image->EditValue ?>"<?php echo $promotion->image->EditAttributes() ?>>
</span><?php echo $promotion->image->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($promotion->pro_title->Visible) { // pro_title ?>
	<tr id="r_pro_title"<?php echo $promotion->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_promotion_pro_title"><?php echo $promotion->pro_title->FldCaption() ?></span></td>
		<td<?php echo $promotion->pro_title->CellAttributes() ?>><span id="el_promotion_pro_title">
<input type="text" name="x_pro_title" id="x_pro_title" size="30" maxlength="200" value="<?php echo $promotion->pro_title->EditValue ?>"<?php echo $promotion->pro_title->EditAttributes() ?>>
</span><?php echo $promotion->pro_title->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($promotion->pro_des->Visible) { // pro_des ?>
	<tr id="r_pro_des"<?php echo $promotion->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_promotion_pro_des"><?php echo $promotion->pro_des->FldCaption() ?></span></td>
		<td<?php echo $promotion->pro_des->CellAttributes() ?>><span id="el_promotion_pro_des">
<textarea name="x_pro_des" id="x_pro_des" cols="35" rows="4"<?php echo $promotion->pro_des->EditAttributes() ?>><?php echo $promotion->pro_des->EditValue ?></textarea>
</span><?php echo $promotion->pro_des->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($promotion->pro_date->Visible) { // pro_date ?>
	<tr id="r_pro_date"<?php echo $promotion->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_promotion_pro_date"><?php echo $promotion->pro_date->FldCaption() ?></span></td>
		<td<?php echo $promotion->pro_date->CellAttributes() ?>><span id="el_promotion_pro_date">
<input type="text" name="x_pro_date" id="x_pro_date" size="30" maxlength="30" value="<?php echo $promotion->pro_date->EditValue ?>"<?php echo $promotion->pro_date->EditAttributes() ?>>
</span><?php echo $promotion->pro_date->CustomMsg ?></td>
	</tr>
<?php } ?>
<?php if ($promotion->status->Visible) { // status ?>
	<tr id="r_status"<?php echo $promotion->RowAttributes() ?>>
		<td class="ewTableHeader"><span id="elh_promotion_status"><?php echo $promotion->status->FldCaption() ?></span></td>
		<td<?php echo $promotion->status->CellAttributes() ?>><span id="el_promotion_status">
<input type="text" name="x_status" id="x_status" size="30" value="<?php echo $promotion->status->EditValue ?>"<?php echo $promotion->status->EditAttributes() ?>>
</span><?php echo $promotion->status->CustomMsg ?></td>
	</tr>
<?php } ?>
</table>
</div>
</td></tr></table>
<p>
<input type="submit" name="btnAction" id="btnAction" value="<?php echo ew_BtnCaption($Language->Phrase("AddBtn")) ?>">
</form>
<script type="text/javascript">
fpromotionadd.Init();
</script>
<?php
$promotion_add->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$promotion_add->Page_Terminate();
?>
