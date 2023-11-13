<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class DosenEdit extends Dosen
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "DosenEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "dosenedit";

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
        $this->NIDN->setVisibility();
        $this->Id_Sinta->setVisibility();
        $this->Nama_Lengkap->setVisibility();
        $this->Alamat->setVisibility();
        $this->_Email->setVisibility();
        $this->Jenis_Kelamin->setVisibility();
        $this->Program_Studi->setVisibility();
        $this->Jenjang_Pendidikan->setVisibility();
        $this->Jabatan_Fungsional->setVisibility();
        $this->Kepakaran->setVisibility();
        $this->Rumpun_Ilmu->setVisibility();
        $this->Aktif->setVisibility();
        $this->Validasi->setVisibility();
    }

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'dosen';
        $this->TableName = 'dosen';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (dosen)
        if (!isset($GLOBALS["dosen"]) || get_class($GLOBALS["dosen"]) == PROJECT_NAMESPACE . "dosen") {
            $GLOBALS["dosen"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'dosen');
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
                    $result["view"] = $pageName == "dosenview"; // If View page, no primary button
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
            $key .= @$ar['NIDN'];
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
        $this->setupLookupOptions($this->Jenis_Kelamin);
        $this->setupLookupOptions($this->Jenjang_Pendidikan);
        $this->setupLookupOptions($this->Jabatan_Fungsional);
        $this->setupLookupOptions($this->Kepakaran);
        $this->setupLookupOptions($this->Rumpun_Ilmu);
        $this->setupLookupOptions($this->Aktif);
        $this->setupLookupOptions($this->Validasi);
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
            if (($keyValue = Get("NIDN") ?? Key(0) ?? Route(2)) !== null) {
                $this->NIDN->setQueryStringValue($keyValue);
                $this->NIDN->setOldValue($this->NIDN->QueryStringValue);
            } elseif (Post("NIDN") !== null) {
                $this->NIDN->setFormValue(Post("NIDN"));
                $this->NIDN->setOldValue($this->NIDN->FormValue);
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
                if (($keyValue = Get("NIDN") ?? Route("NIDN")) !== null) {
                    $this->NIDN->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->NIDN->CurrentValue = null;
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
                        $this->terminate("dosenlist"); // Return to list page
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
                        if ($this->NIDN->CurrentValue != null) {
                            while (!$rs->EOF) {
                                if (SameString($this->NIDN->CurrentValue, $rs->fields['NIDN'])) {
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
                        $this->terminate("dosenlist"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("dosenlist"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "dosenlist") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) {
                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "dosenlist") {
                            Container("flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "dosenlist"; // Return list page content
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

        // Check field name 'NIDN' first before field var 'x_NIDN'
        $val = $CurrentForm->hasValue("NIDN") ? $CurrentForm->getValue("NIDN") : $CurrentForm->getValue("x_NIDN");
        if (!$this->NIDN->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->NIDN->Visible = false; // Disable update for API request
            } else {
                $this->NIDN->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_NIDN")) {
            $this->NIDN->setOldValue($CurrentForm->getValue("o_NIDN"));
        }

        // Check field name 'Id_Sinta' first before field var 'x_Id_Sinta'
        $val = $CurrentForm->hasValue("Id_Sinta") ? $CurrentForm->getValue("Id_Sinta") : $CurrentForm->getValue("x_Id_Sinta");
        if (!$this->Id_Sinta->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Id_Sinta->Visible = false; // Disable update for API request
            } else {
                $this->Id_Sinta->setFormValue($val);
            }
        }

        // Check field name 'Nama_Lengkap' first before field var 'x_Nama_Lengkap'
        $val = $CurrentForm->hasValue("Nama_Lengkap") ? $CurrentForm->getValue("Nama_Lengkap") : $CurrentForm->getValue("x_Nama_Lengkap");
        if (!$this->Nama_Lengkap->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Nama_Lengkap->Visible = false; // Disable update for API request
            } else {
                $this->Nama_Lengkap->setFormValue($val);
            }
        }

        // Check field name 'Alamat' first before field var 'x_Alamat'
        $val = $CurrentForm->hasValue("Alamat") ? $CurrentForm->getValue("Alamat") : $CurrentForm->getValue("x_Alamat");
        if (!$this->Alamat->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Alamat->Visible = false; // Disable update for API request
            } else {
                $this->Alamat->setFormValue($val);
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

        // Check field name 'Jenis_Kelamin' first before field var 'x_Jenis_Kelamin'
        $val = $CurrentForm->hasValue("Jenis_Kelamin") ? $CurrentForm->getValue("Jenis_Kelamin") : $CurrentForm->getValue("x_Jenis_Kelamin");
        if (!$this->Jenis_Kelamin->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Jenis_Kelamin->Visible = false; // Disable update for API request
            } else {
                $this->Jenis_Kelamin->setFormValue($val);
            }
        }

        // Check field name 'Program_Studi' first before field var 'x_Program_Studi'
        $val = $CurrentForm->hasValue("Program_Studi") ? $CurrentForm->getValue("Program_Studi") : $CurrentForm->getValue("x_Program_Studi");
        if (!$this->Program_Studi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Program_Studi->Visible = false; // Disable update for API request
            } else {
                $this->Program_Studi->setFormValue($val);
            }
        }

        // Check field name 'Jenjang_Pendidikan' first before field var 'x_Jenjang_Pendidikan'
        $val = $CurrentForm->hasValue("Jenjang_Pendidikan") ? $CurrentForm->getValue("Jenjang_Pendidikan") : $CurrentForm->getValue("x_Jenjang_Pendidikan");
        if (!$this->Jenjang_Pendidikan->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Jenjang_Pendidikan->Visible = false; // Disable update for API request
            } else {
                $this->Jenjang_Pendidikan->setFormValue($val);
            }
        }

        // Check field name 'Jabatan_Fungsional' first before field var 'x_Jabatan_Fungsional'
        $val = $CurrentForm->hasValue("Jabatan_Fungsional") ? $CurrentForm->getValue("Jabatan_Fungsional") : $CurrentForm->getValue("x_Jabatan_Fungsional");
        if (!$this->Jabatan_Fungsional->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Jabatan_Fungsional->Visible = false; // Disable update for API request
            } else {
                $this->Jabatan_Fungsional->setFormValue($val);
            }
        }

        // Check field name 'Kepakaran' first before field var 'x_Kepakaran'
        $val = $CurrentForm->hasValue("Kepakaran") ? $CurrentForm->getValue("Kepakaran") : $CurrentForm->getValue("x_Kepakaran");
        if (!$this->Kepakaran->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Kepakaran->Visible = false; // Disable update for API request
            } else {
                $this->Kepakaran->setFormValue($val);
            }
        }

        // Check field name 'Rumpun_Ilmu' first before field var 'x_Rumpun_Ilmu'
        $val = $CurrentForm->hasValue("Rumpun_Ilmu") ? $CurrentForm->getValue("Rumpun_Ilmu") : $CurrentForm->getValue("x_Rumpun_Ilmu");
        if (!$this->Rumpun_Ilmu->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Rumpun_Ilmu->Visible = false; // Disable update for API request
            } else {
                $this->Rumpun_Ilmu->setFormValue($val);
            }
        }

        // Check field name 'Aktif' first before field var 'x_Aktif'
        $val = $CurrentForm->hasValue("Aktif") ? $CurrentForm->getValue("Aktif") : $CurrentForm->getValue("x_Aktif");
        if (!$this->Aktif->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Aktif->Visible = false; // Disable update for API request
            } else {
                $this->Aktif->setFormValue($val);
            }
        }

        // Check field name 'Validasi' first before field var 'x_Validasi'
        $val = $CurrentForm->hasValue("Validasi") ? $CurrentForm->getValue("Validasi") : $CurrentForm->getValue("x_Validasi");
        if (!$this->Validasi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Validasi->Visible = false; // Disable update for API request
            } else {
                $this->Validasi->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->NIDN->CurrentValue = $this->NIDN->FormValue;
        $this->Id_Sinta->CurrentValue = $this->Id_Sinta->FormValue;
        $this->Nama_Lengkap->CurrentValue = $this->Nama_Lengkap->FormValue;
        $this->Alamat->CurrentValue = $this->Alamat->FormValue;
        $this->_Email->CurrentValue = $this->_Email->FormValue;
        $this->Jenis_Kelamin->CurrentValue = $this->Jenis_Kelamin->FormValue;
        $this->Program_Studi->CurrentValue = $this->Program_Studi->FormValue;
        $this->Jenjang_Pendidikan->CurrentValue = $this->Jenjang_Pendidikan->FormValue;
        $this->Jabatan_Fungsional->CurrentValue = $this->Jabatan_Fungsional->FormValue;
        $this->Kepakaran->CurrentValue = $this->Kepakaran->FormValue;
        $this->Rumpun_Ilmu->CurrentValue = $this->Rumpun_Ilmu->FormValue;
        $this->Aktif->CurrentValue = $this->Aktif->FormValue;
        $this->Validasi->CurrentValue = $this->Validasi->FormValue;
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
        $this->NIDN->setDbValue($row['NIDN']);
        $this->Id_Sinta->setDbValue($row['Id_Sinta']);
        $this->Nama_Lengkap->setDbValue($row['Nama_Lengkap']);
        $this->Alamat->setDbValue($row['Alamat']);
        $this->_Email->setDbValue($row['Email']);
        $this->Jenis_Kelamin->setDbValue($row['Jenis_Kelamin']);
        $this->Program_Studi->setDbValue($row['Program_Studi']);
        $this->Jenjang_Pendidikan->setDbValue($row['Jenjang_Pendidikan']);
        $this->Jabatan_Fungsional->setDbValue($row['Jabatan_Fungsional']);
        $this->Kepakaran->setDbValue($row['Kepakaran']);
        $this->Rumpun_Ilmu->setDbValue($row['Rumpun_Ilmu']);
        $this->Aktif->setDbValue($row['Aktif']);
        $this->Validasi->setDbValue($row['Validasi']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['NIDN'] = $this->NIDN->DefaultValue;
        $row['Id_Sinta'] = $this->Id_Sinta->DefaultValue;
        $row['Nama_Lengkap'] = $this->Nama_Lengkap->DefaultValue;
        $row['Alamat'] = $this->Alamat->DefaultValue;
        $row['Email'] = $this->_Email->DefaultValue;
        $row['Jenis_Kelamin'] = $this->Jenis_Kelamin->DefaultValue;
        $row['Program_Studi'] = $this->Program_Studi->DefaultValue;
        $row['Jenjang_Pendidikan'] = $this->Jenjang_Pendidikan->DefaultValue;
        $row['Jabatan_Fungsional'] = $this->Jabatan_Fungsional->DefaultValue;
        $row['Kepakaran'] = $this->Kepakaran->DefaultValue;
        $row['Rumpun_Ilmu'] = $this->Rumpun_Ilmu->DefaultValue;
        $row['Aktif'] = $this->Aktif->DefaultValue;
        $row['Validasi'] = $this->Validasi->DefaultValue;
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

        // NIDN
        $this->NIDN->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Id_Sinta
        $this->Id_Sinta->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Nama_Lengkap
        $this->Nama_Lengkap->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Alamat
        $this->Alamat->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Email
        $this->_Email->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Jenis_Kelamin
        $this->Jenis_Kelamin->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Program_Studi
        $this->Program_Studi->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Jenjang_Pendidikan
        $this->Jenjang_Pendidikan->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Jabatan_Fungsional
        $this->Jabatan_Fungsional->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Kepakaran
        $this->Kepakaran->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Rumpun_Ilmu
        $this->Rumpun_Ilmu->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Aktif
        $this->Aktif->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Validasi
        $this->Validasi->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // NIDN
            $this->NIDN->ViewValue = $this->NIDN->CurrentValue;

            // Id_Sinta
            $this->Id_Sinta->ViewValue = $this->Id_Sinta->CurrentValue;

            // Nama_Lengkap
            $this->Nama_Lengkap->ViewValue = $this->Nama_Lengkap->CurrentValue;

            // Alamat
            $this->Alamat->ViewValue = $this->Alamat->CurrentValue;

            // Email
            $this->_Email->ViewValue = $this->_Email->CurrentValue;

            // Jenis_Kelamin
            if (strval($this->Jenis_Kelamin->CurrentValue) != "") {
                $this->Jenis_Kelamin->ViewValue = $this->Jenis_Kelamin->optionCaption($this->Jenis_Kelamin->CurrentValue);
            } else {
                $this->Jenis_Kelamin->ViewValue = null;
            }

            // Program_Studi
            $this->Program_Studi->ViewValue = $this->Program_Studi->CurrentValue;

            // Jenjang_Pendidikan
            $curVal = strval($this->Jenjang_Pendidikan->CurrentValue);
            if ($curVal != "") {
                $this->Jenjang_Pendidikan->ViewValue = $this->Jenjang_Pendidikan->lookupCacheOption($curVal);
                if ($this->Jenjang_Pendidikan->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`Nama_Jenjang`", "=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->Jenjang_Pendidikan->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->Jenjang_Pendidikan->Lookup->renderViewRow($rswrk[0]);
                        $this->Jenjang_Pendidikan->ViewValue = $this->Jenjang_Pendidikan->displayValue($arwrk);
                    } else {
                        $this->Jenjang_Pendidikan->ViewValue = $this->Jenjang_Pendidikan->CurrentValue;
                    }
                }
            } else {
                $this->Jenjang_Pendidikan->ViewValue = null;
            }

            // Jabatan_Fungsional
            $curVal = strval($this->Jabatan_Fungsional->CurrentValue);
            if ($curVal != "") {
                $this->Jabatan_Fungsional->ViewValue = $this->Jabatan_Fungsional->lookupCacheOption($curVal);
                if ($this->Jabatan_Fungsional->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`Nama_Jabatan`", "=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->Jabatan_Fungsional->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->Jabatan_Fungsional->Lookup->renderViewRow($rswrk[0]);
                        $this->Jabatan_Fungsional->ViewValue = $this->Jabatan_Fungsional->displayValue($arwrk);
                    } else {
                        $this->Jabatan_Fungsional->ViewValue = $this->Jabatan_Fungsional->CurrentValue;
                    }
                }
            } else {
                $this->Jabatan_Fungsional->ViewValue = null;
            }

            // Kepakaran
            $curVal = strval($this->Kepakaran->CurrentValue);
            if ($curVal != "") {
                $this->Kepakaran->ViewValue = $this->Kepakaran->lookupCacheOption($curVal);
                if ($this->Kepakaran->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`Kepakaran`", "=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->Kepakaran->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->Kepakaran->Lookup->renderViewRow($rswrk[0]);
                        $this->Kepakaran->ViewValue = $this->Kepakaran->displayValue($arwrk);
                    } else {
                        $this->Kepakaran->ViewValue = $this->Kepakaran->CurrentValue;
                    }
                }
            } else {
                $this->Kepakaran->ViewValue = null;
            }

            // Rumpun_Ilmu
            $curVal = strval($this->Rumpun_Ilmu->CurrentValue);
            if ($curVal != "") {
                $this->Rumpun_Ilmu->ViewValue = $this->Rumpun_Ilmu->lookupCacheOption($curVal);
                if ($this->Rumpun_Ilmu->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`Rumpun_Ilmu`", "=", $curVal, DATATYPE_STRING, "");
                    $sqlWrk = $this->Rumpun_Ilmu->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->Rumpun_Ilmu->Lookup->renderViewRow($rswrk[0]);
                        $this->Rumpun_Ilmu->ViewValue = $this->Rumpun_Ilmu->displayValue($arwrk);
                    } else {
                        $this->Rumpun_Ilmu->ViewValue = $this->Rumpun_Ilmu->CurrentValue;
                    }
                }
            } else {
                $this->Rumpun_Ilmu->ViewValue = null;
            }

            // Aktif
            if (strval($this->Aktif->CurrentValue) != "") {
                $this->Aktif->ViewValue = $this->Aktif->optionCaption($this->Aktif->CurrentValue);
            } else {
                $this->Aktif->ViewValue = null;
            }

            // Validasi
            if (strval($this->Validasi->CurrentValue) != "") {
                $this->Validasi->ViewValue = $this->Validasi->optionCaption($this->Validasi->CurrentValue);
            } else {
                $this->Validasi->ViewValue = null;
            }

            // NIDN
            $this->NIDN->HrefValue = "";

            // Id_Sinta
            $this->Id_Sinta->HrefValue = "";

            // Nama_Lengkap
            $this->Nama_Lengkap->HrefValue = "";

            // Alamat
            $this->Alamat->HrefValue = "";

            // Email
            $this->_Email->HrefValue = "";

            // Jenis_Kelamin
            $this->Jenis_Kelamin->HrefValue = "";

            // Program_Studi
            $this->Program_Studi->HrefValue = "";

            // Jenjang_Pendidikan
            $this->Jenjang_Pendidikan->HrefValue = "";

            // Jabatan_Fungsional
            $this->Jabatan_Fungsional->HrefValue = "";

            // Kepakaran
            $this->Kepakaran->HrefValue = "";

            // Rumpun_Ilmu
            $this->Rumpun_Ilmu->HrefValue = "";

            // Aktif
            $this->Aktif->HrefValue = "";

            // Validasi
            $this->Validasi->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // NIDN
            $this->NIDN->setupEditAttributes();
            if (!$this->NIDN->Raw) {
                $this->NIDN->CurrentValue = HtmlDecode($this->NIDN->CurrentValue);
            }
            $this->NIDN->EditValue = HtmlEncode($this->NIDN->CurrentValue);
            $this->NIDN->PlaceHolder = RemoveHtml($this->NIDN->caption());

            // Id_Sinta
            $this->Id_Sinta->setupEditAttributes();
            if (!$this->Id_Sinta->Raw) {
                $this->Id_Sinta->CurrentValue = HtmlDecode($this->Id_Sinta->CurrentValue);
            }
            $this->Id_Sinta->EditValue = HtmlEncode($this->Id_Sinta->CurrentValue);
            $this->Id_Sinta->PlaceHolder = RemoveHtml($this->Id_Sinta->caption());

            // Nama_Lengkap
            $this->Nama_Lengkap->setupEditAttributes();
            if (!$this->Nama_Lengkap->Raw) {
                $this->Nama_Lengkap->CurrentValue = HtmlDecode($this->Nama_Lengkap->CurrentValue);
            }
            $this->Nama_Lengkap->EditValue = HtmlEncode($this->Nama_Lengkap->CurrentValue);
            $this->Nama_Lengkap->PlaceHolder = RemoveHtml($this->Nama_Lengkap->caption());

            // Alamat
            $this->Alamat->setupEditAttributes();
            if (!$this->Alamat->Raw) {
                $this->Alamat->CurrentValue = HtmlDecode($this->Alamat->CurrentValue);
            }
            $this->Alamat->EditValue = HtmlEncode($this->Alamat->CurrentValue);
            $this->Alamat->PlaceHolder = RemoveHtml($this->Alamat->caption());

            // Email
            $this->_Email->setupEditAttributes();
            if (!$this->_Email->Raw) {
                $this->_Email->CurrentValue = HtmlDecode($this->_Email->CurrentValue);
            }
            $this->_Email->EditValue = HtmlEncode($this->_Email->CurrentValue);
            $this->_Email->PlaceHolder = RemoveHtml($this->_Email->caption());

            // Jenis_Kelamin
            $this->Jenis_Kelamin->EditValue = $this->Jenis_Kelamin->options(false);
            $this->Jenis_Kelamin->PlaceHolder = RemoveHtml($this->Jenis_Kelamin->caption());

            // Program_Studi
            $this->Program_Studi->setupEditAttributes();
            if (!$this->Program_Studi->Raw) {
                $this->Program_Studi->CurrentValue = HtmlDecode($this->Program_Studi->CurrentValue);
            }
            $this->Program_Studi->EditValue = HtmlEncode($this->Program_Studi->CurrentValue);
            $this->Program_Studi->PlaceHolder = RemoveHtml($this->Program_Studi->caption());

            // Jenjang_Pendidikan
            $this->Jenjang_Pendidikan->setupEditAttributes();
            $curVal = trim(strval($this->Jenjang_Pendidikan->CurrentValue));
            if ($curVal != "") {
                $this->Jenjang_Pendidikan->ViewValue = $this->Jenjang_Pendidikan->lookupCacheOption($curVal);
            } else {
                $this->Jenjang_Pendidikan->ViewValue = $this->Jenjang_Pendidikan->Lookup !== null && is_array($this->Jenjang_Pendidikan->lookupOptions()) && count($this->Jenjang_Pendidikan->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->Jenjang_Pendidikan->ViewValue !== null) { // Load from cache
                $this->Jenjang_Pendidikan->EditValue = array_values($this->Jenjang_Pendidikan->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`Nama_Jenjang`", "=", $this->Jenjang_Pendidikan->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->Jenjang_Pendidikan->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->Jenjang_Pendidikan->EditValue = $arwrk;
            }
            $this->Jenjang_Pendidikan->PlaceHolder = RemoveHtml($this->Jenjang_Pendidikan->caption());

            // Jabatan_Fungsional
            $this->Jabatan_Fungsional->setupEditAttributes();
            $curVal = trim(strval($this->Jabatan_Fungsional->CurrentValue));
            if ($curVal != "") {
                $this->Jabatan_Fungsional->ViewValue = $this->Jabatan_Fungsional->lookupCacheOption($curVal);
            } else {
                $this->Jabatan_Fungsional->ViewValue = $this->Jabatan_Fungsional->Lookup !== null && is_array($this->Jabatan_Fungsional->lookupOptions()) && count($this->Jabatan_Fungsional->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->Jabatan_Fungsional->ViewValue !== null) { // Load from cache
                $this->Jabatan_Fungsional->EditValue = array_values($this->Jabatan_Fungsional->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`Nama_Jabatan`", "=", $this->Jabatan_Fungsional->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->Jabatan_Fungsional->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->Jabatan_Fungsional->EditValue = $arwrk;
            }
            $this->Jabatan_Fungsional->PlaceHolder = RemoveHtml($this->Jabatan_Fungsional->caption());

            // Kepakaran
            $this->Kepakaran->setupEditAttributes();
            $curVal = trim(strval($this->Kepakaran->CurrentValue));
            if ($curVal != "") {
                $this->Kepakaran->ViewValue = $this->Kepakaran->lookupCacheOption($curVal);
            } else {
                $this->Kepakaran->ViewValue = $this->Kepakaran->Lookup !== null && is_array($this->Kepakaran->lookupOptions()) && count($this->Kepakaran->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->Kepakaran->ViewValue !== null) { // Load from cache
                $this->Kepakaran->EditValue = array_values($this->Kepakaran->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`Kepakaran`", "=", $this->Kepakaran->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->Kepakaran->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->Kepakaran->EditValue = $arwrk;
            }
            $this->Kepakaran->PlaceHolder = RemoveHtml($this->Kepakaran->caption());

            // Rumpun_Ilmu
            $this->Rumpun_Ilmu->setupEditAttributes();
            $curVal = trim(strval($this->Rumpun_Ilmu->CurrentValue));
            if ($curVal != "") {
                $this->Rumpun_Ilmu->ViewValue = $this->Rumpun_Ilmu->lookupCacheOption($curVal);
            } else {
                $this->Rumpun_Ilmu->ViewValue = $this->Rumpun_Ilmu->Lookup !== null && is_array($this->Rumpun_Ilmu->lookupOptions()) && count($this->Rumpun_Ilmu->lookupOptions()) > 0 ? $curVal : null;
            }
            if ($this->Rumpun_Ilmu->ViewValue !== null) { // Load from cache
                $this->Rumpun_Ilmu->EditValue = array_values($this->Rumpun_Ilmu->lookupOptions());
            } else { // Lookup from database
                if ($curVal == "") {
                    $filterWrk = "0=1";
                } else {
                    $filterWrk = SearchFilter("`Rumpun_Ilmu`", "=", $this->Rumpun_Ilmu->CurrentValue, DATATYPE_STRING, "");
                }
                $sqlWrk = $this->Rumpun_Ilmu->Lookup->getSql(true, $filterWrk, '', $this, false, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                $arwrk = $rswrk;
                $this->Rumpun_Ilmu->EditValue = $arwrk;
            }
            $this->Rumpun_Ilmu->PlaceHolder = RemoveHtml($this->Rumpun_Ilmu->caption());

            // Aktif
            $this->Aktif->setupEditAttributes();
            $this->Aktif->EditValue = $this->Aktif->options(true);
            $this->Aktif->PlaceHolder = RemoveHtml($this->Aktif->caption());

            // Validasi
            $this->Validasi->setupEditAttributes();
            $this->Validasi->EditValue = $this->Validasi->options(true);
            $this->Validasi->PlaceHolder = RemoveHtml($this->Validasi->caption());

            // Edit refer script

            // NIDN
            $this->NIDN->HrefValue = "";

            // Id_Sinta
            $this->Id_Sinta->HrefValue = "";

            // Nama_Lengkap
            $this->Nama_Lengkap->HrefValue = "";

            // Alamat
            $this->Alamat->HrefValue = "";

            // Email
            $this->_Email->HrefValue = "";

            // Jenis_Kelamin
            $this->Jenis_Kelamin->HrefValue = "";

            // Program_Studi
            $this->Program_Studi->HrefValue = "";

            // Jenjang_Pendidikan
            $this->Jenjang_Pendidikan->HrefValue = "";

            // Jabatan_Fungsional
            $this->Jabatan_Fungsional->HrefValue = "";

            // Kepakaran
            $this->Kepakaran->HrefValue = "";

            // Rumpun_Ilmu
            $this->Rumpun_Ilmu->HrefValue = "";

            // Aktif
            $this->Aktif->HrefValue = "";

            // Validasi
            $this->Validasi->HrefValue = "";
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
        if ($this->NIDN->Required) {
            if (!$this->NIDN->IsDetailKey && EmptyValue($this->NIDN->FormValue)) {
                $this->NIDN->addErrorMessage(str_replace("%s", $this->NIDN->caption(), $this->NIDN->RequiredErrorMessage));
            }
        }
        if ($this->Id_Sinta->Required) {
            if (!$this->Id_Sinta->IsDetailKey && EmptyValue($this->Id_Sinta->FormValue)) {
                $this->Id_Sinta->addErrorMessage(str_replace("%s", $this->Id_Sinta->caption(), $this->Id_Sinta->RequiredErrorMessage));
            }
        }
        if ($this->Nama_Lengkap->Required) {
            if (!$this->Nama_Lengkap->IsDetailKey && EmptyValue($this->Nama_Lengkap->FormValue)) {
                $this->Nama_Lengkap->addErrorMessage(str_replace("%s", $this->Nama_Lengkap->caption(), $this->Nama_Lengkap->RequiredErrorMessage));
            }
        }
        if ($this->Alamat->Required) {
            if (!$this->Alamat->IsDetailKey && EmptyValue($this->Alamat->FormValue)) {
                $this->Alamat->addErrorMessage(str_replace("%s", $this->Alamat->caption(), $this->Alamat->RequiredErrorMessage));
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
        if ($this->Jenis_Kelamin->Required) {
            if ($this->Jenis_Kelamin->FormValue == "") {
                $this->Jenis_Kelamin->addErrorMessage(str_replace("%s", $this->Jenis_Kelamin->caption(), $this->Jenis_Kelamin->RequiredErrorMessage));
            }
        }
        if ($this->Program_Studi->Required) {
            if (!$this->Program_Studi->IsDetailKey && EmptyValue($this->Program_Studi->FormValue)) {
                $this->Program_Studi->addErrorMessage(str_replace("%s", $this->Program_Studi->caption(), $this->Program_Studi->RequiredErrorMessage));
            }
        }
        if ($this->Jenjang_Pendidikan->Required) {
            if (!$this->Jenjang_Pendidikan->IsDetailKey && EmptyValue($this->Jenjang_Pendidikan->FormValue)) {
                $this->Jenjang_Pendidikan->addErrorMessage(str_replace("%s", $this->Jenjang_Pendidikan->caption(), $this->Jenjang_Pendidikan->RequiredErrorMessage));
            }
        }
        if ($this->Jabatan_Fungsional->Required) {
            if (!$this->Jabatan_Fungsional->IsDetailKey && EmptyValue($this->Jabatan_Fungsional->FormValue)) {
                $this->Jabatan_Fungsional->addErrorMessage(str_replace("%s", $this->Jabatan_Fungsional->caption(), $this->Jabatan_Fungsional->RequiredErrorMessage));
            }
        }
        if ($this->Kepakaran->Required) {
            if (!$this->Kepakaran->IsDetailKey && EmptyValue($this->Kepakaran->FormValue)) {
                $this->Kepakaran->addErrorMessage(str_replace("%s", $this->Kepakaran->caption(), $this->Kepakaran->RequiredErrorMessage));
            }
        }
        if ($this->Rumpun_Ilmu->Required) {
            if (!$this->Rumpun_Ilmu->IsDetailKey && EmptyValue($this->Rumpun_Ilmu->FormValue)) {
                $this->Rumpun_Ilmu->addErrorMessage(str_replace("%s", $this->Rumpun_Ilmu->caption(), $this->Rumpun_Ilmu->RequiredErrorMessage));
            }
        }
        if ($this->Aktif->Required) {
            if (!$this->Aktif->IsDetailKey && EmptyValue($this->Aktif->FormValue)) {
                $this->Aktif->addErrorMessage(str_replace("%s", $this->Aktif->caption(), $this->Aktif->RequiredErrorMessage));
            }
        }
        if ($this->Validasi->Required) {
            if (!$this->Validasi->IsDetailKey && EmptyValue($this->Validasi->FormValue)) {
                $this->Validasi->addErrorMessage(str_replace("%s", $this->Validasi->caption(), $this->Validasi->RequiredErrorMessage));
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

        // NIDN
        $this->NIDN->setDbValueDef($rsnew, $this->NIDN->CurrentValue, $this->NIDN->ReadOnly);

        // Id_Sinta
        $this->Id_Sinta->setDbValueDef($rsnew, $this->Id_Sinta->CurrentValue, $this->Id_Sinta->ReadOnly);

        // Nama_Lengkap
        $this->Nama_Lengkap->setDbValueDef($rsnew, $this->Nama_Lengkap->CurrentValue, $this->Nama_Lengkap->ReadOnly);

        // Alamat
        $this->Alamat->setDbValueDef($rsnew, $this->Alamat->CurrentValue, $this->Alamat->ReadOnly);

        // Email
        $this->_Email->setDbValueDef($rsnew, $this->_Email->CurrentValue, $this->_Email->ReadOnly);

        // Jenis_Kelamin
        $this->Jenis_Kelamin->setDbValueDef($rsnew, $this->Jenis_Kelamin->CurrentValue, $this->Jenis_Kelamin->ReadOnly);

        // Program_Studi
        $this->Program_Studi->setDbValueDef($rsnew, $this->Program_Studi->CurrentValue, $this->Program_Studi->ReadOnly);

        // Jenjang_Pendidikan
        $this->Jenjang_Pendidikan->setDbValueDef($rsnew, $this->Jenjang_Pendidikan->CurrentValue, $this->Jenjang_Pendidikan->ReadOnly);

        // Jabatan_Fungsional
        $this->Jabatan_Fungsional->setDbValueDef($rsnew, $this->Jabatan_Fungsional->CurrentValue, $this->Jabatan_Fungsional->ReadOnly);

        // Kepakaran
        $this->Kepakaran->setDbValueDef($rsnew, $this->Kepakaran->CurrentValue, $this->Kepakaran->ReadOnly);

        // Rumpun_Ilmu
        $this->Rumpun_Ilmu->setDbValueDef($rsnew, $this->Rumpun_Ilmu->CurrentValue, $this->Rumpun_Ilmu->ReadOnly);

        // Aktif
        $this->Aktif->setDbValueDef($rsnew, $this->Aktif->CurrentValue, $this->Aktif->ReadOnly);

        // Validasi
        $this->Validasi->setDbValueDef($rsnew, $this->Validasi->CurrentValue, $this->Validasi->ReadOnly);

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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("dosenlist"), "", $this->TableVar, true);
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
                case "x_Jenis_Kelamin":
                    break;
                case "x_Jenjang_Pendidikan":
                    break;
                case "x_Jabatan_Fungsional":
                    break;
                case "x_Kepakaran":
                    break;
                case "x_Rumpun_Ilmu":
                    break;
                case "x_Aktif":
                    break;
                case "x_Validasi":
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
