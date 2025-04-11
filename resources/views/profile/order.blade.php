@extends('components.layouts.app')

@section('title', 'Order Summary')

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
                                    {{-- <th>Coupon</th>
                                    <th>Discount</th>
                                    <th>Shipping</th> --}}
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
            { data: 'title', name: 'title' },
            { data: 'price', name: 'price' },
            { data: 'status', name: 'status' },
            { data: 'payment_method', name: 'payment_method' },
            // { data: 'coupon', name: 'coupon' },
            // { data: 'discount', name: 'discount' },
            // { data: 'shipping', name: 'shipping' },
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
</script>
@endpush
