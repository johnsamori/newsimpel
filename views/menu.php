<?php

namespace PHPMaker2023\new2023;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
$topMenu->addMenuItem(80, "mi_home", $MenuLanguage->MenuPhrase("80", "MenuText"), $MenuRelativePath . "home", -1, substr("mi_home", strpos("mi_home", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}home.php'), false, false, "fa-home", "", true, false);
$topMenu->addMenuItem(81, "mi_news", $MenuLanguage->MenuPhrase("81", "MenuText"), $MenuRelativePath . "news", -1, substr("mi_news", strpos("mi_news", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}news.php'), false, false, "fa-bullhorn", "", true, false);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(80, "mi_home", $MenuLanguage->MenuPhrase("80", "MenuText"), $MenuRelativePath . "home", -1, substr("mi_home", strpos("mi_home", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}home.php'), false, false, "fa-home", "", true, true);
$sideMenu->addMenuItem(81, "mi_news", $MenuLanguage->MenuPhrase("81", "MenuText"), $MenuRelativePath . "news", -1, substr("mi_news", strpos("mi_news", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}news.php'), false, false, "fa-bullhorn", "", true, true);
$sideMenu->addMenuItem(75, "mci_Master", $MenuLanguage->MenuPhrase("75", "MenuText"), "", -1, substr("mci_Master", strpos("mci_Master", "mi_") + 3), true, false, true, "fa-briefcase", "", false, true);
$sideMenu->addMenuItem(39, "mi_dosen", $MenuLanguage->MenuPhrase("39", "MenuText"), $MenuRelativePath . "dosenlist", 75, substr("mi_dosen", strpos("mi_dosen", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}dosen'), false, false, "fa-address-book", "", false, true);
$sideMenu->addMenuItem(40, "mi_jabatan_fungsional", $MenuLanguage->MenuPhrase("40", "MenuText"), $MenuRelativePath . "jabatanfungsionallist", 75, substr("mi_jabatan_fungsional", strpos("mi_jabatan_fungsional", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}jabatan_fungsional'), false, false, "fa-file", "", false, true);
$sideMenu->addMenuItem(41, "mi_jenjang", $MenuLanguage->MenuPhrase("41", "MenuText"), $MenuRelativePath . "jenjanglist", 75, substr("mi_jenjang", strpos("mi_jenjang", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}jenjang'), false, false, "fa-file", "", false, true);
$sideMenu->addMenuItem(44, "mi_kepakaran", $MenuLanguage->MenuPhrase("44", "MenuText"), $MenuRelativePath . "kepakaranlist", 75, substr("mi_kepakaran", strpos("mi_kepakaran", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}kepakaran'), false, false, "fa-file", "", false, true);
$sideMenu->addMenuItem(51, "mi_rumpun_ilmu", $MenuLanguage->MenuPhrase("51", "MenuText"), $MenuRelativePath . "rumpunilmulist", 75, substr("mi_rumpun_ilmu", strpos("mi_rumpun_ilmu", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}rumpun_ilmu'), false, false, "fa-file", "", false, true);
$sideMenu->addMenuItem(52, "mi_warna_kaver", $MenuLanguage->MenuPhrase("52", "MenuText"), $MenuRelativePath . "warnakaverlist", 75, substr("mi_warna_kaver", strpos("mi_warna_kaver", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}warna_kaver'), false, false, "fa-file", "", false, true);
$sideMenu->addMenuItem(76, "mci_Kelompok", $MenuLanguage->MenuPhrase("76", "MenuText"), "", -1, substr("mci_Kelompok", strpos("mci_Kelompok", "mi_") + 3), true, false, true, "fa-users", "", false, true);
$sideMenu->addMenuItem(42, "mi_kelompok_penelitian", $MenuLanguage->MenuPhrase("42", "MenuText"), $MenuRelativePath . "kelompokpenelitianlist", 76, substr("mi_kelompok_penelitian", strpos("mi_kelompok_penelitian", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}kelompok_penelitian'), false, false, "fa-file", "", false, true);
$sideMenu->addMenuItem(43, "mi_kelompok_pengabdian", $MenuLanguage->MenuPhrase("43", "MenuText"), $MenuRelativePath . "kelompokpengabdianlist", 76, substr("mi_kelompok_pengabdian", strpos("mi_kelompok_pengabdian", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}kelompok_pengabdian'), false, false, "fa-file", "", false, true);
$sideMenu->addMenuItem(77, "mci_Proposal", $MenuLanguage->MenuPhrase("77", "MenuText"), "", -1, substr("mci_Proposal", strpos("mci_Proposal", "mi_") + 3), true, false, true, "fa-book", "", false, true);
$sideMenu->addMenuItem(47, "mi_proposal_penelitian", $MenuLanguage->MenuPhrase("47", "MenuText"), $MenuRelativePath . "proposalpenelitianlist", 77, substr("mi_proposal_penelitian", strpos("mi_proposal_penelitian", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}proposal_penelitian'), false, false, "fa-file", "", false, true);
$sideMenu->addMenuItem(49, "mi_proposal_pengabdian", $MenuLanguage->MenuPhrase("49", "MenuText"), $MenuRelativePath . "proposalpengabdianlist", 77, substr("mi_proposal_pengabdian", strpos("mi_proposal_pengabdian", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}proposal_pengabdian'), false, false, "fa-file", "", false, true);
$sideMenu->addMenuItem(78, "mci_Status", $MenuLanguage->MenuPhrase("78", "MenuText"), "", -1, substr("mci_Status", strpos("mci_Status", "mi_") + 3), true, false, true, "fa-paper-plane", "", false, true);
$sideMenu->addMenuItem(48, "mi_proposal_penelitian_status", $MenuLanguage->MenuPhrase("48", "MenuText"), $MenuRelativePath . "proposalpenelitianstatuslist", 78, substr("mi_proposal_penelitian_status", strpos("mi_proposal_penelitian_status", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}proposal_penelitian_status'), false, false, "fa-file", "", false, true);
$sideMenu->addMenuItem(50, "mi_proposal_pengabdian_status", $MenuLanguage->MenuPhrase("50", "MenuText"), $MenuRelativePath . "proposalpengabdianstatuslist", 78, substr("mi_proposal_pengabdian_status", strpos("mi_proposal_pengabdian_status", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}proposal_pengabdian_status'), false, false, "fa-file", "", false, true);
$sideMenu->addMenuItem(131, "mci_Diterima_Didanai", $MenuLanguage->MenuPhrase("131", "MenuText"), "", -1, substr("mci_Diterima_Didanai", strpos("mci_Diterima_Didanai", "mi_") + 3), true, false, true, "fa-credit-card ", "", false, true);
$sideMenu->addMenuItem(85, "mi_vproposal_penelitian_terima", $MenuLanguage->MenuPhrase("85", "MenuText"), $MenuRelativePath . "vproposalpenelitianterimalist", 131, substr("mi_vproposal_penelitian_terima", strpos("mi_vproposal_penelitian_terima", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}vproposal_penelitian_terima'), false, false, "fa-file", "", false, true);
$sideMenu->addMenuItem(86, "mi_vproposal_pengabdian_diterima", $MenuLanguage->MenuPhrase("86", "MenuText"), $MenuRelativePath . "vproposalpengabdianditerimalist", 131, substr("mi_vproposal_pengabdian_diterima", strpos("mi_vproposal_pengabdian_diterima", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}vproposal_pengabdian_diterima'), false, false, "fa-file", "", false, true);
$sideMenu->addMenuItem(79, "mci_Laporan", $MenuLanguage->MenuPhrase("79", "MenuText"), "", -1, substr("mci_Laporan", strpos("mci_Laporan", "mi_") + 3), true, false, true, "fa-flag ", "", false, true);
$sideMenu->addMenuItem(45, "mi_laporan_penelitian", $MenuLanguage->MenuPhrase("45", "MenuText"), $MenuRelativePath . "laporanpenelitianlist", 79, substr("mi_laporan_penelitian", strpos("mi_laporan_penelitian", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}laporan_penelitian'), false, false, "fa-book", "", false, true);
$sideMenu->addMenuItem(46, "mi_laporan_pengabdian", $MenuLanguage->MenuPhrase("46", "MenuText"), $MenuRelativePath . "laporanpengabdianlist", 79, substr("mi_laporan_pengabdian", strpos("mi_laporan_pengabdian", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}laporan_pengabdian'), false, false, "fa-book", "", false, true);
$sideMenu->addMenuItem(6, "mi_myuserprofile", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "myuserprofilelist", -1, substr("mi_myuserprofile", strpos("mi_myuserprofile", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}myuserprofile'), false, false, "fa-user", "", false, true);
$sideMenu->addMenuItem(20, "mci_Administrator", $MenuLanguage->MenuPhrase("20", "MenuText"), "", -1, substr("mci_Administrator", strpos("mci_Administrator", "mi_") + 3), IsLoggedIn(), false, true, "fa-key", "", false, true);
$sideMenu->addMenuItem(16, "mi_userlevels", $MenuLanguage->MenuPhrase("16", "MenuText"), $MenuRelativePath . "userlevelslist", 20, substr("mi_userlevels", strpos("mi_userlevels", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}userlevels'), false, false, "fa-diagnoses", "", false, true);
$sideMenu->addMenuItem(15, "mi_userlevelpermissions", $MenuLanguage->MenuPhrase("15", "MenuText"), $MenuRelativePath . "userlevelpermissionslist", 20, substr("mi_userlevelpermissions", strpos("mi_userlevelpermissions", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}userlevelpermissions'), false, false, "fa-user", "", false, true);
$sideMenu->addMenuItem(17, "mi_users", $MenuLanguage->MenuPhrase("17", "MenuText"), $MenuRelativePath . "userslist", 20, substr("mi_users", strpos("mi_users", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}users'), false, false, "fa-user", "", false, true);
$sideMenu->addMenuItem(5, "mi_languages", $MenuLanguage->MenuPhrase("5", "MenuText"), $MenuRelativePath . "languageslist", 20, substr("mi_languages", strpos("mi_languages", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}languages'), false, false, "fa-flag", "", false, true);
$sideMenu->addMenuItem(1, "mi_announcement", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "announcementlist", 20, substr("mi_announcement", strpos("mi_announcement", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}announcement'), false, false, "fas fa-bullhorn", "", false, true);
$sideMenu->addMenuItem(7, "mi_settings", $MenuLanguage->MenuPhrase("7", "MenuText"), $MenuRelativePath . "settingslist", 20, substr("mi_settings", strpos("mi_settings", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}settings'), false, false, "fa-tools", "", false, true);
$sideMenu->addMenuItem(14, "mi_timezone", $MenuLanguage->MenuPhrase("14", "MenuText"), $MenuRelativePath . "timezonelist", 20, substr("mi_timezone", strpos("mi_timezone", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}timezone'), false, false, "fa-map", "", false, true);
$sideMenu->addMenuItem(2, "mi_breadcrumblinks", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "breadcrumblinkslist", 20, substr("mi_breadcrumblinks", strpos("mi_breadcrumblinks", "mi_") + 3), AllowListMenu('{7C26A499-9388-4839-9706-E82595128FFF}breadcrumblinks'), false, false, "fas fa-angle-double-right", "", false, true);
echo $sideMenu->toScript();
