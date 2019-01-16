<?php

// Global variable for table object
$accessory = NULL;

//
// Table class for accessory
//
class caccessory extends cTable {
	var $acs_id;
	var $model_id;
	var $title;
	var $price;
	var $_thumbnail;
	var $short_des;
	var $long_des;
	var $type;
	var $status;
	var $is_new;
	var $wish_list;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'accessory';
		$this->TableName = 'accessory';
		$this->TableType = 'TABLE';

		// Update Table
		$this->UpdateTable = "`accessory`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
		$this->ExportWordColumnWidth = NULL; // Cell width (PHPWord only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 5;
		$this->AllowAddDeleteRow = TRUE; // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// acs_id
		$this->acs_id = new cField('accessory', 'accessory', 'x_acs_id', 'acs_id', '`acs_id`', '`acs_id`', 3, -1, FALSE, '`acs_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->acs_id->Sortable = TRUE; // Allow sort
		$this->acs_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['acs_id'] = &$this->acs_id;

		// model_id
		$this->model_id = new cField('accessory', 'accessory', 'x_model_id', 'model_id', '`model_id`', '`model_id`', 3, -1, FALSE, '`model_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->model_id->Sortable = TRUE; // Allow sort
		$this->model_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->model_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->model_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['model_id'] = &$this->model_id;

		// title
		$this->title = new cField('accessory', 'accessory', 'x_title', 'title', '`title`', '`title`', 200, -1, FALSE, '`title`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->title->Sortable = TRUE; // Allow sort
		$this->fields['title'] = &$this->title;

		// price
		$this->price = new cField('accessory', 'accessory', 'x_price', 'price', '`price`', '`price`', 200, -1, FALSE, '`price`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->price->Sortable = TRUE; // Allow sort
		$this->fields['price'] = &$this->price;

		// thumbnail
		$this->_thumbnail = new cField('accessory', 'accessory', 'x__thumbnail', 'thumbnail', '`thumbnail`', '`thumbnail`', 200, -1, TRUE, '`thumbnail`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->_thumbnail->Sortable = TRUE; // Allow sort
		$this->fields['thumbnail'] = &$this->_thumbnail;

		// short_des
		$this->short_des = new cField('accessory', 'accessory', 'x_short_des', 'short_des', '`short_des`', '`short_des`', 201, -1, FALSE, '`short_des`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->short_des->Sortable = TRUE; // Allow sort
		$this->fields['short_des'] = &$this->short_des;

		// long_des
		$this->long_des = new cField('accessory', 'accessory', 'x_long_des', 'long_des', '`long_des`', '`long_des`', 201, -1, FALSE, '`long_des`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->long_des->Sortable = TRUE; // Allow sort
		$this->fields['long_des'] = &$this->long_des;

		// type
		$this->type = new cField('accessory', 'accessory', 'x_type', 'type', '`type`', '`type`', 16, -1, FALSE, '`type`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'CHECKBOX');
		$this->type->Sortable = TRUE; // Allow sort
		$this->type->OptionCount = 3;
		$this->type->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['type'] = &$this->type;

		// status
		$this->status = new cField('accessory', 'accessory', 'x_status', 'status', '`status`', '`status`', 16, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->status->Sortable = TRUE; // Allow sort
		$this->status->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->status->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->status->OptionCount = 2;
		$this->status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status'] = &$this->status;

		// is_new
		$this->is_new = new cField('accessory', 'accessory', 'x_is_new', 'is_new', '`is_new`', '`is_new`', 16, -1, FALSE, '`is_new`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->is_new->Sortable = TRUE; // Allow sort
		$this->is_new->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['is_new'] = &$this->is_new;

		// wish_list
		$this->wish_list = new cField('accessory', 'accessory', 'x_wish_list', 'wish_list', '`wish_list`', '`wish_list`', 16, -1, FALSE, '`wish_list`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->wish_list->Sortable = TRUE; // Allow sort
		$this->wish_list->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['wish_list'] = &$this->wish_list;
	}

	// Field Visibility
	function GetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Column CSS classes
	var $LeftColumnClass = "col-sm-2 control-label ewLabel";
	var $RightColumnClass = "col-sm-10";
	var $OffsetColumnClass = "col-sm-10 col-sm-offset-2";

	// Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
	function SetLeftColumnClass($class) {
		if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
			$this->LeftColumnClass = $class . " control-label ewLabel";
			$this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - intval($match[2]));
			$this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace($match[1], $match[1] + "-offset", $class);
		}
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

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`accessory`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`acs_id` DESC";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
		switch ($id) {
			case "add":
			case "copy":
			case "gridadd":
			case "register":
			case "addopt":
				return (($allow & 1) == 1);
			case "edit":
			case "gridedit":
			case "update":
			case "changepwd":
			case "forgotpwd":
				return (($allow & 4) == 4);
			case "delete":
				return (($allow & 2) == 2);
			case "view":
				return (($allow & 32) == 32);
			case "search":
				return (($allow & 64) == 64);
			default:
				return (($allow & 8) == 8);
		}
	}

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$filter = $this->CurrentFilter;
		$filter = $this->ApplyUserIDFilters($filter);
		$sort = $this->getSessionOrderBy();
		return $this->GetSQL($filter, $sort);
	}

	// Table SQL with List page filter
	var $UseSessionForListSQL = TRUE;

	function ListSQL() {
		$sFilter = $this->UseSessionForListSQL ? $this->getSessionWhere() : "";
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSelect = $this->getSqlSelect();
		$sSort = $this->UseSessionForListSQL ? $this->getSessionOrderBy() : "";
		return ew_BuildSelectSql($sSelect, $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sql) {
		$cnt = -1;
		$pattern = "/^SELECT \* FROM/i";
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match($pattern, $sql)) {
			$sql = "SELECT COUNT(*) FROM" . preg_replace($pattern, "", $sql);
		} else {
			$sql = "SELECT COUNT(*) FROM (" . $sql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($filter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $filter;
		$this->Recordset_Selecting($this->CurrentFilter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sql);
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
	function ListRecordCount() {
		$filter = $this->getSessionWhere();
		ew_AddFilter($filter, $this->CurrentFilter);
		$filter = $this->ApplyUserIDFilters($filter);
		$this->Recordset_Selecting($filter);
		$select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : "SELECT * FROM " . $this->getSqlFrom();
		$groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
		$having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
		$sql = ew_BuildSelectSql($select, $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
		$cnt = $this->TryGetRecordCount($sql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$names = preg_replace('/,+$/', "", $names);
		$values = preg_replace('/,+$/', "", $values);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		$bInsert = $conn->Execute($this->InsertSQL($rs));
		if ($bInsert) {

			// Get insert id if necessary
			$this->acs_id->setDbValue($conn->Insert_ID());
			$rs['acs_id'] = $this->acs_id->DbValue;
		}
		return $bInsert;
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		$sql = preg_replace('/,+$/', "", $sql);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('acs_id', $rs))
				ew_AddFilter($where, ew_QuotedName('acs_id', $this->DBID) . '=' . ew_QuotedValue($rs['acs_id'], $this->acs_id->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$bDelete = TRUE;
		$conn = &$this->Connection();
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`acs_id` = @acs_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->acs_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->acs_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@acs_id@", ew_AdjustSql($this->acs_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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
			return "accessorylist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "accessoryview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "accessoryedit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "accessoryadd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "accessorylist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("accessoryview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("accessoryview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "accessoryadd.php?" . $this->UrlParm($parm);
		else
			$url = "accessoryadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("accessoryedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("accessoryadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("accessorydelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "acs_id:" . ew_VarToJson($this->acs_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->acs_id->CurrentValue)) {
			$sUrl .= "acs_id=" . urlencode($this->acs_id->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
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
			$arKeys = $_POST["key_m"];
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = $_GET["key_m"];
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsPost();
			if ($isPost && isset($_POST["acs_id"]))
				$arKeys[] = $_POST["acs_id"];
			elseif (isset($_GET["acs_id"]))
				$arKeys[] = $_GET["acs_id"];
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->acs_id->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($filter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $filter;
		//$sql = $this->SQL();

		$sql = $this->GetSQL($filter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->acs_id->setDbValue($rs->fields('acs_id'));
		$this->model_id->setDbValue($rs->fields('model_id'));
		$this->title->setDbValue($rs->fields('title'));
		$this->price->setDbValue($rs->fields('price'));
		$this->_thumbnail->Upload->DbValue = $rs->fields('thumbnail');
		$this->short_des->setDbValue($rs->fields('short_des'));
		$this->long_des->setDbValue($rs->fields('long_des'));
		$this->type->setDbValue($rs->fields('type'));
		$this->status->setDbValue($rs->fields('status'));
		$this->is_new->setDbValue($rs->fields('is_new'));
		$this->wish_list->setDbValue($rs->fields('wish_list'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
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

		// short_des
		$this->short_des->ViewValue = $this->short_des->CurrentValue;
		$this->short_des->ViewCustomAttributes = "";

		// long_des
		$this->long_des->ViewValue = $this->long_des->CurrentValue;
		$this->long_des->ViewCustomAttributes = "";

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

		// short_des
		$this->short_des->LinkCustomAttributes = "";
		$this->short_des->HrefValue = "";
		$this->short_des->TooltipValue = "";

		// long_des
		$this->long_des->LinkCustomAttributes = "";
		$this->long_des->HrefValue = "";
		$this->long_des->TooltipValue = "";

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

		// Call Row Rendered event
		$this->Row_Rendered();

		// Save data for Custom Template
		$this->Rows[] = $this->CustomTemplateFieldValues();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// acs_id
		$this->acs_id->EditAttrs["class"] = "form-control";
		$this->acs_id->EditCustomAttributes = "";
		$this->acs_id->EditValue = $this->acs_id->CurrentValue;
		$this->acs_id->ViewCustomAttributes = "";

		// model_id
		$this->model_id->EditAttrs["class"] = "form-control";
		$this->model_id->EditCustomAttributes = "";

		// title
		$this->title->EditAttrs["class"] = "form-control";
		$this->title->EditCustomAttributes = "";
		$this->title->EditValue = $this->title->CurrentValue;
		$this->title->PlaceHolder = ew_RemoveHtml($this->title->FldCaption());

		// price
		$this->price->EditAttrs["class"] = "form-control";
		$this->price->EditCustomAttributes = "";
		$this->price->EditValue = $this->price->CurrentValue;
		$this->price->PlaceHolder = ew_RemoveHtml($this->price->FldCaption());

		// thumbnail
		$this->_thumbnail->EditAttrs["class"] = "form-control";
		$this->_thumbnail->EditCustomAttributes = "";
		$this->_thumbnail->UploadPath = '../assets/images/accessory/';
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

		// short_des
		$this->short_des->EditAttrs["class"] = "form-control";
		$this->short_des->EditCustomAttributes = "";
		$this->short_des->EditValue = $this->short_des->CurrentValue;
		$this->short_des->PlaceHolder = ew_RemoveHtml($this->short_des->FldCaption());

		// long_des
		$this->long_des->EditAttrs["class"] = "form-control";
		$this->long_des->EditCustomAttributes = "";
		$this->long_des->EditValue = $this->long_des->CurrentValue;
		$this->long_des->PlaceHolder = ew_RemoveHtml($this->long_des->FldCaption());

		// type
		$this->type->EditCustomAttributes = "";
		$this->type->EditValue = $this->type->Options(FALSE);

		// status
		$this->status->EditAttrs["class"] = "form-control";
		$this->status->EditCustomAttributes = "";
		$this->status->EditValue = $this->status->Options(TRUE);

		// is_new
		$this->is_new->EditAttrs["class"] = "form-control";
		$this->is_new->EditCustomAttributes = "";
		$this->is_new->EditValue = $this->is_new->CurrentValue;
		$this->is_new->PlaceHolder = ew_RemoveHtml($this->is_new->FldCaption());

		// wish_list
		$this->wish_list->EditAttrs["class"] = "form-control";
		$this->wish_list->EditCustomAttributes = "";
		$this->wish_list->EditValue = $this->wish_list->CurrentValue;
		$this->wish_list->PlaceHolder = ew_RemoveHtml($this->wish_list->FldCaption());

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->acs_id->Exportable) $Doc->ExportCaption($this->acs_id);
					if ($this->model_id->Exportable) $Doc->ExportCaption($this->model_id);
					if ($this->title->Exportable) $Doc->ExportCaption($this->title);
					if ($this->price->Exportable) $Doc->ExportCaption($this->price);
					if ($this->_thumbnail->Exportable) $Doc->ExportCaption($this->_thumbnail);
					if ($this->short_des->Exportable) $Doc->ExportCaption($this->short_des);
					if ($this->long_des->Exportable) $Doc->ExportCaption($this->long_des);
					if ($this->type->Exportable) $Doc->ExportCaption($this->type);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->is_new->Exportable) $Doc->ExportCaption($this->is_new);
					if ($this->wish_list->Exportable) $Doc->ExportCaption($this->wish_list);
				} else {
					if ($this->acs_id->Exportable) $Doc->ExportCaption($this->acs_id);
					if ($this->model_id->Exportable) $Doc->ExportCaption($this->model_id);
					if ($this->title->Exportable) $Doc->ExportCaption($this->title);
					if ($this->price->Exportable) $Doc->ExportCaption($this->price);
					if ($this->_thumbnail->Exportable) $Doc->ExportCaption($this->_thumbnail);
					if ($this->type->Exportable) $Doc->ExportCaption($this->type);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->is_new->Exportable) $Doc->ExportCaption($this->is_new);
					if ($this->wish_list->Exportable) $Doc->ExportCaption($this->wish_list);
				}
				$Doc->EndExportRow();
			}
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
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->acs_id->Exportable) $Doc->ExportField($this->acs_id);
						if ($this->model_id->Exportable) $Doc->ExportField($this->model_id);
						if ($this->title->Exportable) $Doc->ExportField($this->title);
						if ($this->price->Exportable) $Doc->ExportField($this->price);
						if ($this->_thumbnail->Exportable) $Doc->ExportField($this->_thumbnail);
						if ($this->short_des->Exportable) $Doc->ExportField($this->short_des);
						if ($this->long_des->Exportable) $Doc->ExportField($this->long_des);
						if ($this->type->Exportable) $Doc->ExportField($this->type);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->is_new->Exportable) $Doc->ExportField($this->is_new);
						if ($this->wish_list->Exportable) $Doc->ExportField($this->wish_list);
					} else {
						if ($this->acs_id->Exportable) $Doc->ExportField($this->acs_id);
						if ($this->model_id->Exportable) $Doc->ExportField($this->model_id);
						if ($this->title->Exportable) $Doc->ExportField($this->title);
						if ($this->price->Exportable) $Doc->ExportField($this->price);
						if ($this->_thumbnail->Exportable) $Doc->ExportField($this->_thumbnail);
						if ($this->type->Exportable) $Doc->ExportField($this->type);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->is_new->Exportable) $Doc->ExportField($this->is_new);
						if ($this->wish_list->Exportable) $Doc->ExportField($this->wish_list);
					}
					$Doc->EndExportRow($RowCnt);
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
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

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
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

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

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
