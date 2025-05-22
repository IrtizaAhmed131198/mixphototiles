@extends('components.layouts.app')

@section('title', 'Collections')

@section('content')
<section class="clusters-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
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
        <div id="loader" style="display: none;">Loading...</div>

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
