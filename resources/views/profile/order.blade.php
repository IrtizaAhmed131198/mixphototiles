@extends('components.layouts.app')

@section('title', 'Order Summary')

@section('css')
<style>
#example td:nth-child(2) {
    max-width: 200px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: block;
    max-height: 50px;
    overflow-y: auto;
}

#example td:nth-child(2).scrollable {
    max-height: 100px;
    overflow-y: auto;
}

</style>
@endsection

@section('content')

    <section class="profile-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    @include('partials/profilesidebar')
                </div>
                <div class="col-lg-9">
                    <div class="account-information">
                        <h1>Orders</h1>
                        <table id="example" class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Status</th>
                                    <th>Payment Method</th>
                                    <th>Username</th>
                                    <th>Date/Time</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Refund Modal -->
    <div class="modal fade" id="refundModal" tabindex="-1" aria-labelledby="refundModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="refundForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Process Refund</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="payment_id" id="refund_payment_id">
                        <input type="hidden" name="order_id" id="refund_order_id">
                        <div class="mb-3">
                            <label for="refund_amount" class="form-label">Refund Amount (INR)</label>
                            <input type="number" class="form-control" name="refund_amount" id="refund_amount" min="1" required data-max="0">
                            <div id="refundAmountError" class="text-danger d-none"></div>
                        </div>
                        <div id="refundError" class="text-danger d-none"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Confirm Refund</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#example').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("get.orders") }}',
        columns: [
            { data: 'id', name: 'id' },
            {
                data: 'title',
                name: 'title',
                render: function(data, type, row) {
                    // Add scrollable style if content is long
                    return '<div class="scrollable" style="max-width: 200px; overflow-y: auto;">' + data + '</div>';
                }
            },
            { data: 'price', name: 'price' },
            { data: 'status', name: 'status' },
            { data: 'payment_method', name: 'payment_method' },
            { data: 'username', name: 'username' },
            { data: 'datetime', name: 'datetime' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
});

// Wait for the document to be ready
$(document).ready(function () {
    // Add a click event listener to the delete button
    $(document).on('click', '#deleteButton', function (e) {
        e.preventDefault(); // Prevent the default link behavior

        var deleteUrl = $(this).data('href'); // Get the URL from the data-href attribute

        // Show SweetAlert2 confirmation dialog
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            showClass: {
                popup: 'animate__animated animate__fadeIn animate__slow'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOut animate__faster'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // If the user confirms, redirect to the delete URL
                window.location.href = deleteUrl;
            }
        });
    });
});

// $(document).on('change', '.order-status-dropdown', function () {
//     var orderId = $(this).data('id');
//     var newStatus = $(this).val();

//     $.ajax({
//         url: "{{ url('/orders/update-status/') }}/" + orderId,
//         method: 'POST',
//         data: {
//             _token: '{{ csrf_token() }}',
//             status: newStatus
//         },
//         success: function(response) {
//             toastr.success('Order status updated!');
//         },
//         error: function() {
//             toastr.error('Failed to update order status.');
//         }
//     });
// });

$(document).on('change', '.order-status-dropdown', function () {
    let selectedStatus = $(this).val();
    let orderId = $(this).data('id');

    if (selectedStatus === 'refund') {
        // Get payment ID via API or embed in DOM for demo
        $.ajax({
            url: "{{ url('orders/payment-info') }}/"+orderId, // Make this route
            method: 'GET',
            success: function (data) {
                $('#refund_order_id').val(orderId);
                $('#refund_payment_id').val(data.payment_id);
                $('#refund_amount').val(data.amount); // Optional: default refund to full
                $('#refund_amount').attr('data-max', data.amount);
                $('#refundAmountError').addClass('d-none').text('');
                $('#refundModal').modal('show');
            },
            error: function () {
                alert('Failed to fetch payment details.');
            }
        });
    } else {
        // Auto update other statuses via AJAX

        $.ajax({
            url: "{{ url('/orders/update-status/') }}/" + orderId,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: selectedStatus
            },
            success: function(response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Order status updated!',
                    showClass: {
                        popup: 'animate__animated animate__fadeIn animate__slow'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOut animate__faster'
                    }
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update order status.',
                    showClass: {
                        popup: 'animate__animated animate__fadeIn animate__slow'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOut animate__faster'
                    }
                });
            }
        });
    }
});

$('#refundForm').on('submit', function (e) {
    e.preventDefault();
    console.log('Refund form submitted');

    let refundAmount = parseFloat($('#refund_amount').val());
    let maxAmount = parseFloat($('#refund_amount').data('max'));

    if (refundAmount > maxAmount) {
        console.log(refundAmount, maxAmount);
        $('#refundAmountError').removeClass('d-none').text(`Refund amount cannot exceed ₹${maxAmount}`);
        return;
    }

    // Disable buttons
    $('#refundForm button').attr('disabled', true);

    let formData = {
        _token: '{{ csrf_token() }}',
        order_id: $('#refund_order_id').val(),
        payment_id: $('#refund_payment_id').val(),
        refund_amount: $('#refund_amount').val()
    };

    $.ajax({
        url: "{{ url('orders/refund') }}",
        method: 'POST',
        data: formData,
        success: function (res) {
            if (res.success) {
                $('#refundModal').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Refund processed successfully.',
                    showClass: {
                        popup: 'animate__animated animate__fadeIn animate__slow'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOut animate__faster'
                    }
                }).then((result) => {
                    $('#example').DataTable().ajax.reload(); // reload table
                });
            } else {
                $('#refundError').text(res.message || 'Refund failed.').removeClass('d-none');
            }
        },
        error: function (err) {
            $('#refundError').text('Something went wrong!').removeClass('d-none');
        },
        complete: function () {
            // Re-enable buttons after success or error
            $('#refundForm button').attr('disabled', false);
        }
    });
});

</script>
@endpush
