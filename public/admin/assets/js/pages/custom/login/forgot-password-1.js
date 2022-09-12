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
	
	
	// Private Functions
	var handleForgotPasswordFormSubmit = function () {
		$('#kt_login_signin_submit').click(function (e) {
			e.preventDefault();
			var forgotUrl = new URL(document.URL)+ '';
			var parts = forgotUrl.split('/');
			var resultId = parts[parts.length - 1];
			
			var btn = $(this);
			var form = $('#kt_login_form');

			form.validate({
				rules: {
					password: {
						required: true
					},
					new_confirm_password: {
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
			
			form.ajaxSubmit({
				url: '/admin/forgot-password/'+resultId,
				dataType: 'json',
				data: {
					"_token": $('meta[name="csrf-token"]').attr('content'),
				},
				success: function (response, status, xhr, $form) {
					if(response.status == 1){
						// similate 2s delay
						showErrorMsg(form, 'success', response.msg);
						setTimeout(function () {
							KTApp.unprogress(btn[0]);
							window.location.href=response.action;//redirection
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

	// Public Functions
	return {
		// public functions
		init: function () {
			handleForgotPasswordFormSubmit();
		}
	};
}();

// Class Initialization
jQuery(document).ready(function () {
	KTLoginV1.init();
});
