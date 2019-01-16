<?php

// Menu
$RootMenu = new cMenu("RootMenu", TRUE);
$RootMenu->AddMenuItem(23, "mi_static_page", $Language->MenuPhrase("23", "MenuText"), "static_pagelist.php", -1, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}static_page'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(18, "mi_special_offer", $Language->MenuPhrase("18", "MenuText"), "special_offerlist.php", -1, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}special_offer'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(19, "mi_social_community", $Language->MenuPhrase("19", "MenuText"), "social_communitylist.php", -1, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}social_community'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(9, "mi_home_slide", $Language->MenuPhrase("9", "MenuText"), "home_slidelist.php", -1, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}home_slide'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(14, "mi_news", $Language->MenuPhrase("14", "MenuText"), "newslist.php", -1, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}news'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(15, "mi_news_gallery", $Language->MenuPhrase("15", "MenuText"), "news_gallerylist.php?cmd=resetall", 14, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}news_gallery'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(1, "mi_about_gallery", $Language->MenuPhrase("1", "MenuText"), "about_gallerylist.php", -1, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}about_gallery'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(4, "mi_career", $Language->MenuPhrase("4", "MenuText"), "careerlist.php", -1, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}career'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(2, "mi_accessory", $Language->MenuPhrase("2", "MenuText"), "accessorylist.php", -1, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}accessory'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(21, "mi_dealer", $Language->MenuPhrase("21", "MenuText"), "dealerlist.php", -1, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}dealer'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(10, "mi_model", $Language->MenuPhrase("10", "MenuText"), "modellist.php?cmd=resetall", -1, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}model'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(7, "mi_feature", $Language->MenuPhrase("7", "MenuText"), "featurelist.php?cmd=resetall", 10, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}feature'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(11, "mi_model_category", $Language->MenuPhrase("11", "MenuText"), "model_categorylist.php", 10, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}model_category'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(12, "mi_model_color", $Language->MenuPhrase("12", "MenuText"), "model_colorlist.php?cmd=resetall", 10, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}model_color'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(13, "mi_model_gallery", $Language->MenuPhrase("13", "MenuText"), "model_gallerylist.php?cmd=resetall", 10, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}model_gallery'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(17, "mi_specification", $Language->MenuPhrase("17", "MenuText"), "specificationlist.php?cmd=resetall", 10, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}specification'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(8, "mi_form_request", $Language->MenuPhrase("8", "MenuText"), "form_requestlist.php", -1, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}form_request'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(6, "mi_contact", $Language->MenuPhrase("6", "MenuText"), "contactlist.php", -1, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}contact'), FALSE, FALSE, "");
$RootMenu->AddMenuItem(3, "mi_admin_user", $Language->MenuPhrase("3", "MenuText"), "admin_userlist.php", -1, "", IsLoggedIn() || AllowListMenu('{086EEFE9-31D6-48E2-919A-4B361863B384}admin_user'), FALSE, FALSE, "");
echo $RootMenu->ToScript();
?>
<div class="ewVertical" id="ewMenu"></div>
