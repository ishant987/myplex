//jQuery.noConflict();

//Change status using jquery.
function changeStatus(id_name, id, table, status, msg_type, url = '') {
    var chngUrl = url ? url : "change-status";
    var datas = 'id_name' + id_name + '&id=' + id + '&table=' + table + '&status=' + status + '&msg_type=' + msg_type;
    // alert(datas+'url:'+chngUrl); //die();
    jQuery.ajax({
        url: chngUrl,
        type: "post",
        data: { "_token": $('meta[name="csrf-token"]').attr('content'), "id_name": id_name, "id": id, "table": table, "status": status, "msg_type": msg_type, "url": chngUrl },
        dataType: 'json',
        success: function(data) {
            /*alert(data['msg']);
            alert(data['content']);*/
            jQuery("#msg_id").html(data['msg']);
            jQuery("#change_status" + id).replaceWith(data['content']);
        },
        error: function(data) {
            alert(data);
            jQuery("#msg_id").html('There is error while submit');
        }
    });
}

jQuery(document).ready(function($) {
    $("form input[id='check_all']").click(function() { // triggred check
        var inputs = $("form input[type='checkbox']"); // get the checkbox
        for (var i = 0; i < inputs.length; i++) {
            var type = inputs[i].getAttribute("type");
            if (type == "checkbox") {
                if (this.checked) {
                    inputs[i].checked = true; // checked
                } else {
                    inputs[i].checked = false; // unchecked
                }
            }
        }
    });

    jQuery(".delLink").click(function() {
        var message = $(this).attr("data-message");
        if (message == null) {
            message = 'Are you sure you want to remove this?';
        }
        var strconfirm = confirm(message);
        if (strconfirm == true) {
            return true;
        } else {
            return false;
        }
    });
});

/*Bulk Delete*/
function bulkDelete(currentSelected, formName, message = '') {
    //alert(formName);
    var selecetdBtn = $(currentSelected).attr('name');
    var chkdbx = 0;
    $('input:checkbox[class=del-chkbx]:checked').each(function() {
        chkdbx++;
    });
    if (selecetdBtn == "delete") {
        if (chkdbx > 0) {
            if (message == '') {
                message = 'Are you sure want to remove these?';
            }
            if (confirm(message)) {
                //document.getElementById(formName).action="";
                document.getElementById(formName).submit();
                return true;
            } else {
                //document.getElementById(formName).action=false;
                return false;
            }
        }
    }
}


function setSlugValue(getFldNm = '', setFldNm = '') {
    if (getFldNm == '') { getFldNm = 'title'; }
    if (setFldNm == '') { setFldNm = 'slug'; }
    var newVal;
    var data = document.getElementById(getFldNm).value;
    if (data !== '') {
        newVal = data;
    }

    if (setFldNm !== 'slug') {
        //var newVal = data.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '_').toLowerCase();
        var newVal = data.replace(/[^a-z0-9\s-]/gi, ' ').replace(/[_\s]/g, '_').toLowerCase();
    }

    if (newVal !== '') {
        document.getElementById(setFldNm).value = newVal;
    }
}

function updateSlugValue(getFldNm = '', setFldNm = 'slug') {
    document.getElementById(setFldNm).readOnly = false;
    setSlugValue(getFldNm, setFldNm);
}

function isMenuSubmenu(id) {
    if (document.getElementById('is_submenu_' + id).checked) {
        $("#parent_menu_area_" + id).css("display", "flex");
    } else {
        $("#parent_menu_area_" + id).css("display", "none");
    }
}


function getModalData(url, modalButtonObject) {
    $.ajax({
        type: "GET",
        url: url,
        beforeSend: function() {
            $(modalButtonObject).append('<div class="fa fa-fw fa-spinner fa-spin modal_loader"></div>');
        },
        success: function(data) {
            $('#commonModal').html(data);
            $('#commonModal').modal('show');
            $('#commonModal').on('shown.bs.modal', function(e) {
                $('.modal_loader').remove();
                if ($(this).find('[autofocus]').hasClass('select-auto-open')) {
                    $(".select-auto-open").select2("open");
                } else {
                    $(this).find('[autofocus]').focus();
                }
            });
        },
        error: function(jqXHR, exception) {
            $('.modal_loader').remove();
        }
    });
}