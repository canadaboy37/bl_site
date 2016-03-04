/* Modal resets */

// Resets the Create Section forms
$('#createSectionModal').on('hidden.bs.modal', function(){
    $.notifyClose();
    $(this).find('form')[0].reset();
    $('#createSectionErrorMsg').html('').hide();
});

/* End modal resets */


/* Events */

$('#estimateSelect').change(function() {
    if ($('#estimateSelect').val() != '') {
        populateSectionSelect(function() {
            $('#sectionSelect').removeAttr('disabled');
            jcf.refresh($('#sectionSelect'));
            getEstimate();
        });
    }
});

$('#sectionSelect').change(function() {
    if ($(this).val() == 'new') {
        $('#createSectionModal').modal('toggle');
        $('#section_estimate_id').val($('#estimateSelect').val());
    } else if ($(this).val() != '') {
        getEstimate();
    }
});

$(document).on("click", "#exportButton", (function() {
    var estimateId = $('#estimateId').val();
    window.location = '/estimates/export?id='+estimateId;
}));

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

$(document).on("click", "#deleteEstimateButton", function() {
    deleteEstimate();
    populateEstimateSelect();
});

$(document).on("click", "#updateButton" , function() {
    var $data = $('form').serialize();
    $.ajax({
        type: 'get',
        url: '/estimates/updateEstimate',
        data: $data
    });
    getEstimate();
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
            if (data.length > 0) {
                $('#showAllSections').removeClass('hideme');
            }
            else {
                $('#showAllSections').addClass('hideme');
            }

            $.each(data, function(key, value) {
                $('#sectionSelect').append('<option value="'+value.id+'">'+value.name+'</option>');
            });
            jcf.refresh($('#sectionSelect'));

            $('#updateButton').removeAttr('disabled');
            $('#exportButton').removeAttr('disabled');
            $('#submitToSalespersonButton').removeAttr('disabled');
            $('#deleteEstimateButton').removeAttr('disabled');

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
    $('#sectionSelect option').slice(3).remove();
    $('#sectionSelect')[0].selectedIndex = 0;
    jcf.refresh($('#sectionSelect'));
}

function deleteEstimate() {
    // TODO: delete selected estimate
    var dataString = { estimateId: $('#estimateId').val() };
    $.ajax({
       url: "/estimates/deleteEstimate",
        data: dataString,
        success: function() {
            window.location = '/estimates';
        }
    });
}

function getEstimate() {
    var dataString = { estimateId: $('#estimateSelect').val(), sectionId: $('#sectionSelect').val() };
    $.ajax({
        url: "/estimates/getEstimateDetails",
        data: dataString,
        success: function(data) {
            $('.estimate-results').html(data);
            $('#updateButton').prop('disabled', false);
            $('#exportButton').prop('disabled', false);
            $('#deleteEstimateButton').prop('disabled', false);
        }
    });
}

/* End functions */