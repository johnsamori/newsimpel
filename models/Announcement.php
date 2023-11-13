<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for announcement
 */
class Announcement extends DbTable
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
    public $Announcement_ID;
    public $Is_Active;
    public $Topic;
    public $_Message;
    public $Date_LastUpdate;
    public $_Language;
    public $Auto_Publish;
    public $Date_Start;
    public $Date_End;
    public $Date_Created;
    public $Created_By;
    public $Translated_ID;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("language");
        $this->TableVar = "announcement";
        $this->TableName = 'announcement';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "announcement";
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

        // Announcement_ID
        $this->Announcement_ID = new DbField(
            $this, // Table
            'x_Announcement_ID', // Variable name
            'Announcement_ID', // Name
            '`Announcement_ID`', // Expression
            '`Announcement_ID`', // Basic search expression
            19, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Announcement_ID`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Announcement_ID->InputTextType = "text";
        $this->Announcement_ID->IsAutoIncrement = true; // Autoincrement field
        $this->Announcement_ID->IsPrimaryKey = true; // Primary key field
        $this->Announcement_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Announcement_ID->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Announcement_ID'] = &$this->Announcement_ID;

        // Is_Active
        $this->Is_Active = new DbField(
            $this, // Table
            'x_Is_Active', // Variable name
            'Is_Active', // Name
            '`Is_Active`', // Expression
            '`Is_Active`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Is_Active`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->Is_Active->addMethod("getDefault", fn() => "N");
        $this->Is_Active->InputTextType = "text";
        $this->Is_Active->Nullable = false; // NOT NULL field
        $this->Is_Active->DataType = DATATYPE_BOOLEAN;
        $this->Is_Active->TrueValue = "Y";
        $this->Is_Active->FalseValue = "N";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Is_Active->Lookup = new Lookup('Is_Active', 'announcement', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            case "id-ID":
                $this->Is_Active->Lookup = new Lookup('Is_Active', 'announcement', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->Is_Active->Lookup = new Lookup('Is_Active', 'announcement', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->Is_Active->OptionCount = 2;
        $this->Is_Active->SearchOperators = ["=", "<>"];
        $this->Fields['Is_Active'] = &$this->Is_Active;

        // Topic
        $this->Topic = new DbField(
            $this, // Table
            'x_Topic', // Variable name
            'Topic', // Name
            '`Topic`', // Expression
            '`Topic`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Topic`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Topic->InputTextType = "text";
        $this->Topic->Nullable = false; // NOT NULL field
        $this->Topic->Required = true; // Required field
        $this->Topic->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['Topic'] = &$this->Topic;

        // Message
        $this->_Message = new DbField(
            $this, // Table
            'x__Message', // Variable name
            'Message', // Name
            '`Message`', // Expression
            '`Message`', // Basic search expression
            201, // Type
            16777215, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Message`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->_Message->InputTextType = "text";
        $this->_Message->Nullable = false; // NOT NULL field
        $this->_Message->Required = true; // Required field
        $this->_Message->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['Message'] = &$this->_Message;

        // Date_LastUpdate
        $this->Date_LastUpdate = new DbField(
            $this, // Table
            'x_Date_LastUpdate', // Variable name
            'Date_LastUpdate', // Name
            '`Date_LastUpdate`', // Expression
            CastDateFieldForLike("`Date_LastUpdate`", 1, "DB"), // Basic search expression
            135, // Type
            19, // Size
            1, // Date/Time format
            false, // Is upload field
            '`Date_LastUpdate`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Date_LastUpdate->InputTextType = "text";
        $this->Date_LastUpdate->DefaultErrorMessage = str_replace("%s", DateFormat(1), $Language->phrase("IncorrectDate"));
        $this->Date_LastUpdate->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Date_LastUpdate'] = &$this->Date_LastUpdate;

        // Language
        $this->_Language = new DbField(
            $this, // Table
            'x__Language', // Variable name
            'Language', // Name
            '`Language`', // Expression
            '`Language`', // Basic search expression
            200, // Type
            5, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Language`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->_Language->addMethod("getDefault", fn() => "en");
        $this->_Language->InputTextType = "text";
        $this->_Language->Nullable = false; // NOT NULL field
        $this->_Language->Required = true; // Required field
        $this->_Language->setSelectMultiple(false); // Select one
        $this->_Language->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->_Language->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->_Language->Lookup = new Lookup('Language', 'languages', false, 'Language_Code', ["Language_Name","","",""], '', '', [], [], [], [], [], [], '', '', "`Language_Name`");
                break;
            case "id-ID":
                $this->_Language->Lookup = new Lookup('Language', 'languages', false, 'Language_Code', ["Language_Name","","",""], '', '', [], [], [], [], [], [], '', '', "`Language_Name`");
                break;
            default:
                $this->_Language->Lookup = new Lookup('Language', 'languages', false, 'Language_Code', ["Language_Name","","",""], '', '', [], [], [], [], [], [], '', '', "`Language_Name`");
                break;
        }
        $this->_Language->SearchOperators = ["=", "<>"];
        $this->Fields['Language'] = &$this->_Language;

        // Auto_Publish
        $this->Auto_Publish = new DbField(
            $this, // Table
            'x_Auto_Publish', // Variable name
            'Auto_Publish', // Name
            '`Auto_Publish`', // Expression
            '`Auto_Publish`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Auto_Publish`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->Auto_Publish->addMethod("getDefault", fn() => "N");
        $this->Auto_Publish->InputTextType = "text";
        $this->Auto_Publish->DataType = DATATYPE_BOOLEAN;
        $this->Auto_Publish->TrueValue = "Y";
        $this->Auto_Publish->FalseValue = "N";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Auto_Publish->Lookup = new Lookup('Auto_Publish', 'announcement', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            case "id-ID":
                $this->Auto_Publish->Lookup = new Lookup('Auto_Publish', 'announcement', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->Auto_Publish->Lookup = new Lookup('Auto_Publish', 'announcement', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->Auto_Publish->OptionCount = 2;
        $this->Auto_Publish->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Auto_Publish'] = &$this->Auto_Publish;

        // Date_Start
        $this->Date_Start = new DbField(
            $this, // Table
            'x_Date_Start', // Variable name
            'Date_Start', // Name
            '`Date_Start`', // Expression
            CastDateFieldForLike("`Date_Start`", 1, "DB"), // Basic search expression
            135, // Type
            19, // Size
            1, // Date/Time format
            false, // Is upload field
            '`Date_Start`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Date_Start->InputTextType = "text";
        $this->Date_Start->DefaultErrorMessage = str_replace("%s", DateFormat(1), $Language->phrase("IncorrectDate"));
        $this->Date_Start->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Date_Start'] = &$this->Date_Start;

        // Date_End
        $this->Date_End = new DbField(
            $this, // Table
            'x_Date_End', // Variable name
            'Date_End', // Name
            '`Date_End`', // Expression
            CastDateFieldForLike("`Date_End`", 1, "DB"), // Basic search expression
            135, // Type
            19, // Size
            1, // Date/Time format
            false, // Is upload field
            '`Date_End`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Date_End->InputTextType = "text";
        $this->Date_End->DefaultErrorMessage = str_replace("%s", DateFormat(1), $Language->phrase("IncorrectDate"));
        $this->Date_End->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Date_End'] = &$this->Date_End;

        // Date_Created
        $this->Date_Created = new DbField(
            $this, // Table
            'x_Date_Created', // Variable name
            'Date_Created', // Name
            '`Date_Created`', // Expression
            CastDateFieldForLike("`Date_Created`", 1, "DB"), // Basic search expression
            135, // Type
            19, // Size
            1, // Date/Time format
            false, // Is upload field
            '`Date_Created`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Date_Created->InputTextType = "text";
        $this->Date_Created->DefaultErrorMessage = str_replace("%s", DateFormat(1), $Language->phrase("IncorrectDate"));
        $this->Date_Created->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Date_Created'] = &$this->Date_Created;

        // Created_By
        $this->Created_By = new DbField(
            $this, // Table
            'x_Created_By', // Variable name
            'Created_By', // Name
            '`Created_By`', // Expression
            '`Created_By`', // Basic search expression
            200, // Type
            200, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Created_By`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->Created_By->InputTextType = "text";
        $this->Created_By->setSelectMultiple(false); // Select one
        $this->Created_By->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->Created_By->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Created_By->Lookup = new Lookup('Created_By', 'users', false, 'Username', ["First_Name","Last_Name","",""], '', '', [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`First_Name`, ''),'" . ValueSeparator(1, $this->Created_By) . "',COALESCE(`Last_Name`,''))");
                break;
            case "id-ID":
                $this->Created_By->Lookup = new Lookup('Created_By', 'users', false, 'Username', ["First_Name","Last_Name","",""], '', '', [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`First_Name`, ''),'" . ValueSeparator(1, $this->Created_By) . "',COALESCE(`Last_Name`,''))");
                break;
            default:
                $this->Created_By->Lookup = new Lookup('Created_By', 'users', false, 'Username', ["First_Name","Last_Name","",""], '', '', [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`First_Name`, ''),'" . ValueSeparator(1, $this->Created_By) . "',COALESCE(`Last_Name`,''))");
                break;
        }
        $this->Created_By->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Created_By'] = &$this->Created_By;

        // Translated_ID
        $this->Translated_ID = new DbField(
            $this, // Table
            'x_Translated_ID', // Variable name
            'Translated_ID', // Name
            '`Translated_ID`', // Expression
            '`Translated_ID`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Translated_ID`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->Translated_ID->InputTextType = "text";
        $this->Translated_ID->setSelectMultiple(false); // Select one
        $this->Translated_ID->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->Translated_ID->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Translated_ID->Lookup = new Lookup('Translated_ID', 'announcement', false, 'Announcement_ID', ["Topic","","",""], '', '', [], [], [], [], [], [], '', '', "`Topic`");
                break;
            case "id-ID":
                $this->Translated_ID->Lookup = new Lookup('Translated_ID', 'announcement', false, 'Announcement_ID', ["Topic","","",""], '', '', [], [], [], [], [], [], '', '', "`Topic`");
                break;
            default:
                $this->Translated_ID->Lookup = new Lookup('Translated_ID', 'announcement', false, 'Announcement_ID', ["Topic","","",""], '', '', [], [], [], [], [], [], '', '', "`Topic`");
                break;
        }
        $this->Translated_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Translated_ID->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Translated_ID'] = &$this->Translated_ID;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "announcement";
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
            // Get insert id if necessary
            $this->Announcement_ID->setDbValue($conn->lastInsertId());
            $rs['Announcement_ID'] = $this->Announcement_ID->DbValue;
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

        // Return auto increment field
        if ($success) {
            if (!isset($rs['Announcement_ID']) && !EmptyValue($this->Announcement_ID->CurrentValue)) {
                $rs['Announcement_ID'] = $this->Announcement_ID->CurrentValue;
            }
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
            if (array_key_exists('Announcement_ID', $rs)) {
                AddFilter($where, QuotedName('Announcement_ID', $this->Dbid) . '=' . QuotedValue($rs['Announcement_ID'], $this->Announcement_ID->DataType, $this->Dbid));
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
        $this->Announcement_ID->DbValue = $row['Announcement_ID'];
        $this->Is_Active->DbValue = $row['Is_Active'];
        $this->Topic->DbValue = $row['Topic'];
        $this->_Message->DbValue = $row['Message'];
        $this->Date_LastUpdate->DbValue = $row['Date_LastUpdate'];
        $this->_Language->DbValue = $row['Language'];
        $this->Auto_Publish->DbValue = $row['Auto_Publish'];
        $this->Date_Start->DbValue = $row['Date_Start'];
        $this->Date_End->DbValue = $row['Date_End'];
        $this->Date_Created->DbValue = $row['Date_Created'];
        $this->Created_By->DbValue = $row['Created_By'];
        $this->Translated_ID->DbValue = $row['Translated_ID'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Announcement_ID` = @Announcement_ID@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->Announcement_ID->CurrentValue : $this->Announcement_ID->OldValue;
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
                $this->Announcement_ID->CurrentValue = $keys[0];
            } else {
                $this->Announcement_ID->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Announcement_ID', $row) ? $row['Announcement_ID'] : null;
        } else {
            $val = !EmptyValue($this->Announcement_ID->OldValue) && !$current ? $this->Announcement_ID->OldValue : $this->Announcement_ID->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Announcement_ID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("announcementlist");
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
        if ($pageName == "announcementview") {
            return $Language->phrase("View");
        } elseif ($pageName == "announcementedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "announcementadd") {
            return $Language->phrase("Add");
        }
        return "";
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "AnnouncementView";
            case Config("API_ADD_ACTION"):
                return "AnnouncementAdd";
            case Config("API_EDIT_ACTION"):
                return "AnnouncementEdit";
            case Config("API_DELETE_ACTION"):
                return "AnnouncementDelete";
            case Config("API_LIST_ACTION"):
                return "AnnouncementList";
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
        return "announcementlist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("announcementview", $parm);
        } else {
            $url = $this->keyUrl("announcementview", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "announcementadd?" . $parm;
        } else {
            $url = "announcementadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("announcementedit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("announcementlist", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("announcementadd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("announcementlist", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("announcementdelete");
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
        $json .= "\"Announcement_ID\":" . JsonEncode($this->Announcement_ID->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Announcement_ID->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Announcement_ID->CurrentValue);
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
            if (($keyValue = Param("Announcement_ID") ?? Route("Announcement_ID")) !== null) {
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
                if (!is_numeric($key)) {
                    continue;
                }
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
                $this->Announcement_ID->CurrentValue = $key;
            } else {
                $this->Announcement_ID->OldValue = $key;
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

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "AnnouncementList";
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

        // Announcement_ID

        // Is_Active

        // Topic

        // Message

        // Date_LastUpdate

        // Language

        // Auto_Publish

        // Date_Start

        // Date_End

        // Date_Created

        // Created_By

        // Translated_ID

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
        $this->Announcement_ID->TooltipValue = "";

        // Is_Active
        $this->Is_Active->HrefValue = "";
        $this->Is_Active->TooltipValue = "";

        // Topic
        $this->Topic->HrefValue = "";
        $this->Topic->TooltipValue = "";

        // Message
        $this->_Message->HrefValue = "";
        $this->_Message->TooltipValue = "";

        // Date_LastUpdate
        $this->Date_LastUpdate->HrefValue = "";
        $this->Date_LastUpdate->TooltipValue = "";

        // Language
        $this->_Language->HrefValue = "";
        $this->_Language->TooltipValue = "";

        // Auto_Publish
        $this->Auto_Publish->HrefValue = "";
        $this->Auto_Publish->TooltipValue = "";

        // Date_Start
        $this->Date_Start->HrefValue = "";
        $this->Date_Start->TooltipValue = "";

        // Date_End
        $this->Date_End->HrefValue = "";
        $this->Date_End->TooltipValue = "";

        // Date_Created
        $this->Date_Created->HrefValue = "";
        $this->Date_Created->TooltipValue = "";

        // Created_By
        $this->Created_By->HrefValue = "";
        $this->Created_By->TooltipValue = "";

        // Translated_ID
        $this->Translated_ID->HrefValue = "";
        $this->Translated_ID->TooltipValue = "";

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
        $this->Topic->EditValue = $this->Topic->CurrentValue;
        $this->Topic->PlaceHolder = RemoveHtml($this->Topic->caption());

        // Message
        $this->_Message->setupEditAttributes();
        $this->_Message->EditValue = $this->_Message->CurrentValue;
        $this->_Message->PlaceHolder = RemoveHtml($this->_Message->caption());

        // Date_LastUpdate
        $this->Date_LastUpdate->setupEditAttributes();
        $this->Date_LastUpdate->EditValue = FormatDateTime($this->Date_LastUpdate->CurrentValue, $this->Date_LastUpdate->formatPattern());
        $this->Date_LastUpdate->PlaceHolder = RemoveHtml($this->Date_LastUpdate->caption());

        // Language
        $this->_Language->setupEditAttributes();
        $this->_Language->PlaceHolder = RemoveHtml($this->_Language->caption());

        // Auto_Publish
        $this->Auto_Publish->EditValue = $this->Auto_Publish->options(false);
        $this->Auto_Publish->PlaceHolder = RemoveHtml($this->Auto_Publish->caption());

        // Date_Start
        $this->Date_Start->setupEditAttributes();
        $this->Date_Start->EditValue = FormatDateTime($this->Date_Start->CurrentValue, $this->Date_Start->formatPattern());
        $this->Date_Start->PlaceHolder = RemoveHtml($this->Date_Start->caption());

        // Date_End
        $this->Date_End->setupEditAttributes();
        $this->Date_End->EditValue = FormatDateTime($this->Date_End->CurrentValue, $this->Date_End->formatPattern());
        $this->Date_End->PlaceHolder = RemoveHtml($this->Date_End->caption());

        // Date_Created
        $this->Date_Created->setupEditAttributes();
        $this->Date_Created->EditValue = FormatDateTime($this->Date_Created->CurrentValue, $this->Date_Created->formatPattern());
        $this->Date_Created->PlaceHolder = RemoveHtml($this->Date_Created->caption());

        // Created_By
        $this->Created_By->setupEditAttributes();
        $this->Created_By->PlaceHolder = RemoveHtml($this->Created_By->caption());

        // Translated_ID
        $this->Translated_ID->setupEditAttributes();
        $this->Translated_ID->PlaceHolder = RemoveHtml($this->Translated_ID->caption());

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
                    $doc->exportCaption($this->Announcement_ID);
                    $doc->exportCaption($this->Is_Active);
                    $doc->exportCaption($this->Topic);
                    $doc->exportCaption($this->_Message);
                    $doc->exportCaption($this->Date_LastUpdate);
                    $doc->exportCaption($this->_Language);
                    $doc->exportCaption($this->Auto_Publish);
                    $doc->exportCaption($this->Date_Start);
                    $doc->exportCaption($this->Date_End);
                    $doc->exportCaption($this->Date_Created);
                    $doc->exportCaption($this->Created_By);
                    $doc->exportCaption($this->Translated_ID);
                } else {
                    $doc->exportCaption($this->Announcement_ID);
                    $doc->exportCaption($this->Is_Active);
                    $doc->exportCaption($this->Topic);
                    $doc->exportCaption($this->Date_LastUpdate);
                    $doc->exportCaption($this->_Language);
                    $doc->exportCaption($this->Auto_Publish);
                    $doc->exportCaption($this->Date_Start);
                    $doc->exportCaption($this->Date_End);
                    $doc->exportCaption($this->Date_Created);
                    $doc->exportCaption($this->Created_By);
                    $doc->exportCaption($this->Translated_ID);
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
						$doc->exportCaption($this->Announcement_ID);
						$doc->exportCaption($this->Is_Active);
						$doc->exportCaption($this->Topic);
						$doc->exportCaption($this->Date_LastUpdate);
						$doc->exportCaption($this->_Language);
						$doc->exportCaption($this->Auto_Publish);
						$doc->exportCaption($this->Date_Start);
						$doc->exportCaption($this->Date_End);
						$doc->exportCaption($this->Date_Created);
						$doc->exportCaption($this->Created_By);
						$doc->exportCaption($this->Translated_ID);
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
                        $doc->exportField($this->Announcement_ID);
                        $doc->exportField($this->Is_Active);
                        $doc->exportField($this->Topic);
                        $doc->exportField($this->_Message);
                        $doc->exportField($this->Date_LastUpdate);
                        $doc->exportField($this->_Language);
                        $doc->exportField($this->Auto_Publish);
                        $doc->exportField($this->Date_Start);
                        $doc->exportField($this->Date_End);
                        $doc->exportField($this->Date_Created);
                        $doc->exportField($this->Created_By);
                        $doc->exportField($this->Translated_ID);
                    } else {
                        $doc->exportField($this->Announcement_ID);
                        $doc->exportField($this->Is_Active);
                        $doc->exportField($this->Topic);
                        $doc->exportField($this->Date_LastUpdate);
                        $doc->exportField($this->_Language);
                        $doc->exportField($this->Auto_Publish);
                        $doc->exportField($this->Date_Start);
                        $doc->exportField($this->Date_End);
                        $doc->exportField($this->Date_Created);
                        $doc->exportField($this->Created_By);
                        $doc->exportField($this->Translated_ID);
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
        if (strtotime($rsnew["Date_Start"]) > strtotime($rsnew["Date_End"])) {
    		$this->setFailureMessage("Date of Start must be lower or equal with Date of End.");    
    		return FALSE;
    	}
    	$sDateIntersects = GetIntersectTwoDates($rsnew["Date_Start"], $rsnew["Date_End"], $rsnew["Language"]);
    	if ($sDateIntersects!="") {
    		$this->setFailureMessage("There is/are the intersection of date with another announcement: ".$sDateIntersects);
    		return FALSE;
    	}
    	$val = ExecuteScalar("SELECT Topic FROM ".MS_ANNOUNCEMENT_TABLE." WHERE Language = '".$rsnew["Language"]."' AND Translated_ID = ".$rsnew["Translated_ID"]."");
    	if ($val <> "") {
    		$this->setFailureMessage("The announcement with the same Language and Translated_ID already exists in the Announcements table. <br><br>Please select another Language and/or Translated ID!");
    		return FALSE;
    	}
    	$rsnew["Date_Start"] = $rsnew["Date_Start"]; // ." 00:00:01";
    	$rsnew["Date_End"] = $rsnew["Date_End"]; // ." 23:59:59";
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
        if (strtotime($rsnew["Date_Start"]) > strtotime($rsnew["Date_End"])) {
    		$this->setFailureMessage("Date of Start must be lower or equal with Date of End.");    
    		return FALSE;
    	}
    	$sDateBeginEdit = ($rsold["Date_Start"] != $rsnew["Date_Start"]) ? $rsnew["Date_Start"] : $rsold["Date_Start"];
    	$sDateEndEdit = ($rsold["Date_End"] != $rsnew["Date_End"]) ? $rsnew["Date_End"] : $rsold["Date_End"];
    	$sLangEdit = ($rsold["Language"] != $rsnew["Language"]) ? $rsnew["Language"] : $rsold["Language"];
    	$sTransEdit = ($rsold["Translated_ID"] != $rsnew["Translated_ID"]) ? $rsnew["Translated_ID"] : $rsold["Translated_ID"];
    	$sIDIntersects = GetIntersectTwoDatesEditMode($rsold["Announcement_ID"], $sDateBeginEdit, $sDateEndEdit, $sLangEdit);
    	if (!empty($sIDIntersects)) {
    		list($sID, $sIntersectDates) = explode('#', $sIDIntersects);
    		if ( $sIntersectDates != "" && ($sID!=$rsold["Announcement_ID"]) ) {
    			$this->setFailureMessage("There is/are the intersection of date with another announcement: ".$sIntersectDates);            
    			return FALSE;
    		}
    	}
    	$rsnew["Date_Start"] = $sDateBeginEdit; // ." 00:00:01";
    	$rsnew["Date_End"] = $sDateEndEdit; // ." 23:59:59";
    	if ($sTransEdit != "") {
    		UpdateDatesInOtherLanguage($rsnew["Date_Start"], $rsnew["Date_End"], $rsold["Announcement_ID"]);
    	}
        return true;
    }
    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        ExecuteStatement("UPDATE " . Config("MS_ANNOUNCEMENT_TABLE") . " SET Date_Start = '" . $rsnew["Date_Start"] . "', Date_End = '" . $rsnew["Date_End"] . "' WHERE Translated_ID = " . $rsold["Announcement_ID"]);
    	$this->setSuccessMessage("Successfully updated the related translation record(s).");
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
