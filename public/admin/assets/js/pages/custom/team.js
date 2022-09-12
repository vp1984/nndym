'use strict';
// Class definition

// Class definition

var KTFormControls = function () {
    // Private functions
    var ignore = '';
    if(typeof $('#image_exist').val() !== "undefined"){
        ignore = "#customFile";
    }
    var validateform = function () {
        $( "#frmAddEdit" ).validate({
            // define validation rules
            ignore: ignore,

            rules: {
                name: {
                    required: true,
                },
                image: {
                    required: true,
                    accept:"png"
                },
                email: {
                    validateEmailNotEmpty:true
                },
                // designation_id: {
                //     required: true,
                // },
                city_id: {
                    required: true,
                },
                description: {
                    required: true,
                },
                status: {
                    required: true
                },
            },

            messages: {
                name: {
                    required: 'Please specify Member'
                },
                image: {
                    required:'Please select Photo',
                    accept: "Only image type png is allowed"
                },
                email: {
                    validateEmailNotEmpty:'Please specify valid email address',
                },
                // designation_id: {
                //     required:'Please select Designation'
                // },
                city_id: {
                    required:'Please select City'
                },
                description: {
                    required:'Please specify Description'
                },
                status: {
                    required:'Please select Status'
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
        }
    };
}();

jQuery(document).ready(function() {
    KTFormControls.init();
    $("#reset").click(function () {
        $(':input', '#frmAddEdit').not(':button, :submit, :reset, :hidden').val('').prop('checked', false).prop('selected', false);
        $("#status").val('1').trigger('change');
    });
});