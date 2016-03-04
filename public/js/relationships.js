$(function() {
    $('.relationships-block .wrap').click(function() {
        updatefollowButton(selectedTableRow);
        $('#infoButton').removeAttr('disabled');
        $('#logInAsButton').removeAttr('disabled');
        $('#recentActivityButton').removeAttr('disabled');
        $('#followButton').removeAttr('disabled');
    });

    $('#infoButton').click(function() {
        alert('Not yet implemented');
    });

    $('#recentActivityButton').click(function() {
       /* var newWindow = window.open('relationships/recentActivity/' + selectedTableRow, '_blank');
        newWindow.focus();*/
        alert('Not yet implemented');
    });

    $('#logInAsButton').click(function () {
        // TODO: ask are you sure?
        window.location.replace('/logInAs/' + selectedTableRow);
    });

    $('#followButton').click(function () {
        var action = $(this).html().toLowerCase();

        $.ajax({
            type: 'GET',
            url: '/relationships/' + action + '/' + selectedTableRow,
            success: function(data) {
                updateFollowColumn(data.id);
                updatefollowButton(data.id);
            }
        });
    });

    $('#followAllButton').click(function () {
        $.ajax({
            type: 'GET',
            url: '/relationships/followAll',
            success: function(data) {
                $.each($('.relationships-block .wrap .following'), function(key, element) {
                    $(element).html('Yes');
                });

                if (selectedTableRow != null)
                    updatefollowButton(selectedTableRow);
            }
        });
    });

    $('#unfollowAllButton').click(function () {
        $.ajax({
            type: 'GET',
            url: '/relationships/unfollowAll',
            success: function(data) {
                $.each($('.relationships-block .wrap .following'), function(key, element) {
                    $(element).html('No');
                });

                if (selectedTableRow != null)
                    updatefollowButton(selectedTableRow);
            }
        });
    });
});

function updatefollowButton(id) {
    var row = $(".relationships-block .wrap[data-id='" + id +"']");

    if (row.children('.following').html().indexOf('Yes') >= 0)
        $('#followButton').html('UNFOLLOW');
    else
        $('#followButton').html('FOLLOW');
}

function updateFollowColumn(id) {
    var row = $(".relationships-block .wrap[data-id='" + id +"']");
    if (row.children('.following').html().indexOf('Yes') >= 0)
        row.children('.following').html('No');
    else
        row.children('.following').html('Yes');
}

