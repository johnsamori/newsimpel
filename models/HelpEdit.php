<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class HelpEdit extends Help
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "HelpEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "helpedit";

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
        $this->Help_ID->setVisibility();
        $this->_Language->setVisibility();
        $this->Topic->setVisibility();
        $this->Description->setVisibility();
        $this->Category->setVisibility();
        $this->Order->setVisibility();
        $this->Display_in_Page->setVisibility();
        $this->Updated_By->setVisibility();
        $this->Last_Updated->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'help';
        $this->TableName = 'help';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (help)
        if (!isset($GLOBALS["help"]) || get_class($GLOBALS["help"]) == PROJECT_NAMESPACE . "help") {
            $GLOBALS["help"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'help');
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
                    $result["view"] = $pageName == "helpview"; // If View page, no primary button
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
            $key .= @$ar['Help_ID'];
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
            $this->Help_ID->Visible = false;
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

    // Properties
    public $FormClassName = "ew-form ew-edit-form overlay-wrapper";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->setupLookupOptions($this->_Language);
        $this->setupLookupOptions($this->Category);
        $this->setupLookupOptions($this->Updated_By);
		My_Global_Check(); // Modified by Masino Sinaga, October 6, 2021

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;

        // Load record by position
        $loadByPosition = false;
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("Help_ID") ?? Key(0) ?? Route(2)) !== null) {
                $this->Help_ID->setQueryStringValue($keyValue);
                $this->Help_ID->setOldValue($this->Help_ID->QueryStringValue);
            } elseif (Post("Help_ID") !== null) {
                $this->Help_ID->setFormValue(Post("Help_ID"));
                $this->Help_ID->setOldValue($this->Help_ID->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action", "") !== "") {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("Help_ID") ?? Route("Help_ID")) !== null) {
                    $this->Help_ID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Help_ID->CurrentValue = null;
                }
                if (!$loadByQuery || Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NUMBER")) !== null) {
                    $loadByPosition = true;
                }
            }

            // Set up master detail parameters
            $this->setupMasterParms();

            // Load recordset
            if ($this->isShow()) {
                if (!$this->IsModal) { // Normal edit page
                    $this->StartRecord = 1; // Initialize start position
                    if ($rs = $this->loadRecordset()) { // Load records
                        $this->TotalRecords = $rs->recordCount(); // Get record count
                    }
                    if ($this->TotalRecords <= 0) { // No record found
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $this->terminate("helplist"); // Return to list page
                        return;
                    } elseif ($loadByPosition) { // Load record by position
                        $this->setupStartRecord(); // Set up start record position
                        // Point to current record
                        if ($this->StartRecord <= $this->TotalRecords) {
                            $rs->move($this->StartRecord - 1);
                            // Redirect to correct record
                            $this->loadRowValues($rs);
                            $url = $this->getCurrentUrl();
                            $this->terminate($url);
                            return;
                        }
                    } else { // Match key values
                        if ($this->Help_ID->CurrentValue != null) {
                            while (!$rs->EOF) {
                                if (SameString($this->Help_ID->CurrentValue, $rs->fields['Help_ID'])) {
                                    $this->setStartRecordNumber($this->StartRecord); // Save record position
                                    $loaded = true;
                                    break;
                                } else {
                                    $this->StartRecord++;
                                    $rs->moveNext();
                                }
                            }
                        }
                    }

                    // Load current row values
                    if ($loaded) {
                        $this->loadRowValues($rs);
                    }
                } else {
                    // Load current record
                    $loaded = $this->loadRow();
                } // End modal checking
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$this->IsModal) { // Normal edit page
                    if (!$loaded) {
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $this->terminate("helplist"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("helplist"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "helplist") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) {
                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "helplist") {
                            Container("flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "helplist"; // Return list page content
                        }
                    }
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsJsonResponse()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
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
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();
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

// Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'Help_ID' first before field var 'x_Help_ID'
        $val = $CurrentForm->hasValue("Help_ID") ? $CurrentForm->getValue("Help_ID") : $CurrentForm->getValue("x_Help_ID");
        if (!$this->Help_ID->IsDetailKey) {
            $this->Help_ID->setFormValue($val);
        }

        // Check field name 'Language' first before field var 'x__Language'
        $val = $CurrentForm->hasValue("Language") ? $CurrentForm->getValue("Language") : $CurrentForm->getValue("x__Language");
        if (!$this->_Language->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_Language->Visible = false; // Disable update for API request
            } else {
                $this->_Language->setFormValue($val);
            }
        }

        // Check field name 'Topic' first before field var 'x_Topic'
        $val = $CurrentForm->hasValue("Topic") ? $CurrentForm->getValue("Topic") : $CurrentForm->getValue("x_Topic");
        if (!$this->Topic->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Topic->Visible = false; // Disable update for API request
            } else {
                $this->Topic->setFormValue($val);
            }
        }

        // Check field name 'Description' first before field var 'x_Description'
        $val = $CurrentForm->hasValue("Description") ? $CurrentForm->getValue("Description") : $CurrentForm->getValue("x_Description");
        if (!$this->Description->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Description->Visible = false; // Disable update for API request
            } else {
                $this->Description->setFormValue($val);
            }
        }

        // Check field name 'Category' first before field var 'x_Category'
        $val = $CurrentForm->hasValue("Category") ? $CurrentForm->getValue("Category") : $CurrentForm->getValue("x_Category");
        if (!$this->Category->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Category->Visible = false; // Disable update for API request
            } else {
                $this->Category->setFormValue($val);
            }
        }

        // Check field name 'Order' first before field var 'x_Order'
        $val = $CurrentForm->hasValue("Order") ? $CurrentForm->getValue("Order") : $CurrentForm->getValue("x_Order");
        if (!$this->Order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Order->Visible = false; // Disable update for API request
            } else {
                $this->Order->setFormValue($val, true, $validate);
            }
        }

        // Check field name 'Display_in_Page' first before field var 'x_Display_in_Page'
        $val = $CurrentForm->hasValue("Display_in_Page") ? $CurrentForm->getValue("Display_in_Page") : $CurrentForm->getValue("x_Display_in_Page");
        if (!$this->Display_in_Page->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Display_in_Page->Visible = false; // Disable update for API request
            } else {
                $this->Display_in_Page->setFormValue($val);
            }
        }

        // Check field name 'Updated_By' first before field var 'x_Updated_By'
        $val = $CurrentForm->hasValue("Updated_By") ? $CurrentForm->getValue("Updated_By") : $CurrentForm->getValue("x_Updated_By");
        if (!$this->Updated_By->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Updated_By->Visible = false; // Disable update for API request
            } else {
                $this->Updated_By->setFormValue($val);
            }
        }

        // Check field name 'Last_Updated' first before field var 'x_Last_Updated'
        $val = $CurrentForm->hasValue("Last_Updated") ? $CurrentForm->getValue("Last_Updated") : $CurrentForm->getValue("x_Last_Updated");
        if (!$this->Last_Updated->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Last_Updated->Visible = false; // Disable update for API request
            } else {
                $this->Last_Updated->setFormValue($val, true, $validate);
            }
            $this->Last_Updated->CurrentValue = UnFormatDateTime($this->Last_Updated->CurrentValue, $this->Last_Updated->formatPattern());
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Help_ID->CurrentValue = $this->Help_ID->FormValue;
        $this->_Language->CurrentValue = $this->_Language->FormValue;
        $this->Topic->CurrentValue = $this->Topic->FormValue;
        $this->Description->CurrentValue = $this->Description->FormValue;
        $this->Category->CurrentValue = $this->Category->FormValue;
        $this->Order->CurrentValue = $this->Order->FormValue;
        $this->Display_in_Page->CurrentValue = $this->Display_in_Page->FormValue;
        $this->Updated_By->CurrentValue = $this->Updated_By->FormValue;
        $this->Last_Updated->CurrentValue = $this->Last_Updated->FormValue;
        $this->Last_Updated->CurrentValue = UnFormatDateTime($this->Last_Updated->CurrentValue, $this->Last_Updated->formatPattern());
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
        $this->Help_ID->setDbValue($row['Help_ID']);
        $this->_Language->setDbValue($row['Language']);
        $this->Topic->setDbValue($row['Topic']);
        $this->Description->setDbValue($row['Description']);
        $this->Category->setDbValue($row['Category']);
        $this->Order->setDbValue($row['Order']);
        $this->Display_in_Page->setDbValue($row['Display_in_Page']);
        $this->Updated_By->setDbValue($row['Updated_By']);
        $this->Last_Updated->setDbValue($row['Last_Updated']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Help_ID'] = $this->Help_ID->DefaultValue;
        $row['Language'] = $this->_Language->DefaultValue;
        $row['Topic'] = $this->Topic->DefaultValue;
        $row['Description'] = $this->Description->DefaultValue;
        $row['Category'] = $this->Category->DefaultValue;
        $row['Order'] = $this->Order->DefaultValue;
        $row['Display_in_Page'] = $this->Display_in_Page->DefaultValue;
        $row['Updated_By'] = $this->Updated_By->DefaultValue;
        $row['Last_Updated'] = $this->Last_Updated->DefaultValue;
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

        // Help_ID
        $this->Help_ID->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Language
        $this->_Language->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Topic
        $this->Topic->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Description
        $this->Description->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Category
        $this->Category->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Order
        $this->Order->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Display_in_Page
        $this->Display_in_Page->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Updated_By
        $this->Updated_By->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Last_Updated
        $this->Last_Updated->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // Help_ID
            $this->Help_ID->ViewValue = $this->Help_ID->CurrentValue;

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

            // Topic
            $this->Topic->ViewValue = $this->Topic->CurrentValue;

            // Description
            $this->Description->ViewValue = $this->Description->CurrentValue;

            // Category
            $curVal = strval($this->Category->CurrentValue);
            if ($curVal != "") {
                $this->Category->ViewValue = $this->Category->lookupCacheOption($curVal);
                if ($this->Category->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`Category_ID`", "=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->Category->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->Category->Lookup->renderViewRow($rswrk[0]);
                        $this->Category->ViewValue = $this->Category->displayValue($arwrk);
                    } else {
                        $this->Category->ViewValue = FormatNumber($this->Category->CurrentValue, $this->Category->formatPattern());
                    }
                }
            } else {
                $this->Category->ViewValue = null;
            }

            // Order
            $this->Order->ViewValue = $this->Order->CurrentValue;
            $this->Order->ViewValue = FormatNumber($this->Order->ViewValue, $this->Order->formatPattern());

            // Display_in_Page
            $this->Display_in_Page->ViewValue = $this->Display_in_Page->CurrentValue;

            // Updated_By
            $curVal = strval($this->Updated_By->CurrentValue);
            if ($curVal != "") {
                $this->Updated_By->ViewValue = $this->Updated_By->lookupCacheOption($curVal);
                if ($this->Updated_By->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`Username`", "=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->Updated_By->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->Updated_By->Lookup->renderViewRow($rswrk[0]);
                        $this->Updated_By->ViewValue = $this->Updated_By->displayValue($arwrk);
                    } else {
                        $this->Updated_By->ViewValue = $this->Updated_By->CurrentValue;
                    }
                }
            } else {
                $this->Updated_By->ViewValue = null;
            }

            // Last_Updated
            $this->Last_Updated->ViewValue = $this->Last_Updated->CurrentValue;
            $this->Last_Updated->ViewValue = FormatDateTime($this->Last_Updated->ViewValue, $this->Last_Updated->formatPattern());

            // Help_ID
            $this->Help_ID->HrefValue = "";

            // Language
            $this->_Language->HrefValue = "";

            // Topic
            $this->Topic->HrefValue = "";

            // Description
            $this->Description->HrefValue = "";

            // Category
            $this->Category->HrefValue = "";

            // Order
            $this->Order->HrefValue = "";

            // Display_in_Page
            $this->Display_in_Page->HrefValue = "";

            // Updated_By
            $this->Updated_By->HrefValue = "";

            // Last_Updated
            $this->Last_Updated->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // Help_ID
            $this->Help_ID->setupEditAttributes();
            $this->Help_ID->EditValue = $this->Help_ID->CurrentValue;

            // Language
            $this->_Language->setupEditAttributes();
            $curVal = trim(strval($this->_Language->CurrentValue));
            if ($curVal != "") {
                $this->_Language->ViewValue = $this->_Language->lookupCacheOption($curVal);
            } else {
                $this->_Language->ViewValue = $this->_Language->Lookup !== null && is_array($this->_Language->lookupOptions()) && count($this->_Language->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->_Language->ViewValue !== null) { // Load from cache
                $this->_Language->EditValue = array_values($this->_Language->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`Language_Code`", "=", $this->_Language->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->_Language->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->_Language->EditValue = $arwrk;
            }
            $this->_Language->PlaceHolder = RemoveHtml($this->_Language->caption());

            // Topic
            $this->Topic->setupEditAttributes();
            if (!$this->Topic->Raw) {
                $this->Topic->CurrentValue = HtmlDecode($this->Topic->CurrentValue);
            }
            $this->Topic->EditValue = HtmlEncode($this->Topic->CurrentValue);
            $this->Topic->PlaceHolder = RemoveHtml($this->Topic->caption());

            // Description
            $this->Description->setupEditAttributes();
            $this->Description->EditValue = HtmlEncode($this->Description->CurrentValue);
            $this->Description->PlaceHolder = RemoveHtml($this->Description->caption());

            // Category
            $this->Category->setupEditAttributes();
            if ($this->Category->getSessionValue() != "") {
                $this->Category->CurrentValue = GetForeignKeyValue($this->Category->getSessionValue());
                $curVal = strval($this->Category->CurrentValue);
                if ($curVal != "") {
                    $this->Category->ViewValue = $this->Category->lookupCacheOption($curVal);
                    if ($this->Category->ViewValue === null) { // Lookup from database
                        $filterWrk = SearchFilter("`Category_ID`", "=", $curVal, DATATYPE_NUMBER, "");
                        $sqlWrk = $this->Category->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                        $conn = Conn();
                        $config = $conn->getConfiguration();
                        $config->setResultCacheImpl($this->Cache);
                        $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                        $ari = count($rswrk);
                        if ($ari > 0) { // Lookup values found
                            $arwrk = $this->Category->Lookup->renderViewRow($rswrk[0]);
                            $this->Category->ViewValue = $this->Category->displayValue($arwrk);
                        } else {
                            $this->Category->ViewValue = FormatNumber($this->Category->CurrentValue, $this->Category->formatPattern());
                        }
                    }
                } else {
                    $this->Category->ViewValue = null;
                }
            } else {
                $curVal = trim(strval($this->Category->CurrentValue));
                if ($curVal != "") {
                    $this->Category->ViewValue = $this->Category->lookupCacheOption($curVal);
                } else {
                    $this->Category->ViewValue = $this->Category->Lookup !== null && is_array($this->Category->lookupOptions()) && count($this->Category->lookupOptions()) > 0 ? $curVal : null;
                }
                if ($this->Category->ViewValue !== null) { // Load from cache
                    $this->Category->EditValue = array_values($this->Category->lookupOptions());
                } else { // Lookup from database
                    if ($curVal == "") {
                        $filterWrk = "0=1";
                    } else {
                        $filterWrk = SearchFilter("`Category_ID`", "=", $this->Category->CurrentValue, DATATYPE_NUMBER, "");
                    }
                    $sqlWrk = $this->Category->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    $arwrk = $rswrk;
                    $this->Category->EditValue = $arwrk;
                }
                $this->Category->PlaceHolder = RemoveHtml($this->Category->caption());
            }

            // Order
            $this->Order->setupEditAttributes();
            $this->Order->EditValue = HtmlEncode($this->Order->CurrentValue);
            $this->Order->PlaceHolder = RemoveHtml($this->Order->caption());
            if (strval($this->Order->EditValue) != "" && is_numeric($this->Order->EditValue)) {
                $this->Order->EditValue = FormatNumber($this->Order->EditValue, null);
            }

            // Display_in_Page
            $this->Display_in_Page->setupEditAttributes();
            if (!$this->Display_in_Page->Raw) {
                $this->Display_in_Page->CurrentValue = HtmlDecode($this->Display_in_Page->CurrentValue);
            }
            $this->Display_in_Page->EditValue = HtmlEncode($this->Display_in_Page->CurrentValue);
            $this->Display_in_Page->PlaceHolder = RemoveHtml($this->Display_in_Page->caption());

            // Updated_By
            $this->Updated_By->setupEditAttributes();
            $curVal = trim(strval($this->Updated_By->CurrentValue));
            if ($curVal != "") {
                $this->Updated_By->ViewValue = $this->Updated_By->lookupCacheOption($curVal);
            } else {
                $this->Updated_By->ViewValue = $this->Updated_By->Lookup !== null && is_array($this->Updated_By->lookupOptions()) && count($this->Updated_By->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->Updated_By->ViewValue !== null) { // Load from cache
                $this->Updated_By->EditValue = array_values($this->Updated_By->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`Username`", "=", $this->Updated_By->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->Updated_By->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->Updated_By->EditValue = $arwrk;
            }
            $this->Updated_By->PlaceHolder = RemoveHtml($this->Updated_By->caption());

            // Last_Updated
            $this->Last_Updated->setupEditAttributes();
            $this->Last_Updated->EditValue = HtmlEncode(FormatDateTime($this->Last_Updated->CurrentValue, $this->Last_Updated->formatPattern()));
            $this->Last_Updated->PlaceHolder = RemoveHtml($this->Last_Updated->caption());

            // Edit refer script

            // Help_ID
            $this->Help_ID->HrefValue = "";

            // Language
            $this->_Language->HrefValue = "";

            // Topic
            $this->Topic->HrefValue = "";

            // Description
            $this->Description->HrefValue = "";

            // Category
            $this->Category->HrefValue = "";

            // Order
            $this->Order->HrefValue = "";

            // Display_in_Page
            $this->Display_in_Page->HrefValue = "";

            // Updated_By
            $this->Updated_By->HrefValue = "";

            // Last_Updated
            $this->Last_Updated->HrefValue = "";
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
        if ($this->Help_ID->Required) {
            if (!$this->Help_ID->IsDetailKey && EmptyValue($this->Help_ID->FormValue)) {
                $this->Help_ID->addErrorMessage(str_replace("%s", $this->Help_ID->caption(), $this->Help_ID->RequiredErrorMessage));
            }
        }
        if ($this->_Language->Required) {
            if (!$this->_Language->IsDetailKey && EmptyValue($this->_Language->FormValue)) {
                $this->_Language->addErrorMessage(str_replace("%s", $this->_Language->caption(), $this->_Language->RequiredErrorMessage));
            }
        }
        if ($this->Topic->Required) {
            if (!$this->Topic->IsDetailKey && EmptyValue($this->Topic->FormValue)) {
                $this->Topic->addErrorMessage(str_replace("%s", $this->Topic->caption(), $this->Topic->RequiredErrorMessage));
            }
        }
        if ($this->Description->Required) {
            if (!$this->Description->IsDetailKey && EmptyValue($this->Description->FormValue)) {
                $this->Description->addErrorMessage(str_replace("%s", $this->Description->caption(), $this->Description->RequiredErrorMessage));
            }
        }
        if ($this->Category->Required) {
            if (!$this->Category->IsDetailKey && EmptyValue($this->Category->FormValue)) {
                $this->Category->addErrorMessage(str_replace("%s", $this->Category->caption(), $this->Category->RequiredErrorMessage));
            }
        }
        if ($this->Order->Required) {
            if (!$this->Order->IsDetailKey && EmptyValue($this->Order->FormValue)) {
                $this->Order->addErrorMessage(str_replace("%s", $this->Order->caption(), $this->Order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->Order->FormValue)) {
            $this->Order->addErrorMessage($this->Order->getErrorMessage(false));
        }
        if ($this->Display_in_Page->Required) {
            if (!$this->Display_in_Page->IsDetailKey && EmptyValue($this->Display_in_Page->FormValue)) {
                $this->Display_in_Page->addErrorMessage(str_replace("%s", $this->Display_in_Page->caption(), $this->Display_in_Page->RequiredErrorMessage));
            }
        }
        if ($this->Updated_By->Required) {
            if (!$this->Updated_By->IsDetailKey && EmptyValue($this->Updated_By->FormValue)) {
                $this->Updated_By->addErrorMessage(str_replace("%s", $this->Updated_By->caption(), $this->Updated_By->RequiredErrorMessage));
            }
        }
        if ($this->Last_Updated->Required) {
            if (!$this->Last_Updated->IsDetailKey && EmptyValue($this->Last_Updated->FormValue)) {
                $this->Last_Updated->addErrorMessage(str_replace("%s", $this->Last_Updated->caption(), $this->Last_Updated->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->Last_Updated->FormValue, $this->Last_Updated->formatPattern())) {
            $this->Last_Updated->addErrorMessage($this->Last_Updated->getErrorMessage(false));
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

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();

        // Load old row
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            return false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
        }

        // Set new row
        $rsnew = [];

        // Language
        $this->_Language->setDbValueDef($rsnew, $this->_Language->CurrentValue, $this->_Language->ReadOnly);

        // Topic
        $this->Topic->setDbValueDef($rsnew, $this->Topic->CurrentValue, $this->Topic->ReadOnly);

        // Description
        $this->Description->setDbValueDef($rsnew, $this->Description->CurrentValue, $this->Description->ReadOnly);

        // Category
        if ($this->Category->getSessionValue() != "") {
            $this->Category->ReadOnly = true;
        }
        $this->Category->setDbValueDef($rsnew, $this->Category->CurrentValue, $this->Category->ReadOnly);

        // Order
        $this->Order->setDbValueDef($rsnew, $this->Order->CurrentValue, $this->Order->ReadOnly);

        // Display_in_Page
        $this->Display_in_Page->setDbValueDef($rsnew, $this->Display_in_Page->CurrentValue, $this->Display_in_Page->ReadOnly);

        // Updated_By
        $this->Updated_By->setDbValueDef($rsnew, $this->Updated_By->CurrentValue, $this->Updated_By->ReadOnly);

        // Last_Updated
        $this->Last_Updated->setDbValueDef($rsnew, UnFormatDateTime($this->Last_Updated->CurrentValue, $this->Last_Updated->formatPattern()), $this->Last_Updated->ReadOnly);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);
        if ($updateRow) {
            if (count($rsnew) > 0) {
                $this->CurrentFilter = $filter; // Set up current filter
                $editRow = $this->update($rsnew, "", $rsold);
                if (!$editRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            } else {
                $editRow = true; // No field to update
            }
            if ($editRow) {
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("UpdateCancelled"));
            }
            $editRow = false;
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_EDIT_ACTION"), $table => $row]);
        }
        return $editRow;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
		$foreignKeys = [];
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "help_categories") {
                $validMaster = true;
                $masterTbl = Container("help_categories");
                if (($parm = Get("fk_Category_ID", Get("Category"))) !== null) {
                    $masterTbl->Category_ID->setQueryStringValue($parm);
                    $this->Category->QueryStringValue = $masterTbl->Category_ID->QueryStringValue; // DO NOT change, master/detail key data type can be different
                    $this->Category->setSessionValue($this->Category->QueryStringValue);
					$foreignKeys["Category"] = $this->Category->QueryStringValue;
                    if (!is_numeric($masterTbl->Category_ID->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "help_categories") {
                $validMaster = true;
                $masterTbl = Container("help_categories");
                if (($parm = Post("fk_Category_ID", Post("Category"))) !== null) {
                    $masterTbl->Category_ID->setFormValue($parm);
                    $this->Category->FormValue = $masterTbl->Category_ID->FormValue;
                    $this->Category->setSessionValue($this->Category->FormValue);
					$foreignKeys["Category"] = $this->Category->FormValue;
                    if (!is_numeric($masterTbl->Category_ID->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);
            $this->setSessionWhere($this->getDetailFilterFromSession());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit() && !$this->isGridUpdate()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "help_categories") {
                if (!array_key_exists("Category", $foreignKeys)) { // Not current foreign key
                    $this->Category->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilterFromSession(); // Get master filter from session
        $this->DbDetailFilter = $this->getDetailFilterFromSession(); // Get detail filter from session
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("helplist"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
                case "x_Category":
                    break;
                case "x_Updated_By":
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

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }
}
