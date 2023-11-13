<?php

namespace PHPMaker2023\new2023;

// Page object
$HelpAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { help: currentTable } });
var currentPageID = ew.PAGE_ID = "add";
var currentForm;
var fhelpadd;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fhelpadd")
        .setPageId("add")

        // Add fields
        .setFields([
            ["_Language", [fields._Language.visible && fields._Language.required ? ew.Validators.required(fields._Language.caption) : null], fields._Language.isInvalid],
            ["Topic", [fields.Topic.visible && fields.Topic.required ? ew.Validators.required(fields.Topic.caption) : null], fields.Topic.isInvalid],
            ["Description", [fields.Description.visible && fields.Description.required ? ew.Validators.required(fields.Description.caption) : null], fields.Description.isInvalid],
            ["Category", [fields.Category.visible && fields.Category.required ? ew.Validators.required(fields.Category.caption) : null], fields.Category.isInvalid],
            ["Order", [fields.Order.visible && fields.Order.required ? ew.Validators.required(fields.Order.caption) : null, ew.Validators.integer], fields.Order.isInvalid],
            ["Display_in_Page", [fields.Display_in_Page.visible && fields.Display_in_Page.required ? ew.Validators.required(fields.Display_in_Page.caption) : null], fields.Display_in_Page.isInvalid],
            ["Updated_By", [fields.Updated_By.visible && fields.Updated_By.required ? ew.Validators.required(fields.Updated_By.caption) : null], fields.Updated_By.isInvalid],
            ["Last_Updated", [fields.Last_Updated.visible && fields.Last_Updated.required ? ew.Validators.required(fields.Last_Updated.caption) : null, ew.Validators.datetime(fields.Last_Updated.clientFormatPattern)], fields.Last_Updated.isInvalid]
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
            "_Language": <?= $Page->_Language->toClientList($Page) ?>,
            "Category": <?= $Page->Category->toClientList($Page) ?>,
            "Updated_By": <?= $Page->Updated_By->toClientList($Page) ?>,
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
<form name="fhelpadd" id="fhelpadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="help">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<?php if (IsJsonResponse()) { ?>
<input type="hidden" name="json" value="1">
<?php } ?>
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<?php if ($Page->getCurrentMasterTable() == "help_categories") { ?>
<input type="hidden" name="<?= Config("TABLE_SHOW_MASTER") ?>" value="help_categories">
<input type="hidden" name="fk_Category_ID" value="<?= HtmlEncode($Page->Category->getSessionValue()) ?>">
<?php } ?>
<?php if (!$Page->IsMobileOrModal) { ?>
<div class="ew-desktop"><!-- desktop -->
<?php } ?>
<?php if ($Page->IsMobileOrModal) { ?>
<div class="ew-add-div"><!-- page* -->
<?php } else { ?>
<table id="tbl_helpadd" class="<?= $Page->TableClass ?>"><!-- table* -->
<?php } ?>
<?php if ($Page->_Language->Visible) { // Language ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r__Language"<?= $Page->_Language->rowAttributes() ?>>
        <label id="elh_help__Language" for="x__Language" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Language->caption() ?><?= $Page->_Language->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Language->cellAttributes() ?>>
<span id="el_help__Language">
    <select
        id="x__Language"
        name="x__Language"
        class="form-select ew-select<?= $Page->_Language->isInvalidClass() ?>"
        <?php if (!$Page->_Language->IsNativeSelect) { ?>
        data-select2-id="fhelpadd_x__Language"
        <?php } ?>
        data-table="help"
        data-field="x__Language"
        data-value-separator="<?= $Page->_Language->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->_Language->getPlaceHolder()) ?>"
        <?= $Page->_Language->editAttributes() ?>>
        <?= $Page->_Language->selectOptionListHtml("x__Language") ?>
    </select>
    <?= $Page->_Language->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->_Language->getErrorMessage() ?></div>
<?= $Page->_Language->Lookup->getParamTag($Page, "p_x__Language") ?>
<?php if (!$Page->_Language->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpadd", function() {
    var options = { name: "x__Language", selectId: "fhelpadd_x__Language" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpadd.lists._Language?.lookupOptions.length) {
        options.data = { id: "x__Language", form: "fhelpadd" };
    } else {
        options.ajax = { id: "x__Language", form: "fhelpadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields._Language.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r__Language"<?= $Page->_Language->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_help__Language"><?= $Page->_Language->caption() ?><?= $Page->_Language->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->_Language->cellAttributes() ?>>
<span id="el_help__Language">
    <select
        id="x__Language"
        name="x__Language"
        class="form-select ew-select<?= $Page->_Language->isInvalidClass() ?>"
        <?php if (!$Page->_Language->IsNativeSelect) { ?>
        data-select2-id="fhelpadd_x__Language"
        <?php } ?>
        data-table="help"
        data-field="x__Language"
        data-value-separator="<?= $Page->_Language->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->_Language->getPlaceHolder()) ?>"
        <?= $Page->_Language->editAttributes() ?>>
        <?= $Page->_Language->selectOptionListHtml("x__Language") ?>
    </select>
    <?= $Page->_Language->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->_Language->getErrorMessage() ?></div>
<?= $Page->_Language->Lookup->getParamTag($Page, "p_x__Language") ?>
<?php if (!$Page->_Language->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpadd", function() {
    var options = { name: "x__Language", selectId: "fhelpadd_x__Language" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpadd.lists._Language?.lookupOptions.length) {
        options.data = { id: "x__Language", form: "fhelpadd" };
    } else {
        options.ajax = { id: "x__Language", form: "fhelpadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields._Language.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Topic->Visible) { // Topic ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Topic"<?= $Page->Topic->rowAttributes() ?>>
        <label id="elh_help_Topic" for="x_Topic" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Topic->caption() ?><?= $Page->Topic->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Topic->cellAttributes() ?>>
<span id="el_help_Topic">
<input type="<?= $Page->Topic->getInputTextType() ?>" name="x_Topic" id="x_Topic" data-table="help" data-field="x_Topic" value="<?= $Page->Topic->EditValue ?>" size="50" maxlength="255" placeholder="<?= HtmlEncode($Page->Topic->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Topic->formatPattern()) ?>"<?= $Page->Topic->editAttributes() ?> aria-describedby="x_Topic_help">
<?= $Page->Topic->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Topic->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Topic"<?= $Page->Topic->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_help_Topic"><?= $Page->Topic->caption() ?><?= $Page->Topic->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Topic->cellAttributes() ?>>
<span id="el_help_Topic">
<input type="<?= $Page->Topic->getInputTextType() ?>" name="x_Topic" id="x_Topic" data-table="help" data-field="x_Topic" value="<?= $Page->Topic->EditValue ?>" size="50" maxlength="255" placeholder="<?= HtmlEncode($Page->Topic->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Topic->formatPattern()) ?>"<?= $Page->Topic->editAttributes() ?> aria-describedby="x_Topic_help">
<?= $Page->Topic->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Topic->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <label id="elh_help_Description" for="x_Description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Description->caption() ?><?= $Page->Description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Description->cellAttributes() ?>>
<span id="el_help_Description">
<textarea data-table="help" data-field="x_Description" name="x_Description" id="x_Description" cols="50" rows="5" placeholder="<?= HtmlEncode($Page->Description->getPlaceHolder()) ?>"<?= $Page->Description->editAttributes() ?> aria-describedby="x_Description_help"><?= $Page->Description->EditValue ?></textarea>
<?= $Page->Description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_help_Description"><?= $Page->Description->caption() ?><?= $Page->Description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Description->cellAttributes() ?>>
<span id="el_help_Description">
<textarea data-table="help" data-field="x_Description" name="x_Description" id="x_Description" cols="50" rows="5" placeholder="<?= HtmlEncode($Page->Description->getPlaceHolder()) ?>"<?= $Page->Description->editAttributes() ?> aria-describedby="x_Description_help"><?= $Page->Description->EditValue ?></textarea>
<?= $Page->Description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Description->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Category->Visible) { // Category ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Category"<?= $Page->Category->rowAttributes() ?>>
        <label id="elh_help_Category" for="x_Category" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Category->caption() ?><?= $Page->Category->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Category->cellAttributes() ?>>
<?php if ($Page->Category->getSessionValue() != "") { ?>
<span<?= $Page->Category->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->Category->getDisplayValue($Page->Category->ViewValue) ?></span></span>
<input type="hidden" id="x_Category" name="x_Category" value="<?= HtmlEncode($Page->Category->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_help_Category">
    <select
        id="x_Category"
        name="x_Category"
        class="form-select ew-select<?= $Page->Category->isInvalidClass() ?>"
        <?php if (!$Page->Category->IsNativeSelect) { ?>
        data-select2-id="fhelpadd_x_Category"
        <?php } ?>
        data-table="help"
        data-field="x_Category"
        data-value-separator="<?= $Page->Category->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Category->getPlaceHolder()) ?>"
        <?= $Page->Category->editAttributes() ?>>
        <?= $Page->Category->selectOptionListHtml("x_Category") ?>
    </select>
    <?= $Page->Category->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Category->getErrorMessage() ?></div>
<?= $Page->Category->Lookup->getParamTag($Page, "p_x_Category") ?>
<?php if (!$Page->Category->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpadd", function() {
    var options = { name: "x_Category", selectId: "fhelpadd_x_Category" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpadd.lists.Category?.lookupOptions.length) {
        options.data = { id: "x_Category", form: "fhelpadd" };
    } else {
        options.ajax = { id: "x_Category", form: "fhelpadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields.Category.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Category"<?= $Page->Category->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_help_Category"><?= $Page->Category->caption() ?><?= $Page->Category->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Category->cellAttributes() ?>>
<?php if ($Page->Category->getSessionValue() != "") { ?>
<span<?= $Page->Category->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Page->Category->getDisplayValue($Page->Category->ViewValue) ?></span></span>
<input type="hidden" id="x_Category" name="x_Category" value="<?= HtmlEncode($Page->Category->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el_help_Category">
    <select
        id="x_Category"
        name="x_Category"
        class="form-select ew-select<?= $Page->Category->isInvalidClass() ?>"
        <?php if (!$Page->Category->IsNativeSelect) { ?>
        data-select2-id="fhelpadd_x_Category"
        <?php } ?>
        data-table="help"
        data-field="x_Category"
        data-value-separator="<?= $Page->Category->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Category->getPlaceHolder()) ?>"
        <?= $Page->Category->editAttributes() ?>>
        <?= $Page->Category->selectOptionListHtml("x_Category") ?>
    </select>
    <?= $Page->Category->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Category->getErrorMessage() ?></div>
<?= $Page->Category->Lookup->getParamTag($Page, "p_x_Category") ?>
<?php if (!$Page->Category->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpadd", function() {
    var options = { name: "x_Category", selectId: "fhelpadd_x_Category" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpadd.lists.Category?.lookupOptions.length) {
        options.data = { id: "x_Category", form: "fhelpadd" };
    } else {
        options.ajax = { id: "x_Category", form: "fhelpadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields.Category.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Order->Visible) { // Order ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Order"<?= $Page->Order->rowAttributes() ?>>
        <label id="elh_help_Order" for="x_Order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Order->caption() ?><?= $Page->Order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Order->cellAttributes() ?>>
<span id="el_help_Order">
<input type="<?= $Page->Order->getInputTextType() ?>" name="x_Order" id="x_Order" data-table="help" data-field="x_Order" value="<?= $Page->Order->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Order->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Order->formatPattern()) ?>"<?= $Page->Order->editAttributes() ?> aria-describedby="x_Order_help">
<?= $Page->Order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Order->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fhelpadd", "jquerynumber"], function() {
	ew.createjQueryNumber("fhelpadd", "x_Order", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Order"<?= $Page->Order->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_help_Order"><?= $Page->Order->caption() ?><?= $Page->Order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Order->cellAttributes() ?>>
<span id="el_help_Order">
<input type="<?= $Page->Order->getInputTextType() ?>" name="x_Order" id="x_Order" data-table="help" data-field="x_Order" value="<?= $Page->Order->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Page->Order->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Order->formatPattern()) ?>"<?= $Page->Order->editAttributes() ?> aria-describedby="x_Order_help">
<?= $Page->Order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Order->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fhelpadd", "jquerynumber"], function() {
	ew.createjQueryNumber("fhelpadd", "x_Order", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Display_in_Page->Visible) { // Display_in_Page ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Display_in_Page"<?= $Page->Display_in_Page->rowAttributes() ?>>
        <label id="elh_help_Display_in_Page" for="x_Display_in_Page" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Display_in_Page->caption() ?><?= $Page->Display_in_Page->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Display_in_Page->cellAttributes() ?>>
<span id="el_help_Display_in_Page">
<input type="<?= $Page->Display_in_Page->getInputTextType() ?>" name="x_Display_in_Page" id="x_Display_in_Page" data-table="help" data-field="x_Display_in_Page" value="<?= $Page->Display_in_Page->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Display_in_Page->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Display_in_Page->formatPattern()) ?>"<?= $Page->Display_in_Page->editAttributes() ?> aria-describedby="x_Display_in_Page_help">
<?= $Page->Display_in_Page->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Display_in_Page->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Display_in_Page"<?= $Page->Display_in_Page->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_help_Display_in_Page"><?= $Page->Display_in_Page->caption() ?><?= $Page->Display_in_Page->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Display_in_Page->cellAttributes() ?>>
<span id="el_help_Display_in_Page">
<input type="<?= $Page->Display_in_Page->getInputTextType() ?>" name="x_Display_in_Page" id="x_Display_in_Page" data-table="help" data-field="x_Display_in_Page" value="<?= $Page->Display_in_Page->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Page->Display_in_Page->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Display_in_Page->formatPattern()) ?>"<?= $Page->Display_in_Page->editAttributes() ?> aria-describedby="x_Display_in_Page_help">
<?= $Page->Display_in_Page->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Display_in_Page->getErrorMessage() ?></div>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Updated_By->Visible) { // Updated_By ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Updated_By"<?= $Page->Updated_By->rowAttributes() ?>>
        <label id="elh_help_Updated_By" for="x_Updated_By" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Updated_By->caption() ?><?= $Page->Updated_By->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Updated_By->cellAttributes() ?>>
<span id="el_help_Updated_By">
    <select
        id="x_Updated_By"
        name="x_Updated_By"
        class="form-select ew-select<?= $Page->Updated_By->isInvalidClass() ?>"
        <?php if (!$Page->Updated_By->IsNativeSelect) { ?>
        data-select2-id="fhelpadd_x_Updated_By"
        <?php } ?>
        data-table="help"
        data-field="x_Updated_By"
        data-value-separator="<?= $Page->Updated_By->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Updated_By->getPlaceHolder()) ?>"
        <?= $Page->Updated_By->editAttributes() ?>>
        <?= $Page->Updated_By->selectOptionListHtml("x_Updated_By") ?>
    </select>
    <?= $Page->Updated_By->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Updated_By->getErrorMessage() ?></div>
<?= $Page->Updated_By->Lookup->getParamTag($Page, "p_x_Updated_By") ?>
<?php if (!$Page->Updated_By->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpadd", function() {
    var options = { name: "x_Updated_By", selectId: "fhelpadd_x_Updated_By" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpadd.lists.Updated_By?.lookupOptions.length) {
        options.data = { id: "x_Updated_By", form: "fhelpadd" };
    } else {
        options.ajax = { id: "x_Updated_By", form: "fhelpadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields.Updated_By.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Updated_By"<?= $Page->Updated_By->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_help_Updated_By"><?= $Page->Updated_By->caption() ?><?= $Page->Updated_By->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Updated_By->cellAttributes() ?>>
<span id="el_help_Updated_By">
    <select
        id="x_Updated_By"
        name="x_Updated_By"
        class="form-select ew-select<?= $Page->Updated_By->isInvalidClass() ?>"
        <?php if (!$Page->Updated_By->IsNativeSelect) { ?>
        data-select2-id="fhelpadd_x_Updated_By"
        <?php } ?>
        data-table="help"
        data-field="x_Updated_By"
        data-value-separator="<?= $Page->Updated_By->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Updated_By->getPlaceHolder()) ?>"
        <?= $Page->Updated_By->editAttributes() ?>>
        <?= $Page->Updated_By->selectOptionListHtml("x_Updated_By") ?>
    </select>
    <?= $Page->Updated_By->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Updated_By->getErrorMessage() ?></div>
<?= $Page->Updated_By->Lookup->getParamTag($Page, "p_x_Updated_By") ?>
<?php if (!$Page->Updated_By->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpadd", function() {
    var options = { name: "x_Updated_By", selectId: "fhelpadd_x_Updated_By" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpadd.lists.Updated_By?.lookupOptions.length) {
        options.data = { id: "x_Updated_By", form: "fhelpadd" };
    } else {
        options.ajax = { id: "x_Updated_By", form: "fhelpadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields.Updated_By.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
</td>
    </tr>
<?php } ?>
<?php } ?>
<?php if ($Page->Last_Updated->Visible) { // Last_Updated ?>
<?php if ($Page->IsMobileOrModal) { ?>
    <div id="r_Last_Updated"<?= $Page->Last_Updated->rowAttributes() ?>>
        <label id="elh_help_Last_Updated" for="x_Last_Updated" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Last_Updated->caption() ?><?= $Page->Last_Updated->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Last_Updated->cellAttributes() ?>>
<span id="el_help_Last_Updated">
<input type="<?= $Page->Last_Updated->getInputTextType() ?>" name="x_Last_Updated" id="x_Last_Updated" data-table="help" data-field="x_Last_Updated" value="<?= $Page->Last_Updated->EditValue ?>" placeholder="<?= HtmlEncode($Page->Last_Updated->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Last_Updated->formatPattern()) ?>"<?= $Page->Last_Updated->editAttributes() ?> aria-describedby="x_Last_Updated_help">
<?= $Page->Last_Updated->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Last_Updated->getErrorMessage() ?></div>
<?php if (!$Page->Last_Updated->ReadOnly && !$Page->Last_Updated->Disabled && !isset($Page->Last_Updated->EditAttrs["readonly"]) && !isset($Page->Last_Updated->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fhelpadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fhelpadd", "x_Last_Updated", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } else { ?>
    <tr id="r_Last_Updated"<?= $Page->Last_Updated->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_help_Last_Updated"><?= $Page->Last_Updated->caption() ?><?= $Page->Last_Updated->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></span></td>
        <td<?= $Page->Last_Updated->cellAttributes() ?>>
<span id="el_help_Last_Updated">
<input type="<?= $Page->Last_Updated->getInputTextType() ?>" name="x_Last_Updated" id="x_Last_Updated" data-table="help" data-field="x_Last_Updated" value="<?= $Page->Last_Updated->EditValue ?>" placeholder="<?= HtmlEncode($Page->Last_Updated->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Page->Last_Updated->formatPattern()) ?>"<?= $Page->Last_Updated->editAttributes() ?> aria-describedby="x_Last_Updated_help">
<?= $Page->Last_Updated->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Last_Updated->getErrorMessage() ?></div>
<?php if (!$Page->Last_Updated->ReadOnly && !$Page->Last_Updated->Disabled && !isset($Page->Last_Updated->EditAttrs["readonly"]) && !isset($Page->Last_Updated->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fhelpadd", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fhelpadd", "x_Last_Updated", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
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
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit" form="fhelpadd"><?= $Language->phrase("AddBtn") ?></button>
<?php if (IsJsonResponse()) { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-bs-dismiss="modal"><?= $Language->phrase("CancelBtn") ?></button>
<?php } else { ?>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" form="fhelpadd" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
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
    ew.addEventHandlers("help");
});
</script>
<?php if (Config("MS_ENTER_MOVING_CURSOR_TO_NEXT_FIELD")) { ?>
<script>
loadjs.ready("head", function() { $("#fhelpadd:first *:input[type!=hidden]:first").focus(),$("input").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("select").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()}),$("radio").keydown(function(i){if(13==i.which){var e=$(this).closest("form").find(":input:visible:enabled"),n=e.index(this);n==e.length-1||(e.eq(e.index(this)+1).focus(),i.preventDefault())}else 113==i.which&&$("#btn-action").click()})});
</script>
<?php } ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fhelpadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fhelpadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
