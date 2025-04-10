@extends('components.layouts.app')

@section('title', 'Order Receipt')

@push('css')
    <style>
        @media print {
            .classic-card-design {
                padding: 37px 30px;
                margin: auto;
                width: 309px;
                height: 318px;
                max-width: 500px;
                border-image: url("../images/1703846727357.png");
                border-image-slice: 30;
                border-image-width: 10px;
                border-image-outset: 0;
                border-image-repeat: stretch;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                z-index: 0;
            }

            .bold-card-design {
                padding: 51px 18px;
                margin: auto;
                width: 309px;
                height: 318px;
                max-width: 500px;
                border-image: url("../images/1703846727357.png");
                border-image-slice: 30;
                border-image-width: 20px;
                border-image-outset: 0;
                border-image-repeat: stretch;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                z-index: 0;
            }

            .frameless-card-design {
                margin: auto;
                width: 309px;
                height: 318px;
                max-width: 500px;
                display: flex;
                align-items: center;
                justify-content: center;
                position: relative;
                z-index: 0;
            }

            .inherit-design {
                width: 100%;
                height: 100%;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .child-inherit-design {
                width: 100%;
                height: 100%;
            }

            .frameinner img {
                object-fit: cover;
                width: 100%;
                height: 100%;
            }
        }
    </style>
@endpush

@section('content')
@foreach ($custom_color as $key => $val)
<?php
    $cssClassName = strtolower(str_replace(' ', '-', $val->name));
    $style = '<style>';
    $style .= '
        .box-shadow-' . $cssClassName . '::before {
            position: absolute;
            z-index: -1;
            content: "";
            right: -8px;
            top: 4px;
            bottom: 0;
            height: 100%;
            width: 8px;
            background: ' . $val->before_color_code . ';
            transform: skewY(45deg);
        }

        .box-shadow-' . $cssClassName . '::after {
            position: absolute;
            z-index: -1;
            content: "";
            background: ' . $val->after_color_code . ';
            width: 100%;
            height: 8px;
            bottom: -8px;
            transform: skewX(45deg);
            left: 5px;
        }
    ';
    $style .= '</style>';

    echo $style;
?>
@endforeach
    <section class="receipt-section py-5">
        <div class="container">
            <h2>Order Receipt</h2>
            <div class="card p-4 mb-4">
                <h5><strong>Order ID:</strong> #{{ $order->id }}</h5>
                <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
                <p><strong>Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                <p><strong>Payment Method:</strong> {{ strtoupper($order->payment_method) }}</p>
                @if ($order->coupon)
                    <p><strong>Coupon:</strong> {{ $order->coupon }}</p>
                @endif
                @if ($order->discount)
                    <p><strong>Discount:</strong> {{ $order->discount }}</p>
                @endif
                @if ($order->shipping)
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
                    @foreach ($order->orderItems as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->product->name ?? 'N/A' }}</td>
                            <td>
                                @if ($item->product && $item->product->image)
                                    <a href="{{ asset($item->product->image) }}"
                                        download
                                        class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#imageModal"
                                        data-image="{{ asset($item->product->image) }}"
                                        data-frame-config='{{ $item->product->frame_config }}'>View Image</a>
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
                            <div class="frame-main-wrap frame-main-wrap-main">
                                <div class="frameborder inherit-design">
                                    <div class="frameinner child-inherit-design">
                                        <img id="modalImage" src="" class="img-fluid" alt="Preview">
                                    </div>
                                </div>
                            </div>
                            <a id="downloadImageBtn" href="#" download class="btn btn-primary mt-3">Download Image</a>
                            <button id="printButton" class="btn btn-primary mt-3">Print Image</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
<script>
    const imageModal = document.getElementById('imageModal');
    const downloadBtn = document.getElementById('downloadImageBtn');

    imageModal.addEventListener('show.bs.modal', function (event) {
        const trigger = event.relatedTarget;
        const imageUrl = trigger.getAttribute('data-image');
        const frameConfigRaw = trigger.getAttribute('data-frame-config');

        const modalImage = imageModal.querySelector('#modalImage');
        const frameWrapper = imageModal.querySelector('.frame-main-wrap');

        modalImage.src = imageUrl;

        // Set dynamic classes
        try {
            const config = JSON.parse(frameConfigRaw);
            const designClass = config?.design?.designClass || 'classic-card-design';
            const shadowClass = config?.color?.shadowClass || 'box-shadow-black';

            // Update wrapper classes
            frameWrapper.className = `frame-main-wrap ${designClass} ${shadowClass} frame-main-wrap-main`;
        } catch (e) {
            console.error('Invalid frame_config:', e);
        }
    });

    downloadBtn.addEventListener('click', function (e) {
        e.preventDefault();

        const modalBody = document.querySelector('#imageModal .modal-body');

        html2canvas(modalBody, {
            useCORS: true,
            backgroundColor: '#ffffff',
            scale: 2
        }).then(canvas => {
            const imageData = canvas.toDataURL('image/png');
            const link = document.createElement('a');
            link.href = imageData;
            link.download = 'modal-screenshot.png';
            link.click();
        }).catch(err => {
            console.error('Screenshot failed:', err);
        });
    });

    document.getElementById('printButton').addEventListener('click', function () {
        const screenshotArea = document.getElementById('screenshot-area');
        const printWindow = window.open('', '', 'width=800,height=600');

        // Clone the content to avoid direct DOM manipulation
        const clone = screenshotArea.cloneNode(true);
        printWindow.document.write('<html><head><title>Print</title><style>@media print { body { margin: 0; } }</style></head><body>');
        printWindow.document.body.appendChild(clone);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    });
</script>
@endpush

