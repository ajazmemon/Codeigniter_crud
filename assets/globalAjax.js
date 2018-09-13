$(document).ready(function () {
   

   // file upload 
   $('.GlobalForm')
           .formValidation()
           .on('success.form.fv', function (e) {
              $("#btnsubmit").on('submit', function (e) {
                  
                 $('#loader').show();
                 var form = $('#btnsubmit')[0];
                 var formData = new FormData(form);

                 
                 e.preventDefault();

                 $.ajax({
                    url: $('#btnsubmit').attr('action'),
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




