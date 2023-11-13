<?php

namespace PHPMaker2023\new2023;

// Page object
$DosenList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dosen: currentTable } });
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
<form name="fdosensrch" id="fdosensrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="on">
<div id="fdosensrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { dosen: currentTable } });
var currentForm;
var fdosensrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fdosensrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fdosensrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fdosensrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fdosensrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fdosensrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="dosen">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_dosen" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_dosenlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->NIDN->Visible) { // NIDN ?>
        <th data-name="NIDN" class="<?= $Page->NIDN->headerCellClass() ?>"><div id="elh_dosen_NIDN" class="dosen_NIDN"><?= $Page->renderFieldHeader($Page->NIDN) ?></div></th>
<?php } ?>
<?php if ($Page->Id_Sinta->Visible) { // Id_Sinta ?>
        <th data-name="Id_Sinta" class="<?= $Page->Id_Sinta->headerCellClass() ?>"><div id="elh_dosen_Id_Sinta" class="dosen_Id_Sinta"><?= $Page->renderFieldHeader($Page->Id_Sinta) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <th data-name="Nama_Lengkap" class="<?= $Page->Nama_Lengkap->headerCellClass() ?>"><div id="elh_dosen_Nama_Lengkap" class="dosen_Nama_Lengkap"><?= $Page->renderFieldHeader($Page->Nama_Lengkap) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
        <th data-name="Alamat" class="<?= $Page->Alamat->headerCellClass() ?>"><div id="elh_dosen_Alamat" class="dosen_Alamat"><?= $Page->renderFieldHeader($Page->Alamat) ?></div></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th data-name="_Email" class="<?= $Page->_Email->headerCellClass() ?>"><div id="elh_dosen__Email" class="dosen__Email"><?= $Page->renderFieldHeader($Page->_Email) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <th data-name="Jenis_Kelamin" class="<?= $Page->Jenis_Kelamin->headerCellClass() ?>"><div id="elh_dosen_Jenis_Kelamin" class="dosen_Jenis_Kelamin"><?= $Page->renderFieldHeader($Page->Jenis_Kelamin) ?></div></th>
<?php } ?>
<?php if ($Page->Program_Studi->Visible) { // Program_Studi ?>
        <th data-name="Program_Studi" class="<?= $Page->Program_Studi->headerCellClass() ?>"><div id="elh_dosen_Program_Studi" class="dosen_Program_Studi"><?= $Page->renderFieldHeader($Page->Program_Studi) ?></div></th>
<?php } ?>
<?php if ($Page->Jenjang_Pendidikan->Visible) { // Jenjang_Pendidikan ?>
        <th data-name="Jenjang_Pendidikan" class="<?= $Page->Jenjang_Pendidikan->headerCellClass() ?>"><div id="elh_dosen_Jenjang_Pendidikan" class="dosen_Jenjang_Pendidikan"><?= $Page->renderFieldHeader($Page->Jenjang_Pendidikan) ?></div></th>
<?php } ?>
<?php if ($Page->Jabatan_Fungsional->Visible) { // Jabatan_Fungsional ?>
        <th data-name="Jabatan_Fungsional" class="<?= $Page->Jabatan_Fungsional->headerCellClass() ?>"><div id="elh_dosen_Jabatan_Fungsional" class="dosen_Jabatan_Fungsional"><?= $Page->renderFieldHeader($Page->Jabatan_Fungsional) ?></div></th>
<?php } ?>
<?php if ($Page->Kepakaran->Visible) { // Kepakaran ?>
        <th data-name="Kepakaran" class="<?= $Page->Kepakaran->headerCellClass() ?>"><div id="elh_dosen_Kepakaran" class="dosen_Kepakaran"><?= $Page->renderFieldHeader($Page->Kepakaran) ?></div></th>
<?php } ?>
<?php if ($Page->Rumpun_Ilmu->Visible) { // Rumpun_Ilmu ?>
        <th data-name="Rumpun_Ilmu" class="<?= $Page->Rumpun_Ilmu->headerCellClass() ?>"><div id="elh_dosen_Rumpun_Ilmu" class="dosen_Rumpun_Ilmu"><?= $Page->renderFieldHeader($Page->Rumpun_Ilmu) ?></div></th>
<?php } ?>
<?php if ($Page->Aktif->Visible) { // Aktif ?>
        <th data-name="Aktif" class="<?= $Page->Aktif->headerCellClass() ?>"><div id="elh_dosen_Aktif" class="dosen_Aktif"><?= $Page->renderFieldHeader($Page->Aktif) ?></div></th>
<?php } ?>
<?php if ($Page->Validasi->Visible) { // Validasi ?>
        <th data-name="Validasi" class="<?= $Page->Validasi->headerCellClass() ?>"><div id="elh_dosen_Validasi" class="dosen_Validasi"><?= $Page->renderFieldHeader($Page->Validasi) ?></div></th>
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
    <?php if ($Page->NIDN->Visible) { // NIDN ?>
        <td data-name="NIDN"<?= $Page->NIDN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_NIDN" class="el_dosen_NIDN">
<span<?= $Page->NIDN->viewAttributes() ?>>
<?= $Page->NIDN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Id_Sinta->Visible) { // Id_Sinta ?>
        <td data-name="Id_Sinta"<?= $Page->Id_Sinta->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Id_Sinta" class="el_dosen_Id_Sinta">
<span<?= $Page->Id_Sinta->viewAttributes() ?>>
<?= $Page->Id_Sinta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <td data-name="Nama_Lengkap"<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Nama_Lengkap" class="el_dosen_Nama_Lengkap">
<span<?= $Page->Nama_Lengkap->viewAttributes() ?>>
<?= $Page->Nama_Lengkap->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat->Visible) { // Alamat ?>
        <td data-name="Alamat"<?= $Page->Alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Alamat" class="el_dosen_Alamat">
<span<?= $Page->Alamat->viewAttributes() ?>>
<?= $Page->Alamat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_Email->Visible) { // Email ?>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen__Email" class="el_dosen__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <td data-name="Jenis_Kelamin"<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jenis_Kelamin" class="el_dosen_Jenis_Kelamin">
<span<?= $Page->Jenis_Kelamin->viewAttributes() ?>>
<?= $Page->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Program_Studi->Visible) { // Program_Studi ?>
        <td data-name="Program_Studi"<?= $Page->Program_Studi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Program_Studi" class="el_dosen_Program_Studi">
<span<?= $Page->Program_Studi->viewAttributes() ?>>
<?= $Page->Program_Studi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenjang_Pendidikan->Visible) { // Jenjang_Pendidikan ?>
        <td data-name="Jenjang_Pendidikan"<?= $Page->Jenjang_Pendidikan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jenjang_Pendidikan" class="el_dosen_Jenjang_Pendidikan">
<span<?= $Page->Jenjang_Pendidikan->viewAttributes() ?>>
<?= $Page->Jenjang_Pendidikan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jabatan_Fungsional->Visible) { // Jabatan_Fungsional ?>
        <td data-name="Jabatan_Fungsional"<?= $Page->Jabatan_Fungsional->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jabatan_Fungsional" class="el_dosen_Jabatan_Fungsional">
<span<?= $Page->Jabatan_Fungsional->viewAttributes() ?>>
<?= $Page->Jabatan_Fungsional->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kepakaran->Visible) { // Kepakaran ?>
        <td data-name="Kepakaran"<?= $Page->Kepakaran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Kepakaran" class="el_dosen_Kepakaran">
<span<?= $Page->Kepakaran->viewAttributes() ?>>
<?= $Page->Kepakaran->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Rumpun_Ilmu->Visible) { // Rumpun_Ilmu ?>
        <td data-name="Rumpun_Ilmu"<?= $Page->Rumpun_Ilmu->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Rumpun_Ilmu" class="el_dosen_Rumpun_Ilmu">
<span<?= $Page->Rumpun_Ilmu->viewAttributes() ?>>
<?= $Page->Rumpun_Ilmu->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Aktif->Visible) { // Aktif ?>
        <td data-name="Aktif"<?= $Page->Aktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Aktif" class="el_dosen_Aktif">
<span<?= $Page->Aktif->viewAttributes() ?>>
<?= $Page->Aktif->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Validasi->Visible) { // Validasi ?>
        <td data-name="Validasi"<?= $Page->Validasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Validasi" class="el_dosen_Validasi">
<span<?= $Page->Validasi->viewAttributes() ?>>
<?= $Page->Validasi->getViewValue() ?></span>
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
<table id="tbl_dosenlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->NIDN->Visible) { // NIDN ?>
        <th data-name="NIDN" class="<?= $Page->NIDN->headerCellClass() ?>"><div id="elh_dosen_NIDN" class="dosen_NIDN"><?= $Page->renderFieldHeader($Page->NIDN) ?></div></th>
<?php } ?>
<?php if ($Page->Id_Sinta->Visible) { // Id_Sinta ?>
        <th data-name="Id_Sinta" class="<?= $Page->Id_Sinta->headerCellClass() ?>"><div id="elh_dosen_Id_Sinta" class="dosen_Id_Sinta"><?= $Page->renderFieldHeader($Page->Id_Sinta) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <th data-name="Nama_Lengkap" class="<?= $Page->Nama_Lengkap->headerCellClass() ?>"><div id="elh_dosen_Nama_Lengkap" class="dosen_Nama_Lengkap"><?= $Page->renderFieldHeader($Page->Nama_Lengkap) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
        <th data-name="Alamat" class="<?= $Page->Alamat->headerCellClass() ?>"><div id="elh_dosen_Alamat" class="dosen_Alamat"><?= $Page->renderFieldHeader($Page->Alamat) ?></div></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th data-name="_Email" class="<?= $Page->_Email->headerCellClass() ?>"><div id="elh_dosen__Email" class="dosen__Email"><?= $Page->renderFieldHeader($Page->_Email) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <th data-name="Jenis_Kelamin" class="<?= $Page->Jenis_Kelamin->headerCellClass() ?>"><div id="elh_dosen_Jenis_Kelamin" class="dosen_Jenis_Kelamin"><?= $Page->renderFieldHeader($Page->Jenis_Kelamin) ?></div></th>
<?php } ?>
<?php if ($Page->Program_Studi->Visible) { // Program_Studi ?>
        <th data-name="Program_Studi" class="<?= $Page->Program_Studi->headerCellClass() ?>"><div id="elh_dosen_Program_Studi" class="dosen_Program_Studi"><?= $Page->renderFieldHeader($Page->Program_Studi) ?></div></th>
<?php } ?>
<?php if ($Page->Jenjang_Pendidikan->Visible) { // Jenjang_Pendidikan ?>
        <th data-name="Jenjang_Pendidikan" class="<?= $Page->Jenjang_Pendidikan->headerCellClass() ?>"><div id="elh_dosen_Jenjang_Pendidikan" class="dosen_Jenjang_Pendidikan"><?= $Page->renderFieldHeader($Page->Jenjang_Pendidikan) ?></div></th>
<?php } ?>
<?php if ($Page->Jabatan_Fungsional->Visible) { // Jabatan_Fungsional ?>
        <th data-name="Jabatan_Fungsional" class="<?= $Page->Jabatan_Fungsional->headerCellClass() ?>"><div id="elh_dosen_Jabatan_Fungsional" class="dosen_Jabatan_Fungsional"><?= $Page->renderFieldHeader($Page->Jabatan_Fungsional) ?></div></th>
<?php } ?>
<?php if ($Page->Kepakaran->Visible) { // Kepakaran ?>
        <th data-name="Kepakaran" class="<?= $Page->Kepakaran->headerCellClass() ?>"><div id="elh_dosen_Kepakaran" class="dosen_Kepakaran"><?= $Page->renderFieldHeader($Page->Kepakaran) ?></div></th>
<?php } ?>
<?php if ($Page->Rumpun_Ilmu->Visible) { // Rumpun_Ilmu ?>
        <th data-name="Rumpun_Ilmu" class="<?= $Page->Rumpun_Ilmu->headerCellClass() ?>"><div id="elh_dosen_Rumpun_Ilmu" class="dosen_Rumpun_Ilmu"><?= $Page->renderFieldHeader($Page->Rumpun_Ilmu) ?></div></th>
<?php } ?>
<?php if ($Page->Aktif->Visible) { // Aktif ?>
        <th data-name="Aktif" class="<?= $Page->Aktif->headerCellClass() ?>"><div id="elh_dosen_Aktif" class="dosen_Aktif"><?= $Page->renderFieldHeader($Page->Aktif) ?></div></th>
<?php } ?>
<?php if ($Page->Validasi->Visible) { // Validasi ?>
        <th data-name="Validasi" class="<?= $Page->Validasi->headerCellClass() ?>"><div id="elh_dosen_Validasi" class="dosen_Validasi"><?= $Page->renderFieldHeader($Page->Validasi) ?></div></th>
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
    <?php if ($Page->NIDN->Visible) { // NIDN ?>
        <td data-name="NIDN"<?= $Page->NIDN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_NIDN" class="el_dosen_NIDN">
<span<?= $Page->NIDN->viewAttributes() ?>>
<?= $Page->NIDN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Id_Sinta->Visible) { // Id_Sinta ?>
        <td data-name="Id_Sinta"<?= $Page->Id_Sinta->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Id_Sinta" class="el_dosen_Id_Sinta">
<span<?= $Page->Id_Sinta->viewAttributes() ?>>
<?= $Page->Id_Sinta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <td data-name="Nama_Lengkap"<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Nama_Lengkap" class="el_dosen_Nama_Lengkap">
<span<?= $Page->Nama_Lengkap->viewAttributes() ?>>
<?= $Page->Nama_Lengkap->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat->Visible) { // Alamat ?>
        <td data-name="Alamat"<?= $Page->Alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Alamat" class="el_dosen_Alamat">
<span<?= $Page->Alamat->viewAttributes() ?>>
<?= $Page->Alamat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_Email->Visible) { // Email ?>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen__Email" class="el_dosen__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <td data-name="Jenis_Kelamin"<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jenis_Kelamin" class="el_dosen_Jenis_Kelamin">
<span<?= $Page->Jenis_Kelamin->viewAttributes() ?>>
<?= $Page->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Program_Studi->Visible) { // Program_Studi ?>
        <td data-name="Program_Studi"<?= $Page->Program_Studi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Program_Studi" class="el_dosen_Program_Studi">
<span<?= $Page->Program_Studi->viewAttributes() ?>>
<?= $Page->Program_Studi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenjang_Pendidikan->Visible) { // Jenjang_Pendidikan ?>
        <td data-name="Jenjang_Pendidikan"<?= $Page->Jenjang_Pendidikan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jenjang_Pendidikan" class="el_dosen_Jenjang_Pendidikan">
<span<?= $Page->Jenjang_Pendidikan->viewAttributes() ?>>
<?= $Page->Jenjang_Pendidikan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jabatan_Fungsional->Visible) { // Jabatan_Fungsional ?>
        <td data-name="Jabatan_Fungsional"<?= $Page->Jabatan_Fungsional->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jabatan_Fungsional" class="el_dosen_Jabatan_Fungsional">
<span<?= $Page->Jabatan_Fungsional->viewAttributes() ?>>
<?= $Page->Jabatan_Fungsional->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kepakaran->Visible) { // Kepakaran ?>
        <td data-name="Kepakaran"<?= $Page->Kepakaran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Kepakaran" class="el_dosen_Kepakaran">
<span<?= $Page->Kepakaran->viewAttributes() ?>>
<?= $Page->Kepakaran->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Rumpun_Ilmu->Visible) { // Rumpun_Ilmu ?>
        <td data-name="Rumpun_Ilmu"<?= $Page->Rumpun_Ilmu->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Rumpun_Ilmu" class="el_dosen_Rumpun_Ilmu">
<span<?= $Page->Rumpun_Ilmu->viewAttributes() ?>>
<?= $Page->Rumpun_Ilmu->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Aktif->Visible) { // Aktif ?>
        <td data-name="Aktif"<?= $Page->Aktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Aktif" class="el_dosen_Aktif">
<span<?= $Page->Aktif->viewAttributes() ?>>
<?= $Page->Aktif->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Validasi->Visible) { // Validasi ?>
        <td data-name="Validasi"<?= $Page->Validasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Validasi" class="el_dosen_Validasi">
<span<?= $Page->Validasi->viewAttributes() ?>>
<?= $Page->Validasi->getViewValue() ?></span>
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
<input type="hidden" name="t" value="dosen">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_dosen" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_dosenlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->NIDN->Visible) { // NIDN ?>
        <th data-name="NIDN" class="<?= $Page->NIDN->headerCellClass() ?>"><div id="elh_dosen_NIDN" class="dosen_NIDN"><?= $Page->renderFieldHeader($Page->NIDN) ?></div></th>
<?php } ?>
<?php if ($Page->Id_Sinta->Visible) { // Id_Sinta ?>
        <th data-name="Id_Sinta" class="<?= $Page->Id_Sinta->headerCellClass() ?>"><div id="elh_dosen_Id_Sinta" class="dosen_Id_Sinta"><?= $Page->renderFieldHeader($Page->Id_Sinta) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <th data-name="Nama_Lengkap" class="<?= $Page->Nama_Lengkap->headerCellClass() ?>"><div id="elh_dosen_Nama_Lengkap" class="dosen_Nama_Lengkap"><?= $Page->renderFieldHeader($Page->Nama_Lengkap) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
        <th data-name="Alamat" class="<?= $Page->Alamat->headerCellClass() ?>"><div id="elh_dosen_Alamat" class="dosen_Alamat"><?= $Page->renderFieldHeader($Page->Alamat) ?></div></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th data-name="_Email" class="<?= $Page->_Email->headerCellClass() ?>"><div id="elh_dosen__Email" class="dosen__Email"><?= $Page->renderFieldHeader($Page->_Email) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <th data-name="Jenis_Kelamin" class="<?= $Page->Jenis_Kelamin->headerCellClass() ?>"><div id="elh_dosen_Jenis_Kelamin" class="dosen_Jenis_Kelamin"><?= $Page->renderFieldHeader($Page->Jenis_Kelamin) ?></div></th>
<?php } ?>
<?php if ($Page->Program_Studi->Visible) { // Program_Studi ?>
        <th data-name="Program_Studi" class="<?= $Page->Program_Studi->headerCellClass() ?>"><div id="elh_dosen_Program_Studi" class="dosen_Program_Studi"><?= $Page->renderFieldHeader($Page->Program_Studi) ?></div></th>
<?php } ?>
<?php if ($Page->Jenjang_Pendidikan->Visible) { // Jenjang_Pendidikan ?>
        <th data-name="Jenjang_Pendidikan" class="<?= $Page->Jenjang_Pendidikan->headerCellClass() ?>"><div id="elh_dosen_Jenjang_Pendidikan" class="dosen_Jenjang_Pendidikan"><?= $Page->renderFieldHeader($Page->Jenjang_Pendidikan) ?></div></th>
<?php } ?>
<?php if ($Page->Jabatan_Fungsional->Visible) { // Jabatan_Fungsional ?>
        <th data-name="Jabatan_Fungsional" class="<?= $Page->Jabatan_Fungsional->headerCellClass() ?>"><div id="elh_dosen_Jabatan_Fungsional" class="dosen_Jabatan_Fungsional"><?= $Page->renderFieldHeader($Page->Jabatan_Fungsional) ?></div></th>
<?php } ?>
<?php if ($Page->Kepakaran->Visible) { // Kepakaran ?>
        <th data-name="Kepakaran" class="<?= $Page->Kepakaran->headerCellClass() ?>"><div id="elh_dosen_Kepakaran" class="dosen_Kepakaran"><?= $Page->renderFieldHeader($Page->Kepakaran) ?></div></th>
<?php } ?>
<?php if ($Page->Rumpun_Ilmu->Visible) { // Rumpun_Ilmu ?>
        <th data-name="Rumpun_Ilmu" class="<?= $Page->Rumpun_Ilmu->headerCellClass() ?>"><div id="elh_dosen_Rumpun_Ilmu" class="dosen_Rumpun_Ilmu"><?= $Page->renderFieldHeader($Page->Rumpun_Ilmu) ?></div></th>
<?php } ?>
<?php if ($Page->Aktif->Visible) { // Aktif ?>
        <th data-name="Aktif" class="<?= $Page->Aktif->headerCellClass() ?>"><div id="elh_dosen_Aktif" class="dosen_Aktif"><?= $Page->renderFieldHeader($Page->Aktif) ?></div></th>
<?php } ?>
<?php if ($Page->Validasi->Visible) { // Validasi ?>
        <th data-name="Validasi" class="<?= $Page->Validasi->headerCellClass() ?>"><div id="elh_dosen_Validasi" class="dosen_Validasi"><?= $Page->renderFieldHeader($Page->Validasi) ?></div></th>
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
    <?php if ($Page->NIDN->Visible) { // NIDN ?>
        <td data-name="NIDN"<?= $Page->NIDN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_NIDN" class="el_dosen_NIDN">
<span<?= $Page->NIDN->viewAttributes() ?>>
<?= $Page->NIDN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Id_Sinta->Visible) { // Id_Sinta ?>
        <td data-name="Id_Sinta"<?= $Page->Id_Sinta->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Id_Sinta" class="el_dosen_Id_Sinta">
<span<?= $Page->Id_Sinta->viewAttributes() ?>>
<?= $Page->Id_Sinta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <td data-name="Nama_Lengkap"<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Nama_Lengkap" class="el_dosen_Nama_Lengkap">
<span<?= $Page->Nama_Lengkap->viewAttributes() ?>>
<?= $Page->Nama_Lengkap->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat->Visible) { // Alamat ?>
        <td data-name="Alamat"<?= $Page->Alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Alamat" class="el_dosen_Alamat">
<span<?= $Page->Alamat->viewAttributes() ?>>
<?= $Page->Alamat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_Email->Visible) { // Email ?>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen__Email" class="el_dosen__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <td data-name="Jenis_Kelamin"<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jenis_Kelamin" class="el_dosen_Jenis_Kelamin">
<span<?= $Page->Jenis_Kelamin->viewAttributes() ?>>
<?= $Page->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Program_Studi->Visible) { // Program_Studi ?>
        <td data-name="Program_Studi"<?= $Page->Program_Studi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Program_Studi" class="el_dosen_Program_Studi">
<span<?= $Page->Program_Studi->viewAttributes() ?>>
<?= $Page->Program_Studi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenjang_Pendidikan->Visible) { // Jenjang_Pendidikan ?>
        <td data-name="Jenjang_Pendidikan"<?= $Page->Jenjang_Pendidikan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jenjang_Pendidikan" class="el_dosen_Jenjang_Pendidikan">
<span<?= $Page->Jenjang_Pendidikan->viewAttributes() ?>>
<?= $Page->Jenjang_Pendidikan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jabatan_Fungsional->Visible) { // Jabatan_Fungsional ?>
        <td data-name="Jabatan_Fungsional"<?= $Page->Jabatan_Fungsional->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jabatan_Fungsional" class="el_dosen_Jabatan_Fungsional">
<span<?= $Page->Jabatan_Fungsional->viewAttributes() ?>>
<?= $Page->Jabatan_Fungsional->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kepakaran->Visible) { // Kepakaran ?>
        <td data-name="Kepakaran"<?= $Page->Kepakaran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Kepakaran" class="el_dosen_Kepakaran">
<span<?= $Page->Kepakaran->viewAttributes() ?>>
<?= $Page->Kepakaran->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Rumpun_Ilmu->Visible) { // Rumpun_Ilmu ?>
        <td data-name="Rumpun_Ilmu"<?= $Page->Rumpun_Ilmu->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Rumpun_Ilmu" class="el_dosen_Rumpun_Ilmu">
<span<?= $Page->Rumpun_Ilmu->viewAttributes() ?>>
<?= $Page->Rumpun_Ilmu->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Aktif->Visible) { // Aktif ?>
        <td data-name="Aktif"<?= $Page->Aktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Aktif" class="el_dosen_Aktif">
<span<?= $Page->Aktif->viewAttributes() ?>>
<?= $Page->Aktif->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Validasi->Visible) { // Validasi ?>
        <td data-name="Validasi"<?= $Page->Validasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Validasi" class="el_dosen_Validasi">
<span<?= $Page->Validasi->viewAttributes() ?>>
<?= $Page->Validasi->getViewValue() ?></span>
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
<table id="tbl_dosenlist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->NIDN->Visible) { // NIDN ?>
        <th data-name="NIDN" class="<?= $Page->NIDN->headerCellClass() ?>"><div id="elh_dosen_NIDN" class="dosen_NIDN"><?= $Page->renderFieldHeader($Page->NIDN) ?></div></th>
<?php } ?>
<?php if ($Page->Id_Sinta->Visible) { // Id_Sinta ?>
        <th data-name="Id_Sinta" class="<?= $Page->Id_Sinta->headerCellClass() ?>"><div id="elh_dosen_Id_Sinta" class="dosen_Id_Sinta"><?= $Page->renderFieldHeader($Page->Id_Sinta) ?></div></th>
<?php } ?>
<?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <th data-name="Nama_Lengkap" class="<?= $Page->Nama_Lengkap->headerCellClass() ?>"><div id="elh_dosen_Nama_Lengkap" class="dosen_Nama_Lengkap"><?= $Page->renderFieldHeader($Page->Nama_Lengkap) ?></div></th>
<?php } ?>
<?php if ($Page->Alamat->Visible) { // Alamat ?>
        <th data-name="Alamat" class="<?= $Page->Alamat->headerCellClass() ?>"><div id="elh_dosen_Alamat" class="dosen_Alamat"><?= $Page->renderFieldHeader($Page->Alamat) ?></div></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th data-name="_Email" class="<?= $Page->_Email->headerCellClass() ?>"><div id="elh_dosen__Email" class="dosen__Email"><?= $Page->renderFieldHeader($Page->_Email) ?></div></th>
<?php } ?>
<?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <th data-name="Jenis_Kelamin" class="<?= $Page->Jenis_Kelamin->headerCellClass() ?>"><div id="elh_dosen_Jenis_Kelamin" class="dosen_Jenis_Kelamin"><?= $Page->renderFieldHeader($Page->Jenis_Kelamin) ?></div></th>
<?php } ?>
<?php if ($Page->Program_Studi->Visible) { // Program_Studi ?>
        <th data-name="Program_Studi" class="<?= $Page->Program_Studi->headerCellClass() ?>"><div id="elh_dosen_Program_Studi" class="dosen_Program_Studi"><?= $Page->renderFieldHeader($Page->Program_Studi) ?></div></th>
<?php } ?>
<?php if ($Page->Jenjang_Pendidikan->Visible) { // Jenjang_Pendidikan ?>
        <th data-name="Jenjang_Pendidikan" class="<?= $Page->Jenjang_Pendidikan->headerCellClass() ?>"><div id="elh_dosen_Jenjang_Pendidikan" class="dosen_Jenjang_Pendidikan"><?= $Page->renderFieldHeader($Page->Jenjang_Pendidikan) ?></div></th>
<?php } ?>
<?php if ($Page->Jabatan_Fungsional->Visible) { // Jabatan_Fungsional ?>
        <th data-name="Jabatan_Fungsional" class="<?= $Page->Jabatan_Fungsional->headerCellClass() ?>"><div id="elh_dosen_Jabatan_Fungsional" class="dosen_Jabatan_Fungsional"><?= $Page->renderFieldHeader($Page->Jabatan_Fungsional) ?></div></th>
<?php } ?>
<?php if ($Page->Kepakaran->Visible) { // Kepakaran ?>
        <th data-name="Kepakaran" class="<?= $Page->Kepakaran->headerCellClass() ?>"><div id="elh_dosen_Kepakaran" class="dosen_Kepakaran"><?= $Page->renderFieldHeader($Page->Kepakaran) ?></div></th>
<?php } ?>
<?php if ($Page->Rumpun_Ilmu->Visible) { // Rumpun_Ilmu ?>
        <th data-name="Rumpun_Ilmu" class="<?= $Page->Rumpun_Ilmu->headerCellClass() ?>"><div id="elh_dosen_Rumpun_Ilmu" class="dosen_Rumpun_Ilmu"><?= $Page->renderFieldHeader($Page->Rumpun_Ilmu) ?></div></th>
<?php } ?>
<?php if ($Page->Aktif->Visible) { // Aktif ?>
        <th data-name="Aktif" class="<?= $Page->Aktif->headerCellClass() ?>"><div id="elh_dosen_Aktif" class="dosen_Aktif"><?= $Page->renderFieldHeader($Page->Aktif) ?></div></th>
<?php } ?>
<?php if ($Page->Validasi->Visible) { // Validasi ?>
        <th data-name="Validasi" class="<?= $Page->Validasi->headerCellClass() ?>"><div id="elh_dosen_Validasi" class="dosen_Validasi"><?= $Page->renderFieldHeader($Page->Validasi) ?></div></th>
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
    <?php if ($Page->NIDN->Visible) { // NIDN ?>
        <td data-name="NIDN"<?= $Page->NIDN->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_NIDN" class="el_dosen_NIDN">
<span<?= $Page->NIDN->viewAttributes() ?>>
<?= $Page->NIDN->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Id_Sinta->Visible) { // Id_Sinta ?>
        <td data-name="Id_Sinta"<?= $Page->Id_Sinta->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Id_Sinta" class="el_dosen_Id_Sinta">
<span<?= $Page->Id_Sinta->viewAttributes() ?>>
<?= $Page->Id_Sinta->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Nama_Lengkap->Visible) { // Nama_Lengkap ?>
        <td data-name="Nama_Lengkap"<?= $Page->Nama_Lengkap->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Nama_Lengkap" class="el_dosen_Nama_Lengkap">
<span<?= $Page->Nama_Lengkap->viewAttributes() ?>>
<?= $Page->Nama_Lengkap->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Alamat->Visible) { // Alamat ?>
        <td data-name="Alamat"<?= $Page->Alamat->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Alamat" class="el_dosen_Alamat">
<span<?= $Page->Alamat->viewAttributes() ?>>
<?= $Page->Alamat->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_Email->Visible) { // Email ?>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen__Email" class="el_dosen__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenis_Kelamin->Visible) { // Jenis_Kelamin ?>
        <td data-name="Jenis_Kelamin"<?= $Page->Jenis_Kelamin->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jenis_Kelamin" class="el_dosen_Jenis_Kelamin">
<span<?= $Page->Jenis_Kelamin->viewAttributes() ?>>
<?= $Page->Jenis_Kelamin->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Program_Studi->Visible) { // Program_Studi ?>
        <td data-name="Program_Studi"<?= $Page->Program_Studi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Program_Studi" class="el_dosen_Program_Studi">
<span<?= $Page->Program_Studi->viewAttributes() ?>>
<?= $Page->Program_Studi->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jenjang_Pendidikan->Visible) { // Jenjang_Pendidikan ?>
        <td data-name="Jenjang_Pendidikan"<?= $Page->Jenjang_Pendidikan->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jenjang_Pendidikan" class="el_dosen_Jenjang_Pendidikan">
<span<?= $Page->Jenjang_Pendidikan->viewAttributes() ?>>
<?= $Page->Jenjang_Pendidikan->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Jabatan_Fungsional->Visible) { // Jabatan_Fungsional ?>
        <td data-name="Jabatan_Fungsional"<?= $Page->Jabatan_Fungsional->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Jabatan_Fungsional" class="el_dosen_Jabatan_Fungsional">
<span<?= $Page->Jabatan_Fungsional->viewAttributes() ?>>
<?= $Page->Jabatan_Fungsional->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Kepakaran->Visible) { // Kepakaran ?>
        <td data-name="Kepakaran"<?= $Page->Kepakaran->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Kepakaran" class="el_dosen_Kepakaran">
<span<?= $Page->Kepakaran->viewAttributes() ?>>
<?= $Page->Kepakaran->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Rumpun_Ilmu->Visible) { // Rumpun_Ilmu ?>
        <td data-name="Rumpun_Ilmu"<?= $Page->Rumpun_Ilmu->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Rumpun_Ilmu" class="el_dosen_Rumpun_Ilmu">
<span<?= $Page->Rumpun_Ilmu->viewAttributes() ?>>
<?= $Page->Rumpun_Ilmu->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Aktif->Visible) { // Aktif ?>
        <td data-name="Aktif"<?= $Page->Aktif->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Aktif" class="el_dosen_Aktif">
<span<?= $Page->Aktif->viewAttributes() ?>>
<?= $Page->Aktif->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Validasi->Visible) { // Validasi ?>
        <td data-name="Validasi"<?= $Page->Validasi->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_dosen_Validasi" class="el_dosen_Validasi">
<span<?= $Page->Validasi->viewAttributes() ?>>
<?= $Page->Validasi->getViewValue() ?></span>
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
    ew.addEventHandlers("dosen");
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosenadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdosenadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosenedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fdosenedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosenupdate.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdosenupdate").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fdosendelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdosendelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport() && CurrentPageID()=="list") { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-grid-save, .ew-grid-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdosenlist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-update').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdosenlist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fdosenlist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){var gridchange=false;$('[data-table="dosen"]').change(function(){	gridchange=true;});$('.ew-grid-cancel,.ew-inline-cancel').click(function(){if (gridchange==true){ew.prompt({title: ew.language.phrase("ConfirmCancel"),icon:'question',showCancelButton:true},result=>{if(result) window.location = "<?php echo str_replace('_', '', 'dosenlist'); ?>";});return false;}});});
</script>
<?php } ?>
<?php if (!$dosen->isExport()) { ?>
<script>
loadjs.ready("jqueryjs", function() {
	var expires = new Date(new Date().getTime() + 525600 * 60 * 1000); // expire in 525600 
	var SearchToggle = $('.ew-search-toggle'); 
	SearchToggle.on('click', function(event) { 
		event.preventDefault(); 
		if (SearchToggle.hasClass('active')) { 
			Cookies.set("dosen_searchpanel", "notactive", { path: '', expires: expires }); 
		} else { 
			Cookies.set("dosen_searchpanel", "active", { path: '', expires: expires }); 
		} 
	});
});
</script>
<?php } ?>
<?php } ?>
