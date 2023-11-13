<?php

namespace PHPMaker2023\new2023;

use Slim\App;
use Slim\Routing\RouteCollectorProxy;
use Slim\Exception\HttpNotFoundException;

// Handle Routes
return function (App $app) {
	// breadcrumblinksaddsp
    $app->any('/breadcrumblinksaddsp', BreadcrumblinksaddspController::class)->add(PermissionMiddleware::class)->setName('breadcrumblinksaddsp-breadcrumblinksaddsp-custom'); // custom

	// breadcrumblinkschecksp
    $app->any('/breadcrumblinkschecksp', BreadcrumblinkscheckspController::class)->add(PermissionMiddleware::class)->setName('breadcrumblinkschecksp-breadcrumblinkschecksp-custom'); // custom

	// breadcrumblinksdeletesp
    $app->any('/breadcrumblinksdeletesp', BreadcrumblinksdeletespController::class)->add(PermissionMiddleware::class)->setName('breadcrumblinksdeletesp-breadcrumblinksdeletesp-custom'); // custom

	// breadcrumblinksmovesp
    $app->any('/breadcrumblinksmovesp', BreadcrumblinksmovespController::class)->add(PermissionMiddleware::class)->setName('breadcrumblinksmovesp-breadcrumblinksmovesp-custom'); // custom

	// loadhelponline
    $app->any('/loadhelponline', LoadhelponlineController::class)->add(PermissionMiddleware::class)->setName('loadhelponline-loadhelponline-custom'); // custom

	// loadaboutus
    $app->any('/loadaboutus', LoadaboutusController::class)->add(PermissionMiddleware::class)->setName('loadaboutus-loadaboutus-custom'); // custom

	// loadtermsconditions
    $app->any('/loadtermsconditions', LoadtermsconditionsController::class)->add(PermissionMiddleware::class)->setName('loadtermsconditions-loadtermsconditions-custom'); // custom

	// printtermsconditions
    $app->any('/printtermsconditions', PrinttermsconditionsController::class)->add(PermissionMiddleware::class)->setName('printtermsconditions-printtermsconditions-custom'); // custom

    // announcement
    $app->map(["GET","POST","OPTIONS"], '/announcementlist[/{Announcement_ID}]', AnnouncementController::class . ':list')->add(PermissionMiddleware::class)->setName('announcementlist-announcement-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/announcementadd[/{Announcement_ID}]', AnnouncementController::class . ':add')->add(PermissionMiddleware::class)->setName('announcementadd-announcement-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/announcementview[/{Announcement_ID}]', AnnouncementController::class . ':view')->add(PermissionMiddleware::class)->setName('announcementview-announcement-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/announcementedit[/{Announcement_ID}]', AnnouncementController::class . ':edit')->add(PermissionMiddleware::class)->setName('announcementedit-announcement-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/announcementdelete[/{Announcement_ID}]', AnnouncementController::class . ':delete')->add(PermissionMiddleware::class)->setName('announcementdelete-announcement-delete'); // delete
    $app->group(
        '/announcement',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Announcement_ID}]', AnnouncementController::class . ':list')->add(PermissionMiddleware::class)->setName('announcement/list-announcement-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{Announcement_ID}]', AnnouncementController::class . ':add')->add(PermissionMiddleware::class)->setName('announcement/add-announcement-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{Announcement_ID}]', AnnouncementController::class . ':view')->add(PermissionMiddleware::class)->setName('announcement/view-announcement-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{Announcement_ID}]', AnnouncementController::class . ':edit')->add(PermissionMiddleware::class)->setName('announcement/edit-announcement-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{Announcement_ID}]', AnnouncementController::class . ':delete')->add(PermissionMiddleware::class)->setName('announcement/delete-announcement-delete-2'); // delete
        }
    );

    // breadcrumblinks
    $app->map(["GET","POST","OPTIONS"], '/breadcrumblinkslist[/{Page_Title:.*}]', BreadcrumblinksController::class . ':list')->add(PermissionMiddleware::class)->setName('breadcrumblinkslist-breadcrumblinks-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/breadcrumblinksadd[/{Page_Title:.*}]', BreadcrumblinksController::class . ':add')->add(PermissionMiddleware::class)->setName('breadcrumblinksadd-breadcrumblinks-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/breadcrumblinksview[/{Page_Title:.*}]', BreadcrumblinksController::class . ':view')->add(PermissionMiddleware::class)->setName('breadcrumblinksview-breadcrumblinks-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/breadcrumblinksedit[/{Page_Title:.*}]', BreadcrumblinksController::class . ':edit')->add(PermissionMiddleware::class)->setName('breadcrumblinksedit-breadcrumblinks-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/breadcrumblinksdelete[/{Page_Title:.*}]', BreadcrumblinksController::class . ':delete')->add(PermissionMiddleware::class)->setName('breadcrumblinksdelete-breadcrumblinks-delete'); // delete
    $app->group(
        '/breadcrumblinks',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Page_Title:.*}]', BreadcrumblinksController::class . ':list')->add(PermissionMiddleware::class)->setName('breadcrumblinks/list-breadcrumblinks-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{Page_Title:.*}]', BreadcrumblinksController::class . ':add')->add(PermissionMiddleware::class)->setName('breadcrumblinks/add-breadcrumblinks-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{Page_Title:.*}]', BreadcrumblinksController::class . ':view')->add(PermissionMiddleware::class)->setName('breadcrumblinks/view-breadcrumblinks-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{Page_Title:.*}]', BreadcrumblinksController::class . ':edit')->add(PermissionMiddleware::class)->setName('breadcrumblinks/edit-breadcrumblinks-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{Page_Title:.*}]', BreadcrumblinksController::class . ':delete')->add(PermissionMiddleware::class)->setName('breadcrumblinks/delete-breadcrumblinks-delete-2'); // delete
        }
    );

    // help
    $app->map(["GET","POST","OPTIONS"], '/helplist[/{Help_ID}]', HelpController::class . ':list')->add(PermissionMiddleware::class)->setName('helplist-help-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/helpadd[/{Help_ID}]', HelpController::class . ':add')->add(PermissionMiddleware::class)->setName('helpadd-help-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/helpview[/{Help_ID}]', HelpController::class . ':view')->add(PermissionMiddleware::class)->setName('helpview-help-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/helpedit[/{Help_ID}]', HelpController::class . ':edit')->add(PermissionMiddleware::class)->setName('helpedit-help-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/helpdelete[/{Help_ID}]', HelpController::class . ':delete')->add(PermissionMiddleware::class)->setName('helpdelete-help-delete'); // delete
    $app->map(["GET","OPTIONS"], '/helppreview', HelpController::class . ':preview')->add(PermissionMiddleware::class)->setName('helppreview-help-preview'); // preview
    $app->group(
        '/help',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Help_ID}]', HelpController::class . ':list')->add(PermissionMiddleware::class)->setName('help/list-help-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{Help_ID}]', HelpController::class . ':add')->add(PermissionMiddleware::class)->setName('help/add-help-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{Help_ID}]', HelpController::class . ':view')->add(PermissionMiddleware::class)->setName('help/view-help-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{Help_ID}]', HelpController::class . ':edit')->add(PermissionMiddleware::class)->setName('help/edit-help-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{Help_ID}]', HelpController::class . ':delete')->add(PermissionMiddleware::class)->setName('help/delete-help-delete-2'); // delete
        }
    );

    // help_categories
    $app->map(["GET","POST","OPTIONS"], '/helpcategorieslist[/{Category_ID}]', HelpCategoriesController::class . ':list')->add(PermissionMiddleware::class)->setName('helpcategorieslist-help_categories-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/helpcategoriesadd[/{Category_ID}]', HelpCategoriesController::class . ':add')->add(PermissionMiddleware::class)->setName('helpcategoriesadd-help_categories-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/helpcategoriesview[/{Category_ID}]', HelpCategoriesController::class . ':view')->add(PermissionMiddleware::class)->setName('helpcategoriesview-help_categories-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/helpcategoriesedit[/{Category_ID}]', HelpCategoriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('helpcategoriesedit-help_categories-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/helpcategoriesdelete[/{Category_ID}]', HelpCategoriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('helpcategoriesdelete-help_categories-delete'); // delete
    $app->group(
        '/help_categories',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Category_ID}]', HelpCategoriesController::class . ':list')->add(PermissionMiddleware::class)->setName('help_categories/list-help_categories-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{Category_ID}]', HelpCategoriesController::class . ':add')->add(PermissionMiddleware::class)->setName('help_categories/add-help_categories-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{Category_ID}]', HelpCategoriesController::class . ':view')->add(PermissionMiddleware::class)->setName('help_categories/view-help_categories-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{Category_ID}]', HelpCategoriesController::class . ':edit')->add(PermissionMiddleware::class)->setName('help_categories/edit-help_categories-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{Category_ID}]', HelpCategoriesController::class . ':delete')->add(PermissionMiddleware::class)->setName('help_categories/delete-help_categories-delete-2'); // delete
        }
    );

    // languages
    $app->map(["GET","POST","OPTIONS"], '/languageslist[/{Language_Code:.*}]', LanguagesController::class . ':list')->add(PermissionMiddleware::class)->setName('languageslist-languages-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/languagesadd[/{Language_Code:.*}]', LanguagesController::class . ':add')->add(PermissionMiddleware::class)->setName('languagesadd-languages-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/languagesview[/{Language_Code:.*}]', LanguagesController::class . ':view')->add(PermissionMiddleware::class)->setName('languagesview-languages-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/languagesedit[/{Language_Code:.*}]', LanguagesController::class . ':edit')->add(PermissionMiddleware::class)->setName('languagesedit-languages-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/languagesdelete[/{Language_Code:.*}]', LanguagesController::class . ':delete')->add(PermissionMiddleware::class)->setName('languagesdelete-languages-delete'); // delete
    $app->group(
        '/languages',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Language_Code:.*}]', LanguagesController::class . ':list')->add(PermissionMiddleware::class)->setName('languages/list-languages-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{Language_Code:.*}]', LanguagesController::class . ':add')->add(PermissionMiddleware::class)->setName('languages/add-languages-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{Language_Code:.*}]', LanguagesController::class . ':view')->add(PermissionMiddleware::class)->setName('languages/view-languages-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{Language_Code:.*}]', LanguagesController::class . ':edit')->add(PermissionMiddleware::class)->setName('languages/edit-languages-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{Language_Code:.*}]', LanguagesController::class . ':delete')->add(PermissionMiddleware::class)->setName('languages/delete-languages-delete-2'); // delete
        }
    );

    // myuserprofile
    $app->map(["GET","POST","OPTIONS"], '/myuserprofilelist[/{_Username:.*}]', MyuserprofileController::class . ':list')->add(PermissionMiddleware::class)->setName('myuserprofilelist-myuserprofile-list'); // list
    $app->group(
        '/myuserprofile',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{_Username:.*}]', MyuserprofileController::class . ':list')->add(PermissionMiddleware::class)->setName('myuserprofile/list-myuserprofile-list-2'); // list
        }
    );

    // settings
    $app->map(["GET","POST","OPTIONS"], '/settingslist[/{Option_ID}]', SettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('settingslist-settings-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/settingsadd[/{Option_ID}]', SettingsController::class . ':add')->add(PermissionMiddleware::class)->setName('settingsadd-settings-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/settingsview[/{Option_ID}]', SettingsController::class . ':view')->add(PermissionMiddleware::class)->setName('settingsview-settings-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/settingsedit[/{Option_ID}]', SettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('settingsedit-settings-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/settingsdelete[/{Option_ID}]', SettingsController::class . ':delete')->add(PermissionMiddleware::class)->setName('settingsdelete-settings-delete'); // delete
    $app->group(
        '/settings',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Option_ID}]', SettingsController::class . ':list')->add(PermissionMiddleware::class)->setName('settings/list-settings-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{Option_ID}]', SettingsController::class . ':add')->add(PermissionMiddleware::class)->setName('settings/add-settings-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{Option_ID}]', SettingsController::class . ':view')->add(PermissionMiddleware::class)->setName('settings/view-settings-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{Option_ID}]', SettingsController::class . ':edit')->add(PermissionMiddleware::class)->setName('settings/edit-settings-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{Option_ID}]', SettingsController::class . ':delete')->add(PermissionMiddleware::class)->setName('settings/delete-settings-delete-2'); // delete
        }
    );

    // stats_counter
    $app->map(["GET","POST","OPTIONS"], '/statscounterlist[/{keys:.*}]', StatsCounterController::class . ':list')->add(PermissionMiddleware::class)->setName('statscounterlist-stats_counter-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/statscounteradd[/{keys:.*}]', StatsCounterController::class . ':add')->add(PermissionMiddleware::class)->setName('statscounteradd-stats_counter-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/statscounterview[/{keys:.*}]', StatsCounterController::class . ':view')->add(PermissionMiddleware::class)->setName('statscounterview-stats_counter-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/statscounteredit[/{keys:.*}]', StatsCounterController::class . ':edit')->add(PermissionMiddleware::class)->setName('statscounteredit-stats_counter-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/statscounterdelete[/{keys:.*}]', StatsCounterController::class . ':delete')->add(PermissionMiddleware::class)->setName('statscounterdelete-stats_counter-delete'); // delete
    $app->group(
        '/stats_counter',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{keys:.*}]', StatsCounterController::class . ':list')->add(PermissionMiddleware::class)->setName('stats_counter/list-stats_counter-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{keys:.*}]', StatsCounterController::class . ':add')->add(PermissionMiddleware::class)->setName('stats_counter/add-stats_counter-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{keys:.*}]', StatsCounterController::class . ':view')->add(PermissionMiddleware::class)->setName('stats_counter/view-stats_counter-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{keys:.*}]', StatsCounterController::class . ':edit')->add(PermissionMiddleware::class)->setName('stats_counter/edit-stats_counter-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{keys:.*}]', StatsCounterController::class . ':delete')->add(PermissionMiddleware::class)->setName('stats_counter/delete-stats_counter-delete-2'); // delete
        }
    );

    // stats_counterlog
    $app->map(["GET","POST","OPTIONS"], '/statscounterloglist[/{IP_Address:.*}]', StatsCounterlogController::class . ':list')->add(PermissionMiddleware::class)->setName('statscounterloglist-stats_counterlog-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/statscounterlogadd[/{IP_Address:.*}]', StatsCounterlogController::class . ':add')->add(PermissionMiddleware::class)->setName('statscounterlogadd-stats_counterlog-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/statscounterlogview[/{IP_Address:.*}]', StatsCounterlogController::class . ':view')->add(PermissionMiddleware::class)->setName('statscounterlogview-stats_counterlog-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/statscounterlogedit[/{IP_Address:.*}]', StatsCounterlogController::class . ':edit')->add(PermissionMiddleware::class)->setName('statscounterlogedit-stats_counterlog-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/statscounterlogdelete[/{IP_Address:.*}]', StatsCounterlogController::class . ':delete')->add(PermissionMiddleware::class)->setName('statscounterlogdelete-stats_counterlog-delete'); // delete
    $app->group(
        '/stats_counterlog',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{IP_Address:.*}]', StatsCounterlogController::class . ':list')->add(PermissionMiddleware::class)->setName('stats_counterlog/list-stats_counterlog-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{IP_Address:.*}]', StatsCounterlogController::class . ':add')->add(PermissionMiddleware::class)->setName('stats_counterlog/add-stats_counterlog-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{IP_Address:.*}]', StatsCounterlogController::class . ':view')->add(PermissionMiddleware::class)->setName('stats_counterlog/view-stats_counterlog-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{IP_Address:.*}]', StatsCounterlogController::class . ':edit')->add(PermissionMiddleware::class)->setName('stats_counterlog/edit-stats_counterlog-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{IP_Address:.*}]', StatsCounterlogController::class . ':delete')->add(PermissionMiddleware::class)->setName('stats_counterlog/delete-stats_counterlog-delete-2'); // delete
        }
    );

    // stats_date
    $app->map(["GET","POST","OPTIONS"], '/statsdatelist[/{keys:.*}]', StatsDateController::class . ':list')->add(PermissionMiddleware::class)->setName('statsdatelist-stats_date-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/statsdateadd[/{keys:.*}]', StatsDateController::class . ':add')->add(PermissionMiddleware::class)->setName('statsdateadd-stats_date-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/statsdateview[/{keys:.*}]', StatsDateController::class . ':view')->add(PermissionMiddleware::class)->setName('statsdateview-stats_date-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/statsdateedit[/{keys:.*}]', StatsDateController::class . ':edit')->add(PermissionMiddleware::class)->setName('statsdateedit-stats_date-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/statsdatedelete[/{keys:.*}]', StatsDateController::class . ':delete')->add(PermissionMiddleware::class)->setName('statsdatedelete-stats_date-delete'); // delete
    $app->group(
        '/stats_date',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{keys:.*}]', StatsDateController::class . ':list')->add(PermissionMiddleware::class)->setName('stats_date/list-stats_date-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{keys:.*}]', StatsDateController::class . ':add')->add(PermissionMiddleware::class)->setName('stats_date/add-stats_date-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{keys:.*}]', StatsDateController::class . ':view')->add(PermissionMiddleware::class)->setName('stats_date/view-stats_date-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{keys:.*}]', StatsDateController::class . ':edit')->add(PermissionMiddleware::class)->setName('stats_date/edit-stats_date-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{keys:.*}]', StatsDateController::class . ':delete')->add(PermissionMiddleware::class)->setName('stats_date/delete-stats_date-delete-2'); // delete
        }
    );

    // stats_hour
    $app->map(["GET","POST","OPTIONS"], '/statshourlist[/{keys:.*}]', StatsHourController::class . ':list')->add(PermissionMiddleware::class)->setName('statshourlist-stats_hour-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/statshouradd[/{keys:.*}]', StatsHourController::class . ':add')->add(PermissionMiddleware::class)->setName('statshouradd-stats_hour-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/statshourview[/{keys:.*}]', StatsHourController::class . ':view')->add(PermissionMiddleware::class)->setName('statshourview-stats_hour-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/statshouredit[/{keys:.*}]', StatsHourController::class . ':edit')->add(PermissionMiddleware::class)->setName('statshouredit-stats_hour-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/statshourdelete[/{keys:.*}]', StatsHourController::class . ':delete')->add(PermissionMiddleware::class)->setName('statshourdelete-stats_hour-delete'); // delete
    $app->group(
        '/stats_hour',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{keys:.*}]', StatsHourController::class . ':list')->add(PermissionMiddleware::class)->setName('stats_hour/list-stats_hour-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{keys:.*}]', StatsHourController::class . ':add')->add(PermissionMiddleware::class)->setName('stats_hour/add-stats_hour-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{keys:.*}]', StatsHourController::class . ':view')->add(PermissionMiddleware::class)->setName('stats_hour/view-stats_hour-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{keys:.*}]', StatsHourController::class . ':edit')->add(PermissionMiddleware::class)->setName('stats_hour/edit-stats_hour-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{keys:.*}]', StatsHourController::class . ':delete')->add(PermissionMiddleware::class)->setName('stats_hour/delete-stats_hour-delete-2'); // delete
        }
    );

    // stats_month
    $app->map(["GET","POST","OPTIONS"], '/statsmonthlist[/{keys:.*}]', StatsMonthController::class . ':list')->add(PermissionMiddleware::class)->setName('statsmonthlist-stats_month-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/statsmonthadd[/{keys:.*}]', StatsMonthController::class . ':add')->add(PermissionMiddleware::class)->setName('statsmonthadd-stats_month-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/statsmonthview[/{keys:.*}]', StatsMonthController::class . ':view')->add(PermissionMiddleware::class)->setName('statsmonthview-stats_month-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/statsmonthedit[/{keys:.*}]', StatsMonthController::class . ':edit')->add(PermissionMiddleware::class)->setName('statsmonthedit-stats_month-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/statsmonthdelete[/{keys:.*}]', StatsMonthController::class . ':delete')->add(PermissionMiddleware::class)->setName('statsmonthdelete-stats_month-delete'); // delete
    $app->group(
        '/stats_month',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{keys:.*}]', StatsMonthController::class . ':list')->add(PermissionMiddleware::class)->setName('stats_month/list-stats_month-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{keys:.*}]', StatsMonthController::class . ':add')->add(PermissionMiddleware::class)->setName('stats_month/add-stats_month-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{keys:.*}]', StatsMonthController::class . ':view')->add(PermissionMiddleware::class)->setName('stats_month/view-stats_month-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{keys:.*}]', StatsMonthController::class . ':edit')->add(PermissionMiddleware::class)->setName('stats_month/edit-stats_month-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{keys:.*}]', StatsMonthController::class . ':delete')->add(PermissionMiddleware::class)->setName('stats_month/delete-stats_month-delete-2'); // delete
        }
    );

    // stats_year
    $app->map(["GET","POST","OPTIONS"], '/statsyearlist[/{Year}]', StatsYearController::class . ':list')->add(PermissionMiddleware::class)->setName('statsyearlist-stats_year-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/statsyearadd[/{Year}]', StatsYearController::class . ':add')->add(PermissionMiddleware::class)->setName('statsyearadd-stats_year-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/statsyearview[/{Year}]', StatsYearController::class . ':view')->add(PermissionMiddleware::class)->setName('statsyearview-stats_year-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/statsyearedit[/{Year}]', StatsYearController::class . ':edit')->add(PermissionMiddleware::class)->setName('statsyearedit-stats_year-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/statsyeardelete[/{Year}]', StatsYearController::class . ':delete')->add(PermissionMiddleware::class)->setName('statsyeardelete-stats_year-delete'); // delete
    $app->group(
        '/stats_year',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Year}]', StatsYearController::class . ':list')->add(PermissionMiddleware::class)->setName('stats_year/list-stats_year-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{Year}]', StatsYearController::class . ':add')->add(PermissionMiddleware::class)->setName('stats_year/add-stats_year-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{Year}]', StatsYearController::class . ':view')->add(PermissionMiddleware::class)->setName('stats_year/view-stats_year-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{Year}]', StatsYearController::class . ':edit')->add(PermissionMiddleware::class)->setName('stats_year/edit-stats_year-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{Year}]', StatsYearController::class . ':delete')->add(PermissionMiddleware::class)->setName('stats_year/delete-stats_year-delete-2'); // delete
        }
    );

    // timezone
    $app->map(["GET","POST","OPTIONS"], '/timezonelist[/{ID}]', TimezoneController::class . ':list')->add(PermissionMiddleware::class)->setName('timezonelist-timezone-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/timezoneadd[/{ID}]', TimezoneController::class . ':add')->add(PermissionMiddleware::class)->setName('timezoneadd-timezone-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/timezoneview[/{ID}]', TimezoneController::class . ':view')->add(PermissionMiddleware::class)->setName('timezoneview-timezone-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/timezoneedit[/{ID}]', TimezoneController::class . ':edit')->add(PermissionMiddleware::class)->setName('timezoneedit-timezone-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/timezonedelete[/{ID}]', TimezoneController::class . ':delete')->add(PermissionMiddleware::class)->setName('timezonedelete-timezone-delete'); // delete
    $app->group(
        '/timezone',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{ID}]', TimezoneController::class . ':list')->add(PermissionMiddleware::class)->setName('timezone/list-timezone-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{ID}]', TimezoneController::class . ':add')->add(PermissionMiddleware::class)->setName('timezone/add-timezone-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{ID}]', TimezoneController::class . ':view')->add(PermissionMiddleware::class)->setName('timezone/view-timezone-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{ID}]', TimezoneController::class . ':edit')->add(PermissionMiddleware::class)->setName('timezone/edit-timezone-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{ID}]', TimezoneController::class . ':delete')->add(PermissionMiddleware::class)->setName('timezone/delete-timezone-delete-2'); // delete
        }
    );

    // userlevelpermissions
    $app->map(["GET","POST","OPTIONS"], '/userlevelpermissionslist[/{keys:.*}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermissionslist-userlevelpermissions-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/userlevelpermissionsadd[/{keys:.*}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelpermissionsadd-userlevelpermissions-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/userlevelpermissionsview[/{keys:.*}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevelpermissionsview-userlevelpermissions-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/userlevelpermissionsedit[/{keys:.*}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelpermissionsedit-userlevelpermissions-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/userlevelpermissionsdelete[/{keys:.*}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelpermissionsdelete-userlevelpermissions-delete'); // delete
    $app->group(
        '/userlevelpermissions',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{keys:.*}]', UserlevelpermissionsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelpermissions/list-userlevelpermissions-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{keys:.*}]', UserlevelpermissionsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelpermissions/add-userlevelpermissions-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{keys:.*}]', UserlevelpermissionsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevelpermissions/view-userlevelpermissions-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{keys:.*}]', UserlevelpermissionsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelpermissions/edit-userlevelpermissions-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{keys:.*}]', UserlevelpermissionsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelpermissions/delete-userlevelpermissions-delete-2'); // delete
        }
    );

    // userlevels
    $app->map(["GET","POST","OPTIONS"], '/userlevelslist[/{User_Level_ID}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevelslist-userlevels-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/userlevelsadd[/{User_Level_ID}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevelsadd-userlevels-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/userlevelsview[/{User_Level_ID}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevelsview-userlevels-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/userlevelsedit[/{User_Level_ID}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevelsedit-userlevels-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/userlevelsdelete[/{User_Level_ID}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevelsdelete-userlevels-delete'); // delete
    $app->group(
        '/userlevels',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{User_Level_ID}]', UserlevelsController::class . ':list')->add(PermissionMiddleware::class)->setName('userlevels/list-userlevels-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{User_Level_ID}]', UserlevelsController::class . ':add')->add(PermissionMiddleware::class)->setName('userlevels/add-userlevels-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{User_Level_ID}]', UserlevelsController::class . ':view')->add(PermissionMiddleware::class)->setName('userlevels/view-userlevels-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{User_Level_ID}]', UserlevelsController::class . ':edit')->add(PermissionMiddleware::class)->setName('userlevels/edit-userlevels-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{User_Level_ID}]', UserlevelsController::class . ':delete')->add(PermissionMiddleware::class)->setName('userlevels/delete-userlevels-delete-2'); // delete
        }
    );

    // users
    $app->map(["GET","POST","OPTIONS"], '/userslist[/{_Username:.*}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('userslist-users-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/usersadd[/{_Username:.*}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('usersadd-users-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/usersview[/{_Username:.*}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('usersview-users-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/usersedit[/{_Username:.*}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('usersedit-users-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/usersdelete[/{_Username:.*}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('usersdelete-users-delete'); // delete
    $app->group(
        '/users',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{_Username:.*}]', UsersController::class . ':list')->add(PermissionMiddleware::class)->setName('users/list-users-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{_Username:.*}]', UsersController::class . ':add')->add(PermissionMiddleware::class)->setName('users/add-users-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{_Username:.*}]', UsersController::class . ':view')->add(PermissionMiddleware::class)->setName('users/view-users-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{_Username:.*}]', UsersController::class . ':edit')->add(PermissionMiddleware::class)->setName('users/edit-users-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{_Username:.*}]', UsersController::class . ':delete')->add(PermissionMiddleware::class)->setName('users/delete-users-delete-2'); // delete
        }
    );

    // dosen
    $app->map(["GET","POST","OPTIONS"], '/dosenlist[/{NIDN:.*}]', DosenController::class . ':list')->add(PermissionMiddleware::class)->setName('dosenlist-dosen-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/dosenadd[/{NIDN:.*}]', DosenController::class . ':add')->add(PermissionMiddleware::class)->setName('dosenadd-dosen-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/dosenview[/{NIDN:.*}]', DosenController::class . ':view')->add(PermissionMiddleware::class)->setName('dosenview-dosen-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/dosenedit[/{NIDN:.*}]', DosenController::class . ':edit')->add(PermissionMiddleware::class)->setName('dosenedit-dosen-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/dosendelete[/{NIDN:.*}]', DosenController::class . ':delete')->add(PermissionMiddleware::class)->setName('dosendelete-dosen-delete'); // delete
    $app->group(
        '/dosen',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{NIDN:.*}]', DosenController::class . ':list')->add(PermissionMiddleware::class)->setName('dosen/list-dosen-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{NIDN:.*}]', DosenController::class . ':add')->add(PermissionMiddleware::class)->setName('dosen/add-dosen-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{NIDN:.*}]', DosenController::class . ':view')->add(PermissionMiddleware::class)->setName('dosen/view-dosen-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{NIDN:.*}]', DosenController::class . ':edit')->add(PermissionMiddleware::class)->setName('dosen/edit-dosen-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{NIDN:.*}]', DosenController::class . ':delete')->add(PermissionMiddleware::class)->setName('dosen/delete-dosen-delete-2'); // delete
        }
    );

    // jabatan_fungsional
    $app->map(["GET","POST","OPTIONS"], '/jabatanfungsionallist[/{no}]', JabatanFungsionalController::class . ':list')->add(PermissionMiddleware::class)->setName('jabatanfungsionallist-jabatan_fungsional-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/jabatanfungsionaladd[/{no}]', JabatanFungsionalController::class . ':add')->add(PermissionMiddleware::class)->setName('jabatanfungsionaladd-jabatan_fungsional-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/jabatanfungsionalview[/{no}]', JabatanFungsionalController::class . ':view')->add(PermissionMiddleware::class)->setName('jabatanfungsionalview-jabatan_fungsional-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/jabatanfungsionaledit[/{no}]', JabatanFungsionalController::class . ':edit')->add(PermissionMiddleware::class)->setName('jabatanfungsionaledit-jabatan_fungsional-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/jabatanfungsionaldelete[/{no}]', JabatanFungsionalController::class . ':delete')->add(PermissionMiddleware::class)->setName('jabatanfungsionaldelete-jabatan_fungsional-delete'); // delete
    $app->group(
        '/jabatan_fungsional',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{no}]', JabatanFungsionalController::class . ':list')->add(PermissionMiddleware::class)->setName('jabatan_fungsional/list-jabatan_fungsional-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{no}]', JabatanFungsionalController::class . ':add')->add(PermissionMiddleware::class)->setName('jabatan_fungsional/add-jabatan_fungsional-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{no}]', JabatanFungsionalController::class . ':view')->add(PermissionMiddleware::class)->setName('jabatan_fungsional/view-jabatan_fungsional-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{no}]', JabatanFungsionalController::class . ':edit')->add(PermissionMiddleware::class)->setName('jabatan_fungsional/edit-jabatan_fungsional-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{no}]', JabatanFungsionalController::class . ':delete')->add(PermissionMiddleware::class)->setName('jabatan_fungsional/delete-jabatan_fungsional-delete-2'); // delete
        }
    );

    // jenjang
    $app->map(["GET","POST","OPTIONS"], '/jenjanglist[/{no}]', JenjangController::class . ':list')->add(PermissionMiddleware::class)->setName('jenjanglist-jenjang-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/jenjangadd[/{no}]', JenjangController::class . ':add')->add(PermissionMiddleware::class)->setName('jenjangadd-jenjang-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/jenjangview[/{no}]', JenjangController::class . ':view')->add(PermissionMiddleware::class)->setName('jenjangview-jenjang-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/jenjangedit[/{no}]', JenjangController::class . ':edit')->add(PermissionMiddleware::class)->setName('jenjangedit-jenjang-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/jenjangdelete[/{no}]', JenjangController::class . ':delete')->add(PermissionMiddleware::class)->setName('jenjangdelete-jenjang-delete'); // delete
    $app->group(
        '/jenjang',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{no}]', JenjangController::class . ':list')->add(PermissionMiddleware::class)->setName('jenjang/list-jenjang-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{no}]', JenjangController::class . ':add')->add(PermissionMiddleware::class)->setName('jenjang/add-jenjang-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{no}]', JenjangController::class . ':view')->add(PermissionMiddleware::class)->setName('jenjang/view-jenjang-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{no}]', JenjangController::class . ':edit')->add(PermissionMiddleware::class)->setName('jenjang/edit-jenjang-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{no}]', JenjangController::class . ':delete')->add(PermissionMiddleware::class)->setName('jenjang/delete-jenjang-delete-2'); // delete
        }
    );

    // kelompok_penelitian
    $app->map(["GET","POST","OPTIONS"], '/kelompokpenelitianlist[/{Id_Kelompok:.*}]', KelompokPenelitianController::class . ':list')->add(PermissionMiddleware::class)->setName('kelompokpenelitianlist-kelompok_penelitian-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/kelompokpenelitianadd[/{Id_Kelompok:.*}]', KelompokPenelitianController::class . ':add')->add(PermissionMiddleware::class)->setName('kelompokpenelitianadd-kelompok_penelitian-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/kelompokpenelitianview[/{Id_Kelompok:.*}]', KelompokPenelitianController::class . ':view')->add(PermissionMiddleware::class)->setName('kelompokpenelitianview-kelompok_penelitian-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/kelompokpenelitianedit[/{Id_Kelompok:.*}]', KelompokPenelitianController::class . ':edit')->add(PermissionMiddleware::class)->setName('kelompokpenelitianedit-kelompok_penelitian-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/kelompokpenelitiandelete[/{Id_Kelompok:.*}]', KelompokPenelitianController::class . ':delete')->add(PermissionMiddleware::class)->setName('kelompokpenelitiandelete-kelompok_penelitian-delete'); // delete
    $app->group(
        '/kelompok_penelitian',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Id_Kelompok:.*}]', KelompokPenelitianController::class . ':list')->add(PermissionMiddleware::class)->setName('kelompok_penelitian/list-kelompok_penelitian-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{Id_Kelompok:.*}]', KelompokPenelitianController::class . ':add')->add(PermissionMiddleware::class)->setName('kelompok_penelitian/add-kelompok_penelitian-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{Id_Kelompok:.*}]', KelompokPenelitianController::class . ':view')->add(PermissionMiddleware::class)->setName('kelompok_penelitian/view-kelompok_penelitian-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{Id_Kelompok:.*}]', KelompokPenelitianController::class . ':edit')->add(PermissionMiddleware::class)->setName('kelompok_penelitian/edit-kelompok_penelitian-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{Id_Kelompok:.*}]', KelompokPenelitianController::class . ':delete')->add(PermissionMiddleware::class)->setName('kelompok_penelitian/delete-kelompok_penelitian-delete-2'); // delete
        }
    );

    // kelompok_pengabdian
    $app->map(["GET","POST","OPTIONS"], '/kelompokpengabdianlist[/{Id_Kelompok:.*}]', KelompokPengabdianController::class . ':list')->add(PermissionMiddleware::class)->setName('kelompokpengabdianlist-kelompok_pengabdian-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/kelompokpengabdianadd[/{Id_Kelompok:.*}]', KelompokPengabdianController::class . ':add')->add(PermissionMiddleware::class)->setName('kelompokpengabdianadd-kelompok_pengabdian-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/kelompokpengabdianview[/{Id_Kelompok:.*}]', KelompokPengabdianController::class . ':view')->add(PermissionMiddleware::class)->setName('kelompokpengabdianview-kelompok_pengabdian-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/kelompokpengabdianedit[/{Id_Kelompok:.*}]', KelompokPengabdianController::class . ':edit')->add(PermissionMiddleware::class)->setName('kelompokpengabdianedit-kelompok_pengabdian-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/kelompokpengabdiandelete[/{Id_Kelompok:.*}]', KelompokPengabdianController::class . ':delete')->add(PermissionMiddleware::class)->setName('kelompokpengabdiandelete-kelompok_pengabdian-delete'); // delete
    $app->group(
        '/kelompok_pengabdian',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Id_Kelompok:.*}]', KelompokPengabdianController::class . ':list')->add(PermissionMiddleware::class)->setName('kelompok_pengabdian/list-kelompok_pengabdian-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{Id_Kelompok:.*}]', KelompokPengabdianController::class . ':add')->add(PermissionMiddleware::class)->setName('kelompok_pengabdian/add-kelompok_pengabdian-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{Id_Kelompok:.*}]', KelompokPengabdianController::class . ':view')->add(PermissionMiddleware::class)->setName('kelompok_pengabdian/view-kelompok_pengabdian-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{Id_Kelompok:.*}]', KelompokPengabdianController::class . ':edit')->add(PermissionMiddleware::class)->setName('kelompok_pengabdian/edit-kelompok_pengabdian-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{Id_Kelompok:.*}]', KelompokPengabdianController::class . ':delete')->add(PermissionMiddleware::class)->setName('kelompok_pengabdian/delete-kelompok_pengabdian-delete-2'); // delete
        }
    );

    // kepakaran
    $app->map(["GET","POST","OPTIONS"], '/kepakaranlist[/{no}]', KepakaranController::class . ':list')->add(PermissionMiddleware::class)->setName('kepakaranlist-kepakaran-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/kepakaranadd[/{no}]', KepakaranController::class . ':add')->add(PermissionMiddleware::class)->setName('kepakaranadd-kepakaran-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/kepakaranview[/{no}]', KepakaranController::class . ':view')->add(PermissionMiddleware::class)->setName('kepakaranview-kepakaran-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/kepakaranedit[/{no}]', KepakaranController::class . ':edit')->add(PermissionMiddleware::class)->setName('kepakaranedit-kepakaran-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/kepakarandelete[/{no}]', KepakaranController::class . ':delete')->add(PermissionMiddleware::class)->setName('kepakarandelete-kepakaran-delete'); // delete
    $app->group(
        '/kepakaran',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{no}]', KepakaranController::class . ':list')->add(PermissionMiddleware::class)->setName('kepakaran/list-kepakaran-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{no}]', KepakaranController::class . ':add')->add(PermissionMiddleware::class)->setName('kepakaran/add-kepakaran-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{no}]', KepakaranController::class . ':view')->add(PermissionMiddleware::class)->setName('kepakaran/view-kepakaran-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{no}]', KepakaranController::class . ':edit')->add(PermissionMiddleware::class)->setName('kepakaran/edit-kepakaran-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{no}]', KepakaranController::class . ':delete')->add(PermissionMiddleware::class)->setName('kepakaran/delete-kepakaran-delete-2'); // delete
        }
    );

    // laporan_penelitian
    $app->map(["GET","POST","OPTIONS"], '/laporanpenelitianlist[/{Id_Kelompok:.*}]', LaporanPenelitianController::class . ':list')->add(PermissionMiddleware::class)->setName('laporanpenelitianlist-laporan_penelitian-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/laporanpenelitianadd[/{Id_Kelompok:.*}]', LaporanPenelitianController::class . ':add')->add(PermissionMiddleware::class)->setName('laporanpenelitianadd-laporan_penelitian-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/laporanpenelitianview[/{Id_Kelompok:.*}]', LaporanPenelitianController::class . ':view')->add(PermissionMiddleware::class)->setName('laporanpenelitianview-laporan_penelitian-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/laporanpenelitianedit[/{Id_Kelompok:.*}]', LaporanPenelitianController::class . ':edit')->add(PermissionMiddleware::class)->setName('laporanpenelitianedit-laporan_penelitian-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/laporanpenelitiandelete[/{Id_Kelompok:.*}]', LaporanPenelitianController::class . ':delete')->add(PermissionMiddleware::class)->setName('laporanpenelitiandelete-laporan_penelitian-delete'); // delete
    $app->group(
        '/laporan_penelitian',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Id_Kelompok:.*}]', LaporanPenelitianController::class . ':list')->add(PermissionMiddleware::class)->setName('laporan_penelitian/list-laporan_penelitian-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{Id_Kelompok:.*}]', LaporanPenelitianController::class . ':add')->add(PermissionMiddleware::class)->setName('laporan_penelitian/add-laporan_penelitian-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{Id_Kelompok:.*}]', LaporanPenelitianController::class . ':view')->add(PermissionMiddleware::class)->setName('laporan_penelitian/view-laporan_penelitian-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{Id_Kelompok:.*}]', LaporanPenelitianController::class . ':edit')->add(PermissionMiddleware::class)->setName('laporan_penelitian/edit-laporan_penelitian-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{Id_Kelompok:.*}]', LaporanPenelitianController::class . ':delete')->add(PermissionMiddleware::class)->setName('laporan_penelitian/delete-laporan_penelitian-delete-2'); // delete
        }
    );

    // laporan_pengabdian
    $app->map(["GET","POST","OPTIONS"], '/laporanpengabdianlist[/{Id_kelompok:.*}]', LaporanPengabdianController::class . ':list')->add(PermissionMiddleware::class)->setName('laporanpengabdianlist-laporan_pengabdian-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/laporanpengabdianadd[/{Id_kelompok:.*}]', LaporanPengabdianController::class . ':add')->add(PermissionMiddleware::class)->setName('laporanpengabdianadd-laporan_pengabdian-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/laporanpengabdianview[/{Id_kelompok:.*}]', LaporanPengabdianController::class . ':view')->add(PermissionMiddleware::class)->setName('laporanpengabdianview-laporan_pengabdian-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/laporanpengabdianedit[/{Id_kelompok:.*}]', LaporanPengabdianController::class . ':edit')->add(PermissionMiddleware::class)->setName('laporanpengabdianedit-laporan_pengabdian-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/laporanpengabdiandelete[/{Id_kelompok:.*}]', LaporanPengabdianController::class . ':delete')->add(PermissionMiddleware::class)->setName('laporanpengabdiandelete-laporan_pengabdian-delete'); // delete
    $app->group(
        '/laporan_pengabdian',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Id_kelompok:.*}]', LaporanPengabdianController::class . ':list')->add(PermissionMiddleware::class)->setName('laporan_pengabdian/list-laporan_pengabdian-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{Id_kelompok:.*}]', LaporanPengabdianController::class . ':add')->add(PermissionMiddleware::class)->setName('laporan_pengabdian/add-laporan_pengabdian-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{Id_kelompok:.*}]', LaporanPengabdianController::class . ':view')->add(PermissionMiddleware::class)->setName('laporan_pengabdian/view-laporan_pengabdian-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{Id_kelompok:.*}]', LaporanPengabdianController::class . ':edit')->add(PermissionMiddleware::class)->setName('laporan_pengabdian/edit-laporan_pengabdian-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{Id_kelompok:.*}]', LaporanPengabdianController::class . ':delete')->add(PermissionMiddleware::class)->setName('laporan_pengabdian/delete-laporan_pengabdian-delete-2'); // delete
        }
    );

    // proposal_penelitian
    $app->map(["GET","POST","OPTIONS"], '/proposalpenelitianlist[/{Id_kelompok:.*}]', ProposalPenelitianController::class . ':list')->add(PermissionMiddleware::class)->setName('proposalpenelitianlist-proposal_penelitian-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/proposalpenelitianadd[/{Id_kelompok:.*}]', ProposalPenelitianController::class . ':add')->add(PermissionMiddleware::class)->setName('proposalpenelitianadd-proposal_penelitian-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/proposalpenelitianview[/{Id_kelompok:.*}]', ProposalPenelitianController::class . ':view')->add(PermissionMiddleware::class)->setName('proposalpenelitianview-proposal_penelitian-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/proposalpenelitianedit[/{Id_kelompok:.*}]', ProposalPenelitianController::class . ':edit')->add(PermissionMiddleware::class)->setName('proposalpenelitianedit-proposal_penelitian-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/proposalpenelitiandelete[/{Id_kelompok:.*}]', ProposalPenelitianController::class . ':delete')->add(PermissionMiddleware::class)->setName('proposalpenelitiandelete-proposal_penelitian-delete'); // delete
    $app->group(
        '/proposal_penelitian',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Id_kelompok:.*}]', ProposalPenelitianController::class . ':list')->add(PermissionMiddleware::class)->setName('proposal_penelitian/list-proposal_penelitian-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{Id_kelompok:.*}]', ProposalPenelitianController::class . ':add')->add(PermissionMiddleware::class)->setName('proposal_penelitian/add-proposal_penelitian-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{Id_kelompok:.*}]', ProposalPenelitianController::class . ':view')->add(PermissionMiddleware::class)->setName('proposal_penelitian/view-proposal_penelitian-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{Id_kelompok:.*}]', ProposalPenelitianController::class . ':edit')->add(PermissionMiddleware::class)->setName('proposal_penelitian/edit-proposal_penelitian-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{Id_kelompok:.*}]', ProposalPenelitianController::class . ':delete')->add(PermissionMiddleware::class)->setName('proposal_penelitian/delete-proposal_penelitian-delete-2'); // delete
        }
    );

    // proposal_penelitian_status
    $app->map(["GET","POST","OPTIONS"], '/proposalpenelitianstatuslist[/{id_pengabidian}]', ProposalPenelitianStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('proposalpenelitianstatuslist-proposal_penelitian_status-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/proposalpenelitianstatusadd[/{id_pengabidian}]', ProposalPenelitianStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('proposalpenelitianstatusadd-proposal_penelitian_status-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/proposalpenelitianstatusview[/{id_pengabidian}]', ProposalPenelitianStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('proposalpenelitianstatusview-proposal_penelitian_status-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/proposalpenelitianstatusedit[/{id_pengabidian}]', ProposalPenelitianStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('proposalpenelitianstatusedit-proposal_penelitian_status-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/proposalpenelitianstatusdelete[/{id_pengabidian}]', ProposalPenelitianStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('proposalpenelitianstatusdelete-proposal_penelitian_status-delete'); // delete
    $app->group(
        '/proposal_penelitian_status',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{id_pengabidian}]', ProposalPenelitianStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('proposal_penelitian_status/list-proposal_penelitian_status-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{id_pengabidian}]', ProposalPenelitianStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('proposal_penelitian_status/add-proposal_penelitian_status-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{id_pengabidian}]', ProposalPenelitianStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('proposal_penelitian_status/view-proposal_penelitian_status-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{id_pengabidian}]', ProposalPenelitianStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('proposal_penelitian_status/edit-proposal_penelitian_status-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{id_pengabidian}]', ProposalPenelitianStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('proposal_penelitian_status/delete-proposal_penelitian_status-delete-2'); // delete
        }
    );

    // proposal_pengabdian
    $app->map(["GET","POST","OPTIONS"], '/proposalpengabdianlist[/{Id_kelompok:.*}]', ProposalPengabdianController::class . ':list')->add(PermissionMiddleware::class)->setName('proposalpengabdianlist-proposal_pengabdian-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/proposalpengabdianadd[/{Id_kelompok:.*}]', ProposalPengabdianController::class . ':add')->add(PermissionMiddleware::class)->setName('proposalpengabdianadd-proposal_pengabdian-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/proposalpengabdianview[/{Id_kelompok:.*}]', ProposalPengabdianController::class . ':view')->add(PermissionMiddleware::class)->setName('proposalpengabdianview-proposal_pengabdian-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/proposalpengabdianedit[/{Id_kelompok:.*}]', ProposalPengabdianController::class . ':edit')->add(PermissionMiddleware::class)->setName('proposalpengabdianedit-proposal_pengabdian-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/proposalpengabdiandelete[/{Id_kelompok:.*}]', ProposalPengabdianController::class . ':delete')->add(PermissionMiddleware::class)->setName('proposalpengabdiandelete-proposal_pengabdian-delete'); // delete
    $app->group(
        '/proposal_pengabdian',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Id_kelompok:.*}]', ProposalPengabdianController::class . ':list')->add(PermissionMiddleware::class)->setName('proposal_pengabdian/list-proposal_pengabdian-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{Id_kelompok:.*}]', ProposalPengabdianController::class . ':add')->add(PermissionMiddleware::class)->setName('proposal_pengabdian/add-proposal_pengabdian-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{Id_kelompok:.*}]', ProposalPengabdianController::class . ':view')->add(PermissionMiddleware::class)->setName('proposal_pengabdian/view-proposal_pengabdian-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{Id_kelompok:.*}]', ProposalPengabdianController::class . ':edit')->add(PermissionMiddleware::class)->setName('proposal_pengabdian/edit-proposal_pengabdian-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{Id_kelompok:.*}]', ProposalPengabdianController::class . ':delete')->add(PermissionMiddleware::class)->setName('proposal_pengabdian/delete-proposal_pengabdian-delete-2'); // delete
        }
    );

    // proposal_pengabdian_status
    $app->map(["GET","POST","OPTIONS"], '/proposalpengabdianstatuslist[/{id_pengabdian}]', ProposalPengabdianStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('proposalpengabdianstatuslist-proposal_pengabdian_status-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/proposalpengabdianstatusadd[/{id_pengabdian}]', ProposalPengabdianStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('proposalpengabdianstatusadd-proposal_pengabdian_status-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/proposalpengabdianstatusview[/{id_pengabdian}]', ProposalPengabdianStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('proposalpengabdianstatusview-proposal_pengabdian_status-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/proposalpengabdianstatusedit[/{id_pengabdian}]', ProposalPengabdianStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('proposalpengabdianstatusedit-proposal_pengabdian_status-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/proposalpengabdianstatusdelete[/{id_pengabdian}]', ProposalPengabdianStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('proposalpengabdianstatusdelete-proposal_pengabdian_status-delete'); // delete
    $app->group(
        '/proposal_pengabdian_status',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{id_pengabdian}]', ProposalPengabdianStatusController::class . ':list')->add(PermissionMiddleware::class)->setName('proposal_pengabdian_status/list-proposal_pengabdian_status-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{id_pengabdian}]', ProposalPengabdianStatusController::class . ':add')->add(PermissionMiddleware::class)->setName('proposal_pengabdian_status/add-proposal_pengabdian_status-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{id_pengabdian}]', ProposalPengabdianStatusController::class . ':view')->add(PermissionMiddleware::class)->setName('proposal_pengabdian_status/view-proposal_pengabdian_status-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{id_pengabdian}]', ProposalPengabdianStatusController::class . ':edit')->add(PermissionMiddleware::class)->setName('proposal_pengabdian_status/edit-proposal_pengabdian_status-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{id_pengabdian}]', ProposalPengabdianStatusController::class . ':delete')->add(PermissionMiddleware::class)->setName('proposal_pengabdian_status/delete-proposal_pengabdian_status-delete-2'); // delete
        }
    );

    // rumpun_ilmu
    $app->map(["GET","POST","OPTIONS"], '/rumpunilmulist[/{no}]', RumpunIlmuController::class . ':list')->add(PermissionMiddleware::class)->setName('rumpunilmulist-rumpun_ilmu-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/rumpunilmuadd[/{no}]', RumpunIlmuController::class . ':add')->add(PermissionMiddleware::class)->setName('rumpunilmuadd-rumpun_ilmu-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/rumpunilmuview[/{no}]', RumpunIlmuController::class . ':view')->add(PermissionMiddleware::class)->setName('rumpunilmuview-rumpun_ilmu-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/rumpunilmuedit[/{no}]', RumpunIlmuController::class . ':edit')->add(PermissionMiddleware::class)->setName('rumpunilmuedit-rumpun_ilmu-edit'); // edit
    $app->map(["GET","POST","OPTIONS"], '/rumpunilmudelete[/{no}]', RumpunIlmuController::class . ':delete')->add(PermissionMiddleware::class)->setName('rumpunilmudelete-rumpun_ilmu-delete'); // delete
    $app->group(
        '/rumpun_ilmu',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{no}]', RumpunIlmuController::class . ':list')->add(PermissionMiddleware::class)->setName('rumpun_ilmu/list-rumpun_ilmu-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{no}]', RumpunIlmuController::class . ':add')->add(PermissionMiddleware::class)->setName('rumpun_ilmu/add-rumpun_ilmu-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{no}]', RumpunIlmuController::class . ':view')->add(PermissionMiddleware::class)->setName('rumpun_ilmu/view-rumpun_ilmu-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{no}]', RumpunIlmuController::class . ':edit')->add(PermissionMiddleware::class)->setName('rumpun_ilmu/edit-rumpun_ilmu-edit-2'); // edit
            $group->map(["GET","POST","OPTIONS"], '/' . Config('DELETE_ACTION') . '[/{no}]', RumpunIlmuController::class . ':delete')->add(PermissionMiddleware::class)->setName('rumpun_ilmu/delete-rumpun_ilmu-delete-2'); // delete
        }
    );

    // warna_kaver
    $app->map(["GET","POST","OPTIONS"], '/warnakaverlist[/{id_kaver}]', WarnaKaverController::class . ':list')->add(PermissionMiddleware::class)->setName('warnakaverlist-warna_kaver-list'); // list
    $app->map(["GET","POST","OPTIONS"], '/warnakaveradd[/{id_kaver}]', WarnaKaverController::class . ':add')->add(PermissionMiddleware::class)->setName('warnakaveradd-warna_kaver-add'); // add
    $app->map(["GET","POST","OPTIONS"], '/warnakaverview[/{id_kaver}]', WarnaKaverController::class . ':view')->add(PermissionMiddleware::class)->setName('warnakaverview-warna_kaver-view'); // view
    $app->map(["GET","POST","OPTIONS"], '/warnakaveredit[/{id_kaver}]', WarnaKaverController::class . ':edit')->add(PermissionMiddleware::class)->setName('warnakaveredit-warna_kaver-edit'); // edit
    $app->group(
        '/warna_kaver',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{id_kaver}]', WarnaKaverController::class . ':list')->add(PermissionMiddleware::class)->setName('warna_kaver/list-warna_kaver-list-2'); // list
            $group->map(["GET","POST","OPTIONS"], '/' . Config('ADD_ACTION') . '[/{id_kaver}]', WarnaKaverController::class . ':add')->add(PermissionMiddleware::class)->setName('warna_kaver/add-warna_kaver-add-2'); // add
            $group->map(["GET","POST","OPTIONS"], '/' . Config('VIEW_ACTION') . '[/{id_kaver}]', WarnaKaverController::class . ':view')->add(PermissionMiddleware::class)->setName('warna_kaver/view-warna_kaver-view-2'); // view
            $group->map(["GET","POST","OPTIONS"], '/' . Config('EDIT_ACTION') . '[/{id_kaver}]', WarnaKaverController::class . ':edit')->add(PermissionMiddleware::class)->setName('warna_kaver/edit-warna_kaver-edit-2'); // edit
        }
    );

    // home
    $app->map(["GET", "POST", "OPTIONS"], '/home[/{params:.*}]', HomeController::class . ':custom')->add(PermissionMiddleware::class)->setName('home-home-custom'); // custom

    // news
    $app->map(["GET", "POST", "OPTIONS"], '/news[/{params:.*}]', NewsController::class . ':custom')->add(PermissionMiddleware::class)->setName('news-news-custom'); // custom

    // validasi
    $app->map(["GET","POST","OPTIONS"], '/validasilist[/{NIDN:.*}]', ValidasiController::class . ':list')->add(PermissionMiddleware::class)->setName('validasilist-validasi-list'); // list
    $app->group(
        '/validasi',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{NIDN:.*}]', ValidasiController::class . ':list')->add(PermissionMiddleware::class)->setName('validasi/list-validasi-list-2'); // list
        }
    );

    // vproposal_penelitian
    $app->map(["GET","POST","OPTIONS"], '/vproposalpenelitianlist[/{Id_kelompok:.*}]', VproposalPenelitianController::class . ':list')->add(PermissionMiddleware::class)->setName('vproposalpenelitianlist-vproposal_penelitian-list'); // list
    $app->group(
        '/vproposal_penelitian',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Id_kelompok:.*}]', VproposalPenelitianController::class . ':list')->add(PermissionMiddleware::class)->setName('vproposal_penelitian/list-vproposal_penelitian-list-2'); // list
        }
    );

    // vproposal_pengabdian
    $app->map(["GET","POST","OPTIONS"], '/vproposalpengabdianlist[/{Id_kelompok:.*}]', VproposalPengabdianController::class . ':list')->add(PermissionMiddleware::class)->setName('vproposalpengabdianlist-vproposal_pengabdian-list'); // list
    $app->group(
        '/vproposal_pengabdian',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Id_kelompok:.*}]', VproposalPengabdianController::class . ':list')->add(PermissionMiddleware::class)->setName('vproposal_pengabdian/list-vproposal_pengabdian-list-2'); // list
        }
    );

    // vproposal_penelitian_terima
    $app->map(["GET","POST","OPTIONS"], '/vproposalpenelitianterimalist[/{Id_Kelompok:.*}]', VproposalPenelitianTerimaController::class . ':list')->add(PermissionMiddleware::class)->setName('vproposalpenelitianterimalist-vproposal_penelitian_terima-list'); // list
    $app->group(
        '/vproposal_penelitian_terima',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Id_Kelompok:.*}]', VproposalPenelitianTerimaController::class . ':list')->add(PermissionMiddleware::class)->setName('vproposal_penelitian_terima/list-vproposal_penelitian_terima-list-2'); // list
        }
    );

    // vproposal_pengabdian_diterima
    $app->map(["GET","POST","OPTIONS"], '/vproposalpengabdianditerimalist[/{Id_Kelompok:.*}]', VproposalPengabdianDiterimaController::class . ':list')->add(PermissionMiddleware::class)->setName('vproposalpengabdianditerimalist-vproposal_pengabdian_diterima-list'); // list
    $app->group(
        '/vproposal_pengabdian_diterima',
        function (RouteCollectorProxy $group) {
            $group->map(["GET","POST","OPTIONS"], '/' . Config('LIST_ACTION') . '[/{Id_Kelompok:.*}]', VproposalPengabdianDiterimaController::class . ':list')->add(PermissionMiddleware::class)->setName('vproposal_pengabdian_diterima/list-vproposal_pengabdian_diterima-list-2'); // list
        }
    );

    // personal_data
    $app->map(["GET","POST","OPTIONS"], '/personaldata', OthersController::class . ':personaldata')->add(PermissionMiddleware::class)->setName('personaldata');

    // login
    $app->map(["GET","POST","OPTIONS"], '/login[/{provider}]', OthersController::class . ':login')->add(PermissionMiddleware::class)->setName('login');

    // reset_password
    $app->map(["GET","POST","OPTIONS"], '/resetpassword', OthersController::class . ':resetpassword')->add(PermissionMiddleware::class)->setName('resetpassword');

    // change_password
    $app->map(["GET","POST","OPTIONS"], '/changepassword', OthersController::class . ':changepassword')->add(PermissionMiddleware::class)->setName('changepassword');

    // register
    $app->map(["GET","POST","OPTIONS"], '/register', OthersController::class . ':register')->add(PermissionMiddleware::class)->setName('register');

    // userpriv
    $app->map(["GET","POST","OPTIONS"], '/userpriv', OthersController::class . ':userpriv')->add(PermissionMiddleware::class)->setName('userpriv');

    // logout
    $app->map(["GET","POST","OPTIONS"], '/logout', OthersController::class . ':logout')->add(PermissionMiddleware::class)->setName('logout');

    // captcha
    $app->map(["GET","OPTIONS"], '/captcha[/{page}]', OthersController::class . ':captcha')->add(PermissionMiddleware::class)->setName('captcha');

    // Swagger
    $app->get('/' . Config("SWAGGER_ACTION"), OthersController::class . ':swagger')->setName(Config("SWAGGER_ACTION")); // Swagger

    // Index
    $app->get('/[index]', OthersController::class . ':index')->add(PermissionMiddleware::class)->setName('index');

    // Route Action event
    if (function_exists(PROJECT_NAMESPACE . "Route_Action")) {
        if (Route_Action($app) === false) {
            return;
        }
    }

    /**
     * Catch-all route to serve a 404 Not Found page if none of the routes match
     * NOTE: Make sure this route is defined last.
     */
    $app->map(
        ['GET', 'POST', 'PUT', 'DELETE', 'PATCH'],
        '/{routes:.+}',
        function ($request, $response, $params) {
            throw new HttpNotFoundException($request, str_replace("%p", $params["routes"], Container("language")->phrase("PageNotFound")));
        }
    );
};
