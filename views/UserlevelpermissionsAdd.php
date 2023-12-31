<?php

namespace PHPMaker2023\new2023;

// Page object
$UserlevelpermissionsAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { userlevelpermissions: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fuserlevelpermissionsadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fuserlevelpermissionsadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["User_Level_ID", [fields.User_Level_ID.visible && fields.User_Level_ID.required ? ew.Validators.required(fields.User_Level_ID.caption) : null, ew.Validators.integer], fields.User_Level_ID.isInvalid],
            ["Table_Name", [fields.Table_Name.visible && fields.Table_Name.required ? ew.Validators.required(fields.Table_Name.caption) : null], fields.Table_Name.isInvalid],
            ["_Permission", [fields._Permission.visible && fields._Permission.required ? ew.Validators.required(fields._Permission.caption) : null, ew.Validators.integer], fields._Permission.isInvalid]
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
<form name="fuserlevelpermissionsadd" id="fuserlevelpermissionsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="userlevelpermissions">
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
<table id="tbl_userlevelpermissionsadd" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->User_Level_ID->Visible) { // User_Level_ID ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_User_Level_ID"<?= $Page->User_Level_ID->rowAttributes() ?>>
        <label id="elh_userlevelpermissions_User_Level_ID" for="x_User_Level_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->User_Level_ID->caption() ?><?= $Page->User_Level_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->User_Level_ID->cellAttributes() ?>>
<span id="el_userlevelpermissions_User_Level_ID">
<input type="<?= $Page->User_Level_ID->getInputTextType() ?>" name="x_User_Level_ID" id="x_User_Level_ID" data-table="userlevelpermissions" data-field="x_User_Level_ID" value="<?= $Page->User_Level_ID->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->User_Level_ID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->User_Level_ID->formatPattern()) ?>"<?= $Page->User_Level_ID->editAttributes() ?> aria-describedby="x_User_Level_ID_help">
<?= $Page->User_Level_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->User_Level_ID->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fuserlevelpermissionsadd", "jquerynumber"], function() {
	ew.createjQueryNumber("fuserlevelpermissionsadd", "x_User_Level_ID", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_User_Level_ID"<?= $Page->User_Level_ID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevelpermissions_User_Level_ID"><?= $Page->User_Level_ID->caption() ?><?= $Page->User_Level_ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->User_Level_ID->cellAttributes() ?>>
<span id="el_userlevelpermissions_User_Level_ID">
<input type="<?= $Page->User_Level_ID->getInputTextType() ?>" name="x_User_Level_ID" id="x_User_Level_ID" data-table="userlevelpermissions" data-field="x_User_Level_ID" value="<?= $Page->User_Level_ID->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->User_Level_ID->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->User_Level_ID->formatPattern()) ?>"<?= $Page->User_Level_ID->editAttributes() ?> aria-describedby="x_User_Level_ID_help">
<?= $Page->User_Level_ID->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->User_Level_ID->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fuserlevelpermissionsadd", "jquerynumber"], function() {
	ew.createjQueryNumber("fuserlevelpermissionsadd", "x_User_Level_ID", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Table_Name->Visible) { // Table_Name ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Table_Name"<?= $Page->Table_Name->rowAttributes() ?>>
        <label id="elh_userlevelpermissions_Table_Name" for="x_Table_Name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Table_Name->caption() ?><?= $Page->Table_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Table_Name->cellAttributes() ?>>
<span id="el_userlevelpermissions_Table_Name">
<input type="<?= $Page->Table_Name->getInputTextType() ?>" name="x_Table_Name" id="x_Table_Name" data-table="userlevelpermissions" data-field="x_Table_Name" value="<?= $Page->Table_Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Table_Name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Table_Name->formatPattern()) ?>"<?= $Page->Table_Name->editAttributes() ?> aria-describedby="x_Table_Name_help">
<?= $Page->Table_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Table_Name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Table_Name"<?= $Page->Table_Name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevelpermissions_Table_Name"><?= $Page->Table_Name->caption() ?><?= $Page->Table_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Table_Name->cellAttributes() ?>>
<span id="el_userlevelpermissions_Table_Name">
<input type="<?= $Page->Table_Name->getInputTextType() ?>" name="x_Table_Name" id="x_Table_Name" data-table="userlevelpermissions" data-field="x_Table_Name" value="<?= $Page->Table_Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Table_Name->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Table_Name->formatPattern()) ?>"<?= $Page->Table_Name->editAttributes() ?> aria-describedby="x_Table_Name_help">
<?= $Page->Table_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Table_Name->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->_Permission->Visible) { // Permission ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r__Permission"<?= $Page->_Permission->rowAttributes() ?>>
        <label id="elh_userlevelpermissions__Permission" for="x__Permission" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Permission->caption() ?><?= $Page->_Permission->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Permission->cellAttributes() ?>>
<span id="el_userlevelpermissions__Permission">
<input type="<?= $Page->_Permission->getInputTextType() ?>" name="x__Permission" id="x__Permission" data-table="userlevelpermissions" data-field="x__Permission" value="<?= $Page->_Permission->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->_Permission->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Permission->formatPattern()) ?>"<?= $Page->_Permission->editAttributes() ?> aria-describedby="x__Permission_help">
<?= $Page->_Permission->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Permission->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fuserlevelpermissionsadd", "jquerynumber"], function() {
	ew.createjQueryNumber("fuserlevelpermissionsadd", "x__Permission", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r__Permission"<?= $Page->_Permission->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_userlevelpermissions__Permission"><?= $Page->_Permission->caption() ?><?= $Page->_Permission->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->_Permission->cellAttributes() ?>>
<span id="el_userlevelpermissions__Permission">
<input type="<?= $Page->_Permission->getInputTextType() ?>" name="x__Permission" id="x__Permission" data-table="userlevelpermissions" data-field="x__Permission" value="<?= $Page->_Permission->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->_Permission->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->_Permission->formatPattern()) ?>"<?= $Page->_Permission->editAttributes() ?> aria-describedby="x__Permission_help">
<?= $Page->_Permission->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Permission->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fuserlevelpermissionsadd", "jquerynumber"], function() {
	ew.createjQueryNumber("fuserlevelpermissionsadd", "x__Permission", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fuserlevelpermissionsadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fuserlevelpermissionsadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("userlevelpermissions");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fuserlevelpermissionsadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fuserlevelpermissionsadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fuserlevelpermissionsadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
