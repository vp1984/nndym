'use strict';
// Class definition

var KTDatatableDataLocalDemo = function() {
	// Private functions
	// variables
	var datatable;
	// demo initializer
	var init = function() {
		var dataJSONArray;
		$.ajax({
			url: 'team',
			dataType: 'json',
			type: 'get',
			contentType: 'application/json',
			data: $("#list-form").serialize(),
			success: function( data, textStatus, jQxhr ){
				dataJSONArray = JSON.parse(JSON.stringify(data.data));

				datatable = $('.kt-datatable').KTDatatable({
					// datasource definition
					data: {
						type: 'local',
						source: dataJSONArray,
						pageSize: 10,
					},
		
					// layout definition
					layout: {
						scroll: false, // enable/disable datatable scroll both horizontal and vertical when needed.
						// height: 450, // datatable's body's fixed height
						footer: false, // display/hide footer
					},
		
					// column sorting
					sortable: true,
		
					pagination: true,
		
					search: {
						input: $('#generalSearch'),
					},
		
					// columns definition
					columns: [
						{
							field: 'id',
							title: '#',
							sortable: false,
							width: 20,
							type: 'number',
							selector: {class: 'kt-checkbox--solid'},
							textAlign: 'center',
						}, {
							field: 'name',
							title: 'Team',
						},
						{
							field: 'leader',
							title: 'Team Leader',
						}, 
						// {
						// 	field: 'designation_name',
						// 	title: 'Designation',
						// }, 
						{
								field: 'status',
								title: 'Status',
								template: function(row) {
									var status = {
										'Active': {'title': 'Active', 'class': ' kt-badge--success'},
										'Inactive': {'title': 'Inactive', 'class': ' kt-badge--danger'},
									};
									return '<span class="kt-badge ' + status[row.status].class + ' kt-badge--inline kt-badge--pill">' + status[row.status].title + '</span>';
								},
						}, {
							field: 'Actions',
							title: 'Actions',
							sortable: false,
							width: 110,
							overflow: 'visible',
							autoHide: false,
							template: function(row) {
								var roleBasedAction = '';
								if(isViewStatus == true){
									roleBasedAction += '<a href="'+viewURL+'/'+row.id+'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details"><i class="flaticon-eye"></i></a>'
								}
								if(isUpdateStatus == true){
									roleBasedAction += '<a href="'+editURL+'/'+row.id+'" class="btn btn-sm btn-clean btn-icon btn-icon-md" title="Edit details"><i class="la la-edit"></i></a>'
								}
								if(isDeleteStatus == true){
									roleBasedAction += '<a href="javascript:;" data-toggle="modal" data-target="#delete_modules" data-id="'+row.id+'"  class="btn btn-sm btn-clean btn-icon btn-icon-md delete_row" title="Edit details"><i class="flaticon-delete"></i></a>'
								}
								return roleBasedAction;
							},
						}],
				});
		
				$('#kt_form_status').on('change', function() {
					datatable.search($(this).val().toLowerCase(), 'Status');
				});
		
				$('#kt_form_type').on('change', function() {
					datatable.search($(this).val().toLowerCase(), 'Type');
				});
		
				$('#kt_form_status,#kt_form_type').selectpicker();

				datatable.on(
					'kt-datatable--on-check kt-datatable--on-uncheck kt-datatable--on-layout-updated',
					function(e) {
						var checkedNodes = datatable.rows('.kt-datatable__row--active').nodes();
						var count = checkedNodes.length;
						$('#kt_datatable_selected_number').html(count);
						if (count > 0) {
							$('#kt_datatable_group_action_form').collapse('show');
						} else {
							$('#kt_datatable_group_action_form').collapse('hide');
						}
					});
		
				$('#kt_modal_fetch_id').on('show.bs.modal', function(e) {
					var ids = datatable.rows('.kt-datatable__row--active').
					nodes().
					find('.kt-checkbox--single > [type="checkbox"]').
					map(function(i, chk) {
						return $(chk).val();
					});
					var c = document.createDocumentFragment();
					for (var i = 0; i < ids.length; i++) {
						var li = document.createElement('li');
						li.setAttribute('data-id', ids[i]);
						li.innerHTML = 'Selected record ID: ' + ids[i];
						c.appendChild(li);
					}
					$(e.target).find('.kt-datatable_selected_ids').append(c);
				}).on('hide.bs.modal', function(e) {
					$(e.target).find('.kt-datatable_selected_ids').empty();
				});
				
			},
			error: function( jqXhr, textStatus, errorThrown ){
				console.log( errorThrown );
			}
		});
	};

	return {
		// Public functions
		init: function() {
			// init dmeo
			init();
			//search();
			//selection();
			//selectedFetch();
			//selectedStatusUpdate();
			//selectedDelete();
			//updateTotal();
		},
	};
}();

jQuery(document).ready(function() {
	KTDatatableDataLocalDemo.init();
});