<?php
/**
 * PHPMaker 2023 user level settings
 */
namespace PHPMaker2023\new2023;

// User level info
$USER_LEVELS = [["-2","Anonymous"],
    ["0","Default"],
    ["1","Ketua"],
    ["2","Staf"]];

// User level priv info
$USER_LEVEL_PRIVS_1 = [["{7C26A499-9388-4839-9706-E82595128FFF}announcement","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}announcement","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}announcement","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}announcement","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}breadcrumblinks","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}breadcrumblinks","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}breadcrumblinks","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}breadcrumblinks","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}help","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}help","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}help","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}help","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}help_categories","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}help_categories","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}help_categories","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}help_categories","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}languages","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}languages","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}languages","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}languages","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}myuserprofile","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}myuserprofile","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}myuserprofile","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}myuserprofile","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}settings","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}settings","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}settings","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}settings","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_counter","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_counter","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_counter","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_counter","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_counterlog","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_counterlog","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_counterlog","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_counterlog","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_date","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_date","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_date","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_date","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_hour","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_hour","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_hour","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_hour","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_month","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_month","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_month","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_month","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_year","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_year","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_year","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}stats_year","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}timezone","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}timezone","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}timezone","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}timezone","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}userlevelpermissions","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}userlevelpermissions","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}userlevelpermissions","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}userlevelpermissions","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}userlevels","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}userlevels","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}userlevels","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}userlevels","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}users","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}users","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}users","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}users","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}dosen","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}dosen","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}dosen","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}dosen","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}jabatan_fungsional","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}jabatan_fungsional","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}jabatan_fungsional","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}jabatan_fungsional","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}jenjang","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}jenjang","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}jenjang","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}jenjang","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}kelompok_penelitian","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}kelompok_penelitian","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}kelompok_penelitian","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}kelompok_penelitian","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}kelompok_pengabdian","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}kelompok_pengabdian","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}kelompok_pengabdian","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}kelompok_pengabdian","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}kepakaran","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}kepakaran","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}kepakaran","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}kepakaran","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}laporan_penelitian","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}laporan_penelitian","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}laporan_penelitian","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}laporan_penelitian","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}laporan_pengabdian","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}laporan_pengabdian","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}laporan_pengabdian","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}laporan_pengabdian","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_penelitian","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_penelitian","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_penelitian","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_penelitian","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_penelitian_status","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_penelitian_status","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_penelitian_status","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_penelitian_status","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_pengabdian","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_pengabdian","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_pengabdian","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_pengabdian","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_pengabdian_status","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_pengabdian_status","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_pengabdian_status","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}proposal_pengabdian_status","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}rumpun_ilmu","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}rumpun_ilmu","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}rumpun_ilmu","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}rumpun_ilmu","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}warna_kaver","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}warna_kaver","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}warna_kaver","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}warna_kaver","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}home.php","-2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}home.php","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}home.php","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}home.php","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}news.php","-2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}news.php","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}news.php","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}news.php","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}validasi","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}validasi","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}validasi","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}validasi","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_penelitian","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_penelitian","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_penelitian","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_penelitian","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_pengabdian","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_pengabdian","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_pengabdian","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_pengabdian","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_penelitian_terima","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_penelitian_terima","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_penelitian_terima","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_penelitian_terima","2","360"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_pengabdian_diterima","-2","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_pengabdian_diterima","0","0"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_pengabdian_diterima","1","365"],
    ["{7C26A499-9388-4839-9706-E82595128FFF}vproposal_pengabdian_diterima","2","360"]];
$USER_LEVEL_PRIVS_2 = [["{7C26A499-9388-4839-9706-E82595128FFF}breadcrumblinksaddsp","-1","8"],
					["{7C26A499-9388-4839-9706-E82595128FFF}breadcrumblinkschecksp","-1","8"],
					["{7C26A499-9388-4839-9706-E82595128FFF}breadcrumblinksdeletesp","-1","8"],
					["{7C26A499-9388-4839-9706-E82595128FFF}breadcrumblinksmovesp","-1","8"],
					["{7C26A499-9388-4839-9706-E82595128FFF}loadhelponline","-2","8"],
					["{7C26A499-9388-4839-9706-E82595128FFF}loadaboutus","-2","8"],
					["{7C26A499-9388-4839-9706-E82595128FFF}loadtermsconditions","-2","8"],
					["{7C26A499-9388-4839-9706-E82595128FFF}printtermsconditions","-2","8"]];
$USER_LEVEL_PRIVS = array_merge($USER_LEVEL_PRIVS_1, $USER_LEVEL_PRIVS_2);

// User level table info
$USER_LEVEL_TABLES_1 = [["announcement","announcement","Announcement",true,"{7C26A499-9388-4839-9706-E82595128FFF}","announcementlist"],
    ["breadcrumblinks","breadcrumblinks","Breadcrumb Links",true,"{7C26A499-9388-4839-9706-E82595128FFF}","breadcrumblinkslist"],
    ["help","help","Help (Details)",true,"{7C26A499-9388-4839-9706-E82595128FFF}","helplist"],
    ["help_categories","help_categories","Help (Categories)",true,"{7C26A499-9388-4839-9706-E82595128FFF}","helpcategorieslist"],
    ["languages","languages","Languages",true,"{7C26A499-9388-4839-9706-E82595128FFF}","languageslist"],
    ["myuserprofile","myuserprofile","My User Profile",true,"{7C26A499-9388-4839-9706-E82595128FFF}","myuserprofilelist"],
    ["settings","settings","Application Settings",true,"{7C26A499-9388-4839-9706-E82595128FFF}","settingslist"],
    ["stats_counter","stats_counter","Statistics OS & Browsers",true,"{7C26A499-9388-4839-9706-E82595128FFF}","statscounterlist"],
    ["stats_counterlog","stats_counterlog","Statistics per IP",true,"{7C26A499-9388-4839-9706-E82595128FFF}","statscounterloglist"],
    ["stats_date","stats_date","Statistics per Date",true,"{7C26A499-9388-4839-9706-E82595128FFF}","statsdatelist"],
    ["stats_hour","stats_hour","Statistics per Hour",true,"{7C26A499-9388-4839-9706-E82595128FFF}","statshourlist"],
    ["stats_month","stats_month","Statistics per Month",true,"{7C26A499-9388-4839-9706-E82595128FFF}","statsmonthlist"],
    ["stats_year","stats_year","Statistics per Year",true,"{7C26A499-9388-4839-9706-E82595128FFF}","statsyearlist"],
    ["timezone","timezone","Timezone",true,"{7C26A499-9388-4839-9706-E82595128FFF}","timezonelist"],
    ["userlevelpermissions","userlevelpermissions","User Level Permissions",true,"{7C26A499-9388-4839-9706-E82595128FFF}","userlevelpermissionslist"],
    ["userlevels","userlevels","User Levels",true,"{7C26A499-9388-4839-9706-E82595128FFF}","userlevelslist"],
    ["users","users","Users",true,"{7C26A499-9388-4839-9706-E82595128FFF}","userslist"],
    ["dosen","dosen","dosen",true,"{7C26A499-9388-4839-9706-E82595128FFF}","dosenlist"],
    ["jabatan_fungsional","jabatan_fungsional","jabatan fungsional",true,"{7C26A499-9388-4839-9706-E82595128FFF}","jabatanfungsionallist"],
    ["jenjang","jenjang","jenjang",true,"{7C26A499-9388-4839-9706-E82595128FFF}","jenjanglist"],
    ["kelompok_penelitian","kelompok_penelitian","Kelompok Penelitian",true,"{7C26A499-9388-4839-9706-E82595128FFF}","kelompokpenelitianlist"],
    ["kelompok_pengabdian","kelompok_pengabdian","Kelompok Pengabdian",true,"{7C26A499-9388-4839-9706-E82595128FFF}","kelompokpengabdianlist"],
    ["kepakaran","kepakaran","kepakaran",true,"{7C26A499-9388-4839-9706-E82595128FFF}","kepakaranlist"],
    ["laporan_penelitian","laporan_penelitian","Laporan Penelitian",true,"{7C26A499-9388-4839-9706-E82595128FFF}","laporanpenelitianlist"],
    ["laporan_pengabdian","laporan_pengabdian","Laporan Pengabdian",true,"{7C26A499-9388-4839-9706-E82595128FFF}","laporanpengabdianlist"],
    ["proposal_penelitian","proposal_penelitian","Proposal Penelitian",true,"{7C26A499-9388-4839-9706-E82595128FFF}","proposalpenelitianlist"],
    ["proposal_penelitian_status","proposal_penelitian_status","Proposal Penelitian Status",true,"{7C26A499-9388-4839-9706-E82595128FFF}","proposalpenelitianstatuslist"],
    ["proposal_pengabdian","proposal_pengabdian","Proposal Pengabdian",true,"{7C26A499-9388-4839-9706-E82595128FFF}","proposalpengabdianlist"],
    ["proposal_pengabdian_status","proposal_pengabdian_status","Proposal Pengabdian Status",true,"{7C26A499-9388-4839-9706-E82595128FFF}","proposalpengabdianstatuslist"],
    ["rumpun_ilmu","rumpun_ilmu","rumpun ilmu",true,"{7C26A499-9388-4839-9706-E82595128FFF}","rumpunilmulist"],
    ["warna_kaver","warna_kaver","warna kaver",true,"{7C26A499-9388-4839-9706-E82595128FFF}","warnakaverlist"],
    ["home.php","home","Home",true,"{7C26A499-9388-4839-9706-E82595128FFF}","home"],
    ["news.php","news","News",true,"{7C26A499-9388-4839-9706-E82595128FFF}","news"],
    ["validasi","validasi","validasi",true,"{7C26A499-9388-4839-9706-E82595128FFF}","validasilist"],
    ["vproposal_penelitian","vproposal_penelitian","vproposal penelitian",true,"{7C26A499-9388-4839-9706-E82595128FFF}","vproposalpenelitianlist"],
    ["vproposal_pengabdian","vproposal_pengabdian","vproposal pengabdian",true,"{7C26A499-9388-4839-9706-E82595128FFF}","vproposalpengabdianlist"],
    ["vproposal_penelitian_terima","vproposal_penelitian_terima","vproposal penelitian terima",true,"{7C26A499-9388-4839-9706-E82595128FFF}","vproposalpenelitianterimalist"],
    ["vproposal_pengabdian_diterima","vproposal_pengabdian_diterima","vproposal pengabdian diterima",true,"{7C26A499-9388-4839-9706-E82595128FFF}","vproposalpengabdianditerimalist"]];
$USER_LEVEL_TABLES_2 = [["breadcrumblinksaddsp","breadcrumblinksaddsp","System - Breadcrumb Links - Add",true,"{7C26A499-9388-4839-9706-E82595128FFF}","breadcrumblinksaddsp"],
						["breadcrumblinkschecksp","breadcrumblinkschecksp","System - Breadcrumb Links - Check",true,"{7C26A499-9388-4839-9706-E82595128FFF}","breadcrumblinkschecksp"],
						["breadcrumblinksdeletesp","breadcrumblinksdeletesp","System - Breadcrumb Links - Delete",true,"{7C26A499-9388-4839-9706-E82595128FFF}","breadcrumblinksdeletesp"],
						["breadcrumblinksmovesp","breadcrumblinksmovesp","System - Breadcrumb Links - Move",true,"{7C26A499-9388-4839-9706-E82595128FFF}","breadcrumblinksmovesp"],
						["loadhelponline","loadhelponline","System - Load Help Online",true,"{7C26A499-9388-4839-9706-E82595128FFF}","loadhelponline"],
						["loadaboutus","loadaboutus","System - Load About Us",true,"{7C26A499-9388-4839-9706-E82595128FFF}","loadaboutus"],
						["loadtermsconditions","loadtermsconditions","System - Load Terms and Conditions",true,"{7C26A499-9388-4839-9706-E82595128FFF}","loadtermsconditions"],
						["printtermsconditions","printtermsconditions","System - Print Terms and Conditions",true,"{7C26A499-9388-4839-9706-E82595128FFF}","printtermsconditions"]];
$USER_LEVEL_TABLES = array_merge($USER_LEVEL_TABLES_1, $USER_LEVEL_TABLES_2);
