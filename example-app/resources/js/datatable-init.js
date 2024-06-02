
import $ from 'jquery';
import 'datatables.net';

export function initializeDataTable(selector) {
    $(document).ready(function() {
        if ($.fn.dataTable.isDataTable(selector)) {
            $(selector).DataTable().destroy();
        }
        $(selector).DataTable();
    });
}

export function destroyDataTable(selector) {
    if ($.fn.dataTable.isDataTable(selector)) {
        $(selector).DataTable().destroy();
    }
}
