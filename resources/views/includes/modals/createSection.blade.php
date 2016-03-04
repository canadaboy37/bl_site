<div class="modal fade" id="createSectionModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form id="createSectionForm" action="#">
                    <fieldset>
                        {{ csrf_field() }}
                        <h2>Create a section</h2>
                        <div class="has-error" id="createSectionErrorMsg" style="display: none"></div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="section_name" name="name" placeholder="New Section">
                            <input type="hidden" class="form-control" id="section_estimate_id" name="estimate">
                        </div>
                        <button type="button" class="btn btn-default" id="createSection">CREATE</button>
                        <button type="button" class="btn btn-default" id="cancelCreateSection"  data-dismiss="modal"> CANCEL </button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>