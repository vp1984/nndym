<!--begin: Search Form -->
									<div class="kt-form kt-form--label-right kt-margin-t-20 kt-margin-b-10">
										<div class="row align-items-center">
											<div class="col-xl-8 order-2 order-xl-1">
												<div class="row align-items-center">
													<div class="col-md-4 kt-margin-b-20-tablet-and-mobile">
														<div class="kt-input-icon kt-input-icon--left">
															<input type="text" class="form-control" placeholder="Search..." id="generalSearch">
															<span class="kt-input-icon__icon kt-input-icon__icon--left">
																<span><i class="la la-search"></i></span>
															</span>
														</div>
													</div>
												</div>
											</div>
											<div class="col-xl-4 order-1 order-xl-2 kt-align-right">
												<a href="#" class="btn btn-default kt-hidden">
													<i class="la la-cart-plus"></i> New Order
												</a>
												<div class="kt-separator kt-separator--border-dashed kt-separator--space-lg d-xl-none"></div>
											</div>
										</div>
									</div>

									<!--end: Search Form -->
									<!--begin: Selected Rows Group Action Form -->
									<div class="kt-form kt-form--label-align-right kt-margin-t-20 collapse" id="kt_datatable_group_action_form">
										<div class="row align-items-center">
											<div class="col-xl-12">
												<div class="kt-form__group kt-form__group--inline">
													<div class="kt-form__label kt-form__label-no-wrap">
														<label class="kt-font-bold kt-font-danger-">Selected
															<span id="kt_datatable_selected_number">0</span> records:</label>
													</div>
													<div class="kt-form__control">
														<div class="btn-toolbar">
															<div class="dropdown">
																<button type="button" class="btn btn-brand btn-sm dropdown-toggle" data-toggle="dropdown">
																	Update status
																</button>
																<div class="dropdown-menu">
																	<a class="dropdown-item toggle_status" data-type="1" href="#">Active</a>
																	<a class="dropdown-item toggle_status" data-type="0" href="#">Inactive</a>
																</div>
															</div>
															&nbsp;&nbsp;&nbsp;
															<button class="btn btn-sm btn-danger delete_rows" type="button" id="kt_datatable_delete_all">Delete All</button>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<!--end: Selected Rows Group Action Form -->