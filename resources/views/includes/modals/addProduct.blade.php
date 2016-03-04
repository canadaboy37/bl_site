<div class="modal fade" id="productModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <form action="#" id="addToEstimateForm"class="add-form">
                    <fieldset>
                        {{ csrf_field() }}
                        <div class="top-block">
                            <input type="hidden" class="form-control" id="productId" name="productId">
                            <div class="left-block">
                                <label for="quantity">QTY</label>
                                <input type="text" class="form-control" id="quantity" name="quantity">
                            </div>
                            <div class="description">
                                <strong class="title" id="productName"></strong>
                                <dl>
                                    <dt>SKU:</dt>
                                    <dd id="productSku"></dd>
                                    <dt>Category: </dt>
                                    <dd id="productCategory"></dd>
                                    <dt>List Price: </dt>
                                    <dd id="productListPrice"></dd>
                                    <dt>Your Price: </dt>
                                    <dd id="productYourPrice"></dd>
                                    <dt>Unit of Measurement:</dt>
                                    <dd id="productUnit"></dd>
                                </dl>
                            </div>
                        </div>
                        <div class="form-group">
                            <select title="Estimate Section" class="select-estimate-or-section" id="estimateSelect" name="estimateId">
                                <option class="hideme" value="">Select an Estimate</option>
                                <option value="new">CREATE NEW ESTIMATE</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select title="Estimate Section" class="select-estimate-or-section" id="sectionSelect" name="sectionId" disabled="disabled">
                                <option class="hideme" value="">Select a Section</option>
                                <option value="new">CREATE NEW SECTION</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="partClass" placeholder="Part Class">
                        </div>
                        <div class="has-error" id="addToEstimateErrorMsg" style="display: none"></div>
                        <button type="button" class="btn btn-default" id="addToEstimate" disabled="disabled">Add to estimate</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>