$(document).ready(function () {
   $('#loader').hide();
// Select2 
   if (jQuery().select2) {
      $('.js-example-basic-single').select2({
         placeholder: "Select a Email GateWay",
      });
   }

   // file upload 
   $('.GlobalForm')
           .formValidation({
              framework: 'bootstrap',
              icon: {
                 valid: 'glyphicon glyphicon-ok',
                 invalid: 'glyphicon glyphicon-remove',
                 validating: 'glyphicon glyphicon-refresh'
              },
           })
           .on('success.form.fv', function (e) {
              $("#btnsubmit").on('submit', function (e) {
                  
                 $('#loader').show();
                 var form = $('#btnsubmit')[0];
                 var formData = new FormData(form);

                 $.ajaxSetup({
                    headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                    }
                 });
                 e.preventDefault();

                 $.ajax({
                    url: 'update',
                    type: 'POST',
                    data: formData,
                    async: true,
                    cache: false,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    success: function (data) {
                       $('#loader').hide();
                       $("#divi").css("display", 'block');
                       $("#divi").addClass('alert alert-success');

                       $('#msg').text(data.message);
                       $("#msg").css("color", 'green');
                       // if (data.url != 0) {
                       //    setTimeout(function () {
                       //       window.location.href = data.url;
                       //    }, 1000);
                       // }

                    }
                 });
              });
           });
});




