<?php

namespace PHPMaker2023\new2023;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class ChangePassword extends Users
{
    use MessagesTrait;

    // Page ID
    public $PageID = "change_password";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Page object name
    public $PageObjName = "ChangePassword";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // CSS class/style
    public $CurrentPageName = "changepassword";

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
        $this->TableClass = "table table-striped table-bordered table-hover table-sm ew-view-table";

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
    public $IsModal = false;
    public $OldPassword;
    public $NewPassword;
    public $ConfirmPassword;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $UserProfile, $Language, $Security, $CurrentForm, $UserTable, $Breadcrumb, $SkipHeaderFooter;
        $this->OffsetColumnClass = ""; // Override user table

        // Create Password fields object (used by validation only)
        $this->OldPassword = new DbField(Container("usertable"), "opwd", "opwd", "opwd", "", 202, 255, -1, false, "", false, false, false);
        $this->OldPassword->EditAttrs->appendClass("form-control ew-form-control");
        $this->NewPassword = new DbField(Container("usertable"), "npwd", "npwd", "npwd", "", 202, 255, -1, false, "", false, false, false);
        $this->NewPassword->EditAttrs->appendClass("form-control ew-form-control");
        $this->NewPassword->EditAttrs->appendClass("ew-password-strength");
        $this->ConfirmPassword = new DbField(Container("usertable"), "cpwd", "cpwd", "cpwd", "", 202, 255, -1, false, "", false, false, false);
        $this->ConfirmPassword->EditAttrs->appendClass("form-control ew-form-control");
        if (Config("ENCRYPTED_PASSWORD")) {
            $this->OldPassword->Raw = true;
            $this->NewPassword->Raw = true;
            $this->ConfirmPassword->Raw = true;
        }

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
        $this->CurrentAction = Param("action"); // Set up current action

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }
		My_Global_Check(); // Modified by Masino Sinaga, October 6, 2021

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $Breadcrumb = new Breadcrumb("home");
        $Breadcrumb->add("change_password", "ChangePasswordPage", CurrentUrl(), "", "", true);
        $this->Heading = $Language->phrase("ChangePasswordPage");
        $postBack = IsPost();
        $validate = true;
        if ($postBack) {
            $this->OldPassword->setFormValue(Post($this->OldPassword->FieldVar));
            $this->NewPassword->setFormValue(Post($this->NewPassword->FieldVar));
            $this->ConfirmPassword->setFormValue(Post($this->ConfirmPassword->FieldVar));
            $validate = $this->validateForm();
        }
        $pwdUpdated = false;
        if ($postBack && $validate) {
            // Setup variables
            $userName = $Security->currentUserName();
			$userEmail = ""; // Customization by Masino Sinaga, August 30, 20216
            if (IsPasswordReset()) {
                $userName = Session(SESSION_USER_PROFILE_USER_NAME);
				$userEmail = Session(SESSION_USER_PROFILE_USER_EMAIL); // Customization by Masino Sinaga, August 30, 2016, in order to support changing password based on Username AND Email (related/similar to the same customization in "MasinoForgotPassword19" extension)
            }
            if (IsPasswordExpired()) {
                $userName = Session(SESSION_USER_PROFILE_USER_NAME);
				$userEmail = Session(SESSION_USER_PROFILE_USER_EMAIL); // Customization by Masino Sinaga, August 30, 2016, in order to support changing password based on Username AND Email (related/similar to the same customization in "MasinoForgotPassword19" extension)
            }

            // $filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"), $userName);

			// Begin of customization by Masino Sinaga, August 30, 2016
			if ($userName <> "" && $userEmail <> "") { 
				// $filter = str_replace("%u", AdjustSql($userName, Config("USER_TABLE_DBID")), Config("USER_NAME_FILTER"));
				$filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"),  $userName);
				$filter .= " AND " . str_replace("%e", AdjustSql($userEmail, Config("USER_TABLE_DBID")), Config("USER_EMAIL_FILTER"));
			} elseif ($userName <> "" && $userEmail == "") {
				// $filter = str_replace("%u", AdjustSql($userName, Config("USER_TABLE_DBID")), Config("USER_NAME_FILTER"));
				$filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"),  $userName);
			} elseif ($userName == "" && $userEmail <> "") {
				$filter .= str_replace("%e", AdjustSql($userEmail, Config("USER_TABLE_DBID")), Config("USER_EMAIL_FILTER"));
			} else { // default: based on Username
				// $filter = str_replace("%u", AdjustSql($userName, Config("USER_TABLE_DBID")), Config("USER_NAME_FILTER"));
				$filter = GetUserFilter(Config("LOGIN_USERNAME_FIELD_NAME"),  $userName);
				//$filter .= str_replace("%e", AdjustSql($userEmail, Config("USER_TABLE_DBID")), Config("USER_EMAIL_FILTER"));
			} // End of customization by Masino Sinaga, August 30, 2016

            // Set up filter (WHERE Clause)
            $this->CurrentFilter = $filter;
            $sql = $this->getCurrentSql();
            if ($rsold = Conn($UserTable->Dbid)->fetchAssociative($sql)) {
                if (IsPasswordReset() || ComparePassword(GetUserInfo(Config("LOGIN_PASSWORD_FIELD_NAME"), $rsold), $this->OldPassword->CurrentValue)) {
                    $validPwd = true;
                    if (!IsPasswordReset()) {
                        $validPwd = $this->userChangePassword($rsold, $userName, $this->OldPassword->CurrentValue, $this->NewPassword->CurrentValue);
                    }
                    if ($validPwd) {
                        $rsnew = [Config("LOGIN_PASSWORD_FIELD_NAME") => $this->NewPassword->CurrentValue]; // Change Password
                        $emailAddress = GetUserInfo(Config("USER_EMAIL_FIELD_NAME"), $rsold);
                        $validPwd = $this->update($rsnew);
                        if ($validPwd) {
                            $pwdUpdated = true;
                        }
                    } else {
                        $this->setFailureMessage($Language->phrase("InvalidNewPassword"));
                    }

					// Validate password, by Masino Sinaga, December 23, 2018
					$validPassword = $this->validatePassword(Post($this->OldPassword->FieldVar), Post($this->NewPassword->FieldVar));
					if (!$validPassword) {
						return;
					}
                } else {
                    $this->setFailureMessage($Language->phrase("InvalidPassword"));
                }
            }
        }
        if ($pwdUpdated) {
            if (@$emailAddress != "") {
                // Load Email Content
                $email = new Email();
                // $email->load(Config("EMAIL_CHANGE_PASSWORD_TEMPLATE"));
				// Begin of modification by Masino Sinaga, February 28, 2018
				$email->load(Config("EMAIL_CHANGE_PASSWORD_TEMPLATE"), CurrentLanguageID());
				$email->replaceSubject($Language->phrase("SubjectChangePassword") . ' ' . $Language->projectPhrase("BodyTitle"));
				// End of modification by Masino Sinaga, February 28, 2018
                $email->replaceSender(Config("SENDER_EMAIL")); // Replace Sender
                $email->replaceRecipient($emailAddress); // Replace Recipient
				if (MS_SHOW_PLAIN_TEXT_PASSWORD==TRUE) {
					$email->replaceContent('<!--$Password-->', @$newPassword);
				} else {
					$email->replaceContent('<!--$Password-->', '********** (it is hidden, for security reason)');
				}
				$email->replaceSubject($Language->phrase("SubjectChangePassword").' '.$Language->projectPhrase("BodyTitle"));
                $args = [];
                $args["rs"] = &$rsnew;
                $emailSent = false;
                if ($this->emailSending($email, $args)) {
                    $emailSent = $email->send();
                }

                // Send email failed
                if (!$emailSent) {
                    $this->setFailureMessage($email->SendErrDescription);
                }
            }
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("PasswordChanged")); // Set up success message
            }
            if (IsPasswordReset()) {
                $_SESSION[SESSION_STATUS] = "";
                $_SESSION[SESSION_USER_PROFILE_USER_NAME] = "";
				$_SESSION[SESSION_USER_PROFILE_USER_EMAIL] = "";
            }

            // Update user profile and login again
            global $UserProfile;
            $UserProfile->loadProfileFromDatabase($userName);
            $UserProfile->setValue(Config("USER_PROFILE_LAST_PASSWORD_CHANGED_DATE"), StdCurrentDate());
            $UserProfile->saveProfileToDatabase($userName);
            if (IsPasswordExpired()) {
                $_SESSION[SESSION_USER_PROFILE_PASSWORD] = $this->NewPassword->CurrentValue;
                $_SESSION[SESSION_STATUS] = "loggingin";
                $this->terminate("login"); // Return to login page
                return;
            }
            $this->terminate("index"); // Return to default page
            return;
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

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $valid = true;
        if (!IsPasswordReset() && EmptyValue($this->OldPassword->CurrentValue)) {
            $this->OldPassword->addErrorMessage($Language->phrase("EnterOldPassword"));
            $valid = false;
        }
        if (EmptyValue($this->NewPassword->CurrentValue)) {
            $this->NewPassword->addErrorMessage($Language->phrase("EnterNewPassword"));
            $valid = false;
        }
        if (!$this->NewPassword->Raw && Config("REMOVE_XSS") && CheckPassword($this->NewPassword->CurrentValue)) {
            $this->NewPassword->addErrorMessage($Language->phrase("InvalidPasswordChars"));
            $valid = false;
        }
        if ($this->NewPassword->CurrentValue != $this->ConfirmPassword->CurrentValue) {
            $this->ConfirmPassword->addErrorMessage($Language->phrase("MismatchPassword"));
            $valid = false;
        }

        // Call Form CustomValidate event
        $formCustomError = "";
        $valid = $valid && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $valid;
    }

	private function validatePassword($oldPassword, $newPassword) {
        global $Language, $FormError;

        // Check if validation required
        if (!Config("SERVER_VALIDATE"))
            return TRUE;

        // Initialize form error message
        $FormError = "";
        $validPassword = FALSE;
		if (MS_ENABLE_PASSWORD_POLICY == TRUE) { 

			// Begin of modification Strong Password Policies/Rules, by Masino Sinaga, June 12, 2012
			if (MS_PASSWORD_MUST_COMPLY_WITH_MIN_LENGTH == TRUE) {
				if( strlen($newPassword) < MS_PASSWORD_MINIMUM_LENGTH ) {
					AddMessage($FormError, str_replace("%n", MS_PASSWORD_MINIMUM_LENGTH, $Language->phrase("ErrorPassTooShort")), "\r\n");
					$validPassword = FALSE;
				}
			}
			if (MS_PASSWORD_MUST_COMPLY_WITH_MAX_LENGTH == TRUE) {
				if( strlen($newPassword) > MS_PASSWORD_MAXIMUM_LENGTH ) {
					AddMessage($FormError, str_replace("%n", MS_PASSWORD_MAXIMUM_LENGTH, $Language->phrase("ErrorPassTooLong")), "\r\n");
					$validPassword = FALSE;
				}
			}
			if (MS_PASSWORD_MUST_CONTAIN_AT_LEAST_ONE_NUMERIC == TRUE) {
				if( !preg_match("#[0-9]+#", $newPassword) ) {
					AddMessage($FormError, $Language->phrase("ErrorPassDoesNotIncludeNumber"), "\r\n");
					$validPassword = FALSE;
				}
			}
			if (MS_PASSWORD_MUST_CONTAIN_AT_LEAST_ONE_LOWERCASE == TRUE) {
				if( !preg_match("#[a-z]+#", $newPassword) ) {
					AddMessage($FormError, $Language->phrase("ErrorPassDoesNotIncludeLetter"), "\r\n");
					$validPassword = FALSE;
				}
			}
			if (MS_PASSWORD_MUST_CONTAIN_AT_LEAST_ONE_UPPERCASE == TRUE) {
				if( !preg_match("#[A-Z]+#", $newPassword) ) {
					AddMessage($FormError, $Language->phrase("ErrorPassDoesNotIncludeCaps"), "\r\n");
					$validPassword = FALSE;
				}
			}
			if (MS_PASSWORD_MUST_CONTAIN_AT_LEAST_ONE_SYMBOL == TRUE) {
				if( !preg_match("#\W+#", $newPassword) ) {
					AddMessage($FormError, $Language->phrase("ErrorPassDoesNotIncludeSymbol"), "\r\n");
					$validPassword = FALSE;
				}
			}
			if (MS_PASSWORD_MUST_DIFFERENT_OLD_AND_NEW == TRUE) {
				if ($oldPassword == $newPassword) {
					AddMessage($FormError, $Language->phrase("ErrorPassCouldNotBeSame"), "\r\n");
					$validPassword = FALSE;
				}
			}
			// End of modification Strong Password Policies/Rules, by Masino Sinaga, June 12, 2012
		} 
		if (!empty($FormError)) {
			$this->setFailureMessage($FormError);
			$validPassword = FALSE;
		}
        // Return validate result
        $validPassword = ($FormError == "");
        return $validPassword;
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

    // User ChangePassword event
    public function userChangePassword(&$rs, $usr, $oldpwd, &$newpwd)
    {
        // Return false to abort
        return true;
    }
}
