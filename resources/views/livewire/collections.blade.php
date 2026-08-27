@extends('components.layouts.app')

@section('title', 'Magnetic Photo Frames Collections | Damage-Free Wall Decor Collections')

@section('description', 'Explore curated magnetic photo frame sets for bedrooms, staircases and living rooms. No nails, no marks. Easy to move and reuse.')

@section('keywords', 'photo frame sets, staircase photo frames, wall decor frames, magnetic wall frames, living room photo frames, no damage photo frames, no sticker and no nails photo frames, damage free photo frames')

@section('canonical', url('/your-collection'))

@section('content')
    <section class="clusters-section inner-cluster">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="text-center">
                        <h2 class="heading-2">Collections for your memorable walls</h2>
                        <p class="para">
                            Looking for inspiration or a simple arrangement?
                            <span class="d-block">
                                Explore our thoughtfully curated clusters.
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="row" id="productContainer">
                @include('partials.product_card', ['products' => $products])
            </div>

            @if ($products->hasMorePages())
                <div class="text-center mt-5 mb-4" id="loadMoreContainer">
                    <button type="button" class="btn design-btn filled d-inline-flex align-items-center justify-content-center" id="loadMoreBtn" style="min-width: 180px; height: 48px; border: none; cursor: pointer;">
                        <span id="loadMoreText">Load More</span>
                        <span id="loadMoreSpinner" class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true" style="display: none;"></span>
                    </button>
                </div>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        let page = 1;
        let loading = false;

        $('#loadMoreBtn').on('click', function() {
            if (loading) return;

            page++;
            loading = true;
            $('#loadMoreBtn').prop('disabled', true);
            $('#loadMoreText').text('Loading...');
            $('#loadMoreSpinner').show();

            $.ajax({
                url: "{{ route('collections.load') }}?page=" + page,
                type: "get",
                dataType: "json",
                success: function(response) {
                    if (response && response.html && response.html.trim().length > 0) {
                        $('#productContainer').append(response.html);
                    }

                    if (!response.hasMore || (response.html && response.html.trim().length === 0)) {
                        $('#loadMoreContainer').fadeOut(300, function() { $(this).remove(); });
                    } else {
                        $('#loadMoreBtn').prop('disabled', false);
                        $('#loadMoreText').text('Load More');
                        $('#loadMoreSpinner').hide();
                    }
                    loading = false;
                },
                error: function(xhr) {
                    console.error("Error loading collections:", xhr);
                    $('#loadMoreText').text('Try Again');
                    $('#loadMoreSpinner').hide();
                    $('#loadMoreBtn').prop('disabled', false);
                    loading = false;
                }
            });
        });
    </script>
@endpush
