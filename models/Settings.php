<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for settings
 */
class Settings extends DbTable
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
    public $Option_ID;
    public $Option_Default;
    public $Show_Announcement;
    public $Use_Announcement_Table;
    public $Maintenance_Mode;
    public $Maintenance_Finish_DateTime;
    public $Auto_Normal_After_Maintenance;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $CurrentLanguage, $CurrentLocale;

        // Language object
        $Language = Container("language");
        $this->TableVar = "settings";
        $this->TableName = 'settings';
        $this->TableType = "TABLE";
        $this->ImportUseTransaction = $this->supportsTransaction() && Config("IMPORT_USE_TRANSACTION");
        $this->UseTransaction = $this->supportsTransaction() && Config("USE_TRANSACTION");

        // Update Table
        $this->UpdateTable = "settings";
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

        // Option_ID
        $this->Option_ID = new DbField(
            $this, // Table
            'x_Option_ID', // Variable name
            'Option_ID', // Name
            '`Option_ID`', // Expression
            '`Option_ID`', // Basic search expression
            19, // Type
            11, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Option_ID`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'NO' // Edit Tag
        );
        $this->Option_ID->InputTextType = "text";
        $this->Option_ID->IsAutoIncrement = true; // Autoincrement field
        $this->Option_ID->IsPrimaryKey = true; // Primary key field
        $this->Option_ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Option_ID->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Option_ID'] = &$this->Option_ID;

        // Option_Default
        $this->Option_Default = new DbField(
            $this, // Table
            'x_Option_Default', // Variable name
            'Option_Default', // Name
            '`Option_Default`', // Expression
            '`Option_Default`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Option_Default`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->Option_Default->addMethod("getDefault", fn() => "N");
        $this->Option_Default->InputTextType = "text";
        $this->Option_Default->DataType = DATATYPE_BOOLEAN;
        $this->Option_Default->TrueValue = "Y";
        $this->Option_Default->FalseValue = "N";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Option_Default->Lookup = new Lookup('Option_Default', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            case "id-ID":
                $this->Option_Default->Lookup = new Lookup('Option_Default', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->Option_Default->Lookup = new Lookup('Option_Default', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->Option_Default->OptionCount = 2;
        $this->Option_Default->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Option_Default'] = &$this->Option_Default;

        // Show_Announcement
        $this->Show_Announcement = new DbField(
            $this, // Table
            'x_Show_Announcement', // Variable name
            'Show_Announcement', // Name
            '`Show_Announcement`', // Expression
            '`Show_Announcement`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Show_Announcement`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->Show_Announcement->addMethod("getDefault", fn() => "N");
        $this->Show_Announcement->InputTextType = "text";
        $this->Show_Announcement->DataType = DATATYPE_BOOLEAN;
        $this->Show_Announcement->TrueValue = "Y";
        $this->Show_Announcement->FalseValue = "N";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Show_Announcement->Lookup = new Lookup('Show_Announcement', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            case "id-ID":
                $this->Show_Announcement->Lookup = new Lookup('Show_Announcement', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->Show_Announcement->Lookup = new Lookup('Show_Announcement', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->Show_Announcement->OptionCount = 2;
        $this->Show_Announcement->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Show_Announcement'] = &$this->Show_Announcement;

        // Use_Announcement_Table
        $this->Use_Announcement_Table = new DbField(
            $this, // Table
            'x_Use_Announcement_Table', // Variable name
            'Use_Announcement_Table', // Name
            '`Use_Announcement_Table`', // Expression
            '`Use_Announcement_Table`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Use_Announcement_Table`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->Use_Announcement_Table->addMethod("getDefault", fn() => "N");
        $this->Use_Announcement_Table->InputTextType = "text";
        $this->Use_Announcement_Table->DataType = DATATYPE_BOOLEAN;
        $this->Use_Announcement_Table->TrueValue = "Y";
        $this->Use_Announcement_Table->FalseValue = "N";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Use_Announcement_Table->Lookup = new Lookup('Use_Announcement_Table', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            case "id-ID":
                $this->Use_Announcement_Table->Lookup = new Lookup('Use_Announcement_Table', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->Use_Announcement_Table->Lookup = new Lookup('Use_Announcement_Table', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->Use_Announcement_Table->OptionCount = 2;
        $this->Use_Announcement_Table->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Use_Announcement_Table'] = &$this->Use_Announcement_Table;

        // Maintenance_Mode
        $this->Maintenance_Mode = new DbField(
            $this, // Table
            'x_Maintenance_Mode', // Variable name
            'Maintenance_Mode', // Name
            '`Maintenance_Mode`', // Expression
            '`Maintenance_Mode`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Maintenance_Mode`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->Maintenance_Mode->addMethod("getDefault", fn() => "N");
        $this->Maintenance_Mode->InputTextType = "text";
        $this->Maintenance_Mode->DataType = DATATYPE_BOOLEAN;
        $this->Maintenance_Mode->TrueValue = "Y";
        $this->Maintenance_Mode->FalseValue = "N";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Maintenance_Mode->Lookup = new Lookup('Maintenance_Mode', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            case "id-ID":
                $this->Maintenance_Mode->Lookup = new Lookup('Maintenance_Mode', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->Maintenance_Mode->Lookup = new Lookup('Maintenance_Mode', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->Maintenance_Mode->OptionCount = 2;
        $this->Maintenance_Mode->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Maintenance_Mode'] = &$this->Maintenance_Mode;

        // Maintenance_Finish_DateTime
        $this->Maintenance_Finish_DateTime = new DbField(
            $this, // Table
            'x_Maintenance_Finish_DateTime', // Variable name
            'Maintenance_Finish_DateTime', // Name
            '`Maintenance_Finish_DateTime`', // Expression
            CastDateFieldForLike("`Maintenance_Finish_DateTime`", 1, "DB"), // Basic search expression
            135, // Type
            19, // Size
            1, // Date/Time format
            false, // Is upload field
            '`Maintenance_Finish_DateTime`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'TEXT' // Edit Tag
        );
        $this->Maintenance_Finish_DateTime->InputTextType = "text";
        $this->Maintenance_Finish_DateTime->DefaultErrorMessage = str_replace("%s", DateFormat(1), $Language->phrase("IncorrectDate"));
        $this->Maintenance_Finish_DateTime->SearchOperators = ["=", "<>", "IN", "NOT IN", "<", "<=", ">", ">=", "BETWEEN", "NOT BETWEEN", "IS NULL", "IS NOT NULL"];
        $this->Fields['Maintenance_Finish_DateTime'] = &$this->Maintenance_Finish_DateTime;

        // Auto_Normal_After_Maintenance
        $this->Auto_Normal_After_Maintenance = new DbField(
            $this, // Table
            'x_Auto_Normal_After_Maintenance', // Variable name
            'Auto_Normal_After_Maintenance', // Name
            '`Auto_Normal_After_Maintenance`', // Expression
            '`Auto_Normal_After_Maintenance`', // Basic search expression
            129, // Type
            1, // Size
            -1, // Date/Time format
            false, // Is upload field
            '`Auto_Normal_After_Maintenance`', // Virtual expression
            false, // Is virtual
            false, // Force selection
            false, // Is Virtual search
            'FORMATTED TEXT', // View Tag
            'CHECKBOX' // Edit Tag
        );
        $this->Auto_Normal_After_Maintenance->addMethod("getDefault", fn() => "Y");
        $this->Auto_Normal_After_Maintenance->InputTextType = "text";
        $this->Auto_Normal_After_Maintenance->DataType = DATATYPE_BOOLEAN;
        $this->Auto_Normal_After_Maintenance->TrueValue = "Y";
        $this->Auto_Normal_After_Maintenance->FalseValue = "N";
        switch ($CurrentLanguage) {
            case "en-US":
                $this->Auto_Normal_After_Maintenance->Lookup = new Lookup('Auto_Normal_After_Maintenance', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            case "id-ID":
                $this->Auto_Normal_After_Maintenance->Lookup = new Lookup('Auto_Normal_After_Maintenance', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
            default:
                $this->Auto_Normal_After_Maintenance->Lookup = new Lookup('Auto_Normal_After_Maintenance', 'settings', false, '', ["","","",""], '', '', [], [], [], [], [], [], '', '', "");
                break;
        }
        $this->Auto_Normal_After_Maintenance->OptionCount = 2;
        $this->Auto_Normal_After_Maintenance->SearchOperators = ["=", "<>", "IS NULL", "IS NOT NULL"];
        $this->Fields['Auto_Normal_After_Maintenance'] = &$this->Auto_Normal_After_Maintenance;

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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "settings";
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
            $this->Option_ID->setDbValue($conn->lastInsertId());
            $rs['Option_ID'] = $this->Option_ID->DbValue;
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
            if (!isset($rs['Option_ID']) && !EmptyValue($this->Option_ID->CurrentValue)) {
                $rs['Option_ID'] = $this->Option_ID->CurrentValue;
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
            if (array_key_exists('Option_ID', $rs)) {
                AddFilter($where, QuotedName('Option_ID', $this->Dbid) . '=' . QuotedValue($rs['Option_ID'], $this->Option_ID->DataType, $this->Dbid));
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
        $this->Option_ID->DbValue = $row['Option_ID'];
        $this->Option_Default->DbValue = $row['Option_Default'];
        $this->Show_Announcement->DbValue = $row['Show_Announcement'];
        $this->Use_Announcement_Table->DbValue = $row['Use_Announcement_Table'];
        $this->Maintenance_Mode->DbValue = $row['Maintenance_Mode'];
        $this->Maintenance_Finish_DateTime->DbValue = $row['Maintenance_Finish_DateTime'];
        $this->Auto_Normal_After_Maintenance->DbValue = $row['Auto_Normal_After_Maintenance'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`Option_ID` = @Option_ID@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->Option_ID->CurrentValue : $this->Option_ID->OldValue;
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
                $this->Option_ID->CurrentValue = $keys[0];
            } else {
                $this->Option_ID->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null, $current = false)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('Option_ID', $row) ? $row['Option_ID'] : null;
        } else {
            $val = !EmptyValue($this->Option_ID->OldValue) && !$current ? $this->Option_ID->OldValue : $this->Option_ID->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@Option_ID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("settingslist");
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
        if ($pageName == "settingsview") {
            return $Language->phrase("View");
        } elseif ($pageName == "settingsedit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "settingsadd") {
            return $Language->phrase("Add");
        }
        return "";
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "SettingsView";
            case Config("API_ADD_ACTION"):
                return "SettingsAdd";
            case Config("API_EDIT_ACTION"):
                return "SettingsEdit";
            case Config("API_DELETE_ACTION"):
                return "SettingsDelete";
            case Config("API_LIST_ACTION"):
                return "SettingsList";
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
        return "settingslist";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("settingsview", $parm);
        } else {
            $url = $this->keyUrl("settingsview", Config("TABLE_SHOW_DETAIL") . "=");
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "settingsadd?" . $parm;
        } else {
            $url = "settingsadd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("settingsedit", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl("settingslist", "action=edit");
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("settingsadd", $parm);
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl("settingslist", "action=copy");
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        if ($this->UseAjaxActions && ConvertToBool(Param("infinitescroll")) && CurrentPageID() == "list") {
            return $this->keyUrl(GetApiUrl(Config("API_DELETE_ACTION") . "/" . $this->TableVar));
        } else {
            return $this->keyUrl("settingsdelete");
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
        $json .= "\"Option_ID\":" . JsonEncode($this->Option_ID->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->Option_ID->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->Option_ID->CurrentValue);
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
            if (($keyValue = Param("Option_ID") ?? Route("Option_ID")) !== null) {
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
                $this->Option_ID->CurrentValue = $key;
            } else {
                $this->Option_ID->OldValue = $key;
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
        $this->Option_ID->setDbValue($row['Option_ID']);
        $this->Option_Default->setDbValue($row['Option_Default']);
        $this->Show_Announcement->setDbValue($row['Show_Announcement']);
        $this->Use_Announcement_Table->setDbValue($row['Use_Announcement_Table']);
        $this->Maintenance_Mode->setDbValue($row['Maintenance_Mode']);
        $this->Maintenance_Finish_DateTime->setDbValue($row['Maintenance_Finish_DateTime']);
        $this->Auto_Normal_After_Maintenance->setDbValue($row['Auto_Normal_After_Maintenance']);
    }

    // Render list content
    public function renderListContent($filter)
    {
        global $Response;
        $listPage = "SettingsList";
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

        // Option_ID

        // Option_Default

        // Show_Announcement

        // Use_Announcement_Table

        // Maintenance_Mode

        // Maintenance_Finish_DateTime

        // Auto_Normal_After_Maintenance

        // Option_ID
        $this->Option_ID->ViewValue = $this->Option_ID->CurrentValue;

        // Option_Default
        if (ConvertToBool($this->Option_Default->CurrentValue)) {
            $this->Option_Default->ViewValue = $this->Option_Default->tagCaption(1) != "" ? $this->Option_Default->tagCaption(1) : "Y";
        } else {
            $this->Option_Default->ViewValue = $this->Option_Default->tagCaption(2) != "" ? $this->Option_Default->tagCaption(2) : "N";
        }

        // Show_Announcement
        if (ConvertToBool($this->Show_Announcement->CurrentValue)) {
            $this->Show_Announcement->ViewValue = $this->Show_Announcement->tagCaption(1) != "" ? $this->Show_Announcement->tagCaption(1) : "Y";
        } else {
            $this->Show_Announcement->ViewValue = $this->Show_Announcement->tagCaption(2) != "" ? $this->Show_Announcement->tagCaption(2) : "N";
        }

        // Use_Announcement_Table
        if (ConvertToBool($this->Use_Announcement_Table->CurrentValue)) {
            $this->Use_Announcement_Table->ViewValue = $this->Use_Announcement_Table->tagCaption(2) != "" ? $this->Use_Announcement_Table->tagCaption(2) : "Y";
        } else {
            $this->Use_Announcement_Table->ViewValue = $this->Use_Announcement_Table->tagCaption(1) != "" ? $this->Use_Announcement_Table->tagCaption(1) : "N";
        }

        // Maintenance_Mode
        if (ConvertToBool($this->Maintenance_Mode->CurrentValue)) {
            $this->Maintenance_Mode->ViewValue = $this->Maintenance_Mode->tagCaption(2) != "" ? $this->Maintenance_Mode->tagCaption(2) : "Y";
        } else {
            $this->Maintenance_Mode->ViewValue = $this->Maintenance_Mode->tagCaption(1) != "" ? $this->Maintenance_Mode->tagCaption(1) : "N";
        }

        // Maintenance_Finish_DateTime
        $this->Maintenance_Finish_DateTime->ViewValue = $this->Maintenance_Finish_DateTime->CurrentValue;
        $this->Maintenance_Finish_DateTime->ViewValue = FormatDateTime($this->Maintenance_Finish_DateTime->ViewValue, $this->Maintenance_Finish_DateTime->formatPattern());

        // Auto_Normal_After_Maintenance
        if (ConvertToBool($this->Auto_Normal_After_Maintenance->CurrentValue)) {
            $this->Auto_Normal_After_Maintenance->ViewValue = $this->Auto_Normal_After_Maintenance->tagCaption(1) != "" ? $this->Auto_Normal_After_Maintenance->tagCaption(1) : "Y";
        } else {
            $this->Auto_Normal_After_Maintenance->ViewValue = $this->Auto_Normal_After_Maintenance->tagCaption(2) != "" ? $this->Auto_Normal_After_Maintenance->tagCaption(2) : "N";
        }

        // Option_ID
        $this->Option_ID->HrefValue = "";
        $this->Option_ID->TooltipValue = "";

        // Option_Default
        $this->Option_Default->HrefValue = "";
        $this->Option_Default->TooltipValue = "";

        // Show_Announcement
        $this->Show_Announcement->HrefValue = "";
        $this->Show_Announcement->TooltipValue = "";

        // Use_Announcement_Table
        $this->Use_Announcement_Table->HrefValue = "";
        $this->Use_Announcement_Table->TooltipValue = "";

        // Maintenance_Mode
        $this->Maintenance_Mode->HrefValue = "";
        $this->Maintenance_Mode->TooltipValue = "";

        // Maintenance_Finish_DateTime
        $this->Maintenance_Finish_DateTime->HrefValue = "";
        $this->Maintenance_Finish_DateTime->TooltipValue = "";

        // Auto_Normal_After_Maintenance
        $this->Auto_Normal_After_Maintenance->HrefValue = "";
        $this->Auto_Normal_After_Maintenance->TooltipValue = "";

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

        // Option_ID
        $this->Option_ID->setupEditAttributes();
        $this->Option_ID->EditValue = $this->Option_ID->CurrentValue;

        // Option_Default
        $this->Option_Default->EditValue = $this->Option_Default->options(false);
        $this->Option_Default->PlaceHolder = RemoveHtml($this->Option_Default->caption());

        // Show_Announcement
        $this->Show_Announcement->EditValue = $this->Show_Announcement->options(false);
        $this->Show_Announcement->PlaceHolder = RemoveHtml($this->Show_Announcement->caption());

        // Use_Announcement_Table
        $this->Use_Announcement_Table->EditValue = $this->Use_Announcement_Table->options(false);
        $this->Use_Announcement_Table->PlaceHolder = RemoveHtml($this->Use_Announcement_Table->caption());

        // Maintenance_Mode
        $this->Maintenance_Mode->EditValue = $this->Maintenance_Mode->options(false);
        $this->Maintenance_Mode->PlaceHolder = RemoveHtml($this->Maintenance_Mode->caption());

        // Maintenance_Finish_DateTime
        $this->Maintenance_Finish_DateTime->setupEditAttributes();
        $this->Maintenance_Finish_DateTime->EditValue = FormatDateTime($this->Maintenance_Finish_DateTime->CurrentValue, $this->Maintenance_Finish_DateTime->formatPattern());
        $this->Maintenance_Finish_DateTime->PlaceHolder = RemoveHtml($this->Maintenance_Finish_DateTime->caption());

        // Auto_Normal_After_Maintenance
        $this->Auto_Normal_After_Maintenance->EditValue = $this->Auto_Normal_After_Maintenance->options(false);
        $this->Auto_Normal_After_Maintenance->PlaceHolder = RemoveHtml($this->Auto_Normal_After_Maintenance->caption());

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
                    $doc->exportCaption($this->Option_ID);
                    $doc->exportCaption($this->Option_Default);
                    $doc->exportCaption($this->Show_Announcement);
                    $doc->exportCaption($this->Use_Announcement_Table);
                    $doc->exportCaption($this->Maintenance_Mode);
                    $doc->exportCaption($this->Maintenance_Finish_DateTime);
                    $doc->exportCaption($this->Auto_Normal_After_Maintenance);
                } else {
                    $doc->exportCaption($this->Option_ID);
                    $doc->exportCaption($this->Option_Default);
                    $doc->exportCaption($this->Show_Announcement);
                    $doc->exportCaption($this->Use_Announcement_Table);
                    $doc->exportCaption($this->Maintenance_Mode);
                    $doc->exportCaption($this->Maintenance_Finish_DateTime);
                    $doc->exportCaption($this->Auto_Normal_After_Maintenance);
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
						$doc->exportCaption($this->Option_ID);
						$doc->exportCaption($this->Option_Default);
						$doc->exportCaption($this->Show_Announcement);
						$doc->exportCaption($this->Use_Announcement_Table);
						$doc->exportCaption($this->Maintenance_Mode);
						$doc->exportCaption($this->Maintenance_Finish_DateTime);
						$doc->exportCaption($this->Auto_Normal_After_Maintenance);
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
                        $doc->exportField($this->Option_ID);
                        $doc->exportField($this->Option_Default);
                        $doc->exportField($this->Show_Announcement);
                        $doc->exportField($this->Use_Announcement_Table);
                        $doc->exportField($this->Maintenance_Mode);
                        $doc->exportField($this->Maintenance_Finish_DateTime);
                        $doc->exportField($this->Auto_Normal_After_Maintenance);
                    } else {
                        $doc->exportField($this->Option_ID);
                        $doc->exportField($this->Option_Default);
                        $doc->exportField($this->Show_Announcement);
                        $doc->exportField($this->Use_Announcement_Table);
                        $doc->exportField($this->Maintenance_Mode);
                        $doc->exportField($this->Maintenance_Finish_DateTime);
                        $doc->exportField($this->Auto_Normal_After_Maintenance);
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
        $record_count = ExecuteScalar("SELECT COUNT(*) FROM " . Config("MS_SETTINGS_TABLE"));
    	if ($record_count > 1) {
    		if ($rsnew["Option_Default"] == "Y") {
    			ExecuteStatement("UPDATE " . Config("MS_SETTINGS_TABLE") . " SET Option_Default = 'N' WHERE Option_ID <> " . $rsnew["Option_ID"]);
    		}
    	}
    }
    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        $record_count = ExecuteScalar("SELECT COUNT(*) FROM " . Config("MS_SETTINGS_TABLE"));
    	if ($record_count == 1 && $rsnew["Option_Default"] == "N") {
    		$this->setFailureMessage("You cannot disable Option Default for this current record, since only one record exists in configuration table.");
    		return FALSE;
    	}
        return true;
    }
    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        $record_count = ExecuteScalar("SELECT COUNT(*) FROM " . Config("MS_SETTINGS_TABLE"));
    	if ($record_count > 1) {
    		if ($rsnew["Option_Default"] == "Y") {
    			ExecuteStatement("UPDATE " . Config("MS_SETTINGS_TABLE") . " SET Option_Default = 'N' WHERE Option_ID <> " . $rsold["Option_ID"]);
    		}
    	}
    	$this->setSuccessMessage("You must logout to take the new settings.");
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
        $record_count = ExecuteScalar("SELECT COUNT(*) FROM " . Config("MS_SETTINGS_TABLE"));
    	if ($record_count == 1) {
    		$this->setFailureMessage("You cannot delete this current record, since only one record exists in configuration table.");
    		return FALSE;
    	}
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
