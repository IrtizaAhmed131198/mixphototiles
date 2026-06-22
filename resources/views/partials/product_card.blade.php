@foreach ($products as $product)
    @php
        dump($product->id);
        $discountAmount = ($product->price * $product->discount) / 100;
        $finalPrice = $product->price - $discountAmount;
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
                                    <del>₹ {{ round($product->price) }}</del>
                                </span>
                                <span class="discountPercent">
                                    {{ round($product->discount) }}% OFF
                                </span>
                            @endif
                        </h4>
                    </div>
                </div>
            </a>
        </div>
    </div>
@endforeach
