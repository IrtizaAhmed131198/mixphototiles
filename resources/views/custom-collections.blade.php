@php
    // Presentation samples only; the existing designer owns configuration and pricing.
    $collections = [
        'signature' => ['name' => 'Signature Collection', 'tagline' => 'Warm. Timeless. Versatile.', 'description' => 'Classic frame styling designed for everyday homes, family memories and beautiful gallery walls.', 'price' => 279, 'crop' => '34 94 260 142'],
        'european' => ['name' => 'European Collection', 'tagline' => 'Sleek. Refined. Contemporary.', 'description' => 'Refined profiles and generous mounts that turn your favourite moments into a contemporary gallery.', 'price' => 389, 'crop' => '307 94 253 142'],
        'frameless' => ['name' => 'Frameless Tiles', 'tagline' => 'Clean. Minimal. Modern.', 'description' => 'Let your memories take centre stage with edge-to-edge photo tiles and a beautifully minimal finish.', 'price' => 389, 'crop' => '573 94 239 142'],
    ];
    $products = [];
    foreach (['signature' => [279, 549, 829, 1219], 'european' => [389, 759, 1129, 1499], 'frameless' => [389, 749, 1099, 1449]] as $collection => $prices) {
        foreach (['Mono', 'Duo', 'Starter', 'Quartet'] as $index => $name) {
            $products[$collection][] = [
                'id' => $collection.'-'.$index,
                'name' => ($collection === 'frameless' ? 'Frameless' : ucfirst($collection)).' '.$name,
                'size' => ['8x8', '8x8', '8x11', '12x12'][$index],
                'label' => ['8×8″', '2 × 8×8″', '3 × 8×11″', '2 × 8×8″ + 2 × 12×12″'][$index],
                'price' => $prices[$index],
                'crop' => ($collection === 'frameless' ? '573 94 239 142' : ['41 571 183 131', '235 571 182 131', '429 571 183 131', '623 571 183 131'][$index]),
            ];
        }
    }
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Find your style. Explore Signature, European and Frameless magnetic photo collections for a home filled with memories.">
    <title>Choose Your Style · Photo Collections</title>
    <link rel="icon" href="{{ asset('assets/favicon/favicon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom-collections.css') }}">
    <script src="{{ asset('js/custom-collections.js') }}" defer></script>
</head>
<body class="custom-collections-page">
    <main class="cc-page" id="custom-collections">
        <section class="cc-choose" aria-labelledby="cc-title">
            <header class="cc-intro cc-container">
                <h1 id="cc-title">Choose Your Style</h1>
                <p>Three beautiful collections. The same effortless magnetic experience.</p>
                <span class="cc-handwritten cc-intro-note" aria-hidden="true">More than<br>just frames.<br>It’s your story.<i></i></span>
            </header>
            <div class="cc-collections cc-container row" role="group" aria-label="Choose a collection">
                @foreach ($collections as $key => $collection)
                    <div class="col-12 col-md-4 cc-collection-column">
                        <button type="button" class="cc-collection {{ $loop->first ? 'is-selected' : '' }}" data-collection="{{ $key }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}" aria-controls="cc-products-section">
                            {{-- Only the lifestyle photography is cropped from the supplied reference. --}}
                            <svg class="cc-collection-image" viewBox="{{ $collection['crop'] }}" role="img" aria-label="{{ $collection['name'] }} displayed in a warm, neutral home" preserveAspectRatio="xMidYMid slice">
                                <image href="{{ asset('assets/images/custom-collections-reference.jpg') }}" width="838" height="827" />
                                @if ($key === 'signature')
                                    {{-- Replace the reference's baked-in badge with adjacent wall texture. --}}
                                    <svg x="266" y="97" width="24" height="24" viewBox="239 97 24 24"><image href="{{ asset('assets/images/custom-collections-reference.jpg') }}" width="838" height="827" /></svg>
                                @endif
                            </svg>
                            <span class="cc-selected-mark" aria-hidden="true">✓</span>
                            <span class="cc-collection-copy">
                                <span class="cc-collection-title">{{ $collection['name'] }}</span>
                                <span class="cc-collection-tagline">{{ $collection['tagline'] }}</span>
                                <span class="cc-small-rule"></span>
                                <span class="cc-collection-price">Starts From <strong>₹{{ $collection['price'] }}</strong></span>
                            </span>
                        </button>
                    </div>
                @endforeach
            </div>
            <ul class="cc-features cc-container" aria-label="Made for your home">
                <li><svg viewBox="0 0 48 48" aria-hidden="true"><circle cx="24" cy="24" r="19"/><path d="m11 10 27 28M14 33l12-17m-9-4 7 5 5-6 5 4-6 7-6-5m-2 8 6 4-5 8-5-4z"/></svg><span>No Nails<br>No Drilling</span></li>
                <li><svg viewBox="0 0 48 48" aria-hidden="true"><path d="m24 4 15 6-1 15c-2 9-8 14-14 18-6-4-12-9-14-18L9 10zM17 23l5 5 10-12"/></svg><span>No Wall<br>Damage</span></li>
                <li><svg viewBox="0 0 48 48" aria-hidden="true"><path d="M7 19A18 18 0 0 1 38 10l3 5M41 5v10H31M41 29A18 18 0 0 1 10 38l-3-5M7 43V33h10"/></svg><span>Reposition<br>Anytime</span></li>
                <li><svg viewBox="0 0 48 48" aria-hidden="true"><path d="M38 5C17 5 9 17 12 30s23 6 25-10zM9 42 31 14M15 34l14-4M23 23l-2-10"/></svg><span>Lightweight<br>&amp; Durable</span></li>
                <li><svg viewBox="0 0 48 48" aria-hidden="true"><path d="M12 6h25v36H12zM17 11h15v25H17zM19 28l5-7 5 3 3-4"/></svg><span>Premium<br>Photo Prints</span></li>
            </ul>
        </section>

        <section class="cc-products-section" id="cc-products-section" aria-labelledby="cc-collection-heading">
            <div class="cc-banner">
                <div class="cc-banner-art" aria-hidden="true">
                    <svg viewBox="446 400 391 132" preserveAspectRatio="xMidYMid slice"><image href="{{ asset('assets/images/custom-collections-reference.jpg') }}" width="838" height="827" /></svg>
                </div>
                <div class="cc-container cc-banner-copy">
                    <p class="cc-eyebrow" id="cc-collection-eyebrow">THE SIGNATURE COLLECTION</p>
                    <h2 id="cc-collection-heading">Warm. Timeless. Versatile.</h2>
                    <p id="cc-collection-description">{{ $collections['signature']['description'] }}</p>
                </div>
            </div>
            <div class="cc-container cc-shop">
                <div class="cc-toolbar d-flex align-items-center justify-content-between flex-wrap">
                    <div class="cc-filters" role="group" aria-label="Filter by size">
                        @foreach (['all' => 'All', '8x8' => '8×8″', '8x11' => '8×11″', '12x12' => '12×12″'] as $value => $label)
                            <button type="button" class="cc-filter {{ $loop->first ? 'is-active' : '' }}" data-size="{{ $value }}" aria-pressed="{{ $loop->first ? 'true' : 'false' }}" aria-controls="cc-product-grid">{{ $label }}</button>
                        @endforeach
                    </div>
                    <div class="cc-sort"><label for="cc-sort">Sort by</label><select class="form-select form-select-sm" id="cc-sort"><option value="featured">Featured</option><option value="price-asc">Price: Low to High</option><option value="price-desc">Price: High to Low</option></select></div>
                </div>
                <p class="cc-sr-only" id="cc-results-status" role="status" aria-live="polite" aria-atomic="true"></p>
                <div class="cc-product-grid" id="cc-product-grid"></div>
                <p class="cc-empty" id="cc-empty" hidden>No products in this size yet. Try another size or view all.</p>
                <noscript><p>Please enable JavaScript to browse and filter the sample collections.</p></noscript>
            </div>
        </section>

        <template id="cc-product-template">
            <article class="cc-product">
                <div class="cc-product-photo"><svg preserveAspectRatio="xMidYMid slice" role="img"><image width="838" height="827" /></svg></div>
                <div class="cc-product-info">
                    <h3></h3><p class="cc-product-size"></p><p class="cc-product-price"></p>
                    <div class="cc-colors" role="group">
                        <button type="button" class="cc-color cc-color-black" data-color="Black" aria-label="Black" aria-pressed="true"></button>
                        <button type="button" class="cc-color cc-color-white" data-color="White" aria-label="White" aria-pressed="false"></button>
                        <button type="button" class="cc-color cc-color-oak" data-color="Natural oak" aria-label="Natural oak" aria-pressed="false"></button>
                    </div>
                    <button type="button" class="cc-create btn btn-dark">Create Yours <span aria-hidden="true">→</span></button>
                </div>
            </article>
        </template>

        <dialog class="cc-selection-dialog" id="cc-selection-dialog" aria-labelledby="cc-dialog-title">
            <form method="dialog"><button class="cc-dialog-close" aria-label="Close selection">×</button></form>
            <p class="cc-eyebrow">MAKE IT YOURS</p>
            <h2 id="cc-dialog-title"></h2>
            <p id="cc-dialog-details"></p>
            <p>Bring your favourite memories to life. Choose your final options and pricing in the designer.</p>
            <a class="cc-create btn btn-dark" href="{{ route('design') }}">Continue to designer <span aria-hidden="true">→</span></a>
        </dialog>
        <script type="application/json" id="cc-data">@json(['collections' => $collections, 'products' => $products, 'image' => asset('assets/images/custom-collections-reference.jpg')])</script>
    </main>
</body>
</html>
