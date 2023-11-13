<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for help
 */
class Help extends DbTable
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
    public $Help_ID;
    public $_Language;
    public $Topic;
    public $Description;
    public $Category;
    public $Order;
    public $Display_in_Page;
    public $Updated_By;
    public $Last_Updated;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("language");
        $this->TableVar = "help";
        $this->TableName = 'help';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "help";
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

        // Help_ID
        $this->Help_ID = new DbField(
            $this, // Table
            'x_Help_ID', // Variable name
            'Help_ID', // Name
            '`Help_ID`', // Expression
            '`Help_ID`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Help_ID`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Help_ID->InputTextType = "text";
        $this->Help_ID->IsAutoIncrement = true; // Autoincrement field
        $this->Help_ID->IsPrimaryKey = true; // Primary key field
        $this->Help_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Help_ID->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Help_ID'] = &$this->Help_ID;

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

        // Topic
        $this->Topic = new DbField(
            $this, // Table
            'x_Topic', // Variable name
            'Topic', // Name
            '`Topic`', // Expression
            '`Topic`', // Basic search expression
            200, // Type
            255, // Size
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

        // Description
        $this->Description = new DbField(
            $this, // Table
            'x_Description', // Variable name
            'Description', // Name
            '`Description`', // Expression
            '`Description`', // Basic search expression
            201, // Type
            -1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Description`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXTAREA' // Edit Tag
        );
        $this->Description->InputTextType = "text";
        $this->Description->Nullable = false; // NOT NULL field
        $this->Description->Required = true; // Required field
        $this->Description->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['Description'] = &$this->Description;

        // Category
        $this->Category = new DbField(
            $this, // Table
            'x_Category', // Variable name
            'Category', // Name
            '`Category`', // Expression
            '`Category`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Category`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->Category->InputTextType = "text";
        $this->Category->IsForeignKey = true; // Foreign key field
        $this->Category->Nullable = false; // NOT NULL field
        $this->Category->Required = true; // Required field
        $this->Category->setSelectMultiple(false); // Select one
        $this->Category->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->Category->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Category->Lookup = new Lookup('Category', 'help_categories', false, 'Category_ID', ["Category_Description","","",""], '', '', [], [], [], [], [], [], '', '', "`Category_Description`");
                break;
            case "id-ID":
                $this->Category->Lookup = new Lookup('Category', 'help_categories', false, 'Category_ID', ["Category_Description","","",""], '', '', [], [], [], [], [], [], '', '', "`Category_Description`");
                break;
            default:
                $this->Category->Lookup = new Lookup('Category', 'help_categories', false, 'Category_ID', ["Category_Description","","",""], '', '', [], [], [], [], [], [], '', '', "`Category_Description`");
                break;
        }
        $this->Category->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Category->SearchOperators = ["=", "<>", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Category'] = &$this->Category;

        // Order
        $this->Order = new DbField(
            $this, // Table
            'x_Order', // Variable name
            'Order', // Name
            '`Order`', // Expression
            '`Order`', // Basic search expression
            3, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Order`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Order->InputTextType = "text";
        $this->Order->Nullable = false; // NOT NULL field
        $this->Order->Required = true; // Required field
        $this->Order->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Order->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN"];
        $this->Fields['Order'] = &$this->Order;

        // Display_in_Page
        $this->Display_in_Page = new DbField(
            $this, // Table
            'x_Display_in_Page', // Variable name
            'Display_in_Page', // Name
            '`Display_in_Page`', // Expression
            '`Display_in_Page`', // Basic search expression
            200, // Type
            100, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Display_in_Page`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Display_in_Page->InputTextType = "text";
        $this->Display_in_Page->Nullable = false; // NOT NULL field
        $this->Display_in_Page->Required = true; // Required field
        $this->Display_in_Page->SearchOperators = ["=", "<>", "IN", "NOT IN", "STARTS WITH", "NOT STARTS WITH", "LIKE", "NOT LIKE", "ENDS WITH", "NOT ENDS WITH", "IS EMPTY", "IS NOT EMPTY"];
        $this->Fields['Display_in_Page'] = &$this->Display_in_Page;

        // Updated_By
        $this->Updated_By = new DbField(
            $this, // Table
            'x_Updated_By', // Variable name
            'Updated_By', // Name
            '`Updated_By`', // Expression
            '`Updated_By`', // Basic search expression
            200, // Type
            20, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Updated_By`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'SELECT' // Edit Tag
        );
        $this->Updated_By->InputTextType = "text";
        $this->Updated_By->setSelectMultiple(false); // Select one
        $this->Updated_By->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->Updated_By->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Updated_By->Lookup = new Lookup('Updated_By', 'users', false, 'Username', ["First_Name","Last_Name","",""], '', '', [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`First_Name`, ''),'" . ValueSeparator(1, $this->Updated_By) . "',COALESCE(`Last_Name`,''))");
                break;
            case "id-ID":
                $this->Updated_By->Lookup = new Lookup('Updated_By', 'users', false, 'Username', ["First_Name","Last_Name","",""], '', '', [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`First_Name`, ''),'" . ValueSeparator(1, $this->Updated_By) . "',COALESCE(`Last_Name`,''))");
                break;
            default:
                $this->Updated_By->Lookup = new Lookup('Updated_By', 'users', false, 'Username', ["First_Name","Last_Name","",""], '', '', [], [], [], [], [], [], '', '', "CONCAT(COALESCE(`First_Name`, ''),'" . ValueSeparator(1, $this->Updated_By) . "',COALESCE(`Last_Name`,''))");
                break;
        }
        $this->Updated_By->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Updated_By'] = &$this->Updated_By;

        // Last_Updated
        $this->Last_Updated = new DbField(
            $this, // Table
            'x_Last_Updated', // Variable name
            'Last_Updated', // Name
            '`Last_Updated`', // Expression
            CastDateFieldForLike("`Last_Updated`", 1, "DB"), // Basic search expression
            135, // Type
            19, // Size
            1, // Date/Time format
            false, // Is upload field
            '`Last_Updated`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Last_Updated->InputTextType = "text";
        $this->Last_Updated->DefaultErrorMessage = str_replace("%s", DateFormat(1), $Language->phrase("IncorrectDate"));
        $this->Last_Updated->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Last_Updated'] = &$this->Last_Updated;

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

    // Current master table name
    public function getCurrentMasterTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE"));
    }

    public function setCurrentMasterTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_MASTER_TABLE")] = $v;
    }

    // Get master WHERE clause from session values
    public function getMasterFilterFromSession()
    {
        // Master filter
        $masterFilter = "";
        if ($this->getCurrentMasterTable() == "help_categories") {
            $masterTable = Container("help_categories");
            if ($this->Category->getSessionValue() != "") {
                $masterFilter .= "" . GetKeyFilter($masterTable->Category_ID, $this->Category->getSessionValue(), $masterTable->Category_ID->DataType, $masterTable->Dbid);
            } else {
                return "";
            }
        }
        return $masterFilter;
    }

    // Get detail WHERE clause from session values
    public function getDetailFilterFromSession()
    {
        // Detail filter
        $detailFilter = "";
        if ($this->getCurrentMasterTable() == "help_categories") {
            $masterTable = Container("help_categories");
            if ($this->Category->getSessionValue() != "") {
                $detailFilter .= "" . GetKeyFilter($this->Category, $this->Category->getSessionValue(), $masterTable->Category_ID->DataType, $this->Dbid);
            } else {
                return "";
            }
        }
        return $detailFilter;
    }

    /**
     * Get master filter
     *
     * @param object $masterTable Master Table
     * @param array $keys Detail Keys
     * @return mixed NULL is returned if all keys are empty, Empty string is returned if some keys are empty and is required
     */
    public function getMasterFilter($masterTable, $keys)
    {
        $validKeys = true;
        switch ($masterTable->TableVar) {
            case "help_categories":
                $key = $keys["Category"] ?? "";
                if (EmptyValue($key)) {
                    if ($masterTable->Category_ID->Required) { // Required field and empty value
                        return ""; // Return empty filter
                    }
                    $validKeys = false;
                } elseif (!$validKeys) { // Already has empty key
                    return ""; // Return empty filter
                }
                if ($validKeys) {
                    return GetKeyFilter($masterTable->Category_ID, $keys["Category"], $this->Category->DataType, $this->Dbid);
                }
                break;
        }
        return null; // All null values and no required fields
    }

    // Get detail filter
    public function getDetailFilter($masterTable)
    {
        switch ($masterTable->TableVar) {
            case "help_categories":
                return GetKeyFilter($this->Category, $masterTable->Category_ID->DbValue, $masterTable->Category_ID->DataType, $masterTable->Dbid);
        }
        return "";
    }

    // Render X Axis for chart
    public function renderChartXAxis($chartVar, $chartRow)
    {
        return $chartRow;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "help";
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
            $this->Help_ID->setDbValue($conn->lastInsertId());
            $rs['Help_ID'] = $this->Help_ID->DbValue;
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
            if (!isset($rs['Help_ID']) && !EmptyValue($this->Help_ID->CurrentValue)) {
                $rs['Help_ID'] = $this->Help_ID->CurrentValue;
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
            if (array_key_exists('Help_ID', $rs)) {
                AddFilter($where, QuotedName('Help_ID', $this->Dbid) . '=' . QuotedValue($rs['Help_ID'], $this->Help_ID->DataType, $this->Dbid));
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
        $this->Help_ID->DbValue = $row['Help_ID'];
        $this->_Language->DbValue = $row['Language'];
        $this->Topic->DbValue = $row['Topic'];
        $this->Description->DbValue = $row['Description'];
        $this->Category->DbValue = $row['Category'];
        $this->Order->DbValue = $row['Order'];
        $this->Display_in_Page->DbValue = $row['Display_in_Page'];
        $this->Updated_By->DbValue = $row['Updated_By'];
        $this->Last_Updated->DbValue = $row['Last_Updated'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Help_ID` = @Help_ID@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->Help_ID->CurrentValue : $this->Help_ID->OldValue;
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
                $this->Help_ID->CurrentValue = $keys[0];
            } else {
                $this->Help_ID->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Help_ID', $row) ? $row['Help_ID'] : null;
        } else {
            $val = !EmptyValue($this->Help_ID->OldValue) && !$current ? $this->Help_ID->OldValue : $this->Help_ID->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Help_ID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("helplist");
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
        if ($pageName == "helpview") {
            return $Language->phrase("View");
        } elseif ($pageName == "helpedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "helpadd") {
            return $Language->phrase("Add");
        }
        return "";
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "HelpView";
            case Config("API_ADD_ACTION"):
                return "HelpAdd";
            case Config("API_EDIT_ACTION"):
                return "HelpEdit";
            case Config("API_DELETE_ACTION"):
                return "HelpDelete";
            case Config("API_LIST_ACTION"):
                return "HelpList";
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
        return "helplist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("helpview", $parm);
        } else {
            $url = $this->keyUrl("helpview", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "helpadd?" . $parm;
        } else {
            $url = "helpadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("helpedit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("helplist", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("helpadd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("helplist", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("helpdelete");
        }
    }

    // Add master url
    public function addMasterUrl($url)
    {
        if ($this->getCurrentMasterTable() == "help_categories" && !ContainsString($url, Config("TABLE_SHOW_MASTER") . "=")) {
            $url .= (ContainsString($url, "?") ? "&" : "?") . Config("TABLE_SHOW_MASTER") . "=" . $this->getCurrentMasterTable();
            $url .= "&" . GetForeignKeyUrl("fk_Category_ID", $this->Category->getSessionValue()); // Use Session Value
        }
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"Help_ID\":" . JsonEncode($this->Help_ID->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Help_ID->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Help_ID->CurrentValue);
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
            if (($keyValue = Param("Help_ID") ?? Route("Help_ID")) !== null) {
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
                $this->Help_ID->CurrentValue = $key;
            } else {
                $this->Help_ID->OldValue = $key;
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
        $this->Help_ID->setDbValue($row['Help_ID']);
        $this->_Language->setDbValue($row['Language']);
        $this->Topic->setDbValue($row['Topic']);
        $this->Description->setDbValue($row['Description']);
        $this->Category->setDbValue($row['Category']);
        $this->Order->setDbValue($row['Order']);
        $this->Display_in_Page->setDbValue($row['Display_in_Page']);
        $this->Updated_By->setDbValue($row['Updated_By']);
        $this->Last_Updated->setDbValue($row['Last_Updated']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "HelpList";
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

        // Help_ID

        // Language

        // Topic

        // Description

        // Category

        // Order

        // Display_in_Page

        // Updated_By

        // Last_Updated

        // Help_ID
        $this->Help_ID->ViewValue = $this->Help_ID->CurrentValue;

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

        // Topic
        $this->Topic->ViewValue = $this->Topic->CurrentValue;

        // Description
        $this->Description->ViewValue = $this->Description->CurrentValue;

        // Category
        $curVal = strval($this->Category->CurrentValue);
        if ($curVal != "") {
            $this->Category->ViewValue = $this->Category->lookupCacheOption($curVal);
            if ($this->Category->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter("`Category_ID`", "=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->Category->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->Category->Lookup->renderViewRow($rswrk[0]);
                    $this->Category->ViewValue = $this->Category->displayValue($arwrk);
                } else {
                    $this->Category->ViewValue = FormatNumber($this->Category->CurrentValue, $this->Category->formatPattern());
                }
            }
        } else {
            $this->Category->ViewValue = null;
        }

        // Order
        $this->Order->ViewValue = $this->Order->CurrentValue;
        $this->Order->ViewValue = FormatNumber($this->Order->ViewValue, $this->Order->formatPattern());

        // Display_in_Page
        $this->Display_in_Page->ViewValue = $this->Display_in_Page->CurrentValue;

        // Updated_By
        $curVal = strval($this->Updated_By->CurrentValue);
        if ($curVal != "") {
            $this->Updated_By->ViewValue = $this->Updated_By->lookupCacheOption($curVal);
            if ($this->Updated_By->ViewValue === null) { // Lookup from database
                $filterWrk = SearchFilter("`Username`", "=", $curVal, DATATYPE_STRING, "");
                $sqlWrk = $this->Updated_By->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $conn = Conn();
                $config = $conn->getConfiguration();
                $config->setResultCacheImpl($this->Cache);
                $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->Updated_By->Lookup->renderViewRow($rswrk[0]);
                    $this->Updated_By->ViewValue = $this->Updated_By->displayValue($arwrk);
                } else {
                    $this->Updated_By->ViewValue = $this->Updated_By->CurrentValue;
                }
            }
        } else {
            $this->Updated_By->ViewValue = null;
        }

        // Last_Updated
        $this->Last_Updated->ViewValue = $this->Last_Updated->CurrentValue;
        $this->Last_Updated->ViewValue = FormatDateTime($this->Last_Updated->ViewValue, $this->Last_Updated->formatPattern());

        // Help_ID
        $this->Help_ID->HrefValue = "";
        $this->Help_ID->TooltipValue = "";

        // Language
        $this->_Language->HrefValue = "";
        $this->_Language->TooltipValue = "";

        // Topic
        $this->Topic->HrefValue = "";
        $this->Topic->TooltipValue = "";

        // Description
        $this->Description->HrefValue = "";
        $this->Description->TooltipValue = "";

        // Category
        $this->Category->HrefValue = "";
        $this->Category->TooltipValue = "";

        // Order
        $this->Order->HrefValue = "";
        $this->Order->TooltipValue = "";

        // Display_in_Page
        $this->Display_in_Page->HrefValue = "";
        $this->Display_in_Page->TooltipValue = "";

        // Updated_By
        $this->Updated_By->HrefValue = "";
        $this->Updated_By->TooltipValue = "";

        // Last_Updated
        $this->Last_Updated->HrefValue = "";
        $this->Last_Updated->TooltipValue = "";

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

        // Help_ID
        $this->Help_ID->setupEditAttributes();
        $this->Help_ID->EditValue = $this->Help_ID->CurrentValue;

        // Language
        $this->_Language->setupEditAttributes();
        $this->_Language->PlaceHolder = RemoveHtml($this->_Language->caption());

        // Topic
        $this->Topic->setupEditAttributes();
        if (!$this->Topic->Raw) {
            $this->Topic->CurrentValue = HtmlDecode($this->Topic->CurrentValue);
        }
        $this->Topic->EditValue = $this->Topic->CurrentValue;
        $this->Topic->PlaceHolder = RemoveHtml($this->Topic->caption());

        // Description
        $this->Description->setupEditAttributes();
        $this->Description->EditValue = $this->Description->CurrentValue;
        $this->Description->PlaceHolder = RemoveHtml($this->Description->caption());

        // Category
        $this->Category->setupEditAttributes();
        if ($this->Category->getSessionValue() != "") {
            $this->Category->CurrentValue = GetForeignKeyValue($this->Category->getSessionValue());
            $curVal = strval($this->Category->CurrentValue);
            if ($curVal != "") {
                $this->Category->ViewValue = $this->Category->lookupCacheOption($curVal);
                if ($this->Category->ViewValue === null) { // Lookup from database
                    $filterWrk = SearchFilter("`Category_ID`", "=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->Category->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $conn = Conn();
                    $config = $conn->getConfiguration();
                    $config->setResultCacheImpl($this->Cache);
                    $rswrk = $conn->executeCacheQuery($sqlWrk, [], [], $this->CacheProfile)->fetchAll();
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->Category->Lookup->renderViewRow($rswrk[0]);
                        $this->Category->ViewValue = $this->Category->displayValue($arwrk);
                    } else {
                        $this->Category->ViewValue = FormatNumber($this->Category->CurrentValue, $this->Category->formatPattern());
                    }
                }
            } else {
                $this->Category->ViewValue = null;
            }
        } else {
            $this->Category->PlaceHolder = RemoveHtml($this->Category->caption());
        }

        // Order
        $this->Order->setupEditAttributes();
        $this->Order->EditValue = $this->Order->CurrentValue;
        $this->Order->PlaceHolder = RemoveHtml($this->Order->caption());
        if (strval($this->Order->EditValue) != "" && is_numeric($this->Order->EditValue)) {
            $this->Order->EditValue = FormatNumber($this->Order->EditValue, null);
        }

        // Display_in_Page
        $this->Display_in_Page->setupEditAttributes();
        if (!$this->Display_in_Page->Raw) {
            $this->Display_in_Page->CurrentValue = HtmlDecode($this->Display_in_Page->CurrentValue);
        }
        $this->Display_in_Page->EditValue = $this->Display_in_Page->CurrentValue;
        $this->Display_in_Page->PlaceHolder = RemoveHtml($this->Display_in_Page->caption());

        // Updated_By
        $this->Updated_By->setupEditAttributes();
        $this->Updated_By->PlaceHolder = RemoveHtml($this->Updated_By->caption());

        // Last_Updated
        $this->Last_Updated->setupEditAttributes();
        $this->Last_Updated->EditValue = FormatDateTime($this->Last_Updated->CurrentValue, $this->Last_Updated->formatPattern());
        $this->Last_Updated->PlaceHolder = RemoveHtml($this->Last_Updated->caption());

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
                    $doc->exportCaption($this->Help_ID);
                    $doc->exportCaption($this->_Language);
                    $doc->exportCaption($this->Topic);
                    $doc->exportCaption($this->Description);
                    $doc->exportCaption($this->Category);
                    $doc->exportCaption($this->Order);
                    $doc->exportCaption($this->Display_in_Page);
                    $doc->exportCaption($this->Updated_By);
                    $doc->exportCaption($this->Last_Updated);
                } else {
                    $doc->exportCaption($this->Help_ID);
                    $doc->exportCaption($this->_Language);
                    $doc->exportCaption($this->Topic);
                    $doc->exportCaption($this->Category);
                    $doc->exportCaption($this->Order);
                    $doc->exportCaption($this->Display_in_Page);
                    $doc->exportCaption($this->Updated_By);
                    $doc->exportCaption($this->Last_Updated);
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
						$doc->exportCaption($this->Help_ID);
						$doc->exportCaption($this->_Language);
						$doc->exportCaption($this->Topic);
						$doc->exportCaption($this->Category);
						$doc->exportCaption($this->Order);
						$doc->exportCaption($this->Display_in_Page);
						$doc->exportCaption($this->Updated_By);
						$doc->exportCaption($this->Last_Updated);
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
                        $doc->exportField($this->Help_ID);
                        $doc->exportField($this->_Language);
                        $doc->exportField($this->Topic);
                        $doc->exportField($this->Description);
                        $doc->exportField($this->Category);
                        $doc->exportField($this->Order);
                        $doc->exportField($this->Display_in_Page);
                        $doc->exportField($this->Updated_By);
                        $doc->exportField($this->Last_Updated);
                    } else {
                        $doc->exportField($this->Help_ID);
                        $doc->exportField($this->_Language);
                        $doc->exportField($this->Topic);
                        $doc->exportField($this->Category);
                        $doc->exportField($this->Order);
                        $doc->exportField($this->Display_in_Page);
                        $doc->exportField($this->Updated_By);
                        $doc->exportField($this->Last_Updated);
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
