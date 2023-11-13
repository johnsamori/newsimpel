<?php

namespace PHPMaker2023\new2023;

// Page object
$Loadaboutus = &$Page;
?>
<?php
$val = ExecuteScalar("SELECT About_Text FROM " . Config("MS_LANGUAGE_TABLE_NAME") . " WHERE Language_Code = '".Language()->LanguageId . "'");
if (!empty($val)) {
	echo $val;
} else {
	echo Language()->phrase('AboutUsNotAvailable');
}
?>
<?php
echo GetDebugMessage();
?>
