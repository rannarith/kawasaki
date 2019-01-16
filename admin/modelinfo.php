<?php

// Global variable for table object
$model = NULL;

//
// Table class for model
//
class cmodel extends cTable {
	var $model_id;
	var $model_name;
	var $price;
	var $displacement;
	var $url_slug;
	var $model_logo;
	var $model_year;
	var $icon_menu;
	var $_thumbnail;
	var $full_image;
	var $description;
	var $youtube_url;
	var $category_id;
	var $m_order;
	var $seo_description;
	var $seo_keyword;
	var $status;
	var $is_feature;
	var $is_available;

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

		// Update Table
		$this->UpdateTable = "`model`";
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

		// model_id
		$this->model_id = new cField('model', 'model', 'x_model_id', 'model_id', '`model_id`', '`model_id`', 3, -1, FALSE, '`model_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'NO');
		$this->model_id->Sortable = TRUE; // Allow sort
		$this->model_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['model_id'] = &$this->model_id;

		// model_name
		$this->model_name = new cField('model', 'model', 'x_model_name', 'model_name', '`model_name`', '`model_name`', 200, -1, FALSE, '`model_name`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->model_name->Sortable = TRUE; // Allow sort
		$this->fields['model_name'] = &$this->model_name;

		// price
		$this->price = new cField('model', 'model', 'x_price', 'price', '`price`', '`price`', 4, -1, FALSE, '`price`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->price->Sortable = TRUE; // Allow sort
		$this->price->FldDefaultErrMsg = $Language->Phrase("IncorrectFloat");
		$this->fields['price'] = &$this->price;

		// displacement
		$this->displacement = new cField('model', 'model', 'x_displacement', 'displacement', '`displacement`', '`displacement`', 200, -1, FALSE, '`displacement`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->displacement->Sortable = TRUE; // Allow sort
		$this->fields['displacement'] = &$this->displacement;

		// url_slug
		$this->url_slug = new cField('model', 'model', 'x_url_slug', 'url_slug', '`url_slug`', '`url_slug`', 200, -1, FALSE, '`url_slug`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->url_slug->Sortable = TRUE; // Allow sort
		$this->fields['url_slug'] = &$this->url_slug;

		// model_logo
		$this->model_logo = new cField('model', 'model', 'x_model_logo', 'model_logo', '`model_logo`', '`model_logo`', 200, -1, TRUE, '`model_logo`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->model_logo->Sortable = TRUE; // Allow sort
		$this->fields['model_logo'] = &$this->model_logo;

		// model_year
		$this->model_year = new cField('model', 'model', 'x_model_year', 'model_year', '`model_year`', '`model_year`', 200, -1, FALSE, '`model_year`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->model_year->Sortable = TRUE; // Allow sort
		$this->fields['model_year'] = &$this->model_year;

		// icon_menu
		$this->icon_menu = new cField('model', 'model', 'x_icon_menu', 'icon_menu', '`icon_menu`', '`icon_menu`', 200, -1, TRUE, '`icon_menu`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->icon_menu->Sortable = TRUE; // Allow sort
		$this->fields['icon_menu'] = &$this->icon_menu;

		// thumbnail
		$this->_thumbnail = new cField('model', 'model', 'x__thumbnail', 'thumbnail', '`thumbnail`', '`thumbnail`', 200, -1, TRUE, '`thumbnail`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->_thumbnail->Sortable = TRUE; // Allow sort
		$this->fields['thumbnail'] = &$this->_thumbnail;

		// full_image
		$this->full_image = new cField('model', 'model', 'x_full_image', 'full_image', '`full_image`', '`full_image`', 200, -1, TRUE, '`full_image`', FALSE, FALSE, FALSE, 'IMAGE', 'FILE');
		$this->full_image->Sortable = TRUE; // Allow sort
		$this->fields['full_image'] = &$this->full_image;

		// description
		$this->description = new cField('model', 'model', 'x_description', 'description', '`description`', '`description`', 201, -1, FALSE, '`description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXTAREA');
		$this->description->Sortable = TRUE; // Allow sort
		$this->fields['description'] = &$this->description;

		// youtube_url
		$this->youtube_url = new cField('model', 'model', 'x_youtube_url', 'youtube_url', '`youtube_url`', '`youtube_url`', 200, -1, FALSE, '`youtube_url`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->youtube_url->Sortable = TRUE; // Allow sort
		$this->fields['youtube_url'] = &$this->youtube_url;

		// category_id
		$this->category_id = new cField('model', 'model', 'x_category_id', 'category_id', '`category_id`', '`category_id`', 3, -1, FALSE, '`category_id`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->category_id->Sortable = TRUE; // Allow sort
		$this->category_id->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->category_id->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->category_id->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['category_id'] = &$this->category_id;

		// m_order
		$this->m_order = new cField('model', 'model', 'x_m_order', 'm_order', '`m_order`', '`m_order`', 16, -1, FALSE, '`m_order`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->m_order->Sortable = TRUE; // Allow sort
		$this->m_order->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['m_order'] = &$this->m_order;

		// seo_description
		$this->seo_description = new cField('model', 'model', 'x_seo_description', 'seo_description', '`seo_description`', '`seo_description`', 200, -1, FALSE, '`seo_description`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->seo_description->Sortable = TRUE; // Allow sort
		$this->fields['seo_description'] = &$this->seo_description;

		// seo_keyword
		$this->seo_keyword = new cField('model', 'model', 'x_seo_keyword', 'seo_keyword', '`seo_keyword`', '`seo_keyword`', 200, -1, FALSE, '`seo_keyword`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->seo_keyword->Sortable = TRUE; // Allow sort
		$this->fields['seo_keyword'] = &$this->seo_keyword;

		// status
		$this->status = new cField('model', 'model', 'x_status', 'status', '`status`', '`status`', 16, -1, FALSE, '`status`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->status->Sortable = TRUE; // Allow sort
		$this->status->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->status->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->status->OptionCount = 2;
		$this->status->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['status'] = &$this->status;

		// is_feature
		$this->is_feature = new cField('model', 'model', 'x_is_feature', 'is_feature', '`is_feature`', '`is_feature`', 16, -1, FALSE, '`is_feature`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->is_feature->Sortable = TRUE; // Allow sort
		$this->is_feature->OptionCount = 2;
		$this->is_feature->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['is_feature'] = &$this->is_feature;

		// is_available
		$this->is_available = new cField('model', 'model', 'x_is_available', 'is_available', '`is_available`', '`is_available`', 16, -1, FALSE, '`is_available`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->is_available->Sortable = TRUE; // Allow sort
		$this->is_available->OptionCount = 2;
		$this->is_available->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['is_available'] = &$this->is_available;
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

	// Current master table name
	function getCurrentMasterTable() {
		return @$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE];
	}

	function setCurrentMasterTable($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_MASTER_TABLE] = $v;
	}

	// Session master WHERE clause
	function GetMasterFilter() {

		// Master filter
		$sMasterFilter = "";
		if ($this->getCurrentMasterTable() == "model_category") {
			if ($this->category_id->getSessionValue() <> "")
				$sMasterFilter .= "`category_id`=" . ew_QuotedValue($this->category_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sMasterFilter;
	}

	// Session detail WHERE clause
	function GetDetailFilter() {

		// Detail filter
		$sDetailFilter = "";
		if ($this->getCurrentMasterTable() == "model_category") {
			if ($this->category_id->getSessionValue() <> "")
				$sDetailFilter .= "`category_id`=" . ew_QuotedValue($this->category_id->getSessionValue(), EW_DATATYPE_NUMBER, "DB");
			else
				return "";
		}
		return $sDetailFilter;
	}

	// Master filter
	function SqlMasterFilter_model_category() {
		return "`category_id`=@category_id@";
	}

	// Detail filter
	function SqlDetailFilter_model_category() {
		return "`category_id`=@category_id@";
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
		if ($this->getCurrentDetailTable() == "model_color") {
			$sDetailUrl = $GLOBALS["model_color"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_model_id=" . urlencode($this->model_id->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "model_gallery") {
			$sDetailUrl = $GLOBALS["model_gallery"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_model_id=" . urlencode($this->model_id->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "feature") {
			$sDetailUrl = $GLOBALS["feature"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_model_id=" . urlencode($this->model_id->CurrentValue);
		}
		if ($this->getCurrentDetailTable() == "specification") {
			$sDetailUrl = $GLOBALS["specification"]->GetListUrl() . "?" . EW_TABLE_SHOW_MASTER . "=" . $this->TableVar;
			$sDetailUrl .= "&fk_model_id=" . urlencode($this->model_id->CurrentValue);
		}
		if ($sDetailUrl == "") {
			$sDetailUrl = "modellist.php";
		}
		return $sDetailUrl;
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`model`";
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
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`category_id` ASC,`model_id` DESC";
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
			$this->model_id->setDbValue($conn->Insert_ID());
			$rs['model_id'] = $this->model_id->DbValue;
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

		// Cascade Update detail table 'model_color'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['model_id']) && $rsold['model_id'] <> $rs['model_id'])) { // Update detail field 'model_id'
			$bCascadeUpdate = TRUE;
			$rscascade['model_id'] = $rs['model_id']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["model_color"])) $GLOBALS["model_color"] = new cmodel_color();
			$rswrk = $GLOBALS["model_color"]->LoadRs("`model_id` = " . ew_QuotedValue($rsold['model_id'], EW_DATATYPE_NUMBER, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$rskey = array();
				$fldname = 'mc_id';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$rsdtlold = &$rswrk->fields;
				$rsdtlnew = array_merge($rsdtlold, $rscascade);

				// Call Row_Updating event
				$bUpdate = $GLOBALS["model_color"]->Row_Updating($rsdtlold, $rsdtlnew);
				if ($bUpdate)
					$bUpdate = $GLOBALS["model_color"]->Update($rscascade, $rskey, $rswrk->fields);
				if (!$bUpdate) return FALSE;

				// Call Row_Updated event
				$GLOBALS["model_color"]->Row_Updated($rsdtlold, $rsdtlnew);
				$rswrk->MoveNext();
			}
		}

		// Cascade Update detail table 'model_gallery'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['model_id']) && $rsold['model_id'] <> $rs['model_id'])) { // Update detail field 'model_id'
			$bCascadeUpdate = TRUE;
			$rscascade['model_id'] = $rs['model_id']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["model_gallery"])) $GLOBALS["model_gallery"] = new cmodel_gallery();
			$rswrk = $GLOBALS["model_gallery"]->LoadRs("`model_id` = " . ew_QuotedValue($rsold['model_id'], EW_DATATYPE_NUMBER, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$rskey = array();
				$fldname = 'gallery_id';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$rsdtlold = &$rswrk->fields;
				$rsdtlnew = array_merge($rsdtlold, $rscascade);

				// Call Row_Updating event
				$bUpdate = $GLOBALS["model_gallery"]->Row_Updating($rsdtlold, $rsdtlnew);
				if ($bUpdate)
					$bUpdate = $GLOBALS["model_gallery"]->Update($rscascade, $rskey, $rswrk->fields);
				if (!$bUpdate) return FALSE;

				// Call Row_Updated event
				$GLOBALS["model_gallery"]->Row_Updated($rsdtlold, $rsdtlnew);
				$rswrk->MoveNext();
			}
		}

		// Cascade Update detail table 'feature'
		$bCascadeUpdate = FALSE;
		$rscascade = array();
		if (!is_null($rsold) && (isset($rs['model_id']) && $rsold['model_id'] <> $rs['model_id'])) { // Update detail field 'model_id'
			$bCascadeUpdate = TRUE;
			$rscascade['model_id'] = $rs['model_id']; 
		}
		if ($bCascadeUpdate) {
			if (!isset($GLOBALS["feature"])) $GLOBALS["feature"] = new cfeature();
			$rswrk = $GLOBALS["feature"]->LoadRs("`model_id` = " . ew_QuotedValue($rsold['model_id'], EW_DATATYPE_NUMBER, 'DB')); 
			while ($rswrk && !$rswrk->EOF) {
				$rskey = array();
				$fldname = 'feature_id';
				$rskey[$fldname] = $rswrk->fields[$fldname];
				$rsdtlold = &$rswrk->fields;
				$rsdtlnew = array_merge($rsdtlold, $rscascade);

				// Call Row_Updating event
				$bUpdate = $GLOBALS["feature"]->Row_Updating($rsdtlold, $rsdtlnew);
				if ($bUpdate)
					$bUpdate = $GLOBALS["feature"]->Update($rscascade, $rskey, $rswrk->fields);
				if (!$bUpdate) return FALSE;

				// Call Row_Updated event
				$GLOBALS["feature"]->Row_Updated($rsdtlold, $rsdtlnew);
				$rswrk->MoveNext();
			}
		}
		$bUpdate = $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
		return $bUpdate;
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('model_id', $rs))
				ew_AddFilter($where, ew_QuotedName('model_id', $this->DBID) . '=' . ew_QuotedValue($rs['model_id'], $this->model_id->FldDataType, $this->DBID));
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

		// Cascade delete detail table 'model_color'
		if (!isset($GLOBALS["model_color"])) $GLOBALS["model_color"] = new cmodel_color();
		$rscascade = $GLOBALS["model_color"]->LoadRs("`model_id` = " . ew_QuotedValue($rs['model_id'], EW_DATATYPE_NUMBER, "DB")); 
		$dtlrows = ($rscascade) ? $rscascade->GetRows() : array();

		// Call Row Deleting event
		foreach ($dtlrows as $dtlrow) {
			$bDelete = $GLOBALS["model_color"]->Row_Deleting($dtlrow);
			if (!$bDelete) break;
		}
		if ($bDelete) {
			foreach ($dtlrows as $dtlrow) {
				$bDelete = $GLOBALS["model_color"]->Delete($dtlrow); // Delete
				if ($bDelete === FALSE)
					break;
			}
		}

		// Call Row Deleted event
		if ($bDelete) {
			foreach ($dtlrows as $dtlrow) {
				$GLOBALS["model_color"]->Row_Deleted($dtlrow);
			}
		}

		// Cascade delete detail table 'model_gallery'
		if (!isset($GLOBALS["model_gallery"])) $GLOBALS["model_gallery"] = new cmodel_gallery();
		$rscascade = $GLOBALS["model_gallery"]->LoadRs("`model_id` = " . ew_QuotedValue($rs['model_id'], EW_DATATYPE_NUMBER, "DB")); 
		$dtlrows = ($rscascade) ? $rscascade->GetRows() : array();

		// Call Row Deleting event
		foreach ($dtlrows as $dtlrow) {
			$bDelete = $GLOBALS["model_gallery"]->Row_Deleting($dtlrow);
			if (!$bDelete) break;
		}
		if ($bDelete) {
			foreach ($dtlrows as $dtlrow) {
				$bDelete = $GLOBALS["model_gallery"]->Delete($dtlrow); // Delete
				if ($bDelete === FALSE)
					break;
			}
		}

		// Call Row Deleted event
		if ($bDelete) {
			foreach ($dtlrows as $dtlrow) {
				$GLOBALS["model_gallery"]->Row_Deleted($dtlrow);
			}
		}

		// Cascade delete detail table 'feature'
		if (!isset($GLOBALS["feature"])) $GLOBALS["feature"] = new cfeature();
		$rscascade = $GLOBALS["feature"]->LoadRs("`model_id` = " . ew_QuotedValue($rs['model_id'], EW_DATATYPE_NUMBER, "DB")); 
		$dtlrows = ($rscascade) ? $rscascade->GetRows() : array();

		// Call Row Deleting event
		foreach ($dtlrows as $dtlrow) {
			$bDelete = $GLOBALS["feature"]->Row_Deleting($dtlrow);
			if (!$bDelete) break;
		}
		if ($bDelete) {
			foreach ($dtlrows as $dtlrow) {
				$bDelete = $GLOBALS["feature"]->Delete($dtlrow); // Delete
				if ($bDelete === FALSE)
					break;
			}
		}

		// Call Row Deleted event
		if ($bDelete) {
			foreach ($dtlrows as $dtlrow) {
				$GLOBALS["feature"]->Row_Deleted($dtlrow);
			}
		}
		if ($bDelete)
			$bDelete = $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
		return $bDelete;
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`model_id` = @model_id@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->model_id->CurrentValue))
			return "0=1"; // Invalid key
		if (is_null($this->model_id->CurrentValue))
			return "0=1"; // Invalid key
		else
			$sKeyFilter = str_replace("@model_id@", ew_AdjustSql($this->model_id->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
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

	// Get modal caption
	function GetModalCaption($pageName) {
		global $Language;
		if ($pageName == "modelview.php")
			return $Language->Phrase("View");
		elseif ($pageName == "modeledit.php")
			return $Language->Phrase("Edit");
		elseif ($pageName == "modeladd.php")
			return $Language->Phrase("Add");
		else
			return "";
	}

	// List URL
	function GetListUrl() {
		return "modellist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("modelview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("modelview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "modeladd.php?" . $this->UrlParm($parm);
		else
			$url = "modeladd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("modeledit.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("modeledit.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("modeladd.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("modeladd.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("modeldelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		if ($this->getCurrentMasterTable() == "model_category" && strpos($url, EW_TABLE_SHOW_MASTER . "=") === FALSE) {
			$url .= (strpos($url, "?") !== FALSE ? "&" : "?") . EW_TABLE_SHOW_MASTER . "=" . $this->getCurrentMasterTable();
			$url .= "&fk_category_id=" . urlencode($this->category_id->CurrentValue);
		}
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "model_id:" . ew_VarToJson($this->model_id->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->model_id->CurrentValue)) {
			$sUrl .= "model_id=" . urlencode($this->model_id->CurrentValue);
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
			if ($isPost && isset($_POST["model_id"]))
				$arKeys[] = $_POST["model_id"];
			elseif (isset($_GET["model_id"]))
				$arKeys[] = $_GET["model_id"];
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
			$this->model_id->CurrentValue = $key;
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
		$this->model_id->setDbValue($rs->fields('model_id'));
		$this->model_name->setDbValue($rs->fields('model_name'));
		$this->price->setDbValue($rs->fields('price'));
		$this->displacement->setDbValue($rs->fields('displacement'));
		$this->url_slug->setDbValue($rs->fields('url_slug'));
		$this->model_logo->Upload->DbValue = $rs->fields('model_logo');
		$this->model_year->setDbValue($rs->fields('model_year'));
		$this->icon_menu->Upload->DbValue = $rs->fields('icon_menu');
		$this->_thumbnail->Upload->DbValue = $rs->fields('thumbnail');
		$this->full_image->Upload->DbValue = $rs->fields('full_image');
		$this->description->setDbValue($rs->fields('description'));
		$this->youtube_url->setDbValue($rs->fields('youtube_url'));
		$this->category_id->setDbValue($rs->fields('category_id'));
		$this->m_order->setDbValue($rs->fields('m_order'));
		$this->seo_description->setDbValue($rs->fields('seo_description'));
		$this->seo_keyword->setDbValue($rs->fields('seo_keyword'));
		$this->status->setDbValue($rs->fields('status'));
		$this->is_feature->setDbValue($rs->fields('is_feature'));
		$this->is_available->setDbValue($rs->fields('is_available'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

	// Common render codes
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

		// model_id
		$this->model_id->EditAttrs["class"] = "form-control";
		$this->model_id->EditCustomAttributes = "";
		$this->model_id->EditValue = $this->model_id->CurrentValue;
		$this->model_id->ViewCustomAttributes = "";

		// model_name
		$this->model_name->EditAttrs["class"] = "form-control";
		$this->model_name->EditCustomAttributes = "";
		$this->model_name->EditValue = $this->model_name->CurrentValue;
		$this->model_name->PlaceHolder = ew_RemoveHtml($this->model_name->FldCaption());

		// price
		$this->price->EditAttrs["class"] = "form-control";
		$this->price->EditCustomAttributes = "";
		$this->price->EditValue = $this->price->CurrentValue;
		$this->price->PlaceHolder = ew_RemoveHtml($this->price->FldCaption());
		if (strval($this->price->EditValue) <> "" && is_numeric($this->price->EditValue)) $this->price->EditValue = ew_FormatNumber($this->price->EditValue, -2, -1, -2, 0);

		// displacement
		$this->displacement->EditAttrs["class"] = "form-control";
		$this->displacement->EditCustomAttributes = "";
		$this->displacement->EditValue = $this->displacement->CurrentValue;
		$this->displacement->PlaceHolder = ew_RemoveHtml($this->displacement->FldCaption());

		// url_slug
		$this->url_slug->EditAttrs["class"] = "form-control";
		$this->url_slug->EditCustomAttributes = "";
		$this->url_slug->EditValue = $this->url_slug->CurrentValue;
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

		// model_year
		$this->model_year->EditAttrs["class"] = "form-control";
		$this->model_year->EditCustomAttributes = "";
		$this->model_year->EditValue = $this->model_year->CurrentValue;
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

		// description
		$this->description->EditAttrs["class"] = "form-control";
		$this->description->EditCustomAttributes = "";
		$this->description->EditValue = $this->description->CurrentValue;
		$this->description->PlaceHolder = ew_RemoveHtml($this->description->FldCaption());

		// youtube_url
		$this->youtube_url->EditAttrs["class"] = "form-control";
		$this->youtube_url->EditCustomAttributes = "";
		$this->youtube_url->EditValue = $this->youtube_url->CurrentValue;
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
		}

		// m_order
		$this->m_order->EditAttrs["class"] = "form-control";
		$this->m_order->EditCustomAttributes = "";
		$this->m_order->EditValue = $this->m_order->CurrentValue;
		$this->m_order->PlaceHolder = ew_RemoveHtml($this->m_order->FldCaption());

		// seo_description
		$this->seo_description->EditAttrs["class"] = "form-control";
		$this->seo_description->EditCustomAttributes = "";
		$this->seo_description->EditValue = $this->seo_description->CurrentValue;
		$this->seo_description->PlaceHolder = ew_RemoveHtml($this->seo_description->FldCaption());

		// seo_keyword
		$this->seo_keyword->EditAttrs["class"] = "form-control";
		$this->seo_keyword->EditCustomAttributes = "";
		$this->seo_keyword->EditValue = $this->seo_keyword->CurrentValue;
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
					if ($this->model_id->Exportable) $Doc->ExportCaption($this->model_id);
					if ($this->model_name->Exportable) $Doc->ExportCaption($this->model_name);
					if ($this->price->Exportable) $Doc->ExportCaption($this->price);
					if ($this->displacement->Exportable) $Doc->ExportCaption($this->displacement);
					if ($this->url_slug->Exportable) $Doc->ExportCaption($this->url_slug);
					if ($this->model_logo->Exportable) $Doc->ExportCaption($this->model_logo);
					if ($this->model_year->Exportable) $Doc->ExportCaption($this->model_year);
					if ($this->icon_menu->Exportable) $Doc->ExportCaption($this->icon_menu);
					if ($this->_thumbnail->Exportable) $Doc->ExportCaption($this->_thumbnail);
					if ($this->full_image->Exportable) $Doc->ExportCaption($this->full_image);
					if ($this->description->Exportable) $Doc->ExportCaption($this->description);
					if ($this->youtube_url->Exportable) $Doc->ExportCaption($this->youtube_url);
					if ($this->category_id->Exportable) $Doc->ExportCaption($this->category_id);
					if ($this->m_order->Exportable) $Doc->ExportCaption($this->m_order);
					if ($this->seo_description->Exportable) $Doc->ExportCaption($this->seo_description);
					if ($this->seo_keyword->Exportable) $Doc->ExportCaption($this->seo_keyword);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->is_feature->Exportable) $Doc->ExportCaption($this->is_feature);
					if ($this->is_available->Exportable) $Doc->ExportCaption($this->is_available);
				} else {
					if ($this->model_id->Exportable) $Doc->ExportCaption($this->model_id);
					if ($this->model_name->Exportable) $Doc->ExportCaption($this->model_name);
					if ($this->price->Exportable) $Doc->ExportCaption($this->price);
					if ($this->displacement->Exportable) $Doc->ExportCaption($this->displacement);
					if ($this->url_slug->Exportable) $Doc->ExportCaption($this->url_slug);
					if ($this->model_logo->Exportable) $Doc->ExportCaption($this->model_logo);
					if ($this->model_year->Exportable) $Doc->ExportCaption($this->model_year);
					if ($this->icon_menu->Exportable) $Doc->ExportCaption($this->icon_menu);
					if ($this->_thumbnail->Exportable) $Doc->ExportCaption($this->_thumbnail);
					if ($this->full_image->Exportable) $Doc->ExportCaption($this->full_image);
					if ($this->youtube_url->Exportable) $Doc->ExportCaption($this->youtube_url);
					if ($this->category_id->Exportable) $Doc->ExportCaption($this->category_id);
					if ($this->m_order->Exportable) $Doc->ExportCaption($this->m_order);
					if ($this->seo_description->Exportable) $Doc->ExportCaption($this->seo_description);
					if ($this->seo_keyword->Exportable) $Doc->ExportCaption($this->seo_keyword);
					if ($this->status->Exportable) $Doc->ExportCaption($this->status);
					if ($this->is_feature->Exportable) $Doc->ExportCaption($this->is_feature);
					if ($this->is_available->Exportable) $Doc->ExportCaption($this->is_available);
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
						if ($this->model_id->Exportable) $Doc->ExportField($this->model_id);
						if ($this->model_name->Exportable) $Doc->ExportField($this->model_name);
						if ($this->price->Exportable) $Doc->ExportField($this->price);
						if ($this->displacement->Exportable) $Doc->ExportField($this->displacement);
						if ($this->url_slug->Exportable) $Doc->ExportField($this->url_slug);
						if ($this->model_logo->Exportable) $Doc->ExportField($this->model_logo);
						if ($this->model_year->Exportable) $Doc->ExportField($this->model_year);
						if ($this->icon_menu->Exportable) $Doc->ExportField($this->icon_menu);
						if ($this->_thumbnail->Exportable) $Doc->ExportField($this->_thumbnail);
						if ($this->full_image->Exportable) $Doc->ExportField($this->full_image);
						if ($this->description->Exportable) $Doc->ExportField($this->description);
						if ($this->youtube_url->Exportable) $Doc->ExportField($this->youtube_url);
						if ($this->category_id->Exportable) $Doc->ExportField($this->category_id);
						if ($this->m_order->Exportable) $Doc->ExportField($this->m_order);
						if ($this->seo_description->Exportable) $Doc->ExportField($this->seo_description);
						if ($this->seo_keyword->Exportable) $Doc->ExportField($this->seo_keyword);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->is_feature->Exportable) $Doc->ExportField($this->is_feature);
						if ($this->is_available->Exportable) $Doc->ExportField($this->is_available);
					} else {
						if ($this->model_id->Exportable) $Doc->ExportField($this->model_id);
						if ($this->model_name->Exportable) $Doc->ExportField($this->model_name);
						if ($this->price->Exportable) $Doc->ExportField($this->price);
						if ($this->displacement->Exportable) $Doc->ExportField($this->displacement);
						if ($this->url_slug->Exportable) $Doc->ExportField($this->url_slug);
						if ($this->model_logo->Exportable) $Doc->ExportField($this->model_logo);
						if ($this->model_year->Exportable) $Doc->ExportField($this->model_year);
						if ($this->icon_menu->Exportable) $Doc->ExportField($this->icon_menu);
						if ($this->_thumbnail->Exportable) $Doc->ExportField($this->_thumbnail);
						if ($this->full_image->Exportable) $Doc->ExportField($this->full_image);
						if ($this->youtube_url->Exportable) $Doc->ExportField($this->youtube_url);
						if ($this->category_id->Exportable) $Doc->ExportField($this->category_id);
						if ($this->m_order->Exportable) $Doc->ExportField($this->m_order);
						if ($this->seo_description->Exportable) $Doc->ExportField($this->seo_description);
						if ($this->seo_keyword->Exportable) $Doc->ExportField($this->seo_keyword);
						if ($this->status->Exportable) $Doc->ExportField($this->status);
						if ($this->is_feature->Exportable) $Doc->ExportField($this->is_feature);
						if ($this->is_available->Exportable) $Doc->ExportField($this->is_available);
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
