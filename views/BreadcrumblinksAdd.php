<?php

namespace PHPMaker2023\new2023;

// Page object
$BreadcrumblinksAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { breadcrumblinks: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fbreadcrumblinksadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fbreadcrumblinksadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["Page_Title", [fields.Page_Title.visible && fields.Page_Title.required ? ew.Validators.required(fields.Page_Title.caption) : null], fields.Page_Title.isInvalid],
            ["Page_URL", [fields.Page_URL.visible && fields.Page_URL.required ? ew.Validators.required(fields.Page_URL.caption) : null], fields.Page_URL.isInvalid],
            ["Lft", [fields.Lft.visible && fields.Lft.required ? ew.Validators.required(fields.Lft.caption) : null, ew.Validators.integer], fields.Lft.isInvalid],
            ["Rgt", [fields.Rgt.visible && fields.Rgt.required ? ew.Validators.required(fields.Rgt.caption) : null, ew.Validators.integer], fields.Rgt.isInvalid]
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
<form name="fbreadcrumblinksadd" id="fbreadcrumblinksadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="breadcrumblinks">
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
<table id="tbl_breadcrumblinksadd" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->Page_Title->Visible) { // Page_Title ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Page_Title"<?= $Page->Page_Title->rowAttributes() ?>>
        <label id="elh_breadcrumblinks_Page_Title" for="x_Page_Title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Page_Title->caption() ?><?= $Page->Page_Title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Page_Title->cellAttributes() ?>>
<span id="el_breadcrumblinks_Page_Title">
<input type="<?= $Page->Page_Title->getInputTextType() ?>" name="x_Page_Title" id="x_Page_Title" data-table="breadcrumblinks" data-field="x_Page_Title" value="<?= $Page->Page_Title->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Page_Title->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Page_Title->formatPattern()) ?>"<?= $Page->Page_Title->editAttributes() ?> aria-describedby="x_Page_Title_help">
<?= $Page->Page_Title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Page_Title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Page_Title"<?= $Page->Page_Title->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_breadcrumblinks_Page_Title"><?= $Page->Page_Title->caption() ?><?= $Page->Page_Title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Page_Title->cellAttributes() ?>>
<span id="el_breadcrumblinks_Page_Title">
<input type="<?= $Page->Page_Title->getInputTextType() ?>" name="x_Page_Title" id="x_Page_Title" data-table="breadcrumblinks" data-field="x_Page_Title" value="<?= $Page->Page_Title->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Page_Title->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Page_Title->formatPattern()) ?>"<?= $Page->Page_Title->editAttributes() ?> aria-describedby="x_Page_Title_help">
<?= $Page->Page_Title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Page_Title->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Page_URL->Visible) { // Page_URL ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Page_URL"<?= $Page->Page_URL->rowAttributes() ?>>
        <label id="elh_breadcrumblinks_Page_URL" for="x_Page_URL" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Page_URL->caption() ?><?= $Page->Page_URL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Page_URL->cellAttributes() ?>>
<span id="el_breadcrumblinks_Page_URL">
<input type="<?= $Page->Page_URL->getInputTextType() ?>" name="x_Page_URL" id="x_Page_URL" data-table="breadcrumblinks" data-field="x_Page_URL" value="<?= $Page->Page_URL->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Page_URL->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Page_URL->formatPattern()) ?>"<?= $Page->Page_URL->editAttributes() ?> aria-describedby="x_Page_URL_help">
<?= $Page->Page_URL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Page_URL->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Page_URL"<?= $Page->Page_URL->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_breadcrumblinks_Page_URL"><?= $Page->Page_URL->caption() ?><?= $Page->Page_URL->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Page_URL->cellAttributes() ?>>
<span id="el_breadcrumblinks_Page_URL">
<input type="<?= $Page->Page_URL->getInputTextType() ?>" name="x_Page_URL" id="x_Page_URL" data-table="breadcrumblinks" data-field="x_Page_URL" value="<?= $Page->Page_URL->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Page_URL->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Page_URL->formatPattern()) ?>"<?= $Page->Page_URL->editAttributes() ?> aria-describedby="x_Page_URL_help">
<?= $Page->Page_URL->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Page_URL->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Lft->Visible) { // Lft ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Lft"<?= $Page->Lft->rowAttributes() ?>>
        <label id="elh_breadcrumblinks_Lft" for="x_Lft" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Lft->caption() ?><?= $Page->Lft->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Lft->cellAttributes() ?>>
<span id="el_breadcrumblinks_Lft">
<input type="<?= $Page->Lft->getInputTextType() ?>" name="x_Lft" id="x_Lft" data-table="breadcrumblinks" data-field="x_Lft" value="<?= $Page->Lft->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Lft->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Lft->formatPattern()) ?>"<?= $Page->Lft->editAttributes() ?> aria-describedby="x_Lft_help">
<?= $Page->Lft->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Lft->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fbreadcrumblinksadd", "jquerynumber"], function() {
	ew.createjQueryNumber("fbreadcrumblinksadd", "x_Lft", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Lft"<?= $Page->Lft->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_breadcrumblinks_Lft"><?= $Page->Lft->caption() ?><?= $Page->Lft->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Lft->cellAttributes() ?>>
<span id="el_breadcrumblinks_Lft">
<input type="<?= $Page->Lft->getInputTextType() ?>" name="x_Lft" id="x_Lft" data-table="breadcrumblinks" data-field="x_Lft" value="<?= $Page->Lft->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Lft->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Lft->formatPattern()) ?>"<?= $Page->Lft->editAttributes() ?> aria-describedby="x_Lft_help">
<?= $Page->Lft->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Lft->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fbreadcrumblinksadd", "jquerynumber"], function() {
	ew.createjQueryNumber("fbreadcrumblinksadd", "x_Lft", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Rgt->Visible) { // Rgt ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Rgt"<?= $Page->Rgt->rowAttributes() ?>>
        <label id="elh_breadcrumblinks_Rgt" for="x_Rgt" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Rgt->caption() ?><?= $Page->Rgt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Rgt->cellAttributes() ?>>
<span id="el_breadcrumblinks_Rgt">
<input type="<?= $Page->Rgt->getInputTextType() ?>" name="x_Rgt" id="x_Rgt" data-table="breadcrumblinks" data-field="x_Rgt" value="<?= $Page->Rgt->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Rgt->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Rgt->formatPattern()) ?>"<?= $Page->Rgt->editAttributes() ?> aria-describedby="x_Rgt_help">
<?= $Page->Rgt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Rgt->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fbreadcrumblinksadd", "jquerynumber"], function() {
	ew.createjQueryNumber("fbreadcrumblinksadd", "x_Rgt", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Rgt"<?= $Page->Rgt->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_breadcrumblinks_Rgt"><?= $Page->Rgt->caption() ?><?= $Page->Rgt->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Rgt->cellAttributes() ?>>
<span id="el_breadcrumblinks_Rgt">
<input type="<?= $Page->Rgt->getInputTextType() ?>" name="x_Rgt" id="x_Rgt" data-table="breadcrumblinks" data-field="x_Rgt" value="<?= $Page->Rgt->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Rgt->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Rgt->formatPattern()) ?>"<?= $Page->Rgt->editAttributes() ?> aria-describedby="x_Rgt_help">
<?= $Page->Rgt->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Rgt->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fbreadcrumblinksadd", "jquerynumber"], function() {
	ew.createjQueryNumber("fbreadcrumblinksadd", "x_Rgt", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fbreadcrumblinksadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fbreadcrumblinksadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("breadcrumblinks");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fbreadcrumblinksadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fbreadcrumblinksadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fbreadcrumblinksadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
