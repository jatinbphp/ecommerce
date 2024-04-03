$(document).ready(function() {

    //Admin Subadmin Table Get 
    $('#subadminsTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"subadmin/fetch_sub_admins",
            type:"POST"
        },
        "columnDefs": [{
            "targets":[4,5],
            "orderable": false
        }]
    });

    //Admin applicantion Table Get
    $('#application_typesTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"application_types/fetch_application_types",
            type:"POST"
        },
        "columnDefs": [{
            "targets":[5],
            "orderable": false
        }]
    });

    //Admin Students Table Get
    $('#usersTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"fetch_users",
            type:"POST"
        },
        "columnDefs": [{
            "targets":[4,5],
            "orderable": false
        }]
    });

    //Admin Student Document Table Get
    $('#documentTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"documents/fetch_student_documents",
            type:"POST"
        },
        "columnDefs": [{
            "targets":[4],
            "orderable": false
        }]
    });

    //Admin get messages Table
    $('#messagesTable').DataTable({
        "processing": true,
        "serverSide": true,
        "order":[],
        "ajax":{
            url:"messaging/fetch_messaging",
            type:"POST"
        },
        "columnDefs": [{
            "targets":[4],
            "orderable": false
        }]
    });
});

$(document).ready(function() {
    function getWordCount(wordString) {
      var words = wordString.split(" ");
      words = words.filter(function(words) { 
        return words.length > 0
      }).length;
      return words;
    }

    jQuery.validator.addMethod("wordCount",
       function(value, element, params) {
          var count = getWordCount(value);
          if(count <= params[0]) {
             return true;
          }else{
            return false;
          }
       },
    );

    $("#application_form_step6").validate(
    {                
        rules:
        {   
            organisational:
            {
                required: true,
                wordCount: ['200']
            },
        },
        messages:
        {
            organisational: {
                wordCount :enterMaximumWord,
            },
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    $("#application_form_step7").validate(
    {                
        rules:
        {   
            membership_association:
            {
                required: true,
            },
            since_year_member:
            {
                required: true,
            },   
        },
        messages:
        {
            membership_association:enterResearchManagement,
            since_year_member:enterYear,                        
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    $("#application_form_step4, #application_form_step7, #application_form_step8, #application_form_step9, #application_form_step3").on('click', '.deleteDocuments', function(event) {
        event.preventDefault();

        var id = $(this).attr("data-id");
        var data_name = $(this).attr("data-name");
        var data_step = $(this).attr("data-step");
        var data_field = $(this).attr("data-field");
        var data_file = $(this).attr("data-file");

        swal({
            title: areYouSure,
            text: youWantDelete+" "+data_name+" "+documentMsg,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: yesDelete,
            cancelButtonText: noCancel,
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                window.location.href = '../../applications/delete_document/'+id+'/'+data_field+'/'+data_step+'/'+data_file;
            } else {
                swal("Cancelled", yourDataSafe, "error");
            }
        });
    });

    
    //Admin Edit Profile Validation
    $("#admin_profile").validate(
    {                
        // Specify the validation rules
        rules:
        {        
            username: {
                required: true,
                remote: {
                    url: "adminprofile/check_other_username_exist",
                    type: "post"
                },
                minlength: 8
            },
            email:
            {
                required: true,
                email: true,
                remote: {
                    url: "adminprofile/check_other_admin_email_exist",
                    type: "post"
                }
            },
            firstname:
            {
                required: true,
            },
            lastname:
            {
                required: true,
            }, 
            phone:{
                required: true                   
            }
        },
        // Specify the validation error messages
        messages:
        {
            username: {
                required:enterUsername,
                remote: usernameAlreadyExist,
                minlength: enterAtLeastLength
            }, 
            email: {
                required:enterEmail,
                email: emailNotValid,
                remote: emailAlreadyExist,
            },             
            firstname:enterFirstname,             
            lastname:enterLastname,
            phone: {
                required: enterPhone,
                number: enterValidNumber,
                minlength: enterAtLeastDigit
            }                            
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    //Admin Change Password Validation
    $("#changePassword").validate(
    {                
        // Specify the validation rules
        rules:
        {   
            password:{
                required: true,
                minlength: 8
            },
            cpassword  :
            {
                required: true,
                equalTo: "#password"
            }
        },
        // Specify the validation error messages
        messages:
        {
            password: {
                required: enterPassword,   
                minlength: enterAtLeastLength
            },
            cpassword:{
                required: enterConfirmPassword, 
                equalTo: passwordNotMatched  
            }                             
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    // Application Type Edit
    $("#application_types_form").validate(
    {                
        rules:
        {        
            applicationtype:{
                required: true,
            },
            amount:{
                required: true,
            }, 
            description:{
                required: true
            },
        },
        messages:
        {    
            applicationtype:selectApplicationType,             
            amount:enterAmount,
            description:enterDescription,                        
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

     //Admin Subadmin Create Validation
    $("#create_sub_admin_form").validate(
    {                
        // Specify the validation rules
        rules:
        {        
            username: {
                required: true,
                remote: {
                    url: "../subadmin/check_username_exist",
                    type: "post"
                },
                minlength: 8
            },
            email:
            {
                required: true,
                email: true,
                remote: {
                    url: "../subadmin/check_student_email_exist",
                    type: "post"
                }
            },
            firstname:
            {
                required: true,
            },
            lastname:
            {
                required: true,
            }, 
            phone:{
                required: true
            },
            password:{
                required: true,
                minlength: 8
            },
            cpassword  :
            {
                required: true,
                equalTo: "#password"
            }
        },
        // Specify the validation error messages
        messages:
        {
            username: {
                required:enterUsername,
                remote: usernameAlreadyExist,
                minlength: enterAtLeastLength
            }, 
            email: {
                required:enterEmail,
                email: emailNotValid,
                remote: emailAlreadyExist,
            },             
            firstname:enterFirstname,             
            lastname:enterLastname,
            phone: {
                required: enterPhone,
                number: enterValidNumber,
                minlength: enterAtLeastDigit
            }, 
            password: {
                required: enterPassword,   
                minlength: enterAtLeastLength
            },
            cpassword:{
                required: enterConfirmPassword, 
                equalTo: passwordNotMatched  
            }                             
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    //Admin Subadmin Edit Validation
    $("#sub_admin_form").validate(
    {                
        // Specify the validation rules
        rules:
        {        
            username: {
                required: true,
                remote: {
                    url: "../../subadmin/check_other_username_exist",
                    type: "post",
                    data:{
                       id:function(){
                           return $('input#id').val();
                       }
                   }
                },
                minlength: 8
            },
            email:
            {
                required: true,
                email: true,
                remote: {
                    url: "../../subadmin/check_other_student_email_exist",
                    type: "post",
                    data:{
                       id:function(){
                           return $('input#id').val();
                       }
                   }
                }
            },
            firstname:
            {
                required: true,
            },
            lastname:
            {
                required: true,
            }, 
            phone:{
                required: true
            },
            password:{
                required: false,
                minlength: 8
            },
            cpassword  :
            {
                required: false,
                equalTo: "#password"
            }
        },
        // Specify the validation error messages
        messages:
        {
            username: {
                required:enterUsername,
                remote: usernameAlreadyExist,
                minlength: enterAtLeastLength
            }, 
            email: {
                required:enterEmail,
                email: emailNotValid,
                remote: emailAlreadyExist,
            },             
            firstname:enterFirstname,             
            lastname:enterLastname,
            phone: {
                required: enterPhone,
                number: enterValidNumber,
                minlength: enterAtLeastDigit
            },
            password: {
                required: enterPassword,   
                minlength: enterAtLeastLength
            },
            cpassword:{
                required: enterConfirmPassword, 
                equalTo: passwordNotMatched  
            }                           
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    //Admin Student Create Validation
    $("#student_create_form").validate(
    {                
        // Specify the validation rules
        rules:
        {        
            username: {
                required: true,
                remote: {
                    url: "../students/check_username_exist",
                    type: "post"
                },
                minlength: 8
            },
            email:
            {
                required: true,
                email: true,
                remote: {
                    url: "../students/check_student_email_exist",
                    type: "post"
                }
            },
            firstname:
            {
                required: true,
            },
            lastname:
            {
                required: true,
            }, 
            phone:{
                required: true
            },
            password:{
                required: true,
                minlength: 8
            },
            cpassword  :
            {
                required: true,
                equalTo: "#password"
            }
        },
        // Specify the validation error messages
        messages:
        {
            username: {
                required:enterUsername,
                remote: usernameAlreadyExist,
                minlength: enterAtLeastLength
            }, 
            email: {
                required:enterEmail,
                email: emailNotValid,
                remote: emailAlreadyExist,
            },             
            firstname:enterFirstname,             
            lastname:enterLastname,
            phone: {
                required: enterPhone,
                number: enterValidNumber,
                minlength: enterAtLeastDigit
            }, 
            password: {
                required: enterPassword,   
                minlength: enterAtLeastLength
            },
            cpassword:{
                required: enterConfirmPassword, 
                equalTo: passwordNotMatched  
            }                             
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    //Admin Student Edit Validation
    $("#student_edit_form").validate(
    {                
        // Specify the validation rules
        rules:
        {        
            username: {
                required: true,
                remote: {
                    url: "../../students/check_other_username_exist",
                    type: "post",
                    data:{
                       id:function(){
                           return $('input#id').val();
                       }
                   }
                },
                minlength: 8
            },
            email:
            {
                required: true,
                email: true,
                remote: {
                    url: "../../students/check_other_student_email_exist",
                    type: "post",
                    data:{
                       id:function(){
                           return $('input#id').val();
                       }
                   }
                }
            },
            firstname:
            {
                required: true,
            },
            lastname:
            {
                required: true,
            }, 
            phone:{
                required: true
            },
            password:{
                required: false,
                minlength: 8
            },
            cpassword  :
            {
                required: false,
                equalTo: "#password"
            }
        },
        // Specify the validation error messages
        messages:
        {
            username: {
                required:enterUsername,
                remote: usernameAlreadyExist,
                minlength: enterAtLeastLength
            }, 
            email: {
                required:enterEmail,
                email: emailNotValid,
                remote: emailAlreadyExist,
            },             
            firstname:enterFirstname,             
            lastname:enterLastname,
            phone: {
                required: enterPhone,
                number: enterValidNumber,
                minlength: enterAtLeastDigit
            },
            password: {
                required: enterPassword,   
                minlength: enterAtLeastLength
            },
            cpassword:{
                required: enterConfirmPassword, 
                equalTo: passwordNotMatched  
            }                           
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    //Admin Upload Student Documents Create form
    $("#student_document_create_form").validate(
    {                
        // Specify the validation rules
        rules:
        {        
            document_type_id:
            {
                required: true,
            },
            file_name:
            {   
                required: true,
                extension: "jpg|jpeg|gif|png|bmp|pdf|xls|doc"
            }
        },
        // Specify the validation error messages
        messages:
        {
            document_type_id:selectDocumentType,
            file_name:{
                required: selectFile,
                extension: validExtension
            }
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    //Admin Upload Student Documents Edit form
    $("#student_document_edit_form").validate(
    {                
        rules:
        {        
            document_type_id:
            {
                required: true,
            },
            file_name:
            {   
                required: false,
                extension: "jpg|jpeg|gif|png|bmp|pdf|xls|doc"
            }
        },
        // Specify the validation error messages
        messages:
        {
            document_type_id:selectDocumentType,
            file_name:{
                required: selectFile,
                extension: validExtension
            }
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });

    //admin send bulk messages form
    $("#messaging_form").validate(
    {                
        // Specify the validation rules
        rules:
        { 
            "receive_id[]":
            {
                required: true,
            },
            message:
            {
                required: true,
            }
        },
        // Specify the validation error messages
        messages:
        {
            "receive_id[]": {
                required:selectUser,
            }, 
            message: {
                required:enterMessage,
            },
        },
        submitHandler: function(form)
        {
            form.submit();
        }
    });
});


$(document).ready(function() {

    //Admin Subadmin Delete
    $("#subadminsTable, #usersTable").on('click', '.deleteRecord', function(event) {
        event.preventDefault();
        var id = $(this).attr("data-id");
        var controller = $(this).attr("data-controller");
        var title = $(this).attr("data-title");
        swal({
            title: areYouSure,
            text: youWantDelete+" "+title+"?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: yesDelete,
            cancelButtonText: noCancel,
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                window.location.href = controller+"/delete/" + id;
            } else {
                swal("Cancelled", yourDataSafe, "error");
            }
        });
    });

    $("#student_document_form_d").on('click', '.deleteDocuments', function(event) {
        event.preventDefault();

        var id = $(this).attr("data-id");
        var data_name = $(this).attr("data-name");
        var data_file = $(this).attr("data-file");

        var student_id = $("#student_id").val();

        swal({
            title: areYouSure,
            text: youWantDelete+" "+data_name+" "+documentMsg,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: yesDelete,
            cancelButtonText: noCancel,
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                window.location.href = '../../documents/delete_document/'+id+'/'+student_id+'/'+data_file;
            } else {
                swal("Cancelled", yourDataSafe, "error");
            }
        });
    });
});
