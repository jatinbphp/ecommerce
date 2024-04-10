$(document).ready(function() {
    $("#sendMessage2").validate(
    {                
        rules:
        {     
            name:{
                required: true
            },
             email: {
                required: true,
                email: true,
            },
            subject:{
                required: true
            },
            message:{
                required: true
            },
        },
        messages:
        {
            name:'Please Enter Name.',
            email: {
                required: 'Please Enter Email address.',
                email: 'Please Enter a Valid Email Address.',
            },
            subject:'Please Enter Subject.',
            message:'Please Enter Message.',
        },
        errorPlacement: function(error, element) {
            // Place the error message in a span with class "text-danger"
            error.appendTo(element.closest(".form-group").find(".error-message"));
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });
});