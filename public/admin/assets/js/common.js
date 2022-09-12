"use strict";
$(document).ready(function () {
	$('#local_data').on('click', '.delete_row', function () {
		$('#delete_id').val($(this).data('id'));
		$('#delete_modal').modal('show');
	});
	$('#local_data').on('click', '.copy_row', function () {
		$('#copy_id').val($(this).data('id'));
		$('#copy_modal').modal('show');
	});
	$(document).on('click', '#kt_datatable_delete_all', function () {
		if ($('input[type="checkbox"]:checked').length > 0) {
			var selectedIDs = $('input[type="checkbox"]:checked').map(function () {
				return $(this).val();
			}).get();
			$('#delete_id').val(selectedIDs);
			$('#delete_modal').modal('show');
			return false;
		} else {
			$('#select_modal').modal('show');
			return false;
		}  
	});
	$(document).on('click', '.toggle_status', function () {	
		if ($('input[type="checkbox"]:checked').length > 0) {
			var selectedIDs = $('input[type="checkbox"]:checked').map(function () {
				return $(this).val();
			}).get();
			$('#toggle_id').val(selectedIDs);
			$('#toggle_status').val($(this).attr("data-type"));
			$('#toggle_modal').modal('show');
			return false;
		} else {
			$('#select_modal').modal('show');
			return false;
		}
	});
	$.validator.addMethod("validateEmailNotEmpty", function(value, element) {
		if(value == ''){
			return true;
		}
		else if (/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/.test(value)) {
			return true;
		} else {
			return false;
		}
	}, "Please enter a valid Email.");
});