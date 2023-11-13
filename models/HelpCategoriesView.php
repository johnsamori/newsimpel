<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class HelpCategoriesView extends HelpCategories
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "HelpCategoriesView";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "helpcategoriesview";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $CopyUrl;
    public $ListUrl;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = RemoveXss($route->getArguments());
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        return rtrim(UrlFor($route->getName(), $args), "/") . "?";
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Set field visibility
    public function setVisibility()
    {
        $this->Category_ID->setVisibility();
        $this->_Language->setVisibility();
        $this->Category_Description->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'help_categories';
        $this->TableName = 'help_categories';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-view-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (help_categories)
        if (!isset($GLOBALS["help_categories"]) || get_class($GLOBALS["help_categories"]) == PROJECT_NAMESPACE . "help_categories") {
            $GLOBALS["help_categories"] = &$this;
        }

        // Set up record key
        if (($keyValue = Get("Category_ID") ?? Route("Category_ID")) !== null) {
            $this->RecKey["Category_ID"] = $keyValue;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'help_categories');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // Export options
        $this->ExportOptions = new ListOptions(["TagClassName" => "ew-export-option"]);

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }

        // Detail tables
        $this->OtherOptions["detail"] = new ListOptions(["TagClassName" => "ew-detail-option"]);
        // Actions
        $this->OtherOptions["action"] = new ListOptions(["TagClassName" => "ew-action-option"]);
    }

    // Get content from stream
    public function getContents(): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

        // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show response for API
                $ar = array_merge($this->getMessages(), $url ? ["url" => GetUrl($url)] : []);
                WriteJson($ar);
            }
            $this->clearMessages(); // Clear messages for API request
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }

            // Handle modal response (Assume return to modal for simplicity)
            if ($this->IsModal) { // Show as modal
                $result = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page => View page
                    $result["caption"] = $this->getModalCaption($pageName);
                    $result["view"] = $pageName == "helpcategoriesview"; // If View page, no primary button
                } else { // List page
                    // $result["list"] = $this->PageID == "search"; // Refresh List page if current page is Search page
                    $result["error"] = $this->getFailureMessage(); // List page should not be shown as modal => error
                    $this->clearFailureMessage();
                }
                WriteJson($result);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['Category_ID'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->Category_ID->Visible = false;
        }
    }

    // Lookup data
    public function lookup($ar = null)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $ar["field"] ?? Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;
        $name = $ar["name"] ?? Post("name");
        $isQuery = ContainsString($name, "query_builder_rule");
        if ($isQuery) {
            $lookup->FilterFields = []; // Skip parent fields if any
        }

        // Get lookup parameters
        $lookupType = $ar["ajax"] ?? Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $ar["q"] ?? Param("q") ?? $ar["sv"] ?? Post("sv", "");
            $pageSize = $ar["n"] ?? Param("n") ?? $ar["recperpage"] ?? Post("recperpage", 10);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $ar["q"] ?? Param("q", "");
            $pageSize = $ar["n"] ?? Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $ar["start"] ?? Param("start", -1);
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $ar["page"] ?? Param("page", -1);
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($ar["s"] ?? Post("s", ""));
        $userFilter = Decrypt($ar["f"] ?? Post("f", ""));
        $userOrderBy = Decrypt($ar["o"] ?? Post("o", ""));
        $keys = $ar["keys"] ?? Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $ar["v0"] ?? $ar["lookupValue"] ?? Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $ar["v" . $i] ?? Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, !is_array($ar)); // Use settings from current page
    }
    public $ExportOptions; // Export options
    public $OtherOptions; // Other options
    public $DisplayRecords = 1;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecKey = [];
    public $IsModal = false;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $UserProfile, $Language, $Security, $CurrentForm, $SkipHeaderFooter;

// Is modal
        $this->IsModal = ConvertToBool(Param("modal"));
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Update last accessed time
        if (!IsSysAdmin() && !$UserProfile->isValidUser(CurrentUserName(), session_id())) {
            $this->setFailureMessage($Language->phrase("UserProfileCorrupted"));
            $this->terminate('logout');
            // return;
        }

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        } else {
            $this->setExportReturnUrl(CurrentUrl());
        }
        $ExportType = $this->Export; // Get export parameter, used in header
        if ($ExportType != "") {
            global $SkipHeaderFooter;
            $SkipHeaderFooter = true;
        }
        $this->CurrentAction = Param("action"); // Set up current action
        $this->setVisibility();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Hide fields for add/edit
        if (!$this->UseAjaxActions) {
            $this->hideFieldsForAddEdit();
        }
        // Use inline delete
        if ($this->UseAjaxActions) {
            $this->InlineDelete = true;
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->_Language);
		My_Global_Check(); // Modified by Masino Sinaga, October 6, 2021

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }

        // Load current record
        $loadCurrentRecord = false;
        $returnUrl = "";
        $matchRecord = false;
        if (Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NUMBER")) !== null) {
            $loadCurrentRecord = true;
        }
        if (($keyValue = Get("Category_ID") ?? Route("Category_ID")) !== null) {
            $this->Category_ID->setQueryStringValue($keyValue);
            $this->RecKey["Category_ID"] = $this->Category_ID->QueryStringValue;
        } elseif (Post("Category_ID") !== null) {
            $this->Category_ID->setFormValue(Post("Category_ID"));
            $this->RecKey["Category_ID"] = $this->Category_ID->FormValue;
        } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
            $this->Category_ID->setQueryStringValue($keyValue);
            $this->RecKey["Category_ID"] = $this->Category_ID->QueryStringValue;
        } elseif (!$loadCurrentRecord) {
            $returnUrl = "helpcategorieslist"; // Return to list
        }

        // Get action
        $this->CurrentAction = "show"; // Display
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$this->IsModal) { // Normal view page
                    $this->StartRecord = 1; // Initialize start position
                    if ($this->Recordset = $this->loadRecordset()) { // Load records
                        $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
                    }
                    if ($this->TotalRecords <= 0) { // No record found
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $this->terminate("helpcategorieslist"); // Return to list page
                        return;
                    } elseif ($loadCurrentRecord) { // Load current record position
                        $this->setupStartRecord(); // Set up start record position
                        // Point to current record
                        if ($this->StartRecord <= $this->TotalRecords) {
                            $matchRecord = true;
                            $this->Recordset->move($this->StartRecord - 1);
                            // Redirect to correct record
                            $this->loadRowValues($this->Recordset);
                            $url = $this->getCurrentUrl(Config("TABLE_SHOW_DETAIL") . "=" . $this->getCurrentDetailTable());
                            $this->terminate($url);
                            return;
                        }
                    } else { // Match key values
                        while (!$this->Recordset->EOF) {
                            if (SameString($this->Category_ID->CurrentValue, $this->Recordset->fields['Category_ID'])) {
                                $this->setStartRecordNumber($this->StartRecord); // Save record position
                                $matchRecord = true;
                                break;
                            } else {
                                $this->StartRecord++;
                                $this->Recordset->moveNext();
                            }
                        }
                    }
                    if (!$matchRecord) {
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $returnUrl = "helpcategorieslist"; // No matching record, return to list
                    } else {
                        $this->loadRowValues($this->Recordset); // Load row values
                    }
                } else {
                    // Load record based on key
                    if (IsApi()) {
                        $filter = $this->getRecordFilter();
                        $this->CurrentFilter = $filter;
                        $sql = $this->getCurrentSql();
                        $conn = $this->getConnection();
                        $this->Recordset = LoadRecordset($sql, $conn);
                        $res = $this->Recordset && !$this->Recordset->EOF;
                    } else {
                        $res = $this->loadRow();
                    }
                    if (!$res) { // Load record based on key
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $returnUrl = "helpcategorieslist"; // No matching record, return to list
                    }
                } // End modal checking
                break;
        }

        // Setup export options
        $this->setupExportOptions();
        if ($returnUrl != "") {
            $this->terminate($returnUrl);
            return;
        }

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Render row
        $this->RowType = ROWTYPE_VIEW;
        $this->resetAttributes();
        $this->renderRow();

        // Set up detail parameters
        $this->setupDetailParms();

        // Normal return
        if (IsApi()) {
            if (!$this->isExport()) {
                $row = $this->getRecordsFromRecordset($this->Recordset, true); // Get current record only
                $this->Recordset->close();
                WriteJson(["success" => true, "action" => Config("API_VIEW_ACTION"), $this->TableVar => $row]);
                $this->terminate(true);
            }
            return;
        }

        // Set up pager
        if (!$this->IsModal) { // Normal view page
            $this->Pager = new PrevNextPager($this, $this->StartRecord, $this->DisplayRecords, $this->TotalRecords, "", $this->RecordRange, $this->AutoHidePager, false, false);
            $this->Pager->PageNumberName = Config("TABLE_PAGE_NUMBER");
            $this->Pager->PagePhraseId = "Record"; // Show as record
        }

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;

        // Disable Add/Edit/Copy/Delete for Modal and UseAjaxActions
        /*
        if ($this->IsModal && $this->UseAjaxActions) {
            $this->AddUrl = "";
            $this->EditUrl = "";
            $this->CopyUrl = "";
            $this->DeleteUrl = "";
        }
        */
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("ViewPageAddLink"));
        if ($this->IsModal) {
			$item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" data-ew-action=\"modal\" data-ask=\"1\" data-url=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        }
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();

        // Edit
        $item = &$option->add("edit");
        $editcaption = HtmlTitle($Language->phrase("ViewPageEditLink"));
        if ($this->IsModal) {
			$item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" data-ew-action=\"modal\" data-ask=\"1\" data-url=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        }
        $item->Visible = $this->EditUrl != "" && $Security->canEdit();

        // Copy
        $item = &$option->add("copy");
        $copycaption = HtmlTitle($Language->phrase("ViewPageCopyLink"));
        if ($this->IsModal) {
			$item->Body = "<a class=\"ew-action ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" data-ew-action=\"modal\" data-ask=\"1\" data-url=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\" data-btn=\"AddBtn\">" . $Language->phrase("ViewPageCopyLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("ViewPageCopyLink") . "</a>";
        }
        $item->Visible = $this->CopyUrl != "" && $Security->canAdd();

        // Delete
        $item = &$option->add("delete");
        $url = GetUrl($this->DeleteUrl);
        $item->Body = "<a class=\"ew-action ew-delete\"" .
            ($this->InlineDelete || $this->IsModal ? " data-ew-action=\"inline-delete\"" : "") .
            " title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) .
            "\" href=\"" . HtmlEncode($url) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        $item->Visible = $this->DeleteUrl != "" && $Security->canDelete();
        $option = $options["detail"];
        $detailTableLink = "";
        $detailViewTblVar = "";
        $detailCopyTblVar = "";
        $detailEditTblVar = "";

        // "detail_help"
        $item = &$option->add("detail_help");
        $body = $Language->phrase("ViewPageDetailLink") . $Language->TablePhrase("help", "TblCaption");
        $body = "<a class=\"btn btn-default ew-row-link ew-detail\" data-action=\"list\" href=\"" . HtmlEncode(GetUrl("helplist?" . Config("TABLE_SHOW_MASTER") . "=help_categories&" . GetForeignKeyUrl("fk_Category_ID", $this->Category_ID->CurrentValue) . "")) . "\">" . $body . "</a>";
        $links = "";
        $detailPageObj = Container("HelpGrid");
        if ($detailPageObj->DetailView && $Security->canView() && $Security->allowView(CurrentProjectID() . 'help_categories')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailViewLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=help"))) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            if ($detailViewTblVar != "") {
                $detailViewTblVar .= ",";
            }
            $detailViewTblVar .= "help";
        }
        if ($detailPageObj->DetailEdit && $Security->canEdit() && $Security->allowEdit(CurrentProjectID() . 'help_categories')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=help"))) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            if ($detailEditTblVar != "") {
                $detailEditTblVar .= ",";
            }
            $detailEditTblVar .= "help";
        }
        if ($detailPageObj->DetailAdd && $Security->canAdd() && $Security->allowAdd(CurrentProjectID() . 'help_categories')) {
            $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlTitle($Language->phrase("MasterDetailCopyLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=help"))) . "\">" . $Language->phrase("MasterDetailCopyLink", null) . "</a></li>";
            if ($detailCopyTblVar != "") {
                $detailCopyTblVar .= ",";
            }
            $detailCopyTblVar .= "help";
        }
        if ($links != "") {
            $body .= "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-detail\" data-bs-toggle=\"dropdown\"></button>";
            $body .= "<ul class=\"dropdown-menu\">" . $links . "</ul>";
        } else {
            $body = preg_replace('/\b\s+dropdown-toggle\b/', "", $body);
        }
        $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">" . $body . "</div>";
        $item->Body = $body;
        $item->Visible = $Security->allowList(CurrentProjectID() . 'help');
        if ($item->Visible) {
            if ($detailTableLink != "") {
                $detailTableLink .= ",";
            }
            $detailTableLink .= "help";
        }
        if ($this->ShowMultipleDetails) {
            $item->Visible = false;
        }

        // Multiple details
        if ($this->ShowMultipleDetails) {
            $body = "<div class=\"btn-group btn-group-sm ew-btn-group\">";
            $links = "";
            if ($detailViewTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-view\" data-action=\"view\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailViewLink", true)) . "\" href=\"" . HtmlEncode(GetUrl($this->getViewUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailViewTblVar))) . "\">" . $Language->phrase("MasterDetailViewLink", null) . "</a></li>";
            }
            if ($detailEditTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-edit\" data-action=\"edit\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailEditLink", true)) . "\" href=\"" . HtmlEncode(GetUrl($this->getEditUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailEditTblVar))) . "\">" . $Language->phrase("MasterDetailEditLink", null) . "</a></li>";
            }
            if ($detailCopyTblVar != "") {
                $links .= "<li><a class=\"dropdown-item ew-row-link ew-detail-copy\" data-action=\"add\" data-caption=\"" . HtmlEncode($Language->phrase("MasterDetailCopyLink", true)) . "\" href=\"" . HtmlEncode(GetUrl($this->getCopyUrl(Config("TABLE_SHOW_DETAIL") . "=" . $detailCopyTblVar))) . "\">" . $Language->phrase("MasterDetailCopyLink", null) . "</a></li>";
            }
            if ($links != "") {
                $body .= "<button type=\"button\" class=\"dropdown-toggle btn btn-default ew-master-detail\" title=\"" . HtmlEncode($Language->phrase("MultipleMasterDetails", true)) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("MultipleMasterDetails") . "</button>";
                $body .= "<ul class=\"dropdown-menu ew-dropdown-menu\">" . $links . "</ul>";
            }
            $body .= "</div>";
            // Multiple details
            $item = &$option->add("details");
            $item->Body = $body;
        }

        // Set up detail default
        $option = $options["detail"];
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $ar = explode(",", $detailTableLink);
        $cnt = count($ar);
        $option->UseDropDownButton = ($cnt > 1);
        $option->UseButtonGroup = true;
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Set up action default
        $option = $options["action"];
        $option->DropDownButtonPhrase = $Language->phrase("ButtonActions");
        $option->UseDropDownButton = !IsJsonResponse() && true;
        $option->UseButtonGroup = true;
        $item = &$option->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
    }

// Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->execute();
        $rs = new Recordset($result, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
    }

    // Load records as associative array
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->execute();
        return $result->fetchAllAssociative();
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }
        if (!$row) {
            return;
        }

        // Call Row Selected event
        $this->rowSelected($row);
        $this->Category_ID->setDbValue($row['Category_ID']);
        $this->_Language->setDbValue($row['Language']);
        $this->Category_Description->setDbValue($row['Category_Description']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Category_ID'] = $this->Category_ID->DefaultValue;
        $row['Language'] = $this->_Language->DefaultValue;
        $row['Category_Description'] = $this->Category_Description->DefaultValue;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->AddUrl = $this->getAddUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();
        $this->ListUrl = $this->getListUrl();
        $this->setupOtherOptions();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // Category_ID

        // Language

        // Category_Description

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // Category_ID
            $this->Category_ID->ViewValue = $this->Category_ID->CurrentValue;

            // Language
            $curVal = strval($this->_Language->CurrentValue);
            if ($curVal != "") {
                $this->_Language->ViewValue = $this->_Language->lookupCacheOption($curVal);
                if ($this->_Language->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`Language_Code`", "=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->_Language->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->_Language->Lookup->renderViewRow($rswrk[0]);
                        $this->_Language->ViewValue = $this->_Language->displayValue($arwrk);
                    } else {
                        $this->_Language->ViewValue = $this->_Language->CurrentValue;
                    }
                }
            } else {
                $this->_Language->ViewValue = null;
            }

            // Category_Description
            $this->Category_Description->ViewValue = $this->Category_Description->CurrentValue;

            // Category_ID
            $this->Category_ID->HrefValue = "";
            $this->Category_ID->TooltipValue = "";

            // Language
            $this->_Language->HrefValue = "";
            $this->_Language->TooltipValue = "";

            // Category_Description
            $this->Category_Description->HrefValue = "";
            $this->Category_Description->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;

        // if ($type == "print" || $custom) {
        //    $pageUrl = $this->pageUrl(true); // removed by Masino Sinaga, Sept 27, 2022 ... Printer Friendly (print) using API EXPORT ACTION, too!

        //    $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : "")); // removed by Masino Sinaga, Sept 27, 2022 ... Printer Friendly (print) using API EXPORT ACTION, too!
        // } else {
            //$query = "key=" . $this->getKey(true);

            //$exportUrl = GetApiUrl(Config("API_EXPORT_ACTION") . "/" . $type . "/" . $this->TableVar, $query);
        // } // removed by Masino Sinaga, Sept 27, 2022 ... Printer Friendly (print) using API EXPORT ACTION, too!

		// Begin of modification, moved to Client-Side into masinoew.js file, by Masino Sinaga, September 27, 2022
		$exportUrl = GetApiUrl(Config("API_EXPORT_ACTION") . "/" . $type . "/" . $this->TableVar);
        $exportUrl .= "?" . Config("API_KEY_NAME") . "=" . $this->getKey(true);
		// End of modification, moved to Client-Side into masinoew.js file, by Masino Sinaga, September 27, 2022
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" form=\"fhelp_categoriesview\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcel", true)) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" form=\"fhelp_categoriesview\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWord", true)) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" form=\"fhelp_categoriesview\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdf", true)) . "\">" . $Language->phrase("ExportToPdf") . "</a>";
            }
        } elseif (SameText($type, "html")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-html\" title=\"" . HtmlEncode($Language->phrase("ExportToHtml", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToHtml", true)) . "\">" . $Language->phrase("ExportToHtml") . "</a>";
        } elseif (SameText($type, "xml")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-xml\" title=\"" . HtmlEncode($Language->phrase("ExportToXml", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToXml", true)) . "\">" . $Language->phrase("ExportToXml") . "</a>";
        } elseif (SameText($type, "csv")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-csv\" title=\"" . HtmlEncode($Language->phrase("ExportToCsv", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToCsv", true)) . "\">" . $Language->phrase("ExportToCsv") . "</a>";
        } elseif (SameText($type, "email")) {
            $url = $custom ? ' data-url="' . $exportUrl . '"' : '';
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmail", true) . '" data-caption="' . $Language->phrase("ExportToEmail", true) . '" form="fhelp_categoriesview" data-ew-action="email" data-hdr="' . $Language->phrase("ExportToEmail", true) . '" data-key="' . HtmlEncode(ArrayToJsonAttribute($this->RecKey)) . '" data-exported-selected="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\" data-caption=\"" . HtmlEncode($Language->phrase("PrinterFriendly", true)) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language, $Security;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        if (MS_ENABLE_PERMISSION_FOR_EXPORT_DATA == TRUE) { // customized by Masino Sinaga, September 25, 2020
			$item->Visible = $Security->canExportToPrint();
		} else {
			$item->Visible = true;
		}

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        if (MS_ENABLE_PERMISSION_FOR_EXPORT_DATA == TRUE) { // customized by Masino Sinaga, September 25, 2020
			$item->Visible = $Security->canExportToExcel();
		} else {
			$item->Visible = true;
		}

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        if (MS_ENABLE_PERMISSION_FOR_EXPORT_DATA == TRUE) { // customized by Masino Sinaga, September 25, 2020
			$item->Visible = $Security->canExportToWord();
		} else {
			$item->Visible = true;
		}

        // Export to HTML
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html");
        if (MS_ENABLE_PERMISSION_FOR_EXPORT_DATA == TRUE) { // customized by Masino Sinaga, September 25, 2020
			$item->Visible = $Security->canExportToHTML();
		} else {
			$item->Visible = true;
		}

        // Export to XML
        $item = &$this->ExportOptions->add("xml");
        $item->Body = $this->getExportTag("xml");
        if (MS_ENABLE_PERMISSION_FOR_EXPORT_DATA == TRUE) { // customized by Masino Sinaga, September 25, 2020
			$item->Visible = $Security->canExportToXML();
		} else {
			$item->Visible = true;
		}

        // Export to CSV
        $item = &$this->ExportOptions->add("csv");
        $item->Body = $this->getExportTag("csv");
        if (MS_ENABLE_PERMISSION_FOR_EXPORT_DATA == TRUE) { // customized by Masino Sinaga, September 25, 2020
			$item->Visible = $Security->canExportToCSV();
		} else {
			$item->Visible = true;
		}

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        if (MS_ENABLE_PERMISSION_FOR_EXPORT_DATA == TRUE) { // customized by Masino Sinaga, September 25, 2020
			$item->Visible = $Security->canExportToPDF();
		} else {
			$item->Visible = true;
		}

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        if (MS_ENABLE_PERMISSION_FOR_EXPORT_DATA == TRUE) { // customized by Masino Sinaga, September 25, 2020
			$item->Visible = $Security->canExportToEmail();
		} else {
			$item->Visible = true;
		}

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = true;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide options for export
        if ($this->isExport()) {
            $this->ExportOptions->hideAllOptions();
        }

        // Hide options if json response
        if (IsJsonResponse()) {
            $this->ExportOptions->hideAllOptions();
        }
        if (!$Security->canExport()) { // Export not allowed
            $this->ExportOptions->hideAllOptions();
        }
    }

    /**
    * Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
    *
    * @param bool $return Return the data rather than output it
    * @return mixed
    */
    public function exportData($doc, $keys)
    {
        global $Language;
        $utf8 = SameText(Config("PROJECT_CHARSET"), "utf-8");

        // Load recordset
        $rs = null;
        if (count($keys) >= 1) {
            $this->Category_ID->OldValue = $keys[0];
            $rsview = $this->loadRs($this->getRecordFilter());
            if ($rsview) {
                $rs = new Recordset($rsview);
            }
        }
        if (!$rs || !$doc) {
            RemoveHeader("Content-Type"); // Remove header
            RemoveHeader("Content-Disposition");
            $this->showMessage();
            return;
        }
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords;

        // Call Page Exporting server event
        $doc->ExportCustom = !$this->pageExporting($doc);

        // Page header
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        $doc->Text .= $header;
        $this->exportDocument($doc, $rs, $this->StartRecord, $this->StopRecord, "view");

        // Export detail records (help)
        if (Config("EXPORT_DETAIL_RECORDS") && in_array("help", explode(",", $this->getCurrentDetailTable()))) {
            $help = new HelpList();
            $rsdetail = $help->loadRs($help->getDetailFilterFromSession(), $help->getSessionOrderBy()); // Load detail records
            if ($rsdetail) {
                $exportStyle = $doc->Style;
                $doc->setStyle("h"); // Change to horizontal
                if (!$this->isExport("csv") || Config("EXPORT_DETAIL_RECORDS_FOR_CSV")) {
                    $doc->exportEmptyRow();
                    $detailcnt = $rsdetail->rowCount();
                    $oldtbl = $doc->getTable();
                    $doc->setTable($help);
                    $help->exportDocument($doc, new Recordset($rsdetail), 1, $detailcnt);
                    $doc->setTable($oldtbl);
                }
                $doc->setStyle($exportStyle); // Restore
            }
        }

        // Close recordset
        $rs->close();

        // Page footer
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        $doc->Text .= $footer;

        // Export header and footer
        $doc->exportHeaderAndFooter();

        // Call Page Exported server event
        $this->pageExported($doc);
    }

    // Set up detail parms based on QueryString
    protected function setupDetailParms()
    {
        // Get the keys for master table
        $detailTblVar = Get(Config("TABLE_SHOW_DETAIL"));
        if ($detailTblVar !== null) {
            $this->setCurrentDetailTable($detailTblVar);
        } else {
            $detailTblVar = $this->getCurrentDetailTable();
        }
        if ($detailTblVar != "") {
            $detailTblVar = explode(",", $detailTblVar);
            if (in_array("help", $detailTblVar)) {
                $detailPageObj = Container("HelpGrid");
                if ($detailPageObj->DetailView) {
                    $detailPageObj->EventCancelled = $this->EventCancelled;
                    $detailPageObj->CurrentMode = "view";

                    // Save current master table to detail table
                    $detailPageObj->setCurrentMasterTable($this->TableVar);
                    $detailPageObj->setStartRecordNumber(1);
                    $detailPageObj->Category->IsDetailKey = true;
                    $detailPageObj->Category->CurrentValue = $this->Category_ID->CurrentValue;
                    $detailPageObj->Category->setSessionValue($detailPageObj->Category->CurrentValue);
                }
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("helpcategorieslist"), "", $this->TableVar, true);
        $pageId = "view";
        $Breadcrumb->add("view", $pageId, $url);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x__Language":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0 && count($fld->Lookup->FilterFields) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $key = $row["lf"];
                    if (IsFloatType($fld->Type)) { // Handle float field
                        $key = (float)$key;
                    }
                    $ar[strval($key)] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        $pageNo = Get(Config("TABLE_PAGE_NUMBER"));
        $startRec = Get(Config("TABLE_START_REC"));
        $infiniteScroll = false;
        $recordNo = $pageNo ?? $startRec; // Record number = page number or start record
        if ($recordNo !== null && is_numeric($recordNo)) {
            $this->StartRecord = $recordNo;
        } else {
            $this->StartRecord = $this->getStartRecordNumber();
        }

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || intval($this->StartRecord) <= 0) { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
        }
        if (!$infiniteScroll) {
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Get page count
    public function pageCount() {
        return ceil($this->TotalRecords / $this->DisplayRecords);
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
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

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Page Breaking event
    public function pageBreaking(&$break, &$content)
    {
        // Example:
        //$break = false; // Skip page break, or
        //$content = "<div style=\"break-after:page;\"></div>"; // Modify page break content
    }

    // Page Exporting event
    // $doc = export object
    public function pageExporting(&$doc)
    {
        //$doc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $doc = export document object
    public function rowExport($doc, $rs)
    {
        //$doc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $doc = export document object
    public function pageExported($doc)
    {
        //$doc->Text .= "my footer"; // Export footer
        //Log($doc->Text);
    }
}
