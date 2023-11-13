<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class ProposalPenelitianAdd extends ProposalPenelitian
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ProposalPenelitianAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "proposalpenelitianadd";

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
        $this->Id_kelompok->setVisibility();
        $this->Judul_Penelitian->setVisibility();
        $this->Warna_Kaver->setVisibility();
        $this->Lembar_Pengesahan->setVisibility();
        $this->Soft_copy_Proposal->setVisibility();
        $this->Surat_Pernyataan_Tidak_Studi->setVisibility();
        $this->Tanggal->setVisibility();
        $this->IP->setVisibility();
        $this->user->setVisibility();
        $this->User_Id->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'proposal_penelitian';
        $this->TableName = 'proposal_penelitian';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-add-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (proposal_penelitian)
        if (!isset($GLOBALS["proposal_penelitian"]) || get_class($GLOBALS["proposal_penelitian"]) == PROJECT_NAMESPACE . "proposal_penelitian") {
            $GLOBALS["proposal_penelitian"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'proposal_penelitian');
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
                    $result["view"] = $pageName == "proposalpenelitianview"; // If View page, no primary button
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
            $key .= @$ar['Id_kelompok'];
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
        $this->setupLookupOptions($this->Id_kelompok);
        $this->setupLookupOptions($this->Warna_Kaver);

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
            if (($keyValue = Get("Id_kelompok") ?? Route("Id_kelompok")) !== null) {
                $this->Id_kelompok->setQueryStringValue($keyValue);
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
                    $this->terminate("proposalpenelitianlist"); // No matching record, return to list
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
                    if (GetPageName($returnUrl) == "proposalpenelitianlist") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "proposalpenelitianview") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }

                    // Handle UseAjaxActions
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "proposalpenelitianlist") {
                            Container("flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "proposalpenelitianlist"; // Return list page content
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
        $this->Lembar_Pengesahan->Upload->Index = $CurrentForm->Index;
        $this->Lembar_Pengesahan->Upload->uploadFile();
        $this->Lembar_Pengesahan->CurrentValue = $this->Lembar_Pengesahan->Upload->FileName;
        $this->Soft_copy_Proposal->Upload->Index = $CurrentForm->Index;
        $this->Soft_copy_Proposal->Upload->uploadFile();
        $this->Soft_copy_Proposal->CurrentValue = $this->Soft_copy_Proposal->Upload->FileName;
        $this->Surat_Pernyataan_Tidak_Studi->Upload->Index = $CurrentForm->Index;
        $this->Surat_Pernyataan_Tidak_Studi->Upload->uploadFile();
        $this->Surat_Pernyataan_Tidak_Studi->CurrentValue = $this->Surat_Pernyataan_Tidak_Studi->Upload->FileName;
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

        // Check field name 'Id_kelompok' first before field var 'x_Id_kelompok'
        $val = $CurrentForm->hasValue("Id_kelompok") ? $CurrentForm->getValue("Id_kelompok") : $CurrentForm->getValue("x_Id_kelompok");
        if (!$this->Id_kelompok->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Id_kelompok->Visible = false; // Disable update for API request
            } else {
                $this->Id_kelompok->setFormValue($val);
            }
        }

        // Check field name 'Judul_Penelitian' first before field var 'x_Judul_Penelitian'
        $val = $CurrentForm->hasValue("Judul_Penelitian") ? $CurrentForm->getValue("Judul_Penelitian") : $CurrentForm->getValue("x_Judul_Penelitian");
        if (!$this->Judul_Penelitian->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Judul_Penelitian->Visible = false; // Disable update for API request
            } else {
                $this->Judul_Penelitian->setFormValue($val);
            }
        }

        // Check field name 'Warna_Kaver' first before field var 'x_Warna_Kaver'
        $val = $CurrentForm->hasValue("Warna_Kaver") ? $CurrentForm->getValue("Warna_Kaver") : $CurrentForm->getValue("x_Warna_Kaver");
        if (!$this->Warna_Kaver->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Warna_Kaver->Visible = false; // Disable update for API request
            } else {
                $this->Warna_Kaver->setFormValue($val);
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

        // Check field name 'User_Id' first before field var 'x_User_Id'
        $val = $CurrentForm->hasValue("User_Id") ? $CurrentForm->getValue("User_Id") : $CurrentForm->getValue("x_User_Id");
        if (!$this->User_Id->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->User_Id->Visible = false; // Disable update for API request
            } else {
                $this->User_Id->setFormValue($val);
            }
        }
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Id_kelompok->CurrentValue = $this->Id_kelompok->FormValue;
        $this->Judul_Penelitian->CurrentValue = $this->Judul_Penelitian->FormValue;
        $this->Warna_Kaver->CurrentValue = $this->Warna_Kaver->FormValue;
        $this->Tanggal->CurrentValue = $this->Tanggal->FormValue;
        $this->Tanggal->CurrentValue = UnFormatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern());
        $this->IP->CurrentValue = $this->IP->FormValue;
        $this->user->CurrentValue = $this->user->FormValue;
        $this->User_Id->CurrentValue = $this->User_Id->FormValue;
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
        $this->Id_kelompok->setDbValue($row['Id_kelompok']);
        $this->Judul_Penelitian->setDbValue($row['Judul_Penelitian']);
        $this->Warna_Kaver->setDbValue($row['Warna_Kaver']);
        $this->Lembar_Pengesahan->Upload->DbValue = $row['Lembar_Pengesahan'];
        $this->Lembar_Pengesahan->setDbValue($this->Lembar_Pengesahan->Upload->DbValue);
        $this->Soft_copy_Proposal->Upload->DbValue = $row['Soft_copy_Proposal'];
        $this->Soft_copy_Proposal->setDbValue($this->Soft_copy_Proposal->Upload->DbValue);
        $this->Surat_Pernyataan_Tidak_Studi->Upload->DbValue = $row['Surat_Pernyataan_Tidak_Studi'];
        $this->Surat_Pernyataan_Tidak_Studi->setDbValue($this->Surat_Pernyataan_Tidak_Studi->Upload->DbValue);
        $this->Tanggal->setDbValue($row['Tanggal']);
        $this->IP->setDbValue($row['IP']);
        $this->user->setDbValue($row['user']);
        $this->User_Id->setDbValue($row['User_Id']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Id_kelompok'] = $this->Id_kelompok->DefaultValue;
        $row['Judul_Penelitian'] = $this->Judul_Penelitian->DefaultValue;
        $row['Warna_Kaver'] = $this->Warna_Kaver->DefaultValue;
        $row['Lembar_Pengesahan'] = $this->Lembar_Pengesahan->DefaultValue;
        $row['Soft_copy_Proposal'] = $this->Soft_copy_Proposal->DefaultValue;
        $row['Surat_Pernyataan_Tidak_Studi'] = $this->Surat_Pernyataan_Tidak_Studi->DefaultValue;
        $row['Tanggal'] = $this->Tanggal->DefaultValue;
        $row['IP'] = $this->IP->DefaultValue;
        $row['user'] = $this->user->DefaultValue;
        $row['User_Id'] = $this->User_Id->DefaultValue;
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

        // Id_kelompok
        $this->Id_kelompok->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Judul_Penelitian
        $this->Judul_Penelitian->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Warna_Kaver
        $this->Warna_Kaver->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Lembar_Pengesahan
        $this->Lembar_Pengesahan->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Soft_copy_Proposal
        $this->Soft_copy_Proposal->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Surat_Pernyataan_Tidak_Studi
        $this->Surat_Pernyataan_Tidak_Studi->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Tanggal
        $this->Tanggal->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // IP
        $this->IP->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // user
        $this->user->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // User_Id
        $this->User_Id->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // Id_kelompok
            $curVal = strval($this->Id_kelompok->CurrentValue);
            if ($curVal != "") {
                $this->Id_kelompok->ViewValue = $this->Id_kelompok->lookupCacheOption($curVal);
                if ($this->Id_kelompok->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`Id_Kelompok`", "=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->Id_kelompok->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->Id_kelompok->Lookup->renderViewRow($rswrk[0]);
                        $this->Id_kelompok->ViewValue = $this->Id_kelompok->displayValue($arwrk);
                    } else {
                        $this->Id_kelompok->ViewValue = $this->Id_kelompok->CurrentValue;
                    }
                }
            } else {
                $this->Id_kelompok->ViewValue = null;
            }

            // Judul_Penelitian
            $this->Judul_Penelitian->ViewValue = $this->Judul_Penelitian->CurrentValue;

            // Warna_Kaver
            $curVal = strval($this->Warna_Kaver->CurrentValue);
            if ($curVal != "") {
                $this->Warna_Kaver->ViewValue = $this->Warna_Kaver->lookupCacheOption($curVal);
                if ($this->Warna_Kaver->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`Warna_kaver`", "=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->Warna_Kaver->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->Warna_Kaver->Lookup->renderViewRow($rswrk[0]);
                        $this->Warna_Kaver->ViewValue = $this->Warna_Kaver->displayValue($arwrk);
                    } else {
                        $this->Warna_Kaver->ViewValue = $this->Warna_Kaver->CurrentValue;
                    }
                }
            } else {
                $this->Warna_Kaver->ViewValue = null;
            }

            // Lembar_Pengesahan
            if (!EmptyValue($this->Lembar_Pengesahan->Upload->DbValue)) {
                $this->Lembar_Pengesahan->ViewValue = $this->Lembar_Pengesahan->Upload->DbValue;
            } else {
                $this->Lembar_Pengesahan->ViewValue = "";
            }

            // Soft_copy_Proposal
            if (!EmptyValue($this->Soft_copy_Proposal->Upload->DbValue)) {
                $this->Soft_copy_Proposal->ViewValue = $this->Soft_copy_Proposal->Upload->DbValue;
            } else {
                $this->Soft_copy_Proposal->ViewValue = "";
            }

            // Surat_Pernyataan_Tidak_Studi
            if (!EmptyValue($this->Surat_Pernyataan_Tidak_Studi->Upload->DbValue)) {
                $this->Surat_Pernyataan_Tidak_Studi->ViewValue = $this->Surat_Pernyataan_Tidak_Studi->Upload->DbValue;
            } else {
                $this->Surat_Pernyataan_Tidak_Studi->ViewValue = "";
            }

            // Tanggal
            $this->Tanggal->ViewValue = $this->Tanggal->CurrentValue;
            $this->Tanggal->ViewValue = FormatDateTime($this->Tanggal->ViewValue, $this->Tanggal->formatPattern());

            // IP
            $this->IP->ViewValue = $this->IP->CurrentValue;

            // user
            $this->user->ViewValue = $this->user->CurrentValue;

            // User_Id
            $this->User_Id->ViewValue = $this->User_Id->CurrentValue;
            $this->User_Id->ViewValue = FormatNumber($this->User_Id->ViewValue, $this->User_Id->formatPattern());

            // Id_kelompok
            $this->Id_kelompok->HrefValue = "";

            // Judul_Penelitian
            $this->Judul_Penelitian->HrefValue = "";

            // Warna_Kaver
            $this->Warna_Kaver->HrefValue = "";

            // Lembar_Pengesahan
            $this->Lembar_Pengesahan->HrefValue = "";
            $this->Lembar_Pengesahan->ExportHrefValue = $this->Lembar_Pengesahan->UploadPath . $this->Lembar_Pengesahan->Upload->DbValue;

            // Soft_copy_Proposal
            $this->Soft_copy_Proposal->HrefValue = "";
            $this->Soft_copy_Proposal->ExportHrefValue = $this->Soft_copy_Proposal->UploadPath . $this->Soft_copy_Proposal->Upload->DbValue;

            // Surat_Pernyataan_Tidak_Studi
            $this->Surat_Pernyataan_Tidak_Studi->HrefValue = "";
            $this->Surat_Pernyataan_Tidak_Studi->ExportHrefValue = $this->Surat_Pernyataan_Tidak_Studi->UploadPath . $this->Surat_Pernyataan_Tidak_Studi->Upload->DbValue;

            // Tanggal
            $this->Tanggal->HrefValue = "";

            // IP
            $this->IP->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // User_Id
            $this->User_Id->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // Id_kelompok
            $this->Id_kelompok->setupEditAttributes();
            $curVal = trim(strval($this->Id_kelompok->CurrentValue));
            if ($curVal != "") {
                $this->Id_kelompok->ViewValue = $this->Id_kelompok->lookupCacheOption($curVal);
            } else {
                $this->Id_kelompok->ViewValue = $this->Id_kelompok->Lookup !== null && is_array($this->Id_kelompok->lookupOptions()) && count($this->Id_kelompok->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->Id_kelompok->ViewValue !== null) { // Load from cache
                $this->Id_kelompok->EditValue = array_values($this->Id_kelompok->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`Id_Kelompok`", "=", $this->Id_kelompok->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->Id_kelompok->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->Id_kelompok->EditValue = $arwrk;
            }
            $this->Id_kelompok->PlaceHolder = RemoveHtml($this->Id_kelompok->caption());

            // Judul_Penelitian
            $this->Judul_Penelitian->setupEditAttributes();
            $this->Judul_Penelitian->EditValue = HtmlEncode($this->Judul_Penelitian->CurrentValue);
            $this->Judul_Penelitian->PlaceHolder = RemoveHtml($this->Judul_Penelitian->caption());

            // Warna_Kaver
            $this->Warna_Kaver->setupEditAttributes();
            $curVal = trim(strval($this->Warna_Kaver->CurrentValue));
            if ($curVal != "") {
                $this->Warna_Kaver->ViewValue = $this->Warna_Kaver->lookupCacheOption($curVal);
            } else {
                $this->Warna_Kaver->ViewValue = $this->Warna_Kaver->Lookup !== null && is_array($this->Warna_Kaver->lookupOptions()) && count($this->Warna_Kaver->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->Warna_Kaver->ViewValue !== null) { // Load from cache
                $this->Warna_Kaver->EditValue = array_values($this->Warna_Kaver->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`Warna_kaver`", "=", $this->Warna_Kaver->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->Warna_Kaver->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->Warna_Kaver->EditValue = $arwrk;
            }
            $this->Warna_Kaver->PlaceHolder = RemoveHtml($this->Warna_Kaver->caption());

            // Lembar_Pengesahan
            $this->Lembar_Pengesahan->setupEditAttributes();
            if (!EmptyValue($this->Lembar_Pengesahan->Upload->DbValue)) {
                $this->Lembar_Pengesahan->EditValue = $this->Lembar_Pengesahan->Upload->DbValue;
            } else {
                $this->Lembar_Pengesahan->EditValue = "";
            }
            if (!EmptyValue($this->Lembar_Pengesahan->CurrentValue)) {
                $this->Lembar_Pengesahan->Upload->FileName = $this->Lembar_Pengesahan->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->Lembar_Pengesahan);
            }

            // Soft_copy_Proposal
            $this->Soft_copy_Proposal->setupEditAttributes();
            if (!EmptyValue($this->Soft_copy_Proposal->Upload->DbValue)) {
                $this->Soft_copy_Proposal->EditValue = $this->Soft_copy_Proposal->Upload->DbValue;
            } else {
                $this->Soft_copy_Proposal->EditValue = "";
            }
            if (!EmptyValue($this->Soft_copy_Proposal->CurrentValue)) {
                $this->Soft_copy_Proposal->Upload->FileName = $this->Soft_copy_Proposal->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->Soft_copy_Proposal);
            }

            // Surat_Pernyataan_Tidak_Studi
            $this->Surat_Pernyataan_Tidak_Studi->setupEditAttributes();
            if (!EmptyValue($this->Surat_Pernyataan_Tidak_Studi->Upload->DbValue)) {
                $this->Surat_Pernyataan_Tidak_Studi->EditValue = $this->Surat_Pernyataan_Tidak_Studi->Upload->DbValue;
            } else {
                $this->Surat_Pernyataan_Tidak_Studi->EditValue = "";
            }
            if (!EmptyValue($this->Surat_Pernyataan_Tidak_Studi->CurrentValue)) {
                $this->Surat_Pernyataan_Tidak_Studi->Upload->FileName = $this->Surat_Pernyataan_Tidak_Studi->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->Surat_Pernyataan_Tidak_Studi);
            }

            // Tanggal

            // IP

            // user

            // User_Id

            // Add refer script

            // Id_kelompok
            $this->Id_kelompok->HrefValue = "";

            // Judul_Penelitian
            $this->Judul_Penelitian->HrefValue = "";

            // Warna_Kaver
            $this->Warna_Kaver->HrefValue = "";

            // Lembar_Pengesahan
            $this->Lembar_Pengesahan->HrefValue = "";
            $this->Lembar_Pengesahan->ExportHrefValue = $this->Lembar_Pengesahan->UploadPath . $this->Lembar_Pengesahan->Upload->DbValue;

            // Soft_copy_Proposal
            $this->Soft_copy_Proposal->HrefValue = "";
            $this->Soft_copy_Proposal->ExportHrefValue = $this->Soft_copy_Proposal->UploadPath . $this->Soft_copy_Proposal->Upload->DbValue;

            // Surat_Pernyataan_Tidak_Studi
            $this->Surat_Pernyataan_Tidak_Studi->HrefValue = "";
            $this->Surat_Pernyataan_Tidak_Studi->ExportHrefValue = $this->Surat_Pernyataan_Tidak_Studi->UploadPath . $this->Surat_Pernyataan_Tidak_Studi->Upload->DbValue;

            // Tanggal
            $this->Tanggal->HrefValue = "";

            // IP
            $this->IP->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // User_Id
            $this->User_Id->HrefValue = "";
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
        if ($this->Id_kelompok->Required) {
            if (!$this->Id_kelompok->IsDetailKey && EmptyValue($this->Id_kelompok->FormValue)) {
                $this->Id_kelompok->addErrorMessage(str_replace("%s", $this->Id_kelompok->caption(), $this->Id_kelompok->RequiredErrorMessage));
            }
        }
        if ($this->Judul_Penelitian->Required) {
            if (!$this->Judul_Penelitian->IsDetailKey && EmptyValue($this->Judul_Penelitian->FormValue)) {
                $this->Judul_Penelitian->addErrorMessage(str_replace("%s", $this->Judul_Penelitian->caption(), $this->Judul_Penelitian->RequiredErrorMessage));
            }
        }
        if ($this->Warna_Kaver->Required) {
            if (!$this->Warna_Kaver->IsDetailKey && EmptyValue($this->Warna_Kaver->FormValue)) {
                $this->Warna_Kaver->addErrorMessage(str_replace("%s", $this->Warna_Kaver->caption(), $this->Warna_Kaver->RequiredErrorMessage));
            }
        }
        if ($this->Lembar_Pengesahan->Required) {
            if ($this->Lembar_Pengesahan->Upload->FileName == "" && !$this->Lembar_Pengesahan->Upload->KeepFile) {
                $this->Lembar_Pengesahan->addErrorMessage(str_replace("%s", $this->Lembar_Pengesahan->caption(), $this->Lembar_Pengesahan->RequiredErrorMessage));
            }
        }
        if ($this->Soft_copy_Proposal->Required) {
            if ($this->Soft_copy_Proposal->Upload->FileName == "" && !$this->Soft_copy_Proposal->Upload->KeepFile) {
                $this->Soft_copy_Proposal->addErrorMessage(str_replace("%s", $this->Soft_copy_Proposal->caption(), $this->Soft_copy_Proposal->RequiredErrorMessage));
            }
        }
        if ($this->Surat_Pernyataan_Tidak_Studi->Required) {
            if ($this->Surat_Pernyataan_Tidak_Studi->Upload->FileName == "" && !$this->Surat_Pernyataan_Tidak_Studi->Upload->KeepFile) {
                $this->Surat_Pernyataan_Tidak_Studi->addErrorMessage(str_replace("%s", $this->Surat_Pernyataan_Tidak_Studi->caption(), $this->Surat_Pernyataan_Tidak_Studi->RequiredErrorMessage));
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
        if ($this->User_Id->Required) {
            if (!$this->User_Id->IsDetailKey && EmptyValue($this->User_Id->FormValue)) {
                $this->User_Id->addErrorMessage(str_replace("%s", $this->User_Id->caption(), $this->User_Id->RequiredErrorMessage));
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

        // Id_kelompok
        $this->Id_kelompok->setDbValueDef($rsnew, $this->Id_kelompok->CurrentValue, false);

        // Judul_Penelitian
        $this->Judul_Penelitian->setDbValueDef($rsnew, $this->Judul_Penelitian->CurrentValue, false);

        // Warna_Kaver
        $this->Warna_Kaver->setDbValueDef($rsnew, $this->Warna_Kaver->CurrentValue, false);

        // Lembar_Pengesahan
        if ($this->Lembar_Pengesahan->Visible && !$this->Lembar_Pengesahan->Upload->KeepFile) {
            $this->Lembar_Pengesahan->Upload->DbValue = ""; // No need to delete old file
            if ($this->Lembar_Pengesahan->Upload->FileName == "") {
                $rsnew['Lembar_Pengesahan'] = null;
            } else {
                $rsnew['Lembar_Pengesahan'] = $this->Lembar_Pengesahan->Upload->FileName;
            }
        }

        // Soft_copy_Proposal
        if ($this->Soft_copy_Proposal->Visible && !$this->Soft_copy_Proposal->Upload->KeepFile) {
            $this->Soft_copy_Proposal->Upload->DbValue = ""; // No need to delete old file
            if ($this->Soft_copy_Proposal->Upload->FileName == "") {
                $rsnew['Soft_copy_Proposal'] = null;
            } else {
                $rsnew['Soft_copy_Proposal'] = $this->Soft_copy_Proposal->Upload->FileName;
            }
        }

        // Surat_Pernyataan_Tidak_Studi
        if ($this->Surat_Pernyataan_Tidak_Studi->Visible && !$this->Surat_Pernyataan_Tidak_Studi->Upload->KeepFile) {
            $this->Surat_Pernyataan_Tidak_Studi->Upload->DbValue = ""; // No need to delete old file
            if ($this->Surat_Pernyataan_Tidak_Studi->Upload->FileName == "") {
                $rsnew['Surat_Pernyataan_Tidak_Studi'] = null;
            } else {
                $rsnew['Surat_Pernyataan_Tidak_Studi'] = $this->Surat_Pernyataan_Tidak_Studi->Upload->FileName;
            }
        }

        // Tanggal
        $this->Tanggal->CurrentValue = $this->Tanggal->getAutoUpdateValue(); // PHP
        $this->Tanggal->setDbValueDef($rsnew, $this->Tanggal->CurrentValue);

        // IP
        $this->IP->CurrentValue = $this->IP->getAutoUpdateValue(); // PHP
        $this->IP->setDbValueDef($rsnew, $this->IP->CurrentValue);

        // user
        $this->user->CurrentValue = $this->user->getAutoUpdateValue(); // PHP
        $this->user->setDbValueDef($rsnew, $this->user->CurrentValue);

        // User_Id
        $this->User_Id->CurrentValue = $this->User_Id->getAutoUpdateValue(); // PHP
        $this->User_Id->setDbValueDef($rsnew, $this->User_Id->CurrentValue);
        if ($this->Lembar_Pengesahan->Visible && !$this->Lembar_Pengesahan->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->Lembar_Pengesahan->Upload->DbValue) ? [] : [$this->Lembar_Pengesahan->htmlDecode($this->Lembar_Pengesahan->Upload->DbValue)];
            if (!EmptyValue($this->Lembar_Pengesahan->Upload->FileName)) {
                $newFiles = [$this->Lembar_Pengesahan->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->Lembar_Pengesahan, $this->Lembar_Pengesahan->Upload->Index);
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
                            $file1 = UniqueFilename($this->Lembar_Pengesahan->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->Lembar_Pengesahan->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->Lembar_Pengesahan->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->Lembar_Pengesahan->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->Lembar_Pengesahan->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->Lembar_Pengesahan->setDbValueDef($rsnew, $this->Lembar_Pengesahan->Upload->FileName, false);
            }
        }
        if ($this->Soft_copy_Proposal->Visible && !$this->Soft_copy_Proposal->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->Soft_copy_Proposal->Upload->DbValue) ? [] : [$this->Soft_copy_Proposal->htmlDecode($this->Soft_copy_Proposal->Upload->DbValue)];
            if (!EmptyValue($this->Soft_copy_Proposal->Upload->FileName)) {
                $newFiles = [$this->Soft_copy_Proposal->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->Soft_copy_Proposal, $this->Soft_copy_Proposal->Upload->Index);
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
                            $file1 = UniqueFilename($this->Soft_copy_Proposal->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->Soft_copy_Proposal->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->Soft_copy_Proposal->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->Soft_copy_Proposal->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->Soft_copy_Proposal->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->Soft_copy_Proposal->setDbValueDef($rsnew, $this->Soft_copy_Proposal->Upload->FileName, false);
            }
        }
        if ($this->Surat_Pernyataan_Tidak_Studi->Visible && !$this->Surat_Pernyataan_Tidak_Studi->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->Surat_Pernyataan_Tidak_Studi->Upload->DbValue) ? [] : [$this->Surat_Pernyataan_Tidak_Studi->htmlDecode($this->Surat_Pernyataan_Tidak_Studi->Upload->DbValue)];
            if (!EmptyValue($this->Surat_Pernyataan_Tidak_Studi->Upload->FileName)) {
                $newFiles = [$this->Surat_Pernyataan_Tidak_Studi->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->Surat_Pernyataan_Tidak_Studi, $this->Surat_Pernyataan_Tidak_Studi->Upload->Index);
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
                            $file1 = UniqueFilename($this->Surat_Pernyataan_Tidak_Studi->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->Surat_Pernyataan_Tidak_Studi->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->Surat_Pernyataan_Tidak_Studi->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->Surat_Pernyataan_Tidak_Studi->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->Surat_Pernyataan_Tidak_Studi->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->Surat_Pernyataan_Tidak_Studi->setDbValueDef($rsnew, $this->Surat_Pernyataan_Tidak_Studi->Upload->FileName, false);
            }
        }

        // Update current values
        $this->setCurrentValues($rsnew);
        if ($this->Id_kelompok->CurrentValue != "") { // Check field with unique index
            $filter = "(`Id_kelompok` = '" . AdjustSql($this->Id_kelompok->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->Id_kelompok->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->Id_kelompok->CurrentValue, $idxErrMsg);
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
        if ($insertRow && $this->ValidateKey && strval($rsnew['Id_kelompok']) == "") {
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
                if ($this->Lembar_Pengesahan->Visible && !$this->Lembar_Pengesahan->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->Lembar_Pengesahan->Upload->DbValue) ? [] : [$this->Lembar_Pengesahan->htmlDecode($this->Lembar_Pengesahan->Upload->DbValue)];
                    if (!EmptyValue($this->Lembar_Pengesahan->Upload->FileName)) {
                        $newFiles = [$this->Lembar_Pengesahan->Upload->FileName];
                        $newFiles2 = [$this->Lembar_Pengesahan->htmlDecode($rsnew['Lembar_Pengesahan'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->Lembar_Pengesahan, $this->Lembar_Pengesahan->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->Lembar_Pengesahan->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                if ($this->Soft_copy_Proposal->Visible && !$this->Soft_copy_Proposal->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->Soft_copy_Proposal->Upload->DbValue) ? [] : [$this->Soft_copy_Proposal->htmlDecode($this->Soft_copy_Proposal->Upload->DbValue)];
                    if (!EmptyValue($this->Soft_copy_Proposal->Upload->FileName)) {
                        $newFiles = [$this->Soft_copy_Proposal->Upload->FileName];
                        $newFiles2 = [$this->Soft_copy_Proposal->htmlDecode($rsnew['Soft_copy_Proposal'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->Soft_copy_Proposal, $this->Soft_copy_Proposal->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->Soft_copy_Proposal->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                if ($this->Surat_Pernyataan_Tidak_Studi->Visible && !$this->Surat_Pernyataan_Tidak_Studi->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->Surat_Pernyataan_Tidak_Studi->Upload->DbValue) ? [] : [$this->Surat_Pernyataan_Tidak_Studi->htmlDecode($this->Surat_Pernyataan_Tidak_Studi->Upload->DbValue)];
                    if (!EmptyValue($this->Surat_Pernyataan_Tidak_Studi->Upload->FileName)) {
                        $newFiles = [$this->Surat_Pernyataan_Tidak_Studi->Upload->FileName];
                        $newFiles2 = [$this->Surat_Pernyataan_Tidak_Studi->htmlDecode($rsnew['Surat_Pernyataan_Tidak_Studi'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->Surat_Pernyataan_Tidak_Studi, $this->Surat_Pernyataan_Tidak_Studi->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->Surat_Pernyataan_Tidak_Studi->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("proposalpenelitianlist"), "", $this->TableVar, true);
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
                case "x_Id_kelompok":
                    break;
                case "x_Warna_Kaver":
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
