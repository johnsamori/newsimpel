<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for validasi
 */
class Validasi extends DbTable
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
    public $NIDN;
    public $Id_Sinta;
    public $Nama_Lengkap;
    public $Alamat;
    public $_Email;
    public $Jenis_Kelamin;
    public $Program_Studi;
    public $Jenjang_Pendidikan;
    public $Jabatan_Fungsional;
    public $Kepakaran;
    public $Rumpun_Ilmu;
    public $Aktif;
    public $Validasi;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("language");
        $this->TableVar = "validasi";
        $this->TableName = 'validasi';
        $this->TableType = "VIEW";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "validasi";
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
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this);

        // NIDN
        $this->NIDN = new DbField(
            $this, // Table
            'x_NIDN', // Variable name
            'NIDN', // Name
            '`NIDN`', // Expression
            '`NIDN`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`NIDN`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->NIDN->InputTextType = "text";
        $this->NIDN->IsPrimaryKey = true; // Primary key field
        $this->NIDN->Nullable = false; // NOT NULL field
        $this->NIDN->Required = true; // Required field
        $this->NIDN->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['NIDN'] = &$this->NIDN;

        // Id_Sinta
        $this->Id_Sinta = new DbField(
            $this, // Table
            'x_Id_Sinta', // Variable name
            'Id_Sinta', // Name
            '`Id_Sinta`', // Expression
            '`Id_Sinta`', // Basic search expression
            200, // Type
            7, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Id_Sinta`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Id_Sinta->InputTextType = "text";
        $this->Id_Sinta->Nullable = false; // NOT NULL field
        $this->Id_Sinta->Required = true; // Required field
        $this->Id_Sinta->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['Id_Sinta'] = &$this->Id_Sinta;

        // Nama_Lengkap
        $this->Nama_Lengkap = new DbField(
            $this, // Table
            'x_Nama_Lengkap', // Variable name
            'Nama_Lengkap', // Name
            '`Nama_Lengkap`', // Expression
            '`Nama_Lengkap`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Nama_Lengkap`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Nama_Lengkap->InputTextType = "text";
        $this->Nama_Lengkap->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Nama_Lengkap'] = &$this->Nama_Lengkap;

        // Alamat
        $this->Alamat = new DbField(
            $this, // Table
            'x_Alamat', // Variable name
            'Alamat', // Name
            '`Alamat`', // Expression
            '`Alamat`', // Basic search expression
            200, // Type
            200, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Alamat`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Alamat->InputTextType = "text";
        $this->Alamat->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Alamat'] = &$this->Alamat;

        // Email
        $this->_Email = new DbField(
            $this, // Table
            'x__Email', // Variable name
            'Email', // Name
            '`Email`', // Expression
            '`Email`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Email`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->_Email->InputTextType = "text";
        $this->_Email->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->_Email->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Email'] = &$this->_Email;

        // Jenis_Kelamin
        $this->Jenis_Kelamin = new DbField(
            $this, // Table
            'x_Jenis_Kelamin', // Variable name
            'Jenis_Kelamin', // Name
            '`Jenis_Kelamin`', // Expression
            '`Jenis_Kelamin`', // Basic search expression
            200, // Type
            15, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Jenis_Kelamin`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'RADIO' // Edit Tag
        );
        $this->Jenis_Kelamin->InputTextType = "text";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Jenis_Kelamin->Lookup = new Lookup('Jenis_Kelamin', 'validasi', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            case "id-ID":
                $this->Jenis_Kelamin->Lookup = new Lookup('Jenis_Kelamin', 'validasi', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->Jenis_Kelamin->Lookup = new Lookup('Jenis_Kelamin', 'validasi', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->Jenis_Kelamin->OptionCount = 2;
        $this->Jenis_Kelamin->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Jenis_Kelamin'] = &$this->Jenis_Kelamin;

        // Program_Studi
        $this->Program_Studi = new DbField(
            $this, // Table
            'x_Program_Studi', // Variable name
            'Program_Studi', // Name
            '`Program_Studi`', // Expression
            '`Program_Studi`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Program_Studi`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Program_Studi->InputTextType = "text";
        $this->Program_Studi->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Program_Studi'] = &$this->Program_Studi;

        // Jenjang_Pendidikan
        $this->Jenjang_Pendidikan = new DbField(
            $this, // Table
            'x_Jenjang_Pendidikan', // Variable name
            'Jenjang_Pendidikan', // Name
            '`Jenjang_Pendidikan`', // Expression
            '`Jenjang_Pendidikan`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Jenjang_Pendidikan`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->Jenjang_Pendidikan->InputTextType = "text";
        $this->Jenjang_Pendidikan->setSelectMultiple(false); // Select one
        $this->Jenjang_Pendidikan->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->Jenjang_Pendidikan->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Jenjang_Pendidikan->Lookup = new Lookup('Jenjang_Pendidikan', 'jenjang', false, 'Nama_Jenjang', ["Nama_Jenjang","","",""], '', '', [], [], [], [], [], [], '', '', "`Nama_Jenjang`");
                break;
            case "id-ID":
                $this->Jenjang_Pendidikan->Lookup = new Lookup('Jenjang_Pendidikan', 'jenjang', false, 'Nama_Jenjang', ["Nama_Jenjang","","",""], '', '', [], [], [], [], [], [], '', '', "`Nama_Jenjang`");
                break;
            default:
                $this->Jenjang_Pendidikan->Lookup = new Lookup('Jenjang_Pendidikan', 'jenjang', false, 'Nama_Jenjang', ["Nama_Jenjang","","",""], '', '', [], [], [], [], [], [], '', '', "`Nama_Jenjang`");
                break;
        }
        $this->Jenjang_Pendidikan->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Jenjang_Pendidikan'] = &$this->Jenjang_Pendidikan;

        // Jabatan_Fungsional
        $this->Jabatan_Fungsional = new DbField(
            $this, // Table
            'x_Jabatan_Fungsional', // Variable name
            'Jabatan_Fungsional', // Name
            '`Jabatan_Fungsional`', // Expression
            '`Jabatan_Fungsional`', // Basic search expression
            200, // Type
            255, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Jabatan_Fungsional`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->Jabatan_Fungsional->InputTextType = "text";
        $this->Jabatan_Fungsional->setSelectMultiple(false); // Select one
        $this->Jabatan_Fungsional->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->Jabatan_Fungsional->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Jabatan_Fungsional->Lookup = new Lookup('Jabatan_Fungsional', 'jabatan_fungsional', false, 'Nama_Jabatan', ["Nama_Jabatan","","",""], '', '', [], [], [], [], [], [], '', '', "`Nama_Jabatan`");
                break;
            case "id-ID":
                $this->Jabatan_Fungsional->Lookup = new Lookup('Jabatan_Fungsional', 'jabatan_fungsional', false, 'Nama_Jabatan', ["Nama_Jabatan","","",""], '', '', [], [], [], [], [], [], '', '', "`Nama_Jabatan`");
                break;
            default:
                $this->Jabatan_Fungsional->Lookup = new Lookup('Jabatan_Fungsional', 'jabatan_fungsional', false, 'Nama_Jabatan', ["Nama_Jabatan","","",""], '', '', [], [], [], [], [], [], '', '', "`Nama_Jabatan`");
                break;
        }
        $this->Jabatan_Fungsional->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Jabatan_Fungsional'] = &$this->Jabatan_Fungsional;

        // Kepakaran
        $this->Kepakaran = new DbField(
            $this, // Table
            'x_Kepakaran', // Variable name
            'Kepakaran', // Name
            '`Kepakaran`', // Expression
            '`Kepakaran`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Kepakaran`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->Kepakaran->InputTextType = "text";
        $this->Kepakaran->setSelectMultiple(false); // Select one
        $this->Kepakaran->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->Kepakaran->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Kepakaran->Lookup = new Lookup('Kepakaran', 'kepakaran', false, 'Kepakaran', ["Kepakaran","","",""], '', '', [], [], [], [], [], [], '', '', "`Kepakaran`");
                break;
            case "id-ID":
                $this->Kepakaran->Lookup = new Lookup('Kepakaran', 'kepakaran', false, 'Kepakaran', ["Kepakaran","","",""], '', '', [], [], [], [], [], [], '', '', "`Kepakaran`");
                break;
            default:
                $this->Kepakaran->Lookup = new Lookup('Kepakaran', 'kepakaran', false, 'Kepakaran', ["Kepakaran","","",""], '', '', [], [], [], [], [], [], '', '', "`Kepakaran`");
                break;
        }
        $this->Kepakaran->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Kepakaran'] = &$this->Kepakaran;

        // Rumpun_Ilmu
        $this->Rumpun_Ilmu = new DbField(
            $this, // Table
            'x_Rumpun_Ilmu', // Variable name
            'Rumpun_Ilmu', // Name
            '`Rumpun_Ilmu`', // Expression
            '`Rumpun_Ilmu`', // Basic search expression
            200, // Type
            200, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Rumpun_Ilmu`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Rumpun_Ilmu->InputTextType = "text";
        $this->Rumpun_Ilmu->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Rumpun_Ilmu'] = &$this->Rumpun_Ilmu;

        // Aktif
        $this->Aktif = new DbField(
            $this, // Table
            'x_Aktif', // Variable name
            'Aktif', // Name
            '`Aktif`', // Expression
            '`Aktif`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Aktif`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->Aktif->InputTextType = "text";
        $this->Aktif->setSelectMultiple(false); // Select one
        $this->Aktif->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->Aktif->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Aktif->Lookup = new Lookup('Aktif', 'validasi', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            case "id-ID":
                $this->Aktif->Lookup = new Lookup('Aktif', 'validasi', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->Aktif->Lookup = new Lookup('Aktif', 'validasi', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->Aktif->OptionCount = 2;
        $this->Aktif->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Aktif'] = &$this->Aktif;

        // Validasi
        $this->Validasi = new DbField(
            $this, // Table
            'x_Validasi', // Variable name
            'Validasi', // Name
            '`Validasi`', // Expression
            '`Validasi`', // Basic search expression
            200, // Type
            30, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Validasi`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->Validasi->InputTextType = "text";
        $this->Validasi->setSelectMultiple(false); // Select one
        $this->Validasi->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->Validasi->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Validasi->Lookup = new Lookup('Validasi', 'validasi', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            case "id-ID":
                $this->Validasi->Lookup = new Lookup('Validasi', 'validasi', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->Validasi->Lookup = new Lookup('Validasi', 'validasi', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->Validasi->OptionCount = 2;
        $this->Validasi->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Validasi'] = &$this->Validasi;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "validasi";
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
            if (array_key_exists('NIDN', $rs)) {
                AddFilter($where, QuotedName('NIDN', $this->Dbid) . '=' . QuotedValue($rs['NIDN'], $this->NIDN->DataType, $this->Dbid));
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
        $this->NIDN->DbValue = $row['NIDN'];
        $this->Id_Sinta->DbValue = $row['Id_Sinta'];
        $this->Nama_Lengkap->DbValue = $row['Nama_Lengkap'];
        $this->Alamat->DbValue = $row['Alamat'];
        $this->_Email->DbValue = $row['Email'];
        $this->Jenis_Kelamin->DbValue = $row['Jenis_Kelamin'];
        $this->Program_Studi->DbValue = $row['Program_Studi'];
        $this->Jenjang_Pendidikan->DbValue = $row['Jenjang_Pendidikan'];
        $this->Jabatan_Fungsional->DbValue = $row['Jabatan_Fungsional'];
        $this->Kepakaran->DbValue = $row['Kepakaran'];
        $this->Rumpun_Ilmu->DbValue = $row['Rumpun_Ilmu'];
        $this->Aktif->DbValue = $row['Aktif'];
        $this->Validasi->DbValue = $row['Validasi'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`NIDN` = '@NIDN@'";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->NIDN->CurrentValue : $this->NIDN->OldValue;
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
                $this->NIDN->CurrentValue = $keys[0];
            } else {
                $this->NIDN->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('NIDN', $row) ? $row['NIDN'] : null;
        } else {
            $val = !EmptyValue($this->NIDN->OldValue) && !$current ? $this->NIDN->OldValue : $this->NIDN->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@NIDN@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("validasilist");
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
        if ($pageName == "validasiview") {
            return $Language->phrase("View");
        } elseif ($pageName == "validasiedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "validasiadd") {
            return $Language->phrase("Add");
        }
        return "";
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "ValidasiView";
            case Config("API_ADD_ACTION"):
                return "ValidasiAdd";
            case Config("API_EDIT_ACTION"):
                return "ValidasiEdit";
            case Config("API_DELETE_ACTION"):
                return "ValidasiDelete";
            case Config("API_LIST_ACTION"):
                return "ValidasiList";
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
        return "validasilist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("validasiview", $parm);
        } else {
            $url = $this->keyUrl("validasiview", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "validasiadd?" . $parm;
        } else {
            $url = "validasiadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("validasiedit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("validasilist", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("validasiadd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("validasilist", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("validasidelete");
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
        $json .= "\"NIDN\":" . JsonEncode($this->NIDN->CurrentValue, "string");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->NIDN->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->NIDN->CurrentValue);
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
            if (($keyValue = Param("NIDN") ?? Route("NIDN")) !== null) {
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
                $this->NIDN->CurrentValue = $key;
            } else {
                $this->NIDN->OldValue = $key;
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

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "ValidasiList";
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
        $this->Rumpun_Ilmu->ViewValue = $this->Rumpun_Ilmu->CurrentValue;

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

        // NIDN
        $this->NIDN->setupEditAttributes();
        if (!$this->NIDN->Raw) {
            $this->NIDN->CurrentValue = HtmlDecode($this->NIDN->CurrentValue);
        }
        $this->NIDN->EditValue = $this->NIDN->CurrentValue;
        $this->NIDN->PlaceHolder = RemoveHtml($this->NIDN->caption());

        // Id_Sinta
        $this->Id_Sinta->setupEditAttributes();
        if (!$this->Id_Sinta->Raw) {
            $this->Id_Sinta->CurrentValue = HtmlDecode($this->Id_Sinta->CurrentValue);
        }
        $this->Id_Sinta->EditValue = $this->Id_Sinta->CurrentValue;
        $this->Id_Sinta->PlaceHolder = RemoveHtml($this->Id_Sinta->caption());

        // Nama_Lengkap
        $this->Nama_Lengkap->setupEditAttributes();
        if (!$this->Nama_Lengkap->Raw) {
            $this->Nama_Lengkap->CurrentValue = HtmlDecode($this->Nama_Lengkap->CurrentValue);
        }
        $this->Nama_Lengkap->EditValue = $this->Nama_Lengkap->CurrentValue;
        $this->Nama_Lengkap->PlaceHolder = RemoveHtml($this->Nama_Lengkap->caption());

        // Alamat
        $this->Alamat->setupEditAttributes();
        if (!$this->Alamat->Raw) {
            $this->Alamat->CurrentValue = HtmlDecode($this->Alamat->CurrentValue);
        }
        $this->Alamat->EditValue = $this->Alamat->CurrentValue;
        $this->Alamat->PlaceHolder = RemoveHtml($this->Alamat->caption());

        // Email
        $this->_Email->setupEditAttributes();
        if (!$this->_Email->Raw) {
            $this->_Email->CurrentValue = HtmlDecode($this->_Email->CurrentValue);
        }
        $this->_Email->EditValue = $this->_Email->CurrentValue;
        $this->_Email->PlaceHolder = RemoveHtml($this->_Email->caption());

        // Jenis_Kelamin
        $this->Jenis_Kelamin->EditValue = $this->Jenis_Kelamin->options(false);
        $this->Jenis_Kelamin->PlaceHolder = RemoveHtml($this->Jenis_Kelamin->caption());

        // Program_Studi
        $this->Program_Studi->setupEditAttributes();
        if (!$this->Program_Studi->Raw) {
            $this->Program_Studi->CurrentValue = HtmlDecode($this->Program_Studi->CurrentValue);
        }
        $this->Program_Studi->EditValue = $this->Program_Studi->CurrentValue;
        $this->Program_Studi->PlaceHolder = RemoveHtml($this->Program_Studi->caption());

        // Jenjang_Pendidikan
        $this->Jenjang_Pendidikan->setupEditAttributes();
        $this->Jenjang_Pendidikan->PlaceHolder = RemoveHtml($this->Jenjang_Pendidikan->caption());

        // Jabatan_Fungsional
        $this->Jabatan_Fungsional->setupEditAttributes();
        $this->Jabatan_Fungsional->PlaceHolder = RemoveHtml($this->Jabatan_Fungsional->caption());

        // Kepakaran
        $this->Kepakaran->setupEditAttributes();
        $this->Kepakaran->PlaceHolder = RemoveHtml($this->Kepakaran->caption());

        // Rumpun_Ilmu
        $this->Rumpun_Ilmu->setupEditAttributes();
        if (!$this->Rumpun_Ilmu->Raw) {
            $this->Rumpun_Ilmu->CurrentValue = HtmlDecode($this->Rumpun_Ilmu->CurrentValue);
        }
        $this->Rumpun_Ilmu->EditValue = $this->Rumpun_Ilmu->CurrentValue;
        $this->Rumpun_Ilmu->PlaceHolder = RemoveHtml($this->Rumpun_Ilmu->caption());

        // Aktif
        $this->Aktif->setupEditAttributes();
        $this->Aktif->EditValue = $this->Aktif->options(true);
        $this->Aktif->PlaceHolder = RemoveHtml($this->Aktif->caption());

        // Validasi
        $this->Validasi->setupEditAttributes();
        $this->Validasi->EditValue = $this->Validasi->options(true);
        $this->Validasi->PlaceHolder = RemoveHtml($this->Validasi->caption());

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
                    $doc->exportCaption($this->NIDN);
                    $doc->exportCaption($this->Id_Sinta);
                    $doc->exportCaption($this->Nama_Lengkap);
                    $doc->exportCaption($this->Alamat);
                    $doc->exportCaption($this->_Email);
                    $doc->exportCaption($this->Jenis_Kelamin);
                    $doc->exportCaption($this->Program_Studi);
                    $doc->exportCaption($this->Jenjang_Pendidikan);
                    $doc->exportCaption($this->Jabatan_Fungsional);
                    $doc->exportCaption($this->Kepakaran);
                    $doc->exportCaption($this->Rumpun_Ilmu);
                    $doc->exportCaption($this->Aktif);
                    $doc->exportCaption($this->Validasi);
                } else {
                    $doc->exportCaption($this->NIDN);
                    $doc->exportCaption($this->Id_Sinta);
                    $doc->exportCaption($this->Nama_Lengkap);
                    $doc->exportCaption($this->Alamat);
                    $doc->exportCaption($this->_Email);
                    $doc->exportCaption($this->Jenis_Kelamin);
                    $doc->exportCaption($this->Program_Studi);
                    $doc->exportCaption($this->Jenjang_Pendidikan);
                    $doc->exportCaption($this->Jabatan_Fungsional);
                    $doc->exportCaption($this->Kepakaran);
                    $doc->exportCaption($this->Rumpun_Ilmu);
                    $doc->exportCaption($this->Aktif);
                    $doc->exportCaption($this->Validasi);
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
						$doc->exportCaption($this->NIDN);
						$doc->exportCaption($this->Id_Sinta);
						$doc->exportCaption($this->Nama_Lengkap);
						$doc->exportCaption($this->Alamat);
						$doc->exportCaption($this->_Email);
						$doc->exportCaption($this->Jenis_Kelamin);
						$doc->exportCaption($this->Program_Studi);
						$doc->exportCaption($this->Jenjang_Pendidikan);
						$doc->exportCaption($this->Jabatan_Fungsional);
						$doc->exportCaption($this->Kepakaran);
						$doc->exportCaption($this->Rumpun_Ilmu);
						$doc->exportCaption($this->Aktif);
						$doc->exportCaption($this->Validasi);
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
                        $doc->exportField($this->NIDN);
                        $doc->exportField($this->Id_Sinta);
                        $doc->exportField($this->Nama_Lengkap);
                        $doc->exportField($this->Alamat);
                        $doc->exportField($this->_Email);
                        $doc->exportField($this->Jenis_Kelamin);
                        $doc->exportField($this->Program_Studi);
                        $doc->exportField($this->Jenjang_Pendidikan);
                        $doc->exportField($this->Jabatan_Fungsional);
                        $doc->exportField($this->Kepakaran);
                        $doc->exportField($this->Rumpun_Ilmu);
                        $doc->exportField($this->Aktif);
                        $doc->exportField($this->Validasi);
                    } else {
                        $doc->exportField($this->NIDN);
                        $doc->exportField($this->Id_Sinta);
                        $doc->exportField($this->Nama_Lengkap);
                        $doc->exportField($this->Alamat);
                        $doc->exportField($this->_Email);
                        $doc->exportField($this->Jenis_Kelamin);
                        $doc->exportField($this->Program_Studi);
                        $doc->exportField($this->Jenjang_Pendidikan);
                        $doc->exportField($this->Jabatan_Fungsional);
                        $doc->exportField($this->Kepakaran);
                        $doc->exportField($this->Rumpun_Ilmu);
                        $doc->exportField($this->Aktif);
                        $doc->exportField($this->Validasi);
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

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        global $DownloadFileName;

        // No binary fields
        return false;
    }

    // Table level events

    // Table Load event
    public function tableLoad()
    {
        // Enter your code here
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
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
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
