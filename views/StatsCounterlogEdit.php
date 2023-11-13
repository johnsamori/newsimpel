<?php

namespace PHPMaker2023\new2023;

// Page object
$StatsCounterlogEdit = &$Page;
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
<form name="fstats_counterlogedit" id="fstats_counterlogedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { stats_counterlog: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fstats_counterlogedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fstats_counterlogedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["IP_Address", [fields.IP_Address.visible && fields.IP_Address.required ? ew.Validators.required(fields.IP_Address.caption) : null], fields.IP_Address.isInvalid],
            ["Hostname", [fields.Hostname.visible && fields.Hostname.required ? ew.Validators.required(fields.Hostname.caption) : null], fields.Hostname.isInvalid],
            ["First_Visit", [fields.First_Visit.visible && fields.First_Visit.required ? ew.Validators.required(fields.First_Visit.caption) : null, ew.Validators.datetime(fields.First_Visit.clientFormatPattern)], fields.First_Visit.isInvalid],
            ["Last_Visit", [fields.Last_Visit.visible && fields.Last_Visit.required ? ew.Validators.required(fields.Last_Visit.caption) : null, ew.Validators.datetime(fields.Last_Visit.clientFormatPattern)], fields.Last_Visit.isInvalid],
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
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="stats_counterlog">
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
<table id="tbl_stats_counterlogedit" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->IP_Address->Visible) { // IP_Address ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_IP_Address"<?= $Page->IP_Address->rowAttributes() ?>>
        <label id="elh_stats_counterlog_IP_Address" for="x_IP_Address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->IP_Address->caption() ?><?= $Page->IP_Address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->IP_Address->cellAttributes() ?>>
<span id="el_stats_counterlog_IP_Address">
<input type="<?= $Page->IP_Address->getInputTextType() ?>" name="x_IP_Address" id="x_IP_Address" data-table="stats_counterlog" data-field="x_IP_Address" value="<?= $Page->IP_Address->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->IP_Address->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->IP_Address->formatPattern()) ?>"<?= $Page->IP_Address->editAttributes() ?> aria-describedby="x_IP_Address_help">
<?= $Page->IP_Address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->IP_Address->getErrorMessage() ?></div>
<input type="hidden" data-table="stats_counterlog" data-field="x_IP_Address" data-hidden="1" data-old name="o_IP_Address" id="o_IP_Address" value="<?= HtmlEncode($Page->IP_Address->OldValue ?? $Page->IP_Address->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_IP_Address"<?= $Page->IP_Address->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_counterlog_IP_Address"><?= $Page->IP_Address->caption() ?><?= $Page->IP_Address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->IP_Address->cellAttributes() ?>>
<span id="el_stats_counterlog_IP_Address">
<input type="<?= $Page->IP_Address->getInputTextType() ?>" name="x_IP_Address" id="x_IP_Address" data-table="stats_counterlog" data-field="x_IP_Address" value="<?= $Page->IP_Address->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->IP_Address->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->IP_Address->formatPattern()) ?>"<?= $Page->IP_Address->editAttributes() ?> aria-describedby="x_IP_Address_help">
<?= $Page->IP_Address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->IP_Address->getErrorMessage() ?></div>
<input type="hidden" data-table="stats_counterlog" data-field="x_IP_Address" data-hidden="1" data-old name="o_IP_Address" id="o_IP_Address" value="<?= HtmlEncode($Page->IP_Address->OldValue ?? $Page->IP_Address->CurrentValue) ?>">
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Hostname->Visible) { // Hostname ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Hostname"<?= $Page->Hostname->rowAttributes() ?>>
        <label id="elh_stats_counterlog_Hostname" for="x_Hostname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Hostname->caption() ?><?= $Page->Hostname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Hostname->cellAttributes() ?>>
<span id="el_stats_counterlog_Hostname">
<input type="<?= $Page->Hostname->getInputTextType() ?>" name="x_Hostname" id="x_Hostname" data-table="stats_counterlog" data-field="x_Hostname" value="<?= $Page->Hostname->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Hostname->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Hostname->formatPattern()) ?>"<?= $Page->Hostname->editAttributes() ?> aria-describedby="x_Hostname_help">
<?= $Page->Hostname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Hostname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Hostname"<?= $Page->Hostname->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_counterlog_Hostname"><?= $Page->Hostname->caption() ?><?= $Page->Hostname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Hostname->cellAttributes() ?>>
<span id="el_stats_counterlog_Hostname">
<input type="<?= $Page->Hostname->getInputTextType() ?>" name="x_Hostname" id="x_Hostname" data-table="stats_counterlog" data-field="x_Hostname" value="<?= $Page->Hostname->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Hostname->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Hostname->formatPattern()) ?>"<?= $Page->Hostname->editAttributes() ?> aria-describedby="x_Hostname_help">
<?= $Page->Hostname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Hostname->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->First_Visit->Visible) { // First_Visit ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_First_Visit"<?= $Page->First_Visit->rowAttributes() ?>>
        <label id="elh_stats_counterlog_First_Visit" for="x_First_Visit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->First_Visit->caption() ?><?= $Page->First_Visit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->First_Visit->cellAttributes() ?>>
<span id="el_stats_counterlog_First_Visit">
<input type="<?= $Page->First_Visit->getInputTextType() ?>" name="x_First_Visit" id="x_First_Visit" data-table="stats_counterlog" data-field="x_First_Visit" value="<?= $Page->First_Visit->EditValue ?>" placeholder="<?= HtmlEncode($Page->First_Visit->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->First_Visit->formatPattern()) ?>"<?= $Page->First_Visit->editAttributes() ?> aria-describedby="x_First_Visit_help">
<?= $Page->First_Visit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->First_Visit->getErrorMessage() ?></div>
<?php if (!$Page->First_Visit->ReadOnly && !$Page->First_Visit->Disabled && !isset($Page->First_Visit->EditAttrs["readonly"]) && !isset($Page->First_Visit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fstats_counterlogedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(1) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.isDark() ? "dark" : "auto"
            }
        };
    ew.createDateTimePicker("fstats_counterlogedit", "x_First_Visit", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_First_Visit"<?= $Page->First_Visit->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_counterlog_First_Visit"><?= $Page->First_Visit->caption() ?><?= $Page->First_Visit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->First_Visit->cellAttributes() ?>>
<span id="el_stats_counterlog_First_Visit">
<input type="<?= $Page->First_Visit->getInputTextType() ?>" name="x_First_Visit" id="x_First_Visit" data-table="stats_counterlog" data-field="x_First_Visit" value="<?= $Page->First_Visit->EditValue ?>" placeholder="<?= HtmlEncode($Page->First_Visit->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->First_Visit->formatPattern()) ?>"<?= $Page->First_Visit->editAttributes() ?> aria-describedby="x_First_Visit_help">
<?= $Page->First_Visit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->First_Visit->getErrorMessage() ?></div>
<?php if (!$Page->First_Visit->ReadOnly && !$Page->First_Visit->Disabled && !isset($Page->First_Visit->EditAttrs["readonly"]) && !isset($Page->First_Visit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fstats_counterlogedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(1) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.isDark() ? "dark" : "auto"
            }
        };
    ew.createDateTimePicker("fstats_counterlogedit", "x_First_Visit", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Last_Visit->Visible) { // Last_Visit ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Last_Visit"<?= $Page->Last_Visit->rowAttributes() ?>>
        <label id="elh_stats_counterlog_Last_Visit" for="x_Last_Visit" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Last_Visit->caption() ?><?= $Page->Last_Visit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Last_Visit->cellAttributes() ?>>
<span id="el_stats_counterlog_Last_Visit">
<input type="<?= $Page->Last_Visit->getInputTextType() ?>" name="x_Last_Visit" id="x_Last_Visit" data-table="stats_counterlog" data-field="x_Last_Visit" value="<?= $Page->Last_Visit->EditValue ?>" placeholder="<?= HtmlEncode($Page->Last_Visit->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Last_Visit->formatPattern()) ?>"<?= $Page->Last_Visit->editAttributes() ?> aria-describedby="x_Last_Visit_help">
<?= $Page->Last_Visit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Last_Visit->getErrorMessage() ?></div>
<?php if (!$Page->Last_Visit->ReadOnly && !$Page->Last_Visit->Disabled && !isset($Page->Last_Visit->EditAttrs["readonly"]) && !isset($Page->Last_Visit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fstats_counterlogedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(1) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.isDark() ? "dark" : "auto"
            }
        };
    ew.createDateTimePicker("fstats_counterlogedit", "x_Last_Visit", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Last_Visit"<?= $Page->Last_Visit->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_counterlog_Last_Visit"><?= $Page->Last_Visit->caption() ?><?= $Page->Last_Visit->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Last_Visit->cellAttributes() ?>>
<span id="el_stats_counterlog_Last_Visit">
<input type="<?= $Page->Last_Visit->getInputTextType() ?>" name="x_Last_Visit" id="x_Last_Visit" data-table="stats_counterlog" data-field="x_Last_Visit" value="<?= $Page->Last_Visit->EditValue ?>" placeholder="<?= HtmlEncode($Page->Last_Visit->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Last_Visit->formatPattern()) ?>"<?= $Page->Last_Visit->editAttributes() ?> aria-describedby="x_Last_Visit_help">
<?= $Page->Last_Visit->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Last_Visit->getErrorMessage() ?></div>
<?php if (!$Page->Last_Visit->ReadOnly && !$Page->Last_Visit->Disabled && !isset($Page->Last_Visit->EditAttrs["readonly"]) && !isset($Page->Last_Visit->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fstats_counterlogedit", "datetimepicker"], function () {
    let format = "<?= DateFormat(1) ?>",
        options = {
            localization: {
                locale: ew.LANGUAGE_ID + "-u-nu-" + ew.getNumberingSystem(),
                hourCycle: format.match(/H/) ? "h24" : "h12",
                format,
                ...ew.language.phrase("datetimepicker")
            },
            display: {
                icons: {
                    previous: ew.IS_RTL ? "fa-solid fa-chevron-right" : "fa-solid fa-chevron-left",
                    next: ew.IS_RTL ? "fa-solid fa-chevron-left" : "fa-solid fa-chevron-right"
                },
                components: {
                    hours: !!format.match(/h/i),
                    minutes: !!format.match(/m/),
                    seconds: !!format.match(/s/i)
                },
                theme: ew.isDark() ? "dark" : "auto"
            }
        };
    ew.createDateTimePicker("fstats_counterlogedit", "x_Last_Visit", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Counter->Visible) { // Counter ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Counter"<?= $Page->Counter->rowAttributes() ?>>
        <label id="elh_stats_counterlog_Counter" for="x_Counter" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Counter->caption() ?><?= $Page->Counter->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Counter->cellAttributes() ?>>
<span id="el_stats_counterlog_Counter">
<input type="<?= $Page->Counter->getInputTextType() ?>" name="x_Counter" id="x_Counter" data-table="stats_counterlog" data-field="x_Counter" value="<?= $Page->Counter->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Counter->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Counter->formatPattern()) ?>"<?= $Page->Counter->editAttributes() ?> aria-describedby="x_Counter_help">
<?= $Page->Counter->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Counter->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fstats_counterlogedit", "jquerynumber"], function() {
	ew.createjQueryNumber("fstats_counterlogedit", "x_Counter", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Counter"<?= $Page->Counter->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_stats_counterlog_Counter"><?= $Page->Counter->caption() ?><?= $Page->Counter->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Counter->cellAttributes() ?>>
<span id="el_stats_counterlog_Counter">
<input type="<?= $Page->Counter->getInputTextType() ?>" name="x_Counter" id="x_Counter" data-table="stats_counterlog" data-field="x_Counter" value="<?= $Page->Counter->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Counter->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Counter->formatPattern()) ?>"<?= $Page->Counter->editAttributes() ?> aria-describedby="x_Counter_help">
<?= $Page->Counter->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Counter->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fstats_counterlogedit", "jquerynumber"], function() {
	ew.createjQueryNumber("fstats_counterlogedit", "x_Counter", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fstats_counterlogedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fstats_counterlogedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("stats_counterlog");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fstats_counterlogedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fstats_counterlogedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fstats_counterlogedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
