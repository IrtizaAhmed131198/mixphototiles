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

$(document).on('change', '.order-status-dropdown', function () {
    var orderId = $(this).data('id');
    var newStatus = $(this).val();

    $.ajax({
        url: "{{ url('/orders/update-status/') }}/" + orderId,
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            status: newStatus
        },
        success: function(response) {
            toastr.success('Order status updated!');
        },
        error: function() {
            toastr.error('Failed to update order status.');
        }
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

</script>
@endpush
