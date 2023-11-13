<?php

namespace PHPMaker2023\new2023;

// Page object
$RumpunIlmuEdit = &$Page;
?>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<main class="edit">
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<div class="col-md-12">
  <div class="card shadow-sm">
    <div class="card-header">
	  <h4 class="card-title"><?php echo Language()->phrase("EditCaption"); ?></h4>
	  <div class="card-tools">
	  <button type="button" class="btn btn-tool" data-card-widget="maximize"><i class="fas fa-expand"></i>
	  </button>
	  </div>
	  <!-- /.card-tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body">
<?php } ?>
<form name="frumpun_ilmuedit" id="frumpun_ilmuedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { rumpun_ilmu: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var frumpun_ilmuedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("frumpun_ilmuedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["no", [fields.no.visible && fields.no.required ? ew.Validators.required(fields.no.caption) : null, ew.Validators.integer], fields.no.isInvalid],
            ["Rumpun_Ilmu", [fields.Rumpun_Ilmu.visible && fields.Rumpun_Ilmu.required ? ew.Validators.required(fields.Rumpun_Ilmu.caption) : null], fields.Rumpun_Ilmu.isInvalid]
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="rumpun_ilmu">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if (!$Page->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($Page->IsMobileOrModal) { ?>
<div class="ew-edit-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_rumpun_ilmuedit" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->no->Visible) { // no ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_no"<?= $Page->no->rowAttributes() ?>>
        <label id="elh_rumpun_ilmu_no" for="x_no" class="<?= $Page->LeftColumnClass ?>"><?= $Page->no->caption() ?><?= $Page->no->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->no->cellAttributes() ?>>
<span id="el_rumpun_ilmu_no">
<input type="<?= $Page->no->getInputTextType() ?>" name="x_no" id="x_no" data-table="rumpun_ilmu" data-field="x_no" value="<?= $Page->no->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->no->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->no->formatPattern()) ?>"<?= $Page->no->editAttributes() ?> aria-describedby="x_no_help">
<?= $Page->no->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["frumpun_ilmuedit", "jquerynumber"], function() {
	ew.createjQueryNumber("frumpun_ilmuedit", "x_no", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
<input type="hidden" data-table="rumpun_ilmu" data-field="x_no" data-hidden="1" data-old name="o_no" id="o_no" value="<?= HtmlEncode($Page->no->OldValue ?? $Page->no->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_no"<?= $Page->no->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_rumpun_ilmu_no"><?= $Page->no->caption() ?><?= $Page->no->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->no->cellAttributes() ?>>
<span id="el_rumpun_ilmu_no">
<input type="<?= $Page->no->getInputTextType() ?>" name="x_no" id="x_no" data-table="rumpun_ilmu" data-field="x_no" value="<?= $Page->no->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->no->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->no->formatPattern()) ?>"<?= $Page->no->editAttributes() ?> aria-describedby="x_no_help">
<?= $Page->no->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->no->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["frumpun_ilmuedit", "jquerynumber"], function() {
	ew.createjQueryNumber("frumpun_ilmuedit", "x_no", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
<input type="hidden" data-table="rumpun_ilmu" data-field="x_no" data-hidden="1" data-old name="o_no" id="o_no" value="<?= HtmlEncode($Page->no->OldValue ?? $Page->no->CurrentValue) ?>">
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Rumpun_Ilmu->Visible) { // Rumpun_Ilmu ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Rumpun_Ilmu"<?= $Page->Rumpun_Ilmu->rowAttributes() ?>>
        <label id="elh_rumpun_ilmu_Rumpun_Ilmu" for="x_Rumpun_Ilmu" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Rumpun_Ilmu->caption() ?><?= $Page->Rumpun_Ilmu->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Rumpun_Ilmu->cellAttributes() ?>>
<span id="el_rumpun_ilmu_Rumpun_Ilmu">
<input type="<?= $Page->Rumpun_Ilmu->getInputTextType() ?>" name="x_Rumpun_Ilmu" id="x_Rumpun_Ilmu" data-table="rumpun_ilmu" data-field="x_Rumpun_Ilmu" value="<?= $Page->Rumpun_Ilmu->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Rumpun_Ilmu->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Rumpun_Ilmu->formatPattern()) ?>"<?= $Page->Rumpun_Ilmu->editAttributes() ?> aria-describedby="x_Rumpun_Ilmu_help">
<?= $Page->Rumpun_Ilmu->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Rumpun_Ilmu->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Rumpun_Ilmu"<?= $Page->Rumpun_Ilmu->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_rumpun_ilmu_Rumpun_Ilmu"><?= $Page->Rumpun_Ilmu->caption() ?><?= $Page->Rumpun_Ilmu->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Rumpun_Ilmu->cellAttributes() ?>>
<span id="el_rumpun_ilmu_Rumpun_Ilmu">
<input type="<?= $Page->Rumpun_Ilmu->getInputTextType() ?>" name="x_Rumpun_Ilmu" id="x_Rumpun_Ilmu" data-table="rumpun_ilmu" data-field="x_Rumpun_Ilmu" value="<?= $Page->Rumpun_Ilmu->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Rumpun_Ilmu->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Rumpun_Ilmu->formatPattern()) ?>"<?= $Page->Rumpun_Ilmu->editAttributes() ?> aria-describedby="x_Rumpun_Ilmu_help">
<?= $Page->Rumpun_Ilmu->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Rumpun_Ilmu->getErrorMessage() ?></div>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="frumpun_ilmuedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="frumpun_ilmuedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
<?php if (!$Page->IsModal) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("rumpun_ilmu");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#frumpun_ilmuedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(frumpun_ilmuedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#frumpun_ilmuedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
