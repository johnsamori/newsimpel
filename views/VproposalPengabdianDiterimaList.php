<?php

namespace PHPMaker2023\new2023;

// Page object
$VproposalPengabdianDiterimaList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { vproposal_pengabdian_diterima: currentTable } });
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
<form name="fvproposal_pengabdian_diterimasrch" id="fvproposal_pengabdian_diterimasrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="on">
<div id="fvproposal_pengabdian_diterimasrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { vproposal_pengabdian_diterima: currentTable } });
var currentForm;
var fvproposal_pengabdian_diterimasrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fvproposal_pengabdian_diterimasrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fvproposal_pengabdian_diterimasrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fvproposal_pengabdian_diterimasrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fvproposal_pengabdian_diterimasrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fvproposal_pengabdian_diterimasrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="vproposal_pengabdian_diterima">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_vproposal_pengabdian_diterima" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_vproposal_pengabdian_diterimalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Id_Kelompok->Visible) { // Id_Kelompok ?>
        <th data-name="Id_Kelompok" class="<?= $Page->Id_Kelompok->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Id_Kelompok" class="vproposal_pengabdian_diterima_Id_Kelompok"><?= $Page->renderFieldHeader($Page->Id_Kelompok) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Ketua->Visible) { // Nama_Ketua ?>
        <th data-name="Nama_Ketua" class="<?= $Page->Nama_Ketua->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Nama_Ketua" class="vproposal_pengabdian_diterima_Nama_Ketua"><?= $Page->renderFieldHeader($Page->Nama_Ketua) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Anggota_1->Visible) { // Nama_Anggota_1 ?>
        <th data-name="Nama_Anggota_1" class="<?= $Page->Nama_Anggota_1->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Nama_Anggota_1" class="vproposal_pengabdian_diterima_Nama_Anggota_1"><?= $Page->renderFieldHeader($Page->Nama_Anggota_1) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Anggota_2->Visible) { // Nama_Anggota_2 ?>
        <th data-name="Nama_Anggota_2" class="<?= $Page->Nama_Anggota_2->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Nama_Anggota_2" class="vproposal_pengabdian_diterima_Nama_Anggota_2"><?= $Page->renderFieldHeader($Page->Nama_Anggota_2) ?></div></th>
<?php } ?>
<?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <th data-name="Judul_Penelitian" class="<?= $Page->Judul_Penelitian->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Judul_Penelitian" class="vproposal_pengabdian_diterima_Judul_Penelitian"><?= $Page->renderFieldHeader($Page->Judul_Penelitian) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <th data-name="Tanggal" class="<?= $Page->Tanggal->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Tanggal" class="vproposal_pengabdian_diterima_Tanggal"><?= $Page->renderFieldHeader($Page->Tanggal) ?></div></th>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <th data-name="Status" class="<?= $Page->Status->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Status" class="vproposal_pengabdian_diterima_Status"><?= $Page->renderFieldHeader($Page->Status) ?></div></th>
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
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->Id_Kelompok->Visible) { // Id_Kelompok ?>
        <td data-name="Id_Kelompok"<?= $Page->Id_Kelompok->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Id_Kelompok" class="el_vproposal_pengabdian_diterima_Id_Kelompok">
<span<?= $Page->Id_Kelompok->viewAttributes() ?>>
<?= $Page->Id_Kelompok->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Ketua->Visible) { // Nama_Ketua ?>
        <td data-name="Nama_Ketua"<?= $Page->Nama_Ketua->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Nama_Ketua" class="el_vproposal_pengabdian_diterima_Nama_Ketua">
<span<?= $Page->Nama_Ketua->viewAttributes() ?>>
<?= $Page->Nama_Ketua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Anggota_1->Visible) { // Nama_Anggota_1 ?>
        <td data-name="Nama_Anggota_1"<?= $Page->Nama_Anggota_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Nama_Anggota_1" class="el_vproposal_pengabdian_diterima_Nama_Anggota_1">
<span<?= $Page->Nama_Anggota_1->viewAttributes() ?>>
<?= $Page->Nama_Anggota_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Anggota_2->Visible) { // Nama_Anggota_2 ?>
        <td data-name="Nama_Anggota_2"<?= $Page->Nama_Anggota_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Nama_Anggota_2" class="el_vproposal_pengabdian_diterima_Nama_Anggota_2">
<span<?= $Page->Nama_Anggota_2->viewAttributes() ?>>
<?= $Page->Nama_Anggota_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <td data-name="Judul_Penelitian"<?= $Page->Judul_Penelitian->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Judul_Penelitian" class="el_vproposal_pengabdian_diterima_Judul_Penelitian">
<span<?= $Page->Judul_Penelitian->viewAttributes() ?>>
<?= $Page->Judul_Penelitian->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <td data-name="Tanggal"<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Tanggal" class="el_vproposal_pengabdian_diterima_Tanggal">
<span<?= $Page->Tanggal->viewAttributes() ?>>
<?= $Page->Tanggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status->Visible) { // Status ?>
        <td data-name="Status"<?= $Page->Status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Status" class="el_vproposal_pengabdian_diterima_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
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
<table id="tbl_vproposal_pengabdian_diterimalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Id_Kelompok->Visible) { // Id_Kelompok ?>
        <th data-name="Id_Kelompok" class="<?= $Page->Id_Kelompok->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Id_Kelompok" class="vproposal_pengabdian_diterima_Id_Kelompok"><?= $Page->renderFieldHeader($Page->Id_Kelompok) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Ketua->Visible) { // Nama_Ketua ?>
        <th data-name="Nama_Ketua" class="<?= $Page->Nama_Ketua->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Nama_Ketua" class="vproposal_pengabdian_diterima_Nama_Ketua"><?= $Page->renderFieldHeader($Page->Nama_Ketua) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Anggota_1->Visible) { // Nama_Anggota_1 ?>
        <th data-name="Nama_Anggota_1" class="<?= $Page->Nama_Anggota_1->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Nama_Anggota_1" class="vproposal_pengabdian_diterima_Nama_Anggota_1"><?= $Page->renderFieldHeader($Page->Nama_Anggota_1) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Anggota_2->Visible) { // Nama_Anggota_2 ?>
        <th data-name="Nama_Anggota_2" class="<?= $Page->Nama_Anggota_2->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Nama_Anggota_2" class="vproposal_pengabdian_diterima_Nama_Anggota_2"><?= $Page->renderFieldHeader($Page->Nama_Anggota_2) ?></div></th>
<?php } ?>
<?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <th data-name="Judul_Penelitian" class="<?= $Page->Judul_Penelitian->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Judul_Penelitian" class="vproposal_pengabdian_diterima_Judul_Penelitian"><?= $Page->renderFieldHeader($Page->Judul_Penelitian) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <th data-name="Tanggal" class="<?= $Page->Tanggal->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Tanggal" class="vproposal_pengabdian_diterima_Tanggal"><?= $Page->renderFieldHeader($Page->Tanggal) ?></div></th>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <th data-name="Status" class="<?= $Page->Status->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Status" class="vproposal_pengabdian_diterima_Status"><?= $Page->renderFieldHeader($Page->Status) ?></div></th>
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
    <?php if ($Page->Id_Kelompok->Visible) { // Id_Kelompok ?>
        <td data-name="Id_Kelompok"<?= $Page->Id_Kelompok->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Id_Kelompok" class="el_vproposal_pengabdian_diterima_Id_Kelompok">
<span<?= $Page->Id_Kelompok->viewAttributes() ?>>
<?= $Page->Id_Kelompok->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Ketua->Visible) { // Nama_Ketua ?>
        <td data-name="Nama_Ketua"<?= $Page->Nama_Ketua->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Nama_Ketua" class="el_vproposal_pengabdian_diterima_Nama_Ketua">
<span<?= $Page->Nama_Ketua->viewAttributes() ?>>
<?= $Page->Nama_Ketua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Anggota_1->Visible) { // Nama_Anggota_1 ?>
        <td data-name="Nama_Anggota_1"<?= $Page->Nama_Anggota_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Nama_Anggota_1" class="el_vproposal_pengabdian_diterima_Nama_Anggota_1">
<span<?= $Page->Nama_Anggota_1->viewAttributes() ?>>
<?= $Page->Nama_Anggota_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Anggota_2->Visible) { // Nama_Anggota_2 ?>
        <td data-name="Nama_Anggota_2"<?= $Page->Nama_Anggota_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Nama_Anggota_2" class="el_vproposal_pengabdian_diterima_Nama_Anggota_2">
<span<?= $Page->Nama_Anggota_2->viewAttributes() ?>>
<?= $Page->Nama_Anggota_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <td data-name="Judul_Penelitian"<?= $Page->Judul_Penelitian->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Judul_Penelitian" class="el_vproposal_pengabdian_diterima_Judul_Penelitian">
<span<?= $Page->Judul_Penelitian->viewAttributes() ?>>
<?= $Page->Judul_Penelitian->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <td data-name="Tanggal"<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Tanggal" class="el_vproposal_pengabdian_diterima_Tanggal">
<span<?= $Page->Tanggal->viewAttributes() ?>>
<?= $Page->Tanggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status->Visible) { // Status ?>
        <td data-name="Status"<?= $Page->Status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Status" class="el_vproposal_pengabdian_diterima_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
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
<input type="hidden" name="t" value="vproposal_pengabdian_diterima">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_vproposal_pengabdian_diterima" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_vproposal_pengabdian_diterimalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Id_Kelompok->Visible) { // Id_Kelompok ?>
        <th data-name="Id_Kelompok" class="<?= $Page->Id_Kelompok->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Id_Kelompok" class="vproposal_pengabdian_diterima_Id_Kelompok"><?= $Page->renderFieldHeader($Page->Id_Kelompok) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Ketua->Visible) { // Nama_Ketua ?>
        <th data-name="Nama_Ketua" class="<?= $Page->Nama_Ketua->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Nama_Ketua" class="vproposal_pengabdian_diterima_Nama_Ketua"><?= $Page->renderFieldHeader($Page->Nama_Ketua) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Anggota_1->Visible) { // Nama_Anggota_1 ?>
        <th data-name="Nama_Anggota_1" class="<?= $Page->Nama_Anggota_1->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Nama_Anggota_1" class="vproposal_pengabdian_diterima_Nama_Anggota_1"><?= $Page->renderFieldHeader($Page->Nama_Anggota_1) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Anggota_2->Visible) { // Nama_Anggota_2 ?>
        <th data-name="Nama_Anggota_2" class="<?= $Page->Nama_Anggota_2->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Nama_Anggota_2" class="vproposal_pengabdian_diterima_Nama_Anggota_2"><?= $Page->renderFieldHeader($Page->Nama_Anggota_2) ?></div></th>
<?php } ?>
<?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <th data-name="Judul_Penelitian" class="<?= $Page->Judul_Penelitian->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Judul_Penelitian" class="vproposal_pengabdian_diterima_Judul_Penelitian"><?= $Page->renderFieldHeader($Page->Judul_Penelitian) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <th data-name="Tanggal" class="<?= $Page->Tanggal->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Tanggal" class="vproposal_pengabdian_diterima_Tanggal"><?= $Page->renderFieldHeader($Page->Tanggal) ?></div></th>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <th data-name="Status" class="<?= $Page->Status->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Status" class="vproposal_pengabdian_diterima_Status"><?= $Page->renderFieldHeader($Page->Status) ?></div></th>
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
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->Id_Kelompok->Visible) { // Id_Kelompok ?>
        <td data-name="Id_Kelompok"<?= $Page->Id_Kelompok->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Id_Kelompok" class="el_vproposal_pengabdian_diterima_Id_Kelompok">
<span<?= $Page->Id_Kelompok->viewAttributes() ?>>
<?= $Page->Id_Kelompok->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Ketua->Visible) { // Nama_Ketua ?>
        <td data-name="Nama_Ketua"<?= $Page->Nama_Ketua->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Nama_Ketua" class="el_vproposal_pengabdian_diterima_Nama_Ketua">
<span<?= $Page->Nama_Ketua->viewAttributes() ?>>
<?= $Page->Nama_Ketua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Anggota_1->Visible) { // Nama_Anggota_1 ?>
        <td data-name="Nama_Anggota_1"<?= $Page->Nama_Anggota_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Nama_Anggota_1" class="el_vproposal_pengabdian_diterima_Nama_Anggota_1">
<span<?= $Page->Nama_Anggota_1->viewAttributes() ?>>
<?= $Page->Nama_Anggota_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Anggota_2->Visible) { // Nama_Anggota_2 ?>
        <td data-name="Nama_Anggota_2"<?= $Page->Nama_Anggota_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Nama_Anggota_2" class="el_vproposal_pengabdian_diterima_Nama_Anggota_2">
<span<?= $Page->Nama_Anggota_2->viewAttributes() ?>>
<?= $Page->Nama_Anggota_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <td data-name="Judul_Penelitian"<?= $Page->Judul_Penelitian->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Judul_Penelitian" class="el_vproposal_pengabdian_diterima_Judul_Penelitian">
<span<?= $Page->Judul_Penelitian->viewAttributes() ?>>
<?= $Page->Judul_Penelitian->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <td data-name="Tanggal"<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Tanggal" class="el_vproposal_pengabdian_diterima_Tanggal">
<span<?= $Page->Tanggal->viewAttributes() ?>>
<?= $Page->Tanggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status->Visible) { // Status ?>
        <td data-name="Status"<?= $Page->Status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Status" class="el_vproposal_pengabdian_diterima_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php
    }
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
<table id="tbl_vproposal_pengabdian_diterimalist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->Id_Kelompok->Visible) { // Id_Kelompok ?>
        <th data-name="Id_Kelompok" class="<?= $Page->Id_Kelompok->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Id_Kelompok" class="vproposal_pengabdian_diterima_Id_Kelompok"><?= $Page->renderFieldHeader($Page->Id_Kelompok) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Ketua->Visible) { // Nama_Ketua ?>
        <th data-name="Nama_Ketua" class="<?= $Page->Nama_Ketua->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Nama_Ketua" class="vproposal_pengabdian_diterima_Nama_Ketua"><?= $Page->renderFieldHeader($Page->Nama_Ketua) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Anggota_1->Visible) { // Nama_Anggota_1 ?>
        <th data-name="Nama_Anggota_1" class="<?= $Page->Nama_Anggota_1->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Nama_Anggota_1" class="vproposal_pengabdian_diterima_Nama_Anggota_1"><?= $Page->renderFieldHeader($Page->Nama_Anggota_1) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Anggota_2->Visible) { // Nama_Anggota_2 ?>
        <th data-name="Nama_Anggota_2" class="<?= $Page->Nama_Anggota_2->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Nama_Anggota_2" class="vproposal_pengabdian_diterima_Nama_Anggota_2"><?= $Page->renderFieldHeader($Page->Nama_Anggota_2) ?></div></th>
<?php } ?>
<?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <th data-name="Judul_Penelitian" class="<?= $Page->Judul_Penelitian->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Judul_Penelitian" class="vproposal_pengabdian_diterima_Judul_Penelitian"><?= $Page->renderFieldHeader($Page->Judul_Penelitian) ?></div></th>
<?php } ?>
<?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <th data-name="Tanggal" class="<?= $Page->Tanggal->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Tanggal" class="vproposal_pengabdian_diterima_Tanggal"><?= $Page->renderFieldHeader($Page->Tanggal) ?></div></th>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <th data-name="Status" class="<?= $Page->Status->headerCellClass() ?>"><div id="elh_vproposal_pengabdian_diterima_Status" class="vproposal_pengabdian_diterima_Status"><?= $Page->renderFieldHeader($Page->Status) ?></div></th>
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
    <?php if ($Page->Id_Kelompok->Visible) { // Id_Kelompok ?>
        <td data-name="Id_Kelompok"<?= $Page->Id_Kelompok->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Id_Kelompok" class="el_vproposal_pengabdian_diterima_Id_Kelompok">
<span<?= $Page->Id_Kelompok->viewAttributes() ?>>
<?= $Page->Id_Kelompok->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Ketua->Visible) { // Nama_Ketua ?>
        <td data-name="Nama_Ketua"<?= $Page->Nama_Ketua->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Nama_Ketua" class="el_vproposal_pengabdian_diterima_Nama_Ketua">
<span<?= $Page->Nama_Ketua->viewAttributes() ?>>
<?= $Page->Nama_Ketua->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Anggota_1->Visible) { // Nama_Anggota_1 ?>
        <td data-name="Nama_Anggota_1"<?= $Page->Nama_Anggota_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Nama_Anggota_1" class="el_vproposal_pengabdian_diterima_Nama_Anggota_1">
<span<?= $Page->Nama_Anggota_1->viewAttributes() ?>>
<?= $Page->Nama_Anggota_1->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Anggota_2->Visible) { // Nama_Anggota_2 ?>
        <td data-name="Nama_Anggota_2"<?= $Page->Nama_Anggota_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Nama_Anggota_2" class="el_vproposal_pengabdian_diterima_Nama_Anggota_2">
<span<?= $Page->Nama_Anggota_2->viewAttributes() ?>>
<?= $Page->Nama_Anggota_2->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Judul_Penelitian->Visible) { // Judul_Penelitian ?>
        <td data-name="Judul_Penelitian"<?= $Page->Judul_Penelitian->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Judul_Penelitian" class="el_vproposal_pengabdian_diterima_Judul_Penelitian">
<span<?= $Page->Judul_Penelitian->viewAttributes() ?>>
<?= $Page->Judul_Penelitian->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Tanggal->Visible) { // Tanggal ?>
        <td data-name="Tanggal"<?= $Page->Tanggal->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Tanggal" class="el_vproposal_pengabdian_diterima_Tanggal">
<span<?= $Page->Tanggal->viewAttributes() ?>>
<?= $Page->Tanggal->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Status->Visible) { // Status ?>
        <td data-name="Status"<?= $Page->Status->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_vproposal_pengabdian_diterima_Status" class="el_vproposal_pengabdian_diterima_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
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
    ew.addEventHandlers("vproposal_pengabdian_diterima");
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fvproposal_pengabdian_diterimaadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fvproposal_pengabdian_diterimaadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fvproposal_pengabdian_diterimaedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fvproposal_pengabdian_diterimaedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fvproposal_pengabdian_diterimaupdate.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fvproposal_pengabdian_diterimaupdate").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fvproposal_pengabdian_diterimadelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fvproposal_pengabdian_diterimadelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport() && CurrentPageID()=="list") { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-grid-save, .ew-grid-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fvproposal_pengabdian_diterimalist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-update').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fvproposal_pengabdian_diterimalist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fvproposal_pengabdian_diterimalist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){var gridchange=false;$('[data-table="vproposal_pengabdian_diterima"]').change(function(){	gridchange=true;});$('.ew-grid-cancel,.ew-inline-cancel').click(function(){if (gridchange==true){ew.prompt({title: ew.language.phrase("ConfirmCancel"),icon:'question',showCancelButton:true},result=>{if(result) window.location = "<?php echo str_replace('_', '', 'vproposal_pengabdian_diterimalist'); ?>";});return false;}});});
</script>
<?php } ?>
<?php if (!$vproposal_pengabdian_diterima->isExport()) { ?>
<script>
loadjs.ready("jqueryjs", function() {
	var expires = new Date(new Date().getTime() + 525600 * 60 * 1000); // expire in 525600 
	var SearchToggle = $('.ew-search-toggle'); 
	SearchToggle.on('click', function(event) { 
		event.preventDefault(); 
		if (SearchToggle.hasClass('active')) { 
			Cookies.set("vproposal_pengabdian_diterima_searchpanel", "notactive", { path: '', expires: expires }); 
		} else { 
			Cookies.set("vproposal_pengabdian_diterima_searchpanel", "active", { path: '', expires: expires }); 
		} 
	});
});
</script>
<?php } ?>
<?php } ?>
