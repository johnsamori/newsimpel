<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class LanguagesEdit extends Languages
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "LanguagesEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "languagesedit";

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
        $this->Language_Code->setVisibility();
        $this->Language_Name->setVisibility();
        $this->_Default->setVisibility();
        $this->Site_Logo->setVisibility();
        $this->Site_Title->setVisibility();
        $this->Default_Thousands_Separator->setVisibility();
        $this->Default_Decimal_Point->setVisibility();
        $this->Default_Currency_Symbol->setVisibility();
        $this->Default_Money_Thousands_Separator->setVisibility();
        $this->Default_Money_Decimal_Point->setVisibility();
        $this->Terms_And_Condition_Text->setVisibility();
        $this->Announcement_Text->setVisibility();
        $this->About_Text->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'languages';
        $this->TableName = 'languages';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (languages)
        if (!isset($GLOBALS["languages"]) || get_class($GLOBALS["languages"]) == PROJECT_NAMESPACE . "languages") {
            $GLOBALS["languages"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'languages');
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
                    $result["view"] = $pageName == "languagesview"; // If View page, no primary button
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
            $key .= @$ar['Language_Code'];
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
        $this->setupLookupOptions($this->_Default);
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
            if (($keyValue = Get("Language_Code") ?? Key(0) ?? Route(2)) !== null) {
                $this->Language_Code->setQueryStringValue($keyValue);
                $this->Language_Code->setOldValue($this->Language_Code->QueryStringValue);
            } elseif (Post("Language_Code") !== null) {
                $this->Language_Code->setFormValue(Post("Language_Code"));
                $this->Language_Code->setOldValue($this->Language_Code->FormValue);
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
                if (($keyValue = Get("Language_Code") ?? Route("Language_Code")) !== null) {
                    $this->Language_Code->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Language_Code->CurrentValue = null;
                }
                if (!$loadByQuery || Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NUMBER")) !== null) {
                    $loadByPosition = true;
                }
            }

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
                        $this->terminate("languageslist"); // Return to list page
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
                        if ($this->Language_Code->CurrentValue != null) {
                            while (!$rs->EOF) {
                                if (SameString($this->Language_Code->CurrentValue, $rs->fields['Language_Code'])) {
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
                        $this->terminate("languageslist"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("languageslist"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "languageslist") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) {
                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "languageslist") {
                            Container("flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "languageslist"; // Return list page content
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

        // Check field name 'Language_Code' first before field var 'x_Language_Code'
        $val = $CurrentForm->hasValue("Language_Code") ? $CurrentForm->getValue("Language_Code") : $CurrentForm->getValue("x_Language_Code");
        if (!$this->Language_Code->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Language_Code->Visible = false; // Disable update for API request
            } else {
                $this->Language_Code->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_Language_Code")) {
            $this->Language_Code->setOldValue($CurrentForm->getValue("o_Language_Code"));
        }

        // Check field name 'Language_Name' first before field var 'x_Language_Name'
        $val = $CurrentForm->hasValue("Language_Name") ? $CurrentForm->getValue("Language_Name") : $CurrentForm->getValue("x_Language_Name");
        if (!$this->Language_Name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Language_Name->Visible = false; // Disable update for API request
            } else {
                $this->Language_Name->setFormValue($val);
            }
        }

        // Check field name 'Default' first before field var 'x__Default'
        $val = $CurrentForm->hasValue("Default") ? $CurrentForm->getValue("Default") : $CurrentForm->getValue("x__Default");
        if (!$this->_Default->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_Default->Visible = false; // Disable update for API request
            } else {
                $this->_Default->setFormValue($val);
            }
        }

        // Check field name 'Site_Logo' first before field var 'x_Site_Logo'
        $val = $CurrentForm->hasValue("Site_Logo") ? $CurrentForm->getValue("Site_Logo") : $CurrentForm->getValue("x_Site_Logo");
        if (!$this->Site_Logo->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Site_Logo->Visible = false; // Disable update for API request
            } else {
                $this->Site_Logo->setFormValue($val);
            }
        }

        // Check field name 'Site_Title' first before field var 'x_Site_Title'
        $val = $CurrentForm->hasValue("Site_Title") ? $CurrentForm->getValue("Site_Title") : $CurrentForm->getValue("x_Site_Title");
        if (!$this->Site_Title->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Site_Title->Visible = false; // Disable update for API request
            } else {
                $this->Site_Title->setFormValue($val);
            }
        }

        // Check field name 'Default_Thousands_Separator' first before field var 'x_Default_Thousands_Separator'
        $val = $CurrentForm->hasValue("Default_Thousands_Separator") ? $CurrentForm->getValue("Default_Thousands_Separator") : $CurrentForm->getValue("x_Default_Thousands_Separator");
        if (!$this->Default_Thousands_Separator->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Default_Thousands_Separator->Visible = false; // Disable update for API request
            } else {
                $this->Default_Thousands_Separator->setFormValue($val);
            }
        }

        // Check field name 'Default_Decimal_Point' first before field var 'x_Default_Decimal_Point'
        $val = $CurrentForm->hasValue("Default_Decimal_Point") ? $CurrentForm->getValue("Default_Decimal_Point") : $CurrentForm->getValue("x_Default_Decimal_Point");
        if (!$this->Default_Decimal_Point->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Default_Decimal_Point->Visible = false; // Disable update for API request
            } else {
                $this->Default_Decimal_Point->setFormValue($val);
            }
        }

        // Check field name 'Default_Currency_Symbol' first before field var 'x_Default_Currency_Symbol'
        $val = $CurrentForm->hasValue("Default_Currency_Symbol") ? $CurrentForm->getValue("Default_Currency_Symbol") : $CurrentForm->getValue("x_Default_Currency_Symbol");
        if (!$this->Default_Currency_Symbol->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Default_Currency_Symbol->Visible = false; // Disable update for API request
            } else {
                $this->Default_Currency_Symbol->setFormValue($val);
            }
        }

        // Check field name 'Default_Money_Thousands_Separator' first before field var 'x_Default_Money_Thousands_Separator'
        $val = $CurrentForm->hasValue("Default_Money_Thousands_Separator") ? $CurrentForm->getValue("Default_Money_Thousands_Separator") : $CurrentForm->getValue("x_Default_Money_Thousands_Separator");
        if (!$this->Default_Money_Thousands_Separator->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Default_Money_Thousands_Separator->Visible = false; // Disable update for API request
            } else {
                $this->Default_Money_Thousands_Separator->setFormValue($val);
            }
        }

        // Check field name 'Default_Money_Decimal_Point' first before field var 'x_Default_Money_Decimal_Point'
        $val = $CurrentForm->hasValue("Default_Money_Decimal_Point") ? $CurrentForm->getValue("Default_Money_Decimal_Point") : $CurrentForm->getValue("x_Default_Money_Decimal_Point");
        if (!$this->Default_Money_Decimal_Point->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Default_Money_Decimal_Point->Visible = false; // Disable update for API request
            } else {
                $this->Default_Money_Decimal_Point->setFormValue($val);
            }
        }

        // Check field name 'Terms_And_Condition_Text' first before field var 'x_Terms_And_Condition_Text'
        $val = $CurrentForm->hasValue("Terms_And_Condition_Text") ? $CurrentForm->getValue("Terms_And_Condition_Text") : $CurrentForm->getValue("x_Terms_And_Condition_Text");
        if (!$this->Terms_And_Condition_Text->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Terms_And_Condition_Text->Visible = false; // Disable update for API request
            } else {
                $this->Terms_And_Condition_Text->setFormValue($val);
            }
        }

        // Check field name 'Announcement_Text' first before field var 'x_Announcement_Text'
        $val = $CurrentForm->hasValue("Announcement_Text") ? $CurrentForm->getValue("Announcement_Text") : $CurrentForm->getValue("x_Announcement_Text");
        if (!$this->Announcement_Text->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Announcement_Text->Visible = false; // Disable update for API request
            } else {
                $this->Announcement_Text->setFormValue($val);
            }
        }

        // Check field name 'About_Text' first before field var 'x_About_Text'
        $val = $CurrentForm->hasValue("About_Text") ? $CurrentForm->getValue("About_Text") : $CurrentForm->getValue("x_About_Text");
        if (!$this->About_Text->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->About_Text->Visible = false; // Disable update for API request
            } else {
                $this->About_Text->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Language_Code->CurrentValue = $this->Language_Code->FormValue;
        $this->Language_Name->CurrentValue = $this->Language_Name->FormValue;
        $this->_Default->CurrentValue = $this->_Default->FormValue;
        $this->Site_Logo->CurrentValue = $this->Site_Logo->FormValue;
        $this->Site_Title->CurrentValue = $this->Site_Title->FormValue;
        $this->Default_Thousands_Separator->CurrentValue = $this->Default_Thousands_Separator->FormValue;
        $this->Default_Decimal_Point->CurrentValue = $this->Default_Decimal_Point->FormValue;
        $this->Default_Currency_Symbol->CurrentValue = $this->Default_Currency_Symbol->FormValue;
        $this->Default_Money_Thousands_Separator->CurrentValue = $this->Default_Money_Thousands_Separator->FormValue;
        $this->Default_Money_Decimal_Point->CurrentValue = $this->Default_Money_Decimal_Point->FormValue;
        $this->Terms_And_Condition_Text->CurrentValue = $this->Terms_And_Condition_Text->FormValue;
        $this->Announcement_Text->CurrentValue = $this->Announcement_Text->FormValue;
        $this->About_Text->CurrentValue = $this->About_Text->FormValue;
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
        $this->Language_Code->setDbValue($row['Language_Code']);
        $this->Language_Name->setDbValue($row['Language_Name']);
        $this->_Default->setDbValue($row['Default']);
        $this->Site_Logo->setDbValue($row['Site_Logo']);
        $this->Site_Title->setDbValue($row['Site_Title']);
        $this->Default_Thousands_Separator->setDbValue($row['Default_Thousands_Separator']);
        $this->Default_Decimal_Point->setDbValue($row['Default_Decimal_Point']);
        $this->Default_Currency_Symbol->setDbValue($row['Default_Currency_Symbol']);
        $this->Default_Money_Thousands_Separator->setDbValue($row['Default_Money_Thousands_Separator']);
        $this->Default_Money_Decimal_Point->setDbValue($row['Default_Money_Decimal_Point']);
        $this->Terms_And_Condition_Text->setDbValue($row['Terms_And_Condition_Text']);
        $this->Announcement_Text->setDbValue($row['Announcement_Text']);
        $this->About_Text->setDbValue($row['About_Text']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Language_Code'] = $this->Language_Code->DefaultValue;
        $row['Language_Name'] = $this->Language_Name->DefaultValue;
        $row['Default'] = $this->_Default->DefaultValue;
        $row['Site_Logo'] = $this->Site_Logo->DefaultValue;
        $row['Site_Title'] = $this->Site_Title->DefaultValue;
        $row['Default_Thousands_Separator'] = $this->Default_Thousands_Separator->DefaultValue;
        $row['Default_Decimal_Point'] = $this->Default_Decimal_Point->DefaultValue;
        $row['Default_Currency_Symbol'] = $this->Default_Currency_Symbol->DefaultValue;
        $row['Default_Money_Thousands_Separator'] = $this->Default_Money_Thousands_Separator->DefaultValue;
        $row['Default_Money_Decimal_Point'] = $this->Default_Money_Decimal_Point->DefaultValue;
        $row['Terms_And_Condition_Text'] = $this->Terms_And_Condition_Text->DefaultValue;
        $row['Announcement_Text'] = $this->Announcement_Text->DefaultValue;
        $row['About_Text'] = $this->About_Text->DefaultValue;
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

        // Language_Code
        $this->Language_Code->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Language_Name
        $this->Language_Name->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Default
        $this->_Default->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Site_Logo
        $this->Site_Logo->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Site_Title
        $this->Site_Title->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Default_Thousands_Separator
        $this->Default_Thousands_Separator->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Default_Decimal_Point
        $this->Default_Decimal_Point->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Default_Currency_Symbol
        $this->Default_Currency_Symbol->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Default_Money_Thousands_Separator
        $this->Default_Money_Thousands_Separator->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Default_Money_Decimal_Point
        $this->Default_Money_Decimal_Point->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Terms_And_Condition_Text
        $this->Terms_And_Condition_Text->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Announcement_Text
        $this->Announcement_Text->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // About_Text
        $this->About_Text->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // Language_Code
            $this->Language_Code->ViewValue = $this->Language_Code->CurrentValue;

            // Language_Name
            $this->Language_Name->ViewValue = $this->Language_Name->CurrentValue;

            // Default
            if (ConvertToBool($this->_Default->CurrentValue)) {
                $this->_Default->ViewValue = $this->_Default->tagCaption(1) != "" ? $this->_Default->tagCaption(1) : "Y";
            } else {
                $this->_Default->ViewValue = $this->_Default->tagCaption(2) != "" ? $this->_Default->tagCaption(2) : "N";
            }

            // Site_Logo
            $this->Site_Logo->ViewValue = $this->Site_Logo->CurrentValue;

            // Site_Title
            $this->Site_Title->ViewValue = $this->Site_Title->CurrentValue;

            // Default_Thousands_Separator
            $this->Default_Thousands_Separator->ViewValue = $this->Default_Thousands_Separator->CurrentValue;

            // Default_Decimal_Point
            $this->Default_Decimal_Point->ViewValue = $this->Default_Decimal_Point->CurrentValue;

            // Default_Currency_Symbol
            $this->Default_Currency_Symbol->ViewValue = $this->Default_Currency_Symbol->CurrentValue;

            // Default_Money_Thousands_Separator
            $this->Default_Money_Thousands_Separator->ViewValue = $this->Default_Money_Thousands_Separator->CurrentValue;

            // Default_Money_Decimal_Point
            $this->Default_Money_Decimal_Point->ViewValue = $this->Default_Money_Decimal_Point->CurrentValue;

            // Terms_And_Condition_Text
            $this->Terms_And_Condition_Text->ViewValue = $this->Terms_And_Condition_Text->CurrentValue;

            // Announcement_Text
            $this->Announcement_Text->ViewValue = $this->Announcement_Text->CurrentValue;

            // About_Text
            $this->About_Text->ViewValue = $this->About_Text->CurrentValue;

            // Language_Code
            $this->Language_Code->HrefValue = "";

            // Language_Name
            $this->Language_Name->HrefValue = "";

            // Default
            $this->_Default->HrefValue = "";

            // Site_Logo
            $this->Site_Logo->HrefValue = "";

            // Site_Title
            $this->Site_Title->HrefValue = "";

            // Default_Thousands_Separator
            $this->Default_Thousands_Separator->HrefValue = "";

            // Default_Decimal_Point
            $this->Default_Decimal_Point->HrefValue = "";

            // Default_Currency_Symbol
            $this->Default_Currency_Symbol->HrefValue = "";

            // Default_Money_Thousands_Separator
            $this->Default_Money_Thousands_Separator->HrefValue = "";

            // Default_Money_Decimal_Point
            $this->Default_Money_Decimal_Point->HrefValue = "";

            // Terms_And_Condition_Text
            $this->Terms_And_Condition_Text->HrefValue = "";

            // Announcement_Text
            $this->Announcement_Text->HrefValue = "";

            // About_Text
            $this->About_Text->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // Language_Code
            $this->Language_Code->setupEditAttributes();
            if (!$this->Language_Code->Raw) {
                $this->Language_Code->CurrentValue = HtmlDecode($this->Language_Code->CurrentValue);
            }
            $this->Language_Code->EditValue = HtmlEncode($this->Language_Code->CurrentValue);
            $this->Language_Code->PlaceHolder = RemoveHtml($this->Language_Code->caption());

            // Language_Name
            $this->Language_Name->setupEditAttributes();
            if (!$this->Language_Name->Raw) {
                $this->Language_Name->CurrentValue = HtmlDecode($this->Language_Name->CurrentValue);
            }
            $this->Language_Name->EditValue = HtmlEncode($this->Language_Name->CurrentValue);
            $this->Language_Name->PlaceHolder = RemoveHtml($this->Language_Name->caption());

            // Default
            $this->_Default->EditValue = $this->_Default->options(false);
            $this->_Default->PlaceHolder = RemoveHtml($this->_Default->caption());

            // Site_Logo
            $this->Site_Logo->setupEditAttributes();
            if (!$this->Site_Logo->Raw) {
                $this->Site_Logo->CurrentValue = HtmlDecode($this->Site_Logo->CurrentValue);
            }
            $this->Site_Logo->EditValue = HtmlEncode($this->Site_Logo->CurrentValue);
            $this->Site_Logo->PlaceHolder = RemoveHtml($this->Site_Logo->caption());

            // Site_Title
            $this->Site_Title->setupEditAttributes();
            if (!$this->Site_Title->Raw) {
                $this->Site_Title->CurrentValue = HtmlDecode($this->Site_Title->CurrentValue);
            }
            $this->Site_Title->EditValue = HtmlEncode($this->Site_Title->CurrentValue);
            $this->Site_Title->PlaceHolder = RemoveHtml($this->Site_Title->caption());

            // Default_Thousands_Separator
            $this->Default_Thousands_Separator->setupEditAttributes();
            if (!$this->Default_Thousands_Separator->Raw) {
                $this->Default_Thousands_Separator->CurrentValue = HtmlDecode($this->Default_Thousands_Separator->CurrentValue);
            }
            $this->Default_Thousands_Separator->EditValue = HtmlEncode($this->Default_Thousands_Separator->CurrentValue);
            $this->Default_Thousands_Separator->PlaceHolder = RemoveHtml($this->Default_Thousands_Separator->caption());

            // Default_Decimal_Point
            $this->Default_Decimal_Point->setupEditAttributes();
            if (!$this->Default_Decimal_Point->Raw) {
                $this->Default_Decimal_Point->CurrentValue = HtmlDecode($this->Default_Decimal_Point->CurrentValue);
            }
            $this->Default_Decimal_Point->EditValue = HtmlEncode($this->Default_Decimal_Point->CurrentValue);
            $this->Default_Decimal_Point->PlaceHolder = RemoveHtml($this->Default_Decimal_Point->caption());

            // Default_Currency_Symbol
            $this->Default_Currency_Symbol->setupEditAttributes();
            if (!$this->Default_Currency_Symbol->Raw) {
                $this->Default_Currency_Symbol->CurrentValue = HtmlDecode($this->Default_Currency_Symbol->CurrentValue);
            }
            $this->Default_Currency_Symbol->EditValue = HtmlEncode($this->Default_Currency_Symbol->CurrentValue);
            $this->Default_Currency_Symbol->PlaceHolder = RemoveHtml($this->Default_Currency_Symbol->caption());

            // Default_Money_Thousands_Separator
            $this->Default_Money_Thousands_Separator->setupEditAttributes();
            if (!$this->Default_Money_Thousands_Separator->Raw) {
                $this->Default_Money_Thousands_Separator->CurrentValue = HtmlDecode($this->Default_Money_Thousands_Separator->CurrentValue);
            }
            $this->Default_Money_Thousands_Separator->EditValue = HtmlEncode($this->Default_Money_Thousands_Separator->CurrentValue);
            $this->Default_Money_Thousands_Separator->PlaceHolder = RemoveHtml($this->Default_Money_Thousands_Separator->caption());

            // Default_Money_Decimal_Point
            $this->Default_Money_Decimal_Point->setupEditAttributes();
            if (!$this->Default_Money_Decimal_Point->Raw) {
                $this->Default_Money_Decimal_Point->CurrentValue = HtmlDecode($this->Default_Money_Decimal_Point->CurrentValue);
            }
            $this->Default_Money_Decimal_Point->EditValue = HtmlEncode($this->Default_Money_Decimal_Point->CurrentValue);
            $this->Default_Money_Decimal_Point->PlaceHolder = RemoveHtml($this->Default_Money_Decimal_Point->caption());

            // Terms_And_Condition_Text
            $this->Terms_And_Condition_Text->setupEditAttributes();
            $this->Terms_And_Condition_Text->EditValue = HtmlEncode($this->Terms_And_Condition_Text->CurrentValue);
            $this->Terms_And_Condition_Text->PlaceHolder = RemoveHtml($this->Terms_And_Condition_Text->caption());

            // Announcement_Text
            $this->Announcement_Text->setupEditAttributes();
            $this->Announcement_Text->EditValue = HtmlEncode($this->Announcement_Text->CurrentValue);
            $this->Announcement_Text->PlaceHolder = RemoveHtml($this->Announcement_Text->caption());

            // About_Text
            $this->About_Text->setupEditAttributes();
            $this->About_Text->EditValue = HtmlEncode($this->About_Text->CurrentValue);
            $this->About_Text->PlaceHolder = RemoveHtml($this->About_Text->caption());

            // Edit refer script

            // Language_Code
            $this->Language_Code->HrefValue = "";

            // Language_Name
            $this->Language_Name->HrefValue = "";

            // Default
            $this->_Default->HrefValue = "";

            // Site_Logo
            $this->Site_Logo->HrefValue = "";

            // Site_Title
            $this->Site_Title->HrefValue = "";

            // Default_Thousands_Separator
            $this->Default_Thousands_Separator->HrefValue = "";

            // Default_Decimal_Point
            $this->Default_Decimal_Point->HrefValue = "";

            // Default_Currency_Symbol
            $this->Default_Currency_Symbol->HrefValue = "";

            // Default_Money_Thousands_Separator
            $this->Default_Money_Thousands_Separator->HrefValue = "";

            // Default_Money_Decimal_Point
            $this->Default_Money_Decimal_Point->HrefValue = "";

            // Terms_And_Condition_Text
            $this->Terms_And_Condition_Text->HrefValue = "";

            // Announcement_Text
            $this->Announcement_Text->HrefValue = "";

            // About_Text
            $this->About_Text->HrefValue = "";
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
        if ($this->Language_Code->Required) {
            if (!$this->Language_Code->IsDetailKey && EmptyValue($this->Language_Code->FormValue)) {
                $this->Language_Code->addErrorMessage(str_replace("%s", $this->Language_Code->caption(), $this->Language_Code->RequiredErrorMessage));
            }
        }
        if ($this->Language_Name->Required) {
            if (!$this->Language_Name->IsDetailKey && EmptyValue($this->Language_Name->FormValue)) {
                $this->Language_Name->addErrorMessage(str_replace("%s", $this->Language_Name->caption(), $this->Language_Name->RequiredErrorMessage));
            }
        }
        if ($this->_Default->Required) {
            if ($this->_Default->FormValue == "") {
                $this->_Default->addErrorMessage(str_replace("%s", $this->_Default->caption(), $this->_Default->RequiredErrorMessage));
            }
        }
        if ($this->Site_Logo->Required) {
            if (!$this->Site_Logo->IsDetailKey && EmptyValue($this->Site_Logo->FormValue)) {
                $this->Site_Logo->addErrorMessage(str_replace("%s", $this->Site_Logo->caption(), $this->Site_Logo->RequiredErrorMessage));
            }
        }
        if ($this->Site_Title->Required) {
            if (!$this->Site_Title->IsDetailKey && EmptyValue($this->Site_Title->FormValue)) {
                $this->Site_Title->addErrorMessage(str_replace("%s", $this->Site_Title->caption(), $this->Site_Title->RequiredErrorMessage));
            }
        }
        if ($this->Default_Thousands_Separator->Required) {
            if (!$this->Default_Thousands_Separator->IsDetailKey && EmptyValue($this->Default_Thousands_Separator->FormValue)) {
                $this->Default_Thousands_Separator->addErrorMessage(str_replace("%s", $this->Default_Thousands_Separator->caption(), $this->Default_Thousands_Separator->RequiredErrorMessage));
            }
        }
        if ($this->Default_Decimal_Point->Required) {
            if (!$this->Default_Decimal_Point->IsDetailKey && EmptyValue($this->Default_Decimal_Point->FormValue)) {
                $this->Default_Decimal_Point->addErrorMessage(str_replace("%s", $this->Default_Decimal_Point->caption(), $this->Default_Decimal_Point->RequiredErrorMessage));
            }
        }
        if ($this->Default_Currency_Symbol->Required) {
            if (!$this->Default_Currency_Symbol->IsDetailKey && EmptyValue($this->Default_Currency_Symbol->FormValue)) {
                $this->Default_Currency_Symbol->addErrorMessage(str_replace("%s", $this->Default_Currency_Symbol->caption(), $this->Default_Currency_Symbol->RequiredErrorMessage));
            }
        }
        if ($this->Default_Money_Thousands_Separator->Required) {
            if (!$this->Default_Money_Thousands_Separator->IsDetailKey && EmptyValue($this->Default_Money_Thousands_Separator->FormValue)) {
                $this->Default_Money_Thousands_Separator->addErrorMessage(str_replace("%s", $this->Default_Money_Thousands_Separator->caption(), $this->Default_Money_Thousands_Separator->RequiredErrorMessage));
            }
        }
        if ($this->Default_Money_Decimal_Point->Required) {
            if (!$this->Default_Money_Decimal_Point->IsDetailKey && EmptyValue($this->Default_Money_Decimal_Point->FormValue)) {
                $this->Default_Money_Decimal_Point->addErrorMessage(str_replace("%s", $this->Default_Money_Decimal_Point->caption(), $this->Default_Money_Decimal_Point->RequiredErrorMessage));
            }
        }
        if ($this->Terms_And_Condition_Text->Required) {
            if (!$this->Terms_And_Condition_Text->IsDetailKey && EmptyValue($this->Terms_And_Condition_Text->FormValue)) {
                $this->Terms_And_Condition_Text->addErrorMessage(str_replace("%s", $this->Terms_And_Condition_Text->caption(), $this->Terms_And_Condition_Text->RequiredErrorMessage));
            }
        }
        if ($this->Announcement_Text->Required) {
            if (!$this->Announcement_Text->IsDetailKey && EmptyValue($this->Announcement_Text->FormValue)) {
                $this->Announcement_Text->addErrorMessage(str_replace("%s", $this->Announcement_Text->caption(), $this->Announcement_Text->RequiredErrorMessage));
            }
        }
        if ($this->About_Text->Required) {
            if (!$this->About_Text->IsDetailKey && EmptyValue($this->About_Text->FormValue)) {
                $this->About_Text->addErrorMessage(str_replace("%s", $this->About_Text->caption(), $this->About_Text->RequiredErrorMessage));
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

        // Language_Code
        $this->Language_Code->setDbValueDef($rsnew, $this->Language_Code->CurrentValue, $this->Language_Code->ReadOnly);

        // Language_Name
        $this->Language_Name->setDbValueDef($rsnew, $this->Language_Name->CurrentValue, $this->Language_Name->ReadOnly);

        // Default
        $tmpBool = $this->_Default->CurrentValue;
        if ($tmpBool != "Y" && $tmpBool != "N") {
            $tmpBool = !empty($tmpBool) ? "Y" : "N";
        }
        $this->_Default->setDbValueDef($rsnew, $tmpBool, $this->_Default->ReadOnly);

        // Site_Logo
        $this->Site_Logo->setDbValueDef($rsnew, $this->Site_Logo->CurrentValue, $this->Site_Logo->ReadOnly);

        // Site_Title
        $this->Site_Title->setDbValueDef($rsnew, $this->Site_Title->CurrentValue, $this->Site_Title->ReadOnly);

        // Default_Thousands_Separator
        $this->Default_Thousands_Separator->setDbValueDef($rsnew, $this->Default_Thousands_Separator->CurrentValue, $this->Default_Thousands_Separator->ReadOnly);

        // Default_Decimal_Point
        $this->Default_Decimal_Point->setDbValueDef($rsnew, $this->Default_Decimal_Point->CurrentValue, $this->Default_Decimal_Point->ReadOnly);

        // Default_Currency_Symbol
        $this->Default_Currency_Symbol->setDbValueDef($rsnew, $this->Default_Currency_Symbol->CurrentValue, $this->Default_Currency_Symbol->ReadOnly);

        // Default_Money_Thousands_Separator
        $this->Default_Money_Thousands_Separator->setDbValueDef($rsnew, $this->Default_Money_Thousands_Separator->CurrentValue, $this->Default_Money_Thousands_Separator->ReadOnly);

        // Default_Money_Decimal_Point
        $this->Default_Money_Decimal_Point->setDbValueDef($rsnew, $this->Default_Money_Decimal_Point->CurrentValue, $this->Default_Money_Decimal_Point->ReadOnly);

        // Terms_And_Condition_Text
        $this->Terms_And_Condition_Text->setDbValueDef($rsnew, $this->Terms_And_Condition_Text->CurrentValue, $this->Terms_And_Condition_Text->ReadOnly);

        // Announcement_Text
        $this->Announcement_Text->setDbValueDef($rsnew, $this->Announcement_Text->CurrentValue, $this->Announcement_Text->ReadOnly);

        // About_Text
        $this->About_Text->setDbValueDef($rsnew, $this->About_Text->CurrentValue, $this->About_Text->ReadOnly);

        // Update current values
        $this->setCurrentValues($rsnew);

        // Call Row Updating event
        $updateRow = $this->rowUpdating($rsold, $rsnew);

        // Check for duplicate key when key changed
        if ($updateRow) {
            $newKeyFilter = $this->getRecordFilter($rsnew);
            if ($newKeyFilter != $oldKeyFilter) {
                $rsChk = $this->loadRs($newKeyFilter)->fetch();
                if ($rsChk !== false) {
                    $keyErrMsg = str_replace("%f", $newKeyFilter, $Language->phrase("DupKey"));
                    $this->setFailureMessage($keyErrMsg);
                    $updateRow = false;
                }
            }
        }
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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("languageslist"), "", $this->TableVar, true);
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
                case "x__Default":
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
