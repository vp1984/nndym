'use strict';
// Class definition

// Class definition

var KTFormControls = function () {
    // Private functions

    var validateform = function () {
        $( "#frmAddEdit" ).validate({
            // define validation rules
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true
                },
                password: {
                    required: true
                },
                address1: {
                    required: true
                },
                address2: {
                    required: true
                },
                address1: {
                    required: true
                },
                postal_code: {
                    required: true
                },
                country_id: {
                    required: true
                },
                state_id: {
                    required: true
                },
                city_id: {
                    required: true
                },
                role_id: {
                    required: true
                },
                current_password: {
                    required: true
                },
                status: {
                    required: true
                },
            },
            messages: {
                'name': {
                    required: "Please enter Name",
                },
                'email': {
                    required: "Please enter email",
                },
                'password': {
                    required: "Please enter password",
                },
                'address1': {
                    required: "Please enter address 1",
                },
                'address2': {
                    required: "Please enter address 2",
                },
                'postal_code': {
                    required: "Please enter postal code",
                },
                'country_id': {
                    required: "Please select country",
                },
                'state_id': {
                    required: "Please select state",
                },
                'city_id': {
                    required: "Please select city",
                },
                'role_id': {
                    required: "Please select role",
                },
                'current_password': {
                    required: "Please select role",
                },
                'status': {
                    required: "Please select status",
                },

            },

            errorPlacement: function(error, element) {
                var group = element.closest('.input-group');
                if (group.length) {
                    group.after(error.addClass('invalid-feedback'));
                } else {
                    element.after(error.addClass('invalid-feedback'));
                }
            },

            //display error alert on form submit
            invalidHandler: function(event, validator) {
                var alert = $('#kt_form_1_msg');
                alert.removeClass('kt--hide').show();
                KTUtil.scrollTop();
            },

            submitHandler: function (form) {
                form.submit(); // submit the form
            }
        });
    }

    var validateform1 = function () {
        $( "#frmchngpsw" ).validate({
            // define validation rules
            rules: {
                current_password: {
                    required: true
                },
                password: {
                    required: true
                },
                password_confirmation: {
                    required: true
                }
            },
            messages: {
                
                'current_password': {
                    required: "Please enter current password",
                },
                'password': {
                    required: "Please enter password",
                },
                'password_confirmation': {
                    required: "Please re enter password",
                }
            },

            errorPlacement: function(error, element) {
                var group = element.closest('.input-group');
                if (group.length) {
                    group.after(error.addClass('invalid-feedback'));
                } else {
                    element.after(error.addClass('invalid-feedback'));
                }
            },

            //display error alert on form submit
            invalidHandler: function(event, validator) {
                var alert = $('#kt_form_1_msg');
                alert.removeClass('kt--hide').show();
                KTUtil.scrollTop();
            },

            submitHandler: function (form) {
                form.submit(); // submit the form
            }
        });
    }
    var validateform2 = function () {
        $( "#frmmyprofile" ).validate({
            // define validation rules
            rules: {
                name: {
                    required: true,
                },
                email: {
                    required: true
                },
                password: {
                    required: true
                },
                address1: {
                    required: true
                },
                address2: {
                    required: true
                },
                address1: {
                    required: true
                },
                postal_code: {
                    required: true
                },
                country_id: {
                    required: true
                },
                state_id: {
                    required: true
                },
                city_id: {
                    required: true
                },
                role_id: {
                    required: true
                },
                current_password: {
                    required: true
                },
                password: {
                    required: true
                },
                password_confirmation: {
                    required: true
                },
                status: {
                    required: true
                },
            },
            messages: {
                'name': {
                    required: "Please enter Name",
                },
                'email': {
                    required: "Please enter email",
                },
                'password': {
                    required: "Please enter password",
                },
                'address1': {
                    required: "Please enter address 1",
                },
                'address2': {
                    required: "Please enter address 2",
                },
                'postal_code': {
                    required: "Please enter postal code",
                },
                'country_id': {
                    required: "Please select country",
                },
                'state_id': {
                    required: "Please select state",
                },
                'city_id': {
                    required: "Please select city",
                },
                'role_id': {
                    required: "Please select role",
                },
                'current_password': {
                    required: "Please enter current password",
                },
                'password': {
                    required: "Please enter password",
                },
                'password_confirmation': {
                    required: "Please re enter password",
                },
                'status': {
                    required: "Please select status",
                },

            },

            errorPlacement: function(error, element) {
                var group = element.closest('.input-group');
                if (group.length) {
                    group.after(error.addClass('invalid-feedback'));
                } else {
                    element.after(error.addClass('invalid-feedback'));
                }
            },

            //display error alert on form submit
            invalidHandler: function(event, validator) {
                var alert = $('#kt_form_1_msg');
                alert.removeClass('kt--hide').show();
                KTUtil.scrollTop();
            },

            submitHandler: function (form) {
                form.submit(); // submit the form
            }
        });
    }

    return {
        // public functions
        init: function() {
            validateform();
            validateform1();
            validateform2();
        }
    };
}();

jQuery(document).ready(function() {
    KTFormControls.init();
    $("#reset").click(function () {
        $(':input', '#frmAddEdit').not(':button, :submit, :reset, :hidden').val('').prop('checked', false).prop('selected', false);
        $("#status").val('1').trigger('change');
    });

    $('#role_id').select2();
	$("#role_id").change(function(){
        var roleId = $("#role_id").val();
        var id = $("#id").val();
		$.ajax({
			type: 'POST',
			url: '/admin/user/get-rights',
			dataType: 'json',
			data: {role_id:roleId,id:id,_token : $('meta[name="csrf-token"]').attr('content')},
			success: function(response){
                console.log('response', response);
				if(response.result != ""){
					$(".rights").html(response.result);
				}else{
					$(".rights").html("<p class='text-danger'>Something went wrong.</p>");
				}
			}
        });
        
	});
   
    $('#role_id').trigger('change');
	
	$('body').on('click', '#checkAll', function () {
        
		if ($(this).prop('checked')) {
			$('.checkbox').prop('checked', true);
			$('.checkAllByModule').prop('checked', true);
		}
		else {
			$('.checkbox').prop('checked', false);
			$('.checkAllByModule').prop('checked', false);
		}
	});
	$('#checkAll').trigger('change');
	$('body').on('click', '.checkAllByModule', function () {
		var id = this.id;
		$('input:checkbox.'+id+'').each(function () {
			if ($('#'+id).prop('checked')) {
				$(this).prop('checked', true);
			}
			else {
				$(this).prop('checked', false);
			}
		});
		$(this).trigger('change');
	});
	$('body').on('click', '.checkbox', function () {
		var myClass = $(this).attr("class");
		var split = myClass.split(" ");
		var dynamicClass = split[split.length-1];
        // if ($('.'+dynamicClass).prop('checked') == true) {
		// 	$('#'+dynamicClass).prop('checked', false);
		// }
		if($('.'+dynamicClass).not(':checked').length){
			$('#'+dynamicClass).prop('checked', false);
		}else{
			$('#'+dynamicClass).prop('checked', true);
		} 
    });

	$( ".checkAllByModule" ).each(function(){
		Id = this.id;
		if($('.'+Id).not(':checked').length){
			$('#'+Id).prop('checked', false);
		}else{
			$('#'+Id).prop('checked', true);
		} 
	});
});

$('#country_id').change(function(){
    var countryId = $(this).val();
    if(countryId){
        $.ajax({
            type:"GET",
            url:"/admin/user/state?countryId="+countryId,
            dataType: "json",
            success:function(res){
                if(res){
                    $("#state_id").empty();
                    $("#state_id").append('<option>--Select State--</option>');
                    $.each(res,function(key,value)
                    {
                        $("#state_id").append('<option value="'+value.id+'">'+value.name+'</option>');
                    });
                }
                else{
                    $("#state_id").empty();
                }
            }
        });
    }
    else{   
        $("#state_id").empty();
        $("#city_id").empty();
    }
});


$('#state_id').on('change',function(){
    var stateID = $(this).val();    
    if(stateID){
        $.ajax({
        type:"GET",
        url:"/admin/user/cities?stateID="+stateID,
        success:function(res){               
            if(res){
                $("#city_id").empty();
                $.each(res,function(key,value){
                        $("#city_id").append('<option value="'+value.id+'">'+value.name+'</option>');                  
                });
        
            }else{
            $("#city_id").empty();
            }
        }
        });
    }else{
        $("#city_id").empty();
    }
    
});