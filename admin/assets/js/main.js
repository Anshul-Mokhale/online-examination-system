$(document).ready(function() {
    //datatable
    $('#table_id').DataTable( {
        fixedHeader: true //fix header
    });

    //datetimepicker
    $( "#datetimepicker" ).datetimepicker( { 
      format:'Y-m-d H:i:s', //date format
      minDate: 0,  // disable past date
      minTime: 0, // disable past time
    });

    // alert box
    setTimeout(function() {
      $(".alert").alert('close');
    }, 2000); // hide alert
    

    /* Start User Registration Email Verify */

    //validate register email
    $("#exampleInputEmail").on('focusout', function() {
        var email = $('#exampleInputEmail').val();
        if(email != ''){
            checkemailAvailability();
        }else{
            $('#exampleInputEmail').addClass('input-focus');
            $('#exampleInputEmail').focus();
            return false;
        }        
    }); 

    //send otp for registeration of user through email
    $("#verify_email").on('click', function() {
        $('#spinner').show();
        send_reg_otp();
    });

    //verify email otp
    $("#exampleVerifyOtp").on('focusout', function() {
        var otp = $('#exampleVerifyOtp').val();
        if(otp != ''){
            $('#loaderIcon2').show();
            checkOtp();
        }else{
            $('#exampleVerifyOtp').addClass('input-focus');
            $('#exampleVerifyOtp').focus();
            $('#loaderIcon2').hide();
            $('#otp-status').val('failed');
            $('#otp-availability-status').html('<span style="color:red">Please enter OTP</span>');
            return false;
        }        
    });

    /*End User Registration Email Verify */


    /*Start User Forgot Password Email Verify */
    //validate forgot email
    $("#exampleInputEmail1").on('focusout', function() {
        var email = $('#exampleInputEmail1').val();
        if(email != ''){
            checkfemailAvailability();
        }else{
            $('#exampleInputEmail1').addClass('input-focus');
            $('#exampleInputEmail1').focus();
            return false;
        }        
    });

    //send otp for verified user
    $("#verify").on('click', function() {
        $('#spinner').show();
        send_otp();
    });

    /*End User Forgot Password Email Verify */
    
});

/* Start User Registration Email Verify */

//check email for register
function checkemailAvailability() {
    $('#loaderIcon').show();
    jQuery.ajax({
    url: 'checkavailability.php',
    data:'email='+$('#exampleInputEmail').val(),
    type: 'POST',
    success:function(response){
        var response = [response];
        var data = $.parseJSON(response);
        if (data.check == 'success') {            
            $('#email-status').val(data.check);
            $('#email-availability-status').html(data.message);
            $('#loaderIcon').hide();
            $("#verify_email").show();
        } else {
            $('#email-status').val(data.check);
            $('#email-availability-status').html(data.message);
            $('#loaderIcon').hide();
            $("#verify_email").hide();            
        }    
    },
    error:function (){}
    });
}

//send otp to registeration of user through email
function send_reg_otp(){ 
    var email = $('#exampleInputEmail').val();
    if(email == ''){
        $('#exampleInputEmail').addClass('input-focus');
        $('#exampleInputEmail').focus();
    }else{
        $.ajax({
            url: "ajax.php",
            type: 'POST',
            data: {
                'email': email,
            },
            beforeSend: function(){
            },
            success:function(response){
                var response = [response];
                var data = $.parseJSON(response);
                if (data.check == 'success') {            
                    $('#spinner').hide();
                    $("#otp_verify").show();
                    $("#otp_id").val(data.id);
                    $("#verify_email").html("<span style='color:red;float:right;'>Resend OTP</span>");
                } else {
                    $("#verify_email").html("<span style='color:red;float:right;'>Re-verify<span>");
                }    
            }
        });
    }   
}

//check otp status for verified user & forgot password
function checkOtp() {
    jQuery.ajax({
    url: 'checkavailability.php',
    data:{'id':$('#otp_id').val(),'otp':$('#exampleVerifyOtp').val()},
    type: 'POST',
    success:function(response){
        var response = [response];
        var data = $.parseJSON(response);
        if (data.check == 'success') {
            $('#reset_password').removeAttr("disabled");
            $('#register').removeAttr("disabled");
            $('#otp-status').val(data.check);
            $('#otp-availability-status').html(data.message);
            $('#loaderIcon2').hide();
        } else {
            $('#otp-status').val(data.check);
            $('#otp-availability-status').html(data.message);
            $('#loaderIcon2').hide();
        }
    },
    error:function (){}
    });
}

/*End User Registration Email Verify */

/*Start User Forgot Password Email Verify */

//check email for forgot password
function checkfemailAvailability() {
    $('#loaderIcon').show();
    jQuery.ajax({
    url: 'checkavailability.php',
    data:'femail='+$('#exampleInputEmail1').val(),
    type: 'POST',
    success:function(response){
        var response = [response];
        var data = $.parseJSON(response);
        if (data.check == 'success') {            
            $('#email-status').val(data.check);
            $('#email-availability-status').html(data.message);
            $('#loaderIcon').hide();
            $("#verify").show();
        } else {
            $('#email-status').val(data.check);
            $('#email-availability-status').html(data.message);
            $('#loaderIcon').hide();
            $("#verify").hide();            
        }    
    },
    error:function (){}
    });
}

//send otp to verified user
function send_otp(){ 
    //send otp to email
    var email = $('#exampleInputEmail1').val();
    if(email == ''){
        $('#exampleInputEmail1').addClass('input-focus');
        $('#exampleInputEmail1').focus();
    }else{
        $.ajax({
            url: "ajax.php",
            type: 'POST',
            data: {
                'email': email,
            },
            beforeSend: function(){
            },
            success:function(response){
                var response = [response];
                var data = $.parseJSON(response);
                if (data.check == 'success') {            
                    $('#spinner').hide();
                    $("#otp_verify").show();
                    $("#otp_id").val(data.id);
                    $("#verify").html("<span style='color:red;float:right;'>Resend OTP</span>");
                } else {
                    $("#verify").html("<span style='color:red;float:right;'>Re-verify<span>");
                }    
            }
        });
    }  
}

/*End User Forgot Password Email Verify */

//delete user
function DeleteUser(deleteid){
    var conf = confirm("Do you want to delete this user and it's respective data?")
    if(conf==true){
        $.ajax({
        url:"delete.php",
        type:'POST',
        data:{user_id:deleteid},
        success:function(response){
            var response = [response];
            var data = $.parseJSON(response);
            $('#delete_status').html(data.message);
        }
        });
        setTimeout(function(){
            location.reload();
        },2000);
    }  
}


//delete header menu 
function DeleteMenu(deleteid){
    var conf = confirm("Do you want to delete this menu and it's respective sub-menu?")
    if(conf==true){
        $.ajax({
        url:"delete.php",
        type:'POST',
        data:{menu_id:deleteid},
        success:function(response){
            var response = [response];
            var data = $.parseJSON(response);
            $('#delete_status').html(data.message);
        }
        });
        setTimeout(function(){
            location.reload();
        },2000);
    }  
}


//delete banner image 
function DeleteHeaderImage(deleteid){
    var conf = confirm("Do you want to delete this banner image?")
    if(conf==true){
        $.ajax({
        url:"delete.php",
        type:'POST',
        data:{banner_images_id:deleteid},
        success:function(response){
            var response = [response];
            var data = $.parseJSON(response);
            $('#delete_status').html(data.message);
        }
        });
        setTimeout(function(){
            location.reload();
        },2000);
    }  
}

//delete quote 
function DeleteQuote(deleteid){
    var conf = confirm("Do you want to delete this quote?")
    if(conf==true){
        $.ajax({
        url:"delete.php",
        type:'POST',
        data:{quote_id:deleteid},
        success:function(response){
            var response = [response];
            var data = $.parseJSON(response);
            $('#delete_status').html(data.message);
        }
        });
        setTimeout(function(){
            location.reload();
        },2000);
    }  
}

