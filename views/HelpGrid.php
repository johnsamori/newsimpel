<?php

namespace PHPMaker2023\new2023;

// Set up and run Grid object
$Grid = Container("HelpGrid");
$Grid->run();
?>
<?php if (!$Grid->isExport()) { ?>
<script>
var fhelpgrid;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let currentTable = <?= JsonEncode($Grid->toClientVar()) ?>;
    ew.deepAssign(ew.vars, { tables: { help: currentTable } });
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("fhelpgrid")
        .setPageId("grid")
        .setFormKeyCountName("<?= $Grid->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["Help_ID", [fields.Help_ID.visible && fields.Help_ID.required ? ew.Validators.required(fields.Help_ID.caption) : null], fields.Help_ID.isInvalid],
            ["_Language", [fields._Language.visible && fields._Language.required ? ew.Validators.required(fields._Language.caption) : null], fields._Language.isInvalid],
            ["Topic", [fields.Topic.visible && fields.Topic.required ? ew.Validators.required(fields.Topic.caption) : null], fields.Topic.isInvalid],
            ["Category", [fields.Category.visible && fields.Category.required ? ew.Validators.required(fields.Category.caption) : null], fields.Category.isInvalid],
            ["Order", [fields.Order.visible && fields.Order.required ? ew.Validators.required(fields.Order.caption) : null, ew.Validators.integer], fields.Order.isInvalid],
            ["Display_in_Page", [fields.Display_in_Page.visible && fields.Display_in_Page.required ? ew.Validators.required(fields.Display_in_Page.caption) : null], fields.Display_in_Page.isInvalid],
            ["Updated_By", [fields.Updated_By.visible && fields.Updated_By.required ? ew.Validators.required(fields.Updated_By.caption) : null], fields.Updated_By.isInvalid],
            ["Last_Updated", [fields.Last_Updated.visible && fields.Last_Updated.required ? ew.Validators.required(fields.Last_Updated.caption) : null, ew.Validators.datetime(fields.Last_Updated.clientFormatPattern)], fields.Last_Updated.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["_Language",false],["Topic",false],["Category",false],["Order",false],["Display_in_Page",false],["Updated_By",false],["Last_Updated",false]];
                if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
                    return false;
                return true;
            }
        )

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
            "_Language": <?= $Grid->_Language->toClientList($Grid) ?>,
            "Category": <?= $Grid->Category->toClientList($Grid) ?>,
            "Updated_By": <?= $Grid->Updated_By->toClientList($Grid) ?>,
        })
        .build();
    window[form.id] = form;
    loadjs.done(form.id);
});
</script>
<?php } ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE == TRUE) { ?>
<main class="list">
<?php } else { ?>
<main class="list">
<?php } ?>
<div id="ew-list">
<?php if ($Grid->TotalRecords > 0 || $Grid->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Grid->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Grid->TableGridClass ?>">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="fhelpgrid" class="ew-form ew-list-form">
<div id="gmp_help" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_helpgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->Help_ID->Visible) { // Help_ID ?>
        <th data-name="Help_ID" class="<?= $Grid->Help_ID->headerCellClass() ?>"><div id="elh_help_Help_ID" class="help_Help_ID"><?= $Grid->renderFieldHeader($Grid->Help_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->_Language->Visible) { // Language ?>
        <th data-name="_Language" class="<?= $Grid->_Language->headerCellClass() ?>"><div id="elh_help__Language" class="help__Language"><?= $Grid->renderFieldHeader($Grid->_Language) ?></div></th>
<?php } ?>
<?php if ($Grid->Topic->Visible) { // Topic ?>
        <th data-name="Topic" class="<?= $Grid->Topic->headerCellClass() ?>"><div id="elh_help_Topic" class="help_Topic"><?= $Grid->renderFieldHeader($Grid->Topic) ?></div></th>
<?php } ?>
<?php if ($Grid->Category->Visible) { // Category ?>
        <th data-name="Category" class="<?= $Grid->Category->headerCellClass() ?>"><div id="elh_help_Category" class="help_Category"><?= $Grid->renderFieldHeader($Grid->Category) ?></div></th>
<?php } ?>
<?php if ($Grid->Order->Visible) { // Order ?>
        <th data-name="Order" class="<?= $Grid->Order->headerCellClass() ?>"><div id="elh_help_Order" class="help_Order"><?= $Grid->renderFieldHeader($Grid->Order) ?></div></th>
<?php } ?>
<?php if ($Grid->Display_in_Page->Visible) { // Display_in_Page ?>
        <th data-name="Display_in_Page" class="<?= $Grid->Display_in_Page->headerCellClass() ?>"><div id="elh_help_Display_in_Page" class="help_Display_in_Page"><?= $Grid->renderFieldHeader($Grid->Display_in_Page) ?></div></th>
<?php } ?>
<?php if ($Grid->Updated_By->Visible) { // Updated_By ?>
        <th data-name="Updated_By" class="<?= $Grid->Updated_By->headerCellClass() ?>"><div id="elh_help_Updated_By" class="help_Updated_By"><?= $Grid->renderFieldHeader($Grid->Updated_By) ?></div></th>
<?php } ?>
<?php if ($Grid->Last_Updated->Visible) { // Last_Updated ?>
        <th data-name="Last_Updated" class="<?= $Grid->Last_Updated->headerCellClass() ?>"><div id="elh_help_Last_Updated" class="help_Last_Updated"><?= $Grid->renderFieldHeader($Grid->Last_Updated) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Grid->getPageNumber() ?>">
<?php
$Grid->setupGrid();
while ($Grid->RecordCount < $Grid->StopRecord || $Grid->RowIndex === '$rowindex$') {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Grid->RowAction != "delete" &&
            $Grid->RowAction != "insertdelete" &&
            !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow()) &&
            $Grid->RowAction != "hide"
        ) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->Help_ID->Visible) { // Help_ID ?>
        <td data-name="Help_ID"<?= $Grid->Help_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_help_Help_ID" class="el_help_Help_ID"></span>
<input type="hidden" data-table="help" data-field="x_Help_ID" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Help_ID" id="o<?= $Grid->RowIndex ?>_Help_ID" value="<?= HtmlEncode($Grid->Help_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_help_Help_ID" class="el_help_Help_ID">
<span<?= $Grid->Help_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Help_ID->getDisplayValue($Grid->Help_ID->EditValue))) ?>"></span>
<input type="hidden" data-table="help" data-field="x_Help_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Help_ID" id="x<?= $Grid->RowIndex ?>_Help_ID" value="<?= HtmlEncode($Grid->Help_ID->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help_Help_ID" class="el_help_Help_ID">
<span<?= $Grid->Help_ID->viewAttributes() ?>>
<?= $Grid->Help_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x_Help_ID" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>_Help_ID" id="fhelpgrid$x<?= $Grid->RowIndex ?>_Help_ID" value="<?= HtmlEncode($Grid->Help_ID->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Help_ID" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>_Help_ID" id="fhelpgrid$o<?= $Grid->RowIndex ?>_Help_ID" value="<?= HtmlEncode($Grid->Help_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="help" data-field="x_Help_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Help_ID" id="x<?= $Grid->RowIndex ?>_Help_ID" value="<?= HtmlEncode($Grid->Help_ID->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->_Language->Visible) { // Language ?>
        <td data-name="_Language"<?= $Grid->_Language->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_help__Language" class="el_help__Language">
    <select
        id="x<?= $Grid->RowIndex ?>__Language"
        name="x<?= $Grid->RowIndex ?>__Language"
        class="form-select ew-select<?= $Grid->_Language->isInvalidClass() ?>"
        <?php if (!$Grid->_Language->IsNativeSelect) { ?>
        data-select2-id="fhelpgrid_x<?= $Grid->RowIndex ?>__Language"
        <?php } ?>
        data-table="help"
        data-field="x__Language"
        data-value-separator="<?= $Grid->_Language->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->_Language->getPlaceHolder()) ?>"
        <?= $Grid->_Language->editAttributes() ?>>
        <?= $Grid->_Language->selectOptionListHtml("x{$Grid->RowIndex}__Language") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->_Language->getErrorMessage() ?></div>
<?= $Grid->_Language->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "__Language") ?>
<?php if (!$Grid->_Language->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>__Language", selectId: "fhelpgrid_x<?= $Grid->RowIndex ?>__Language" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpgrid.lists._Language?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>__Language", form: "fhelpgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>__Language", form: "fhelpgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields._Language.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="help" data-field="x__Language" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>__Language" id="o<?= $Grid->RowIndex ?>__Language" value="<?= HtmlEncode($Grid->_Language->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_help__Language" class="el_help__Language">
    <select
        id="x<?= $Grid->RowIndex ?>__Language"
        name="x<?= $Grid->RowIndex ?>__Language"
        class="form-select ew-select<?= $Grid->_Language->isInvalidClass() ?>"
        <?php if (!$Grid->_Language->IsNativeSelect) { ?>
        data-select2-id="fhelpgrid_x<?= $Grid->RowIndex ?>__Language"
        <?php } ?>
        data-table="help"
        data-field="x__Language"
        data-value-separator="<?= $Grid->_Language->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->_Language->getPlaceHolder()) ?>"
        <?= $Grid->_Language->editAttributes() ?>>
        <?= $Grid->_Language->selectOptionListHtml("x{$Grid->RowIndex}__Language") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->_Language->getErrorMessage() ?></div>
<?= $Grid->_Language->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "__Language") ?>
<?php if (!$Grid->_Language->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>__Language", selectId: "fhelpgrid_x<?= $Grid->RowIndex ?>__Language" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpgrid.lists._Language?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>__Language", form: "fhelpgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>__Language", form: "fhelpgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields._Language.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help__Language" class="el_help__Language">
<span<?= $Grid->_Language->viewAttributes() ?>>
<?= $Grid->_Language->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x__Language" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>__Language" id="fhelpgrid$x<?= $Grid->RowIndex ?>__Language" value="<?= HtmlEncode($Grid->_Language->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x__Language" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>__Language" id="fhelpgrid$o<?= $Grid->RowIndex ?>__Language" value="<?= HtmlEncode($Grid->_Language->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Topic->Visible) { // Topic ?>
        <td data-name="Topic"<?= $Grid->Topic->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_help_Topic" class="el_help_Topic">
<input type="<?= $Grid->Topic->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Topic" id="x<?= $Grid->RowIndex ?>_Topic" data-table="help" data-field="x_Topic" value="<?= $Grid->Topic->EditValue ?>" size="50" maxlength="255" placeholder="<?= HtmlEncode($Grid->Topic->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Topic->formatPattern()) ?>"<?= $Grid->Topic->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Topic->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="help" data-field="x_Topic" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Topic" id="o<?= $Grid->RowIndex ?>_Topic" value="<?= HtmlEncode($Grid->Topic->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_help_Topic" class="el_help_Topic">
<input type="<?= $Grid->Topic->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Topic" id="x<?= $Grid->RowIndex ?>_Topic" data-table="help" data-field="x_Topic" value="<?= $Grid->Topic->EditValue ?>" size="50" maxlength="255" placeholder="<?= HtmlEncode($Grid->Topic->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Topic->formatPattern()) ?>"<?= $Grid->Topic->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Topic->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help_Topic" class="el_help_Topic">
<span<?= $Grid->Topic->viewAttributes() ?>>
<?= $Grid->Topic->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x_Topic" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>_Topic" id="fhelpgrid$x<?= $Grid->RowIndex ?>_Topic" value="<?= HtmlEncode($Grid->Topic->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Topic" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>_Topic" id="fhelpgrid$o<?= $Grid->RowIndex ?>_Topic" value="<?= HtmlEncode($Grid->Topic->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Category->Visible) { // Category ?>
        <td data-name="Category"<?= $Grid->Category->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->Category->getSessionValue() != "") { ?>
<span<?= $Grid->Category->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->Category->getDisplayValue($Grid->Category->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_Category" name="x<?= $Grid->RowIndex ?>_Category" value="<?= HtmlEncode($Grid->Category->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_help_Category" class="el_help_Category">
    <select
        id="x<?= $Grid->RowIndex ?>_Category"
        name="x<?= $Grid->RowIndex ?>_Category"
        class="form-select ew-select<?= $Grid->Category->isInvalidClass() ?>"
        <?php if (!$Grid->Category->IsNativeSelect) { ?>
        data-select2-id="fhelpgrid_x<?= $Grid->RowIndex ?>_Category"
        <?php } ?>
        data-table="help"
        data-field="x_Category"
        data-value-separator="<?= $Grid->Category->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Category->getPlaceHolder()) ?>"
        <?= $Grid->Category->editAttributes() ?>>
        <?= $Grid->Category->selectOptionListHtml("x{$Grid->RowIndex}_Category") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Category->getErrorMessage() ?></div>
<?= $Grid->Category->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_Category") ?>
<?php if (!$Grid->Category->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_Category", selectId: "fhelpgrid_x<?= $Grid->RowIndex ?>_Category" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpgrid.lists.Category?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_Category", form: "fhelpgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_Category", form: "fhelpgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields.Category.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<input type="hidden" data-table="help" data-field="x_Category" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Category" id="o<?= $Grid->RowIndex ?>_Category" value="<?= HtmlEncode($Grid->Category->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->Category->getSessionValue() != "") { ?>
<span<?= $Grid->Category->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->Category->getDisplayValue($Grid->Category->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_Category" name="x<?= $Grid->RowIndex ?>_Category" value="<?= HtmlEncode($Grid->Category->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_help_Category" class="el_help_Category">
    <select
        id="x<?= $Grid->RowIndex ?>_Category"
        name="x<?= $Grid->RowIndex ?>_Category"
        class="form-select ew-select<?= $Grid->Category->isInvalidClass() ?>"
        <?php if (!$Grid->Category->IsNativeSelect) { ?>
        data-select2-id="fhelpgrid_x<?= $Grid->RowIndex ?>_Category"
        <?php } ?>
        data-table="help"
        data-field="x_Category"
        data-value-separator="<?= $Grid->Category->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Category->getPlaceHolder()) ?>"
        <?= $Grid->Category->editAttributes() ?>>
        <?= $Grid->Category->selectOptionListHtml("x{$Grid->RowIndex}_Category") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Category->getErrorMessage() ?></div>
<?= $Grid->Category->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_Category") ?>
<?php if (!$Grid->Category->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_Category", selectId: "fhelpgrid_x<?= $Grid->RowIndex ?>_Category" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpgrid.lists.Category?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_Category", form: "fhelpgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_Category", form: "fhelpgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields.Category.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help_Category" class="el_help_Category">
<span<?= $Grid->Category->viewAttributes() ?>>
<?= $Grid->Category->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x_Category" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>_Category" id="fhelpgrid$x<?= $Grid->RowIndex ?>_Category" value="<?= HtmlEncode($Grid->Category->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Category" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>_Category" id="fhelpgrid$o<?= $Grid->RowIndex ?>_Category" value="<?= HtmlEncode($Grid->Category->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Order->Visible) { // Order ?>
        <td data-name="Order"<?= $Grid->Order->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_help_Order" class="el_help_Order">
<input type="<?= $Grid->Order->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Order" id="x<?= $Grid->RowIndex ?>_Order" data-table="help" data-field="x_Order" value="<?= $Grid->Order->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->Order->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Order->formatPattern()) ?>"<?= $Grid->Order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Order->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fhelpgrid", "jquerynumber"], function() {
	ew.createjQueryNumber("fhelpgrid", "x<?= $Grid->RowIndex ?>_Order", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
<input type="hidden" data-table="help" data-field="x_Order" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Order" id="o<?= $Grid->RowIndex ?>_Order" value="<?= HtmlEncode($Grid->Order->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_help_Order" class="el_help_Order">
<input type="<?= $Grid->Order->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Order" id="x<?= $Grid->RowIndex ?>_Order" data-table="help" data-field="x_Order" value="<?= $Grid->Order->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->Order->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Order->formatPattern()) ?>"<?= $Grid->Order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Order->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fhelpgrid", "jquerynumber"], function() {
	ew.createjQueryNumber("fhelpgrid", "x<?= $Grid->RowIndex ?>_Order", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help_Order" class="el_help_Order">
<span<?= $Grid->Order->viewAttributes() ?>>
<?= $Grid->Order->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x_Order" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>_Order" id="fhelpgrid$x<?= $Grid->RowIndex ?>_Order" value="<?= HtmlEncode($Grid->Order->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Order" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>_Order" id="fhelpgrid$o<?= $Grid->RowIndex ?>_Order" value="<?= HtmlEncode($Grid->Order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Display_in_Page->Visible) { // Display_in_Page ?>
        <td data-name="Display_in_Page"<?= $Grid->Display_in_Page->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_help_Display_in_Page" class="el_help_Display_in_Page">
<input type="<?= $Grid->Display_in_Page->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Display_in_Page" id="x<?= $Grid->RowIndex ?>_Display_in_Page" data-table="help" data-field="x_Display_in_Page" value="<?= $Grid->Display_in_Page->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->Display_in_Page->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Display_in_Page->formatPattern()) ?>"<?= $Grid->Display_in_Page->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Display_in_Page->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="help" data-field="x_Display_in_Page" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Display_in_Page" id="o<?= $Grid->RowIndex ?>_Display_in_Page" value="<?= HtmlEncode($Grid->Display_in_Page->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_help_Display_in_Page" class="el_help_Display_in_Page">
<input type="<?= $Grid->Display_in_Page->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Display_in_Page" id="x<?= $Grid->RowIndex ?>_Display_in_Page" data-table="help" data-field="x_Display_in_Page" value="<?= $Grid->Display_in_Page->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->Display_in_Page->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Display_in_Page->formatPattern()) ?>"<?= $Grid->Display_in_Page->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Display_in_Page->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help_Display_in_Page" class="el_help_Display_in_Page">
<span<?= $Grid->Display_in_Page->viewAttributes() ?>>
<?= $Grid->Display_in_Page->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x_Display_in_Page" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>_Display_in_Page" id="fhelpgrid$x<?= $Grid->RowIndex ?>_Display_in_Page" value="<?= HtmlEncode($Grid->Display_in_Page->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Display_in_Page" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>_Display_in_Page" id="fhelpgrid$o<?= $Grid->RowIndex ?>_Display_in_Page" value="<?= HtmlEncode($Grid->Display_in_Page->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Updated_By->Visible) { // Updated_By ?>
        <td data-name="Updated_By"<?= $Grid->Updated_By->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_help_Updated_By" class="el_help_Updated_By">
    <select
        id="x<?= $Grid->RowIndex ?>_Updated_By"
        name="x<?= $Grid->RowIndex ?>_Updated_By"
        class="form-select ew-select<?= $Grid->Updated_By->isInvalidClass() ?>"
        <?php if (!$Grid->Updated_By->IsNativeSelect) { ?>
        data-select2-id="fhelpgrid_x<?= $Grid->RowIndex ?>_Updated_By"
        <?php } ?>
        data-table="help"
        data-field="x_Updated_By"
        data-value-separator="<?= $Grid->Updated_By->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Updated_By->getPlaceHolder()) ?>"
        <?= $Grid->Updated_By->editAttributes() ?>>
        <?= $Grid->Updated_By->selectOptionListHtml("x{$Grid->RowIndex}_Updated_By") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Updated_By->getErrorMessage() ?></div>
<?= $Grid->Updated_By->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_Updated_By") ?>
<?php if (!$Grid->Updated_By->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_Updated_By", selectId: "fhelpgrid_x<?= $Grid->RowIndex ?>_Updated_By" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpgrid.lists.Updated_By?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_Updated_By", form: "fhelpgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_Updated_By", form: "fhelpgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields.Updated_By.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="help" data-field="x_Updated_By" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Updated_By" id="o<?= $Grid->RowIndex ?>_Updated_By" value="<?= HtmlEncode($Grid->Updated_By->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_help_Updated_By" class="el_help_Updated_By">
    <select
        id="x<?= $Grid->RowIndex ?>_Updated_By"
        name="x<?= $Grid->RowIndex ?>_Updated_By"
        class="form-select ew-select<?= $Grid->Updated_By->isInvalidClass() ?>"
        <?php if (!$Grid->Updated_By->IsNativeSelect) { ?>
        data-select2-id="fhelpgrid_x<?= $Grid->RowIndex ?>_Updated_By"
        <?php } ?>
        data-table="help"
        data-field="x_Updated_By"
        data-value-separator="<?= $Grid->Updated_By->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Updated_By->getPlaceHolder()) ?>"
        <?= $Grid->Updated_By->editAttributes() ?>>
        <?= $Grid->Updated_By->selectOptionListHtml("x{$Grid->RowIndex}_Updated_By") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Updated_By->getErrorMessage() ?></div>
<?= $Grid->Updated_By->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_Updated_By") ?>
<?php if (!$Grid->Updated_By->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_Updated_By", selectId: "fhelpgrid_x<?= $Grid->RowIndex ?>_Updated_By" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpgrid.lists.Updated_By?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_Updated_By", form: "fhelpgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_Updated_By", form: "fhelpgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields.Updated_By.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help_Updated_By" class="el_help_Updated_By">
<span<?= $Grid->Updated_By->viewAttributes() ?>>
<?= $Grid->Updated_By->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x_Updated_By" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>_Updated_By" id="fhelpgrid$x<?= $Grid->RowIndex ?>_Updated_By" value="<?= HtmlEncode($Grid->Updated_By->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Updated_By" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>_Updated_By" id="fhelpgrid$o<?= $Grid->RowIndex ?>_Updated_By" value="<?= HtmlEncode($Grid->Updated_By->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Last_Updated->Visible) { // Last_Updated ?>
        <td data-name="Last_Updated"<?= $Grid->Last_Updated->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_help_Last_Updated" class="el_help_Last_Updated">
<input type="<?= $Grid->Last_Updated->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Last_Updated" id="x<?= $Grid->RowIndex ?>_Last_Updated" data-table="help" data-field="x_Last_Updated" value="<?= $Grid->Last_Updated->EditValue ?>" placeholder="<?= HtmlEncode($Grid->Last_Updated->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Last_Updated->formatPattern()) ?>"<?= $Grid->Last_Updated->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Last_Updated->getErrorMessage() ?></div>
<?php if (!$Grid->Last_Updated->ReadOnly && !$Grid->Last_Updated->Disabled && !isset($Grid->Last_Updated->EditAttrs["readonly"]) && !isset($Grid->Last_Updated->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fhelpgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fhelpgrid", "x<?= $Grid->RowIndex ?>_Last_Updated", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="help" data-field="x_Last_Updated" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Last_Updated" id="o<?= $Grid->RowIndex ?>_Last_Updated" value="<?= HtmlEncode($Grid->Last_Updated->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_help_Last_Updated" class="el_help_Last_Updated">
<input type="<?= $Grid->Last_Updated->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Last_Updated" id="x<?= $Grid->RowIndex ?>_Last_Updated" data-table="help" data-field="x_Last_Updated" value="<?= $Grid->Last_Updated->EditValue ?>" placeholder="<?= HtmlEncode($Grid->Last_Updated->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Last_Updated->formatPattern()) ?>"<?= $Grid->Last_Updated->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Last_Updated->getErrorMessage() ?></div>
<?php if (!$Grid->Last_Updated->ReadOnly && !$Grid->Last_Updated->Disabled && !isset($Grid->Last_Updated->EditAttrs["readonly"]) && !isset($Grid->Last_Updated->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fhelpgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fhelpgrid", "x<?= $Grid->RowIndex ?>_Last_Updated", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help_Last_Updated" class="el_help_Last_Updated">
<span<?= $Grid->Last_Updated->viewAttributes() ?>>
<?= $Grid->Last_Updated->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x_Last_Updated" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>_Last_Updated" id="fhelpgrid$x<?= $Grid->RowIndex ?>_Last_Updated" value="<?= HtmlEncode($Grid->Last_Updated->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Last_Updated" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>_Last_Updated" id="fhelpgrid$o<?= $Grid->RowIndex ?>_Last_Updated" value="<?= HtmlEncode($Grid->Last_Updated->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script data-rowindex="<?= $Grid->RowIndex ?>">
loadjs.ready(["fhelpgrid","load"], () => fhelpgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (
        $Grid->Recordset &&
        !$Grid->Recordset->EOF &&
        $Grid->RowIndex !== '$rowindex$' &&
        (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy") &&
        (!(($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0))
    ) {
        $Grid->Recordset->moveNext();
    }
    // Reset for template row
    if ($Grid->RowIndex === '$rowindex$') {
        $Grid->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0) {
        $Grid->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fhelpgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Grid->TotalRecords == 0 && !$Grid->CurrentAction) { // Show other options ?>
<?php // Begin of Empty Table by Masino Sinaga, September 30, 2020 ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE == TRUE) { ?>
<div class="card ew-card ew-grid<?= $Grid->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Grid->TableGridClass ?>">
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-header ew-grid-upper-panel">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<?php } ?>
<div id="fhelpgrid" class="ew-form ew-list-form">
<div id="gmp_help" class="card-body ew-grid-middle-panel <?= $Grid->TableContainerClass ?>" style="<?= $Grid->TableContainerStyle ?>">
<table id="tbl_helpgrid" class="<?= $Grid->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Grid->RowType = ROWTYPE_HEADER;

// Render list options
$Grid->renderListOptions();

// Render list options (header, left)
$Grid->ListOptions->render("header", "left");
?>
<?php if ($Grid->Help_ID->Visible) { // Help_ID ?>
        <th data-name="Help_ID" class="<?= $Grid->Help_ID->headerCellClass() ?>"><div id="elh_help_Help_ID" class="help_Help_ID"><?= $Grid->renderFieldHeader($Grid->Help_ID) ?></div></th>
<?php } ?>
<?php if ($Grid->_Language->Visible) { // Language ?>
        <th data-name="_Language" class="<?= $Grid->_Language->headerCellClass() ?>"><div id="elh_help__Language" class="help__Language"><?= $Grid->renderFieldHeader($Grid->_Language) ?></div></th>
<?php } ?>
<?php if ($Grid->Topic->Visible) { // Topic ?>
        <th data-name="Topic" class="<?= $Grid->Topic->headerCellClass() ?>"><div id="elh_help_Topic" class="help_Topic"><?= $Grid->renderFieldHeader($Grid->Topic) ?></div></th>
<?php } ?>
<?php if ($Grid->Category->Visible) { // Category ?>
        <th data-name="Category" class="<?= $Grid->Category->headerCellClass() ?>"><div id="elh_help_Category" class="help_Category"><?= $Grid->renderFieldHeader($Grid->Category) ?></div></th>
<?php } ?>
<?php if ($Grid->Order->Visible) { // Order ?>
        <th data-name="Order" class="<?= $Grid->Order->headerCellClass() ?>"><div id="elh_help_Order" class="help_Order"><?= $Grid->renderFieldHeader($Grid->Order) ?></div></th>
<?php } ?>
<?php if ($Grid->Display_in_Page->Visible) { // Display_in_Page ?>
        <th data-name="Display_in_Page" class="<?= $Grid->Display_in_Page->headerCellClass() ?>"><div id="elh_help_Display_in_Page" class="help_Display_in_Page"><?= $Grid->renderFieldHeader($Grid->Display_in_Page) ?></div></th>
<?php } ?>
<?php if ($Grid->Updated_By->Visible) { // Updated_By ?>
        <th data-name="Updated_By" class="<?= $Grid->Updated_By->headerCellClass() ?>"><div id="elh_help_Updated_By" class="help_Updated_By"><?= $Grid->renderFieldHeader($Grid->Updated_By) ?></div></th>
<?php } ?>
<?php if ($Grid->Last_Updated->Visible) { // Last_Updated ?>
        <th data-name="Last_Updated" class="<?= $Grid->Last_Updated->headerCellClass() ?>"><div id="elh_help_Last_Updated" class="help_Last_Updated"><?= $Grid->renderFieldHeader($Grid->Last_Updated) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Grid->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Grid->getPageNumber() ?>">
<?php
$Grid->setupGrid();
while ($Grid->RecordCount < $Grid->StopRecord || $Grid->RowIndex === '$rowindex$') {
    $Grid->RecordCount++;
    if ($Grid->RecordCount >= $Grid->StartRecord) {
        $Grid->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Grid->RowAction != "delete" &&
            $Grid->RowAction != "insertdelete" &&
            !($Grid->RowAction == "insert" && $Grid->isConfirm() && $Grid->emptyRow()) &&
            $Grid->RowAction != "hide"
        ) {
?>
    <tr <?= $Grid->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Grid->ListOptions->render("body", "left", $Grid->RowCount);
?>
    <?php if ($Grid->Help_ID->Visible) { // Help_ID ?>
        <td data-name="Help_ID"<?= $Grid->Help_ID->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_help_Help_ID" class="el_help_Help_ID"></span>
<input type="hidden" data-table="help" data-field="x_Help_ID" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Help_ID" id="o<?= $Grid->RowIndex ?>_Help_ID" value="<?= HtmlEncode($Grid->Help_ID->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_help_Help_ID" class="el_help_Help_ID">
<span<?= $Grid->Help_ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Grid->Help_ID->getDisplayValue($Grid->Help_ID->EditValue))) ?>"></span>
<input type="hidden" data-table="help" data-field="x_Help_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Help_ID" id="x<?= $Grid->RowIndex ?>_Help_ID" value="<?= HtmlEncode($Grid->Help_ID->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help_Help_ID" class="el_help_Help_ID">
<span<?= $Grid->Help_ID->viewAttributes() ?>>
<?= $Grid->Help_ID->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x_Help_ID" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>_Help_ID" id="fhelpgrid$x<?= $Grid->RowIndex ?>_Help_ID" value="<?= HtmlEncode($Grid->Help_ID->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Help_ID" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>_Help_ID" id="fhelpgrid$o<?= $Grid->RowIndex ?>_Help_ID" value="<?= HtmlEncode($Grid->Help_ID->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="help" data-field="x_Help_ID" data-hidden="1" name="x<?= $Grid->RowIndex ?>_Help_ID" id="x<?= $Grid->RowIndex ?>_Help_ID" value="<?= HtmlEncode($Grid->Help_ID->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Grid->_Language->Visible) { // Language ?>
        <td data-name="_Language"<?= $Grid->_Language->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_help__Language" class="el_help__Language">
    <select
        id="x<?= $Grid->RowIndex ?>__Language"
        name="x<?= $Grid->RowIndex ?>__Language"
        class="form-select ew-select<?= $Grid->_Language->isInvalidClass() ?>"
        <?php if (!$Grid->_Language->IsNativeSelect) { ?>
        data-select2-id="fhelpgrid_x<?= $Grid->RowIndex ?>__Language"
        <?php } ?>
        data-table="help"
        data-field="x__Language"
        data-value-separator="<?= $Grid->_Language->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->_Language->getPlaceHolder()) ?>"
        <?= $Grid->_Language->editAttributes() ?>>
        <?= $Grid->_Language->selectOptionListHtml("x{$Grid->RowIndex}__Language") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->_Language->getErrorMessage() ?></div>
<?= $Grid->_Language->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "__Language") ?>
<?php if (!$Grid->_Language->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>__Language", selectId: "fhelpgrid_x<?= $Grid->RowIndex ?>__Language" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpgrid.lists._Language?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>__Language", form: "fhelpgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>__Language", form: "fhelpgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields._Language.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="help" data-field="x__Language" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>__Language" id="o<?= $Grid->RowIndex ?>__Language" value="<?= HtmlEncode($Grid->_Language->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_help__Language" class="el_help__Language">
    <select
        id="x<?= $Grid->RowIndex ?>__Language"
        name="x<?= $Grid->RowIndex ?>__Language"
        class="form-select ew-select<?= $Grid->_Language->isInvalidClass() ?>"
        <?php if (!$Grid->_Language->IsNativeSelect) { ?>
        data-select2-id="fhelpgrid_x<?= $Grid->RowIndex ?>__Language"
        <?php } ?>
        data-table="help"
        data-field="x__Language"
        data-value-separator="<?= $Grid->_Language->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->_Language->getPlaceHolder()) ?>"
        <?= $Grid->_Language->editAttributes() ?>>
        <?= $Grid->_Language->selectOptionListHtml("x{$Grid->RowIndex}__Language") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->_Language->getErrorMessage() ?></div>
<?= $Grid->_Language->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "__Language") ?>
<?php if (!$Grid->_Language->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>__Language", selectId: "fhelpgrid_x<?= $Grid->RowIndex ?>__Language" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpgrid.lists._Language?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>__Language", form: "fhelpgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>__Language", form: "fhelpgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields._Language.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help__Language" class="el_help__Language">
<span<?= $Grid->_Language->viewAttributes() ?>>
<?= $Grid->_Language->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x__Language" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>__Language" id="fhelpgrid$x<?= $Grid->RowIndex ?>__Language" value="<?= HtmlEncode($Grid->_Language->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x__Language" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>__Language" id="fhelpgrid$o<?= $Grid->RowIndex ?>__Language" value="<?= HtmlEncode($Grid->_Language->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Topic->Visible) { // Topic ?>
        <td data-name="Topic"<?= $Grid->Topic->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_help_Topic" class="el_help_Topic">
<input type="<?= $Grid->Topic->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Topic" id="x<?= $Grid->RowIndex ?>_Topic" data-table="help" data-field="x_Topic" value="<?= $Grid->Topic->EditValue ?>" size="50" maxlength="255" placeholder="<?= HtmlEncode($Grid->Topic->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Topic->formatPattern()) ?>"<?= $Grid->Topic->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Topic->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="help" data-field="x_Topic" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Topic" id="o<?= $Grid->RowIndex ?>_Topic" value="<?= HtmlEncode($Grid->Topic->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_help_Topic" class="el_help_Topic">
<input type="<?= $Grid->Topic->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Topic" id="x<?= $Grid->RowIndex ?>_Topic" data-table="help" data-field="x_Topic" value="<?= $Grid->Topic->EditValue ?>" size="50" maxlength="255" placeholder="<?= HtmlEncode($Grid->Topic->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Topic->formatPattern()) ?>"<?= $Grid->Topic->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Topic->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help_Topic" class="el_help_Topic">
<span<?= $Grid->Topic->viewAttributes() ?>>
<?= $Grid->Topic->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x_Topic" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>_Topic" id="fhelpgrid$x<?= $Grid->RowIndex ?>_Topic" value="<?= HtmlEncode($Grid->Topic->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Topic" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>_Topic" id="fhelpgrid$o<?= $Grid->RowIndex ?>_Topic" value="<?= HtmlEncode($Grid->Topic->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Category->Visible) { // Category ?>
        <td data-name="Category"<?= $Grid->Category->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if ($Grid->Category->getSessionValue() != "") { ?>
<span<?= $Grid->Category->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->Category->getDisplayValue($Grid->Category->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_Category" name="x<?= $Grid->RowIndex ?>_Category" value="<?= HtmlEncode($Grid->Category->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_help_Category" class="el_help_Category">
    <select
        id="x<?= $Grid->RowIndex ?>_Category"
        name="x<?= $Grid->RowIndex ?>_Category"
        class="form-select ew-select<?= $Grid->Category->isInvalidClass() ?>"
        <?php if (!$Grid->Category->IsNativeSelect) { ?>
        data-select2-id="fhelpgrid_x<?= $Grid->RowIndex ?>_Category"
        <?php } ?>
        data-table="help"
        data-field="x_Category"
        data-value-separator="<?= $Grid->Category->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Category->getPlaceHolder()) ?>"
        <?= $Grid->Category->editAttributes() ?>>
        <?= $Grid->Category->selectOptionListHtml("x{$Grid->RowIndex}_Category") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Category->getErrorMessage() ?></div>
<?= $Grid->Category->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_Category") ?>
<?php if (!$Grid->Category->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_Category", selectId: "fhelpgrid_x<?= $Grid->RowIndex ?>_Category" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpgrid.lists.Category?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_Category", form: "fhelpgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_Category", form: "fhelpgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields.Category.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<input type="hidden" data-table="help" data-field="x_Category" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Category" id="o<?= $Grid->RowIndex ?>_Category" value="<?= HtmlEncode($Grid->Category->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if ($Grid->Category->getSessionValue() != "") { ?>
<span<?= $Grid->Category->viewAttributes() ?>>
<span class="form-control-plaintext"><?= $Grid->Category->getDisplayValue($Grid->Category->ViewValue) ?></span></span>
<input type="hidden" id="x<?= $Grid->RowIndex ?>_Category" name="x<?= $Grid->RowIndex ?>_Category" value="<?= HtmlEncode($Grid->Category->CurrentValue) ?>" data-hidden="1">
<?php } else { ?>
<span id="el<?= $Grid->RowCount ?>_help_Category" class="el_help_Category">
    <select
        id="x<?= $Grid->RowIndex ?>_Category"
        name="x<?= $Grid->RowIndex ?>_Category"
        class="form-select ew-select<?= $Grid->Category->isInvalidClass() ?>"
        <?php if (!$Grid->Category->IsNativeSelect) { ?>
        data-select2-id="fhelpgrid_x<?= $Grid->RowIndex ?>_Category"
        <?php } ?>
        data-table="help"
        data-field="x_Category"
        data-value-separator="<?= $Grid->Category->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Category->getPlaceHolder()) ?>"
        <?= $Grid->Category->editAttributes() ?>>
        <?= $Grid->Category->selectOptionListHtml("x{$Grid->RowIndex}_Category") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Category->getErrorMessage() ?></div>
<?= $Grid->Category->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_Category") ?>
<?php if (!$Grid->Category->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_Category", selectId: "fhelpgrid_x<?= $Grid->RowIndex ?>_Category" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpgrid.lists.Category?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_Category", form: "fhelpgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_Category", form: "fhelpgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields.Category.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help_Category" class="el_help_Category">
<span<?= $Grid->Category->viewAttributes() ?>>
<?= $Grid->Category->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x_Category" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>_Category" id="fhelpgrid$x<?= $Grid->RowIndex ?>_Category" value="<?= HtmlEncode($Grid->Category->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Category" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>_Category" id="fhelpgrid$o<?= $Grid->RowIndex ?>_Category" value="<?= HtmlEncode($Grid->Category->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Order->Visible) { // Order ?>
        <td data-name="Order"<?= $Grid->Order->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_help_Order" class="el_help_Order">
<input type="<?= $Grid->Order->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Order" id="x<?= $Grid->RowIndex ?>_Order" data-table="help" data-field="x_Order" value="<?= $Grid->Order->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->Order->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Order->formatPattern()) ?>"<?= $Grid->Order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Order->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fhelpgrid", "jquerynumber"], function() {
	ew.createjQueryNumber("fhelpgrid", "x<?= $Grid->RowIndex ?>_Order", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
<input type="hidden" data-table="help" data-field="x_Order" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Order" id="o<?= $Grid->RowIndex ?>_Order" value="<?= HtmlEncode($Grid->Order->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_help_Order" class="el_help_Order">
<input type="<?= $Grid->Order->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Order" id="x<?= $Grid->RowIndex ?>_Order" data-table="help" data-field="x_Order" value="<?= $Grid->Order->EditValue ?>" size="30" placeholder="<?= HtmlEncode($Grid->Order->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Order->formatPattern()) ?>"<?= $Grid->Order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Order->getErrorMessage() ?></div>
<script type="text/javascript">
loadjs.ready(["fhelpgrid", "jquerynumber"], function() {
	ew.createjQueryNumber("fhelpgrid", "x<?= $Grid->RowIndex ?>_Order", {"number": true, "decimals": 0, "dec_point": "<?php echo $DECIMAL_SEPARATOR ?>", "thousands_sep" : "<?php echo $GROUPING_SEPARATOR ?>"});
});
</script>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help_Order" class="el_help_Order">
<span<?= $Grid->Order->viewAttributes() ?>>
<?= $Grid->Order->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x_Order" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>_Order" id="fhelpgrid$x<?= $Grid->RowIndex ?>_Order" value="<?= HtmlEncode($Grid->Order->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Order" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>_Order" id="fhelpgrid$o<?= $Grid->RowIndex ?>_Order" value="<?= HtmlEncode($Grid->Order->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Display_in_Page->Visible) { // Display_in_Page ?>
        <td data-name="Display_in_Page"<?= $Grid->Display_in_Page->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_help_Display_in_Page" class="el_help_Display_in_Page">
<input type="<?= $Grid->Display_in_Page->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Display_in_Page" id="x<?= $Grid->RowIndex ?>_Display_in_Page" data-table="help" data-field="x_Display_in_Page" value="<?= $Grid->Display_in_Page->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->Display_in_Page->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Display_in_Page->formatPattern()) ?>"<?= $Grid->Display_in_Page->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Display_in_Page->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="help" data-field="x_Display_in_Page" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Display_in_Page" id="o<?= $Grid->RowIndex ?>_Display_in_Page" value="<?= HtmlEncode($Grid->Display_in_Page->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_help_Display_in_Page" class="el_help_Display_in_Page">
<input type="<?= $Grid->Display_in_Page->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Display_in_Page" id="x<?= $Grid->RowIndex ?>_Display_in_Page" data-table="help" data-field="x_Display_in_Page" value="<?= $Grid->Display_in_Page->EditValue ?>" size="30" maxlength="100" placeholder="<?= HtmlEncode($Grid->Display_in_Page->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Display_in_Page->formatPattern()) ?>"<?= $Grid->Display_in_Page->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Display_in_Page->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help_Display_in_Page" class="el_help_Display_in_Page">
<span<?= $Grid->Display_in_Page->viewAttributes() ?>>
<?= $Grid->Display_in_Page->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x_Display_in_Page" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>_Display_in_Page" id="fhelpgrid$x<?= $Grid->RowIndex ?>_Display_in_Page" value="<?= HtmlEncode($Grid->Display_in_Page->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Display_in_Page" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>_Display_in_Page" id="fhelpgrid$o<?= $Grid->RowIndex ?>_Display_in_Page" value="<?= HtmlEncode($Grid->Display_in_Page->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Updated_By->Visible) { // Updated_By ?>
        <td data-name="Updated_By"<?= $Grid->Updated_By->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_help_Updated_By" class="el_help_Updated_By">
    <select
        id="x<?= $Grid->RowIndex ?>_Updated_By"
        name="x<?= $Grid->RowIndex ?>_Updated_By"
        class="form-select ew-select<?= $Grid->Updated_By->isInvalidClass() ?>"
        <?php if (!$Grid->Updated_By->IsNativeSelect) { ?>
        data-select2-id="fhelpgrid_x<?= $Grid->RowIndex ?>_Updated_By"
        <?php } ?>
        data-table="help"
        data-field="x_Updated_By"
        data-value-separator="<?= $Grid->Updated_By->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Updated_By->getPlaceHolder()) ?>"
        <?= $Grid->Updated_By->editAttributes() ?>>
        <?= $Grid->Updated_By->selectOptionListHtml("x{$Grid->RowIndex}_Updated_By") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Updated_By->getErrorMessage() ?></div>
<?= $Grid->Updated_By->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_Updated_By") ?>
<?php if (!$Grid->Updated_By->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_Updated_By", selectId: "fhelpgrid_x<?= $Grid->RowIndex ?>_Updated_By" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpgrid.lists.Updated_By?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_Updated_By", form: "fhelpgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_Updated_By", form: "fhelpgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields.Updated_By.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="help" data-field="x_Updated_By" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Updated_By" id="o<?= $Grid->RowIndex ?>_Updated_By" value="<?= HtmlEncode($Grid->Updated_By->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_help_Updated_By" class="el_help_Updated_By">
    <select
        id="x<?= $Grid->RowIndex ?>_Updated_By"
        name="x<?= $Grid->RowIndex ?>_Updated_By"
        class="form-select ew-select<?= $Grid->Updated_By->isInvalidClass() ?>"
        <?php if (!$Grid->Updated_By->IsNativeSelect) { ?>
        data-select2-id="fhelpgrid_x<?= $Grid->RowIndex ?>_Updated_By"
        <?php } ?>
        data-table="help"
        data-field="x_Updated_By"
        data-value-separator="<?= $Grid->Updated_By->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Grid->Updated_By->getPlaceHolder()) ?>"
        <?= $Grid->Updated_By->editAttributes() ?>>
        <?= $Grid->Updated_By->selectOptionListHtml("x{$Grid->RowIndex}_Updated_By") ?>
    </select>
    <div class="invalid-feedback"><?= $Grid->Updated_By->getErrorMessage() ?></div>
<?= $Grid->Updated_By->Lookup->getParamTag($Grid, "p_x" . $Grid->RowIndex . "_Updated_By") ?>
<?php if (!$Grid->Updated_By->IsNativeSelect) { ?>
<script>
loadjs.ready("fhelpgrid", function() {
    var options = { name: "x<?= $Grid->RowIndex ?>_Updated_By", selectId: "fhelpgrid_x<?= $Grid->RowIndex ?>_Updated_By" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fhelpgrid.lists.Updated_By?.lookupOptions.length) {
        options.data = { id: "x<?= $Grid->RowIndex ?>_Updated_By", form: "fhelpgrid" };
    } else {
        options.ajax = { id: "x<?= $Grid->RowIndex ?>_Updated_By", form: "fhelpgrid", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.help.fields.Updated_By.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help_Updated_By" class="el_help_Updated_By">
<span<?= $Grid->Updated_By->viewAttributes() ?>>
<?= $Grid->Updated_By->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x_Updated_By" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>_Updated_By" id="fhelpgrid$x<?= $Grid->RowIndex ?>_Updated_By" value="<?= HtmlEncode($Grid->Updated_By->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Updated_By" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>_Updated_By" id="fhelpgrid$o<?= $Grid->RowIndex ?>_Updated_By" value="<?= HtmlEncode($Grid->Updated_By->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Grid->Last_Updated->Visible) { // Last_Updated ?>
        <td data-name="Last_Updated"<?= $Grid->Last_Updated->cellAttributes() ?>>
<?php if ($Grid->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Grid->RowCount ?>_help_Last_Updated" class="el_help_Last_Updated">
<input type="<?= $Grid->Last_Updated->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Last_Updated" id="x<?= $Grid->RowIndex ?>_Last_Updated" data-table="help" data-field="x_Last_Updated" value="<?= $Grid->Last_Updated->EditValue ?>" placeholder="<?= HtmlEncode($Grid->Last_Updated->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Last_Updated->formatPattern()) ?>"<?= $Grid->Last_Updated->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Last_Updated->getErrorMessage() ?></div>
<?php if (!$Grid->Last_Updated->ReadOnly && !$Grid->Last_Updated->Disabled && !isset($Grid->Last_Updated->EditAttrs["readonly"]) && !isset($Grid->Last_Updated->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fhelpgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fhelpgrid", "x<?= $Grid->RowIndex ?>_Last_Updated", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="help" data-field="x_Last_Updated" data-hidden="1" data-old name="o<?= $Grid->RowIndex ?>_Last_Updated" id="o<?= $Grid->RowIndex ?>_Last_Updated" value="<?= HtmlEncode($Grid->Last_Updated->OldValue) ?>">
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Grid->RowCount ?>_help_Last_Updated" class="el_help_Last_Updated">
<input type="<?= $Grid->Last_Updated->getInputTextType() ?>" name="x<?= $Grid->RowIndex ?>_Last_Updated" id="x<?= $Grid->RowIndex ?>_Last_Updated" data-table="help" data-field="x_Last_Updated" value="<?= $Grid->Last_Updated->EditValue ?>" placeholder="<?= HtmlEncode($Grid->Last_Updated->getPlaceHolder()) ?>" data-format-pattern="<?= HtmlEncode($Grid->Last_Updated->formatPattern()) ?>"<?= $Grid->Last_Updated->editAttributes() ?>>
<div class="invalid-feedback"><?= $Grid->Last_Updated->getErrorMessage() ?></div>
<?php if (!$Grid->Last_Updated->ReadOnly && !$Grid->Last_Updated->Disabled && !isset($Grid->Last_Updated->EditAttrs["readonly"]) && !isset($Grid->Last_Updated->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fhelpgrid", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fhelpgrid", "x<?= $Grid->RowIndex ?>_Last_Updated", ew.deepAssign({"useCurrent":false,"display":{"sideBySide":false}}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Grid->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Grid->RowCount ?>_help_Last_Updated" class="el_help_Last_Updated">
<span<?= $Grid->Last_Updated->viewAttributes() ?>>
<?= $Grid->Last_Updated->getViewValue() ?></span>
</span>
<?php if ($Grid->isConfirm()) { ?>
<input type="hidden" data-table="help" data-field="x_Last_Updated" data-hidden="1" name="fhelpgrid$x<?= $Grid->RowIndex ?>_Last_Updated" id="fhelpgrid$x<?= $Grid->RowIndex ?>_Last_Updated" value="<?= HtmlEncode($Grid->Last_Updated->FormValue) ?>">
<input type="hidden" data-table="help" data-field="x_Last_Updated" data-hidden="1" data-old name="fhelpgrid$o<?= $Grid->RowIndex ?>_Last_Updated" id="fhelpgrid$o<?= $Grid->RowIndex ?>_Last_Updated" value="<?= HtmlEncode($Grid->Last_Updated->OldValue) ?>">
<?php } ?>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Grid->ListOptions->render("body", "right", $Grid->RowCount);
?>
    </tr>
<?php if ($Grid->RowType == ROWTYPE_ADD || $Grid->RowType == ROWTYPE_EDIT) { ?>
<script data-rowindex="<?= $Grid->RowIndex ?>">
loadjs.ready(["fhelpgrid","load"], () => fhelpgrid.updateLists(<?= $Grid->RowIndex ?><?= $Grid->isAdd() || $Grid->isEdit() || $Grid->isCopy() || $Grid->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (
        $Grid->Recordset &&
        !$Grid->Recordset->EOF &&
        $Grid->RowIndex !== '$rowindex$' &&
        (!$Grid->isGridAdd() || $Grid->CurrentMode == "copy") &&
        (!(($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0))
    ) {
        $Grid->Recordset->moveNext();
    }
    // Reset for template row
    if ($Grid->RowIndex === '$rowindex$') {
        $Grid->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Grid->isCopy() || $Grid->isAdd()) && $Grid->RowIndex == 0) {
        $Grid->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php if ($Grid->CurrentMode == "add" || $Grid->CurrentMode == "copy") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
<?php if ($Grid->CurrentMode == "edit") { ?>
<input type="hidden" name="<?= $Grid->FormKeyCountName ?>" id="<?= $Grid->FormKeyCountName ?>" value="<?= $Grid->KeyCount ?>">
<?= $Grid->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Grid->CurrentMode == "") { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
<input type="hidden" name="detailpage" value="fhelpgrid">
</div><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Grid->Recordset) {
    $Grid->Recordset->close();
}
?>
<?php if ($Grid->ShowOtherOptions) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php $Grid->OtherOptions->render("body", "bottom") ?>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Grid->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } // end of Empty Table by Masino Sinaga, September 30, 2020 ?>
<?php } ?>
</div>
</main>
<?php if (!$Grid->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("help");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("head", function() {
	$(".ew-grid").css("width", "100%");
	$(".sidebar, .main-sidebar, .main-header, .header-navbar, .main-menu").on("mouseenter", function(event) {
		$(".ew-grid").css("width", "100%");
	});
	$(".sidebar, .main-sidebar, .main-header, .header-navbar, .main-menu").on("mouseover", function(event) {
		$(".ew-grid").css("width", "100%");
	});
	var cssTransitionEnd = 'webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend';
	$('.main-header').on(cssTransitionEnd, function(event) {
		$(".ew-grid").css("width", "100%");
	});
	$(document).on('resize', function() {
		if ($('.ew-grid').length > 0) {
			$(".ew-grid").css("width", "100%");
		}
	});
	$(".nav-item.d-block").on("click", function(event) {
		$(".ew-grid").css("width", "100%");
	});
});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fhelpadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fhelpadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fhelpedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fhelpedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$help->isExport()) { ?>
<script>
loadjs.ready("jqueryjs", function() {
	var expires = new Date(new Date().getTime() + 525600 * 60 * 1000); // expire in 525600 
	var SearchToggle = $('.ew-search-toggle'); 
	SearchToggle.on('click', function(event) { 
		event.preventDefault(); 
		if (SearchToggle.hasClass('active')) { 
			Cookies.set("help_searchpanel", "notactive", { path: '', expires: expires }); 
		} else { 
			Cookies.set("help_searchpanel", "active", { path: '', expires: expires }); 
		} 
	});
});
</script>
<?php } ?>
<?php } ?>
