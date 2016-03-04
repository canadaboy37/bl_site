$(function() {
    $('#searchBar').autocomplete({
        source: "/productsearch",
        select: function(event, ui) {
            $('#searchBar').val(ui.item.id);
        },
        html: true,

        open: function(event, ui) {
            $('.ui-autocomplete').css('z-index', 1000);
        }

    });
});

/* Modal resets */

// Resets the form, and removes the all but the first
// two options from both selects and refreshes them
$('#productModal').on('hidden.bs.modal', function(){
    $.notifyClose();
    $(this).find('form')[0].reset();
    $('#sectionSelect').attr('disabled', 'disabled');
    $('#addToEstimate').attr('disabled', 'disabled');
    $('#addToEstimateErrorMsg').html('').hide();
    resetEstimateSelect();
    resetSectionSelect();
});

// Resets the Create Estimate and Create Section forms
$('#createEstimateModal').on('hidden.bs.modal', function(){
    $.notifyClose();
    $(this).find('form')[0].reset();
    $('#createEstimateErrorMsg').html('').hide();
});

$('#createSectionModal').on('hidden.bs.modal', function(){
    $.notifyClose();
    $(this).find('form')[0].reset();
    $('#createSectionErrorMsg').html('').hide();
});

/* End modal resets */


/* Events */

$('a.openModal').click(function(event){
    event.preventDefault();
    var productId = this.dataset['para1'];
    var url = '/product/' + productId;
    $.ajax({
        url: url,
        success: function(data){
            populateEstimateSelect(function() {
                $('#productId').val(data.id);
                $('#productName').text(data.name);
                $('#productSku').text(data.sku);
                $('#productCategory').text($(this).closest('li').find('.categories').text());
                $('#productListPrice').text('$'+data.list_price.toFixed(2));
                $('#productYourPrice').text($(this).closest('li').find('.your-price').text());
                $('#productUnit').text(data.unit);
                $('#productModal').modal('toggle');

                $('#estimateSelect').change(function() {
                    if ($('#estimateSelect').val() == 'new') {
                        $('#createEstimateModal').modal('toggle');
                    }
                    else {
                        if ($('#estimateSelect').val() != '') {
                            populateSectionSelect();
                            $('#sectionSelect').removeAttr('disabled');
                            jcf.refresh($('#sectionSelect'));
                        }
                        checkFormReady();
                    }
                });

                $('#quantity').on('change, keyup', function() {
                    checkFormReady();
                });

                $('#sectionSelect').change(function() {
                    if ($(this).val() == 'new') {
                        $('#createSectionModal').modal('toggle');
                        $('#section_estimate_id').val($('#estimateSelect').val());
                    }
                });
            });
        }
    });
});

$('#createEstimate').click(function(){
    var form = $("#createEstimateForm");
    var dataString = form.serialize();
    $.ajax({
        type: "POST",
        url: "/estimates/create",
        data: dataString,
        success: function(data) {
            if(data.status == 'error'){
                $.notify({message: 'Estimate name cannot be blank'},{type: 'danger', z_index: '9999'});
            } else {
                populateEstimateSelect(function() {
                    $('#estimateSelect').val(data.estimateId);
                    $('#estimateSelect').trigger('change');
                    $("#createEstimateModal").modal('toggle');
                });
            }
        }
    });
});

$('#createSection').click(function(){
    var form = $("#createSectionForm");
    var dataString = form.serialize();
    $.ajax({
        type: "POST",
        url: "/estimates/createSection",
        data: dataString,
        success: function(data) {
            if(data.status == 'error'){
                $.notify({message: 'Section name cannot be blank'},{type: 'danger', z_index: '9999'});
            } else {
                populateSectionSelect(function() {
                    $('#sectionSelect').val(data.sectionId);
                    $('#createSectionModal').modal('toggle');
                });
            }
        }
    });
});

$('#addToEstimate').click(function() {
    var form = $('#addToEstimateForm');
    var dataString = form.serialize();

    $.ajax({
        type: "POST",
        url: "/estimates/addProduct",
        data: dataString,
        success: function(data) {
            if(data.status == 'qtyNonInt'){
                $.notify({message: 'Quantity must be an integer'},{type: 'danger', z_index: '9999'});
            } else {
                $('#productModal').modal('toggle');
                setTimeout(function() {
                    $.notify({message: 'Product was added to estimate'},{type: 'success', z_index: '9999'}); // TODO find out why this isn't working
                }, 1000);
            }
        }
    });
});

$('#cancelCreateEstimate').click(function() {
    $('#estimateSelect')[0].selectedIndex = 0;
});

$('#cancelCreateSection').click(function() {
    $('#sectionSelect')[0].selectedIndex = 0;
});

/* End events */


/* Functions */

// Populate the estimate select
function populateEstimateSelect(callback) {
    $.ajax({
        url: 'estimates/getEstimates',
        success: function(data){
            resetEstimateSelect();
            $.each(data, function(key, value) {
                $('#estimateSelect').append('<option value="'+value.id+'">'+value.name+'</option>');
            });
            jcf.refresh($('#estimateSelect'));


            if (callback && typeof(callback) === "function") {
                callback();
            }
        }
    });
}

// Populate the section select
function populateSectionSelect(callback) {
    var dataString = { estimateId: $('#estimateSelect').val() };
    $.ajax({
        url: 'estimates/getSections',
        data: dataString,
        success: function(data){
            resetSectionSelect();
            $.each(data, function(key, value) {
                $('#sectionSelect').append('<option value="'+value.id+'">'+value.name+'</option>');
            });
            jcf.refresh($('#sectionSelect'));


            if (callback && typeof(callback) === "function") {
                callback();
            }
        }
    });
}

function resetEstimateSelect() {
    $('#estimateSelect option').slice(2).remove();
    $('#estimateSelect')[0].selectedIndex = 0;
    jcf.refresh($('#estimateSelect'));
}

function resetSectionSelect() {
    $('#sectionSelect option').slice(2).remove();
    $('#sectionSelect')[0].selectedIndex = 0;
    jcf.refresh($('#sectionSelect'));
}

function checkFormReady() {
    if ($.trim($('#quantity').val()) != '' && $('#estimateSelect').val() != '') {
        $('#addToEstimate').removeAttr('disabled');
    }
    else {
        $('#addToEstimate').attr('disabled', 'disabled');
    }
}

/* End functions */