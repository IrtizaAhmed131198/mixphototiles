@extends('components.layouts.app')

@section('title', 'Collections')

@section('content')
<section class="clusters-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-center">
                    <h2 class="heading-2">Collection for your memorable walls</h2>
                    <p class="para">
                        Looking for inspiration or a simple arrangement?
                        <span class="d-block">
                            Explore our thoughtfully curated clusters.
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($products as $product)
                @php
                $discountAmount = ($product->price * $product->discount) / 100;
                $finalPrice = $product->price - $discountAmount;
                $url = url('collection') . '/' . $product->slug;
                @endphp
                <div class="col-lg-3">
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
                                            ₹ {{ number_format($finalPrice, 2) }}
                                        </span>
                                        @if ($product->discount > 0)
                                            <span class="cutPrize">
                                                <del>₹ {{ number_format($product->price, 2) }}</del>
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
        </div>

    </div>
</section>
@endsection

@push('scripts')

@endpush
