<?php

namespace PHPMaker2023\new2023;

// Page object
$Loadhelponline = &$Page;
?>
<?php
if (!empty(Get("page"))) {
	$row = ExecuteRow("SELECT Topic, Description FROM " . Config("MS_HELP_TABLE_NAME") . " WHERE Display_In_Page = '".$_GET['page'] . "' AND Language = '" . CurrentLanguageID() . "'");
	if (!empty($row)) {
		echo "" . $row["Topic"] . "~~~" . $row["Description"];
	} else {
		echo "" . Language()->phrase('Help') . "~~~" . Language()->phrase('HelpNotAvailable');
	}
} else {
	echo "" . Language()->phrase('Help') . "~~~" . Language()->phrase('HelpNotAvailable');
}
?>
<?php
echo GetDebugMessage();
?>
