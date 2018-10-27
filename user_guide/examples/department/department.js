$(document).ready(function () {

    $("#divi").hide();
   
    if (jQuery().DataTable) {
        oTable = $('#data_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "department_data",
            "columns": [
                {data: 'DT_Row_Index', orderable: false, searchable: false},
                {data: 'department', name: 'department'},
                {
                    data: 'is_active',name: 'is_active',
                    searchable: true,
                    render: function (data, type, full, meta) {
                        if (full.is_active == 0)
                        {
                            return '<input type="checkbox" data-id="' + full.id + '" id="toggle" class="js-switch"  unchecked/>';
                        } else
                        {
                            return '<input type="checkbox" data-id="' + full.id + '" id="toggle" class="js-switch"  checked/>';
                        }
                    }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    }

    $('#data_table').on('click', '.edited', function () {
        var id = $(this).attr('data-id');

        $.ajax({
            url: 'department/edit/' + id,
            type: "GET",
            dataType: "json",
            success: function (data) {
                $('#dname').val(data.department);
                $(".GlobalFormValidation").attr("action", "department/update/" + id);
            }
        });

    });

    $('#data_table').on('click', '.deleted', function () {
        var id = $(this).attr('data-id');
        $('#btn_delete').click(function (e) {

            $.ajax({
                url: 'department/delete/' + id,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    if (data.status == 'false') {

                        $('#delete').modal('hide');
                        $("#divi").css("display", 'block');
                        $("#divi").addClass('alert alert-danger');
                        $('#msg').text(data.message);
                        $("#msg").css("color", 'red');
                        $('#divi').delay(3000).fadeOut('slow');

                    } else {
                        oTable.draw();
                        $('#delete').modal('hide');
                        $("#divi").css("display", 'block');
                        $("#divi").addClass('alert alert-danger');
                        $('#msg').text(data.message);
                        $("#msg").css("color", 'red');
                        $('#divi').delay(3000).fadeOut('slow');
                    }
                }
            });
        });
    });

    $('#data_table').on('change', '#toggle', function (e) {
        if ($(this).is(":checked")) {

            var id = $(this).attr('data-id');
            $.ajax({
                url: 'department/active/' + id,
                type: "GET",
                success: function (json) {
              
                  
                    $("#divi").css("display", 'block');
                    $("#divi").removeClass('alert alert-danger');
                    $("#divi").addClass('alert alert-success');
                    $('#msg').text(json.message);
                    $("#msg").css("color", 'green');
                    $('#divi').delay(3000).fadeOut('slow');
                }
            });

        } else {
            var id = $(this).attr('data-id');
            $.ajax({
                url: 'department/inactive/' + id,
                type: "GET",
                success: function (json) {
                    $("#divi").css("display", 'block');
                    $("#divi").addClass('alert alert-danger');
                    $('#msg').text(json.message);
                    $("#msg").css("color", 'red');
                    $('#divi').delay(3000).fadeOut('slow');
                }
            });
        }
    });
});
