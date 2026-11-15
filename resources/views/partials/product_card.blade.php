@foreach ($products as $product)
    @php
        // Tiles use European pricing; Frames retain the Indian default.
        $basePrice = $product->isTileCollection()
            ? $product->price
            : ($product->indian_price ?? round($product->price * 0.60));
        $discountAmount = ($basePrice * $product->discount) / 100;
        $finalPrice = $basePrice - $discountAmount;
        $frameNote = $product->isTileCollection() ? $product->frame_note : $product->indian_frame_note;
        $url = url('collection') . '/' . $product->slug;
    @endphp
    <div class="col-lg-3 col-md-4 col-12">
        <div class="ClusterCard">
            <a href="{{ $url }}">
                <div class="ImgFrame">
                    <img alt="{{ $product->name }}" class="img-fluid" src="{{ asset($product->image) }}">
                </div>
                <div class="custom-card-body">
                    <h3 class="card-title">{{ $product->name }}</h3>
                    <div class="card-prize">
                        <h4 class="product-prize">
                            <span class="realPize">
                                ₹ {{ round($finalPrice) }}
                            </span>
                            @if ($product->discount > 0)
                                <span class="cutPrize">
                                    <del>₹ {{ round($basePrice) }}</del>
                                </span>
                                <span class="discountPercent">
                                    {{ round($product->discount) }}% OFF
                                </span>
                            @endif
                        </h4>
                        @if (!empty($frameNote))
                            <span class="frameNote">{{ $frameNote }}</span>
                        @endif
                    </div>
                </div>
            </a>
        </div>
    </div>
@endforeach
