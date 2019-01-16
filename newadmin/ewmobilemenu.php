<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, "mmi_accessory", $Language->MenuPhrase("1", "MenuText"), "accessorylist.php", -1, "", IsLoggedIn() || AllowListMenu('{BE8C113E-D6C5-4712-BA29-D5C99D7D07A2}accessory'), FALSE, FALSE);
$RootMenu->AddMenuItem(2, "mmi_admin_user", $Language->MenuPhrase("2", "MenuText"), "admin_userlist.php", -1, "", IsLoggedIn() || AllowListMenu('{BE8C113E-D6C5-4712-BA29-D5C99D7D07A2}admin_user'), FALSE, FALSE);
$RootMenu->AddMenuItem(3, "mmi_contact", $Language->MenuPhrase("3", "MenuText"), "contactlist.php", -1, "", IsLoggedIn() || AllowListMenu('{BE8C113E-D6C5-4712-BA29-D5C99D7D07A2}contact'), FALSE, FALSE);
$RootMenu->AddMenuItem(4, "mmi_feature", $Language->MenuPhrase("4", "MenuText"), "featurelist.php", -1, "", IsLoggedIn() || AllowListMenu('{BE8C113E-D6C5-4712-BA29-D5C99D7D07A2}feature'), FALSE, FALSE);
$RootMenu->AddMenuItem(5, "mmi_model", $Language->MenuPhrase("5", "MenuText"), "modellist.php", -1, "", IsLoggedIn() || AllowListMenu('{BE8C113E-D6C5-4712-BA29-D5C99D7D07A2}model'), FALSE, FALSE);
$RootMenu->AddMenuItem(6, "mmi_model_category", $Language->MenuPhrase("6", "MenuText"), "model_categorylist.php", -1, "", IsLoggedIn() || AllowListMenu('{BE8C113E-D6C5-4712-BA29-D5C99D7D07A2}model_category'), FALSE, FALSE);
$RootMenu->AddMenuItem(7, "mmi_model_gallery", $Language->MenuPhrase("7", "MenuText"), "model_gallerylist.php", -1, "", IsLoggedIn() || AllowListMenu('{BE8C113E-D6C5-4712-BA29-D5C99D7D07A2}model_gallery'), FALSE, FALSE);
$RootMenu->AddMenuItem(8, "mmi_news", $Language->MenuPhrase("8", "MenuText"), "newslist.php", -1, "", IsLoggedIn() || AllowListMenu('{BE8C113E-D6C5-4712-BA29-D5C99D7D07A2}news'), FALSE, FALSE);
$RootMenu->AddMenuItem(9, "mmi_promotion", $Language->MenuPhrase("9", "MenuText"), "promotionlist.php", -1, "", IsLoggedIn() || AllowListMenu('{BE8C113E-D6C5-4712-BA29-D5C99D7D07A2}promotion'), FALSE, FALSE);
$RootMenu->AddMenuItem(-1, "mmi_logout", $Language->Phrase("Logout"), "logout.php", -1, "", IsLoggedIn());
$RootMenu->AddMenuItem(-1, "mmi_login", $Language->Phrase("Login"), "login.php", -1, "", !IsLoggedIn() && substr(@$_SERVER["URL"], -1 * strlen("login.php")) <> "login.php");
$RootMenu->Render();
?>
<!-- End Main Menu -->
