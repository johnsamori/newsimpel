<?php

namespace PHPMaker2023\new2023;

// Page object
$ResetPassword = &$Page;
?>
<script>
loadjs.ready("head", function () {
    // Write your client script here, no need to add script tags.
});
</script>
<script>
var freset_password;
loadjs.ready(["wrapper", "head"], function() {
    let $ = jQuery;
    ew.PAGE_ID ||= "reset_password";
    window.currentPageID ||= "reset_password";
    let form = new ew.FormBuilder()
        .setId("freset_password")
        // Add field
		<?php if (MS_KNOWN_FIELD_OPTIONS=="Email" || MS_KNOWN_FIELD_OPTIONS=="EmailAndUsername" || MS_KNOWN_FIELD_OPTIONS=="") { ?>
        .addFields([
            ["email", [ew.Validators.required(ew.language.phrase("Email")), ew.Validators.email], <?= $Page->Email->IsInvalid ? "true" : "false" ?>]
        ])
		<?php } ?>
		<?php if (MS_KNOWN_FIELD_OPTIONS=="Username" || MS_KNOWN_FIELD_OPTIONS=="EmailAndUsername") { ?>
		.setId("freset_password").addFields([
			["username", [ew.Validators.required(ew.language.phrase("UserName"))]]
		])
		<?php } ?>

        // Validate
        .setValidate(
            async function() {
                if (!this.validateRequired)
                    return true; // Ignore validation
                var fobj = this.getForm();

                // Validate fields
                if (!this.validateFields())
                    return false;

                // Call Form_CustomValidate event
                if (!(await this.customValidate?.(fobj) ?? true)) {
                    this.focus();
                    return false;
                }
                return true;
            }
        )

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation
        .setValidateRequired(ew.CLIENT_VALIDATE)
        .build();
    window[form.id] = form;
    window.currentForm ||= form;
    loadjs.done(form.id);
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="freset_password" id="freset_password" class="ew-form ew-forgot-pwd-form" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (!$Page->IsModal) { ?>
<div class="ew-reset-pwd-box shadow-sm">
<?php } else { ?>
<div class="ew-reset-pwd-box">
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="card">
<div class="card-body">
<?php } ?>
<p class="login-box-msg"><?= $Language->phrase("ResetPwdTitle") ?></p>
	<?php if (MS_KNOWN_FIELD_OPTIONS == "Email" || MS_KNOWN_FIELD_OPTIONS == "EmailAndUsername" || MS_KNOWN_FIELD_OPTIONS == "") { ?>
	<div class="form-group row" id="control-email">
		<div class="col-sm-12">
			<input type="text" name="email" id="email" class="form-control ew-form-control" value="<?= HtmlEncode($Page->Email->CurrentValue) ?>"  size="50" maxlength="100" placeholder="<?= HtmlEncode($Language->phrase("UserEmail", true)) ?>"<?= $Page->Email->editAttributes() ?>>
			<div class="invalid-feedback"><?= $Language->phrase("IncorrectEmail") ?></div>
		</div>
    </div>
	<?php } ?>
	<?php if (MS_KNOWN_FIELD_OPTIONS == "Username" || MS_KNOWN_FIELD_OPTIONS == "EmailAndUsername") { ?>
	<div class="form-group row" id="control-username">
		<div class="col-sm-12">
			<input type="text" name="username" id="username" class="form-control ew-form-control" value="" autocomplete="username" value="" placeholder="<?= HtmlEncode($Language->phrase("UserName")) ?>">
			<div class="invalid-feedback"><?= $Language->phrase("InvalidParameter") ?></div>
		</div>
    </div>
	<?php } ?>
<div class="d-grid mb-3">
    <button class="btn btn-primary ew-btn disabled enable-on-init" name="btn-submit" id="btn-submit" type="submit" formaction="<?= CurrentPageUrl(false) ?>"><?= $Language->phrase("SendPwd") ?></button>
</div>
<?php if (!$Page->IsModal) { ?>
</div>
</div>
<?php } ?>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function(){
<?php if (MS_KNOWN_FIELD_OPTIONS == "Email" || MS_KNOWN_FIELD_OPTIONS == "EmailAndUsername") { ?>
  setTimeout(function (){
    $("#email").focus();
  }, 500);
<?php } else { ?>
  setTimeout(function (){
    $("#username").focus();
  }, 500);
<?php } ?>
<?php if (!$Page->IsModal) { ?>
  $("div.ew-forgot-pwd-box").css({"width":"350px"});
<?php } else { ?>
  $("div.ew-forgot-pwd-box").css({"width":"auto"});
<?php } ?>
});

// Startup script from extension
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#freset_password:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-submit").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-submit").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-submit").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your startup script here, no need to add script tags.
});
</script>
