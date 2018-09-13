$(function() {
  // Initialize form validation on the registration form.
  // It has the name attribute "registration"
  $("#form").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      title: "required",
      description: "required",
      
    },
    // Specify validation error messages
    messages: {
      title: "Please enter your firstname",
      description: "Please enter your lastname",
      
    },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
    submitHandler: function(form) {
      form.submit();
    }
  });
});