<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class AnnouncementEdit extends Announcement
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "AnnouncementEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "announcementedit";

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
        $this->Announcement_ID->setVisibility();
        $this->Is_Active->setVisibility();
        $this->Topic->setVisibility();
        $this->_Message->setVisibility();
        $this->Date_LastUpdate->setVisibility();
        $this->_Language->setVisibility();
        $this->Auto_Publish->setVisibility();
        $this->Date_Start->setVisibility();
        $this->Date_End->setVisibility();
        $this->Date_Created->setVisibility();
        $this->Created_By->setVisibility();
        $this->Translated_ID->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'announcement';
        $this->TableName = 'announcement';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (announcement)
        if (!isset($GLOBALS["announcement"]) || get_class($GLOBALS["announcement"]) == PROJECT_NAMESPACE . "announcement") {
            $GLOBALS["announcement"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'announcement');
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
                    $result["view"] = $pageName == "announcementview"; // If View page, no primary button
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
            $key .= @$ar['Announcement_ID'];
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
            $this->Announcement_ID->Visible = false;
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
        $this->setupLookupOptions($this->Is_Active);
        $this->setupLookupOptions($this->_Language);
        $this->setupLookupOptions($this->Auto_Publish);
        $this->setupLookupOptions($this->Created_By);
        $this->setupLookupOptions($this->Translated_ID);
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
            if (($keyValue = Get("Announcement_ID") ?? Key(0) ?? Route(2)) !== null) {
                $this->Announcement_ID->setQueryStringValue($keyValue);
                $this->Announcement_ID->setOldValue($this->Announcement_ID->QueryStringValue);
            } elseif (Post("Announcement_ID") !== null) {
                $this->Announcement_ID->setFormValue(Post("Announcement_ID"));
                $this->Announcement_ID->setOldValue($this->Announcement_ID->FormValue);
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
                if (($keyValue = Get("Announcement_ID") ?? Route("Announcement_ID")) !== null) {
                    $this->Announcement_ID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Announcement_ID->CurrentValue = null;
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
                        $this->terminate("announcementlist"); // Return to list page
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
                        if ($this->Announcement_ID->CurrentValue != null) {
                            while (!$rs->EOF) {
                                if (SameString($this->Announcement_ID->CurrentValue, $rs->fields['Announcement_ID'])) {
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
                        $this->terminate("announcementlist"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("announcementlist"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "announcementlist") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) {
                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "announcementlist") {
                            Container("flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "announcementlist"; // Return list page content
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

        // Check field name 'Announcement_ID' first before field var 'x_Announcement_ID'
        $val = $CurrentForm->hasValue("Announcement_ID") ? $CurrentForm->getValue("Announcement_ID") : $CurrentForm->getValue("x_Announcement_ID");
        if (!$this->Announcement_ID->IsDetailKey) {
            $this->Announcement_ID->setFormValue($val);
        }

        // Check field name 'Is_Active' first before field var 'x_Is_Active'
        $val = $CurrentForm->hasValue("Is_Active") ? $CurrentForm->getValue("Is_Active") : $CurrentForm->getValue("x_Is_Active");
        if (!$this->Is_Active->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Is_Active->Visible = false; // Disable update for API request
            } else {
                $this->Is_Active->setFormValue($val);
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

        // Check field name 'Message' first before field var 'x__Message'
        $val = $CurrentForm->hasValue("Message") ? $CurrentForm->getValue("Message") : $CurrentForm->getValue("x__Message");
        if (!$this->_Message->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_Message->Visible = false; // Disable update for API request
            } else {
                $this->_Message->setFormValue($val);
            }
        }

        // Check field name 'Date_LastUpdate' first before field var 'x_Date_LastUpdate'
        $val = $CurrentForm->hasValue("Date_LastUpdate") ? $CurrentForm->getValue("Date_LastUpdate") : $CurrentForm->getValue("x_Date_LastUpdate");
        if (!$this->Date_LastUpdate->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Date_LastUpdate->Visible = false; // Disable update for API request
            } else {
                $this->Date_LastUpdate->setFormValue($val, true, $validate);
            }
            $this->Date_LastUpdate->CurrentValue = UnFormatDateTime($this->Date_LastUpdate->CurrentValue, $this->Date_LastUpdate->formatPattern());
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

        // Check field name 'Auto_Publish' first before field var 'x_Auto_Publish'
        $val = $CurrentForm->hasValue("Auto_Publish") ? $CurrentForm->getValue("Auto_Publish") : $CurrentForm->getValue("x_Auto_Publish");
        if (!$this->Auto_Publish->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Auto_Publish->Visible = false; // Disable update for API request
            } else {
                $this->Auto_Publish->setFormValue($val);
            }
        }

        // Check field name 'Date_Start' first before field var 'x_Date_Start'
        $val = $CurrentForm->hasValue("Date_Start") ? $CurrentForm->getValue("Date_Start") : $CurrentForm->getValue("x_Date_Start");
        if (!$this->Date_Start->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Date_Start->Visible = false; // Disable update for API request
            } else {
                $this->Date_Start->setFormValue($val, true, $validate);
            }
            $this->Date_Start->CurrentValue = UnFormatDateTime($this->Date_Start->CurrentValue, $this->Date_Start->formatPattern());
        }

        // Check field name 'Date_End' first before field var 'x_Date_End'
        $val = $CurrentForm->hasValue("Date_End") ? $CurrentForm->getValue("Date_End") : $CurrentForm->getValue("x_Date_End");
        if (!$this->Date_End->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Date_End->Visible = false; // Disable update for API request
            } else {
                $this->Date_End->setFormValue($val, true, $validate);
            }
            $this->Date_End->CurrentValue = UnFormatDateTime($this->Date_End->CurrentValue, $this->Date_End->formatPattern());
        }

        // Check field name 'Date_Created' first before field var 'x_Date_Created'
        $val = $CurrentForm->hasValue("Date_Created") ? $CurrentForm->getValue("Date_Created") : $CurrentForm->getValue("x_Date_Created");
        if (!$this->Date_Created->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Date_Created->Visible = false; // Disable update for API request
            } else {
                $this->Date_Created->setFormValue($val, true, $validate);
            }
            $this->Date_Created->CurrentValue = UnFormatDateTime($this->Date_Created->CurrentValue, $this->Date_Created->formatPattern());
        }

        // Check field name 'Created_By' first before field var 'x_Created_By'
        $val = $CurrentForm->hasValue("Created_By") ? $CurrentForm->getValue("Created_By") : $CurrentForm->getValue("x_Created_By");
        if (!$this->Created_By->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Created_By->Visible = false; // Disable update for API request
            } else {
                $this->Created_By->setFormValue($val);
            }
        }

        // Check field name 'Translated_ID' first before field var 'x_Translated_ID'
        $val = $CurrentForm->hasValue("Translated_ID") ? $CurrentForm->getValue("Translated_ID") : $CurrentForm->getValue("x_Translated_ID");
        if (!$this->Translated_ID->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Translated_ID->Visible = false; // Disable update for API request
            } else {
                $this->Translated_ID->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Announcement_ID->CurrentValue = $this->Announcement_ID->FormValue;
        $this->Is_Active->CurrentValue = $this->Is_Active->FormValue;
        $this->Topic->CurrentValue = $this->Topic->FormValue;
        $this->_Message->CurrentValue = $this->_Message->FormValue;
        $this->Date_LastUpdate->CurrentValue = $this->Date_LastUpdate->FormValue;
        $this->Date_LastUpdate->CurrentValue = UnFormatDateTime($this->Date_LastUpdate->CurrentValue, $this->Date_LastUpdate->formatPattern());
        $this->_Language->CurrentValue = $this->_Language->FormValue;
        $this->Auto_Publish->CurrentValue = $this->Auto_Publish->FormValue;
        $this->Date_Start->CurrentValue = $this->Date_Start->FormValue;
        $this->Date_Start->CurrentValue = UnFormatDateTime($this->Date_Start->CurrentValue, $this->Date_Start->formatPattern());
        $this->Date_End->CurrentValue = $this->Date_End->FormValue;
        $this->Date_End->CurrentValue = UnFormatDateTime($this->Date_End->CurrentValue, $this->Date_End->formatPattern());
        $this->Date_Created->CurrentValue = $this->Date_Created->FormValue;
        $this->Date_Created->CurrentValue = UnFormatDateTime($this->Date_Created->CurrentValue, $this->Date_Created->formatPattern());
        $this->Created_By->CurrentValue = $this->Created_By->FormValue;
        $this->Translated_ID->CurrentValue = $this->Translated_ID->FormValue;
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
        $this->Announcement_ID->setDbValue($row['Announcement_ID']);
        $this->Is_Active->setDbValue($row['Is_Active']);
        $this->Topic->setDbValue($row['Topic']);
        $this->_Message->setDbValue($row['Message']);
        $this->Date_LastUpdate->setDbValue($row['Date_LastUpdate']);
        $this->_Language->setDbValue($row['Language']);
        $this->Auto_Publish->setDbValue($row['Auto_Publish']);
        $this->Date_Start->setDbValue($row['Date_Start']);
        $this->Date_End->setDbValue($row['Date_End']);
        $this->Date_Created->setDbValue($row['Date_Created']);
        $this->Created_By->setDbValue($row['Created_By']);
        $this->Translated_ID->setDbValue($row['Translated_ID']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Announcement_ID'] = $this->Announcement_ID->DefaultValue;
        $row['Is_Active'] = $this->Is_Active->DefaultValue;
        $row['Topic'] = $this->Topic->DefaultValue;
        $row['Message'] = $this->_Message->DefaultValue;
        $row['Date_LastUpdate'] = $this->Date_LastUpdate->DefaultValue;
        $row['Language'] = $this->_Language->DefaultValue;
        $row['Auto_Publish'] = $this->Auto_Publish->DefaultValue;
        $row['Date_Start'] = $this->Date_Start->DefaultValue;
        $row['Date_End'] = $this->Date_End->DefaultValue;
        $row['Date_Created'] = $this->Date_Created->DefaultValue;
        $row['Created_By'] = $this->Created_By->DefaultValue;
        $row['Translated_ID'] = $this->Translated_ID->DefaultValue;
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

        // Announcement_ID
        $this->Announcement_ID->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Is_Active
        $this->Is_Active->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Topic
        $this->Topic->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Message
        $this->_Message->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Date_LastUpdate
        $this->Date_LastUpdate->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Language
        $this->_Language->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Auto_Publish
        $this->Auto_Publish->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Date_Start
        $this->Date_Start->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Date_End
        $this->Date_End->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Date_Created
        $this->Date_Created->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Created_By
        $this->Created_By->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Translated_ID
        $this->Translated_ID->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // Announcement_ID
            $this->Announcement_ID->ViewValue = $this->Announcement_ID->CurrentValue;

            // Is_Active
            if (ConvertToBool($this->Is_Active->CurrentValue)) {
                $this->Is_Active->ViewValue = $this->Is_Active->tagCaption(2) != "" ? $this->Is_Active->tagCaption(2) : "Y";
            } else {
                $this->Is_Active->ViewValue = $this->Is_Active->tagCaption(1) != "" ? $this->Is_Active->tagCaption(1) : "N";
            }

            // Topic
            $this->Topic->ViewValue = $this->Topic->CurrentValue;

            // Message
            $this->_Message->ViewValue = $this->_Message->CurrentValue;

            // Date_LastUpdate
            $this->Date_LastUpdate->ViewValue = $this->Date_LastUpdate->CurrentValue;
            $this->Date_LastUpdate->ViewValue = FormatDateTime($this->Date_LastUpdate->ViewValue, $this->Date_LastUpdate->formatPattern());

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

            // Auto_Publish
            if (ConvertToBool($this->Auto_Publish->CurrentValue)) {
                $this->Auto_Publish->ViewValue = $this->Auto_Publish->tagCaption(1) != "" ? $this->Auto_Publish->tagCaption(1) : "Y";
            } else {
                $this->Auto_Publish->ViewValue = $this->Auto_Publish->tagCaption(2) != "" ? $this->Auto_Publish->tagCaption(2) : "N";
            }

            // Date_Start
            $this->Date_Start->ViewValue = $this->Date_Start->CurrentValue;
            $this->Date_Start->ViewValue = FormatDateTime($this->Date_Start->ViewValue, $this->Date_Start->formatPattern());

            // Date_End
            $this->Date_End->ViewValue = $this->Date_End->CurrentValue;
            $this->Date_End->ViewValue = FormatDateTime($this->Date_End->ViewValue, $this->Date_End->formatPattern());

            // Date_Created
            $this->Date_Created->ViewValue = $this->Date_Created->CurrentValue;
            $this->Date_Created->ViewValue = FormatDateTime($this->Date_Created->ViewValue, $this->Date_Created->formatPattern());

            // Created_By
            $curVal = strval($this->Created_By->CurrentValue);
            if ($curVal != "") {
                $this->Created_By->ViewValue = $this->Created_By->lookupCacheOption($curVal);
                if ($this->Created_By->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`Username`", "=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->Created_By->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->Created_By->Lookup->renderViewRow($rswrk[0]);
                        $this->Created_By->ViewValue = $this->Created_By->displayValue($arwrk);
                    } else {
                        $this->Created_By->ViewValue = $this->Created_By->CurrentValue;
                    }
                }
            } else {
                $this->Created_By->ViewValue = null;
            }

            // Translated_ID
            $curVal = strval($this->Translated_ID->CurrentValue);
            if ($curVal != "") {
                $this->Translated_ID->ViewValue = $this->Translated_ID->lookupCacheOption($curVal);
                if ($this->Translated_ID->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`Announcement_ID`", "=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->Translated_ID->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->Translated_ID->Lookup->renderViewRow($rswrk[0]);
                        $this->Translated_ID->ViewValue = $this->Translated_ID->displayValue($arwrk);
                    } else {
                        $this->Translated_ID->ViewValue = FormatNumber($this->Translated_ID->CurrentValue, $this->Translated_ID->formatPattern());
                    }
                }
            } else {
                $this->Translated_ID->ViewValue = null;
            }

            // Announcement_ID
            $this->Announcement_ID->HrefValue = "";

            // Is_Active
            $this->Is_Active->HrefValue = "";

            // Topic
            $this->Topic->HrefValue = "";

            // Message
            $this->_Message->HrefValue = "";

            // Date_LastUpdate
            $this->Date_LastUpdate->HrefValue = "";

            // Language
            $this->_Language->HrefValue = "";

            // Auto_Publish
            $this->Auto_Publish->HrefValue = "";

            // Date_Start
            $this->Date_Start->HrefValue = "";

            // Date_End
            $this->Date_End->HrefValue = "";

            // Date_Created
            $this->Date_Created->HrefValue = "";

            // Created_By
            $this->Created_By->HrefValue = "";

            // Translated_ID
            $this->Translated_ID->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // Announcement_ID
            $this->Announcement_ID->setupEditAttributes();
            $this->Announcement_ID->EditValue = $this->Announcement_ID->CurrentValue;

            // Is_Active
            $this->Is_Active->EditValue = $this->Is_Active->options(false);
            $this->Is_Active->PlaceHolder = RemoveHtml($this->Is_Active->caption());

            // Topic
            $this->Topic->setupEditAttributes();
            if (!$this->Topic->Raw) {
                $this->Topic->CurrentValue = HtmlDecode($this->Topic->CurrentValue);
            }
            $this->Topic->EditValue = HtmlEncode($this->Topic->CurrentValue);
            $this->Topic->PlaceHolder = RemoveHtml($this->Topic->caption());

            // Message
            $this->_Message->setupEditAttributes();
            $this->_Message->EditValue = HtmlEncode($this->_Message->CurrentValue);
            $this->_Message->PlaceHolder = RemoveHtml($this->_Message->caption());

            // Date_LastUpdate
            $this->Date_LastUpdate->setupEditAttributes();
            $this->Date_LastUpdate->EditValue = HtmlEncode(FormatDateTime($this->Date_LastUpdate->CurrentValue, $this->Date_LastUpdate->formatPattern()));
            $this->Date_LastUpdate->PlaceHolder = RemoveHtml($this->Date_LastUpdate->caption());

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

            // Auto_Publish
            $this->Auto_Publish->EditValue = $this->Auto_Publish->options(false);
            $this->Auto_Publish->PlaceHolder = RemoveHtml($this->Auto_Publish->caption());

            // Date_Start
            $this->Date_Start->setupEditAttributes();
            $this->Date_Start->EditValue = HtmlEncode(FormatDateTime($this->Date_Start->CurrentValue, $this->Date_Start->formatPattern()));
            $this->Date_Start->PlaceHolder = RemoveHtml($this->Date_Start->caption());

            // Date_End
            $this->Date_End->setupEditAttributes();
            $this->Date_End->EditValue = HtmlEncode(FormatDateTime($this->Date_End->CurrentValue, $this->Date_End->formatPattern()));
            $this->Date_End->PlaceHolder = RemoveHtml($this->Date_End->caption());

            // Date_Created
            $this->Date_Created->setupEditAttributes();
            $this->Date_Created->EditValue = HtmlEncode(FormatDateTime($this->Date_Created->CurrentValue, $this->Date_Created->formatPattern()));
            $this->Date_Created->PlaceHolder = RemoveHtml($this->Date_Created->caption());

            // Created_By
            $this->Created_By->setupEditAttributes();
            $curVal = trim(strval($this->Created_By->CurrentValue));
            if ($curVal != "") {
                $this->Created_By->ViewValue = $this->Created_By->lookupCacheOption($curVal);
            } else {
                $this->Created_By->ViewValue = $this->Created_By->Lookup !== null && is_array($this->Created_By->lookupOptions()) && count($this->Created_By->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->Created_By->ViewValue !== null) { // Load from cache
                $this->Created_By->EditValue = array_values($this->Created_By->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`Username`", "=", $this->Created_By->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->Created_By->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->Created_By->EditValue = $arwrk;
            }
            $this->Created_By->PlaceHolder = RemoveHtml($this->Created_By->caption());

            // Translated_ID
            $this->Translated_ID->setupEditAttributes();
            $curVal = trim(strval($this->Translated_ID->CurrentValue));
            if ($curVal != "") {
                $this->Translated_ID->ViewValue = $this->Translated_ID->lookupCacheOption($curVal);
            } else {
                $this->Translated_ID->ViewValue = $this->Translated_ID->Lookup !== null && is_array($this->Translated_ID->lookupOptions()) && count($this->Translated_ID->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->Translated_ID->ViewValue !== null) { // Load from cache
                $this->Translated_ID->EditValue = array_values($this->Translated_ID->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`Announcement_ID`", "=", $this->Translated_ID->CurrentValue, DATATYPE_NUMBER, "");
                }
                $sqlWrk = $this->Translated_ID->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->Translated_ID->EditValue = $arwrk;
            }
            $this->Translated_ID->PlaceHolder = RemoveHtml($this->Translated_ID->caption());

            // Edit refer script

            // Announcement_ID
            $this->Announcement_ID->HrefValue = "";

            // Is_Active
            $this->Is_Active->HrefValue = "";

            // Topic
            $this->Topic->HrefValue = "";

            // Message
            $this->_Message->HrefValue = "";

            // Date_LastUpdate
            $this->Date_LastUpdate->HrefValue = "";

            // Language
            $this->_Language->HrefValue = "";

            // Auto_Publish
            $this->Auto_Publish->HrefValue = "";

            // Date_Start
            $this->Date_Start->HrefValue = "";

            // Date_End
            $this->Date_End->HrefValue = "";

            // Date_Created
            $this->Date_Created->HrefValue = "";

            // Created_By
            $this->Created_By->HrefValue = "";

            // Translated_ID
            $this->Translated_ID->HrefValue = "";
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
        if ($this->Announcement_ID->Required) {
            if (!$this->Announcement_ID->IsDetailKey && EmptyValue($this->Announcement_ID->FormValue)) {
                $this->Announcement_ID->addErrorMessage(str_replace("%s", $this->Announcement_ID->caption(), $this->Announcement_ID->RequiredErrorMessage));
            }
        }
        if ($this->Is_Active->Required) {
            if ($this->Is_Active->FormValue == "") {
                $this->Is_Active->addErrorMessage(str_replace("%s", $this->Is_Active->caption(), $this->Is_Active->RequiredErrorMessage));
            }
        }
        if ($this->Topic->Required) {
            if (!$this->Topic->IsDetailKey && EmptyValue($this->Topic->FormValue)) {
                $this->Topic->addErrorMessage(str_replace("%s", $this->Topic->caption(), $this->Topic->RequiredErrorMessage));
            }
        }
        if ($this->_Message->Required) {
            if (!$this->_Message->IsDetailKey && EmptyValue($this->_Message->FormValue)) {
                $this->_Message->addErrorMessage(str_replace("%s", $this->_Message->caption(), $this->_Message->RequiredErrorMessage));
            }
        }
        if ($this->Date_LastUpdate->Required) {
            if (!$this->Date_LastUpdate->IsDetailKey && EmptyValue($this->Date_LastUpdate->FormValue)) {
                $this->Date_LastUpdate->addErrorMessage(str_replace("%s", $this->Date_LastUpdate->caption(), $this->Date_LastUpdate->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->Date_LastUpdate->FormValue, $this->Date_LastUpdate->formatPattern())) {
            $this->Date_LastUpdate->addErrorMessage($this->Date_LastUpdate->getErrorMessage(false));
        }
        if ($this->_Language->Required) {
            if (!$this->_Language->IsDetailKey && EmptyValue($this->_Language->FormValue)) {
                $this->_Language->addErrorMessage(str_replace("%s", $this->_Language->caption(), $this->_Language->RequiredErrorMessage));
            }
        }
        if ($this->Auto_Publish->Required) {
            if ($this->Auto_Publish->FormValue == "") {
                $this->Auto_Publish->addErrorMessage(str_replace("%s", $this->Auto_Publish->caption(), $this->Auto_Publish->RequiredErrorMessage));
            }
        }
        if ($this->Date_Start->Required) {
            if (!$this->Date_Start->IsDetailKey && EmptyValue($this->Date_Start->FormValue)) {
                $this->Date_Start->addErrorMessage(str_replace("%s", $this->Date_Start->caption(), $this->Date_Start->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->Date_Start->FormValue, $this->Date_Start->formatPattern())) {
            $this->Date_Start->addErrorMessage($this->Date_Start->getErrorMessage(false));
        }
        if ($this->Date_End->Required) {
            if (!$this->Date_End->IsDetailKey && EmptyValue($this->Date_End->FormValue)) {
                $this->Date_End->addErrorMessage(str_replace("%s", $this->Date_End->caption(), $this->Date_End->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->Date_End->FormValue, $this->Date_End->formatPattern())) {
            $this->Date_End->addErrorMessage($this->Date_End->getErrorMessage(false));
        }
        if ($this->Date_Created->Required) {
            if (!$this->Date_Created->IsDetailKey && EmptyValue($this->Date_Created->FormValue)) {
                $this->Date_Created->addErrorMessage(str_replace("%s", $this->Date_Created->caption(), $this->Date_Created->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->Date_Created->FormValue, $this->Date_Created->formatPattern())) {
            $this->Date_Created->addErrorMessage($this->Date_Created->getErrorMessage(false));
        }
        if ($this->Created_By->Required) {
            if (!$this->Created_By->IsDetailKey && EmptyValue($this->Created_By->FormValue)) {
                $this->Created_By->addErrorMessage(str_replace("%s", $this->Created_By->caption(), $this->Created_By->RequiredErrorMessage));
            }
        }
        if ($this->Translated_ID->Required) {
            if (!$this->Translated_ID->IsDetailKey && EmptyValue($this->Translated_ID->FormValue)) {
                $this->Translated_ID->addErrorMessage(str_replace("%s", $this->Translated_ID->caption(), $this->Translated_ID->RequiredErrorMessage));
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

        // Is_Active
        $tmpBool = $this->Is_Active->CurrentValue;
        if ($tmpBool != "Y" && $tmpBool != "N") {
            $tmpBool = !empty($tmpBool) ? "Y" : "N";
        }
        $this->Is_Active->setDbValueDef($rsnew, $tmpBool, $this->Is_Active->ReadOnly);

        // Topic
        $this->Topic->setDbValueDef($rsnew, $this->Topic->CurrentValue, $this->Topic->ReadOnly);

        // Message
        $this->_Message->setDbValueDef($rsnew, $this->_Message->CurrentValue, $this->_Message->ReadOnly);

        // Date_LastUpdate
        $this->Date_LastUpdate->setDbValueDef($rsnew, UnFormatDateTime($this->Date_LastUpdate->CurrentValue, $this->Date_LastUpdate->formatPattern()), $this->Date_LastUpdate->ReadOnly);

        // Language
        $this->_Language->setDbValueDef($rsnew, $this->_Language->CurrentValue, $this->_Language->ReadOnly);

        // Auto_Publish
        $tmpBool = $this->Auto_Publish->CurrentValue;
        if ($tmpBool != "Y" && $tmpBool != "N") {
            $tmpBool = !empty($tmpBool) ? "Y" : "N";
        }
        $this->Auto_Publish->setDbValueDef($rsnew, $tmpBool, $this->Auto_Publish->ReadOnly);

        // Date_Start
        $this->Date_Start->setDbValueDef($rsnew, UnFormatDateTime($this->Date_Start->CurrentValue, $this->Date_Start->formatPattern()), $this->Date_Start->ReadOnly);

        // Date_End
        $this->Date_End->setDbValueDef($rsnew, UnFormatDateTime($this->Date_End->CurrentValue, $this->Date_End->formatPattern()), $this->Date_End->ReadOnly);

        // Date_Created
        $this->Date_Created->setDbValueDef($rsnew, UnFormatDateTime($this->Date_Created->CurrentValue, $this->Date_Created->formatPattern()), $this->Date_Created->ReadOnly);

        // Created_By
        $this->Created_By->setDbValueDef($rsnew, $this->Created_By->CurrentValue, $this->Created_By->ReadOnly);

        // Translated_ID
        $this->Translated_ID->setDbValueDef($rsnew, $this->Translated_ID->CurrentValue, $this->Translated_ID->ReadOnly);

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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("announcementlist"), "", $this->TableVar, true);
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
                case "x_Is_Active":
                    break;
                case "x__Language":
                    break;
                case "x_Auto_Publish":
                    break;
                case "x_Created_By":
                    break;
                case "x_Translated_ID":
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
