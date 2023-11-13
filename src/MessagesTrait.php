<?php

namespace PHPMaker2023\new2023;
trait MessagesTrait {
    // Messages
    private $message = "";
    private $failureMessage = "";
    private $successMessage = "";
    private $warningMessage = "";

    // Heading
    private $messageHeading = "";

    // Use JavaScript message
    public $UseJavaScriptMessage;

    // Get message
    public function getMessage()
    {
        return $_SESSION[SESSION_MESSAGE] ?? $this->message;
    }

    // Set message
    public function setMessage($v)
    {
        AddMessage($this->message, $v);
        $_SESSION[SESSION_MESSAGE] = $this->message;
    }

    // Get failure message
    public function getFailureMessage()
    {
        return $_SESSION[SESSION_FAILURE_MESSAGE] ?? $this->failureMessage;
    }

    // Set failure message
    public function setFailureMessage($v)
    {
        AddMessage($this->failureMessage, $v);
        $_SESSION[SESSION_FAILURE_MESSAGE] = $this->failureMessage;
    }

    // Get success message
    public function getSuccessMessage()
    {
        return $_SESSION[SESSION_SUCCESS_MESSAGE] ?? $this->successMessage;
    }

    // Set success message
    public function setSuccessMessage($v)
    {
        AddMessage($this->successMessage, $v);
        $_SESSION[SESSION_SUCCESS_MESSAGE] = $this->successMessage;
    }

    // Get warning message
    public function getWarningMessage()
    {
        return $_SESSION[SESSION_WARNING_MESSAGE] ?? $this->warningMessage;
    }

    // Set warning message
    public function setWarningMessage($v)
    {
        AddMessage($this->warningMessage, $v);
        $_SESSION[SESSION_WARNING_MESSAGE] = $this->warningMessage;
    }

    // Get message heading
    public function getMessageHeading()
    {
        return $_SESSION[SESSION_MESSAGE_HEADING] ?? $this->messageHeading;
    }

    // Set message heading
    public function setMessageHeading($v)
    {
        $this->messageHeading = $v;
        $_SESSION[SESSION_MESSAGE_HEADING] = $this->messageHeading;
    }

    // Clear message heading
    public function clearMessageHeading()
    {
        $this->messageHeading = "";
        $_SESSION[SESSION_MESSAGE_HEADING] = "";
    }

    // Clear message
    public function clearMessage()
    {
        $this->message = "";
        $_SESSION[SESSION_MESSAGE] = "";
        $this->clearMessageHeading();
    }

    // Clear failure message
    public function clearFailureMessage()
    {
        $this->failureMessage = "";
        $_SESSION[SESSION_FAILURE_MESSAGE] = "";
        $this->clearMessageHeading();
    }

    // Clear success message
    public function clearSuccessMessage()
    {
        $this->successMessage = "";
        $_SESSION[SESSION_SUCCESS_MESSAGE] = "";
        $this->clearMessageHeading();
    }

    // Clear warning message
    public function clearWarningMessage()
    {
        $this->warningMessage = "";
        $_SESSION[SESSION_WARNING_MESSAGE] = "";
        $this->clearMessageHeading();
    }

    // Clear messages
    public function clearMessages()
    {
        $this->clearMessage();
        $this->clearFailureMessage();
        $this->clearSuccessMessage();
        $this->clearWarningMessage();
    }

    // Show message
    public function showMessage()
    {
        global $Language;
        $hidden = $this->UseJavaScriptMessage ?? Config("USE_JAVASCRIPT_MESSAGE");
		$msg_box = Config("MS_USE_MESSAGE_BOX_INSTEAD_OF_TOAST");
        $html = "";
        // Message heading
        if ($msg_box == false) {
			$heading = function () {
				$mh =  $this->getMessageHeading();
				return $mh != '' ? '<h5 class="alert-heading">' . $mh . '</h5>' : '';
			};
		} else {
			$heading = function () {
				return '';
			};
		}
        // Message
        $message = $this->getMessage();
        if (method_exists($this, "messageShowing")) {
            $this->messageShowing($message, "");
        }
        if ($message != "") {
			if ($msg_box == false) {
				$html .= '<div class="alert alert-info alert-dismissible ew-info">' . $heading() . '<i class="icon fa-solid fa-info"></i>' . $message . '</div>';
			} else {
				$html .= '<div class="alert alert-info alert-dismissible ew-info">' . $heading() . '<div class="row"><div class="col-2"><span style="font-size: 3rem;"><i class="icon fa-solid fa-circle-info" style="vertical-align: text-top;"></i></span></div><div class="col-10">' . $message . '</div></div></div>';
			}
        }
        // Warning message
        $warningMessage = $this->getWarningMessage();
        if (method_exists($this, "messageShowing")) {
            $this->messageShowing($warningMessage, "warning");
        }
        if ($warningMessage != "") {
			if ($msg_box == false) {
				$html .= '<div class="alert alert-warning alert-dismissible ew-warning">' . $heading() . '<i class="icon fa-solid fa-exclamation"></i>' . $warningMessage . '</div>';
			} else {
				$html .= '<div class="alert alert-warning alert-dismissible ew-warning">' . $heading() . '<div class="row"><div class="col-2"><span style="font-size: 3rem;"><i class="icon fa-solid fa-circle-exclamation" style="vertical-align: text-top;"></i></span></div><div class="col-10">' . $warningMessage . '</div></div></div>';
			}
        }
        // Success message
        $successMessage = $this->getSuccessMessage();
        if (method_exists($this, "messageShowing")) {
            $this->messageShowing($successMessage, "success");
        }
        if ($successMessage != "") {
			if ($msg_box == false) {
				$html .= '<div class="alert alert-success alert-dismissible ew-success">' . $heading() . '<i class="icon fa-solid fa-check"></i>' . $successMessage . '</div>';
			} else {
				$html .= '<div class="alert alert-success alert-dismissible ew-success">' . $heading() . '<div class="row"><div class="col-2"><span style="font-size: 3rem;"><i class="icon fa-solid fa-circle-check" style="vertical-align: text-top;"></i></span></div><div class="col-10">' . $successMessage . '</div></div></div>';
			}
        }
        // Failure message
        $errorMessage = $this->getFailureMessage();
        if (method_exists($this, "messageShowing")) {
            $this->messageShowing($errorMessage, "failure");
        }
        if ($errorMessage != "") {
			if ($msg_box == false) {
				$html .= '<div class="alert alert-danger alert-dismissible ew-error">' . $heading() . '<i class="icon fa-solid fa-close"></i>' . $errorMessage . '</div>';
			} else {
				$html .= '<div class="alert alert-danger alert-dismissible ew-error">' . $heading() . '<div class="row"><div class="col-2"><span style="font-size: 3rem;"><i class="icon fa-solid fa-circle-xmark" style="vertical-align: text-top;"></i></span></div><div class="col-10">' . $errorMessage . '</div></div></div>';
			}
        }
        $this->clearMessages();
        if ($html && !$hidden) {
            $html = '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="' . $Language->phrase("CloseBtn") . '"></button>' . $html;
        }
        echo '<div class="ew-message-dialog' . ($hidden ? ' d-none' : '') . '">' . $html . '</div>';
    }

    // Get message as array
    public function getMessages()
    {
        $ar = [];
        // Message heading
        $heading = $this->getMessageHeading();
        if ($heading != "") {
            $ar["heading"] = $heading;
        }
        // Message
        $message = $this->getMessage();
        if ($message != "") {
            $ar["message"] = $message;
        }
        // Warning message
        $warningMessage = $this->getWarningMessage();
        if ($warningMessage != "") {
            $ar["warningMessage"] = $warningMessage;
        }
        // Success message
        $successMessage = $this->getSuccessMessage();
        if ($successMessage != "") {
            $ar["success"] = true;
            $ar["successMessage"] = $successMessage;
        }
        // Failure message
        $failureMessage = $this->getFailureMessage();
        if ($failureMessage != "") {
            $ar["failureMessage"] = $failureMessage;
        }
        $this->clearMessages();
        return $ar;
    }
}
