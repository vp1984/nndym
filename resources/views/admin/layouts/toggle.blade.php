<div class="modal fade" id="toggle_modal" tabindex="-1" role="dialog" aria-labelledby="toggle_modal_label">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form id="toggle-modules-form" name="toggle-modules-form" action="{{ url($action_url) }}" class="" method="post">{{ csrf_field() }}
					<input type="hidden" name="id" id="toggle_id" value="">
					<input type="hidden" name="status" id="toggle_status" value="">
					<div class="form-group">
						<div class="row">
							<div class="col-md-12 text-center">
								<h3>Are you sure?</h3>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6 text-right">
								<button class="btn btn-primary confirmtoggle" type="submit">Yes</button>
							</div>
							<div class="col-md-6 text-left">
								<button type="button" class="btn btn-warning" data-dismiss="modal">No</button>
							</div>
						</div>
					</div>
                </form>
            </div>
        </div>
    </div>
</div>

