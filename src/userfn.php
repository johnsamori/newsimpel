<?php

namespace PHPMaker2023\new2023;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Slim\App;
use Slim\Routing\RouteCollectorProxy;
if (@$_COOKIE['theme'] == 'dark') {
	Config("BODY_CLASS", Config("BODY_CLASS") . " dark-mode");
}
if (@$_COOKIE['aside_toggle_state'] == 'collapsed') {
	Config("BODY_CLASS", Config("BODY_CLASS") . " sidebar-collapse");
} elseif (@$_COOKIE['aside_toggle_state'] == 'closed') {
	Config("BODY_CLASS", Config("BODY_CLASS") . " sidebar-closed");
} elseif (@$_COOKIE['aside_toggle_state'] == 'expanded') {
	Config("BODY_CLASS", Config("BODY_CLASS") . " sidebar-open");
}

function AutoVersion($url){
	$dirfile = realpath($url);
	$ver = filemtime($dirfile);
	$file_ext = ".".substr(strtolower(strrchr($url, ".")), 1);
	$file_ext = $file_ext;
	$result = str_replace($file_ext, $file_ext."?v=".$ver, $url);
	echo $result;
}

function getCurrentPageTitle($pt) {
    global $CurrentPageTitle, $Language;
	$CurrentPageTitle = "";
	$dbid = 0;
	$conn = Conn();
	if (@MS_SHOW_MASINO_BREADCRUMBLINKS == TRUE && Config("MS_MASINO_BREADCRUMBLINKS_TABLE") != "") {
		$sSql = "SELECT C.Page_Title FROM ".Config("MS_MASINO_BREADCRUMBLINKS_TABLE")." AS B, ".Config("MS_MASINO_BREADCRUMBLINKS_TABLE")." AS C WHERE (B.Lft BETWEEN C.Lft AND C.Rgt) AND (B.Page_URL LIKE '".$pt."') ORDER BY C.Lft";
			$stmt = $conn->executeQuery($sSql);
			if ($stmt->rowCount() > 0) {
				while ($row = $stmt->fetch()) {
					$CurrentPageTitle = $Language->breadcrumbPhrase($row["Page_Title"]);
				}
			} else {
				$CurrentPageTitle = "";
			}
	}
	if (empty($CurrentPageTitle)) {
		if ( @CurrentPage()->PageID != "custom") {
			if (@CurrentPage()->TableName == trim(@CurrentPage()->TableName) && strpos(@CurrentPage()->TableName, ' ') !== false) {
				$CurrentPageTitle = ($Language->tablePhrase(str_replace(' ', '', @CurrentPage()->TableName), "TblCaption") != "") ? $Language->tablePhrase(str_replace(' ', '', @CurrentPage()->TableName), "TblCaption") : str_replace(' ', '', @CurrentPage()->TableName);
			} else {
				$CurrentPageTitle = ($Language->tablePhrase(@CurrentPage()->TableName, "TblCaption") != "") ? $Language->tablePhrase(@CurrentPage()->TableName, "TblCaption") : ucwords(@CurrentPage()->TableName);
			}
		} elseif ( @CurrentPage()->PageID == "custom") { // support for Custom Files
			$CurrentPageTitle = $Language->tablePhrase(str_replace(".php", "", @CurrentPage()->PageObjName), "TblCaption"); // Modified by Masino Sinaga, August 31, 2021
		}			
		$CurrentPageTitle = str_replace("_list", "", $CurrentPageTitle);
		$CurrentPageTitle = str_replace("_php", "", $CurrentPageTitle);
		$CurrentPageTitle = str_replace("_htm", "", $CurrentPageTitle);
		$CurrentPageTitle = str_replace("_html", "", $CurrentPageTitle);
		$CurrentPageTitle = str_replace("_", " ", $CurrentPageTitle);
		$CurrentPageTitle = ucwords($CurrentPageTitle);
	}
	if ($CurrentPageTitle == "") {
		$Language->projectPhrase("BodyTitle");
	}
	return $CurrentPageTitle;
}

/**
 * Application Root URL
 *
 * @return the url of application root
 */
function AppRootURL() {
	return str_replace(substr(strrchr(CurrentUrl(), "/"), 1), "", DomainUrl().CurrentUrl());
}

// Begin of modification LoadApplicationSettings, by Masino Sinaga, September 22, 2014
function LoadApplicationSettings() {
	$conn = Conn();
	$_SESSION["new2023_views"] = 1; // reset the global counter
	// Parent array of all items, initialized if not already...
	if (!isset($_SESSION["new2023_appset"])) {
		$_SESSION["new2023_appset"] = array();
	}
	$sSql = "SELECT * FROM ".Config("MS_SETTINGS_TABLE")." WHERE Option_Default = 'Y'";
	$stmt = $conn->executeQuery($sSql);
	if ($stmt->rowCount() > 0) {
		while ($row = $stmt->fetch()) {
			$x = array_keys($row);
			for ($i=0; $i<count($x); $i++) {
				if (is_string($x[$i])) {
					$sfieldname = $x[$i];
					$_SESSION["new2023_appset"][0][$sfieldname] = $row[$x[$i]];
				}
			}
		}
		if (!isset($_SESSION["new2023_errordb"]))
			$_SESSION["new2023_errordb"] = "";
	} else {
		if (!isset($_SESSION["new2023_errordb"]))
			$_SESSION["new2023_errordb"] = Config("MS_SETTINGS_TABLE");
	}
}
// End of modification LoadApplicationSettings, by Masino Sinaga, September 22, 2014

// Begin of modification My_Global_Check, by Masino Sinaga, July 3, 2013
function My_Global_Check() {
	global $Language, $Security, $page_type, $conn;
    $page_type = "TABLE"; 
	$dbid = 0;	
	if (!isset($_SESSION["new2023_Root_URL"])) { 
		$_SESSION["new2023_Root_URL"] = AppRootURL();
	}
	if (IsLoggedIn()) {
        if (!IsAdmin()) {
            Config("MS_USER_CARD_USER_NAME", CurrentUserName());
            Config("MS_USER_CARD_COMPLETE_NAME", CurrentUserInfo("FirstName") . " " .  CurrentUserInfo("LastName"));
		    Config("MS_USER_CARD_POSITION", Security()->currentUserLevelName());
        } else {
            Config("MS_USER_CARD_USER_NAME", CurrentUserName());
		    Config("MS_USER_CARD_COMPLETE_NAME", "Administrator");
		    Config("MS_USER_CARD_POSITION", Security()->currentUserLevelName());
        }
	}
	if (!isset($_SESSION["new2023_views"])) { 
		$_SESSION["new2023_views"] = 0;
	}
	$_SESSION["new2023_views"] = $_SESSION["new2023_views"]+1;
	if (!isset($_SESSION["new2023_appset"])) {
		LoadApplicationSettings();
	}
	if (@$_SESSION["new2023_appset"][0]["Show_Announcement"]=="Y") {
		Config("MS_SHOW_ANNOUNCEMENT", TRUE);
	} else {
		Config("MS_SHOW_ANNOUNCEMENT", FALSE);      
	}
	if (@$_SESSION["new2023_appset"][0]["Use_Announcement_Table"]=="Y") {
		Config("MS_SEPARATED_ANNOUNCEMENT", TRUE);
	} else {
		Config("MS_SEPARATED_ANNOUNCEMENT", FALSE);      
	}
	if (@$_SESSION["new2023_appset"][0]["Maintenance_Mode"]=="Y") {
		Config("MS_MAINTENANCE_MODE", TRUE);        
	} else {
		Config("MS_MAINTENANCE_MODE", FALSE);
	}
	if (@$_SESSION["new2023_appset"][0]["Maintenance_Finish_DateTime"]!="") {
		Config("MS_MAINTENANCE_END_DATETIME", $_SESSION["new2023_appset"][0]["Maintenance_Finish_DateTime"]);        
	} else {
		Config("MS_MAINTENANCE_END_DATETIME", "");
	}
	if (@$_SESSION["new2023_appset"][0]["Auto_Normal_After_Maintenance"]=="Y") {
		Config("MS_AUTO_NORMAL_AFTER_MAINTENANCE", TRUE);
	} else {
		Config("MS_AUTO_NORMAL_AFTER_MAINTENANCE", FALSE);      
	}

	// Begin of modification Announcement in All Pages, by Masino Sinaga, May 12, 2012   
	if (Config("MS_SHOW_ANNOUNCEMENT")) {
	  if (Config("MS_SEPARATED_ANNOUNCEMENT")) {
		$sSqla = "SELECT * FROM ".Config("MS_ANNOUNCEMENT_TABLE")." WHERE Is_Active = 'Y' AND Auto_Publish = 'Y' AND Language = '".CurrentLanguageID()."'";
		$rsa = ExecuteQuery($sSqla, "DB");
		if ($rsa->rowCount() > 0) {
			$today_begin = CurrentDateTime(); // date('Y-m-d')." 00:00:01";
			$today_end = CurrentDateTime(); // date('Y-m-d')." 23:59:59";
			$sTranslatedID = "";
			$sIDAnnouncement = "";
			$sAnnouncement = "";
			while ($row = $rsa->fetch()) {
				$sIDAnnouncement = $row["Announcement_ID"];
				if ($row["Translated_ID"] == $sIDAnnouncement) {
					$sTranslatedID = $row["Announcement_ID"];
					ExecuteUpdate("UPDATE ".Config("MS_ANNOUNCEMENT_TABLE")." SET Is_Active = 'N' WHERE Translated_ID <> " . $sIDAnnouncement . " OR Announcement_ID <> " . $sIDAnnouncement); // reset all become Not Active
				} else {
					$sTranslatedID = $row["Translated_ID"];
				}
				$sAnnouncement = $row["Message"];
				if (IsDateBetweenTwoDates($today_begin, $today_end, $row["Date_Start"], $row["Date_End"])) {
					$sIDAnnouncement = $row["Announcement_ID"];
					ExecuteUpdate("UPDATE ".Config("MS_ANNOUNCEMENT_TABLE")." SET Is_Active = 'Y' WHERE Announcement_ID = ".$sIDAnnouncement." OR Translated_ID = ".$sIDAnnouncement); // set Active for the current published announcement
				}
			}
			Config("MS_ANNOUNCEMENT_TEXT", $sAnnouncement);
		} else {
			Config("MS_ANNOUNCEMENT_TEXT", "");
		}
	  } else {
		$sSqll = "SELECT Announcement_Text FROM ".Config("MS_LANGUAGES_TABLE")." WHERE Language_Code = '".CurrentLanguageID()."'";
		$val = ExecuteScalar($sSqll);
		Config("MS_ANNOUNCEMENT_TEXT", $val);
	  }
	}
	// End of modification Announcement in All Pages, by Masino Sinaga, May 12, 2012

	// Begin of modification Maintenance Mode, by Masino Sinaga, May 12, 2012    
	if (Config("MS_MAINTENANCE_MODE")==TRUE) {
		$date_now = date("Y-m-d H:i:s");
		$date_end = Config("MS_MAINTENANCE_END_DATETIME");
		$cssfile = '<link rel="stylesheet" type="text/css" href="adminlte32/css/adminlte.css?v=1666171579">';
		$cssfile .= '<link rel="stylesheet" href="adminlte32/css/font-opensans.css?v=1666171579">';
		if (!$Security->isAdmin()) {
			if ((CurrentPageName()!="index") && (CurrentPageName()!="logout") && (CurrentPageName()!="login")) {
				if ($date_end != "") { // Assuming end of maintenance date/time is valid
					if ($date_end<=$date_now) {
						if (Config("MS_AUTO_NORMAL_AFTER_MAINTENANCE")==TRUE) {
							// Normal mode here, nothing to do here; just give your user an access!
						} else {
							// Still in maintenance mode, and end of date/time not reached yet, even Auto Normal is False
							echo '<head><title>'.$Language->phrase("MaintenanceTitle").'</title>';
							echo $cssfile;
							echo '</head>';
							echo '<div class="alert alert-danger">'.JsEncode($Language->phrase("MaintenanceUserMessageUnknown")).' <br><a href="logout">'.$Language->phrase("GoBack").'</a></div>';
							exit;
						}
					} else {
						// Still in maintenance mode, even end of date/time has been reached
						echo '<head><title>'.$Language->phrase("MaintenanceTitle").'</title>';
						echo $cssfile;
						echo '</head>';
						echo '<div class="alert alert-danger">'.JsEncode($Language->phrase("MaintenanceUserMessage")).' '.Duration(date("Y-m-d H:i:s"), $date_end).'<br><a href="logout">'.$Language->phrase("GoBack").'</a></div>';
						exit;
					}
				} else {
					// Still in maintenance mode, the date/time value is blank!
					echo '<head><title>'.$Language->phrase("MaintenanceTitle").'</title>';
					echo $cssfile;
					echo '</head>';
					echo '<div class="alert alert-danger">'.JsEncode($Language->phrase("MaintenanceUserMessageUnknown")).' <br><a href="logout">'.$Language->phrase("GoBack").'</a></div>';
					exit;                
				}
			} else {
				// DO NOTHING HERE !!!                
				if ($date_end != "") { // Assuming end of maintenance date/time is valid
					if ($date_end<=$date_now) {
						if (Config("MS_AUTO_NORMAL_AFTER_MAINTENANCE")==TRUE) {
							Config("MS_MAINTENANCE_TEXT", JsEncode($Language->phrase("MaintenanceUserMessageUnknown")).' &nbsp;<a href="logout">'.$Language->phrase("GoBack").'</a>');

							// Normal mode here, just give your user an access!
						} else {
							// Still in maintenance mode, and end of date/time not reached yet, even Auto Normal is False
							Config("MS_MAINTENANCE_TEXT", JsEncode($Language->phrase("MaintenanceUserMessageUnknown")).' &nbsp;<a href="logout">'.$Language->phrase("GoBack").'</a>');
						}
					} else {
						// Still in maintenance mode, even end of date/time has been reached
						Config("MS_MAINTENANCE_TEXT", JsEncode($Language->phrase("MaintenanceUserMessage")).' '.Duration(date("Y-m-d H:i:s"), $date_end).'&nbsp;&nbsp;<a href="logout">'.$Language->phrase("GoBack").'</a>');
					}
				} else {
					// Still in maintenance mode, the date/time value is blank!
					Config("MS_MAINTENANCE_TEXT", JsEncode($Language->phrase("MaintenanceUserMessageUnknown")).' &nbsp;&nbsp;<a href="logout">'.$Language->phrase("GoBack").'</a>');
				}                
			}
		} else {  // Start from here, Maintenance Mode for Admin!
			if ((CurrentPageName()!="index") && (CurrentPageName()!="logout") && (CurrentPageName()!="login")) {
				if ($date_end != "") { // Assuming end of maintenance date/time is valid
					if ($date_end<=$date_now) {
						if (Config("MS_AUTO_NORMAL_AFTER_MAINTENANCE")==TRUE) {
							Config("MS_MAINTENANCE_TEXT", JsEncode($Language->phrase("MaintenanceUserMessageError")).' &nbsp;<a href="logout">'.$Language->phrase("GoBack").'</a>');
						} else {
						  // We are using this, in order to avoid the css conflict, so we use constant help just for admin!
						  Config("MS_MAINTENANCE_TEXT", JsEncode($Language->phrase("MaintenanceAdminMessageUnknown")).' ');
						}
					} else {
						// We are using this, in order to avoid the css conflict, so we use constant help just for admin!
						// Show the remaining time to admin!
						Config("MS_MAINTENANCE_TEXT", JsEncode($Language->phrase("MaintenanceAdminMessage")).' '.Duration(date("Y-m-d H:i:s"), $date_end).'&nbsp;&nbsp;<a href="logout">'.$Language->phrase("GoBack").'</a>');
					}
				} else {
					// We are using this, in order to avoid the css conflict, so we use constant help just for admin!
					Config("MS_MAINTENANCE_TEXT", JsEncode($Language->phrase("MaintenanceAdminMessageUnknown")).' ');
				}
			}
		}
	}
	// End of modification Maintenance Mode, by Masino Sinaga, May 12, 2012
}

// Begin of modification How Long User Should be Allowed Login in the Messages When Failed Login Exceeds the Maximum Limit, by Masino Sinaga, May 12, 2012
function CurrentDateTime_Add_Minutes($currentdate, $minute) {
  $timestamp = strtotime("$currentdate");
  $addtime = strtotime("+$minute minutes", $timestamp);
  $next_time = date('Y-m-d H:i:s', $addtime);
  return $next_time;
}

function DurationFromSeconds($iSeconds) {
	/**
	* Convert number of seconds into years, days, hours, minutes and seconds
	* and return an string containing those values
	*
	* @param integer $seconds Number of seconds to parse
	* @return string
	*/
	global $Language;
	$y = floor($iSeconds / (86400*365.25));
	$d = floor(($iSeconds - ($y*(86400*365.25))) / 86400);
	$h = gmdate('H', $iSeconds);
	$m = gmdate('i', $iSeconds);
	$s = gmdate('s', $iSeconds);
	$string = '';
	if($y > 0)
		$string .= intval($y) . " " . $Language->phrase("years")." ";
	if($d > 0) 
		$string .= intval($d) . " " . $Language->phrase("days")." ";
	if($h > 0) 
		$string .= intval($h) . " " . $Language->phrase("hours")." ";
	if($m > 0) 
		$string .= intval($m) . " " . $Language->phrase("minutes")." ";
	if($s > 0) 
		$string .= intval($s) . " " . $Language->phrase("seconds")." ";
	return preg_replace('/\s+/',' ',$string);
}

function Duration($parambegindate, $paramenddate) {
  global $Language;
  $begindate = strtotime($parambegindate);  
  $enddate = strtotime($paramenddate);
  $diff = intval($enddate) - intval($begindate);
  $diffday = intval(floor($diff/86400));                                      
  $modday = ($diff%86400);  
  $diffhour = intval(floor($modday/3600));  
  $diffminute = intval(floor(($modday%3600)/60));  
  $diffsecond = ($modday%60);  
  if ($diffday!=0 && $diffhour!=0 && $diffminute!=0 && $diffsecond==0) {
    return round($diffday)." ".$Language->phrase('days').        
    ", ".round($diffhour)." ".$Language->phrase('hours').        
    ", ".round($diffminute,0)." ".$Language->phrase('minutes');
  } elseif ($diffday!=0 && $diffhour==0 && $diffminute!=0 && $diffsecond!=0) {
    return round($diffday)." ".$Language->phrase('days').        
    ", ".round($diffminute)." ".$Language->phrase('minutes').        
    ", ".round($diffsecond,0)." ".$Language->phrase('seconds');
  } elseif ($diffday!=0 && $diffhour!=0 && $diffminute==0 && $diffsecond==0) {
    return round($diffday)." ".$Language->phrase('days').        
    ", ".round($diffhour)." ".$Language->phrase('hours');
  } elseif ($diffday!=0 && $diffhour==0 && $diffminute!=0 && $diffsecond==0) {
    return round($diffday)." ".$Language->phrase('days').        
    ", ".round($diffminute,0)." ".$Language->phrase('minutes');
  } elseif ($diffday!=0 && $diffhour==0 && $diffminute==0 && $diffsecond!=0) {
    return round($diffday)." ".$Language->phrase('days').        
    ", ".round($diffsecond,0)." ".$Language->phrase('seconds');	
  } elseif ($diffday!=0 && $diffhour==0 && $diffminute==0 && $diffsecond==0) {
    return round($diffday)." ".$Language->phrase('days');
  }	elseif ($diffday==0 && $diffhour!=0 && $diffminute!=0 && $diffsecond!=0) {
    return round($diffhour)." ".$Language->phrase('hours').
    ", ".round($diffminute,0)." ".$Language->phrase('minutes').
    ", ".round($diffsecond,0)." ".$Language->phrase('seconds')."";
  } elseif ($diffday==0 && $diffhour!=0 && $diffminute==0 && $diffsecond==0) {
    return round($diffhour)." ".$Language->phrase('hours');
  } elseif ($diffday==0 && $diffhour!=0 && $diffminute!=0 && $diffsecond==0) {
    return round($diffhour)." ".$Language->phrase('hours').
    ", ".round($diffminute,0)." ".$Language->phrase('minutes');
  } elseif ($diffday==0 && $diffhour==0 && $diffminute!=0 && $diffsecond==0) {   
    return round($diffminute,0)." ".$Language->phrase('minutes');	
  } elseif ($diffday==0 && $diffhour==0 && $diffminute!=0 && $diffsecond!=0) {   
    return round($diffminute,0)." ".$Language->phrase('minutes').
    ", ".round($diffsecond,0)." ".$Language->phrase('seconds')."";
  } elseif ($diffday==0 && $diffhour==0 && $diffminute==0 && $diffsecond!=0) {   
    return round($diffsecond,0)." ".$Language->phrase('seconds')."";   
  } else {
    return round($diffday)." ".$Language->phrase('days').        
    ", ".round($diffhour)." ".$Language->phrase('hours').        
    ", ".round($diffminute,0)." ".$Language->phrase('minutes').        
    ", ".round($diffsecond,0)." ".$Language->phrase('seconds')."";
  }
}

// End of modification How Long User Should be Allowed Login in the Messages When Failed Login Exceeds the Maximum Limit, by Masino Sinaga, May 12, 2012
function GetIntersectTwoDatesEditMode($iID, $sDateCheckBegin, $sDateCheckEnd, $sLang) {
	$sResult = "";
	$sSql = "SELECT Announcement_ID, Date_Start, Date_End
			FROM " . Config("MS_ANNOUNCEMENT_TABLE") . " 
			WHERE Date_Start <> '' 
			AND Date_End <> '' 
			AND Announcement_ID <> ".$iID." 
			AND Language = '".$sLang."'";
	$rs = ExecuteQuery($sSql, "DB");
	if ($rs->rowCount() > 0) {
		while ($row = $rs->fetch()) {
			$sDateCheckBegin = substr($sDateCheckBegin, 0, 10);
			$sDateCheckEnd = substr($sDateCheckEnd, 0, 10);
			$arrDates1 = GetAllDatesFromTwoDates($sDateCheckBegin, $sDateCheckEnd); 
			$sDateBegin = substr($row["Date_Start"], 0, 10);
			$sDateEnd = substr($row["Date_End"], 0, 10);
			$arrDates2 = GetAllDatesFromTwoDates($sDateBegin, $sDateEnd);
			$result = array_intersect($arrDates1, $arrDates2);
			if ( (count($result)>0) && ($row["Announcement_ID"] != $iID) ) {
				$sResult .= $row["Announcement_ID"]."#";
				foreach($result as $key => $value){ 
					$sResult .= $value.", ";
				} 
				unset($value);
				$sResult = trim($sResult, ", ");
				return $sResult;
			}
		}
	}
    return $sResult;
}

function UpdateDatesInOtherLanguage($sDateBegin, $sDateEnd, $iID) {
	$sResult = "";
	$sSql = "UPDATE " . Config("MS_ANNOUNCEMENT_TABLE") . " 
			SET Date_Start = '".$sDateBegin."',
			Date_End = '".$sDateEnd."' 
			WHERE Translated_ID = ".$iID;
	ExecuteUpdate($sSql, "DB");
}

function GetAllDatesFromTwoDates($fromDate, $toDate)
{
    if(!$fromDate || !$toDate ) {return false;}
    $dateMonthYearArr = array();
    $fromDateTS = strtotime($fromDate);
    $toDateTS = strtotime($toDate);
    for ($currentDateTS = $fromDateTS; $currentDateTS <= $toDateTS; $currentDateTS += (60 * 60 * 24))
    {
        $currentDateStr = date("Y-m-d",$currentDateTS);
        $dateMonthYearArr[] = $currentDateStr;
    }
    return $dateMonthYearArr;
}

function IsDateBetweenTwoDates($sDateCheckBegin, $sDateCheckEnd, $sDateBegin, $sDateEnd) {
    $dDate1 = strtotime($sDateCheckBegin);
    $dDate2 = strtotime($sDateCheckEnd);
    if ( ($dDate1 >= strtotime($sDateBegin)) && ($dDate2 <= strtotime($sDateEnd)) ) {
        return TRUE;    
    } else {
        return FALSE;    
    }  
}

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression, $dbid = 0)
{
    $today = getdate();
    $lastmonth = mktime(0, 0, 0, $today['mon'] - 1, 1, $today['year']);
    $val = date("Y|m", $lastmonth);
    $wrk = $FldExpression . " BETWEEN " .
        QuotedValue(DateValue("month", $val, 1, $dbid), DATATYPE_DATE, $dbid) .
        " AND " .
        QuotedValue(DateValue("month", $val, 2, $dbid), DATATYPE_DATE, $dbid);
    return $wrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression, $dbid = 0)
{
    return $FldExpression . Like("'A%'", $dbid);
}

// Global user functions
// Database Connecting event
function Database_Connecting(&$info)
{
   if (CurrentUserIP() == "127.0.0.1") { // setting koneksi database di komputer localhost
        $info["host"] = "localhost";
        $info["user"] = "root"; // sesuaikan dengan username database di komputer localhost
        $info["pass"] = ""; // sesuaikan dengan password database di komputer localhost
        $info["db"] = "db_newsimpel"; // sesuaikan dengan nama database di komputer localhost
    } else { // setting koneksi database untuk komputer server
        $info["host"] = "simpel.uncen.ac.id";  // sesuaikan dengan ip address atau hostname komputer server
        $info["user"] = "simpeluncenac_john"; // sesuaikan dengan username database di komputer server
        $info["pass"] = "GJ3s@nq2V7pG"; // sesuaikan deengan password database di komputer server
        $info["db"] = "simpeluncenac_23"; // sesuaikan dengan nama database di komputer server
    }
}

// Database Connected event
function Database_Connected(&$conn)
{
    // Example:
    //if ($conn->info["id"] == "DB") {
    //    $conn->executeQuery("Your SQL");
    //}
}

function MenuItem_Adding($item)
{
    //var_dump($item);
    // Return false if menu item not allowed
    return true;
}

function Menu_Rendering($menu)
{
    // Change menu items here
}

function Menu_Rendered($menu)
{
    // Clean up here
}

// Page Loading event
function Page_Loading()
{
    //Log("Page Loading");
}

// Page Rendering event
function Page_Rendering()
{
    if (IsLoggedIn()) {
        if (!IsAdmin()) {
            Config("MS_USER_CARD_USER_NAME", CurrentUserName());
            Config("MS_USER_CARD_COMPLETE_NAME", CurrentUserInfo("First_Name") . " " . CurrentUserInfo("Last_Name"));
		    Config("MS_USER_CARD_POSITION", Security()->currentUserLevelName());
        } else {
            Config("MS_USER_CARD_USER_NAME", CurrentUserName());
		    Config("MS_USER_CARD_COMPLETE_NAME", "Administrator");
		    Config("MS_USER_CARD_POSITION", Security()->currentUserLevelName());
        }
	}
}

// Page Unloaded event
function Page_Unloaded()
{
    //Log("Page Unloaded");
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew)
{
    //var_dump($rsnew);
    return true;
}

// Personal Data Downloading event
function PersonalData_Downloading(&$row)
{
    //Log("PersonalData Downloading");
}

// Personal Data Deleted event
function PersonalData_Deleted($row)
{
    //Log("PersonalData Deleted");
}

// One Time Password Sending event
function Otp_Sending($usr, $client)
{
    // Example:
    // var_dump($usr, $client); // View user and client (Email or Sms object)
    // if (SameText(Config("TWO_FACTOR_AUTHENTICATION_TYPE"), "email")) { // Possible values, email or sms
    //     $client->Content = ...; // Change content
    //     $client->Recipient = ...; // Change recipient
    //     // return false; // Return false to cancel
    // }
    return true;
}

// Route Action event
function Route_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// API Action event
function Api_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// Container Build event
function Container_Build($builder)
{
    // Example:
    // $builder->addDefinitions([
    //    "myservice" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService();
    //    },
    //    "myservice2" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService2();
    //    }
    // ]);
}

function GetNextKodePenelitian() {
    $sNextKode = "";
    $sLastKode = "";
    $value = ExecuteScalar("SELECT Id_Kelompok FROM kelompok_penelitian ORDER BY Id_Kelompok DESC");
    if ($value != "") { // jika sudah ada, langsung ambil dan proses...
        $sLastKode = intval(substr($value, 3, 3)); // ambil 3 digit terakhir
        $sLastKode = intval($sLastKode) + 1; // konversi ke integer, lalu tambahkan satu
        $sNextKode = "PLT" . sprintf('%03s', $sLastKode); // format hasilnya dan tambahkan prefix
        if (strlen($sNextKode) > 6) {
            $sNextKode = "PLT999";
        }
    } else { // jika belum ada, gunakan kode yang pertama
        $sNextKode = "PLT001";
    }
    return $sNextKode;
}

function GetNextKodePengabdian() {
    $sNextKode2 = "";
    $sLastKode2 = "";
    $value = ExecuteScalar("SELECT Id_Kelompok FROM kelompok_pengabdian ORDER BY Id_Kelompok DESC");
    if ($value != "") { // jika sudah ada, langsung ambil dan proses...
        $sLastKode2 = intval(substr($value, 3, 3)); // ambil 3 digit terakhir
        $sLastKode2 = intval($sLastKode2) + 1; // konversi ke integer, lalu tambahkan satu
        $sNextKode2 = "PGD" . sprintf('%03s', $sLastKode2); // format hasilnya dan tambahkan prefix
        if (strlen($sNextKode2) > 6) {
            $sNextKode2 = "PGD999";
        }
    } else { // jika belum ada, gunakan kode yang pertama
        $sNextKode2 = "PGD001";
    }
    return $sNextKode2;
}
