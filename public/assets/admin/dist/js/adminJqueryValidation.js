$(document).ready(function() {
    $("#categories_form_add").validate(
    {                
        rules:
        {     
            name:{
                required: true
            },
        },
        messages:
        {
            name:'Please enter Category Name.',
        },
         errorPlacement: function(error, element) {
            if(element.attr("name") == "image"){
                error.insertAfter(".image");
            }else{
                error.insertAfter(element);
            }
        },  
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    $("#categories_form_edit").validate(
    {                
        rules:
        {     
            name:{
                required: true
            },
        },
        messages:
        {
            name:'Please enter Category Name.',
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    $("#banerTable, #usersTable, #contentTable, #contactUsTable, #CategoriesTable, #productsTable, #ordersDasboardTable, #usersReportTable, #ordersTable, #salesReportTable, #subscriptionPlanTable").on('click', '.view-info', function(event) {
        var title = $(this).attr('data-title');
        var url = $(this).attr('data-url');
        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                $("#viewModalTitle").html(title);
                $("#viewModalBody").html(response);
                $("#viewShowModal").modal('show');
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        }).always(function (dataOrjqXHR, textStatus, jqXHRorErrorThrown) {
            updateCsrfToken();
        });
    });

    $.validator.addMethod("strongPassword", function(value, element) {
        return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/.test(value);
        }, "Your password must contain at least one lowercase letter, one uppercase letter, and one digit");

    $("#user_create_form").validate(
    {   
        rules: {
            email: {
                required: true,
                email: true,
                remote: {
                    url: baseUrl+"check-email-validation",
                    type: "get"
                }
            },
             password: {
                    required: true,
                    minlength: 6,
                    strongPassword: true
                },
             first_name: "required",
             last_name: "required",
             confirm_password: {
                    required: true,
                    equalTo: "#password"
            },
            countryCode: {
                    required: true,
            },
             mobileNo: {
                    required: true,
                    minlength: 10,
                    maxlength: 12
            }
        },
        messages: {
             fname: "Please enter your first name",
             lname: "Please enter your last name",

            email: {
                required: "Please enter your email address",
                email: "Please enter a valid email address",
                remote: "Email already exists"
            },
             password: {
                    required: "Please enter a password",
                    minlength: "Your password must be at least 6 characters long",
                    strongPassword: "Your password must contain at least one lowercase letter, one uppercase letter, and one digit"
            },
             confirm_password: {
                    required: "Please confirm your password",
                    equalTo: "Passwords do not match"
                },
            countryCode: {
                required: "Please select country code",
            },
            mobileNo: {
                required: "Please enter your mobile number",
                minlength: "Mobile number must be at least 10 characters long",
                maxlength: "Mobile number can't be longer than 12 characters"
            },
            countryCode: {
                required: "Please select country code",
            }
        },
        errorPlacement: function(error, element) {
           error.insertAfter(element).css('color', 'red');
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });


    function addNewAddress() {
        addressCounter++;
        var newAddress = $('#addressTemplate').clone();
        newAddress.removeAttr('id'); // Remove ID attribute to avoid duplicates

        // Update IDs and names for input fields
        newAddress.find('[id]').each(function() {
            var oldId = $(this).attr('id');
            $(this).attr('id', oldId + '_' + addressCounter);
        });

        newAddress.find('[name^="addresses"]').each(function() {
            var newName = $(this).attr('name').replace('[0]', '[' + addressCounter + ']');
            $(this).attr('name', newName);
        });

        // Append the new address to the container
        $('#extraAddress').append(newAddress.html());
        $('#title_0_'+addressCounter).focus();
    }

    // Add new address when button is clicked
    $('#addressBtn').on('click', function() {
        addNewAddress();
    });

    $(document).on('click', '.delete-new-address', function() {
        $(this).closest('.user-addresses').remove();
    });

    $('#user_edit_form').submit(function(event) {
        var emptyFields = [];
        var tabIds = [];
        var mobileValidField = [];
        $('.error').remove();

        var password = $(".usr-pass-field").val();
        var confirmPassword = $(".usr-confpass-field").val();

        if (password && confirmPassword) {

            var pattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,}$/;
            if (!pattern.test(password)) {
                errorMessage = 'Your password must contain at least one lowercase letter, one uppercase letter, and one digit';
                $('.usr-pass-field').after('<span class="text-danger text-bold error">' + errorMessage + '</span>');
                return false;
            }

            if (password != confirmPassword)
            {
                errorMessage = 'Password and confirm password is not matched';
                $('.usr-pass-field').after('<span class="text-danger text-bold error">' + errorMessage + '</span>');
                return false;
            }
        }


        $(this).find('input').each(function() {
            // Get the name and value of the input field
            var fieldName = $(this).attr('name');
            var fieldValue = $(this).val();
            var filedType = $(this).attr('type');


            // If the input field has no value, add its name to the emptyFields array
            if($(this).hasClass('chk-required'))
            {
                if (fieldValue === ''  ) {

                emptyFields.push(fieldName);
                var errorMessage = 'This field is required.';
                if(filedType == 'tel')
                {
                    if(validateMobileNo(fieldValue) == false)
                    {
                        errorMessage = 'Please enter valid mobile number';
                        $(this).after('<span class="text-danger text-bold error">' + errorMessage + '</span>');
                    }
                }
                else
                {
                    $(this).after('<span class="text-danger text-bold error">' + errorMessage + '</span>');
                }
                
                tabIds.push($(this).closest('.tab-pane').attr('id'));
                }
                else if(filedType == 'tel')
                {
                    if(validateMobileNo(fieldValue) == false)
                    {
                        mobileValidField.push(fieldName);
                        errorMessage = 'Please enter valid mobile number';
                        $(this).after('<span class="text-danger text-bold error">' + errorMessage + '</span>');
                        tabIds.push($(this).closest('.tab-pane').attr('id'));
                    }
                }

            }

        });


        if (emptyFields.length > 0) {
            if (tabIds.length > 0) {
                $('.' + tabIds[0]).click();
            }
            event.preventDefault();
        }
        else if(mobileValidField.length >0)
        {
            if (tabIds.length > 0) {
                $('.' + tabIds[0]).click();
            }
            event.preventDefault();
        }
    });


    var initialEmail;
    if ($('#email').length && $('#email').val().trim() !== '') {
        initialEmail = $('#email').val().trim();
    } else {
        initialEmail = ''; 
    }

    $('#user_edit_form').on('input', '#email', function() {
        var newEmail = $(this).val().trim();
         if (newEmail !== initialEmail) {
            $('#email').rules('add', {
                remote: {
                    url: baseUrl + "check-email-validation",
                    type: "get",
                    data: {
                        email: function() {
                            return $('#email').val().trim();
                        }
                    },
                    messages: {
                       remote: "This email is already taken."
                    }
                }
            });
        }
        else {
            //$('#email').rules('remove', 'remote');
        } 
    });

    function validateMobileNo(mobileNo) {
        mobileNo = mobileNo.replace(/\s/g, '');

        if (mobileNo.length === 0) {
            return false; // Mobile number is required
        }

        if (!/^\+?\d+$/.test(mobileNo)) {
            return false; // Mobile number must contain only digits
        }
        
        if (mobileNo.length < 10 || mobileNo.length > 15) {
            return false; // Mobile number length is invalid
        }

        return true;
    }

    $("#bannerFormCreate").validate(
    {
        ignore: ".description *",          
        rules:
        {     
            title:{
                required: true
            },
            subtitle:{
                required: true
            },
            image: {
                required: true,
                // extension: "jpeg,jpg,png"
            },
            description: {
                required: true,
            },
        },
        messages:
        {
            title:'Please Enter Title.',
            subtitle:'Please Enter Sub Title.',
            description:'Please Enter Description.',
            image: {
                required: 'Please select an image file.',
                // extension: 'Please select a valid image file (JPEG, JPG, PNG).'
            }
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == "description"){
                error.insertAfter(".note-editor");
            }else if(element.attr("name") == "image"){
                error.insertAfter(".image");
            }else{
                error.insertAfter(element);
            }
        },  
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    $("#bannerFormEdit").validate(
    {
        ignore: ".description *",          
        rules:
        {     
            title:{
                required: true
            },
            subtitle:{
                required: true
            },
            description: {
                required: true,
            },
        },
        messages:
        {
            title:'Please Enter Title.',
            subtitle:'Please Enter Sub Title.',
            description:'Please Enter Description.',
            image: {
                required: 'Please select an image file.',
                // extension: 'Please select a valid image file (JPEG, JPG, PNG).'
            }
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == "description"){
                error.insertAfter(".note-editor");
            }else{
                error.insertAfter(element);
            }
        },  
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    $("#contentFormEdit").validate(
    {
        ignore: ".description *",          
        rules:
        {     
            title:{
                required: true
            },
            description: {
                required: true,
            },
        },
        messages:
        {
            title:'Please Enter Title.',
            description:'Please Enter Description.',
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == "description"){
                error.insertAfter(".note-editor");
            }else{
                error.insertAfter(element);
            }
        },  
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    $("#productFormInfo").validate(
    {    
        rules:
        {     
            category_id:{
                required: true
            },
            product_name:{
                required: true
            },
            sku: {
                required: true,
            },
            description: {
                required: true,
            },
            type: {
                required: true,
            },
            price: {
                required: true,
                number: true,
                min: 0,            },
            status: {
                required: true,
            },
        },
        messages:
        {
            category_id:'Please enter category id.',
            product_name:'Please enter product name.',
            sku:'Please enter sku.',
            description: 'Please enter description.',
            type: 'Please enter type.',
            price: {
                required: "Please enter Price.",
                number: "Please enter valid number.",
                min: "Price must be greater than or equal to 0."
            },
            status: "Please enter status."
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == "type"){
                error.insertAfter(".type-error");
            } else if(element.attr("name") == "category_id") {
                error.insertAfter(".category-error");
            }else{
                error.insertAfter(element);
            }
        },  
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    $('#productFormEdit').submit(function(event) {
        var emptyFields = [];
        var tabIds = [];
        $('.error').remove();
        $(this).find('input').each(function() {
            // Get the name and value of the input field
            var fieldName = $(this).attr('name');
            var fieldValue = $(this).val();
            var filedType = $(this).attr('type');

            // If the input field has no value, add its name to the emptyFields array
            if (fieldValue === '') {
                emptyFields.push(fieldName);
                var errorMessage = 'This field is required.';
                if(filedType == 'file'){
                    $('.image-error').remove();
                    $('.imagediv').after('<span class="text-danger text-bold image-error">' + errorMessage + '</span>');
                } else {
                    if($(this).closest('div').hasClass('my-colorpicker2')){
                        $(this).closest('.my-colorpicker2').next('.error-color').remove();
                        $(this).closest('.my-colorpicker2').addClass('mb-0').after('<span class="text-danger text-bold error-color">' + errorMessage + '</span>');
                    } else {
                        $(this).after('<span class="text-danger text-bold error">' + errorMessage + '</span>');
                    }
                }
                tabIds.push($(this).closest('.tab-pane').attr('id'));
            }
        });


        if (emptyFields.length > 0) {
            if (tabIds.length > 0) {
                $('.' + tabIds[0]).click();
            }
            event.preventDefault();
        }
    });

    /*Subscription Plan*/
    $("#subscriptionForm").validate({
        ignore: ".description *",          
        rules:
        {     
            name:{
                required: true
            },
            duration:{
                required: true
            },
            description: {
                required: true,
            },
        },
        messages:
        {
            name:'Please Enter the Name.',
            duration:'Please select Duration.',
            description:'Please Enter Description.',
        },
        errorPlacement: function(error, element) {
            if(element.attr("name") == "description"){
                error.insertAfter(".note-editor");
            }else{
                error.insertAfter(element);
            }
        },  
        submitHandler: function(form){
            form.submit();
        }
    });
    
    $("#reviewsTable").on('click', '.show-more-reviews', function(event) {
        event.preventDefault();
        console.log('calles');
        var desc = $(this).attr('data-description');
        $('#reviewDescbody').html(desc);
        $('#reviewDesc').modal('show');
    });
});
