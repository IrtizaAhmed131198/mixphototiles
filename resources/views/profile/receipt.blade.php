@extends('components.layouts.app')

@section('title', 'Order Receipt')

@push('css')
    <style>
        .frameinner {
            padding: 14px;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            height: 100%;
            width: 100%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .frameinner-pad {
            padding: 3px !important;
        }

        .frameinner-less {
            padding: 0 !important;
        }

        .bold-image-width {
            border-image-width: 4px !important;
            border-image-slice: 30 fill !important;
            border-image-repeat: round !important;
            /* border: 4px solid !important; */
        }

        .selected {
            border: 3px solid red;
            cursor: pointer;
        }

        .fs-14px.fw-semibold.cursor-pointer.list-group-item {
            padding: 28px;
            cursor: pointer;
        }

        button.btn-close.position-absolute.top-0.end-0.m-3 {
            z-index: 1;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
            padding: 10px;
        }

        .gallery-grid img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .gallery-grid img:hover {
            transform: scale(1.05);
        }
    </style>
@endpush

@section('content')
    @foreach ($custom_color as $key => $val)
        <?php
        $cssClassName = strtolower(str_replace(' ', '-', $val->name));
        $style = '<style>';
        $style .=
            '
                .box-shadow-' .
            $cssClassName .
            '::before {
                    position: absolute;
                    z-index: -1;
                    content: "";
                    right: -8px;
                    top: 4px;
                    bottom: 0;
                    height: 100%;
                    width: 8px;
                    background: ' .
            $val->before_color_code .
            ';
                    transform: skewY(45deg);
                }

                .box-shadow-' .
            $cssClassName .
            '::after {
                    position: absolute;
                    z-index: -1;
                    content: "";
                    background: ' .
            $val->after_color_code .
            ';
                    width: 100%;
                    height: 8px;
                    bottom: -8px;
                    transform: skewX(45deg);
                    left: 5px;
                }
            ';
        $style .= '</style>';

        echo $style;

        $cssClassName2 = strtolower(str_replace(' ', '-', $val->name));
        $style2 = '<style>';
        $style2 .= '
            .' . $cssClassName2 . '-frame {
                border-image : url(' . asset($val->frame_img) . ');
                border-image-slice: 30;
                border-image-width: 3px;
                border-image-outset: 0;
                border-image-repeat: stretch;
            }
        ';
        $style2 .= '
            .'. $cssClassName2 .'-frame::before {
                position: absolute;
                z-index: 1;
                content: "";
                right: -5px;
                top: 2px;
                bottom: 0;
                height: 100%;
                width: 5px;
                background: '. $val->before_color_code .';
                transform: skewY(45deg);
            }
            .'. $cssClassName2 .'-frame::after {
                position: absolute;
                z-index: 1;
                content: "";
                background: '. $val->after_color_code .';
                width: 99%;
                height: 6px;
                bottom: -6px;
                transform: skewX(45deg);
                left: 4px;
            }';
        $style2 .= '</style>';

        echo $style2;
        ?>
    @endforeach
    <section class="receipt-section py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Order Receipt</h2>
                <a href="{{ route('orders') }}" class="btn btn-secondary mb-4">Back to Orders</a>
            </div>
            <div class="card p-4 mb-4">
                <h5><strong>Order ID:</strong> #{{ $order->id }}</h5>
                <p><strong>Customer Name:</strong> {{$order->user->name }}</p>
                <p><strong>Customer Email:</strong> {{$order->user->email }}</p>
                <p><strong>Customer Phone:</strong> {{$order->user->phone }}</p>
                <p><strong>Address:</strong> {{$order->address->address_line1.' '.$order->address->address_line2.', '.$order->address->city.' - '.$order->address->pincode }}</p>
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
                        <th>Products</th>
                        <th>Your Design</th>
                        @if(in_array(Auth::user()->role, ['super_admin', 'admin']))
                            <th>Uploaded Image</th>
                        @endif
                        {{-- <th>Quantity</th> --}}
                        <th>Price (Each)</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($order->orderItems as $index => $item)
                        @php
                            $price = $item->price;
                            $quantity = $item->quantity;
                        @endphp
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->product->name ?? 'N/A' }}</td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-sm btn-brand-dark"
                                    data-bs-toggle="modal" data-bs-target="#designModal{{ $item->id }}">View Image</a>

                                <!-- Design Modal for this Item -->
                                <div class="modal fade" id="designModal{{ $item->id }}" tabindex="-1" aria-labelledby="designModalLabel{{ $item->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" style="{{ $item->product && $item->product->type == 'manual' ? '' : 'max-width: 846px;' }}">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="designModalLabel{{ $item->id }}">Your Design</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                @if ($item->product && $item->product->type == 'manual')
                                                    @php
                                                        $config = json_decode($item->product->frame_config ?? '{}', true);
                                                        $designClass = $config['design']['designClass'] ?? 'classic-card-design';
                                                        $shadowClass = $config['color']['shadowClass'] ?? 'box-shadow-black';
                                                        $imgSrc = $config['color']['img_src'] ?? null;
                                                        $borderStyle = '';
                                                        if ($designClass !== 'frameless-card-design' && $imgSrc) {
                                                            $fullImgUrl = (str_starts_with($imgSrc, 'http') || str_starts_with($imgSrc, '/')) ? $imgSrc : asset($imgSrc);
                                                            $borderStyle = "border-image-source: url('{$fullImgUrl}'); border-image-slice: 30; border-image-repeat: stretch;";
                                                        }
                                                    @endphp
                                                    <div class="frame-main-wrap {{ $designClass }} {{ $shadowClass }} frame-main-wrap-main" style="{{ $borderStyle }}">
                                                        <div class="frameborder inherit-design">
                                                            <div class="frameinner-manual child-inherit-design">
                                                                <img src="{{ asset($item->product->image) }}" class="img-fluid" alt="Preview">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-brand-dark mt-3 print-btn" onclick="printModalContent('designModal{{ $item->id }}', 'dynamicPrintStyles')">Print Image</button>
                                                @else
                                                    @php
                                                        $clusters = json_decode($item->product->coordinates ?? '[]');
                                                        $data = App\Models\SessionCollection::where('product_id', $item->product->id)->first();
                                                        $config = json_decode($data->configuration ?? ($item->product->frame_config ?? '{}'));
                                                        if ($data) {
                                                            $collectionImages = App\Models\CollectionImages::where('collection_id', $data->id)->get();
                                                        } else {
                                                            $collectionImages = App\Models\ProductImage::where('product_id', $item->product->id)->get();
                                                        }
                                                        $colorClass = $config->color->class ?? 'black-frame';
                                                        $frameClass = $config->frame->class ?? '';
                                                    @endphp
                                                    <div class="Parentframe" id="zoomContainer{{ $item->id }}">
                                                        <figure class="frameBackground">
                                                            <img src="{{ asset($item->product->no_coordinates_image ?? $item->product->image) }}" class="img-fluid" alt="">
                                                        </figure>
                                                        <div class="framelayoutsParent">
                                                            @if ($clusters)
                                                                @foreach ($clusters as $k => $cluster)
                                                                    <div class="clusterFrameWrp {{ $colorClass }} {{ $frameClass }}"
                                                                        id="cluster-block-{{ $item->id }}-{{ $cluster->id }}"
                                                                        style="position: absolute;
                                                                        top: {{ $cluster->y }}%;
                                                                        left: {{ $cluster->x }}%;
                                                                        width: {{ $cluster->width }}%;
                                                                        height: {{ $cluster->height }}%;">

                                                                        <div class="frame-main-wrap">
                                                                            <div class="frameborder">
                                                                                <div class="frameinner d-flex align-items-center justify-content-center {{ $frameClass == 'bold-image-width' ? 'frameinner-pad' : ($frameClass == 'frameless-image-width' ? 'frameinner-less' : '') }}">
                                                                                    @php
                                                                                        $clusterImg = $collectionImages[$k]->image ?? ($collectionImages[$k]->image_path ?? null);
                                                                                    @endphp
                                                                                    @if ($clusterImg)
                                                                                        <img src="{{ asset($clusterImg) }}"
                                                                                            id="preview-{{ $item->id }}-{{ $cluster->id }}"
                                                                                            class="image-preview w-100 h-100 object-fit-cover"
                                                                                            alt="Preview">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <button class="btn btn-brand-dark mt-3 print-btn" onclick="printModalContent('designModal{{ $item->id }}', 'dynamicPrintStyles2')">Print Image</button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            @if(in_array(Auth::user()->role, ['super_admin', 'admin']))
                                <td>
                                    @if ($item->product && $item->product->type == 'manual')
                                        @php
                                            $product_images = App\Models\ProductImage::where('product_id', $item->product->id)->first();
                                            $image_path = '';
                                            if ($product_images) {
                                                $image_path = $product_images->crop_image_path ? asset($product_images->crop_image_path) : asset($product_images->image_path);
                                            }
                                        @endphp
                                        <a href="javascript:void(0)" class="btn btn-sm btn-brand-dark"
                                            data-bs-toggle="modal" data-bs-target="#orignalImageModal{{ $item->id }}">View Image</a>

                                        <div class="modal fade" id="orignalImageModal{{ $item->id }}" tabindex="-1" aria-labelledby="orignalImageModal{{ $item->id }}Label" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="orignalImageModal{{ $item->id }}Label">Uploaded Image</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <div class="frame-main-wrap frame-main-wrap-main">
                                                            <div class="frameborder inherit-design">
                                                                <div class="frameinner-manual child-inherit-design">
                                                                    <img src="{{ $image_path }}" class="img-fluid" alt="Preview">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        @php
                                            $product_images = App\Models\ProductImage::where('product_id', $item->product->id)->get();
                                        @endphp
                                        <a href="javascript:void(0)" class="btn btn-sm btn-brand-dark"
                                            data-bs-toggle="modal" data-bs-target="#orignalImageModal{{ $item->id }}">View Image</a>

                                        <div class="modal fade" id="orignalImageModal{{ $item->id }}" tabindex="-1" aria-labelledby="orignalImageModal{{ $item->id }}Label" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="orignalImageModal{{ $item->id }}Label">Uploaded Image</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body text-center">
                                                        <div class="frame-main-wrap frame-main-wrap-main">
                                                            <div class="frameborder inherit-design">
                                                                <div class="frameinner-manual child-inherit-design">
                                                                    <div class="gallery-grid">
                                                                        @foreach ($product_images as $rawImg)
                                                                            @php
                                                                                $raw_path = $rawImg->crop_image_path ? asset($rawImg->crop_image_path) : asset($rawImg->image_path);
                                                                            @endphp
                                                                            <img src="{{ $raw_path }}" class="img-fluid" alt="Preview" data-product-id="{{ $item->product->id }}" data-image-id="{{ $rawImg->id }}">
                                                                        @endforeach
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </td>
                            @endif
                            <td>Rs.{{ round($price, 0) }}</td>
                            <td>Rs.{{ round($price * $quantity, 0) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mt-3">
                <h4>Total Amount: Rs.{{ round($order->total_amount, 0) }}</h4>
            </div>
        </div>
    </section>

    <?php
    // Assuming $custom_color is an array of objects or associative arrays
    echo '<style id="dynamicPrintStyles">';

    foreach ($custom_color as $val) {
        $cssClassName = strtolower(str_replace(' ', '-', $val->name));

        echo "
                .box-shadow-{$cssClassName}::before {
                    position: absolute;
                    z-index: -1;
                    content: \"\";
                    right: -8px;
                    top: 4px;
                    bottom: 0;
                    height: 100%;
                    width: 8px;
                    background: {$val->before_color_code};
                    transform: skewY(45deg);
                }

                .box-shadow-{$cssClassName}::after {
                    position: absolute;
                    z-index: -1;
                    content: \"\";
                    background: {$val->after_color_code};
                    width: 100%;
                    height: 8px;
                    bottom: -8px;
                    transform: skewX(45deg);
                    left: 5px;
                }
            ";
    }

    echo '</style>';

    // Assuming $custom_color is an array of objects or associative arrays
    echo '<style id="dynamicPrintStyles2">';

    foreach ($custom_color as $val) {
        $cssClassName2 = strtolower(str_replace(' ', '-', $val->name));

        echo '
        .' . $cssClassName2 . '-frame {
                border-image : url(' . asset($val->frame_img) . ');
                border-image-slice: 30;
                border-image-width: 3px;
                border-image-outset: 0;
                border-image-repeat: stretch;
            }
        ';

        echo '
            .'. $cssClassName2 .'-frame::before {
                position: absolute;
                z-index: 1;
                content: "";
                right: -5px;
                top: 2px;
                bottom: 0;
                height: 100%;
                width: 5px;
                background: '. $val->before_color_code .';
                transform: skewY(45deg);
            }
            .'. $cssClassName2 .'-frame::after {
                position: absolute;
                z-index: 1;
                content: "";
                background: '. $val->after_color_code .';
                width: 99%;
                height: 6px;
                bottom: -6px;
                transform: skewX(45deg);
                left: 4px;
            }';
    }

    echo '</style>';
    ?>


@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <script>
        function printModalContent(modalId, styleId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;

            const modalBody = modal.querySelector('.modal-body').cloneNode(true);
            const printBtn = modalBody.querySelector('.print-btn');
            if (printBtn) {
                printBtn.remove();
            }

            const printWindow = window.open('', '_blank', 'width=800,height=600');
            const dynamicStyles = document.getElementById(styleId)?.innerHTML || '';
            const isCollection = styleId === 'dynamicPrintStyles2';

            let extraCss = '';
            if (isCollection) {
                extraCss = `
                    .Parentframe {
                        position: relative;
                        display: inline-block;
                        max-width: 100%;
                    }
                    .framelayoutsParent {
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                    }
                    .frameinner {
                        padding: 14px;
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                    }
                    .frameinner img {
                        object-fit: cover;
                        width: 100%;
                        height: 100%;
                    }
                    .frameinner-pad {
                        padding: 3px !important;
                    }
                    .frameinner-less {
                        padding: 0 !important;
                    }
                    .bold-image-width {
                        border-image-width: 4px !important;
                        border-image-slice: 30 fill !important;
                        border-image-repeat: round !important;
                    }
                `;
            } else {
                extraCss = `
                    .classic-card-design {
                        padding: 37px 30px;
                        margin: auto;
                        width: 309px;
                        height: 318px;
                        max-width: 500px;
                        border-image: url('{{ asset('assets/images/1703846727357.png') }}');
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
                        border-image: url('{{ asset('assets/images/1703846727357.png') }}');
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
                    .frameinner-manual img {
                        object-fit: cover;
                        width: 100%;
                        height: 100%;
                    }
                `;
            }

            const styleContent = `
                <style>
                    html, body {
                        height: auto;
                        margin: 0;
                        padding: 0;
                        -webkit-print-color-adjust: exact !important;
                        color-adjust: exact !important;
                    }
                    body {
                        display: flex;
                        justify-content: center;
                        align-items: flex-start;
                        min-height: 100vh;
                    }
                    ${extraCss}
                    .print-btn {
                        display: none !important;
                    }
                    ${dynamicStyles}
                    @page {
                        size: auto;
                        margin: 5mm 5mm 0 5mm;
                    }
                    @media print {
                        body {
                            padding: 0;
                            margin: 0;
                            -webkit-print-color-adjust: exact;
                            print-color-adjust: exact;
                        }
                        html, body {
                            height: auto;
                        }
                        .print-btn {
                            display: none !important;
                        }
                    }
                </style>
            `;

            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                    <head>
                        <title>Print</title>
                        ${styleContent}
                    </head>
                    <body>
                        ${modalBody.innerHTML}
                    </body>
                </html>
            `);

            printWindow.document.close();

            const checkReady = setInterval(function() {
                if (printWindow.document.readyState === 'complete') {
                    clearInterval(checkReady);
                    setTimeout(function() {
                        printWindow.print();
                    }, 500);
                }
            }, 100);
        }
    </script>
@endpush
