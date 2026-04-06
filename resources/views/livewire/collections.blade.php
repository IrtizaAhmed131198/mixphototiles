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
            <div id="loader" style="text-align:center; padding:20px; display:none;">
                <img src="{{ asset('assets/images/loader.gif') }}" width="50" alt="loading..." />
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        let page = 1;
        let loading = false;

        $(window).scroll(function() {
            if ($(window).scrollTop() + $(window).height() >= $(document).height() - 100 && !loading) {
                page++;
                loadMore(page);
            }
        });

        function loadMore(page) {
            loading = true;
            $('#loader').show();

            $.ajax({
                url: "{{ route('collections.load') }}?page=" + page,
                type: "get",
                success: function(data) {
                    if (data.trim().length == 0) {
                        $('#loader').text("No more collections");
                        return;
                    }
                    $('#loader').hide();
                    $('#productContainer').append(data);
                    loading = false;
                },
                error: function() {
                    $('#loader').text("Something went wrong!");
                    loading = false;
                }
            });
        }
    </script>
@endpush
