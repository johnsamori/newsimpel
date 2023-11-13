<?php

namespace PHPMaker2023\new2023;

// Page object
$UserlevelsEdit = &$Page;
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
<form name="fuserlevelsedit" id="fuserlevelsedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { userlevels: currentTable } });
var currentPageID = ew.PAGE_ID = "edit";
var currentForm;
var fuserlevelsedit;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fuserlevelsedit")
        .setPageId("edit")

        // Add fields
        .setFields([
            ["User_Level_ID", [fields.User_Level_ID.visible && fields.User_Level_ID.required ? ew.Validators.required(fields.User_Level_ID.caption) : null, ew.Validators.userLevelId, ew.Validators.integer], fields.User_Level_ID.isInvalid],
            ["User_Level_Name", [fields.User_Level_Name.visible && fields.User_Level_Name.required ? ew.Validators.required(fields.User_Level_Name.caption) : null, ew.Validators.userLevelName('User_Level_ID')], fields.User_Level_Name.isInvalid]
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
<input type="hidden" name="t" value="userlevels">
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
<table id="tbl_userlevelsedit" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->User_Level_ID->Visible) { // User_Level_ID ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_User_Level_ID"<?= $Page->User_Level_ID->rowAttributes() ?>>
        <label id="elh_userlevels_User_Level_ID" for="x_User_Level_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->User_Level_ID->caption() ?><?= $Page->User_Level_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->User_Level_ID->cellAttributes() ?>>
<span id="el_userlevels_User_Level_ID">
<input type="<?= $Page->User_Level_ID->getInputTextType() ?>" name="x_User_Level_ID" id="x_User_Level_ID" data-table="userlevels" data-field="x_User_Level_ID" value="<?= $Page->User_Level_ID->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->User_Level_ID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->User_Level_ID->formatPattern()) ?>"<?= $Page->User_Level_ID->editAttributes() ?> aria-describedby="x_User_Level_ID_help">
<?= $Page->User_Level_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->User_Level_ID->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fuserlevelsedit", "jquerynumber"], function() {
	ew.createjQueryNumber("fuserlevelsedit", "x_User_Level_ID", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
<input type="hidden" data-table="userlevels" data-field="x_User_Level_ID" data-hidden="1" data-old name="o_User_Level_ID" id="o_User_Level_ID" value="<?= HtmlEncode($Page->User_Level_ID->OldValue ?? $Page->User_Level_ID->CurrentValue) ?>">
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_User_Level_ID"<?= $Page->User_Level_ID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevels_User_Level_ID"><?= $Page->User_Level_ID->caption() ?><?= $Page->User_Level_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->User_Level_ID->cellAttributes() ?>>
<span id="el_userlevels_User_Level_ID">
<input type="<?= $Page->User_Level_ID->getInputTextType() ?>" name="x_User_Level_ID" id="x_User_Level_ID" data-table="userlevels" data-field="x_User_Level_ID" value="<?= $Page->User_Level_ID->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->User_Level_ID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->User_Level_ID->formatPattern()) ?>"<?= $Page->User_Level_ID->editAttributes() ?> aria-describedby="x_User_Level_ID_help">
<?= $Page->User_Level_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->User_Level_ID->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fuserlevelsedit", "jquerynumber"], function() {
	ew.createjQueryNumber("fuserlevelsedit", "x_User_Level_ID", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
<input type="hidden" data-table="userlevels" data-field="x_User_Level_ID" data-hidden="1" data-old name="o_User_Level_ID" id="o_User_Level_ID" value="<?= HtmlEncode($Page->User_Level_ID->OldValue ?? $Page->User_Level_ID->CurrentValue) ?>">
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->User_Level_Name->Visible) { // User_Level_Name ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_User_Level_Name"<?= $Page->User_Level_Name->rowAttributes() ?>>
        <label id="elh_userlevels_User_Level_Name" for="x_User_Level_Name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->User_Level_Name->caption() ?><?= $Page->User_Level_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->User_Level_Name->cellAttributes() ?>>
<span id="el_userlevels_User_Level_Name">
<input type="<?= $Page->User_Level_Name->getInputTextType() ?>" name="x_User_Level_Name" id="x_User_Level_Name" data-table="userlevels" data-field="x_User_Level_Name" value="<?= $Page->User_Level_Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->User_Level_Name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->User_Level_Name->formatPattern()) ?>"<?= $Page->User_Level_Name->editAttributes() ?> aria-describedby="x_User_Level_Name_help">
<?= $Page->User_Level_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->User_Level_Name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_User_Level_Name"<?= $Page->User_Level_Name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevels_User_Level_Name"><?= $Page->User_Level_Name->caption() ?><?= $Page->User_Level_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->User_Level_Name->cellAttributes() ?>>
<span id="el_userlevels_User_Level_Name">
<input type="<?= $Page->User_Level_Name->getInputTextType() ?>" name="x_User_Level_Name" id="x_User_Level_Name" data-table="userlevels" data-field="x_User_Level_Name" value="<?= $Page->User_Level_Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->User_Level_Name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->User_Level_Name->formatPattern()) ?>"<?= $Page->User_Level_Name->editAttributes() ?> aria-describedby="x_User_Level_Name_help">
<?= $Page->User_Level_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->User_Level_Name->getErrorMessage() ?></div>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fuserlevelsedit"><?= $Language->phrase("SaveBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fuserlevelsedit" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("userlevels");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fuserlevelsedit:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fuserlevelsedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fuserlevelsedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
