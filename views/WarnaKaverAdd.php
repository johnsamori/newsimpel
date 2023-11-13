<?php

namespace PHPMaker2023\new2023;

// Page object
$WarnaKaverAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { warna_kaver: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fwarna_kaveradd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fwarna_kaveradd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["id_kaver", [fields.id_kaver.visible && fields.id_kaver.required ? ew.Validators.required(fields.id_kaver.caption) : null, ew.Validators.integer], fields.id_kaver.isInvalid],
            ["Warna_kaver", [fields.Warna_kaver.visible && fields.Warna_kaver.required ? ew.Validators.required(fields.Warna_kaver.caption) : null], fields.Warna_kaver.isInvalid]
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
<form name="fwarna_kaveradd" id="fwarna_kaveradd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="warna_kaver">
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
<table id="tbl_warna_kaveradd" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->id_kaver->Visible) { // id_kaver ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_id_kaver"<?= $Page->id_kaver->rowAttributes() ?>>
        <label id="elh_warna_kaver_id_kaver" for="x_id_kaver" class="<?= $Page->LeftColumnClass ?>"><?= $Page->id_kaver->caption() ?><?= $Page->id_kaver->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->id_kaver->cellAttributes() ?>>
<span id="el_warna_kaver_id_kaver">
<input type="<?= $Page->id_kaver->getInputTextType() ?>" name="x_id_kaver" id="x_id_kaver" data-table="warna_kaver" data-field="x_id_kaver" value="<?= $Page->id_kaver->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->id_kaver->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_kaver->formatPattern()) ?>"<?= $Page->id_kaver->editAttributes() ?> aria-describedby="x_id_kaver_help">
<?= $Page->id_kaver->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_kaver->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fwarna_kaveradd", "jquerynumber"], function() {
	ew.createjQueryNumber("fwarna_kaveradd", "x_id_kaver", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_id_kaver"<?= $Page->id_kaver->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_warna_kaver_id_kaver"><?= $Page->id_kaver->caption() ?><?= $Page->id_kaver->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->id_kaver->cellAttributes() ?>>
<span id="el_warna_kaver_id_kaver">
<input type="<?= $Page->id_kaver->getInputTextType() ?>" name="x_id_kaver" id="x_id_kaver" data-table="warna_kaver" data-field="x_id_kaver" value="<?= $Page->id_kaver->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->id_kaver->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->id_kaver->formatPattern()) ?>"<?= $Page->id_kaver->editAttributes() ?> aria-describedby="x_id_kaver_help">
<?= $Page->id_kaver->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->id_kaver->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fwarna_kaveradd", "jquerynumber"], function() {
	ew.createjQueryNumber("fwarna_kaveradd", "x_id_kaver", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Warna_kaver->Visible) { // Warna_kaver ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Warna_kaver"<?= $Page->Warna_kaver->rowAttributes() ?>>
        <label id="elh_warna_kaver_Warna_kaver" for="x_Warna_kaver" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Warna_kaver->caption() ?><?= $Page->Warna_kaver->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Warna_kaver->cellAttributes() ?>>
<span id="el_warna_kaver_Warna_kaver">
<input type="<?= $Page->Warna_kaver->getInputTextType() ?>" name="x_Warna_kaver" id="x_Warna_kaver" data-table="warna_kaver" data-field="x_Warna_kaver" value="<?= $Page->Warna_kaver->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->Warna_kaver->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Warna_kaver->formatPattern()) ?>"<?= $Page->Warna_kaver->editAttributes() ?> aria-describedby="x_Warna_kaver_help">
<?= $Page->Warna_kaver->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Warna_kaver->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Warna_kaver"<?= $Page->Warna_kaver->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_warna_kaver_Warna_kaver"><?= $Page->Warna_kaver->caption() ?><?= $Page->Warna_kaver->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Warna_kaver->cellAttributes() ?>>
<span id="el_warna_kaver_Warna_kaver">
<input type="<?= $Page->Warna_kaver->getInputTextType() ?>" name="x_Warna_kaver" id="x_Warna_kaver" data-table="warna_kaver" data-field="x_Warna_kaver" value="<?= $Page->Warna_kaver->EditValue ?>" size="30" maxlength="30" placeholder="<?= HtmlEncode($Page->Warna_kaver->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Warna_kaver->formatPattern()) ?>"<?= $Page->Warna_kaver->editAttributes() ?> aria-describedby="x_Warna_kaver_help">
<?= $Page->Warna_kaver->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Warna_kaver->getErrorMessage() ?></div>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fwarna_kaveradd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fwarna_kaveradd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("warna_kaver");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fwarna_kaveradd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fwarna_kaveradd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fwarna_kaveradd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
