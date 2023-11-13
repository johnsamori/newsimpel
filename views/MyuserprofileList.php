<?php

namespace PHPMaker2023\new2023;

// Page object
$MyuserprofileList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { myuserprofile: currentTable } });
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
<form name="fmyuserprofilesrch" id="fmyuserprofilesrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>" novalidate autocomplete="on">
<div id="fmyuserprofilesrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { myuserprofile: currentTable } });
var currentForm;
var fmyuserprofilesrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    let $ = jQuery,
        fields = currentTable.fields;

    // Form object for search
    let form = new ew.FormBuilder()
        .setId("fmyuserprofilesrch")
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fmyuserprofilesrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fmyuserprofilesrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fmyuserprofilesrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fmyuserprofilesrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<input type="hidden" name="t" value="myuserprofile">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_myuserprofile" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_myuserprofilelist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->_Username->Visible) { // Username ?>
        <th data-name="_Username" class="<?= $Page->_Username->headerCellClass() ?>"><div id="elh_myuserprofile__Username" class="myuserprofile__Username"><?= $Page->renderFieldHeader($Page->_Username) ?></div></th>
<?php } ?>
<?php if ($Page->First_Name->Visible) { // First_Name ?>
        <th data-name="First_Name" class="<?= $Page->First_Name->headerCellClass() ?>"><div id="elh_myuserprofile_First_Name" class="myuserprofile_First_Name"><?= $Page->renderFieldHeader($Page->First_Name) ?></div></th>
<?php } ?>
<?php if ($Page->Last_Name->Visible) { // Last_Name ?>
        <th data-name="Last_Name" class="<?= $Page->Last_Name->headerCellClass() ?>"><div id="elh_myuserprofile_Last_Name" class="myuserprofile_Last_Name"><?= $Page->renderFieldHeader($Page->Last_Name) ?></div></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th data-name="_Email" class="<?= $Page->_Email->headerCellClass() ?>"><div id="elh_myuserprofile__Email" class="myuserprofile__Email"><?= $Page->renderFieldHeader($Page->_Email) ?></div></th>
<?php } ?>
<?php if ($Page->User_Level->Visible) { // User_Level ?>
        <th data-name="User_Level" class="<?= $Page->User_Level->headerCellClass() ?>"><div id="elh_myuserprofile_User_Level" class="myuserprofile_User_Level"><?= $Page->renderFieldHeader($Page->User_Level) ?></div></th>
<?php } ?>
<?php if ($Page->Report_To->Visible) { // Report_To ?>
        <th data-name="Report_To" class="<?= $Page->Report_To->headerCellClass() ?>"><div id="elh_myuserprofile_Report_To" class="myuserprofile_Report_To"><?= $Page->renderFieldHeader($Page->Report_To) ?></div></th>
<?php } ?>
<?php if ($Page->Activated->Visible) { // Activated ?>
        <th data-name="Activated" class="<?= $Page->Activated->headerCellClass() ?>"><div id="elh_myuserprofile_Activated" class="myuserprofile_Activated"><?= $Page->renderFieldHeader($Page->Activated) ?></div></th>
<?php } ?>
<?php if ($Page->Locked->Visible) { // Locked ?>
        <th data-name="Locked" class="<?= $Page->Locked->headerCellClass() ?>"><div id="elh_myuserprofile_Locked" class="myuserprofile_Locked"><?= $Page->renderFieldHeader($Page->Locked) ?></div></th>
<?php } ?>
<?php if ($Page->Photo->Visible) { // Photo ?>
        <th data-name="Photo" class="<?= $Page->Photo->headerCellClass() ?>"><div id="elh_myuserprofile_Photo" class="myuserprofile_Photo"><?= $Page->renderFieldHeader($Page->Photo) ?></div></th>
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
    <?php if ($Page->_Username->Visible) { // Username ?>
        <td data-name="_Username"<?= $Page->_Username->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile__Username" class="el_myuserprofile__Username">
<span<?= $Page->_Username->viewAttributes() ?>>
<?= $Page->_Username->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->First_Name->Visible) { // First_Name ?>
        <td data-name="First_Name"<?= $Page->First_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_First_Name" class="el_myuserprofile_First_Name">
<span<?= $Page->First_Name->viewAttributes() ?>>
<?= $Page->First_Name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Last_Name->Visible) { // Last_Name ?>
        <td data-name="Last_Name"<?= $Page->Last_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Last_Name" class="el_myuserprofile_Last_Name">
<span<?= $Page->Last_Name->viewAttributes() ?>>
<?= $Page->Last_Name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_Email->Visible) { // Email ?>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile__Email" class="el_myuserprofile__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->User_Level->Visible) { // User_Level ?>
        <td data-name="User_Level"<?= $Page->User_Level->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_User_Level" class="el_myuserprofile_User_Level">
<span<?= $Page->User_Level->viewAttributes() ?>>
<?= $Page->User_Level->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Report_To->Visible) { // Report_To ?>
        <td data-name="Report_To"<?= $Page->Report_To->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Report_To" class="el_myuserprofile_Report_To">
<span<?= $Page->Report_To->viewAttributes() ?>>
<?= $Page->Report_To->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Activated->Visible) { // Activated ?>
        <td data-name="Activated"<?= $Page->Activated->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Activated" class="el_myuserprofile_Activated">
<span<?= $Page->Activated->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_Activated_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->Activated->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Activated->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_Activated_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Locked->Visible) { // Locked ?>
        <td data-name="Locked"<?= $Page->Locked->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Locked" class="el_myuserprofile_Locked">
<span<?= $Page->Locked->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_Locked_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->Locked->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Locked->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_Locked_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Photo->Visible) { // Photo ?>
        <td data-name="Photo"<?= $Page->Photo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Photo" class="el_myuserprofile_Photo">
<span>
<?= GetFileViewTag($Page->Photo, $Page->Photo->getViewValue(), false) ?>
</span>
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
<table id="tbl_myuserprofilelist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->_Username->Visible) { // Username ?>
        <th data-name="_Username" class="<?= $Page->_Username->headerCellClass() ?>"><div id="elh_myuserprofile__Username" class="myuserprofile__Username"><?= $Page->renderFieldHeader($Page->_Username) ?></div></th>
<?php } ?>
<?php if ($Page->First_Name->Visible) { // First_Name ?>
        <th data-name="First_Name" class="<?= $Page->First_Name->headerCellClass() ?>"><div id="elh_myuserprofile_First_Name" class="myuserprofile_First_Name"><?= $Page->renderFieldHeader($Page->First_Name) ?></div></th>
<?php } ?>
<?php if ($Page->Last_Name->Visible) { // Last_Name ?>
        <th data-name="Last_Name" class="<?= $Page->Last_Name->headerCellClass() ?>"><div id="elh_myuserprofile_Last_Name" class="myuserprofile_Last_Name"><?= $Page->renderFieldHeader($Page->Last_Name) ?></div></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th data-name="_Email" class="<?= $Page->_Email->headerCellClass() ?>"><div id="elh_myuserprofile__Email" class="myuserprofile__Email"><?= $Page->renderFieldHeader($Page->_Email) ?></div></th>
<?php } ?>
<?php if ($Page->User_Level->Visible) { // User_Level ?>
        <th data-name="User_Level" class="<?= $Page->User_Level->headerCellClass() ?>"><div id="elh_myuserprofile_User_Level" class="myuserprofile_User_Level"><?= $Page->renderFieldHeader($Page->User_Level) ?></div></th>
<?php } ?>
<?php if ($Page->Report_To->Visible) { // Report_To ?>
        <th data-name="Report_To" class="<?= $Page->Report_To->headerCellClass() ?>"><div id="elh_myuserprofile_Report_To" class="myuserprofile_Report_To"><?= $Page->renderFieldHeader($Page->Report_To) ?></div></th>
<?php } ?>
<?php if ($Page->Activated->Visible) { // Activated ?>
        <th data-name="Activated" class="<?= $Page->Activated->headerCellClass() ?>"><div id="elh_myuserprofile_Activated" class="myuserprofile_Activated"><?= $Page->renderFieldHeader($Page->Activated) ?></div></th>
<?php } ?>
<?php if ($Page->Locked->Visible) { // Locked ?>
        <th data-name="Locked" class="<?= $Page->Locked->headerCellClass() ?>"><div id="elh_myuserprofile_Locked" class="myuserprofile_Locked"><?= $Page->renderFieldHeader($Page->Locked) ?></div></th>
<?php } ?>
<?php if ($Page->Photo->Visible) { // Photo ?>
        <th data-name="Photo" class="<?= $Page->Photo->headerCellClass() ?>"><div id="elh_myuserprofile_Photo" class="myuserprofile_Photo"><?= $Page->renderFieldHeader($Page->Photo) ?></div></th>
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
    <?php if ($Page->_Username->Visible) { // Username ?>
        <td data-name="_Username"<?= $Page->_Username->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile__Username" class="el_myuserprofile__Username">
<span<?= $Page->_Username->viewAttributes() ?>>
<?= $Page->_Username->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->First_Name->Visible) { // First_Name ?>
        <td data-name="First_Name"<?= $Page->First_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_First_Name" class="el_myuserprofile_First_Name">
<span<?= $Page->First_Name->viewAttributes() ?>>
<?= $Page->First_Name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Last_Name->Visible) { // Last_Name ?>
        <td data-name="Last_Name"<?= $Page->Last_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Last_Name" class="el_myuserprofile_Last_Name">
<span<?= $Page->Last_Name->viewAttributes() ?>>
<?= $Page->Last_Name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_Email->Visible) { // Email ?>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile__Email" class="el_myuserprofile__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->User_Level->Visible) { // User_Level ?>
        <td data-name="User_Level"<?= $Page->User_Level->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_User_Level" class="el_myuserprofile_User_Level">
<span<?= $Page->User_Level->viewAttributes() ?>>
<?= $Page->User_Level->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Report_To->Visible) { // Report_To ?>
        <td data-name="Report_To"<?= $Page->Report_To->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Report_To" class="el_myuserprofile_Report_To">
<span<?= $Page->Report_To->viewAttributes() ?>>
<?= $Page->Report_To->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Activated->Visible) { // Activated ?>
        <td data-name="Activated"<?= $Page->Activated->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Activated" class="el_myuserprofile_Activated">
<span<?= $Page->Activated->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_Activated_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->Activated->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Activated->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_Activated_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Locked->Visible) { // Locked ?>
        <td data-name="Locked"<?= $Page->Locked->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Locked" class="el_myuserprofile_Locked">
<span<?= $Page->Locked->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_Locked_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->Locked->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Locked->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_Locked_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Photo->Visible) { // Photo ?>
        <td data-name="Photo"<?= $Page->Photo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Photo" class="el_myuserprofile_Photo">
<span>
<?= GetFileViewTag($Page->Photo, $Page->Photo->getViewValue(), false) ?>
</span>
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
<input type="hidden" name="t" value="myuserprofile">
<?php if ($Page->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<div id="gmp_myuserprofile" class="card-body ew-grid-middle-panel <?= $Page->TableContainerClass ?>" style="<?= $Page->TableContainerStyle ?>">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit() || $Page->isMultiEdit()) { ?>
<table id="tbl_myuserprofilelist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->_Username->Visible) { // Username ?>
        <th data-name="_Username" class="<?= $Page->_Username->headerCellClass() ?>"><div id="elh_myuserprofile__Username" class="myuserprofile__Username"><?= $Page->renderFieldHeader($Page->_Username) ?></div></th>
<?php } ?>
<?php if ($Page->First_Name->Visible) { // First_Name ?>
        <th data-name="First_Name" class="<?= $Page->First_Name->headerCellClass() ?>"><div id="elh_myuserprofile_First_Name" class="myuserprofile_First_Name"><?= $Page->renderFieldHeader($Page->First_Name) ?></div></th>
<?php } ?>
<?php if ($Page->Last_Name->Visible) { // Last_Name ?>
        <th data-name="Last_Name" class="<?= $Page->Last_Name->headerCellClass() ?>"><div id="elh_myuserprofile_Last_Name" class="myuserprofile_Last_Name"><?= $Page->renderFieldHeader($Page->Last_Name) ?></div></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th data-name="_Email" class="<?= $Page->_Email->headerCellClass() ?>"><div id="elh_myuserprofile__Email" class="myuserprofile__Email"><?= $Page->renderFieldHeader($Page->_Email) ?></div></th>
<?php } ?>
<?php if ($Page->User_Level->Visible) { // User_Level ?>
        <th data-name="User_Level" class="<?= $Page->User_Level->headerCellClass() ?>"><div id="elh_myuserprofile_User_Level" class="myuserprofile_User_Level"><?= $Page->renderFieldHeader($Page->User_Level) ?></div></th>
<?php } ?>
<?php if ($Page->Report_To->Visible) { // Report_To ?>
        <th data-name="Report_To" class="<?= $Page->Report_To->headerCellClass() ?>"><div id="elh_myuserprofile_Report_To" class="myuserprofile_Report_To"><?= $Page->renderFieldHeader($Page->Report_To) ?></div></th>
<?php } ?>
<?php if ($Page->Activated->Visible) { // Activated ?>
        <th data-name="Activated" class="<?= $Page->Activated->headerCellClass() ?>"><div id="elh_myuserprofile_Activated" class="myuserprofile_Activated"><?= $Page->renderFieldHeader($Page->Activated) ?></div></th>
<?php } ?>
<?php if ($Page->Locked->Visible) { // Locked ?>
        <th data-name="Locked" class="<?= $Page->Locked->headerCellClass() ?>"><div id="elh_myuserprofile_Locked" class="myuserprofile_Locked"><?= $Page->renderFieldHeader($Page->Locked) ?></div></th>
<?php } ?>
<?php if ($Page->Photo->Visible) { // Photo ?>
        <th data-name="Photo" class="<?= $Page->Photo->headerCellClass() ?>"><div id="elh_myuserprofile_Photo" class="myuserprofile_Photo"><?= $Page->renderFieldHeader($Page->Photo) ?></div></th>
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
    <?php if ($Page->_Username->Visible) { // Username ?>
        <td data-name="_Username"<?= $Page->_Username->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile__Username" class="el_myuserprofile__Username">
<span<?= $Page->_Username->viewAttributes() ?>>
<?= $Page->_Username->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->First_Name->Visible) { // First_Name ?>
        <td data-name="First_Name"<?= $Page->First_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_First_Name" class="el_myuserprofile_First_Name">
<span<?= $Page->First_Name->viewAttributes() ?>>
<?= $Page->First_Name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Last_Name->Visible) { // Last_Name ?>
        <td data-name="Last_Name"<?= $Page->Last_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Last_Name" class="el_myuserprofile_Last_Name">
<span<?= $Page->Last_Name->viewAttributes() ?>>
<?= $Page->Last_Name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_Email->Visible) { // Email ?>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile__Email" class="el_myuserprofile__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->User_Level->Visible) { // User_Level ?>
        <td data-name="User_Level"<?= $Page->User_Level->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_User_Level" class="el_myuserprofile_User_Level">
<span<?= $Page->User_Level->viewAttributes() ?>>
<?= $Page->User_Level->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Report_To->Visible) { // Report_To ?>
        <td data-name="Report_To"<?= $Page->Report_To->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Report_To" class="el_myuserprofile_Report_To">
<span<?= $Page->Report_To->viewAttributes() ?>>
<?= $Page->Report_To->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Activated->Visible) { // Activated ?>
        <td data-name="Activated"<?= $Page->Activated->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Activated" class="el_myuserprofile_Activated">
<span<?= $Page->Activated->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_Activated_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->Activated->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Activated->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_Activated_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Locked->Visible) { // Locked ?>
        <td data-name="Locked"<?= $Page->Locked->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Locked" class="el_myuserprofile_Locked">
<span<?= $Page->Locked->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_Locked_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->Locked->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Locked->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_Locked_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Photo->Visible) { // Photo ?>
        <td data-name="Photo"<?= $Page->Photo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Photo" class="el_myuserprofile_Photo">
<span>
<?= GetFileViewTag($Page->Photo, $Page->Photo->getViewValue(), false) ?>
</span>
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
<table id="tbl_myuserprofilelist" class="<?= $Page->TableClass ?>"><!-- .ew-table -->
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
<?php if ($Page->_Username->Visible) { // Username ?>
        <th data-name="_Username" class="<?= $Page->_Username->headerCellClass() ?>"><div id="elh_myuserprofile__Username" class="myuserprofile__Username"><?= $Page->renderFieldHeader($Page->_Username) ?></div></th>
<?php } ?>
<?php if ($Page->First_Name->Visible) { // First_Name ?>
        <th data-name="First_Name" class="<?= $Page->First_Name->headerCellClass() ?>"><div id="elh_myuserprofile_First_Name" class="myuserprofile_First_Name"><?= $Page->renderFieldHeader($Page->First_Name) ?></div></th>
<?php } ?>
<?php if ($Page->Last_Name->Visible) { // Last_Name ?>
        <th data-name="Last_Name" class="<?= $Page->Last_Name->headerCellClass() ?>"><div id="elh_myuserprofile_Last_Name" class="myuserprofile_Last_Name"><?= $Page->renderFieldHeader($Page->Last_Name) ?></div></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th data-name="_Email" class="<?= $Page->_Email->headerCellClass() ?>"><div id="elh_myuserprofile__Email" class="myuserprofile__Email"><?= $Page->renderFieldHeader($Page->_Email) ?></div></th>
<?php } ?>
<?php if ($Page->User_Level->Visible) { // User_Level ?>
        <th data-name="User_Level" class="<?= $Page->User_Level->headerCellClass() ?>"><div id="elh_myuserprofile_User_Level" class="myuserprofile_User_Level"><?= $Page->renderFieldHeader($Page->User_Level) ?></div></th>
<?php } ?>
<?php if ($Page->Report_To->Visible) { // Report_To ?>
        <th data-name="Report_To" class="<?= $Page->Report_To->headerCellClass() ?>"><div id="elh_myuserprofile_Report_To" class="myuserprofile_Report_To"><?= $Page->renderFieldHeader($Page->Report_To) ?></div></th>
<?php } ?>
<?php if ($Page->Activated->Visible) { // Activated ?>
        <th data-name="Activated" class="<?= $Page->Activated->headerCellClass() ?>"><div id="elh_myuserprofile_Activated" class="myuserprofile_Activated"><?= $Page->renderFieldHeader($Page->Activated) ?></div></th>
<?php } ?>
<?php if ($Page->Locked->Visible) { // Locked ?>
        <th data-name="Locked" class="<?= $Page->Locked->headerCellClass() ?>"><div id="elh_myuserprofile_Locked" class="myuserprofile_Locked"><?= $Page->renderFieldHeader($Page->Locked) ?></div></th>
<?php } ?>
<?php if ($Page->Photo->Visible) { // Photo ?>
        <th data-name="Photo" class="<?= $Page->Photo->headerCellClass() ?>"><div id="elh_myuserprofile_Photo" class="myuserprofile_Photo"><?= $Page->renderFieldHeader($Page->Photo) ?></div></th>
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
    <?php if ($Page->_Username->Visible) { // Username ?>
        <td data-name="_Username"<?= $Page->_Username->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile__Username" class="el_myuserprofile__Username">
<span<?= $Page->_Username->viewAttributes() ?>>
<?= $Page->_Username->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->First_Name->Visible) { // First_Name ?>
        <td data-name="First_Name"<?= $Page->First_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_First_Name" class="el_myuserprofile_First_Name">
<span<?= $Page->First_Name->viewAttributes() ?>>
<?= $Page->First_Name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Last_Name->Visible) { // Last_Name ?>
        <td data-name="Last_Name"<?= $Page->Last_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Last_Name" class="el_myuserprofile_Last_Name">
<span<?= $Page->Last_Name->viewAttributes() ?>>
<?= $Page->Last_Name->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->_Email->Visible) { // Email ?>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile__Email" class="el_myuserprofile__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->User_Level->Visible) { // User_Level ?>
        <td data-name="User_Level"<?= $Page->User_Level->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_User_Level" class="el_myuserprofile_User_Level">
<span<?= $Page->User_Level->viewAttributes() ?>>
<?= $Page->User_Level->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Report_To->Visible) { // Report_To ?>
        <td data-name="Report_To"<?= $Page->Report_To->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Report_To" class="el_myuserprofile_Report_To">
<span<?= $Page->Report_To->viewAttributes() ?>>
<?= $Page->Report_To->getViewValue() ?></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Activated->Visible) { // Activated ?>
        <td data-name="Activated"<?= $Page->Activated->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Activated" class="el_myuserprofile_Activated">
<span<?= $Page->Activated->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_Activated_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->Activated->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Activated->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_Activated_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Locked->Visible) { // Locked ?>
        <td data-name="Locked"<?= $Page->Locked->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Locked" class="el_myuserprofile_Locked">
<span<?= $Page->Locked->viewAttributes() ?>>
<div class="form-check form-switch d-inline-block">
    <input type="checkbox" id="x_Locked_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->Locked->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Locked->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_Locked_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
    <?php } ?>
    <?php if ($Page->Photo->Visible) { // Photo ?>
        <td data-name="Photo"<?= $Page->Photo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_myuserprofile_Photo" class="el_myuserprofile_Photo">
<span>
<?= GetFileViewTag($Page->Photo, $Page->Photo->getViewValue(), false) ?>
</span>
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
    ew.addEventHandlers("myuserprofile");
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
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmyuserprofileadd.validateFields()){ew.prompt({title: ew.language.phrase("MessageAddConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fmyuserprofileadd").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmyuserprofileedit.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result)$("#fmyuserprofileedit").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmyuserprofileupdate.validateFields()){ew.prompt({title: ew.language.phrase("MessageEditConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fmyuserprofileupdate").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport()) { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('#btn-action').on('click',function(){if(fmyuserprofiledelete.validateFields()){ew.prompt({title: ew.language.phrase("MessageDeleteConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fmyuserprofiledelete").submit();});return false;} else { ew.prompt({title: ew.language.phrase("MessageInvalidForm"), icon: 'warning', showCancelButton:false}); }});});
</script>
<?php } ?>
<?php if (!$Page->IsModal && !$Page->isExport() && CurrentPageID()=="list") { ?>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-grid-save, .ew-grid-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fmyuserprofilelist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-update').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fmyuserprofilelist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){$('.ew-inline-insert').on('click',function(){ew.prompt({title: ew.language.phrase("MessageSaveGridConfirm"),icon:'question',showCancelButton:true},result=>{if(result) $("#fmyuserprofilelist").submit();});return false;});});
</script>
<script>
loadjs.ready(["wrapper", "head", "swal"],function(){var gridchange=false;$('[data-table="myuserprofile"]').change(function(){	gridchange=true;});$('.ew-grid-cancel,.ew-inline-cancel').click(function(){if (gridchange==true){ew.prompt({title: ew.language.phrase("ConfirmCancel"),icon:'question',showCancelButton:true},result=>{if(result) window.location = "<?php echo str_replace('_', '', 'myuserprofilelist'); ?>";});return false;}});});
</script>
<?php } ?>
<?php if (!$myuserprofile->isExport()) { ?>
<script>
loadjs.ready("jqueryjs", function() {
	var expires = new Date(new Date().getTime() + 525600 * 60 * 1000); // expire in 525600 
	var SearchToggle = $('.ew-search-toggle'); 
	SearchToggle.on('click', function(event) { 
		event.preventDefault(); 
		if (SearchToggle.hasClass('active')) { 
			Cookies.set("myuserprofile_searchpanel", "notactive", { path: '', expires: expires }); 
		} else { 
			Cookies.set("myuserprofile_searchpanel", "active", { path: '', expires: expires }); 
		} 
	});
});
</script>
<?php } ?>
<?php } ?>
