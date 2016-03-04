<div class="modal fade" id="createEstimateModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form id="createEstimateForm" action="#">
                    <fieldset>
                        {{ csrf_field() }}
                        <h2>Create an estimate</h2>
                        <div class="has-error" id="createEstimateErrorMsg" style="display: none"></div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="New Estimate">
                        </div>
                        <button type="button" class="btn btn-default" id="createEstimate">CREATE</button>
                        <button type="button" class="btn btn-default" id="cancelCreateEstimate" data-dismiss="modal">CANCEL</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>