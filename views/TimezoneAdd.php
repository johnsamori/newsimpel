<?php

namespace PHPMaker2023\new2023;

// Page object
$TimezoneAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { timezone: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var ftimezoneadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("ftimezoneadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["Timezone", [fields.Timezone.visible && fields.Timezone.required ? ew.Validators.required(fields.Timezone.caption) : null], fields.Timezone.isInvalid],
            ["_Default", [fields._Default.visible && fields._Default.required ? ew.Validators.required(fields._Default.caption) : null], fields._Default.isInvalid]
        ])

        // Form_CustomValidate
        .setCustomValidate(
            function (fobj) { // DO NOT CHANGE THIS LINE! (except for adding "async" keyword)!
                    // Your custom validation code here, return false if invalid.
                    return true;
                }
        )

        // Use JavaScript validation or not
        .setValidateRequired(ew.CLIENT_VALIDATE)

        // Dynamic selection lists
        .setLists({
            "_Default": <?= $Page->_Default->toClientList($Page) ?>,
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if (!$Page->IsModal) { ?>
<div class="col-md-12">
  <div class="card shadow-sm">
    <div class="card-header">
	  <h4 class="card-title"><?php echo Language()->phrase("AddCaption"); ?></h4>
	  <div class="card-tools">
	  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
	  </button>
	  </div>
	  <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
<?php } ?>
<form name="ftimezoneadd" id="ftimezoneadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="timezone">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if (!$Page->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($Page->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_timezoneadd" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->Timezone->Visible) { // Timezone ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Timezone"<?= $Page->Timezone->rowAttributes() ?>>
        <label id="elh_timezone_Timezone" for="x_Timezone" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Timezone->caption() ?><?= $Page->Timezone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Timezone->cellAttributes() ?>>
<span id="el_timezone_Timezone">
<input type="<?= $Page->Timezone->getInputTextType() ?>" name="x_Timezone" id="x_Timezone" data-table="timezone" data-field="x_Timezone" value="<?= $Page->Timezone->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Timezone->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Timezone->formatPattern()) ?>"<?= $Page->Timezone->editAttributes() ?> aria-describedby="x_Timezone_help">
<?= $Page->Timezone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Timezone->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Timezone"<?= $Page->Timezone->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_timezone_Timezone"><?= $Page->Timezone->caption() ?><?= $Page->Timezone->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Timezone->cellAttributes() ?>>
<span id="el_timezone_Timezone">
<input type="<?= $Page->Timezone->getInputTextType() ?>" name="x_Timezone" id="x_Timezone" data-table="timezone" data-field="x_Timezone" value="<?= $Page->Timezone->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Timezone->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Timezone->formatPattern()) ?>"<?= $Page->Timezone->editAttributes() ?> aria-describedby="x_Timezone_help">
<?= $Page->Timezone->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Timezone->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->_Default->Visible) { // Default ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r__Default"<?= $Page->_Default->rowAttributes() ?>>
        <label id="elh_timezone__Default" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Default->caption() ?><?= $Page->_Default->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Default->cellAttributes() ?>>
<span id="el_timezone__Default">
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->_Default->isInvalidClass() ?>" data-table="timezone" data-field="x__Default" data-boolean name="x__Default" id="x__Default" value="1"<?= ConvertToBool($Page->_Default->CurrentValue) ? " checked" : "" ?><?= $Page->_Default->editAttributes() ?> aria-describedby="x__Default_help">
    <div class="invalid-feedback"><?= $Page->_Default->getErrorMessage() ?></div>
</div>
<?= $Page->_Default->getCustomMessage() ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r__Default"<?= $Page->_Default->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_timezone__Default"><?= $Page->_Default->caption() ?><?= $Page->_Default->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->_Default->cellAttributes() ?>>
<span id="el_timezone__Default">
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" class="form-check-input<?= $Page->_Default->isInvalidClass() ?>" data-table="timezone" data-field="x__Default" data-boolean name="x__Default" id="x__Default" value="1"<?= ConvertToBool($Page->_Default->CurrentValue) ? " checked" : "" ?><?= $Page->_Default->editAttributes() ?> aria-describedby="x__Default_help">
    <div class="invalid-feedback"><?= $Page->_Default->getErrorMessage() ?></div>
</div>
<?= $Page->_Default->getCustomMessage() ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->IsMobileOrModal) { ?>
</div><!-- /page* -->
<?php } else { ?>
</table><!-- /table* -->
<?php } ?>
<?= $Page->IsModal ? '<template class="ew-modal-buttons">' : '<div class="row ew-buttons">' ?><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="ftimezoneadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="ftimezoneadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
<?php } ?>
    </div><!-- /buttons offset -->
<?= $Page->IsModal ? "</template>" : "</div>" ?><!-- /buttons .row -->
<?php if (!$Page->IsMobileOrModal) { ?>
</div><!-- /desktop -->
<?php } ?>
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
    ew.addEventHandlers("timezone");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#ftimezoneadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(ftimezoneadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#ftimezoneadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
