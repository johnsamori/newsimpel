<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class LaporanPengabdianEdit extends LaporanPengabdian
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "LaporanPengabdianEdit";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "laporanpengabdianedit";

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
        $this->Lembar_Pengesahan->setVisibility();
        $this->Laporan->setVisibility();
        $this->Luaran->setVisibility();
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->setVisibility();
        $this->Dokumentasi->setVisibility();
        $this->Daftar_Hadir->setVisibility();
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
        $this->TableVar = 'laporan_pengabdian';
        $this->TableName = 'laporan_pengabdian';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-edit-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (laporan_pengabdian)
        if (!isset($GLOBALS["laporan_pengabdian"]) || get_class($GLOBALS["laporan_pengabdian"]) == PROJECT_NAMESPACE . "laporan_pengabdian") {
            $GLOBALS["laporan_pengabdian"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'laporan_pengabdian');
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
                    $result["view"] = $pageName == "laporanpengabdianview"; // If View page, no primary button
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
        $this->setupLookupOptions($this->Id_kelompok);
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
            if (($keyValue = Get("Id_kelompok") ?? Key(0) ?? Route(2)) !== null) {
                $this->Id_kelompok->setQueryStringValue($keyValue);
                $this->Id_kelompok->setOldValue($this->Id_kelompok->QueryStringValue);
            } elseif (Post("Id_kelompok") !== null) {
                $this->Id_kelompok->setFormValue(Post("Id_kelompok"));
                $this->Id_kelompok->setOldValue($this->Id_kelompok->FormValue);
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
                if (($keyValue = Get("Id_kelompok") ?? Route("Id_kelompok")) !== null) {
                    $this->Id_kelompok->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->Id_kelompok->CurrentValue = null;
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
                        $this->terminate("laporanpengabdianlist"); // Return to list page
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
                        if ($this->Id_kelompok->CurrentValue != null) {
                            while (!$rs->EOF) {
                                if (SameString($this->Id_kelompok->CurrentValue, $rs->fields['Id_kelompok'])) {
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
                        $this->terminate("laporanpengabdianlist"); // Return to list page
                        return;
                    } else {
                    }
                } else { // Modal edit page
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("laporanpengabdianlist"); // No matching record, return to list
                        return;
                    }
                } // End modal checking
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "laporanpengabdianlist") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) {
                    // Handle UseAjaxActions with return page
                    if ($this->IsModal && $this->UseAjaxActions) {
                        $this->IsModal = false;
                        if (GetPageName($returnUrl) != "laporanpengabdianlist") {
                            Container("flash")->addMessage("Return-Url", $returnUrl); // Save return URL
                            $returnUrl = "laporanpengabdianlist"; // Return list page content
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
        $this->Lembar_Pengesahan->Upload->Index = $CurrentForm->Index;
        $this->Lembar_Pengesahan->Upload->uploadFile();
        $this->Lembar_Pengesahan->CurrentValue = $this->Lembar_Pengesahan->Upload->FileName;
        $this->Laporan->Upload->Index = $CurrentForm->Index;
        $this->Laporan->Upload->uploadFile();
        $this->Laporan->CurrentValue = $this->Laporan->Upload->FileName;
        $this->Luaran->Upload->Index = $CurrentForm->Index;
        $this->Luaran->Upload->uploadFile();
        $this->Luaran->CurrentValue = $this->Luaran->Upload->FileName;
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->Index = $CurrentForm->Index;
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->uploadFile();
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->CurrentValue = $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->FileName;
        $this->Dokumentasi->Upload->Index = $CurrentForm->Index;
        $this->Dokumentasi->Upload->uploadFile();
        $this->Dokumentasi->CurrentValue = $this->Dokumentasi->Upload->FileName;
        $this->Daftar_Hadir->Upload->Index = $CurrentForm->Index;
        $this->Daftar_Hadir->Upload->uploadFile();
        $this->Daftar_Hadir->CurrentValue = $this->Daftar_Hadir->Upload->FileName;
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
        if ($CurrentForm->hasValue("o_Id_kelompok")) {
            $this->Id_kelompok->setOldValue($CurrentForm->getValue("o_Id_kelompok"));
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
        $this->Tanggal->CurrentValue = $this->Tanggal->FormValue;
        $this->Tanggal->CurrentValue = UnFormatDateTime($this->Tanggal->CurrentValue, $this->Tanggal->formatPattern());
        $this->IP->CurrentValue = $this->IP->FormValue;
        $this->user->CurrentValue = $this->user->FormValue;
        $this->User_Id->CurrentValue = $this->User_Id->FormValue;
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

        // Check if valid User ID
        if ($res) {
            $res = $this->showOptionLink("edit");
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
        $this->Lembar_Pengesahan->Upload->DbValue = $row['Lembar_Pengesahan'];
        $this->Lembar_Pengesahan->setDbValue($this->Lembar_Pengesahan->Upload->DbValue);
        $this->Laporan->Upload->DbValue = $row['Laporan'];
        $this->Laporan->setDbValue($this->Laporan->Upload->DbValue);
        $this->Luaran->Upload->DbValue = $row['Luaran'];
        $this->Luaran->setDbValue($this->Luaran->Upload->DbValue);
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue = $row['Surat_Keterangan_dari_Tempat_Mengabdi'];
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->setDbValue($this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue);
        $this->Dokumentasi->Upload->DbValue = $row['Dokumentasi'];
        $this->Dokumentasi->setDbValue($this->Dokumentasi->Upload->DbValue);
        $this->Daftar_Hadir->Upload->DbValue = $row['Daftar_Hadir'];
        $this->Daftar_Hadir->setDbValue($this->Daftar_Hadir->Upload->DbValue);
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
        $row['Lembar_Pengesahan'] = $this->Lembar_Pengesahan->DefaultValue;
        $row['Laporan'] = $this->Laporan->DefaultValue;
        $row['Luaran'] = $this->Luaran->DefaultValue;
        $row['Surat_Keterangan_dari_Tempat_Mengabdi'] = $this->Surat_Keterangan_dari_Tempat_Mengabdi->DefaultValue;
        $row['Dokumentasi'] = $this->Dokumentasi->DefaultValue;
        $row['Daftar_Hadir'] = $this->Daftar_Hadir->DefaultValue;
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

        // Lembar_Pengesahan
        $this->Lembar_Pengesahan->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Laporan
        $this->Laporan->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Luaran
        $this->Luaran->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Surat_Keterangan_dari_Tempat_Mengabdi
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Dokumentasi
        $this->Dokumentasi->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Daftar_Hadir
        $this->Daftar_Hadir->RowCssClass = $this->IsMobileOrModal ? "row" : "";

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

            // Lembar_Pengesahan
            if (!EmptyValue($this->Lembar_Pengesahan->Upload->DbValue)) {
                $this->Lembar_Pengesahan->ViewValue = $this->Lembar_Pengesahan->Upload->DbValue;
            } else {
                $this->Lembar_Pengesahan->ViewValue = "";
            }

            // Laporan
            if (!EmptyValue($this->Laporan->Upload->DbValue)) {
                $this->Laporan->ViewValue = $this->Laporan->Upload->DbValue;
            } else {
                $this->Laporan->ViewValue = "";
            }

            // Luaran
            if (!EmptyValue($this->Luaran->Upload->DbValue)) {
                $this->Luaran->ViewValue = $this->Luaran->Upload->DbValue;
            } else {
                $this->Luaran->ViewValue = "";
            }

            // Surat_Keterangan_dari_Tempat_Mengabdi
            if (!EmptyValue($this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue)) {
                $this->Surat_Keterangan_dari_Tempat_Mengabdi->ViewValue = $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue;
            } else {
                $this->Surat_Keterangan_dari_Tempat_Mengabdi->ViewValue = "";
            }

            // Dokumentasi
            if (!EmptyValue($this->Dokumentasi->Upload->DbValue)) {
                $this->Dokumentasi->ViewValue = $this->Dokumentasi->Upload->DbValue;
            } else {
                $this->Dokumentasi->ViewValue = "";
            }

            // Daftar_Hadir
            if (!EmptyValue($this->Daftar_Hadir->Upload->DbValue)) {
                $this->Daftar_Hadir->ViewValue = $this->Daftar_Hadir->Upload->DbValue;
            } else {
                $this->Daftar_Hadir->ViewValue = "";
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

            // Lembar_Pengesahan
            $this->Lembar_Pengesahan->HrefValue = "";
            $this->Lembar_Pengesahan->ExportHrefValue = $this->Lembar_Pengesahan->UploadPath . $this->Lembar_Pengesahan->Upload->DbValue;

            // Laporan
            $this->Laporan->HrefValue = "";
            $this->Laporan->ExportHrefValue = $this->Laporan->UploadPath . $this->Laporan->Upload->DbValue;

            // Luaran
            $this->Luaran->HrefValue = "";
            $this->Luaran->ExportHrefValue = $this->Luaran->UploadPath . $this->Luaran->Upload->DbValue;

            // Surat_Keterangan_dari_Tempat_Mengabdi
            $this->Surat_Keterangan_dari_Tempat_Mengabdi->HrefValue = "";
            $this->Surat_Keterangan_dari_Tempat_Mengabdi->ExportHrefValue = $this->Surat_Keterangan_dari_Tempat_Mengabdi->UploadPath . $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue;

            // Dokumentasi
            $this->Dokumentasi->HrefValue = "";
            $this->Dokumentasi->ExportHrefValue = $this->Dokumentasi->UploadPath . $this->Dokumentasi->Upload->DbValue;

            // Daftar_Hadir
            $this->Daftar_Hadir->HrefValue = "";
            $this->Daftar_Hadir->ExportHrefValue = $this->Daftar_Hadir->UploadPath . $this->Daftar_Hadir->Upload->DbValue;

            // Tanggal
            $this->Tanggal->HrefValue = "";

            // IP
            $this->IP->HrefValue = "";

            // user
            $this->user->HrefValue = "";

            // User_Id
            $this->User_Id->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
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
            if ($this->isShow()) {
                RenderUploadField($this->Lembar_Pengesahan);
            }

            // Laporan
            $this->Laporan->setupEditAttributes();
            if (!EmptyValue($this->Laporan->Upload->DbValue)) {
                $this->Laporan->EditValue = $this->Laporan->Upload->DbValue;
            } else {
                $this->Laporan->EditValue = "";
            }
            if (!EmptyValue($this->Laporan->CurrentValue)) {
                $this->Laporan->Upload->FileName = $this->Laporan->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->Laporan);
            }

            // Luaran
            $this->Luaran->setupEditAttributes();
            if (!EmptyValue($this->Luaran->Upload->DbValue)) {
                $this->Luaran->EditValue = $this->Luaran->Upload->DbValue;
            } else {
                $this->Luaran->EditValue = "";
            }
            if (!EmptyValue($this->Luaran->CurrentValue)) {
                $this->Luaran->Upload->FileName = $this->Luaran->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->Luaran);
            }

            // Surat_Keterangan_dari_Tempat_Mengabdi
            $this->Surat_Keterangan_dari_Tempat_Mengabdi->setupEditAttributes();
            if (!EmptyValue($this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue)) {
                $this->Surat_Keterangan_dari_Tempat_Mengabdi->EditValue = $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue;
            } else {
                $this->Surat_Keterangan_dari_Tempat_Mengabdi->EditValue = "";
            }
            if (!EmptyValue($this->Surat_Keterangan_dari_Tempat_Mengabdi->CurrentValue)) {
                $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->FileName = $this->Surat_Keterangan_dari_Tempat_Mengabdi->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->Surat_Keterangan_dari_Tempat_Mengabdi);
            }

            // Dokumentasi
            $this->Dokumentasi->setupEditAttributes();
            if (!EmptyValue($this->Dokumentasi->Upload->DbValue)) {
                $this->Dokumentasi->EditValue = $this->Dokumentasi->Upload->DbValue;
            } else {
                $this->Dokumentasi->EditValue = "";
            }
            if (!EmptyValue($this->Dokumentasi->CurrentValue)) {
                $this->Dokumentasi->Upload->FileName = $this->Dokumentasi->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->Dokumentasi);
            }

            // Daftar_Hadir
            $this->Daftar_Hadir->setupEditAttributes();
            if (!EmptyValue($this->Daftar_Hadir->Upload->DbValue)) {
                $this->Daftar_Hadir->EditValue = $this->Daftar_Hadir->Upload->DbValue;
            } else {
                $this->Daftar_Hadir->EditValue = "";
            }
            if (!EmptyValue($this->Daftar_Hadir->CurrentValue)) {
                $this->Daftar_Hadir->Upload->FileName = $this->Daftar_Hadir->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->Daftar_Hadir);
            }

            // Tanggal

            // IP

            // user

            // User_Id

            // Edit refer script

            // Id_kelompok
            $this->Id_kelompok->HrefValue = "";

            // Lembar_Pengesahan
            $this->Lembar_Pengesahan->HrefValue = "";
            $this->Lembar_Pengesahan->ExportHrefValue = $this->Lembar_Pengesahan->UploadPath . $this->Lembar_Pengesahan->Upload->DbValue;

            // Laporan
            $this->Laporan->HrefValue = "";
            $this->Laporan->ExportHrefValue = $this->Laporan->UploadPath . $this->Laporan->Upload->DbValue;

            // Luaran
            $this->Luaran->HrefValue = "";
            $this->Luaran->ExportHrefValue = $this->Luaran->UploadPath . $this->Luaran->Upload->DbValue;

            // Surat_Keterangan_dari_Tempat_Mengabdi
            $this->Surat_Keterangan_dari_Tempat_Mengabdi->HrefValue = "";
            $this->Surat_Keterangan_dari_Tempat_Mengabdi->ExportHrefValue = $this->Surat_Keterangan_dari_Tempat_Mengabdi->UploadPath . $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue;

            // Dokumentasi
            $this->Dokumentasi->HrefValue = "";
            $this->Dokumentasi->ExportHrefValue = $this->Dokumentasi->UploadPath . $this->Dokumentasi->Upload->DbValue;

            // Daftar_Hadir
            $this->Daftar_Hadir->HrefValue = "";
            $this->Daftar_Hadir->ExportHrefValue = $this->Daftar_Hadir->UploadPath . $this->Daftar_Hadir->Upload->DbValue;

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
        if ($this->Lembar_Pengesahan->Required) {
            if ($this->Lembar_Pengesahan->Upload->FileName == "" && !$this->Lembar_Pengesahan->Upload->KeepFile) {
                $this->Lembar_Pengesahan->addErrorMessage(str_replace("%s", $this->Lembar_Pengesahan->caption(), $this->Lembar_Pengesahan->RequiredErrorMessage));
            }
        }
        if ($this->Laporan->Required) {
            if ($this->Laporan->Upload->FileName == "" && !$this->Laporan->Upload->KeepFile) {
                $this->Laporan->addErrorMessage(str_replace("%s", $this->Laporan->caption(), $this->Laporan->RequiredErrorMessage));
            }
        }
        if ($this->Luaran->Required) {
            if ($this->Luaran->Upload->FileName == "" && !$this->Luaran->Upload->KeepFile) {
                $this->Luaran->addErrorMessage(str_replace("%s", $this->Luaran->caption(), $this->Luaran->RequiredErrorMessage));
            }
        }
        if ($this->Surat_Keterangan_dari_Tempat_Mengabdi->Required) {
            if ($this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->FileName == "" && !$this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->KeepFile) {
                $this->Surat_Keterangan_dari_Tempat_Mengabdi->addErrorMessage(str_replace("%s", $this->Surat_Keterangan_dari_Tempat_Mengabdi->caption(), $this->Surat_Keterangan_dari_Tempat_Mengabdi->RequiredErrorMessage));
            }
        }
        if ($this->Dokumentasi->Required) {
            if ($this->Dokumentasi->Upload->FileName == "" && !$this->Dokumentasi->Upload->KeepFile) {
                $this->Dokumentasi->addErrorMessage(str_replace("%s", $this->Dokumentasi->caption(), $this->Dokumentasi->RequiredErrorMessage));
            }
        }
        if ($this->Daftar_Hadir->Required) {
            if ($this->Daftar_Hadir->Upload->FileName == "" && !$this->Daftar_Hadir->Upload->KeepFile) {
                $this->Daftar_Hadir->addErrorMessage(str_replace("%s", $this->Daftar_Hadir->caption(), $this->Daftar_Hadir->RequiredErrorMessage));
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

        // Id_kelompok
        $this->Id_kelompok->setDbValueDef($rsnew, $this->Id_kelompok->CurrentValue, $this->Id_kelompok->ReadOnly);

        // Lembar_Pengesahan
        if ($this->Lembar_Pengesahan->Visible && !$this->Lembar_Pengesahan->ReadOnly && !$this->Lembar_Pengesahan->Upload->KeepFile) {
            $this->Lembar_Pengesahan->Upload->DbValue = $rsold['Lembar_Pengesahan']; // Get original value
            if ($this->Lembar_Pengesahan->Upload->FileName == "") {
                $rsnew['Lembar_Pengesahan'] = null;
            } else {
                $rsnew['Lembar_Pengesahan'] = $this->Lembar_Pengesahan->Upload->FileName;
            }
        }

        // Laporan
        if ($this->Laporan->Visible && !$this->Laporan->ReadOnly && !$this->Laporan->Upload->KeepFile) {
            $this->Laporan->Upload->DbValue = $rsold['Laporan']; // Get original value
            if ($this->Laporan->Upload->FileName == "") {
                $rsnew['Laporan'] = null;
            } else {
                $rsnew['Laporan'] = $this->Laporan->Upload->FileName;
            }
        }

        // Luaran
        if ($this->Luaran->Visible && !$this->Luaran->ReadOnly && !$this->Luaran->Upload->KeepFile) {
            $this->Luaran->Upload->DbValue = $rsold['Luaran']; // Get original value
            if ($this->Luaran->Upload->FileName == "") {
                $rsnew['Luaran'] = null;
            } else {
                $rsnew['Luaran'] = $this->Luaran->Upload->FileName;
            }
        }

        // Surat_Keterangan_dari_Tempat_Mengabdi
        if ($this->Surat_Keterangan_dari_Tempat_Mengabdi->Visible && !$this->Surat_Keterangan_dari_Tempat_Mengabdi->ReadOnly && !$this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->KeepFile) {
            $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue = $rsold['Surat_Keterangan_dari_Tempat_Mengabdi']; // Get original value
            if ($this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->FileName == "") {
                $rsnew['Surat_Keterangan_dari_Tempat_Mengabdi'] = null;
            } else {
                $rsnew['Surat_Keterangan_dari_Tempat_Mengabdi'] = $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->FileName;
            }
        }

        // Dokumentasi
        if ($this->Dokumentasi->Visible && !$this->Dokumentasi->ReadOnly && !$this->Dokumentasi->Upload->KeepFile) {
            $this->Dokumentasi->Upload->DbValue = $rsold['Dokumentasi']; // Get original value
            if ($this->Dokumentasi->Upload->FileName == "") {
                $rsnew['Dokumentasi'] = null;
            } else {
                $rsnew['Dokumentasi'] = $this->Dokumentasi->Upload->FileName;
            }
        }

        // Daftar_Hadir
        if ($this->Daftar_Hadir->Visible && !$this->Daftar_Hadir->ReadOnly && !$this->Daftar_Hadir->Upload->KeepFile) {
            $this->Daftar_Hadir->Upload->DbValue = $rsold['Daftar_Hadir']; // Get original value
            if ($this->Daftar_Hadir->Upload->FileName == "") {
                $rsnew['Daftar_Hadir'] = null;
            } else {
                $rsnew['Daftar_Hadir'] = $this->Daftar_Hadir->Upload->FileName;
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

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check field with unique index (Id_kelompok)
        if ($this->Id_kelompok->CurrentValue != "") {
            $filterChk = "(`Id_kelompok` = '" . AdjustSql($this->Id_kelompok->CurrentValue, $this->Dbid) . "')";
            $filterChk .= " AND NOT (" . $filter . ")";
            $this->CurrentFilter = $filterChk;
            $sqlChk = $this->getCurrentSql();
            $rsChk = $conn->executeQuery($sqlChk);
            if (!$rsChk) {
                return false;
            }
            if ($rsChk->fetch()) {
                $idxErrMsg = str_replace("%f", $this->Id_kelompok->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->Id_kelompok->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
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
                $this->Lembar_Pengesahan->setDbValueDef($rsnew, $this->Lembar_Pengesahan->Upload->FileName, $this->Lembar_Pengesahan->ReadOnly);
            }
        }
        if ($this->Laporan->Visible && !$this->Laporan->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->Laporan->Upload->DbValue) ? [] : [$this->Laporan->htmlDecode($this->Laporan->Upload->DbValue)];
            if (!EmptyValue($this->Laporan->Upload->FileName)) {
                $newFiles = [$this->Laporan->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->Laporan, $this->Laporan->Upload->Index);
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
                            $file1 = UniqueFilename($this->Laporan->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->Laporan->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->Laporan->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->Laporan->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->Laporan->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->Laporan->setDbValueDef($rsnew, $this->Laporan->Upload->FileName, $this->Laporan->ReadOnly);
            }
        }
        if ($this->Luaran->Visible && !$this->Luaran->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->Luaran->Upload->DbValue) ? [] : [$this->Luaran->htmlDecode($this->Luaran->Upload->DbValue)];
            if (!EmptyValue($this->Luaran->Upload->FileName)) {
                $newFiles = [$this->Luaran->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->Luaran, $this->Luaran->Upload->Index);
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
                            $file1 = UniqueFilename($this->Luaran->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->Luaran->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->Luaran->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->Luaran->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->Luaran->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->Luaran->setDbValueDef($rsnew, $this->Luaran->Upload->FileName, $this->Luaran->ReadOnly);
            }
        }
        if ($this->Surat_Keterangan_dari_Tempat_Mengabdi->Visible && !$this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue) ? [] : [$this->Surat_Keterangan_dari_Tempat_Mengabdi->htmlDecode($this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue)];
            if (!EmptyValue($this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->FileName)) {
                $newFiles = [$this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->Surat_Keterangan_dari_Tempat_Mengabdi, $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->Index);
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
                            $file1 = UniqueFilename($this->Surat_Keterangan_dari_Tempat_Mengabdi->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->Surat_Keterangan_dari_Tempat_Mengabdi->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->Surat_Keterangan_dari_Tempat_Mengabdi->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->Surat_Keterangan_dari_Tempat_Mengabdi->setDbValueDef($rsnew, $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->FileName, $this->Surat_Keterangan_dari_Tempat_Mengabdi->ReadOnly);
            }
        }
        if ($this->Dokumentasi->Visible && !$this->Dokumentasi->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->Dokumentasi->Upload->DbValue) ? [] : [$this->Dokumentasi->htmlDecode($this->Dokumentasi->Upload->DbValue)];
            if (!EmptyValue($this->Dokumentasi->Upload->FileName)) {
                $newFiles = [$this->Dokumentasi->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->Dokumentasi, $this->Dokumentasi->Upload->Index);
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
                            $file1 = UniqueFilename($this->Dokumentasi->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->Dokumentasi->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->Dokumentasi->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->Dokumentasi->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->Dokumentasi->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->Dokumentasi->setDbValueDef($rsnew, $this->Dokumentasi->Upload->FileName, $this->Dokumentasi->ReadOnly);
            }
        }
        if ($this->Daftar_Hadir->Visible && !$this->Daftar_Hadir->Upload->KeepFile) {
            $oldFiles = EmptyValue($this->Daftar_Hadir->Upload->DbValue) ? [] : [$this->Daftar_Hadir->htmlDecode($this->Daftar_Hadir->Upload->DbValue)];
            if (!EmptyValue($this->Daftar_Hadir->Upload->FileName)) {
                $newFiles = [$this->Daftar_Hadir->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->Daftar_Hadir, $this->Daftar_Hadir->Upload->Index);
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
                            $file1 = UniqueFilename($this->Daftar_Hadir->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->Daftar_Hadir->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->Daftar_Hadir->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->Daftar_Hadir->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->Daftar_Hadir->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->Daftar_Hadir->setDbValueDef($rsnew, $this->Daftar_Hadir->Upload->FileName, $this->Daftar_Hadir->ReadOnly);
            }
        }

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
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->Lembar_Pengesahan->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->Laporan->Visible && !$this->Laporan->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->Laporan->Upload->DbValue) ? [] : [$this->Laporan->htmlDecode($this->Laporan->Upload->DbValue)];
                    if (!EmptyValue($this->Laporan->Upload->FileName)) {
                        $newFiles = [$this->Laporan->Upload->FileName];
                        $newFiles2 = [$this->Laporan->htmlDecode($rsnew['Laporan'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->Laporan, $this->Laporan->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->Laporan->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadError7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->Laporan->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->Luaran->Visible && !$this->Luaran->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->Luaran->Upload->DbValue) ? [] : [$this->Luaran->htmlDecode($this->Luaran->Upload->DbValue)];
                    if (!EmptyValue($this->Luaran->Upload->FileName)) {
                        $newFiles = [$this->Luaran->Upload->FileName];
                        $newFiles2 = [$this->Luaran->htmlDecode($rsnew['Luaran'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->Luaran, $this->Luaran->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->Luaran->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadError7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->Luaran->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->Surat_Keterangan_dari_Tempat_Mengabdi->Visible && !$this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue) ? [] : [$this->Surat_Keterangan_dari_Tempat_Mengabdi->htmlDecode($this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue)];
                    if (!EmptyValue($this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->FileName)) {
                        $newFiles = [$this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->FileName];
                        $newFiles2 = [$this->Surat_Keterangan_dari_Tempat_Mengabdi->htmlDecode($rsnew['Surat_Keterangan_dari_Tempat_Mengabdi'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->Surat_Keterangan_dari_Tempat_Mengabdi, $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadError7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->Surat_Keterangan_dari_Tempat_Mengabdi->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->Dokumentasi->Visible && !$this->Dokumentasi->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->Dokumentasi->Upload->DbValue) ? [] : [$this->Dokumentasi->htmlDecode($this->Dokumentasi->Upload->DbValue)];
                    if (!EmptyValue($this->Dokumentasi->Upload->FileName)) {
                        $newFiles = [$this->Dokumentasi->Upload->FileName];
                        $newFiles2 = [$this->Dokumentasi->htmlDecode($rsnew['Dokumentasi'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->Dokumentasi, $this->Dokumentasi->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->Dokumentasi->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadError7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->Dokumentasi->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->Daftar_Hadir->Visible && !$this->Daftar_Hadir->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->Daftar_Hadir->Upload->DbValue) ? [] : [$this->Daftar_Hadir->htmlDecode($this->Daftar_Hadir->Upload->DbValue)];
                    if (!EmptyValue($this->Daftar_Hadir->Upload->FileName)) {
                        $newFiles = [$this->Daftar_Hadir->Upload->FileName];
                        $newFiles2 = [$this->Daftar_Hadir->htmlDecode($rsnew['Daftar_Hadir'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->Daftar_Hadir, $this->Daftar_Hadir->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->Daftar_Hadir->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadError7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->Daftar_Hadir->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
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
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("laporanpengabdianlist"), "", $this->TableVar, true);
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
                case "x_Id_kelompok":
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
