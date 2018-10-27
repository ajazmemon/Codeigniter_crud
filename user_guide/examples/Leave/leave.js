$(document).ready(function () {
    $('#test').hide();
    $("#divi").hide();
    if (jQuery().DataTable) {
        oTable = $('#data_table').DataTable({
            "proccess": true,
            "serverSide": true,
            "ajax": "leave_data",
            "columns": [
                {data: 'DT_Row_Index', orderable: false, searchable: false},
                {data: 'name', name: 'name'},             
                {data: 'leave_type', name: 'leave_type'},
                {data: 'leave_from', name: 'leave_from'},
                {data: 'leave_to', name: 'leave_to'},
                {data: 'time', name: 'time'},
                {
                    data: 'status',
                    name: 'status',
                    render: function (data) {
                        if (data == 0) {
                            return "<span class='label bg-danger'> Rejected </span>";
                        } else if (data == 1)
                        {
                            return "<span class='label bg-success'> Approved </span>";
                        } else
                        {
                            return "<span class='label bg-primary'> Pending </span>";
                        }
                    }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }
     if (jQuery().DataTable) {
        oTable = $('#data_table1').DataTable({
            "proccess": true,
            "serverSide": true,
            "ajax": "leave_empdata",
            "columns": [
                {data: 'DT_Row_Index', orderable: false, searchable: false},
                {data: 'name', name: 'name'},              
                {data: 'leave_type', name: 'leave_type'},
                {data: 'leave_from', name: 'leave_from'},
                {data: 'leave_to', name: 'leave_to'},
                {data: 'time', name: 'time'},
                {
                    data: 'status',
                    name: 'status',
                    render: function (data) {
                        if (data == 0) {
                            return "<span class='label bg-danger'> Rejected </span>";
                        } else if (data == 1)
                        {
                            return "<span class='label bg-success'> Approved </span>";
                        } else
                        {
                            return "<span class='label bg-primary'> Pending </span>";
                        }
                    }
                },
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    }

    $('.timepicker').datetimepicker({
        format: 'HH:mm:ss'

    });

    $('.datefrom').datepicker({
        format: 'yyyy-mm-dd'

    }).on('changeDate', function (e) {
        // Revalidate the date field
        $('#form').formValidation('revalidateField', 'leave_from');

        var dateRangePickerFrom = document.getElementById("dateRangePickerFrom").value;
        var dateRangePickerTo = document.getElementById("dateRangePickerTo").value;

        if ((Date.parse(dateRangePickerTo) < Date.parse(dateRangePickerFrom))) {
            $('#to').text('Leave to date is not a valid').css('color', 'red');
            document.getElementById("dateRangePickerTo").value = "";
        }
    });

    $('.dateto').datepicker({
        format: 'yyyy-mm-dd'

    }).on('changeDate', function (e) {
        // Revalidate the date field
        $('#form').formValidation('revalidateField', 'leave_to');
        var dateRangePickerFrom = document.getElementById("dateRangePickerFrom").value;
        var dateRangePickerTo = document.getElementById("dateRangePickerTo").value;

        if ((Date.parse(dateRangePickerTo) < Date.parse(dateRangePickerFrom))) {
            $('#to').text('Leave to date is not a valid').css('color', 'red');
            document.getElementById("dateRangePickerTo").value = "";
        } else {
            $('#to').text('');
        }

    });

    if (jQuery().select2) {
        $('.js-example-basic-single').select2({  
            placeholder: "Select ",
        });
    }

    $('#data_table').on('click', '#delete_leave', function (e) {
        var id = $(this).attr('data-id');

        $('#btn_delete').click(function () {

            $.ajax({
                url: 'leave/destroy/' + id,
                type: "GET",
                success: function (data) {

                    oTable.draw();
                    $('#delete').modal('hide');
                    $("#divi").show();
                    $("#divi").addClass('alert alert-danger');
                    $('#msg').text(data.message);
                    $("#msg").css("color", 'red');
                    $('#divi').delay(3000).fadeOut('slow');
                }
            });
        });
    });
    $('#data_table1').on('click', '#delete_leave', function (e) {
        var id = $(this).attr('data-id');

        $('#btn_delete').click(function () {

            $.ajax({
                url: 'leave/destroy/' + id,
                type: "GET",
                success: function (data) {

                    oTable.draw();
                    $('#delete').modal('hide');
                    $("#divi").show();
                    $("#divi").addClass('alert alert-danger');
                    $('#msg').text(data.message);
                    $("#msg").css("color", 'red');
                    $('#divi').delay(3000).fadeOut('slow');
                }
            });
        });
    });

    $('#fullday').click(function () {
        $('#test').hide();
        $('#leave_to').show();
    });

    $('#halfday').click(function () {

        $('#test').show();
        $('#leave_to').hide();
    });

    //start time
    $('#end_time').on('blur', function () {
        
        var startTime = $('#start_time').val();
        var endTime = $('#end_time').val();
        st = minFromMidnight(startTime);
        et = minFromMidnight(endTime);
        if (st >= et) {
            $('#abc').text('End time should be greater than start time');
            $('#abc').css('color','red');
        }
        else {
            $('#abc').text('');
            $('#abc').css('');
        }

        function minFromMidnight(tm) {
            var ampm = tm.substr(-2)
            var clk = tm.substr(0, 5);
            var m = parseInt(clk.match(/\d+$/)[0], 10);
            var h = parseInt(clk.match(/^\d+/)[0], 10);
            h += (ampm.match(/pm/i)) ? 12 : 0;
            return h * 60 + m;
        }

    });


});