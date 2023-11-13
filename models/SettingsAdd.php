<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class SettingsAdd extends Settings
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "SettingsAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "settingsadd";

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
        $this->Option_ID->Visible = false;
        $this->Option_Default->setVisibility();
        $this->Show_Announcement->setVisibility();
        $this->Use_Announcement_Table->setVisibility();
        $this->Maintenance_Mode->setVisibility();
        $this->Maintenance_Finish_DateTime->setVisibility();
        $this->Auto_Normal_After_Maintenance->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'settings';
        $this->TableName = 'settings';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (settings)
        if (!isset($GLOBALS["settings"]) || get_class($GLOBALS["settings"]) == PROJECT_NAMESPACE . "settings") {
            $GLOBALS["settings"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'settings');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] ??= $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
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
                    $result["view"] = $pageName == "settingsview"; // If View page, no primary button
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
            $key .= @$ar['Option_ID'];
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
            $this->Option_ID->Visible = false;
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
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $CopyRecord;

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

        // Create form object
        $CurrentForm = new HttpForm();
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
        $this->setupLookupOptions($this->Option_Default);
        $this->setupLookupOptions($this->Show_Announcement);
        $this->setupLookupOptions($this->Use_Announcement_Table);
        $this->setupLookupOptions($this->Maintenance_Mode);
        $this->setupLookupOptions($this->Auto_Normal_After_Maintenance);

        // Load default values for add
        $this->loadDefaultValues();
		My_Global_Check(); // Modified by Masino Sinaga, October 6, 2021

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action", "") !== "") {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("Option_ID") ?? Route("Option_ID")) !== null) {
                $this->Option_ID->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
                $this->setKey($this->OldKey); // Set up record key
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record or default values
        $rsold = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$rsold) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("settingslist"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($rsold)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "settingslist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "settingsview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "settingslist") {
                            Container("flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "settingslist"; // Return list page content
                        }
                    }
                    if (IsJsonResponse()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->IsModal && $this->UseAjaxActions) { // Return JSON error message
                    WriteJson([ "success" => false, "validation" => $this->getValidationErrors(), "error" => $this->getFailureMessage() ]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

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

// Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->Option_Default->DefaultValue = $this->Option_Default->getDefault(); // PHP
        $this->Option_Default->OldValue = $this->Option_Default->DefaultValue;
        $this->Show_Announcement->DefaultValue = $this->Show_Announcement->getDefault(); // PHP
        $this->Show_Announcement->OldValue = $this->Show_Announcement->DefaultValue;
        $this->Use_Announcement_Table->DefaultValue = $this->Use_Announcement_Table->getDefault(); // PHP
        $this->Use_Announcement_Table->OldValue = $this->Use_Announcement_Table->DefaultValue;
        $this->Maintenance_Mode->DefaultValue = $this->Maintenance_Mode->getDefault(); // PHP
        $this->Maintenance_Mode->OldValue = $this->Maintenance_Mode->DefaultValue;
        $this->Auto_Normal_After_Maintenance->DefaultValue = $this->Auto_Normal_After_Maintenance->getDefault(); // PHP
        $this->Auto_Normal_After_Maintenance->OldValue = $this->Auto_Normal_After_Maintenance->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'Option_Default' first before field var 'x_Option_Default'
        $val = $CurrentForm->hasValue("Option_Default") ? $CurrentForm->getValue("Option_Default") : $CurrentForm->getValue("x_Option_Default");
        if (!$this->Option_Default->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Option_Default->Visible = false; // Disable update for API request
            } else {
                $this->Option_Default->setFormValue($val);
            }
        }

        // Check field name 'Show_Announcement' first before field var 'x_Show_Announcement'
        $val = $CurrentForm->hasValue("Show_Announcement") ? $CurrentForm->getValue("Show_Announcement") : $CurrentForm->getValue("x_Show_Announcement");
        if (!$this->Show_Announcement->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Show_Announcement->Visible = false; // Disable update for API request
            } else {
                $this->Show_Announcement->setFormValue($val);
            }
        }

        // Check field name 'Use_Announcement_Table' first before field var 'x_Use_Announcement_Table'
        $val = $CurrentForm->hasValue("Use_Announcement_Table") ? $CurrentForm->getValue("Use_Announcement_Table") : $CurrentForm->getValue("x_Use_Announcement_Table");
        if (!$this->Use_Announcement_Table->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Use_Announcement_Table->Visible = false; // Disable update for API request
            } else {
                $this->Use_Announcement_Table->setFormValue($val);
            }
        }

        // Check field name 'Maintenance_Mode' first before field var 'x_Maintenance_Mode'
        $val = $CurrentForm->hasValue("Maintenance_Mode") ? $CurrentForm->getValue("Maintenance_Mode") : $CurrentForm->getValue("x_Maintenance_Mode");
        if (!$this->Maintenance_Mode->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Maintenance_Mode->Visible = false; // Disable update for API request
            } else {
                $this->Maintenance_Mode->setFormValue($val);
            }
        }

        // Check field name 'Maintenance_Finish_DateTime' first before field var 'x_Maintenance_Finish_DateTime'
        $val = $CurrentForm->hasValue("Maintenance_Finish_DateTime") ? $CurrentForm->getValue("Maintenance_Finish_DateTime") : $CurrentForm->getValue("x_Maintenance_Finish_DateTime");
        if (!$this->Maintenance_Finish_DateTime->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Maintenance_Finish_DateTime->Visible = false; // Disable update for API request
            } else {
                $this->Maintenance_Finish_DateTime->setFormValue($val, true, $validate);
            }
            $this->Maintenance_Finish_DateTime->CurrentValue = UnFormatDateTime($this->Maintenance_Finish_DateTime->CurrentValue, $this->Maintenance_Finish_DateTime->formatPattern());
        }

        // Check field name 'Auto_Normal_After_Maintenance' first before field var 'x_Auto_Normal_After_Maintenance'
        $val = $CurrentForm->hasValue("Auto_Normal_After_Maintenance") ? $CurrentForm->getValue("Auto_Normal_After_Maintenance") : $CurrentForm->getValue("x_Auto_Normal_After_Maintenance");
        if (!$this->Auto_Normal_After_Maintenance->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Auto_Normal_After_Maintenance->Visible = false; // Disable update for API request
            } else {
                $this->Auto_Normal_After_Maintenance->setFormValue($val);
            }
        }

        // Check field name 'Option_ID' first before field var 'x_Option_ID'
        $val = $CurrentForm->hasValue("Option_ID") ? $CurrentForm->getValue("Option_ID") : $CurrentForm->getValue("x_Option_ID");
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Option_Default->CurrentValue = $this->Option_Default->FormValue;
        $this->Show_Announcement->CurrentValue = $this->Show_Announcement->FormValue;
        $this->Use_Announcement_Table->CurrentValue = $this->Use_Announcement_Table->FormValue;
        $this->Maintenance_Mode->CurrentValue = $this->Maintenance_Mode->FormValue;
        $this->Maintenance_Finish_DateTime->CurrentValue = $this->Maintenance_Finish_DateTime->FormValue;
        $this->Maintenance_Finish_DateTime->CurrentValue = UnFormatDateTime($this->Maintenance_Finish_DateTime->CurrentValue, $this->Maintenance_Finish_DateTime->formatPattern());
        $this->Auto_Normal_After_Maintenance->CurrentValue = $this->Auto_Normal_After_Maintenance->FormValue;
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
        $this->Option_ID->setDbValue($row['Option_ID']);
        $this->Option_Default->setDbValue($row['Option_Default']);
        $this->Show_Announcement->setDbValue($row['Show_Announcement']);
        $this->Use_Announcement_Table->setDbValue($row['Use_Announcement_Table']);
        $this->Maintenance_Mode->setDbValue($row['Maintenance_Mode']);
        $this->Maintenance_Finish_DateTime->setDbValue($row['Maintenance_Finish_DateTime']);
        $this->Auto_Normal_After_Maintenance->setDbValue($row['Auto_Normal_After_Maintenance']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Option_ID'] = $this->Option_ID->DefaultValue;
        $row['Option_Default'] = $this->Option_Default->DefaultValue;
        $row['Show_Announcement'] = $this->Show_Announcement->DefaultValue;
        $row['Use_Announcement_Table'] = $this->Use_Announcement_Table->DefaultValue;
        $row['Maintenance_Mode'] = $this->Maintenance_Mode->DefaultValue;
        $row['Maintenance_Finish_DateTime'] = $this->Maintenance_Finish_DateTime->DefaultValue;
        $row['Auto_Normal_After_Maintenance'] = $this->Auto_Normal_After_Maintenance->DefaultValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        if ($this->OldKey != "") {
            $this->setKey($this->OldKey);
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = LoadRecordset($sql, $conn);
            if ($rs && ($row = $rs->fields)) {
                $this->loadRowValues($row); // Load row values
                return $row;
            }
        }
        $this->loadRowValues(); // Load default row values
        return null;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // Option_ID
        $this->Option_ID->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Option_Default
        $this->Option_Default->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Show_Announcement
        $this->Show_Announcement->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Use_Announcement_Table
        $this->Use_Announcement_Table->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Maintenance_Mode
        $this->Maintenance_Mode->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Maintenance_Finish_DateTime
        $this->Maintenance_Finish_DateTime->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Auto_Normal_After_Maintenance
        $this->Auto_Normal_After_Maintenance->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // Option_ID
            $this->Option_ID->ViewValue = $this->Option_ID->CurrentValue;

            // Option_Default
            if (ConvertToBool($this->Option_Default->CurrentValue)) {
                $this->Option_Default->ViewValue = $this->Option_Default->tagCaption(1) != "" ? $this->Option_Default->tagCaption(1) : "Y";
            } else {
                $this->Option_Default->ViewValue = $this->Option_Default->tagCaption(2) != "" ? $this->Option_Default->tagCaption(2) : "N";
            }

            // Show_Announcement
            if (ConvertToBool($this->Show_Announcement->CurrentValue)) {
                $this->Show_Announcement->ViewValue = $this->Show_Announcement->tagCaption(1) != "" ? $this->Show_Announcement->tagCaption(1) : "Y";
            } else {
                $this->Show_Announcement->ViewValue = $this->Show_Announcement->tagCaption(2) != "" ? $this->Show_Announcement->tagCaption(2) : "N";
            }

            // Use_Announcement_Table
            if (ConvertToBool($this->Use_Announcement_Table->CurrentValue)) {
                $this->Use_Announcement_Table->ViewValue = $this->Use_Announcement_Table->tagCaption(2) != "" ? $this->Use_Announcement_Table->tagCaption(2) : "Y";
            } else {
                $this->Use_Announcement_Table->ViewValue = $this->Use_Announcement_Table->tagCaption(1) != "" ? $this->Use_Announcement_Table->tagCaption(1) : "N";
            }

            // Maintenance_Mode
            if (ConvertToBool($this->Maintenance_Mode->CurrentValue)) {
                $this->Maintenance_Mode->ViewValue = $this->Maintenance_Mode->tagCaption(2) != "" ? $this->Maintenance_Mode->tagCaption(2) : "Y";
            } else {
                $this->Maintenance_Mode->ViewValue = $this->Maintenance_Mode->tagCaption(1) != "" ? $this->Maintenance_Mode->tagCaption(1) : "N";
            }

            // Maintenance_Finish_DateTime
            $this->Maintenance_Finish_DateTime->ViewValue = $this->Maintenance_Finish_DateTime->CurrentValue;
            $this->Maintenance_Finish_DateTime->ViewValue = FormatDateTime($this->Maintenance_Finish_DateTime->ViewValue, $this->Maintenance_Finish_DateTime->formatPattern());

            // Auto_Normal_After_Maintenance
            if (ConvertToBool($this->Auto_Normal_After_Maintenance->CurrentValue)) {
                $this->Auto_Normal_After_Maintenance->ViewValue = $this->Auto_Normal_After_Maintenance->tagCaption(1) != "" ? $this->Auto_Normal_After_Maintenance->tagCaption(1) : "Y";
            } else {
                $this->Auto_Normal_After_Maintenance->ViewValue = $this->Auto_Normal_After_Maintenance->tagCaption(2) != "" ? $this->Auto_Normal_After_Maintenance->tagCaption(2) : "N";
            }

            // Option_Default
            $this->Option_Default->HrefValue = "";

            // Show_Announcement
            $this->Show_Announcement->HrefValue = "";

            // Use_Announcement_Table
            $this->Use_Announcement_Table->HrefValue = "";

            // Maintenance_Mode
            $this->Maintenance_Mode->HrefValue = "";

            // Maintenance_Finish_DateTime
            $this->Maintenance_Finish_DateTime->HrefValue = "";

            // Auto_Normal_After_Maintenance
            $this->Auto_Normal_After_Maintenance->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // Option_Default
            $this->Option_Default->EditValue = $this->Option_Default->options(false);
            $this->Option_Default->PlaceHolder = RemoveHtml($this->Option_Default->caption());

            // Show_Announcement
            $this->Show_Announcement->EditValue = $this->Show_Announcement->options(false);
            $this->Show_Announcement->PlaceHolder = RemoveHtml($this->Show_Announcement->caption());

            // Use_Announcement_Table
            $this->Use_Announcement_Table->EditValue = $this->Use_Announcement_Table->options(false);
            $this->Use_Announcement_Table->PlaceHolder = RemoveHtml($this->Use_Announcement_Table->caption());

            // Maintenance_Mode
            $this->Maintenance_Mode->EditValue = $this->Maintenance_Mode->options(false);
            $this->Maintenance_Mode->PlaceHolder = RemoveHtml($this->Maintenance_Mode->caption());

            // Maintenance_Finish_DateTime
            $this->Maintenance_Finish_DateTime->setupEditAttributes();
            $this->Maintenance_Finish_DateTime->EditValue = HtmlEncode(FormatDateTime($this->Maintenance_Finish_DateTime->CurrentValue, $this->Maintenance_Finish_DateTime->formatPattern()));
            $this->Maintenance_Finish_DateTime->PlaceHolder = RemoveHtml($this->Maintenance_Finish_DateTime->caption());

            // Auto_Normal_After_Maintenance
            $this->Auto_Normal_After_Maintenance->EditValue = $this->Auto_Normal_After_Maintenance->options(false);
            $this->Auto_Normal_After_Maintenance->PlaceHolder = RemoveHtml($this->Auto_Normal_After_Maintenance->caption());

            // Add refer script

            // Option_Default
            $this->Option_Default->HrefValue = "";

            // Show_Announcement
            $this->Show_Announcement->HrefValue = "";

            // Use_Announcement_Table
            $this->Use_Announcement_Table->HrefValue = "";

            // Maintenance_Mode
            $this->Maintenance_Mode->HrefValue = "";

            // Maintenance_Finish_DateTime
            $this->Maintenance_Finish_DateTime->HrefValue = "";

            // Auto_Normal_After_Maintenance
            $this->Auto_Normal_After_Maintenance->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language, $Security;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
        if ($this->Option_Default->Required) {
            if ($this->Option_Default->FormValue == "") {
                $this->Option_Default->addErrorMessage(str_replace("%s", $this->Option_Default->caption(), $this->Option_Default->RequiredErrorMessage));
            }
        }
        if ($this->Show_Announcement->Required) {
            if ($this->Show_Announcement->FormValue == "") {
                $this->Show_Announcement->addErrorMessage(str_replace("%s", $this->Show_Announcement->caption(), $this->Show_Announcement->RequiredErrorMessage));
            }
        }
        if ($this->Use_Announcement_Table->Required) {
            if ($this->Use_Announcement_Table->FormValue == "") {
                $this->Use_Announcement_Table->addErrorMessage(str_replace("%s", $this->Use_Announcement_Table->caption(), $this->Use_Announcement_Table->RequiredErrorMessage));
            }
        }
        if ($this->Maintenance_Mode->Required) {
            if ($this->Maintenance_Mode->FormValue == "") {
                $this->Maintenance_Mode->addErrorMessage(str_replace("%s", $this->Maintenance_Mode->caption(), $this->Maintenance_Mode->RequiredErrorMessage));
            }
        }
        if ($this->Maintenance_Finish_DateTime->Required) {
            if (!$this->Maintenance_Finish_DateTime->IsDetailKey && EmptyValue($this->Maintenance_Finish_DateTime->FormValue)) {
                $this->Maintenance_Finish_DateTime->addErrorMessage(str_replace("%s", $this->Maintenance_Finish_DateTime->caption(), $this->Maintenance_Finish_DateTime->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->Maintenance_Finish_DateTime->FormValue, $this->Maintenance_Finish_DateTime->formatPattern())) {
            $this->Maintenance_Finish_DateTime->addErrorMessage($this->Maintenance_Finish_DateTime->getErrorMessage(false));
        }
        if ($this->Auto_Normal_After_Maintenance->Required) {
            if ($this->Auto_Normal_After_Maintenance->FormValue == "") {
                $this->Auto_Normal_After_Maintenance->addErrorMessage(str_replace("%s", $this->Auto_Normal_After_Maintenance->caption(), $this->Auto_Normal_After_Maintenance->RequiredErrorMessage));
            }
        }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;

        // Set new row
        $rsnew = [];

        // Option_Default
        $tmpBool = $this->Option_Default->CurrentValue;
        if ($tmpBool != "Y" && $tmpBool != "N") {
            $tmpBool = !empty($tmpBool) ? "Y" : "N";
        }
        $this->Option_Default->setDbValueDef($rsnew, $tmpBool, strval($this->Option_Default->CurrentValue) == "");

        // Show_Announcement
        $tmpBool = $this->Show_Announcement->CurrentValue;
        if ($tmpBool != "Y" && $tmpBool != "N") {
            $tmpBool = !empty($tmpBool) ? "Y" : "N";
        }
        $this->Show_Announcement->setDbValueDef($rsnew, $tmpBool, strval($this->Show_Announcement->CurrentValue) == "");

        // Use_Announcement_Table
        $tmpBool = $this->Use_Announcement_Table->CurrentValue;
        if ($tmpBool != "Y" && $tmpBool != "N") {
            $tmpBool = !empty($tmpBool) ? "Y" : "N";
        }
        $this->Use_Announcement_Table->setDbValueDef($rsnew, $tmpBool, strval($this->Use_Announcement_Table->CurrentValue) == "");

        // Maintenance_Mode
        $tmpBool = $this->Maintenance_Mode->CurrentValue;
        if ($tmpBool != "Y" && $tmpBool != "N") {
            $tmpBool = !empty($tmpBool) ? "Y" : "N";
        }
        $this->Maintenance_Mode->setDbValueDef($rsnew, $tmpBool, strval($this->Maintenance_Mode->CurrentValue) == "");

        // Maintenance_Finish_DateTime
        $this->Maintenance_Finish_DateTime->setDbValueDef($rsnew, UnFormatDateTime($this->Maintenance_Finish_DateTime->CurrentValue, $this->Maintenance_Finish_DateTime->formatPattern()), false);

        // Auto_Normal_After_Maintenance
        $tmpBool = $this->Auto_Normal_After_Maintenance->CurrentValue;
        if ($tmpBool != "Y" && $tmpBool != "N") {
            $tmpBool = !empty($tmpBool) ? "Y" : "N";
        }
        $this->Auto_Normal_After_Maintenance->setDbValueDef($rsnew, $tmpBool, strval($this->Auto_Normal_After_Maintenance->CurrentValue) == "");

        // Update current values
        $this->setCurrentValues($rsnew);
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
            } elseif (!EmptyValue($this->DbErrorMessage)) { // Show database error
                $this->setFailureMessage($this->DbErrorMessage);
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_ADD_ACTION"), $table => $row]);
        }
        return $addRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("settingslist"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
                case "x_Option_Default":
                    break;
                case "x_Show_Announcement":
                    break;
                case "x_Use_Announcement_Table":
                    break;
                case "x_Maintenance_Mode":
                    break;
                case "x_Auto_Normal_After_Maintenance":
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
