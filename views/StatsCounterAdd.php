<?php

namespace PHPMaker2023\new2023;

// Page object
$StatsCounterAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { stats_counter: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fstats_counteradd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fstats_counteradd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["Type", [fields.Type.visible && fields.Type.required ? ew.Validators.required(fields.Type.caption) : null], fields.Type.isInvalid],
            ["Variable", [fields.Variable.visible && fields.Variable.required ? ew.Validators.required(fields.Variable.caption) : null], fields.Variable.isInvalid],
            ["Counter", [fields.Counter.visible && fields.Counter.required ? ew.Validators.required(fields.Counter.caption) : null, ew.Validators.integer], fields.Counter.isInvalid]
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
<form name="fstats_counteradd" id="fstats_counteradd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stats_counter">
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
<table id="tbl_stats_counteradd" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->Type->Visible) { // Type ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Type"<?= $Page->Type->rowAttributes() ?>>
        <label id="elh_stats_counter_Type" for="x_Type" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Type->caption() ?><?= $Page->Type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Type->cellAttributes() ?>>
<span id="el_stats_counter_Type">
<input type="<?= $Page->Type->getInputTextType() ?>" name="x_Type" id="x_Type" data-table="stats_counter" data-field="x_Type" value="<?= $Page->Type->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Type->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Type->formatPattern()) ?>"<?= $Page->Type->editAttributes() ?> aria-describedby="x_Type_help">
<?= $Page->Type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Type->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Type"<?= $Page->Type->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_counter_Type"><?= $Page->Type->caption() ?><?= $Page->Type->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Type->cellAttributes() ?>>
<span id="el_stats_counter_Type">
<input type="<?= $Page->Type->getInputTextType() ?>" name="x_Type" id="x_Type" data-table="stats_counter" data-field="x_Type" value="<?= $Page->Type->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Type->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Type->formatPattern()) ?>"<?= $Page->Type->editAttributes() ?> aria-describedby="x_Type_help">
<?= $Page->Type->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Type->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Variable->Visible) { // Variable ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Variable"<?= $Page->Variable->rowAttributes() ?>>
        <label id="elh_stats_counter_Variable" for="x_Variable" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Variable->caption() ?><?= $Page->Variable->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Variable->cellAttributes() ?>>
<span id="el_stats_counter_Variable">
<input type="<?= $Page->Variable->getInputTextType() ?>" name="x_Variable" id="x_Variable" data-table="stats_counter" data-field="x_Variable" value="<?= $Page->Variable->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Variable->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Variable->formatPattern()) ?>"<?= $Page->Variable->editAttributes() ?> aria-describedby="x_Variable_help">
<?= $Page->Variable->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Variable->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Variable"<?= $Page->Variable->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_counter_Variable"><?= $Page->Variable->caption() ?><?= $Page->Variable->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Variable->cellAttributes() ?>>
<span id="el_stats_counter_Variable">
<input type="<?= $Page->Variable->getInputTextType() ?>" name="x_Variable" id="x_Variable" data-table="stats_counter" data-field="x_Variable" value="<?= $Page->Variable->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Variable->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Variable->formatPattern()) ?>"<?= $Page->Variable->editAttributes() ?> aria-describedby="x_Variable_help">
<?= $Page->Variable->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Variable->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Counter->Visible) { // Counter ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Counter"<?= $Page->Counter->rowAttributes() ?>>
        <label id="elh_stats_counter_Counter" for="x_Counter" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Counter->caption() ?><?= $Page->Counter->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Counter->cellAttributes() ?>>
<span id="el_stats_counter_Counter">
<input type="<?= $Page->Counter->getInputTextType() ?>" name="x_Counter" id="x_Counter" data-table="stats_counter" data-field="x_Counter" value="<?= $Page->Counter->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Counter->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Counter->formatPattern()) ?>"<?= $Page->Counter->editAttributes() ?> aria-describedby="x_Counter_help">
<?= $Page->Counter->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Counter->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fstats_counteradd", "jquerynumber"], function() {
	ew.createjQueryNumber("fstats_counteradd", "x_Counter", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Counter"<?= $Page->Counter->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_counter_Counter"><?= $Page->Counter->caption() ?><?= $Page->Counter->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Counter->cellAttributes() ?>>
<span id="el_stats_counter_Counter">
<input type="<?= $Page->Counter->getInputTextType() ?>" name="x_Counter" id="x_Counter" data-table="stats_counter" data-field="x_Counter" value="<?= $Page->Counter->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Counter->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Counter->formatPattern()) ?>"<?= $Page->Counter->editAttributes() ?> aria-describedby="x_Counter_help">
<?= $Page->Counter->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Counter->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fstats_counteradd", "jquerynumber"], function() {
	ew.createjQueryNumber("fstats_counteradd", "x_Counter", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fstats_counteradd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fstats_counteradd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("stats_counter");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fstats_counteradd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fstats_counteradd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fstats_counteradd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
