<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for laporan_pengabdian
 */
class LaporanPengabdian extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $DbErrorMessage = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-4 col-form-label ew-label";
    public $RightColumnClass = "col-sm-8";
    public $OffsetColumnClass = "col-sm-8 offset-sm-4";
    public $TableLeftColumnClass = "w-col-4";

    // Ajax / Modal
    public $UseAjaxActions = false;
    public $ModalSearch = false;
    public $ModalView = false;
    public $ModalAdd = false;
    public $ModalEdit = false;
    public $ModalUpdate = false;
    public $InlineDelete = false;
    public $ModalGridAdd = false;
    public $ModalGridEdit = false;
    public $ModalMultiEdit = false;

    // Fields
    public $Id_kelompok;
    public $Lembar_Pengesahan;
    public $Laporan;
    public $Luaran;
    public $Surat_Keterangan_dari_Tempat_Mengabdi;
    public $Dokumentasi;
    public $Daftar_Hadir;
    public $Tanggal;
    public $IP;
    public $user;
    public $User_Id;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("language");
        $this->TableVar = "laporan_pengabdian";
        $this->TableName = 'laporan_pengabdian';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "laporan_pengabdian";
        $this->Dbid = 'DB';
        $this->ExportAll = false;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)

        // PDF
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)

        // PhpSpreadsheet
        $this->ExportExcelPageOrientation = null; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = null; // Page size (PhpSpreadsheet only)

        // PHPWord
        $this->ExportWordPageOrientation = ""; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = ""; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 8;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UseAjaxActions = $this->UseAjaxActions || Config("USE_AJAX_ACTIONS");
        $this->BasicSearch = new BasicSearch($this);

        // Id_kelompok
        $this->Id_kelompok = new DbField(
            $this, // Table
            'x_Id_kelompok', // Variable name
            'Id_kelompok', // Name
            '`Id_kelompok`', // Expression
            '`Id_kelompok`', // Basic search expression
            200, // Type
            10, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Id_kelompok`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->Id_kelompok->InputTextType = "text";
        $this->Id_kelompok->IsPrimaryKey = true; // Primary key field
        $this->Id_kelompok->Nullable = false; // NOT NULL field
        $this->Id_kelompok->Required = true; // Required field
        $this->Id_kelompok->setSelectMultiple(false); // Select one
        $this->Id_kelompok->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->Id_kelompok->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Id_kelompok->Lookup = new Lookup('Id_kelompok', 'vproposal_pengabdian_diterima', false, 'Id_Kelompok', ["Id_Kelompok","Nama_Ketua","Judul_Penelitian",""], '', '', [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`Id_Kelompok`, ''),'" . ValueSeparator(1, $this->Id_kelompok) . "',COALESCE(`Nama_Ketua`,''),'" . ValueSeparator(2, $this->Id_kelompok) . "',COALESCE(`Judul_Penelitian`,''))");
                break;
            case "id-ID":
                $this->Id_kelompok->Lookup = new Lookup('Id_kelompok', 'vproposal_pengabdian_diterima', false, 'Id_Kelompok', ["Id_Kelompok","Nama_Ketua","Judul_Penelitian",""], '', '', [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`Id_Kelompok`, ''),'" . ValueSeparator(1, $this->Id_kelompok) . "',COALESCE(`Nama_Ketua`,''),'" . ValueSeparator(2, $this->Id_kelompok) . "',COALESCE(`Judul_Penelitian`,''))");
                break;
            default:
                $this->Id_kelompok->Lookup = new Lookup('Id_kelompok', 'vproposal_pengabdian_diterima', false, 'Id_Kelompok', ["Id_Kelompok","Nama_Ketua","Judul_Penelitian",""], '', '', [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`Id_Kelompok`, ''),'" . ValueSeparator(1, $this->Id_kelompok) . "',COALESCE(`Nama_Ketua`,''),'" . ValueSeparator(2, $this->Id_kelompok) . "',COALESCE(`Judul_Penelitian`,''))");
                break;
        }
        $this->Id_kelompok->SearchOperators = ["=", "<>"];
        $this->Fields['Id_kelompok'] = &$this->Id_kelompok;

        // Lembar_Pengesahan
        $this->Lembar_Pengesahan = new DbField(
            $this, // Table
            'x_Lembar_Pengesahan', // Variable name
            'Lembar_Pengesahan', // Name
            '`Lembar_Pengesahan`', // Expression
            '`Lembar_Pengesahan`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            true, // Is upload field
            '`Lembar_Pengesahan`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'FILE' // Edit Tag
        );
        $this->Lembar_Pengesahan->InputTextType = "text";
        $this->Lembar_Pengesahan->Nullable = false; // NOT NULL field
        $this->Lembar_Pengesahan->Required = true; // Required field
        $this->Lembar_Pengesahan->UploadAllowedFileExt = "pdf";
        $this->Lembar_Pengesahan->UploadMaxFileSize = 3000000;
        $this->Lembar_Pengesahan->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['Lembar_Pengesahan'] = &$this->Lembar_Pengesahan;

        // Laporan
        $this->Laporan = new DbField(
            $this, // Table
            'x_Laporan', // Variable name
            'Laporan', // Name
            '`Laporan`', // Expression
            '`Laporan`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            true, // Is upload field
            '`Laporan`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'FILE' // Edit Tag
        );
        $this->Laporan->InputTextType = "text";
        $this->Laporan->Nullable = false; // NOT NULL field
        $this->Laporan->Required = true; // Required field
        $this->Laporan->UploadAllowedFileExt = "pdf";
        $this->Laporan->UploadMaxFileSize = 4000000;
        $this->Laporan->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['Laporan'] = &$this->Laporan;

        // Luaran
        $this->Luaran = new DbField(
            $this, // Table
            'x_Luaran', // Variable name
            'Luaran', // Name
            '`Luaran`', // Expression
            '`Luaran`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            true, // Is upload field
            '`Luaran`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'FILE' // Edit Tag
        );
        $this->Luaran->InputTextType = "text";
        $this->Luaran->Nullable = false; // NOT NULL field
        $this->Luaran->Required = true; // Required field
        $this->Luaran->UploadAllowedFileExt = "pdf";
        $this->Luaran->UploadMaxFileSize = 3000000;
        $this->Luaran->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['Luaran'] = &$this->Luaran;

        // Surat_Keterangan_dari_Tempat_Mengabdi
        $this->Surat_Keterangan_dari_Tempat_Mengabdi = new DbField(
            $this, // Table
            'x_Surat_Keterangan_dari_Tempat_Mengabdi', // Variable name
            'Surat_Keterangan_dari_Tempat_Mengabdi', // Name
            '`Surat_Keterangan_dari_Tempat_Mengabdi`', // Expression
            '`Surat_Keterangan_dari_Tempat_Mengabdi`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            true, // Is upload field
            '`Surat_Keterangan_dari_Tempat_Mengabdi`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'FILE' // Edit Tag
        );
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->InputTextType = "text";
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->Nullable = false; // NOT NULL field
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->Required = true; // Required field
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->UploadAllowedFileExt = "pdf";
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->UploadMaxFileSize = 2000000;
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['Surat_Keterangan_dari_Tempat_Mengabdi'] = &$this->Surat_Keterangan_dari_Tempat_Mengabdi;

        // Dokumentasi
        $this->Dokumentasi = new DbField(
            $this, // Table
            'x_Dokumentasi', // Variable name
            'Dokumentasi', // Name
            '`Dokumentasi`', // Expression
            '`Dokumentasi`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            true, // Is upload field
            '`Dokumentasi`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'FILE' // Edit Tag
        );
        $this->Dokumentasi->InputTextType = "text";
        $this->Dokumentasi->Nullable = false; // NOT NULL field
        $this->Dokumentasi->Required = true; // Required field
        $this->Dokumentasi->UploadAllowedFileExt = "pdf";
        $this->Dokumentasi->UploadMaxFileSize = 5000000;
        $this->Dokumentasi->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['Dokumentasi'] = &$this->Dokumentasi;

        // Daftar_Hadir
        $this->Daftar_Hadir = new DbField(
            $this, // Table
            'x_Daftar_Hadir', // Variable name
            'Daftar_Hadir', // Name
            '`Daftar_Hadir`', // Expression
            '`Daftar_Hadir`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            true, // Is upload field
            '`Daftar_Hadir`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'FILE' // Edit Tag
        );
        $this->Daftar_Hadir->InputTextType = "text";
        $this->Daftar_Hadir->Nullable = false; // NOT NULL field
        $this->Daftar_Hadir->Required = true; // Required field
        $this->Daftar_Hadir->UploadAllowedFileExt = "pdf";
        $this->Daftar_Hadir->UploadMaxFileSize = 2000000;
        $this->Daftar_Hadir->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['Daftar_Hadir'] = &$this->Daftar_Hadir;

        // Tanggal
        $this->Tanggal = new DbField(
            $this, // Table
            'x_Tanggal', // Variable name
            'Tanggal', // Name
            '`Tanggal`', // Expression
            CastDateFieldForLike("`Tanggal`", 0, "DB"), // Basic search expression
            135, // Type
            19, // Size
            0, // Date/Time format
            false, // Is upload field
            '`Tanggal`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Tanggal->addMethod("getAutoUpdateValue", fn() => CurrentDateTime());
        $this->Tanggal->InputTextType = "text";
        $this->Tanggal->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Tanggal->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Tanggal'] = &$this->Tanggal;

        // IP
        $this->IP = new DbField(
            $this, // Table
            'x_IP', // Variable name
            'IP', // Name
            '`IP`', // Expression
            '`IP`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`IP`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->IP->addMethod("getAutoUpdateValue", fn() => CurrentUserIP());
        $this->IP->InputTextType = "text";
        $this->IP->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['IP'] = &$this->IP;

        // user
        $this->user = new DbField(
            $this, // Table
            'x_user', // Variable name
            'user', // Name
            '`user`', // Expression
            '`user`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`user`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->user->addMethod("getAutoUpdateValue", fn() => CurrentUserName());
        $this->user->InputTextType = "text";
        $this->user->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['user'] = &$this->user;

        // User_Id
        $this->User_Id = new DbField(
            $this, // Table
            'x_User_Id', // Variable name
            'User_Id', // Name
            '`User_Id`', // Expression
            '`User_Id`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`User_Id`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->User_Id->addMethod("getAutoUpdateValue", fn() => CurrentUserID());
        $this->User_Id->InputTextType = "text";
        $this->User_Id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->User_Id->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['User_Id'] = &$this->User_Id;

        // Add Doctrine Cache
        $this->Cache = new ArrayCache();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);

        // Call Table Load event
        $this->tableLoad();
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        }
    }

    // Update field sort
    public function updateFieldSort()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        $flds = GetSortFields($orderBy);
        foreach ($this->Fields as $field) {
            $fldSort = "";
            foreach ($flds as $fld) {
                if ($fld[0] == $field->Expression || $fld[0] == $field->VirtualExpression) {
                    $fldSort = $fld[1];
                }
            }
            $field->setSort($fldSort);
        }
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "laporan_pengabdian";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : "";
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter, $id = "")
    {
        global $Security;
        // Add User ID filter
        if ($Security->currentUserID() != "" && !$Security->isAdmin()) { // Non system admin
            $filter = $this->addUserIDFilter($filter, $id);
        }
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            case "lookup":
                return (($allow & 256) == 256);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlwrk);
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->getSqlAsQueryBuilder($where, $orderBy)->getSQL();
    }

    // Get QueryBuilder
    public function getSqlAsQueryBuilder($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        );
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    public function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        try {
            $success = $this->insertSql($rs)->execute();
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $success = false;
            $this->DbErrorMessage = $e->getMessage();
        }
        if ($success) {
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        try {
            $success = $this->updateSql($rs, $where, $curfilter)->execute();
            $success = ($success > 0) ? $success : true;
            $this->DbErrorMessage = "";
        } catch (\Exception $e) {
            $success = false;
            $this->DbErrorMessage = $e->getMessage();
        }
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('Id_kelompok', $rs)) {
                AddFilter($where, QuotedName('Id_kelompok', $this->Dbid) . '=' . QuotedValue($rs['Id_kelompok'], $this->Id_kelompok->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            try {
                $success = $this->deleteSql($rs, $where, $curfilter)->execute();
                $this->DbErrorMessage = "";
            } catch (\Exception $e) {
                $success = false;
                $this->DbErrorMessage = $e->getMessage();
            }
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->Id_kelompok->DbValue = $row['Id_kelompok'];
        $this->Lembar_Pengesahan->Upload->DbValue = $row['Lembar_Pengesahan'];
        $this->Laporan->Upload->DbValue = $row['Laporan'];
        $this->Luaran->Upload->DbValue = $row['Luaran'];
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue = $row['Surat_Keterangan_dari_Tempat_Mengabdi'];
        $this->Dokumentasi->Upload->DbValue = $row['Dokumentasi'];
        $this->Daftar_Hadir->Upload->DbValue = $row['Daftar_Hadir'];
        $this->Tanggal->DbValue = $row['Tanggal'];
        $this->IP->DbValue = $row['IP'];
        $this->user->DbValue = $row['user'];
        $this->User_Id->DbValue = $row['User_Id'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['Lembar_Pengesahan']) ? [] : [$row['Lembar_Pengesahan']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->Lembar_Pengesahan->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->Lembar_Pengesahan->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['Laporan']) ? [] : [$row['Laporan']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->Laporan->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->Laporan->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['Luaran']) ? [] : [$row['Luaran']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->Luaran->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->Luaran->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['Surat_Keterangan_dari_Tempat_Mengabdi']) ? [] : [$row['Surat_Keterangan_dari_Tempat_Mengabdi']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->Surat_Keterangan_dari_Tempat_Mengabdi->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->Surat_Keterangan_dari_Tempat_Mengabdi->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['Dokumentasi']) ? [] : [$row['Dokumentasi']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->Dokumentasi->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->Dokumentasi->oldPhysicalUploadPath() . $oldFile);
            }
        }
        $oldFiles = EmptyValue($row['Daftar_Hadir']) ? [] : [$row['Daftar_Hadir']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->Daftar_Hadir->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->Daftar_Hadir->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Id_kelompok` = '@Id_kelompok@'";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->Id_kelompok->CurrentValue : $this->Id_kelompok->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->Id_kelompok->CurrentValue = $keys[0];
            } else {
                $this->Id_kelompok->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Id_kelompok', $row) ? $row['Id_kelompok'] : null;
        } else {
            $val = !EmptyValue($this->Id_kelompok->OldValue) && !$current ? $this->Id_kelompok->OldValue : $this->Id_kelompok->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Id_kelompok@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("laporanpengabdianlist");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "laporanpengabdianview") {
            return $Language->phrase("View");
        } elseif ($pageName == "laporanpengabdianedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "laporanpengabdianadd") {
            return $Language->phrase("Add");
        }
        return "";
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "LaporanPengabdianView";
            case Config("API_ADD_ACTION"):
                return "LaporanPengabdianAdd";
            case Config("API_EDIT_ACTION"):
                return "LaporanPengabdianEdit";
            case Config("API_DELETE_ACTION"):
                return "LaporanPengabdianDelete";
            case Config("API_LIST_ACTION"):
                return "LaporanPengabdianList";
            default:
                return "";
        }
    }

    // Current URL
    public function getCurrentUrl($parm = "")
    {
        $url = CurrentPageUrl(false);
        if ($parm != "") {
            $url = $this->keyUrl($url, $parm);
        } else {
            $url = $this->keyUrl($url, Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // List URL
    public function getListUrl()
    {
        return "laporanpengabdianlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("laporanpengabdianview", $parm);
        } else {
            $url = $this->keyUrl("laporanpengabdianview", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "laporanpengabdianadd?" . $parm;
        } else {
            $url = "laporanpengabdianadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("laporanpengabdianedit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("laporanpengabdianlist", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("laporanpengabdianadd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("laporanpengabdianlist", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("laporanpengabdiandelete");
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"Id_kelompok\":" . JsonEncode($this->Id_kelompok->CurrentValue, "string");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Id_kelompok->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Id_kelompok->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language, $Page;
        $sortUrl = "";
        $attrs = "";
        if ($fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-ew-action="sort" data-ajax="' . ($this->UseAjaxActions ? "true" : "false") . '" data-sort-url="' . $sortUrl . '" data-sort-type="1"';
            if ($this->ContextClass) { // Add context
                $attrs .= ' data-context="' . HtmlEncode($this->ContextClass) . '"';
            }
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") . '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        global $DashboardReport;
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = "order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort();
            if ($DashboardReport) {
                $urlParm .= "&amp;dashboard=true";
            }
            return $this->addMasterUrl($this->CurrentPageName . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("Id_kelompok") ?? Route("Id_kelompok")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from records
    public function getFilterFromRecords($rows)
    {
        $keyFilter = "";
        foreach ($rows as $row) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            $keyFilter .= "(" . $this->getRecordFilter($row) . ")";
        }
        return $keyFilter;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->Id_kelompok->CurrentValue = $key;
            } else {
                $this->Id_kelompok->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter / sort
    public function loadRs($filter, $sort = "")
    {
        $sql = $this->getSql($filter, $sort); // Set up filter (WHERE Clause) / sort (ORDER BY Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->Id_kelompok->setDbValue($row['Id_kelompok']);
        $this->Lembar_Pengesahan->Upload->DbValue = $row['Lembar_Pengesahan'];
        $this->Laporan->Upload->DbValue = $row['Laporan'];
        $this->Luaran->Upload->DbValue = $row['Luaran'];
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue = $row['Surat_Keterangan_dari_Tempat_Mengabdi'];
        $this->Dokumentasi->Upload->DbValue = $row['Dokumentasi'];
        $this->Daftar_Hadir->Upload->DbValue = $row['Daftar_Hadir'];
        $this->Tanggal->setDbValue($row['Tanggal']);
        $this->IP->setDbValue($row['IP']);
        $this->user->setDbValue($row['user']);
        $this->User_Id->setDbValue($row['User_Id']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "LaporanPengabdianList";
        $listClass = PROJECT_NAMESPACE . $listPage;
        $page = new $listClass();
        $page->loadRecordsetFromFilter($filter);
        $view = Container("view");
        $template = $listPage . ".php"; // View
        $GLOBALS["Title"] ??= $page->Title; // Title
        try {
            $Response = $view->render($Response, $template, $GLOBALS);
        } finally {
            $page->terminate(); // Terminate page and clean up
        }
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // Id_kelompok

        // Lembar_Pengesahan

        // Laporan

        // Luaran

        // Surat_Keterangan_dari_Tempat_Mengabdi

        // Dokumentasi

        // Daftar_Hadir

        // Tanggal

        // IP

        // user

        // User_Id

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
        $this->Id_kelompok->TooltipValue = "";

        // Lembar_Pengesahan
        $this->Lembar_Pengesahan->HrefValue = "";
        $this->Lembar_Pengesahan->ExportHrefValue = $this->Lembar_Pengesahan->UploadPath . $this->Lembar_Pengesahan->Upload->DbValue;
        $this->Lembar_Pengesahan->TooltipValue = "";

        // Laporan
        $this->Laporan->HrefValue = "";
        $this->Laporan->ExportHrefValue = $this->Laporan->UploadPath . $this->Laporan->Upload->DbValue;
        $this->Laporan->TooltipValue = "";

        // Luaran
        $this->Luaran->HrefValue = "";
        $this->Luaran->ExportHrefValue = $this->Luaran->UploadPath . $this->Luaran->Upload->DbValue;
        $this->Luaran->TooltipValue = "";

        // Surat_Keterangan_dari_Tempat_Mengabdi
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->HrefValue = "";
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->ExportHrefValue = $this->Surat_Keterangan_dari_Tempat_Mengabdi->UploadPath . $this->Surat_Keterangan_dari_Tempat_Mengabdi->Upload->DbValue;
        $this->Surat_Keterangan_dari_Tempat_Mengabdi->TooltipValue = "";

        // Dokumentasi
        $this->Dokumentasi->HrefValue = "";
        $this->Dokumentasi->ExportHrefValue = $this->Dokumentasi->UploadPath . $this->Dokumentasi->Upload->DbValue;
        $this->Dokumentasi->TooltipValue = "";

        // Daftar_Hadir
        $this->Daftar_Hadir->HrefValue = "";
        $this->Daftar_Hadir->ExportHrefValue = $this->Daftar_Hadir->UploadPath . $this->Daftar_Hadir->Upload->DbValue;
        $this->Daftar_Hadir->TooltipValue = "";

        // Tanggal
        $this->Tanggal->HrefValue = "";
        $this->Tanggal->TooltipValue = "";

        // IP
        $this->IP->HrefValue = "";
        $this->IP->TooltipValue = "";

        // user
        $this->user->HrefValue = "";
        $this->user->TooltipValue = "";

        // User_Id
        $this->User_Id->HrefValue = "";
        $this->User_Id->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Id_kelompok
        $this->Id_kelompok->setupEditAttributes();
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

        // Tanggal

        // IP

        // user

        // User_Id

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
	// Now including Export Print (printer friendly), modification by Masino Sinaga, September 27, 2022 
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->Id_kelompok);
                    $doc->exportCaption($this->Lembar_Pengesahan);
                    $doc->exportCaption($this->Laporan);
                    $doc->exportCaption($this->Luaran);
                    $doc->exportCaption($this->Surat_Keterangan_dari_Tempat_Mengabdi);
                    $doc->exportCaption($this->Dokumentasi);
                    $doc->exportCaption($this->Daftar_Hadir);
                    $doc->exportCaption($this->Tanggal);
                } else {
                    $doc->exportCaption($this->Id_kelompok);
                    $doc->exportCaption($this->Lembar_Pengesahan);
                    $doc->exportCaption($this->Laporan);
                    $doc->exportCaption($this->Luaran);
                    $doc->exportCaption($this->Surat_Keterangan_dari_Tempat_Mengabdi);
                    $doc->exportCaption($this->Dokumentasi);
                    $doc->exportCaption($this->Daftar_Hadir);
                    $doc->exportCaption($this->Tanggal);
                    $doc->exportCaption($this->IP);
                    $doc->exportCaption($this->user);
                    $doc->exportCaption($this->User_Id);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
		// Begin of modification Record Number in Exported Data by Masino Sinaga, September 27, 2022
		$seqRec = 0;
		if (CurrentPageID() == "view") { // Modified by Masino Sinaga, reset seq. number in View Page
		    $_SESSION["First_Record"] = 0;
			$seqRec = (empty($_SESSION["First_Record"])) ? 0 : $_SESSION["First_Record"] - 1; 
		} else {
			$seqRec = (empty($_SESSION["First_Record"])) ? $recCnt : $_SESSION["First_Record"] - 1;
		}
		// End of modification Record Number in Exported Data by Masino Sinaga, September 27, 2022
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
			$seqRec++; // Record Number in Exported Data by Masino Sinaga, September 27, 2022
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;
                // Page break
				// Begin of modification PageBreak for Export to PDF dan Export to Word by Masino Sinaga, September 27, 2022
                if ($this->ExportPageBreakCount > 0 && ($this->Export == "pdf" || $this->Export =="word")) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
						$doc->beginExportRow(); // Begin of modification by Masino Sinaga, table header will be repeated at the top of each page after page break, must be handled from here for Export to PDF that has the possibility to repeat the table header column in each top of page
						$doc->exportCaption($this->Id_kelompok);
						$doc->exportCaption($this->Lembar_Pengesahan);
						$doc->exportCaption($this->Laporan);
						$doc->exportCaption($this->Luaran);
						$doc->exportCaption($this->Surat_Keterangan_dari_Tempat_Mengabdi);
						$doc->exportCaption($this->Dokumentasi);
						$doc->exportCaption($this->Daftar_Hadir);
						$doc->exportCaption($this->Tanggal);
						$doc->exportCaption($this->IP);
						$doc->exportCaption($this->user);
						$doc->exportCaption($this->User_Id);
						$doc->endExportRow(); // End of modification by Masino Sinaga, table header will be repeated at the top of each page after page break
                    }
                }
				// End of modification PageBreak for Export to PDF dan Export to Word by Masino Sinaga, September 27, 2022
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->Id_kelompok);
                        $doc->exportField($this->Lembar_Pengesahan);
                        $doc->exportField($this->Laporan);
                        $doc->exportField($this->Luaran);
                        $doc->exportField($this->Surat_Keterangan_dari_Tempat_Mengabdi);
                        $doc->exportField($this->Dokumentasi);
                        $doc->exportField($this->Daftar_Hadir);
                        $doc->exportField($this->Tanggal);
                    } else {
                        $doc->exportField($this->Id_kelompok);
                        $doc->exportField($this->Lembar_Pengesahan);
                        $doc->exportField($this->Laporan);
                        $doc->exportField($this->Luaran);
                        $doc->exportField($this->Surat_Keterangan_dari_Tempat_Mengabdi);
                        $doc->exportField($this->Dokumentasi);
                        $doc->exportField($this->Daftar_Hadir);
                        $doc->exportField($this->Tanggal);
                        $doc->exportField($this->IP);
                        $doc->exportField($this->user);
                        $doc->exportField($this->User_Id);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($doc, $row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Add User ID filter
    public function addUserIDFilter($filter = "", $id = "")
    {
        global $Security;
        $filterWrk = "";
        if ($id == "")
            $id = (CurrentPageID() == "list") ? $this->CurrentAction : CurrentPageID();
        if (!$this->userIDAllow($id) && !$Security->isAdmin()) {
            $filterWrk = $Security->userIdList();
            if ($filterWrk != "") {
                $filterWrk = '`user` IN (' . $filterWrk . ')';
            }
        }

        // Call User ID Filtering event
        $this->userIdFiltering($filterWrk);
        AddFilter($filter, $filterWrk);
        return $filter;
    }

    // User ID subquery
    public function getUserIDSubquery(&$fld, &$masterfld)
    {
        global $UserTable;
        $wrk = "";
        $sql = "SELECT " . $masterfld->Expression . " FROM laporan_pengabdian";
        $filter = $this->addUserIDFilter("");
        if ($filter != "") {
            $sql .= " WHERE " . $filter;
        }

        // List all values
        $conn = Conn($UserTable->Dbid);
        $config = $conn->getConfiguration();
        $config->setResultCacheImpl($this->Cache);
        if ($rs = $conn->executeCacheQuery($sql, [], [], $this->CacheProfile)->fetchAllNumeric()) {
            foreach ($rs as $row) {
                if ($wrk != "") {
                    $wrk .= ",";
                }
                $wrk .= QuotedValue($row[0], $masterfld->DataType, Config("USER_TABLE_DBID"));
            }
        }
        if ($wrk != "") {
            $wrk = $fld->Expression . " IN (" . $wrk . ")";
        } else { // No User ID value found
            $wrk = "0=1";
        }
        return $wrk;
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        global $DownloadFileName;
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'Lembar_Pengesahan') {
            $fldName = "Lembar_Pengesahan";
            $fileNameFld = "Lembar_Pengesahan";
        } elseif ($fldparm == 'Laporan') {
            $fldName = "Laporan";
            $fileNameFld = "Laporan";
        } elseif ($fldparm == 'Luaran') {
            $fldName = "Luaran";
            $fileNameFld = "Luaran";
        } elseif ($fldparm == 'Surat_Keterangan_dari_Tempat_Mengabdi') {
            $fldName = "Surat_Keterangan_dari_Tempat_Mengabdi";
            $fileNameFld = "Surat_Keterangan_dari_Tempat_Mengabdi";
        } elseif ($fldparm == 'Dokumentasi') {
            $fldName = "Dokumentasi";
            $fileNameFld = "Dokumentasi";
        } elseif ($fldparm == 'Daftar_Hadir') {
            $fldName = "Daftar_Hadir";
            $fileNameFld = "Daftar_Hadir";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->Id_kelompok->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssociative($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $ext = strtolower($pathinfo["extension"] ?? "");
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment" . ($DownloadFileName ? "; filename=\"" . $DownloadFileName . "\"" : ""));
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    if ($fld->hasMethod("getUploadPath")) { // Check field level upload path
                        $fld->UploadPath = $fld->getUploadPath();
                    }
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
        return false;
    }

    // Table level events
    // Table Load event
    public function tableLoad()
    {
        // Enter your code here
        $this->UseAjaxActions = true;
    }

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew) {
        // Enter your code here
        // To cancel, set return value to FALSE

           // Enter your code here
        // To cancel, set return value to FALSE
        if ($rsnew["Lembar_Pengesahan"] != "") { // pastikan ada file yang di-upload, updated on January 24, 2017
            $ekstensi_file = substr(strtolower(strrchr($rsnew["Lembar_Pengesahan"], ".")), 1);
            $tanggal = str_replace("-", "", $rsnew["Tanggal"]);
            $tanggal = str_replace(":", "", $tanggal);
            $tanggal = str_replace(" ", "", $tanggal);
            $rsnew["Lembar_Pengesahan"] = $rsnew["Id_kelompok"]."_".$rsnew["user"]."_".$tanggal. "_".$rsnew["Lembar_Pengesahan"]. "." .$ekstensi_file;
        }
           if ($rsnew["Laporan"] != "") { // pastikan ada file yang di-upload, updated on January 24, 2017
            $ekstensi_file = substr(strtolower(strrchr($rsnew["Laporan"], ".")), 1);
            $tanggal = str_replace("-", "", $rsnew["Tanggal"]);
            $tanggal = str_replace(":", "", $tanggal);
            $tanggal = str_replace(" ", "", $tanggal);
            $rsnew["Laporan"] = $rsnew["Id_kelompok"]."_".$rsnew["user"]."_".$tanggal. "_".$rsnew["Laporan"]. "." .$ekstensi_file;
        }
           if ($rsnew["Luaran"] != "") { // pastikan ada file yang di-upload, updated on January 24, 2017
            $ekstensi_file = substr(strtolower(strrchr($rsnew["Luaran"], ".")), 1);
            $tanggal = str_replace("-", "", $rsnew["Tanggal"]);
            $tanggal = str_replace(":", "", $tanggal);
            $tanggal = str_replace(" ", "", $tanggal);
            $rsnew["Luaran"] = $rsnew["Id_kelompok"]."_".$rsnew["user"]."_".$tanggal. "_".$rsnew["Luaran"]. "." .$ekstensi_file;
        }
         if ($rsnew["Surat_Keterangan_dari_Tempat_Mengabdi"] != "") { // pastikan ada file yang di-upload, updated on January 24, 2017
            $ekstensi_file = substr(strtolower(strrchr($rsnew["Surat_Keterangan_dari_Tempat_Mengabdi"], ".")), 1);
            $tanggal = str_replace("-", "", $rsnew["Tanggal"]);
            $tanggal = str_replace(":", "", $tanggal);
            $tanggal = str_replace(" ", "", $tanggal);
            $rsnew["Surat_Keterangan_dari_Tempat_Mengabdi"] = $rsnew["Id_kelompok"]."_".$rsnew["user"]."_".$tanggal. "_".$rsnew["Surat_Keterangan_dari_Tempat_Mengabdi"]. "." .$ekstensi_file;
        }
         if ($rsnew["Dokumentasi"] != "") { // pastikan ada file yang di-upload, updated on January 24, 2017
            $ekstensi_file = substr(strtolower(strrchr($rsnew["Dokumentasi"], ".")), 1);
            $tanggal = str_replace("-", "", $rsnew["Tanggal"]);
            $tanggal = str_replace(":", "", $tanggal);
            $tanggal = str_replace(" ", "", $tanggal);
            $rsnew["Dokumentasi"] = $rsnew["Id_kelompok"]."_".$rsnew["user"]."_".$tanggal. "_".$rsnew["Dokumentasi"]. "." .$ekstensi_file;
        }
         if ($rsnew["Daftar_Hadir"] != "") { // pastikan ada file yang di-upload, updated on January 24, 2017
            $ekstensi_file = substr(strtolower(strrchr($rsnew["Daftar_Hadir"], ".")), 1);
            $tanggal = str_replace("-", "", $rsnew["Tanggal"]);
            $tanggal = str_replace(":", "", $tanggal);
            $tanggal = str_replace(" ", "", $tanggal);
            $rsnew["Daftar_Hadir"] = $rsnew["Id_kelompok"]."_".$rsnew["user"]."_".$tanggal. "_".$rsnew["Daftar_Hadir"]. "." .$ekstensi_file;
        }
        return TRUE;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    public function rowUpdating($rsold, &$rsnew) {
        // Enter your code here
        // To cancel, set return value to FALSE
        if ($rsnew["Lembar_Pengesahan"] <> $rsold["Lembar_Pengesahan"] && $rsnew["Lembar_Pengesahan"] != "") { // pastikan ada file yang di-upload, updated on January 24, 2017
            $ekstensi_file = substr(strtolower(strrchr($rsnew["Lembar_Pengesahan"], ".")), 1);
            $tanggal = str_replace("-", "", $rsnew["Tanggal"]);
            $tanggal = str_replace(":", "", $tanggal);
            $tanggal = str_replace(" ", "", $tanggal);
            $rsnew["Lembar_Pengesahan"] = $rsnew["Id_kelompok"] . "_" . $rsnew["user"] . "_" . $tanggal. "_" . $rsnew["Lembar_Pengesahan"] . "." . $ekstensi_file;
        }
     if ($rsnew["Laporan"] <> $rsold["Laporan"] && $rsnew["Laporan"] != "") { // pastikan ada file yang di-upload, updated on January 24, 2017
            $ekstensi_file = substr(strtolower(strrchr($rsnew["Laporan"], ".")), 1);
            $tanggal = str_replace("-", "", $rsnew["Tanggal"]);
            $tanggal = str_replace(":", "", $tanggal);
            $tanggal = str_replace(" ", "", $tanggal);
            $rsnew["Laporan"] = $rsnew["Id_kelompok"] . "_" . $rsnew["user"] . "_" . $tanggal. "_" . $rsnew["Laporan"] . "." . $ekstensi_file;
        }
     if ($rsnew["Luaran"] <> $rsold["Luaran"] && $rsnew["Luaran"] != "") { // pastikan ada file yang di-upload, updated on January 24, 2017
            $ekstensi_file = substr(strtolower(strrchr($rsnew["Luaran"], ".")), 1);
            $tanggal = str_replace("-", "", $rsnew["Tanggal"]);
            $tanggal = str_replace(":", "", $tanggal);
            $tanggal = str_replace(" ", "", $tanggal);
            $rsnew["Luaran"] = $rsnew["Id_kelompok"] . "_" . $rsnew["user"] . "_" . $tanggal. "_" . $rsnew["Luaran"] . "." . $ekstensi_file;
        }
     if ($rsnew["Surat_Keterangan_dari_Tempat_Mengabdi"] <> $rsold["Surat_Keterangan_dari_Tempat_Mengabdi"] && $rsnew["Surat_Pernyataan_Kesediaan_Anggota"] != "") { // pastikan ada file yang di-upload, updated on January 24, 2017
            $ekstensi_file = substr(strtolower(strrchr($rsnew["Surat_Keterangan_dari_Tempat_Mengabdi"], ".")), 1);
            $tanggal = str_replace("-", "", $rsnew["Tanggal"]);
            $tanggal = str_replace(":", "", $tanggal);
            $tanggal = str_replace(" ", "", $tanggal);
            $rsnew["Surat_Keterangan_dari_Tempat_Mengabdi"] = $rsnew["Id_kelompok"] . "_" . $rsnew["user"] . "_" . $tanggal. "_" . $rsnew["Surat_Keterangan_dari_Tempat_Mengabdi"] . "." . $ekstensi_file;
        }
      if ($rsnew["Dokumentasi"] <> $rsold["Dokumentasi"] && $rsnew["Dokumentasi"] != "") { // pastikan ada file yang di-upload, updated on January 24, 2017
            $ekstensi_file = substr(strtolower(strrchr($rsnew["Dokumentasi"], ".")), 1);
            $tanggal = str_replace("-", "", $rsnew["Tanggal"]);
            $tanggal = str_replace(":", "", $tanggal);
            $tanggal = str_replace(" ", "", $tanggal);
            $rsnew["Dokumentasi"] = $rsnew["Id_kelompok"] . "_" . $rsnew["user"] . "_" . $tanggal. "_" . $rsnew["Dokumentasi"] . "." . $ekstensi_file;
        }
        if ($rsnew["Daftar_Hadir"] <> $rsold["Daftar_Hadir"] && $rsnew["Daftar_Hadir"] != "") { // pastikan ada file yang di-upload, updated on January 24, 2017
            $ekstensi_file = substr(strtolower(strrchr($rsnew["Daftar_Hadir"], ".")), 1);
            $tanggal = str_replace("-", "", $rsnew["Tanggal"]);
            $tanggal = str_replace(":", "", $tanggal);
            $tanggal = str_replace(" ", "", $tanggal);
            $rsnew["Daftar_Hadir"] = $rsnew["Id_kelompok"] . "_" . $rsnew["user"] . "_" . $tanggal. "_" . $rsnew["Daftar_Hadir"] . "." . $ekstensi_file;
        }
        return TRUE;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
