$(document).ready(function() {
    //datatable
    var table = $('#table_id').DataTable( {
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

    // //validate forgot email
    // $("#exampleInputEmail1").on('focusout', function() {
    //     var email = $('#exampleInputEmail1').val();
    //     if(email != ''){
    //         checkfemailAvailability();
    //     }else{
    //         $('#exampleInputEmail1').addClass('input-focus');
    //         $('#exampleInputEmail1').focus();
    //         return false;
    //     }        
    // }); 

    // //send otp for verified user
    // $("#verify").on('click', function() {
    //     $('#spinner').show();
    //     send_otp();
    // });

    // //send otp for register email user
    // $("#verify_email").on('click', function() {
    //     $('#spinner').show();
    //     send_reg_otp();
    // });

    // $("#exampleVerifyOtp").on('focusout', function() {
    //     var otp = $('#exampleVerifyOtp').val();
    //     if(otp != ''){
    //         $('#loaderIcon2').show();
    //         checkOtp();
    //     }else{
    //         $('#exampleVerifyOtp').addClass('input-focus');
    //         $('#exampleVerifyOtp').focus();
    //         $('#loaderIcon2').hide();
    //         $('#otp-status').val('failed');
    //         $('#otp-availability-status').html('<span style="color:red">Please enter OTP</span>');
    //         return false;
    //     }
        
    // });
});

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




// //check email for forgot password
// function checkfemailAvailability() {
//     $('#loaderIcon').show();
//     jQuery.ajax({
//     url: 'checkavailability.php',
//     data:'femail='+$('#exampleInputEmail1').val(),
//     type: 'POST',
//     success:function(response){
//         var response = [response];
//         var data = $.parseJSON(response);
//         if (data.check == 'success') {            
//             $('#email-status').val(data.check);
//             $('#email-availability-status').html(data.message);
//             $('#loaderIcon').hide();
//             $("#verify").show();
//         } else {
//             $('#email-status').val(data.check);
//             $('#email-availability-status').html(data.message);
//             $('#loaderIcon').hide();
//             $("#verify").hide();            
//         }    
//     },
//     error:function (){}
//     });
// }



// //send otp to verified user
// function send_otp(){ 
//     //send otp to email
//     var email = $('#exampleInputEmail1').val();
//     if(email == ''){
//         $('#exampleInputEmail1').addClass('input-focus');
//         $('#exampleInputEmail1').focus();
//     }else{
//         $.ajax({
//             url: "ajax.php",
//             type: 'POST',
//             data: {
//                 'email': email,
//             },
//             beforeSend: function(){
//             },
//             success:function(response){
//                 var response = [response];
//                 var data = $.parseJSON(response);
//                 if (data.check == 'success') {            
//                     $('#spinner').hide();
//                     $("#otp_verify").show();
//                     $("#otp_id").val(data.id);
//                     $("#verify").html("<span style='color:red;float:right;'>Resend OTP</span>");
//                 } else {
//                     $("#verify").html("<span style='color:red;float:right;'>Re-verify<span>");
//                 }    
//             }
//         });
//     }  
// }

// //check otp for verified user
// function checkOtp() {
//     jQuery.ajax({
//     url: 'checkavailability.php',
//     data:{'id':$('#otp_id').val(),'otp':$('#exampleVerifyOtp').val()},
//     type: 'POST',
//     success:function(response){
//         var response = [response];
//         var data = $.parseJSON(response);
//         if (data.check == 'success') {
//             $('#reset_password').removeAttr("disabled");
//             $('#otp-status').val(data.check);
//             $('#otp-availability-status').html(data.message);
//             $('#loaderIcon2').hide();
//         } else {
//             $('#otp-status').val(data.check);
//             $('#otp-availability-status').html(data.message);
//             $('#loaderIcon2').hide();
//         }
//     },
//     error:function (){}
//     });
// }

// //send otp to register user
// function send_reg_otp(){ 
//     var email = $('#exampleInputEmail').val();
//     if(email == ''){
//         $('#exampleInputEmail').addClass('input-focus');
//         $('#exampleInputEmail').focus();
//     }else{
//         $.ajax({
//             url: "ajax.php",
//             type: 'POST',
//             data: {
//                 'email': email,
//             },
//             beforeSend: function(){
//             },
//             success:function(response){
//                 var response = [response];
//                 var data = $.parseJSON(response);
//                 if (data.check == 'success') {            
//                     $('#spinner').hide();
//                     $("#otp_verify").show();
//                     $("#otp_id").val(data.id);
//                     $("#verify_email").html("<span style='color:red;float:right;'>Resend OTP</span>");
//                 } else {
//                     $("#verify_email").html("<span style='color:red;float:right;'>Re-verify<span>");
//                 }    
//             }
//         });
//     }   
// }

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

// //delete category
// function DeleteCategory(deleteid){
//     var conf = confirm("Do you want to delete this category?")
//     if(conf==true){
//         $.ajax({
//         url:"delete.php",
//         type:'POST',
//         data:{cat_id:deleteid},
//         success:function(response){
//             var response = [response];
//             var data = $.parseJSON(response);
//             $('#delete_status').html(data.message);
//         }
//         });
//         setTimeout(function(){
//             location.reload();
//         },2000);
//     }  
// }

// //delete plan
// function DeletePlan(deleteid){
//     var conf = confirm("Do you want to delete this plan?")
//     if(conf==true){
//         $.ajax({
//         url:"delete.php",
//         type:'POST',
//         data:{plan_id:deleteid},
//         success:function(response){
//             var response = [response];
//             var data = $.parseJSON(response);
//             $('#delete_status').html(data.message);
//         }
//         });
//         setTimeout(function(){
//             location.reload();
//         },2000);
//     }  
// }

// //delete agency
// function DeleteAgency(deleteid){
//     var conf = confirm("Do you want to delete this agency and it's respective agents and user?")
//     if(conf==true){
//         $.ajax({
//         url:"delete.php",
//         type:'POST',
//         data:{agency_id:deleteid},
//         success:function(response){
//             var response = [response];
//             var data = $.parseJSON(response);
//             $('#delete_status').html(data.message);
//         }
//         });
//         setTimeout(function(){
//             location.reload();
//         },2000);
//     }  
// }

// //delete agent
// function DeleteAgent(deleteid){
//     var conf = confirm("Do you want to delete this agent and it's respective user?")
//     if(conf==true){
//         $.ajax({
//         url:"delete.php",
//         type:'POST',
//         data:{agent_id:deleteid},
//         success:function(response){
//             var response = [response];
//             var data = $.parseJSON(response);
//             $('#delete_status').html(data.message);
//         }
//         });
//         setTimeout(function(){
//             location.reload();
//         },2000);
//     }  
// }

// //delete yard
// function DeleteYard(deleteid){
//     var conf = confirm("Do you want to delete this yard?")
//     if(conf==true){
//         $.ajax({
//         url:"delete.php",
//         type:'POST',
//         data:{yard_id:deleteid},
//         success:function(response){
//             var response = [response];
//             var data = $.parseJSON(response);
//             $('#delete_status').html(data.message);
//         }
//         });
//         setTimeout(function(){
//             location.reload();
//         },2000);
//     }  
// }

// //delete staff
// function DeleteStaff(deleteid){
//     var conf = confirm("Do you want to delete this staff and it's respective user?")
//     if(conf==true){
//         $.ajax({
//         url:"delete.php",
//         type:'POST',
//         data:{staff_id:deleteid},
//         success:function(response){
//             var response = [response];
//             var data = $.parseJSON(response);
//             $('#delete_status').html(data.message);
//         }
//         });
//         setTimeout(function(){
//             location.reload();
//         },2000);
//     }  
// }

// //delete mapping
// function DeleteMapping(deleteid){
//     var conf = confirm("Do you want to delete this mapping menu?")
//     if(conf==true){
//         $.ajax({
//         url:"delete.php",
//         type:'POST',
//         data:{mapping_id:deleteid},
//         success:function(response){
//             var response = [response];
//             var data = $.parseJSON(response);
//             $('#delete_status').html(data.message);
//         }
//         });
//         setTimeout(function(){
//             location.reload();
//         },2000);
//     }  
// }

// //delete bank_name
// function DeleteBank(deleteid){
//     var conf = confirm("Do you want to delete this Bank?")
//     if(conf==true){
//         $.ajax({
//         url:"delete.php",
//         type:'POST',
//         data:{bank_id:deleteid},
//         success:function(response){
//             var response = [response];
//             var data = $.parseJSON(response);
//             $('#delete_status').html(data.message);
//         }
//         });
//         setTimeout(function(){
//             location.reload();
//         },2000);
//     }  
// }


// //delete branch_name
// function DeleteBranch(deleteid){
//     var conf = confirm("Do you want to delete this Branch?")
//     if(conf==true){
//         $.ajax({
//         url:"delete.php",
//         type:'POST',
//         data:{branch_id:deleteid},
//         success:function(response){
//             var response = [response];
//             var data = $.parseJSON(response);
//             $('#delete_status').html(data.message);
//         }
//         });
//         setTimeout(function(){
//             location.reload();
//         },2000);
//     }  
// }

// //delete parking yard
// function DeleteParkingYard(deleteid){
//     var conf = confirm("Do you want to delete this yard?")
//     if(conf==true){
//         $.ajax({
//         url:"delete.php",
//         type:'POST',
//         data:{parking_yard_id:deleteid},
//         success:function(response){
//             var response = [response];
//             var data = $.parseJSON(response);
//             $('#delete_status').html(data.message);
//         }
//         });
//         setTimeout(function(){
//             location.reload();
//         },2000);
//     }  
// }



// //delete vehicle
// function DeleteVehicle(deleteid){
//     var conf = confirm("Do you want to delete this vehicle?")
//     if(conf==true){
//         $.ajax({
//         url:"delete.php",
//         type:'POST',
//         data:{vehicle_id:deleteid},
//         success:function(response){
//             var response = [response];
//             var data = $.parseJSON(response);
//             $('#delete_status').html(data.message);
//         }
//         });
//         setTimeout(function(){
//             location.reload();
//         },2000);
//     }  
// }

// //delete bank report
// function DeleteReport(deleteid){
//     var conf = confirm("Do you want to delete this report and it's respective data?")
//     if(conf==true){
//         $.ajax({
//         url:"delete.php",
//         type:'POST',
//         data:{report_id:deleteid},
//         success:function(response){
//             var response = [response];
//             var data = $.parseJSON(response);
//             $('#delete_status').html(data.message);
//         }
//         });
//         setTimeout(function(){
//             location.reload();
//         },2000);
//     }  
// }


// //delete bank report
// function DeleteSampleReport(deleteid){
//     var conf = confirm("Do you want to delete this report and it's respective data?")
//     if(conf==true){
//         $.ajax({
//         url:"delete.php",
//         type:'POST',
//         data:{sample_report_id:deleteid},
//         success:function(response){
//             var response = [response];
//             var data = $.parseJSON(response);
//             $('#delete_status').html(data.message);
//         }
//         });
//         setTimeout(function(){
//             location.reload();
//         },2000);
//     }  
// }

// //show branch as per bank id
// function show_branch(self){
//     var bank_data = self.value;
//     if (bank_data != '') {
//         $.ajax({
//             url: "ajax.php",
//             dataType: 'html',
//             type: 'POST',
//             data: {
//                 'bank_data': bank_data,
//             },
//             success: function (data) {
//                 $("#branch_data").html(data);
//                 $("#branch_div").show();
//                 $("#upload_file").removeAttr('disabled');
//                 add_branch_search();
//             }
//         });
//     }
// }
// //searchable branch name
// function add_branch_search(){
//     var select_box_element = document.querySelector('#exampleInputbranchname1');
//     dselect(select_box_element, {
//         search: true
//     }); 
// }

// //show city as per state
// function show_city(self){
//     var state_id = self.value;
//     if (state_id != '' && state_id != 0) {
//         $.ajax({
//             url: "ajax.php",
//             dataType: 'html',
//             type: 'POST',
//             data: {
//                 'state_id': state_id,
//             },
//             success: function (data) {
//                 $("#city_data").html(data);
//                 $("#other_state").attr('type','hidden');
//                 $("#other_city").attr('type','hidden');
//                 $("#city_div").show();
//                 $("#other_state_div").hide();
//                 $("#add_yard").removeAttr('disabled');
//                 add_city_search();
//             }
//         });
//     }else if(state_id == 0){
//         $("#add_yard").removeAttr('disabled');
//         $("#state_id").attr('disabled');
//         $("#other_state_div").show();
//     }
// }

// function activate_plan(self){
//     var id = $.trim($(self).data('id'));
//     var plan_id = $.trim($("#plan_" + id).val());
//     var start_date = $.trim($(".start_date_" + id).val());

//     $.ajax({
//         url: "ajax.php",
//         type: 'POST',
//         data: {
//             'agency_id': id,
//             'plan_id': plan_id,
//             'start_date': start_date,
//         },
//         beforeSend: function(){
//         },
//         success:function(response){
//             var response = [response];
//             var data = $.parseJSON(response);
//             $('#show_activate_status_'+ id).html(data.message);   
//         }
//     });
//     setTimeout(function(){
//         location.reload();
//     },2000);
// }

// //searchable city name
// function add_city_search(){
//     var select_box_element = document.querySelector('#city_id');
//     dselect(select_box_element, {
//         search: true
//     }); 
// }

// //document.querySelector('#select_option > div > button');
// $("#select_option").on('click', function() {
//     var value = $("#select_option > div > button").attr('data-dselect-text');
//     if(value != ''){
//         $("#searchform").show();
//         $("#search_btn").removeAttr('disabled'); 
//     }   
// });

// //click_to_copy_html_text
// function click_to_copy_html_text(self) {
//     var $temp = $("<input>");
//     $("body").append($temp);
//     $temp.val($(self).text()).select();
//     document.execCommand("copy");
//     $(self).tooltip('hide').attr('data-original-title', 'Copied').tooltip('show');
//     $temp.remove();
//     setTimeout(function () {
//         $('#message').html('<div class="alert alert-success alert-dismissible" role="alert">Copied</div>');
//         setTimeout(function() {
//             $(".alert").alert('close');
//           }, 2000); // hide alert
//         $(self).tooltip('hide').attr('data-original-title', "Click To Copy");
//     }, 1000);
// }

// var payment_in_progress = false;

// function buy_plan(plan_id){
//     if (payment_in_progress) {
//         return false;
//     }
    
//     $("#pay_button_"+plan_id).html("Loading...");
//     $("#pay_button_"+plan_id).prop("disabled", true);

//     payment_in_progress = true;

//     //var current_url = window.location.href;
//     $.ajax({
//         url: "pay_ajax.php",
//         type: 'POST',
//         data: {
//             'plan_id': plan_id,
//             //'current_url': current_url,
//             'buy_plan': 'buy_plan'
//         },
//         success: function(data) {
//             var options = jQuery.parseJSON(data);
//             //console.log(options)
//             $('#razorpay_order_id_'+plan_id).val(options.order_id);

//             // Boolean whether to show image inside a white frame. (default: true)
//             options.theme.image_padding = false;
//             options.handler = function(payment) {
//                 $('#razorpay_payment_id_'+plan_id).val(payment.razorpay_payment_id);
//                 $('#razorpay_signature_'+plan_id).val(payment.razorpay_signature);

//                 $.ajax({
//                     url: "pay_ajax.php",
//                     data: {
//                         'razorpay_payment_id': $('#razorpay_payment_id_'+plan_id).val(),
//                         'razorpay_signature': $('#razorpay_signature_'+plan_id).val(),
//                         'razorpay_order_id': $('#razorpay_order_id_'+plan_id).val(),
//                         'plan_id': plan_id,
//                         'payment_success': 'payment_success'
//                     },
//                     type: 'POST',
//                     success: function(response) {
//                         payment_in_progress = false;
//                         $("#pay_button_"+plan_id).html("Buy Plan");
//                         $("#pay_button_"+plan_id).removeAttr('disabled');
//                         var result = jQuery.parseJSON(response);
//                         $("#delete_status").html(result.message);
//                         setTimeout(function() {
//                             window.location.reload();// refresh page
//                         }, 2000); 
                        
//                         // if (result.check == 'success') {                            
//                         //     window.location.href = 'index.php';
//                         // }
//                     },
//                     error: function(error) {
//                         $("#delete_status").html("<div class='alert alert-danger alert-dismissible' role='alert'><strong>Payment Verification in progress...</strong></div>");
//                     }
//                 });
//             };

//             options.modal = {
//                 ondismiss: function() {
//                     payment_in_progress = false;
//                     $("#pay_button_"+plan_id).html("Buy Plan");
//                     $("#pay_button_"+plan_id).removeAttr('disabled');
//                     console.log("This code runs when the popup is closed");
//                 },
//                 // Boolean indicating whether pressing escape key 
//                 // should close the checkout form. (default: true)
//                 escape: true,
//                 // Boolean indicating whether clicking translucent blank
//                 // space outside checkout form should close the form. (default: false)
//                 backdropclose: false
//             };

//             var rzp = new Razorpay(options);
//             rzp.open();


//         },
//         error: function(xhr, status, error) {
//             $("#delete_status").html("<div class='alert alert-danger alert-dismissible' role='alert'><strong>Payment Verification in progress...</strong></div>");
//         }
//     });
// }