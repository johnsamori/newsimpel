<?php

namespace PHPMaker2023\new2023;

// Page object
$Visitorstatistics = &$Page;
?>
<?php
	$user_ip = GetUserIPAddress(); // getenv("REMOTE_ADDR"); // <-- old way, don't use it!!!

	//$user_host = gethostname(); // <-- PHP >= 5.3.0 // php_uname('n');  // <-- PHP 4 >= 4.0.2, PHP 5  // getenv("REMOTE_HOST"); // <-- PHP < 4.0.2
	$user_host = "";
	if (version_compare(phpversion(), '5.3.5', '>=')) {
		$user_host = gethostname();
	} elseif (version_compare(phpversion(), '4.2.0', '>=')) {
		$user_host = php_uname('n');
	} else {
		$user_host = getenv('HOSTNAME'); 
		if(!$user_host) $user_host = trim(`hostname`); 
		if(!$user_host) $user_host = exec('echo $HOSTNAME');
		if(!$user_host) $user_host = preg_replace('#^\w+\s+(\w+).*$#', '$1', exec('uname -a'));
	}
	if ( IsLogEmpty($user_ip) == TRUE ) {
		AddLog($user_ip, $user_host);
	} else {
		UpdateCounterLog($user_ip, $user_host);
	}

	/* Get the Browser data */
	if ((@preg_match("/Nav/", $_SERVER["HTTP_USER_AGENT"])) || (@preg_match("/Gold/", $_SERVER["HTTP_USER_AGENT"])) || (@preg_match("/X11/", $_SERVER["HTTP_USER_AGENT"])) || (@preg_match("/Mozilla/", $_SERVER["HTTP_USER_AGENT"])) || (@preg_match("/Safari/", $_SERVER["HTTP_USER_AGENT"])) AND (!@preg_match("/MSIE/", $_SERVER["HTTP_USER_AGENT"])) AND (!@preg_match("/Konqueror/", $_SERVER["HTTP_USER_AGENT"])) AND (!@preg_match("/Yahoo/", $_SERVER["HTTP_USER_AGENT"])) AND (!@preg_match("/Firefox/", $_SERVER["HTTP_USER_AGENT"])) AND (!@preg_match("/Chrome/", $_SERVER["HTTP_USER_AGENT"]))) $browser = "Safari";
	elseif(@preg_match("/Chrome/", $_SERVER["HTTP_USER_AGENT"])) $browser = "Chrome";
	elseif(@preg_match("/Firefox/", $_SERVER["HTTP_USER_AGENT"])) $browser = "FireFox";
	elseif(@preg_match("/MSIE/", $_SERVER["HTTP_USER_AGENT"])) $browser = "MSIE";
	elseif(@preg_match("/Lynx/", $_SERVER["HTTP_USER_AGENT"])) $browser = "Lynx";
	elseif(@preg_match("/Opera/", $_SERVER["HTTP_USER_AGENT"])) $browser = "Opera";
	elseif(@preg_match("/WebTV/", $_SERVER["HTTP_USER_AGENT"])) $browser = "WebTV";
	elseif(@preg_match("/Konqueror/", $_SERVER["HTTP_USER_AGENT"])) $browser = "Konqueror";
	elseif((stristr("bot", $_SERVER["HTTP_USER_AGENT"])) || (@preg_match("/Google/", $_SERVER["HTTP_USER_AGENT"])) || (@preg_match("/Slurp/", $_SERVER["HTTP_USER_AGENT"])) || (@preg_match("/Scooter/", $_SERVER["HTTP_USER_AGENT"])) || (stristr("Spider", $_SERVER["HTTP_USER_AGENT"])) || (stristr("Infoseek", $_SERVER["HTTP_USER_AGENT"]))) $browser = "Bot";
	else $browser = "Other";

	/* Get the Operating System data */
	if(@preg_match("/Win/", $_SERVER["HTTP_USER_AGENT"])) $os = "Windows";
	elseif((@preg_match("/Mac/", $_SERVER["HTTP_USER_AGENT"])) || (@preg_match("/PPC/", $_SERVER["HTTP_USER_AGENT"]))) $os = "Mac";
	elseif(@preg_match("/Linux/", $_SERVER["HTTP_USER_AGENT"])) $os = "Linux";
	elseif(@preg_match("/FreeBSD/", $_SERVER["HTTP_USER_AGENT"])) $os = "FreeBSD";
	elseif(@preg_match("/SunOS/", $_SERVER["HTTP_USER_AGENT"])) $os = "SunOS";
	elseif(@preg_match("/IRIX/", $_SERVER["HTTP_USER_AGENT"])) $os = "IRIX";
	elseif(@preg_match("/BeOS/", $_SERVER["HTTP_USER_AGENT"])) $os = "BeOS";
	elseif(@preg_match("/OS\/2/", $_SERVER["HTTP_USER_AGENT"])) $os = "OS/2";
	elseif(@preg_match("/AIX/", $_SERVER["HTTP_USER_AGENT"])) $os = "AIX";
	else $os = "Other";

	/* Save on the databases the obtained values */
	$rs = ExecuteStatement("UPDATE ". MS_STATS_COUNTER_TABLE . " SET Counter = Counter + 1 WHERE (Type = 'total' AND Variable = 'hits') OR (Variable = '".$browser."' AND Type = 'browser') OR (Variable = '".$os."' AND Type = 'os')", "DB");

	/* Start Detailed Statistics */
	$dot = date("d-m-Y-H");
	$now = explode ("-",$dot);
	$nowHour = $now[3];
	$nowYear = $now[2];
	$nowMonth = $now[1];
	$nowDate = $now[0];
	$sql = "SELECT Year FROM " . MS_STATS_YEAR_TABLE . " WHERE Year = ".$nowYear."";
	$resultYear = ExecuteScalar($sql, "DB");
	if (!empty($resultYear)) {
	} else {
		//if ($RecCount <= 0) {
			$sql = "INSERT INTO " . MS_STATS_YEAR_TABLE . " VALUES (".$nowYear.", 0)";
			$rs = ExecuteStatement($sql, "DB");
			for ($i = 1; $i <= 12; $i++) {
				$rs = ExecuteStatement("INSERT INTO " . MS_STATS_MONTH_TABLE . " VALUES (".$nowYear.", ".$i.", 0)", "DB");
				if ($i == 1) $TotalDay = 31;
				if ($i == 2) {
					if (date("L") == true) {
						$TotalDay = 29;
					} else {
						$TotalDay = 28;
					}
				}
				if ($i == 3) $TotalDay = 31;
				if ($i == 4) $TotalDay = 30;
				if ($i == 5) $TotalDay = 31;
				if ($i == 6) $TotalDay = 30;
				if ($i == 7) $TotalDay = 31;
				if ($i == 8) $TotalDay = 31;
				if ($i == 9) $TotalDay = 30;
				if ($i == 10) $TotalDay = 31;
				if ($i == 11) $TotalDay = 30;
				if ($i == 12) $TotalDay = 31;
				for ($k = 1; $k <= $TotalDay; $k++) {
					$rs = ExecuteStatement("INSERT INTO " . MS_STATS_DATE_TABLE . " VALUES (".$nowYear.", ".$i.", ".$k.", 0)", "DB");
				}
			}
		//}
	}
	$sql = "SELECT Hour FROM " . MS_STATS_HOUR_TABLE . " WHERE (Year = ".$nowYear.") AND (Month = ".$nowMonth.") AND (Date = ".$nowDate.") ORDER BY Hour DESC";
	$resultHour = ExecuteScalar($sql, "DB");
	if (!empty($resultHour)) {
	} else {
		//if ($resultHour <= 0) {
			for ($i = 0; $i <= 23; $i++) {
				$rs = ExecuteStatement("INSERT INTO " . MS_STATS_HOUR_TABLE . " VALUES (".$nowYear.", ".$nowMonth.", ".$nowDate.", ".$i.", 0)", "DB");
			}
		//}
	}
	$rs = ExecuteStatement("UPDATE " . MS_STATS_YEAR_TABLE . " SET Hits = Hits + 1 WHERE Year = ".$nowYear."", "DB");
	$rs = ExecuteStatement("UPDATE " . MS_STATS_MONTH_TABLE . " SET Hits = Hits + 1 WHERE (Year = ".$nowYear.") AND (Month = ".$nowMonth.")", "DB");
	$rs = ExecuteStatement("UPDATE " . MS_STATS_DATE_TABLE . " SET Hits = Hits + 1 WHERE (Year = ".$nowYear.") AND (Month = ".$nowMonth.") AND (Date = ".$nowDate.")", "DB");
	$rs = ExecuteStatement("UPDATE " . MS_STATS_HOUR_TABLE . " SET Hits = Hits + 1 WHERE (Year = ".$nowYear.") AND (Month = ".$nowMonth.") AND (Date = ".$nowDate.") AND (Hour = ".$nowHour.")", "DB");
?>
<?php
echo GetDebugMessage();
?>
