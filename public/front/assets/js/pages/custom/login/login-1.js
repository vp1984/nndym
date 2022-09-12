"use strict";

// Class Definition
var KTLoginV1 = function () {
	var login = $('#kt_login');

	var showErrorMsg = function(form, type, msg) {
        var alert = $('<div class="alert alert-bold alert-solid-' + type + ' alert-dismissible" role="alert">\
			<div class="alert-text">'+msg+'</div>\
			<div class="alert-close">\
                <i class="flaticon2-cross kt-icon-sm" data-dismiss="alert"></i>\
            </div>\
		</div>');

        form.find('.alert').remove();
        alert.prependTo(form);
		KTUtil.animateClass(alert[0], 'fadeIn animated');
	}

	var displaySignInForm = function() {
		login.removeClass('kt-login--forgot');
        
        login.addClass('kt-login--signin');
        KTUtil.animateClass(login.find('.kt-login__form')[0], 'flipInX animated');
        //login.find('.kt-login__signin').animateClass('flipInX animated');
    }

	var displayForgotForm = function() {
		
        login.removeClass('kt-login--signin');
        
        login.addClass('kt-login--forgot');
        //login.find('.kt-login--forgot').animateClass('flipInX animated');
        KTUtil.animateClass(login.find('.kt-login__forgot')[0], 'flipInX animated');

    }
	
	var handleFormSwitch = function() {
		$('#kt_login_forgot').click(function(e) {
            e.preventDefault();
            displayForgotForm();
        });

        $('#kt_login_forgot_cancel').click(function(e) {
            e.preventDefault();
            displaySignInForm();
        });
	}
	
	var handleForgotFormSubmit = function() {
        $('#kt_login_forgot_submit').click(function(e) {
            e.preventDefault();

            var btn = $(this);
            var form = $(this).closest('form');

            form.validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    }
                }
            });

            if (!form.valid()) {
                return;
            }

            btn.addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', true);

            form.ajaxSubmit({
				url: 'admin/forgot-login',
				dataType: 'json',
				data: {
					"_token": $('meta[name="csrf-token"]').attr('content'),
				},
                success: function(response, status, xhr, $form) {
					console.log(response.status);
					if(response.status == 1){
						// similate 2s delay
						setTimeout(function() {
							btn.removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').attr('disabled', false); // remove
							form.clearForm(); // clear form
							form.validate().resetForm(); // reset validation states
	
							// display signup form
							displaySignInForm();
							var signInForm = login.find('.kt-login__form form');
							signInForm.clearForm();
							signInForm.validate().resetForm();
	
							showErrorMsg(signInForm, 'success', response.msg);
						}, 2000);

					}else{
						// similate 2s delay
						setTimeout(function () {
							KTApp.unprogress(btn[0]);
							showErrorMsg(form, 'danger', response.msg);
						}, 2000);
					}
                	
                }
            });
        });
    }

	// Private Functions
	var handleSignInFormSubmit = function () {
		$('#kt_login_signin_submit').click(function (e) {
			e.preventDefault();

			var btn = $(this);
			var form = $('#kt_login_form');

			form.validate({
				rules: {
					username: {
						required: true,
						email: true
					},
					password: {
						required: true
					}
				}
			});

			if (!form.valid()) {
				return;
			}

			KTApp.progress(btn[0]);

			setTimeout(function () {
				KTApp.unprogress(btn[0]);
			}, 2000);
			// ajax form submit:  http://jquery.malsup.com/form/
			form.ajaxSubmit({
				url: '/backend-login',
				dataType: 'json',
				data: {
					"admin": false,
					"_token": $('meta[name="csrf-token"]').attr('content'),
				},
				success: function (response, status, xhr, $form) {
					if(response.status == 1){
						window.location.href=response.action;//redirection
					}else{
						// similate 2s delay
						setTimeout(function () {
							KTApp.unprogress(btn[0]);
							showErrorMsg(form, 'danger', response.msg);
						}, 2000);
					}
				}
			});
		});
	}

	// Public Functions
	return {
		// public functions
		init: function () {
			handleFormSwitch();
			handleSignInFormSubmit();
			handleForgotFormSubmit();
		}
	};
}();

// Class Initialization
jQuery(document).ready(function () {
	KTLoginV1.init();
});
