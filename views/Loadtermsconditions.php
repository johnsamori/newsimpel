<?php

namespace PHPMaker2023\new2023;

// Page object
$Loadtermsconditions = &$Page;
?>
<?php
$val = ExecuteScalar("SELECT Terms_And_Condition_Text FROM " . Config("MS_LANGUAGE_TABLE_NAME") . " WHERE Language_Code = '".Language()->LanguageId . "'");
if (!empty($val)) {
	echo $val;
} else {
	echo $Language->phrase('TermsConditionsNotAvailable');
}
?>
<?php
echo GetDebugMessage();
?>
