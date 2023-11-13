<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class DosenDelete extends Dosen
{
    use MessagesTrait;

    // Page ID
    public $PageID = "delete";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "DosenDelete";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "dosendelete";

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
        $this->TableClass = "table table-bordered table-hover table-sm ew-table";

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
            SaveDebugMessage();
            Redirect(GetUrl($url));
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
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $TotalRecords = 0;
    public $RecordCount;
    public $RecKeys = [];
    public $StartRowCount = 1;
    public $RowCount = 0;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $UserProfile, $Language, $Security, $CurrentForm;

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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Load key parameters
        $this->RecKeys = $this->getRecordKeys(); // Load record keys
        $filter = $this->getFilterFromRecordKeys();
        if ($filter == "") {
            $this->terminate("dosenlist"); // Prevent SQL injection, return to list
            return;
        }

        // Set up filter (WHERE Clause)
        $this->CurrentFilter = $filter;

        // Get action
        if (IsApi()) {
            $this->CurrentAction = "delete"; // Delete record directly
        } elseif (Param("action") !== null) {
            $this->CurrentAction = Param("action") == "delete" ? "delete" : "show";
        } else {
            $this->CurrentAction = $this->InlineDelete ?
                "delete" : // Delete record directly
                "show"; // Display record
        }
        if ($this->isDelete()) {
            $this->SendEmail = true; // Send email on delete success
            if ($this->deleteRows()) { // Delete rows
                if ($this->getSuccessMessage() == "") {
                    $this->setSuccessMessage($Language->phrase("DeleteSuccess")); // Set up success message
                }
                if (IsJsonResponse()) {
                    $this->terminate(true);
                    return;
                } else {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                }
            } else { // Delete failed
                if (IsJsonResponse()) {
                    $this->terminate();
                    return;
                }
                // Return JSON error message if UseAjaxActions
                if ($this->UseAjaxActions) {
                    WriteJson([ "success" => false, "error" => $this->getFailureMessage() ]);
                    $this->clearFailureMessage();
                    $this->terminate();
                    return;                    
                }
                if ($this->InlineDelete) {
                    $this->terminate($this->getReturnUrl()); // Return to caller
                    return;
                } else {
                    $this->CurrentAction = "show"; // Display record
                }
            }
        }
        if ($this->isShow()) { // Load records for display
            if ($this->Recordset = $this->loadRecordset()) {
                $this->TotalRecords = $this->Recordset->recordCount(); // Get record count
            }
            if ($this->TotalRecords <= 0) { // No record found, exit
                if ($this->Recordset) {
                    $this->Recordset->close();
                }
                $this->terminate("dosenlist"); // Return to list
                return;
            }
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

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // NIDN

        // Id_Sinta

        // Nama_Lengkap

        // Alamat

        // Email

        // Jenis_Kelamin

        // Program_Studi

        // Jenjang_Pendidikan

        // Jabatan_Fungsional

        // Kepakaran

        // Rumpun_Ilmu

        // Aktif

        // Validasi

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
            $this->NIDN->TooltipValue = "";

            // Id_Sinta
            $this->Id_Sinta->HrefValue = "";
            $this->Id_Sinta->TooltipValue = "";

            // Nama_Lengkap
            $this->Nama_Lengkap->HrefValue = "";
            $this->Nama_Lengkap->TooltipValue = "";

            // Alamat
            $this->Alamat->HrefValue = "";
            $this->Alamat->TooltipValue = "";

            // Email
            $this->_Email->HrefValue = "";
            $this->_Email->TooltipValue = "";

            // Jenis_Kelamin
            $this->Jenis_Kelamin->HrefValue = "";
            $this->Jenis_Kelamin->TooltipValue = "";

            // Program_Studi
            $this->Program_Studi->HrefValue = "";
            $this->Program_Studi->TooltipValue = "";

            // Jenjang_Pendidikan
            $this->Jenjang_Pendidikan->HrefValue = "";
            $this->Jenjang_Pendidikan->TooltipValue = "";

            // Jabatan_Fungsional
            $this->Jabatan_Fungsional->HrefValue = "";
            $this->Jabatan_Fungsional->TooltipValue = "";

            // Kepakaran
            $this->Kepakaran->HrefValue = "";
            $this->Kepakaran->TooltipValue = "";

            // Rumpun_Ilmu
            $this->Rumpun_Ilmu->HrefValue = "";
            $this->Rumpun_Ilmu->TooltipValue = "";

            // Aktif
            $this->Aktif->HrefValue = "";
            $this->Aktif->TooltipValue = "";

            // Validasi
            $this->Validasi->HrefValue = "";
            $this->Validasi->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['NIDN'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
                if (!$deleteRow && !EmptyValue($this->DbErrorMessage)) { // Show database error
                    $this->setFailureMessage($this->DbErrorMessage);
                }
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }
        if ($deleteRows) {
            if ($this->UseTransaction) { // Commit transaction
                $conn->commit();
            }

            // Set warning message if delete some records failed
            if (count($failKeys) > 0) {
                $this->setWarningMessage(str_replace("%k", explode(", ", $failKeys), $Language->phrase("DeleteRecordsFailed")));
            }
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                $conn->rollback();
            }
        }

        // Write JSON response
        if ((IsJsonResponse() || ConvertToBool(Param("infinitescroll"))) && $deleteRows) {
            $rows = $this->getRecordsFromRecordset($rsold);
            $table = $this->TableVar;
            if (Route(2) !== null) { // Single delete
                $rows = $rows[0]; // Return object
            }
            WriteJson(["success" => true, "action" => Config("API_DELETE_ACTION"), $table => $rows]);
        }
        return $deleteRows;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("home");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("dosenlist"), "", $this->TableVar, true);
        $pageId = "delete";
        $Breadcrumb->add("delete", $pageId, $url);
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
}
