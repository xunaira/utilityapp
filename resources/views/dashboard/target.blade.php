<!-- modal medium -->
			<div class="modal fade" id="mediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="mediumModalLabel">Add Agent Target</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form action="{{url('admin/agents/settarget')}}" method="post" class="form-horizontal">
                                @csrf
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Agent Name</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <select class="form-control" name="agent" id="agent">
                                        	@foreach($ag as $a)
                                        		<option value="{{$a->id}}">{{$a->name}}</option>
                                        	@endforeach
                                        </select>
                                    </div>
                                </div> 
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Set Target Value</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="text" id="value" name="value" class="form-control">
                                    </div>
                                </div> 
                                <div class="row form-group">
                                    <div class="col col-md-4">
                                        <label for="text-input" class=" form-control-label">Date</label>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <input type="date" id="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                    </div>
                                </div>                                         
						</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
								<button type="submit" class="btn btn-primary">Confirm</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<!-- end modal medium -->