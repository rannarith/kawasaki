<?php

// Global variable for table object
$model = NULL;

//
// Table class for model
//
class cmodel extends cTable {
	var $model_id;
	var $model_name;
	var $model_logo;
	var $model_year;
	var $icon_menu;
	var $thumbnail;
	var $full_image;
	var $description;
	var $youtube_url;
	var $category_id;
	var $status;
	var $m_order;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'model';
		$this->TableName = 'model';
		$this->TableType = 'TABLE';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row

		// model_id
		$this->model_id = new cField('model', 'model', 'x_model_id', 'model_id', '`model_id`', '`model_id`', 3, -1, FALSE, '`model_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->model_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['model_id'] = &$this->model_id;

		// model_name
		$this->model_name = new cField('model', 'model', 'x_model_name', 'model_name', '`model_name`', '`model_name`', 200, -1, FALSE, '`model_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['model_name'] = &$this->model_name;

		// model_logo
		$this->model_logo = new cField('model', 'model', 'x_model_logo', 'model_logo', '`model_logo`', '`model_logo`', 200, -1, TRUE, '`model_logo`', FALSE, FALSE, FALSE, 'IMAGE');
		$this->fields['model_logo'] = &$this->model_logo;

		// model_year
		$this->model_year = new cField('model', 'model', 'x_model_year', 'model_year', '`model_year`', '`model_year`', 200, -1, FALSE, '`model_year`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['model_year'] = &$this->model_year;

		// icon_menu
		$this->icon_menu = new cField('model', 'model', 'x_icon_menu', 'icon_menu', '`icon_menu`', '`icon_menu`', 200, -1, TRUE, '`icon_menu`', FALSE, FALSE, FALSE, 'IMAGE');
		$this->fields['icon_menu'] = &$this->icon_menu;

		// thumbnail
		$this->thumbnail = new cField('model', 'model', 'x_thumbnail', 'thumbnail', '`thumbnail`', '`thumbnail`', 200, -1, TRUE, '`thumbnail`', FALSE, FALSE, FALSE, 'IMAGE');
		$this->fields['thumbnail'] = &$this->thumbnail;

		// full_image
		$this->full_image = new cField('model', 'model', 'x_full_image', 'full_image', '`full_image`', '`full_image`', 200, -1, TRUE, '`full_image`', FALSE, FALSE, FALSE, 'IMAGE');
		$this->fields['full_image'] = &$this->full_image;

		// description
		$this->description = new cField('model', 'model', 'x_description', 'description', '`description`', '`description`', 201, -1, FALSE, '`description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['description'] = &$this->description;

		// youtube_url
		$this->youtube_url = new cField('model', 'model', 'x_youtube_url', 'youtube_url', '`youtube_url`', '`youtube_url`', 200, -1, FALSE, '`youtube_url`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->fields['youtube_url'] = &$this->youtube_url;

		// category_id
		$this->category_id = new cField('model', 'model', 'x_category_id', 'category_id', '`category_id`', '`category_id`', 3, -1, FALSE, '`category_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->category_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['category_id'] = &$this->category_id;

		// status
		$this->status = new cField('model', 'model', 'x_status', 'status', '`status`', '`status`', 16, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status'] = &$this->status;

		// m_order
		$this->m_order = new cField('model', 'model', 'x_m_order', 'm_order', '`m_order`', '`m_order`', 16, -1, FALSE, '`m_order`', FALSE, FALSE, FALSE, 'FORMATTED TEXT');
		$this->m_order->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['m_order'] = &$this->m_order;
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Current detail table name
	function getCurrentDetailTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE];
	}

	function setCurrentDetailTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_DETAIL_TABLE] = $v;
	}

	// Get detail url
	function GetDetailUrl() {

		// Detail url
		$sDetailUrl = "";
		if ($this->getCurrentDetailTable() == "specification") {
			$sDetailUrl = $GLOBALS["specification"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&model_id=" . $this->model_id->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "feature") {
			$sDetailUrl = $GLOBALS["feature"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&model_id=" . $this->model_id->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "model_gallery") {
			$sDetailUrl = $GLOBALS["model_gallery"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&model_id=" . $this->model_id->CurrentValue;
		}
		if ($this->getCurrentDetailTable() == "model_color") {
			$sDetailUrl = $GLOBALS["model_color"]->GetListUrl() . "?showmaster=" . $this->TableVar;
			$sDetailUrl .= "&model_id=" . $this->model_id->CurrentValue;
		}
		return $sDetailUrl;
	}

	// Table level SQL
	function SqlFrom() { // From
		return "`model`";
	}

	function SqlSelect() { // Select
		return "SELECT * FROM " . $this->SqlFrom();
	}

	function SqlWhere() { // Where
		$sWhere = "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlGroupBy() { // Group By
		return "";
	}

	function SqlHaving() { // Having
		return "";
	}

	function SqlOrderBy() { // Order By
		return "`model_id` DESC";
	}

	// Check if Anonymous User is allowed
	function AllowAnonymousUser() {
		switch (@$this->PageID) {
			case "add":
			case "register":
			case "addopt":
				return FALSE;
			case "edit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return FALSE;
			case "delete":
				return FALSE;
			case "view":
				return FALSE;
			case "search":
				return FALSE;
			default:
				return FALSE;
		}
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		return TRUE;
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(),
			$this->SqlGroupBy(), $this->SqlHaving(), $this->SqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->SqlSelect(), $this->SqlWhere(), $this->SqlGroupBy(),
			$this->SqlHaving(), $this->SqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->SqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		global $conn;
		$cnt = -1;
		if ($this->TableType == 'TABLE' || $this->TableType == 'VIEW') {
			$sSql = "SELECT COUNT(*) FROM" . substr($sSql, 13);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		global $conn;
		$origFilter = $this->CurrentFilter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Update Table
	var $UpdateTable = "`model`";

	// INSERT statement
	function InsertSQL(&$rs) {
		global $conn;
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		global $conn;
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "") {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]))
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->UpdateSQL($rs, $where));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "") {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if ($rs) {
			$sql .= ew_QuotedName('model_id') . '=' . ew_QuotedValue($rs['model_id'], $this->model_id->FldDataType) . ' AND ';
		}
		if (substr($sql, -5) == " AND ") $sql = substr($sql, 0, -5);
		$filter = $this->CurrentFilter;
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " AND " . $filter;
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "") {
		global $conn;
		return $conn->Execute($this->DeleteSQL($rs, $where));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`model_id` = @model_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->model_id->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@model_id@", ew_AdjustSql($this->model_id->CurrentValue), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "modellist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "modellist.php";
	}

	// View URL
	function GetViewUrl() {
		return $this->KeyUrl("modelview.php", $this->UrlParm());
	}

	// Add URL
	function GetAddUrl() {
		return "modeladd.php";
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("modeledit.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("modeledit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			return $this->KeyUrl("modeladd.php", $this->UrlParm($parm));
		else
			return $this->KeyUrl("modeladd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		return $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("modeldelete.php", $this->UrlParm());
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->model_id->CurrentValue)) {
			$sUrl .= "model_id=" . urlencode($this->model_id->CurrentValue);
		} else {
			return "javascript:alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&ordertype=" . $fld->ReverseSort());
			return ew_CurrentPage() . "?" . $sUrlParm;
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET)) {
			$arKeys[] = @$_GET["model_id"]; // model_id

			//return $arKeys; // do not return yet, so the values will also be checked by the following code
		}

		// check keys
		$ar = array();
		foreach ($arKeys as $key) {
			if (!is_numeric($key))
				continue;
			$ar[] = $key;
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->model_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {
		global $conn;

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
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

	// Render list row values
	function RenderListRow() {
		global $conn, $Security;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
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

		// description
		$this->description->ViewValue = $this->description->CurrentValue;
		$this->description->ViewCustomAttributes = "";

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

		// status
		$this->status->LinkCustomAttributes = "";
		$this->status->HrefValue = "";
		$this->status->TooltipValue = "";

		// m_order
		$this->m_order->LinkCustomAttributes = "";
		$this->m_order->HrefValue = "";
		$this->m_order->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {
	}

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;

		// Write header
		$Doc->ExportTableHeader();
		if ($Doc->Horizontal) { // Horizontal format, write header
			$Doc->BeginExportRow();
			if ($ExportPageType == "view") {
				$Doc->ExportCaption($this->model_id);
				$Doc->ExportCaption($this->model_name);
				$Doc->ExportCaption($this->model_logo);
				$Doc->ExportCaption($this->model_year);
				$Doc->ExportCaption($this->icon_menu);
				$Doc->ExportCaption($this->thumbnail);
				$Doc->ExportCaption($this->full_image);
				$Doc->ExportCaption($this->description);
				$Doc->ExportCaption($this->youtube_url);
				$Doc->ExportCaption($this->category_id);
				$Doc->ExportCaption($this->status);
				$Doc->ExportCaption($this->m_order);
			} else {
				$Doc->ExportCaption($this->model_id);
				$Doc->ExportCaption($this->model_name);
				$Doc->ExportCaption($this->model_logo);
				$Doc->ExportCaption($this->model_year);
				$Doc->ExportCaption($this->icon_menu);
				$Doc->ExportCaption($this->thumbnail);
				$Doc->ExportCaption($this->full_image);
				$Doc->ExportCaption($this->youtube_url);
				$Doc->ExportCaption($this->category_id);
				$Doc->ExportCaption($this->status);
				$Doc->ExportCaption($this->m_order);
			}
			$Doc->EndExportRow();
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
				if ($ExportPageType == "view") {
					$Doc->ExportField($this->model_id);
					$Doc->ExportField($this->model_name);
					$Doc->ExportField($this->model_logo);
					$Doc->ExportField($this->model_year);
					$Doc->ExportField($this->icon_menu);
					$Doc->ExportField($this->thumbnail);
					$Doc->ExportField($this->full_image);
					$Doc->ExportField($this->description);
					$Doc->ExportField($this->youtube_url);
					$Doc->ExportField($this->category_id);
					$Doc->ExportField($this->status);
					$Doc->ExportField($this->m_order);
				} else {
					$Doc->ExportField($this->model_id);
					$Doc->ExportField($this->model_name);
					$Doc->ExportField($this->model_logo);
					$Doc->ExportField($this->model_year);
					$Doc->ExportField($this->icon_menu);
					$Doc->ExportField($this->thumbnail);
					$Doc->ExportField($this->full_image);
					$Doc->ExportField($this->youtube_url);
					$Doc->ExportField($this->category_id);
					$Doc->ExportField($this->status);
					$Doc->ExportField($this->m_order);
				}
				$Doc->EndExportRow();
			}
			$Recordset->MoveNext();
		}
		$Doc->ExportTableFooter();
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
