@extends('components.layouts.app')

@section('title', 'Order Receipt')

@section('content')
<section class="receipt-section py-5">
    <div class="container">
        <h2>Order Receipt</h2>
        <div class="card p-4 mb-4">
            <h5><strong>Order ID:</strong> #{{ $order->id }}</h5>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
            <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
            @if($order->coupon)
                <p><strong>Coupon:</strong> {{ $order->coupon }}</p>
            @endif
            @if($order->discount)
                <p><strong>Discount:</strong> {{ $order->discount }}</p>
            @endif
            @if($order->shipping)
                <p><strong>Shipping:</strong> {{ $order->shipping }}</p>
            @endif
        </div>

        <h5>Order Items</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Collection</th>
                    <th>Image</th>
                    {{-- <th>Quantity</th> --}}
                    <th>Price (Each)</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product->name ?? 'N/A' }}</td>
                        <td>
                            @if($item->product && $item->product->image)
                                <a href="{{ asset($item->product->image) }}" download class="btn btn-sm btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#imageModal"
                                    data-image="{{ asset($item->product->image) }}">View Image</a>
                            @else
                                N/A
                            @endif
                        </td>
                        {{-- <td>{{ $item->quantity }}</td> --}}
                        <td>${{ number_format($item->price, 2) }}</td>
                        <td>${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-end mt-3">
            <h4>Total Amount: ${{ number_format($order->total_amount, 2) }}</h4>
        </div>

        <!-- Image Preview Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Product Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                <img id="modalImage" src="" class="img-fluid mb-3" alt="Preview">
                <br>
                <a id="downloadImageBtn" href="#" download class="btn btn-primary">Download Image</a>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    const imageModal = document.getElementById('imageModal');
    imageModal.addEventListener('show.bs.modal', function (event) {
        const triggerImg = event.relatedTarget;
        const imageUrl = triggerImg.getAttribute('data-image');
        const modalImage = imageModal.querySelector('#modalImage');
        const downloadBtn = imageModal.querySelector('#downloadImageBtn');

        modalImage.src = imageUrl;
        downloadBtn.href = imageUrl;
    });
</script>
@endpush

