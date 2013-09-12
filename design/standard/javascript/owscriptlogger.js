$(document).ready(function() {

    function filter_log_list(checked, other_list_selector) {
        if (checked.is(':checked')) {
            $(other_list_selector).each(function() {
                var filter = $(this);
                if (filter.is(':checked')) {
                    $("tr." + checked.attr("id") + "." + filter.attr("id")).show();
                } else {
                    $("tr." + checked.attr("id") + "." + filter.attr("id")).hide();
                }
            });
        } else {
            $("tr." + checked.attr("id")).hide();
        }
        $("tr:visible:odd").removeClass("yui-dt-odd").addClass("yui-dt-even");
        $("tr:visible:even").removeClass("yui-dt-even").addClass("yui-dt-odd");
    }

    function searchTable(inputVal, col_class) {
        $('table.log_list').each(function(index, table) {
            $(table).find('tr').each(function(index, row) {
                var allCells = $(row).find('td.' + col_class);
                console.log(allCells);
                if (allCells.length > 0) {
                    var found = false;
                    allCells.each(function(index, td) {
                        var regExp = new RegExp(inputVal, 'i');
                        if (regExp.test($(td).text())) {
                            found = true;
                            return false;
                        }
                    });
                    if (found == true)
                        $(row).show();
                    else
                        $(row).hide();
                }
            });
        });
    }


    $(".identifier_filter").change(function() {
        var checked = $(this);
        if (checked.is(':checked')) {
            $("tr." + checked.attr("id")).show();
        } else {
            $("tr." + checked.attr("id")).hide();
        }
        $("tr:visible:odd").removeClass("yui-dt-odd").addClass("yui-dt-even");
        $("tr:visible:even").removeClass("yui-dt-even").addClass("yui-dt-odd");
    });

    $(".date_filter").keyup(function() {
        console.log($(this).val());
        searchTable($(this).val(), "logger_date");
        $("tr:visible:odd").removeClass("yui-dt-odd").addClass("yui-dt-even");
        $("tr:visible:even").removeClass("yui-dt-even").addClass("yui-dt-odd");
    });

    $(".level_filter").change(function() {
        filter_log_list($(this), ".action_filter");
    });

    $(".action_filter").change(function() {
        filter_log_list($(this), ".level_filter");
    });

    $(".toggle_checkboxes").click(function() {
        $(this).parents("table.log_list").find("tr:visible input[type=checkbox]:enabled").each(function() {
            checkbox = $(this);
            checkbox.attr('checked', !checkbox.is(':checked'));
        });
    });
});
