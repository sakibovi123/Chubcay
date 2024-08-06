$(document).ready(function() {
    // Set CSRF token in headers for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Use a delegated event listener for all select elements with ID starting with 'statusChange'
    $(document).on('change', '[id^="statusChange_"]', function() {
        var userId = $(this).prev('input').val();
        var status = $(this).val();

        $.ajax({
            url: "/admin/users/update-status",
            type: 'POST',
            data: {
                user_id: userId,
                status: status
            },
            success: function(response) {
                // Display an info toast with no title
                toastr.success('User updated', {timeOut: 3000})
                toastr.options.preventDuplicates = true;
                toastr.options.progressBar = true;
            },
            error: function(xhr, status, error) {
                console.error(error);
                toastr.error(error, {timeOut: 3000});
                toastr.options.preventDuplicates = true;
                toastr.options.progressBar = true;
            }
        });
    });
});

function deleteUser(id) {
    if( confirm('Are you sure you want remove this user?') ) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/admin/users/delete/'+id,
            type: 'DELETE',
            success: function (result) {
                $('#' + result['tr']).slideUp('slow')
                toastr.success('User removed', {timeOut: 3000})
            },
            error: function(error) {
                toastr.error('Something went wrong please try again later',
                {timeOut: 3000})
            }
        })



    }
}
