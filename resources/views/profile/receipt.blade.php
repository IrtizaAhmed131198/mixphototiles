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
                        <th>Orignal Image</th>
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
                                @if ($item->product && $item->product->image && $item->product->type == 'manual')
                                    <a href="{{ asset($item->product->image) }}" download class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#imageModal"
                                        data-image="{{ asset($item->product->image) }}"
                                        data-frame-config='{{ $item->product->frame_config }}'>View Image</a>
                                @else
                                    <a href="{{ asset($item->product->no_coordinates_image) }}" download
                                        class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#imageModal2"
                                        data-image="{{ asset($item->product->no_coordinates_image) }}">View Image</a>
                                @endif
                            </td>
                            <td>
                                @if ($item->product->type == 'manual')
                                @php
                                    $product_images = App\Models\ProductImage::where('product_id', $item->product->id)->first();
                                    $image_path = asset($product_images?->image_path ?? '');
                                @endphp
                                <a href="javascript:void(0)" download class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#orignalImageModal">View Image</a>

                                <div class="modal fade" id="orignalImageModal" tabindex="-1" aria-labelledby="orignalImageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="orignalImageModalLabel">Collection Image</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <div class="frame-main-wrap frame-main-wrap-main">
                                                    <div class="frameborder inherit-design">
                                                        <div class="frameinner-manual child-inherit-design">
                                                            <img id="modalOrignalImage" src="{{ $image_path }}" class="img-fluid" alt="Preview">
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
                                <a href="javascript:void(0)" download class="btn btn-sm btn-primary"
                                        data-bs-toggle="modal" data-bs-target="#orignalImageModal">View Image</a>

                                <div class="modal fade" id="orignalImageModal" tabindex="-1" aria-labelledby="orignalImageModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="orignalImageModalLabel">Collection Image</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <div class="frame-main-wrap frame-main-wrap-main">
                                                    <div class="frameborder inherit-design">
                                                        <div class="frameinner-manual child-inherit-design">
                                                            <div class="gallery-grid">
                                                                @foreach ($product_images as $item)
                                                                    <img id="modalOrignalImage" src="{{ asset($item->image_path) }}" class="img-fluid" alt="Preview">
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
                            {{-- <td>{{ $item->quantity }}</td> --}}
                            <td>Rs.{{ number_format($price, 2) }}</td>
                            <td>Rs.{{ number_format($price * $quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mt-3">
                <h4>Total Amount: R.{{ number_format($order->total_amount, 2) }}</h4>
            </div>

            @if ($item->product->type == 'manual')
                <!-- Image Preview Modal -->
                <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModalLabel">Collection Image</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="frame-main-wrap frame-main-wrap-main">
                                    <div class="frameborder inherit-design">
                                        <div class="frameinner-manual child-inherit-design">
                                            <img id="modalImage" src="" class="img-fluid" alt="Preview">
                                        </div>
                                    </div>
                                </div>
                                <button id="printButton" class="btn btn-primary mt-3">Print Image</button>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                @php
                    $clusters = json_decode($item->product->coordinates);
                    $data = App\Models\SessionCollection::where('product_id', $item->product->id)->first();
                    if ($data) {
                        $config = json_decode($data->configuration);
                        $price = $data->price;
                        $collectionImages = App\Models\CollectionImages::where('collection_id', $data->id)->get();
                    }
                    $colorClass = $config->color->class ?? 'black-frame';
                    $frameClass = $config->frame->class ?? '';
                @endphp
                <div class="modal fade" id="imageModal2" tabindex="-1" aria-labelledby="imageModal2Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 846px;">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="imageModal2Label">Product Image</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="Parentframe" id="zoomContainer">
                                    <figure class="frameBackground">
                                        <img id="zoomImage" src="{{ asset($item->product->no_coordinates_image) }}"
                                            class="img-fluid" alt="">
                                    </figure>
                                    <div class="framelayoutsParent">
                                        @foreach ($clusters as $key => $cluster)
                                            <div class="clusterFrameWrp {{ $colorClass }} {{ $frameClass }}"
                                                id="cluster-block-{{ $cluster->id }}"
                                                style="position: absolute;
                                            top: {{ $cluster->y }}px;
                                            left: {{ $cluster->x }}px;
                                            width: {{ $cluster->width }}px;
                                            height: {{ $cluster->height }}px;">

                                                <div class="frame-main-wrap">
                                                    <div class="frameborder">
                                                        <div
                                                            class="frameinner d-flex align-items-center justify-content-center {{ $frameClass == 'bold-image-width' ? 'frameinner-pad' : ($frameClass == 'frameless-image-width' ? 'frameinner-less' : '') }}">
                                                            @php
                                                                $image_path = $collectionImages[$key]['image'];
                                                            @endphp
                                                            <img src="{{ asset($image_path) }}"
                                                                id="preview-{{ $cluster->id }}"
                                                                class="image-preview w-100 h-100 object-fit-cover"
                                                                alt="Preview">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <button id="printButtonCollection" class="btn btn-primary mt-3">Print Image</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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
        const imageModal = document.getElementById('imageModal');

        imageModal.addEventListener('show.bs.modal', function(event) {
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
                // let frameClass;
                // if(frameClass == 'frameless-card-design') {
                //     frameClass = 'frameinner-less';
                // } else if (frameClass == 'bold-card-design') {
                //     frameClass = config.design.frameClass;
                // } else {
                //     frameClass = 'classic-card-design';
                // }
                console.log(config);

                // Update wrapper classes
                frameWrapper.className = `frame-main-wrap ${designClass} ${shadowClass} frame-main-wrap-main`;
            } catch (e) {
                console.error('Invalid frame_config:', e);
            }
        });

        document.getElementById('printButton').addEventListener('click', function() {
            // Clone the modal content
            const modalContent = document.querySelector('#imageModal .modal-body').cloneNode(true);
            const printWindow = window.open('', '_blank', 'width=800,height=600');

            // Get dynamic styles if they exist
            const dynamicStyles = document.getElementById('dynamicPrintStyles')?.innerHTML || '';

            // Create the style content with all necessary CSS
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
                        align-items: flex-start; /* Align to top */
                        min-height: 100vh; /* Ensure at least full viewport height */
                    }

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

                    #printButton {
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
                        #printButton {
                            display: none !important;
                        }
                    }
                </style>
            `;

            // Write the content to the print window
            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                    <head>
                        <title>Print</title>
                        ${styleContent}
                    </head>
                    <body>
                        ${modalContent.innerHTML}
                    </body>
                </html>
            `);

            // Close the document to ensure proper rendering
            printWindow.document.close();

            // Wait for content to load before printing
            const checkReady = setInterval(function() {
                if (printWindow.document.readyState === 'complete') {
                    clearInterval(checkReady);
                    setTimeout(function() {
                        printWindow.print();
                        // Optional: Close the window after printing
                        // printWindow.close();
                    }, 500);
                }
            }, 100);
        });
    </script>

<script>
    const imageModal2 = document.getElementById('imageModal2');

    imageModal2.addEventListener('show.bs.modal', function(event) {
        const trigger = event.relatedTarget;
        const imageUrl = trigger.getAttribute('data-image');

        const zoomImage = imageModal2.querySelector('#zoomImage'); // update target image

        // Update image source
        zoomImage.src = imageUrl;
    });

    // Print logic for the new modal
    document.getElementById('printButtonCollection').addEventListener('click', function() {
        const modalContent = document.querySelector('#imageModal2 .modal-body').cloneNode(true);
        const printWindow = window.open('', '_blank', 'width=800,height=600');

        const dynamicStyles = document.getElementById('dynamicPrintStyles2')?.innerHTML || '';

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

                #printButtonCollection {
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
                    #printButtonCollection {
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
                    ${modalContent.innerHTML}
                </body>
            </html>
        `);

        printWindow.document.close();

        const checkReady = setInterval(function () {
            if (printWindow.document.readyState === 'complete') {
                clearInterval(checkReady);
                setTimeout(function () {
                    printWindow.print();
                    // printWindow.close(); // optional
                }, 500);
            }
        }, 100);
    });
</script>

@endpush
