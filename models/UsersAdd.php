<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class UsersAdd extends Users
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "UsersAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "usersadd";

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
        $this->_Username->setVisibility();
        $this->_Password->setVisibility();
        $this->First_Name->setVisibility();
        $this->Last_Name->setVisibility();
        $this->_Email->setVisibility();
        $this->User_Level->setVisibility();
        $this->Report_To->setVisibility();
        $this->Activated->setVisibility();
        $this->Locked->setVisibility();
        $this->_Profile->Visible = false;
        $this->Photo->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'users';
        $this->TableName = 'users';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (users)
        if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == PROJECT_NAMESPACE . "users") {
            $GLOBALS["users"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'users');
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
                    $result["view"] = $pageName == "usersview"; // If View page, no primary button
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
            $key .= @$ar['Username'];
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
        $this->setupLookupOptions($this->User_Level);
        $this->setupLookupOptions($this->Activated);
        $this->setupLookupOptions($this->Locked);

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
            if (($keyValue = Get("_Username") ?? Route("_Username")) !== null) {
                $this->_Username->setQueryStringValue($keyValue);
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
                    $this->terminate("userslist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "userslist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "usersview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "userslist") {
                            Container("flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "userslist"; // Return list page content
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
        $this->Photo->Upload->Index = $CurrentForm->Index;
        $this->Photo->Upload->uploadFile();
        $this->Photo->CurrentValue = $this->Photo->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->Activated->DefaultValue = $this->Activated->getDefault(); // PHP
        $this->Activated->OldValue = $this->Activated->DefaultValue;
        $this->Locked->DefaultValue = $this->Locked->getDefault(); // PHP
        $this->Locked->OldValue = $this->Locked->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'Username' first before field var 'x__Username'
        $val = $CurrentForm->hasValue("Username") ? $CurrentForm->getValue("Username") : $CurrentForm->getValue("x__Username");
        if (!$this->_Username->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_Username->Visible = false; // Disable update for API request
            } else {
                $this->_Username->setFormValue($val);
            }
        }

        // Check field name 'Password' first before field var 'x__Password'
        $val = $CurrentForm->hasValue("Password") ? $CurrentForm->getValue("Password") : $CurrentForm->getValue("x__Password");
        if (!$this->_Password->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_Password->Visible = false; // Disable update for API request
            } else {
                $this->_Password->setFormValue($val);
            }
        }

        // Check field name 'First_Name' first before field var 'x_First_Name'
        $val = $CurrentForm->hasValue("First_Name") ? $CurrentForm->getValue("First_Name") : $CurrentForm->getValue("x_First_Name");
        if (!$this->First_Name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->First_Name->Visible = false; // Disable update for API request
            } else {
                $this->First_Name->setFormValue($val);
            }
        }

        // Check field name 'Last_Name' first before field var 'x_Last_Name'
        $val = $CurrentForm->hasValue("Last_Name") ? $CurrentForm->getValue("Last_Name") : $CurrentForm->getValue("x_Last_Name");
        if (!$this->Last_Name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Last_Name->Visible = false; // Disable update for API request
            } else {
                $this->Last_Name->setFormValue($val);
            }
        }

        // Check field name 'Email' first before field var 'x__Email'
        $val = $CurrentForm->hasValue("Email") ? $CurrentForm->getValue("Email") : $CurrentForm->getValue("x__Email");
        if (!$this->_Email->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_Email->Visible = false; // Disable update for API request
            } else {
                $this->_Email->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'User_Level' first before field var 'x_User_Level'
        $val = $CurrentForm->hasValue("User_Level") ? $CurrentForm->getValue("User_Level") : $CurrentForm->getValue("x_User_Level");
        if (!$this->User_Level->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->User_Level->Visible = false; // Disable update for API request
            } else {
                $this->User_Level->setFormValue($val);
            }
        }

        // Check field name 'Report_To' first before field var 'x_Report_To'
        $val = $CurrentForm->hasValue("Report_To") ? $CurrentForm->getValue("Report_To") : $CurrentForm->getValue("x_Report_To");
        if (!$this->Report_To->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Report_To->Visible = false; // Disable update for API request
            } else {
                $this->Report_To->setFormValue($val);
            }
        }

        // Check field name 'Activated' first before field var 'x_Activated'
        $val = $CurrentForm->hasValue("Activated") ? $CurrentForm->getValue("Activated") : $CurrentForm->getValue("x_Activated");
        if (!$this->Activated->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Activated->Visible = false; // Disable update for API request
            } else {
                $this->Activated->setFormValue($val);
            }
        }

        // Check field name 'Locked' first before field var 'x_Locked'
        $val = $CurrentForm->hasValue("Locked") ? $CurrentForm->getValue("Locked") : $CurrentForm->getValue("x_Locked");
        if (!$this->Locked->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Locked->Visible = false; // Disable update for API request
            } else {
                $this->Locked->setFormValue($val);
            }
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->_Username->CurrentValue = $this->_Username->FormValue;
        $this->_Password->CurrentValue = $this->_Password->FormValue;
        $this->First_Name->CurrentValue = $this->First_Name->FormValue;
        $this->Last_Name->CurrentValue = $this->Last_Name->FormValue;
        $this->_Email->CurrentValue = $this->_Email->FormValue;
        $this->User_Level->CurrentValue = $this->User_Level->FormValue;
        $this->Report_To->CurrentValue = $this->Report_To->FormValue;
        $this->Activated->CurrentValue = $this->Activated->FormValue;
        $this->Locked->CurrentValue = $this->Locked->FormValue;
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

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("add");
            if (!$res) {
                $userIdMsg = DeniedMessage();
                $this->setFailureMessage($userIdMsg);
            }
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
        $this->_Username->setDbValue($row['Username']);
        $this->_Password->setDbValue($row['Password']);
        $this->First_Name->setDbValue($row['First_Name']);
        $this->Last_Name->setDbValue($row['Last_Name']);
        $this->_Email->setDbValue($row['Email']);
        $this->User_Level->setDbValue($row['User_Level']);
        $this->Report_To->setDbValue($row['Report_To']);
        $this->Activated->setDbValue($row['Activated']);
        $this->Locked->setDbValue($row['Locked']);
        $this->_Profile->setDbValue($row['Profile']);
        $this->Photo->Upload->DbValue = $row['Photo'];
        $this->Photo->setDbValue($this->Photo->Upload->DbValue);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Username'] = $this->_Username->DefaultValue;
        $row['Password'] = $this->_Password->DefaultValue;
        $row['First_Name'] = $this->First_Name->DefaultValue;
        $row['Last_Name'] = $this->Last_Name->DefaultValue;
        $row['Email'] = $this->_Email->DefaultValue;
        $row['User_Level'] = $this->User_Level->DefaultValue;
        $row['Report_To'] = $this->Report_To->DefaultValue;
        $row['Activated'] = $this->Activated->DefaultValue;
        $row['Locked'] = $this->Locked->DefaultValue;
        $row['Profile'] = $this->_Profile->DefaultValue;
        $row['Photo'] = $this->Photo->DefaultValue;
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

        // Username
        $this->_Username->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Password
        $this->_Password->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // First_Name
        $this->First_Name->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Last_Name
        $this->Last_Name->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Email
        $this->_Email->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // User_Level
        $this->User_Level->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Report_To
        $this->Report_To->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Activated
        $this->Activated->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Locked
        $this->Locked->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Profile
        $this->_Profile->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Photo
        $this->Photo->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // Username
            $this->_Username->ViewValue = $this->_Username->CurrentValue;

            // Password
            $this->_Password->ViewValue = $Language->phrase("PasswordMask");

            // First_Name
            $this->First_Name->ViewValue = $this->First_Name->CurrentValue;

            // Last_Name
            $this->Last_Name->ViewValue = $this->Last_Name->CurrentValue;

            // Email
            $this->_Email->ViewValue = $this->_Email->CurrentValue;

            // User_Level
            if ($Security->canAdmin()) { // System admin
                $curVal = strval($this->User_Level->CurrentValue);
                if ($curVal != "") {
                    $this->User_Level->ViewValue = $this->User_Level->lookupCacheOption($curVal);
                    if ($this->User_Level->ViewValue === null) { // Lookup from database
                        $filterWrk = SearchFilter("`User_Level_ID`", "=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->User_Level->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->User_Level->Lookup->renderViewRow($rswrk[0]);
                            $this->User_Level->ViewValue = $this->User_Level->displayValue($arwrk);
                        } else {
                            $this->User_Level->ViewValue = $this->User_Level->CurrentValue;
                        }
                    }
                } else {
                    $this->User_Level->ViewValue = null;
                }
            } else {
                $this->User_Level->ViewValue = $Language->phrase("PasswordMask");
            }

            // Report_To
            $this->Report_To->ViewValue = $this->Report_To->CurrentValue;

            // Activated
            if (ConvertToBool($this->Activated->CurrentValue)) {
                $this->Activated->ViewValue = $this->Activated->tagCaption(2) != "" ? $this->Activated->tagCaption(2) : "Y";
            } else {
                $this->Activated->ViewValue = $this->Activated->tagCaption(1) != "" ? $this->Activated->tagCaption(1) : "N";
            }

            // Locked
            if (ConvertToBool($this->Locked->CurrentValue)) {
                $this->Locked->ViewValue = $this->Locked->tagCaption(1) != "" ? $this->Locked->tagCaption(1) : "Y";
            } else {
                $this->Locked->ViewValue = $this->Locked->tagCaption(2) != "" ? $this->Locked->tagCaption(2) : "N";
            }

            // Photo
            if (!EmptyValue($this->Photo->Upload->DbValue)) {
                $this->Photo->ImageAlt = $this->Photo->alt();
                $this->Photo->ImageCssClass = "ew-image";
                $this->Photo->ViewValue = $this->Photo->Upload->DbValue;
            } else {
                $this->Photo->ViewValue = "";
            }

            // Username
            $this->_Username->HrefValue = "";

            // Password
            $this->_Password->HrefValue = "";

            // First_Name
            $this->First_Name->HrefValue = "";

            // Last_Name
            $this->Last_Name->HrefValue = "";

            // Email
            $this->_Email->HrefValue = "";

            // User_Level
            $this->User_Level->HrefValue = "";

            // Report_To
            $this->Report_To->HrefValue = "";

            // Activated
            $this->Activated->HrefValue = "";

            // Locked
            $this->Locked->HrefValue = "";

            // Photo
            if (!EmptyValue($this->Photo->Upload->DbValue)) {
                $this->Photo->HrefValue = GetFileUploadUrl($this->Photo, $this->Photo->htmlDecode($this->Photo->Upload->DbValue)); // Add prefix/suffix
                $this->Photo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->Photo->HrefValue = FullUrl($this->Photo->HrefValue, "href");
                }
            } else {
                $this->Photo->HrefValue = "";
            }
            $this->Photo->ExportHrefValue = $this->Photo->UploadPath . $this->Photo->Upload->DbValue;
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // Username
            $this->_Username->setupEditAttributes();
            if (!$Security->isAdmin() && $Security->isLoggedIn() && !$this->userIDAllow("add")) { // Non system admin
                $this->_Username->CurrentValue = EmptyValue($this->_Username->CurrentValue) ? CurrentUserID() : $this->_Username->CurrentValue;
            } else {
                if (!$this->_Username->Raw) {
                    $this->_Username->CurrentValue = HtmlDecode($this->_Username->CurrentValue);
                }
                $this->_Username->EditValue = HtmlEncode($this->_Username->CurrentValue);
                $this->_Username->PlaceHolder = RemoveHtml($this->_Username->caption());
            }

            // Password
            $this->_Password->setupEditAttributes(["class" => "ew-password-strength"]);
            $this->_Password->PlaceHolder = RemoveHtml($this->_Password->caption());

            // First_Name
            $this->First_Name->setupEditAttributes();
            if (!$this->First_Name->Raw) {
                $this->First_Name->CurrentValue = HtmlDecode($this->First_Name->CurrentValue);
            }
            $this->First_Name->EditValue = HtmlEncode($this->First_Name->CurrentValue);
            $this->First_Name->PlaceHolder = RemoveHtml($this->First_Name->caption());

            // Last_Name
            $this->Last_Name->setupEditAttributes();
            if (!$this->Last_Name->Raw) {
                $this->Last_Name->CurrentValue = HtmlDecode($this->Last_Name->CurrentValue);
            }
            $this->Last_Name->EditValue = HtmlEncode($this->Last_Name->CurrentValue);
            $this->Last_Name->PlaceHolder = RemoveHtml($this->Last_Name->caption());

            // Email
            $this->_Email->setupEditAttributes();
            if (!$this->_Email->Raw) {
                $this->_Email->CurrentValue = HtmlDecode($this->_Email->CurrentValue);
            }
            $this->_Email->EditValue = HtmlEncode($this->_Email->CurrentValue);
            $this->_Email->PlaceHolder = RemoveHtml($this->_Email->caption());

            // User_Level
            $this->User_Level->setupEditAttributes();
            if (!$Security->canAdmin()) { // System admin
                $this->User_Level->EditValue = $Language->phrase("PasswordMask");
            } else {
                $curVal = trim(strval($this->User_Level->CurrentValue));
                if ($curVal != "") {
                    $this->User_Level->ViewValue = $this->User_Level->lookupCacheOption($curVal);
                } else {
                    $this->User_Level->ViewValue = $this->User_Level->Lookup !== null && is_array($this->User_Level->lookupOptions()) && count($this->User_Level->lookupOptions()) > 0 ? $curVal : null;
                }
                if ($this->User_Level->ViewValue !== null) { // Load from cache
                    $this->User_Level->EditValue = array_values($this->User_Level->lookupOptions());
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = SearchFilter("`User_Level_ID`", "=", $this->User_Level->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->User_Level->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->User_Level->EditValue = $arwrk;
                }
                $this->User_Level->PlaceHolder = RemoveHtml($this->User_Level->caption());
            }

            // Report_To
            $this->Report_To->setupEditAttributes();
            if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin
            } else {
                if (!$this->Report_To->Raw) {
                    $this->Report_To->CurrentValue = HtmlDecode($this->Report_To->CurrentValue);
                }
                $this->Report_To->EditValue = HtmlEncode($this->Report_To->CurrentValue);
                $this->Report_To->PlaceHolder = RemoveHtml($this->Report_To->caption());
            }

            // Activated
            $this->Activated->EditValue = $this->Activated->options(false);
            $this->Activated->PlaceHolder = RemoveHtml($this->Activated->caption());

            // Locked
            $this->Locked->EditValue = $this->Locked->options(false);
            $this->Locked->PlaceHolder = RemoveHtml($this->Locked->caption());

            // Photo
            $this->Photo->setupEditAttributes();
            if (!EmptyValue($this->Photo->Upload->DbValue)) {
                $this->Photo->ImageAlt = $this->Photo->alt();
                $this->Photo->ImageCssClass = "ew-image";
                $this->Photo->EditValue = $this->Photo->Upload->DbValue;
            } else {
                $this->Photo->EditValue = "";
            }
            if (!EmptyValue($this->Photo->CurrentValue)) {
                $this->Photo->Upload->FileName = $this->Photo->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->Photo);
            }

            // Add refer script

            // Username
            $this->_Username->HrefValue = "";

            // Password
            $this->_Password->HrefValue = "";

            // First_Name
            $this->First_Name->HrefValue = "";

            // Last_Name
            $this->Last_Name->HrefValue = "";

            // Email
            $this->_Email->HrefValue = "";

            // User_Level
            $this->User_Level->HrefValue = "";

            // Report_To
            $this->Report_To->HrefValue = "";

            // Activated
            $this->Activated->HrefValue = "";

            // Locked
            $this->Locked->HrefValue = "";

            // Photo
            if (!EmptyValue($this->Photo->Upload->DbValue)) {
                $this->Photo->HrefValue = GetFileUploadUrl($this->Photo, $this->Photo->htmlDecode($this->Photo->Upload->DbValue)); // Add prefix/suffix
                $this->Photo->LinkAttrs["target"] = ""; // Add target
                if ($this->isExport()) {
                    $this->Photo->HrefValue = FullUrl($this->Photo->HrefValue, "href");
                }
            } else {
                $this->Photo->HrefValue = "";
            }
            $this->Photo->ExportHrefValue = $this->Photo->UploadPath . $this->Photo->Upload->DbValue;
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
        if ($this->_Username->Required) {
            if (!$this->_Username->IsDetailKey && EmptyValue($this->_Username->FormValue)) {
                $this->_Username->addErrorMessage(str_replace("%s", $this->_Username->caption(), $this->_Username->RequiredErrorMessage));
            }
        }
        if (!$this->_Username->Raw && Config("REMOVE_XSS") && CheckUsername($this->_Username->FormValue)) {
            $this->_Username->addErrorMessage($Language->phrase("InvalidUsernameChars"));
        }
        if ($this->_Password->Required) {
            if (!$this->_Password->IsDetailKey && EmptyValue($this->_Password->FormValue)) {
                $this->_Password->addErrorMessage(str_replace("%s", $this->_Password->caption(), $this->_Password->RequiredErrorMessage));
            }
        }
        if (!$this->_Password->Raw && Config("REMOVE_XSS") && CheckPassword($this->_Password->FormValue)) {
            $this->_Password->addErrorMessage($Language->phrase("InvalidPasswordChars"));
        }
        if ($this->First_Name->Required) {
            if (!$this->First_Name->IsDetailKey && EmptyValue($this->First_Name->FormValue)) {
                $this->First_Name->addErrorMessage(str_replace("%s", $this->First_Name->caption(), $this->First_Name->RequiredErrorMessage));
            }
        }
        if ($this->Last_Name->Required) {
            if (!$this->Last_Name->IsDetailKey && EmptyValue($this->Last_Name->FormValue)) {
                $this->Last_Name->addErrorMessage(str_replace("%s", $this->Last_Name->caption(), $this->Last_Name->RequiredErrorMessage));
            }
        }
        if ($this->_Email->Required) {
            if (!$this->_Email->IsDetailKey && EmptyValue($this->_Email->FormValue)) {
                $this->_Email->addErrorMessage(str_replace("%s", $this->_Email->caption(), $this->_Email->RequiredErrorMessage));
            }
        }
        if (!CheckEmail($this->_Email->FormValue)) {
            $this->_Email->addErrorMessage($this->_Email->getErrorMessage(false));
        }
        if ($this->User_Level->Required) {
            if ($Security->canAdmin() && !$this->User_Level->IsDetailKey && EmptyValue($this->User_Level->FormValue)) {
                $this->User_Level->addErrorMessage(str_replace("%s", $this->User_Level->caption(), $this->User_Level->RequiredErrorMessage));
            }
        }
        if ($this->Report_To->Required) {
            if (!$this->Report_To->IsDetailKey && EmptyValue($this->Report_To->FormValue)) {
                $this->Report_To->addErrorMessage(str_replace("%s", $this->Report_To->caption(), $this->Report_To->RequiredErrorMessage));
            }
        }
        if ($this->Activated->Required) {
            if ($this->Activated->FormValue == "") {
                $this->Activated->addErrorMessage(str_replace("%s", $this->Activated->caption(), $this->Activated->RequiredErrorMessage));
            }
        }
        if ($this->Locked->Required) {
            if ($this->Locked->FormValue == "") {
                $this->Locked->addErrorMessage(str_replace("%s", $this->Locked->caption(), $this->Locked->RequiredErrorMessage));
            }
        }
        if ($this->Photo->Required) {
            if ($this->Photo->Upload->FileName == "" && !$this->Photo->Upload->KeepFile) {
                $this->Photo->addErrorMessage(str_replace("%s", $this->Photo->caption(), $this->Photo->RequiredErrorMessage));
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

        // Username
        $this->_Username->setDbValueDef($rsnew, $this->_Username->CurrentValue, false);

        // Password
        if (!IsMaskedPassword($this->_Password->CurrentValue)) {
            $this->_Password->setDbValueDef($rsnew, $this->_Password->CurrentValue, false);
        }

        // First_Name
        $this->First_Name->setDbValueDef($rsnew, $this->First_Name->CurrentValue, false);

        // Last_Name
        $this->Last_Name->setDbValueDef($rsnew, $this->Last_Name->CurrentValue, false);

        // Email
        $this->_Email->setDbValueDef($rsnew, $this->_Email->CurrentValue, false);

        // User_Level
        if ($Security->canAdmin()) { // System admin
            $this->User_Level->setDbValueDef($rsnew, $this->User_Level->CurrentValue, strval($this->User_Level->CurrentValue) == "");
        }

        // Report_To
        $this->Report_To->setDbValueDef($rsnew, $this->Report_To->CurrentValue, false);

        // Activated
        $tmpBool = $this->Activated->CurrentValue;
        if ($tmpBool != "Y" && $tmpBool != "N") {
            $tmpBool = !empty($tmpBool) ? "Y" : "N";
        }
        $this->Activated->setDbValueDef($rsnew, $tmpBool, strval($this->Activated->CurrentValue) == "");

        // Locked
        $tmpBool = $this->Locked->CurrentValue;
        if ($tmpBool != "Y" && $tmpBool != "N") {
            $tmpBool = !empty($tmpBool) ? "Y" : "N";
        }
        $this->Locked->setDbValueDef($rsnew, $tmpBool, strval($this->Locked->CurrentValue) == "");

        // Photo
        if ($this->Photo->Visible && !$this->Photo->Upload->KeepFile) {
            $this->Photo->Upload->DbValue = ""; // No need to delete old file
            if ($this->Photo->Upload->FileName == "") {
                $rsnew['Photo'] = null;
            } else {
                $rsnew['Photo'] = $this->Photo->Upload->FileName;
            }
        }
        if ($this->Photo->Visible && !$this->Photo->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->Photo->Upload->DbValue) ? [] : [$this->Photo->htmlDecode($this->Photo->Upload->DbValue)];
            if (!EmptyValue($this->Photo->Upload->FileName)) {
                $newFiles = [$this->Photo->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->Photo, $this->Photo->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->Photo->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->Photo->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->Photo->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->Photo->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->Photo->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->Photo->setDbValueDef($rsnew, $this->Photo->Upload->FileName, false);
            }
        }

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check if valid User ID
        if (
            !EmptyValue($Security->currentUserID()) &&
            !$Security->isAdmin() && // Non system admin
            !$Security->isValidUserID($this->_Username->CurrentValue)
        ) {
			$Security->addUserID($this->_Username->CurrentValue); // added by Masino Sinaga, in order to prevent message below
            $userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
            $userIdMsg = str_replace("%u", strval($this->_Username->CurrentValue), $userIdMsg);
            $this->setFailureMessage($userIdMsg);
            return false;
        }

        // Check if valid Parent User ID
        if (
            !EmptyValue($Security->currentUserID()) &&
            !EmptyValue($this->Report_To->CurrentValue) && // Allow empty value
            !$Security->isAdmin() && // Non system admin
            !$Security->isValidUserID($this->Report_To->CurrentValue)
        ) {
			$Security->addUserID($this->Report_To->CurrentValue); // added by Masino Sinaga, in order to prevent message below
            $parentUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedParentUserID"));
            $parentUserIdMsg = str_replace("%p", strval($this->Report_To->CurrentValue), $parentUserIdMsg);
            $this->setFailureMessage($parentUserIdMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['Username']) == "") {
            $this->setFailureMessage($Language->phrase("InvalidKeyValue"));
            $insertRow = false;
        }

        // Check for duplicate key
        if ($insertRow && $this->ValidateKey) {
            $filter = $this->getRecordFilter($rsnew);
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $keyErrMsg = str_replace("%f", $filter, $Language->phrase("DupKey"));
                $this->setFailureMessage($keyErrMsg);
                $insertRow = false;
            }
        }
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->Photo->Visible && !$this->Photo->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->Photo->Upload->DbValue) ? [] : [$this->Photo->htmlDecode($this->Photo->Upload->DbValue)];
                    if (!EmptyValue($this->Photo->Upload->FileName)) {
                        $newFiles = [$this->Photo->Upload->FileName];
                        $newFiles2 = [$this->Photo->htmlDecode($rsnew['Photo'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->Photo, $this->Photo->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->Photo->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadError7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                }
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

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->_Username->CurrentValue);
        }
        return true;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("userslist"), "", $this->TableVar, true);
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
                case "x_User_Level":
                    break;
                case "x_Activated":
                    break;
                case "x_Locked":
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
