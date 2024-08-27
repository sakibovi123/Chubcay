$(document).ready(function() {
    // Set CSRF token in headers for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Use a delegated event listener for all select elements with ID starting with 'statusChange'
//     $(document).on('change', '[id^="statusChange_"]', function() {
//         var userId = $(this).prev('input').val();
//         var status = $(this).val();
//         console.log(status)
//         if(status === 'Active') {
//             $('#fee').removeAttr('hidden');
//         }

//         $.ajax({
//             url: "/admin/users/update-status",
//             type: 'POST',
//             data: {
//                 user_id: userId,
//                 status: status
//             },
//             success: function(response) {
//                 // Display an info toast with no title
//                 toastr.success('User updated', {timeOut: 3000})
//                 toastr.options.preventDuplicates = true;
//                 toastr.options.progressBar = true;
//             },
//             error: function(xhr, status, error) {
//                 console.error(error);
//                 toastr.error(error, {timeOut: 3000});
//                 toastr.options.preventDuplicates = true;
//                 toastr.options.progressBar = true;
//             }
//         });
//     });
// });

$(document).on('change', '[id^="statusChange_"]', function() {
    var userId = $(this).prev('input').val();
    var status = $(this).val();

    if (status === 'Active') {
        $('#modalUserId').val(userId);
        $('#feeModal').removeClass('hidden'); // Show the modal
    } else {
        updateStatus(userId, status);
    }
});

// Close modal
$('[data-close="modal"]').on('click', function() {
    $('#feeModal').addClass('hidden'); // Hide the modal
});

// Submit form inside modal
$('#feeForm').on('submit', function(e) {
    e.preventDefault();

    var userId = $('#modalUserId').val();
    var status = 'Active';
    var fee = $('#fee').val();

    // Show loading indicator
    $('#loadingIndicator').removeClass('hidden');


    $.ajax({
        url: "/admin/users/update-status",
        type: 'POST',
        data: {
            user_id: userId,
            status: status,
            fee: fee
        },
        success: function(response) {
            $('#feeModal').addClass('hidden'); // Hide the modal
            toastr.success('User updated', {timeOut: 3000});
        },
        error: function(xhr, status, error) {
            toastr.error(error, {timeOut: 3000});
        }
    });
});

// Function to update status without opening modal
function updateStatus(userId, status) {
    $.ajax({
        url: "/admin/users/update-status",
        type: 'POST',
        data: {
            user_id: userId,
            status: status
        },
        success: function(response) {
            toastr.success('User updated', {timeOut: 3000});
        },
        error: function(xhr, status, error) {
            toastr.error(error, {timeOut: 3000});
        }
    });
}
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


$(document).ready(function() {
    // Function to update the background color based on the status
    function updateSelectColor(selectElement) {
        const status = selectElement.val();
        if (status === 'Active') {
            selectElement.css('background-color', '#6ee464');
        } else if (status === 'Pending') {
            selectElement.css('background-color', '#ed5e5e');
        } else {
            selectElement.css('background-color', '');
        }
    }

    // Initialize the color on page load
    $('select[name="status"]').each(function() {
        updateSelectColor($(this));
    });

    // Update the color on change
    $('select[name="status"]').change(function() {
        updateSelectColor($(this));
    });
});

