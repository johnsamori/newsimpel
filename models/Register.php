<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class Register extends Users
{
    use MessagesTrait;

    // Page ID
    public $PageID = "register";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "Register";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "register";

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

    // Constructor
    public function __construct()
    {
        parent::__construct();
        global $Language, $DashboardReport, $DebugTimer, $UserTable;
        $this->TableVar = 'users';
        $this->TableName = 'users';

        // Table CSS class
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-desktop-table ew-register-table";

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Table object (users)
        if (!isset($GLOBALS["users"]) || get_class($GLOBALS["users"]) == PROJECT_NAMESPACE . "users") {
            $GLOBALS["users"] = &$this;
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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                WriteJson(["url" => $url]);
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
            $key .= @$ar['Username'];
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
    public $FormClassName = "ew-form ew-register-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $UserProfile, $Language, $Security, $CurrentForm, $UserTable, $CurrentLanguage, $Breadcrumb, $SkipHeaderFooter;

// Is modal
        $this->IsModal = ConvertToBool(Param("modal"));
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param(Config("PAGE_LAYOUT"), true));

        // View
        $this->View = Get(Config("VIEW"));

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Load default values for add
        $this->loadDefaultValues();
		My_Global_Check(); // Modified by Masino Sinaga, October 6, 2021

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;

        // Set up Breadcrumb
        $Breadcrumb = new Breadcrumb("home");
        $Breadcrumb->add("register", "RegisterPage", CurrentUrl(), "", "", true);
        $this->Heading = $Language->phrase("RegisterPage");
        $userExists = false;
        $this->loadRowValues(); // Load default values

        // Get action
        $action = "";
        if (IsApi()) {
            $action = "insert";
        } elseif (Post("action") != "") {
            $action = Post("action");
        }

        // Check action
        if ($action != "") {
            // Get action
            $this->CurrentAction = $action;
            $this->loadFormValues(); // Get form values

            // Validate form
            if (!$this->validateForm()) {
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }

			// Check the password strength, by Masino Sinaga, December 23, 2018
			if (!$this->checkPasswordStrength() && $this->CurrentAction != "show") {
				$this->CurrentAction = "show"; // Form error, reset action
				$this->setFailureMessage($FormError);
			}
        } else {
            $this->CurrentAction = "show"; // Display blank record
        }

        // Handle email activation
        if (Get("action") != "") {
            $action = Get("action");
            $userName = Get("user");
            $code = Get("activatetoken");
            @list($emailAddress, $approvalCode, $pwd) = explode(",", $code, 3);
            $emailAddress = Decrypt($emailAddress);
            $approvalCode = Decrypt($approvalCode);
            $pwd = Decrypt($pwd);
            if ($userName == $approvalCode) {
                if (SameText($action, "confirm")) { // Email activation
                    if ($this->activateUser($userName)) { // Activate this user
                        if ($this->getSuccessMessage() == "") {
                            $this->setSuccessMessage($Language->phrase("ActivateAccount")); // Set up message acount activated
                        }
                        $this->terminate("login"); // Go to login page
                        return;
                    }
                }
            }
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("ActivateFailed")); // Set activate failed message
            }
            $this->terminate("login"); // Go to login page
            return;
        }

        // Insert record
        if ($this->isInsert()) {
            // Check for duplicate User ID
            $filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"), $this->_Username->CurrentValue);
            // Set up filter (WHERE Clause)
            $this->CurrentFilter = $filter;
            $userSql = $this->getCurrentSql();
            $rs = Conn($UserTable->Dbid)->executeQuery($userSql);
            if ($rs->fetch()) {
                $userExists = true;
                $this->restoreFormValues(); // Restore form values
                $this->setFailureMessage($Language->phrase("UserExists")); // Set user exist message
            }
            if (!$userExists) {
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow()) { // Add record
                    $email = $this->prepareRegisterEmail();
                    // Get new record
                    $this->CurrentFilter = $this->getRecordFilter();
                    $sql = $this->getCurrentSql();
                    $row = Conn($UserTable->Dbid)->fetchAssociative($sql);
                    $args = [];
                    $args["rs"] = $row;
                    $emailSent = false;
                    if ($this->emailSending($email, $args)) {
                        $emailSent = $email->send();
                    }

                    // Send email failed
                    if (!$emailSent) {
                        $this->setFailureMessage($email->SendErrDescription);
                    }

                    // Save user language
                    global $UserProfile;
                    $userName = GetUserInfo(Config("LOGIN_USERNAME_FIELD_NAME"), $row);
                    $UserProfile->setLanguageId($userName, $CurrentLanguage);
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("RegisterSuccessActivate")); // Activate success
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        if (Config("USE_TWO_FACTOR_AUTHENTICATION") && Config("FORCE_TWO_FACTOR_AUTHENTICATION")) { // Add two factor authentication
                            $_SESSION[SESSION_STATUS] = "loggingin2fa";
                            $_SESSION[SESSION_USER_PROFILE_USER_NAME] = $this->_Username->CurrentValue;
                            $_SESSION[SESSION_USER_PROFILE_PASSWORD] = ""; // DO NOT auto login
                            $this->terminate("login2fa"); // Add two factor authentication
                        } else {
                            $this->terminate("login"); // Return
                        }
                        return;
                    }
                } else {
                    $this->restoreFormValues(); // Restore form values
                }
            }
        }

        // API request, return
        if (IsApi()) {
            $this->terminate();
            return;
        }

        // Render row
        if ($this->isConfirm()) { // Confirm page
            $this->RowType = ROWTYPE_VIEW; // Render view
        } else {
            $this->RowType = ROWTYPE_ADD; // Render add
        }
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

    // Activate account based on user
    protected function activateUser($usr)
    {
        global $UserTable, $Language;
        $filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"), $usr);
        $sql = $this->getSql($filter);
        $conn = Conn($UserTable->Dbid);
        $rsnew = $conn->fetchAssociative($sql);
        if ($rsnew) {
            $this->loadRowValues($rsnew); // Load row values
            $rsact = [Config("REGISTER_ACTIVATE_FIELD_NAME") => "Y"]; // Auto register
            $this->CurrentFilter = $filter;
            $res = $this->update($rsact);
            if ($res) { // Call User Activated event
                $rsnew[Config("REGISTER_ACTIVATE_FIELD_NAME")] = "Y";
                $this->userActivated($rsnew);
            }
            return $res;
        } else {
            $this->setFailureMessage($Language->phrase("NoRecord"));
            return false;
        }
    }

	protected function checkPasswordStrength() {
        global $Language, $FormError;

        // Check if validation required
        if (!Config("SERVER_VALIDATE"))
            return TRUE;

        // Initialize form error message
        $FormError = "";
		if (MS_ENABLE_PASSWORD_POLICY == TRUE) { 

			// Begin of modification Strong Password Policies/Rules, by Masino Sinaga, June 12, 2012
			if (MS_PASSWORD_MUST_COMPLY_WITH_MIN_LENGTH == TRUE) {
				if( strlen($this->_Password->FormValue) < MS_PASSWORD_MINIMUM_LENGTH ) {
					AddMessage($FormError, str_replace("%n", MS_PASSWORD_MINIMUM_LENGTH, $Language->phrase("ErrorPassTooShort")));
				}
			}
			if (MS_PASSWORD_MUST_COMPLY_WITH_MAX_LENGTH == TRUE) {
				if( strlen($this->_Password->FormValue) > MS_PASSWORD_MAXIMUM_LENGTH ) {
					AddMessage($FormError, str_replace("%n", MS_PASSWORD_MAXIMUM_LENGTH, $Language->phrase("ErrorPassTooLong")));
				}
			}
			if (MS_PASSWORD_MUST_CONTAIN_AT_LEAST_ONE_NUMERIC == TRUE) {
				if( !preg_match("#[0-9]+#", $this->_Password->FormValue) ) {
					AddMessage($FormError, $Language->phrase("ErrorPassDoesNotIncludeNumber"));
				}
			}
			if (MS_PASSWORD_MUST_CONTAIN_AT_LEAST_ONE_LOWERCASE == TRUE) {
				if( !preg_match("#[a-z]+#", $this->_Password->FormValue) ) {
					AddMessage($FormError, $Language->phrase("ErrorPassDoesNotIncludeLetter"));
				}
			}
			if (MS_PASSWORD_MUST_CONTAIN_AT_LEAST_ONE_UPPERCASE == TRUE) {
				if( !preg_match("#[A-Z]+#", $this->_Password->FormValue) ) {
					AddMessage($FormError, $Language->phrase("ErrorPassDoesNotIncludeCaps"));
				}
			}
			if (MS_PASSWORD_MUST_CONTAIN_AT_LEAST_ONE_SYMBOL == TRUE) {
				if( !preg_match("#\W+#", $this->_Password->FormValue) ) {
					AddMessage($FormError, $Language->phrase("ErrorPassDoesNotIncludeSymbol"));
				}
			}
			// End of modification Strong Password Policies/Rules, by Masino Sinaga, June 12, 2012
		} 
        // Return validate result
        $valid = ($FormError == "");
        return $valid;
    }

// Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->Activated->DefaultValue = $this->Activated->getDefault(); // PHP
        $this->Activated->OldValue = $this->Activated->DefaultValue;
        $this->Locked->DefaultValue = $this->Locked->getDefault(); // PHP
        $this->Locked->OldValue = $this->Locked->DefaultValue;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'Username' first before field var 'x__Username'
        $val = $CurrentForm->hasValue("Username") ? $CurrentForm->getValue("Username") : $CurrentForm->getValue("x__Username");
        if (!$this->_Username->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_Username->Visible = false; // Disable update for API request
            } else {
                $this->_Username->setFormValue($val);
            }
        }

        // Check field name 'Password' first before field var 'x__Password'
        $val = $CurrentForm->hasValue("Password") ? $CurrentForm->getValue("Password") : $CurrentForm->getValue("x__Password");
        if (!$this->_Password->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_Password->Visible = false; // Disable update for API request
            } else {
                $this->_Password->setFormValue($val);
            }
        }

        // Note: ConfirmValue will be compared with FormValue
        if (Config("ENCRYPTED_PASSWORD")) { // Encrypted password, use raw value
            $this->_Password->ConfirmValue = $CurrentForm->getValue("c__Password");
        } else {
            $this->_Password->ConfirmValue = RemoveXss($CurrentForm->getValue("c__Password"));
        }

        // Check field name 'First_Name' first before field var 'x_First_Name'
        $val = $CurrentForm->hasValue("First_Name") ? $CurrentForm->getValue("First_Name") : $CurrentForm->getValue("x_First_Name");
        if (!$this->First_Name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->First_Name->Visible = false; // Disable update for API request
            } else {
                $this->First_Name->setFormValue($val);
            }
        }

        // Check field name 'Last_Name' first before field var 'x_Last_Name'
        $val = $CurrentForm->hasValue("Last_Name") ? $CurrentForm->getValue("Last_Name") : $CurrentForm->getValue("x_Last_Name");
        if (!$this->Last_Name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Last_Name->Visible = false; // Disable update for API request
            } else {
                $this->Last_Name->setFormValue($val);
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
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->_Username->CurrentValue = $this->_Username->FormValue;
        $this->_Password->CurrentValue = $this->_Password->FormValue;
        $this->First_Name->CurrentValue = $this->First_Name->FormValue;
        $this->Last_Name->CurrentValue = $this->Last_Name->FormValue;
        $this->_Email->CurrentValue = $this->_Email->FormValue;
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
        $this->Photo->setDbValue($this->Photo->Upload->DbValue);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['Username'] = $this->_Username->DefaultValue;
        $row['Password'] = $this->_Password->DefaultValue;
        $row['First_Name'] = $this->First_Name->DefaultValue;
        $row['Last_Name'] = $this->Last_Name->DefaultValue;
        $row['Email'] = $this->_Email->DefaultValue;
        $row['User_Level'] = $this->User_Level->DefaultValue;
        $row['Report_To'] = $this->Report_To->DefaultValue;
        $row['Activated'] = $this->Activated->DefaultValue;
        $row['Locked'] = $this->Locked->DefaultValue;
        $row['Profile'] = $this->_Profile->DefaultValue;
        $row['Photo'] = $this->Photo->DefaultValue;
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

        // Username
        $this->_Username->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Password
        $this->_Password->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // First_Name
        $this->First_Name->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Last_Name
        $this->Last_Name->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Email
        $this->_Email->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // User_Level
        $this->User_Level->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Report_To
        $this->Report_To->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Activated
        $this->Activated->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Locked
        $this->Locked->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Profile
        $this->_Profile->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // Photo
        $this->Photo->RowCssClass = $this->IsMobileOrModal ? "row" : "";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
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
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // Username
            $this->_Username->setupEditAttributes();
            if (!$this->_Username->Raw) {
                $this->_Username->CurrentValue = HtmlDecode($this->_Username->CurrentValue);
            }
            $this->_Username->EditValue = HtmlEncode($this->_Username->CurrentValue);
            $this->_Username->PlaceHolder = RemoveHtml($this->_Username->caption());

            // Password
            $this->_Password->setupEditAttributes(["class" => "ew-password-strength"]);
            $this->_Password->PlaceHolder = RemoveHtml($this->_Password->caption());

            // First_Name
            $this->First_Name->setupEditAttributes();
            if (!$this->First_Name->Raw) {
                $this->First_Name->CurrentValue = HtmlDecode($this->First_Name->CurrentValue);
            }
            $this->First_Name->EditValue = HtmlEncode($this->First_Name->CurrentValue);
            $this->First_Name->PlaceHolder = RemoveHtml($this->First_Name->caption());

            // Last_Name
            $this->Last_Name->setupEditAttributes();
            if (!$this->Last_Name->Raw) {
                $this->Last_Name->CurrentValue = HtmlDecode($this->Last_Name->CurrentValue);
            }
            $this->Last_Name->EditValue = HtmlEncode($this->Last_Name->CurrentValue);
            $this->Last_Name->PlaceHolder = RemoveHtml($this->Last_Name->caption());

            // Email
            $this->_Email->setupEditAttributes();
            if (!$this->_Email->Raw) {
                $this->_Email->CurrentValue = HtmlDecode($this->_Email->CurrentValue);
            }
            $this->_Email->EditValue = HtmlEncode($this->_Email->CurrentValue);
            $this->_Email->PlaceHolder = RemoveHtml($this->_Email->caption());

            // Add refer script

            // Username
            $this->_Username->HrefValue = "";

            // Password
            $this->_Password->HrefValue = "";

            // First_Name
            $this->First_Name->HrefValue = "";

            // Last_Name
            $this->Last_Name->HrefValue = "";

            // Email
            $this->_Email->HrefValue = "";
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
        if ($this->_Username->Required) {
            if (!$this->_Username->IsDetailKey && EmptyValue($this->_Username->FormValue)) {
                $this->_Username->addErrorMessage($Language->phrase("EnterUserName"));
            }
        }
        if (!$this->_Username->Raw && Config("REMOVE_XSS") && CheckUsername($this->_Username->FormValue)) {
            $this->_Username->addErrorMessage($Language->phrase("InvalidUsernameChars"));
        }
        if ($this->_Password->Required) {
            if (!$this->_Password->IsDetailKey && EmptyValue($this->_Password->FormValue)) {
                $this->_Password->addErrorMessage($Language->phrase("EnterPassword"));
            }
        }
        if ($this->_Password->ConfirmValue != $this->_Password->FormValue) {
            $this->_Password->addErrorMessage($Language->phrase("MismatchPassword"));
        }
        if (!$this->_Password->Raw && Config("REMOVE_XSS") && CheckPassword($this->_Password->FormValue)) {
            $this->_Password->addErrorMessage($Language->phrase("InvalidPasswordChars"));
        }
        if ($this->First_Name->Required) {
            if (!$this->First_Name->IsDetailKey && EmptyValue($this->First_Name->FormValue)) {
                $this->First_Name->addErrorMessage(str_replace("%s", $this->First_Name->caption(), $this->First_Name->RequiredErrorMessage));
            }
        }
        if ($this->Last_Name->Required) {
            if (!$this->Last_Name->IsDetailKey && EmptyValue($this->Last_Name->FormValue)) {
                $this->Last_Name->addErrorMessage(str_replace("%s", $this->Last_Name->caption(), $this->Last_Name->RequiredErrorMessage));
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

        // Username
        $this->_Username->setDbValueDef($rsnew, $this->_Username->CurrentValue, false);

        // Password
        if (!IsMaskedPassword($this->_Password->CurrentValue)) {
            $this->_Password->setDbValueDef($rsnew, $this->_Password->CurrentValue, false);
        }

        // First_Name
        $this->First_Name->setDbValueDef($rsnew, $this->First_Name->CurrentValue, false);

        // Last_Name
        $this->Last_Name->setDbValueDef($rsnew, $this->Last_Name->CurrentValue, false);

        // Email
        $this->_Email->setDbValueDef($rsnew, $this->_Email->CurrentValue, false);

        // Report_To

        // Update current values
        $this->setCurrentValues($rsnew);

        // Check if valid User ID
        if (
            !EmptyValue($Security->currentUserID()) &&
            !$Security->isAdmin() && // Non system admin
            !$Security->isValidUserID($this->_Username->CurrentValue)
        ) {
			$Security->addUserID($this->_Username->CurrentValue); // added by Masino Sinaga, in order to prevent message below
            $userIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedUserID"));
            $userIdMsg = str_replace("%u", strval($this->_Username->CurrentValue), $userIdMsg);
            $this->setFailureMessage($userIdMsg);
            return false;
        }

        // Check if valid Parent User ID
        if (
            !EmptyValue($Security->currentUserID()) &&
            !EmptyValue($this->Report_To->CurrentValue) && // Allow empty value
            !$Security->isAdmin() && // Non system admin
            !$Security->isValidUserID($this->Report_To->CurrentValue)
        ) {
			$Security->addUserID($this->Report_To->CurrentValue); // added by Masino Sinaga, in order to prevent message below
            $parentUserIdMsg = str_replace("%c", CurrentUserID(), $Language->phrase("UnAuthorizedParentUserID"));
            $parentUserIdMsg = str_replace("%p", strval($this->Report_To->CurrentValue), $parentUserIdMsg);
            $this->setFailureMessage($parentUserIdMsg);
            return false;
        }
        $conn = $this->getConnection();

        // Load db values from old row
        $this->loadDbValues($rsold);

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);

        // Check if key value entered
        if ($insertRow && $this->ValidateKey && strval($rsnew['Username']) == "") {
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

            // Call User Registered event
            $this->userRegistered($rsnew);
        }

        // Write JSON response
        if (IsJsonResponse() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            $table = $this->TableVar;
            WriteJson(["success" => true, "action" => Config("API_ADD_ACTION"), $table => $row]);
        }
        return $addRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("home");
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
                case "x_User_Level":
                    break;
                case "x_Activated":
                    break;
                case "x_Locked":
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
    // $type = ''|'success'|'failure'
    public function messageShowing(&$msg, $type)
    {
        // Example:
        //if ($type == 'success') $msg = "your success message";
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

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email, $args); exit();
        return true;
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }

    // User Registered event
    public function userRegistered(&$rs)
    {
        //Log("User_Registered");
    }

    // User Activated event
    public function userActivated(&$rs)
    {
        //Log("User_Activated");
    }
}
