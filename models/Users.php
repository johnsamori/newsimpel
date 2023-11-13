<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for users
 */
class Users extends DbTable
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
    public $_Username;
    public $_Password;
    public $First_Name;
    public $Last_Name;
    public $_Email;
    public $User_Level;
    public $Report_To;
    public $Activated;
    public $Locked;
    public $_Profile;
    public $Photo;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("language");
        $this->TableVar = "users";
        $this->TableName = 'users';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "users";
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

        // Username
        $this->_Username = new DbField(
            $this, // Table
            'x__Username', // Variable name
            'Username', // Name
            '`Username`', // Expression
            '`Username`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Username`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->_Username->InputTextType = "text";
        $this->_Username->IsPrimaryKey = true; // Primary key field
        $this->_Username->Nullable = false; // NOT NULL field
        $this->_Username->Required = true; // Required field
        $this->_Username->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['Username'] = &$this->_Username;

        // Password
        $this->_Password = new DbField(
            $this, // Table
            'x__Password', // Variable name
            'Password', // Name
            '`Password`', // Expression
            '`Password`', // Basic search expression
            200, // Type
            64, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Password`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'PASSWORD' // Edit Tag
        );
        $this->_Password->InputTextType = "text";
        if (Config("ENCRYPTED_PASSWORD")) {
            $this->_Password->Raw = true;
        }
        $this->_Password->Nullable = false; // NOT NULL field
        $this->_Password->Required = true; // Required field
        $this->_Password->Sortable = false; // Allow sort
        $this->_Password->SearchOperators = ["=", "<>"];
        $this->Fields['Password'] = &$this->_Password;

        // First_Name
        $this->First_Name = new DbField(
            $this, // Table
            'x_First_Name', // Variable name
            'First_Name', // Name
            '`First_Name`', // Expression
            '`First_Name`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`First_Name`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->First_Name->InputTextType = "text";
        $this->First_Name->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['First_Name'] = &$this->First_Name;

        // Last_Name
        $this->Last_Name = new DbField(
            $this, // Table
            'x_Last_Name', // Variable name
            'Last_Name', // Name
            '`Last_Name`', // Expression
            '`Last_Name`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Last_Name`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Last_Name->InputTextType = "text";
        $this->Last_Name->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Last_Name'] = &$this->Last_Name;

        // Email
        $this->_Email = new DbField(
            $this, // Table
            'x__Email', // Variable name
            'Email', // Name
            '`Email`', // Expression
            '`Email`', // Basic search expression
            200, // Type
            100, // Size
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
        $this->_Email->Required = true; // Required field
        $this->_Email->DefaultErrorMessage = $Language->phrase("IncorrectEmail");
        $this->_Email->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Email'] = &$this->_Email;

        // User_Level
        $this->User_Level = new DbField(
            $this, // Table
            'x_User_Level', // Variable name
            'User_Level', // Name
            '`User_Level`', // Expression
            '`User_Level`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`User_Level`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->User_Level->InputTextType = "text";
        $this->User_Level->Nullable = false; // NOT NULL field
        $this->User_Level->Required = true; // Required field
        $this->User_Level->setSelectMultiple(false); // Select one
        $this->User_Level->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->User_Level->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->User_Level->Lookup = new Lookup('User_Level', 'userlevels', false, 'User_Level_ID', ["User_Level_Name","","",""], '', '', [], [], [], [], [], [], '', '', "`User_Level_Name`");
                break;
            case "id-ID":
                $this->User_Level->Lookup = new Lookup('User_Level', 'userlevels', false, 'User_Level_ID', ["User_Level_Name","","",""], '', '', [], [], [], [], [], [], '', '', "`User_Level_Name`");
                break;
            default:
                $this->User_Level->Lookup = new Lookup('User_Level', 'userlevels', false, 'User_Level_ID', ["User_Level_Name","","",""], '', '', [], [], [], [], [], [], '', '', "`User_Level_Name`");
                break;
        }
        $this->User_Level->SearchOperators = ["=", "<>"];
        $this->Fields['User_Level'] = &$this->User_Level;

        // Report_To
        $this->Report_To = new DbField(
            $this, // Table
            'x_Report_To', // Variable name
            'Report_To', // Name
            '`Report_To`', // Expression
            '`Report_To`', // Basic search expression
            200, // Type
            50, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Report_To`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Report_To->InputTextType = "text";
        $this->Report_To->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Report_To'] = &$this->Report_To;

        // Activated
        $this->Activated = new DbField(
            $this, // Table
            'x_Activated', // Variable name
            'Activated', // Name
            '`Activated`', // Expression
            '`Activated`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Activated`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->Activated->addMethod("getDefault", fn() => "N");
        $this->Activated->InputTextType = "text";
        $this->Activated->Nullable = false; // NOT NULL field
        $this->Activated->DataType = DATATYPE_BOOLEAN;
        $this->Activated->TrueValue = "Y";
        $this->Activated->FalseValue = "N";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Activated->Lookup = new Lookup('Activated', 'users', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            case "id-ID":
                $this->Activated->Lookup = new Lookup('Activated', 'users', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->Activated->Lookup = new Lookup('Activated', 'users', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->Activated->OptionCount = 2;
        $this->Activated->SearchOperators = ["=", "<>"];
        $this->Fields['Activated'] = &$this->Activated;

        // Locked
        $this->Locked = new DbField(
            $this, // Table
            'x_Locked', // Variable name
            'Locked', // Name
            '`Locked`', // Expression
            '`Locked`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Locked`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->Locked->addMethod("getDefault", fn() => "N");
        $this->Locked->InputTextType = "text";
        $this->Locked->DataType = DATATYPE_BOOLEAN;
        $this->Locked->TrueValue = "Y";
        $this->Locked->FalseValue = "N";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Locked->Lookup = new Lookup('Locked', 'users', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            case "id-ID":
                $this->Locked->Lookup = new Lookup('Locked', 'users', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->Locked->Lookup = new Lookup('Locked', 'users', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->Locked->OptionCount = 2;
        $this->Locked->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Locked'] = &$this->Locked;

        // Profile
        $this->_Profile = new DbField(
            $this, // Table
            'x__Profile', // Variable name
            'Profile', // Name
            '`Profile`', // Expression
            '`Profile`', // Basic search expression
            201, // Type
            65535, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Profile`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->_Profile->InputTextType = "text";
        $this->_Profile->Sortable = false; // Allow sort
        $this->_Profile->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Profile'] = &$this->_Profile;

        // Photo
        $this->Photo = new DbField(
            $this, // Table
            'x_Photo', // Variable name
            'Photo', // Name
            '`Photo`', // Expression
            '`Photo`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            true, // Is upload field
            '`Photo`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'IMAGE', // View Tag
            'FILE' // Edit Tag
        );
        $this->Photo->InputTextType = "text";
        $this->Photo->SearchOperators = ["=", "<>", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY", "IS NULL", "IS NOT NULL"];
        $this->Fields['Photo'] = &$this->Photo;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "users";
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
            if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                $value = Config("CASE_SENSITIVE_PASSWORD") ? EncryptPassword($value) : EncryptPassword(strtolower($value));
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
            if (Config("ENCRYPTED_PASSWORD") && $name == Config("LOGIN_PASSWORD_FIELD_NAME")) {
                if ($value == $this->Fields[$name]->OldValue) { // No need to update hashed password if not changed
                    continue;
                }
                $value = Config("CASE_SENSITIVE_PASSWORD") ? EncryptPassword($value) : EncryptPassword(strtolower($value));
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
            if (array_key_exists('Username', $rs)) {
                AddFilter($where, QuotedName('Username', $this->Dbid) . '=' . QuotedValue($rs['Username'], $this->_Username->DataType, $this->Dbid));
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
        $this->_Username->DbValue = $row['Username'];
        $this->_Password->DbValue = $row['Password'];
        $this->First_Name->DbValue = $row['First_Name'];
        $this->Last_Name->DbValue = $row['Last_Name'];
        $this->_Email->DbValue = $row['Email'];
        $this->User_Level->DbValue = $row['User_Level'];
        $this->Report_To->DbValue = $row['Report_To'];
        $this->Activated->DbValue = $row['Activated'];
        $this->Locked->DbValue = $row['Locked'];
        $this->_Profile->DbValue = $row['Profile'];
        $this->Photo->Upload->DbValue = $row['Photo'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $oldFiles = EmptyValue($row['Photo']) ? [] : [$row['Photo']];
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->Photo->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->Photo->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Username` = '@_Username@'";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->_Username->CurrentValue : $this->_Username->OldValue;
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
                $this->_Username->CurrentValue = $keys[0];
            } else {
                $this->_Username->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Username', $row) ? $row['Username'] : null;
        } else {
            $val = !EmptyValue($this->_Username->OldValue) && !$current ? $this->_Username->OldValue : $this->_Username->CurrentValue;
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@_Username@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("userslist");
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
        if ($pageName == "usersview") {
            return $Language->phrase("View");
        } elseif ($pageName == "usersedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "usersadd") {
            return $Language->phrase("Add");
        }
        return "";
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "UsersView";
            case Config("API_ADD_ACTION"):
                return "UsersAdd";
            case Config("API_EDIT_ACTION"):
                return "UsersEdit";
            case Config("API_DELETE_ACTION"):
                return "UsersDelete";
            case Config("API_LIST_ACTION"):
                return "UsersList";
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
        return "userslist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("usersview", $parm);
        } else {
            $url = $this->keyUrl("usersview", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "usersadd?" . $parm;
        } else {
            $url = "usersadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("usersedit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("userslist", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("usersadd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("userslist", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("usersdelete");
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
        $json .= "\"_Username\":" . JsonEncode($this->_Username->CurrentValue, "string");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->_Username->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->_Username->CurrentValue);
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
            if (($keyValue = Param("_Username") ?? Route("_Username")) !== null) {
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
                $this->_Username->CurrentValue = $key;
            } else {
                $this->_Username->OldValue = $key;
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
        $this->_Username->setDbValue($row['Username']);
        $this->_Password->setDbValue($row['Password']);
        $this->First_Name->setDbValue($row['First_Name']);
        $this->Last_Name->setDbValue($row['Last_Name']);
        $this->_Email->setDbValue($row['Email']);
        $this->User_Level->setDbValue($row['User_Level']);
        $this->Report_To->setDbValue($row['Report_To']);
        $this->Activated->setDbValue($row['Activated']);
        $this->Locked->setDbValue($row['Locked']);
        $this->_Profile->setDbValue($row['Profile']);
        $this->Photo->Upload->DbValue = $row['Photo'];
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "UsersList";
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

        // Username

        // Password
        $this->_Password->CellCssStyle = "white-space: nowrap;";

        // First_Name

        // Last_Name

        // Email

        // User_Level

        // Report_To

        // Activated

        // Locked

        // Profile
        $this->_Profile->CellCssStyle = "white-space: nowrap;";

        // Photo

        // Username
        $this->_Username->ViewValue = $this->_Username->CurrentValue;

        // Password
        $this->_Password->ViewValue = $Language->phrase("PasswordMask");

        // First_Name
        $this->First_Name->ViewValue = $this->First_Name->CurrentValue;

        // Last_Name
        $this->Last_Name->ViewValue = $this->Last_Name->CurrentValue;

        // Email
        $this->_Email->ViewValue = $this->_Email->CurrentValue;

        // User_Level
        if ($Security->canAdmin()) { // System admin
            $curVal = strval($this->User_Level->CurrentValue);
            if ($curVal != "") {
                $this->User_Level->ViewValue = $this->User_Level->lookupCacheOption($curVal);
                if ($this->User_Level->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`User_Level_ID`", "=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->User_Level->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->User_Level->Lookup->renderViewRow($rswrk[0]);
                        $this->User_Level->ViewValue = $this->User_Level->displayValue($arwrk);
                    } else {
                        $this->User_Level->ViewValue = $this->User_Level->CurrentValue;
                    }
                }
            } else {
                $this->User_Level->ViewValue = null;
            }
        } else {
            $this->User_Level->ViewValue = $Language->phrase("PasswordMask");
        }

        // Report_To
        $this->Report_To->ViewValue = $this->Report_To->CurrentValue;

        // Activated
        if (ConvertToBool($this->Activated->CurrentValue)) {
            $this->Activated->ViewValue = $this->Activated->tagCaption(2) != "" ? $this->Activated->tagCaption(2) : "Y";
        } else {
            $this->Activated->ViewValue = $this->Activated->tagCaption(1) != "" ? $this->Activated->tagCaption(1) : "N";
        }

        // Locked
        if (ConvertToBool($this->Locked->CurrentValue)) {
            $this->Locked->ViewValue = $this->Locked->tagCaption(1) != "" ? $this->Locked->tagCaption(1) : "Y";
        } else {
            $this->Locked->ViewValue = $this->Locked->tagCaption(2) != "" ? $this->Locked->tagCaption(2) : "N";
        }

        // Profile
        $this->_Profile->ViewValue = $this->_Profile->CurrentValue;

        // Photo
        if (!EmptyValue($this->Photo->Upload->DbValue)) {
            $this->Photo->ImageAlt = $this->Photo->alt();
            $this->Photo->ImageCssClass = "ew-image";
            $this->Photo->ViewValue = $this->Photo->Upload->DbValue;
        } else {
            $this->Photo->ViewValue = "";
        }

        // Username
        $this->_Username->HrefValue = "";
        $this->_Username->TooltipValue = "";

        // Password
        $this->_Password->HrefValue = "";
        $this->_Password->TooltipValue = "";

        // First_Name
        $this->First_Name->HrefValue = "";
        $this->First_Name->TooltipValue = "";

        // Last_Name
        $this->Last_Name->HrefValue = "";
        $this->Last_Name->TooltipValue = "";

        // Email
        $this->_Email->HrefValue = "";
        $this->_Email->TooltipValue = "";

        // User_Level
        $this->User_Level->HrefValue = "";
        $this->User_Level->TooltipValue = "";

        // Report_To
        $this->Report_To->HrefValue = "";
        $this->Report_To->TooltipValue = "";

        // Activated
        $this->Activated->HrefValue = "";
        $this->Activated->TooltipValue = "";

        // Locked
        $this->Locked->HrefValue = "";
        $this->Locked->TooltipValue = "";

        // Profile
        $this->_Profile->HrefValue = "";
        $this->_Profile->TooltipValue = "";

        // Photo
        if (!EmptyValue($this->Photo->Upload->DbValue)) {
            $this->Photo->HrefValue = GetFileUploadUrl($this->Photo, $this->Photo->htmlDecode($this->Photo->Upload->DbValue)); // Add prefix/suffix
            $this->Photo->LinkAttrs["target"] = ""; // Add target
            if ($this->isExport()) {
                $this->Photo->HrefValue = FullUrl($this->Photo->HrefValue, "href");
            }
        } else {
            $this->Photo->HrefValue = "";
        }
        $this->Photo->ExportHrefValue = $this->Photo->UploadPath . $this->Photo->Upload->DbValue;
        $this->Photo->TooltipValue = "";
        if ($this->Photo->UseColorbox) {
            if (EmptyValue($this->Photo->TooltipValue)) {
                $this->Photo->LinkAttrs["title"] = $Language->phrase("ViewImageGallery");
            }
            $this->Photo->LinkAttrs["data-rel"] = "users_x_Photo";
            $this->Photo->LinkAttrs->appendClass("ew-lightbox");
        }

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

        // Username
        $this->_Username->setupEditAttributes();
        if (!$this->_Username->Raw) {
            $this->_Username->CurrentValue = HtmlDecode($this->_Username->CurrentValue);
        }
        $this->_Username->EditValue = $this->_Username->CurrentValue;
        $this->_Username->PlaceHolder = RemoveHtml($this->_Username->caption());

        // Password
        $this->_Password->setupEditAttributes(["class" => "ew-password-strength"]);
        $this->_Password->EditValue = $Language->phrase("PasswordMask"); // Show as masked password
        $this->_Password->PlaceHolder = RemoveHtml($this->_Password->caption());

        // First_Name
        $this->First_Name->setupEditAttributes();
        if (!$this->First_Name->Raw) {
            $this->First_Name->CurrentValue = HtmlDecode($this->First_Name->CurrentValue);
        }
        $this->First_Name->EditValue = $this->First_Name->CurrentValue;
        $this->First_Name->PlaceHolder = RemoveHtml($this->First_Name->caption());

        // Last_Name
        $this->Last_Name->setupEditAttributes();
        if (!$this->Last_Name->Raw) {
            $this->Last_Name->CurrentValue = HtmlDecode($this->Last_Name->CurrentValue);
        }
        $this->Last_Name->EditValue = $this->Last_Name->CurrentValue;
        $this->Last_Name->PlaceHolder = RemoveHtml($this->Last_Name->caption());

        // Email
        $this->_Email->setupEditAttributes();
        if (!$this->_Email->Raw) {
            $this->_Email->CurrentValue = HtmlDecode($this->_Email->CurrentValue);
        }
        $this->_Email->EditValue = $this->_Email->CurrentValue;
        $this->_Email->PlaceHolder = RemoveHtml($this->_Email->caption());

        // User_Level
        $this->User_Level->setupEditAttributes();
        if (!$Security->canAdmin()) { // System admin
            $this->User_Level->EditValue = $Language->phrase("PasswordMask");
        } else {
            $this->User_Level->PlaceHolder = RemoveHtml($this->User_Level->caption());
        }

        // Report_To
        $this->Report_To->setupEditAttributes();
        if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin
            if (SameString($this->_Username->CurrentValue, CurrentUserID())) {
                $this->Report_To->EditValue = $this->Report_To->CurrentValue;
            } else {
            }
        } else {
            if (!$this->Report_To->Raw) {
                $this->Report_To->CurrentValue = HtmlDecode($this->Report_To->CurrentValue);
            }
            $this->Report_To->EditValue = $this->Report_To->CurrentValue;
            $this->Report_To->PlaceHolder = RemoveHtml($this->Report_To->caption());
        }

        // Activated
        $this->Activated->EditValue = $this->Activated->options(false);
        $this->Activated->PlaceHolder = RemoveHtml($this->Activated->caption());

        // Locked
        $this->Locked->EditValue = $this->Locked->options(false);
        $this->Locked->PlaceHolder = RemoveHtml($this->Locked->caption());

        // Profile
        $this->_Profile->setupEditAttributes();
        $this->_Profile->EditValue = $this->_Profile->CurrentValue;
        $this->_Profile->PlaceHolder = RemoveHtml($this->_Profile->caption());

        // Photo
        $this->Photo->setupEditAttributes();
        if (!EmptyValue($this->Photo->Upload->DbValue)) {
            $this->Photo->ImageAlt = $this->Photo->alt();
            $this->Photo->ImageCssClass = "ew-image";
            $this->Photo->EditValue = $this->Photo->Upload->DbValue;
        } else {
            $this->Photo->EditValue = "";
        }
        if (!EmptyValue($this->Photo->CurrentValue)) {
            $this->Photo->Upload->FileName = $this->Photo->CurrentValue;
        }

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
                    $doc->exportCaption($this->_Username);
                    $doc->exportCaption($this->First_Name);
                    $doc->exportCaption($this->Last_Name);
                    $doc->exportCaption($this->_Email);
                    $doc->exportCaption($this->User_Level);
                    $doc->exportCaption($this->Report_To);
                    $doc->exportCaption($this->Activated);
                    $doc->exportCaption($this->Locked);
                    $doc->exportCaption($this->Photo);
                } else {
                    $doc->exportCaption($this->_Username);
                    $doc->exportCaption($this->First_Name);
                    $doc->exportCaption($this->Last_Name);
                    $doc->exportCaption($this->_Email);
                    $doc->exportCaption($this->User_Level);
                    $doc->exportCaption($this->Report_To);
                    $doc->exportCaption($this->Activated);
                    $doc->exportCaption($this->Locked);
                    $doc->exportCaption($this->Photo);
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
						$doc->exportCaption($this->_Username);
						$doc->exportCaption($this->First_Name);
						$doc->exportCaption($this->Last_Name);
						$doc->exportCaption($this->_Email);
						$doc->exportCaption($this->User_Level);
						$doc->exportCaption($this->Report_To);
						$doc->exportCaption($this->Activated);
						$doc->exportCaption($this->Locked);
						$doc->exportCaption($this->Photo);
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
                        $doc->exportField($this->_Username);
                        $doc->exportField($this->First_Name);
                        $doc->exportField($this->Last_Name);
                        $doc->exportField($this->_Email);
                        $doc->exportField($this->User_Level);
                        $doc->exportField($this->Report_To);
                        $doc->exportField($this->Activated);
                        $doc->exportField($this->Locked);
                        $doc->exportField($this->Photo);
                    } else {
                        $doc->exportField($this->_Username);
                        $doc->exportField($this->First_Name);
                        $doc->exportField($this->Last_Name);
                        $doc->exportField($this->_Email);
                        $doc->exportField($this->User_Level);
                        $doc->exportField($this->Report_To);
                        $doc->exportField($this->Activated);
                        $doc->exportField($this->Locked);
                        $doc->exportField($this->Photo);
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

    // User ID filter
    public function getUserIDFilter($userId)
    {
        global $Security;
        $userIdFilter = '`Username` = ' . QuotedValue($userId, DATATYPE_STRING, Config("USER_TABLE_DBID"));
        $parentUserIdFilter = '`Username` IN (SELECT `Username` FROM ' . "users" . ' WHERE ' . GetMultiValueFilter('`Report_To`', $userId, Config("USER_TABLE_DBID")) . ')';
        $userIdFilter = "(" . $userIdFilter . ") OR (" . $parentUserIdFilter . ")";
        return $userIdFilter;
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
                $filterWrk = '`Username` IN (' . $filterWrk . ')';
            }
        }

        // Call User ID Filtering event
        $this->userIdFiltering($filterWrk);
        AddFilter($filter, $filterWrk);
        return $filter;
    }

    // Add Parent User ID filter
    public function addParentUserIDFilter($userId)
    {
        global $Security;
        if (!$Security->isAdmin()) {
            $result = $Security->parentUserIDList($userId);
            if ($result != "") {
                $result = '`Username` IN (' . $result . ')';
            }
            return $result;
        }
        return "";
    }

    // User ID subquery
    public function getUserIDSubquery(&$fld, &$masterfld)
    {
        global $UserTable;
        $wrk = "";
        $sql = "SELECT " . $masterfld->Expression . " FROM users";
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

    // Send register email
    public function sendRegisterEmail($row)
    {
        // Get user language
        global $UserProfile;
        $userName = GetUserInfo(Config("LOGIN_USERNAME_FIELD_NAME"), $row);
        $langId = $UserProfile->getLanguageId($userName);
        $email = $this->prepareRegisterEmail($row, $langId);
        $args = [];
        $args["rs"] = $row;
        $emailSent = false;
        if ($this->emailSending($email, $args)) { // Use Email_Sending server event of user table
            $emailSent = $email->send();
        }
        return $emailSent;
    }

    // Get activate link
    public function getActivateLink($username, $password, $email)
    {
        return FullUrl("register", "activate") . "?action=confirm&user=" . urlencode($username) . "&activatetoken=" . Encrypt($email) . "," . Encrypt($username) . "," . Encrypt($password);
    }

    // Prepare register email
    public function prepareRegisterEmail($row = null, $langId = "")
    {
        global $CurrentForm;
        $email = new Email();
        $email->load(Config("EMAIL_REGISTER_TEMPLATE"), $langId);
        $email->replaceSender(Config("SENDER_EMAIL")); // Replace Sender
        $emailAddress = $row === null ? $this->_Email->CurrentValue : GetUserInfo(Config("USER_EMAIL_FIELD_NAME"), $row);
        $emailAddress = $emailAddress ?: Config("RECIPIENT_EMAIL"); // Send to recipient directly if no email address
        $email->replaceSubject(Language()->phrase("SubjectRegistrationInformation").' '.Language()->projectPhrase("BodyTitle"));
		$email->replaceRecipient($emailAddress); // Replace Recipient
        if (!SameText($emailAddress, Config("RECIPIENT_EMAIL"))) { // Add Bcc
            $email->addBcc(Config("RECIPIENT_EMAIL"));
        }
        $email->replaceContent('<!--FieldCaption_Username-->', $this->_Username->caption());
        $email->replaceContent('<!--Username-->', $row === null ? strval($this->_Username->FormValue) : GetUserInfo('Username', $row));
        $email->replaceContent('<!--FieldCaption_Password-->', $this->_Password->caption());
        $email->replaceContent('<!--Password-->', $row === null ? strval($this->_Password->FormValue) : GetUserInfo('Password', $row));
        $email->replaceContent('<!--FieldCaption_First_Name-->', $this->First_Name->caption());
        $email->replaceContent('<!--First_Name-->', $row === null ? strval($this->First_Name->FormValue) : GetUserInfo('First_Name', $row));
        $email->replaceContent('<!--FieldCaption_Last_Name-->', $this->Last_Name->caption());
        $email->replaceContent('<!--Last_Name-->', $row === null ? strval($this->Last_Name->FormValue) : GetUserInfo('Last_Name', $row));
        $email->replaceContent('<!--FieldCaption_Email-->', $this->_Email->caption());
        $email->replaceContent('<!--Email-->', $row === null ? strval($this->_Email->FormValue) : GetUserInfo('Email', $row));
        $username = $row === null ? $this->_Username->CurrentValue : GetUserInfo(Config("LOGIN_USERNAME_FIELD_NAME"), $row);
        $password = $row === null ? ($CurrentForm->hasValue("Password") ? $CurrentForm->getValue("Password") : $CurrentForm->getValue("x__Password")) : GetUserInfo(Config("LOGIN_PASSWORD_FIELD_NAME"), $row); // Use raw password post value
        $email->replaceContent("<!--ActivateLink-->", $this->getActivateLink($username, $password, $emailAddress));
        return $email;
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
        if ($fldparm == 'Photo') {
            $fldName = "Photo";
            $fileNameFld = "Photo";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->_Username->CurrentValue = $ar[0];
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
