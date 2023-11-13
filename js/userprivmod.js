(function($) {

    $.hik.jtable.prototype._createErrorDialogDiv = function () {};

    $.hik.jtable.prototype._showError = function (message) {
        ew.alert(message);
    };

    $.extend(true, $.hik.jtable.prototype.options.messages, {
        serverCommunicationError: ew.language.phrase("ServerCommunicationError"),
        loadingMessage: ew.language.phrase("Loading"),
        noDataAvailable: ew.language.phrase("NoRecord")
    });

    function getDisplayFn(name, trueValue) {
        return function(data) {
            var row = data.record, id = name + '_' + row.index,
                checked = (row.permission & trueValue) == trueValue;
            row.checked = checked;
            return '<div class="custom-control custom-checkbox d-inline-block" title="' + row.table + ' --> ' + id.charAt(0).toUpperCase() + name.slice(1).toUpperCase() + '"><input type="checkbox" class="custom-control-input ew-priv ew-multi-select" name="' + id + '" id="' + id +
                '" value="' + trueValue + '" data-index="' + row.index + '"' +
                (checked ? ' checked' : '') +
                (((row.allowed & trueValue) != trueValue) ? ' disabled' : '') + '><label class="custom-control-label" for="' + id + '"></label></div>';
        };
    }

    function displayTableName(data) {
        var row = data.record;
		var tablename = priv.permissions[row.index].name;
        return '<span title="' + tablename + '">' +  row.table + '<input type="hidden" name="table_' + row.index + '" value="1"></span>';
    }

    function getRecords(data, params) {
        var rows = priv.permissions.slice(0);
        if (data && data.table) {
            var table = data.table.toLowerCase();
            rows = $.map(rows, function(row) {
                if (row.table.toLowerCase().includes(table))
                    return row;
                return null;
            });
        }
        if (params && params.jtSorting) {
            var asc = params.jtSorting.match(/ASC$/);
            rows.sort(function(a, b) { // Case-insensitive
                if (b.table.toLowerCase() > a.table.toLowerCase())
                    return (asc) ? -1 : 1;
                else if (b.table.toLowerCase() === a.table.toLowerCase())
                    return 0
                else if (b.table.toLowerCase() < a.table.toLowerCase())
                    return (asc) ? 1 : -1;
            });
        }
        return {
            Result: "OK",
            params: Object.assign({}, data, params),
            Records: rows
        };
    }

    function getTitleHtml(id, phraseId) {
        return '<div class="form-check" title="' + id.charAt(0).toUpperCase() + id.slice(1) + '"><input type="checkbox" class="form-check-input ew-priv" name="' + id + '" id="' + id + '" data-ew-action="select-all">' +
            '<label class="form-check-label" for="' + id + '">' + ew.language.phrase("Permission" + (phraseId || id)) + '</label></div>'
    }

    // Fields
    var _fields = {
        table: {
            title: '<span class="fw-normal">' + ew.language.phrase("Tables") + '</span>',
            display: displayTableName,
            sorting: true
        }
    };
    ["add", "delete", "edit", "list", "view", "search", "import", "lookup", "export", "print", "excel", "word", "html", "xml", "csv", "pdf", "email", "push", "admin"].forEach(function(id) {
        _fields[id] = {
            title: getTitleHtml(id),
            display: getDisplayFn(id, priv[id]),
            sorting: false
        };
    });

    // Init
    $(".ew-card.ew-user-priv .ew-card-body").jtable({
        paging: false,
        sorting: true,
        defaultSorting: "table ASC",
        fields: _fields,
        actions: { listAction: getRecords },
        rowInserted: function (event, data) {
            var $row = data.row;
            $row.find("input[type=checkbox]").on("click", function() {
                var $this = $(this),
                    index = parseInt($this.data("index"), 10),
                    value = parseInt($this.data("value"), 10);
                if (this.checked)
                    priv.permissions[index].permission |= value;
                else
                    priv.permissions[index].permission ^= priv.permissions[index].permission ^ value;
            });
        },
        loadingRecords: function () {
            this.querySelector(".jtable").classList.add("table", "table-sm");
        },
        recordsLoaded: function (event, data) {
            var sorting = data.serverResponse.params.jtSorting,
                $mc = $(this).find(".jtable-main-container"),
                $t = $mc.find(".jtable"),
                $c = $t.find(".jtable-column-header-container:first");
            if (useFixedHeaderTable) {
                if (tableHeight)
                    $mc.height(tableHeight);
                $t.addClass("table-head-fixed ew-fixed-header-table");
                if (ew.USE_OVERLAY_SCROLLBARS)
                    $mc.overlayScrollbars(ew.overlayScrollbarsOptions);
            }
            if (!$c.find(".ew-table-header-sort")[0])
                $c.append('&nbsp;&nbsp;-->&nbsp;&nbsp;' + '<span class="ew-table-header-sort"></span>');
            $sort = $c.find(".ew-table-header-sort").empty();
            if (sorting.match(/ASC$/))
                $sort.append(ew.language.phrase("SortUp"));
            else if (sorting.match(/DESC$/))
                $sort.append(ew.language.phrase("SortDown"));
            ew.initMultiSelectCheckboxes();
            ew.fixLayoutHeight();
        }
    });

    // Re-load records on search
    var _timer;
    $("#table-name").on("keydown keypress cut paste", function(e) {
        if (_timer)
            _timer.cancel();
        _timer = $.later(200, null, function() {
            $(".ew-card.ew-user-priv .ew-card-body").jtable("load", {
                table: $("#table-name").val()
            });
        });
    });

    // Load all records
    $("#table-name").trigger("keydown");
	$(".ew-desktop").css({"width":"auto"});
})(jQuery);
