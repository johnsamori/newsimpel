<?php

namespace PHPMaker2023\new2023;

// Page object
$Register = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { users: currentTable } });
var currentPageID = ew.PAGE_ID = "register";
var currentForm;
var fregister;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fregister")
        .setPageId("register")

        // Add fields
        .setFields([
            ["_Username", [fields._Username.visible && fields._Username.required ? ew.Validators.required(fields._Username.caption) : null, ew.Validators.username(fields._Username.raw)], fields._Username.isInvalid],
            ["c__Password", [ew.Validators.required(ew.language.phrase("ConfirmPassword")), ew.Validators.mismatchPassword], fields._Password.isInvalid],
            ["_Password", [fields._Password.visible && fields._Password.required ? ew.Validators.required(fields._Password.caption) : null, ew.Validators.passwordStrength, ew.Validators.password(fields._Password.raw)], fields._Password.isInvalid],
            ["First_Name", [fields.First_Name.visible && fields.First_Name.required ? ew.Validators.required(fields.First_Name.caption) : null], fields.First_Name.isInvalid],
            ["Last_Name", [fields.Last_Name.visible && fields.Last_Name.required ? ew.Validators.required(fields.Last_Name.caption) : null], fields.Last_Name.isInvalid],
            ["_Email", [fields._Email.visible && fields._Email.required ? ew.Validators.required(fields._Email.caption) : null, ew.Validators.email], fields._Email.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fregister" id="fregister" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="t" value="users">
<?php if ($Page->isConfirm()) { // Confirm page ?>
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="confirm" id="confirm" value="confirm">
<?php } else { ?>
<input type="hidden" name="action" id="action" value="confirm">
<?php // Begin of added to handle confirmation dialog not showing in masinoew.js by Masino Sinaga, September 25, 2022 ?>
<input type="hidden" name="confirm" id="confirm" value="">
<?php // End of added to handle confirmation dialog not showing in masinoew.js by Masino Sinaga, September 25, 2022 ?>
<?php } ?>
<?php // Begin of modification Terms and Conditions, by Masino Sinaga, July 14, 2014 ?>
<?php if (MS_SHOW_TERMS_AND_CONDITIONS_ON_REGISTRATION_PAGE == true) { ?>
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<?php
global $Language;
$val = ExecuteScalar("SELECT Terms_And_Condition_Text FROM " . Config("MS_LANGUAGE_TABLE_NAME") . " WHERE Language_Code = '".$Language->LanguageId . "'");
if (!empty($val)) {
	$taccontent = $val;
} else {
	$taccontent = $Language->phrase('TermsConditionsNotAvailable');
}
$taccontent = str_replace("<br>", "\n", $taccontent);
$taccontent = str_replace("<br />", "\n", $taccontent);
$taccontent = strip_tags($taccontent);
?>
<div class="form-group" id="r_Title">
	<div class="col-sm-12">
	<?php echo "<h4>" . $Language->phrase('TermsConditionsTitle') . "</h4>" ?>
	</div>
</div>
<?php if (MS_HIDE_TEXT_TERMS_ON_REGISTRATION_PAGE == false) { ?>
<div class="form-group" id="r_TAC">
	<div class="col-sm-12">
		<textarea class="form-control ew-control" id="tactextarea" readonly style="min-width:100%; max-width: 400px; max-height:400px; min-height:300px;"><?php echo $taccontent; ?></textarea>
	</div>
</div>
<?php } ?>
<?php if (MS_TERMS_AND_CONDITION_CHECKBOX_ON_REGISTER_PAGE == true) { ?>
<div class="form-group" id="r_ChkTerms">
	<div class="col-sm-12">
		<label>
			<span class="kt-switch">
				<?php $selwrk = (@isset($_POST["chkterms"])) ? " checked='checked'" : ""; ?>
				<div class="form-check form-switch d-inline-block" style="vertical-align: middle;">
				<input type="checkbox" class="form-check-input" name="chkterms" id="chkterms" value="<?php echo @$_POST["chkterms"]; ?>" <?php echo $selwrk; ?>>
				</div>
				<label class="col-form-label" for="chkterms">
				&nbsp;<?php echo $Language->phrase("IAgreeWith"); ?>&nbsp;<a href="javascript:void(0);" id="tac" onclick="getTermsConditions();return false;"><?php echo $Language->phrase("TermsConditionsTitle"); ?></a>&nbsp;[ <a href="printtermsconditions" title="<?php echo $Language->phrase("Print"); ?>&nbsp;<?php echo $Language->phrase("TermsConditionsTitle"); ?>"><?php echo Language()->phrase("Print"); ?></a> ]
				</label>
			</span>
		</label>
	</div>
</div>
<?php } ?>
<div class="form-group" id="r_btnAction">
	<div class="col-sm-12">
	</div>
</div>
<?php } ?>
<?php } // MS_SHOW_TERMS_AND_CONDITIONS_ON_REGISTRATION_PAGE ?>
<?php // End of modification Terms and Conditions, by Masino Sinaga, July 14, 2014 ?>
<?php if (!$Page->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($Page->IsMobileOrModal) { ?>
<div class="ew-register-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_register" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->_Username->Visible) { // Username ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r__Username"<?= $Page->_Username->rowAttributes() ?>>
        <label id="elh_users__Username" for="x__Username" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Username->caption() ?><?= $Page->_Username->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_Username->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_users__Username">
<input type="<?= $Page->_Username->getInputTextType() ?>" name="x__Username" id="x__Username" data-table="users" data-field="x__Username" value="<?= $Page->_Username->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_Username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Username->formatPattern()) ?>"<?= $Page->_Username->editAttributes() ?> aria-describedby="x__Username_help">
<?= $Page->_Username->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Username->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_users__Username">
<span<?= $Page->_Username->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_Username->getDisplayValue($Page->_Username->ViewValue))) ?>"></span>
<input type="hidden" data-table="users" data-field="x__Username" data-hidden="1" name="x__Username" id="x__Username" value="<?= HtmlEncode($Page->_Username->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r__Username"<?= $Page->_Username->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users__Username"><?= $Page->_Username->caption() ?><?= $Page->_Username->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->_Username->cellAttributes() ?>> 
<?php if (!$Page->isConfirm()) { ?>
<span id="el_users__Username">
<input type="<?= $Page->_Username->getInputTextType() ?>" name="x__Username" id="x__Username" data-table="users" data-field="x__Username" value="<?= $Page->_Username->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->_Username->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Username->formatPattern()) ?>"<?= $Page->_Username->editAttributes() ?> aria-describedby="x__Username_help">
<?= $Page->_Username->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Username->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_users__Username">
<span<?= $Page->_Username->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_Username->getDisplayValue($Page->_Username->ViewValue))) ?>"></span>
<input type="hidden" data-table="users" data-field="x__Username" data-hidden="1" name="x__Username" id="x__Username" value="<?= HtmlEncode($Page->_Username->FormValue) ?>">
</span>
<?php } ?>
 </td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->_Password->Visible) { // Password ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r__Password"<?= $Page->_Password->rowAttributes() ?>>
        <label id="elh_users__Password" for="x__Password" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Password->caption() ?><?= $Page->_Password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_Password->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_users__Password">
<div class="input-group" id="ig__Password">
    <input type="password" autocomplete="new-password" data-password-strength="pst__Password" data-table="users" data-field="x__Password" name="x__Password" id="x__Password" size="30" maxlength="64" placeholder="<?= HtmlEncode($Page->_Password->getPlaceHolder()) ?>"<?= $Page->_Password->editAttributes() ?> aria-describedby="x__Password_help">
    <button type="button" class="btn btn-default ew-toggle-password" data-ew-action="password"><i class="fa-solid fa-eye"></i></button>
    <button type="button" class="btn btn-default ew-password-generator rounded-end" title="<?= HtmlTitle($Language->phrase("GeneratePassword")) ?>" data-password-field="x__Password" data-password-confirm="c__Password" data-password-strength="pst__Password"><?= $Language->phrase("GeneratePassword") ?></button>
</div>
<div class="progress ew-password-strength-bar form-text mt-1 d-none" id="pst__Password">
    <div class="progress-bar" role="progressbar"></div>
</div>
<?= $Page->_Password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Password->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_users__Password">
<span<?= $Page->_Password->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_Password->getDisplayValue($Page->_Password->ViewValue))) ?>"></span>
<input type="hidden" data-table="users" data-field="x__Password" data-hidden="1" name="x__Password" id="x__Password" value="<?= HtmlEncode($Page->_Password->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r__Password"<?= $Page->_Password->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users__Password"><?= $Page->_Password->caption() ?><?= $Page->_Password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->_Password->cellAttributes() ?>> <div style="max-width: 500px;"> 
<?php if (!$Page->isConfirm()) { ?>
<span id="el_users__Password">
<div class="input-group" id="ig__Password">
    <input type="password" autocomplete="new-password" data-password-strength="pst__Password" data-table="users" data-field="x__Password" name="x__Password" id="x__Password" size="30" maxlength="64" placeholder="<?= HtmlEncode($Page->_Password->getPlaceHolder()) ?>"<?= $Page->_Password->editAttributes() ?> aria-describedby="x__Password_help">
    <button type="button" class="btn btn-default ew-toggle-password" data-ew-action="password"><i class="fa-solid fa-eye"></i></button>
    <button type="button" class="btn btn-default ew-password-generator rounded-end" title="<?= HtmlTitle($Language->phrase("GeneratePassword")) ?>" data-password-field="x__Password" data-password-confirm="c__Password" data-password-strength="pst__Password"><?= $Language->phrase("GeneratePassword") ?></button>
</div>
<div class="progress ew-password-strength-bar form-text mt-1 d-none" id="pst__Password">
    <div class="progress-bar" role="progressbar"></div>
</div>
<?= $Page->_Password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Password->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_users__Password">
<span<?= $Page->_Password->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_Password->getDisplayValue($Page->_Password->ViewValue))) ?>"></span>
<input type="hidden" data-table="users" data-field="x__Password" data-hidden="1" name="x__Password" id="x__Password" value="<?= HtmlEncode($Page->_Password->FormValue) ?>">
</span>
<?php } ?>
 </div></td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->_Password->Visible) { // Password ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_c__Password" class="row">
        <label id="elh_c_users__Password" for="c__Password" class="<?= $Page->LeftColumnClass ?>"><?= $Language->phrase("Confirm") ?> <?= $Page->_Password->caption() ?><?= $Page->_Password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Password->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_c_users__Password">
<div class="input-group">
    <input type="password" name="c__Password" id="c__Password" autocomplete="new-password" data-field="c__Password" size="30" maxlength="64" placeholder="<?= HtmlEncode($Page->_Password->getPlaceHolder()) ?>"<?= $Page->_Password->editAttributes() ?> aria-describedby="x__Password_help">
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fa-solid fa-eye"></i></button>
</div>
<?= $Page->_Password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Password->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_c_users__Password">
<span<?= $Page->_Password->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_Password->getDisplayValue($Page->_Password->ViewValue))) ?>"></span>
<input type="hidden" data-table="users" data-field="x__Password" data-hidden="1" name="c__Password" id="c__Password" value="<?= HtmlEncode($Page->_Password->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_c__Password">
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_c_users__Password" class="ew-confirm-password"><?= $Language->phrase("Confirm") ?> <?= $Page->_Password->caption() ?><?= $Page->_Password->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->_Password->cellAttributes() ?>><div style="max-width: 500px;">
<?php if (!$Page->isConfirm()) { ?>
<span id="el_c_users__Password">
<div class="input-group">
    <input type="password" name="c__Password" id="c__Password" autocomplete="new-password" data-field="c__Password" size="30" maxlength="64" placeholder="<?= HtmlEncode($Page->_Password->getPlaceHolder()) ?>"<?= $Page->_Password->editAttributes() ?> aria-describedby="x__Password_help">
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fa-solid fa-eye"></i></button>
</div>
<?= $Page->_Password->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Password->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_c_users__Password">
<span<?= $Page->_Password->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_Password->getDisplayValue($Page->_Password->ViewValue))) ?>"></span>
<input type="hidden" data-table="users" data-field="x__Password" data-hidden="1" name="c__Password" id="c__Password" value="<?= HtmlEncode($Page->_Password->FormValue) ?>">
</span>
<?php } ?>
</div></td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->First_Name->Visible) { // First_Name ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_First_Name"<?= $Page->First_Name->rowAttributes() ?>>
        <label id="elh_users_First_Name" for="x_First_Name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->First_Name->caption() ?><?= $Page->First_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->First_Name->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_users_First_Name">
<input type="<?= $Page->First_Name->getInputTextType() ?>" name="x_First_Name" id="x_First_Name" data-table="users" data-field="x_First_Name" value="<?= $Page->First_Name->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->First_Name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->First_Name->formatPattern()) ?>"<?= $Page->First_Name->editAttributes() ?> aria-describedby="x_First_Name_help">
<?= $Page->First_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->First_Name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_users_First_Name">
<span<?= $Page->First_Name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->First_Name->getDisplayValue($Page->First_Name->ViewValue))) ?>"></span>
<input type="hidden" data-table="users" data-field="x_First_Name" data-hidden="1" name="x_First_Name" id="x_First_Name" value="<?= HtmlEncode($Page->First_Name->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_First_Name"<?= $Page->First_Name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_First_Name"><?= $Page->First_Name->caption() ?><?= $Page->First_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->First_Name->cellAttributes() ?>> 
<?php if (!$Page->isConfirm()) { ?>
<span id="el_users_First_Name">
<input type="<?= $Page->First_Name->getInputTextType() ?>" name="x_First_Name" id="x_First_Name" data-table="users" data-field="x_First_Name" value="<?= $Page->First_Name->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->First_Name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->First_Name->formatPattern()) ?>"<?= $Page->First_Name->editAttributes() ?> aria-describedby="x_First_Name_help">
<?= $Page->First_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->First_Name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_users_First_Name">
<span<?= $Page->First_Name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->First_Name->getDisplayValue($Page->First_Name->ViewValue))) ?>"></span>
<input type="hidden" data-table="users" data-field="x_First_Name" data-hidden="1" name="x_First_Name" id="x_First_Name" value="<?= HtmlEncode($Page->First_Name->FormValue) ?>">
</span>
<?php } ?>
 </td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Last_Name->Visible) { // Last_Name ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Last_Name"<?= $Page->Last_Name->rowAttributes() ?>>
        <label id="elh_users_Last_Name" for="x_Last_Name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Last_Name->caption() ?><?= $Page->Last_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->Last_Name->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_users_Last_Name">
<input type="<?= $Page->Last_Name->getInputTextType() ?>" name="x_Last_Name" id="x_Last_Name" data-table="users" data-field="x_Last_Name" value="<?= $Page->Last_Name->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Last_Name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Last_Name->formatPattern()) ?>"<?= $Page->Last_Name->editAttributes() ?> aria-describedby="x_Last_Name_help">
<?= $Page->Last_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Last_Name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_users_Last_Name">
<span<?= $Page->Last_Name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Last_Name->getDisplayValue($Page->Last_Name->ViewValue))) ?>"></span>
<input type="hidden" data-table="users" data-field="x_Last_Name" data-hidden="1" name="x_Last_Name" id="x_Last_Name" value="<?= HtmlEncode($Page->Last_Name->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Last_Name"<?= $Page->Last_Name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users_Last_Name"><?= $Page->Last_Name->caption() ?><?= $Page->Last_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Last_Name->cellAttributes() ?>> 
<?php if (!$Page->isConfirm()) { ?>
<span id="el_users_Last_Name">
<input type="<?= $Page->Last_Name->getInputTextType() ?>" name="x_Last_Name" id="x_Last_Name" data-table="users" data-field="x_Last_Name" value="<?= $Page->Last_Name->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Last_Name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Last_Name->formatPattern()) ?>"<?= $Page->Last_Name->editAttributes() ?> aria-describedby="x_Last_Name_help">
<?= $Page->Last_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Last_Name->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_users_Last_Name">
<span<?= $Page->Last_Name->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->Last_Name->getDisplayValue($Page->Last_Name->ViewValue))) ?>"></span>
<input type="hidden" data-table="users" data-field="x_Last_Name" data-hidden="1" name="x_Last_Name" id="x_Last_Name" value="<?= HtmlEncode($Page->Last_Name->FormValue) ?>">
</span>
<?php } ?>
 </td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r__Email"<?= $Page->_Email->rowAttributes() ?>>
        <label id="elh_users__Email" for="x__Email" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Email->caption() ?><?= $Page->_Email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div <?= $Page->_Email->cellAttributes() ?>>
<?php if (!$Page->isConfirm()) { ?>
<span id="el_users__Email">
<input type="<?= $Page->_Email->getInputTextType() ?>" name="x__Email" id="x__Email" data-table="users" data-field="x__Email" value="<?= $Page->_Email->EditValue ?>" size="50" maxlength="100" placeholder="<?= HtmlEncode($Page->_Email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Email->formatPattern()) ?>"<?= $Page->_Email->editAttributes() ?> aria-describedby="x__Email_help">
<?= $Page->_Email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_users__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_Email->getDisplayValue($Page->_Email->ViewValue))) ?>"></span>
<input type="hidden" data-table="users" data-field="x__Email" data-hidden="1" name="x__Email" id="x__Email" value="<?= HtmlEncode($Page->_Email->FormValue) ?>">
</span>
<?php } ?>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r__Email"<?= $Page->_Email->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_users__Email"><?= $Page->_Email->caption() ?><?= $Page->_Email->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->_Email->cellAttributes() ?>> 
<?php if (!$Page->isConfirm()) { ?>
<span id="el_users__Email">
<input type="<?= $Page->_Email->getInputTextType() ?>" name="x__Email" id="x__Email" data-table="users" data-field="x__Email" value="<?= $Page->_Email->EditValue ?>" size="50" maxlength="100" placeholder="<?= HtmlEncode($Page->_Email->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Email->formatPattern()) ?>"<?= $Page->_Email->editAttributes() ?> aria-describedby="x__Email_help">
<?= $Page->_Email->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Email->getErrorMessage() ?></div>
</span>
<?php } else { ?>
<span id="el_users__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->_Email->getDisplayValue($Page->_Email->ViewValue))) ?>"></span>
<input type="hidden" data-table="users" data-field="x__Email" data-hidden="1" name="x__Email" id="x__Email" value="<?= HtmlEncode($Page->_Email->FormValue) ?>">
</span>
<?php } ?>
 </td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?php if (!$Page->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
<?php // } // MS_SHOW_TERMS_AND_CONDITIONS_ON_REGISTRATION_PAGE ?>
<?php // End of modification Terms and Conditions, by Masino Sinaga, July 14, 2014 ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<?php if (!$Page->isConfirm()) { // Confirm page ?>
<button class="btn btn-primary ew-btn disabled enable-on-init" name="btn-action" id="btn-action" type="submit" form="fregister" data-ew-action="set-action" data-value="confirm"><?= $Language->phrase("RegisterBtn") ?></button>
<?php } else { ?>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fregister"><?= $Language->phrase("ConfirmBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="submit" form="fregister" data-ew-action="set-action" data-value="cancel"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
</form>
<?php if (!$Page->IsModal) { ?>
		</div>
     <!-- /.card-body -->
     </div>
  <!-- /.card -->
</div>
<?php } ?>
<div class="clearfix">&nbsp;</div>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("users");
});
</script>
<script>
<?php // Begin of modification Terms and Conditions, by Masino Sinaga, July 14, 2014 ?>
<?php if (MS_SHOW_TERMS_AND_CONDITIONS_ON_REGISTRATION_PAGE == true && !CurrentPage()->isConfirm()) { ?>
<?php if (MS_TERMS_AND_CONDITION_CHECKBOX_ON_REGISTER_PAGE == true && !CurrentPage()->isConfirm()) { ?>
loadjs.ready("load", function() {
	$('input[name="chkterms"]').change(function(){
        if ($(this).is(':checked') && ($('#r_ChkTerms').scrollTop() + $('#r_ChkTerms').innerHeight() < 450)) {
            $(document).scrollTop(480);
        } else {
			window.scrollTo({ top: 0, behavior: "smooth"});
		}
    });
    $('#btn-action').click(function() {
		if (!$('#chkterms').is(":checked")) {
			Swal.fire({title: ew.language.phrase("TermsConditionsNotSelected"), icon: "error"});
			return false;
        }
    });
});
<?php } // MS_TERMS_AND_CONDITION_CHECKBOX_ON_REGISTER_PAGE ?>
<?php } // MS_SHOW_TERMS_AND_CONDITIONS_ON_REGISTRATION_PAGE ?>
<?php // End of modification Terms and Conditions, by Masino Sinaga, July 14, 2014 ?>
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fregister:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your startup script here, no need to add script tags.
});
</script>
