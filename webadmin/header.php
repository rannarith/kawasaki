<?php

// Compatibility with PHP Report Maker
if (!isset($Language)) {
	include_once "ewcfg9.php";
	include_once "ewshared9.php";
	$Language = new cLanguage();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title><?php echo $Language->ProjectPhrase("BodyTitle") ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo ew_YuiHost() ?>build/menu/assets/skins/sam/menu.css">
<link rel="stylesheet" type="text/css" href="phpcss/ewmenu.css">
<link rel="stylesheet" type="text/css" href="<?php echo ew_YuiHost() ?>build/container/assets/skins/sam/container.css">
<link rel="stylesheet" type="text/css" href="<?php echo ew_YuiHost() ?>build/resize/assets/skins/sam/resize.css">
<link rel="stylesheet" type="text/css" href="<?php echo EW_PROJECT_STYLESHEET_FILENAME ?>">
<script type="text/javascript" src="phpjs/sizzle-min.js"></script>
<script type="text/javascript" src="<?php echo ew_YuiHost() ?>build/utilities/utilities.js"></script>
<script type="text/javascript" src="<?php echo ew_YuiHost() ?>build/json/json-min.js"></script>
<script type="text/javascript" src="<?php echo ew_YuiHost() ?>build/container/container-min.js"></script>
<script type="text/javascript" src="phpjs/datenumber-min.js"></script>
<script type="text/javascript" src="<?php echo ew_YuiHost() ?>build/resize/resize-min.js"></script>
<script type="text/javascript" src="<?php echo ew_YuiHost() ?>build/menu/menu.js"></script>
<link href="calendar/calendar-win2k-cold-1.css" rel="stylesheet" type="text/css" media="all" title="win2k-1">
<style type="text/css">.ewCalendar {cursor: pointer; cursor: hand;}</style>
<script type="text/javascript" src="calendar/calendar.js"></script>
<script type="text/javascript" src="calendar/lang/calendar-en.js"></script>
<script type="text/javascript" src="calendar/calendar-setup.js"></script>
<script type="text/javascript">

// Create calendar
function ew_CreateCalendar(formid, id, format) {
	if (id.indexOf("$rowindex$") > -1)
		return;
	Calendar.setup({
		inputField: ew_GetElement(id, formid), // input field
		showsTime: / %H:%M:%S$/.test(format), // shows time
		ifFormat: format, // date format
		button: ew_ConcatId(formid, id) // button ID
	});
}

// Custom event
var ewSelectDateEvent = new YAHOO.util.CustomEvent("SelectDate");
</script>
<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
<script type="text/javascript">

// update value from editor to textarea
function ew_UpdateTextArea() {
	if (typeof FCKeditorAPI == "undefined")
		return;
	for (var inst in FCKeditorAPI.Instances)
		FCKeditorAPI.Instances[inst].UpdateLinkedField();
}

// update value from textarea to editor
function ew_UpdateEditor(name) {
	if (typeof FCKeditorAPI == "undefined")
		return;
	var inst = FCKeditorAPI.GetInstance(name);		
	if (inst)
		inst.SetHTML(inst.LinkedField.value);
}

// focus editor
function ew_FocusEditor(name) {
	if (typeof FCKeditorAPI == "undefined")
		return;
	var inst = FCKeditorAPI.GetInstance(name);	

	//if (inst && inst.EditorWindow)
		//inst.EditorWindow.focus();

	if (inst)
		inst.Focus();
}

// create editor
function ew_CreateEditor(formid, name, cols, rows, readonly) {
	if (typeof FCKeditor == "undefined" || name.indexOf("$rowindex$") > -1)
		return;
	var form = document.getElementById(formid);	
	var el = ew_GetElement(name, form);
	if (!el)
		return;
	var args = {"id": name, "form": form, "enabled": true};
	ewCreateEditorEvent.fire(args);
	if (!args.enabled)
		return;
	if (cols <= 0)
		cols = 35;
	if (rows <= 0)
		rows = 4;
	var w = cols * 16; // width multiplier
	var h = rows * 60; // height multiplier
	if (readonly) {
		new ew_ReadOnlyTextArea(el, w, h);
	} else {
		name = ew_ConcatId(formid, name);
		ewForms[formid].Editors.push(new ew_Editor(name, function() {
			var sBasePath = 'fckeditor/';
			var oFCKeditor = new FCKeditor(name, w, h);
			oFCKeditor.BasePath = sBasePath;
			oFCKeditor.ReplaceTextarea();
			this.active = true;
		}));
	}
}
</script>
<script type="text/javascript">
var EW_LANGUAGE_ID = "<?php echo $gsLanguage ?>";
var EW_DATE_SEPARATOR = "/" || "/"; // Default date separator
var EW_DECIMAL_POINT = "<?php echo $DEFAULT_DECIMAL_POINT ?>";
var EW_THOUSANDS_SEP = "<?php echo $DEFAULT_THOUSANDS_SEP ?>";
var EW_UPLOAD_ALLOWED_FILE_EXT = "gif,jpg,jpeg,bmp,png,doc,xls,pdf,zip"; // Allowed upload file extension

// Ajax settings
var EW_RECORD_DELIMITER = "\r";
var EW_FIELD_DELIMITER = "|";
var EW_LOOKUP_FILE_NAME = "ewlookup9.php"; // Lookup file name
var EW_AUTO_SUGGEST_MAX_ENTRIES = <?php echo EW_AUTO_SUGGEST_MAX_ENTRIES ?>; // Auto-Suggest max entries

// Common JavaScript messages
var EW_ADDOPT_BUTTON_SUBMIT_TEXT = "<?php echo ew_JsEncode2(ew_BtnCaption($Language->Phrase("AddBtn"))) ?>";
var EW_EMAIL_EXPORT_BUTTON_SUBMIT_TEXT = "<?php echo ew_JsEncode2(ew_BtnCaption($Language->Phrase("SendEmailBtn"))) ?>";
var EW_BUTTON_CANCEL_TEXT = "<?php echo ew_JsEncode2(ew_BtnCaption($Language->Phrase("CancelBtn"))) ?>";
var EW_DISABLE_BUTTON_ON_SUBMIT = true;
var EW_IMAGE_FOLDER = "phpimages/"; // Image folder
</script>
<script type="text/javascript" src="phpjs/jsrender.js"></script>
<script type="text/javascript" src="phpjs/ewp9.js"></script>
<script type="text/javascript" src="phpjs/userfn9.js"></script>
<script type="text/javascript">
<?php echo $Language->ToJSON() ?>
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="generator" content="PHPMaker v9.0.4">
</head>
<body class="yui-skin-sam">
<?php if (@!$gbSkipHeaderFooter) { ?>
<div class="ewLayout">
	<!-- header (begin) --><!-- *** Note: Only licensed users are allowed to change the logo *** -->
  <div class="ewHeaderRow"><img src="phpimages/phpmkrlogo9.png" alt="" border="0"></div>
	<!-- header (end) -->
	<!-- content (begin) -->
  <table cellspacing="0" class="ewContentTable">
		<tr>
			<td class="ewMenuColumn">
			<!-- left column (begin) -->
<?php include_once "ewmenu.php" ?>
			<!-- left column (end) -->
			</td>
	    <td class="ewContentColumn">
			<!-- right column (begin) -->
				<p><span class="ewSiteTitle"><?php echo $Language->ProjectPhrase("BodyTitle") ?></span></p>
<?php } ?>
