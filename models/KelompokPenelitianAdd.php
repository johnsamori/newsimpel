<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class KelompokPenelitianAdd extends KelompokPenelitian
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "KelompokPenelitianAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "kelompokpenelitianadd";

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
        $this->Id_Kelompok->setVisibility();
        $this->Nama_Ketua->setVisibility();
        $this->Nama_Anggota_1->setVisibility();
        $this->Nama_Anggota_2->setVisibility();
        $this->Tanggal->setVisibility();
        $this->IP->setVisibility();
        $this->user->setVisibility();
        $this->user_id->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'kelompok_penelitian';
        $this->TableName = 'kelompok_penelitian';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (kelompok_penelitian)
        if (!isset($GLOBALS["kelompok_penelitian"]) || get_class($GLOBALS["kelompok_penelitian"]) == PROJECT_NAMESPACE . "kelompok_penelitian") {
            $GLOBALS["kelompok_penelitian"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'kelompok_penelitian');
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
                    $result["view"] = $pageName == "kelompokpenelitianview"; // If View page, no primary button
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
            $key .= @$ar['Id_Kelompok'];
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
        $this->setupLookupOptions($this->Nama_Ketua);
        $this->setupLookupOptions($this->Nama_Anggota_1);
        $this->setupLookupOptions($this->Nama_Anggota_2);

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
            if (($keyValue = Get("Id_Kelompok") ?? Route("Id_Kelompok")) !== null) {
                $this->Id_Kelompok->setQueryStringValue($keyValue);
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
                    $this->terminate("kelompokpenelitianlist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "kelompokpenelitianlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "kelompokpenelitianview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "kelompokpenelitianlist") {
                            Container("flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "kelompokpenelitianlist"; // Return list page content
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
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'Id_Kelompok' first before field var 'x_Id_Kelompok'
        $val = $CurrentForm->hasValue("Id_Kelompok") ? $CurrentForm->getValue("Id_Kelompok") : $CurrentForm->getValue("x_Id_Kelompok");
        if (!$this->Id_Kelompok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Id_Kelompok->Visible = false; // Disable update for API request
            } else {
                $this->Id_Kelompok->setFormValue($val);
            }
        }

        // Check field name 'Nama_Ketua' first before field var 'x_Nama_Ketua'
        $val = $CurrentForm->hasValue("Nama_Ketua") ? $CurrentForm->getValue("Nama_Ketua") : $CurrentForm->getValue("x_Nama_Ketua");
        if (!$this->Nama_Ketua->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nama_Ketua->Visible = false; // Disable update for API request
            } else {
                $this->Nama_Ketua->setFormValue($val);
            }
        }

        // Check field name 'Nama_Anggota_1' first before field var 'x_Nama_Anggota_1'
        $val = $CurrentForm->hasValue("Nama_Anggota_1") ? $CurrentForm->getValue("Nama_Anggota_1") : $CurrentForm->getValue("x_Nama_Anggota_1");
        if (!$this->Nama_Anggota_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nama_Anggota_1->Visible = false; // Disable update for API request
            } else {
                $this->Nama_Anggota_1->setFormValue($val);
            }
        }

        // Check field name 'Nama_Anggota_2' first before field var 'x_Nama_Anggota_2'
        $val = $CurrentForm->hasValue("Nama_Anggota_2") ? $CurrentForm->getValue("Nama_Anggota_2") : $CurrentForm->getValue("x_Nama_Anggota_2");
        if (!$this->Nama_Anggota_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nama_Anggota_2->Visible = false; // Disable update for API request
            } else {
                $this->Nama_Anggota_2->setFormValue($val);
            }
        }

        // Check field name 'Tanggal' first before field var 'x_Tanggal'
        $val = $CurrentForm->hasValue("Tanggal") ? $CurrentForm->getValue("Tanggal") : $CurrentForm->getValue("x_Tanggal");
        if (!$this->Tanggal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Tanggal->Visible = false; // Disable update for API request
            } else {
                $this->Tanggal->setFormValue($val);
            }
            $this->Tanggal->CurrentValue = UnFormatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern());
        }

        // Check field name 'IP' first before field var 'x_IP'
        $val = $CurrentForm->hasValue("IP") ? $CurrentForm->getValue("IP") : $CurrentForm->getValue("x_IP");
        if (!$this->IP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->IP->Visible = false; // Disable update for API request
            } else {
                $this->IP->setFormValue($val);
            }
        }

        // Check field name 'user' first before field var 'x_user'
        $val = $CurrentForm->hasValue("user") ? $CurrentForm->getValue("user") : $CurrentForm->getValue("x_user");
        if (!$this->user->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user->Visible = false; // Disable update for API request
            } else {
                $this->user->setFormValue($val);
            }
        }

        // Check field name 'user_id' first before field var 'x_user_id'
        $val = $CurrentForm->hasValue("user_id") ? $CurrentForm->getValue("user_id") : $CurrentForm->getValue("x_user_id");
        if (!$this->user_id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->user_id->Visible = false; // Disable update for API request
            } else {
                $this->user_id->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Id_Kelompok->CurrentValue = $this->Id_Kelompok->FormValue;
        $this->Nama_Ketua->CurrentValue = $this->Nama_Ketua->FormValue;
        $this->Nama_Anggota_1->CurrentValue = $this->Nama_Anggota_1->FormValue;
        $this->Nama_Anggota_2->CurrentValue = $this->Nama_Anggota_2->FormValue;
        $this->Tanggal->CurrentValue = $this->Tanggal->FormValue;
        $this->Tanggal->CurrentValue = UnFormatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern());
        $this->IP->CurrentValue = $this->IP->FormValue;
        $this->user->CurrentValue = $this->user->FormValue;
        $this->user_id->CurrentValue = $this->user_id->FormValue;
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
        $this->Id_Kelompok->setDbValue($row['Id_Kelompok']);
        $this->Nama_Ketua->setDbValue($row['Nama_Ketua']);
        $this->Nama_Anggota_1->setDbValue($row['Nama_Anggota_1']);
        $this->Nama_Anggota_2->setDbValue($row['Nama_Anggota_2']);
        $this->Tanggal->setDbValue($row['Tanggal']);
        $this->IP->setDbValue($row['IP']);
        $this->user->setDbValue($row['user']);
        $this->user_id->setDbValue($row['user_id']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Id_Kelompok'] = $this->Id_Kelompok->DefaultValue;
        $row['Nama_Ketua'] = $this->Nama_Ketua->DefaultValue;
        $row['Nama_Anggota_1'] = $this->Nama_Anggota_1->DefaultValue;
        $row['Nama_Anggota_2'] = $this->Nama_Anggota_2->DefaultValue;
        $row['Tanggal'] = $this->Tanggal->DefaultValue;
        $row['IP'] = $this->IP->DefaultValue;
        $row['user'] = $this->user->DefaultValue;
        $row['user_id'] = $this->user_id->DefaultValue;
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

        // Id_Kelompok
        $this->Id_Kelompok->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Nama_Ketua
        $this->Nama_Ketua->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Nama_Anggota_1
        $this->Nama_Anggota_1->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Nama_Anggota_2
        $this->Nama_Anggota_2->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Tanggal
        $this->Tanggal->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // IP
        $this->IP->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // user
        $this->user->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // user_id
        $this->user_id->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // Id_Kelompok
            $this->Id_Kelompok->ViewValue = $this->Id_Kelompok->CurrentValue;

            // Nama_Ketua
            $curVal = strval($this->Nama_Ketua->CurrentValue);
            if ($curVal != "") {
                $this->Nama_Ketua->ViewValue = $this->Nama_Ketua->lookupCacheOption($curVal);
                if ($this->Nama_Ketua->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`NIDN`", "=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->Nama_Ketua->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->Nama_Ketua->Lookup->renderViewRow($rswrk[0]);
                        $this->Nama_Ketua->ViewValue = $this->Nama_Ketua->displayValue($arwrk);
                    } else {
                        $this->Nama_Ketua->ViewValue = $this->Nama_Ketua->CurrentValue;
                    }
                }
            } else {
                $this->Nama_Ketua->ViewValue = null;
            }

            // Nama_Anggota_1
            $curVal = strval($this->Nama_Anggota_1->CurrentValue);
            if ($curVal != "") {
                $this->Nama_Anggota_1->ViewValue = $this->Nama_Anggota_1->lookupCacheOption($curVal);
                if ($this->Nama_Anggota_1->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`NIDN`", "=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->Nama_Anggota_1->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->Nama_Anggota_1->Lookup->renderViewRow($rswrk[0]);
                        $this->Nama_Anggota_1->ViewValue = $this->Nama_Anggota_1->displayValue($arwrk);
                    } else {
                        $this->Nama_Anggota_1->ViewValue = $this->Nama_Anggota_1->CurrentValue;
                    }
                }
            } else {
                $this->Nama_Anggota_1->ViewValue = null;
            }

            // Nama_Anggota_2
            $curVal = strval($this->Nama_Anggota_2->CurrentValue);
            if ($curVal != "") {
                $this->Nama_Anggota_2->ViewValue = $this->Nama_Anggota_2->lookupCacheOption($curVal);
                if ($this->Nama_Anggota_2->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`NIDN`", "=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->Nama_Anggota_2->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->Nama_Anggota_2->Lookup->renderViewRow($rswrk[0]);
                        $this->Nama_Anggota_2->ViewValue = $this->Nama_Anggota_2->displayValue($arwrk);
                    } else {
                        $this->Nama_Anggota_2->ViewValue = $this->Nama_Anggota_2->CurrentValue;
                    }
                }
            } else {
                $this->Nama_Anggota_2->ViewValue = null;
            }

            // Tanggal
            $this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
            $this->Tanggal->ViewValue = FormatDateTime($this->Tanggal->ViewValue, $this->Tanggal->formatPattern());

            // IP
            $this->IP->ViewValue = $this->IP->CurrentValue;

            // user
            $this->user->ViewValue = $this->user->CurrentValue;

            // user_id
            $this->user_id->ViewValue = $this->user_id->CurrentValue;
            $this->user_id->ViewValue = FormatNumber($this->user_id->ViewValue, $this->user_id->formatPattern());

            // Id_Kelompok
            $this->Id_Kelompok->HrefValue = "";

            // Nama_Ketua
            $this->Nama_Ketua->HrefValue = "";

            // Nama_Anggota_1
            $this->Nama_Anggota_1->HrefValue = "";

            // Nama_Anggota_2
            $this->Nama_Anggota_2->HrefValue = "";

            // Tanggal
            $this->Tanggal->HrefValue = "";

            // IP
            $this->IP->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // user_id
            $this->user_id->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // Id_Kelompok
            $this->Id_Kelompok->setupEditAttributes();
            if (!$this->Id_Kelompok->Raw) {
                $this->Id_Kelompok->CurrentValue = HtmlDecode($this->Id_Kelompok->CurrentValue);
            }
            $this->Id_Kelompok->EditValue = HtmlEncode($this->Id_Kelompok->CurrentValue);
            $this->Id_Kelompok->PlaceHolder = RemoveHtml($this->Id_Kelompok->caption());

            // Nama_Ketua
            $this->Nama_Ketua->setupEditAttributes();
            $curVal = trim(strval($this->Nama_Ketua->CurrentValue));
            if ($curVal != "") {
                $this->Nama_Ketua->ViewValue = $this->Nama_Ketua->lookupCacheOption($curVal);
            } else {
                $this->Nama_Ketua->ViewValue = $this->Nama_Ketua->Lookup !== null && is_array($this->Nama_Ketua->lookupOptions()) && count($this->Nama_Ketua->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->Nama_Ketua->ViewValue !== null) { // Load from cache
                $this->Nama_Ketua->EditValue = array_values($this->Nama_Ketua->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`NIDN`", "=", $this->Nama_Ketua->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->Nama_Ketua->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->Nama_Ketua->EditValue = $arwrk;
            }
            $this->Nama_Ketua->PlaceHolder = RemoveHtml($this->Nama_Ketua->caption());

            // Nama_Anggota_1
            $this->Nama_Anggota_1->setupEditAttributes();
            $curVal = trim(strval($this->Nama_Anggota_1->CurrentValue));
            if ($curVal != "") {
                $this->Nama_Anggota_1->ViewValue = $this->Nama_Anggota_1->lookupCacheOption($curVal);
            } else {
                $this->Nama_Anggota_1->ViewValue = $this->Nama_Anggota_1->Lookup !== null && is_array($this->Nama_Anggota_1->lookupOptions()) && count($this->Nama_Anggota_1->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->Nama_Anggota_1->ViewValue !== null) { // Load from cache
                $this->Nama_Anggota_1->EditValue = array_values($this->Nama_Anggota_1->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`NIDN`", "=", $this->Nama_Anggota_1->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->Nama_Anggota_1->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->Nama_Anggota_1->EditValue = $arwrk;
            }
            $this->Nama_Anggota_1->PlaceHolder = RemoveHtml($this->Nama_Anggota_1->caption());

            // Nama_Anggota_2
            $this->Nama_Anggota_2->setupEditAttributes();
            $curVal = trim(strval($this->Nama_Anggota_2->CurrentValue));
            if ($curVal != "") {
                $this->Nama_Anggota_2->ViewValue = $this->Nama_Anggota_2->lookupCacheOption($curVal);
            } else {
                $this->Nama_Anggota_2->ViewValue = $this->Nama_Anggota_2->Lookup !== null && is_array($this->Nama_Anggota_2->lookupOptions()) && count($this->Nama_Anggota_2->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->Nama_Anggota_2->ViewValue !== null) { // Load from cache
                $this->Nama_Anggota_2->EditValue = array_values($this->Nama_Anggota_2->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`NIDN`", "=", $this->Nama_Anggota_2->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->Nama_Anggota_2->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->Nama_Anggota_2->EditValue = $arwrk;
            }
            $this->Nama_Anggota_2->PlaceHolder = RemoveHtml($this->Nama_Anggota_2->caption());

            // Tanggal

            // IP

            // user

            // user_id

            // Add refer script

            // Id_Kelompok
            $this->Id_Kelompok->HrefValue = "";

            // Nama_Ketua
            $this->Nama_Ketua->HrefValue = "";

            // Nama_Anggota_1
            $this->Nama_Anggota_1->HrefValue = "";

            // Nama_Anggota_2
            $this->Nama_Anggota_2->HrefValue = "";

            // Tanggal
            $this->Tanggal->HrefValue = "";

            // IP
            $this->IP->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // user_id
            $this->user_id->HrefValue = "";
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
        if ($this->Id_Kelompok->Required) {
            if (!$this->Id_Kelompok->IsDetailKey && EmptyValue($this->Id_Kelompok->FormValue)) {
                $this->Id_Kelompok->addErrorMessage(str_replace("%s", $this->Id_Kelompok->caption(), $this->Id_Kelompok->RequiredErrorMessage));
            }
        }
        if ($this->Nama_Ketua->Required) {
            if (!$this->Nama_Ketua->IsDetailKey && EmptyValue($this->Nama_Ketua->FormValue)) {
                $this->Nama_Ketua->addErrorMessage(str_replace("%s", $this->Nama_Ketua->caption(), $this->Nama_Ketua->RequiredErrorMessage));
            }
        }
        if ($this->Nama_Anggota_1->Required) {
            if (!$this->Nama_Anggota_1->IsDetailKey && EmptyValue($this->Nama_Anggota_1->FormValue)) {
                $this->Nama_Anggota_1->addErrorMessage(str_replace("%s", $this->Nama_Anggota_1->caption(), $this->Nama_Anggota_1->RequiredErrorMessage));
            }
        }
        if ($this->Nama_Anggota_2->Required) {
            if (!$this->Nama_Anggota_2->IsDetailKey && EmptyValue($this->Nama_Anggota_2->FormValue)) {
                $this->Nama_Anggota_2->addErrorMessage(str_replace("%s", $this->Nama_Anggota_2->caption(), $this->Nama_Anggota_2->RequiredErrorMessage));
            }
        }
        if ($this->Tanggal->Required) {
            if (!$this->Tanggal->IsDetailKey && EmptyValue($this->Tanggal->FormValue)) {
                $this->Tanggal->addErrorMessage(str_replace("%s", $this->Tanggal->caption(), $this->Tanggal->RequiredErrorMessage));
            }
        }
        if ($this->IP->Required) {
            if (!$this->IP->IsDetailKey && EmptyValue($this->IP->FormValue)) {
                $this->IP->addErrorMessage(str_replace("%s", $this->IP->caption(), $this->IP->RequiredErrorMessage));
            }
        }
        if ($this->user->Required) {
            if (!$this->user->IsDetailKey && EmptyValue($this->user->FormValue)) {
                $this->user->addErrorMessage(str_replace("%s", $this->user->caption(), $this->user->RequiredErrorMessage));
            }
        }
        if ($this->user_id->Required) {
            if (!$this->user_id->IsDetailKey && EmptyValue($this->user_id->FormValue)) {
                $this->user_id->addErrorMessage(str_replace("%s", $this->user_id->caption(), $this->user_id->RequiredErrorMessage));
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

        // Id_Kelompok
        $this->Id_Kelompok->setDbValueDef($rsnew, $this->Id_Kelompok->CurrentValue, false);

        // Nama_Ketua
        $this->Nama_Ketua->setDbValueDef($rsnew, $this->Nama_Ketua->CurrentValue, false);

        // Nama_Anggota_1
        $this->Nama_Anggota_1->setDbValueDef($rsnew, $this->Nama_Anggota_1->CurrentValue, false);

        // Nama_Anggota_2
        $this->Nama_Anggota_2->setDbValueDef($rsnew, $this->Nama_Anggota_2->CurrentValue, false);

        // Tanggal
        $this->Tanggal->CurrentValue = $this->Tanggal->getAutoUpdateValue(); // PHP
        $this->Tanggal->setDbValueDef($rsnew, $this->Tanggal->CurrentValue);

        // IP
        $this->IP->CurrentValue = $this->IP->getAutoUpdateValue(); // PHP
        $this->IP->setDbValueDef($rsnew, $this->IP->CurrentValue);

        // user
        $this->user->CurrentValue = $this->user->getAutoUpdateValue(); // PHP
        $this->user->setDbValueDef($rsnew, $this->user->CurrentValue);

        // user_id
        $this->user_id->CurrentValue = $this->user_id->getAutoUpdateValue(); // PHP
        $this->user_id->setDbValueDef($rsnew, $this->user_id->CurrentValue);

        // Update current values
        $this->setCurrentValues($rsnew);
        if ($this->Nama_Ketua->CurrentValue != "") { // Check field with unique index
            $filter = "(`Nama_Ketua` = '" . AdjustSql($this->Nama_Ketua->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->Nama_Ketua->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->Nama_Ketua->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        if ($this->Nama_Anggota_1->CurrentValue != "") { // Check field with unique index
            $filter = "(`Nama_Anggota_1` = '" . AdjustSql($this->Nama_Anggota_1->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->Nama_Anggota_1->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->Nama_Anggota_1->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['Id_Kelompok']) == "") {
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
            return $Security->isValidUserID($this->user->CurrentValue);
        }
        return true;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("kelompokpenelitianlist"), "", $this->TableVar, true);
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
                case "x_Nama_Ketua":
                    break;
                case "x_Nama_Anggota_1":
                    break;
                case "x_Nama_Anggota_2":
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
