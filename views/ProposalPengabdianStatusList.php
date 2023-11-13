<?php

namespace PHPMaker2023\new2023;

// Page object
$ProposalPengabdianStatusList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { proposal_pengabdian_status: currentTable } });
var currentPageID = ew.PAGE_ID = "list";
var currentForm;
var <?= $Page->FormName ?>;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery;
    let fields = currentTable.fields;

    // Form object
    let form = new ew.FormBuilder()
        .setId("<?= $Page->FormName ?>")
        .setPageId("list")
        .setSubmitWithFetch(<?= $Page->UseAjaxActions ? "true" : "false" ?>)
        .setFormKeyCountName("<?= $Page->FormKeyCountName ?>")

        // Add fields
        .setFields([
            ["id_pengabdian", [fields.id_pengabdian.visible && fields.id_pengabdian.required ? ew.Validators.required(fields.id_pengabdian.caption) : null], fields.id_pengabdian.isInvalid],
            ["Kelompok_ID", [fields.Kelompok_ID.visible && fields.Kelompok_ID.required ? ew.Validators.required(fields.Kelompok_ID.caption) : null], fields.Kelompok_ID.isInvalid],
            ["Status", [fields.Status.visible && fields.Status.required ? ew.Validators.required(fields.Status.caption) : null], fields.Status.isInvalid]
        ])

        // Check empty row
        .setEmptyRow(
            function (rowIndex) {
                let fobj = this.getForm(),
                    fields = [["Kelompok_ID",false],["Status",false]];
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
            "Kelompok_ID": <?= $Page->Kelompok_ID->toClientList($Page) ?>,
            "Status": <?= $Page->Status->toClientList($Page) ?>,
        })
        .build();
    window[form.id] = form;
    currentForm = form;
    loadjs.done(form.id);
});
</script>
<script>
ew.PREVIEW_SELECTOR = ".ew-preview-btn";
ew.PREVIEW_MODAL_CLASS = "modal modal-fullscreen";
ew.PREVIEW_ROW = true;
ew.PREVIEW_SINGLE_ROW = false;
ew.PREVIEW || ew.ready("head", ew.PATH_BASE + "js/preview.min.js?v=19.10.0", "preview");
</script>
<script>
window.Tabulator || loadjs([
    ew.PATH_BASE + "js/tabulator.min.js?v=19.10.0",
    ew.PATH_BASE + "css/<?= CssFile("tabulator_bootstrap5.css", false) ?>?v=19.10.0"
], "import");
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php if (!$Page->IsModal) { ?>
<form name="fproposal_pengabdian_statussrch" id="fproposal_pengabdian_statussrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="on">
<div id="fproposal_pengabdian_statussrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { proposal_pengabdian_status: currentTable } });
var currentForm;
var fproposal_pengabdian_statussrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fproposal_pengabdian_statussrch")
        .setPageId("list")
<?php if ($Page->UseAjaxActions) { ?>
        .setSubmitWithFetch(true)
<?php } ?>

        // Dynamic selection lists
        .setLists({
        })

        // Filters
        .setFilterList(<?= $Page->getFilterList() ?>)
        .build();
    window[form.id] = form;
    currentSearchForm = form;
    loadjs.done(form.id);
});
</script>
<input type="hidden" name="cmd" value="search">
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !($Page->CurrentAction && $Page->CurrentAction != "search") && $Page->hasSearchFields()) { ?>
<div class="ew-extended-search container-fluid ps-2">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fproposal_pengabdian_statussrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fproposal_pengabdian_statussrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fproposal_pengabdian_statussrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fproposal_pengabdian_statussrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
<?php } ?>
<?php } ?>
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE == TRUE) { ?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? "" : "" ?>">
<?php } else { ?>
<main class="list<?= ($Page->TotalRecords == 0 && !$Page->isAdd()) ? " ew-no-record" : "" ?>">
<?php } ?>
<div id="ew-list">
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="proposal_pengabdian_status">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_proposal_pengabdian_status" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_proposal_pengabdian_statuslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id_pengabdian->Visible) { // id_pengabdian ?>
        <th data-name="id_pengabdian" class="<?= $Page->id_pengabdian->headerCellClass() ?>"><div id="elh_proposal_pengabdian_status_id_pengabdian" class="proposal_pengabdian_status_id_pengabdian"><?= $Page->renderFieldHeader($Page->id_pengabdian) ?></div></th>
<?php } ?>
<?php if ($Page->Kelompok_ID->Visible) { // Kelompok_ID ?>
        <th data-name="Kelompok_ID" class="<?= $Page->Kelompok_ID->headerCellClass() ?>"><div id="elh_proposal_pengabdian_status_Kelompok_ID" class="proposal_pengabdian_status_Kelompok_ID"><?= $Page->renderFieldHeader($Page->Kelompok_ID) ?></div></th>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <th data-name="Status" class="<?= $Page->Status->headerCellClass() ?>"><div id="elh_proposal_pengabdian_status_Status" class="proposal_pengabdian_status_Status"><?= $Page->renderFieldHeader($Page->Status) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$') {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Page->RowAction != "delete" &&
            $Page->RowAction != "insertdelete" &&
            !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow()) &&
            $Page->RowAction != "hide"
        ) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id_pengabdian->Visible) { // id_pengabdian ?>
        <td data-name="id_pengabdian"<?= $Page->id_pengabdian->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_id_pengabdian" class="el_proposal_pengabdian_status_id_pengabdian"></span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_id_pengabdian" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_pengabdian" id="o<?= $Page->RowIndex ?>_id_pengabdian" value="<?= HtmlEncode($Page->id_pengabdian->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_id_pengabdian" class="el_proposal_pengabdian_status_id_pengabdian">
<span<?= $Page->id_pengabdian->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_pengabdian->getDisplayValue($Page->id_pengabdian->EditValue))) ?>"></span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_id_pengabdian" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_pengabdian" id="x<?= $Page->RowIndex ?>_id_pengabdian" value="<?= HtmlEncode($Page->id_pengabdian->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_id_pengabdian" class="el_proposal_pengabdian_status_id_pengabdian">
<span<?= $Page->id_pengabdian->viewAttributes() ?>>
<?= $Page->id_pengabdian->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="proposal_pengabdian_status" data-field="x_id_pengabdian" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_pengabdian" id="x<?= $Page->RowIndex ?>_id_pengabdian" value="<?= HtmlEncode($Page->id_pengabdian->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->Kelompok_ID->Visible) { // Kelompok_ID ?>
        <td data-name="Kelompok_ID"<?= $Page->Kelompok_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Kelompok_ID" class="el_proposal_pengabdian_status_Kelompok_ID">
    <select
        id="x<?= $Page->RowIndex ?>_Kelompok_ID"
        name="x<?= $Page->RowIndex ?>_Kelompok_ID"
        class="form-select ew-select<?= $Page->Kelompok_ID->isInvalidClass() ?>"
        <?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID"
        <?php } ?>
        data-table="proposal_pengabdian_status"
        data-field="x_Kelompok_ID"
        data-value-separator="<?= $Page->Kelompok_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Kelompok_ID->getPlaceHolder()) ?>"
        <?= $Page->Kelompok_ID->editAttributes() ?>>
        <?= $Page->Kelompok_ID->selectOptionListHtml("x{$Page->RowIndex}_Kelompok_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Kelompok_ID->getErrorMessage() ?></div>
<?= $Page->Kelompok_ID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_Kelompok_ID") ?>
<?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_Kelompok_ID", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.Kelompok_ID?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.proposal_pengabdian_status.fields.Kelompok_ID.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_Kelompok_ID" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Kelompok_ID" id="o<?= $Page->RowIndex ?>_Kelompok_ID" value="<?= HtmlEncode($Page->Kelompok_ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Kelompok_ID" class="el_proposal_pengabdian_status_Kelompok_ID">
    <select
        id="x<?= $Page->RowIndex ?>_Kelompok_ID"
        name="x<?= $Page->RowIndex ?>_Kelompok_ID"
        class="form-select ew-select<?= $Page->Kelompok_ID->isInvalidClass() ?>"
        <?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID"
        <?php } ?>
        data-table="proposal_pengabdian_status"
        data-field="x_Kelompok_ID"
        data-value-separator="<?= $Page->Kelompok_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Kelompok_ID->getPlaceHolder()) ?>"
        <?= $Page->Kelompok_ID->editAttributes() ?>>
        <?= $Page->Kelompok_ID->selectOptionListHtml("x{$Page->RowIndex}_Kelompok_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Kelompok_ID->getErrorMessage() ?></div>
<?= $Page->Kelompok_ID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_Kelompok_ID") ?>
<?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_Kelompok_ID", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.Kelompok_ID?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.proposal_pengabdian_status.fields.Kelompok_ID.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Kelompok_ID" class="el_proposal_pengabdian_status_Kelompok_ID">
<span<?= $Page->Kelompok_ID->viewAttributes() ?>>
<?= $Page->Kelompok_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Status->Visible) { // Status ?>
        <td data-name="Status"<?= $Page->Status->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Status" class="el_proposal_pengabdian_status_Status">
<template id="tp_x<?= $Page->RowIndex ?>_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="proposal_pengabdian_status" data-field="x_Status" name="x<?= $Page->RowIndex ?>_Status" id="x<?= $Page->RowIndex ?>_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_Status"
    name="x<?= $Page->RowIndex ?>_Status"
    value="<?= HtmlEncode($Page->Status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_Status"
    data-target="dsl_x<?= $Page->RowIndex ?>_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="proposal_pengabdian_status"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_Status" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Status" id="o<?= $Page->RowIndex ?>_Status" value="<?= HtmlEncode($Page->Status->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Status" class="el_proposal_pengabdian_status_Status">
<template id="tp_x<?= $Page->RowIndex ?>_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="proposal_pengabdian_status" data-field="x_Status" name="x<?= $Page->RowIndex ?>_Status" id="x<?= $Page->RowIndex ?>_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_Status"
    name="x<?= $Page->RowIndex ?>_Status"
    value="<?= HtmlEncode($Page->Status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_Status"
    data-target="dsl_x<?= $Page->RowIndex ?>_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="proposal_pengabdian_status"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Status" class="el_proposal_pengabdian_status_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script data-rowindex="<?= $Page->RowIndex ?>">
loadjs.ready(["<?= $Page->FormName ?>","load"], () => <?= $Page->FormName ?>.updateLists(<?= $Page->RowIndex ?><?= $Page->isAdd() || $Page->isEdit() || $Page->isCopy() || $Page->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (
        $Page->Recordset &&
        !$Page->Recordset->EOF &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        (!(($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0))
    ) {
        $Page->Recordset->moveNext();
    }
    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php // Begin of Empty Table by Masino Sinaga, September 28, 2021 ?>
<?php } else { ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE == TRUE) { // --- Begin of if MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE ?>
<table id="tbl_proposal_pengabdian_statuslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
// $Page->renderListOptions(); // do not display for empty table, by Masino Sinaga, March 21, 2022

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id_pengabdian->Visible) { // id_pengabdian ?>
        <th data-name="id_pengabdian" class="<?= $Page->id_pengabdian->headerCellClass() ?>"><div id="elh_proposal_pengabdian_status_id_pengabdian" class="proposal_pengabdian_status_id_pengabdian"><?= $Page->renderFieldHeader($Page->id_pengabdian) ?></div></th>
<?php } ?>
<?php if ($Page->Kelompok_ID->Visible) { // Kelompok_ID ?>
        <th data-name="Kelompok_ID" class="<?= $Page->Kelompok_ID->headerCellClass() ?>"><div id="elh_proposal_pengabdian_status_Kelompok_ID" class="proposal_pengabdian_status_Kelompok_ID"><?= $Page->renderFieldHeader($Page->Kelompok_ID) ?></div></th>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <th data-name="Status" class="<?= $Page->Status->headerCellClass() ?>"><div id="elh_proposal_pengabdian_status_Status" class="proposal_pengabdian_status_Status"><?= $Page->renderFieldHeader($Page->Status) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
    <tr class="border-bottom-0" style="height:36px;">
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id_pengabdian->Visible) { // id_pengabdian ?>
        <td data-name="id_pengabdian"<?= $Page->id_pengabdian->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_id_pengabdian" class="el_proposal_pengabdian_status_id_pengabdian"></span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_id_pengabdian" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_pengabdian" id="o<?= $Page->RowIndex ?>_id_pengabdian" value="<?= HtmlEncode($Page->id_pengabdian->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_id_pengabdian" class="el_proposal_pengabdian_status_id_pengabdian">
<span<?= $Page->id_pengabdian->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_pengabdian->getDisplayValue($Page->id_pengabdian->EditValue))) ?>"></span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_id_pengabdian" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_pengabdian" id="x<?= $Page->RowIndex ?>_id_pengabdian" value="<?= HtmlEncode($Page->id_pengabdian->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_id_pengabdian" class="el_proposal_pengabdian_status_id_pengabdian">
<span<?= $Page->id_pengabdian->viewAttributes() ?>>
<?= $Page->id_pengabdian->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="proposal_pengabdian_status" data-field="x_id_pengabdian" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_pengabdian" id="x<?= $Page->RowIndex ?>_id_pengabdian" value="<?= HtmlEncode($Page->id_pengabdian->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->Kelompok_ID->Visible) { // Kelompok_ID ?>
        <td data-name="Kelompok_ID"<?= $Page->Kelompok_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Kelompok_ID" class="el_proposal_pengabdian_status_Kelompok_ID">
    <select
        id="x<?= $Page->RowIndex ?>_Kelompok_ID"
        name="x<?= $Page->RowIndex ?>_Kelompok_ID"
        class="form-select ew-select<?= $Page->Kelompok_ID->isInvalidClass() ?>"
        <?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID"
        <?php } ?>
        data-table="proposal_pengabdian_status"
        data-field="x_Kelompok_ID"
        data-value-separator="<?= $Page->Kelompok_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Kelompok_ID->getPlaceHolder()) ?>"
        <?= $Page->Kelompok_ID->editAttributes() ?>>
        <?= $Page->Kelompok_ID->selectOptionListHtml("x{$Page->RowIndex}_Kelompok_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Kelompok_ID->getErrorMessage() ?></div>
<?= $Page->Kelompok_ID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_Kelompok_ID") ?>
<?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_Kelompok_ID", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.Kelompok_ID?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.proposal_pengabdian_status.fields.Kelompok_ID.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_Kelompok_ID" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Kelompok_ID" id="o<?= $Page->RowIndex ?>_Kelompok_ID" value="<?= HtmlEncode($Page->Kelompok_ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Kelompok_ID" class="el_proposal_pengabdian_status_Kelompok_ID">
    <select
        id="x<?= $Page->RowIndex ?>_Kelompok_ID"
        name="x<?= $Page->RowIndex ?>_Kelompok_ID"
        class="form-select ew-select<?= $Page->Kelompok_ID->isInvalidClass() ?>"
        <?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID"
        <?php } ?>
        data-table="proposal_pengabdian_status"
        data-field="x_Kelompok_ID"
        data-value-separator="<?= $Page->Kelompok_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Kelompok_ID->getPlaceHolder()) ?>"
        <?= $Page->Kelompok_ID->editAttributes() ?>>
        <?= $Page->Kelompok_ID->selectOptionListHtml("x{$Page->RowIndex}_Kelompok_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Kelompok_ID->getErrorMessage() ?></div>
<?= $Page->Kelompok_ID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_Kelompok_ID") ?>
<?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_Kelompok_ID", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.Kelompok_ID?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.proposal_pengabdian_status.fields.Kelompok_ID.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Kelompok_ID" class="el_proposal_pengabdian_status_Kelompok_ID">
<span<?= $Page->Kelompok_ID->viewAttributes() ?>>
<?= $Page->Kelompok_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Status->Visible) { // Status ?>
        <td data-name="Status"<?= $Page->Status->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Status" class="el_proposal_pengabdian_status_Status">
<template id="tp_x<?= $Page->RowIndex ?>_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="proposal_pengabdian_status" data-field="x_Status" name="x<?= $Page->RowIndex ?>_Status" id="x<?= $Page->RowIndex ?>_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_Status"
    name="x<?= $Page->RowIndex ?>_Status"
    value="<?= HtmlEncode($Page->Status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_Status"
    data-target="dsl_x<?= $Page->RowIndex ?>_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="proposal_pengabdian_status"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_Status" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Status" id="o<?= $Page->RowIndex ?>_Status" value="<?= HtmlEncode($Page->Status->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Status" class="el_proposal_pengabdian_status_Status">
<template id="tp_x<?= $Page->RowIndex ?>_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="proposal_pengabdian_status" data-field="x_Status" name="x<?= $Page->RowIndex ?>_Status" id="x<?= $Page->RowIndex ?>_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_Status"
    name="x<?= $Page->RowIndex ?>_Status"
    value="<?= HtmlEncode($Page->Status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_Status"
    data-target="dsl_x<?= $Page->RowIndex ?>_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="proposal_pengabdian_status"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Status" class="el_proposal_pengabdian_status_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
</tbody>
</table><!-- /.ew-table -->
<?php } // --- End of if MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE ?>
<?php // End of Empty Table by Masino Sinaga, September 28, 2021 ?>
<?php } ?>
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } elseif ($Page->isMultiEdit()) { ?>
<input type="hidden" name="action" id="action" value="multiupdate">
<?php } ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } ?>
<?php if ($Page->TotalRecords == 0 && !$Page->CurrentAction) { // Show other options ?>
<?php // Begin of Empty Table by Masino Sinaga, September 30, 2020 ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE == TRUE) { ?>
<div class="card ew-card ew-grid<?= $Page->isAddOrEdit() ? " ew-grid-add-edit" : "" ?> <?= $Page->TableGridClass ?>">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="<?= $Page->FormName ?>" id="<?= $Page->FormName ?>" class="ew-form ew-list-form" action="<?= $Page->PageAction ?>" method="post" novalidate autocomplete="on">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="proposal_pengabdian_status">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_proposal_pengabdian_status" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_proposal_pengabdian_statuslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id_pengabdian->Visible) { // id_pengabdian ?>
        <th data-name="id_pengabdian" class="<?= $Page->id_pengabdian->headerCellClass() ?>"><div id="elh_proposal_pengabdian_status_id_pengabdian" class="proposal_pengabdian_status_id_pengabdian"><?= $Page->renderFieldHeader($Page->id_pengabdian) ?></div></th>
<?php } ?>
<?php if ($Page->Kelompok_ID->Visible) { // Kelompok_ID ?>
        <th data-name="Kelompok_ID" class="<?= $Page->Kelompok_ID->headerCellClass() ?>"><div id="elh_proposal_pengabdian_status_Kelompok_ID" class="proposal_pengabdian_status_Kelompok_ID"><?= $Page->renderFieldHeader($Page->Kelompok_ID) ?></div></th>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <th data-name="Status" class="<?= $Page->Status->headerCellClass() ?>"><div id="elh_proposal_pengabdian_status_Status" class="proposal_pengabdian_status_Status"><?= $Page->renderFieldHeader($Page->Status) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
<?php
$Page->setupGrid();
while ($Page->RecordCount < $Page->StopRecord || $Page->RowIndex === '$rowindex$') {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->setupRow();

        // Skip 1) delete row / empty row for confirm page, 2) hidden row
        if (
            $Page->RowAction != "delete" &&
            $Page->RowAction != "insertdelete" &&
            !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow()) &&
            $Page->RowAction != "hide"
        ) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id_pengabdian->Visible) { // id_pengabdian ?>
        <td data-name="id_pengabdian"<?= $Page->id_pengabdian->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_id_pengabdian" class="el_proposal_pengabdian_status_id_pengabdian"></span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_id_pengabdian" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_pengabdian" id="o<?= $Page->RowIndex ?>_id_pengabdian" value="<?= HtmlEncode($Page->id_pengabdian->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_id_pengabdian" class="el_proposal_pengabdian_status_id_pengabdian">
<span<?= $Page->id_pengabdian->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_pengabdian->getDisplayValue($Page->id_pengabdian->EditValue))) ?>"></span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_id_pengabdian" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_pengabdian" id="x<?= $Page->RowIndex ?>_id_pengabdian" value="<?= HtmlEncode($Page->id_pengabdian->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_id_pengabdian" class="el_proposal_pengabdian_status_id_pengabdian">
<span<?= $Page->id_pengabdian->viewAttributes() ?>>
<?= $Page->id_pengabdian->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="proposal_pengabdian_status" data-field="x_id_pengabdian" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_pengabdian" id="x<?= $Page->RowIndex ?>_id_pengabdian" value="<?= HtmlEncode($Page->id_pengabdian->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->Kelompok_ID->Visible) { // Kelompok_ID ?>
        <td data-name="Kelompok_ID"<?= $Page->Kelompok_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Kelompok_ID" class="el_proposal_pengabdian_status_Kelompok_ID">
    <select
        id="x<?= $Page->RowIndex ?>_Kelompok_ID"
        name="x<?= $Page->RowIndex ?>_Kelompok_ID"
        class="form-select ew-select<?= $Page->Kelompok_ID->isInvalidClass() ?>"
        <?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID"
        <?php } ?>
        data-table="proposal_pengabdian_status"
        data-field="x_Kelompok_ID"
        data-value-separator="<?= $Page->Kelompok_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Kelompok_ID->getPlaceHolder()) ?>"
        <?= $Page->Kelompok_ID->editAttributes() ?>>
        <?= $Page->Kelompok_ID->selectOptionListHtml("x{$Page->RowIndex}_Kelompok_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Kelompok_ID->getErrorMessage() ?></div>
<?= $Page->Kelompok_ID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_Kelompok_ID") ?>
<?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_Kelompok_ID", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.Kelompok_ID?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.proposal_pengabdian_status.fields.Kelompok_ID.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_Kelompok_ID" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Kelompok_ID" id="o<?= $Page->RowIndex ?>_Kelompok_ID" value="<?= HtmlEncode($Page->Kelompok_ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Kelompok_ID" class="el_proposal_pengabdian_status_Kelompok_ID">
    <select
        id="x<?= $Page->RowIndex ?>_Kelompok_ID"
        name="x<?= $Page->RowIndex ?>_Kelompok_ID"
        class="form-select ew-select<?= $Page->Kelompok_ID->isInvalidClass() ?>"
        <?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID"
        <?php } ?>
        data-table="proposal_pengabdian_status"
        data-field="x_Kelompok_ID"
        data-value-separator="<?= $Page->Kelompok_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Kelompok_ID->getPlaceHolder()) ?>"
        <?= $Page->Kelompok_ID->editAttributes() ?>>
        <?= $Page->Kelompok_ID->selectOptionListHtml("x{$Page->RowIndex}_Kelompok_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Kelompok_ID->getErrorMessage() ?></div>
<?= $Page->Kelompok_ID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_Kelompok_ID") ?>
<?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_Kelompok_ID", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.Kelompok_ID?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.proposal_pengabdian_status.fields.Kelompok_ID.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Kelompok_ID" class="el_proposal_pengabdian_status_Kelompok_ID">
<span<?= $Page->Kelompok_ID->viewAttributes() ?>>
<?= $Page->Kelompok_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Status->Visible) { // Status ?>
        <td data-name="Status"<?= $Page->Status->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Status" class="el_proposal_pengabdian_status_Status">
<template id="tp_x<?= $Page->RowIndex ?>_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="proposal_pengabdian_status" data-field="x_Status" name="x<?= $Page->RowIndex ?>_Status" id="x<?= $Page->RowIndex ?>_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_Status"
    name="x<?= $Page->RowIndex ?>_Status"
    value="<?= HtmlEncode($Page->Status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_Status"
    data-target="dsl_x<?= $Page->RowIndex ?>_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="proposal_pengabdian_status"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_Status" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Status" id="o<?= $Page->RowIndex ?>_Status" value="<?= HtmlEncode($Page->Status->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Status" class="el_proposal_pengabdian_status_Status">
<template id="tp_x<?= $Page->RowIndex ?>_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="proposal_pengabdian_status" data-field="x_Status" name="x<?= $Page->RowIndex ?>_Status" id="x<?= $Page->RowIndex ?>_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_Status"
    name="x<?= $Page->RowIndex ?>_Status"
    value="<?= HtmlEncode($Page->Status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_Status"
    data-target="dsl_x<?= $Page->RowIndex ?>_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="proposal_pengabdian_status"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Status" class="el_proposal_pengabdian_status_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script data-rowindex="<?= $Page->RowIndex ?>">
loadjs.ready(["<?= $Page->FormName ?>","load"], () => <?= $Page->FormName ?>.updateLists(<?= $Page->RowIndex ?><?= $Page->isAdd() || $Page->isEdit() || $Page->isCopy() || $Page->RowIndex === '$rowindex$' ? ", true" : "" ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (
        $Page->Recordset &&
        !$Page->Recordset->EOF &&
        $Page->RowIndex !== '$rowindex$' &&
        (!$Page->isGridAdd() || $Page->CurrentMode == "copy") &&
        (!(($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0))
    ) {
        $Page->Recordset->moveNext();
    }
    // Reset for template row
    if ($Page->RowIndex === '$rowindex$') {
        $Page->RowIndex = 0;
    }
    // Reset inline add/copy row
    if (($Page->isCopy() || $Page->isAdd()) && $Page->RowIndex == 0) {
        $Page->RowIndex = 1;
    }
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php // Begin of Empty Table by Masino Sinaga, September 28, 2021 ?>
<?php } else { ?>
<?php if (MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE == TRUE) { // --- Begin of if MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE ?>
<table id="tbl_proposal_pengabdian_statuslist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
// $Page->renderListOptions(); // do not display for empty table, by Masino Sinaga, March 21, 2022

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->id_pengabdian->Visible) { // id_pengabdian ?>
        <th data-name="id_pengabdian" class="<?= $Page->id_pengabdian->headerCellClass() ?>"><div id="elh_proposal_pengabdian_status_id_pengabdian" class="proposal_pengabdian_status_id_pengabdian"><?= $Page->renderFieldHeader($Page->id_pengabdian) ?></div></th>
<?php } ?>
<?php if ($Page->Kelompok_ID->Visible) { // Kelompok_ID ?>
        <th data-name="Kelompok_ID" class="<?= $Page->Kelompok_ID->headerCellClass() ?>"><div id="elh_proposal_pengabdian_status_Kelompok_ID" class="proposal_pengabdian_status_Kelompok_ID"><?= $Page->renderFieldHeader($Page->Kelompok_ID) ?></div></th>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <th data-name="Status" class="<?= $Page->Status->headerCellClass() ?>"><div id="elh_proposal_pengabdian_status_Status" class="proposal_pengabdian_status_Status"><?= $Page->renderFieldHeader($Page->Status) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody data-page="<?= $Page->getPageNumber() ?>">
    <tr class="border-bottom-0" style="height:36px;">
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->id_pengabdian->Visible) { // id_pengabdian ?>
        <td data-name="id_pengabdian"<?= $Page->id_pengabdian->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_id_pengabdian" class="el_proposal_pengabdian_status_id_pengabdian"></span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_id_pengabdian" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_id_pengabdian" id="o<?= $Page->RowIndex ?>_id_pengabdian" value="<?= HtmlEncode($Page->id_pengabdian->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_id_pengabdian" class="el_proposal_pengabdian_status_id_pengabdian">
<span<?= $Page->id_pengabdian->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->id_pengabdian->getDisplayValue($Page->id_pengabdian->EditValue))) ?>"></span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_id_pengabdian" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_pengabdian" id="x<?= $Page->RowIndex ?>_id_pengabdian" value="<?= HtmlEncode($Page->id_pengabdian->CurrentValue) ?>">
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_id_pengabdian" class="el_proposal_pengabdian_status_id_pengabdian">
<span<?= $Page->id_pengabdian->viewAttributes() ?>>
<?= $Page->id_pengabdian->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="proposal_pengabdian_status" data-field="x_id_pengabdian" data-hidden="1" name="x<?= $Page->RowIndex ?>_id_pengabdian" id="x<?= $Page->RowIndex ?>_id_pengabdian" value="<?= HtmlEncode($Page->id_pengabdian->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->Kelompok_ID->Visible) { // Kelompok_ID ?>
        <td data-name="Kelompok_ID"<?= $Page->Kelompok_ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Kelompok_ID" class="el_proposal_pengabdian_status_Kelompok_ID">
    <select
        id="x<?= $Page->RowIndex ?>_Kelompok_ID"
        name="x<?= $Page->RowIndex ?>_Kelompok_ID"
        class="form-select ew-select<?= $Page->Kelompok_ID->isInvalidClass() ?>"
        <?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID"
        <?php } ?>
        data-table="proposal_pengabdian_status"
        data-field="x_Kelompok_ID"
        data-value-separator="<?= $Page->Kelompok_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Kelompok_ID->getPlaceHolder()) ?>"
        <?= $Page->Kelompok_ID->editAttributes() ?>>
        <?= $Page->Kelompok_ID->selectOptionListHtml("x{$Page->RowIndex}_Kelompok_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Kelompok_ID->getErrorMessage() ?></div>
<?= $Page->Kelompok_ID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_Kelompok_ID") ?>
<?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_Kelompok_ID", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.Kelompok_ID?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.proposal_pengabdian_status.fields.Kelompok_ID.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_Kelompok_ID" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Kelompok_ID" id="o<?= $Page->RowIndex ?>_Kelompok_ID" value="<?= HtmlEncode($Page->Kelompok_ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Kelompok_ID" class="el_proposal_pengabdian_status_Kelompok_ID">
    <select
        id="x<?= $Page->RowIndex ?>_Kelompok_ID"
        name="x<?= $Page->RowIndex ?>_Kelompok_ID"
        class="form-select ew-select<?= $Page->Kelompok_ID->isInvalidClass() ?>"
        <?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
        data-select2-id="<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID"
        <?php } ?>
        data-table="proposal_pengabdian_status"
        data-field="x_Kelompok_ID"
        data-value-separator="<?= $Page->Kelompok_ID->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Kelompok_ID->getPlaceHolder()) ?>"
        <?= $Page->Kelompok_ID->editAttributes() ?>>
        <?= $Page->Kelompok_ID->selectOptionListHtml("x{$Page->RowIndex}_Kelompok_ID") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Kelompok_ID->getErrorMessage() ?></div>
<?= $Page->Kelompok_ID->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_Kelompok_ID") ?>
<?php if (!$Page->Kelompok_ID->IsNativeSelect) { ?>
<script>
loadjs.ready("<?= $Page->FormName ?>", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_Kelompok_ID", selectId: "<?= $Page->FormName ?>_x<?= $Page->RowIndex ?>_Kelompok_ID" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    if (!el)
        return;
    options.closeOnSelect = !options.multiple;
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (<?= $Page->FormName ?>.lists.Kelompok_ID?.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_Kelompok_ID", form: "<?= $Page->FormName ?>", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumInputLength = ew.selectMinimumInputLength;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.proposal_pengabdian_status.fields.Kelompok_ID.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Kelompok_ID" class="el_proposal_pengabdian_status_Kelompok_ID">
<span<?= $Page->Kelompok_ID->viewAttributes() ?>>
<?= $Page->Kelompok_ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Status->Visible) { // Status ?>
        <td data-name="Status"<?= $Page->Status->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Status" class="el_proposal_pengabdian_status_Status">
<template id="tp_x<?= $Page->RowIndex ?>_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="proposal_pengabdian_status" data-field="x_Status" name="x<?= $Page->RowIndex ?>_Status" id="x<?= $Page->RowIndex ?>_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_Status"
    name="x<?= $Page->RowIndex ?>_Status"
    value="<?= HtmlEncode($Page->Status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_Status"
    data-target="dsl_x<?= $Page->RowIndex ?>_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="proposal_pengabdian_status"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="proposal_pengabdian_status" data-field="x_Status" data-hidden="1" data-old name="o<?= $Page->RowIndex ?>_Status" id="o<?= $Page->RowIndex ?>_Status" value="<?= HtmlEncode($Page->Status->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Status" class="el_proposal_pengabdian_status_Status">
<template id="tp_x<?= $Page->RowIndex ?>_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="proposal_pengabdian_status" data-field="x_Status" name="x<?= $Page->RowIndex ?>_Status" id="x<?= $Page->RowIndex ?>_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_Status"
    name="x<?= $Page->RowIndex ?>_Status"
    value="<?= HtmlEncode($Page->Status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_Status"
    data-target="dsl_x<?= $Page->RowIndex ?>_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="proposal_pengabdian_status"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_proposal_pengabdian_status_Status" class="el_proposal_pengabdian_status_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
</tbody>
</table><!-- /.ew-table -->
<?php } // --- End of if MS_SHOW_EMPTY_TABLE_ON_LIST_PAGE ?>
<?php // End of Empty Table by Masino Sinaga, September 28, 2021 ?>
<?php } ?>
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<?php } elseif ($Page->isMultiEdit()) { ?>
<input type="hidden" name="action" id="action" value="multiupdate">
<?php } ?>
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if (!$Page->CurrentAction && !$Page->UseAjaxActions) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd() && !($Page->isGridEdit() && $Page->ModalGridEdit) && !$Page->isMultiEdit()) { ?>
<?= $Page->Pager->render() ?>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<div class="clearfix"></div>
<?php } // end of Empty Table by Masino Sinaga, September 30, 2020 ?>
<?php } ?>
</div>
</main>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("proposal_pengabdian_status");
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fproposal_pengabdian_statusadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fproposal_pengabdian_statusadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fproposal_pengabdian_statusedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fproposal_pengabdian_statusedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fproposal_pengabdian_statusupdate.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fproposal_pengabdian_statusupdate").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fproposal_pengabdian_statusdelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fproposal_pengabdian_statusdelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport() && CurrentPageID()=="list") { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-grid-save, .ew-grid-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fproposal_pengabdian_statuslist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-update').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fproposal_pengabdian_statuslist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fproposal_pengabdian_statuslist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){var gridchange=false;$('[data-table="proposal_pengabdian_status"]').change(function(){	gridchange=true;});$('.ew-grid-cancel,.ew-inline-cancel').click(function(){if (gridchange==true){ew.prompt({title: ew.language.phrase("ConfirmCancel"),icon:'question',showCancelButton:true},result=>{if(result) window.location = "<?php echo str_replace('_', '', 'proposal_pengabdian_statuslist'); ?>";});return false;}});});
</script>
<?php } ?>
<?php if (!$proposal_pengabdian_status->isExport()) { ?>
<script>
loadjs.ready("jqueryjs", function() {
	var expires = new Date(new Date().getTime() + 525600 * 60 * 1000); // expire in 525600 
	var SearchToggle = $('.ew-search-toggle'); 
	SearchToggle.on('click', function(event) { 
		event.preventDefault(); 
		if (SearchToggle.hasClass('active')) { 
			Cookies.set("proposal_pengabdian_status_searchpanel", "notactive", { path: '', expires: expires }); 
		} else { 
			Cookies.set("proposal_pengabdian_status_searchpanel", "active", { path: '', expires: expires }); 
		} 
	});
});
</script>
<?php } ?>
<?php } ?>
