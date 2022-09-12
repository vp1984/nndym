$( document ).ready(function() {
    $('#checkAll').click(function(){
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
	$('.checkAllByModule').click(function(){
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