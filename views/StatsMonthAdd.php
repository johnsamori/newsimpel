<?php

namespace PHPMaker2023\new2023;

// Page object
$StatsMonthAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { stats_month: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fstats_monthadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fstats_monthadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["Year", [fields.Year.visible && fields.Year.required ? ew.Validators.required(fields.Year.caption) : null, ew.Validators.integer], fields.Year.isInvalid],
            ["Month", [fields.Month.visible && fields.Month.required ? ew.Validators.required(fields.Month.caption) : null, ew.Validators.integer], fields.Month.isInvalid],
            ["Hits", [fields.Hits.visible && fields.Hits.required ? ew.Validators.required(fields.Hits.caption) : null, ew.Validators.integer], fields.Hits.isInvalid]
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
<form name="fstats_monthadd" id="fstats_monthadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stats_month">
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
<table id="tbl_stats_monthadd" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->Year->Visible) { // Year ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Year"<?= $Page->Year->rowAttributes() ?>>
        <label id="elh_stats_month_Year" for="x_Year" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Year->caption() ?><?= $Page->Year->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Year->cellAttributes() ?>>
<span id="el_stats_month_Year">
<input type="<?= $Page->Year->getInputTextType() ?>" name="x_Year" id="x_Year" data-table="stats_month" data-field="x_Year" value="<?= $Page->Year->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Year->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Year->formatPattern()) ?>"<?= $Page->Year->editAttributes() ?> aria-describedby="x_Year_help">
<?= $Page->Year->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Year->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Year"<?= $Page->Year->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_month_Year"><?= $Page->Year->caption() ?><?= $Page->Year->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Year->cellAttributes() ?>>
<span id="el_stats_month_Year">
<input type="<?= $Page->Year->getInputTextType() ?>" name="x_Year" id="x_Year" data-table="stats_month" data-field="x_Year" value="<?= $Page->Year->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Year->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Year->formatPattern()) ?>"<?= $Page->Year->editAttributes() ?> aria-describedby="x_Year_help">
<?= $Page->Year->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Year->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Month->Visible) { // Month ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Month"<?= $Page->Month->rowAttributes() ?>>
        <label id="elh_stats_month_Month" for="x_Month" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Month->caption() ?><?= $Page->Month->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Month->cellAttributes() ?>>
<span id="el_stats_month_Month">
<input type="<?= $Page->Month->getInputTextType() ?>" name="x_Month" id="x_Month" data-table="stats_month" data-field="x_Month" value="<?= $Page->Month->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Month->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Month->formatPattern()) ?>"<?= $Page->Month->editAttributes() ?> aria-describedby="x_Month_help">
<?= $Page->Month->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Month->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fstats_monthadd", "jquerynumber"], function() {
	ew.createjQueryNumber("fstats_monthadd", "x_Month", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Month"<?= $Page->Month->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_month_Month"><?= $Page->Month->caption() ?><?= $Page->Month->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Month->cellAttributes() ?>>
<span id="el_stats_month_Month">
<input type="<?= $Page->Month->getInputTextType() ?>" name="x_Month" id="x_Month" data-table="stats_month" data-field="x_Month" value="<?= $Page->Month->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Month->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Month->formatPattern()) ?>"<?= $Page->Month->editAttributes() ?> aria-describedby="x_Month_help">
<?= $Page->Month->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Month->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fstats_monthadd", "jquerynumber"], function() {
	ew.createjQueryNumber("fstats_monthadd", "x_Month", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Hits->Visible) { // Hits ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Hits"<?= $Page->Hits->rowAttributes() ?>>
        <label id="elh_stats_month_Hits" for="x_Hits" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Hits->caption() ?><?= $Page->Hits->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Hits->cellAttributes() ?>>
<span id="el_stats_month_Hits">
<input type="<?= $Page->Hits->getInputTextType() ?>" name="x_Hits" id="x_Hits" data-table="stats_month" data-field="x_Hits" value="<?= $Page->Hits->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Hits->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Hits->formatPattern()) ?>"<?= $Page->Hits->editAttributes() ?> aria-describedby="x_Hits_help">
<?= $Page->Hits->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Hits->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fstats_monthadd", "jquerynumber"], function() {
	ew.createjQueryNumber("fstats_monthadd", "x_Hits", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Hits"<?= $Page->Hits->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_month_Hits"><?= $Page->Hits->caption() ?><?= $Page->Hits->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Hits->cellAttributes() ?>>
<span id="el_stats_month_Hits">
<input type="<?= $Page->Hits->getInputTextType() ?>" name="x_Hits" id="x_Hits" data-table="stats_month" data-field="x_Hits" value="<?= $Page->Hits->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Hits->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Hits->formatPattern()) ?>"<?= $Page->Hits->editAttributes() ?> aria-describedby="x_Hits_help">
<?= $Page->Hits->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Hits->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fstats_monthadd", "jquerynumber"], function() {
	ew.createjQueryNumber("fstats_monthadd", "x_Hits", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fstats_monthadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fstats_monthadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("stats_month");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fstats_monthadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fstats_monthadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fstats_monthadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
